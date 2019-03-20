<?php

namespace App\Lib\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemConfig extends Model
{
    const CACHE_NAME = 'system_config';
    const CACHE_TTS = 60;

    protected $table = 'config';

    public $timestamps = false;

    public static function getConfig($key)
    {
        $allConfig = self::getAllConfig();
        if (!empty($allConfig[$key])) {
            return $allConfig[$key];
        }

        $value = self::where('config_key', $key)->value('value');

        return $value ?: '';
    }

    public static function getAllConfig()
    {
        $model = new self();
        $data = Cache::remember(self::CACHE_NAME, self::CACHE_TTS, function () use ($model) {
            $list = $model->all();

            $data = [];
            foreach ($list as $item) {
                $data[$item->config_key] = $item->value;
            }

            return $data;
        });

        return $data;
    }


    public static function delCache()
    {
        Cache::forget(self::CACHE_NAME);
    }

    public static function getConfigByType($type)
    {
        $list = self::where('type', $type)->get();

        $data = [];
        foreach ($list as $item) {
            $data[$item->config_key] = $item->toArray();
        }

        return $data;
    }


    public function save(array $options = [])
    {
        self::delCache();

        return parent::save($options);
    }
}