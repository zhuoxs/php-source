<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Goodsgroup_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' uniacid = :uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= ' and name like :keyword';
			$params[':keyword'] = '%' . $keyword . '%';
		}

		$sql = 'SELECT * FROM ' . tablename('ewei_shop_newstore_goodsgroup') . ' WHERE 1 and ' . $condition . ' ORDER BY id DESC ';
		$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$row) {
			$goodscount = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_newstore_goodsgroup_goods') . ' WHERE goodsgroupid = :goodsgroupid  and uniacid = :uniacid', array(':uniacid' => $_W['uniacid'], ':goodsgroupid' => $row['id']));
			$row['goodscount'] = $goodscount;
		}

		unset($row);
		$total = pdo_fetchcolumn('SELECT count(*)  FROM ' . tablename('ewei_shop_newstore_goodsgroup') . ' WHERE 1 and ' . $condition . ' ORDER BY id DESC ', $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$detail = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_newstore_goodsgroup') . ' WHERE uniacid = :uniacid AND id = :id', array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if ($_W['ispost']) {
			$data = array();
			$data['name'] = $_GPC['name'];
			$data['uniacid'] = $_W['uniacid'];

			if (empty($id)) {
				pdo_insert('ewei_shop_newstore_goodsgroup', $data);
			}
			else {
				pdo_update('ewei_shop_newstore_goodsgroup', $data, array('id' => $id));
			}

			show_json(1, array('url' => webUrl('store/goodsgroup')));
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_newstore_goodsgroup') . (' WHERE id in( ' . $id . ' )  AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_newstore_goodsgroup', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('ewei_shop_newstore_goodsgroup_goods', array('goodsgroupid' => $item['id'], 'uniacid' => $_W['uniacid']));
		}

		show_json(1, array('url' => referer()));
	}

	public function plusgoods()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (!cv('member.card')) {
			$this->message('你没有相应的权限查看');
		}

		if ($_W['ispost']) {
			$goodsids = $_GPC['goodsid'];
			$params = array();
			$params[':uniacid'] = $_W['uniacid'];
			$ids = implode(',', $goodsids);
			$list = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid=:uniacid and `type` in (1,5,30)  and deleted = 0 and merchid =0  and id in (' . $ids . ')', $params);

			foreach ($list as $goods) {
				$count = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_newstore_goodsgroup_goods') . ' WHERE uniacid=:uniacid   and goodsgroupid=:goodsgroupid and goodsid =:goodsid', array(':uniacid' => $_W['uniacid'], ':goodsgroupid' => $id, ':goodsid' => $goods['id']));

				if (empty($count)) {
					$data = array('uniacid' => $_W['uniacid'], 'goodsgroupid' => $id, 'goodsid' => $goods['id']);
					pdo_insert('ewei_shop_newstore_goodsgroup_goods', $data);
				}
			}

			show_json(1, array('url' => referer()));
		}

		include $this->template();
	}

	public function deletegoods()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_newstore_goodsgroup_goods') . (' WHERE id in( ' . $id . ' )  AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_newstore_goodsgroup_goods', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
		}

		show_json(1, array('url' => referer()));
	}

	public function goods()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' a.goodsgroupid = :goodsgroupid AND a.uniacid = :uniacid';
		$params = array(':uniacid' => $_W['uniacid'], ':goodsgroupid' => $id);
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= ' and b.title like :keyword';
			$params[':keyword'] = '%' . $keyword . '%';
		}

		$sql = 'SELECT a.* ,b.title,b.thumb,b.hasoption,b.marketprice FROM ' . tablename('ewei_shop_newstore_goodsgroup_goods') . '
        a inner join ' . tablename('ewei_shop_goods') . ' b ON a.goodsid = b.id  WHERE 1 and ' . $condition . ' ORDER BY a.id DESC ';
		$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT count(1)  FROM ' . tablename('ewei_shop_newstore_goodsgroup_goods') . '
        a inner join ' . tablename('ewei_shop_goods') . ' b ON a.goodsid = b.id  WHERE 1 and ' . $condition . ' ORDER BY a.id DESC ', $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}
}

?>
