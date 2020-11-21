<?php

namespace app\model;
use think\Loader;
use think\Db;

class Sms extends Base
{

    //发送短信
    /**
     * @param $store_id 商户id
     * @param $smstype  0下单提醒 1退款订单提醒
     */
    public function SendSms($store_id,$smstype){
        global $_W;
        $sms=Db::name('sms')->where(array('uniacid'=>$_W['uniacid']))->find();

        $phone=Store::get(['id'=>$store_id])['phone'];

        if($sms&&$sms['is_open']==1){
            if($sms["smstype"]==1){
                $msg = $smstype==1?$sms["ytx_orderrefund"]:$sms["ytx_order"];
                if($msg!=''){
                    $this->SendYtxSms($msg,$sms,$phone);
                }
            }else if($sms["smstype"]==3){
                $sendid = $smstype==1?$sms["aly_orderrefund"]:$sms["aly_order"];
                $this->SendAldy($sms,$phone,$sendid);
            }
        }
    }

    //253云通信
    public function SendYtxSms($sendid='',$sms=array(),$mobile=''){
        $postArr = array (
            'account'  => $sms["ytx_apiaccount"],
            'password' => $sms["ytx_apipass"],
            'msg' => $sendid,
            'phone' => $mobile,
            'report' => 'true'
        );
        $url = "http://smssh1.253.com/msg/send/json";
        $result = $this->curlPost($url, $postArr);
        return $result;
    }
    //聚合短信
    public function SendJuheSms($phone=0,$sendid=0,$sms=array()){
        header('content-type:text/html;charset=utf-8');
        $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
        $smsConf = array(
            'key'   => $sms["appkey"], //您申请的APPKEY
            'mobile'    => $phone, //接受短信的用户手机号码
            'tpl_id'    => $sendid, //您申请的短信模板ID，根据实际情况修改
            'tpl_value' =>'#code#=1234&#company#=聚合数据' //您设置的模板变量，根据实际情况修改
        );
        $content = $this->juhecurl($sendUrl,$smsConf,1); //请求发送短信
        if($content){
            $result = json_decode($content,true);
            $error_code = $result['error_code'];
            if($error_code == 0){
                //状态为0，说明短信发送成功
                echo "短信发送成功,短信ID：".$result['result']['sid'];
            }else{
                //状态非0，说明失败
                $msg = $result['reason'];
                return "短信发送失败(".$error_code.")：".$msg;
            }
        }else{
            //返回内容异常，以下可根据业务逻辑自行修改
            return "请求发送短信失败";
        }
    }
    //阿里大于(阿里云)
    public function SendAldy($sms,$phone,$sendid){
        Loader::import('aliyun-dysms.sendSms');
        set_time_limit(0);
        header('Content-Type: text/plain; charset=utf-8');
        $return = sendSms($sms["aly_accesskeyid"],$sms["aly_accesskeysecret"],$phone,$sms["aly_sign"],$sendid);
        return $return;
    }


    //post请求
   public function curlPost($url,$postFields){
        $postFields = json_encode($postFields);
        $ch = curl_init ();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8'   //json版本需要填写  Content-Type: application/json;
            )
        );
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt( $ch, CURLOPT_TIMEOUT,60);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec ( $ch );
        if (false == $ret) {
            $result = curl_error(  $ch);
        } else {
            $rsp = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
            if (200 != $rsp) {
                $result = "请求状态 ". $rsp . " " . curl_error($ch);
            } else {
                $result = $ret;
            }
        }
        curl_close ( $ch );
        return $result;
    }
    //聚合短信情路
   public function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost ){
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }



}
