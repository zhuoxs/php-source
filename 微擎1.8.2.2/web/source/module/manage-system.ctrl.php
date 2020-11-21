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
load()->object('cloudapi');
load()->model('utility');
load()->func('db');

$dos = array('subscribe', 'check_subscribe', 'check_upgrade', 'get_upgrade_info', 'upgrade',
			'install', 'installed', 'not_installed', 'uninstall', 'save_module_info', 'module_detail',
			'change_receive_ban', 'install_success', 'set_site_welcome_module',
			'founder_update_modules', 'recycle', 'recycle_post',
);
$do = in_array($do, $dos) ? $do : 'installed';


	if (user_is_vice_founder() && !empty($_GPC['system_welcome'])){
		itoast('无权限操作！');
	}
	if ($do == 'set_site_welcome_module') {
		if (!$_W['isfounder']) {
			iajax(1, '非法操作');
		}
		if (!empty($_GPC['name'])) {
			$site = WeUtility::createModuleSystemWelcome($_GPC['name']);
			if (!method_exists($site, 'systemWelcomeDisplay')) {
				iajax(1, '应用未实现系统首页功能！');
			}
		}
		setting_save(trim($_GPC['name']), 'site_welcome_module');
		iajax(0);
	}


if ($do == 'subscribe') {
	$module_uninstall_total = module_uninstall_total($module_support);

	$module_list = user_modules($_W['uid']);
	$subscribe_type = ext_module_msg_types();

	$subscribe_module = array();
	$receive_ban = $_W['setting']['module_receive_ban'];

	if (is_array($module_list) && !empty($module_list)) {
		foreach ($module_list as $module) {
			if (!empty($module['subscribes']) && is_array($module['subscribes'])) {
				$subscribe_module[$module['name']]['subscribe'] = $module['subscribes'];
				$subscribe_module[$module['name']]['title'] = $module['title'];
				$subscribe_module[$module['name']]['name'] = $module['name'];
				$subscribe_module[$module['name']]['subscribe_success'] = 2;
				$subscribe_module[$module['name']]['receive_ban'] = in_array($module['name'], $receive_ban) ? 1 : 0;
			}
		}
	}
}

