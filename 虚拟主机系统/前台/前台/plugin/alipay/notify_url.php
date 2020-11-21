<?php 
date_default_timezone_set('Asia/Shanghai');
header("Cache-Control: no-cache, must-revalidate");
header("Content-Type: text/html; charset=utf-8");
define('SYS_ROOT', dirname(dirname(dirname(__FILE__))).'/framework');
include(SYS_ROOT . '/runtime.php');
$setting = getSetting();
require_once("class/alipay_notify.php");
$alipay = new alipay_notify(
				$setting['ALIPAY_PARTNER'],
				$setting['ALIPAY_KEY'],
				'MD5',
				'utf-8',
				strcasecmp($_SERVER['HTTPS'],"ON")==0?"https:":"http:");
$verify_result = $alipay->notify_verify();  //计算得出通知验证结果

if($verify_result) {//验证成功
    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
    $dingdan           = $_POST['out_trade_no'];	//获取支付宝传递过来的订单号
    $total             = $_POST['total_fee'];		//获取支付宝传递过来的总价格
    apicall('money','payReturn',array($_GET['out_trade_no'],$_GET['total_fee']*100,'支付宝通知'));
    if($_POST['trade_status'] == 'TRADE_FINISHED' ||$_POST['trade_status'] == 'TRADE_SUCCESS') {    //交易成功结束
		//判断该笔订单是否在商户网站中已经做过处理（可参考“集成教程”中“3.4返回数据处理”）
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
        
		echo "success";		//请不要修改或删除

        //调试用，写文本函数记录程序运行情况是否正常
        //log_result("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
    else {
        echo "success";		//其他状态判断。普通即时到帐中，其他状态不用判断，直接打印success。

        //调试用，写文本函数记录程序运行情况是否正常
        //log_result ("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //log_result ("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>