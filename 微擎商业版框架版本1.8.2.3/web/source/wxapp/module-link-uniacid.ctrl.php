<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');

$dos = array('module_link_uniacid', 'search_link_account', 'module_unlink_uniacid');
$do = in_array($do, $dos) ? $do : 'module_link_uniacid';

$_W['page']['title'] = '数据同步 - 小程序 - 管理';

$wxapp_info = miniapp_fetch($_W['uniacid']);

if ($do == 'module_link_uniacid') {
	$module_name = trim($_GPC['module_name']);

	if (checksubmit('submit')) {
		$uniacid = intval($_GPC['uniacid']);
		if (empty($module_name) || empty($uniacid)) {
			iajax('1', '参数错误！');
		}
		$module = module_fetch($module_name);
		if (empty($module)) {
			iajax('1', '模块不存在！');
		}
		$module_update = array();
		$module_update[$module['name']] = array('name' => $module['name'], 'version' => $module['version'], 'uniacid' => $uniacid);
		pdo_update('wxapp_versions', array('modules' => iserializer($module_update)), array('id' => $version_id));
		uni_passive_link_uniacid($uniacid, $module_name);
		cache_delete(cache_system_key('miniapp_version', array('version_id' => $version_id)));
		iajax(0, '关联成功');
	}
	if (!empty($version_info['modules'])) {
		foreach ($version_info['modules'] as &$module_value) {
			$link_uniacid_info = module_link_uniacid_info($module_value['name']);
			if (!empty($link_uniacid_info)) {
				foreach ($link_uniacid_info as $info) {
					if ($info['settings']['link_uniacid'] == $_W['uniacid'] ||
						!empty($info['settings']['passive_link_uniacid']) && $info['uniacid'] == $_W['uniacid']) {
						$module_value['other_link'] = uni_fetch($info['settings']['passive_link_uniacid']);
					}
				}
			}
		}
	}
	template('wxapp/version-module-link-uniacid');
}

if ($do == 'module_unlink_uniacid') {
	if (empty($version_info)) {
		iajax(-1, '版本信息错误！');
	}
	$module = current($version_info['modules']);
	$version_modules = array(
		$module['name'] => array(
		'name' => $module['name'],
		'version' => $module['version']
		)
	);
	uni_unpassive_link_uniacid($module['account']['uniacid'], $module['name']);

	$version_modules = iserializer($version_modules);
	$result = pdo_update('wxapp_versions', array('modules' => $version_modules), array('id' => $version_info['id']));
	if ($result) {
		cache_delete(cache_system_key('miniapp_version', array('version_id' => $version_id)));
		iajax(0, '删除成功！', referer());
	} else {
		iajax(0, '删除失败！', referer());
	}
}

if ($do == 'search_link_account') {
	$module_name = trim($_GPC['module_name']);
	$account_type = intval($_GPC['type']);
	if (empty($module_name)) {
		iajax(0, array());
	}
	$module = module_fetch($module_name);
	if (empty($module)) {
		iajax(0, array());
	}
	if (!in_array($account_type, array(ACCOUNT_TYPE_WEBAPP_NORMAL, ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_APP_NORMAL))) {
		iajax(0, array());
	}
		$have_link_uniacid = array();
	$link_uniacid_info = module_link_uniacid_info($module_name);
	if (!empty($link_uniacid_info)) {
		foreach ($link_uniacid_info as $info) {
			if (!empty($info['settings']['link_uniacid'])) {
				$have_link_uniacid[] = $info['uniacid'];
			}
		}
	}
		if ($account_type == ACCOUNT_TYPE_OFFCIAL_NORMAL) {
		$account_normal_list = uni_search_link_account($module_name, ACCOUNT_TYPE_OFFCIAL_NORMAL);
		$account_auth_list = uni_search_link_account($module_name, ACCOUNT_TYPE_OFFCIAL_AUTH);
		$account_list = array_merge($account_normal_list, $account_auth_list);
	} elseif ($account_type == ACCOUNT_TYPE_APP_NORMAL) {
		$account_normal_list = uni_search_link_account($module_name, ACCOUNT_TYPE_APP_NORMAL);
		$account_auth_list = uni_search_link_account($module_name, ACCOUNT_TYPE_APP_AUTH);
		$account_list = array_merge($account_normal_list, $account_auth_list);
	} else {
		$account_list = uni_search_link_account($module_name, $account_type);
	}
	if (!empty($account_list)) {
		foreach ($account_list as $key => $account) {
			if (in_array($account['uniacid'], $have_link_uniacid)) {
				unset($account_list[$key]);
				continue;
			}
			$account_list[$key]['logo'] = is_file(IA_ROOT . '/attachment/headimg_' . $account['acid'] . '.jpg') ? tomedia('headimg_'.$account['acid']. '.jpg').'?time='.time() : './resource/images/nopic-107.png';
		}
	}
	iajax(0, $account_list);
}