<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

load()->model('extension');
load()->model('cloud');
load()->model('cache');
load()->model('module');
load()->model('user');
load()->model('account');
load()->classs('account');
load()->model('utility');
$dos = array('filter', 'check', 'check_upgrade', 'get_upgrade_info', 'upgrade', 'install', 'installed', 'not_installed', 'uninstall', 'save_module_info', 'module_detail', 'change_receive_ban');
$do = in_array($do, $dos) ? $do : 'installed';

if ($_W['role'] != ACCOUNT_MANAGE_NAME_OWNER && $_W['role'] != ACCOUNT_MANAGE_NAME_MANAGER && $_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER) {
	itoast('无权限操作！', referer(), 'error');
}

if ($do == 'check') {
	load()->classs('account');
	$modulename = $_GPC['module_name'];
	$obj = WeUtility::createModuleReceiver($modulename);
	if (empty($obj)) {
		exit('error');
	}
	$obj->uniacid = $_W['uniacid'];
	$obj->acid = $_W['acid'];
	$obj->message = array(
		'event' => 'subscribe'
	);
	if(method_exists($obj, 'receive')) {
		@$obj->receive();
		iajax(0);
	} else {
		iajax(1);
	}
}

if ($do == 'get_upgrade_info') {
	$module_name = trim($_GPC['name']);
	$module_info = module_fetch($module_name);
	$module = cloud_m_upgradeinfo($module_name);
	if (is_error($module)) {
		iajax(1, $module['message']);
	} else {
		iajax(0, $module, '');
	}
}

if ($do == 'check_upgrade') {
	$module_list = $_GPC['module_list'];	if (!empty($module_list) && is_array($module_list)) {
		$module_list = pdo_getall('modules', array('name' => $module_list));
	} else {
		iajax(0, '');
	}

	$cloud_prepare_result = cloud_prepare();
	$cloud_m_query_module = cloud_m_query();
	if (is_error($cloud_m_query_module)) {
		$cloud_m_query_module = array();
	}
	foreach ($module_list as &$module) {
		$manifest = ext_module_manifest($module['name']);
		if (!empty($manifest)&& is_array($manifest)) {
			if (version_compare($module['version'], $manifest['application']['version']) == '-1') {
				$module['best_version'] = $manifest['application']['version'];
				$module['upgrade'] = true;
			} else {
				$module['upgrade'] = false;
			}
			$module['from'] = 'local';
		}

		if (empty($manifest)) {
			if (in_array($module['name'], array_keys($cloud_m_query_module))) {
				$cloud_m_info = $cloud_m_query_module[$module['name']];
				if (!empty($cloud_m_info['service_expiretime'])) {
					$module['service_expire'] = $cloud_m_info['service_expiretime'] > time() ? false : true;
				}
				$site_branch = $cloud_m_info['site_branch']['id'];
				if (empty($site_branch)) {
					$site_branch = $cloud_m_info['branch'];
				}
				$cloud_branch_version = $cloud_m_info['branches'][$site_branch]['version'];
				if (!empty($cloud_m_info['branches'])) {
					$best_branch_id = 0;
					foreach ($cloud_m_info['branches'] as $branch) {
						if ($best_branch_id == 0) {
							$best_branch_id = $branch['id'];
						} else {
							if ($branch['displayorder'] > $cloud_m_info['branches'][$best_branch_id]['displayorder']) {
								$best_branch_id = $branch['id'];
							}
						}
					}
				} else {
					$module['upgrade'] = false;
					continue;
				}
				$best_branch = $cloud_m_info['branches'][$best_branch_id];
				if (version_compare($module['version'], $cloud_branch_version) == -1 || ($cloud_m_info['displayorder'] < $best_branch['displayorder'] && !empty($cloud_m_info['version']))) {
					$module['upgrade'] = true;
				} else {
					$module['upgrade'] = false;
				}
				$module['from'] = 'cloud';
			}
		}
	}
	unset($module);
	iajax(0, $module_list, '');
}

