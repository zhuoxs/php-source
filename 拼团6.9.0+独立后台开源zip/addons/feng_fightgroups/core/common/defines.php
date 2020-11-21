<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
} 

define('TG_DEBUG', TRUE);
define('TG_NAME', 'feng_fightgroups');

!defined("MODULE_NAME") && define("MODULE_NAME", "feng_fightgroups");
!defined('WL_URL_AUTH') && define('WL_URL_AUTH', 'http://weixin.weliam.cn/api/api.php');
!defined('TG_PATH') && define('TG_PATH', IA_ROOT . '/addons/feng_fightgroups/');
!defined('TG_CORE') && define('TG_CORE', TG_PATH . 'core/');
!defined('TG_APP') && define('TG_APP', TG_PATH . 'app/');
!defined('TG_WEB') && define('TG_WEB', TG_PATH . 'web/');
!defined('TG_DATA') && define('TG_DATA', TG_PATH . 'data/');
!defined('TG_CERT') && define('TG_CERT', TG_PATH . 'cert/');

!defined('TG_URL') && define('TG_URL', $_W['siteroot'] . 'addons/feng_fightgroups/');
!defined('TG_URL_APP') && define('TG_URL_APP', TG_URL . 'app/');
!defined('TG_URL_WEB') && define('TG_URL_WEB', TG_URL . 'web/');
!defined('TG_URL_ARES') && define('TG_URL_ARES', TG_URL . 'app/resource/');
!defined('TG_URL_WRES') && define('TG_URL_WRES', TG_URL . 'web/resource/');

!defined('IMAGE_PIXEL') && define('IMAGE_PIXEL', TG_URL . 'web/resource/images/pixel.gif');
!defined('IMAGE_NOPIC_SMALL') && define('IMAGE_NOPIC_SMALL', TG_URL . 'web/resource/images/nopic-small.jpg');
!defined('IMAGE_LOADING') && define('IMAGE_LOADING', TG_URL . 'web/resource/images/loading.gif');