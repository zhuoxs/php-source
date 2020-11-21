<?php
namespace App\Lib\Storage;
class Qiniu
{
    public $option;
    public function __construct($option)
    {
        $this->option = $option;
    }

    public function upload($file,$filename)
    {
        // 需要填写你的 Access Key 和 Secret Key
        $storage = $this->option;
        $accessKey = $storage["qiniu_appId"];
        $secretKey = $storage["qiniu_appSecret"];
        $bucket = $storage["qiniu_bucket"];

// 构建鉴权对象
        $auth = new \Qiniu\Auth($accessKey, $secretKey);

// 生成上传 Token
        $token = $auth->uploadToken($bucket);

// 要上传文件的本地路径
        $filePath = $file;

// 上传到七牛后保存的文件名
        $key = "images/".$filename;

// 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new \Qiniu\Storage\UploadManager();

// 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            debug($err);
            return false;
        } else {
            return true;
        }
    }

    public function delete($filename)
    {
        // 需要填写你的 Access Key 和 Secret Key
        $storage = $this->option;
        $accessKey = $storage["qiniu_appId"];
        $secretKey = $storage["qiniu_appSecret"];
        $bucket = $storage["qiniu_bucket"];
        // 上传到七牛后保存的文件名
        $key = "images/".$filename;
        $auth = new \Qiniu\Auth($accessKey, $secretKey);
        $config = new \Qiniu\Config();
        $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
        $err = $bucketManager->delete($bucket, $key);
        if ($err) {
            debug($err);
            return false;
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->option["qiniu_url"];
    }
}