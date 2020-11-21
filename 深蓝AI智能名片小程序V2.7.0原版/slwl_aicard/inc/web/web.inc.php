<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
	$sys_id = $_W['uniacid'];
	$account = uni_fetch($sys_id);
	$app_id = $account['key'];
	// $secret = $account['secret'];
	unset($account);

	// $rst = cache_updatecache();

	$ai_total_count = get_web_ai_total_count('all'); // 数据概览
	$ai_total_count_by_type = get_web_ai_total_count_by_type('client', '7'); // 数据指标

	if ($ai_total_count['errcode']=='0') {
		$ai_total_count = $ai_total_count['data'];
	} else {
		$ai_total_count = array();
	}

	if ($ai_total_count_by_type['errcode']=='0') {
		$ai_total_count_by_type = $ai_total_count_by_type['data'];
	} else {
		$ai_total_count_by_type = array();
	}

	$is_https = stripos($_W['siteroot'], 'https');
	if ($is_https) {
		$siteroot = $_W['siteroot'];
	} else {
		$siteroot = preg_replace('/http/', 'https', $_W['siteroot'], 1);
	}
	// echo $siteroot;


} else if ($operation == 'web_atc') {
	$type = $_GPC['type'];

	if (empty($type)) {
		sl_ajax(1, 'type参数为空');
	}

	$ai_total_count = get_web_ai_total_count($type);

	if ($ai_total_count['errcode']=='0') {
		sl_ajax(0, $ai_total_count['data']);
	} else {
		sl_ajax(1, $ai_total_count['errmsg'].'-'.$ai_total_count['data']);
	}


} else if ($operation == 'web_atc_by_type') {
	$type = $_GPC['type'];
	$day = $_GPC['day'];

	if (empty($type)) {
		sl_ajax(1, 'type参数为空');
	}

	if (empty($day)) {
		sl_ajax(1, 'day参数为空');
	}

	$ai_total_count_by_type = get_web_ai_total_count_by_type($type, $day);

	if ($ai_total_count_by_type['errcode']=='0') {
		sl_ajax(0, $ai_total_count_by_type['data']);
	} else {
		sl_ajax(1, $ai_total_count_by_type['errmsg'].'-'.$ai_total_count_by_type['data']);
	}


} else {
	message('请求方式不存在');
}

include $this->template('web/web');

