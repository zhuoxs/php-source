<?php
//QQ63779278
function str($str)
{
	$str = str_replace('"', '', $str);
	$str = str_replace('\'', '', $str);
	$str = str_replace('=', '', $str);
	return $str;
}

require '../../../../framework/bootstrap.inc.php';
require '../../../../addons/ewei_shopv2/defines.php';
require '../../../../addons/ewei_shopv2/core/inc/functions.php';
$ordersn = str($_GET['out_trade_no']);
$attachs = explode(':', str($_GET['body']));
if (empty($ordersn) && !empty($_GET['alipayresult'])) {
	$alipayresult = json_decode($_GET['alipayresult'], true);
	$ordersn = $alipayresult['alipay_trade_app_pay_response']['out_trade_no'];
	$change_price = stripos($alipayresult['alipay_trade_app_pay_response']['out_trade_no'], 'GJ');

	if ($change_price) {
		$ordersn = substr($alipayresult['alipay_trade_app_pay_response']['out_trade_no'], 0, $change_price);
	}

	$prefix = substr($ordersn, 0, 2);
	if ($prefix == 'SH' || $prefix == 'ME') {
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where  ordersn=:ordersn limit 1', array(':ordersn' => $ordersn));

		if (!empty($order)) {
			$url = $_W['siteroot'] . '../../app/index.php?i=' . $order['uniacid'] . '&c=entry&m=ewei_shopv2&do=mobile&r=order.detail&id=' . $order['id'];
		}
	}
	else {
		if ($prefix == 'RC') {
			$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_log') . ' WHERE `logno`=:logno  limit 1', array(':logno' => $ordersn));

			if (!empty($log)) {
				$url = $_W['siteroot'] . '../../app/index.php?i=' . $log['uniacid'] . '&c=entry&m=ewei_shopv2&do=mobile&r=member';
			}
		}
	}

	header('location: ' . $url);
	exit();
}

$get = json_encode($_GET);
$get = base64_encode($get);
if (empty($attachs) || !is_array($attachs)) {
	exit();
}

$uniacid = intval($attachs[0]);
$paytype = intval($attachs[1]);
$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile';

if (!empty($ordersn)) {
	if (strexists($ordersn, 'CS') && pdo_tableexists('ewei_shop_cashier_pay_log')) {
		$cashier = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_cashier_pay_log') . ' WHERE logno=:logno', array(':logno' => $ordersn));

		if (!empty($cashier)) {
			$uniacid = $cashier['uniacid'];
			$cashierid = $cashier['cashierid'];
			$paytype = 2;
		}
	}

	if ($paytype == 0) {
		$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile&r=order.pay_alipay.complete&alidata=' . $get;
	}
	else if ($paytype == 1) {
		$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile&r=order.pay_alipay.recharge_complete&alidata=' . $get;
	}
	else if ($paytype == 2) {
		$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile&r=cashier.pay.success&cashierid=' . $cashierid . '&orderid=' . $ordersn;
	}
	else {
		if ($paytype == 6) {
			$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile&r=threen.register.threen_complete&alidata=' . $get . '&logno=' . $ordersn;
		}
	}
}

header('location: ' . $url);
exit();

?>
