<?php
namespace App\Lib\Entity;

use Illuminate\Database\Eloquent\Model;

class ManageUserGroup extends Model
{
    protected $table = 'manage_user_group';

    public $timestamps = false;

    public static function getGroupsByUserId($userId)
    {
        return self::where('user_id', $userId)->pluck('group_id')->toArray();
    }

    public static function getUsersByGroupId($groupId)
    {
        return self::where('group_id', $groupId)->pluck('user_id')->toArray();
    }

    public static function addInfo($userId, $groupId)
    {
        self::where('user_id', $userId)->delete();
        if (self::where('user_id', $userId)->where('group_id', $groupId)->first()) {
            return true;
        }

        $entity = new self();
        $entity->user_id = $userId;
        $entity->group_id = $groupId;

        return $entity->save();
    }

    public static function deleteBygroupId($groupId)
    {
        return self::where('group_id', $groupId)->delete();
    }
}