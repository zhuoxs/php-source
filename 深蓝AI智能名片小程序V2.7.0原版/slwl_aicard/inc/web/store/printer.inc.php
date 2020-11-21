<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
	$condition = " AND uniacid=:uniacid AND printer_name=:printer_name ";
	$params = array(':uniacid' => $_W['uniacid'], ':printer_name'=>'ylyun_printers');
	$set = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_store_printers')
		. ' WHERE 1 ' . $condition . ' limit 1', $params);

	if ($set) {
		$printers = json_decode($set['printer_value'], true);
	}

} else if ($operation == 'post') {
	$condition = " AND uniacid=:uniacid AND printer_name=:printer_name ";
	$params = array(':uniacid' => $_W['uniacid'], ':printer_name'=>'ylyun_printers');
	$set = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_store_printers')
		. ' WHERE 1 ' . $condition . ' limit 1', $params);

	$options = $_GPC['options'];

	$data = array();
	$data['uniacid'] = $_W['uniacid'];
	$data['printer_name_cn'] = '易联云打印机';
	$data['printer_name'] = 'ylyun_printers';
	$data['printer_value'] = json_encode($options);
	$data['enabled'] = intval($_GPC['enabled']);

	if ($set) {
		pdo_update('slwl_aicard_store_printers', $data, array('id' => $set['id']));
	} else {
		$data['addtime'] = $_W['slwl']['datetime']['now'];
		pdo_insert('slwl_aicard_store_printers', $data);
	}
	sl_ajax(0, '保存成功！');


} else {
	message('请求方式不存在');
}

include $this->template('web/store/printer');

