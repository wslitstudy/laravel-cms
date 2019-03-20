<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class IniAdminUser extends Command
{
    const INI_NAME = 'admin';
    const INI_PASSWORD = 'admin';
    const INI_PASSWORD_SALT = 'admin';
    const INI_GROUP_NAME = '超级管理员';

    protected $signature = 'ini_admin_user';

    protected $description = '初始化后台管理员';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        echo "ini start \n";

        DB::beginTransaction();

        try {

            $service = new \App\Lib\Model\Rbac\Users\Service();

            if (!$service->checkName(self::INI_NAME)) {
                $userEntity = new \App\Lib\Entity\ManageUser();
                $userEntity->name = self::INI_NAME;
                $userEntity->password = $service->getPassword(self::INI_PASSWORD, self::INI_PASSWORD_SALT);
                $userEntity->password_salt = self::INI_PASSWORD_SALT;
                $userEntity->is_default = 1;

                if (!$userEntity->save()) {
                    throw new \Exception('ini user error');
                }
            } else {
                $userEntity = \App\Lib\Entity\ManageUser::where('name', self::INI_NAME)->first();
            }

            if (\App\Lib\Model\Rbac\Group\Service::checkName(self::INI_GROUP_NAME)) {
                $groupEntity = \App\Lib\Entity\ManageGroup::where('group_name', self::INI_GROUP_NAME)->first();
            } else {
                $groupEntity = new \App\Lib\Entity\ManageGroup();
                $groupEntity->group_name = self::INI_GROUP_NAME;
                $groupEntity->auth_ids = 'all';
                $groupEntity->is_default = 1;

                if (!$groupEntity->save()) {
                    throw new \Exception('ini group error');
                }
            }

            if (!\App\Lib\Entity\ManageUserGroup::where('user_id', $userEntity->getId())->where('group_id', $groupEntity->getId())->first()) {
                $userGroupEntity = new \App\Lib\Entity\ManageUserGroup();

                $userGroupEntity->user_id = $userEntity->getId();
                $userGroupEntity->group_id = $groupEntity->getId();

                if (!$userGroupEntity->save()) {
                    throw new \Exception('ini user_group error');
                }
            }

            DB::commit();

            echo "end....\n";

        } catch (\Exception $e) {

            DB::rollBack();

            echo $e->getMessage() . '\n';
        }
    }
}
