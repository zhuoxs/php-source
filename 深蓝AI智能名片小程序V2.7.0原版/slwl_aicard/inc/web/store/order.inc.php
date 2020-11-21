<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
	$status = $_GPC['status'];


} else if ($operation == 'display_table') {
	$keyword = $_GPC['keyword'];

	$status = $_GPC['status'];
	if ($status == '') {
		$where = '';
	} else {
		$where .= " AND status='$status' ";
	}
	$condition = ' AND uniacid=:uniacid ';
	$condition .= $where;
	$params = array(':uniacid' => $_W['uniacid']);
	$pindex = max(1, intval($_GPC['page']));
	$psize = max(10, intval($_GPC['limit']));
	if ($keyword != '') {
		$params[':ordersn'] = '%'.$keyword.'%';
	}
	if ($keyword != '') {
		$tmp = json_encode($keyword);
		$tmp = ltrim($tmp, '"');
		$tmp = rtrim($tmp, '"');
		$tmp = str_replace('\\', '\\\\', $tmp);
		$condition .= ' AND (`address` LIKE :address OR ordersn LIKE :ordersn) ';
		$params[':address'] = '%'.$tmp.'%';
	}

	$sql = "SELECT * FROM " . tablename('slwl_aicard_store_order'). ' WHERE 1 '
		. $condition . " ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

	$list = pdo_fetchall($sql, $params);
	if ($list) {
		$order_status = array(
			'0'=>'已取消',
			'1'=>'待付款',
			'2'=>'待发货',
			'3'=>'待收货',
			'4'=>'已完成',
			'5'=>'退款',
		);
		foreach ($list as $k => $v) {
			$list[$k]['price_format'] = number_format($v['price'] / 100, 2);
			$list[$k]['status_format'] = $order_status[$v['status']];

			// 地址信息
			if ($v['address']) {
				$list_address = json_decode($v['address'], TRUE);
			}
			$list[$k]['address'] = $list_address;
		}
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_store_order')
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


} else if ($operation == 'detail') {
	$id = intval($_GPC['id']);

	$condition = " AND uniacid=:uniacid AND id=:id ";
	$params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
	$order = pdo_fetch('SELECT * FROM ' . sl_table_name('store_order',TRUE) . ' WHERE 1 ' . $condition, $params);
	if (empty($order)) {
		sl_ajax(1, '抱歉，不存在或是已经被删除');
	}

	// 地址信息
	if ($order['address']) {
		$list_address = json_decode($order['address'], TRUE);
	} else {
		sl_ajax(1, '地址信息不存在');
	}
	$order['address'] = $list_address;

	// 商品信息
	if ($order['goods']) {
		$list_goods = json_decode($order['goods'], TRUE);
		foreach ($list_goods as $k => $v) {
			$list_goods[$k]['thumb_url'] = tomedia($v['thumb']);
			$list_goods[$k]['price_format']   = number_format($v['price'] / 100, 2);
			$list_goods[$k]['original_price_format']  = number_format($v['original_price'] / 100, 2);
		}
	} else {
		sl_ajax(1, '商品信息不存在');
	}
	$order['goods'] = $list_goods;

	// 优惠券
	if ($order['coupon']) {
		$order_coupon = json_decode($order['coupon'], TRUE);
		$order['coupon'] = $order_coupon;
	} else {
		$order['coupon'] = '空';
	}

	$order['price_format'] = number_format($order['price'] / 100, 2);
	$order['discount_money_format'] = number_format($order['discount_money'] / 100, 2);
	$originalprice = $order['price'] + $order['discount_money']; // 原价 = 优惠后的价格 + 优惠价格
	$order['originalprice'] = $originalprice;
	$order['originalprice_format'] = number_format($originalprice / 100, 2);


} else if ($operation == 'delete') {

	$post = file_get_contents('php://input');
	if (!$post) { sl_ajax(1, '参数不存在'); }

	$params = @json_decode($post, TRUE);
	if (!$params) { sl_ajax(1, '参数解析出错'); }

	$ids = isset($params['ids']) ? $params['ids'] : '';
	if (!$ids) { sl_ajax(1, 'ID为空'); }

	$where = [];
	$where['id IN'] = $ids;

	$rst = @pdo_delete('slwl_aicard_store_order', $where);

	if ($rst !== false) {
		sl_ajax(0, '成功');
	} else {
		sl_ajax(1, '不存在或已删除');
	}


} else if ($operation == 'order_status') {
	global $_GPC, $_W;
	$id = intval($_GPC['id']);
	$status = $_GPC['status'];

	if (($id == '') || ($status == '')) {
		sl_ajax(0, '参数不能为空');
	}

	$data = [
		'status' => $status,
	];
	$rst = pdo_update("slwl_aicard_store_order", $data, ["id" => $id, "uniacid" => $_W['uniacid']]);

	if ($rst !== false) {
		return result(0, '成功');
	} else {
		return result(1, '失败');
	}


} else {
	message('请求方式不存在');
}


include $this->template('web/store/order');

