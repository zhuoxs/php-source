<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Goods_rank_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$params = array();
		$condition = ' and og.uniacid=' . $_W['uniacid'] . ' and og.merchid=' . $_W['merchid'];
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['datetime'])) {
			$starttime = strtotime($_GPC['datetime']['start']);
			$endtime = strtotime($_GPC['datetime']['end']);

			if (!empty($starttime)) {
				$condition .= ' AND o.createtime >= ' . $starttime;
			}

			if (!empty($endtime)) {
				$condition .= ' AND o.createtime <= ' . $endtime . ' ';
			}
		}

		$condition1 = ' and g.uniacid=:uniacid and g.merchid=:merchid';
		$params1 = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);

		if (!empty($_GPC['title'])) {
			$_GPC['title'] = trim($_GPC['title']);
			$condition1 .= ' and g.title like :title';
			$params1[':title'] = '%' . $_GPC['title'] . '%';
		}

		$orderby = !isset($_GPC['orderby']) ? 'money' : (empty($_GPC['orderby']) ? 'money' : 'count');
		$sql = 'SELECT g.id,g.title,g.thumb,' . '(select ifnull(sum(og.price),0) from  ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_order') . (' o on og.orderid=o.id  where o.status>=1 and og.goodsid=g.id ' . $condition . ')  as money,') . '(select ifnull(sum(og.total),0) from  ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_order') . (' o on og.orderid=o.id  where o.status>=1 and og.goodsid=g.id ' . $condition . ') as count  ') . 'from ' . tablename('ewei_shop_goods') . ' g  ' . ('where 1 ' . $condition1 . '  order by ' . $orderby . ' desc ');

		if (empty($_GPC['export'])) {
			$sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params1);
		$total = pdo_fetchcolumn('select  count(*) from ' . tablename('ewei_shop_goods') . ' g ' . (' where 1 ' . $condition1 . ' '), $params1);
		$pager = pagination2($total, $pindex, $psize);

		if ($_GPC['export'] == 1) {
			mca('statistics.goods_rank.export');
			$list[] = array('data' => '商品销售排行', 'count' => $total);

			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
			}

			unset($row);
			m('excel')->export($list, array(
	'title'   => '商品销售报告-' . date('Y-m-d-H-i', time()),
	'columns' => array(
		array('title' => '商品名称', 'field' => 'title', 'width' => 36),
		array('title' => '数量', 'field' => 'count', 'width' => 12),
		array('title' => '价格', 'field' => 'money', 'width' => 12)
		)
	));
			mplog('statistics.goods_rank.export', '导出商品销售排行');
		}

		load()->func('tpl');
		include $this->template('statistics/goods_rank');
	}
}

?>
