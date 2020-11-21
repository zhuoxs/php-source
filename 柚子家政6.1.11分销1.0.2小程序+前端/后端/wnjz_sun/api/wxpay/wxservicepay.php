<?php 
require_once IA_ROOT . "/addons/wnjz_sun/api/wxpay/wxservice.php";

class WeixinPay extends WxService {

    protected $appid;
    protected $sub_appid;
    protected $mch_id;
    protected $sub_mch_id;
    protected $key;
    protected $openid;
    protected $out_trade_no;
    protected $body;
    protected $total_fee;
    protected $notify_url;
    protected $attach;

    function __construct($appid,$sub_appid, $openid, $mch_id, $sub_mch_id, $key,$out_trade_no,$body,$total_fee,$notify_url,$attach) {
        $this->appid = $appid;
        $this->sub_appid = $sub_appid;
        $this->openid = $openid;
        $this->mch_id = $mch_id;
        $this->sub_mch_id = $sub_mch_id;
        $this->key = $key;
        $this->out_trade_no = $out_trade_no;
        $this->body = $body;
        $this->total_fee = $total_fee;
        $this->notify_url = $notify_url;
        $this->attach = $attach;
    }

    public function pay() {
        //统一下单接口
        $return = $this->weixinapp();
        return $return;
    }

    //统一下单接口
    private function unifiedorder() {
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';//https://api.mch.weixin.qq.com/pay/unifiedorder
        $parameters = array(
            'appid' => $this->appid, //微信分配的公众账号ID
            'mch_id' => $this->mch_id, //商户号
            'sub_appid' => $this->sub_appid, //小程序ID
            'sub_mch_id' => $this->sub_mch_id, //子商户号
            'nonce_str' => $this->createNoncestr(), //随机字符串
            'body' => $this->body,
            'out_trade_no'=> $this->out_trade_no,//商户订单号
            'total_fee' => $this->total_fee,//总金额 单位 分
            'spbill_create_ip' => '120.79.152.105', //终端IP
            'notify_url' => $this->notify_url, //通知地址  确保外网能正常访问
            'sub_openid' => $this->openid, //用户id
            'attach' => $this->attach, //
            'trade_type' => 'JSAPI'//交易类型
        );
        // echo json_encode($parameters);
        //统一下单签名
        $parameters['sign'] = $this->getSign($parameters,$this->key);
        $xmlData = $this->arrayToXml($parameters);
        $return = $this->xmlToArray($this->postXmlCurl($xmlData, $url));
        // echo $return;
        return $return;
    }

    //微信小程序接口
    private function weixinapp() {
        //统一下单接口
        $unifiedorder = $this->unifiedorder();
//        print_r($unifiedorder);
        $parameters = array(
            'appId' => $this->sub_appid, //小程序ID
            'timeStamp' => '' . time() . '', //时间戳
            'nonceStr' => $this->createNoncestr(), //随机串
            'package' => 'prepay_id=' . $unifiedorder['prepay_id'], //数据包
            'signType' => 'MD5'//签名方式
        );
        //签名
        $parameters['paySign'] = $this->getSign($parameters,$this->key);
        return $parameters;
    }
}		
			
		
