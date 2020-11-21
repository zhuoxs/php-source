<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Team_EweiShopV2Page extends AppMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 5;
		$success = intval($_GPC['success']);
		$condition = ' and o.openid=:openid and o.uniacid=:uniacid and o.is_team = 1 and o.paytime > 0 and o.deleted = 0 ';
		$params = array(':uniacid' => $uniacid, ':openid' => $openid);

		if ($success == 0) {
			$condition .= ' and o.success = :success ';
			$params[':success'] = $success;
		}
		else if ($success == 1) {
			$condition .= ' and o.success = :success ';
			$params[':success'] = $success;
		}
		else {
			if ($success == -1) {
				$condition .= ' and o.success = :success ';
				$params[':success'] = $success;
			}
		}

		$orders = pdo_fetchall('select o.id,o.groupnum,o.orderno,o.status,o.creditmoney,o.teamid,o.price as o_price,o.success,o.freight,o.goodid,o.is_ladder,o.more_spec,g.title,g.price as gprice,g.groupsprice,g.thumb,g.thumb_url,g.units,g.goodsnum,og.option_name,o.goods_price from ' . tablename('ewei_shop_groups_order') . ' as o
				left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
				left join ' . tablename('ewei_shop_groups_order_goods') . (' as og on og.groups_order_id = o.id 
				where 1 ' . $condition . ' order by o.createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . (' as o where 1 ' . $condition), $params);

		foreach ($orders as $key => $order) {
			$orders[$key]['amount'] = $order['o_price'] + $order['freight'] - $order['creditmoney'];
			$goods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_goods') . ('WHERE id = ' . $order['goodid']));
			$sql2 = 'SELECT * FROM' . tablename('ewei_shop_groups_order') . 'where teamid = :teamid and success = 1';
			$params2 = array(':teamid' => $order['teamid']);
			$alltuan = pdo_fetchall($sql2, $params2);
			$item = array();

			foreach ($alltuan as $num => $all) {
				$item[$num] = $all['id'];
			}

			$orders[$key]['itemnum'] = count($item);
			$sql3 = 'SELECT * FROM ' . tablename('ewei_shop_groups_order') . ' WHERE teamid = :teamid and paytime > 0 and heads = :heads';
			$params3 = array(':teamid' => $order['teamid'], ':heads' => 1);
			$tuan_first_order = pdo_fetch($sql3, $params3);
			$hours = $tuan_first_order['endtime'];
			$time = time();
			$date = date('Y-m-d H:i:s', $tuan_first_order['starttime']);
			$endtime = date('Y-m-d H:i:s', strtotime(' ' . $date . ' + ' . $hours . ' hour'));
			$date1 = date('Y-m-d H:i:s', $time);
			$orders[$key]['lasttime'] = strtotime($endtime) - strtotime($date1);
			$orders[$key]['starttime'] = date('Y-m-d H:i:s', $orders[$key]['starttime']);
		}

		$orders = set_medias($orders, 'thumb');
		return app_json(array('list' => $orders, 'pagesize' => $psize, 'total' => $total));
	}

	public function details()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$teamid = intval($_GPC['teamid']);
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$condition = '';

		if (empty($teamid)) {
			return app_error(1, '该团不存在!');
		}

		$myorder = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_order') . ' WHERE uniacid = ' . $uniacid . (' and openid = \'' . $openid . '\' and teamid = ' . $teamid . ' and paytime>0'));
		$params = array(':teamid' => $teamid);
		$orders = pdo_fetchall('select * from ' . tablename('ewei_shop_groups_order') . ' where uniacid = ' . $uniacid . ' and teamid = :teamid and paytime>0 order by id asc ', $params);
		$profileall = array();

		foreach ($orders as $key => $value) {
			if ($value['groupnum'] == 1) {
				$single = 1;
			}

			$order['goodid'] = $value['goodid'];
			$order['groupnum'] = $value['groupnum'];
			$order['success'] = $value['success'];
			$avatar = pdo_fetch('SELECT openid,avatar,nickname FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid =\'' . $_W['uniacid'] . '\' and openid = \'' . $value['openid'] . '\''));
			$orders[$key]['openid'] = $avatar['openid'];
			$orders[$key]['nickname'] = $avatar['nickname'];
			$orders[$key]['avatar'] = $avatar['avatar'];
			$orders[$key]['createtime'] = date('Y-m-d H:i:s', $value['createtime']);

			if ($orders[$key]['avatar'] == '') {
				$orders[$key]['avatar'] = tomedia('../addons/ewei_shopv2/plugin/groups/template/mobile/default/images/user/' . mt_rand(1, 20) . '.jpg');
			}
		}

		$groupsset = pdo_fetch('select description,groups_description,discount,headstype,headsmoney,headsdiscount from ' . tablename('ewei_shop_groups_set') . '
					where uniacid = :uniacid ', array(':uniacid' => $uniacid));
		$groupsset['groups_description'] = m('ui')->lazy($groupsset['groups_description']);
		$goods = pdo_fetch('SELECT * FROM' . tablename('ewei_shop_groups_goods') . 'WHERE  uniacid = ' . $uniacid . (' and id = ' . $order['goodid']));
		$goods = set_medias($goods, 'thumb');
		$goods['content'] = m('ui')->lazy($goods['content']);

		if (!empty($goods['thumb_url'])) {
			$goods['thumb_url'] = array_merge(iunserializer($goods['thumb_url']));
		}

		$sql = 'SELECT * FROM' . tablename('ewei_shop_groups_order') . ' where uniacid = :uniacid and teamid=:teamid and status > 0 ';
		$params = array(':uniacid' => $_W['uniacid'], ':teamid' => $teamid);
		$alltuan = pdo_fetchall($sql, $params);
		$item = array();
		$is_success = 0;

		foreach ($alltuan as $num => $all) {
			$item[$num] = $all['id'];

			if ($all['success'] == 1) {
				$is_success = 1;
			}
		}

		$nn = count($alltuan);
		$n = intval($order['groupnum']) - $nn;

		if ($n <= 0) {
			pdo_update('ewei_shop_groups_order', array('success' => 1), array('teamid' => $teamid));
		}
		else {
			if ($is_success == 1) {
				$n = 0;
			}
		}

		$arr = array();
		$i = 0;

		while ($i < $n) {
			$arr[$i] = 0;
			++$i;
		}

		$tuan_first_order = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_order') . (' WHERE teamid = ' . $teamid . ' and heads = 1'));
		$hours = $tuan_first_order['endtime'];
		$time = time();
		$date = date('Y-m-d H:i:s', $tuan_first_order['starttime']);
		$endtime = date('Y-m-d H:i:s', strtotime(' ' . $date . ' + ' . $hours . ' hour'));
		$date1 = date('Y-m-d H:i:s', $time);
		$lasttime2 = strtotime($endtime) - strtotime($date1);
		$tuan_first_order['endtime'] = strtotime(' ' . $date . ' + ' . $hours . ' hour');
		$ladder = array();

		if ($tuan_first_order['is_ladder'] == 1) {
			$ladder = pdo_get('ewei_shop_groups_ladder', array('id' => $tuan_first_order['ladder_id']));
			$goods['groupsprice'] = $ladder['ladder_price'];
			$order['groupnum'] = $ladder['ladder_num'];
		}

		$shopshare = array('title' => '还差' . $n . '人，我参加了“' . $goods['title'] . '”拼团，快来吧。盼你如南方人盼暖气~', 'imgUrl' => !empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']), 'desc' => !empty($goods['share_title']) ? $goods['share_title'] : $goods['title'], 'link' => mobileUrl('groups/team/detail', array('teamid' => $teamid), true));
		return app_json(array(
			'data' => array('myorder' => $myorder, 'tuan_first_order' => $tuan_first_order, 'shopshare' => $shopshare, 'lasttime2' => $lasttime2, 'n' => $n, 'nn' => $nn, 'ladder' => $ladder, 'goods' => $goods, 'orders' => $orders, 'uid' => $member['id'], 'arr' => $arr)
		));
	}
}

?>
