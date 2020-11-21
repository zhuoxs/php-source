<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Indexremove_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$orderid = trim($_GPC['data']['orderid']);
			$recharge = trim($_GPC['data']['recharge']);
			$params = array('uniacid' => $_W['uniacid']);

			if (!empty($orderid)) {
				$params['ordersn'] = $orderid;
				$order = pdo_get('ewei_shop_order', $params);

				if (empty($order)) {
					show_json(0, '订单不存在');
				}

				$param = array(':uniacid' => $_W['uniacid'], ':orderid' => $order['id']);
				$condition = 'og.uniacid=:uniacid and og.orderid=:orderid';
				$goods = pdo_fetchall('select og.goodsid,og.total,g.totalcnf,og.optionid,g.sales,g.salesreal,g.type from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . (' where ' . $condition), $param);
				pdo_delete('ewei_shop_order', array('uniacid' => $_W['uniacid'], 'id' => $order['id']));
				pdo_delete('ewei_shop_order_goods', array('uniacid' => $_W['uniacid'], 'orderid' => $order['id']));
				pdo_delete('ewei_shop_order_comment', array('uniacid' => $_W['uniacid'], 'orderid' => $order['id']));
				pdo_delete('ewei_shop_order_refund', array('uniacid' => $_W['uniacid'], 'orderid' => $order['id']));

				if (!empty($goods)) {
					foreach ($goods as $g) {
						$salesreal = pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' where og.goodsid=:goodsid and o.status>=1 and o.uniacid=:uniacid limit 1', array(':goodsid' => $g['goodsid'], ':uniacid' => $_W['uniacid']));
						pdo_update('ewei_shop_goods', array('salesreal' => $salesreal), array('id' => $g['goodsid']));
					}
				}

				show_json(1);
			}

			if (!empty($recharge)) {
				$params['logno'] = $recharge;
				pdo_delete('ewei_shop_member_log', $params);
				show_json(1);
			}
		}

		include $this->template();
	}
}

?>
