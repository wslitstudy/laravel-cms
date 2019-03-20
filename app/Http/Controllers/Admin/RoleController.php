<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AdminException;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Services\Admin\MenuService;
use App\Lib\Entity\ManageGroup;
use App\Lib\Entity\ManagePower;
use App\Lib\Entity\ManageUserGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * @power 权限管理|角色管理
     * @rank 2
     */
    public function index()
    {
        return $this->render('admin.role.index', [
            'list' => ManageGroup::all()
        ]);
    }

    /**
     * @power 权限管理|角色管理@添加
     */
    public function create()
    {
        $menuService = new MenuService();
        return $this->render('admin.role.create', [
            'menus' => $menuService->getMenus()
        ]);
    }

    /**
     * @power 权限管理|角色管理@添加
     */
    public function store(RoleRequest $request)
    {
        $entity = new ManageGroup();
        $entity->group_name = $request->input('Role.name');
        $entity->auth_ids = implode(',', $request->input('power_id'));

        if (!$entity->save()) {
            throw new AdminException('添加失败');
        }

        return response(['code' => 0, 'message' => '添加成功', 'url' => url('/admin/role')]);
    }


    /**
     * @power 权限管理|角色管理@编辑
     */
    public function edit($id)
    {
        $info = ManageGroup::find($id);
        if (!$info) {
            throw new AdminException('对象不存在');
        }

        $menuService = new MenuService();
        return $this->render('admin.role.edit', [
            'menus' => $menuService->getMenus(),
            'info' => $info,
            'auth_ids' => explode(',', $info->auth_ids)
        ]);
    }

    /**
     * @power 权限管理|角色管理@编辑
     */
    public function update(Request $request, $id)
    {
        $entity = ManageGroup::find($id);
        if (!$entity) {
            throw new AdminException('对象不存在');
        }

        $entity->group_name = $request->input('Role.name');
        $entity->auth_ids = implode(',', $request->input('power_id'));

        if (!$entity->save()) {
            throw new AdminException('编辑失败');
        }

        return response(['code' => 0, 'message' => '编辑成功', 'url' => url('/admin/role')]);

    }

    /**
     * @power 权限管理|角色管理@删除
     */
    public function destroy($id)
    {
        $entity = ManageGroup::find($id);
        if (!$entity) {
            throw new AdminException('对象不存在');
        }

        //查询此分组下是否存在管理员
        $total = ManageUserGroup::where('group_id', $id)->count();
        if ($total) {
            throw new AdminException('此角色下面还存在管理员，不能删除');
        }

        if (!$entity->delete()) {
            ManagePower::where('menu_id', $id)->delete();
            throw new AdminException('删除失败');
        }

        return response(['code' => 0, 'message' => '删除成功']);
    }
}
