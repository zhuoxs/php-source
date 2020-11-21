<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Goods_trans_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$condition = ' and og.uniacid=' . $_W['uniacid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$params = array();
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['datetime'])) {
			$starttime = strtotime($_GPC['datetime']['start']);
			$endtime = strtotime($_GPC['datetime']['end']);
			$condition .= ' AND o.createtime >=' . $starttime . ' AND o.createtime <= ' . $endtime . ' ';
		}

		$condition1 = ' and g.uniacid=:uniacid';
		$params1 = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['title'])) {
			$_GPC['title'] = trim($_GPC['title']);
			$condition1 .= ' and g.title like :title';
			$params1[':title'] = '%' . $_GPC['title'] . '%';
		}

		$orderby = !isset($_GPC['orderby']) ? 'desc' : (empty($_GPC['orderby']) ? 'desc' : 'asc');
		$sql = 'SELECT g.id,g.title,g.thumb,g.viewcount,' . '(select sum(og.total) from  ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_order') . (' o on og.orderid=o.id  where o.status>=1 and og.goodsid=g.id ' . $condition . ')  as buycount') . ' from ' . tablename('ewei_shop_goods') . ' g  ' . ('where 1 ' . $condition1 . ' order by buycount/g.viewcount ' . $orderby . '  ');

		if (empty($_GPC['export'])) {
			$sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params1);

		foreach ($list as &$row) {
			$row['percent'] = round($row['buycount'] / (empty($row['viewcount']) ? 1 : $row['viewcount']) * 100, 2);
		}

		unset($row);
		$total = pdo_fetchcolumn('select  count(*) from ' . tablename('ewei_shop_goods') . ' g ' . (' where 1 ' . $condition1 . ' '), $params1);
		$pager = pagination2($total, $pindex, $psize);

		if ($_GPC['export'] == 1) {
			ca('statistics.goods_trans.export');
			m('excel')->export($list, array(
	'title'   => '商品转化率报告-' . date('Y-m-d-H-i', time()),
	'columns' => array(
		array('title' => '商品名称', 'field' => 'title', 'width' => 24),
		array('title' => '浏览量', 'field' => 'viewcount', 'width' => 12),
		array('title' => '购买数', 'field' => 'buycount', 'width' => 12),
		array('title' => '转化率(%)', 'field' => 'percent', 'width' => 12)
		)
	));
			plog('statistics.goods_trans.export', '导出商品转化率报告');
		}

		load()->func('tpl');
		include $this->template('statistics/goods_trans');
	}
}

?>
