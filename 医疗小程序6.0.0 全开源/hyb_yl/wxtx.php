<?php 
header('content-type:text/html;charset=utf-8');
class WeixinTx {
    protected $appid;
    protected $mch_id;
    protected $appkey;
    protected $openid;
    protected $amount;
    protected $desc;
    protected $re_user_name;

    function __construct($appid, $mch_id, $openid,$amount,$desc,$appkey,$re_user_name) {
        $this->appid = $appid;
        $this->openid = $openid;
        $this->mch_id = $mch_id;
        $this->key = $appkey;
        $this->desc = $desc;
        $this->amount = $amount;
        $this->re_user_name = $re_user_name;
       
    }
    public function Wxtx()
    {
        $return = $this->Wxtxpay();
        return $return;     
    }
    //统一下单接口
    private function Wxtxpay() {   
        $data['mch_appid']=$this->appid;//商户的应用appid
        $data['mchid']=$this->mch_id;//商户ID
        $data['nonce_str']=$this->createNoncestr();//这个据说是唯一的字符串下面有方法
        $data['partner_trade_no']=time().rand(10000, 99999);//.time();//这个是订单号。
        $data['openid']=$this->openid;//这个是授权用户的openid。。这个必须得是用户授权才能用
        $data['check_name']='NO_CHECK';//这个是设置是否检测用户真实姓名的
        $data['re_user_name']=$re_user_name;//用户的真实名字
        $data['amount']=$this->amount;//提现金额
        $data['desc']=$this->desc;//订单描述
        $data['spbill_create_ip']=$this->get_server_ip();//服务器的ip
        
        $secrect_key=$this->key;///这个就是个API密码。32位的。。随便MD5一下就可以了
        $data=array_filter($data);
        ksort($data);
        $str='';
        foreach($data as $k=>$v) {
          $str.=$k.'='.$v.'&';
        }
        $str.='key='.$secrect_key;
        $data['sign']=md5($str);
        $xml=$this->arraytoxml($data);
        $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $res=$this->curl($xml,$url);
        $return=$this->xmltoarray($res);
        return $return;

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

    private function arraytoxml($data){
          $str='<xml>';
          foreach($data as $k=>$v) {
            $str.='<'.$k.'>'.$v.'</'.$k.'>';
          }
          $str.='</xml>';
          return $str;
        }
    private function xmltoarray($xml) {
       //禁止引用外部xml实体
      libxml_disable_entity_loader(true);
      $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
      $val = json_decode(json_encode($xmlstring),true);
      return $val;
    }
      private  function curl($param="",$url) {
      $postUrl = $url;
      $curlPost = $param;
      $ch = curl_init();                   //初始化curl
      curl_setopt($ch, CURLOPT_URL,$postUrl);         //抓取指定网页
      curl_setopt($ch, CURLOPT_HEADER, 0);          //设置header
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);      //要求结果为字符串且输出到屏幕上
      curl_setopt($ch, CURLOPT_POST, 1);           //post提交方式
      curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);      // 增加 HTTP Header（头）里的字段
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // 终止从服务端进行验证
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($ch, CURLOPT_SSLCERT,getcwd().'/cert/apiclient_cert.pem'); //这个是证书的位置
      curl_setopt($ch, CURLOPT_SSLKEY,getcwd().'/cert/apiclient_key.pem'); //这个也是证书的位置
      $data = curl_exec($ch);                 //运行curl
      curl_close($ch);
      return $data;
    }
     /**
    * 获取服务器端IP地址
     * @return string
    */

   private function get_server_ip(){
      if(isset($_SERVER)){
        if($_SERVER['SERVER_ADDR']){
          $server_ip=$_SERVER['SERVER_ADDR'];
        }else{
          $server_ip=$_SERVER['LOCAL_ADDR'];
        }
      }else{
        $server_ip = getenv('SERVER_ADDR');
      }
      return $server_ip;
    }
}       
            
        
