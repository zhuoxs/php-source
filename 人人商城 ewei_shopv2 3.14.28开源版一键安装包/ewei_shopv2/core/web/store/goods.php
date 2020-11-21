<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Goods_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$sql = 'SELECT *  FROM ' . tablename('ewei_shop_newstore_goodsgroup') . ' WHERE  uniacid=:uniacid  ORDER BY id DESC ';
		$grouplist = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$id = intval($_GPC['id']);
		$condition = '  ng.storeid = :storeid AND ng.uniacid = :uniacid';
		$params = array(':uniacid' => $_W['uniacid'], ':storeid' => $id);
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= ' and g.title like :keyword';
			$params[':keyword'] = '%' . $keyword . '%';
		}

		$goodsgroupid = intval($_GPC['goodsgroupid']);

		if (!empty($goodsgroupid)) {
			$condition .= ' and EXISTS(select id from ' . tablename('ewei_shop_newstore_goodsgroup_goods') . ' gg where  gg.goodsgroupid=:goodsgroupid and gg.goodsid = ng.goodsid) ';
			$params[':goodsgroupid'] = $goodsgroupid;
		}

		$sql = 'SELECT ng.*,g.title,g.thumb,g.hasoption,g.type  FROM ' . tablename('ewei_shop_newstore_goods') . '  ng
        INNER JOIN ' . tablename('ewei_shop_goods') . '  g ON ng.goodsid = g.id
        WHERE   1 and ' . $condition . ' ORDER BY ng.id DESC ';
		$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT count(*)  FROM ' . tablename('ewei_shop_newstore_goods') . '  ng
        INNER JOIN ' . tablename('ewei_shop_goods') . '  g ON ng.goodsid = g.id
        WHERE   1 and ' . $condition . ' ORDER BY ng.id DESC ', $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
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
			$list = pdo_fetchall('SELECT id,marketprice,total,dowpayment FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid=:uniacid and deleted = 0 and merchid =0 and `type` in (1,5,30) and id in (' . $ids . ')', $params);

			foreach ($list as $goods) {
				$count = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_newstore_goods') . ' WHERE uniacid=:uniacid and storeid=:storeid   and goodsid =:goodsid', array(':uniacid' => $_W['uniacid'], ':storeid' => $id, ':goodsid' => $goods['id']));

				if (empty($count)) {
					$data = array('uniacid' => $_W['uniacid'], 'storeid' => $id, 'goodsid' => $goods['id'], 'sdowpayment' => $goods['dowpayment'], 'smarketprice' => $goods['marketprice'], 'sminprice' => $goods['marketprice'], 'smaxprice' => $goods['marketprice'], 'stotal' => $goods['total'], 'createtime' => time(), 'deleted' => 0);
					pdo_insert('ewei_shop_newstore_goods', $data);
					$ngoods = pdo_insertid();
					pdo_delete('ewei_shop_newstore_goods_option', array('goodsid' => $goods['id'], 'storeid' => $id), 'AND');
					$sql = 'insert into ims_ewei_shop_newstore_goods_option(uniacid,storeid,goodsid,ngoodsid,marketprice,stock,deleted,optionid) select  :uniacid,:storeid,goodsid,:ngoods,marketprice,stock,0,id from ims_ewei_shop_goods_option where goodsid =:goodsid';
					pdo_query($sql, array(':uniacid' => $_W['uniacid'], ':storeid' => $id, ':ngoods' => $ngoods, ':goodsid' => $goods['id']));
				}
			}

			show_json(1, array('url' => referer()));
		}

		include $this->template();
	}

	public function plusgoodsgroup()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (!cv('member.card')) {
			$this->message('你没有相应的权限查看');
		}

		$sql = 'SELECT *  FROM ' . tablename('ewei_shop_newstore_goodsgroup') . ' WHERE  uniacid=:uniacid  ORDER BY id DESC ';
		$list = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			$goodsgroupid = $_GPC['goodsgroupid'];
			$params = array();
			$params[':uniacid'] = $_W['uniacid'];
			$params[':goodsgroupid'] = $goodsgroupid;
			$list = pdo_fetchall('SELECT g.id,g.marketprice,g.total,g.dowpayment FROM ' . tablename('ewei_shop_goods') . ' g
            inner join ' . tablename('ewei_shop_newstore_goodsgroup_goods') . ' gg on g.id=gg.goodsid
            WHERE g.uniacid=:uniacid and g.deleted = 0 and g.merchid =0  and g.`type` in (1,5,30)  and gg.goodsgroupid=:goodsgroupid', $params);

			foreach ($list as $goods) {
				$count = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_newstore_goods') . ' WHERE uniacid=:uniacid    and storeid=:storeid and goodsid =:goodsid', array(':uniacid' => $_W['uniacid'], ':storeid' => $id, ':goodsid' => $goods['id']));

				if (empty($count)) {
					$data = array('uniacid' => $_W['uniacid'], 'storeid' => $id, 'goodsid' => $goods['id'], 'sdowpayment' => $goods['dowpayment'], 'smarketprice' => $goods['marketprice'], 'sminprice' => $goods['marketprice'], 'smaxprice' => $goods['marketprice'], 'stotal' => $goods['total'], 'createtime' => time(), 'deleted' => 0);
					pdo_insert('ewei_shop_newstore_goods', $data);
					$ngoods = pdo_insertid();
					pdo_delete('ewei_shop_newstore_goods_option', array('goodsid' => $goods['id'], 'storeid' => $id), 'AND');
					$sql = 'insert into ims_ewei_shop_newstore_goods_option(uniacid,storeid,goodsid,ngoodsid,marketprice,stock,deleted,optionid) select  :uniacid,:storeid,goodsid,:ngoods,marketprice,0,0,id from ims_ewei_shop_goods_option where goodsid =:goodsid';
					pdo_query($sql, array(':uniacid' => $_W['uniacid'], ':storeid' => $id, ':ngoods' => $ngoods, ':goodsid' => $goods['id']));
				}
			}

			show_json(1, array('url' => referer()));
		}

		include $this->template();
	}

	public function goods()
	{
		global $_W;
		global $_GPC;
		$type = trim($_GPC['type']);
		$title = '';
		$page = intval($_GPC['page']) ? intval($_GPC['page']) : 1;
		$pageprev = $page - 1;
		$pagenext = $page + 1;
		$psize = 10;
		$params = array(':title' => '%' . $title . '%', ':uniacid' => $_W['uniacid'], ':status' => '1');
		$totalsql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_goods') . ' WHERE `uniacid`= :uniacid and `status`=:status and `deleted` = 0 AND merchid = 0 AND title LIKE :title ';
		$searchsql = 'SELECT id,title,productprice,marketprice,thumb,sales,unit,minprice,hasoption,`total`,`status`,`deleted` FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid= :uniacid and `status`=:status and `deleted`=0 AND merchid=0 AND title LIKE :title ORDER BY `status` DESC, `displayorder` DESC,`id` DESC LIMIT ' . ($page - 1) * $psize . ',' . $psize;
		$total = pdo_fetchcolumn($totalsql, $params);
		$pagelast = intval(($total - 1) / $psize) + 1;
		$list = pdo_fetchall($searchsql, $params);
		$spcSql = 'SELECT * FROM ' . tablename('ewei_shop_goods_option') . ' WHERE uniacid= :uniacid AND  goodsid= :goodsid';

		foreach ($list as $key => $value) {
			if ($value['hasoption']) {
				$spcwhere = array(':uniacid' => $_W['uniacid'], ':goodsid' => $value['id']);
				$spclist = pdo_fetchall($spcSql, $spcwhere);

				if (!empty($spclist)) {
					$list[$key]['spc'] = $spclist;
				}
				else {
					$list[$key]['spc'] = '';
				}
			}
		}

		include $this->template();
	}

	public function goodsoption()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if ($_W['ispost']) {
			$ids = $_GPC['ids'];
			$price = $_GPC['price'];
			$total = $_GPC['total'];

			if (!is_array($ids)) {
				$ids = array($ids);
			}

			$conditon = '';
			pdo_update('ewei_shop_newstore_goods_option', array('deleted' => 1), array('storeid' => $id, 'uniacid' => $_W['uniacid']));
			$list = pdo_fetchall('SELECT ng.id  FROM   ' . tablename('ewei_shop_newstore_goods_option') . ' ng inner join
            ' . tablename('ewei_shop_goods_option') . ' g on ng.optionid = g.id   where ng.ngoodsid=:id AND ng.uniacid = :uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$stotal = 0;

			if (is_array($price)) {
				if (is_array($price)) {
					$max = array_search(max($price), $price);
					$min = array_search(min($price), $price);
					pdo_update('ewei_shop_newstore_goods', array('smaxprice' => $price[$max], 'sminprice' => $price[$min]), array('id' => $id, 'uniacid' => $_W['uniacid']));
				}

				foreach ($list as $v) {
					$deleted = 1;

					if (in_array($v['id'], $ids)) {
						$deleted = 0;
						$stotal += intval($total[$v['id']]);
					}

					pdo_update('ewei_shop_newstore_goods_option', array('marketprice' => $price[$v['id']], 'deleted' => $deleted, 'stock' => $total[$v['id']]), array('id' => $v['id'], 'uniacid' => $_W['uniacid']));
				}
			}

			pdo_update('ewei_shop_newstore_goods', array('stotal' => $stotal), array('id' => $id, 'uniacid' => $_W['uniacid']));
			show_json(1);
		}
		else {
			$data = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_newstore_goods_option') . ' WHERE ngoodsid = :id AND uniacid = :uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$option = pdo_fetchall('SELECT ng.id,ng.deleted,ng.marketprice,ng.stock ,g.title  FROM   ' . tablename('ewei_shop_newstore_goods_option') . ' ng inner join
            ' . tablename('ewei_shop_goods_option') . ' g on ng.optionid = g.id   where ng.ngoodsid=:id AND ng.uniacid = :uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$spec = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_goods_spec') . (' WHERE goodsid = \'' . $data['goodsid'] . '\' AND uniacid = :uniacid'), array(':uniacid' => $_W['uniacid']));
			include $this->template();
		}
	}

	public function setstatus()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$status = empty($_GPC['status']) ? 1 : 0;

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_newstore_goods') . (' WHERE id in( ' . $id . ' )  AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_newstore_goods', array('gstatus' => $status), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
		}

		show_json(1, array('url' => referer()));
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_newstore_goods') . (' WHERE id in( ' . $id . ' )  AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_newstore_goods', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('ewei_shop_newstore_goods_option', array('ngoodsid' => $item['id']));
		}

		show_json(1, array('url' => referer()));
	}

	public function setprice()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$price = floatval($_GPC['value']);
		pdo_update('ewei_shop_newstore_goods', array('smarketprice' => $price), array('id' => $id, 'uniacid' => $_W['uniacid']));
		show_json(1);
	}

	public function settotal()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$total = floatval($_GPC['value']);
		pdo_update('ewei_shop_newstore_goods', array('stotal' => $total), array('id' => $id, 'uniacid' => $_W['uniacid']));
		show_json(1);
	}

	public function setdisplayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$total = floatval($_GPC['value']);
		pdo_update('ewei_shop_newstore_goods', array('sdisplayorder' => $total), array('id' => $id, 'uniacid' => $_W['uniacid']));
		show_json(1);
	}

	public function staff()
	{
		global $_W;
		global $_GPC;
		include $this->template();
	}
}

?>
