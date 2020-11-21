<?php

//decode by http://www.yunlu99.com/
include_once "SDKRuntimeException.php";
include_once "WxPay.pub.config.php";
class Common_util_pub
{
	function __construct()
	{
	}
	function trimString($value)
	{
		$ret = null;
		if (null != $value) {
			$ret = $value;
			if (strlen($ret) == 0) {
				$ret = null;
			}
		}
		return $ret;
	}
	public function createNoncestr($length = 32)
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$str = '';
		$i = 0;
		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			$i++;
		}
		return $str;
	}
	function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
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
	public function getSign($Obj, $shkey)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}
		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . "&key=" . $shkey;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}
	function arrayToXml($arr)
	{
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
	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA)), true);
		return $array_data;
	}
	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		if (stripos($url, "https://") !== FALSE) {
			curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		} else {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		}
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);
		if ($data) {
			curl_close($ch);
			return $data;
		} else {
			$error = curl_errno($ch);
			curl_close($ch);
			throw new SDKRuntimeException("curl出错，错误码:{$error}");
		}
	}
	function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, "PEM");
		curl_setopt($ch, CURLOPT_SSLCERT, WxPayConf_pub::SSLCERT_PATH);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, "PEM");
		curl_setopt($ch, CURLOPT_SSLKEY, WxPayConf_pub::SSLKEY_PATH);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);
		if ($data) {
			curl_close($ch);
			return $data;
		} else {
			$error = curl_errno($ch);
			echo "curl出错，错误码:{$error}" . "<br>";
			echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
			curl_close($ch);
			return false;
		}
	}
	function printErr($wording = '', $err = '')
	{
		print_r("<pre>");
		echo $wording . "</br>";
		var_dump($err);
		print_r("</pre>");
	}
}
class Wxpay_client_pub extends Common_util_pub
{
	var $parameters;
	public $response;
	public $result;
	var $url;
	var $curl_timeout;
	var $setting;
	function setParameter($parameter, $parameterValue)
	{
		$this->parameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
	}
	function createXml()
	{
		$this->parameters["appid"] = $this->setting["appid"];
		$this->parameters["mch_id"] = $this->setting["mchid"];
		$this->parameters["nonce_str"] = $this->createNoncestr();
		$this->parameters["sign"] = $this->getSign($this->parameters, $this->setting["shkey"]);
		return $this->arrayToXml($this->parameters);
	}
	function postXml()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}
	function postXmlSSL()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlSSLCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}
	function getResult()
	{
		$this->postXml();
		$this->result = $this->xmlToArray($this->response);
		return $this->result;
	}
}
class UnifiedOrder_pub extends Wxpay_client_pub
{
	function __construct($setting)
	{
		$this->url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
		$this->curl_timeout = WxPayConf_pub::CURL_TIMEOUT;
		$this->setting = $setting;
	}
	function createXml()
	{
		try {
			if ($this->parameters["out_trade_no"] == null) {
				throw new SDKRuntimeException("缺少统一支付接口必填参数out_trade_no！" . "<br>");
			} else {
				if ($this->parameters["body"] == null) {
					throw new SDKRuntimeException("缺少统一支付接口必填参数body！" . "<br>");
				} else {
					if ($this->parameters["total_fee"] == null) {
						throw new SDKRuntimeException("缺少统一支付接口必填参数total_fee！" . "<br>");
					} else {
						if ($this->parameters["notify_url"] == null) {
							throw new SDKRuntimeException("缺少统一支付接口必填参数notify_url！" . "<br>");
						} else {
							if ($this->parameters["trade_type"] == null) {
								throw new SDKRuntimeException("缺少统一支付接口必填参数trade_type！" . "<br>");
							} else {
								if ($this->parameters["trade_type"] == "JSAPI" && $this->parameters["openid"] == NULL) {
									throw new SDKRuntimeException("统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！" . "<br>");
								}
							}
						}
					}
				}
			}
			$this->parameters["appid"] = $this->setting["appid"];
			$this->parameters["mch_id"] = $this->setting["mchid"];
			$this->parameters["spbill_create_ip"] = $_SERVER["REMOTE_ADDR"];
			$this->parameters["nonce_str"] = $this->createNoncestr();
			$this->parameters["sign"] = $this->getSign($this->parameters, $this->setting["shkey"]);
			return $this->arrayToXml($this->parameters);
		} catch (SDKRuntimeException $e) {
			die($e->errorMessage());
		}
	}
	function getPrepayId()
	{
		$this->postXml();
		$this->result = $this->xmlToArray($this->response);
		$prepay_id = $this->result["prepay_id"];
		return $prepay_id;
	}
}
class OrderQuery_pub extends Wxpay_client_pub
{
	function __construct()
	{
		$this->url = "https://api.mch.weixin.qq.com/pay/orderquery";
		$this->curl_timeout = WxPayConf_pub::CURL_TIMEOUT;
	}
	function createXml()
	{
		try {
			if ($this->parameters["out_trade_no"] == null && $this->parameters["transaction_id"] == null) {
				throw new SDKRuntimeException("订单查询接口中，out_trade_no、transaction_id至少填一个！" . "<br>");
			}
			$this->parameters["appid"] = WxPayConf_pub::APPID;
			$this->parameters["mch_id"] = WxPayConf_pub::MCHID;
			$this->parameters["nonce_str"] = $this->createNoncestr();
			$this->parameters["sign"] = $this->getSign($this->parameters, '');
			return $this->arrayToXml($this->parameters);
		} catch (SDKRuntimeException $e) {
			die($e->errorMessage());
		}
	}
}
class Refund_pub extends Wxpay_client_pub
{
	function __construct()
	{
		$this->url = "https://api.mch.weixin.qq.com/secapi/pay/refund";
		$this->curl_timeout = WxPayConf_pub::CURL_TIMEOUT;
	}
	function createXml()
	{
		try {
			if ($this->parameters["out_trade_no"] == null && $this->parameters["transaction_id"] == null) {
				throw new SDKRuntimeException("退款申请接口中，out_trade_no、transaction_id至少填一个！" . "<br>");
			} else {
				if ($this->parameters["out_refund_no"] == null) {
					throw new SDKRuntimeException("退款申请接口中，缺少必填参数out_refund_no！" . "<br>");
				} else {
					if ($this->parameters["total_fee"] == null) {
						throw new SDKRuntimeException("退款申请接口中，缺少必填参数total_fee！" . "<br>");
					} else {
						if ($this->parameters["refund_fee"] == null) {
							throw new SDKRuntimeException("退款申请接口中，缺少必填参数refund_fee！" . "<br>");
						} else {
							if ($this->parameters["op_user_id"] == null) {
								throw new SDKRuntimeException("退款申请接口中，缺少必填参数op_user_id！" . "<br>");
							}
						}
					}
				}
			}
			$this->parameters["appid"] = $this->setting["appid"];
			$this->parameters["mch_id"] = $this->setting["mchid"];
			$this->parameters["nonce_str"] = $this->createNoncestr();
			$this->parameters["sign"] = $this->getSign($this->parameters, '');
			return $this->arrayToXml($this->parameters);
		} catch (SDKRuntimeException $e) {
			die($e->errorMessage());
		}
	}
	function getResult()
	{
		$this->postXmlSSL();
		$this->result = $this->xmlToArray($this->response);
		return $this->result;
	}
}
class RefundQuery_pub extends Wxpay_client_pub
{
	function __construct()
	{
		$this->url = "https://api.mch.weixin.qq.com/pay/refundquery";
		$this->curl_timeout = WxPayConf_pub::CURL_TIMEOUT;
	}
	function createXml()
	{
		try {
			if ($this->parameters["out_refund_no"] == null && $this->parameters["out_trade_no"] == null && $this->parameters["transaction_id"] == null && $this->parameters["refund_id "] == null) {
				throw new SDKRuntimeException("退款查询接口中，out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个！" . "<br>");
			}
			$this->parameters["appid"] = WxPayConf_pub::APPID;
			$this->parameters["mch_id"] = WxPayConf_pub::MCHID;
			$this->parameters["nonce_str"] = $this->createNoncestr();
			$this->parameters["sign"] = $this->getSign($this->parameters, '');
			return $this->arrayToXml($this->parameters);
		} catch (SDKRuntimeException $e) {
			die($e->errorMessage());
		}
	}
	function getResult()
	{
		$this->postXmlSSL();
		$this->result = $this->xmlToArray($this->response);
		return $this->result;
	}
}
class DownloadBill_pub extends Wxpay_client_pub
{
	function __construct()
	{
		$this->url = "https://api.mch.weixin.qq.com/pay/downloadbill";
		$this->curl_timeout = WxPayConf_pub::CURL_TIMEOUT;
	}
	function createXml()
	{
		try {
			if ($this->parameters["bill_date"] == null) {
				throw new SDKRuntimeException("对账单接口中，缺少必填参数bill_date！" . "<br>");
			}
			$this->parameters["appid"] = WxPayConf_pub::APPID;
			$this->parameters["mch_id"] = WxPayConf_pub::MCHID;
			$this->parameters["nonce_str"] = $this->createNoncestr();
			$this->parameters["sign"] = $this->getSign($this->parameters, '');
			return $this->arrayToXml($this->parameters);
		} catch (SDKRuntimeException $e) {
			die($e->errorMessage());
		}
	}
	function getResult()
	{
		$this->postXml();
		$this->result = $this->xmlToArray($this->result_xml);
		return $this->result;
	}
}
class ShortUrl_pub extends Wxpay_client_pub
{
	function __construct()
	{
		$this->url = "https://api.mch.weixin.qq.com/tools/shorturl";
		$this->curl_timeout = WxPayConf_pub::CURL_TIMEOUT;
	}
	function createXml()
	{
		try {
			if ($this->parameters["long_url"] == null) {
				throw new SDKRuntimeException("短链接转换接口中，缺少必填参数long_url！" . "<br>");
			}
			$this->parameters["appid"] = WxPayConf_pub::APPID;
			$this->parameters["mch_id"] = WxPayConf_pub::MCHID;
			$this->parameters["nonce_str"] = $this->createNoncestr();
			$this->parameters["sign"] = $this->getSign($this->parameters, '');
			return $this->arrayToXml($this->parameters);
		} catch (SDKRuntimeException $e) {
			die($e->errorMessage());
		}
	}
	function getShortUrl()
	{
		$this->postXml();
		$prepay_id = $this->result["short_url"];
		return $prepay_id;
	}
}
class Wxpay_server_pub extends Common_util_pub
{
	public $data;
	var $returnParameters;
	var $setting;
	function saveData($xml)
	{
		$this->data = $this->xmlToArray($xml);
	}
	function checkSign($shkey)
	{
		return true;
		$tmpData = $this->data;
		unset($tmpData["sign"]);
		$sign = $this->getSign($tmpData, $shkey);
		if ($this->data["sign"] == $sign) {
			return TRUE;
		}
		return FALSE;
	}
	function getData()
	{
		return $this->data;
	}
	function setReturnParameter($parameter, $parameterValue)
	{
		$this->returnParameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
	}
	function createXml()
	{
		return $this->arrayToXml($this->returnParameters);
	}
	function returnXml()
	{
		$returnXml = $this->createXml();
		return $returnXml;
	}
}
class Notify_pub extends Wxpay_server_pub
{
	function __construct()
	{
	}
}
class NativeCall_pub extends Wxpay_server_pub
{
	function createXml()
	{
		if ($this->returnParameters["return_code"] == "SUCCESS") {
			$this->returnParameters["appid"] = WxPayConf_pub::APPID;
			$this->returnParameters["mch_id"] = WxPayConf_pub::MCHID;
			$this->returnParameters["nonce_str"] = $this->createNoncestr();
			$this->returnParameters["sign"] = $this->getSign($this->returnParameters, '');
		}
		return $this->arrayToXml($this->returnParameters);
	}
	function getProductId()
	{
		$product_id = $this->data["product_id"];
		return $product_id;
	}
}
class NativeLink_pub extends Common_util_pub
{
	var $parameters;
	var $url;
	function __construct()
	{
	}
	function setParameter($parameter, $parameterValue)
	{
		$this->parameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
	}
	function createLink()
	{
		try {
			if ($this->parameters["product_id"] == null) {
				throw new SDKRuntimeException("缺少Native支付二维码链接必填参数product_id！" . "<br>");
			}
			$this->parameters["appid"] = WxPayConf_pub::APPID;
			$this->parameters["mch_id"] = WxPayConf_pub::MCHID;
			$time_stamp = time();
			$this->parameters["time_stamp"] = "{$time_stamp}";
			$this->parameters["nonce_str"] = $this->createNoncestr();
			$this->parameters["sign"] = $this->getSign($this->parameters, '');
			$bizString = $this->formatBizQueryParaMap($this->parameters, false);
			$this->url = "weixin://wxpay/bizpayurl?" . $bizString;
		} catch (SDKRuntimeException $e) {
			die($e->errorMessage());
		}
	}
	function getUrl()
	{
		$this->createLink();
		return $this->url;
	}
}
class JsApi_pub extends Common_util_pub
{
	var $code;
	var $openid;
	var $parameters;
	var $prepay_id;
	var $curl_timeout;
	var $setting;
	function __construct($setting)
	{
		$this->curl_timeout = WxPayConf_pub::CURL_TIMEOUT;
		$this->setting = $setting;
	}
	function createOauthUrlForCode($redirectUrl)
	{
		$urlObj["appid"] = $this->setting["appid"];
		$urlObj["redirect_uri"] = "{$redirectUrl}";
		$urlObj["response_type"] = "code";
		$urlObj["scope"] = "snsapi_base";
		$urlObj["state"] = "STATE" . "#wechat_redirect";
		$bizString = $this->formatBizQueryParaMap($urlObj, false);
		return "https://open.weixin.qq.com/connect/oauth2/authorize?" . $bizString;
	}
	function createOauthUrlForOpenid()
	{
		$urlObj["appid"] = $this->setting["appid"];
		$urlObj["secret"] = $this->setting["appsecret"];
		$urlObj["code"] = $this->code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = $this->formatBizQueryParaMap($urlObj, false);
		return "https://api.weixin.qq.com/sns/oauth2/access_token?" . $bizString;
	}
	function getOpenid()
	{
		$url = $this->createOauthUrlForOpenid();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$res = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($res, true);
		$this->openid = $data["openid"];
		return $this->openid;
	}
	public function setOpenId($openid)
	{
		$this->openid = $openid;
	}
	function setPrepayId($prepayId)
	{
		$this->prepay_id = $prepayId;
	}
	function setCode($code_)
	{
		$this->code = $code_;
	}
	public function getParameters()
	{
		$jsApiObj["appId"] = $this->setting["appid"];
		$timeStamp = time();
		$jsApiObj["timeStamp"] = "{$timeStamp}";
		$jsApiObj["nonceStr"] = $this->createNoncestr();
		$jsApiObj["package"] = "prepay_id={$this->prepay_id}";
		$jsApiObj["signType"] = "MD5";
		$jsApiObj["paySign"] = $this->getSign($jsApiObj, $this->setting["shkey"]);
		$this->parameters = json_encode($jsApiObj);
		return $this->parameters;
	}
	public function GetEditAddressParameters($access_token)
	{
		load()->func("logging");
		$data = array();
		$data["appid"] = $this->setting["appid"];
		$data["url"] = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		$time = time();
		$data["timestamp"] = "{$time}";
		$data["noncestr"] = "1234568";
		$data["accesstoken"] = $access_token;
		ksort($data);
		$params = $this->ToUrlParams($data);
		$addrSign = sha1($params);
		$afterData = array("addrSign" => $addrSign, "signType" => "sha1", "scope" => "jsapi_address", "appId" => $this->setting["appid"], "timeStamp" => $data["timestamp"], "nonceStr" => $data["noncestr"]);
		$parameters = json_encode($afterData);
		return $parameters;
	}
	private function ToUrlParams($urlObj)
	{
		$buff = '';
		foreach ($urlObj as $k => $v) {
			if ($k != "sign") {
				$buff .= $k . "=" . $v . "&";
			}
		}
		$buff = trim($buff, "&");
		return $buff;
	}
}