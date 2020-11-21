<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class DividendMobilePage extends PluginMobilePage
{
	public function __construct()
	{
		parent::__construct();
		global $_W;
		global $_GPC;
	}
}

?>
