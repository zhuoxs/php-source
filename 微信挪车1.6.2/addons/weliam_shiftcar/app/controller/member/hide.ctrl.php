<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '躲罚单 - '.$_W['wlsetting']['base']['name'] : '躲罚单';

if ($op == 'display') {
	include wl_template('member/hide');
}

if ($op == 'post') {
	if ($_W['mid']) {
		if (empty($_W['wlmember']['hidestatus'])) {
			$status = 1;
		} else {
			$status = 0;
		}
		$re = pdo_update('weliam_shiftcar_member', array('hidestatus'=>$status,'hidetime'=>TIMESTAMP,'hidelng'=>$_GPC['longitude'],'hidelat'=>$_GPC['latitude']), array('id' => $_W['mid']));
		if ($re) {
			die(json_encode(array("result" => 1)));
		} else {
			die(json_encode(array("result" => 2)));
		}
	} else {
		die(json_encode(array("result" => 2)));
	}
}

if ($op == 'send') {
	load()->func('communication');
	$longitude = $_GPC['longitude'];
	$latitude = $_GPC['latitude'];
	$nowlocation = $_GPC['nowlocation'];
	$record = pdo_getcolumn('weliam_shiftcar_hidenotice', array('mid'=>$_W['mid'],'uniacid'=>$_W['uniacid'],'createtime >'=>TIMESTAMP - 30*60),'id');	
	if($record){
		die(json_encode(array("result" => 2, "msg" => '您已发送提醒，请不要重复发送哦')));
	}

	$info = pdo_fetchall('select * from '.tablename('weliam_shiftcar_member').' where uniacid=:uniacid and hidestatus=:hidestatus', array(':uniacid' => $_W['uniacid'], ':hidestatus' => 1));
	
	$limit = !empty($_W['wlsetting']['hide']['limit']) ? $_W['wlsetting']['hide']['limit'] : 5000;
	$i = 0;
	$openids = array();
	foreach ($info as $key => $value) {
		$m = Util::getdistance($value['hidelng'], $value['hidelat'], $longitude, $latitude);
		if ($m <= intval($limit)) {
			$openids[$i] = $value['id'];
			$i++;
		}
	}
	if(empty($i)){
		die(json_encode(array("result" => 2, "msg" => '感谢您的提醒，附近暂时没有车主')));
	}
	$o = serialize($openids);
	$data = array('uniacid'=>$_W['uniacid'],'mid'=>$_W['mid'],'touser'=>$o,'num'=>$i,'createtime'=>TIMESTAMP,'address'=>$nowlocation);
	pdo_insert('weliam_shiftcar_hidenotice', $data);
	$hideid = pdo_insertid();
	pdo_insert('weliam_shiftcar_waitmessage', array('uniacid'=>$_W['uniacid'],'type'=>3,'str'=>$hideid));
	die(json_encode(array("result" => 1, "num" => $i)));
}
