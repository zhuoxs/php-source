<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Order_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and o.uniacid=:uniacid and o.merchid>0 and o.status>=1';
		$params = array(':uniacid' => $_W['uniacid']);
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['datetime']['start']) && !empty($_GPC['datetime']['end'])) {
			$starttime = strtotime($_GPC['datetime']['start']);
			$endtime = strtotime($_GPC['datetime']['end']);
			$condition .= ' AND o.createtime >= :starttime AND o.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		$searchfield = strtolower(trim($_GPC['searchfield']));
		$_GPC['keyword'] = trim($_GPC['keyword']);
		if (!empty($searchfield) && !empty($_GPC['keyword'])) {
			if ($searchfield == 'ordersn') {
				$condition .= ' and o.ordersn like :keyword';
			}
			else if ($searchfield == 'member') {
				$condition .= ' and ( m.realname like :keyword or m.mobile like :keyword)';
			}
			else if ($searchfield == 'address') {
				$condition .= ' and a.realname like :keyword';
			}
			else {
				if ($searchfield == 'merchname') {
					$condition .= ' and u.merchname like :keyword';
				}
			}

			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$condition .= ' and o.deleted = 0 group by o.id';
		$sql = 'select o.*, a.realname as addressname,m.realname,u.merchname from ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_member') . ' m on o.openid = m.openid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id = o.addressid ' . ' left join ' . tablename('ewei_shop_merch_user') . ' u on u.id = o.merchid ' . (' where 1 ' . $condition . ' ');

		if (empty($_GPC['export'])) {
			$sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$row) {
			$row['ordersn'] = $row['ordersn'] . ' ';
			$row['goods'] = pdo_fetchall('SELECT g.thumb,og.price,og.total,og.realprice,g.title,og.optionname from ' . tablename('ewei_shop_order_goods') . ' og' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid  ' . ' where og.uniacid = :uniacid and og.orderid=:orderid order by og.createtime  desc ', array(':uniacid' => $_W['uniacid'], ':orderid' => $row['id']));
			$totalmoney += $row['price'];
		}

		unset($row);
		$total = pdo_fetchall('select o.id from ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_member') . ' m on o.openid = m.openid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id = o.addressid ' . ' left join ' . tablename('ewei_shop_merch_user') . ' u on u.id = o.merchid ' . (' where 1 ' . $condition), $params);
		$totalcount = $total = count($total);
		$pager = pagination2($total, $pindex, $psize);

		if ($_GPC['export'] == 1) {
			ca('statistics.order.export');

			foreach ($list as &$row) {
				if ($row['paytype'] == 1) {
					$row['paytype'] = '余额支付';
				}
				else if ($row['paytype'] == 11) {
					$row['paytype'] = '后台付款';
				}
				else if ($row['paytype'] == 21) {
					$row['paytype'] = '微信支付';
				}
				else if ($row['paytype'] == 22) {
					$row['paytype'] = '支付宝支付';
				}
				else if ($row['paytype'] == 23) {
					$row['paytype'] = '银联支付';
				}
				else {
					if ($row['paytype'] == 3) {
						$row['paytype'] = '货到付款';
					}
				}

				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
			}

			unset($row);
			$list[] = array('ordersn' => '订单总计', 'price' => $totalcount);
			$list[] = array('ordersn' => '金额总计', 'price' => $totalmoney);
			m('excel')->export($list, array(
	'title'   => '订单报告-' . date('Y-m-d-H-i', time()),
	'columns' => array(
		array('title' => '订单号', 'field' => 'ordersn', 'width' => 24),
		array('title' => '总金额', 'field' => 'price', 'width' => 12),
		array('title' => '商品金额', 'field' => 'goodsprice', 'width' => 12),
		array('title' => '运费', 'field' => 'dispatchprice', 'width' => 12),
		array('title' => '付款方式', 'field' => 'paytype', 'width' => 12),
		array('title' => '会员名', 'field' => 'realname', 'width' => 12),
		array('title' => '收货人', 'field' => 'addressname', 'width' => 12),
		array('title' => '下单时间', 'field' => 'createtime', 'width' => 24)
		)
	));
			plog('statistics.order.export', '导出订单统计');
		}

		load()->func('tpl');
		include $this->template();
	}
}

?>
