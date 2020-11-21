<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Team_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$otherorder = false;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$type = $_GPC['type'];
		$sort = $_GPC['sort'];
		$team = $_GPC['team'];
		$condition = ' o.uniacid=:uniacid and o.paytime > 0 and o.heads = 1 and o.is_team = 1 ';

		if ($type == 'ing') {
			$condition .= ' and o.success = 0 ';
		}
		else if ($type == 'success') {
			$condition .= ' and o.success = 1 ';
		}
		else if ($type == 'error') {
			$condition .= ' and o.success = -1 ';
		}
		else {
			if ($type == 'all') {
				$condition .= ' ';
			}
		}

		$params = array(':uniacid' => $_W['uniacid']);
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		$searchtime = $_GPC['searchtime'];

		if ($searchtime == 'starttime') {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND o.starttime >= :starttime AND o.starttime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		if (!empty($_GPC['keyword'])) {
			if ($_GPC['searchfield'] == 'orderno') {
				$condition .= ' and o.orderno like :orderno ';
				$params[':orderno'] = '%' . $_GPC['keyword'] . '%';
			}

			if ($_GPC['searchfield'] == 'teamid') {
				$condition .= ' AND o.id = :teamid';
				$params[':teamid'] = intval($_GPC['keyword']);
			}
		}

		$teams = pdo_fetchall('SELECT o.* FROM ' . tablename('ewei_shop_groups_order') . (' as o
					WHERE ' . $condition . ' ORDER BY o.createtime DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($teams as $key => $value) {
			$good = pdo_fetch('select title from ' . tablename('ewei_shop_groups_goods') . ' where uniacid = ' . $_W['uniacid'] . ' and id = ' . $value['goodid']);
			$teams[$key]['title'] = $good['title'];
			$teams[$key]['num'] = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_groups_order') . ' as o
										WHERE o.status > 0 and o.deleted = 0 and o.uniacid = :uniacid and o.teamid = :teamid ', array(':uniacid' => $_W['uniacid'], ':teamid' => $value['teamid']));
			$teams[$key]['groups_team'] = $teams[$key]['groupnum'] - $teams[$key]['num'];
			$teams[$key]['starttime'] = date('Y-m-d H:i', $value['starttime']);
			$hours = $value['endtime'];
			$date = date('Y-m-d H:i:s', $value['starttime']);
			$teams[$key]['endtime'] = date('Y-m-d H:i', strtotime(' ' . $date . ' + ' . $hours . ' hour'));
		}

		if ($sort == 'desc') {
			$teams = $this->multi_array_sort($teams, 'num');
		}
		else {
			if ($sort == 'asc') {
				$teams = $this->multi_array_sort($teams, 'num', SORT_ASC);
			}
		}

		if ($team == 'groups') {
			$teams = $this->multi_array_sort($teams, 'groups_team', SORT_ASC);
		}

		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_groups_order') . ' as o
					left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
					right join ' . tablename('ewei_shop_groups_category') . (' as c on c.id = g.category
					WHERE ' . $condition), $params);
		if (empty($teams) && !empty($_GPC['keyword']) && $_GPC['searchfield'] == 'orderno') {
			$grouporder = pdo_fetch('select teamid from ' . tablename('ewei_shop_groups_order') . ' where uniacid = :uniacid and orderno like :orderno ', array(':uniacid' => intval($_W['uniacid']), ':orderno' => '%' . $_GPC['keyword'] . '%'));
			$teams = pdo_fetchall('select * from ' . tablename('ewei_shop_groups_order') . ' where id = :teamid and uniacid = :uniacid and  paytime > 0 and heads = 1 and is_team = 1', array(':teamid' => $grouporder['teamid'], ':uniacid' => intval($_W['uniacid'])));

			foreach ($teams as $key => $value) {
				$good = pdo_fetch('select title from ' . tablename('ewei_shop_groups_goods') . ' where uniacid = ' . $_W['uniacid'] . ' and id = ' . $value['goodid']);
				$teams[$key]['title'] = $good['title'];
				$teams[$key]['num'] = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_groups_order') . ' as o
										WHERE o.status > 0 and o.deleted = 0 and o.uniacid = :uniacid and o.teamid = :teamid ', array(':uniacid' => $_W['uniacid'], ':teamid' => $value['teamid']));
				$teams[$key]['groups_team'] = $teams[$key]['groupnum'] - $teams[$key]['num'];
				$teams[$key]['starttime'] = date('Y-m-d H:i', $value['starttime']);
				$hours = $value['endtime'];
				$date = date('Y-m-d H:i:s', $value['starttime']);
				$teams[$key]['endtime'] = date('Y-m-d H:i', strtotime(' ' . $date . ' + ' . $hours . ' hour'));
			}

			$total = count($teams);
		}

		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function multi_array_sort($multi_array, $sort_key, $sort = SORT_DESC)
	{
		if (is_array($multi_array)) {
			foreach ($multi_array as $row_array) {
				if (is_array($row_array)) {
					$key_array[] = $row_array[$sort_key];
				}
				else {
					return false;
				}
			}
		}
		else {
			return false;
		}

		if (empty($multi_array)) {
			return false;
		}

		array_multisort($key_array, $sort, $multi_array);
		return $multi_array;
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$teamid = $_GPC['teamid'];
		$teaminfo = pdo_fetch('SELECT o.*,g.id as gid,g.title,g.thumb,g.thumb_url FROM ' . tablename('ewei_shop_groups_order') . ' as o
					left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
					WHERE o.teamid =:teamid and o.uniacid=:uniacid and o.is_team = :is_team and heads = :heads', array(':uniacid' => $_W['uniacid'], ':teamid' => $teamid, ':is_team' => 1, ':heads' => 1));
		$total = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' as o where o.teamid =:teamid and o.uniacid=:uniacid and o.is_team = :is_team and status > :status', array(':uniacid' => $_W['uniacid'], ':teamid' => $teamid, ':is_team' => 1, ':status' => 0));
		$orders = pdo_fetchall('SELECT o.*,g.thumb,g.thumb_url FROM ' . tablename('ewei_shop_groups_order') . ' as o
					left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
					WHERE o.teamid =:teamid and o.uniacid=:uniacid and o.is_team = :is_team and o.status != :status', array(':uniacid' => $_W['uniacid'], ':teamid' => $teamid, ':is_team' => 1, ':status' => 0));

		foreach ($orders as $key => $value) {
			$member = m('member')->getMember($value['openid']);
			$orders[$key]['avatar'] = $member['avatar'];
			$orders[$key]['nickname'] = $member['nickname'];
			$orders[$key]['uid'] = $member['id'];
		}

		$member = m('member')->getMember($teaminfo['openid']);
		$dispatch = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_dispatch') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $teaminfo['dispatchid'], ':uniacid' => $_W['uniacid']));

		if (empty($item['addressid'])) {
			$user = unserialize($item['carrier']);
		}
		else {
			$user = iunserializer($item['address']);

			if (!is_array($user)) {
				$user = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['addressid'], ':uniacid' => $_W['uniacid']));
			}

			$address_info = $user['address'];
			$user['address'] = $user['province'] . ' ' . $user['city'] . ' ' . $user['area'] . ' ' . $user['address'];
			$item['addressdata'] = array('realname' => $user['realname'], 'mobile' => $user['mobile'], 'address' => $user['address']);
		}

		include $this->template();
	}

	public function group()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$teamid = intval($_GPC['id']);

		if (empty($teamid)) {
			$teamid = is_array($_GPC['ids']) ? $_GPC['ids'] : 0;
		}
		else {
			$teamid = array($teamid);
		}

		foreach ($teamid as $key => $value) {
			$order = pdo_fetch('select id,uniacid,groupnum,goodid,endtime from ' . tablename('ewei_shop_groups_order') . '
					where teamid = :teamid and heads = 1 and success = 0 and uniacid = :uniacid ', array(':teamid' => $value, ':uniacid' => $uniacid));
			$order_count = pdo_fetchcolumn('select COUNT(1) from ' . tablename('ewei_shop_groups_order') . ' where teamid = :teamid and status = 1 and success = 0 and uniacid = :uniacid ', array(':teamid' => $value, ':uniacid' => $uniacid));
			$num = $order['groupnum'] - $order_count;
			$i = 0;

			while ($i < $num) {
				$orderno = m('common')->createNO('groups_order', 'orderno', 'PT');
				$system_order_data = array('uniacid' => $order['uniacid'], 'groupnum' => $order['groupnum'], 'openid' => '', 'paytime' => TIMESTAMP, 'starttime' => TIMESTAMP, 'finishtime' => TIMESTAMP, 'pay_type' => 'system', 'orderno' => $orderno, 'status' => 3, 'goodid' => $order['goodid'], 'teamid' => $value, 'is_team' => 1, 'endtime' => $order['endtime'], 'sendtime' => TIMESTAMP, 'createtime' => TIMESTAMP, 'success' => 1);
				$order_insert = pdo_insert('ewei_shop_groups_order', $system_order_data);
				++$i;
			}

			pdo_update('ewei_shop_groups_order', array('success' => 1), array('teamid' => $value, 'uniacid' => $uniacid, 'status' => 1));
			pdo_update('ewei_shop_groups_order', array('status' => -1), array('teamid' => $value, 'uniacid' => $uniacid, 'status' => 0));
			$this->model->sendTeamMessage($order['id']);
		}

		show_json(1);
	}

	public function cancel_group()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$teamid = intval($_GPC['id']);

		if (empty($teamid)) {
			show_json(0, '该团不存在！');
		}

		$orderNum = pdo_fetchcolumn('select COUNT(id) from ' . tablename('ewei_shop_groups_order') . ' where teamid = :teamid and uniacid = :uniacid and status >1 and success = 1 ', array(':teamid' => $teamid, ':uniacid' => $uniacid));

		if (!empty($orderNum)) {
			show_json(0, '该团商品已发货或已使用，不可取消！');
		}

		$headgroup = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . ' where heads = 1 and teamid = :teamid and uniacid = :uniacid ', array(':teamid' => $teamid, ':uniacid' => $uniacid));

		if ($headgroup['success'] < 1) {
			show_json(0, '该团不满足取消条件！');
		}

		pdo_update('ewei_shop_groups_order', array('success' => -1), array('teamid' => $teamid, 'uniacid' => $uniacid, 'status' => 1));
		pdo_update('ewei_shop_groups_order', array('status' => -1), array('teamid' => $teamid, 'uniacid' => $uniacid, 'status' => 0));
		show_json(1);
	}

	public function ajaxgettotals()
	{
		$totals = $this->model->getTotals();
		$result = empty($totals) ? array() : $totals;
		show_json(1, $result);
	}
}

?>
