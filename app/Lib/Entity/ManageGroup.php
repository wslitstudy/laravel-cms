<?php
namespace App\Lib\Entity;

use Illuminate\Database\Eloquent\Model;

class ManageGroup extends Model
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    protected $table = 'manage_group';

    public $timestamps = true;

    protected $dateFormat = 'U';

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->group_name;
    }

    public function getAuthIds()
    {
        return $this->auth_ids;
    }

    public function getCreateTime()
    {
        return $this->create_time;
    }

    public function isDefault()
    {
        return $this->is_default;
    }
}