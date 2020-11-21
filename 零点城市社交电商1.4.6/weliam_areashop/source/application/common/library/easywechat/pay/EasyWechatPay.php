<?php
/**
 * Created by 微连科技.
 * User: 漆大大
 * Date: 2019/4/10
 * Time: 17:48
 */

namespace app\common\library\easywechat\pay;


use app\common\exception\BaseException;
use app\common\model\UploadFile;
use app\common\model\Wxapp;
use app\store\model\payment\Payment;
use app\store\model\Setting;
use EasyWeChat\Factory;

class EasyWechatPay extends Factory
{
    private $app;
    private $jssdk;
    private $source;
    private $wxapp_id;
    public function __construct($data = [])
    {
        $this->source = $data['source'] ? :2;
        $this->wxapp_id = $data['wxapp_id'] ? : null;

        $configData  = Wxapp::getPamentCache($this->wxapp_id,$this->source,'wechat');
        $chanel = Setting::detail('channel');
        $chanel = $chanel?$chanel->toArray()['values'][sourNameE($this->source)]:[];
        if(!$chanel['AppId']) {
            throw new BaseException(['msg'=>'小程序 设置参数错误']);
        }
        if(empty($configData)) {
            throw new BaseException(['msg'=>'支付参数错误']);
        }
        $configData = json_decode($configData,true);
        $apiclient_cert_file_id = $configData['apiclient_cert_file_id'];
        $apiclient_key_file_id = $configData['apiclient_key_file_id'];
        $fileModel = new UploadFile();
        $f1 = $fileModel->find($apiclient_cert_file_id);
        $f2 = $fileModel->find($apiclient_key_file_id);

        $f1 = explode('uploads',$f1['file_path']);
        $certPem = WEB_PATH."uploads".$f1[1];
        $f2 = explode('uploads',$f2['file_path']);
        $keyPem = WEB_PATH."uploads".$f2[1];
        $config = [
            // 必要配置
            'app_id'             => $chanel['AppId'],
            'mch_id'             => $configData['mcn'],
            'key'                => $configData['appkey'],   // API 密钥
            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
            'cert_path'          => $certPem, // XXX: 绝对路径！！！！
            'key_path'           => $keyPem,      // XXX: 绝对路径！！！！
            'notify_url'         => base_url() . 'payment/WxApp_notify.php'//支付结果回调地址
        ];
        $this->app = Factory::payment($config);
        $this->jssdk = $this->app->jssdk;
    }
    //退款
    public function refund($transactionId,  $refundNumber,  $totalFee,  $refundFee,  $config = []){

        return $this->app->refund->byTransactionId($transactionId,  $refundNumber,  $totalFee*100,  $refundFee*100,  $config);
    }
    //退款
    public function refundbyOutTradeNumber($number,  $refundNumber,  $totalFee,  $refundFee,  $config = []){

        return $this->app->refund->byOutTradeNumber($number,  $refundNumber,  $totalFee*100,  $refundFee*100,  $config);
    }

