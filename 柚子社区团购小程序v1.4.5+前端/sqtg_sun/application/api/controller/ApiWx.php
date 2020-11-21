<?php
namespace app\api\controller;

use app\model\Config;
use app\model\System;
use app\model\Task;
use think\Loader;
use app\base\controller\Api;

class ApiWx extends Api
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
            success_json($ret);
        }else{
            return_json('['.$ret->errcode.']'.$ret->errmsg,-1);
        }
    }
    public function login(){
        $openid = input('request.openid');
        $info = \app\model\User::get(['openid'=>$openid])?:new \app\model\User();

        $data = input('request.');
        $data['login_time'] = time();
        $data['login_ip'] = $_SERVER["REMOTE_ADDR"];

        $share_user_id = $data['share_user_id'];

//        邀请人如果不是分销商，则不记录
//        if(!User::isDistribution($share_user_id)){
//            $share_user_id = 0;
//        }

        $data['last_share_user_id'] = $share_user_id;
//        第一次进入
        if(!isset($info->id) || !$info->id){
            $data['first_share_user_id'] = $share_user_id;
        }
        unset($data['share_user_id']);

        //还没确定上线
//        if (!isset($info->share_user_id) || ! $info->share_user_id){
//            if (!Config::get_value('distribution_relation')){
//                $data['share_user_id'] = $share_user_id;
//            }
//        }

        $ret = $info->allowField(true)->save($data);

        if ($ret){
            success_json($info);
        }else{
            return_json('登录失败',-1);
        }
    }
    /**
     * 绑定手机号
    */
    public function blindTel(){
        $user_id=input('post.user_id');
        $tel=input('post.tel');
        $isbland=\app\model\User::get(['tel'=>$tel]);
        if($isbland){
            return_json('该手机号已被绑定',-1);
        }else{
            $res=\app\model\User::update(['tel'=>$tel],['id'=>$user_id]);
            if($res){
                return_json();
            }else{
                return_json('绑定失败，请重试',-1);
            }
        }
    }
    /**支付*/
    public function pay($openid,$total_fee=0.01,$attach,$body='消费支付') {
        global $_W;
        Loader::import('wxpay.wxpay');
        $system = System::get_curr();
        $appid = $system['appid'];
        $mch_id = $system['mchid'];//商户号
        $key = $system['wxkey'];   //密钥
        $out_trade_no = date('YmdHis') . substr('' . time(), -4, 4);//订单号
        $total_fee = sprintf("%.0f",$total_fee*100);//价格
        $siteroot=str_replace("https","http",$_W['siteroot']);
        $notify_url=$siteroot.'/addons/lhy_sun/public/notify.php';
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
        $is_hyaline=(input('post.is_hyaline',1))==1?true:false;
        $data = [
            'scene'=>$scene,
            'page'=>$page_path,
            'width'=>430,
            'auto_color'=>false,
            'line_color'=>[
                'r' => '#ABABAB',
                'g' => '#ABABAC',
                'b' => '#ABABAD',
            ],
            'is_hyaline'=>$is_hyaline
        ];
        $json_data = json_encode($data);
        $return = httpRequest($url,$json_data);

        $newpath=IA_ROOT."/attachment/";
        $filename=time().rand(1000,9999).".jpg";///要生成的图片名字

        $file = fopen($newpath.$filename,"w");//打开文件准备写入
        fwrite($file,$return);//写入
        fclose($file);//关闭
        //远程附件存储
        @require_once (IA_ROOT."/framework/function/file.func.php");
        @$filenames=$filename;
        @file_remote_upload($filenames);

////        文件名
//        $filename = time().rand(10000,99999).'.png';
////        保存位置
        $path = '/addons/lhy/attachment/';
//        if(!is_dir(IA_ROOT.$path)){
//            mkdir(IA_ROOT.$path);
//        }

//        file_put_contents(IA_ROOT . $path. $filename, $return);

        $distribution_share_msg = Config::get_value('distribution_share_msg','');
        $distribution_share_title = Config::get_value('distribution_share_title','');
        $distribution_share_banner = Config::get_value('distribution_share_banner','');

//        返回图片地址
        global $_W;
        $root = $_W['siteroot'];//str_replace("https","http",$_W['siteroot']);
        success_withimg_json([
            'root'=>$root,
            'path'=>$filename,
            'banner'=>$distribution_share_banner,
            'title'=>$distribution_share_title,
            'msg'=>$distribution_share_msg,
        ]);
    }
    public function deleteQRCode(){
        $path = input('request.path');
        if ($path){
            $ret = unlink(IA_ROOT."/attachment/".$path);
            if ($ret){
                success_json('删除成功');
            }
            error_json('删除失败');
        }else{
            error_json('地址为空');
        }
    }

    public function decryptPhone(){
        Loader::import('wxpay.wxBizDataCrypt');
        $appid = System::get_curr()['appid'];
        $sessionKey = input('post.sessionKey');
        $model = new \WXBizDataCrypt($appid, $sessionKey);
        $encryptedData = input('post.encryptedData');
        $iv = input('post.iv');
        $errCode = $model->decryptData($encryptedData, $iv, $data);
        if ($errCode == 0) {
            success_json(json_decode($data,true));
        } else {
            print($errCode . "\n");
        }
    }
}
