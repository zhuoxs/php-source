<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class DividendWebPage extends PluginWebPage
{
	public function __construct()
	{
		parent::__construct();
		global $_W;
		global $_GPC;
		if ($_W['action'] != 'init' && empty($this->set['init']) && $_W['action'] != 'getHandleStatus') {
			header('location: ' . webUrl('dividend/init'));
			exit();
		}

		if ($_W['action'] == 'init' && !empty($this->set['init'])) {
			header('location: ' . webUrl('dividend/index'));
			exit();
		}
	}
}

?>
