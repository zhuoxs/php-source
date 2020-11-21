<?php
class WeixinTake {
    protected $appid;
    protected $mch_id;
    protected $openid;
    protected $key;
    protected $out_trade_no;
    protected $money;
    protected $check_name;
    protected $desc;
    function __construct($appid, $openid, $mch_id, $key,$out_trade_no,$money,$check_name = "NO_CHECK",$desc= '提现') {
        $this->appid = $appid;
        $this->openid = $openid;
        $this->mch_id = $mch_id;
        $this->key = $key;
        $this->out_trade_no = $out_trade_no;
        $this->money = $money;
        $this->check_name= $check_name;
        $this->desc= $desc;
    }

    public function take(){
        $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $data = array(
            'mch_appid'=> $this->appid,
            'mchid'=> $this->mch_id,
            'partner_trade_no'=> $this->out_trade_no,
            'openid'=> $this->openid,
            'amount'=> $this->money,
            'check_name'=> $this->check_name,
            'desc'=> $this->desc,
            'nonce_str'=> $this->createNoncestr(),
            'spbill_create_ip'=> $_SERVER['REMOTE_ADDR'],
        );
        $data['sign'] = $this->getSign($data);

        $xmlData = $this->arrayToXml($data);
        $xml_ret = $this->postXmlCurl($xmlData, $url, 60);
        $return = $this->xmlToArray($xml_ret);
        if(!($return['return_code']=='SUCCESS' && $return['result_code']=='SUCCESS')) {
            $return['code'] = $return['err_code'];
            $return['msg'] = $return['err_code_des'];
        }
        return $return;
    }

    private static function postXmlCurl($xml, $url, $second = 30) 
    {
        global $_W;
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_URL, $url);

//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //严格校验

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, IA_ROOT . '/addons/yztc_sun/cert/apiclient_cert_'.$_W['uniacid'].'.pem');
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, IA_ROOT . '/addons/yztc_sun/cert/apiclient_key_'.$_W['uniacid'].'.pem');


        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        set_time_limit(0);


        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new ZhyException("curl出错，错误码:$error");
        }
    }

    //数组转换成xml
    private function arrayToXml($arr) {
        $xml = "<root>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</root>";
        return $xml;
    }

    //xml转换成数组
    private function xmlToArray($xml) {


        //禁止引用外部xml实体 


        libxml_disable_entity_loader(true);


        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);


        $val = json_decode(json_encode($xmlstring), true);


        return $val;
    }

    //作用：产生随机字符串，不长于32位
    private function createNoncestr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    //作用：生成签名
    private function getSign($Obj) {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $this->key;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }

    ///作用：格式化参数，签名过程需要使用
    private function formatBizQueryParaMap($paraMap, $urlencode) {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar; 
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }
}		
			
		
