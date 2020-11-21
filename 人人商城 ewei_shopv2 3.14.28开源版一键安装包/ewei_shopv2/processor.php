<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once IA_ROOT . '/addons/ewei_shopv2/version.php';
require_once IA_ROOT . '/addons/ewei_shopv2/defines.php';
require_once EWEI_SHOPV2_INC . 'functions.php';
require_once EWEI_SHOPV2_INC . 'processor.php';
require_once EWEI_SHOPV2_INC . 'plugin_model.php';
require_once EWEI_SHOPV2_INC . 'com_model.php';
class Ewei_shopv2ModuleProcessor extends Processor
{
	public function respond()
	{
		return parent::respond();
	}
}

?>
