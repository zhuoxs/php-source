<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Goods_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and og.uniacid=:uniacid and og.merchid=:merchid and o.status>=1';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['datetime'])) {
			$starttime = strtotime($_GPC['datetime']['start']);
			$endtime = strtotime($_GPC['datetime']['end']);

			if (!empty($starttime)) {
				$condition .= ' AND o.createtime >= :starttime';
				$params[':starttime'] = $starttime;
			}

			if (!empty($endtime)) {
				$condition .= ' AND o.createtime <= :endtime ';
				$params[':endtime'] = $endtime;
			}
		}

		if (!empty($_GPC['title'])) {
			$_GPC['title'] = trim($_GPC['title']);
			$condition .= ' and g.title like :title';
			$params[':title'] = '%' . $_GPC['title'] . '%';
		}

		$orderby = !isset($_GPC['orderby']) ? 'og.price' : (empty($_GPC['orderby']) ? 'og.price' : 'og.total');
		$sql = 'select og.price,og.total,o.createtime,o.ordersn,g.title,g.thumb,g.goodssn,op.goodssn as optiongoodssn from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id = og.goodsid ' . ' left join ' . tablename('ewei_shop_goods_option') . ' op on op.id = og.optionid ' . (' where 1 ' . $condition . ' order by ' . $orderby . ' desc ');

		if (empty($_GPC['export'])) {
			$sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$row) {
			if (!empty($row['optiongoodssn'])) {
				$row['goodssn'] = $row['optiongoodssn'];
			}
		}

		unset($row);
		$total = pdo_fetchcolumn('select  count(*) from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id = og.goodsid ' . (' where 1 ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);

		if ($_GPC['export'] == 1) {
			mca('statistics.goods.export');
			$list[] = array('data' => '商品总计', 'count' => $total);

			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
			}

			unset($row);
			m('excel')->export($list, array(
	'title'   => '商品销售报告-' . date('Y-m-d-H-i', time()),
	'columns' => array(
		array('title' => '订单号', 'field' => 'ordersn', 'width' => 24),
		array('title' => '商品名称', 'field' => 'title', 'width' => 12),
		array('title' => '商品编号', 'field' => 'goodssn', 'width' => 12),
		array('title' => '数量', 'field' => 'total', 'width' => 12),
		array('title' => '价格', 'field' => 'price', 'width' => 12),
		array('title' => '成交时间', 'field' => 'createtime', 'width' => 24)
		)
	));
			mplog('statistics.goods.export', '导出商品销售明细');
		}

		load()->func('tpl');
		include $this->template('statistics/goods');
	}
}

?>
