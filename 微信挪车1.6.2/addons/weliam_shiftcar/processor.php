<?php
/**
 * 微信挪车模块处理程序
 *
 */
defined('IN_IA') or exit('Access Denied');
require IA_ROOT. '/addons/weliam_shiftcar/core/common/defines.php';
require WL_CORE . 'class/wlloader.class.php';
if(file_exists(WL_AUTOLOAD)) require WL_AUTOLOAD;
wl_load()->func('global');
wl_load()->func('pdo');

class Weliam_shiftcarModuleProcessor extends WeModuleProcessor {

	public function respond() {
		global $_W;
		$message = $this -> message;
		qrcard::handle($message);
	}
}