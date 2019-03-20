<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AdminException;
use App\Http\Requests\Admin\MenuRequest;
use App\Http\Services\Admin\MenuService;
use App\Lib\Entity\ManageMenu;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public $menuService;

    public function __construct()
    {
        $this->menuService = new MenuService();
    }

    /**
     * @power 权限管理|菜单管理
     * @rank 3
     */
    public function index()
    {
        return $this->render('admin.menu.index', [
            'menus' => $this->menuService->getAllMenu()
        ]);
    }

    /**
     * @power 权限管理|菜单管理@添加
     */
    public function create()
    {
        return $this->render('admin.menu.create', [
            'parents' => $this->menuService->getParentMenu()
        ]);
    }

    /**
     * @power 权限管理|菜单管理@添加
     */
    public function store(MenuRequest $request)
    {
        $result = $this->menuService->addMenu($request->input('Menu'));
        if (!$result) {
            throw new AdminException('添加失败');
        }

        return response(['code' => 0, 'message' => '添加成功', 'url' => url('/admin/menu')]);
    }


    /**
     * @power 权限管理|菜单管理@编辑
     */
    public function edit($id)
    {
        $info = ManageMenu::find($id);
        if (!$info) {
            throw new AdminException('对象不存在');
        }

        return $this->render('admin.menu.edit', [
            'parents' => $this->menuService->getParentMenu(),
            'info' => $info
        ]);
    }

    /**
     * @power 权限管理|菜单管理@编辑
     */
    public function update(MenuRequest $request, $id)
    {
        $entity = ManageMenu::find($id);
        if (!$entity) {
            throw new AdminException('对象不存在');
        }

        $result = $this->menuService->updateMenu($entity, $request->input('Menu'));
        if (!$result) {
            throw new AdminException('修改失败');
        }

        return response(['code' => 0, 'message' => '修改成功', 'url' => url('/admin/menu')]);
    }

    /**
     * @power 权限管理|菜单管理@删除
     */
    public function destroy($id)
    {
        $entity = ManageMenu::find($id);
        if (!$entity) {
            throw new AdminException('对象不存在');
        }

        //查询是否有下级
        $child = ManageMenu::where('parent_id', $id)->count();
        if ($child) {
            throw new AdminException('此菜单还存在下级菜单，不能删除');
        }

        if (!$entity->delete()) {
            throw new AdminException('删除失败');
        }

        return response(['code' => 0, 'message' => '删除成功']);
    }
}
