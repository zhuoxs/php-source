<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Account_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 24;

		if (function_exists('uni_account_list')) {
			list($list, $total) = $this->newAccount($pindex, $psize);
		}
		else {
			list($list, $total) = $this->oldAccount($pindex, $psize);
		}

		if (!empty($list)) {
			foreach ($list as &$account) {
				$account['url'] = url('account/display/switch', array('uniacid' => $account['uniacid']));
				$account['details'] = uni_accounts($account['uniacid']);

				if (!empty($account['details'])) {
					foreach ($account['details'] as &$account_val) {
						$account_val['thumb'] = tomedia('headimg_' . $account_val['acid'] . '.jpg') . '?time=' . time();
					}
				}

				$account['role'] = uni_permission($_W['uid'], $account['uniacid']);
				$account['setmeal'] = uni_setmeal($account['uniacid']);
			}

			unset($account_val);
			unset($account);
		}

		$pager = pagination($total, $pindex, $psize);
		include $this->template('sysset/account/index');
	}

	private function oldAccount($pindex, $psize)
	{
		global $_GPC;
		global $_W;
		$start = ($pindex - 1) * $psize;
		$condition = '';
		$param = array();
		$keyword = trim($_GPC['keyword']);
		if (!empty($_W['isfounder']) && $_W['role'] != 'vice_founder') {
			$condition .= ' WHERE a.default_acid <> 0 AND b.isdeleted <> 1 AND (b.type = ' . ACCOUNT_TYPE_OFFCIAL_NORMAL . ' OR b.type = ' . ACCOUNT_TYPE_OFFCIAL_AUTH . ')';
			$order_by = ' ORDER BY a.`rank` DESC';
		}
		else {
			$condition .= 'LEFT JOIN ' . tablename('uni_account_users') . ' as c ON a.uniacid = c.uniacid WHERE a.default_acid <> 0 AND c.uid = :uid AND b.isdeleted <> 1 AND (b.type = ' . ACCOUNT_TYPE_OFFCIAL_NORMAL . ' OR b.type = ' . ACCOUNT_TYPE_OFFCIAL_AUTH . ')';
			$param[':uid'] = $_W['uid'];
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

	private function newAccount($pindex, $psize)
	{
		global $_GPC;
		global $_W;
		$condition = array();
		$condition['type'] = array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH);
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition['keyword'] = $keyword;
		}

		if (isset($_GPC['letter']) && strlen($_GPC['letter']) == 1) {
			$condition['letter'] = trim($_GPC['letter']);
		}

		$account_lists = uni_account_list($condition, array($pindex, $psize));
		return array_values($account_lists);
	}

	public function choose()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_GPC['uniacid']);
		$role = uni_permission($_W['uid'], $uniacid);

		if (empty($role)) {
			message('操作失败, 非法访问.');
		}

		if (function_exists('uni_account_save_switch')) {
			uni_account_save_switch($uniacid);
		}

		isetcookie('__uniacid', $uniacid, 7 * 86400);
		isetcookie('__uid', $_W['uid'], 7 * 86400);
		header('location: ' . webUrl('shop'));
	}
}

?>
