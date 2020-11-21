<?php

error_reporting(0);
require '../../../../../framework/bootstrap.inc.php';
require '../../../../../addons/ewei_shopv2/defines.php';
require '../../../../../addons/ewei_shopv2/core/inc/functions.php';
ignore_user_abort();
set_time_limit(0);
$sets = pdo_fetchall('select uniacid from ' . tablename('ewei_shop_sysset'));

if (!empty($sets)) {
	foreach ($sets as $set) {
		$sql = 'SELECT id,accounttime FROM ' . tablename('ewei_shop_merch_user') . ' WHERE accounttime <= ' . time() . ' AND uniacid = :uniacid';
		$params = array(':uniacid' => $set['uniacid']);
		$merchUsers = pdo_fetchall($sql, $params);

		if (!empty($merchUsers)) {
			foreach ($merchUsers as $merchUser) {
				pdo_update('ewei_shop_goods', array('status' => 0), array('merchid' => $merchUser['id'], 'uniacid' => $set['uniacid']));
			}
		}
	}
}

?>
