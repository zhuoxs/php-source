<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>在线支付接口PHP版</title>

<link href="css/index.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="javascript:document.E_FORM.submit()">
<?php
//****************************************
	$v_mid = $setting['china_v_mid'];// 商户号，这里为测试商户号1001，替换为自己的商户号(老版商户号为4位或5位,新版为8位)即可
	$v_url = 'http://'.$_SERVER['HTTP_HOST'].'/plugin/chinabank/Receive.php';	// 请填写返回url,地址应为绝对路径,带有http协议
	$key   = $setting['china_key'];	 // 如果您还没有设置MD5密钥请登陆我们为您提供商户后台，地址：https://merchant3.chinabank.com.cn/
														// 登陆后在上面的导航栏里可能找到“B2C”，在二级导航栏里有“MD5密钥设置” 
														// 建议您设置一个16位以上的密钥或更高，密钥最多64位，但设置16位已经足够了
	//判断是否有传递订单号
	$v_oid = $v_oid ? $v_oid : date('Ymd',time())."-".$v_mid."-".date('His',time());//订单号，建议构成格式 年月日-商户号-小时分钟秒
	$v_amount = trim($_REQUEST['money']);                   //支付金额                 
    $v_moneytype = "CNY";                                            //币种

	$text = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;        //md5加密拼凑串,注意顺序不能变
	$v_md5info = strtoupper(md5($text));                             //md5函数加密并转化成大写字母

	 $remark1 = $id;					 //备注字段1
	 $remark2 = $id;                    //备注字段2
	$v_rcvname   = $setting['china_name'];		// 收货人
	$v_rcvaddr   = trim($_POST['v_rcvaddr'])  ;		// 收货地址
	$v_rcvtel    = $setting['china_tel'];		// 收货人电话
	$v_rcvpost   = trim($_POST['v_rcvpost'])  ;		// 收货人邮编
	$v_rcvemail  = $setting['china_email'];		// 收货人邮件
	$v_rcvmobile = trim($_POST['v_rcvmobile']);		// 收货人手机号

	$v_ordername   = trim($_POST['v_ordername'])  ;	// 订货人姓名
	$v_orderaddr   = trim($_POST['v_orderaddr'])  ;	// 订货人地址
	$v_ordertel    = trim($_POST['v_ordertel'])   ;	// 订货人电话
	$v_orderpost   = trim($_POST['v_orderpost'])  ;	// 订货人邮编
	$v_orderemail  = trim($_POST['v_orderemail']) ;	// 订货人邮件
	$v_ordermobile = trim($_POST['v_ordermobile']);	// 订货人手机号 

?>

<form method="post" name="E_FORM" action="https://Pay3.chinabank.com.cn/PayGate">
	<input type="hidden" name="v_mid"         value="<?php echo $v_mid;?>">
	<input type="hidden" name="v_oid"         value="<?php echo $v_oid;?>">
	<input type="hidden" name="v_amount"      value="<?php echo $v_amount;?>">
	<input type="hidden" name="v_moneytype"   value="<?php echo $v_moneytype;?>">
	<input type="hidden" name="v_url"         value="<?php echo $v_url;?>">
	<input type="hidden" name="v_md5info"     value="<?php echo $v_md5info;?>">
	<input type="hidden" name="remark1"       value="<?php echo $remark1;?>">
	<input type="hidden" name="remark2"       value="<?php echo $remark2;?>">
</form>

</body>
</html>
