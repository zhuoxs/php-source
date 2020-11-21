<?php
/**
 * 创建url
 *
 * @param funAndOperate
 *            请求的功能和操作
 * @return
*/
function createUrl($ACCOUNT_SID, $AUTH_TOKEN, $funAndOperate){
	// 时间戳
	date_default_timezone_set("Asia/Shanghai");
	$timestamp = date("YmdHis");
	// 签名
	$sig = md5($ACCOUNT_SID.$AUTH_TOKEN.$timestamp);
	return "https://voice.253.com/20141029/accounts/" . $ACCOUNT_SID . "/" . $funAndOperate . "sig=" . $sig . "&timestamp=" . $timestamp;
}

/**
 * 创建请求头
 * @param body
 * @return
 */
function createHeaders($body){
	$headers = array('Content-type: application/json', 'Accept: application/json', 'Content-Length: '.strlen($body));
	return $headers;
}

/**
 * post请求
 *
 * @param funAndOperate
 *            功能和操作
 * @param body
 *            要post的数据
 * @return
 * @throws IOException
 */
function callbackpost($funAndOperate,$ACCOUNT_SID, $AUTH_TOKEN, $body){
	// 构造请求数据
	$url = createUrl($ACCOUNT_SID,$AUTH_TOKEN,$funAndOperate);
	$headers = createHeaders($body);
	// 提交请求
	$con = curl_init();
	curl_setopt($con, CURLOPT_URL, $url);
	curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($con, CURLOPT_HEADER, 0);
	curl_setopt($con, CURLOPT_POST, 1);
	curl_setopt ($con, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($con, CURLOPT_POSTFIELDS, $body);
	$result = curl_exec($con);
	curl_close($con);

	return "".$result;
}
