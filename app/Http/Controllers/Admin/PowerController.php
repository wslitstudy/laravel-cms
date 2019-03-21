<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AdminException;
use App\Lib\Entity\ManageMenu;
use App\Lib\Entity\ManagePower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PowerController extends Controller
{

    /**
     * @power 权限管理|菜单管理@添加路由
     */
    public function store(Request $request)
    {
        $menuId = $request->input('menu_id');
        $path = $request->input('Power.path');
        $method = $request->input('Power.method');

        if (empty($path)) {
            throw new AdminException('路由路径不能为空');
        }

        $menu = ManageMenu::find($menuId);
        if (!$menu) {
            throw new AdminException('菜单不存在');
        }

        $entity = new ManagePower();
        $entity->path = $path;
        $entity->method = $method;
        $entity->menu_id = $menuId;
        $entity->level = $menu->level;

        if (!$entity->save()) {
            throw new AdminException('添加失败');
        }

        return response(['code' => 0, 'message' => '添加成功']);
    }


    /**
     * @power 权限管理|菜单管理@编辑路由
     */
    public function update(Request $request, $id)
    {
        $entity = ManagePower::find($id);
        if (!$entity) {
            throw new AdminException('对象不存在');
        }

        $path = $request->input('path');
        $method = $request->input('method');

        if (empty($path)) {
            throw new AdminException('路由路径不能为空');
        }

        $entity->path = $path;
        $entity->method = $method;


        if (!$entity->save()) {
            throw new AdminException('编辑失败');
        }

        return response(['code' => 0, 'message' => '编辑成功']);
    }

    /**
     * @power 权限管理|菜单管理@删除路由
     */
    public function destroy($id)
    {
        $entity = ManagePower::find($id);
        if (!$entity) {
            throw new AdminException('对象不存在');
        }

        if (!$entity->delete()) {
            throw new AdminException('删除失败');
        }

        return response(['code' => 0, 'message' => '删除成功']);
    }
}
