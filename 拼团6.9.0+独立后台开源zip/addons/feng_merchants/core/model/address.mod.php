<?php
	
/**
 * [weliam] Copyright (c) 2016/3/23 
 * 地址model
 */
defined('IN_IA') or exit('Access Denied');

function address_get_list($params = '') {
	global $_W;
	if(!empty($params)){
		$params = ' where '. $params;
	}else{
		return;
	}
	$sql = "SELECT * FROM " . tablename('tg_address') . " {$params} ";
	$orders = pdo_fetchall($sql);
	return $orders;
}

function address_get_by_params($params = '') {
	global $_W;
	if(!empty($params)){
		$params = ' where '. $params;
	}else{
		return;
	}	
	$sql = "SELECT * FROM " . tablename('tg_address') . " {$params} ";
	$order = pdo_fetch($sql);
	return $order;
}

function address_update_by_params($data,$params) {
	global $_W;
	$flag = pdo_update('tg_address',$data,$params);
	return $flag;
}

function address_insert($data) {
	global $_W;
	$flag = pdo_insert('tg_address',$data);
	if($flag){
		$insertid = pdo_insertid();
	}else{
		$insertid = FALSE;
	}
	return $insertid;
}

function address_delete($id) {
	global $_W;
	$flag = pdo_delete('tg_address',$id);
	return $flag;
}

function address_get_by_id($id = '') {
	global $_W;
	if(empty($id)){
		return;
	}
	$sql = "SELECT * FROM " . tablename('tg_address') . " where uniacid = '{$_W['uniacid']}' and id = {$id}";
	$order = pdo_fetch($sql);
	return $order;
}

function address_set_by_id($id = '',$openid) {
	global $_W;
	if(empty($id)){
		return;
	}
	$moren =  pdo_fetch("SELECT id FROM".tablename('tg_address')."where status = 1 and openid = '{$openid}'");
    $re = pdo_update('tg_address',array('status' => 0),array('id' => $moren['id']));
    $re = pdo_update('tg_address',array('status' => 1),array('id' => $id));
	return $re;
}

function shareAddress() {
	global $_W, $_GPC;
	$appid = $_W['account']['key'];
	$secret = $_W['account']['secret'];
	load() -> func('communication');
	$url = $_W['siteroot'] . "app/index.php?" . $_SERVER['QUERY_STRING'];
	if (empty($_GPC['code'])) {
		$oauth2_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
		header("location: $oauth2_url");
		exit();
	} 
	$code = $_GPC['code'];
	$token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
	$resp = ihttp_get($token_url);
	$token = @json_decode($resp['content'], true);
	if (empty($token) || !is_array($token) || empty($token['access_token']) || empty($token['openid'])) {
		return false;
	} 
	$package = array("appid" => $appid, "url" => $url, 'timestamp' => time() . "", 'noncestr' => random(8, true) . "", 'accesstoken' => $token['access_token']);
	ksort($package, SORT_STRING);
	$addrSigns = array();
	foreach ($package as $k => $v) {
		$addrSigns[] = "{$k}={$v}";
	} 
	$string = implode('&', $addrSigns);
	$addrSign = strtolower(sha1(trim($string)));
	$data = array("appId" => $appid, "scope" => "jsapi_address", "signType" => "sha1", "addrSign" => $addrSign, "timeStamp" => $package['timestamp'], "nonceStr" => $package['noncestr']);
	return $data;
} 