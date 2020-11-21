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
$cycel = m('common')->getSysset('cycelbuy', $_GPC['uniacid']);
$_W['uniacid'] = $_GPC['uniacid'];
$terminal = empty($cycel['terminal']) ? 3 : $cycel['terminal'];
$order = pdo_fetchall('select id,openid,deductcredit2,price,address,ordersn,isparent,deductcredit,deductprice,status,isparent,isverify,`virtual`,`virtual_info`,createtime,cycelbuy_periodic from ' . tablename('ewei_shop_order') . (' where uniacid=' . $_W['uniacid'] . '  and paytype<>3   and status=2 and iscycelbuy = 1'));

if (!empty($order)) {
	foreach ($order as $k => $v) {
		$cycelbuy_periodic = explode(',', $v['cycelbuy_periodic']);
		$cycel = pdo_fetchall('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where  orderid = ' . $v['id'] . ' and status = 0 and uniacid = ' . $_W['uniacid'] . ' order by receipttime asc limit 1');
		$cycelsn = explode('_', $cycel[0]['cycelsn']);
		$num = $cycelsn[1];
		$v['num'] = $num;
		if ($cycelbuy_periodic[1] == 0 && $cycelbuy_periodic[0] < 3) {
			$days = time() + 86400 * $cycelbuy_periodic[0];

			if ($cycel['receipttime'] <= $days) {
				p('cycelbuy')->sendMessage(NULL, $v, 'TM_CYCELBUY_SELLER_SEND');
			}
		}
		else {
			$days = time() + 86400 * $terminals;

			if ($cycel['receipttime'] <= $days) {
				p('cycelbuy')->sendMessage(NULL, $v, 'TM_CYCELBUY_SELLER_SEND');
			}
		}
	}
}

?>
