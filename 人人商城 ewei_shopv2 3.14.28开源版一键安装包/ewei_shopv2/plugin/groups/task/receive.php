<?php
//QQ63779278
error_reporting(0);
require '../../../../../framework/bootstrap.inc.php';
require '../../../../../addons/ewei_shopv2/defines.php';
require '../../../../../addons/ewei_shopv2/core/inc/functions.php';
require '../../../../../addons/ewei_shopv2/core/inc/plugin_model.php';
global $_W;
global $_GPC;
ignore_user_abort();
set_time_limit(0);
$sets = pdo_fetchall('select uniacid,receive from ' . tablename('ewei_shop_groups_set'));

foreach ($sets as $set) {
	$_W['uniacid'] = $set['uniacid'];

	if (empty($_W['uniacid'])) {
		continue;
	}

	$days = intval($set['receive']);

	if ($days <= 0) {
		continue;
	}

	$daytimes = 86400 * $days;
	$p = p('groups');
	$pcoupon = com('coupon');
	$orders = pdo_fetchall('select id from ' . tablename('ewei_shop_groups_order') . (' where uniacid=' . $_W['uniacid'] . ' and status=2 and sendtime + ' . $daytimes . ' <=unix_timestamp() '), array(), 'id');

	if (!empty($orders)) {
		$orderkeys = array_keys($orders);
		$orderids = implode(',', $orderkeys);

		if (!empty($orderids)) {
			pdo_query('update ' . tablename('ewei_shop_groups_order') . ' set status=3,finishtime=' . time() . ' where id in (' . $orderids . ')');
		}
	}
}

?>