if ($do == 'upgrade') {
	$points = ext_module_bindings();
	$module_name = addslashes($_GPC['module_name']);
		$module_exist = module_fetch($module_name);
	if (empty($module_exist)) {
		itoast('模块已经被卸载或是不存在！', '', 'error');
	}
	$manifest = ext_module_manifest($module_name);
		if (empty($manifest)) {
		$cloud_prepare = cloud_prepare();
		if (is_error($cloud_prepare)) {
			iajax(1, $cloud_prepare['message']);
		}
		$module_info = cloud_m_upgradeinfo($module_name);
		if (is_error($module_info)) {
			iajax(1, $module_info);
		}
		$uninstall_modules = module_get_all_unistalled('uninstalled');
		$upgrade_support_module = $uninstall_modules['modules'][$module_name]['upgrade_support'];
		if (!empty($_GPC['flag']) || $upgrade_support_module) {
			define('ONLINE_MODULE', true);
			$packet = cloud_m_build($module_name);
			$manifest = ext_module_manifest_parse($packet['manifest']);
		}
	}
	if (empty($manifest)) {
		itoast('模块安装配置文件不存在或是格式不正确！', '', 'error');
	}
	$check_manifest_result = manifest_check($module_name, $manifest);
	if (is_error($check_manifest_result)) {
		itoast($check_manifest_result['message'], '', 'error');
	}
	$module_path = IA_ROOT . '/addons/' . $module_name . '/';
	if (!file_exists($module_path . 'processor.php') && !file_exists($module_path . 'module.php') && !file_exists($module_path . 'receiver.php') && !file_exists($module_path . 'site.php')) {
		itoast('模块缺失文件，请检查模块文件中site.php, processor.php, module.php, receiver.php 文件是否存在！', '', 'error');
	}

	if (!empty($manifest['platform']['plugin_list'])) {
		pdo_delete('modules_plugin', array('main_module' => $manifest['application']['identifie']));
		foreach ($manifest['platform']['plugin_list'] as $plugin) {
			pdo_insert('modules_plugin', array('main_module' => $manifest['application']['identifie'], 'name' => $plugin));
		}
	}
		$module = ext_module_convert($manifest);

	unset($module['name'], $module['title']);
	$bindings = array_elements(array_keys($points), $module, false);
	foreach ($points as $point_name => $point_info) {
		unset($module[$point_name]);
		if (is_array($bindings[$point_name]) && !empty($bindings[$point_name])) {
			foreach ($bindings[$point_name] as $entry) {
				$entry['module'] = $manifest['application']['identifie'];
				$entry['entry'] = $point_name;
				if ($point_name == 'page' && !empty($wxapp_support)) {
					$entry['url'] = $entry['do'];
					$entry['do'] = '';
				}
				if ($entry['title'] && $entry['do']) {
										$not_delete_do[] = $entry['do'];
					$not_delete_title[] = $entry['title'];
					$module_binding = pdo_get('modules_bindings',array('module' => $manifest['application']['identifie'], 'entry' => $point_name, 'title' => $entry['title'], 'do' => $entry['do']));
					if (!empty($module_binding)) {
						pdo_update('modules_bindings', $entry, array('eid' => $module_binding['eid']));
						continue;
					}
				} elseif ($entry['call']) {
					$not_delete_call[] = $entry['call'];
					$module_binding = pdo_get('modules_bindings',array('module' => $manifest['application']['identifie'], 'entry' => $point_name, 'call' => $entry['call']));
					if (!empty($module_binding)) {
						pdo_update('modules_bindings', $entry, array('eid' => $module_binding['eid']));
						continue;
					}
				}
				pdo_insert('modules_bindings', $entry);
			}
						if (!empty($not_delete_do)) {
				pdo_query("DELETE FROM " . tablename('modules_bindings') . " WHERE module = :module AND entry = :entry AND `call` = '' AND do NOT IN ('" . implode("','", $not_delete_do) . "')", array(':module' => $manifest['application']['identifie'], ':entry' => $point_name));
				unset($not_delete_do);
			}
			if (!empty($not_delete_title)) {
				pdo_query("DELETE FROM " . tablename('modules_bindings') . " WHERE module = :module AND entry = :entry AND `call` = '' AND title NOT IN ('" . implode("','", $not_delete_title) . "')", array(':module' => $manifest['application']['identifie'], ':entry' => $point_name));
				unset($not_delete_title);
			}
			if (!empty($not_delete_call)) {
				pdo_query("DELETE FROM " . tablename('modules_bindings') . " WHERE module = :module AND  entry = :entry AND do = '' AND title = '' AND `call` NOT IN ('" . implode("','", $not_delete_call) . "')", array(':module' => $manifest['application']['identifie'], ':entry' => $point_name));
				unset($not_delete_call);
			}
		}
	}
		if (!empty($manifest['upgrade'])) {
		if (strexists($manifest['upgrade'], '.php')) {
			if (file_exists($module_path . $manifest['upgrade'])) {
				include_once $module_path . $manifest['upgrade'];
				if (ONLINE_MODULE) {
					unlink($module_path . $manifest['upgrade']);
				}
			}
		} else {
			pdo_run($manifest['upgrade']);
		}
	}
	if (ONLINE_MODULE) {
		if (strexists($manifest['uninstall'], '.php') && file_exists($module_path . $manifest['uninstall'])) {
			unlink($module_path . $manifest['uninstall']);
		}
		if (strexists($manifest['install'], '.php') && file_exists($module_path . $manifest['install'])) {
			unlink($module_path . $manifest['install']);
		}
	}

	$module['permissions'] = iserializer($module['permissions']);
	if (!empty($module_info['version']['cloud_setting'])) {
		$module['settings'] = 2;
	} else {
		$module['settings'] = empty($module['settings']) ? 0 : 1;
	}
	pdo_update('modules', $module, array('name' => $module_name));
	cache_build_account_modules();
	cache_build_uninstalled_module();
	cache_build_cloud_upgrade_module();
	if (!empty($module['subscribes'])) {
		ext_check_module_subscribe($module_name);
	}
	cache_delete('cloud:transtoken');
	cache_build_module_info($module_name);

	itoast('模块更新成功！', url('system/module', array('account_type' => ACCOUNT_TYPE)), 'success');
}

