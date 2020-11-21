<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class AbonusMobileLoginPage extends PluginMobileLoginPage
{
	public function __construct()
	{
		parent::__construct();
		global $_W;
		global $_GPC;
		if ($_W['action'] != 'register' && $_W['action'] != 'myshop' && $_W['action'] != 'share') {
			$member = m('member')->getMember($_W['openid']);
			if (empty($member['isagent']) || empty($member['status'])) {
				header('location: ' . mobileUrl('commission/register'));
				exit();
			}

			if (empty($member['isaagent']) || empty($member['aagentstatus'])) {
				header('location: ' . mobileUrl('abonus/register'));
				exit();
			}
		}
	}

	public function footerMenus($diymenuid = NULL, $p = NULL, $texts = array())
	{
		global $_W;
		global $_GPC;
		include $this->template('abonus/_menu');
	}
}

?>
