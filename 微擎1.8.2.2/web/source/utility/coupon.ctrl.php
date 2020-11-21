<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
error_reporting(0);
global $_W;
load()->func('file');
load()->model('activity');
activity_coupon_type_init();
if (!in_array($do, array('local', 'wechat'))) {
	exit('Access Denied');
}

if ($do == 'wechat') {
	$condition = ' WHERE uniacid = :uniacid AND is_display = 1 AND status = 3 AND source = :source AND quantity > 0';
	$param = array(
		':uniacid' => $_W['uniacid'],
		':source' => COUPON_TYPE,
	);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '. tablename('coupon') . $condition, $param);
	$data = pdo_fetchall('SELECT * FROM ' . tablename('coupon') . $condition . ' ORDER BY id DESC LIMIT ' . ($pindex - 1) * $psize . ', ' . $psize, $param, 'id');
	if(!empty($data)) {
		foreach($data as $key => &$da) {
			$da['date_info'] = iunserializer($da['date_info']);
			$da['media_id'] = $da['card_id'];
			$da['logo_url'] = url('utility/wxcode/image', array('attach' => $da['logo_url']));
			$da['ctype'] = $da['type'];
			$da['extra'] = iunserializer($da['extra']);
			if ($da['type'] == '1') {
				$da['extra']['discount'] = $da['extra']['discount'] * 0.1;
			} elseif ($da['type'] == '2') {
				$da['extra']['reduce_cost'] = $da['extra']['reduce_cost'] * 0.01;
			}
			if ($da['date_info']['time_type'] == '1') {
				$starttime = strtotime(str_replace('.', '-', $da['date_info']['time_limit_start']));		
				$endtime = strtotime(str_replace('.', '-', $da['date_info']['time_limit_end']));
				if ($starttime > strtotime(date('Y-m-d')) || $endtime < strtotime(date('Y-m-d'))) {
					unset($data[$key]);
				}
			}
		}
	}
	message(array('page'=> pagination($total, $pindex, $psize, '', array('before' => '2', 'after' => '2', 'ajaxcallback'=>'null')), 'items' => $data), '', 'ajax');
}


