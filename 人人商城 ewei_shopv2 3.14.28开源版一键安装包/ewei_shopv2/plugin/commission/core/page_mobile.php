<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class CommissionMobilePage extends PluginMobilePage
{
	public function __construct()
	{
		parent::__construct();
		global $_W;
		global $_GPC;
		if ($_W['action'] != 'register' && $_W['action'] != 'myshop' && $_W['action'] != 'share') {
			$member = m('member')->getMember($_W['openid']);
			if ($member['isagent'] != 1 || $member['status'] != 1) {
				header('location:' . mobileUrl('commission/register'));
				exit();
			}
		}
	}
}

?>
