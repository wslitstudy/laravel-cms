<?php

namespace App\Lib\Model\Rbac\Users;

use App\Exceptions\AdminException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Service
{
    /**
     * 加密前缀
     */
    const PREFIX_KEY = "admin";

    const SESSION_NAME = 'mysite_admin';

    const SALT_STRING = 'abcdefghijklmnopqrstuvwxyz0123456789';

    /**
     * 生成加密盐
     */
    public function getPasswordSalt()
    {
        $saltLen = mt_rand(4, 10);
        $randStrLen = strlen(self::SALT_STRING);
        $string = "";
        for ($i = 1; $i <= $saltLen; $i++) {
            $rand = mt_rand(0, $randStrLen - 1);
            $string .= self::SALT_STRING[$rand];
        }
        return $string;
    }

    /**
     * 加密函数
     */
    public function getPassword($password, $passwordSalt)
    {
        return md5(md5(self::PREFIX_KEY . $password) . $passwordSalt);
    }

    /**
     * 验证密码
     */
    public function checkPassword($password, \App\Lib\Entity\ManageUser $entity)
    {
        return $this->getPassword($password, $entity->getPasswordSalt()) === $entity->getPassword();
    }

    /**
     * 获取session
     */
    public function getManageInfo()
    {
        if (session()->has(self::SESSION_NAME)) {
            return session()->get(self::SESSION_NAME);
        }
        return [];
    }

    /**
     * 获取管理员id
     */
    public function getManageId()
    {
        $session = $this->getManageInfo();
        return $session['id'] ?? 0;
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        Cache::forget('user:menu:one');
        Cache::forget('user:menu:two');
        session()->forget(self::SESSION_NAME);
    }

    /**
     * 登录处理
     */
    public function doLogin($accout, $password)
    {
        $userInfo = \App\Lib\Entity\ManageUser::where('name', $accout)->first();
        if (!$userInfo) {
            throw new \Exception('用户名或者密码错误');
        }
        if (!$this->checkPassword($password, $userInfo)) {
            throw new \Exception('用户名或者密码错误');
        }

        //设置session
        session()->put(self::SESSION_NAME, [
            'id' => $userInfo->getId(),
            'name' => $userInfo->getName(),
            'menu_ids' => $this->getMenus($userInfo->getId())
        ]);

        return true;
    }

    /**
     * 检查用户名是否已存在
     */
    public function checkName($name, $id = 0)
    {
        $entity = \App\Lib\Entity\ManageUser::where('name', $name);
        if ($id) {
            $entity->where('id', '<>', $id);
        }
        return $entity->first() ? true : false;
    }

    /**
     * @return 检查权限
     */
    public function checkAuth()
    {
        $white = config('app.rbac_white');

        $path = \App\Lib\Model\Rbac\Power\Service::getRoutePath();

        $menus = $this->getSessionMenus();

        if (in_array($path, $white) || in_array('all', $menus)) {
            return true;
        }

        $method = request()->method();

        $power = \App\Lib\Entity\ManagePower::where('path', $path)->where('method', $method)->first();


        if (!$power) {
            return false;
        }
        if (!in_array($power->getMenuId(), $menus)) {
            return false;
        }

        return true;

    }

    /**
     * @获取菜单ids
     */
    public function getMenus($userId = 0)
    {
        $userId = $userId ? $userId : $this->getManageId();

        $groupIds = \App\Lib\Entity\ManageUserGroup::getGroupsByUserId($userId);

        $menuIds = [];
        $groups = \App\Lib\Entity\ManageGroup::whereIn('id', $groupIds)->get();


        foreach ($groups as $group) {

            if ($group->getAuthIds() == 'all') {
                $menuIds = array_merge($menuIds, ['all']);
            } else {
                $menuIds = array_merge($menuIds, explode(',', $group->getAuthIds()));
            }
        }

        return array_unique($menuIds);
    }


    public function getSessionMenus()
    {
        $session = $this->getManageInfo();
        $menuIds = $session['menu_ids'] ?? [];

        if (!$menuIds) {
            return $this->getMenus();
        }

        return $menuIds;
    }
}
