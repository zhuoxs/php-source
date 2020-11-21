<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('welcome');
load()->model('module');
load()->model('system');
load()->model('user');
load()->model('miniapp');
load()->model('account');
load()->model('message');
load()->model('visit');

$dos = array('platform', 'system', 'ext', 'get_fans_kpi', 'get_last_modules', 'get_system_upgrade', 'get_upgrade_modules', 'get_module_statistics', 'get_ads', 'get_not_installed_modules', 'system_home', 'set_top', 'add_welcome', 'ignore_update_module');
$do = in_array($do, $dos) ? $do : 'platform';

if ($do == 'get_not_installed_modules') {
	$not_installed_modules = module_uninstall_list();
	iajax(0, $not_installed_modules);
}



	if ($do == 'ext' && $_GPC['m'] != 'store' && !$_GPC['system_welcome']) {
		if (!empty($_GPC['version_id'])) {
			$version_info = miniapp_version($_GPC['version_id']);
		}
		$account_api = WeAccount::create();
		if (is_error($account_api)) {
			message($account_api['message'], url('account/display'));
		}
		$check_manange = $account_api->checkIntoManage();
		if (is_error($check_manange)) {
			$account_display_url = $account_api->accountDisplayUrl();
			itoast('', $account_display_url);
		}
	}



if ($do == 'platform') {
	define('FRAME', 'account');
	if (!empty($_W['account']['endtime']) && $_W['account']['endtime'] < time() && !user_is_founder($_W['uid'], true)) {
		itoast('公众号已到服务期限，请联系管理员并续费', url('account/manage'), 'info');
	}
		$notices = welcome_notices_get();

	template('home/welcome');
}

if ($do == 'system') {
	define('FRAME', 'system');
	$_W['page']['title'] = '欢迎页 - 系统管理';
	if(!$_W['isfounder'] || user_is_vice_founder()){
		header('Location: ' . url('account/manage', array('account_type' => 1)), true);
		exit;
	}
	$reductions = system_database_backup();
	if (!empty($reductions)) {
		$last_backup = array_shift($reductions);
		$last_backup_time = $last_backup['time'];
		$backup_days = welcome_database_backup_days($last_backup_time);
	} else {
		$backup_days = 0;
	}
	template('home/welcome-system');
}
if ($do =='get_module_statistics') {
	$install_modules = module_installed_list();

	$module_statistics = array(
		'account' => array(
			'total' => array(
				'uninstall' => module_uninstall_total('account'),
				'upgrade' => module_upgrade_total('account'),
				'all' => 0
			),
		),
		'wxapp' => array(
			'total' => array(
				'uninstall' => module_uninstall_total('wxapp'),
				'upgrade' => module_upgrade_total('wxapp'),
				'all' => 0,
			)
		),
	);

		$module_statistics['account']['total']['all'] = $module_statistics['account']['total']['uninstall'] + count((array)$install_modules['account']);
	$module_statistics['wxapp']['total']['all'] = $module_statistics['wxapp']['total']['uninstall'] + count((array)$install_modules['wxapp']);

	iajax(0, $module_statistics, '');
}

if ($do == 'ext') {
	$modulename = $_GPC['m'];
	if (!empty($modulename)) {
		$_W['current_module'] = module_fetch($modulename);
	}
	define('FRAME', 'account');
	define('IN_MODULE', $modulename);
	if ($_GPC['system_welcome'] && $_W['isfounder']) {
		define('SYSTEM_WELCOME_MODULE', true);
		$frames = buildframes('system_welcome');
	} else {
		$site = WeUtility::createModule($modulename);
		if (!is_error($site)) {
			$method = 'welcomeDisplay';
			if(method_exists($site, $method)){
				define('FRAME', 'module_welcome');
				$entries = module_entries($modulename, array('menu', 'home', 'profile', 'shortcut', 'cover', 'mine'));
				$site->$method($entries);
				exit;
			}
		}
		$frames = buildframes('account');
	}
	foreach ($frames['section'] as $secion) {
		foreach ($secion['menu'] as $menu) {
			if (!empty($menu['url'])) {
				if (!empty($_W['current_module']['config']['default_entry']) && !strpos($menu['url'], '&eid=' . $_W['current_module']['config']['default_entry'])) {
					continue;
				}
				header('Location: ' . $_W['siteroot'] . 'web/' . $menu['url']);
				exit;
			}
		}
	}
	template('home/welcome-ext');
}

