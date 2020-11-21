<?php
define('IN_MOBILE', true);
global $_W, $_GPC;
wl_load() -> model('setting');
wl_load() -> model('member');
load() -> func('communication');

if ($_GPC['ac'] != 'auto_task') {
	checkMember($_W['openid']);
	$openid = getOpenid($_W['openid']);
}
$fansInfo = mc_fansinfo($openid);
//获取用户信息
$_W['wlsetting'] = $config = tgsetting_load();
if ($config['refund']['auto_refund'] == 1) {
	check_refund();
}

$controller = $_GPC['do'];
$action = $_GPC['ac'];
if (empty($controller) || empty($action)) {
	$_GPC['do'] = $controller = 'home';
	$_GPC['ac'] = $action = 'index';
}

$file = TG_APP . 'controller/' . $controller . '/' . $action . '.ctrl.php';
if (!file_exists($file)) {
	header("Location: index.php?i={$_W['uniacid']}&c=entry&do=home&ac=index&m=feng_fightgroups");
	exit ;
}
if ($action != 'group' && $action != 'detail' && $action != 'orderconfirm' && $action != 'addmanage' && $action != 'createadd' && $action != 'cash') {
	session_start();
	unset($_SESSION['goodsid']);
	unset($_SESSION['tuan_id']);
	unset($_SESSION['groupnum']);
	unset($_SESSION['optionid']);
	unset($_SESSION['num']);
}

require $file;
