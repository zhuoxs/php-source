<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class List_EweiShopV2Page extends AppMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$cateid = intval($_GPC['category']);
		$list = array();
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and uniacid = :uniacid and status=1 and deleted=0';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($cateid)) {
			$condition .= ' and category = ' . $cateid;
		}

		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= ' AND title like \'%' . $keyword . '%\' ';
		}

		$sql = 'SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_goods') . (' where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);

		if (!empty($total)) {
			$sql = 'SELECT id,title,thumb,price,groupnum,groupsprice,category,isindex,goodsnum,units,sales,description,stock FROM ' . tablename('ewei_shop_groups_goods') . '
						where 1 ' . $condition . ' ORDER BY displayorder DESC,id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
			$list = set_medias($list, 'thumb');
		}

		return app_json(array('list' => $list, 'pagesize' => $psize, 'pindex' => $pindex, 'total' => $total));
	}
}

?>
