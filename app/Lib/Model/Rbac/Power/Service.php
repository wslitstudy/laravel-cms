<?php

namespace App\Lib\Model\Rbac\Power;

use App\Exceptions\AdminExption;
use App\Lib\Entity\ManageMenu;
use App\Lib\Entity\ManagePower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class Service
{
    /**
     * 添加菜单
     */
    public static function addMenu($data)
    {
        $entity = new ManageMenu();
        $entity->path = $data['power'];
        $entity->level = $data['level'];
        $entity->sort = $data['sort'];
        $entity->parent_id = $data['parent_id'] ?? 0;
        $entity->level_path = isset($data['parent_id']) ? ManageMenu::getParentPath($data['parent_id']) : '';

        if ($entity->save()) {
            return $entity->id;
        }
        return false;
    }


    /**
     * 添加 power
     */
    public static function addPower($path, $method, $meunId, $level)
    {
        $entity = new ManagePower();
        $entity->path = $path;
        $entity->method = $method;
        $entity->menu_id = $meunId;
        $entity->level = $level;

        return $entity->save();
    }

    /**
     * 获取请求route
     */
    public static function getRoutePath()
    {
        $actions = Route::currentRouteAction();
        $arr = explode('@', $actions);

        $namespace = explode('\\', $arr[0]);
        $controller = $namespace[count($namespace) - 1];

        $route = substr($controller, 0, strlen($controller) - 10);
        $path = '/admin/' . strtolower($route) . '/' . strtolower($arr[1]);

        return trim($path);
    }

    /**
     * 获取菜单
     */
    public function getMenus()
    {
        $session = new \App\Lib\Model\Rbac\Users\Service();

        $cacheKey = 'user:menu:' . $session->getManageId();

        $value = Cache::remember($cacheKey, 20, function () use ($session) {
            $menuIds = $session->getSessionMenus();

            if (in_array('all', $menuIds)) {
                $leftMenus = $this->getAllMenus();
            } else {
                $leftMenus = $this->getAllMenus($menuIds);
            }

            return $leftMenus;
        });

        return $value;
    }


    public function getAllMenus($menuIds = [])
    {
        $query = \App\Lib\Entity\ManageMenu::whereIn('manage_menu.level', [1, 2]);
        if ($menuIds) {
            $query->whereIn('manage_menu.id', $menuIds);
        }
        return $query->select('manage_power.path as url', 'manage_menu.*')
            ->leftJoin('manage_power', 'manage_power.menu_id', '=', 'manage_menu.id')
            ->orderBy('manage_menu.sort', 'asc')
            ->get();
    }

    public function getOneMenus()
    {
        $cacheKey = 'user:menu:one';

        $value = Cache::remember($cacheKey, 60, function () {
            $one = ManageMenu::select(['manage_menu.*', 'manage_power.path as url'])
                ->leftJoin('manage_power', 'manage_power.menu_id', '=', 'manage_menu.id')
                ->where('manage_menu.parent_id', 0)
                ->orderBy('manage_menu.sort', 'ASC')
                ->get();

            return $one;
        });

        return $value;
    }


    public function getTwoMenus()
    {
        $cacheKey = 'user:menu:two';

        $value = Cache::remember($cacheKey, 60, function () {
            $one = ManageMenu::select(['manage_menu.*', 'manage_power.path as url'])
                ->leftJoin('manage_power', 'manage_power.menu_id', '=', 'manage_menu.id')
                ->where('manage_menu.level', 2)
                ->where('manage_power.level', 2)
                ->orderBy('manage_menu.sort', 'ASC')
                ->get();

            return $one;
        });

        return $value;
    }

    /**
     * 获取左边菜单
     */
    public function getLeft()
    {

        $session = new \App\Lib\Model\Rbac\Users\Service();
        $menuIds = $session->getSessionMenus();

        //获取当前路由
        $currentPath = \App\Lib\Model\Rbac\Power\Service::getRoutePath();

        //获取当前meauid
        $menuId = ManagePower::where('path', $currentPath)
            ->where('level', '>', 1)
            ->value('menu_id');

        if ($menuId) {
            $menu = ManageMenu::where('id', $menuId)->first();

            //获取下级菜单
            if ($menu->level == 1) {
                $parentId = $menu->id;
            } elseif ($menu->level == 2) {
                $parentId = $menu->parent_id;
            } else {
                $levelPath = $menu->level_path;
                if ($levelPath) {
                    $levelPathArr = explode('-', $levelPath);
                }

                $parentId = $levelPathArr[0];
                $menuId = $levelPathArr[1];
            }

            $allTwo = $this->getTwoMenus();
            $two = [];

            foreach ($allTwo as $item) {
                if (in_array('all', $menuIds) && $item->parent_id == $parentId) {
                    $two[] = $item;
                } elseif (in_array($item->id, $menuIds) && $item->parent_id == $parentId) {
                    $two[] = $item;
                }
            }
        }

        //获取全部一级菜单
        $allOne = $this->getOneMenus();
        $one = [];
        foreach ($allOne as $item) {
            if (in_array('all', $menuIds) || in_array($item->id, $menuIds)) {
                $one[] = $item;
            }

            if(isset($parentId) && $item->id == $parentId){
                $oneName = $item->getShrotName();
            }
        }



        $left = [
            'one' => $one,
            'menu_id' => $menuId,
            'menu_parent_id' => isset($parentId) ? $parentId : 0,
            'two' => isset($two) ? $two : [],
            'one_name' => isset($oneName) ? $oneName : '',
        ];

        return $left;
    }

}
