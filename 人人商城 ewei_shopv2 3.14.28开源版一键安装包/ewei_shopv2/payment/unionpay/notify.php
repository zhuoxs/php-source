<?php
//QQ63779278
error_reporting(0);
define('IN_MOBILE', true);
require '../../../../framework/bootstrap.inc.php';
$strs = explode(':', $_POST['reqReserved']);
$_W['uniacid'] = $_W['weid'] = $strs[0];
$type = $strs[1];
$setting = uni_setting($_W['uniacid'], array('payment'));

if (!is_array($setting['payment'])) {
	exit('没有设定支付参数.');
}

$payment = $setting['payment']['unionpay'];
require '__init.php';
if (!empty($_POST) && verify($_POST) && $_POST['respMsg'] == 'success') {
	if ($type == '0') {
		$tid = substr($_POST['orderId'], 8);
		$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `tid`=:tid and `module`=:module limit 1';
		$params = array();
		$params[':tid'] = $tid;
		$params[':module'] = 'ewei_shopv2';
		$log = pdo_fetch($sql, $params);
		if (!empty($log) && $log['status'] == '0') {
			$log['tag'] = iunserializer($log['tag']);
			$log['tag']['queryId'] = $_POST['queryId'];
			$record = array();
			$record['status'] = 1;
			$record['tag'] = iserializer($log['tag']);
			pdo_update('core_paylog', $record, array('plid' => $log['plid']));
			if ($log['is_usecard'] == 1 && $log['card_type'] == 1 && !empty($log['encrypt_code']) && $log['acid']) {
				load()->classs('coupon');
				$acc = new coupon($log['acid']);
				$codearr['encrypt_code'] = $log['encrypt_code'];
				$codearr['module'] = $log['module'];
				$codearr['card_id'] = $log['card_id'];
				$acc->PayConsumeCode($codearr);
			}

			if ($log['is_usecard'] == 1 && $log['card_type'] == 2) {
				$now = time();
				$log['card_id'] = intval($log['card_id']);
				$iscard = pdo_fetchcolumn('SELECT iscard FROM ' . tablename('modules') . ' WHERE name = :name', array(':name' => $log['module']));
				$condition = '';

				if ($iscard == 1) {
					$condition = ' AND grantmodule = \'' . $log['module'] . '\'';
				}

				pdo_query('UPDATE ' . tablename('activity_coupon_record') . (' SET status = 2, usetime = ' . $now . ', usemodule = \'' . $log['module'] . '\' WHERE uniacid = :aid AND couponid = :cid AND uid = :uid AND status = 1 ' . $condition . ' LIMIT 1'), array(':aid' => $_W['uniacid'], ':uid' => $log['openid'], ':cid' => $log['card_id']));
			}

			$site = WeUtility::createModuleSite($log['module']);

			if (!is_error($site)) {
				$method = 'payResult';

				if (method_exists($site, $method)) {
					$ret = array();
					$ret['weid'] = $log['uniacid'];
					$ret['uniacid'] = $log['uniacid'];
					$ret['result'] = 'success';
					$ret['type'] = $log['type'];
					$ret['from'] = 'return';
					$ret['tid'] = $log['tid'];
					$ret['user'] = $log['openid'];
					$ret['fee'] = $log['fee'];
					$ret['tag'] = $log['tag'];
					$ret['is_usecard'] = $log['is_usecard'];
					$ret['card_type'] = $log['card_type'];
					$ret['card_fee'] = $log['card_fee'];
					$ret['card_id'] = $log['card_id'];
					$site->{$method}($ret);
					exit('success');
				}
			}
		}
	}
	else {
		if ($type == '1') {
			require '../../../../addons/ewei_shopv2/defines.php';
			require '../../../../addons/ewei_shopv2/core/inc/functions.php';
			$tid = substr($_POST['orderId'], 8);
			$logid = intval(str_replace('recharge', '', $tid));

			if (empty($logid)) {
				exit();
			}

			$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_log') . ' WHERE `uniacid`=:uniacid and `id`=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $logid));
			if (!empty($log) && empty($log['status'])) {
				pdo_update('ewei_shop_member_log', array('status' => 1, 'rechargetype' => 'alipay', 'logno' => $log['openid']), array('id' => $logid));
				$shopset = m('common')->getSysset('shop');
				m('member')->setCredit($log['openid'], 'credit2', $log['money'], array(0, $shopset['name'] . '会员充值:credit2:' . $log['money']));
				m('member')->setRechargeCredit($openid, $log['money']);
				m('notice')->sendMemberLogMessage($logid);
			}
		}
	}
}

exit('fail');

?>
