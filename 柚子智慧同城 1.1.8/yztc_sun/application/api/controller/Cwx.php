<?php
namespace app\api\controller;

use app\model\Config;
use app\model\System;
use app\model\Task;
use think\Loader;

class Cwx extends Api
{
    public function getopenid(){
        $code = input('request.code');
        $system = System::get_curr();

        $appid = $system->appid;
        $appsecret = $system->appsecret;

        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appsecret."&js_code=".$code."&grant_type=authorization_code";
        function httpRequest($url,$data = null){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            if (!empty($data)){
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);
            return $output;
        }
        $re=httpRequest($url);
        $ret = json_decode($re);
        if (isset($ret->openid)){
            $this->ajaxSuccess($ret->openid);
        }else{
            $this->ajaxError('['.$ret->errcode.']'.$ret->errmsg);
        }
    }

    /**支付*/
    public function pay($openid,$total_fee=0.01,$attach,$body='充值') {
        global $_W;
        Loader::import('wxpay.wxpay');
        $system = System::get_curr();
        $appid = $system['appid'];
        $mch_id = $system['mchid'];//商户号
        $key = $system['wxkey'];   //密钥
        $out_trade_no = date('YmdHis') . substr('' . time(), -4, 4);//订单号
        $total_fee = intval($total_fee*100);//价格
//        $body='充值';
//        $attach=$attach;
        $siteroot=str_replace("https","http",$_W['siteroot']);
        $notify_url=$siteroot.'/addons/yztc_sun/public/notify.php';
        if($total_fee<=0){
            error_json('金额有误');
        }
        $weixinpay = new \WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee,$attach,$notify_url);
        $return = $weixinpay->pay();
        return $return;
    }
    function randstr($length=20)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }
    function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,60);
        curl_setopt($curl, CURLOPT_SSLVERSION, 4);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
    function createPaySign($result)
    {
        global  $_W;
        $appData = pdo_get('yzkq_sun_system',array('uniacid'=>$_W['uniacid']));
        $keys = $appData['wxkey'];
        $data = array(
            'appId' => $result['appid'],
            'timeStamp' => (string)time(),
            'nonceStr' => $result['nonce_str'],
            'package' => 'prepay_id=' . $result['prepay_id'],
            'signType' => 'MD5'
        );
        ksort($data, SORT_ASC);
        $stringA = '';
        foreach ($data as $key => $val) {
            $stringA .= "{$key}={$val}&";
        }
        $signTempStr = $stringA . 'key='.$keys;
        $signValue = strtoupper(md5($signTempStr));
        $data['paySign'] = $signValue;
        $data['prepay_id']=$result['prepay_id'];
        return $data;
    }

//    获取微信二维码图片
    public function getQRCode(){
        $link = input('request.link');
        $page_path = explode('?',$link)[0]?:'';
        $scene = explode('?',$link)[1]?:'a=a';

        $access_token = getAccessToken();
        if (!preg_match('/[0-9a-zA-Z\!\#\$\&\'\(\)\*\+\,\/\:\;\=\?\@\-\.\_\~]{1,32}/', $scene)) {
            return $this->result(1, '场景值不合法', array());
        }

        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$access_token;//B

        $data = [
            'scene'=>$scene,
            'page'=>$page_path,
            'width'=>430,
            'auto_color'=>false,
            'line_color'=>[
                'r' => '#ABABAB',
                'g' => '#ABABAC',
                'b' => '#ABABAD',
            ]
        ];
        $json_data = json_encode($data);
        $return = httpRequest($url,$json_data);

//        文件名
        $filename = time().rand(10000,99999).'.png';
//        保存位置
        $path = '/addons/yztc_sun/runtime/qrcode/';
        if(!is_dir(IA_ROOT.$path)){
            mkdir(IA_ROOT.$path);
        }


//        if (is_string($response)){
//            $response2 = json_decode($response);
//        }else{
//            $response2 = $response;
//        }
//        if ($response2['errno']){
//            error_json($response2['message']);
//        }

        file_put_contents(IA_ROOT . $path. $filename, $return);

        $distribution_share_msg = Config::get_value('distribution_share_msg','');
        $distribution_share_title = Config::get_value('distribution_share_title','');
        $distribution_share_banner = Config::get_value('distribution_share_banner','');

//        返回图片地址
        global $_W;
        $root = $_W['siteroot'];//str_replace("https","http",$_W['siteroot']);
        success_withimg_json([
            'root'=>$root,
            'path'=>$path.$filename,
            'banner'=>$distribution_share_banner,
            'title'=>$distribution_share_title,
            'msg'=>$distribution_share_msg,
        ]);
    }
    public function deleteQRCode(){
        $path = input('request.path');
        if ($path){
            $ret = unlink(IA_ROOT.$path);
            if ($ret){
                success_json('删除成功');
            }
            error_json('删除失败');
        }else{
            error_json('地址为空');
        }
    }

    public function test(){
        \app\model\Order::confirm(input('request.order_id'));
    }
}
