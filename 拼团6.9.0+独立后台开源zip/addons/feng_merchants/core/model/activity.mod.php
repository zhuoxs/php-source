<?php
/**
 * 函数getGoodsList，按检索条件检索出所有商品
 * $params : 类型：array
 * 
 */
	function activity_get_list($args = array()) {
		global $_W;
		$usepage = !empty($args['usepage'])? $args['usepage'] : false;
		$page = !empty($args['page'])? intval($args['page']): 1;
		$pagesize = !empty($args['pagesize'])? intval($args['pagesize']): 10;
		$orderby = !empty($args['orderby'])? $args['orderby'] : 'order by id desc';
		
		$condition = ' and `uniacid` = :uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		if ($usepage) {
			$sql = "SELECT * FROM " . tablename('tg_coupon_template') . " where 1 {$condition} {$orderby} LIMIT " . ($page - 1) * $pagesize . ',' . $pagesize;
		} else {
			$sql = "SELECT * FROM " . tablename('tg_coupon_template') . " where 1 {$condition} ";
		} 
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('tg_coupon_template')."where 1 $condition ",$params);
		$data = array();
		$data['list'] = $list;
		$data['total'] = $total;
		return $data;
	} 
function coupon_template_all() {
	$coupon_template_all = pdo_fetch_many('tg_coupon_template', array(), array(), 'id', 'ORDER BY `id` DESC');
	cache_write($cache_key, $coupon_template_all);
	return $coupon_template_all;
}


function coupon_template($coupon_template_id) {
	$coupon_template_all = coupon_template_all();
	return $coupon_template_all[$coupon_template_id];
}


function coupon_grant($uid, $coupon_template_id){
	if (!activity_enable('coupon')) {
		return error(1, '优惠券未开启');
	}
	
	$coupon_template = coupon_template($coupon_template_id);
	if (empty($coupon_template)) {
		return error(1, '优惠券不存在或已删除');
	}
	if ($coupon_template['total'] <= $coupon_template['quantity_issue']) {
		return error(1, '优惠券已发完');
	}
	if ($coupon_template['enable'] != YES) {
		return error(1, '商家停止发放优惠券');
	}
	
	if ($coupon_template['is_random'] == YES) {
		$cash = rand($coupon_template['value'], $coupon_template['value_to']);
	} else {
		$cash = $coupon_template['value'];
	}
	$coupon_data = array(
		'coupon_template_id' => $coupon_template['id'],
		'name' => $coupon_template['name'],
		'cash' => $cash,
		'is_at_least' => $coupon_template['is_at_least'],
		'at_least' => $coupon_template['at_least'],
		'description' => $coupon_template['description'],
		'start_time' => $coupon_template['start_time'],
		'end_time' => $coupon_template['end_time'],
		'use_time' => 0,
		'uid' => $uid,
		'createtime' => TIMESTAMP
	);
	pdo_insert('coupon', $coupon_data);
	$coupon_data['id'] = pdo_insertid();
	
	coupon_quantity_issue_increase($coupon_template['id'], 1);
	
	return $coupon_data;
}


function coupon($coupon_id){
	$coupon = pdo_fetch_one('coupon', array('id' => $coupon_id));
	return $coupon;
}


function coupon_quantity_issue_increase($coupon_template_id, $quantity) {
	$sql = 'UPDATE '.tablename('tg_coupon_template').' SET `quantity_issue` = `quantity_issue` + :quantity WHERE id=:id';
	$params = array(
		':id' => $coupon_template_id,
		':quantity' => $quantity
	);
	pdo_query($sql, $params);
	
	return true;
}


function coupon_quantity_used_increase($coupon_template_id, $quantity) {
	$sql = 'UPDATE '.tablename('tg_coupon_template').' SET `quantity_used`=`quantity_used`+:quantity WHERE id=:id';
	$params = array(
		':id' => $coupon_template_id,
		':quantity' => $quantity
	);
	pdo_query($sql, $params);
	
	return true;
}


function coupon_handle($order, $coupon_id) {
	$errmsg = '无法使用优惠券: ';
	if (!activity_enable('coupon')) {
		return error(1, $errmsg.'优惠券功能未启用');
	}
	if ($order['status'] != OrderStatus::TO_PAY) {
		return error(1, $errmsg.'订单不是待付款订单');
	}
	$coupon = coupon($coupon_id);
	if (empty($coupon) || $coupon['uid'] != $order['uid']) {
		return error(1, $errmsg.'不存在或已删除');
	}
	if ($coupon['start_time'] > TIMESTAMP ) {
		return error(1, $errmsg.'未生效');
	}
	if ($coupon['end_time'] < TIMESTAMP) {
		return error(1, $errmsg.'已失效');
	}
	if ($coupon['use_time'] > 0) {
		return error(1, $errmsg.'已使用');
	}
	if ($coupon['is_at_least'] == YES && $order['total_fee'] < $coupon['at_least']) {
		return error(1, $errmsg.'不满足使用条件,商品总价应达到'.currency_format($coupon['at_least']).'元');
	}
	
		$old_coupon_activity = pdo_fetch_one('order_activity', array('order_id' => $order['id'], 'activity' => 'coupon'));
	if (!empty($old_coupon_activity)) {
		$old_coupon_id = $old_coupon_activity['activity_id'];
		$old_coupon = coupon($old_coupon_id);
		pdo_delete('order_activity', array('id' => $old_coupon_activity['id']));
		pdo_update('coupon', array('use_time' => 0), array('id' => $old_coupon_id));
		coupon_quantity_used_increase($old_coupon['coupon_template_id'], -1);
	}
	
		$cash = currency_format($coupon['cash']);
	$activity = array(
		'order_id' => $order['id'],
		'activity' => 'coupon',
		'activity_id' => $coupon['id'],
		'code' => 'cash',
		'value' => $cash,
		'quantity' => 1,
		'status' => 2,
		'remark' => "使用优惠券减 {$cash} 元",
	);
	pdo_insert('order_activity', $activity);
	pdo_update('coupon', array('use_time' => TIMESTAMP), array('id' => $coupon['id']));
	
	coupon_quantity_used_increase($coupon['coupon_template_id'], 1);
	
	$order['discount_fee'] = order_discount_fee($order);
	$order['payment'] = order_payment($order);
	pdo_update('order', array('discount_fee' => $order['discount_fee'], 'payment' => $order['payment']), array('id' => $order['id']));

	return true;
}