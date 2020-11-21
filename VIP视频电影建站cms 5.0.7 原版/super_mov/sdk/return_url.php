<?php
function chkurl($url){
$handle = curl_init($url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);//设置超时时间
curl_exec($handle);
//检查是否404（网页找不到）
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
if($httpCode == 404) {
  return false;
}else{
    return true;
}
curl_close($handle);
}

function geturl($url) {
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data_string );
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        print curl_error($ch);
    }
    curl_close($ch);
    return $response;
}
$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https' : 'http';
$url = $http_type . '://' . $_SERVER['HTTP_HOST'].'/web/index.php?c=site&a=entry&op=partner&do=order&out_trade_no='.$_GET['out_trade_no'].'&m=super_mov';
$url = geturl($url); 
$url = json_decode($url,true);
$alipay_config['partner']		= $_GET['pid'];
$alipay_config['key']			= $url['key']; 
//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

//签名方式 不需修改
$alipay_config['sign_type']    = strtoupper('MD5');

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset']= strtolower('utf-8');

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport']    = $http_type;

//支付API地址
$alipay_config['apiurl']    = 'https://pay.blyzf.cn/';
require_once("lib/epay_notify.class.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号

	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号

	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];

	//支付方式
	$type = $_GET['type'];


    if($_GET['trade_status'] == 'TRADE_SUCCESS') {
		$url = $http_type . '://' . $_SERVER['HTTP_HOST'].'/app/index.php?i='.$url['uniacid'].'&c=entry&do=Blypay&op=return&type='.$type.'&tid='.$_GET['out_trade_no'].'&m=super_mov';
		header("Location: $url"); 
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }


	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
    echo "支付失败";
}
?>
        <title>BL云支付即时到账交易接口</title>
	</head>
    <body>
    </body>
</html>