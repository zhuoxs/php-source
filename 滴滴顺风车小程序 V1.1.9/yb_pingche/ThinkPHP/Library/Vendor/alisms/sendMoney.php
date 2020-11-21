<?php
/**
 * 企业支付到零钱接口
 * @author 上帝禁区<593894955@qq.com>
 * 示例
 *   $sendmoney = new sendMoney($appid,$mchid,$secrect_key,$ip,$sslcert_path,$sslkey_path);
 */
class sendMoney{
    private $APPID="";
    private $MCHID="";
    private $SECRECT_KEY="";
    private $IP="";
    private $SSLCERT_PATH = '';
    private $SSLKEY_PATH = '';
    
    function __construct($appid,$mchid,$secrect_key,$ip,$sslcert_path,$sslkey_path){
        $this->APPID=$appid;
        $this->MCHID=$mchid;
        $this->SECRECT_KEY=$secrect_key;
        $this->IP=$ip;
        $this->SSLCERT_PATH=$sslcert_path;
        $this->SSLKEY_PATH=$sslkey_path;
    }
    
    
    function createNoncestr($length =32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

    function unicode() {
        $str = uniqid(mt_rand(),1);
        $str=sha1($str);
        return md5($str);
    }

    function arraytoxml($data){
        $str='<xml>';
        foreach($data as $k=>$v) {
            $str.='<'.$k.'>'.$v.'</'.$k.'>';
        }
        $str.='</xml>';
        return $str;
    }
    function xmltoarray($xml) {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring),true);
        return $val;
    }
    function curl($param="",$url) {
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();                                      //初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);                 //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);        // 增加 HTTP Header（头）里的字段
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_SSLCERT,$this->SSLCERT_PATH);   //这个是证书的位置绝对路径//ROOT_PATH .'/wxpay/cacert/apiclient_cert.pem'
        curl_setopt($ch,CURLOPT_SSLKEY,$this->SSLKEY_PATH);     //这个也是证书的位置绝对路径//ROOT_PATH .'/wxpay/cacert/apiclient_key.pem'
        $data = curl_exec($ch);                                 //运行curl
        curl_close($ch);
        return $data;
    }

    /*
    $amount     //发送的金额（分）目前发送金额不能少于1元
    $re_openid, //发送人的 openid
    $desc       //企业付款描述信息 (必填)
    $check_name //收款用户姓名 (选填)
    */
    function sendmoney($amount,$re_openid,$ordernum,$desc,$check_name=''){
        $total_amount = (100) * $amount;
        $data=array(
            'mch_appid'       =>$this->APPID,                   //商户账号appid
            'mchid'           =>$this->MCHID,                   //商户号
            'nonce_str'       =>$this->createNoncestr(),        //随机字符串
            'partner_trade_no'=> $ordernum,//商户订单号
            'openid'          => $re_openid,                    //用户openid
            'check_name'      =>'NO_CHECK',                     //校验用户姓名选项,
            're_user_name'    => $check_name,                   //收款用户姓名
            'amount'          =>$total_amount,                  //金额
            'desc'            => $desc,                         //企业付款描述信息
            'spbill_create_ip'=> $this->IP,                     //Ip地址
        );
        $secrect_key=$this->SECRECT_KEY;///这个就是个API密码。MD5 32位。
        $data=array_filter($data);
        ksort($data);
        $str='';
        foreach($data as $k=>$v) {
            $str.=$k.'='.$v.'&';
        }
        $str.='key='.$secrect_key;
        $data['sign']=md5($str);
        $xml=$this->arraytoxml($data);
        $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers'; //调用接口
        $res=$this->curl($xml,$url);
        $return=$this->xmltoarray($res);
        //$responseObj = simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
        //$res= $responseObj->return_code;  //SUCCESS  echo 如果返回来SUCCESS,则发生成功，处理自己的逻辑
        return $return;
    }
}