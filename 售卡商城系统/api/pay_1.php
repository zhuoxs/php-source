<?php
header('Content-Type: text/html;charset=utf-8');
require '../Mao/common.php';

/* *
 * 功能：即时到账交易接口接入页
 * 
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 */
require_once("epay.config.php");
require_once("../lib/epay_submit.class.php");
$types=isset($_GET['type'])?daddslashes($_GET['type']):exit(sysmsg("错误的支付方式！<a href=\"/index.php\">返回</a>"));
$ddh=isset($_GET['ddh'])?daddslashes($_GET['ddh']):exit(sysmsg("订单号不存在.请返回重新发起支付！<a href=\"/index.php\">返回</a>"));

$shop = $DB->get_row("SELECT * FROM mao_dindan WHERE M_id='{$mao['id']}' and ddh='{$ddh}' limit 1");//查询订单

if(!$shop){
	sysmsg('订单号不存在.请返回重新发起支付！<a href="/index.php">返回</a>');
}elseif($shop['price'] == 0.00 || $shop['price'] <= 0.00 || $shop['price'] <= 0){
	sysmsg('这么想送钱?<a href="/index.php">返回</a>');
}elseif($shop['zt'] == 0 || $shop['zt'] == 2 || $shop['zt'] == 3){
	sysmsg('该订单号已完成交易！<a href="/index.php">返回</a>');
}

/**************************请求参数**************************/
        $notify_url = "http://{$_SERVER['HTTP_HOST']}/notify_url.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = "http://{$_SERVER['HTTP_HOST']}/return_url.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //商户订单号
        $out_trade_no = $shop['ddh'];
        //商户网站订单系统中唯一订单号，必填

		//支付方式
        $type = $types;
        //商品名称
        $name = $shop['name'];
		//付款金额
        $money = $shop['price'];
		//站点名称
        $sitename = '猫咪';
        //必填

        //订单描述


/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"pid" => trim($alipay_config['partner']),
		"type" => $type,
		"notify_url"	=> $notify_url,
		"return_url"	=> $return_url,
		"out_trade_no"	=> $out_trade_no,
		"name"	=> $name,
		"money"	=> $money,
		"sitename"	=> $sitename
);

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
?>
