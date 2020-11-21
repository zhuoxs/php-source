<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}


require EWEI_SHOPV2_PLUGIN . 'merchmanage/core/inc/page_merchmanage.php';
class Login_EweiShopV2Page extends MerchmanageMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$check = $this->isLogin();

		if ($check) {
			header('location: ' . mobileUrl('merchmanage'));
		}


		$backurl = trim($_GPC['backurl']);

		if ($_W['ispost']) {
			
			if (!(empty($backurl))) {
				$backurl = base64_decode(urldecode($backurl));
				$backurl = './index.php?' . $backurl;
			}

			$username = trim($_GPC['username']);
			$password = trim($_GPC['password']);

			if (empty($username)) {
				show_json(0, '请填写用户名');
			}


			if (empty($password)) {
				show_json(0, '请填写密码');
			}

			
			if (!($this->model->merch_user_check(array('username' => $username)))) {
				show_json(0, '用户不存在');
			}


			if (!($this->model->merch_user_check(array('username' => $username, 'pwd' => $password)))) {
				show_json(0, '用户名或密码错误');
			}
			
			
			$account = $this->model->merch_user_single(array('username' => $username));
			$user = pdo_fetch('select status,accounttime from ' . tablename('ewei_shop_merch_user') . ' where uniacid=:uniacid and accountid=:accountid limit 1', array(':uniacid' => $_W['uniacid'], ':accountid' => $account['id']));

			if (0 < (int) $user['accounttime']) {
				if ((int) $user['accounttime'] <= time()) {
					show_json(0, '账号已过期，请联系商家咨询!');
				}
			}

			if (!empty($user)) {
				if ($user['status'] == 2) {
					show_json(0, '帐号暂停中,请联系管理员!');
				}
			}
			
			$account = $this->model->merch_user_single(array('username' => $username));
			$account['hash'] = md5($account['pwd'] . $account['salt']);
			$session = base64_encode(json_encode($account));
			$session_key = '__merchmanage_' . $_W['uniacid'] . '_session';
			
			isetcookie($session_key, $session, 7200);
			$status = array();
			$status['lastvisit'] = TIMESTAMP;
			$status['lastip'] = CLIENT_IP;
			pdo_update('ewei_shop_merch_account', $status, array('id' => $account['id']));
			
			show_json(1, array('backurl' => $backurl));
		}

		$shopset = $_W['shopset'];
		$logo = tomedia($shopset['shop']['logo']);
		if (is_weixin() || (!(empty($shopset['wap']['open'])) && empty($shopset['wap']['inh5app']))) {
			$goshop = true;
		}


		include $this->template();
	}

	public function logout()
	{
		global $_W;
		global $_GPC;
		$session_key = '__merchmanage_' . $_W['uniacid'] . '_session';
		isetcookie($session_key, false, -100);
		unset($GLOBALS['_W']['merchmanage']);

		if ($_W['isajax']) {
			show_json(1);
		}else{
			header('location: ' . mobileUrl('merchmanage/login'));
		}
	}
}


?>