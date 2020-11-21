<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if($op == 'display'){
	$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '用户中心 - '.$_W['wlsetting']['base']['name'] : '用户中心';
	include wl_template('user/usercenter');
}

if($op == 'qr'){
	$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '我的挪车卡 - '.$_W['wlsetting']['base']['name'] : '我的挪车卡';
	if($_W['wlmember']['ncnumber']){
		$qrcode = pdo_get('weliam_shiftcar_qrcode', array('cardsn' => $_W['wlmember']['ncnumber'],'uniacid'=> $_W['uniacid']), array('qrid','model','salt'));
		if($qrcode['model'] == 2){
			$ticket = pdo_getcolumn('qrcode', array('id' => $qrcode['qrid']), 'ticket');
			$showurl = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket);
		}else{
			$showurl = app_url('qr/qrcode/show',array('ncnumber' => $_W['wlmember']['ncnumber'],'salt' => $qrcode['salt']));
		}
	}
	include wl_template('user/carqrcode');
}