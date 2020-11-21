<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

require '../../framework/bootstrap.inc.php';
load()->web('common');
$input = file_get_contents('php://input');

if (!empty($input)) {
	$obj = isimplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
	$wechat_data = json_decode(json_encode($obj), true);
	if (empty($wechat_data)) {
		$result = array(
			'return_code' => 'FAIL',
			'return_msg' => ''
		);
		echo array2xml($result);
		exit;
	}
	if ($wechat_data['return_code'] != 'SUCCESS') {
		$result = array(
			'return_code' => 'FAIL',
			'return_msg' => $wechat_data['return_msg']
		);
		exit;
	}
} else {
	$result = array(
		'return_code' => 'FAIL',
		'return_msg' => ''
	);
	echo array2xml($result);
	exit;
}

$account = pdo_get('account_wechats', array('key' => $wechat_data['appid']));
if (empty($account)) {
	$account = pdo_get('account_wxapp', array('key' => $wechat_data['appid']));
}
$_W['uniacid'] = $account['uniacid'];
if (!empty($wechat_data['sub_mch_id'])) {
	$account_list = pdo_getall('account', array(), array('uniacid'));
	if (is_array($account_list)) {
		foreach ($account_list as $sub_account) {
			$setting = uni_setting_load('payment', $sub_account['uniacid']);
			if ($setting['payment']['wechat']['switch'] == PAYMENT_WECHAT_TYPE_SERVICE && $wechat_data['sub_mch_id'] == $setting['payment']['wechat']['sub_mch_id']) {
				$_W['uniacid'] = $sub_account['uniacid'];
				break;
			}
		}
	}
}
$setting = uni_setting_load('payment', $_W['uniacid']);
$pay_setting = $setting['payment']['wechat'];
$pay_setting['signkey'] = $pay_setting['version'] == 1 ? $pay_setting['key'] : $pay_setting['signkey'];
if ($pay_setting['switch'] == PAYMENT_WECHAT_TYPE_SERVICE) {
	$proxy_setting = uni_setting_load('payment', $pay_setting['service']);
	$pay_setting['signkey'] = $proxy_setting['payment']['wechat_facilitator']['signkey'];
}

if(!empty($pay_setting['signkey'])) {
	WeUtility::logging('refund', var_export($wechat_data, true));
	$key = md5($pay_setting['signkey']);
	$wechat_data['req_info'] = aes_pkcs7_decode($wechat_data['req_info'], $key);
	$refund = json_decode(json_encode(isimplexml_load_string($wechat_data['req_info'], 'SimpleXMLElement', LIBXML_NOCDATA)), true);

	if(!empty($refund)) {
		$pay_log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'uniontid' => $refund['out_trade_no']));
		$refund_log = pdo_get('core_refundlog', array('uniacid' => $_W['uniacid'], 'refund_uniontid' => $refund['out_refund_no'], 'uniontid' => $refund['out_trade_no']));
				if(!empty($refund_log) && $refund_log['status'] == '0' && (($refund['total_fee'] / 100) == $pay_log['card_fee'])) {
			pdo_update('core_refundlog', array('status' => 1), array('id' => $refund_log['id']));
			$site = WeUtility::createModuleSite($pay_log['module']);
			if(!is_error($site)) {
				$method = 'refundResult';
				if (method_exists($site, $method)) {
					$ret = array();
					$ret['uniacid'] = $pay_log['uniacid'];
					$ret['result'] = 'success';
					$ret['type'] = $pay_log['type'];
					$ret['from'] = 'refund';
					$ret['tid'] = $pay_log['tid'];
					$ret['uniontid'] = $pay_log['uniontid'];
					$ret['refund_uniontid'] = $refund_log['refund_uniontid'];
					$ret['user'] = $pay_log['openid'];
					$ret['fee'] = $refund['fee'];
					if(!empty($refund['success_time'])) {
						$ret['refund_time'] = strtotime($refund['time_end']);
					}
					$site->$method($ret);
					exit('success');
				}
			}
		}
	}
}