if ($do == 'check_subscribe') {
	$module = module_fetch($_GPC['module_name']);
	if (empty($module)) {
		iajax(1);
	}
	$obj = WeUtility::createModuleReceiver($module['name']);
	if (empty($obj)) {
		iajax(1);
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
	$modulename = trim($_GPC['name']);
	$module = module_fetch($modulename);
	if (empty($module)) {
		iajax(1, '模块不存在！');
	}
			$manifest = ext_module_manifest($modulename);
	$manifest_cloud = cloud_m_upgradeinfo($modulename);
	if (is_error($manifest_cloud)) {
		iajax(1, $manifest_cloud['message']);
	}
	$result = array(
		'name' => $modulename,
		'upgrade' => $manifest_cloud['upgrade'],
		'site_branch' => $manifest_cloud['site_branch'],
		'new_branch' => $manifest_cloud['new_branch'],
		'branches' => $manifest_cloud['branches'],
		'from' => 'cloud',
		'id' => $manifest_cloud['id'],
	);
		if (!empty($manifest) && version_compare($manifest['application']['version'], $manifest_cloud['version']['version'], '>')) {
		$result = array(
			'name' => $modulename,
			'upgrade' => true,
			'site_branch' => array(),
			'branches' => array(),
			'new_branch' => false,
			'from' => 'local',
			'best_version' => $manifest['application']['version'],
		);

	}
	iajax(0, $result);
}

if ($do == 'check_upgrade') {
	cache_build_uninstalled_module();

	$module_upgrade = module_upgrade_info();

	iajax(0, $module_upgrade);
}

if ($do == 'upgrade') {
	$module_name = $_GPC['module_name'];
		$module = module_fetch($module_name);
	if (empty($module)) {
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
		if (!empty($_GPC['flag'])) {
			define('ONLINE_MODULE', true);
			$packet = cloud_m_build($module_name);
			$manifest = ext_module_manifest_parse($packet['manifest']);
		}
	}
	if (empty($manifest)) {
		itoast('模块安装配置文件不存在或是格式不正确！', '', 'error');
	}
	$check_manifest_result = ext_manifest_check($module_name, $manifest);
	if (is_error($check_manifest_result)) {
		itoast($check_manifest_result['message'], '', 'error');
	}

	$check_file_result = ext_file_check($module_name, $manifest);
	if (is_error($check_file_result)) {
		itoast($check_file_result['message'], '', 'error');
	}

	if (!empty($manifest['platform']['plugin_list'])) {
		pdo_delete('modules_plugin', array('main_module' => $manifest['application']['identifie']));
		foreach ($manifest['platform']['plugin_list'] as $plugin) {
			pdo_insert('modules_plugin', array('main_module' => $manifest['application']['identifie'], 'name' => $plugin));
		}
	}
		$module_upgrade = ext_module_convert($manifest);
	unset($module_upgrade['name'], $module_upgrade['title'], $module_upgrade['ability'], $module_upgrade['description']);

	$points = ext_module_bindings();
	$bindings = array_elements(array_keys($points), $module_upgrade, false);

	foreach ($points as $point_name => $point_info) {
		unset($module_upgrade[$point_name]);
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

					$module_binding = table('modules_bindings')->isEntryExists($module_name, $point_name, $entry['do']);
					if (!empty($module_binding)) {
						pdo_update('modules_bindings', $entry, array('eid' => $module_binding['eid']));
						continue;
					}

				} elseif ($entry['call']) {
					$not_delete_call[] = $entry['call'];

					$module_binding = table('modules_bindings')->isCallExists($module_name, $point_name, $entry['call']);
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

	if ($packet['schemes']) {
		foreach ($packet['schemes'] as $remote) {
			$remote['tablename'] = trim(tablename($remote['tablename']), '`');
			$local = db_table_schema(pdo(), $remote['tablename']);
			$sqls = db_table_fix_sql($local, $remote);
			foreach ($sqls as $sql) {
				pdo_run($sql);
			}
		}
	}

	ext_module_run_script($manifest, 'upgrade');

	$module_upgrade['permissions'] = iserializer($module_upgrade['permissions']);
	if (!empty($module_info['version']['cloud_setting'])) {
		$module_upgrade['settings'] = 2;
	} else {
		$module_upgrade['settings'] = empty($module_upgrade['settings']) ? 0 : 1;
	}
	pdo_update('modules', $module_upgrade, array('name' => $module_name));

	cache_build_account_modules();
	if (!empty($module_upgrade['subscribes'])) {
		ext_check_module_subscribe($module_name);
	}
	cache_delete(cache_system_key('cloud_transtoken'));
	cache_build_module_info($module_name);

	itoast('模块更新成功！', url('module/manage-system', array('support' => $module_support_name)), 'success');
}

if ($do =='install') {
	if (empty($_W['isfounder'])) {
		itoast('您没有安装模块的权限', '', 'error');
	}
	$module_name = trim($_GPC['module_name']);
	$module_info = module_fetch($module_name);
	if (!empty($module_info)) {
		itoast('模块已经安装或是唯一标识已存在！', '', 'error');
	}

	$manifest = ext_module_manifest($module_name);
	if (!empty($manifest)) {
		$result = cloud_m_prepare($module_name);
		if (is_error($result)) {
			itoast($result['message'], referer(), 'error');
		}
	} else {
		$result = cloud_prepare();
		if (is_error($result)) {
			itoast($result['message'], url('cloud/profile'), 'error');
		}
		$module_info = cloud_m_info($module_name);
		if (!is_error($module_info)) {
			if (empty($_GPC['flag'])) {
				header('location: ' . url('cloud/process', array('support' => $module_support_name, 'm' => $module_name)));
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
		itoast('模块安装配置文件不存在或是格式不正确，请刷新重试！', referer(), 'error');
	}

	if (!empty($manifest['platform']['main_module'])) {
		$plugin_exist = table('modules_plugin')->getPluginExists($manifest['platform']['main_module'], $manifest['application']['identifie']);
		if (empty($plugin_exist)) {
			itoast('请先更新或安装主模块后再安装插件', url('module/manage-system/installed'), 'error', array(array('title' => '查看主程序', 'url' => url('module/manage-system/module_detail', array('name' => $manifest['platform']['main_module'])))));
		}
	}

	$check_manifest_result = ext_manifest_check($module_name, $manifest);
	if (is_error($check_manifest_result)) {
		itoast($check_manifest_result['message'], '', 'error');
	}
	$check_file_result = ext_file_check($module_name, $manifest);
	if (is_error($check_file_result)) {
		itoast('模块缺失文件，请检查模块文件中site.php, processor.php, module.php, receiver.php 文件是否存在！', '', 'error');
	}

	$module = ext_module_convert($manifest);
		if (!$_W['ispost'] || empty($_GPC['flag'])) {
		$module_group = uni_groups();
		template('system/module-group');
		exit;
	}
	if (!empty($manifest['platform']['plugin_list'])) {
		foreach ($manifest['platform']['plugin_list'] as $plugin) {
			pdo_insert('modules_plugin', array('main_module' => $manifest['application']['identifie'], 'name' => $plugin));
		}
	}
	$post_groups = $_GPC['group'];
	$points = ext_module_bindings();
	if (!empty($points)) {
		$bindings = array_elements(array_keys($points), $module, false);
		foreach ($points as $name => $point) {
			unset($module[$name]);
			if (is_array($bindings[$name]) && !empty($bindings[$name])) {
				foreach ($bindings[$name] as $entry) {
					$entry['module'] = $manifest['application']['identifie'];
					$entry['entry'] = $name;
					if ($name == 'page' && !empty($wxapp_support)){
						$entry['url'] = $entry['do'];
						$entry['do'] = '';
					}
					table('modules_bindings')->fill($entry)->save();
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

	if ($packet['schemes']){
		foreach ($packet['schemes'] as $remote) {
			$remote['tablename'] = trim(tablename($remote['tablename']), '`');
			$local = db_table_schema(pdo(), $remote['tablename']);
			$sqls = db_table_fix_sql($local, $remote);
			foreach ($sqls as $sql) {
				pdo_run($sql);
			}
		}
	}

	ext_module_run_script($manifest, 'install');

	if (pdo_insert('modules', $module)) {
		if ($_GPC['flag'] && !empty($post_groups) && $module['name']) {
			foreach ($post_groups as $groupid) {
				$group_info = pdo_get('uni_group', array('id' => intval($groupid)), array('id', 'name', 'modules'));
				if (empty($group_info)) {
					continue;
				}
				$group_info['modules'] = iunserializer($group_info['modules']);
				if (!empty($group_info['modules'])) {
					$is_continue = false;
					foreach ($group_info['modules'] as $modulenames) {
						if (in_array($module['name'], $modulenames)) {
							$is_continue = true;
							break;
						}
					}
					if ($is_continue) {
						continue;
					}
				}
				$group_info['modules']['modules'][] = $module['name'];
				$group_info['modules']['wxapp'][] = $module['name'];
				$group_info['modules']['webapp'][] = $module['name'];
				$group_info['modules']['xzapp'][] = $module['name'];
				$group_info['modules']['phoneapp'][] = $module['name'];
				$group_info['modules'] = iserializer($group_info['modules']);
				pdo_update('uni_group', $group_info, array('id' => $groupid));
			}
		}
		cache_build_module_subscribe_type();
		cache_build_account_modules($_W['uniacid'], $_W['uid']);
		cache_build_module_info($module_name);
		cache_build_uni_group();
		itoast('模块成功！', url('module/manage-system/install_success', array('support' => $module_support_name)), 'success');
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
	cache_build_module_info($module_name);
	iajax(0, '');
}

if ($do == 'save_module_info') {
	$module_name = trim($_GPC['modulename']);
	if (empty($module_name)) {
		iajax(1, '数据非法');
	}
	$module = module_fetch($module_name);
	if (empty($module)) {
		iajax(1, '数据非法');
	}
	$module_info_type = key($_GPC['moduleinfo']);

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
	if (!isset($module_icon_map[$module_info_type]) && !in_array($module_info_type, $module_field)) {
		iajax(1, '数据非法');
	}
	if (in_array($module_info_type, $module_field)) {
		$module_update = array($module_info_type => trim($_GPC['moduleinfo'][$module_info_type]));
		if ($module_info_type == 'title') {
			$module_update['title_initial'] = get_first_pinyin($_GPC['moduleinfo']['title']);
		}
		$result =  pdo_update('modules', $module_update, array('name' => $module_name));
	} else {
		$image_destination_url = IA_ROOT . "/addons/" . $module_name . '/' . $module_icon_map[$module_info_type]['filename'];
		$result = utility_image_rename($module_icon_map[$module_info_type]['url'], $image_destination_url);
	}
	cache_build_module_info($module_name);
	if (!empty($result)) {
		iajax(0, '');
	}
	iajax(1, '更新失败');
}

if ($do == 'module_detail') {
	$_W['page']['title'] = '模块详情';

	$module_name = trim($_GPC['name']);
	$module_info = module_fetch($module_name);
	if (empty($module_info)) {
		itoast('模块不存在或是已经被删除', '', 'error');
	}
	$manifest = ext_module_manifest($module_name);
	if (empty($manifest)) {
		$current_cloud_module = cloud_m_info($module_name);
		if (is_error($current_cloud_module)) {
			itoast($current_cloud_module['message']);
		}
	}

	$module_info['cloud_mid'] = !empty($current_cloud_module['id']) ? $current_cloud_module['id'] : '';

		foreach ($module_info as $key => $value) {
		if ($key != $module_support . '_support' && strexists($key, '_support') && $value == MODULE_SUPPORT_ACCOUNT) {
			$module_info['relation'][] = $key;
		}
	}

	if (!empty($module_info['main_module'])) {
		$main_module = module_fetch($module_info['main_module']);
	}
	if (!empty($module_info['plugin_list'])) {
		$module_info['plugin_list'] = module_get_plugin_list($module_name);
	}
	$module_group_list = pdo_getall('uni_group', array('uniacid' => 0, 'uid' => 0));
	$module_group = array();
	if (!empty($module_group_list)) {
		foreach ($module_group_list as $group) {
			if (user_is_vice_founder() && $group['owner_uid'] != $_W['uid']) {
				continue;
			}
			$group['modules'] = iunserializer($group['modules']);
			if (is_array($group['modules'])) {
				foreach ($group['modules'] as $modulenames) {
					if (is_array($modulenames) && in_array($module_name, $modulenames)) {
						$module_group[] = $group;
						break;
					}
				}
			}
		}
	}
	$subscribes_type = ext_module_msg_types();
}

if ($do == 'uninstall') {
	if (empty($_W['isfounder'])) {
		return error(1, '您没有卸载模块的权限！');
	}
	$name = trim($_GPC['module_name']);
	$module = module_fetch($name, false);
	if (empty($module)) {
		itoast('应用不存在或是已经卸载！', referer(), 'success');
	}
	if (!isset($_GPC['confirm'])) {
		$message = '';
		if ($module['isrulefields']) {
			$message .= '是否删除相关规则和统计分析数据<div><a class="btn btn-primary" style="width:80px;" href="' . url('module/manage-system/uninstall', array('module_name' => $name, 'confirm' => 1, 'support' => $module_support_name)) . '">是</a> &nbsp;&nbsp;<a class="btn btn-default" style="width:80px;" href="' . url('module/manage-system/uninstall', array('support' => $module_support_name, 'module_name' => $name, 'confirm' => 0)) . '">否</a></div>';
		}
		if (!empty($message)) {
			message($message, '', 'tips');
		}
	}
	ext_module_uninstall($name, $_GPC['confirm']);

	cache_build_account_modules($_W['uniacid'], $_W['uid']);
	cache_build_module_subscribe_type();
	cache_build_module_info($name);
	module_upgrade_info();

	itoast('模块已卸载！', url('module/manage-system/recycle', array('support' => $module_support_name, 'type' => MODULE_RECYCLE_INSTALL_DISABLED)), 'success');
}

if ($do == 'recycle_post') {
	$name = trim($_GPC['module_name']);
	if (empty($name)) {
		itoast('应用不存在或是已经被删除', referer(), 'error');
	}
	$module = module_fetch($name);
	$module_recycle = module_recycle_fetch($name);

			if (!empty($module)) {
		if (empty($module_recycle)) {
			$msg = '模块已停用!';
			table('modules_recycle')->fill(array('name' => $name, 'type' => 1))->save();

		} else {
			$msg = '模块已恢复!';
			table('modules_recycle')->deleteByName($name);
		}
		cache_write(cache_system_key('user_modules', array('uid' => $_W['uid'])), array());
		cache_build_module_info($name);
	} else {
		if (empty($module_recycle)) {
			$msg = '模块已放入回收站!';
			table('modules_recycle')->fill(array('name' => $name, 'type' => 2))->save();
		} else {
			$msg = '模块已恢复!';
			table('modules_recycle')->deleteByName($name);
		}
	}
	itoast($msg, referer(), 'success');
}
if ($do == 'recycle') {
	$type = intval($_GPC['type']);
	$title = safe_gpc_string($_GPC['title']);
	$letter = safe_gpc_string($_GPC['letter']);

	if ($type == MODULE_RECYCLE_INSTALL_DISABLED) {
		$_W['page']['title'] = '已停用模块列表';
	} else {
		$_W['page']['title'] = '模块回收站';
	}

	$pageindex = max($_GPC['page'], 1);
	$pagesize = 20;

	$module_recycle_table = table('modules_recycle');
	if ($type == MODULE_RECYCLE_INSTALL_DISABLED) {
		$module_recycle_table->searchWithModules();
	} else {
		$module_recycle_table->searchWithModulesCloud();
	}
	$module_recycle_table->searchWithPage($pageindex, $pagesize)->where('b.type', $type);
	if (!empty($title)) {
		$module_recycle_table->where('a.title LIKE', "%{$title}%");
	}
	if (!empty($letter) && strlen($letter) == 1) {
		$module_recycle_table->where('a.title_initial', $letter);
	}

	$modulelist = $module_recycle_table->getall('name');

	if (!empty($modulelist)) {
		foreach ($modulelist as $modulename => &$module) {
			$module = module_fetch($modulename, false);
			if (empty($module)) {
				$module = table('modules_cloud')->getByName($modulename);
			}
		}
		unset($module);
		$pager = pagination($module_recycle_table->getLastQueryTotal(), $pageindex, $pagesize);
	}

	$module_uninstall_total = module_uninstall_total($module_support);
}

if ($do == 'installed') {
	$_W['page']['title'] = '应用列表';

	$module_list = module_installed_list($module_support);

	if (!empty($module_list)) {
		foreach ($module_list as $key => &$module) {
			if (!empty($module['issystem'])) {
				unset($module_list[$key]);
			}
			if (!empty($letter) && strlen($letter) == 1) {
				if ($module['title_initial'] != $letter) {
					unset($module_list[$key]);
				}
			}

		}
		unset($module);
	}
	$pager = pagination(count($module_list), 1, 15, '', array('ajaxcallback' => true, 'callbackfuncname' => 'loadMore'));
	$module_uninstall_total = module_uninstall_total($module_support);
}

if ($do == 'not_installed') {
	$_W['page']['title'] = '未安装模块';

	$title = safe_gpc_string($_GPC['title']);
	$letter = safe_gpc_string($_GPC['letter']);

		cache_build_uninstalled_module();

	$pageindex = max($_GPC['page'], 1);
	$pagesize = 20;

	$module_cloud_talbe = table('modules_cloud');
	$module_cloud_talbe->searchWithoutRecycle();
	$module_cloud_talbe->searchWithPage($pageindex, $pagesize);

	if (!empty($title)) {
		$module_cloud_talbe->where('a.title LIKE', "%{$title}%");
	}
	if (!empty($letter) && strlen($letter) == 1) {
		$module_cloud_talbe->where('a.title_initial', $letter);
	}
	$module_cloud_talbe->where('a.install_status', array(MODULE_LOCAL_UNINSTALL, MODULE_CLOUD_UNINSTALL));
	$module_cloud_talbe->where("a.{$module_support}_support", MODULE_SUPPORT_ACCOUNT);
	$module_cloud_talbe->orderby('a.install_status', 'asc');

	$modulelist = $module_cloud_talbe->getall('name');

	$pager = pagination($module_cloud_talbe->getLastQueryTotal(), $pageindex, $pagesize);

	$module_uninstall_total = module_uninstall_total($module_support);
}

template('module/manage-system');