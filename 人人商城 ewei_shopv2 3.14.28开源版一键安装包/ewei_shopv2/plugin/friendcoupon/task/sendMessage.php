<?php

error_reporting(0);
require '../../../../../framework/bootstrap.inc.php';
require '../../../../../addons/ewei_shopv2/defines.php';
require '../../../../../addons/ewei_shopv2/core/inc/functions.php';
global $_W;
global $_GPC;
set_time_limit(0);
ignore_user_abort();
$time = time();
$table1 = tablename('ewei_shop_friendcoupon');
$table2 = tablename('ewei_shop_friendcoupon_data');
$_W['uniacid'] = $_GPC['uniacid'];
$sql = '    select f.title,fd.* from ' . $table2 . ' fd left join ' . $table1 . ' f on fd.activity_id = f.id where fd.uniacid = ' . $_W['uniacid'] . ' and fd.status = 0 and fd.send_failed_message = 0  and fd.openid <> \'\'   ';
$rows = pdo_fetchall($sql);

foreach ($rows as $row) {
	if ($row['deadline'] < $time) {
		$ret[] = $row;
	}
}

$commonModel = m('common');
$noticeModel = m('notice');
$tm = $commonModel->getSysset('notice');

foreach ($ret as $currentActivityInfo) {
	$url = mobileUrl('friendcoupon', array('id' => $currentActivityInfo['activity_id'], 'mid' => $currentActivityInfo['headerid']));
	$url = substr($url, 1);
	$r = parse_url($_W['siteroot']);
	$resultUrl = $r['scheme'] . '://' . $r['host'] . '/app' . $url;

	if (0 < $currentActivityInfo['enough']) {
		$couponName = '满' . $currentActivityInfo['enough'] . '减' . $currentActivityInfo['deduct'] . '元优惠券';
	}
	else {
		$couponName = '无门槛减' . $currentActivityInfo['deduct'] . '元优惠券';
	}

	if ($tm['friendcoupon_launch_close_advanced']) {
		$sendResult = $noticeModel->sendNotice(array(
	'openid' => $currentActivityInfo['openid'],
	'tag'    => 'friendcoupon_launch',
	'datas'  => array(
		array('name' => '活动名称', 'value' => $currentActivityInfo['title']),
		array('name' => '活动开始时间', 'value' => date('Y-m-d H:i:s', $currentActivityInfo['receive_time'])),
		array('name' => '活动结束时间', 'value' => date('Y-m-d H:i:s', $currentActivityInfo['deadline'])),
		array('name' => '瓜分券领取时间', 'value' => date('Y-m-d H:i:s', time())),
		array('name' => '瓜分券名称', 'value' => $couponName)
		),
	'url'    => $resultUrl
	));

		if (!is_error($sendResult)) {
			pdo_update('ewei_shop_friendcoupon_data', array('send_failed_message' => 1), array('id' => $currentActivityInfo['id']));
		}
	}
	else {
		$params = array('activity_title' => $currentActivityInfo['title'], 'activity_start_time' => date('Y-m-d H:i:s', $currentActivityInfo['receive_time']), 'activity_end_time' => date('Y-m-d H:i:s', $currentActivityInfo['deadline']), 'receiveTime' => date('Y-m-d H:i:s', $currentActivityInfo['receive_time']), 'couponName' => $couponName, 'url' => $resultUrl);
		$ret = m('notice')->sendFriendCouponTemplateMessage($currentActivityInfo['openid'], $params, 'failed');

		if (!is_error($ret)) {
			pdo_update('ewei_shop_friendcoupon_data', array('send_failed_message' => 1), array('id' => $currentActivityInfo['id']));
		}
	}
}

?>
