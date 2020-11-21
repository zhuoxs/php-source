<?php

defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
paycenter_check_login();
$user_permission = permission_account_user('system');
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'index';
if ($_W['account']['level'] != ACCOUNT_SERVICE_VERIFY) {
	message('公众号权限不足', '', 'error');
}
if($op == 'post') {
	if(checksubmit()) {
		$fee = trim($_GPC['fee']) ? trim($_GPC['fee']) : message('收款金额有误', '', 'error');
		$body = trim($_GPC['body']) ? trim($_GPC['body']) : '收银台收款' . $fee;
		$data = array(
			'uniacid' => $_W['uniacid'],
			'clerk_id' => $_W['user']['clerk_id'],
			'clerk_type' => $_W['user']['clerk_type'],
			'store_id' => $_W['user']['store_id'],
			'body' => $body,
			'fee' => $fee,
			'final_fee' => $fee,
			'credit_status' => 1,
			'createtime' => TIMESTAMP,
		);
		pdo_insert('paycenter_order', $data);
		$id = pdo_insertid();
		header('location:' . $this->createMobileUrl('scanpay', array('op' => 'qrcode', 'id' => $id)));
		die;
	}
}

if($op == 'qrcode') {
	$id = intval($_GPC['id']);
	$order = pdo_get('paycenter_order', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if(empty($order)) {
		message('订单不存在或已删除', '', 'error');
	}
	if($order['status'] == 1) {
		message('该订单已付款', '', 'error');
	}
}

if($op == 'list') {
	$condition = ' WHERE uniacid = :uniacid AND status = 1 AND clerk_id = :clerk_id ';
	$params = array(':uniacid' => $_W['uniacid'], ':clerk_id' => $_W['user']['clerk_id']);
	$period = intval($_GPC['period']);
	if($period <= 0) {
		$starttime = strtotime(date('Y-m-d')) + $period * 86400;
		$endtime = $starttime + 86400;
		$condition .= ' AND paytime >= :starttime AND paytime <= :endtime ';
		$params[':starttime'] = $starttime;
		$params[':endtime'] = $endtime;
	}
	$orders = pdo_fetchall('SELECT * FROM ' . tablename('paycenter_order') . $condition . ' ORDER BY paytime DESC ', $params);
}

if($op == 'detail') {
	$id = intval($_GPC['id']);
	$order = pdo_get('paycenter_order', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if(empty($order)) {
		message('订单不存在', '', '');
	} else {
		$store_id = $order['store_id'];
		$types = paycenter_order_types();
		$trade_types = paycenter_order_trade_types();
		$status = paycenter_order_status();
		$store_info = pdo_get('activity_stores', array('id' => $store_id), array('business_name'));
	}
}

include $this->template('scanpay');