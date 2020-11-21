<?php
define('IN_MOBILE', true);
define('SIGN', false);
wl_load() -> func('template');
wl_load() -> model('setting');
wl_load() -> model('syssetting');
wl_load() -> model('permissions');
load() -> func('communication');
global $_W, $_GPC;

session_start();
$_SESSION['role'] = '';
$_SESSION['role_id'] = '';
define('UNIACID', '');
define('TG_ID', '');
define('TG_MERCHANTID', '');
define('MERCHANTID', '');

$controller = $_GPC['do'];
$action = $_GPC['ac'];
$op = $_GPC['op'];
if (empty($controller) || empty($action)) {
	$_GPC['do'] = $controller = 'store';
	$_GPC['ac'] = $action = 'setting';
}
$getlistFrames = 'get' . $controller . 'Frames';
$frames = $getlistFrames();
$top_menus = get_top_menus();
$headerconfig = tg_syssetting_read('base');
$file = TG_WEB . 'controller/' . $controller . '/' . $action . '.ctrl.php';
if (!file_exists($file)) {
	header("Location: index.php?c=site&a=entry&m=feng_fightgroups&do=store&ac=setting&op=display&");
	exit ;
}
require $file;
