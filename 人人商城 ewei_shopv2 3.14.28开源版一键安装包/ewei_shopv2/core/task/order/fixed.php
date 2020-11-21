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
$table = tablename('ewei_shop_order');
pdo_query('update ' . $table . ' set status = -1 where createtime <1501257600');
pdo_query('update ' . $table . ' set status = 1 where (paytime > 0 or paytype =3) and (sendtime = 0 and sendtype = 0) and createtime <1501257600');
pdo_query('update ' . $table . ' set status = 2 where (paytime>0 or paytype = 3) and (sendtime > 0 or sendtype >0) and finishtime = 0 and createtime <1501257600');
pdo_query('update ' . $table . ' set status = 3 where (paytime>0  or paytype = 3) and (sendtime >0 or sendtype >0) and finishtime >0 and createtime <1501257600');
pdo_query('update ' . $table . ' set status = 0 where (paytime = 0 and paytype <>3) and canceltime = 0 and createtime + 86400 <= unix_timestamp() and createtime <1501257600');
pdo_query('update ' . $table . ' set refundstate = 0,status = -1 where refundtime <> 0 and createtime <1501257600');
$sets = pdo_fetchall('select uniacid from ' . tablename('ewei_shop_sysset'));

foreach ($sets as $set) {
	$_W['uniacid'] = $set['uniacid'];

	if (empty($_W['uniacid'])) {
		continue;
	}

	$trade = m('common')->getSysset('trade', $_W['uniacid']);
	$days = intval($trade['closeorder']);

	if ($days <= 0) {
		continue;
	}

	$daytimes = 86400 * $days;
	$orders = pdo_fetchall('select id,openid,deductcredit2,ordersn,isparent,deductcredit,deductprice,status,isparent,isverify from ' . tablename('ewei_shop_order') . (' where uniacid=' . $_W['uniacid'] . '  and paytype<>3  and ((createtime + ' . $daytimes . ' <=unix_timestamp() and status=0) or (status = 1 and `isverify` = 1 and `verifyendtime` <= unix_timestamp() and `verifyendtime` > 0))'));
	$p = com('coupon');

	foreach ($orders as $o) {
		if ($o['status'] == 0) {
			$isPeerpay = m('order')->checkpeerpay($o['id']);

			if ($o['isparent'] == 0) {
				if ($p) {
					if (!empty($o['couponid'])) {
						$p->returnConsumeCoupon($o['id']);
					}
				}

				m('order')->setStocksAndCredits($o['id'], 2);
				m('order')->setDeductCredit2($o);

				if (0 < $o['deductprice']) {
					m('member')->setCredit($o['openid'], 'credit1', $o['deductcredit'], array('0', $_W['shopset']['shop']['name'] . ('自动关闭订单返还抵扣积分 积分: ' . $o['deductcredit'] . ' 抵扣金额: ' . $o['deductprice'] . ' 订单号: ' . $o['ordersn'])));
				}
			}

			if (!empty($isPeerpay)) {
				$refundsql = 'SELECT * FROM ' . tablename('ewei_shop_order_peerpay_payinfo') . ' WHERE pid = :pid';
				$refundlist = pdo_fetchall($refundsql, array(':pid' => $isPeerpay['id']));

				foreach ($refundlist as $k => $v) {
					$openid = $v['openid'];
					if (!empty($openid) && !empty($v['tid'])) {
						$result = m('finance')->pay($openid, 1, $v['price'] * 100, $o['ordersn'], '退款: ' . $v['price'] . '元 订单号: ' . $o['ordersn']);

						if (is_error($result)) {
							m('member')->setCredit($openid, 'credit2', $v['price'], array(0, '退款: ' . $v['price'] . '元 订单号: ' . $o['ordersn']));
						}
					}
					else {
						m('member')->setCredit($openid, 'credit2', $v['price'], array(0, '退款: ' . $v['price'] . '元 订单号: ' . $o['ordersn']));
					}
				}
			}

			pdo_query('update ' . tablename('ewei_shop_order') . ' set status=-1,canceltime=' . time() . ' where id=' . $o['id']);
		}
		else {
			if ($o['status'] == 1 && $o['isverify'] == 1) {
				pdo_query('update ' . tablename('ewei_shop_order') . ' set status=-1,canceltime=' . time() . ' where id=' . $o['id']);
			}
		}
	}
}

exit('补丁运行成功，请检查订单状态是否已经修复，如有异常订单请联系客服');

?>
