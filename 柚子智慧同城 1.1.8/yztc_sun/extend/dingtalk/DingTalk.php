<?php
namespace dingtalk;
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/9/17
 * Time: 10:57
 */
class DingTalk
{
    protected $url = 'https://oapi.dingtalk.com/robot/send';
    protected $token = '';

    function send($token,$msg){
        $result = $this->request_by_curl(
            $this->url."?access_token=".$token,
            $msg.'');
        return $result;
    }
    function request_by_curl($remote_server, $post_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}