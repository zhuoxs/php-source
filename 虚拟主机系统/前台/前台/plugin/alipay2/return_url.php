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
	if (!$out_trade_no) {
		die("商户订单号不能为空");
	}
	//支付宝交易号

	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];

    if ($trade_status == 'WAIT_SELLER_SEND_GOODS') {
    	require_once("lib/alipay_submit.class.php");
    	//支付宝交易号
    	$trade_no = $trade_no ? $trade_no : $_POST['WIDtrade_no'];
    	//必填
    	
    	//物流公司名称
    	$logistics_name = $_POST['WIDlogistics_name'] ? $_POST['WIDlogistics_name'] : '自动充值';
    	//必填
    	
    	//物流发货单号
    	$invoice_no = $_POST['WIDinvoice_no'] ? $_POST['WIDinvoice_no'] : $trade_no;
    	//物流运输类型
    	$transport_type = $_POST['WIDtransport_type'] ? $_POST['WIDtransport_type'] : 'POST';
    	//三个值可选：POST（平邮）、EXPRESS（快递）、EMS（EMS）
    	if (!$alipay_config['partner'] ) {
    		require_once("../alipay.config.php");
    	}
    	//构造要请求的参数数组，无需改动
    	$parameter = array(
    			"service" => "send_goods_confirm_by_platform",
    			"partner" => trim($alipay_config['partner']),
    			"trade_no"	=> $trade_no,
    			"logistics_name"	=> $logistics_name,
    			"invoice_no"	=> $invoice_no,
    			"transport_type"	=> $transport_type,
    			"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
    	);
    	//建立请求
    	$alipaySubmit = new AlipaySubmit($alipay_config);
    	$html_text = $alipaySubmit->buildRequestHttp($parameter);
    	//解析XML
    	//注意：该功能PHP5环境及以上支持，需开通curl、SSL等PHP配置环境。建议本地调试时使用PHP开发软件
    	$doc = new DOMDocument();
    	$doc->loadXML($html_text);
    	/*
    	if( ! empty($doc->getElementsByTagName( "alipay" )->item(0)->nodeValue) ) {
    		$alipay = $doc->getElementsByTagName( "alipay" )->item(0)->nodeValue;
    		echo $alipay;
    	}
    	*/
    	//include_once 'send/alipayapi.php';
    	echo "<p style='margin-top:100px;margin-left:200px'><h1>请<a href='https://www.alipay.com' target=_blank>登陆支付宝</a>确认收货完成支付</h1></p>";
    	die();
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
		
	echo "验证成功<br />";
	echo "trade_no=".$trade_no;

}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
    echo "验证失败";
}
?>