if ($do =='install') {
	$points = ext_module_bindings();
	$module_name = trim($_GPC['module_name']);
	$is_recycle_module = pdo_get('modules_recycle', array('modulename' => $module_name));
	if (empty($_W['isfounder'])) {
		itoast('您没有安装模块的权限', '', 'error');
	}
	$module_info = module_fetch($module_name);
	if (!empty($module_info)) {
		itoast('模块已经安装或是唯一标识已存在！', '', 'error');
	}
	$manifest = ext_module_manifest($module_name);
	if (!empty($manifest)) {
		$result = cloud_m_prepare($module_name);
		if (is_error($result)) {
			itoast($result['message'], url('system/module/not_installed', array('account_type' => ACCOUNT_TYPE)), 'error');
		}
	} else {
		$result = cloud_prepare();
		if (is_error($result)) {
			itoast($result['message'], url('cloud/profile'), 'error');
		}
		$module_info = cloud_m_info($module_name);
		if (!is_error($module_info)) {
			if (empty($_GPC['flag'])) {
				header('location: ' . url('cloud/process', array('account_type' => ACCOUNT_TYPE, 'm' => $module_name)));
				exit;
			} else {
				define('ONLINE_MODULE', true);
				$packet = cloud_m_build($module_name);
				$manifest = ext_module_manifest_parse($packet['manifest']);
			}
		} else {
			itoast($module_info['message'], '', 'error');
		}
	}
	if (empty($manifest)) {
		itoast('模块安装配置文件不存在或是格式不正确，请刷新重试！', url('system/module/not_installed', array('account_type' => ACCOUNT_TYPE)), 'error');
	}
	if (!empty($manifest['platform']['main_module'])) {
		$plugin_exist = pdo_get('modules_plugin', array('main_module' => $manifest['platform']['main_module'], 'name' => $manifest['application']['identifie']));
		if (empty($plugin_exist)) {
			itoast('请先更新主模块后再安装插件', url('system/module/installed'), 'error');
		}
	}
	$check_manifest_result = manifest_check($module_name, $manifest);
	if (is_error($check_manifest_result)) {
		itoast($check_manifest_result['message'], '', 'error');
	}
	$module_path = IA_ROOT . '/addons/' . $module_name . '/';
	if (!file_exists($module_path . 'processor.php') && !file_exists($module_path . 'module.php') && !file_exists($module_path . 'receiver.php') && !file_exists($module_path . 'site.php')) {
		itoast('模块缺失文件，请检查模块文件中site.php, processor.php, module.php, receiver.php 文件是否存在！', '', 'error');
	}
	$module = ext_module_convert($manifest);
	$module_group = uni_groups();
	if (!$_W['ispost'] || empty($_GPC['flag'])) {
		template('system/select-module-group');
		exit;
	}
	if (!empty($manifest['platform']['plugin_list'])) {
		foreach ($manifest['platform']['plugin_list'] as $plugin) {
			pdo_insert('modules_plugin', array('main_module' => $manifest['application']['identifie'], 'name' => $plugin));
		}
	}
	$post_groups = $_GPC['group'];
	ext_module_clean($module_name);
	$bindings = array_elements(array_keys($points), $module, false);
	if (!empty($points)) {
		foreach ($points as $name => $point) {
			unset($module[$name]);
			if (is_array($bindings[$name]) && !empty($bindings[$name])) {
				foreach ($bindings[$name] as $entry) {
					$entry['module'] = $manifest['application']['identifie'];
					$entry['entry'] = $name;
					if ($name == 'page' && !empty($wxapp_support)) {
						$entry['url'] = $entry['do'];
						$entry['do'] = '';
					}
					pdo_insert('modules_bindings', $entry);
				}
			}
		}
	}
	$module['permissions'] = iserializer($module['permissions']);
	$module_subscribe_success = true;
	if (!empty($module['subscribes'])) {
		$subscribes = iunserializer($module['subscribes']);
		if (!empty($subscribes)) {
			$module_subscribe_success = ext_check_module_subscribe($module['name']);
		}
	}
	if (!empty($module_info['version']['cloud_setting'])) {
		$module['settings'] = 2;
	}
	$module['title_initial'] = get_first_pinyin($module['title']);
	if (strexists($manifest['install'], '.php')) {
		if (file_exists($module_path . $manifest['install'])) {
			include_once $module_path . $manifest['install'];
			if (ONLINE_MODULE) {
				unlink ($module_path . $manifest['install']);
			}
		}
	} else {
		pdo_run($manifest['install']);
	}
	if (pdo_insert('modules', $module)) {
		if (ONLINE_MODULE) {
			if (strexists($manifest['upgrade'], '.php') && file_exists($module_path . $manifest['upgrade'])) {
				unlink($module_path . $manifest['upgrade']);
			}
			if (strexists($manifest['uninstall'], '.php') && file_exists($module_path . $manifest['uninstall'])) {
				unlink($module_path . $manifest['uninstall']);
			}
		}

				if (defined('ONLINE_MODULE')) {
			ext_module_script_clean($module['name'], $manifest);
		}
		if ($_GPC['flag'] && !empty($post_groups) && $module['name']) {
			foreach ($post_groups as $groupid) {
				$group_info = pdo_get('uni_group', array('id' => intval($groupid)), array('id', 'name', 'modules'));
				if (empty($group_info)) {
					continue;
				}
				$group_info['modules'] = iunserializer($group_info['modules']);
				if (in_array($module['name'], $group_info['modules'])) {
					continue;
				}
				$group_info['modules'][] = $module['name'];
				$group_info['modules'] = iserializer($group_info['modules']);
				pdo_update('uni_group', $group_info, array('id' => $groupid));
			}
		}

		if (!empty($is_recycle_module)) {
			pdo_delete('modules_recycle', array('modulename' => $module_name));
		}
		cache_build_module_subscribe_type();
		cache_build_account_modules();
		cache_build_uninstalled_module();
		module_build_privileges();
		cache_build_module_info($module_name);

		if (empty($module_subscribe_success)) {
			itoast('模块安装成功！模块订阅消息有错误，系统已禁用该模块的订阅消息，详细信息请查看', url('system/module/module_detail', array('name' => $module['name'])), 'tips');
		} else {
			itoast('模块安装成功!', url('system/module', array('account_type' => ACCOUNT_TYPE)), 'success');
		}
	} else {
		itoast('模块安装失败, 请联系模块开发者！');
	}
}

