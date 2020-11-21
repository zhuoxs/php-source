<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class MmanageMobilePage extends PluginMobilePage
{
	public function __construct($_com = '', $_init = false)
	{
		global $_W;
		global $_GPC;

		if (empty($_GPC['i'])) {
			$this->message('公众号参数错误');
		}

		$GLOBALS['_W']['uniacid'] = intval($_GPC['i']);
		parent::__construct(false);
		$this->set = m('common')->getPluginset('mmanage');

		if (empty($this->set['open'])) {
			$this->message('暂未开放', mobileUrl());
		}

		$this->checkLogin();
		$this->setShare();
	}

	protected function checkLogin()
	{
		global $_W;
		global $_GPC;

		if ($_W['controller'] != 'login') {
			load()->model('user');
			$islogin = $this->isLogin();

			if ($islogin) {
				$GLOBALS['_W']['mmanage'] = $islogin;
				$GLOBALS['_W']['role'] = '';

				if (p('mmanage')) {
					$GLOBALS['_W']['role'] = p('mmanage')->uni_permission($islogin['uid'], $_W['uniacid']);
				}

				$GLOBALS['_W']['uid'] = $islogin['uid'];
				return NULL;
			}

			unset($GLOBALS['_W']['mmanage']);
			$session_key = '__mmanage_' . $_W['uniacid'] . '_session';
			isetcookie($session_key, false, -100);
			$backurl = urlencode(base64_encode($_SERVER['QUERY_STRING']));
			header('location: ' . mobileUrl('mmanage/login', array('backurl' => $backurl)));
			exit();
		}
	}

	protected function isLogin()
	{
		global $_W;
		global $_GPC;
		load()->model('user');
		$session_key = '__mmanage_' . $_W['uniacid'] . '_session';
		$session = json_decode(base64_decode($_GPC[$session_key]), true);

		if (is_array($session)) {
			$account = user_single(array('username' => $session['username']));
			if (is_array($account) && $session['hash'] == md5($account['password'] . $account['salt'])) {
				return $account;
			}
		}

		return false;
	}

	protected function setShare()
	{
		global $_W;
		$shopset = $_W['shopset']['shop'];
		$set = $this->set;
		$GLOBALS['_W']['shopshare'] = array('title' => !empty($set['title']) ? $set['title'] : $shopset['name'] . '管理后台', 'imgUrl' => !empty($set['thumb']) ? tomedia($set['thumb']) : tomedia($shopset['logo']), 'desc' => !empty($set['desc']) ? $set['desc'] : $shopset['description'], 'link' => mobileUrl('mmanage', array(), true));
	}
}

?>
