<?php
require '../../../framework/bootstrap.inc.php';
load()->web('common');
load()->classs('coupon');
$xml = file_get_contents('php://input');
$obj = isimplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
$data = json_decode(json_encode($obj), true); 
//增加报文记录
$baowen=array(); 
$baowen['xml']=$xml;
$baowen['out_trade_no']=$data['out_trade_no'];
$baowen['transaction_id']=$data['transaction_id'];
$baowen['add_time']=time();
pdo_insert('yzqzk_sun_baowen',$baowen);  
//签名验证
$get=$data;
$string1 = '';
ksort($get);
foreach($get as $k => $v) {
	if($v != '' && $k != 'sign') {
		$string1 .= "{$k}={$v}&";
	}
}
$wxkey=pdo_getcolumn('yzqzk_sun_system',array('uniacid' =>intval($get['attach'])), 'wxkey',1);
$sign = strtoupper(md5($string1 . "key=$wxkey"));
if($sign==$get['sign']){
    //验证成功进行回调操作
    $_W['uniacid'] = $_W['weid'] = intval($data['attach']);
	$_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
	$_W['acid'] = $_W['uniaccount']['acid'];
    $site = WeUtility::createModuleWxapp('yzqzk_sun'); 
    $method = 'payResult';
    $site->$method($data); 
    echo 1; 
}
exit; 














