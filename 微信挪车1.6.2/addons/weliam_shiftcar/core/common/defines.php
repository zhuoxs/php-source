<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
} 

define('WL_DEBUG', TRUE);
define('WL_NAME', 'weliam_shiftcar');
!defined("PDO_NAME") && define("PDO_NAME", "weliam_shiftcar_");

!defined('WL_PATH') && define('WL_PATH', IA_ROOT . '/addons/'.WL_NAME.'/');
!defined('WL_CORE') && define('WL_CORE', WL_PATH . 'core/');
!defined('WL_APP') && define('WL_APP', WL_PATH . 'app/');
!defined('WL_WEB') && define('WL_WEB', WL_PATH . 'web/');
!defined('WL_SYS') && define('WL_SYS', WL_PATH . 'sys/');
!defined('WL_DATA') && define('WL_DATA', WL_PATH . 'data/');
!defined('WL_CERT') && define('WL_CERT', WL_PATH . 'cert/');
!defined('WL_AUTOLOAD') && define('WL_AUTOLOAD', WL_CORE . 'common/autoload.php');
!defined("PATH_PLUGIN") && define("PATH_PLUGIN",WL_PATH.'plugin/');

!defined('WL_URL') && define('WL_URL', $_W['siteroot'] . 'addons/'.WL_NAME.'/');
!defined('WL_URL_APP') && define('WL_URL_APP', WL_URL . 'app/');
!defined('WL_URL_WEB') && define('WL_URL_WEB', WL_URL . 'web/');
!defined('WL_URL_ARES') && define('WL_URL_ARES', WL_URL . 'app/resource/');
!defined('WL_URL_WRES') && define('WL_URL_WRES', WL_URL . 'web/resource/');
!defined('WL_URL_AUTH') && define('WL_URL_AUTH', '127.0.0.1');

!defined('IMAGE_PIXEL') && define('IMAGE_PIXEL', WL_URL . 'web/resource/images/pixel.gif');
!defined('IMAGE_NOPIC_SMALL') && define('IMAGE_NOPIC_SMALL', WL_URL . 'web/resource/images/nopic-small.jpg');
!defined('IMAGE_LOADING') && define('IMAGE_LOADING', WL_URL . 'web/resource/images/loading.gif');