if ($do == 'change_receive_ban') {
	$modulename = trim($_GPC['modulename']);
	$module_exist = module_fetch($modulename);
	if (empty($module_exist)) {
		iajax(1, '模块不存在', '');
	}
	if (!is_array($_W['setting']['module_receive_ban'])) {
		$_W['setting']['module_receive_ban'] = array();
	}
	if (in_array($modulename, $_W['setting']['module_receive_ban'])) {
		unset($_W['setting']['module_receive_ban'][$modulename]);
	} else {
		$_W['setting']['module_receive_ban'][$modulename] = $modulename;
	}
	setting_save($_W['setting']['module_receive_ban'], 'module_receive_ban');
	cache_build_module_subscribe_type();
	iajax(0, '');
}

if ($do == 'save_module_info') {
	$module_info = $_GPC['moduleinfo'];
	$type = trim($_GPC['type']);

	$module_name = trim($_GPC['modulename']);
	if (empty($module_name)) {
		iajax(1, '数据非法');
	}

	$module = module_fetch($module_name);
	if (empty($module)) {
		iajax(1, '数据非法');
	}

	$module_icon_map = array(
		'logo' => array(
			'filename' => 'icon-custom.jpg',
			'url' => trim($_GPC['moduleinfo']['logo'])
		),
		'preview' => array(
			'filename' => 'preview-custom.jpg',
			'url' => trim($_GPC['moduleinfo']['preview'])
		),
	);
	$module_field = array('title', 'ability', 'description');
	if (!in_array($type, array_keys($module_icon_map)) && !in_array($type, $module_field)) {
		iajax(1, '数据非法');
	}

	if (in_array($type, $module_field)) {
		$module_update = array($type => trim($module_info[$type]));
		$result =  pdo_update('modules', $module_update, array('name' => $module_name));
	} else {
		$image_destination_url = IA_ROOT . "/addons/" . $module_name . '/' . $module_icon_map[$type]['filename'];
		$result = utility_image_rename($module_icon_map[$type]['url'], $image_destination_url);
	}

	cache_delete(cache_system_key("module_info:" . $module_name));
	if (!empty($result)) {
		iajax(0, '');
	}
	iajax(1, '更新失败');
}

