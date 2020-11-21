<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
	$condition = ' and uniacid=:uniacid and printer_name=:printer_name';
	$params = array(':uniacid' => $_W['uniacid'], ':printer_name'=>'ylyun_printers');
	$set = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_shop_printers')
		. ' WHERE 1 ' . $condition . ' limit 1', $params);

	if (!(empty($set))) {
		$printers = json_decode($set['printer_value'], true);
	}


} else if ($operation == 'post') {
	$condition = ' and uniacid=:uniacid and printer_name=:printer_name';
	$params = array(':uniacid' => $_W['uniacid'], ':printer_name'=>'ylyun_printers');
	$set = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_shop_printers')
		. ' WHERE 1 ' . $condition . ' limit 1', $params);

	$options = $_GPC['options'];

	$data = array();
	$data['uniacid'] = $_W['uniacid'];
	$data['printer_name_cn'] = '易联云打印机';
	$data['printer_name'] = 'ylyun_printers';
	$data['printer_value'] = json_encode($options);
	$data['enabled'] = intval($_GPC['enabled']);

	if (!empty($set)) {
		pdo_update('slwl_aicard_shop_printers', $data, array('id' => $set['id']));
	} else {
		$data['addtime'] = date('Y-m-d H:i:s', time());
		pdo_insert('slwl_aicard_shop_printers', $data);
	}
	sl_ajax(0, '保存成功！');


} else {
	message('请求方式不存在');
}

include $this->template('web/shop/printer');

