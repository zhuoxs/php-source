<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class DividendMobileLoginPage extends PluginMobileLoginPage
{
	public function __construct()
	{
		parent::__construct();
		global $_W;
		global $_GPC;

		if (empty($this->set['open'])) {
			$this->message('团队分红未开启');
			exit();
		}

		if ($_W['action'] != 'register' && $_W['action'] != 'share') {
			$member = m('member')->getMember($_W['openid']);
			if ($member['isheads'] != 1 || $member['headsstatus'] != 1 || $member['isagent'] != 1 || $member['status'] != 1) {
				header('location:' . mobileUrl('dividend/register'));
				exit();
			}
		}
	}
}

?>
