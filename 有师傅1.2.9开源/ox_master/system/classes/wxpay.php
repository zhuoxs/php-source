<?php
/**
 * 关于微信企业付款的说明
 * 1.微信企业付款要求必传证书，需要到https://pay.weixin.qq.com 账户中心->账户设置->API安全->下载证书，证书路径在第207行和210行修改
 * 2.错误码参照 ：https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=14_2
 */
//$mchid = '';          //微信支付商户号 PartnerID 通过微信支付商户资料审核后邮件发送
//$appid = '';  //微信支付申请对应的公众号的APPID
//$appKey = '';   //微信支付申请对应的公众号的APP Key
//$apiKey = '';   //https://pay.weixin.qq.com 帐户设置-安全设置-API安全-API密钥-设置API密钥
//填写证书所在位置，证书在https://pay.weixin.qq.com 账户中心->账户设置->API安全->下载证书，下载后将apiclient_cert.pem和apiclient_key.pem上传到服务器。
//$apiclient_cert = './apiclient_cert.pem';
//$apiclient_key ='./apiclient_key.pem';
class Wxpay
{
	protected $mchid;
	protected $appid;
	protected $apiKey;
	protected $apiclient_cert;
	protected $apiclient_key;
	public $data = null;
    /*
     * $mchid = '';          //微信支付商户号 PartnerID 通过微信支付商户资料审核后邮件发送
	 * $appid = '';          //微信支付申请对应的公众号的APPID
	 * $apiKey = '';
	 * $params->openid   or_t25Ha4nHeWuYE9g3I8OytP3Xg
	 * $params->payAmount //转账金额，单位:元。转账最小金额为1元
	 * $params->$outTradeNo 订单号
	 * $params->apiclient_cert
	 * $params->apiclient_key
	 * $params->money_desc
     */
	public function wx_date($mchid, $appid, $apiKey, $params)
	{
	    $this->mchid = $mchid;
	    $this->appid = $appid;
	    $this->apiKey = $apiKey;
	    if (!$params['openid']) exit('获取openid失败');
	    //②、付款
	    $result = $this->createJsBizPackage($params['openid'], $params['payAmount'],  $params['outTradeNo'], $params['apiclient_cert'], $params['apiclient_key'], $params['money_desc']);

	    return $result;
	}
	/**
	 * 企业付款
	 * @param string $openid 调用【网页授权获取用户信息】接口获取到用户在该公众号下的Openid
	 * @param float $totalFee 收款总费用 单位元
	 * @param string $outTradeNo 唯一的订单号
	 * @param string $orderName 订单名称
	 * @param string $notifyUrl 支付结果通知url 不要有问号
	 * @param string $timestamp 支付时间
	 * @return string
	 */
	public function createJsBizPackage($openid, $totalFee, $outTradeNo, $apiclient_cert, $apiclient_key, $money_desc)
	{
	    $result = array('code'=>0);
		$config = array(
			'mch_id' => $this->mchid,
			'appid' => $this->appid,
			'key' => $this->apiKey,
		);
		$unified = array(
			'mch_appid' => $config['appid'],
			'mchid' => $config['mch_id'],
			'nonce_str' => self::createNonceStr(),
			'openid' => $openid,
			'check_name' => 'NO_CHECK',        //校验用户姓名选项。NO_CHECK：不校验真实姓名，FORCE_CHECK：强校验真实姓名
			're_user_name' => '零象',                 //收款用户真实姓名（不支持给非实名用户打款）
			'partner_trade_no' => $outTradeNo,
			'spbill_create_ip' => '127.0.0.1',
			'amount' => intval($totalFee * 100),       //单位 转为分
			'desc' => $money_desc,            //企业付款操作说明信息
		);
		$unified['sign'] = self::getSign($unified, $config['key']);
		$responseXml = self::curl_post('https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers', self::arrayToXml($unified),array(),$apiclient_cert, $apiclient_key);
		if(!$responseXml)
		{
		    $result['msg'] = '请求失败！请确保配置正确';
		    return $result;
		}
		$unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
		if ($unifiedOrder === false) {
			die('parse xml error');
		}
		if ($unifiedOrder->return_code != 'SUCCESS') {
			//die($unifiedOrder->return_msg);
		    $result['msg'] = $unifiedOrder->err_code_des;
			return $result;
		}
		if ($unifiedOrder->result_code != 'SUCCESS') {
			$result['msg'] = $unifiedOrder->err_code_des;
			return $result;
		}
		$result['code'] = 1;
		return $result;
	}
	public function curl_post($url = '', $postData = '', $options = array(), $apiclient_cert, $apiclient_key)
	{
		if (is_array($postData)) {
			$postData = http_build_query($postData);
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
		if (!empty($options)) {
			curl_setopt_array($ch, $options);
		}
		//https请求 不验证证书和host
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		//第一种方法，cert 与 key 分别属于两个.pem文件
		//默认格式为PEM，可以注释
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, $apiclient_cert);
		//默认格式为PEM，可以注释
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, $apiclient_key);
		//第二种方式，两个文件合成一个.pem文件
//        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');
		$data = curl_exec($ch);
		if(curl_exec($ch) === false)
		{
			return 0;
		}
		curl_close($ch);
		return $data;
	}
	public static function createNonceStr($length = 16)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$str = '';
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}
	public static function arrayToXml($arr)
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
	return   $xml;
}
public static function getSign($params, $key)
{
	ksort($params, SORT_STRING);
	$unSignParaString = self::formatQueryParaMap($params, false);
	$signStr = strtoupper(md5($unSignParaString . "&key=" . $key));
	return $signStr;
}
protected  static function formatQueryParaMap($paraMap, $urlEncode = false)
{
	$buff = "";
	ksort($paraMap);
	foreach ($paraMap as $k => $v) {
		if (null != $v && "null" != $v) {
			if ($urlEncode) {
				$v = urlencode($v);
			}
			$buff .= $k . "=" . $v . "&";
		}
	}
	$reqPar = '';
	if (strlen($buff) > 0) {
		$reqPar = substr($buff, 0, strlen($buff) - 1);
	}
	return $reqPar;
}
}
?>
