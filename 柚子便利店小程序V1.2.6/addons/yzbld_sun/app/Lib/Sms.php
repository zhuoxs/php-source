<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 10:59
 */

namespace App\Lib;


class Sms
{
    const ORDER_TEMPLATE = 0;

    /**
     * @param $phone 手机号
     * @param int $sms_template 哪个短信模板
     * @return mixed
     */
    public static function send($phone,$sms_template = 0){
        $sms = new SmsTemplate();
        if($sms->isEnable()){
            $sms_type = $sms->getType();
            if($sms_type == 0){
                $params = $sms->getResult()["cloud_253"];
                if($sms_template == 0){
                    $sms_template = $sms->getResult()["cloud_253"]["cloud253_order_template_code"];
                }
                return self::send_253($params,$phone,$sms_template);
            }else if($sms_type == 1){
                $params = $sms->getResult()["aliyun"];
                if($sms_template == 0){
                    $sms_template = $sms->getResult()["aliyun"]["aliyun_order_template_code"];
                }
                return self::send_aliyun($params,$phone,$sms_template);
            }

        }
    }

    /** Get 或 Post 请求
     * @param $url
     * @param null $data 为null时，为post方法
     *
     * @return mixed
     */
    public static function http($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
    }

    /**
     * 253发送短信
     *
     * @param $params
     * @param $phone
     * @param $sms_template
     */
    public static function send_253($params,$phone,$sms_template)
    {
        $appId = $params["cloud253_appId"];
        $appSecret = $params["cloud253_appSecret"];
        $postArr = array (
            'account'  => $appId,
            'password' => $appSecret,
            'msg' => $sms_template,
            'phone' => $phone,
            'report' => 'true'
        );
        $url = "http://smssh1.253.com/msg/send/json";
        $result = self::http($url, $postArr);
        echo $result;
    }

    /**
     * 阿里大鱼发送短信
     *
     * @param $params
     * @param $phone
     * @param $sms_template
     * @return mixed
     */
    public static function send_aliyun($params,$phone,$sms_template)
    {
        $accessKeyId = $params["aliyun_appId"];
        $accessKeySecret = $params["aliyun_appSecret"];
        $mobilephone = $phone;
        $alisign =  $params["aliyun_sign"];
        $template = $sms_template;
        return self::send_aliyun_api($accessKeyId, $accessKeySecret,$mobilephone, $alisign,$template);
    }

    /**
     * 阿里大鱼API
     * @param $accessKeyId
     * @param $accessKeySecret
     * @param $mobilephone
     * @param $alisign
     * @param $template
     * @return mixed
     */
    public static function send_aliyun_api($accessKeyId, $accessKeySecret,$mobilephone, $alisign,$template) {

        $info = sprintf("%s,%s,%s,%s,%s",$accessKeyId, $accessKeySecret,$mobilephone, $alisign,$template);
        //debug($info);
        require_once __DIR__."/SignatureHelper.php";
        $params = array ();

        // *** 需用户填写部分 ***

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = $accessKeyId;
        $accessKeySecret = $accessKeySecret;

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $mobilephone;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = $alisign;

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = $template;

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        // $params['TemplateParam'] = Array (
        //     "code" => "12345",
        //     "product" => "阿里通信"
        // );

        // fixme 可选: 设置发送短信流水号
        //$params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        //$params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new \SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        // fixme 选填: 启用https
        // ,true
        );


        return $content;
    }


}