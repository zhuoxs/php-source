<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

if (!function_exists('getIsSecureConnection')) {
	function getIsSecureConnection()
	{
		if (isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))) {
			return true;
		}

		if (isset($_SERVER['SERVER_PORT']) && '443' == $_SERVER['SERVER_PORT']) {
			return true;
		}

		return false;
	}
}

if (function_exists('getIsSecureConnection')) {
	$secure = getIsSecureConnection();
	$http = $secure ? 'https' : 'http';
	$_W['siteroot'] = strexists($_W['siteroot'], 'https://') ? $_W['siteroot'] : str_replace('http', $http, $_W['siteroot']);
}

require_once IA_ROOT . '/addons/ewei_shopv2/version.php';
require_once IA_ROOT . '/addons/ewei_shopv2/defines.php';
require_once EWEI_SHOPV2_INC . 'functions.php';
class Ewei_shopv2ModuleSite extends WeModuleSite
{
	public function getMenus()
	{
		global $_W;
		return array(
			array('title' => '管理后台', 'icon' => 'fa fa-shopping-cart', 'url' => webUrl())
		);
	}

	public function doWebWeb()
	{
		m('route')->run();
	}

	public function doMobileMobile()
	{
		m('route')->run(false);
	}

	public function payResult($params)
	{
		return m('order')->payResult($params);
	}
}

?>
