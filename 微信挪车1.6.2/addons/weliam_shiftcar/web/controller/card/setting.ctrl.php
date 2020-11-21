<?php 
defined('IN_IA') or exit('Access Denied');
$ops = array('qrset');
$op = in_array($op, $ops) ? $op : 'qrset';
load()->func('tpl');
wl_load()->model('setting');

if ($op == 'qrset') {
	$settings = wlsetting_read('qrset');
	if (checksubmit('submit')) {
		$base = array(
			'gzstatus'=>intval($_GPC['gzstatus']),
			'gznc'=>intval($_GPC['gznc']),
			'digit'=>intval($_GPC['digit']),
			'storeshow'=>intval($_GPC['storeshow']),
			'integral'=>intval($_GPC['integral']),
			'mobileshow'=>intval($_GPC['mobileshow']),
			'movecarbg'=>$_GPC['movecarbg'],
			'bdtuwen'=>$_GPC['bdtuwen'],
			'nctuwen'=>$_GPC['nctuwen'],
			'gzlogo'=>$_GPC['gzlogo']
		);
		wlsetting_save($base, 'qrset');
		message('更新设置成功！', web_url('card/setting/qrset'));
	}
	include wl_template('card/qr-setting');
}
