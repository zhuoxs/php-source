<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require IA_ROOT. '/addons/feng_fightgroups/core/common/defines.php';
require TG_CORE . 'class/wlloader.class.php';
wl_load()->func('global');
class Feng_fightgroupsModule extends WeModule
{
	public function welcomeDisplay()
	{
		header('location: ' . web_url('store/setting'));
		exit();
	}
}

?>
