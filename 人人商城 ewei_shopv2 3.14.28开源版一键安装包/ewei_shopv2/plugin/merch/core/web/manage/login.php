<?php
//dezend by http://www.efwww.com/
class Login_EweiShopV2Page extends Page
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$i = intval($_GPC['i']);

		if (empty($i)) {
			$_W['uniacid'] = $_COOKIE[$_W['config']['cookie']['pre'] . '__uniacid'];
		}
		else {
			$_W['uniacid'] = $i;
		}

		$_SESSION['__merch_uniacid'] = $_W['uniacid'];
		$set = m('common')->getPluginset('merch', $_W['uniacid']);

		if ($_W['ispost']) {
			$username = trim($_GPC['username']);
			$pwd = trim($_GPC['pwd']);

			if (empty($username)) {
				show_json(0, '请输入用户名!');
			}

			if (empty($pwd)) {
				show_json(0, '请输入密码!');
			}

			$account = pdo_fetch('select * from ' . tablename('ewei_shop_merch_account') . ' where uniacid=:uniacid and username=:username limit 1', array(':uniacid' => $_W['uniacid'], ':username' => $username));

			if (empty($account)) {
				show_json(0, '用户未找到!');
			}

			$pwd = md5($pwd . $account['salt']);

			if ($account['pwd'] != $pwd) {
				show_json(0, '用户密码错误!');
			}

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

			$account['hash'] = md5($account['pwd'] . $account['salt']);
			$session = base64_encode(json_encode($account));
			$session_key = '__merch_' . $account['uniacid'] . '_session';
			isetcookie($session_key, $session, 0, true);
			$status = array();
			$status['lastvisit'] = TIMESTAMP;
			$status['lastip'] = CLIENT_IP;
			pdo_update('ewei_shop_merch_account', $status, array('id' => $account['id']));
			$url = $_W['siteroot'] . ('web/merchant.php?c=site&a=entry&i=' . $account['uniacid'] . '&m=ewei_shopv2&do=web&r=shop');
			show_json(1, array('url' => $url));
		}

		$submitUrl = $_W['siteroot'] . ('web/merchant.php?c=site&a=entry&i=' . $_COOKIE[$_W['config']['cookie']['pre'] . '__uniacid'] . '&m=ewei_shopv2&do=web&r=login');
		$set['regpic'] = $this->getImage($set, 'regpic');
		$set['reglogo'] = $this->getImage($set, 'reglogo');
		include $this->template('merch/manage/login');
	}

	private function getImage($set, $f)
	{
		global $_W;
		$remote = $_W['setting']['remote'];
		$uniacid = $_W['uniacid'];
		$url = $set[$f];

		if (empty($url)) {
			return '';
		}

		if (!empty($remote[$uniacid])) {
			return $this->takeUrl($url, $remote[$uniacid]);
		}

		return $this->takeUrl($url);
	}

	private function takeUrl($url, $remote = array())
	{
		global $_W;
		if (strexists($url, 'http://') || strexists($url, 'https://')) {
			return $url;
		}

		if (empty($remote)) {
			$remote = $_W['setting']['remote'];
		}

		$type = $remote['type'];
		$typeStr = '';

		switch ($type) {
		case 1:
			$typeStr = 'ftp';
			break;

		case 2:
			$typeStr = 'alioss';
			break;

		case 3:
			$typeStr = 'qiniu';
			break;

		case 4:
			$typeStr = 'cos';
			break;

		default:
			continue;
		}

		return $remote[$typeStr]['url'] . '/' . $url;
	}
}

?>
