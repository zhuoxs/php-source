<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('setting');
$custom_sign = safe_gpc_string($_GPC['custom_sign']);

$_W['uniacid'] = intval($_GPC['uniacid']);
if (empty($_W['uniacid'])) {
	$uniacid_arr = array(
		'name' => '短信验证码',
	);
} else {
	$uniacid_arr = pdo_fetch('SELECT * FROM ' . tablename('uni_account') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
	if(empty($uniacid_arr)) {
		exit('非法访问');
	}
}

$receiver = trim($_GPC['receiver']);
if(empty($receiver)){
	exit('请输入邮箱或手机号');
} elseif(preg_match(REGULAR_MOBILE, $receiver)){
	$receiver_type = 'mobile';
} elseif(preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $receiver)) {
	$receiver_type = 'email';
} else {
	exit('您输入的邮箱或手机号格式错误');
}

pdo_delete('uni_verifycode', array('createtime <' => TIMESTAMP - 1800));

$sql = 'SELECT * FROM ' . tablename('uni_verifycode') . ' WHERE `receiver`=:receiver AND `uniacid`=:uniacid';
$pars = array();
$pars[':receiver'] = $receiver;
$pars[':uniacid'] = $_W['uniacid'];
$row = pdo_fetch($sql, $pars);
$record = array();
$code = random(6, true);
if(!empty($row)) {
	if($row['total'] >= 5) {
		exit('您的操作过于频繁,请稍后再试');
	}
	$record['total'] = $row['total'] + 1;
	$record['verifycode'] = $code;
	$record['createtime'] = TIMESTAMP;
} else {
	$record['uniacid'] = $_W['uniacid'];
	$record['receiver'] = $receiver;
	$record['verifycode'] = $code;
	$record['total'] = 1;
	$record['createtime'] = TIMESTAMP;
}
if(!empty($row)) {
	pdo_update('uni_verifycode', $record, array('id' => $row['id']));
} else {
	pdo_insert('uni_verifycode', $record);
}

if($receiver_type == 'email') {
	load()->func('communication');
	$content = "您的邮箱验证码为: {$code} 您正在使用{$uniacid_arr['name']}相关功能, 需要你进行身份确认.";
	$result = ihttp_email($receiver, "{$uniacid_arr['name']}身份确认验证码", $content);
} else {
	load()->model('cloud');
	$r = cloud_prepare();
	if(is_error($r)) {
		exit($r['message']);
	}
	$setting = uni_setting($_W['uniacid'], 'notify');
	$content = "您的短信验证码为: {$code} 您正在使用{$uniacid_arr['name']}相关功能, 需要你进行身份确认. ".random(3);
	$result = cloud_sms_send($receiver, $content, array(), $custom_sign);
}

if(is_error($result)) {
	header('error: ' . urlencode($result['message']));
	exit($result['message']);
}
exit('success');