<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

namespace Aliyun\DySDKLite\Sms;
use Aliyun\DySDKLite\SignatureHelper;

if (!defined('IN_IA')) {
    exit('Access Denied');
}

// 旧版阿里大于
if (!function_exists('sendsms')) {
    function sendsms($mobile, $cont=array(), $data=array()) {
        global $_W;

        include_once MODULE_ROOT . '/lib/Alidayu/TopSdk.php';

        $appkey = $data['appkey'];
        $content = json_encode($cont);
        $secret = $data['secret'];
        $c = new \TopClient;
        $c->appkey = $appkey;
        $c->secretKey = $secret;
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("123454");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($data['sign']);
        $req->setSmsParam($content);
        $req->setRecNum($mobile);
        $req->setSmsTemplateCode($data['sms_id']);
        $resp = @$c->execute($req);

        if (property_exists($resp, 'result')) {
            $return_data = array(
                'errcode'=>'0',
                'errmsg'=>'发送成功',
            );
            return $return_data;
        } else {
            $return_data = array(
                'errcode'=>$resp->code,
                'errmsg'=>'发送失败-'.$resp->msg,
            );
            return $return_data;
        }
        // return 'SUCCESS';
    }
}

// 新版阿里云通信
if (!function_exists('sendsms_new')) {
    function sendsms_new($mobile, $cont=array(), $data=array()) {
        global $_W;

        include_once MODULE_ROOT . '/lib/Alidysmslite/SignatureHelper.php';

        $params = array ();

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = $data['appkey'];
        $accessKeySecret = $data['secret'];

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $mobile;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = $data['sign'];

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = $data['sms_id'];

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = $cont;

        // fixme 可选: 设置发送短信流水号
        $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        $params['SmsUpExtendCode'] = "1234567";

        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = @$helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );

        if (property_exists($content, 'Code') && $content->Code == 'OK') {
            $return_data = array(
                'errcode'=>'0',
                'errmsg'=>'发送成功',
            );
            return $return_data;
        } else {
            $return_data = array(
                'errcode'=>$content->Code,
                'errmsg'=>'发送失败-'.$content->Message,
            );
            return $return_data;
        }
        // return $content;
    }
}



if (!function_exists('send_sys_msg_admin')) {
    // $type = 1,测试
    function send_sys_msg_admin($phone, $type = 0) {
        global $_W;

        $res = true;

        if ($type == 0) {
            $res = check_send_time(); // 是否超过 15 分钟
        }

        if ($res) {

            $uniacid = $_W['uniacid'];
            $condition = ' and uniacid=:uniacid and setting_name=:setting_name';
            $params = array(':uniacid' => $uniacid, ':setting_name'=>'msg_settings');
            $msg = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition, $params);

            $curr_date = date('Y-m-d H:i:s', time()); // 变量最长只能15个字符

            if (!(empty($msg))) {
                $messages = json_decode($msg['setting_value'], true);

                if ($messages['type']=='Alidayu') {
                    $mobile = $messages['Alidayu']['mobile'];
                    $content = array(
                        'time'=>$curr_date,
                        'phone' => $phone,
                        'money' => '0',
                    );
                    // sign = 签名
                    // sms_id = 短信模板ID
                    $data = array(
                        'appkey' => $messages['Alidayu']['appkey'],
                        'secret' => $messages['Alidayu']['secret'],
                        'sign' => $messages['Alidayu']['sign'],
                        'sms_id' => $messages['Alidayu']['sms_id'],
                        'curr_date' => $curr_date,
                    );
                    $res = sendsms($mobile, $content, $data);
                } else if ($messages['type']=='Alidysmslite') {
                    $mobile = $messages['Alidayu']['mobile'];
                    $content = array(
                        'time'=>$curr_date,
                        'phone' => $phone,
                        'money' => '0',
                    );
                    $data = array(
                        'appkey' => $messages['Alidayu']['appkey'],
                        'secret' => $messages['Alidayu']['secret'],
                        'sign' => $messages['Alidayu']['sign'],
                        'sms_id' => $messages['Alidayu']['sms_id'],
                        'curr_date' => $curr_date,
                    );
                    $res = sendsms_new($mobile, $content, $data);
                }
            }
        }

        return $res;
    }
}

// 发送用户通知短信
if (!function_exists('send_user_msg')) {
    function send_user_msg($phone, $money) {
        global $_W;

        $uniacid = $_W['uniacid'];
        $condition = ' and uniacid=:uniacid and setting_name=:setting_name';
        $params = array(':uniacid' => $uniacid, ':setting_name'=>'msg_user_settings');
        $msg = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition, $params);

        $curr_date = date('Y-m-d H:i:s', time()); // 变量最长只能15个字符

        if (!(empty($msg))) {
            $messages = json_decode($msg['setting_value'], true);

            if ($messages['type']=='Alidayu') {
                $mobile = $messages['Alidayu']['mobile'];
                $content = array(
                    'time'=>$curr_date,
                    'phone' => $phone,
                    'money' => '0',
                );
                // sign = 签名
                // sms_id = 短信模板ID
                $data = array(
                    'appkey' => $messages['Alidayu']['appkey'],
                    'secret' => $messages['Alidayu']['secret'],
                    'sign' => $messages['Alidayu']['sign'],
                    'sms_id' => $messages['Alidayu']['sms_id'],
                    'curr_date' => $curr_date,
                );
                $res = sendsms($mobile, $content, $data);
            } else if ($messages['type']=='Alidysmslite') {
                $mobile = $messages['Alidayu']['mobile'];
                $content = array(
                    'time'=>$curr_date,
                    'phone' => $phone,
                    'money' => '0',
                );
                $data = array(
                    'appkey' => $messages['Alidayu']['appkey'],
                    'secret' => $messages['Alidayu']['secret'],
                    'sign' => $messages['Alidayu']['sign'],
                    'sms_id' => $messages['Alidayu']['sms_id'],
                    'curr_date' => $curr_date,
                );
                $res = sendsms_new($mobile, $content, $data);
            }
        }

        return $res;
    }
}
