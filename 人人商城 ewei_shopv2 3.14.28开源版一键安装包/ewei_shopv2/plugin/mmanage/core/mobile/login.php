<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'mmanage/core/inc/page_mmanage.php';
class Login_EweiShopV2Page extends MmanageMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$check = $this->isLogin();

		if ($check) {
			header('location: ' . mobileUrl('mmanage'));
		}

		$backurl = trim($_GPC['backurl']);

		if ($_W['ispost']) {
			$type = trim($_GPC['type']);

			if (!empty($backurl)) {
				$backurl = base64_decode(urldecode($backurl));
				$backurl = './index.php?' . $backurl;
			}

			load()->model('user');

			if ($type == 'wechat') {
				if (empty($_W['openid'])) {
					show_json(0, '未获取到当前用户信息，请刷新重试');
				}

				$roleuser = pdo_fetch('SELECT id, uid, username, status FROM' . tablename('ewei_shop_perm_user') . 'WHERE openid=:openid AND uniacid=:uniacid LIMIT 1', array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));

				if (empty($roleuser)) {
					show_json(0, '当前账号未绑定操作员');
				}

				if (empty($roleuser['status'])) {
					show_json(0, '此账号暂时无法登录管理后台');
				}

				$account = user_single($roleuser['uid']);

				if (!$account) {
					show_json(0, '当前账号未绑定操作员');
				}

				$account['hash'] = md5($account['password'] . $account['salt']);
				$session = base64_encode(json_encode($account));
				$session_key = '__mmanage_' . $_W['uniacid'] . '_session';
				isetcookie($session_key, $session, 7200);
				show_json(1, array('backurl' => $backurl));
			}
			else {
				$username = trim($_GPC['username']);
				$password = trim($_GPC['password']);

				if (empty($username)) {
					show_json(0, '请填写用户名');
				}

				if (empty($password)) {
					show_json(0, '请填写密码');
				}

				if (!user_check(array('username' => $username))) {
					show_json(0, '用户不存在');
				}

				if (!user_check(array('username' => $username, 'password' => $password))) {
					show_json(0, '用户名或密码错误');
				}

				$account = user_single(array('username' => $username));
				$founders = explode(',', $_W['config']['setting']['founder']);

				if (!in_array($account['uid'], $founders)) {
					if ($account['status'] != 2) {
						show_json(0, '操作员已被禁用');
					}
				}

				$permission = $this->model->uni_permission($account['uid'], $_W['uniacid']);

				if (empty($permission)) {
					show_json(0, '此账号没有管理权限');
				}

				$account['hash'] = md5($account['password'] . $account['salt']);
				$session = base64_encode(json_encode($account));
				$session_key = '__mmanage_' . $_W['uniacid'] . '_session';
				isetcookie($session_key, $session, 7200);
				show_json(1, array('backurl' => $backurl));
			}
		}

		$shopset = $_W['shopset'];
		$logo = tomedia($shopset['shop']['logo']);
		$name = $shopset['shop']['name'];
		if (is_weixin() || !empty($shopset['wap']['open']) && empty($shopset['wap']['inh5app'])) {
			$goshop = true;
		}

		include $this->template();
	}

	public function logout()
	{
		global $_W;
		global $_GPC;
		$session_key = '__mmanage_' . $_W['uniacid'] . '_session';
		isetcookie($session_key, false, -100);
		unset($GLOBALS['_W']['mmanage']);

		if ($_W['isajax']) {
			show_json(1);
		}
		else {
			header('location: ' . mobileUrl('mmanage/login'));
		}
	}
}

?>
