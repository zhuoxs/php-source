<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function store_goods_info($id) {
	$result = array();
	$id = intval($id);
	if (empty($id)) {
		return $result;
	}
	$result = table('store')->goodsInfo($id);
	if (!empty($result[$id])) {
		$result = $result[$id];
	}
	return $result;
}

function store_goods_changestatus($id) {
	$result = false;
	$id = intval($id);
	if (empty($id)) {
		return $result;
	}
	$if_exist = pdo_get('site_store_goods', array('id' => $id));
	if (!empty($if_exist)) {
		$status = $if_exist['status'] == 1 ? 0 : 1;
		$data = array('status' => $status);
		$result = pdo_update('site_store_goods', $data, array('id' => $id));
	}
	return $result;
}

function store_goods_delete($id) {
	$result = false;
	$id = intval($id);
	if (empty($id)) {
		return $result;
	}
	$result = pdo_update('site_store_goods', array('status' => 2), array('id' => $id));
	return $result;
}

function store_goods_post($data) {
	$result = false;
	if (empty($data)) {
		return $result;
	}
	$post = array();
	if (!empty($data['title'])) {
		$post['title'] = trim($data['title']);
	}
	if (!empty($data['price']) && is_numeric($data['price'])) {
		$post['price'] = $data['price'];
	}
	$post['slide'] = $data['slide'];
	if (!empty($data['status'])) {
		$post['status'] = 1;
	}
	if (!empty($data['ability']) || !empty($data['synopsis'])) {
		$post['synopsis'] = empty($data['ability']) ? trim($data['synopsis']) : trim($data['ability']);
	}
	if (!empty($data['description'])) {
		$post['description'] = trim($data['description']);
	}
	if (!empty($data['api_num'])) {
		$post['api_num'] = intval($data['api_num']);
	}
	if (!empty($data['unit'])) {
		$post['unit'] = $data['unit'];
	} else {
		if ($data['type'] != STORE_TYPE_API) {
			$post['unit'] = 'month';
		}
	}
	$post['account_num'] = $data['account_num'];
	$post['wxapp_num'] = $data['wxapp_num'];
	$post['module_group'] = $data['module_group'];
	$post['user_group'] = $data['user_group'];
	$post['account_group'] = $data['account_group'];
	$post['user_group_price'] = $data['user_group_price'];

	if ($data['type'] == STORE_TYPE_ACCOUNT_RENEW) {
		$post['account_num'] = $data['account_num'] == 0 ? 1 : $data['account_num'];
	}

	if ($data['type'] == STORE_TYPE_WXAPP_RENEW) {
		$post['wxapp_num'] = $data['wxapp_num'] == 0 ? 1 : $data['wxapp_num'];
	}

	if (!empty($data['id'])) {
		$result = pdo_update('site_store_goods', $post, array('id' => $data['id']));
	} else {
		$post['type'] = $data['type'];
		$post['createtime'] = TIMESTAMP;
		$post['title_initial'] = get_first_pinyin($data['title']);
		if (empty($post['unit'])) {
			$post['unit'] = 'month';
		}
		if ($data['type'] == STORE_TYPE_API) {
			$post['unit'] = 'ten_thousand';
		}
		$post['module'] = trim($data['module']);
		$result = pdo_insert('site_store_goods', $post);
	}
	return $result;
}

function store_order_info($id) {
	$result = array();
	$id = intval($id);
	if (empty($id)) {
		return $result;
	}
	$store_table = table('store');
	$result = $store_table->searchOrderInfo($id);
	if (!empty($result[$id])) {
		$result = $result[$id];
	}
	return $result;
}

function store_order_change_price($id, $price) {
	global $_W;
	$result = false;
	$id = intval($id);
	$price = floatval($price);
	$if_exist = store_order_info($id);
	if (empty($id) || empty($if_exist)) {
		return $result;
	}
	if (user_is_vice_founder() || empty($_W['isfounder'])) {
		return $result;
	}
	pdo_update('core_paylog', array('card_fee' => $price), array('module' => 'store', 'tid' => $id));
	$result = pdo_update('site_store_order', array('amount' => $price, 'changeprice' => 1), array('id' => $id));
	return $result;
}


function store_order_delete($id) {
	$result = false;
	$id = intval($id);
	if (empty($id)) {
		return $result;
	}
	$result = pdo_update('site_store_order', array('type' => STORE_ORDER_DELETE), array('id' => $id));
	return $result;
}


