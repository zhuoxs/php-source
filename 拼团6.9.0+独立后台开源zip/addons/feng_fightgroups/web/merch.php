<?php
define('IN_SYS', true);
require_once '../../../framework/bootstrap.inc.php';
require_once IA_ROOT. '/addons/feng_fightgroups/web/common/bootstrap.sys.inc.php';
require_once IA_ROOT. '/addons/feng_fightgroups/core/common/defines.php';
require_once TG_CORE . 'class/wlloader.class.php';
require_once TG_PATH.'web/common/common.func.php';
require_once TG_PATH.'web/common/template.func.php';
$autoload = TG_CORE . 'class/autoload.php';
if(file_exists($autoload)) {
	require $autoload;
}
wl_load()->func('tpl');
wl_load()->func('pdo');
wl_load()->func('global');
wl_load()->func('template');
load()->func('communication');
global $_W,$_GPC;
$_W['attachurl'] = $_W['attachurl_local'] = $_W['siteroot'] . $_W['config']['upload']['attachdir'] . '/';
if (!empty($_W['setting']['remote']['type'])) {
	if ($_W['setting']['remote']['type'] == 1) {
		$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['ftp']['url'] . '/';
	} elseif ($_W['setting']['remote']['type'] == 2) {
		$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['alioss']['url'].'/';
	} elseif ($_W['setting']['remote']['type'] == 3) {
		$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['qiniu']['url'].'/';
	} elseif ($_W['setting']['remote']['type'] == 4) {
		$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['cos']['url'].'/';
	}
}
if($_GPC['c'] == 'utility'){
	if (!empty($_GPC['__uniacid']) && empty($_W['uniacid'])) {
		
		$_W['uniacid'] = intval($_GPC['__uniacid']);
	}
	
	if (!empty($_W['uniacid'])) {
		$_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
		$_W['acid'] = $_W['account']['acid'];
		$_W['weid'] = $_W['uniacid'];
	}
	require TG_PATH .'/web/source/utility/file.ctrl.php';
	exit;
}
session_start();
if($_SESSION['role']!='merchant'){
	require TG_PATH .'/web/source/user/login.ctrl.php';
}else{
	if($_GPC['do']=='user' && $_GPC['ac']=='logout'){
		$_SESSION['role']='';
		require TG_PATH .'/web/source/user/login.ctrl.php';
	}else{
		define('UNIACID', $_GPC['__uniacid']);
		define('TG_ID', " and id = '{$_SESSION['role_id']}' ");
		define('TG_MERCHANTID', " and merchantid = '{$_SESSION['role_id']}' ");
		define('MERCHANTID', $_SESSION['role_id']);
		$_W['uniacid'] = $_GPC['__uniacid'];
		$controller = $_GPC['do'];
		$action = $_GPC['ac'];
		$op = $_GPC['op'];
		if(empty($controller) || empty($action)) {
			$_GPC['do'] = $controller = 'store';
			$_GPC['ac'] = $action = 'setting';
		}
		if($_GPC['do']!='store' && $_GPC['ac']!='plugins'){
			$flag = allow($controller, $action, $op, $_SESSION['role_id']);
			if(!$flag){
				message("权限不足，如有需要请联系系统管理员",referer(),'error');
			}
		}
		
		$getlistFrames = 'get'.$controller.'Frames';
		$frames = $getlistFrames();
		$top_menus = get_top_menus();
		$file = TG_WEB . 'controller/'.$controller.'/'.$action.'.ctrl.php';
		require $file;
	}
}
