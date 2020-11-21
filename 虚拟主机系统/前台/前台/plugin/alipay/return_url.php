<?php 
date_default_timezone_set('Asia/Shanghai');
header("Cache-Control: no-cache, must-revalidate");
header("Content-Type: text/html; charset=utf-8");
define('SYS_ROOT', dirname(dirname(dirname(__FILE__))).'/framework');
include(SYS_ROOT . '/runtime.php');
$setting = getSetting();
require_once("class/alipay_notify.php");

//构造通知函数信息
$alipay = new alipay_notify(
				$setting['ALIPAY_PARTNER'],
				$setting['ALIPAY_KEY'],
				'MD5',
				'utf-8',
				strcasecmp($_SERVER['HTTPS'],"ON")==0?"https:":"http:");
//计算得出通知验证结果
$verify_result = $alipay->return_verify();

if($verify_result) {//验证成功
	$option = explode ( '-', $_GET['out_trade_no'] );
	$id = intval($option [0]);
	if (!apicall('money','payReturn',array($id,$_GET['total_fee']*100,'支付宝即时到账'.$_GET['trade_no']))) {
		echo "<h3>支付失败，请联系管理员对账</h3>";
	}else {
    	echo "<h3>成功支付".$_GET['total_fee']."元</h3>"; 	
	}
} else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的return_verify函数，比对sign和mysign的值是否相等，或者检查$veryfy_result有没有返回true
    echo "<h3>验证失败</h3>";
}
?>