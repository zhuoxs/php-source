<?php
defined('IN_IA') or exit('Access Denied');
wl_load()->model('syssetting');
wl_load()->model('setting');
wl_load()->model('mc');

wlsetting_load();
$_W['wlmember'] = checkMember();
$_W['mid'] = $_W['wlmember']['id'];
puv();

$controller = $_GPC['do'];
$action = $_GPC['ac'];
$op = $_GPC['op'];
if (empty($controller) || empty($action)) {
	$_GPC['do'] = $controller = 'home';
	$_GPC['ac'] = $action = 'index';
}

$file = WL_APP . 'controller/'.$controller.'/'.$action.'.ctrl.php';
if (!file_exists($file)) {
	header("Location: index.php?i={$_W['uniacid']}&c=entry&do=home&ac=index&m=".WL_NAME);
	exit;
}

require $file;
