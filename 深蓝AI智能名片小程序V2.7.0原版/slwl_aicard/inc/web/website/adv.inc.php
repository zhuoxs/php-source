<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {


} else if ($operation == 'display_table') {
	$keyword = $_GPC['keyword'];

	$condition = " AND uniacid=:uniacid ";
	$params = array(':uniacid' => $_W['uniacid']);
	$pindex = max(1, intval($_GPC['page']));
	$psize = max(10, intval($_GPC['limit']));
	if ($keyword != '') {
		$condition .= ' AND (advname LIKE :advname) ';
		$params[':advname'] = '%'.$keyword.'%';
	}

	$sql = "SELECT * FROM " . tablename('slwl_aicard_website_adv'). ' WHERE 1 '
		. $condition . " ORDER BY displayorder DESC, id DESC LIMIT "
		. ($pindex - 1) * $psize .',' .$psize;

	$list = pdo_fetchall($sql, $params);

	if ($list) {
		foreach ($list as $k => $v) {
			$list[$k]['thumb_url'] = tomedia($v['thumb']);
			$list[$k]['enabled_format'] = $v['enabled'] ? '启用':'禁用';
		}
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_website_adv')
			. ' WHERE 1 ' . $condition, $params);
		// $pager = pagination($total, $pindex, $psize);
	}
	$data_return = [
		'code'  => 0,
		'msg'   => '',
		'count' => $total,
		'data'  => $list,
	];
	echo json_encode($data_return);
	exit;


} else if ($operation == 'post') {
	$id = intval($_GPC['id']);

	if ($_W['ispost']) {
		$data = array(
			'uniacid' => $_W['uniacid'],
			'displayorder' => $_GPC['displayorder'],
			'advname' => $_GPC['advname'],
			'enabled' => intval($_GPC['enabled']),
			'page_url' => $_GPC['page_url'],
			'thumb' => $_GPC['thumb'],
		);
		if ($id) {
			pdo_update('slwl_aicard_website_adv', $data, array('id' => $id));
		} else {
			$data['addtime'] = $_W['slwl']['datetime']['now'];
			pdo_insert('slwl_aicard_website_adv', $data);
			$id = pdo_insertid();
		}
		sl_ajax(0, '保存成功！');
	}
	$condition = " AND uniacid=:uniacid AND id=:id ";
	$params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
	$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_website_adv')
		. ' WHERE 1 ' . $condition, $params);


} else if ($operation == 'delete') {

	$post = file_get_contents('php://input');
	if (!$post) { sl_ajax(1, '参数不存在'); }

	$params = @json_decode($post, true);
	if (!$params) { sl_ajax(1, '参数解析出错'); }

	$ids = isset($params['ids']) ? $params['ids'] : '';
	if (!$ids) { sl_ajax(1, 'ID为空'); }

	$where = [];
	$where['id IN'] = $ids;

	$rst = @pdo_delete('slwl_aicard_website_adv', $where);

	if ($rst !== false) {
		sl_ajax(0, '成功');
	} else {
		sl_ajax(1, '不存在或已删除');
	}


} else {
	message('请求方式不存在');
}

include $this->template('web/website/adv');

