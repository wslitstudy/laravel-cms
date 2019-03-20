<?php

namespace App\Lib\Entity;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    const SHOW_STATUS = 1;
    const HIDE_STATUS = -1;

    protected $table = 'banner';

    public $timestamps = true;

    protected $dateFormat = 'U';


    public static function addBanner($data)
    {
        $entity = new self();

        $entity->img = $data['img'];
        $entity->url = $data['url'];
        $entity->is_show = $data['is_show'] ?? self::HIDE_STATUS;
        $entity->sort = $data['sort'] ?? 0;

        return $entity->save();
    }


    public static function getAllStatus()
    {
        return [
            self::SHOW_STATUS => '显示',
            self::HIDE_STATUS => '隐藏'
        ];
    }

    public function getStatusText($status = '')
    {
        $status = $status ? $status : $this->is_show;
        $statusArr = self::getAllStatus();

        return $statusArr[$status] ?? '';
    }
}