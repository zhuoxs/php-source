<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Orders_EweiShopV2Page extends PluginMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		load()->model('mc');
		$uid = mc_openid2uid($openid);

		if (empty($uid)) {
			mc_oauth_userinfo($openid);
		}

		$this->model->groupsShare();
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$data = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_set') . ' WHERE uniacid = :uniacid ', array(':uniacid' => $_W['uniacid']));
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['orderid']);
		$teamid = intval($_GPC['teamid']);
		$condition = ' and openid=:openid  and uniacid=:uniacid and id = :orderid and teamid = :teamid ';
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . '
				where openid=:openid  and uniacid=:uniacid and id = :orderid and teamid = :teamid order by createtime desc ', array(':uniacid' => $uniacid, ':openid' => $openid, ':orderid' => $orderid, ':teamid' => $teamid));
		$diyform_plugin = p('diyform');
		if (!empty($order['diyformid']) && $diyform_plugin) {
			$order['diyformdata'] = iunserializer($order['diyformdata']);
			$order['diyformfields'] = iunserializer($order['diyformfields']);
		}

		if ($order['refundid'] != 0) {
			$refund = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_groups_order_refund') . ' WHERE orderid = :orderid and uniacid=:uniacid order by id desc', array(':orderid' => $order['id'], ':uniacid' => $_W['uniacid']));
		}

		if ($order['more_spec'] == 1) {
			$option = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order_goods') . '
				where uniacid=:uniacid and groups_order_id = :orderid', array(':uniacid' => $uniacid, ':orderid' => $orderid));
		}

		if ($order['is_ladder'] == 1) {
			$ladder = pdo_fetch('select * from ' . tablename('ewei_shop_groups_ladder') . '
				where uniacid=:uniacid and id = :id', array(':uniacid' => $uniacid, ':id' => $order['ladder_id']));
		}

		$good = pdo_fetch('select * from ' . tablename('ewei_shop_groups_goods') . '
					where id = :id and status = :status and uniacid = :uniacid and deleted = 0 order by displayorder desc', array(':id' => $order['goodid'], ':uniacid' => $uniacid, ':status' => 1));

		if (!empty($order['isverify'])) {
			$storeids = array();
			$merchid = 0;

			if (!empty($good['storeids'])) {
				$merchid = $good['merchid'];
				$storeids = array_merge(explode(',', $good['storeids']), $storeids);
			}

			if (empty($storeids)) {
				if (0 < $merchid) {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where  uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
				}
				else {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
				}
			}
			else if (0 < $merchid) {
				$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
			}
			else {
				$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
			}

			$verifytotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_verify') . ' where orderid = :orderid and openid = :openid and uniacid = :uniacid and verifycode = :verifycode ', array(':orderid' => $order['id'], ':openid' => $order['openid'], ':uniacid' => $order['uniacid'], ':verifycode' => $order['verifycode']));

			if ($order['verifytype'] == 0) {
				$verify = pdo_fetch('select isverify from ' . tablename('ewei_shop_groups_verify') . ' where orderid = :orderid and openid = :openid and uniacid = :uniacid and verifycode = :verifycode ', array(':orderid' => $order['id'], ':openid' => $order['openid'], ':uniacid' => $order['uniacid'], ':verifycode' => $order['verifycode']));
			}

			$verifynum = $order['verifynum'] - $verifytotal;

			if ($verifynum < 0) {
				$verifynum = 0;
			}
		}
		else {
			$address = false;

			if (!empty($order['addressid'])) {
				$address = iunserializer($order['address']);

				if (!is_array($address)) {
					$address = pdo_fetch('select * from  ' . tablename('ewei_shop_member_address') . ' where id=:id limit 1', array(':id' => $order['addressid']));
				}
			}
		}

		$carrier = @iunserializer($order['carrier']);
		if (!is_array($carrier) || empty($carrier)) {
			$carrier = false;
		}

		$this->model->groupsShare();
		include $this->template();
	}

	public function express()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['id']);

		if (empty($orderid)) {
			header('location: ' . mobileUrl('groups/orders'));
			exit();
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

		if (empty($order)) {
			header('location: ' . mobileUrl('groups/order'));
			exit();
		}

		if (empty($order['addressid'])) {
			$this->message('订单非快递单，无法查看物流信息!');
		}

		if ($order['status'] < 2) {
			$this->message('订单未发货，无法查看物流信息!');
		}

		$goods = pdo_fetch('select *  from ' . tablename('ewei_shop_groups_goods') . '  where id=:id and uniacid=:uniacid ', array(':uniacid' => $uniacid, ':id' => $order['goodid']));
		$expresslist = m('util')->getExpressList($order['express'], $order['expresssn']);
		include $this->template();
	}

	/**
     * 取消订单
     * @global type $_W
     * @global type $_GPC
     */
	public function cancel()
	{
		global $_W;
		global $_GPC;

		try {
			$orderid = intval($_GPC['id']);
			$order = pdo_fetch('select id,orderno,openid,status,credit,teamid,groupnum,creditmoney,price,freight,pay_type,discount,success from ' . tablename('ewei_shop_groups_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
			$total = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . '  where teamid = :teamid  ', array(':teamid' => $order['teamid']));

			if (empty($order)) {
				show_json(0, '订单未找到');
			}

			if ($order['status'] != 0) {
				show_json(0, '订单不能取消');
			}

			pdo_update('ewei_shop_groups_order', array('status' => -1, 'canceltime' => time()), array('id' => $order['id'], 'uniacid' => $_W['uniacid']));
			p('groups')->sendTeamMessage($orderid);
			show_json(1);
		}
		catch (Exception $e) {
			throw new $e->getMessage();
		}
	}

	/**
     * 删除订单
     * @global type $_W
     * @global type $_GPC
     */
	public function delete()
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC['id']);
		$order = pdo_fetch('select id,status from ' . tablename('ewei_shop_groups_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if (empty($order)) {
			show_json(0, '订单未找到!');
		}

		if ($order['status'] != 3 && $order['status'] != -1) {
			show_json(0, '无法删除');
		}

		pdo_update('ewei_shop_groups_order', array('deleted' => 1), array('id' => $order['id'], 'uniacid' => $_W['uniacid']));
		show_json(1);
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$list = array();
		$openid = $_W['openid'];
		load()->model('mc');
		$uid = mc_openid2uid($openid);

		if (empty($uid)) {
			mc_oauth_userinfo($openid);
		}

		$uniacid = $_W['uniacid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 5;
		$status = $_GPC['status'];

		if ($status == 0) {
			$tab_all = true;
			$condition = ' and o.openid=:openid  and o.uniacid=:uniacid and o.deleted = :deleted ';
			$params = array(':uniacid' => $uniacid, ':openid' => $openid, ':deleted' => 0);
		}
		else {
			$condition = ' and o.openid=:openid  and o.uniacid=:uniacid and o.status = :status and o.deleted = :deleted  ';
			$params = array(':uniacid' => $uniacid, ':openid' => $openid, ':deleted' => 0);

			if ($status == 1) {
				$tab0 = true;
				$params[':status'] = 0;
			}
			else if ($status == 2) {
				$tab1 = true;
				$condition = ' and o.openid=:openid  and o.uniacid=:uniacid and o.deleted = :deleted and o.status = :status and (o.is_team = 0 or o.success = 1) ';
				$params[':status'] = 1;
			}
			else if ($status == 3) {
				$tab2 = true;
				$condition = ' and o.openid=:openid  and o.uniacid=:uniacid and o.deleted = :deleted and ( o.status = :status  or( o.status = :status2 and o.isverify = 1)) ';
				$params[':status'] = 2;
				$params[':status2'] = 1;
			}
			else {
				if ($status == 4) {
					$tab3 = true;
					$params[':status'] = 3;
				}
			}
		}

		$orders = pdo_fetchall('select o.id,o.orderno,o.createtime,o.price,o.more_spec,o.is_ladder,o.freight,o.ladder_id,o.specs,o.creditmoney,o.goodid,o.teamid,o.status,o.is_team,o.success,o.teamid,o.openid,
				g.title,g.thumb,g.units,g.goodsnum,g.groupsprice,g.singleprice,o.verifynum,o.verifytype,o.isverify,o.uniacid,o.verifycode,g.thumb_url,l.ladder_price,l.ladder_num,p.option_name
				from ' . tablename('ewei_shop_groups_order') . ' as o
				left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
				left join ' . tablename('ewei_shop_groups_ladder') . ' as l on l.id = o.ladder_id
				left join ' . tablename('ewei_shop_groups_order_goods') . (' as p on p.groups_order_id = o.id
				where 1 ' . $condition . ' order by o.createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . (' as o where 1 ' . $condition), $params);

		foreach ($orders as $key => $value) {
			$verifytotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_verify') . ' where orderid = :orderid and openid = :openid and uniacid = :uniacid and verifycode = :verifycode ', array(':orderid' => $value['id'], ':openid' => $value['openid'], ':uniacid' => $value['uniacid'], ':verifycode' => $value['verifycode']));

			if (!$verifytotal) {
				$verifytotal = 0;
			}

			$orders[$key]['vnum'] = $value['verifynum'] - intval($verifytotal);
			$orders[$key]['amount'] = $value['price'] + $value['freight'] - $value['creditmoney'];
			$statuscss = 'text-cancel';

			switch ($value['status']) {
			case '-1':
				$status = '已取消';
				break;

			case '0':
				$status = '待付款';
				$statuscss = 'text-cancel';
				break;

			case '1':
				if ($value['is_team'] == 0 || $value['success'] == 1) {
					$status = '待发货';
					$statuscss = 'text-warning';
				}
				else if ($value['success'] == -1) {
					$status = '已过期';
					$statuscss = 'text-warning';
				}
				else {
					$status = '已付款';
					$statuscss = 'text-success';
				}

				break;

			case '2':
				$status = '待收货';
				$statuscss = 'text-danger';
				break;

			case '3':
				$status = '已完成';
				$statuscss = 'text-success';
				break;
			}

			$orders[$key]['statusstr'] = $status;
			$orders[$key]['statuscss'] = $statuscss;
		}

		$orders = set_medias($orders, 'thumb');
		show_json(1, array('list' => $orders, 'pagesize' => $psize, 'total' => $total));
	}

	public function confirm()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		load()->model('mc');
		$uid = mc_openid2uid($openid);

		if (empty($uid)) {
			mc_oauth_userinfo($openid);
		}

		$isverify = false;
		$goodid = intval($_GPC['id']);
		$type = $_GPC['type'];
		$heads = intval($_GPC['heads']);
		$teamid = intval($_GPC['teamid']);
		$member = m('member')->getMember($openid, true);
		$credit = array();
		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_groups_goods') . '
				where id = :id and uniacid = :uniacid and deleted = 0 order by displayorder desc', array(':id' => $goodid, ':uniacid' => $uniacid));

		if ($goods['stock'] <= 0) {
			$this->message('您选择的商品库存不足，请浏览其他商品或联系商家！');
		}

		if (empty($goods['status'])) {
			$this->message('您选择的商品已经下架，请浏览其他商品或联系商家！');
		}

		$ladder = array();

		if ($goods['is_ladder'] == 1) {
			$ladder = pdo_get('ewei_shop_groups_ladder', array('goods_id' => $goodid, 'uniacid' => $_W['uniacid']));
		}

		if (0 < $_GPC['ladder_id']) {
			$ladder = pdo_get('ewei_shop_groups_ladder', array('id' => $_GPC['ladder_id'], 'uniacid' => $_W['uniacid']));
		}

		if ($goods['more_spec'] == 1) {
			$option_id = $_GPC['options_id'];

			if (!empty($option_id)) {
				$option = pdo_fetch('select * from ' . tablename('ewei_shop_groups_goods_option') . ' where goods_option_id=:goods_option_id and groups_goods_id=:groups_goods_id and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':groups_goods_id' => $goods['id'], ':goods_option_id' => $option_id));
			}
		}

		$follow = m('user')->followed($openid);
		if (!empty($goods['followneed']) && !$follow && is_weixin()) {
			$followtext = empty($goods['followtext']) ? '如果您想要购买此商品，需要您关注我们的公众号，点击【确定】关注后再来购买吧~' : $goods['followtext'];
			$followurl = empty($goods['followurl']) ? $_W['shopset']['share']['followurl'] : $goods['followurl'];
			$this->message($followtext, $followurl, 'error');
		}

		if ($type == 'groups') {
			$ordernum = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' as o
			where openid = :openid and status >= :status and goodid = :goodid and is_team = 1 and uniacid = :uniacid ', array(':openid' => $openid, ':status' => 0, ':goodid' => $goodid, ':uniacid' => $uniacid));
		}
		else {
			if ($type == 'single') {
				$ordernum = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' as o
			where openid = :openid and status >= :status and goodid = :goodid and uniacid = :uniacid and is_team = 0', array(':openid' => $openid, ':status' => 0, ':goodid' => $goodid, ':uniacid' => $uniacid));
			}
		}

		if (!empty($goods['purchaselimit']) && $goods['purchaselimit'] <= $ordernum) {
			$this->message('您已到达此商品购买上限，请浏览其他商品或联系商家！');
		}

		if ($type == 'groups') {
			$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . '
                where goodid = :goodid and status >= 0  and openid = :openid and uniacid = :uniacid and success = 0 and deleted = 0 and is_team =1', array(':goodid' => $goodid, ':openid' => $openid, ':uniacid' => $uniacid));
		}
		else {
			if ($type == 'single') {
				$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . '
                where goodid = :goodid and status >= 0  and openid = :openid and uniacid = :uniacid and success = 0 and deleted = 0 and is_team = 0 ', array(':goodid' => $goodid, ':openid' => $openid, ':uniacid' => $uniacid));
			}
		}

		if ($order && $order['status'] == 0) {
			$this->message('您的订单已存在，请尽快完成支付！');
		}

		if ($order && $order['status'] == 1 && $type == 'groups') {
			$this->message('您已经参与了该团，请等待拼团结束后再进行购买1！');
		}

		if (!empty($teamid)) {
			$orders = pdo_fetchall('select * from ' . tablename('ewei_shop_groups_order') . '
					where teamid = :teamid and uniacid = :uniacid ', array(':teamid' => $teamid, ':uniacid' => $uniacid));

			foreach ($orders as $key => $value) {
				if ($orders && $value['success'] == -1) {
					$this->message('该活动已过期，请浏览其他商品或联系商家！');
				}

				if ($orders && $value['success'] == 1) {
					$this->message('该活动已结束，请浏览其他商品或联系商家！');
				}
			}

			$num = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' as o where teamid = :teamid and status > :status and goodid = :goodid and uniacid = :uniacid ', array(':teamid' => $teamid, ':status' => 0, ':goodid' => $goods['id'], ':uniacid' => $uniacid));

			if (!empty($ladder)) {
				if ($ladder['ladder_num'] <= $num) {
					$this->message('该活动已成功组团，请浏览其他商品或联系商家！');
				}
			}
			else {
				if ($goods['groupnum'] <= $num) {
					$this->message('该活动已成功组团，请浏览其他商品或联系商家！');
				}
			}
		}

		if ($type == 'groups' && $goods['more_spec'] == 0 && $goods['is_ladder'] == 0) {
			$goodsprice = $goods['groupsprice'];
			$price = $goods['groupsprice'];
			$groupnum = intval($goods['groupnum']);
			$is_team = 1;
		}
		else {
			if ($type == 'single' && $goods['more_spec'] == 1) {
				$goodsprice = $option['single_price'];
				$price = $option['single_price'];
				$goods['singleprice'] = $option['single_price'];
				$groupnum = 1;
				$is_team = 0;
				$teamid = 0;
			}
			else {
				if ($type == 'groups' && !empty($ladder) && $goods['is_ladder'] == 1) {
					$goodsprice = $ladder['ladder_price'];
					$price = $ladder['ladder_price'];
					$groupnum = $ladder['ladder_num'];
					$is_team = 1;
					$goods['groupsprice'] = $ladder['ladder_price'];
				}
				else {
					if ($type == 'groups' && !empty($option) && $goods['more_spec'] == 1) {
						$goodsprice = $option['price'];
						$price = $option['price'];
						$groupnum = intval($goods['groupnum']);
						$is_team = 1;
						$goods['groupsprice'] = $option['price'];
					}
					else {
						if ($type == 'single') {
							$goodsprice = $goods['singleprice'];
							$price = $goods['singleprice'];
							$groupnum = 1;
							$is_team = 0;
							$teamid = 0;
						}
					}
				}
			}
		}

		$set = pdo_fetch('select discount,headstype,headsmoney,headsdiscount from ' . tablename('ewei_shop_groups_set') . '
					where uniacid = :uniacid ', array(':uniacid' => $uniacid));
		if (!empty($set['discount']) && $heads == 1) {
			if (!empty($goods['discount'])) {
				if (empty($goods['headstype'])) {
				}
				else if (0 < $goods['headsdiscount']) {
					if ($goods['headsdiscount'] == 100) {
						$goods['headsmoney'] = $goods['groupsprice'];
					}
					else {
						$goods['headsmoney'] = $goods['groupsprice'] - price_format($goods['groupsprice'] * $goods['headsdiscount'] / 100, 2);
					}
				}
				else {
					if ($goods['headsdiscount'] == 0) {
						$goods['headsmoney'] = 0;
					}
				}
			}
			else {
				if (empty($set['headstype'])) {
					$goods['headsmoney'] = $set['headsmoney'];
				}
				else {
					if (0 < $set['headsdiscount']) {
						if ($set['headsdiscount'] == 100) {
							$goods['headsmoney'] = $goods['groupsprice'];
						}
						else {
							$goods['headsmoney'] = $goods['groupsprice'] - price_format($goods['groupsprice'] * $set['headsdiscount'] / 100, 2);
						}
					}
				}

				$goods['headstype'] = $set['headstype'];
				$goods['headsdiscount'] = $set['headsdiscount'];
			}

			if ($goods['groupsprice'] < $goods['headsmoney']) {
				$goods['headsmoney'] = $goods['groupsprice'];
			}

			$price = $price - $goods['headsmoney'];

			if ($price < 0) {
				$price = 0;
			}
		}
		else {
			$goods['headsmoney'] = 0;
		}

		if (!empty($goods['isverify'])) {
			$isverify = true;
			$goods['freight'] = 0;
			$storeids = array();
			$merchid = 0;

			if (!empty($goods['storeids'])) {
				$merchid = $goods['merchid'];
				$storeids = array_merge(explode(',', $goods['storeids']), $storeids);
			}

			if (empty($storeids)) {
				if (0 < $merchid) {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where  uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
				}
				else {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
				}
			}
			else if (0 < $merchid) {
				$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
			}
			else {
				$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
			}

			$verifycode = 'PT' . random(8, true);

			while (1) {
				$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_groups_order') . ' where verifycode=:verifycode and uniacid=:uniacid limit 1', array(':verifycode' => $verifycode, ':uniacid' => $_W['uniacid']));

				if ($count <= 0) {
					break;
				}

				$verifycode = 'PT' . random(8, true);
			}

			$verifynum = !empty($goods['verifytype']) ? $verifynum = $goods['verifynum'] : 1;
		}
		else {
			$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . '
				where openid=:openid and deleted=0 and isdefault=1  and uniacid=:uniacid limit 1', array(':uniacid' => $uniacid, ':openid' => $openid));
		}

		$creditdeduct = pdo_fetch('SELECT creditdeduct,groupsdeduct,credit,groupsmoney FROM' . tablename('ewei_shop_groups_set') . 'WHERE uniacid = :uniacid ', array(':uniacid' => $uniacid));

		if (intval($creditdeduct['creditdeduct'])) {
			if (intval($creditdeduct['groupsdeduct'])) {
				if (0 < $goods['deduct']) {
					$credit['deductprice'] = round(intval($member['credit1']) * $creditdeduct['groupsmoney'], 2);

					if ($price <= $credit['deductprice']) {
						$credit['deductprice'] = $price;
					}

					if ($goods['deduct'] <= $credit['deductprice']) {
						$credit['deductprice'] = $goods['deduct'];
					}

					$credit['credit'] = floor($credit['deductprice'] / $creditdeduct['groupsmoney']);

					if ($credit['credit'] < 1) {
						$credit['credit'] = 0;
						$credit['deductprice'] = 0;
					}

					$credit['deductprice'] = $credit['credit'] * $creditdeduct['groupsmoney'];
				}
				else {
					$credit['deductprice'] = 0;
				}
			}
			else {
				$sys_data = m('common')->getPluginset('sale');

				if (0 < $goods['deduct']) {
					$credit['deductprice'] = round(intval($member['credit1']) * $sys_data['money'], 2);

					if ($price <= $credit['deductprice']) {
						$credit['deductprice'] = $price;
					}

					if ($goods['deduct'] <= $credit['deductprice']) {
						$credit['deductprice'] = $goods['deduct'];
					}

					$credit['credit'] = floor($credit['deductprice'] / $sys_data['money']);

					if ($credit['credit'] < 1) {
						$credit['credit'] = 0;
						$credit['deductprice'] = 0;
					}

					$credit['deductprice'] = $credit['credit'] * $sys_data['money'];
				}
				else {
					$credit['deductprice'] = 0;
				}
			}
		}

		$template_flag = 0;
		$diyform_plugin = p('diyform');

		if ($diyform_plugin) {
			$set_config = $diyform_plugin->getSet();
			$groups_diyform_open = $set_config['groups_diyform_open'];

			if ($groups_diyform_open == 1) {
				$template_flag = 1;
				$diyform_id = $set_config['groups_diyform'];

				if (!empty($diyform_id)) {
					$formInfo = $diyform_plugin->getDiyformInfo($diyform_id);
					$fields = $formInfo['fields'];
					$diyform_data = array();
					$f_data = $diyform_plugin->getDiyformData($diyform_data, $fields, $member);
				}
			}
		}

		$ordersn = m('common')->createNO('groups_order', 'orderno', 'PT');

		if ($_W['ispost']) {
			if (empty($_GPC['aid']) && !$isverify) {
				header('location: ' . mobileUrl('groups/address/post'));
				exit();
			}

			if ($isverify) {
				if (empty($_GPC['realname']) || empty($_GPC['mobile'])) {
					$this->message('联系人或联系电话不能为空！');
				}
			}

			if (0 < intval($_GPC['aid']) && !$isverify) {
				$order_address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where id=:id and openid=:openid and uniacid=:uniacid   limit 1', array(':uniacid' => $uniacid, ':openid' => $openid, ':id' => intval($_GPC['aid'])));

				if (empty($order_address)) {
					$this->message('未找到地址');
					header('location: ' . mobileUrl('groups/address/post'));
					exit();
				}
				else {
					if (empty($order_address['province']) || empty($order_address['city'])) {
						$this->message('地址请选择省市信息');
						header('location: ' . mobileUrl('groups/address/post'));
						exit();
					}
				}
			}

			$data = array('uniacid' => $_W['uniacid'], 'groupnum' => $groupnum, 'openid' => $openid, 'paytime' => '', 'orderno' => $ordersn, 'credit' => intval($_GPC['isdeduct']) ? $_GPC['credit'] : 0, 'creditmoney' => intval($_GPC['isdeduct']) ? $_GPC['creditmoney'] : 0, 'price' => $price, 'freight' => $goods['freight'], 'status' => 0, 'goodid' => $goodid, 'teamid' => $teamid, 'is_team' => $is_team, 'more_spec' => $goods['more_spec'], 'heads' => $heads, 'discount' => !empty($heads) ? $goods['headsmoney'] : 0, 'addressid' => intval($_GPC['aid']), 'address' => iserializer($order_address), 'message' => trim($_GPC['message']), 'realname' => $isverify ? trim($_GPC['realname']) : '', 'mobile' => $isverify ? trim($_GPC['mobile']) : '', 'endtime' => $goods['endtime'], 'isverify' => intval($goods['isverify']), 'verifytype' => intval($goods['verifytype']), 'verifycode' => !empty($verifycode) ? $verifycode : 0, 'verifynum' => !empty($verifynum) ? $verifynum : 1, 'createtime' => TIMESTAMP);
			if ($goods['is_ladder'] == 1 && 0 < $_GPC['ladder_id']) {
				$data['is_ladder'] = 1;
				$data['ladder_id'] = $_GPC['ladder_id'];
			}

			if ($goods['more_spec'] == 1 && 0 < $_GPC['options_id']) {
				$data['specs'] = $option['specs'];
			}

			if ($template_flag == 1) {
				$memberdata = json_decode(htmlspecialchars_decode($_GPC['groups'], ENT_QUOTES), true);
				$insert_data = $diyform_plugin->getInsertData($fields, $memberdata);
				$data['diyformid'] = $diyform_id;
				$data['diyformfields'] = serialize($fields);
				$data['diyformdata'] = $insert_data['data'];
			}

			$order_insert = pdo_insert('ewei_shop_groups_order', $data);

			if (!$order_insert) {
				$this->message('生成订单失败！');
			}

			$orderid = pdo_insertid();
			if (empty($teamid) && $type == 'groups') {
				pdo_update('ewei_shop_groups_order', array('teamid' => $orderid), array('id' => $orderid));
			}

			if (!empty($orderid) && $goods['more_spec'] == 1) {
				$_data = array('uniacid' => $_W['uniacid'], 'goods_id' => $goods['gid'], 'groups_goods_id' => $goods['id'], 'groups_goods_option_id' => $_GPC['options_id'], 'option_name' => $option['title'], 'groups_order_id' => $orderid, 'price' => $price, 'create_time' => time());
				pdo_insert('ewei_shop_groups_order_goods', $_data);
			}

			$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . '
						where id = :id and uniacid = :uniacid ', array(':id' => $orderid, ':uniacid' => $uniacid));
			header('location: ' . MobileUrl('groups/pay', array('teamid' => empty($teamid) ? $order['teamid'] : $teamid, 'orderid' => $orderid)));
		}

		$this->model->groupsShare();
		include $this->template();
	}

	/**
     * 确认收货
     * @global type $_W
     * @global type $_GPC
     */
	public function finish()
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC['id']);
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if (empty($order)) {
			show_json(0, '订单未找到');
		}

		if ($order['status'] != 2) {
			show_json(0, '订单不能确认收货');
		}

		if (0 < $order['refundstate'] && !empty($order['refundid'])) {
			$change_refund = array();
			$change_refund['refundstatus'] = -2;
			$change_refund['refundtime'] = time();
			pdo_update('ewei_shop_groups_order_refund', $change_refund, array('id' => $order['refundid'], 'uniacid' => $_W['uniacid']));
		}

		pdo_update('ewei_shop_groups_order', array('status' => 3, 'finishtime' => time(), 'refundstate' => 0), array('id' => $order['id'], 'uniacid' => $_W['uniacid']));
		p('groups')->sendTeamMessage($orderid);
		show_json(1);
	}
}

?>
