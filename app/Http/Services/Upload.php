<?php

namespace App\Http\Services;

use App\Lib\Entity\SystemConfig;
use App\Lib\Model\Upload\AliYun;
use App\Lib\Model\Upload\Local;
use App\Lib\Model\Upload\QiNiu;

class Upload
{
    public $method;
    public $error;
    public $path;

    public $extensions = ['jpg', 'jpeg', 'gif', 'png'];

    public function __construct($path)
    {
        //获取配置文件
        $method = SystemConfig::getConfig('upload_method');

        $this->method = strtolower($method);
        $this->path = $path;
    }


    //上传文件
    public function uploadImage($image)
    {
        //获取文件的扩展名
        $ext = $image->getClientOriginalExtension();

        if (!in_array($ext, $this->extensions)) {
            $this->error = '上传文件格式错误';
            return false;
        }

        $filePath = $image->getRealPath();
        $filename = $this->path . '/' . time() . '_' . uniqid() . '.' . $ext;

        return $this->upload($filename, $filePath);
    }

    public function upload($filename, $filePath)
    {

        switch ($this->method) {
            case 'local':
                return $this->saveFileToLocal($filename, $filePath);
                break;
            case 'qiniu':
                return $this->saveFileToQiNiu($filename, $filePath);
                break;
            case 'aliyun':
                return $this->saveFileToAliYun($filename, $filePath);
                break;
            default:
                $this->error = '请先配置上传文件参数';
                return false;
        }
    }

    private function saveFileToLocal($filename, $filePath)
    {
        $model = new Local();
        return $model->upload($filename, $filePath);
    }

    private function saveFileToQiNiu($filename, $filePath)
    {
        $config = SystemConfig::getConfig('upload_qiniu_config');
        if (!$config) {
            $this->error = '配置文件错误';
            return false;
        }

        $config = json_decode($config, true);
        $bucket = $config['bucket'] ?? '';
        $accessKeyId = $config['access_key'] ?? '';
        $accessKeySecret = $config['secret_key'] ?? '';
        $doMain = $config['domain'] ?? '';

        if (empty($bucket) || empty($accessKeyId) || empty($accessKeySecret) || empty($doMain)) {
            $this->error = '配置文件错误';
            return false;
        }

        try {
            $model = new QiNiu($bucket, $accessKeyId, $accessKeySecret);

            $result = $model->upload($filename, $filePath);

            return $doMain . '/' . $result['key'];

        } catch (\Exception $exception) {
            $this->error = $exception->getMessage();

            return false;
        }
    }

    private function saveFileToAliYun($filename, $filePath)
    {
        $config = SystemConfig::getConfig('upload_aliyun_config');
        if (!$config) {
            $this->error = '配置文件错误';
            return false;
        }

        $config = json_decode($config, true);
        $bucket = $config['bucket'] ?? '';
        $region = $config['region'] ?? '';
        $ecs = $config['ecs'] ?? '';
        $accessKeyId = $config['access_key_id'] ?? '';
        $accessKeySecret = $config['access_key_secret'] ?? '';
        $doMain = $config['domain'] ?? '';

        if (empty($bucket) || empty($accessKeyId) || empty($region) || empty($ecs) || empty($accessKeySecret) || empty($doMain)) {
            $this->error = '配置文件错误';
            return false;
        }

        try {
            $model = new AliYun($bucket, $accessKeyId, $accessKeySecret, $region, $ecs);

            $result = $model->upload($filename, $filePath);

            if (!$result) {
                throw new \Exception('上传失败');
            }

            return $doMain . '/' . $filename;

        } catch (\Exception $exception) {
            $this->error = $exception->getMessage();

            return false;
        }
    }
}