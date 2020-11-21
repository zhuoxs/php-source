<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {


} else if ($operation == 'display_table') {
	$keyword = $_GPC['keyword'];

	$condition = ' AND weid=:weid ';
	$params = array(':weid' => $_W['uniacid']);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$psize = 10;
	if ($keyword != '') {
		$condition .= ' AND (name LIKE :name) ';
		$params[':name'] = '%'.$keyword.'%';
	}

	$sql = "SELECT * FROM " . tablename('slwl_aicard_shop_sale'). ' WHERE 1 '
		. $condition . " ORDER BY displayorder DESC, id DESC LIMIT "
		. ($pindex - 1) * $psize .',' .$psize;

	$list = pdo_fetchall($sql, $params);
	if ($list) {
		foreach ($list as $k => $v) {
			$list[$k]['enabled_format'] = $v['enabled'] ? '启用':'禁用';
		}
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_shop_sale') . ' WHERE 1 ' . $condition, $params);
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
		@list($dt['start'], $dt['end']) = @explode(' 至 ', $_GPC['time']);

		$data = array(
			'weid' => $_W['uniacid'],
			'displayorder' => intval($_GPC['displayorder']),
			'name' => $_GPC['name'],
			'thumb'=>$_GPC['thumb'],
			'enough' => $_GPC['enough'],
			'timelimit' => $_GPC['timelimit'],
			'timedays1' => $_GPC['timedays1'],
			'timedays2' => json_encode($dt),
			'backtype' => $_GPC['backtype'],
			'backmoney' => $_GPC['backmoney'],
			'discount' => $_GPC['discount'],
			'flbackmoney' => $_GPC['flbackmoney'],
			'backwhen' => $_GPC['backwhen'],
			'total' => $_GPC['total'],
			'enabled' => intval($_GPC['enabled']),
			'total' => intval($_GPC['total']),
		);

		if (!empty($id)) {
			pdo_update('slwl_aicard_shop_sale', $data, array('id' => $id));
		} else {
			$data['addtime'] = date('Y-m-d H:i:s', time());
			pdo_insert('slwl_aicard_shop_sale', $data);
			$id = pdo_insertid();
		}
		sl_ajax(0, '保存成功！');
	}
	$sale = pdo_fetch("select * from " . tablename('slwl_aicard_shop_sale') . " where id=:id and weid=:weid limit 1", array(":id" => $id, ":weid" => $_W['uniacid']));

	if ($sale) {
		$time = json_decode($sale['timedays2'], true);
		if (!(empty($time['start']))) {
			$sale['timestart'] = strtotime($time['start']);
		} else {
			$sale['timestart'] = time();
		}
		if (!(empty($time['end']))) {
			$sale['timeend'] = strtotime($time['end']);
		} else {
			$sale['timeend'] = strtotime("+1 months");
		}
	}


} else if ($operation == 'delete') {

	$post = file_get_contents('php://input');
	if (!$post) { sl_ajax(1, '参数不存在'); }

	$params = @json_decode($post, true);
	if (!$params) { sl_ajax(1, '参数解析出错'); }

	$ids = isset($params['ids']) ? $params['ids'] : '';
	if (!$ids) { sl_ajax(1, 'ID为空'); }

	$where = [];
	$where['id IN'] = $ids;

	$rst = @pdo_delete('slwl_aicard_shop_sale', $where);

	if ($rst !== false) {
		sl_ajax(0, '成功');
	} else {
		sl_ajax(1, '不存在或已删除');
	}


} else {
	message('请求方式不存在');
}

include $this->template('web/shop/sale');

