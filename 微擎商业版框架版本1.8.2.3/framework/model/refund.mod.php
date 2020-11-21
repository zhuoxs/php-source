<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');


function refund_order_can_refund($module, $tid) {
	global $_W;
	$paylog = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'tid' => $tid, 'module' => $module));
	if (empty($paylog)) {
		return error(1, '订单不存在');
	}
	if ($paylog['status'] != 1) {
		return error(1, '此订单还未支付成功不可退款');
	}
	$refund_amount = pdo_getcolumn('core_refundlog', array('uniacid' => $_W['uniacid'], 'status' => 1, 'uniontid' => $paylog['uniontid']), 'SUM(fee)');
	if ($refund_amount >= $paylog['card_fee']) {
		return error(1, '订单已退款成功');
	}
	return true;
}


function refund_create_order($tid, $module, $fee = 0, $reason = '') {
	load()->classs('pay');
	load()->model('module');
	global $_W;
	$order_can_refund = refund_order_can_refund($module, $tid);
	if (is_error($order_can_refund)) {
		return $order_can_refund;
	}
	$module_info = module_fetch($module);
	$moduleid =  empty($module_info['mid']) ? '000000' : sprintf("%06d", $module_info['mid']);
	$refund_uniontid = date('YmdHis') . $moduleid . random(8,1);
	$paylog = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'tid' => $tid, 'module' => $module));
	$refund = array (
		'uniacid' => $_W['uniacid'],
		'uniontid' => $paylog['uniontid'],
		'fee' => empty($fee) ? $paylog['card_fee'] : $fee,
		'status' => 0,
		'refund_uniontid' => $refund_uniontid,
		'reason' => $reason
	);
	pdo_insert('core_refundlog', $refund);
	return pdo_insertid();
}


function refund($refund_id) {
	load()->classs('pay');
	global $_W;
	$refundlog = pdo_get('core_refundlog', array('id' => $refund_id));
	$paylog = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'uniontid' => $refundlog['uniontid']));
	if ($paylog['type'] == 'wechat') {
		$refund_param = reufnd_wechat_build($refund_id);
		$wechat = Pay::create('wechat');
		$response = $wechat->refund($refund_param);
		unlink(ATTACHMENT_ROOT . $_W['uniacid'] . '_wechat_refund_all.pem');
		if (is_error($response)) {
			pdo_update('core_refundlog', array('status' => '-1'), array('id' => $refund_id));
			return $response;
		} else {
			return $response;
		}
	} elseif ($paylog['type'] == 'alipay') {
		$refund_param = reufnd_ali_build($refund_id);
		$ali = Pay::create('alipay');
		$response = $ali->refund($refund_param, $refund_id);
		if (is_error($response)) {
			pdo_update('core_refundlog', array('status' => '-1'), array('id' => $refund_id));
			return $response;
		} else {
			return $response;
		}
	}
	return error(1, '此订单退款方式不存在');
}


function reufnd_ali_build($refund_id) {
	global $_W;
	$setting = uni_setting_load('payment', $_W['uniacid']);
	$refund_setting = $setting['payment']['ali_refund'];
	if ($refund_setting['switch'] != 1) {
		return error(1, '未开启支付宝退款功能！');
	}
	if (empty($refund_setting['private_key'])) {
		return error(1, '缺少支付宝秘钥证书！');
	}

	$refundlog = pdo_get('core_refundlog', array('id' => $refund_id));
	$paylog = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'uniontid' => $refundlog['uniontid']));
	$refund_param = array(
		'app_id' => $refund_setting['app_id'],
		'method' => 'alipay.trade.refund',
		'charset' => 'utf-8',
		'sign_type' => 'RSA2',
		'timestamp' => date('Y-m-d H:i:s'),
		'version' => '1.0',
		'biz_content' => array(
			'out_trade_no' => $paylog['tid'],
			'refund_amount' => $refundlog['fee'],
			'refund_reason' => $refundlog['reason'],
		)
	);
	$refund_param['biz_content'] = json_encode($refund_param['biz_content']);
	return $refund_param;
}


function reufnd_wechat_build($refund_id) {
	global $_W;
	$setting = uni_setting_load('payment', $_W['uniacid']);
	$refund_setting = $setting['payment']['wechat_refund'];
	if ($refund_setting['switch'] != 1) {
		return error(1, '未开启微信退款功能！');
	}
	if (empty($refund_setting['key']) || empty($refund_setting['cert'])) {
		return error(1, '缺少微信证书！');
	}

	$refundlog = pdo_get('core_refundlog', array('id' => $refund_id));
	$paylog = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'uniontid' => $refundlog['uniontid']));
	$account = uni_fetch($_W['uniacid']);
	$refund_param = array(
		'appid' => $account['key'],
		'mch_id' => $setting['payment']['wechat']['mchid'],
		'out_trade_no' => $refundlog['uniontid'],
		'out_refund_no' => $refundlog['refund_uniontid'],
		'total_fee' => $paylog['card_fee'] * 100,
		'refund_fee' => $refundlog['fee'] * 100,
		'nonce_str' => random(8),
		'refund_desc' => $refundlog['reason']
	);
	if ($setting['payment']['wechat']['switch'] == PAYMENT_WECHAT_TYPE_SERVICE) {
		$refund_param['sub_mch_id'] = $setting['payment']['wechat']['sub_mch_id'];
		$refund_param['sub_appid'] = $account['key'];
		$proxy_account = uni_fetch($setting['payment']['wechat']['service']);
		$refund_param['appid'] = $proxy_account['key'];
		$refund_param['mch_id'] = $proxy_account['setting']['payment']['wechat_facilitator']['mchid'];
	}
	$cert = authcode($refund_setting['cert'], 'DECODE');
	$key = authcode($refund_setting['key'], 'DECODE');
	file_put_contents(ATTACHMENT_ROOT . $_W['uniacid'] . '_wechat_refund_all.pem', $cert . $key);
	return $refund_param;
}