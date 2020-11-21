<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
	$condition = " AND uniacid=:uniacid ";
	$params = array(':uniacid' => $_W['uniacid']);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 1000;
	$sql = "SELECT * FROM " . tablename('slwl_aicard_store_category'). ' WHERE 1 '
		. $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;
	$list = pdo_fetchall($sql, $params);

} else if ($operation == 'post') {
	$parentid = intval($_GPC['parentid']);
	$id = intval($_GPC['id']);

	if ($parentid) {
		$parent = pdo_fetch("SELECT id, title FROM " . tablename('slwl_aicard_store_category') . " WHERE id = '$parentid'");
		if (empty($parent)) {
			sl_ajax(1, '抱歉，上级分类不存在或是已经被删除！');
		}
	}

	$condition = " AND uniacid=:uniacid AND id=:id ";
	$params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
	$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_store_category') . ' WHERE 1 ' . $condition, $params);

	if ($_W['ispost']) {
		if (empty($_GPC['title'])) {
			sl_ajax(1, '抱歉，请输入分类名称！');
		}
		$data = array(
			'title' => $_GPC['title'],
			'displayorder' => intval($_GPC['displayorder']),
			'isrecommand' => intval($_GPC['isrecommand']),
			'intro' => $_GPC['intro'],
			'thumb' => $_GPC['thumb'],
			'adthumb' => $_GPC['adthumb'],
			'enabled' => intval($_GPC['enabled']),
		);

		if ($id) {
			pdo_update('slwl_aicard_store_category', $data, array('id'=>$id));
		} else {
			$data['uniacid'] = $_W['uniacid'];
			$data['parentid'] = $parentid;
			$data['addtime'] = $_W['slwl']['datetime']['now'];
			pdo_insert('slwl_aicard_store_category', $data);
			$id = pdo_insertid();
		}
		sl_ajax(0, '保存成功！');
	}


} else if ($operation == 'delete') {
	$id = intval($_GPC['id']);

	$condition_child = " AND uniacid=:uniacid AND parentid=:id ";
	$params_child = array(':uniacid' => $_W['uniacid'], ':id' => $id);
	$one_child = pdo_fetch('SELECT id FROM ' . tablename('slwl_aicard_store_category') . ' WHERE 1 '
		. $condition_child, $params_child);

	if ($one_child) {
		sl_ajax(1, '标签下存在子标签不能删除！');
	}

	$rst = pdo_delete('slwl_aicard_store_category', array('id' => $id));
	if ($rst !== false) {
		sl_ajax(0, '成功');
	} else {
		sl_ajax(1, '不存在或已删除');
	}


} else {
	message('请求方式不存在');
}

include $this->template('web/store/category');

