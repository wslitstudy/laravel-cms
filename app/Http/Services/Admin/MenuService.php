<?php

namespace App\Http\Services\Admin;

use App\Exceptions\AdminException;
use App\Lib\Entity\ManageMenu;

class MenuService
{
    /**
     * 获取全部菜单
     */
    public function getAllMenu()
    {
        $menus = ManageMenu::with('getPower')->paginate(25);

        return $menus;
    }


    public function getMenus()
    {
        return ManageMenu::all();
    }

    public function getParentMenu()
    {
        $one = ManageMenu::where('level', 1)->orderBy('sort', 'asc')->get();
        $two = ManageMenu::where('level', 2)->orderBy('sort', 'asc')->get();
        $menus = [];

        foreach ($one as $key => $entity) {
            $menus[$key]['self'] = $entity;
            foreach ($two as $twoKey => $twoEntity) {
                if ($twoEntity->parent_id == $entity->id) {
                    $menus[$key]['child'][$twoKey]['self'] = $twoEntity;
                }

            }
        }

        return $menus;
    }

    public function addMenu($data)
    {
        $entity = new ManageMenu();
        $entity->path = $data['name'];
        $entity->level = $data['level'] ?? 1;
        $entity->parent_id = $data['parent_id'] ?? 0;
        $entity->icon = $data['icon'] ?? '';
        $entity->sort = $data['sort'];
        $entity->level_path = $data['parent_id'] ? ManageMenu::getParentPath($data['parent_id']) : '';

        return $entity->save();
    }

    public function updateMenu($entity, $data)
    {
        $entity->path = $data['name'];
        $entity->level = $data['level'] ?? 1;
        $entity->parent_id = $data['parent_id'] ?? 0;
        $entity->icon = $data['icon'] ?? '';
        $entity->sort = $data['sort'];
        $entity->level_path = $data['parent_id'] ? ManageMenu::getParentPath($data['parent_id']) : '';

        return $entity->save();
    }
}