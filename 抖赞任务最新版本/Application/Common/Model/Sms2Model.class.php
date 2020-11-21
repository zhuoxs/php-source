<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 短信发送
 */
class Sms2Model extends BaseModel{

    public static function send($phones,$msg,&$errMSG){
        $config = C('SMS2');
        $url = $config['url'];
        $userid =  $config['user_id'];
        $account = $config['account'];
        $password = $config['password'];
        $extno = $config['extno'];
        $msg = $config['sign'] . $msg;
        //$msg = iconv( "UTF-8","GB2312//IGNORE",$msg);
        $post_data = array(
            'userid' => $userid,
            'account' => $account,
            'password' => $password,
            'mobile' => $phones,
            'content' => $msg,
            'sendTime' => '',
            'action' => 'send',
            'extno' => $extno,
        );
        $postData = http_build_query($post_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $output = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($output);
        $returnstatus = (string)$xml->returnstatus;

        if($returnstatus !== 'Success'){
            $errMSG = "验证码发送失败：" . (string)$xml->message;
            return false;
        }
        return true;

    }
}