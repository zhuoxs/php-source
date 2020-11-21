<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');
load()->model('account');
load()->model('user');
load()->model('cloud');
load()->model('cache');
load()->model('extension');

$dos = array('display', 'setting', 'shortcut', 'enable', 'check_status');
$do = !empty($_GPC['do']) ? $_GPC['do'] : 'display';

$modulelist = uni_modules(false);
if ($do == 'check_status') {
	$modulename = $_GPC['module'];
	if (!empty($modulename)) {
		$module_status = module_status($modulename);
		if (!empty($module_status)) {
			isetcookie('module_status:' . $modulename, json_encode($module_status));
		}
		if ($module_status['ban']) {
			iajax(1, '您的站点存在盗版模块, 请删除文件后联系客服');
		}
		if ($module_status['upgrade']['upgrade']) {
			iajax(2, $module_status['upgrade']['name'] . '检测最新版为' . $module_status['upgrade']['version'] . '，请尽快更新');
		}
	}
	iajax(0, '', '');
}

if($do == 'display') {
	$_W['page']['title'] = '公众号 - 应用模块 - 更多应用';
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize = 30;

	if (!empty($modulelist)) {
		foreach ($modulelist as $name => &$row) {
			if (!empty($row['issystem']) || $row['app_support'] != 2 || (!empty($_GPC['keyword']) && !strexists ($row['title'], $_GPC['keyword'])) || (!empty($_GPC['letter']) && $row['title_initial'] != $_GPC['letter'])) {
				unset($modulelist[$name]);
				continue;
			}
		}
		$modules = $modulelist;
	}
	template ('profile/module');
} elseif ($do == 'shortcut') {
	$status = intval($_GPC['shortcut']);
	$modulename = $_GPC['modulename'];
	$module = module_fetch($modulename);
	if(empty($module)) {
		itoast('抱歉，你操作的模块不能被访问！', '', '');
	}
	
	$module_enabled = uni_account_module_shortcut_enabled($modulename, $_W['uniacid'], $status);
	
	if ($status) {
		itoast('添加模块快捷操作成功！', referer(), 'success');
	} else {
		itoast('取消模块快捷操作成功！', referer(), 'success');
	}
} elseif ($do == 'enable') {
	$modulename = $_GPC['modulename'];
	if(empty($modulelist[$modulename])) {
		itoast('抱歉，你操作的模块不能被访问！', '', '');
	}
	pdo_update('uni_account_modules', array(
		'enabled' => empty($_GPC['enabled']) ? STATUS_OFF : STATUS_ON,
	), array(
		'module' => $modulename,
		'uniacid' => $_W['uniacid']
	));
	cache_build_module_info($modulename);
	itoast('模块操作成功！', referer(), 'success');
} elseif ($do == 'top') {
	$modulename = $_GPC['modulename'];
	$module = $modulelist[$modulename];
	if(empty($module)) {
		itoast('抱歉，你操作的模块不能被访问！', '', '');
	}
	$max_displayorder = (int)pdo_getcolumn('uni_account_modules', array('uniacid' => $_W['uniacid']), 'MAX(displayorder)');
	
	$module_profile = pdo_get('uni_account_modules', array('module' => $modulename, 'uniacid' => $_W['uniacid']));
	if (!empty($module_profile)) {
		pdo_update('uni_account_modules', array('displayorder' => ++$max_displayorder), array('id' => $module_profile['id']));
	} else {
		pdo_insert('uni_account_modules', array(
			'displayorder' => ++$max_displayorder,
			'module' => $modulename,
			'uniacid' => $_W['uniacid'],
			'enabled' => STATUS_ON,
			'shortcut' => STATUS_OFF,
		));
	}
	cache_build_account_modules($_W['uniacid']);
	itoast('模块置顶成功', referer(), 'success');
} elseif ($do == 'setting') {
	$modulename = $_GPC['m'];
	$module = $_W['current_module'] = $modulelist[$modulename];
	
	if(empty($module)) {
		itoast('抱歉，你操作的模块不能被访问！', '', '');
	}

	if(!uni_user_module_permission_check($modulename.'_settings', $modulename)) {
		itoast('您没有权限进行该操作', '', '');
	}
	
		define('CRUMBS_NAV', 1);
	
	$config = $module['config'];
	if (($module['settings'] == 2) && !is_file(IA_ROOT."/addons/{$module['name']}/developer.cer")) {
		
		if (empty($_W['setting']['site']['key']) || empty($_W['setting']['site']['token'])) {
			itoast('站点未注册，请先注册站点。', url('cloud/profile'), 'info');
		}
		
		if (empty($config)) {
			$config = array();
		}
		
		load()->model('cloud');
		load()->func('communication');
		
		$pro_attach_url = tomedia('pro_attach_url');
		$pro_attach_url = str_replace('pro_attach_url', '', $pro_attach_url);
		
		$module_simple = array_elements(array('name', 'type', 'title', 'version', 'settings'), $module);
		$module_simple['pro_attach_url'] = $pro_attach_url;
		
		$iframe = cloud_module_setting_prepare($module_simple, 'setting');
		$result = ihttp_post($iframe, array('inherit_setting' => base64_encode(iserializer($config))));
		if (is_error($result)) {
			itoast($result['message'], '', '');
		}
		$result = json_decode($result['content'], true);
		if (is_error($result)) {
			itoast($result['message'], '', '');
		}
		
		$module_simple = array_elements(array('name', 'type', 'title', 'version', 'settings'), $module);
		$module_simple['pro_attach_url'] = $pro_attach_url;
		
		$iframe = cloud_module_setting_prepare($module_simple, 'setting');
		template('profile/module-setting');
		exit();
	}
	$obj = WeUtility::createModule($module['name']);
	$obj->settingsDisplay($config);
	exit();
}