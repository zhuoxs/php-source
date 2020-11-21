<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
} 

define('MERCHANT_DEBUG', TRUE);
define('MERCHANT_NAME', 'feng_merchants');

!defined('MERCHANT_PATH') && define('MERCHANT_PATH', IA_ROOT . '/addons/feng_merchants/');
!defined('MERCHANT_CORE') && define('MERCHANT_CORE', MERCHANT_PATH . 'core/');
!defined('MERCHANT_APP') && define('MERCHANT_APP', MERCHANT_PATH . 'app/');
!defined('MERCHANT_WEB') && define('MERCHANT_WEB', MERCHANT_PATH . 'web/');
!defined('MERCHANT_DATA') && define('MERCHANT_DATA', MERCHANT_PATH . 'data/');
!defined('MERCHANT_CERT') && define('MERCHANT_CERT', MERCHANT_PATH . 'cert/');
