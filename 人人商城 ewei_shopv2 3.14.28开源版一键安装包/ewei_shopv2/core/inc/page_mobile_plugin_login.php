<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class PluginMobileLoginPage extends PluginMobilePage
{
	public function __construct()
	{
		global $_W;
		global $_GPC;
		parent::__construct();
	}
}

?>
