<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}
define('MODEL_NAME','ox_reathouse');
require_once IA_ROOT . '/addons/'.MODEL_NAME.'/application/bootstrap.php';
class Ox_reathouseModule extends WeModule
{
	public function welcomeDisplay()
	{
        include __DIR__.'/dist/index.html';
	}
}

?>