<?php
namespace App\Lib\Entity;

use Illuminate\Database\Eloquent\Model;

class ManageUser extends Model
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    /**
     * @var string 对应的数据表名
     */
    protected $table = 'manage_user';

    protected $hidden = ['password'];

    public $timestamps = true;

    protected $dateFormat = 'U';

    public function getId()
    {
        return $this->id;
    }

    /**
     * 获取用户名
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 获取密码
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * 获取密码盐
     */
    public function getPasswordSalt()
    {
        return $this->password_salt;
    }

    /**
     * 获取禁用时间
     */
    public function getForbiddenTime()
    {
        return $this->forbidden_time ? date('Y-m-d H:i:s', $this->forbidden_time) : 0;
    }

    /**
     * 判断是否被禁用
     */
    public function isForbiddened()
    {
        return $this->forbidden_time ? true : false;
    }

    /**
     * 获取创建时间
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * 是否是默认用户
     */
    public function isDefault()
    {
        return $this->is_default;
    }

    /**
     * 获取用户所属分组名称
     */
    public function roles()
    {
        /*$groupIds = \App\Lib\Entity\ManageUserGroup::getGroupsByUserId($this->getId());

        $groups = \App\Lib\Entity\ManageGroup::whereIn('id', $groupIds)->get();

        $groupStr = "";

        foreach ($groups as $group) {
            $groupStr .= $group->getName() . ',';
        }

        return substr($groupStr, 0, -1);*/

        $roles = $this->belongsToMany('App\Lib\Entity\ManageGroup', 'manage_user_group', 'user_id', 'group_id');

        return $roles;
    }
}