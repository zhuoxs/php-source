<?php
namespace App\Lib;
use App\Model\SystemInfo;

class StorageTemplate
{

    private $result;

    public function __construct()
    {
        $storage = SystemInfo::instance()->first()->storage;
        if(!empty($storage)){
            $this->result = json_decode($storage,true);
            if(!$this->result)
            {
                $this->result = $this->getDefault();
            }
        }else{
            $this->result = $this->getDefault();
        }
    }
    public function isEnable()
    {
        return $this->result["is_enable"];
    }

    public function getType()
    {
        return $this->result["type"];
    }
    public function getDefault()
    {
        $res = [
            "is_enable"=>false,
            "type"=>0,
            "qiniu"=>[
                "qiniu_appId"=>"",
                "qiniu_appSecret"=>"",
                "qiniu_bucket"=>"",
                "qiniu_url"=>"",
            ],
        ];

        return $res;
    }

    public function getStorageTypeList()
    {
        return [0=>"七牛云存储"];
    }

    public function getResult()
    {
        return $this->result;
    }

    public static function setValue($val)
    {
        $systemInfo = SystemInfo::instance()->first();
        $systemInfo->storage = json_encode($val);
        $systemInfo->save();
        return true;
    }



}