<?php
defined('IN_IA') or exit('Access Denied');
wl_load()->model('address');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

session_start();
$goodsid = $_SESSION['goodsid'];
$tuan_id = $_GPC['tuan_id'];
$openid = $_W['openid'];
$pagetitle = !empty($config['tginfo']['sname']) ? '我的收货地址 - '.$config['tginfo']['sname'] : '我的收货地址';
if($goodsid){
	$bakurl = app_url('order/orderconfirm',array('tuan_id'=>$tuan_id));
//	wl_debug($bakurl);
}else{
	$bakurl = app_url('member/home');
}

if($op == 'display'){
	$address = address_get_list($openid);
	include wl_template('address/addmanage');
}

if($op == 'select'){
	$id = $_GPC['id'];
	address_set_by_id($id,$openid);
	header("location:".app_url('address/addmanage'));
}
