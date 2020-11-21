<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');
load()->model('miniapp');
load()->model('account');

$dos = array('display', 'switch', 'getall_last_switch', 'have_permission_uniacids', 'accounts_dropdown_menu', 'rank');
$do = in_array($do, $dos) ? $do : 'display';

if ($do == 'display') {
	$user_module = array();
	if (!$_W['isfounder'] || user_is_vice_founder()) {
		$account_table = table('account');
		$userspermission_table = table('userspermission');
		$user_owned_account = $account_table->userOwnedAccount($_W['uid']);

		if (!empty($user_owned_account) && is_array($user_owned_account)) {
			foreach ($user_owned_account as $uniacid => $account) {
				$account_module = uni_modules_list($uniacid, true, $account['type']);
				$account_user_module = $userspermission_table->userPermission($_W['uid'], $uniacid);
								if ($account['type'] == ACCOUNT_TYPE_APP_NORMAL || $account['type'] == ACCOUNT_TYPE_APP_AUTH) {
					$wxapp_versions = pdo_getall('wxapp_versions', array('uniacid' => $uniacid), '');
					if (is_array($wxapp_versions) && !empty($wxapp_versions)) {
						$versions = array();
						foreach($wxapp_versions as $version) {
							$version_module = (array)iunserializer($version['modules']);
							$version_module = array_keys($version_module);
							$versions[] = $version_module[0];
						}
						$diffs = array_diff(array_keys($account_module), $versions);
						foreach($diffs as $diff) {
							unset($account_module[$diff]);
						}
					} else {
						$account_module = array();
					}
				}

				if (!empty($account_user_module) && is_array($account_user_module)) {
					$account_module = array_intersect_key($account_module, $account_user_module);
				}
				$user_module = array_merge($user_module, $account_module);
			}
		}
	} else {
		$user_module = user_modules($_W['uid']);
		$user_owned_account = table('account')->userOwnedAccount($_W['uid']);
		foreach($user_owned_account as $account_key => $account) {
			if (in_array($account['type'], array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH, ACCOUNT_TYPE_WXAPP_WORK))) {
				$versions = miniapp_version_all($account['uniacid']);
				if (empty($versions)) {
					$user_owned_account[$account_key]['premission_modules'][] = '';
					continue;
				}
				foreach($versions as $version) {
					if (empty($version['modules'])) {
						$user_owned_account[$account_key]['premission_modules'][] = '';
						continue;
					}
					$module_info = current($version['modules']);
					$user_owned_account[$account_key]['premission_modules'][] = $module_info['name'];
				}
				$user_owned_account[$account_key]['premission_modules'] = array_unique($user_owned_account[$account_key]['premission_modules']);
			} else {
				$account_modules = uni_modules_by_uniacid($account['uniacid'], true);
				$user_owned_account[$account_key]['premission_modules'] = array_keys($account_modules);
			}
		}
		foreach($user_module as $key => $module) {
			$show_module = false;

			foreach($user_owned_account as $account) {
				if (in_array($module['name'], $account['premission_modules'])) {
					$show_module = true;
					break;
				}
			}
			if ($show_module == false) {
				unset($user_module[$key]);
			}
		}
	}
	$module_rank = table('modules_rank')->getByModuleNameList(array_keys($user_module));

	$rank = array();
	foreach ($user_module as $module_name => $module_info) {
		if (!empty($module_info['issystem']) || ($module_info[MODULE_SUPPORT_SYSTEMWELCOME_NAME] == MODULE_SUPPORT_SYSTEMWELCOME && $module_info[MODULE_SUPPORT_ACCOUNT_NAME] != MODULE_SUPPORT_ACCOUNT && $module_info[MODULE_SUPPORT_WXAPP_NAME] != MODULE_SUPPORT_WXAPP && $module_info[MODULE_SUPPORT_WEBAPP_NAME] != MODULE_SUPPORT_WEBAPP && $module_info[MODULE_SUPPORT_PHONEAPP_NAME] != MODULE_SUPPORT_PHONEAPP && $module_info[MODULE_SUPPORT_XZAPP_NAME] != MODULE_SUPPORT_XZAPP)) {
			unset($user_module[$module_name]);
		} else {
			$rank[] = !empty($module_rank[$module_name]['rank']) ? $module_rank[$module_name]['rank'] : 0;
		}
	}
	array_multisort($rank, SORT_DESC, $user_module);
	template('module/display');
}

if ($do == 'rank') {
	$module_name = trim($_GPC['module_name']);

	$exist = module_fetch($module_name);
	if (empty($exist)) {
		iajax(1, '模块不存在', '');
	}
	module_rank_top($module_name);
	itoast('更新成功！', referer(), 'success');
}

