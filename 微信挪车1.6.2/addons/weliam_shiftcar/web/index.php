<?php
defined('IN_IA') or exit('Access Denied');
wl_load()->web('nav');
wl_load()->model('syssetting');
load()->func('communication');

$_W['plugin'] = $plugin = !empty($_GPC['do']) ? $_GPC['do'] : 'dashboard';
$_W['controller'] = $action = !empty($_GPC['ac']) ? $_GPC['ac'] : 'index';
$_W['method'] = $method = $op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';

//$auth = wl_syssetting_read('auth');
$getlistFrames = 'get'.$plugin.'Frames';
if (!function_exists($getlistFrames)) {
	$config = Plugins::ext_plugin_config($plugin);
	if(empty($config['menus']) || $config['setting']['system'] != 'true') {
		message('您访问的应用不存在，请重试！');
	}
	$_W['frames'] = $config['menus'];
} else {
	$_W['frames'] = $getlistFrames();
}
$_W['top_menus'] = get_top_menus();

//if (empty($auth) && $plugin != 'system') {
	//header("Location: index.php?c=site&a=entry&m=".WL_NAME."&do=system&ac=auth");
	//exit;
//}
if (!empty($auth2) && $plugin != 'system') {
	$addressid = pdo_getcolumn('weliam_shiftcar_wechataddr',array('acid' => $_W['acid']),'addressid');
	if (empty($addressid) && !empty($auth2) && $plugin != 'system') {
		message('您还未添加公众号运营地区！', web_url('system/account'),'success');
	}
}

$file = WL_WEB . 'controller/'.$plugin.'/'.$action.'.ctrl.php';
if(!file_exists($file)) {
	$file = WL_PATH . 'plugin/' . $plugin . '/sys/controller/' . $action . '.ctrl.php';
	if(file_exists($file)) {
		require_once $file;
		$class = ucfirst($action) . '_WeliamController';
		$instance = new $class();

		if (!method_exists($instance, $method)) {
			trigger_error('控制器 ' . $action . ' 方法 ' . $method . ' 未找到!');
		}
		$instance->$method();
	}else{
		trigger_error("访问的模块 {$plugin} 不存在.", E_USER_WARNING);
	}
} else {
	require_once $file;
}