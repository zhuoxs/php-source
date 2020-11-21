<?php 
defined('IN_IA') or exit('Access Denied');
$ops = array('display','post');
$op = in_array($op, $ops) ? $op : 'post';
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '发送消息 - '.$_W['wlsetting']['base']['name'] : '发送消息';

if ($op == 'post') {
	qrcard::check_qrcode($_GPC['ncnum'], $_GPC['salt']);
	$carmember = wl_mem_single(array('uniacid' => $_W['uniacid'],'ncnumber' => $_GPC['ncnum']));
	$typeid = intval($_GPC['typeid']);
	$radioValue = $_GPC['radioValue'];
	$sendmsg = $_GPC['sendmsg'];
	if(empty($typeid) || (empty($radioValue) && empty($sendmsg))){
		die(json_encode(array("result" => 2,'msg' => '缺少重要参数，请重试')));
	}
	
	//判断发送次数是否超过限制
	$sendtime = Util::getCache('notice', "c".$_W['mid'].$carmember['id']);
	if($sendtime >= time() - 30*60){
		die(json_encode(array("result" => 2,'msg' => '不要频繁发送提醒哦')));
	}
	
	//发送模板消息并记录
	wl_load()->model('notice');
	if($typeid == 1){
		$sendcontent = $radioValue;
	}else{
		$sendcontent = $sendmsg;
	}
	forcar_notice($carmember,$sendcontent);
	Util::setCache('notice', "c".$_W['mid'].$carmember['id'], time());
	die(json_encode(array("result" => 1)));
}
