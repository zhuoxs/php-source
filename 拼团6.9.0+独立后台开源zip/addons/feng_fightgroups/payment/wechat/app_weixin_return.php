<?php

require '../../../../framework/bootstrap.inc.php';
require IA_ROOT. '/addons/feng_fightgroups/core/common/defines.php';
require TG_CORE . 'class/wlloader.class.php';
$ordersn = $_GET['outtradeno'];
$attachs = explode('/', $_GET['attach']);
if (empty($attachs) || !is_array($attachs)) {
	exit();
}
$uniacid = $attachs[0];
$order_out = pdo_fetch("select * from".tablename('tg_order')."where orderno='{$ordersn}' and uniacid={$uniacid}");
if($order_out['is_tuan'] == 2){
	$url = $_W['siteroot'] . '../../app/index.php?i='.$uniacid.'&c=entry&m=feng_fightgroups&do=pay&ac=success&orderid='.$order_out['id'].'&errno=2';
}elseif($order_out['is_tuan'] == 1){
	$url = $_W['siteroot'] . '../../app/index.php?i='.$uniacid.'&c=entry&m=feng_fightgroups&do=order&ac=group&tuan_id='.$order_out['tuan_id'].'&pay=pay';
}elseif($order_out['is_tuan'] == 0){
	$url = $_W['siteroot'] . '../../app/index.php?i='.$uniacid.'&c=entry&m=feng_fightgroups&do=pay&ac=success&orderid='.$order_out['id'];
}
header('location: ' . $url);
exit();
?>
