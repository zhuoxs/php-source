<?php

//----------------------------
//www.efwww.com
//----------------------------
//----------------------------


class wxpay
{

    private $appid='';
    private $mc_id='';
    private $wx_key='';
    private $result_paydata='';
    private  $prepay_id='';
    private $total_fee='';
    private $pay_attach='';

    private $out_trade_no='';
    function __construct($appid1,$mc_id1,$wx_key1,$total_fee,$pay_attach,$ordersn)
    {
        $this->appid =$appid1 ;//开放平台appid-------------------------------------------------------------------必填
        $this->mc_id = $mc_id1 ;     //商户平台商户id---------------------------------------------------------------必填
        $this->wx_key=$wx_key1;   //商户平台支付秘钥key
        $this->total_fee=$total_fee;
        $this->pay_attach=$pay_attach;
        $this->out_trade_no=$ordersn;
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $postdata =$this-> mkPostData($this->appid,  $this->mc_id,$this->total_fee);
        $data =$this-> posturl($url,$postdata);
        $this->prepay_id = $this-> getPrepayId($data);
        $this->result_paydata= $paydata = $this-> mkPayData($this->prepay_id,$this->appid,$this->mc_id);
		
//       echo $postdata;
        // return $this->result;
    }

    //设置只能用来读取类里的变量，不能修改
    public function  __get($property_name)
    {
        if(isset($this->$property_name))
        {
            return $this->$property_name;
        }
        else
        {
            return NULL;
        }
    }


    function mkPostData($appid,$mc_id,$fee){
        $postarray=array(
            "appid"=>$appid,
            "body"=> $this->pay_attach,
            "mch_id"=>$mc_id,
            "nonce_str"=>md5(time()),
            "notify_url"=>"http://rengx.wezhicms.com/addons/ewei_shopv2/payment/wechat/notify2.php",  //自已的网址  修改
            "out_trade_no"=>$this->out_trade_no,//'bsl_'.time(),
            "spbill_create_ip"=>$_SERVER['REMOTE_ADDR'],
            "total_fee"=>$fee,
            "trade_type"=>"APP"
        );
      	
        $sign =$this-> mkSign($postarray,$this->wx_key);
        $postarray['sign'] = $sign;
      	
      
        $postdata = '<xml>';
        foreach($postarray as $p => $v){
            $postdata .= '<'.$p.'>'.$v.'</'.$p.'>';
        }
        $postdata .= '</xml>';
        //$postdata = iconv('UTF-8','ISO8859-1',$postdata);
        return $postdata;
    }
    function getPrepayId($data){
        $ob = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
        $prepayid = (array)$ob->prepay_id;
        return $prepayid[0];
    }
    function mkPayData($prepay_id,$appid,$mc_id){
        $data = array(
            "appid"=>$appid,
            "noncestr"=>md5(time()),
            "package"=>"Sign=WXPay",
            "partnerid"=>$mc_id,
            "prepayid"=>$prepay_id,
            "timestamp"=>time(),
        );
        $data['sign'] =$this-> mkSign($data,$this->wx_key);
        return json_encode($data);
    }
    function mkSign($postarray,$wx_key){
        //$wx_key = 'pHrHeeoxqG27tUf5Fgbl1pZjyHAcAuzt';   //商户平台支付秘钥key------------------------------------------------------------------必填
        $poststr = '';
      
      	foreach($postarray as $k => $v)
	    {
	        $poststr .= $k."=".$v."&";
	    }

	    $poststr .= 'key=' . $wx_key;
	    $poststr = rtrim($poststr, '&');
      	/*
        foreach($postarray as $p => $v){
            $poststr .= '&'.$p.'='.$v;
        }
        $poststr .= '&key='.$wx_key;
        */
      	return strtoupper(md5($poststr));
      	
        return strtoupper(md5(substr($poststr,1)));
    }

//    function sendData($url,$data){
//        $ch = curl_init();//初始化curl
//        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
//        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
//        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_error($ch);
//        $data = curl_exec($ch);//运行curl
//        // curl_close($ch);
//        return $data;
//    }

    function posturl($url,$data){
        // $data  = json_encode($data);
        // $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        // return json_decode($output，true);
        return $output;
    }
}
