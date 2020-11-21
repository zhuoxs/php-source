<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('activity');
load()->classs('coupon');

define('FRAME', 'mc');
$frames = buildframes(array('mc'));
$frames = $frames['mc'];
if($controller == 'activity') {
	if($action == 'coupon') {
		define('ACTIVE_FRAME_URL', url('activity/coupon/display'));
	}
	if($action  == 'exchange') {
		if ($_GPC['type'] == 'coupon' &&  $_GPC['a'] == 'exchange') {
			define('ACTIVE_FRAME_URL', url('activity/exchange/display', array('type' => 'coupon')));
		}
		if ($_GPC['type'] == 'goods' && $_GPC['a'] == 'exchange') {
			define('ACTIVE_FRAME_URL', url('activity/exchange/display', array('type' => 'goods')));
		}
	}
}

$coupon_api = new coupon();
activity_coupon_type_init();
