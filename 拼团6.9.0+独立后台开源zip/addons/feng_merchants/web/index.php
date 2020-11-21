<?php
define('IN_MOBILE', true);
wl_load()->func('template');
wl_load()->model('permissions');
global $_W,$_GPC;
$controller = $_GPC['do'];
$action = $_GPC['ac'];
$op = $_GPC['op'];
if(empty($controller) || empty($action)) {
	$_GPC['do'] = $controller = 'store';
	$_GPC['ac'] = $action = 'setting';
}
if($controller=='goods' && ($action=='option' || $action=='param')){
	
}else{
	$flag=allow($controller, $action, $op, MERCHANTID);
	if(!$flag){
		message("没有权限!",referer(), 'error');exit;
	}
}
$getlistFrames = 'get'.$controller.'Frames';
$frames = $getlistFrames();
$top_menus = get_top_menus();

$file = MERCHANT_WEB . 'controller/'.$controller.'/'.$action.'.ctrl.php';
if (!file_exists($file)) {
	header("Location: index.php?i={$_W['uniacid']}&c=entry&do=store&ac=setting&m=feng_merchants");
	exit;
}

require $file;

