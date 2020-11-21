<?php
date_default_timezone_set('Asia/Shanghai');
header("Cache-Control: no-cache, must-revalidate");
header("Content-Type: text/html; charset=utf-8");
define('SYS_ROOT', dirname(dirname(dirname(__FILE__))).'/framework');
include(SYS_ROOT . '/runtime.php');
$setting = getSetting();
require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];
	$trade_no = $_GET['trade_no'];
	$trade_status = $_GET['trade_status'];
    if ($trade_status == 'WAIT_SELLER_SEND_GOODS') {
    	echo "<p></p>";
    	echo "<p style='margin-left:200px;margin-top:200px'>请完成确认收货操作<a href='https://lab.alipay.com/consume/queryTradeDetail.htm?tradeNo=".$trade_no."'>转到支付宝</a></p>";
    	die();
    } else if($_GET['trade_status'] == 'TRADE_FINISHED') {
    	$arr['gwid'] = trim($out_trade_no);
    	$moneyin = daocall('moneyin','getForArray',array($arr,'row'));
    	if (!$moneyin) {
    		die("数据异常,请联系管理员检查");
    	}
    	$id = $moneyin['id'];
    	if (apicall('money','payReturn',array($id,$moneyin['money']))) {
    		echo "支付成功";
			sleep(2);
			header("Location:/?c=money&a=moneyin");
			die();
    	}else {
    		echo "支付异常";
    	}
    }else {
      echo "trade_status=".$_GET['trade_status'];
    }
}
else {
    echo "验证失败";
}
?>
