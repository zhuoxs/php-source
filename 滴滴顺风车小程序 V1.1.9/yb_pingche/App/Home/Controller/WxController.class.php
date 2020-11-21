<?php
namespace Home\Controller;

use Think\Controller;
use Ht\Controller\MemberController;

class WxController extends Controller {

    private $appid;
    private $appsecret;
    private $token ;
    public function __construct()
    {
        $mem=new MemberController();
        $mem->getConfig();
        $this->token = C("gzh_token");
    }

    public function index()
    {
			
        if(!isset($_GET["echostr"])){
		
           $this->responseMsg();
        }else{

            $this->valid();
        }
    }

    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    public function responseMsg()//执行接收器方法
    {
        $postStr = file_get_contents("php://input");
        
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            switch($RX_TYPE){
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
            }
            echo $result;
        }else{
            echo "";
            exit;
        }
    }
    private function receiveEvent($object){
        $content = "";
        switch ($object->Event){
            case "subscribe":
                $content = "欢迎关注";//这里是向关注者发送的提示信息

                $access_token = getAccessToken2();

                $openid = $object->FromUserName;

                $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid;

                $res= json_decode($this->https_request($url),true);
                //file_put_contents('kkk.txt',json_encode($res));
                
                $rs=M("gzh_member")->where("unionid='".$res["unionid"]."'")->find();
                if($rs){
                    M('gzh_member')->where(['unionid'=>$res['unionid']])->save(['openid'=>$res['openid']]);
                }else{
                    $add['openid'] = $res['openid'];
                    $add['addtime'] = date("Y-m-d H:i:s");
                    $add['nickname']=  $res['nickname'];
                    $add['unionid'] = $res['unionid'];
                    $add['headimgurl']  = $res['headimgurl'];
                    M('gzh_member')->data($add)->add();
                }

                break;
            case "unsubscribe":
                $content = "";
                break;
        }
        $result = $this->transmitText($object,$content);
        return $result;
    }
    private function transmitText($object,$content){
        $textTpl = "<xml> 
<ToUserName><![CDATA[%s]]></ToUserName> 
<FromUserName><![CDATA[%s]]></FromUserName> 
<CreateTime>%s</CreateTime> 
<MsgType><![CDATA[text]]></MsgType> 
<Content><![CDATA[%s]]></Content> 
<FuncFlag>0</FuncFlag> 
</xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = $this->token;
   
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    // 单文本回复
    private function singleText($fromUsername,$toUsername,$contentStr)
    {
        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";

        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), 'text', $contentStr);
        return $resultStr;
    }

    private function https_request($url,$data = null){
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
}

?>