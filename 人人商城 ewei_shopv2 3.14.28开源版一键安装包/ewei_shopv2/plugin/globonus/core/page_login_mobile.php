<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class GlobonusMobileLoginPage extends PluginMobileLoginPage
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

			if (empty($member['ispartner']) || empty($member['partnerstatus'])) {
				header('location: ' . mobileUrl('globonus/register'));
				exit();
			}
		}
	}

	public function footerMenus($diymenuid = '', $ismerch = '', $texts = '')
	{
		global $_W;
		global $_GPC;
		include $this->template('globonus/_menu');
	}
}

?>
