<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/page_cashier.php';
class Operator_EweiShopV2Page extends CashierWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, $_GPC['page']);
		$psize = 20;
		$where = '';
		$params = array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']);

		if (!empty($_GPC['keyword'])) {
			$where = ' AND title LIKE :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_cashier_operator') . (' WHERE uniacid=:uniacid AND cashierid=:cashierid ' . $where . ' ORDER BY id DESC'), $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_cashier_operator') . (' WHERE uniacid=:uniacid AND cashierid=:cashierid ' . $where . ' LIMIT 1'), $params);
		$openids = array();

		foreach ($list as $value) {
			if (!empty($value['manageopenid'])) {
				$openids[] = $value['manageopenid'];
			}
		}

		if (!empty($openids)) {
			$member = pdo_fetchall('SELECT id,openid,nickname,realname FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid=:uniacid AND openid IN (\'' . implode(',', $openids) . '\')', array(':uniacid' => $_W['uniacid']), 'openid');
		}

		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function add()
	{
		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$perm = array();

		if ($id) {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_cashier_operator') . ' WHERE id=:id AND cashierid=:cashierid limit 1', array(':id' => $id, ':cashierid' => $_W['cashierid']));

			if (!empty($item['manageopenid'])) {
				$manageopenid = m('member')->getMember($item['manageopenid']);
			}

			$perm = json_decode($item['perm'], true);
		}

		if ($_W['ispost']) {
			$params = array('uniacid' => $_W['uniacid'], 'cashierid' => $_W['cashierid'], 'title' => $_GPC['title'], 'manageopenid' => $_GPC['manageopenid'], 'perm' => !empty($_GPC['perm']) ? json_encode($_GPC['perm']) : '', 'username' => $_GPC['username'], 'password' => !empty($_GPC['password']) ? $_GPC['password'] : '');
			$user_totle = (int) pdo_fetchcolumn('SELECT id FROM ' . tablename('ewei_shop_cashier_operator') . ' WHERE username=:username AND uniacid=:uniacid LIMIT 1', array(':username' => $params['username'], ':uniacid' => $_W['uniacid']));

			if ($id) {
				if ($user_totle && $user_totle != $id) {
					show_json(0, '该登录用户名称,已经存在!请更换!');
				}
			}
			else {
				if ($user_totle) {
					show_json(0, '该登录用户名称,已经存在!请更换!');
				}
			}

			if (empty($params['username'])) {
				show_json(0, '请填写后台登录用户名!');
			}

			if (!empty($params['password'])) {
				$params['salt'] = random(8);
				$params['password'] = md5(trim($params['password']) . $params['salt']);
			}
			else {
				unset($params['password']);
			}

			if (!$id) {
				$params['createtime'] = TIMESTAMP;
				pdo_insert('ewei_shop_cashier_operator', $params);
				$id = pdo_insertid();
			}
			else {
				pdo_update('ewei_shop_cashier_operator', $params, array('id' => $id, 'cashierid' => $params['cashierid']));
			}

			show_json(1, array('url' => cashierUrl('sysset/operator/edit', array('id' => $id))));
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

		pdo_query('DELETE FROM ' . tablename('ewei_shop_cashier_operator') . (' WHERE id in(' . $id . ') AND cashierid=' . $_W['cashierid'] . ' AND uniacid=') . $_W['uniacid']);
		pdo_query('UPDATE ' . tablename('ewei_shop_cashier_pay_log') . (' SET operatorid=0 WHERE operatorid in(' . $id . ') AND cashierid=' . $_W['cashierid'] . ' AND uniacid=') . $_W['uniacid']);
		show_json(1);
	}

	public function viewqr()
	{
		global $_W;
		global $_GPC;
		$id = trim($_GPC['id']);

		if (empty($id)) {
			return false;
		}

		$url = mobileUrl('cashier/pay', array('cashierid' => $_W['cashierid'], 'id' => $id), true);
		$img = cashierUrl('qr', array('url' => $url));
		include $this->template();
	}
}

?>