if ($do == 'get_fans_kpi') {
	uni_update_week_stat();
		$yesterday = date('Ymd', strtotime('-1 days'));
	$yesterday_stat = pdo_get('stat_fans', array('date' => $yesterday, 'uniacid' => $_W['uniacid']));
	$yesterday_stat['new'] = intval($yesterday_stat['new']);
	$yesterday_stat['cancel'] = intval($yesterday_stat['cancel']);
	$yesterday_stat['jing_num'] = intval($yesterday_stat['new']) - intval($yesterday_stat['cancel']);
	$yesterday_stat['cumulate'] = intval($yesterday_stat['cumulate']);
		$today_stat = pdo_get('stat_fans', array('date' => date('Ymd'), 'uniacid' => $_W['uniacid']));
	$today_stat['new'] = intval($today_stat['new']);
	$today_stat['cancel'] = intval($today_stat['cancel']);
	$today_stat['jing_num'] = $today_stat['new'] - $today_stat['cancel'];
	$today_stat['cumulate'] = intval($today_stat['jing_num']) + $yesterday_stat['cumulate'];
	if($today_stat['cumulate'] < 0) {
		$today_stat['cumulate'] = 0;
	}
	iajax(0, array('yesterday' => $yesterday_stat, 'today' => $today_stat), '');
}

if ($do == 'get_last_modules') {
		$last_modules = welcome_get_last_modules();
	if (is_error($last_modules)) {
		iajax(1, $last_modules['message'], '');
	} else {
		iajax(0, $last_modules, '');
	}
}

if ($do == 'get_system_upgrade') {
		$upgrade = welcome_get_cloud_upgrade();
	iajax(0, $upgrade, '');
} elseif ($do == 'get_upgrade_modules') {
		module_upgrade_info();
	$upgrade_modules = module_upgrade_list();

	iajax(0, $upgrade_modules, '');
}

if ($do == 'get_ads') {
	$ads = welcome_get_ads();
	if (is_error($ads)) {
		iajax(1, $ads['message']);
	} else {
		iajax(0, $ads);
	}
}

if ($do == 'system_home') {
	define('FRAME', '');
	$user_info = user_single($_W['uid']);
	$account_num = permission_user_account_num();

	$last_accounts_modules = pdo_getall('system_stat_visit', array('uid' => $_W['uid']), array(), '', array('displayorder desc', 'updatetime desc'), 20);

	if (!empty($last_accounts_modules)) {
		foreach ($last_accounts_modules as &$info) {
			if (!empty($info['uniacid'])) {
				$info['account'] = uni_fetch($info['uniacid']);
			}

			if (!empty($info['modulename'])) {
				$info['account'] = module_fetch($info['modulename']);
				$info['account']['switchurl'] = url('module/display/switch', array('module_name' => $info['modulename']));
				unset($info['account']['type']);
			}
		}
		unset($info);
	}

	$types = array(MESSAGE_ACCOUNT_EXPIRE_TYPE, MESSAGE_WECHAT_EXPIRE_TYPE, MESSAGE_WEBAPP_EXPIRE_TYPE, MESSAGE_USER_EXPIRE_TYPE, MESSAGE_WXAPP_MODULE_UPGRADE);
	$messages = pdo_getall('message_notice_log', array('uid' => $_W['uid'], 'type' => $types, 'is_read' => MESSAGE_NOREAD), array(), '', array('id desc'), 10);
	$messages = message_list_detail($messages);
	template('home/welcome-system-home');
}


if ($do == 'set_top') {
	$id = intval($_GPC['id']);
	$system_visit_info = pdo_get('system_stat_visit', array('id' => $id));
	visit_system_update($system_visit_info, true);
	iajax(0, '设置成功', referer());
}

if ($do == 'add_welcome') {
	visit_system_update(array('uid' => $_W['uid'], 'uniacid' => intval($_GPC['uniacid']), 'modulename' => safe_gpc_string($_GPC['module'])), true);
	itoast(0, referer());
}

if ($do == 'ignore_update_module') {
	if (empty($_GPC['name'])) {
		iajax(1, '参数错误');
	}
	$module_info = module_fetch($_GPC['name']);
	if (empty($module_info)) {
		iajax(1, '参数错误');
	}

	$upgrade_version = table('modules_cloud')->getByName($module_info['name']);

	table('modules_ignore')->add($module_info['name'], $upgrade_version['version']);
	iajax(0, '');
}
