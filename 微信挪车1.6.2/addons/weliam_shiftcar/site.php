<?php
/**
 * 微信挪车模块微站定义
 *
 */
defined('IN_IA') or exit('Access Denied');
require IA_ROOT. '/addons/weliam_shiftcar/core/common/defines.php';
require WL_CORE . 'class/wlloader.class.php';
if(file_exists(WL_AUTOLOAD)) require WL_AUTOLOAD;
wl_load()->func('global');
wl_load()->func('pdo');

class Weliam_shiftcarModuleSite extends WeModuleSite {
	
	public function __call($name, $arguments) {
		global $_W,$_GPC;
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
	
	public function payResult($params) {
	    //根据参数params中的result来判断支付是否成功
	    if ($params['result'] == 'success' && $params['from'] == 'notify') {
	    	$data = array('status' => 1);
	        $re = pdo_update('weliam_shiftcar_apply',$data,array('ordersn' => $params['tid']));
	    }

	    //如果消息是用户直接返回（非通知），则提示一个付款成功
	    if ($params['from'] == 'return') {
	        if ($params['result'] == 'success') {
	            message('支付成功！请耐心等待发货。', app_url('app/apply/list'), 'success');
	        } else {
	            message('支付失败！', app_url('app/apply/post'), 'error');
	        }
	    }
	}
}