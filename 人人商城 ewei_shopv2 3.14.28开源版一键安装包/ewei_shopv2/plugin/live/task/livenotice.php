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
$sets = pdo_fetchall('select uniacid,livenoticetime from ' . tablename('ewei_shop_live_setting'));

foreach ($sets as $key => $value) {
	global $_W;
	global $_GPC;
	$_W['uniacid'] = $value['uniacid'];

	if (empty($_W['uniacid'])) {
		continue;
	}

	$params = array(':uniacid' => $_W['uniacid']);
	$times = intval($value['livenoticetime']) * 60;
	$livetime = $times + time();
	$sql = 'select id,livetime from ' . tablename('ewei_shop_live') . ' where uniacid = :uniacid and subscribenotice = 0 and livetime > ' . time() . ' and livetime < ' . $livetime . ' and status = 1 and subscribe > 0 ';
	$lives = pdo_fetchall($sql, $params);

	if (!empty($lives)) {
		foreach ($lives as $k => $val) {
			$sql_favorite = 'select openid from ' . tablename('ewei_shop_live_favorite') . ' where uniacid = :uniacid and roomid = ' . $val['id'] . ' and deleted = 0 ';
			$favorites = pdo_fetchall($sql_favorite, $params);

			foreach ($favorites as $v) {
			}

			pdo_update('ewei_shop_live', array('subscribenotice' => 1), array('id' => $val['id']));
		}
	}
}

?>
