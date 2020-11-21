<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = $_GPC['op'] ? $_GPC['op'] : 'display';

if ($operation == 'display') {
	$condition = " AND uniacid=:uniacid ";
	$params = array(':uniacid' => $_W['uniacid']);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$sql = "SELECT * FROM " . tablename('slwl_aicard_dept'). ' WHERE 1 '
		. $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

	$list = pdo_fetchall($sql, $params);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_dept') . ' WHERE 1 ' . $condition, $params);
	$pager = pagination($total, $pindex, $psize);


} else if ($operation == 'post') {
	$id = intval($_GPC['id']);
	$tid = max(0, intval($_GPC['tid']));

	if ($_W['ispost']) {
		$data = array(
			'uniacid' => $_W['uniacid'],
			'displayorder' => $_GPC['displayorder'],
			'parentid' => $tid,
			'name' => $_GPC['name'],
			'enabled' => intval($_GPC['enabled']),
			'case' => intval($_GPC['case']),
			'isrecommand' => intval($_GPC['isrecommand']),
			'thumb' => $_GPC['thumb']
		);
		if ($id) {
			pdo_update('slwl_aicard_dept', $data, array('id' => $id));
		} else {
			$data['addtime'] = $_W['slwl']['datetime']['now'];
			pdo_insert('slwl_aicard_dept', $data);
			$id = pdo_insertid();
		}
		sl_ajax(0, '保存成功');
	}

	if ($id) {
		$condition = " AND uniacid=:uniacid AND id=:id ";
		$params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
		$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_dept') . ' WHERE 1 ' . $condition, $params);
	}


} else if ($operation == 'delete') {
	$id = intval($_GPC['id']);

	$condition_child = " AND uniacid=:uniacid AND parentid=:id ";
	$params_child = array(':uniacid' => $_W['uniacid'], ':id' => $id);
	$one_child = pdo_fetch('SELECT id FROM ' . tablename('slwl_aicard_dept') . ' WHERE 1 ' . $condition, $params);
	if ($one_child) {
		sl_ajax(1, '标签下存在子标签不能删除！');
	}

	$rst = pdo_delete('slwl_aicard_dept', array('id' => $id));
	if ($rst !== false) {
		sl_ajax(0, '成功');
	} else {
		sl_ajax(1, '不存在或已删除');
	}


} else {
	message('请求方式不存在');
}

include $this->template('web/card-dept');

