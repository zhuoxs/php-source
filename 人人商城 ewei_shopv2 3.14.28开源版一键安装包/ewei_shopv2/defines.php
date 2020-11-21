<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}


define('EWEI_SHOPV2_DEBUG', false);
!(defined('EWEI_SHOPV2_PATH')) && define('EWEI_SHOPV2_PATH', IA_ROOT . '/addons/ewei_shopv2/');
!(defined('EWEI_SHOPV2_CORE')) && define('EWEI_SHOPV2_CORE', EWEI_SHOPV2_PATH . 'core/');
!(defined('EWEI_SHOPV2_DATA')) && define('EWEI_SHOPV2_DATA', EWEI_SHOPV2_PATH . 'data/');
!(defined('EWEI_SHOPV2_VENDOR')) && define('EWEI_SHOPV2_VENDOR', EWEI_SHOPV2_PATH . 'vendor/');
!(defined('EWEI_SHOPV2_CORE_WEB')) && define('EWEI_SHOPV2_CORE_WEB', EWEI_SHOPV2_CORE . 'web/');
!(defined('EWEI_SHOPV2_CORE_MOBILE')) && define('EWEI_SHOPV2_CORE_MOBILE', EWEI_SHOPV2_CORE . 'mobile/');
!(defined('EWEI_SHOPV2_CORE_SYSTEM')) && define('EWEI_SHOPV2_CORE_SYSTEM', EWEI_SHOPV2_CORE . 'system/');
!(defined('EWEI_SHOPV2_PLUGIN')) && define('EWEI_SHOPV2_PLUGIN', EWEI_SHOPV2_PATH . 'plugin/');
!(defined('EWEI_SHOPV2_PROCESSOR')) && define('EWEI_SHOPV2_PROCESSOR', EWEI_SHOPV2_CORE . 'processor/');
!(defined('EWEI_SHOPV2_INC')) && define('EWEI_SHOPV2_INC', EWEI_SHOPV2_CORE . 'inc/');
!(defined('EWEI_SHOPV2_URL')) && define('EWEI_SHOPV2_URL', $_W['siteroot'] . 'addons/ewei_shopv2/');
!(defined('EWEI_SHOPV2_TASK_URL')) && define('EWEI_SHOPV2_TASK_URL', $_W['siteroot'] . 'addons/ewei_shopv2/core/task/');
!(defined('EWEI_SHOPV2_LOCAL')) && define('EWEI_SHOPV2_LOCAL', '../addons/ewei_shopv2/');
!(defined('EWEI_SHOPV2_STATIC')) && define('EWEI_SHOPV2_STATIC', EWEI_SHOPV2_URL . 'static/');
!(defined('EWEI_SHOPV2_PREFIX')) && define('EWEI_SHOPV2_PREFIX', 'ewei_shop_');
define("EWEI_SHOPV2_AUTH_WXAPP","http://www.efwww.com");
define('EWEI_SHOPV2_PLACEHOLDER', '../addons/ewei_shopv2/static/images/placeholder.png');

?>