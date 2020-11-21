<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Goods_EweiShopV2Page extends PluginMobileLoginPage
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

		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$groupsset = pdo_fetch('select description,groups_description,discount,headstype,headsmoney,headsdiscount,followbar from ' . tablename('ewei_shop_groups_set') . 'where uniacid = :uniacid ', array(':uniacid' => $uniacid));
		$groupsset['groups_description'] = m('ui')->lazy($groupsset['groups_description']);
		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_groups_goods') . '
					where id = :id and status = :status and uniacid = :uniacid and deleted = 0 order by displayorder desc', array(':id' => $id, ':uniacid' => $uniacid, ':status' => 1));
		if (empty($id) || empty($goods)) {
			$this->message('你访问的商品不存在或已删除!', mobileUrl('groups'), 'error');
		}

		if (!empty($goods['thumb_url'])) {
			$goods['thumb_url'] = array_merge(iunserializer($goods['thumb_url']));
		}

		$goods = set_medias($goods, 'thumb');
		$goods['fightnum'] = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' where goodid = :goodid and uniacid = :uniacid and deleted = 0 and is_team = 1 and status > 0 ', array(':goodid' => $goods['id'], ':uniacid' => $uniacid));
		$goods['fightnum'] = $goods['teamnum'] + $goods['fightnum'];
		$goods['content'] = m('ui')->lazy($goods['content']);

		if (empty($goods)) {
			$this->message('商品已下架或被删除!', mobileUrl('groups'), 'error');
		}

		if (!empty($groupsset['discount'])) {
			if (empty($goods['discount'])) {
				$goods['headstype'] = $groupsset['headstype'];
				$goods['headsmoney'] = $groupsset['headsmoney'];
				$goods['headsdiscount'] = $groupsset['headsdiscount'];
			}

			if ($goods['groupsprice'] < $goods['headsmoney']) {
				$goods['headsmoney'] = $goods['groupsprice'];
			}
		}

		$specArr = array();

		if ($goods['more_spec'] == 1) {
			$group_goods = pdo_get('ewei_shop_groups_goods', array('id' => $id, 'uniacid' => $_W['uniacid']));

			if (empty($group_goods['gid'])) {
				app_error('缺少商品');
			}

			$specArr = pdo_getall('ewei_shop_goods_spec', array('goodsid' => $group_goods['gid'], 'uniacid' => $_W['uniacid']), array('id', 'title'), '', array('displayorder' => 'desc'));

			foreach ($specArr as $k => $v) {
				$specArr[$k]['item'] = pdo_getall('ewei_shop_goods_spec_item', array('uniacid' => $_W['uniacid'], 'specid' => $v['id']), array('id', 'specid', 'title', 'thumb'), '', array('displayorder' => 'desc'));
			}
		}

		$ladder = array();

		if ($goods['is_ladder'] == 1) {
			$ladder = pdo_getall('ewei_shop_groups_ladder', array('goods_id' => $id, 'uniacid' => $_W['uniacid']));
		}

		$url = array('pay' => mobileUrl('groups/goods/pay'), 'lottery' => mobileUrl('groups/goods/lottery'));
		$set = $_W['shopset'];
		$_W['shopshare'] = array('title' => !empty($goods['share_title']) ? $goods['share_title'] : $goods['title'], 'imgUrl' => !empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']), 'desc' => !empty($goods['share_desc']) ? $goods['share_desc'] : $goods['description'], 'link' => mobileUrl('groups/goods', array('id' => $id), true));
		include $this->template();
	}

	public function openGroups()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		load()->model('mc');
		$uid = mc_openid2uid($openid);

		if (empty($uid)) {
			mc_oauth_userinfo($openid);
		}

		if (empty($id)) {
			$this->message('你访问的商品不存在或已删除!', mobileUrl('groups'), 'error');
		}

		$groupsset = pdo_fetch('SELECT followbar FROM ' . tablename('ewei_shop_groups_set') . ' WHERE uniacid = :uniacid ', array(':uniacid' => $uniacid));
		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_groups_goods') . '
					where id = :id and status = :status and uniacid = :uniacid and deleted = 0 order by displayorder desc', array(':id' => $id, ':uniacid' => $uniacid, ':status' => 1));
		$goods['fightnum'] = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' where goodid = :goodid and uniacid = :uniacid and deleted = 0 and is_team = 1 and status > 0 ', array(':goodid' => $goods['id'], ':uniacid' => $uniacid));
		$goods['fightnum'] = $goods['teamnum'] + $goods['fightnum'];
		$goods = set_medias($goods, 'thumb');
		$ladder = array();
		if ($goods['is_ladder'] == 1 && $_GPC['is_ladder'] == 1) {
			$ladder = pdo_getall('ewei_shop_groups_ladder', array('goods_id' => $id, 'uniacid' => $_W['uniacid']));
			$info = pdo_fetchall('SELECT count(ladder_id) as order_num FROM ' . tablename('ewei_shop_groups_order') . ' WHERE `uniacid` = :uniacid and `openid`!=:openid and success = 0 and is_team =1 and status>0 and ladder_id >0 and goodid = :goodid group by ladder_id', array(':uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'goodid' => $id));

			if ($info[0]['order_num'] == 0) {
				$order_num = 0;
			}
			else {
				$order_num = 1;
			}
		}

		if ($_GPC['is_ladder'] != $goods['is_ladder']) {
			app_error('拼团类型错误,请重新选择!');
		}

		$specArr = array();
		if ($goods['more_spec'] == 1 && $_GPC['more_spec'] == 1) {
			$group_goods = pdo_get('ewei_shop_groups_goods', array('id' => $id, 'uniacid' => $_W['uniacid']));

			if (empty($group_goods['gid'])) {
				app_error('缺少商品');
			}

			$specArr = pdo_getall('ewei_shop_goods_spec', array('goodsid' => $group_goods['gid'], 'uniacid' => $_W['uniacid']), array('id', 'title'), '', array('displayorder' => 'desc'));

			foreach ($specArr as $k => $v) {
				$specArr[$k]['item'] = pdo_getall('ewei_shop_goods_spec_item', array('uniacid' => $_W['uniacid'], 'specid' => $v['id']), array('id', 'specid', 'title', 'thumb'), '', array('displayorder' => 'desc'));
			}

			$order_num = pdo_fetchcolumn('SELECT count(id) as order_num FROM ' . tablename('ewei_shop_groups_order') . ' WHERE `uniacid` = :uniacid and `openid`!=:openid and success = 0 and status>0 and more_spec =1 and is_team =1 and `goodid`=:goodid ', array(':uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'goodid' => $id));
		}

		if ($goods['is_ladder'] == 0 && $goods['more_spec'] == 0) {
			$order_num = pdo_fetchcolumn('SELECT count(id) as order_num FROM ' . tablename('ewei_shop_groups_order') . ' WHERE `uniacid` = :uniacid and `openid`!=:openid and success = 0 and is_team =1 and status>0 and `goodid`=:goodid ', array(':uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'goodid' => $id));
		}

		$teams = pdo_fetchall('select * from ' . tablename('ewei_shop_groups_goods') . ' where deleted = 0 and status = 1 and uniacid = :uniacid order by sales desc limit 4', array(':uniacid' => $uniacid));

		foreach ($teams as $key => $value) {
			$value['fightnum'] = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' where goodid = :goodid and uniacid = :uniacid and deleted = 0 and is_team = 1 and status > 0 ', array(':goodid' => $value['id'], ':uniacid' => $uniacid));
			$value['fightnum'] = $value['teamnum'] + $value['fightnum'];
			$value = set_medias($value, 'thumb');
			$teams[$key] = $value;
		}

		if (empty($goods)) {
			$this->message('商品已下架或被删除!', mobileUrl('groups'), 'error');
		}

		$_W['shopshare'] = array('title' => '我参加了“' . $goods['title'] . '”拼团，快来吧。盼你如南方人盼暖气~', 'imgUrl' => !empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']), 'desc' => !empty($goods['share_title']) ? $goods['share_title'] : $goods['title'], 'link' => mobileUrl('groups/goods', array('id' => $id, 'mid' => $member['id']), true));
		include $this->template();
	}

	public function fightGroups()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		load()->model('mc');
		$uid = mc_openid2uid($openid);

		if (empty($uid)) {
			mc_oauth_userinfo($openid);
		}

		$options_id = $_GPC['options_id'];
		$groupsset = pdo_fetch('SELECT followbar FROM ' . tablename('ewei_shop_groups_set') . ' WHERE uniacid = :uniacid ', array(':uniacid' => $uniacid));

		if (empty($id)) {
			$this->message('你访问的商品不存在或已删除!', mobileUrl('groups'), 'error');
		}

		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_groups_goods') . '
					where id = :id and status = :status and uniacid = :uniacid and deleted = 0 order by displayorder desc', array(':id' => $id, ':uniacid' => $uniacid, ':status' => 1));
		$goods['fightnum'] = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' where goodid = :goodid and uniacid = :uniacid and deleted = 0 and is_team = 1 and status > 0 ', array(':goodid' => $goods['id'], ':uniacid' => $uniacid));
		$goods['fightnum'] = $goods['teamnum'] + $goods['fightnum'];
		$goods = set_medias($goods, 'thumb');
		if ($goods['is_ladder'] == 1 && 0 < $_GPC['ladder_id']) {
			$teams = pdo_fetchall('select o.paytime,o.id,o.goodid,o.ladder_id,o.is_ladder,o.teamid,m.nickname,m.realname,m.mobile,m.avatar,g.endtime,g.groupnum,g.thumb_url,l.ladder_num,l.ladder_price from ' . tablename('ewei_shop_groups_order') . ' as o
				left join ' . tablename('ewei_shop_member') . ' as m on m.openid=o.openid and m.uniacid =  o.uniacid
				left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
				left join ' . tablename('ewei_shop_groups_ladder') . ' as l on l.id = o.ladder_id
				where o.goodid = :goodid and o.uniacid = :uniacid and o.openid != :openid and l.id = :ladder_id and o.deleted = 0 and o.heads = 1 and o.paytime > 0 and o.success = 0 limit 10 ', array(':goodid' => $goods['id'], ':uniacid' => $uniacid, ':openid' => $openid, ':ladder_id' => $_GPC['ladder_id']));
		}
		else {
			$teams = pdo_fetchall('select o.paytime,o.id,o.goodid,o.ladder_id,o.is_ladder,o.teamid,m.nickname,m.realname,m.mobile,m.avatar,g.endtime,g.groupnum,g.thumb_url,g.more_spec from ' . tablename('ewei_shop_groups_order') . ' as o
				left join ' . tablename('ewei_shop_member') . ' as m on m.openid=o.openid and m.uniacid =  o.uniacid
				left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
				where o.goodid = :goodid and o.uniacid = :uniacid and o.openid != :openid and o.deleted = 0 and o.heads = 1 and o.paytime > 0 and o.is_ladder = 0 and o.success = 0 limit 10 ', array(':goodid' => $goods['id'], ':uniacid' => $uniacid, ':openid' => $openid));
		}

		foreach ($teams as $key => $value) {
			$num = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' where uniacid = :uniacid and deleted = 0 and teamid = :teamid and status > 0 ', array(':teamid' => $value['teamid'], ':uniacid' => $uniacid));

			if ($value['is_ladder'] == 1) {
				$value['num'] = $value['ladder_num'] - $num;
			}
			else {
				$value['num'] = $value['groupnum'] - $num;
			}

			$value['residualtime'] = $value['paytime'] + $value['endtime'] * 60 * 60 - time();
			$value['hour'] = intval($value['residualtime'] / 3600);
			$value['minite'] = intval($value['residualtime'] / 60 % 60);
			$value['second'] = intval($value['residualtime'] % 60);
			$value['options_id'] = $options_id;
			$teams[$key] = $value;
		}

		$_W['shopshare'] = array('title' => '我参加了“' . $goods['title'] . '”拼团，快来吧。盼你如南方人盼暖气~', 'imgUrl' => !empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']), 'desc' => !empty($goods['share_title']) ? $goods['share_title'] : $goods['title'], 'link' => mobileUrl('groups/goods', array('id' => $id, 'mid' => $member['id']), true));
		include $this->template();
	}

	public function goodsCheck()
	{
		global $_W;
		global $_GPC;

		try {
			$uniacid = $_W['uniacid'];
			$id = intval($_GPC['id']);
			$type = $_GPC['type'];
			$openid = $_W['openid'];

			if (empty($id)) {
				show_json(0, array('message' => '商品不存在！'));
			}

			$goods = pdo_fetch('select * from ' . tablename('ewei_shop_groups_goods') . '
					where id = :id and status = :status and uniacid = :uniacid and deleted = 0 order by displayorder desc', array(':id' => $id, ':uniacid' => $uniacid, ':status' => 1));

			if (empty($goods)) {
				show_json(0, array('message' => '商品不存在！'));
			}

			if ($goods['stock'] <= 0) {
				show_json(0, array('message' => '您选择的商品库存不足，请浏览其他商品或联系商家！'));
			}

			if (empty($goods['status'])) {
				show_json(0, array('message' => '您选择的商品已经下架，请浏览其他商品或联系商家！'));
			}

			$ordernum = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' as o
			where openid = :openid and status >= :status and goodid = :goodid and uniacid = :uniacid', array(':openid' => $openid, ':status' => 0, ':goodid' => $id, ':uniacid' => $uniacid));
			if (!empty($goods['purchaselimit']) && $goods['purchaselimit'] <= $ordernum) {
				show_json(0, array('message' => '您已到达此商品购买上限，请浏览其他商品或联系商家！'));
			}

			$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . '
                where goodid = :goodid and status >= 0  and openid = :openid and uniacid = :uniacid and success = 0  and is_team = 1 and deleted = 0 ', array(':goodid' => $id, ':openid' => $openid, ':uniacid' => $uniacid));
			if ($order && $order['status'] == 0) {
				show_json(0, array('message' => '您的订单已存在，请尽快完成支付！'));
			}

			if ($order && $order['status'] == 1 && $type == 'groups') {
				show_json(0, array('message' => '您已经参与了该团，请等待拼团结束后再进行购买！'));
			}

			if ($type == 'single') {
				if (empty($goods['single'])) {
					show_json(0, array('message' => '商品不允许单购，请重新选择！'));
				}
			}

			$ladder = array();

			if ($goods['is_ladder'] == 1) {
				$ladder = pdo_getall('ewei_shop_groups_ladder', array('goods_id' => $id, 'uniacid' => $_W['uniacid']));

				if ($_GPC['fightgroups'] == 1) {
					$info = pdo_fetchall('SELECT ladder_id,count(ladder_id) as order_num FROM ' . tablename('ewei_shop_groups_order') . ' WHERE `uniacid` = :uniacid and `openid`!=:openid and success = 0 and status>0 and ladder_id >0 and goodid = :goodid group by ladder_id', array(':uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'goodid' => $id));
					if (!empty($info) && !empty($ladder)) {
						foreach ($ladder as $key => $value) {
							foreach ($info as $k => $v) {
								if ($value['id'] == $v['ladder_id']) {
									$ladder[$key]['order_num'] = $v['order_num'];
								}
							}
						}
					}
				}
			}

			if (empty($goods['stock'])) {
				show_json(0, array('message' => '商品库存为0，暂时无法购买，请浏览其他商品！'));
			}

			$specArr = array();

			if ($goods['more_spec'] == 1) {
				$group_goods = pdo_get('ewei_shop_groups_goods', array('id' => $id, 'uniacid' => $_W['uniacid']));

				if (empty($group_goods['gid'])) {
					app_error('缺少商品');
				}

				$specArr = pdo_getall('ewei_shop_goods_spec', array('goodsid' => $group_goods['gid'], 'uniacid' => $_W['uniacid']), array('id', 'title'), '', array('displayorder' => 'desc'));

				foreach ($specArr as $k => $v) {
					$specArr[$k]['item'] = pdo_getall('ewei_shop_goods_spec_item', array('uniacid' => $_W['uniacid'], 'specid' => $v['id']), array('id', 'specid', 'title', 'thumb'), '', array('displayorder' => 'desc'));
				}
			}

			show_json(1, array('ladder' => $ladder, 'specArr' => $specArr));
		}
		catch (Exception $e) {
			$content = $e->getMessage();
			include $this->template('groups/error');
		}
	}

	public function get_option()
	{
		global $_W;
		global $_GPC;
		$specArr = $_GPC['spec_id'];
		asort($specArr);

		if (!empty($specArr)) {
			$spec_id = implode('_', $specArr);
			$goods_option = pdo_get('ewei_shop_groups_goods_option', array('specs' => $spec_id, 'uniacid' => $_W['uniacid']));
			show_json(1, array('data' => $goods_option));
		}
	}
}

?>