if ($do == 'module_detail') {
	$_W['page']['title'] = '模块详情';
	$module_name = trim($_GPC['name']);
	$module_info = module_fetch($module_name);
	if (!empty($module_info['is_relation'])) {
		$type = intval($_GPC['type']);
		switch ($type) {
			case ACCOUNT_TYPE_OFFCIAL_NORMAL:
			case ACCOUNT_TYPE_OFFCIAL_AUTH:
				$module_info['relation_name'] = '小程序版';
				$module_info['account_type'] = 0;
				$module_info['type'] = ACCOUNT_TYPE_APP_NORMAL;
				break;
			default:
				$module_info['relation_name'] = '公众号版';
				$module_info['account_type'] = ACCOUNT_TYPE_OFFCIAL_NORMAL;
				$module_info['type'] = ACCOUNT_TYPE_OFFCIAL_NORMAL;
				break;
		}
	}
	if (file_exists(IA_ROOT.'/addons/'.$module_info['name'].'/preview-custom.jpg')) {
		$module_info['preview'] = tomedia(IA_ROOT.'/addons/'.$module_info['name'].'/preview-custom.jpg');
	} else {
		$module_info['preview'] = tomedia(IA_ROOT.'/addons/'.$module_info['name'].'/preview.jpg');
	}
	if (!empty($module_info['main_module'])) {
		$main_module = module_fetch($module_info['main_module']);
	}
	if (!empty($module_info['plugin_list'])) {
		foreach ($module_info['plugin_list'] as $key => &$plugin) {
			$plugin = module_fetch($plugin);
			if (empty($plugin)) {
				unset($module_info['plugin'][$name]);
			}
		}
	}
	unset($plugin);
	$module_group_list = pdo_getall('uni_group', array('uniacid' => 0));
	$module_group = array();
	if (!empty($module_group_list)) {
		foreach ($module_group_list as $group) {
			$group['modules'] = iunserializer($group['modules']);
			if (is_array($group['modules']) && in_array($module_name, $group['modules'])) {
				$module_group[] = $group;
			}
		}
	}

		$module_subscribes = array();
	$module['subscribes'] = iunserializer($module_info['subscribes']);
	if (!empty($module['subscribes'])) {
		foreach ($module['subscribes'] as $event) {
			if ($event == 'text' || $event == 'enter') {
				continue;
			}
			$module_subscribes = $module['subscribes'];
		}
	}
	$mtypes = ext_module_msg_types();
	$module_ban = $_W['setting']['module_receive_ban'];
	if (!is_array($module_ban)) {
		$module_ban = array();
	}
	$receive_ban = in_array($module_info['name'], $module_ban) ? 1 : 2;
	$modulename = $_GPC['modulename'];


	
		$pageindex = max(1, $_GPC['page']);
	$pagesize = 20;
	$use_module_account = array();
	
	$total = count($use_module_account);
	$use_module_account = array_slice($use_module_account, ($pageindex - 1) * $pagesize, $pagesize);
	$pager = pagination($total, $pageindex, $pagesize);
}

