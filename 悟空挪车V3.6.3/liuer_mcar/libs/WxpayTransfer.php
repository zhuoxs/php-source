<?php
/**
 * WxpayTransfer.php
 * @authors
 */
class WxpayTransfer{
    const API_URL = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
    private $_appid;
    private $_merchantid;
    private $_key;
    private $apiclient_cert;
    private $apiclient_key;

    public function __construct($config)
    {
        $this->_appid = $config['appid'];
        $this->_merchantid = $config['mchid'];
        $this->_key = $config['key'];
        $this->apiclient_cert = $config['apiclient_cert'];
        $this->apiclient_key = $config['apiclient_key'];
    }

    function transfer($data, $debug = false)
    {
        if ($debug) {
            return ['code' => 1, 'msg' => '测试转账'];
        }
        //支付信息
        $webdata = array(
            'mch_appid' => $this->_appid,//商户账号appid
            'mchid' => $this->_merchantid,//商户号
            'nonce_str' => $this->getNonceStr(),//随机字符串
            'partner_trade_no' => $data['order_sn'], //商户订单号，需要唯一
            'openid' => $data['openid'],//转账用户的openid
            //'re_user_name' => $data['truename'],
            'check_name' => 'NO_CHECK', //OPTION_CHECK不强制校验真实姓名, FORCE_CHECK：强制 NO_CHECK：
            'amount' => $data['money'] * 100, //付款金额单位为分
            'desc' => $data['desc'],//企业付款描述信息
            'spbill_create_ip' => $data['ip'],//获取IP
        );
        foreach ($webdata as $k => $v) {
            $tarr[] = $k . '=' . $v;
        }
        sort($tarr);
        $sign = implode($tarr, '&');
        $sign .= '&key=' . $this->_key;
        $webdata['sign'] = strtoupper(md5($sign));
        $wget = $this->ArrToXml($webdata);//数组转XML
        $res = $this->postData(self::API_URL, $wget);//发送数据
        if(array_key_exists('error',$res)){
            return ['code'=>0,'msg'=>$res['msg']];
        }
        /*if (!$res) {
            return array('code' => 0, 'msg' => "不能连接到服务器");
        }*/
        $content = simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (strval($content->return_code) == 'FAIL') {
            return array('code' => 0, 'msg' => strval($content->return_msg));
        }
        if (strval($content->result_code) == 'FAIL') {
            return array('code' => 0, 'msg' => strval($content->err_code_des));
        }
        $rdata = array(
            'mch_appid' => strval($content->mch_appid),
            'mchid' => strval($content->mchid),
            'device_info' => strval($content->device_info),
            'nonce_str' => strval($content->nonce_str),
            'result_code' => strval($content->result_code),
            'partner_trade_no' => strval($content->partner_trade_no),
            'payment_no' => strval($content->payment_no),
            'payment_time' => strval($content->payment_time),
        );
        return array('code' => 1, 'data' => $rdata);
    }


    //数组转XML
    protected function ArrToXml($arr)
    {
        if (!is_array($arr) || count($arr) == 0) return '';
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }


    //发送数据
    protected function postData($url, $postfields)
    {
        $ch = curl_init();
        $params[CURLOPT_URL] = $url;    //请求url地址
        $params[CURLOPT_HEADER] = false; //是否返回响应头信息
        $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
        $params[CURLOPT_FOLLOWLOCATION] = true; //是否重定向
        $params[CURLOPT_POST] = true;
        $params[CURLOPT_POSTFIELDS] = $postfields;
        $params[CURLOPT_SSL_VERIFYPEER] = false;
        $params[CURLOPT_SSL_VERIFYHOST] = false;
        //以下是证书相关代码
        $params[CURLOPT_SSLCERTTYPE] = 'PEM';
        $params[CURLOPT_SSLCERT] = $this->apiclient_cert;//绝对路径
        $params[CURLOPT_SSLKEYTYPE] = 'PEM';
        $params[CURLOPT_SSLKEY] = $this->apiclient_key;//绝对路径
        curl_setopt_array($ch, $params); //传入curl参数
        $content = curl_exec($ch); //执行
        if(curl_errno($ch)){
            return ['error'=>1,'msg'=>curl_errno($ch) . '#' . curl_error($ch)];
        }
        curl_close($ch); //关闭连接
        return $content;
    }

    //随机字符串(不长于32位)
    protected function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}