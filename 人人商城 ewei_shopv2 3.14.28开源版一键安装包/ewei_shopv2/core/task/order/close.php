<?php
//QQ63779278
error_reporting(0);
require '../../../../../framework/bootstrap.inc.php';
require '../../../../../addons/ewei_shopv2/defines.php';
require '../../../../../addons/ewei_shopv2/core/inc/functions.php';
global $_W;
ignore_user_abort();
set_time_limit(0);
m('cache')->get('ewei_shop_close_order_limit_start');
$limit_page = 60;
$count = pdo_fetch('select count(*) as count from ' . tablename('ewei_shop_sysset'));
$limit_count = ceil($count['count'] / $limit_page);

if (m('cache')->get('ewei_shop_close_order_limit_start') <= $limit_count - 1) {
	$sets = pdo_fetchall('select uniacid from ' . tablename('ewei_shop_sysset') . ' limit ' . m('cache')->get('ewei_shop_close_order_limit_start') * $limit_page . ',' . $limit_page);
	m('cache')->set('ewei_shop_close_order_limit_start', m('cache')->get('ewei_shop_close_order_limit_start') + 1);
}
else {
	m('cache')->set('ewei_shop_close_order_limit_start', 0);
	$sets = pdo_fetchall('select uniacid from ' . tablename('ewei_shop_sysset') . ' limit ' . m('cache')->get('ewei_shop_close_order_limit_start') * $limit_page . ',' . $limit_page);
	m('cache')->set('ewei_shop_close_order_limit_start', 1);
}

foreach ($sets as $set) {
	$_W['uniacid'] = $set['uniacid'];

	if (empty($_W['uniacid'])) {
		continue;
	}

	$trade = m('common')->getSysset('trade', $_W['uniacid']);
	if (isset($trade['closeorder_virtual']) && !empty($trade['closeorder_virtual'])) {
		$min = intval($trade['closeorder_virtual']);
	}
	else {
		$min = 15;
	}

	if (0 < $min) {
		$mintimes = 60 * $min;
		$orders = pdo_fetchall('select id,openid,deductcredit2,ordersn,isparent,deductcredit,deductprice,status,isparent,isverify,`virtual`,`virtual_info`,createtime,merchid from ' . tablename('ewei_shop_order') . (' where uniacid=' . $_W['uniacid'] . '  and paytype<>3  and `virtual` <> 0 and createtime + ' . $mintimes . ' <=unix_timestamp() and status=0'));
		$p = com('coupon');

		if (count($orders) != 0) {
			foreach ($orders as $o) {
				if (!empty($o['virtual']) && $o['virtual'] != 0) {
					if ($o['status'] == 0) {
						$isPeerpay = m('order')->checkpeerpay($o['id']);

						if (!empty($isPeerpay)) {
							continue;
						}

						if ($o['isparent'] == 0) {
							if ($p) {
								if (!empty($o['couponid'])) {
									$p->returnConsumeCoupon($o['id']);
								}
							}

							m('order')->setDeductCredit2($o);
						}

						pdo_query('update ' . tablename('ewei_shop_order') . ' set status=-1,canceltime=' . time() . ' where id=' . $o['id']);
						m('finance')->closeOrder($o['ordersn']);
						$goodsid = pdo_fetch('SELECT goodsid FROM ' . tablename('ewei_shop_order_goods') . ' WHERE uniacid = ' . $_W['uniacid'] . ' AND orderid = ' . $o['id']);
						$typeid = $o['virtual'];
						$vkdata = ltrim($o['virtual_info'], '[');
						$vkdata = rtrim($vkdata, ']');
						$arr = explode('}', $vkdata);

						foreach ($arr as $k => $v) {
							if (!$v) {
								unset($arr[$k]);
							}
						}

						$vkeynum = count($arr);
						pdo_query('update ' . tablename('ewei_shop_virtual_data') . ' set openid="",usetime=0,orderid=0,ordersn="",price=0,merchid=' . $o['merchid'] . ' where typeid=' . intval($typeid) . ' and orderid = ' . $o['id']);
						pdo_query('update ' . tablename('ewei_shop_virtual_type') . ' set usedata=usedata-' . $vkeynum . ' where id=' . intval($typeid));
						pdo_query('update ' . tablename('ewei_shop_goods') . ' set total=total+' . $vkeynum . ' where id=' . intval($goodsid['goodsid']) . ' and uniacid = ' . $_W['uniacid']);
					}
				}
			}
		}
	}

	$days = intval($trade['closeorder']);

	if ($days <= 0) {
		continue;
	}

	if (0 < $days) {
		$daytimes = 86400 * $days;
		$orders = pdo_fetchall('select id,openid,deductcredit2,ordersn,isparent,deductcredit,deductprice,status,isparent,isverify,couponid from ' . tablename('ewei_shop_order') . (' where uniacid=' . $_W['uniacid'] . '  and paytype<>3  and ((createtime + ' . $daytimes . ' <=unix_timestamp() and status=0) or (status = 1 and `isverify` = 1 and `verifyendtime` <= unix_timestamp() and `verifyendtime` > 0))'));
		$p = com('coupon');

		foreach ($orders as $o) {
			if ($o['status'] == 0) {
				$isPeerpay = m('order')->checkpeerpay($o['id']);

				if (!empty($isPeerpay)) {
					if (time() < $isPeerpay['createtime'] + 86400 * 15) {
						continue;
					}

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

				if ($o['isparent'] == 0) {
					if ($p) {
						if (!empty($o['couponid'])) {
							$p->returnConsumeCoupon($o['id']);
						}
					}

					m('order')->setStocksAndCredits($o['id'], 2);
					m('order')->setDeductCredit2($o);
				}

				pdo_query('update ' . tablename('ewei_shop_order') . ' set status=-1,canceltime=' . time() . ' where id=' . $o['id']);
				m('finance')->closeOrder($o['ordersn']);
			}
			else {
				if ($o['status'] == 1 && $o['isverify'] == 1) {
					pdo_query('update ' . tablename('ewei_shop_order') . ' set status=-1,canceltime=' . time() . ' where id=' . $o['id']);
					m('finance')->closeOrder($o['ordersn']);
				}
			}
		}
	}
}

?>
