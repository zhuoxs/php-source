<?php
//QQ63779278
require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/page_cashier.php';
class Login_EweiShopV2Page extends CashierWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if (!empty($_GPC['auth_code'])) {
			$auth_code = authcode(base64_decode($_GPC['auth_code']), 'DECODE', 'ewei_shopv2_cashier');

			if ($auth_code) {
				$account = explode('|', $auth_code);
				$this->login($account[0], $account[1], $account[2]);
			}
		}

		if ($_W['ispost'] && $_W['isajax']) {
			$username = trim($_GPC['username']);
			$password = trim($_GPC['password']);
			$is_operator = intval($_GPC['is_operator']);
			$this->login($username, $password, NULL, $is_operator);
		}

		$submitUrl = cashierUrl('login');
		$set = $this->set;
		include $this->template();
	}

	public function login($username, $password, $salt = NULL, $is_operator = 0)
	{
		global $_W;
		global $_GPC;

		if ($is_operator == 0) {
			$user = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_cashier_user') . ' WHERE username=:username AND uniacid=:uniacid AND status=1 AND deleted=0 LIMIT 1', array(':username' => $username, ':uniacid' => $_W['uniacid']));
		}
		else {
			$operator = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_cashier_operator') . ' WHERE username=:username AND uniacid=:uniacid LIMIT 1', array(':username' => $username, ':uniacid' => $_W['uniacid']));

			if (empty($operator)) {
				show_json(0, '用户名不存在!');
			}

			$password = md5($password . $operator['salt']);

			if ($operator['password'] != $password) {
				show_json(0, '用户名密码错误!');
			}

			$perm = json_decode($operator['perm'], true);

			if (empty($perm)) {
				show_json(0, '用户没有有任何权限!');
			}

			$user = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_cashier_user') . ' WHERE id=:id AND uniacid=:uniacid AND status=1 AND deleted=0 LIMIT 1', array(':id' => $operator['cashierid'], ':uniacid' => $_W['uniacid']));

			if (!empty($user)) {
				$user['operator'] = $operator;
				session_start();
				$_SESSION['__cashier_' . (int) $_GPC['i'] . '_session'] = $user;
				show_json(1, array('url' => cashierUrl($perm[0])));
			}
			else {
				show_json(0, '用户名不存在!');
			}
		}

		if ($salt !== NULL) {
			if (!empty($user)) {
				if ($user['salt'] == $salt && $user['password'] == $password) {
					session_start();
					$_SESSION['__cashier_' . (int) $_GPC['i'] . '_session'] = $user;
					header('Location:' . cashierUrl('index'));
					exit();
				}
			}

			header('Location:' . cashierUrl('login'));
			exit();
		}
		else if (!empty($user)) {
			if ($user['deleted']) {
				show_json(0, '该用户已被删除!');
			}

			$password = md5($password . $user['salt']);

			if ($user['password'] == $password) {
				session_start();
				$_SESSION['__cashier_' . (int) $_GPC['i'] . '_session'] = $user;
				show_json(1, array('url' => cashierUrl('index')));
			}
			else {
				show_json(0, '用户名密码错误!');
			}
		}
		else {
			show_json(0, '用户名不存在!');
		}
	}
}

?>
