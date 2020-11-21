<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');

if ($_W['ispost']) {
	$options = $_GPC['options'];

	$data = array();
	$data['setting_value'] = json_encode($options, JSON_UNESCAPED_UNICODE); // 压缩

	if ($_W['slwl']['set']['site_settings']) {
		$where['uniacid'] = $_W['uniacid'];
		$where['setting_name'] = 'site_settings';
		pdo_update('slwl_aicard_settings', $data, $where);
	} else {
		$data['uniacid'] = $_W['uniacid'];
		$data['setting_name'] = 'site_settings';
		$data['addtime'] = $_W['slwl']['datetime']['now'];
		pdo_insert('slwl_aicard_settings', $data);
	}

	sl_ajax(0, '保存成功！');
}

if ($_W['slwl']['set']['site_settings']) {
	$settings = $_W['slwl']['set']['site_settings'];

	if (empty($settings['titledf1_show']) && ($settings['titledf1_show'] != '0')) {
		$settings['titledf1_show'] = '1';
	}
	if (empty($settings['titledf2_show']) && ($settings['titledf2_show'] != '0')) {
		$settings['titledf2_show'] = '1';
	}
}

include $this->template('web/basic/set');

