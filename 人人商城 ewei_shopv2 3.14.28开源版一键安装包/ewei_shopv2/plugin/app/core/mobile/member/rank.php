<?php
function ranksort($a, $b)
{
	return $b['credit1'] < $a['credit1'] ? -1 : 1;
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Rank_EweiShopV2Page extends MobilePage
{
	protected function status()
	{
		global $_W;

		if (empty($_W['shopset']['rank']['status'])) {
			$err = '未开启积分排名';

			if ($_W['isajax']) {
				show_json(0, $err);
			}

			$this->message($err, '', 'error');
		}
	}

	protected function getRank($update = false)
	{
		global $_W;
		$rank_cache = m('cache')->getArray('member_rank');
		if (empty($rank_cache) || $rank_cache['time'] < TIMESTAMP || $update) {
			$num = intval($_W['shopset']['rank']['num']);
			$result = pdo_fetchall('SELECT sm.id,sm.uid,m.credit1,sm.nickname,sm.avatar,sm.openid FROM ' . tablename('ewei_shop_member') . ' sm RIGHT JOIN ' . tablename('mc_members') . (' m ON m.uid=sm.uid WHERE sm.uniacid = :uniacid ORDER BY m.credit1 DESC LIMIT ' . $num), array(':uniacid' => $_W['uniacid']));
			$result1 = pdo_fetchall('SELECT id,uid,credit1,nickname,avatar,openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = :uniacid AND uid=0 ORDER BY credit1 DESC LIMIT ' . $num), array(':uniacid' => $_W['uniacid']));
			$result = array_merge($result, $result1);
			usort($result, 'ranksort');
			$result = array_slice($result, 0, $num);
			m('cache')->set('member_rank', array('time' => TIMESTAMP + 3600, 'result' => $result));
		}

		return $rank_cache;
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$this->status();
		$user = m('member')->getMember($_W['openid'], true);
		$rank_cache = $this->getRank();
		$result = $rank_cache['result'];
		$paiming = 0;

		foreach ($result as $key => $val) {
			if ($val['openid'] == $_W['openid']) {
				$paiming += $key + 1;
			}
		}

		$num = intval($_W['shopset']['rank']['num']);
		$user['credit1'] = intval($user['credit1']);
		$user['paiming'] = empty($paiming) ? '未上榜' : $paiming;
		$seven = $this->creditChange($user['uid']);
		$user['seven'] = empty($seven) ? 0 : $seven;
		include $this->template();
	}

	public function ajaxpage()
	{
		global $_W;
		global $_GPC;
		$this->status();
		$pindex = max(1, (int) $_GPC['page']);
		$psize = 20;
		$num = intval($_W['shopset']['rank']['num']);

		if ($num <= 0) {
			$num = 50;
		}

		$stop = false;

		if ($num <= $pindex * $psize) {
			$psize = $num % $psize == 0 ? 20 : $num % $psize;
			$pindex = ceil($num / $psize);
			$stop = true;
		}

		$rank_cache = $this->getRank();
		$result = $rank_cache['result'];
		$result = array_slice($result, ($pindex - 1) * $psize, $psize);
		show_json(1, array('list' => $result, 'stop' => $stop));
	}

	protected function creditChange($uid, $credittype = 'credit1', $day = 7)
	{
		global $_W;
		$day = (int) $day;

		if ($day != 0) {
			$createtime1 = strtotime(date('Y-m-d', time() - $day * 3600 * 24));
			$createtime2 = strtotime(date('Y-m-d', time()));
		}
		else {
			$createtime1 = strtotime(date('Y-m-d', time()));
			$createtime2 = strtotime(date('Y-m-d', time() + 3600 * 24));
		}

		$sql = 'select sum(num) from ' . tablename('mc_credits_record') . ' where uniacid = :uniacid and uid = :uid and credittype = :credittype and `module` = "ewei_shopv2" and createtime between :createtime1 and :createtime2';
		$param = array(':uniacid' => $_W['uniacid'], ':uid' => (int) $uid, ':createtime1' => $createtime1, ':createtime2' => $createtime2, ':credittype' => $credittype);
		return pdo_fetchcolumn($sql, $param);
	}

	protected function orderStatus()
	{
		global $_W;

		if (empty($_W['shopset']['rank']['order_status'])) {
			$err = '未开启订单排名';

			if ($_W['isajax']) {
				show_json(0, $err);
			}

			$this->message($err, '', 'error');
		}
	}

	public function order_rank()
	{
		global $_W;
		global $_GPC;
		$this->orderStatus();
		$user = m('member')->getMember($_W['openid'], true);
		$result_one = pdo_fetch('SELECT SUM(price) as price,openid FROM ' . tablename('ewei_shop_order') . ' WHERE uniacid = :uniacid AND openid = :openid AND status = 3 GROUP BY openid ', array(':uniacid' => $_W['uniacid'], ':openid' => $user['openid']));
		$result_all = pdo_fetchall('SELECT SUM(price) as price,openid FROM ' . tablename('ewei_shop_order') . ' WHERE uniacid = :uniacid AND status = 3 GROUP BY openid HAVING price>=:price ORDER BY price DESC', array(':uniacid' => $_W['uniacid'], ':price' => $result_one['price']));
		$user['paiming'] = count($result_all);
		$seven = $this->orderChange($user['openid']);
		$user['seven'] = empty($seven) ? 0 : $seven;
		include $this->template('member/order_rank');
	}

	public function ajaxorderpage()
	{
		global $_W;
		global $_GPC;
		$this->orderStatus();
		$pindex = max(1, (int) $_GPC['page']);
		$psize = 20;
		$num = intval($_W['shopset']['rank']['order_num']);

		if ($num <= 0) {
			$num = 50;
		}

		$stop = false;

		if ($num <= $pindex * $psize) {
			$psize = $num % $psize == 0 ? 20 : $num % $psize;
			$pindex = ceil($num / $psize);
			$stop = true;
		}

		$limit = ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$result = pdo_fetchall('SELECT m.id,m.uid,m.nickname,m.avatar,SUM(o.price) as price FROM ' . tablename('ewei_shop_member') . ' as m JOIN ' . tablename('ewei_shop_order') . ' as o ON m.openid = o.openid AND m.uniacid = o.uniacid WHERE o.uniacid = :uniacid AND o.status = 3 GROUP BY o.openid ORDER BY price DESC ' . $limit, array(':uniacid' => $_W['uniacid']));
		show_json(1, array('list' => $result, 'stop' => $stop));
	}

	protected function orderChange($openid, $day = 7)
	{
		global $_W;
		$day = (int) $day;

		if ($day != 0) {
			$createtime1 = strtotime(date('Y-m-d', time() - $day * 3600 * 24));
			$createtime2 = strtotime(date('Y-m-d', time()));
		}
		else {
			$createtime1 = strtotime(date('Y-m-d', time()));
			$createtime2 = strtotime(date('Y-m-d', time() + 3600 * 24));
		}

		$sql = 'select sum(price) from ' . tablename('ewei_shop_order') . ' where uniacid = :uniacid and openid = :openid and status = 3 and createtime between :createtime1 and :createtime2';
		$param = array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':createtime1' => $createtime1, ':createtime2' => $createtime2);
		return pdo_fetchcolumn($sql, $param);
	}
}

?>
