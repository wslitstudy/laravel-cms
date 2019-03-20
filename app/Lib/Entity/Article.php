<?php

namespace App\Lib\Entity;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    const SHOW_STATUS = 1;
    const HIDE_STATUS = -1;

    protected $table = 'article';

    public $timestamps = true;

    protected $dateFormat = 'U';


    public static function addArticle($data)
    {
        $entity = new self();

        $entity->title = $data['title'];
        $entity->content = $data['content'];
        $entity->is_show = $data['is_show'] ?? self::HIDE_STATUS;
        $entity->sort = $data['sort'] ?? 0;
        $entity->cate_id = $data['cate_id'];

        return $entity->save();
    }

    public static function getAllCate()
    {
        return [
            '1' => '在线帮助',
            '2' => '注册协议'
        ];
    }

    public function getCateText($cateId = '')
    {
        $cateId = $cateId ? $cateId : $this->cate_id;
        $array = self::getAllCate();

        return $array[$cateId] ?? '';
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