if ($do == 'switch') {
	$module_name = trim($_GPC['module_name']);
	$module_info = module_fetch($module_name);
	$uniacid = intval($_GPC['uniacid']);
	$version_id = intval($_GPC['version_id']);
	if (empty($module_name) || empty($module_info)) {
		itoast('模块不存在或已经删除！', referer(), 'error');
	}
	if (empty($uniacid) && empty($version_id)) {
		$last_module_info = module_last_switch($module_name);
		if (empty($last_module_info)) {
			$accounts_list = module_link_uniacid_fetch($_W['uid'], $module_name);
			$current_account = current($accounts_list);
			$uniacid = $current_account['uniacid'];
			$version_id = $current_account['version_id'];
		} else {
			$uniacid = $last_module_info['uniacid'];
			$version_id = $last_module_info['version_id'];
		}
	}
	if (empty($uniacid) && empty($version_id)) {
		itoast('该模块暂无可用的公众号或小程序，请先给公众号或小程序分配该应用的使用权限', url('module/display'), 'info');
	}

	module_save_switch($module_name, $uniacid, $version_id);
	if (!empty($version_id)) {
		$version_info = miniapp_version($version_id);
	}
	if (empty($uniacid) && !empty($version_id)) {
		uni_account_save_switch($version_info['uniacid'], WXAPP_TYPE_SIGN);
		miniapp_update_last_use_version($version_info['uniacid'], $version_id);
		itoast('', url('account/display/switch', array('uniacid' => $uniacid, 'module' => $module_name, 'version_id' => $version_id, 'type' => ACCOUNT_TYPE_APP_NORMAL)), 'success');
	}
	if (!empty($uniacid)) {
		if (empty($version_id)) {
			itoast('', url('account/display/switch', array('uniacid' => $uniacid, 'module_name' => $module_name, 'type' => ACCOUNT_TYPE_OFFCIAL_NORMAL)), 'success');
		}
		if ($version_info['uniacid'] != $uniacid) {
			itoast('', url('account/display/switch', array('uniacid' => $uniacid, 'module_name' => $module_name, 'version_id' => $version_id, 'type' => ACCOUNT_TYPE_OFFCIAL_NORMAL)), 'success');
		} else {
			uni_account_save_switch($version_info['uniacid'], WXAPP_TYPE_SIGN);
			miniapp_update_last_use_version($version_info['uniacid'], $version_id);
			itoast('', url('account/display/switch', array('uniacid' => $uniacid, 'module' => $module_name, 'version_id' => $version_id, 'type' => ACCOUNT_TYPE_APP_NORMAL)), 'success');
		}
	}
}

if ($do == 'getall_last_switch') {
	set_time_limit(0);
	$user_module = user_modules($_W['uid']);
	$result = array();
	foreach ($user_module as $module_value) {
		$last_module_info = module_last_switch($module_value['name']);
		if (empty($last_module_info)) {
			$accounts_list = module_link_uniacid_fetch($_W['uid'], $module_value['name']);
			$current_account = current($accounts_list);
			$result[$module_value['name']] = array(
				'app_name' => $current_account['app_name'],
				'wxapp_name' => $current_account['wxapp_name'],
			);
			continue;
		}
		$account_info = uni_fetch($last_module_info['uniacid']);
		if ($account_info['type'] == ACCOUNT_TYPE_APP_NORMAL) {
			$result[$module_value['name']] = array(
				'app_name' => '',
				'wxapp_name' => $account_info['name']
			);
			continue;
		}
		if (!empty($last_module_info['version_id'])) {
			$version_info = miniapp_version($last_module_info['version_id']);
			$account_wxapp_info = miniapp_fetch($version_info['uniacid']);
			$result[$module_value['name']] = array(
				'app_name' => $account_info['name'],
				'wxapp_name' => $account_wxapp_info['name']
			);
		} else {
			$result[$module_value['name']] = array(
				'app_name' => $account_info['name'],
				'wxapp_name' => ''
			);
		}
	}
	iajax(0, $result);
}

if ($do == 'have_permission_uniacids') {
	$module_name = trim($_GPC['module_name']);
	$accounts_list = module_link_uniacid_fetch($_W['uid'], $module_name);
	iajax(0, $accounts_list);
}

if ($do == 'accounts_dropdown_menu') {
	$module_name = trim($_GPC['module_name']);
	if (empty($module_name)) {
		exit();
	}
	$accounts_list = module_link_uniacid_fetch($_W['uid'], $module_name);
	if (empty($accounts_list)) {
		exit();
	}
	$selected_account = array();
	foreach ($accounts_list as $account) {
		if (empty($account['uniacid']) || $account['uniacid'] != $_W['uniacid']) {
			continue;
		}
		if (in_array($_W['account']['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH))) {
			if (!empty($account['version_id'])) {
				$version_info = miniapp_version($account['version_id']);
				$account['version_info'] = $version_info;
			}
			$selected_account = $account;
			break;
		} elseif (in_array($_W['account']['type'], array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_ALIAPP_NORMAL))) {
			$version_info = miniapp_version($account['version_id']);
			$account['version_info'] = $version_info;
			$selected_account = $account;
			break;
		}
	}
	foreach ($accounts_list as $key => $account) {
		$url = url('module/display/switch', array('uniacid' => $account['uniacid'], 'module_name' => $module_name));
		if (!empty($account['version_id'])) {
			$url .= '&version_id=' . $account['version_id'];
		}
		$accounts_list[$key]['url'] = $url;
	}
	echo template('module/dropdown-menu');
	exit;
}