if ($do == 'uninstall') {
	$name = trim($_GPC['name']);
	$message = '';
	$module = module_fetch($name);
	if (!empty($module['plugin'])) {
		$plugin_list = module_get_plugin_list($module['name']);
		if (!empty($plugin_list) && is_array($plugin_list)) {
			$message .= '删除' . $module['title'] . '并删除' . $module['title'] .  '包含插件<ul>';
			foreach ($plugin_list as $plugin) {
				$message .= "<li>{$plugin['title']}</li>";
			}
			unset($plugin);
			$message .= '</ul>';
		}
	}
	if (!isset($_GPC['confirm'])) {
		if ($module['isrulefields']) {
			$message .= '是否删除相关规则和统计分析数据<div><a class="btn btn-primary" style="width:80px;" href="' . url('system/module/uninstall', array('name' => $name, 'confirm' => 1)) . '">是</a> &nbsp;&nbsp;<a class="btn btn-default" style="width:80px;" href="' . url('system/module/uninstall', array('account_type' => ACCOUNT_TYPE, 'name' => $name, 'confirm' => 0)) . '">否</a></div>';
		} elseif (!empty($plugin_list)) {
			$message .= "<a href=" . url('system/module/uninstall', array('name' => $name,'confirm' => 0)) . " class='btn btn-info'>继续删除</a>";
		}
		if (!empty($message)) {
			itoast($message, '', 'tips');
		}
	}
	if (!empty($plugin_list) && is_array($plugin_list)) {
		foreach ($plugin_list as $plugin) {
			module_uninstall($plugin['name']);
		}
	}
	$uninstall_result = module_uninstall($module['name'], $_GPC['confirm'] == 1);
	if (is_error($uninstall_result)) {
		itoast($uninstall_result['message'], url('system/module'), 'error');
	}
	itoast('模块已放入回收站！', url('system/module', array('account_type' => ACCOUNT_TYPE)), 'success');
}

if ($do == 'installed') {
	$_W['page']['title'] = '应用列表';
	$uninstalled_module = module_get_all_unistalled('uninstalled');
	$total_uninstalled = $uninstalled_module['module_count'];
	$pageindex = max($_GPC['page'], 1);
	$pagesize = 20;
	$letter = $_GPC['letter'];
	$title = $_GPC['title'];
	$letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$module_list = $all_modules = user_modules($_W['uid']);
	if (!empty($module_list)) {
		foreach ($module_list as $key => &$module) {
			if (!empty($module['issystem']) || (ACCOUNT_TYPE == ACCOUNT_TYPE_APP_NORMAL && $module['wxapp_support'] != 2) || (ACCOUNT_TYPE == ACCOUNT_TYPE_OFFCIAL_NORMAL && $module['app_support'] != 2)) {
				unset($module_list[$key]);
			}
			if (!empty($letter) && strlen($letter) == 1) {
				if ($module['title_initial'] != $letter){
					unset($module_list[$key]);
				}
			}
			if (!empty($title) && !strexists($module['title'], $title)) {
				unset($module_list[$key]);
			}
		}
		unset($module);
	}
	$total = count($module_list);
	if ($total > 0){
		$module_list = array_slice($module_list, ($pageindex - 1) * $pagesize, $pagesize);
	}
	$pager = pagination($total, $pageindex, $pagesize);
}

