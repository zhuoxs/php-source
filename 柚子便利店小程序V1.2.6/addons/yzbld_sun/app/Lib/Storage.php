<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/10
 * Time: 15:09
 */

namespace App\Lib;


class Storage extends StorageTemplate
{
    private static $instance = null;
    public static function instance()
    {
        if(static::$instance == null){
            return new Storage();
        }
        return static::$instance;
    }

    public function getStorageName()
    {
        $namelist = ["qiniu","aliyun","tencent"];
        $type = $this->getType();
        return $namelist[$type];
    }

    public function getStorage()
    {
        $storageName  = $this->getStorageName();
        $driver = "App\\Lib\Storage\\".ucfirst($storageName);
        $storage = new $driver($this->getResult()[$storageName]);
        return $storage;
    }
    /**
     * 上传文件
     * @param $file 本地文件路径
     * @param $filename 云存储文件名
     * @return bool
     */
    public function upload($file,$filename)
    {

        if($this->isEnable()){
            return $this->getStorage()->upload($file,$filename);
        }
        return true;
    }


    public function delete($filename)
    {

        if($this->isEnable()){
            return $this->getStorage()->delete($filename);
        }
        return true;
    }
    public function getUploadUrl()
    {

        if($this->isEnable()){
            return $this->getStorage()->getUrl()."/images/";
        }
        return "/attachment/images/";
    }


}