<?php

namespace App\Lib\Model\Upload;

use App\Exceptions\AdminException;
use JohnLui\AliyunOSS;

class AliYun
{
    private $ossClient;

    public $bucket;

    public function __construct($bucket, $accessKeyId, $accessKeySecret, $region, $ecs)
    {
        $this->bucket = $bucket;

        try {
            $this->ossClient = AliyunOSS::boot(
                $region,
                $ecs,
                false,
                $accessKeyId,
                $accessKeySecret
            );
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

    public function upload($ossKey, $filePath)
    {
        $this->ossClient->setBucket($this->bucket);
        $res = $this->ossClient->uploadFile($ossKey, $filePath);
        return $res;
    }

    /**
     * 直接把变量内容上传到oss
     * @param $osskey
     * @param $content
     */
    public function uploadContent($ossKey, $content)
    {
        $this->ossClient->setBucket($this->bucket);
        $res = $this->ossClient->uploadContent($ossKey, $content);

        return $res;
    }

    /**
     * 删除存储在oss中的文件
     *
     * @param string $ossKey 存储的key（文件路径和文件名）
     * @return
     */
    public function deleteObject($ossKey)
    {

        return $this->ossClient->deleteObject($this->bucket, $ossKey);
    }

    /**
     * 复制存储在阿里云OSS中的Object
     *
     * @param string $sourceBuckt 复制的源Bucket
     * @param string $sourceKey - 复制的的源Object的Key
     * @param string $destBucket - 复制的目的Bucket
     * @param string $destKey - 复制的目的Object的Key
     * @return Models\CopyObjectResult
     */
    public function copyObject($sourceBuckt, $sourceKey, $destBucket, $destKey)
    {

        return $this->ossClient->copyObject($sourceBuckt, $sourceKey, $destBucket, $destKey);
    }

    /**
     * 移动存储在阿里云OSS中的Object
     *
     * @param string $sourceBuckt 复制的源Bucket
     * @param string $sourceKey - 复制的的源Object的Key
     * @param string $destBucket - 复制的目的Bucket
     * @param string $destKey - 复制的目的Object的Key
     * @return Models\CopyObjectResult
     */
    public function moveObject($sourceBuckt, $sourceKey, $destBucket, $destKey)
    {

        return $this->ossClient->moveObject($sourceBuckt, $sourceKey, $destBucket, $destKey);
    }

    public function getUrl($ossKey)
    {
        $this->ossClient->setBucket($this->bucket);
        return $this->ossClient->getUrl($ossKey, new \DateTime("+1 day"));
    }

    public function createBucket($bucketName)
    {
        return $this->ossClient->createBucket($bucketName);
    }

    public function getAllObjectKey($bucketName)
    {
        return $this->ossClient->getAllObjectKey($bucketName);
    }

    /**
     * 获取指定Object的元信息
     *
     * @param  string $bucketName 源Bucket名称
     * @param  string $key 存储的key（文件路径和文件名）
     * @return object 元信息
     */
    public function getObjectMeta($bucketName, $osskey)
    {
        return $this->ossClient->getObjectMeta($bucketName, $osskey);
    }
}