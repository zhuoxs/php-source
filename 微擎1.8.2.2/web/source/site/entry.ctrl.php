<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');
load()->model('extension');

$eid = intval($_GPC['eid']);
if (!empty($eid)) {
	$entry = module_entry($eid);
} else {
	$entry = pdo_get('modules_bindings', array('module' => trim($_GPC['m']), 'do' => trim($_GPC['do'])));
	if (empty($entry)) {
		$entry = array(
			'module' => $_GPC['m'],
			'do' => $_GPC['do'],
			'state' => $_GPC['state'],
			'direct' => $_GPC['direct']
		);
	}
}
if (empty($entry) || empty($entry['do'])) {
	itoast('非法访问.', '', '');
}

$module = module_fetch($entry['module']);
if (empty($module)) {
	itoast("访问非法, 没有操作权限. (module: {$entry['module']})", '', '');
}

if (!$entry['direct']) {
	checklogin();
	$referer = (url_params(referer()));
	if (empty($_W['isajax']) && empty($_W['ispost']) && empty($_GPC['version_id']) && intval($referer['version_id']) > 0 &&
		($referer['c'] == 'wxapp' ||
		$referer['c'] == 'site' && in_array($referer['a'], array('entry', 'nav')) ||
		$referer['c'] == 'home' && $referer['a'] == 'welcome' ||
		$referer['c'] == 'module' && in_array($referer['a'], array('manage-account', 'permission')))) {
			itoast('', $_W['siteurl'] . '&version_id=' . $referer['version_id']);
	}
	
		if (empty($_W['uniacid']) && $entry['entry'] != 'system_welcome' && $_GPC['module_type'] != 'system_welcome') {
			if (!empty($_GPC['version_id'])) {
				itoast('', url('account/display', array('type' => WXAPP_TYPE_SIGN)));
			} else {
				itoast('', url('account/display'));
			}
		}
	
	

	if ($entry['entry'] == 'menu') {
		$permission = permission_check_account_user_module($entry['module'] . '_menu_' . $entry['do'], $entry['module']);
	} else {
		$permission = permission_check_account_user_module($entry['module'] . '_rule', $entry['module']);
	}
	if (!$permission) {
		itoast('您没有权限进行该操作', '', '');
	}

		define('CRUMBS_NAV', 1);

	$_W['page']['title'] = $entry['title'];
	define('ACTIVE_FRAME_URL', url('site/entry/', array('eid' => $entry['eid'], 'version_id' => $_GPC['version_id'])));
}

if (!empty($entry['module']) && !empty($_W['founder'])) {
	if (ext_module_checkupdate($entry['module'])) {
		itoast('系统检测到该模块有更新，请点击“<a href="' . url('extension/module/upgrade', array('m' => $entry['module'])) . '">更新模块</a>”后继续使用！', '', 'error');
	}
}

$_GPC['__entry'] = $entry['title'];
$_GPC['__state'] = $entry['state'];
$_GPC['state'] = $entry['state'];
$_GPC['m'] = $entry['module'];
$_GPC['do'] = $entry['do'];

$_W['current_module'] = $module;


	if ($entry['entry'] == 'system_welcome' || $_GPC['module_type'] == 'system_welcome') {
		$_GPC['module_type'] = 'system_welcome';
		define('SYSTEM_WELCOME_MODULE', true);
		$site = WeUtility::createModuleSystemWelcome($entry['module']);
	} else {
		$site = WeUtility::createModuleSite($entry['module']);
	}




define('IN_MODULE', $entry['module']);

if (!is_error($site)) {
	if ($_W['role'] == ACCOUNT_MANAGE_NAME_OWNER) {
		$_W['role'] = ACCOUNT_MANAGE_NAME_MANAGER;
	}
	$sysmodule = system_modules();
	if (in_array($m, $sysmodule)) {
		$site_urls = $site->getTabUrls();
	}
	
	
		$do_function = defined('SYSTEM_WELCOME_MODULE') ? 'doPage' : 'doWeb';
		$method = $do_function . ucfirst($entry['do']);
	
	exit($site->$method());
}
itoast("访问的方法 {$method} 不存在.", referer(), 'error');