function store_add_cash_order($orderid) {
	global $_W;
	$store_setting = $_W['setting']['store'];
	if (empty($store_setting['cash_status']) || empty($store_setting['cash_ratio'])) {
		return error(1, '未开启分销, 或者提成比例为0');
	}
	$order = store_order_info($orderid);
	if (empty($order)) {
		return error(1, '订单不存在');
	}
	if ($order['type'] != STORE_ORDER_FINISH) {
		return error(1, '订单未支付');
	}
	if ($order['amount'] <= 0) {
		return error(1, '订单金额为0');
	}
	$order_cash = pdo_get('site_store_cash_order', array('order_id' => $order['id']));
	if (!empty($order_cash)) {
		return error(1, '分销订单已存在');
	}
	$user_founder = table('users_founder_own_users')->getFounderByUid($order['buyerid']);
	if (empty($user_founder['founder_uid'])) {
		return error(1, '上级用户非副创始人');
	}

	pdo_insert('site_store_cash_order', array(
		'number' => date('YmdHis') . random(6, 1),
		'founder_uid' => $user_founder['founder_uid'],
		'order_id' => $order['id'],
		'goods_id' => $order['goodsid'],
		'order_amount' => $order['amount'],
		'create_time' => TIMESTAMP,
		'status' => 1,
	));
	if (pdo_insertid()) {
		return true;
	} else {
		return error(1, '写入数据失败');
	}
}

function store_get_cash_orders($condition = array(), $page = 1, $psize = 15) {
	global $_W;
	$cash_orders = pdo_getall('site_store_cash_order', $condition, array(), '', 'id DESC', ($page - 1) * $psize . ',' . $psize);
	if (empty($cash_orders)) {
		return array('list' => array(), 'total' => 0);
	}
	$total = pdo_getcolumn('site_store_cash_order', $condition, 'count(*)');
	$goods_ids = $order_ids = array();
	if (empty($_W['setting']['store']['cash_status']) || empty($_W['setting']['store']['cash_ratio'])) {
		$cash_ratio = 0;
	} else {
		$cash_ratio = $_W['setting']['store']['cash_ratio'];
	}
	foreach ($cash_orders as $k => $order) {
		$goods_ids[] = $order['goods_id'];
		$order_ids[] = $order['order_id'];
		$cash_orders[$k]['cash_amount'] = sprintf('%.2f', $order['order_amount'] * $cash_ratio / 100);
	}
	$store_table = table('store');
	$goods = $store_table->goodsInfo($goods_ids);
	$orders = $store_table->searchOrderInfo($order_ids);
	foreach ($cash_orders as $k => $order) {
		$cash_orders[$k]['order'] = empty($orders[$order['order_id']]) ? array() : $orders[$order['order_id']];
		if (empty($goods[$order['goods_id']])) {
			$cash_orders[$k]['goods'] = array();
		} else {
			if (in_array($goods[$order['goods_id']]['type'], array(STORE_TYPE_MODULE, STORE_TYPE_WXAPP_MODULE))) {
				$cash_orders[$k]['goods'] = module_fetch($goods[$order['goods_id']]['module']);
				$cash_orders[$k]['goods']['type'] = $goods[$order['goods_id']]['type'];
			} else {
				$cash_orders[$k]['goods'] = $goods[$order['goods_id']];
			}
		}
	}
	return array(
		'list' => $cash_orders,
		'total' => $total
	);
}

function store_get_founder_can_cash_amount($founder_id, $has_refuse = false) {
	global $_W;
	$store_setting = $_W['setting']['store'];
	if (empty($store_setting['cash_status']) || empty($store_setting['cash_ratio'])) {
		return 0;
	}
	$status = empty($has_refuse) ? 1 : array(1, 3);
	$can_cash_amount = pdo_getcolumn('site_store_cash_order', array('founder_uid' => $founder_id, 'status' => $status), 'sum(order_amount)');
	return sprintf('%.2f', floatval($can_cash_amount) * $store_setting['cash_ratio'] / 100);
}

function store_add_cash_log($founder_id) {
	$can_cash_amount = store_get_founder_can_cash_amount($founder_id);
	if ($can_cash_amount <= 0) {
		return error(1, '暂无待提现订单');
	}

	pdo_insert('site_store_cash_log', array(
		'number' => date('YmdHis') . random(6, 1),
		'founder_uid' => $founder_id,
		'amount' => $can_cash_amount,
		'create_time' => TIMESTAMP,
		'status' => 1,
	));
	$cash_log_id = pdo_insertid();
	if (empty($cash_log_id)) {
		return error(1, '操作失败, 请重试');
	}
	pdo_update(
		'site_store_cash_order',
		array('status' => 2, 'cash_log_id' => $cash_log_id),
		array('founder_uid' => $founder_id, 'status' => 1)
	);
	return true;
}

function store_get_cash_logs($condition = array(), $page = 1, $psize = 15) {
	$cash_logs = pdo_getall('site_store_cash_log', $condition, array(), '', 'id DESC', ($page - 1) * $psize . ',' . $psize);
	if (empty($cash_logs)) {
		return array('list' => array(), 'total' => 0);
	}
	$founder_uids = array();
	foreach ($cash_logs as $log) {
		$founder_uids[] = $log['founder_uid'];
	}
	$users_info = table('users')->where('uid', $founder_uids)->getall('uid');
	foreach ($cash_logs as $k => $log) {
		$cash_logs[$k]['username'] = empty($users_info[$log['founder_uid']]['username']) ? '' : $users_info[$log['founder_uid']]['username'];
	}
	$total = pdo_getcolumn('site_store_cash_log', $condition, 'count(*)');
	return array(
		'list' => $cash_logs,
		'total' => $total
	);
}
