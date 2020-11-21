<?php
require_once TG_CERT."WxPay.Exception.php";
require_once TG_CERT."WxPay.Data.php";

/**
 * 
 * 接口访问类，包含所有微信支付API列表的封装，类中方法为static方法，
 * 每个接口有默认超时时间（除提交被扫支付为10s，上报超时时间为1s外，其他均为6s）
 * @author widyhu
 *
 */
class WxPayApi
{
	/**
	 * 
	 * 查询订单，WxPayOrderQuery中out_trade_no、transaction_id至少填一个
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param WxPayOrderQuery $inputObj
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return 成功时返回，其他抛异常
	 */
	public static function orderQuery($inputObj, $timeOut = 6,$key)
	{
		$url = "https://api.mch.weixin.qq.com/pay/orderquery";
		//检测必填参数
		if(!$inputObj->IsOut_trade_noSet() && !$inputObj->IsTransaction_idSet()) {
			throw new WxPayException("订单查询接口中，out_trade_no、transaction_id至少填一个！");
		}
		
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		$inputObj->SetSign($key);//签名
		$xml = $inputObj->ToXml();
		
		$startTimeStamp = self::getMillisecond();//请求开始时间
		$response = self::postXmlCurl($xml, $url, false, $timeOut,'1','2');
		$result = WxPayResults::Init($response);
		return $result;
	}
	
/**
 * 
 *退款接口
 *
 */
	public static function refund($inputObj, $timeOut = 6,$f1,$f2,$key)

	{

		global $_W,$_GPC;

		$url = "https://api.mch.weixin.qq.com/secapi/pay/refund";

		//检测必填参数

		if(!$inputObj->IsOut_trade_noSet() && !$inputObj->IsTransaction_idSet()) {

			throw new WxPayException("退款申请接口中，out_trade_no、transaction_id至少填一个！");

			

		}else if(!$inputObj->IsOut_refund_noSet()){

			throw new WxPayException("退款申请接口中，缺少必填参数out_refund_no！");

		}else if(!$inputObj->IsTotal_feeSet()){

			throw new WxPayException("退款申请接口中，缺少必填参数total_fee！");

		}else if(!$inputObj->IsRefund_feeSet()){

			throw new WxPayException("退款申请接口中，缺少必填参数refund_fee！");

		}else if(!$inputObj->IsOp_user_idSet()){

			throw new WxPayException("退款申请接口中，缺少必填参数op_user_id！");

		}

		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串

		$inputObj->SetSign($key);//签名

		$xml = $inputObj->ToXml();

		$startTimeStamp = self::getMillisecond();//请求开始时间

		$response = self::postXmlCurl($xml, $url, true, $timeOut,$f1,$f2);

		$result = WxPayResults::Init($response);

		return $result;

	}

	/**
	 * 
	 * 产生随机字符串，不长于32位
	 * @param int $length
	 * @return 产生的随机字符串
	 */
	public static function getNonceStr($length = 32) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {  
			$str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
		} 
		return $str;
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

	private static function postXmlCurl($xml, $url, $useCert, $second = 30,$f1,$f2)
	{

		
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		
//		//如果有配置代理这里就设置代理
//		if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0" 
//			&& WxPayConfig::CURL_PROXY_PORT != 0){
//			curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
//			curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
//		}
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//严格校验
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	
		if($useCert == true){
			//设置证书
			//使用证书：cert 与 key 分别属于两个.pem文件
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLCERT, $f1);
			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLKEY, $f2);
		}
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//运行curl
		$data = curl_exec($ch);
		//返回结果
		if($data){
			curl_close($ch);
			return $data;
		} else {
			$error = curl_errno($ch);
			curl_close($ch);
			message("退款失败，CURL出错，错误码：".$error);exit;
			
//			throw new WxPayException("curl出错，错误码:$error");
		}
	}
	
	/**
	 * 获取毫秒级别的时间戳
	 */
	private static function getMillisecond()
	{
		//获取毫秒的时间戳
		$time = explode ( " ", microtime () );
		$time = $time[1] . ($time[0] * 1000);
		$time2 = explode( ".", $time );
		$time = $time2[0];
		return $time;
	}
}

