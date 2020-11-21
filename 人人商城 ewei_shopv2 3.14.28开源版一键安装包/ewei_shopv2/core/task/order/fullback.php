<?php

error_reporting(0);
require '../../../../../framework/bootstrap.inc.php';
require '../../../../../addons/ewei_shopv2/defines.php';
require '../../../../../addons/ewei_shopv2/core/inc/functions.php';
global $_W;
global $_GPC;
ignore_user_abort();
set_time_limit(0);
$sets = pdo_fetchall('select uniacid from ' . tablename('ewei_shop_sysset'));

foreach ($sets as $set) {
	$_W['uniacid'] = $set['uniacid'];

	if (empty($_W['uniacid'])) {
		continue;
	}

	$trade = m('common')->getSysset('trade', $_W['uniacid']);
	$logs = pdo_fetchall('select id,`day`,fullbackday,openid,priceevery,price,fullbacktime,goodsid,optionid from ' . tablename('ewei_shop_fullback_log') . ' where uniacid = ' . $_W['uniacid'] . ' and isfullback = 0 and (fullbacktime =0 or fullbacktime < ' . strtotime('-1 days') . ') and fullbackday < day ');
	$today = strtotime(date('Y-m-d'), time());

	foreach ($logs as $key => $value) {
		if (1 < $value['day'] - $value['fullbackday']) {
			$count = floor((time() - $value['fullbacktime']) / 86400);

			if (1 <= $count) {
				if ($value['day'] - $value['fullbackday'] <= $count) {
					$count = $value['day'] - $value['fullbackday'];
					$value['priceevery'] = $value['price'] - $value['priceevery'] * $value['fullbackday'];
					$result = m('member')->setCredit($value['openid'], 'credit2', $value['priceevery'], array('0', $_W['shopset']['shop']['name'] . '全返余额' . $value['priceevery']));
					pdo_update('ewei_shop_fullback_log', array('fullbackday' => $value['day'], 'fullbacktime' => $today, 'isfullback' => 1), array('id' => $value['id']));
				}
				else {
					$value['priceevery'] = $value['priceevery'] * $count;
					$value['fullbackday'] = $value['fullbackday'] + $count;
					$result = m('member')->setCredit($value['openid'], 'credit2', $value['priceevery'], array('0', $_W['shopset']['shop']['name'] . '全返余额' . $value['priceevery']));
					pdo_update('ewei_shop_fullback_log', array('fullbackday' => $value['fullbackday'], 'fullbacktime' => $today), array('id' => $value['id']));
				}
			}
		}
		else {
			if ($value['day'] - $value['fullbackday'] == 1) {
				$count = 1;
				$value['priceevery'] = $value['price'] - $value['priceevery'] * $value['fullbackday'];
				$result = m('member')->setCredit($value['openid'], 'credit2', $value['priceevery'], array('0', $_W['shopset']['shop']['name'] . '全返余额' . $value['priceevery']));
				pdo_update('ewei_shop_fullback_log', array('fullbackday' => $value['day'], 'fullbacktime' => time(), 'isfullback' => 1), array('id' => $value['id']));
			}
		}

		if (1 < $count) {
			$i = 1;

			while ($i <= $count - 1) {
				$logdata = array();
				$logdata['uniacid'] = $_W['uniacid'];
				$logdata['fullback_time'] = $value['fullbacktime'] + 86400 * $i;
				$logdata['logid'] = $value['id'];
				$logdata['price'] = 0;
				$logdata['goodsid'] = $value['goodsid'];
				$logdata['optionid'] = $value['optionid'];
				$logdata['day'] = 0;
				pdo_insert('ewei_shop_fullback_log_map', $logdata);
				++$i;
			}
		}

		$logdata = array();
		$logdata['uniacid'] = $_W['uniacid'];
		$logdata['fullback_time'] = $today;
		$logdata['logid'] = $value['id'];
		$logdata['price'] = $value['priceevery'];
		$logdata['goodsid'] = $value['goodsid'];
		$logdata['optionid'] = $value['optionid'];
		$logdata['day'] = $count;
		pdo_insert('ewei_shop_fullback_log_map', $logdata);
	}
}

?>
