<?php
defined('IN_IA') or exit('Access Denied');
$ops = array('display','post');
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'display';
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '我的手机号 - '.$_W['wlsetting']['base']['name'] : '我的手机号';

if ($op == 'display') {
    include wl_template('member/tel');
}

if ($op == 'post') {
	$session = json_decode(base64_decode($_GPC['__auth_session']), true);
	if(is_array($session)) {
		if($session['mobile'] != $_GPC['mobile']){
			die(json_encode(array("result" => 2,'msg' => '手机号码不匹配')));
		}
		if($session['code'] != $_GPC['inputcode']){
			die(json_encode(array("result" => 2,'msg' => '验证码错误，请重试')));
		}
	}else{
		die(json_encode(array("result" => 2,'msg' => '验证码已过期，请重新发送')));	
	}
    $re = pdo_update('weliam_shiftcar_member', array('mobile' => trim($_GPC['mobile'])), array('id' => $_W['mid']));
    if ($re) {
        die(json_encode(array("result" => 1)));
    } else {
        die(json_encode(array("result" => 2,'msg' => '手机号码绑定失败')));
    }
}
