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
	$store_table = table('store');
	$result = $store_table->goodsInfo($id);
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
	if (!empty($data['slide'])) {
		$post['slide'] = $data['slide'];
	}
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
	$post['user_group_price'] = $data['user_group_price'];
	if (!empty($data['id'])) {
		$result = pdo_update('site_store_goods', $post, array('id' => $data['id']));
	} else {
		$post['type'] = $data['type'];
		$post['createtime'] = TIMESTAMP;
		$post['title_initial'] = get_first_pinyin($data['title']);
		if ($data['type'] == STORE_TYPE_USER_PACKAGE && !empty($post['unit'])) {
			$post['unit'] = $data['unit'];
		} else {
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