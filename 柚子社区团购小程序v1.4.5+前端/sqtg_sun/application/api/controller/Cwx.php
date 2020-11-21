<?php
namespace app\api\controller;
use app\base\controller\Api;
use app\model\Baowen;
use app\model\Config;
use app\model\System;
use app\model\Payrecord;
use think\Exception;
use think\Loader;
use think\Log;
use \wxcrypt\WXBizDataCrypt;

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
            $this->ajaxSuccess($ret);
        }else{
            $this->ajaxError('['.$ret->errcode.']'.$ret->errmsg);
        }
    }

    /**支付*/
    public function pay($openid,$total_fee=0.01,$id,$type='Order',$body='充值') {
        global $_W;
        if($total_fee<=0){
            error_json('金额有误');
        }
//        $total_fee = 0.01;//todo 删除
        $out_trade_no = date('YmdHis') . substr('' . time(), -4, 4);//订单号
        $payrecord = [
            'source_type'=>$type,
            'source_id'=>$id,
            'pay_money'=>$total_fee,
            'pay_time'=>time(),
            'openid'=>$openid,
            'no'=>$out_trade_no,
        ];
        $payrecord_model = new Payrecord();
        $payrecord_model->allowField(true)->save($payrecord);

        $attach = json_encode([
            'payrecord_id'=>$payrecord_model->id,
        ]);

        Loader::import('wxpay.wxpay');
        $system = System::get_curr();
        $appid = $system['appid'];
        $mch_id = $system['mchid'];//商户号
        $key = $system['wxkey'];   //密钥

        $total_fee = intval(strval($total_fee*100));//价格
        $siteroot=$_W['siteroot'];
        $siteroot=str_replace("https","http",$siteroot);
        $notify_url=$siteroot.'/addons/sqtg_sun/public/notify.php';

        $weixinpay = new \WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee,$attach,$notify_url);
        $return = $weixinpay->pay();
        if (!$return['prepay_id']){
            error_json($return['return_msg'].'，请联系管理员！');
        }
        return $return;
    }
    //回调方法
    public function paycallback(){
        Log::record('回调进入','callback');
        $xml = file_get_contents('php://input');
        $obj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $data = json_decode(json_encode($obj), true);
        //增加报文记录
        $baowen=array();
        $baowen['xml']=$xml;
        $baowen['out_trade_no']=$data['out_trade_no'];
        $baowen['transaction_id']=$data['transaction_id'];
        $baowen['add_time']=time();
        $baowen_model = new Baowen($baowen);
        $baowen_model->allowField(true)->save();
        try{
            if($this->checksign($data)){
                $attach = json_decode($data['attach'],true);
                $payrecord_id = $attach['payrecord_id'];

                $payrecord = Payrecord::get($payrecord_id);
                if ($payrecord['callback_time']){
                    die('SUCCESS');
                }

                global $_W;
                $_W['uniacid'] = $payrecord['uniacid'];

                $ret = $payrecord->save([
                    'callback_time'=>time(),
                    'callback_xml'=>json_encode($data),
                ]);
                if ($ret){
                    die('SUCCESS');
                }
            }
        }catch (Exception $e){
        }
        echo 'FAIL';
    }
    //签名验证
    private function checksign($data){

        $get=$data;
        $string1 = '';
        ksort($get);
        foreach($get as $k => $v) {
            if($v != '' && $k != 'sign') {
                $string1 .= "{$k}={$v}&";
            }
        }
        //   $uniacid=explode('-',$data['attach']);
        $attach=json_decode($data['attach'],true);

        $payrecord = Payrecord::get($attach['payrecord_id']);
        $system=System::get(['uniacid'=>$payrecord['uniacid']]);

        $wxkey=$system['wxkey'];
        $sign = strtoupper(md5($string1 . "key=$wxkey"));
        if($sign==$get['sign']){
            return true;
        }else{
            return false;
        }
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
        $path = '/addons/sqtg_sun/runtime/qrcode/';
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

    public function decrypt(){
        $system = System::get_curr();
        $appid = $system['appid'];

        $key = input('request.key');
        $iv = urldecode(input('request.iv'));
        $data = input('request.data');

        $wx = new WXBizDataCrypt($appid,$key);

        $ret = "";
        $r = $wx->decryptData($data,$iv,$ret);
        $ret = json_decode($ret);
        success_json($ret);
    }
}
