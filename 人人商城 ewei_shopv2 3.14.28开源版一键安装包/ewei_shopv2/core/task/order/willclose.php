<?php
//QQ63779278
error_reporting(0);
require '../../../../../framework/bootstrap.inc.php';
require '../../../../../addons/ewei_shopv2/defines.php';
require '../../../../../addons/ewei_shopv2/core/inc/functions.php';
global $_W;
global $_GPC;
ignore_user_abort();
set_time_limit(0);
$uniacids = m('cache')->get('willcloseuniacid', 'global');

if (empty($uniacids)) {
	return NULL;
}

foreach ($uniacids as $uniacid) {
	if (empty($uniacid)) {
		continue;
	}

	$_W['uniacid'] = $uniacid;
	$trade = m('common')->getSysset('trade', $_W['uniacid']);
	$days = intval($trade['closeorder']);
	$minute = intval($trade['willcloseorder']);

	if ($days <= 0) {
		exit();
	}

	if ($minute == 0) {
		$minute = 30;
	}

	$minute *= 60;
	$daytimes = 86400 * $days;
	$orders = pdo_fetchall('select id,openid,deductcredit2,ordersn,isparent,deductcredit,deductprice from ' . tablename('ewei_shop_order') . (' where  uniacid=' . $_W['uniacid'] . ' and status=0 and paytype<>3 and willcancelmessage <>1 and createtime + ' . $daytimes . '- ' . $minute . '<=unix_timestamp() '));

	foreach ($orders as $o) {
		$onew = pdo_fetch('select id,status  from ' . tablename('ewei_shop_order') . (' where id=:id and status=0 and paytype<>3  and createtime + ' . $daytimes . '- ' . $minute . ' <=unix_timestamp()  limit 1'), array(':id' => $o['id']));
		if (!empty($onew) && $onew['status'] == 0) {
			m('notice')->sendOrderWillCancelMessage($onew['id'], $daytimes);
		}
	}
}

?>
