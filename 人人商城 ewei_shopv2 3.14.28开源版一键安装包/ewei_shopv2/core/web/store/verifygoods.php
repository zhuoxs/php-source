<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Verifygoods_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' vg.uniacid = :uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		$searchfield = strtolower(trim($_GPC['searchfield']));
		$keyword = trim($_GPC['keyword']);
		if (!empty($searchfield) && !empty($keyword)) {
			if ($searchfield == 'ordersn') {
				$condition .= ' and o.ordersn like :keyword';
			}
			else if ($searchfield == 'verifyid') {
				$condition .= ' and vg.id like :keyword';
			}
			else if ($searchfield == 'store') {
				$condition .= ' and s.storename like :keyword';
			}
			else {
				if ($searchfield == 'goodtitle') {
					$condition .= ' and g.title like :keyword';
				}
			}

			$params[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($_GPC['buydate']['start']) && !empty($_GPC['buydate']['end'])) {
			$buystarttime = strtotime($_GPC['buydate']['start']);
			$buyendtime = strtotime($_GPC['buydate']['end']);
			$condition .= ' AND o.paytime >= :buystarttime AND o.paytime <= :buyendtime ';
			$params[':buystarttime'] = $buystarttime;
			$params[':buyendtime'] = $buyendtime;
		}

		$sql = 'select vg.*,g.id as goodsid ,g.title,g.thumb,o.ordersn,o.paytime,s.storename,o.openid  from ' . tablename('ewei_shop_verifygoods') . '   vg
		 left join ' . tablename('ewei_shop_store') . ' s  on s.id = vg.storeid
		 left join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
		 left join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid
		 left join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		 where  1 and  ' . $condition . ' ORDER BY vg.id DESC ';
		$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$row) {
			$member = m('member')->getMember($row['openid']);
			$row['username'] = $member['realname'];
			$row['mobile'] = $member['mobile'];
			$verifygoodlogs = pdo_fetchall('select  *  from ' . tablename('ewei_shop_verifygoods_log') . '  where  verifygoodsid =:id  ', array(':id' => $row['id']));
			$verifynum = 0;

			foreach ($verifygoodlogs as $verifygoodlog) {
				$verifynum += intval($verifygoodlog['verifynum']);
			}

			$row['verifynum'] = $verifynum;
		}

		unset($row);
		$total = pdo_fetchcolumn('select  COUNT(*)   from ' . tablename('ewei_shop_verifygoods') . '   vg
		 left join ' . tablename('ewei_shop_store') . ' s  on s.id = vg.storeid
		 left join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
		 left join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid
		 left join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		  where  1 and  ' . $condition . ' ORDER BY vg.id  DESC ', $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		$uniacid = $_W['uniacid'];
		$item = pdo_fetch('select vg.*,g.title,g.subtitle,g.thumb,o.ordersn,o.paytime,o.openid  from ' . tablename('ewei_shop_verifygoods') . '   vg
		 inner join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
		 left join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid
		 inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		 where  vg.id =:id and vg.uniacid=:uniacid   limit 1', array(':id' => $id, ':uniacid' => $uniacid));

		if (empty($item)) {
			header('location: ' . webUrl('store/verifygoods'));
		}

		$member = m('member')->getMember($item['openid']);
		$username = $member['realname'];
		$mobile = $member['mobile'];
		$verifygoodlogs = pdo_fetchall('select vgl.*,s.storename,sa.salername  from ' . tablename('ewei_shop_verifygoods_log') . '   vgl
		left  join ' . tablename('ewei_shop_store') . ' s on s.id = vgl.storeid
		left  join ' . tablename('ewei_shop_saler') . ' sa on sa.id = vgl.salerid
          where  vgl.verifygoodsid =:id  ', array(':id' => $id));
		$verifynum = 0;

		foreach ($verifygoodlogs as $verifygoodlog) {
			$verifynum += intval($verifygoodlog['verifynum']);
		}

		if ($_W['ispost']) {
			$limittype = intval($_GPC['limittype']);
			$limitdate = strtotime($_GPC['limitdate']);
			$limitdays = intval($_GPC['limitdays']);

			if (empty($limitdays)) {
				$limitdays = 365;
			}

			$limitnum = intval($_GPC['limitnum']);
			if (empty($limitnum) || $verifynum < $limitnum) {
				$used = 0;
			}
			else {
				$used = 1;
			}

			$data = array('limittype' => $limittype, 'limitdate' => $limitdate, 'limitdays' => $limitdays, 'limitnum' => intval($_GPC['limitnum']), 'invalid' => intval($_GPC['invalid']), 'used' => $used);
			pdo_update('ewei_shop_verifygoods', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
			plog('store.edit', '编辑记次时商品核销信息 ID: ' . $id);
			com('wxcard')->updateusercardbyvarifygoodid($id);
			show_json(1, array('url' => referer()));
		}

		if (empty($item['limittype'])) {
			$limitdatestr = date('Y-m-d H:i:s', intval($item['starttime']) + $item['limitdays'] * 86400);
		}
		else {
			$limitdatestr = date('Y-m-d H:i:s', $item['limitdate']);
		}

		include $this->template();
	}

	public function invalid()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = intval($_GPC['type']);

		if (empty($id)) {
			header('location: ' . webUrl('store/verifygoods'));
		}

		$item = pdo_fetch('SELECT id FROM ' . tablename('ewei_shop_verifygoods') . ' WHERE id=' . $id . '  AND uniacid=' . $_W['uniacid']);

		if (!empty($item)) {
			pdo_update('ewei_shop_verifygoods', array('invalid' => $type), array('id' => $item['id']));
			com('wxcard')->updateusercardbyvarifygoodid($id);
		}

		show_json(1, array('url' => referer()));
	}

	public function verifygoodslog()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			header('location: ' . webUrl('store/verifygoods'));
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' vg.uniacid = :uniacid and vg.id =:id';
		$params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
		if (!empty($_GPC['verifydate']['start']) && !empty($_GPC['verifydate']['end'])) {
			$verifystarttime = strtotime($_GPC['verifydate']['start']);
			$verifyendtime = strtotime($_GPC['verifydate']['end']);
			$condition .= ' AND vgl.verifydate >= :verifystarttime AND vgl.verifydate <= :verifyendtime ';
			$params[':verifystarttime'] = $verifystarttime;
			$params[':verifyendtime'] = $verifyendtime;
		}

		$sql = 'select vgl.id,g.id as goodsid ,g.title,g.thumb,o.ordersn,vgl.verifydate,vgl.verifynum,o.paytime,s.storename,sa.salername,vgl.remarks,o.openid  from ' . tablename('ewei_shop_verifygoods_log') . '   vgl
		 left join ' . tablename('ewei_shop_verifygoods') . ' vg on vg.id = vgl.verifygoodsid
		 left join ' . tablename('ewei_shop_store') . ' s  on s.id = vgl.storeid
		 left join ' . tablename('ewei_shop_saler') . ' sa  on sa.id = vgl.salerid
		 left join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
		 left join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid
		 left join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		 where  1 and  ' . $condition . ' ORDER BY vgl.verifydate DESC ';
		$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$rom) {
			$member = m('member')->getMember($rom['openid']);
			$rom['username'] = $member['realname'];
			$rom['mobile'] = $member['mobile'];
		}

		unset($rom);
		$total = pdo_fetchcolumn('select  COUNT(*)   from ' . tablename('ewei_shop_verifygoods_log') . '   vgl
		 left join ' . tablename('ewei_shop_verifygoods') . ' vg on vg.id = vgl.verifygoodsid
		 left join ' . tablename('ewei_shop_store') . ' s  on s.id = vgl.storeid
		 left join ' . tablename('ewei_shop_saler') . ' sa  on sa.id = vgl.salerid
		 left join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
		 left join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid
		 left join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		  where  1 and  ' . $condition . ' ORDER BY vgl.verifydate DESC ', $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function verifygoodslogdelete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,verifygoodsid FROM ' . tablename('ewei_shop_verifygoods_log') . ' WHERE id=' . $id . ' AND uniacid=' . $_W['uniacid']);

		if (!empty($item)) {
			pdo_delete('ewei_shop_verifygoods_log', array('id' => $item['id']));
			pdo_update('ewei_shop_verifygoods', array('used' => 0), array('id' => $item['verifygoodsid']));
			com('wxcard')->updateusercardbyvarifygoodid($item['verifygoodsid']);
		}

		show_json(1, array('url' => referer()));
	}
}

?>
