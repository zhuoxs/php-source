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
$sets = pdo_fetchall('select uniacid,refund from ' . tablename('ewei_shop_groups_set'));

foreach ($sets as $key => $value) {
	global $_W;
	global $_GPC;
	$_W['uniacid'] = $value['uniacid'];

	if (empty($_W['uniacid'])) {
		continue;
	}

	$params = array(':uniacid' => $_W['uniacid']);
	$times = 24 * 60 * 60;
	$sql = 'SELECT id,status FROM' . tablename('ewei_shop_groups_order') . (' where uniacid = :uniacid and status = 0 and createtime + ' . $times . ' <= ') . time() . ' ';
	$orders = pdo_fetchall($sql, $params);

	foreach ($orders as $k => $val) {
		if (!empty($val) && $val['status'] == 0) {
			pdo_query('update ' . tablename('ewei_shop_groups_order') . ' set status=-1,canceltime=' . time() . ' where id=' . $val['id']);
		}
	}

	$sql1 = 'SELECT * FROM' . tablename('ewei_shop_groups_order') . ' where uniacid = :uniacid and heads = 1 and status = 1 and success = 0 ';
	$allteam = pdo_fetchall($sql1, $params);

	foreach ($allteam as $k => $val) {
		$total = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . '  where uniacid = :uniacid and teamid = :teamid and heads = :heads and status = :status and success = :success and is_team = 1  ', array(':uniacid' => $_W['uniacid'], ':heads' => 1, ':teamid' => $val['teamid'], ':status' => 1, ':success' => 0));
		$groups_num = $val['groupnum'];

		if ($val['is_ladder'] == 1) {
			$ladder = pdo_get('ewei_shop_groups_ladder', array('id' => $val['ladder_id']));
			$groups_num = $ladder['ladder_num'];
		}

		if ($groups_num == $total) {
			pdo_update('ewei_shop_groups_order', array('success' => 1), array('teamid' => $val['teamid']));
			p('groups')->sendTeamMessage($val['id']);
		}
		else {
			$hours = $val['endtime'];
			$time = time();
			$date = date('Y-m-d H:i:s', $val['starttime']);
			$endtime = date('Y-m-d H:i:s', strtotime(' ' . $date . ' + ' . $hours . ' hour'));
			$date1 = date('Y-m-d H:i:s', $time);
			$lasttime2 = strtotime($endtime) - strtotime($date1);

			if ($lasttime2 < 0) {
				pdo_update('ewei_shop_groups_order', array('success' => -1, 'canceltime' => $time), array('teamid' => $val['teamid']));
				p('groups')->sendTeamMessage($val['id']);
			}
		}
	}
}

?>
