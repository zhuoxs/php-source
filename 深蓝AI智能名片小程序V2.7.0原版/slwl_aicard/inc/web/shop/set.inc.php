<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');

$condition = ' and uniacid=:uniacid and setting_name=:setting_name';
$params = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'set_shop_site_settings');
$set = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition . ' limit 1', $params);

if ($_W['ispost']) {
	$options = $_GPC['options'];

	$data = array();
	$data['uniacid'] = $_W['uniacid'];
	$data['setting_name'] = 'set_shop_site_settings';
	$data['setting_value'] = json_encode($options);

	if (!empty($set)) {
		pdo_update('slwl_aicard_settings', $data, array('id' => $set['id']));
	} else {
		$data['addtime'] = date('Y-m-d H:i:s', time());
		pdo_insert('slwl_aicard_settings', $data);
	}
	sl_ajax(0, '保存成功！');
}

if (!(empty($set))) {
	$settings = json_decode($set['setting_value'], true);
}

include $this->template('web/shop-set');

