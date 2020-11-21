<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

define('FRAME', 'system');
load()->model('system');
load()->model('miniapp');

$dos = array('display', 'edit_version', 'del_version');
$do = in_array($do, $dos) ? $do : 'display';

$uniacid = intval($_GPC['uniacid']);
$acid = intval($_GPC['acid']);
if (empty($uniacid)) {
	itoast('请选择要编辑的小程序', referer(), 'error');
}

$state = permission_account_user_role($_W['uid'], $uniacid);

$role_permission = in_array($state, array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_FOUNDER, ACCOUNT_MANAGE_NAME_MANAGER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER));
if (!$role_permission) {
	itoast('无权限操作！', referer(), 'error');
}

if ($do == 'display') {
	$account = uni_fetch($uniacid);
	if (is_error($account)) {
		itoast($account['message'], url('account/manage', array('account_type' => ACCOUNT_TYPE_APP_NORMAL)), 'error');
	} else {
		$miniapp_info = pdo_get('account_aliapp', array('uniacid' => $account['uniacid']));
		$version_exist = miniapp_fetch($account['uniacid']);
		if (!empty($version_exist)) {
			$version_lists = miniapp_version_all($account['uniacid']);
			if (!empty($version_lists)) {
				foreach ($version_lists as &$row) {
					if (!empty($row['modules'])) {
						$row['module'] = current($row['modules']);
					}
				}
				unset($row);
			}
			$miniapp_modules = miniapp_support_uniacid_modules($account['uniacid'], MODULE_SUPPORT_ALIAPP_NAME);
		}
	}
	template('miniapp/manage');
}

if ($do == 'edit_version') {
	if (empty($_GPC['name'])) {
		iajax(1, '模块名不可为空！');
	}
	$module_name = safe_gpc_string($_GPC['name']);
	$module_info = module_fetch($module_name);
	if (empty($module_info)) {
		iajax(1, '模块不存在！');
	}
	$versionid = intval($_GPC['version_id']);
	$version_exist = miniapp_fetch($uniacid, $versionid);
	if(empty($version_exist)) {
		iajax(1, '版本不存在或已删除！');
	}
	$miniapp_modules = miniapp_support_uniacid_modules($uniacid, MODULE_SUPPORT_ALIAPP_NAME);
	$supoort_modulenames = array_keys($miniapp_modules);
	$new_module_data = array();
	if (!in_array($module_name, $supoort_modulenames)) {
		iajax(1, '没有模块：' . $module_info['title'] . '的权限！');
	}
	$new_module_data[$module_name] = array(
		'name' => $module_name,
		'version' => $module_info['version']
	);
	pdo_update('wxapp_versions', array('modules' => iserializer($new_module_data)), array('id' => $versionid));
	cache_delete(cache_system_key('miniapp_version', array('version_id' => $versionid)));
	iajax(0, '修改成功！', referer());
}

if ($do == 'del_version') {
	$id = intval($_GPC['versionid']);
	if (empty($id)) {
		iajax(1, '参数错误！');
	}
	$version_exist = pdo_get('wxapp_versions', array('id' => $id, 'uniacid' => $uniacid));
	if (empty($version_exist)) {
		iajax(1, '模块版本不存在！');
	}
	$result = pdo_delete('wxapp_versions', array('id' => $id, 'uniacid' => $uniacid));
	if (!empty($result)) {
		iajax(0, '删除成功！', referer());
	} else {
		iajax(1, '删除失败，请稍候重试！');
	}
}