<?php
namespace App\Lib\Model\Rbac\Group;

class Service
{
    /**
     * 检查分组名称是否存在
     */
    public static function checkName($name, $id = 0)
    {
        $entity = \App\Lib\Entity\ManageGroup::where('group_name', $name);
        if ($id) {
            $entity->where('id', '<>', $id);
        }
        return $entity->first() ? true : false;
    }

    /**
     * 添加分组
     */
    public static function addGroup($data)
    {
        $entity = new \App\Lib\Entity\ManageGroup();
        $entity->group_name = $data['group_name'];
        $entity->auth_ids = $data['auth_ids'];

        return $entity->save();
    }

    /**
     * 更新分组
     */
    public static function updateGroup($data, $entity)
    {

        $entity->group_name = $data['group_name'];
        $entity->auth_ids = $data['auth_ids'];

        return $entity->save();
    }
}