    /**
     * Notes:微信支付统一下单
     * User: 漆乾明
     * Date: 2019/4/10
     * Time: 19:56
     * @param $body|商品名称
     * @param $out_trade_no|订单号
     * @param $total_fee|支付金额
     * @param $openid|用户openid
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    static function shortText($text,$len=32){
        if(strlen($text)>$len)
            return mb_substr($text,0,$len,"utf-8") . '...';
        else
            return $text;
    }
    private function createOrder($body,$out_trade_no,$total_fee,$openid,$trade_type='JSAPI'){
        return $this->app->order->unify([
            'body' => self::shortText($body),
            'out_trade_no' => $out_trade_no,
            'total_fee' => $total_fee,
            'trade_type' => $trade_type,
            'openid' => $openid,
        ]);
    }

    /**
     * Notes:小程序支付
     * User: 漆乾明
     * Date: 2019/4/10
     * Time: 19:56
     * @param $body|商品名称
     * @param $out_trade_no|订单号
     * @param $total_fee|支付金额
     * @param $openid|用户openid
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function pay($body,$out_trade_no,$total_fee,$openid){
        $trade_type = $this->source == 3 ? 'MWEB' : 'JSAPI';
        $createResult = self::createOrder($body,$out_trade_no,$total_fee*100,$openid,$trade_type);
        $result =  $this->jssdk->sdkConfig($createResult['prepay_id']); // 返回数组

        $payment = [
            'prepay_id' => $createResult['prepay_id'],
            'nonceStr' => $result['nonceStr'],
            'timeStamp' => (string)$result['timestamp'],
            'paySign' => $result['paySign']
        ];
        return $payment;
    }
    //企业付款到用户零钱
    public function transferToBalance($partner_trade_no,$openid,$amount,$desc){
       return $this->app->transfer->toBalance([
            'partner_trade_no' => $partner_trade_no, // 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
            'openid' => $openid,
            'check_name' => 'NO_CHECK', // NO_CHECK：不校验真实姓名, FORCE_CHECK：强校验真实姓名
            're_user_name' => '', // 如果 check_name 设置为FORCE_CHECK，则必填用户真实姓名
            'amount' => $amount*100, // 企业付款金额，单位为分
            'desc' => $desc, // 企业付款操作说明信息。必填
        ]);
    }

    /**
     * @param $partner_trade_no    (随机数)
     * @param $enc_bank_no         (银行卡号)
     * @param $enc_true_name       (持卡人名称)
     * @param $bank_code           (银行编号)
     * @param $amount              (提取金额)
     * @param $desc                (操作说明)
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * 企业付款到用户银行卡
     */
    public function transferToBankCard($partner_trade_no,$enc_bank_no,$enc_true_name,$bank_code,$amount,$desc){
        return $this->app->transfer->toBankCard([
            'partner_trade_no' => $partner_trade_no, // 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
            'enc_bank_no' => $enc_bank_no,  //银行卡号
            'enc_true_name' => $enc_true_name, // 银行卡对应的真实姓名
            'bank_code' => $bank_code, // 银行编号，具体对应微信银行编号列表
            'amount' => $amount * 100, // 企业付款金额，单位为分
            'desc' => $desc, // 企业付款操作说明信息。必填
        ]);
    }
    public function payH5($body,$out_trade_no,$total_fee,$openid){
        $createResult = self::createOrder($body,$out_trade_no,$total_fee*100,$openid);
        $result =  $this->jssdk->sdkConfig($createResult['prepay_id']); // 返回数组
        $payment = [
            'prepay_id' => $createResult['prepay_id'],
            'nonceStr' => $result['nonceStr'],
            'timeStamp' => (string)$result['timestamp'],
            'paySign' => $result['paySign']
        ];
        return $payment;
    }

    /**
     * @param $config
     * @param $data
     * @param $notify_url
     * @param $source
     * @return array
     * @throws BaseException
     * Notes:微信子商户支付
     * User: 漆乾明
     * Date: 2019/5/31
     * Time: 16:54
     */
    public function subPay($config,$data,$notify_url,$source){
        $paySetAll = \app\common\model\Setting::getItem('paySet',$this->wxapp_id);
        $paySet = $paySetAll['payset'];
        if(!$paySet){
            throw new BaseException([ 'msg' => '支付方式未开通，请使用余额支付！' ]);
        }
        if ($source == 2){//小程序
            $id = $paySet['wxapppay']['wechat'];
        }else{
            $id = $paySet['wechatpay']['wechat'];
        }
        $sub_appid = (new Payment())->payFind($id);
        $sub_appid = json_decode($sub_appid['param'],true);

        $this->app['config'] = [
            'app_id'             => $sub_appid['appid'],
            'sub_appid'          => $data['appid'],
            'mch_id'             => $config['mcn'],
            'key'                => $config['appkey'],   // API 密钥
            'notify_url'         => $notify_url//支付结果回调地址
        ];
        $this->app = Factory::payment($this->app['config']);

        $this->app = $this->app->setSubMerchant($config['cmcn'], $data['appid']);
        $createResult =  $this->app->order->unify([
            'body' => self::shortText("购买商品服务"),
            'out_trade_no' => $data['order_no'],
            'total_fee' => intval($data['pay_price']*100),
            'trade_type' => 'JSAPI',
            'sub_openid' => $data['openid'],
        ]);
        $result =  $this->app->jssdk->sdkConfig($createResult['prepay_id']); // 返回数组
        return [
            'appId'     => $result['appid'] ,
            'timeStamp' => (string)$result['timestamp'],
            'nonceStr'  => $result['nonceStr'],
            'package'   => $result['package'] ,
            'signType'  => $result['signType'] ,
            'paySign'   => $result['paySign']
        ];
    }

}