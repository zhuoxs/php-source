<?php

/**
 * 阿里云短信接口
 * @author 上帝禁区<593894955@qq.com>
 * 示例
 *     $alisms = new \Common\Model\Alisms($accessKeyId,$accessKeySecret);
 *       $mobile = '18914695716';
 *       $code   = 'SMS_36225243';
 *       $paramString = '{"code":"344556"}';
 *       $re = $alisms->smsend($mobile,$code,$paramString);
 *       print_r($re);
 *
 */
 
class Alisms{
    public $config = array(
              'Format'  =>'json',       //返回值的类型，支持JSON与XML。默认为XML
              'Version' =>'2017-05-25', //API版本号，为日期形式：YYYY-MM-DD，本版本对应为2016-09-27
              'SignatureMethod' =>'HMAC-SHA1', //签名方式，目前支持HMAC-SHA1
              'SignatureVersion'=>'1.0',
            );
    private    $accessKeySecret;    
    private    $http = 'http://dysmsapi.aliyuncs.com';//https://sms.aliyuncs.com/';        //短信接口
    private    $dateTimeFormat = 'Y-m-d\TH:i:s\Z'; 
    
    public     $signName = '短信签名'; //管理控制台中配置的短信签名（状态必须是验证通过）
    public     $method = 'GET';
    /**
    *发送短信
    *@AccessKeyId      阿里云申请的 Access Key ID
    *@AccessKeySecret  阿里云申请的 Access Key Secret
    */
    function __construct($accessKeyId,$accessKeySecret){
         $this->config['AccessKeyId'] = $accessKeyId;
         $this->AccessKeySecret = $accessKeySecret;
    } 
    /**
    *发送短信
    *@mobile  目标手机号，多个手机号可以逗号分隔 
    *@code 短信模板的模板CODE
    *@ParamString  短信模板中的变量；,参数格式{“no”:”123456”}， 个人用户每个变量长度必须小于15个字符
    */
    public function smsend($mobile,$code,$ParamString){
        $apiParams = $this->config;
        $apiParams["Action"]         = 'SendSms';//'SingleSendSms';
        $apiParams['TemplateCode']     = $code;  //短信模板的模板CODE
        //$apiParams['RecNum']         = $mobile;   //目标手机号，多个手机号可以逗号分隔
        //$apiParams['ParamString']     = $ParamString;   //短信模板中的变量；,此参数传递{“no”:”123456”}， 个人用户每个变量长度必须小于15个字符
        $apiParams['SignName']         = $this->signName;   //管理控制台中配置的短信签名（状态必须是验证通过）
        date_default_timezone_set("GMT");
        $apiParams["Timestamp"] = date($this->dateTimeFormat);
        $apiParams["SignatureNonce"]   = md5(md5('wbh').rand(100000,999999).uniqid()); //唯一随机数

        $apiParams['RegionId'] = 'cn-hangzhou';
        $apiParams['PhoneNumbers'] = $mobile;
        $apiParams['TemplateParam'] = $ParamString;

        $apiParams["Signature"] = $this->computeSignature($apiParams, $this->AccessKeySecret);//签名

        $tag = '?'; 
        $requestUrl = $this->http;
        foreach ($apiParams as $apiParamKey => $apiParamValue){
            $requestUrl .= $tag."$apiParamKey=" . urlencode($apiParamValue);
            $tag = '&';
        }
        return $this->postSMS($requestUrl);
    }
    private function postSMS($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output,true);
/*
        $opts = array( 
            'http'=>array( 
                'method'=>$this->method, 
                'timeout'=>600, 
                'header'=>'Content-Type: application/x-www-form-urlencoded',
            ) 
        ); 
        $html = file_get_contents($url, false, stream_context_create($opts));     
        if($html){
            return json_decode($html,true);
        }else{
            return false;
        }*/
    }

    //生成取短信签名
    private function computeSignature($parameters, $accessKeySecret){
        ksort($parameters);
        $canonicalizedQueryString = '';
        foreach($parameters as $key => $value){
            $canonicalizedQueryString .= '&' . $this->percentEncode($key). '=' . $this->percentEncode($value);
        }    
        $stringToSign = $this->method.'&%2F&' . $this->percentencode(substr($canonicalizedQueryString, 1));
        $signature = $this->signString($stringToSign, $accessKeySecret."&");
        return $signature;
    }
    protected function percentEncode($str){
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }
    private function signString($source, $accessSecret){
        return    base64_encode(hash_hmac('sha1', $source, $accessSecret, true));
    }
}
?>