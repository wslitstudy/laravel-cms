<?php

namespace App\Lib\Model\Upload;

use App\Exceptions\AdminException;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class QiNiu
{
    public $bucket;
    public $accessKey;
    public $secretKey;

    public function __construct($bucket, $accessKeyId, $accessKeySecret)
    {
        $this->bucket = $bucket;
        $this->accessKey = $accessKeyId;
        $this->secretKey = $accessKeySecret;

    }

    public function getToken()
    {
        $auth = new Auth($this->accessKey, $this->secretKey);

        return $auth->uploadToken($this->bucket);

    }


    public function upload($key, $filePath)
    {
        $uploadMgr = new UploadManager();
        $token = $this->getToken();

        try {
            $result = $uploadMgr->putFile($token, $key, $filePath);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $result;

    }
}