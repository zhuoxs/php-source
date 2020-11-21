<?php
//QQ63779278
require '../../../../framework/bootstrap.inc.php';
require '../../../../addons/ewei_shopv2/defines.php';
require '../../../../addons/ewei_shopv2/core/inc/functions.php';
$ordersn = $_GET['outtradeno'];
$attachs = explode(':', $_GET['attach']);
if (empty($attachs) || !is_array($attachs)) {
	exit();
}

$uniacid = $attachs[0];
$paytype = $attachs[1];
$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile';

if (!empty($ordersn)) {
	if ($paytype == 0) {
		$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile&r=order.pay.complete&ordersn=' . $ordersn . '&type=wechat';
	}
	else if ($paytype == 1) {
		$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile&r=member.recharge.wechat_complete&logno=' . $ordersn;
	}
	else if ($paytype == 2) {
		$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile&r=creditshop.detail.wechat_complete&logno=' . $ordersn;
	}
	else if ($paytype == 3) {
		$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile&r=creditshop.log.wechat_dispatch_complete&logno=' . $ordersn;
	}
	else if ($paytype == 4) {
		$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile&r=sale.coupon.my';
	}
	else if ($paytype == 5) {
		$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile&r=groups.pay.complete&ordersn=' . $ordersn . '&type=wechat';
	}
	else {
		if ($paytype == 6) {
			$url = $_W['siteroot'] . '../../app/index.php?i=' . $uniacid . '&c=entry&m=ewei_shopv2&do=mobile&r=threen.register.complete&logno=' . $ordersn . '&type=wechat';
		}
	}
}

header('location: ' . $url);
exit();

?>
