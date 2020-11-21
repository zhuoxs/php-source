<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Org\Net\Wechat;

class WeixinController extends BaseController{
    protected $openid;
    public function _initialize() {
        //调试用户----------------------------
        /*$wx_user = D('wx_user')->find();
        session('wxuser', $wx_user);*/
        //------------------------------------

        if( $_SESSION['wxuser']['openid'] == '' ) {

            $config = C('WEIXINPAY_CONFIG');
            $options = array (
                'token' => '', // 填写你设定的key
                'encodingaeskey' => '', // 填写加密用的EncodingAESKey
                'appid' => $config ["APPID"], // 填写高级调用功能的app id
                'appsecret' => $config ["APPSECRET"], // 填写高级调用功能的密钥
                'partnerid' => '', // 财付通商户身份标识
                'partnerkey' => '', // 财付通商户权限密钥Key
                'paysignkey' => ''  // 商户签名密钥Key
            );

    //        import("ORG.Wechat.Wechat");
            $weObj = new Wechat($options);
            $info = $weObj->getOauthAccessToken();
            if(!$info) {
                //$callback = 'http://' . $_SERVER ['SERVER_NAME']. U("Home/Wechat/getOpenid",$_GET);
                $callback = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                $url = $weObj->getOauthRedirect($callback,'','snsapi_base');
                header("Location: $url");
                exit();
            }
            else
            {
                $openid = $info['openid'];
            }
            $wx_info = $weObj->getUserInfo($openid);

            print_r($wx_info);
            exit;

            //$this->getOpenid();
        }
    }


    public function index()
    {

    }

}