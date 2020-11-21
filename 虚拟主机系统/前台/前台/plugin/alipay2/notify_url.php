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
$verify_result = $alipayNotify->verifyNotify();
/*
$logfile = sprintf("%s.log",$_POST['out_trade_no']);
$fp = fopen(dirname(__FILE__).'/'.$logfile, "a");
foreach ($_REQUEST as $key=>$val) {
	fwrite($fp, sprintf("%s=>%s\n",$key,$val));
}
*/

if($verify_result) {//验证成功
	//商户订单号	$out_trade_no = $_POST['out_trade_no'];
	//支付宝交易号	$trade_no = $_POST['trade_no'];
	//交易状态
	$trade_status = $_POST['trade_status'];
	if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
		//fwrite($fp,"status=WAIT_BUYER_PAY\n");
	//该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款
        echo "success";		//请不要修改或删除
    }
	else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
		//fwrite($fp,"status=WAIT_SELLER_SEND_GOODS\n");
	//该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
        echo "success";		//请不要修改或删除
    }
	else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
		//fwrite($fp,"status=WAIT_BUYER_CONFIRM_GOODS\n");
	//该判断表示卖家已经发了货，但买家还没有做确认收货的操作
        echo "success";		//请不要修改或删除
    }
	else if($_POST['trade_status'] == 'TRADE_FINISHED') {
		//fwrite($fp,"status=TRADE_FINISHED\n");
	//该判断表示买家已经确认收货，这笔交易完成
		$option = explode ( '-', $out_trade_no );
		$id = intval($option [0]);
		if (apicall('money','payReturn',array($id,intval($_REQUEST['total_fee']*100),'支付宝担保交易通知'.$trade_no))) {
			//fwrite($fp,"支付成功");
			die("success");
			
		}else {
			//fwrite($fp,"支付失败".$GLOBALS['last_error']);
        	die("fail");		//请不要修改或删除
        	
		}
    }
    else {
		//其他状态判断
        die("success");
    }
}
else {
    //验证失败
    echo "fail";
    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
//fclose($fp);
?>