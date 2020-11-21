<?php 

 
class Alisms
{
	public     $accessKeyId ;	//= 'LTAIE66A1hjdjrqm'; //阿里控制台获取
	public     $accessKeySecret;//= 'V6YfIoXazKQ8YynT7wnd3SlTf6IKpH';//阿里控制台获取
	public     $signName;		//='聚汇盈'; //签名 就是发送短信的【】里的内容  后台需要先审核一下
	public     $TemplateCode;	//= 'SMS_140115563'; //模板编码 也是后台审核通过 有一个SMS_***的值
	
	public function __construct( $accessKeyId, $accessKeySecret, $signName, $TemplateCode )
	{
		$this->accessKeyId = $accessKeyId;
		$this->accessKeySecret = $accessKeySecret;
		$this->signName = $signName;
		$this->TemplateCode = $TemplateCode;
	}
	/**
	* 发送短信
	*/
	public function sendSms($mobile,$code) 
	{
		$params = array ();
		$accessKeyId = $this->accessKeyId;
		$accessKeySecret = $this->accessKeySecret;
		$params["PhoneNumbers"] = $mobile;
		$params["SignName"] = $this->signName;
		$params["TemplateCode"] = $this->TemplateCode;
		$params['TemplateParam'] = json_encode(Array(  // 短信模板中字段的值
            "code"=> $code,
        ));
		$content = $this->request(
			$accessKeyId,
			$accessKeySecret,
			"dysmsapi.aliyuncs.com",
			array_merge($params, array(
				"RegionId" => "cn-hangzhou",
				"Action" => "SendSms",
				"Version" => "2017-05-25",
			))
		);
 
		return $content;
	}
	
	public function request($accessKeyId, $accessKeySecret, $domain, $params, $security=false) {
        $apiParams = array_merge(array (
            "SignatureMethod" => "HMAC-SHA1",
            "SignatureNonce" => uniqid(mt_rand(0,0xffff), true),
            "SignatureVersion" => "1.0",
            "AccessKeyId" => $accessKeyId,
            "Timestamp" => gmdate("Y-m-d\TH:i:s\Z"),
            "Format" => "JSON",
        ), $params);
        ksort($apiParams);
        $sortedQueryStringTmp = "";
        foreach ($apiParams as $key => $value) {
            $sortedQueryStringTmp .= "&" . $this->encode($key) . "=" . $this->encode($value);
        }

        $stringToSign = "GET&%2F&" . $this->encode(substr($sortedQueryStringTmp, 1));

        $sign = base64_encode(hash_hmac("sha1", $stringToSign, $accessKeySecret . "&",true));

        $signature = $this->encode($sign);

        $url = ($security ? 'https' : 'http')."://{$domain}/?Signature={$signature}{$sortedQueryStringTmp}";

        try {
            $content = $this->fetchContent($url);
            return json_decode($content, true );
        } catch( Exception $e) {
            return false;
        }
    }

    private function encode($str)
    {
        $res = urlencode($str);
        $res = preg_replace("/\+/", "%20", $res);
        $res = preg_replace("/\*/", "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
    }

    private function fetchContent($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "x-sdk-client" => "php/2.0.0"
        ));

        if(substr($url, 0,5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $rtn = curl_exec($ch);

        if($rtn === false) {
            trigger_error("[CURL_" . curl_errno($ch) . "]: " . curl_error($ch), E_USER_ERROR);
        }
        curl_close($ch);

        return $rtn;
    }
}


?>