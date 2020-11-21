<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'app/core/page_auth_mobile.php';
class Index_EweiShopV2Page extends AppMobileAuthPage
{
	public function main()
	{
		return app_error(AppError::$RequestError);
	}

	/**
     * 工作台首页接口
     */
	public function home()
	{
		global $_W;
		$notices = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_copyright_notice') . ' WHERE status=1 ORDER BY displayorder ASC,createtime DESC LIMIT 10');
		$order = $this->order(0);
		$member = $this->newmember(0);
		$goods = m('goods')->getTotals();
		$goodscount = $goods['sale'] + $goods['out'] + $goods['stock'] + $goods['cycle'];
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = 'ewei_' . $_W['uniacid'] . '_member_mmanage_index1';
			$member_count = m('member')->memberRadisCount($redis_key);

			if (!$member_count) {
				$member_count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
				m('member')->memberRadisCount($redis_key, $member_count);
			}
		}
		else {
			$member_count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
		}

		$result = array(
			'shopset'      => array('name' => $_W['shopset']['shop']['name'], 'logo' => tomedia($_W['shopset']['shop']['logo']), 'desc' => $_W['shopset']['shop']['description']),
			'notices'      => $notices,
			'today_count'  => $order['count'],
			'today_price'  => $order['price'],
			'today_member' => $member['count'],
			'order_count'  => m('order')->getTotals(),
			'goods_count'  => $goodscount,
			'member_count' => $member_count,
			'perms'        => array('sysset' => cv('sysset'), 'order_status0' => cv('order.list.status0'), 'order_status1' => cv('order.list.status1'), 'order_status2' => cv('order.list.status2'), 'order_status4' => cv('order.list.status4'), 'order_status5' => cv('order.list.status5'), 'goods' => cv('goods'), 'member' => cv('member'), 'finance' => cv('finance'), 'statistics' => cv('statistics'))
		);
		return app_json($result);
	}

	/**
     * 切换公众号
     */
	public function switchwx()
	{
		global $_GPC;
		$uid = intval($_GPC['_uid']);

		if (empty($uid)) {
			return app_error(AppError::$ParamsError);
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		list($list, $total) = $this->oldAccount($pindex, $psize, $uid);

		if (!empty($list)) {
			foreach ($list as $index => &$account) {
				$account_details = uni_accounts($account['uniacid']);

				if (!empty($account_details)) {
					$account_detail = $account_details[$account['uniacid']];
					$account['thumb'] = tomedia('headimg_' . $account_detail['acid'] . '.jpg') . '?time=' . time();
				}

				$set = m('common')->getPluginset('mmanage', $account['uniacid']);
				if (is_array($set) && !empty($set['open'])) {
					$account['open'] = 1;
				}
			}

			unset($account_val);
			unset($account);
			unset($set);
		}

		return app_json(array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}

	/**
     * 获取指定天数订单数量
     * @param $day
     * @return array
     */
	private function order($day)
	{
		global $_GPC;
		$day = (int) $day;
		$orderPrice = $this->selectOrderPrice($day);
		$orderPrice['avg'] = empty($orderPrice['count']) ? 0 : round($orderPrice['price'] / $orderPrice['count'], 1);
		unset($orderPrice['fetchall']);
		return $orderPrice;
	}

	/**
     * 获取指定天数订单价格
     * @param int $day
     * @return array
     */
	private function selectOrderPrice($day = 0)
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

		$sql = 'select id,price,createtime from ' . tablename('ewei_shop_order') . ' where uniacid = :uniacid and ismr=0 and isparent=0 and (status > 0 or ( status=0 and paytype=3)) and deleted=0 and createtime between :createtime1 and :createtime2';
		$param = array(':uniacid' => $_W['uniacid'], ':createtime1' => $createtime1, ':createtime2' => $createtime2);
		$pdo_res = pdo_fetchall($sql, $param);
		$price = 0;

		foreach ($pdo_res as $arr) {
			$price += $arr['price'];
		}

		$result = array('price' => round($price, 1), 'count' => count($pdo_res), 'fetchall' => $pdo_res);
		return $result;
	}

	/**
     * 获取指定参数新增会员数量
     * @param int $day
     * @return array
     */
	private function newmember($day = 0)
	{
		global $_GPC;
		global $_W;
		$day = (int) $day;

		if (isset($_GPC['day'])) {
			$day = (int) $_GPC['day'];
		}

		$param = array(':uniacid' => $_W['uniacid']);
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = 'ewei_' . $_W['uniacid'] . '_member_mmanage_index2';
			$member_count = m('member')->memberRadisCount($redis_key);

			if (!$member_count) {
				$member_count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid', $param);
				m('member')->memberRadisCount($redis_key, $member_count);
			}
		}
		else {
			$member_count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid', $param);
		}

		$newmember = $this->selectMemberCreate($day);
		return array('count' => (int) $newmember, 'rate' => empty($member_count) ? 0 : (int) number_format(round($newmember / $member_count, 3) * 100));
	}

	/**
     * 获取指定天数新增会员数量
     * @param int $day
     * @return bool
     */
	private function selectMemberCreate($day = 0)
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

		$sql = 'select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid = :uniacid and createtime between :createtime1 and :createtime2';
		$param = array(':uniacid' => $_W['uniacid'], ':createtime1' => $createtime1, ':createtime2' => $createtime2);
		return pdo_fetchcolumn($sql, $param);
	}

	/**
     * 读取公众号列表
     * @param $pindex
     * @param $psize
     * @return array
     */
	private function oldAccount($pindex, $psize, $uid = 0)
	{
		global $_GPC;
		global $_W;
		$founders = explode(',', $_W['config']['setting']['founder']);
		$isfounder = in_array($uid, $founders);
		$start = ($pindex - 1) * $psize;
		$condition = '';
		$param = array();
		$keyword = trim($_GPC['keyword']);

		if (!empty($isfounder)) {
			$condition .= ' WHERE a.default_acid <> 0 AND b.isdeleted <> 1 AND (b.type = ' . ACCOUNT_TYPE_OFFCIAL_NORMAL . ' OR b.type = ' . ACCOUNT_TYPE_OFFCIAL_AUTH . ')';
			$order_by = ' ORDER BY a.`rank` DESC';
		}
		else {
			$condition .= 'LEFT JOIN ' . tablename('uni_account_users') . ' as c ON a.uniacid = c.uniacid WHERE a.default_acid <> 0 AND c.uid = :uid AND b.isdeleted <> 1 AND (b.type = ' . ACCOUNT_TYPE_OFFCIAL_NORMAL . ' OR b.type = ' . ACCOUNT_TYPE_OFFCIAL_AUTH . ')';
			$param[':uid'] = $uid;
			$order_by = ' ORDER BY c.`rank` DESC';
		}

		if (!empty($keyword)) {
			$condition .= ' AND a.`name` LIKE :name';
			$param[':name'] = '%' . $keyword . '%';
		}

		if (isset($_GPC['letter']) && strlen($_GPC['letter']) == 1) {
			$letter = trim($_GPC['letter']);

			if (!empty($letter)) {
				$condition .= ' AND a.`title_initial` = :title_initial';
				$param[':title_initial'] = $letter;
			}
			else {
				$condition .= ' AND a.`title_initial` = \'\'';
			}
		}

		$tsql = 'SELECT COUNT(*) FROM ' . tablename('uni_account') . ' as a LEFT JOIN' . tablename('account') . (' as b ON a.default_acid = b.acid ' . $condition . ' ' . $order_by . ', a.`uniacid` DESC');
		$total = pdo_fetchcolumn($tsql, $param);
		$sql = 'SELECT * FROM ' . tablename('uni_account') . ' as a LEFT JOIN' . tablename('account') . (' as b ON a.default_acid = b.acid  ' . $condition . ' ' . $order_by . ', a.`uniacid` DESC LIMIT ' . $start . ', ' . $psize);
		$list = pdo_fetchall($sql, $param);
		return array($list, $total);
	}
}

?>