if ($do == 'not_installed') {
	if (empty($_W['isfounder'])) {
		itoast('非法访问！', referer(), 'info');
	}
	$_W['page']['title'] = '安装模块 - 模块 - 扩展';

	$status = $_GPC['status'] == 'recycle'? 'recycle' : 'uninstalled';
	$letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$title = $_GPC['title'];
	$letter = $_GPC['letter'];
	$pageindex = max($_GPC['page'], 1);
	$pagesize = 20;

	$uninstallModules = module_get_all_unistalled($status);
	$total_uninstalled = $uninstallModules['module_count'];
	$uninstallModules = (array)$uninstallModules['modules'];
	if (!empty($uninstallModules)) {
		foreach($uninstallModules as $name => &$module) {
			if (!empty($letter) && strlen($letter) == 1) {
				$first_char = get_first_pinyin($module['title']);
				if ($letter != $first_char) {
					unset($uninstallModules[$name]);
					continue;
				}
			}
			if (!empty($title)) {
				if (!strexists($module['title'], $title)) {
					unset($uninstallModules[$name]);
					continue;
				}
			}

			if (file_exists(IA_ROOT.'/addons/'.$module['name'].'/icon-custom.jpg')) {
				$module['logo'] = tomedia(IA_ROOT.'/addons/'.$module['name'].'/icon-custom.jpg');
			} elseif (file_exists(IA_ROOT.'/addons/'.$module['name'].'/icon.jpg')) {
				$module['logo'] = tomedia(IA_ROOT.'/addons/'.$module['name'].'/icon.jpg');
			} else {
				$module['logo'] = tomedia($module['thumb']);
			}
			if (!empty($module['main_module'])) {
				$main_module_installed = module_fetch($module['main_module']);
				if ($main_module_installed) {
					$module['main_module_logo'] = $main_module_installed['logo'];
				} else {
					if ($module['from'] == 'cloud') {
						$module['main_module_logo'] = tomedia($uninstallModules[$module['main_module']]['thumb']);
					} else {
						if (file_exists(IA_ROOT.'/addons/'.$module['main_module'].'/icon-custom.jpg')) {
							$module['main_module_logo'] = tomedia(IA_ROOT.'/addons/'.$module['main_module'].'/icon-custom.jpg');
						} elseif (file_exists(IA_ROOT.'/addons/'.$module['main_module'].'/icon.jpg')) {
							$module['main_module_logo'] = tomedia(IA_ROOT.'/addons/'.$module['main_module'].'/icon.jpg');
						}
					}
				}
			}
		}
	}
	$total = count($uninstallModules);
	$uninstallModules = array_slice($uninstallModules, ($pageindex - 1)*$pagesize, $pagesize);
	$pager = pagination($total, $pageindex, $pagesize);
}

if ($do == 'filter') {
	$pageindex = max($_GPC['pageindex'], 1);
	$pagesize = 20;
	$condition = $_GPC['condition'];
	$module_list  = user_modules($_W['uid']);
	$upgrade_modules = module_filter_upgrade(array_keys($module_list));
	$modules = array();
	if (!empty($module_list) && is_array($module_list)) {
		$empty_condition = empty($condition['new_branch']) && empty($condition['upgrade_branch']);
		foreach ($module_list as $module) {
			$new_branch_module = !empty($condition['new_branch']) && $upgrade_modules[$module['name']]['new_branch'];
			$upgrade_branch_module = !empty($condition['upgrade_branch']) && $upgrade_modules[$module['name']]['upgrade_branch'];
			if (($empty_condition && $module['issystem'] != 1) || $new_branch_module || $upgrade_branch_module) {
				$modules[$module['name']] = $module;
				$modules[$module['name']]['upgrade'] = $upgrade_modules[$module['name']]['upgrade'];
				$modules[$module['name']]['new_branch'] = $upgrade_modules[$module['name']]['new_branch'];
				$modules[$module['name']]['upgrade_branch'] = $upgrade_modules[$module['name']]['upgrade_branch'];
				$modules[$module['name']]['from'] = $upgrade_modules[$module['name']]['from'];
			}
		}
	}
	$total = count($modules);
	$modules = array_slice($modules, ($pageindex - 1) * $pagesize, $pagesize);
	$pager = pagination($total, $pageindex, $pagesize, '', array('before' => 5, 'after' => 4,'ajaxcallback' => true, 'callbackfuncname' => 'filter'));
	iajax(0, array('modules' => $modules, 'pager' => $pager));
}
template('system/module' . ACCOUNT_TYPE_TEMPLATE);