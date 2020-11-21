<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
	$condition = ' AND weid=:weid ';
	$params = array(':weid' => $_W['uniacid']);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$sql = "SELECT * FROM " . tablename('slwl_aicard_shop_express'). ' WHERE 1 '
		. $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

	$list = pdo_fetchall($sql, $params);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_shop_express')
		. ' WHERE 1 ' . $condition, $params);
	$pager = pagination($total, $pindex, $psize);


} else if ($operation == 'post') {
	$id = intval($_GPC['id']);

	if ($_W['ispost']) {
		$data = array(
			'weid' => $_W['uniacid'],
			'displayorder' => $_GPC['displayorder'],
			'express_name' => $_GPC['express_name'],
			'express_url' => $_GPC['express_url'],
			'express_area' => $_GPC['express_area'],
		);
		if (!empty($id)) {
			pdo_update('slwl_aicard_shop_express', $data, array('id' => $id));
		} else {
			$data['addtime'] = $_W['slwl']['datetime']['now'];
			pdo_insert('slwl_aicard_shop_express', $data);
			$id = pdo_insertid();
		}
		sl_ajax(0, '保存成功！');
	}
	$one = pdo_fetch("select * from " . tablename('slwl_aicard_shop_express')
		. " where id=:id and weid=:weid", array(":id" => $id, ":weid" => $_W['uniacid']));


} else if ($operation == 'delete') {
	$id = intval($_GPC['id']);
	$one = pdo_fetch("SELECT id  FROM " . tablename('slwl_aicard_shop_express')
		. " WHERE id = '{$id}' AND uniacid=" . $_W['uniacid'] . "");

	if (empty($one)) {
		sl_ajax(1, '抱歉，不存在或是已经被删除！');
	}
	pdo_delete('slwl_aicard_shop_express', array('id' => $id));
	sl_ajax(0, '删除成功！');


} else {
	message('请求方式不存在');
}

include $this->template('web/shop-express');

