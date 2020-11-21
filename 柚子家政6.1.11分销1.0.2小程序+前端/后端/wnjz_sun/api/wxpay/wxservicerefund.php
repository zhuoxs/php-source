<?php 
require_once IA_ROOT . "/addons/wnjz_sun/api/wxpay/wxservice.php";

class WxserviceRefund extends WxService {

    protected $appid;//服务商ID
    protected $sub_appid;//小程序的APPID
    protected $mch_id;//商户号
    protected $sub_mch_id;//子商户号
    protected $out_trade_no;//商户订单号
    protected $out_refund_no;//商户退款单号   
    protected $total_fee;//订单金额
    protected $refund_fee;//申请退款金额
    protected $key;//商户秘钥
    protected $f1;//证书cert
    protected $f2;//证书key

    function __construct($appid,$sub_appid, $mch_id, $sub_mch_id,$key, $out_trade_no,$out_refund_no,$total_fee,$refund_fee,$f1,$f2) {
        $this->appid = $appid;
        $this->sub_appid = $sub_appid;
        $this->mch_id = $mch_id;
        $this->sub_mch_id = $sub_mch_id;
        $this->out_trade_no = $out_trade_no;
        $this->out_refund_no = $out_refund_no;
        $this->total_fee = $total_fee;
        $this->refund_fee = $refund_fee;
        $this->key = $key;
        $this->f1 = $f1;
        $this->f2 = $f2;
    }

    //统一退款接口
    public function refund() {
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';//https://api.mch.weixin.qq.com/pay/unifiedorder
        $parameters = array(
            'appid' => $this->appid, //微信分配的公众账号ID
            'mch_id' => $this->mch_id, //商户号
            'sub_appid' => $this->sub_appid, //小程序ID
            'sub_mch_id' => $this->sub_mch_id, //子商户号
            'nonce_str' => $this->createNoncestr(), //随机字符串
            'out_trade_no'=> $this->out_trade_no,//商户订单号
            'out_refund_no' => $this->out_refund_no, //商户退款单号
            'total_fee' => $this->total_fee,//总金额 单位 分
            'refund_fee' => $this->refund_fee,//商户退款单号
        );
        //统一下单签名
        $parameters['sign'] = $this->getSign($parameters,$this->key);
        $xmlData = $this->arrayToXml($parameters);
        // print_r($xmlData);
        $return = $this->xmlToArray($this->postXmlCurl($xmlData, $url,true,$this->f1,$this->f2, 60));
        // echo $return;
        return $return;
    }

}		
			
		
