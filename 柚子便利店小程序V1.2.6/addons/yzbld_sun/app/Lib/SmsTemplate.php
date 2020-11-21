<?php
namespace App\Lib;
use App\Model\SystemInfo;

class SmsTemplate
{

    private $result;

    public function __construct()
    {
        $sms = SystemInfo::instance()->first()->sms;
        if(!empty($sms)){
            $this->result = json_decode($sms,true);
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
            "type"=>1,
            "cloud253"=>[
                "cloud253_appId"=>"",
                "cloud253_appSecret"=>"",
                "cloud253_order_template_code"=>"",
            ],
            "aliyun"=>[
                "aliyun_appId"=>"",
                "aliyun_appSecret"=>"",
                "aliyun_sign"=>"",
                "aliyun_order_template_code"=>"",
            ],
        ];

        return $res;
    }

    public function getSmsTypeList()
    {
        return [0=>"253云通讯",1=>"阿里大鱼（阿里云)"];
    }

    public function getResult()
    {
        return $this->result;
    }

    public static function setValue($val)
    {
        $systemInfo = SystemInfo::instance()->first();
        $systemInfo->sms = json_encode($val);
        $systemInfo->save();
        return true;
    }

}