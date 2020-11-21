<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require IA_ROOT. '/addons/weliam_shiftcar/core/common/defines.php';
require WL_CORE . 'class/wlloader.class.php';
wl_load()->func('global');
class Weliam_shiftcarModule extends WeModule
{
	public function welcomeDisplay()
	{
		header('location: ' . web_url('dashboard/index'));
		exit();
	}
}

?>
