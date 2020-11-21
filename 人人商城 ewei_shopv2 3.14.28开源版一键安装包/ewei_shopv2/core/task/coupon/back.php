<?php
//QQ63779278
ini_set('display_errors', 'On');
error_reporting(32767);
require '../../../../../framework/bootstrap.inc.php';
require '../../../../../addons/ewei_shopv2/defines.php';
require '../../../../../addons/ewei_shopv2/core/inc/functions.php';
global $_W;
global $_GPC;
ignore_user_abort();
set_time_limit(0);
$p = com('coupon');
$sets = pdo_fetchall('select uniacid from ' . tablename('ewei_shop_sysset'));

foreach ($sets as $set) {
	$_W['uniacid'] = $set['uniacid'];

	if (empty($_W['uniacid'])) {
		continue;
	}

	$trade = m('common')->getSysset('trade', $_W['uniacid']);
	$days = intval($trade['refunddays']);
	$daytimes = 86400 * $days;
	$orders = pdo_fetchall('select id,couponid from ' . tablename('ewei_shop_order') . (' where  uniacid=' . $_W['uniacid'] . ' and status=3 and isparent=0 and couponid<>0 and finishtime + ' . $daytimes . ' <=unix_timestamp() '));

	if (!empty($orders)) {
		if ($p) {
			foreach ($orders as $o) {
				if (!empty($o['couponid'])) {
					$p->backConsumeCoupon($o['id']);
				}
			}
		}
	}
}

?>
