<?php
header ( 'Content-type: text/html; charset=utf-8' );
define ( 'APPLICATON_ROOT', dirname ( __FILE__ ) );
define ( 'SYS_ROOT',  dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/framework' );
define ( 'DEFAULT_CONTROL', 'index' );
include (SYS_ROOT . '/runtime.php');
session_start();
?>
<!doctype html>
<html class="no-js" lang="zh-CN">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>财付通支付返回</title>
<!--[if lt IE 7]>
<script>
window.location = '?c=public&a=toIe6';
</script>
<![endif]-->
<body>
<?php 
require_once ("./classes/ResponseHandler.class.php");
$setting = getSetting ();
$key = $setting['tenpay_key'];
$resHandler = new ResponseHandlerClass();
$resHandler->setKey($key);

//判断签名
if(!$resHandler->isTenpaySign()) {
	//通知id
	$notify_id = $resHandler->getParameter("notify_id");
	//商户订单号
	$out_trade_no = $resHandler->getParameter("out_trade_no");
	//财付通订单号
	$transaction_id = $resHandler->getParameter("transaction_id");
	//金额,以分为单位
	$total_fee = $resHandler->getParameter("total_fee");
	//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
	$discount = $resHandler->getParameter("discount");
	//支付结果
	$trade_state = $resHandler->getParameter("trade_state");
	//交易模式,1即时到账
	$trade_mode = $resHandler->getParameter("trade_mode");
	if("1" == $trade_mode ) {
		if( "0" == $trade_state){ 
			$option = explode ( '-', $out_trade_no );
			$id = intval($option [0]);
			$ret = apicall ( 'money', 'payReturn', array ($id,$total_fee/100,"财付通{$transaction_id}" ) );
			if ($ret) {
				echo "<div class='alert alert-success '><h3 style='margin-left:40%'>成功支付" . $_GET ['total_fee']/100 . "元</h3></div>";
			} else {
				echo "<div class='alert alert-error'><h3 style='margin-left:40%'>支付异常，请联系管理员对账</h3><div>";
			}
		} else {
			//当做不成功处理
			echo "<div class='alert alert-error'><h3 style='margin-left:40%'>即时到帐支付失败</h3></div>";
		}
	}else {
		echo "<div class='alert alert-error'><h3 style='margin-left:40%'>支付方式错误</h3></div>";
	}
	
} else {
	echo "<div class='alert alert-error'><h3 style='margin-left:40%'>支付错误:认证签名失败</h3></div>";
}
?>
</body>
</html>
