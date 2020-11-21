<?php
header('Content-Type: text/html;charset=utf-8');
require '../Mao/common.php';
if($mao['yzf_type'] == 1){
	$id = $mao_zz['mzf_id'];
	$key = $mao_zz['mzf_key'];
}else{
	$id = $mao['mzf_id'];
	$key = $mao['mzf_key'];
}

$type = isset($_GET['type'])?daddslashes($_GET['type']):exit(sysmsg("错误的支付方式！<a href=\"/index.php\">返回</a>"));
$ddh = isset($_GET['ddh'])?daddslashes($_GET['ddh']):exit(sysmsg("订单号不存在.请返回重新发起支付！<a href=\"/index.php\">返回</a>"));
$shop = $DB->get_row("SELECT * FROM mao_dindan WHERE M_id='{$mao['id']}' and ddh='{$ddh}' limit 1");//查询订单
if($type < 1 || $type > 3){
	exit(sysmsg("错误的支付方式！<a href=\"/index.php\">返回</a>"));
}elseif($shop['price'] == 0.00 || $shop['price'] <= 0.00 || $shop['price'] <= 0){
	sysmsg('这么想送钱?<a href="/index.php">返回</a>');
}elseif($shop['zt'] == 0 || $shop['zt'] == 2 || $shop['zt'] == 3){
	sysmsg('该订单号已完成交易！<a href="/index.php">返回</a>');
}

$codepay_id = $id;//这里改成码支付ID
$codepay_key = $key; //这是您的通讯密钥

$data = array(
	"id" => $codepay_id,//你的码支付ID
	"pay_id" => $shop['ddh'], //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
	"type" => $type,//1支付宝支付 3微信支付 2QQ钱包
	"price" => $shop['price'],//金额100元
	"param" => $shop['name'],//自定义参数
	"notify_url"=>"http://{$_SERVER['HTTP_HOST']}/notify.php",//通知地址
	"return_url"=>"http://{$_SERVER['HTTP_HOST']}/return.php",//跳转地址
); //构造需要传递的参数

ksort($data); //重新排序$data数组
reset($data); //内部指针指向数组中的第一个元素

$sign = ''; //初始化需要签名的字符为空
$urls = ''; //初始化URL参数为空

foreach ($data AS $key => $val) { //遍历需要传递的参数
	if ($val == ''||$key == 'sign') continue; //跳过这些不参数签名
	if ($sign != '') { //后面追加&拼接URL
		$sign .= "&";
		$urls .= "&";
	}
	$sign .= "$key=$val"; //拼接为url参数形式
	$urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值

}
$query = $urls . '&sign=' . md5($sign .$codepay_key); //创建订单所需的参数
$url = "http://api2.fateqq.com:52888/creat_order/?{$query}"; //支付页面

header("Location:{$url}"); //跳转到支付页面
?>
