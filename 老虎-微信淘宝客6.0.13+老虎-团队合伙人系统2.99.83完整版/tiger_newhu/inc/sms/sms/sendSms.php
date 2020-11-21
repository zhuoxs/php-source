<?php
/*
 * 此文件用于验证短信服务API接口，供开发时参考
 * 执行验证前请确保文件为utf-8编码，并替换相应参数为您自己的信息，并取消相关调用的注释
 * 建议验证前先执行Test.php验证PHP环境
 *
 * 2017/11/30
 */

namespace Aliyun\DySDKLite\Sms;

require_once "../SignatureHelper.php";

use Aliyun\DySDKLite\SignatureHelper;


/**
 * 发送短信
 */
function sendSms($accessKeyId,$accessKeySecret,$tel='',$SignName='',$TemplateCode='',$code='') {

    $params = array ();

    // *** 需用户填写部分 ***

    // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
    //$accessKeyId = "";
   // $accessKeySecret = "";
//return $accessKeyId."------------". $accessKeySecret;
    // fixme 必填: 短信接收号码
    $params["PhoneNumbers"] =trim($tel);

    // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
    $params["SignName"] = $SignName;//"老虎淘客";

    // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
    $params["TemplateCode"] = $TemplateCode;//"SMS_90090036";

    // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
    $params['TemplateParam'] = Array (
        "code" => $code,//"12345",
        //"product" => "阿里通信"
    );

    // fixme 可选: 设置发送短信流水号
    $params['OutId'] =$code;// "12345";

    // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
    //$params['SmsUpExtendCode'] = "1234567";


    // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }

    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
    $helper = new SignatureHelper();

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

ini_set("display_errors", "on"); // 显示错误提示，仅用于测试时排查问题
// error_reporting(E_ALL); // 显示所有错误提示，仅用于测试时排查问题
set_time_limit(0); // 防止脚本超时，仅用于测试使用，生产环境请按实际情况设置
header("Content-Type: text/plain; charset=utf-8"); // 输出为utf-8的文本格式，仅用于测试

// 验证发送短信(SendSms)接口

//http://cs.tigertaoke.com/addons/tiger_newhu/inc/sms/sms/sendSms.php?tel=&accessKeyId=&accessKeySecret=&SignName=&TemplateCode=&code=
//http://cs.tigertaoke.com/addons/tiger_newhu/inc/sms/sms/sendSms.php?tel=13867986973&accessKeyId=LTAIuLXYaLzTR9yF&accessKeySecret=nToY03vVLWGRmoIq09IehSdENNAVJZ&SignName=%E8%80%81%E8%99%8E%E6%B7%98%E5%AE%A2&TemplateCode=SMS_90090036&code=55555

if(!empty($_GET['tel'])){
	$accessKeyId=$_GET['accessKeyId'];
	$accessKeySecret=$_GET['accessKeySecret'];
	$tel=$_GET['tel'];
	$SignName=$_GET['SignName'];
	$TemplateCode=$_GET['TemplateCode'];
	$code=$_GET['code'];
	$res=sendSms($accessKeyId,$accessKeySecret,$tel,$SignName,$TemplateCode,$code);
	$res=json_encode($res, JSON_UNESCAPED_UNICODE);
	exit($res);
}else{
	exit("手机号必须填写！");
}




//print_r(sendSms());