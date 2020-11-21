<?php
defined('IN_IA') or exit('Access Denied');
require IA_ROOT. '/addons/feng_merchants/core/common/defines.php';
require IA_ROOT. '/addons/feng_fightgroups/core/common/defines.php';
require MERCHANT_CORE . 'class/wlloader.class.php';
wl_load()->func('global');
wl_load()->func('pdo');
wl_load()->func('tpl');
wl_load()->func('message');
$merchantid = merchant();
!defined('MERCHANTID') && define('MERCHANTID', $merchantid);
class Feng_merchantsModuleSite extends WeModuleSite {
	public function __call($name, $arguments) {
		$isWeb = stripos($name, 'doWeb') === 0;
		$isMobile = stripos($name, 'doMobile') === 0;
		if($isWeb || $isMobile) {
			$dir = IA_ROOT . '/addons/' . $this->modulename . '/';
			if($isWeb) {
				$dir .= 'web/';
				$controller = strtolower(substr($name, 5));
			}
			if($isMobile) {
				$dir .= 'app/';
				$controller = strtolower(substr($name, 8));
			}
			$file = $dir . 'index.php';
			if(file_exists($file)) {
				require $file;
				exit;
			}
		}
		trigger_error("访问的方法 {$name} 不存在.", E_USER_WARNING);
		return null;
	}
}
