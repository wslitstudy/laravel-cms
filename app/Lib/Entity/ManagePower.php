<?php
namespace App\Lib\Entity;

use Illuminate\Database\Eloquent\Model;

class ManagePower extends Model
{

    protected $table = 'manage_power';

    public $timestamps = false;

    public function getMenuId()
    {
        return $this->menu_id;
    }

    public static function checkPath($path)
    {
        $menu = self::where('path', $path)->first();
        return $menu ? true : false;
    }
}