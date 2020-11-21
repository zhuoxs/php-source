<?php

//商户付款

require_once 'WxPay.Data.php';
class WxMchPay extends WxPayDataBase {

    public  function MchPayOrder($openid, $money, $payId) {

        $this->values['mch_appid'] =    WX_APPID;
        $this->values['mchid']     =    WX_MCHID;
        $this->values['nonce_str'] = self::getNonceStr();
        $this->values['partner_trade_no'] = $payId . date('YmdHis', $_SERVER['REQUEST_TIME']);
        $this->values['openid'] = $openid;
        $this->values['check_name'] = 'NO_CHECK';
        $this->values['amount'] = $money;
        $this->values['desc'] = '提现';
        $this->values['spbill_create_ip'] = gethostbyname($_SERVER['SERVER_NAME']);
        $this->SetSign();
        $api = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';

        $xml = $this->ToXml();
        $response = self::postXmlCurl($xml, $api, true);
        return $this->FromXml($response);
    }

    /**
     * 以post方式提交xml到对应的接口url
     * 
     * @param string $xml  需要post的xml数据
     * @param string $url  url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second   url执行超时时间，默认30s
     * @throws WxPayException
     */
    private static function postXmlCurl($xml, $url, $useCert = false, $second = 30) {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        //如果有配置代理这里就设置代理
        if (WX_CURL_PROXY_HOST != "0.0.0.0" && WX_CURL_PROXY_PORT != 0) {
            curl_setopt($ch, CURLOPT_PROXY, WX_CURL_PROXY_HOST);
            curl_setopt($ch, CURLOPT_PROXYPORT, WX_CURL_PROXY_PORT);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //echo WX_SSLCERT_PATH;
        //echo WX_SSLKEY_PATH;
       // die;
        if ($useCert == true) {
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT,WX_SSLCERT_PATH);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, WX_SSLKEY_PATH);
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException("curl出错，错误码:$error");
        }
    }

    public static function getNonceStr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

}
