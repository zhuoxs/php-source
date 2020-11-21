<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('module');
load()->model('user');
load()->model('module');

$dos = array('display', 'delete', 'post', 'save');
$do = !empty($_GPC['do']) ? $_GPC['do'] : 'display';
if (!in_array($_W['role'], array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_MANAGER, ACCOUNT_MANAGE_NAME_FOUNDER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER))){
	itoast('无权限操作！', referer(), 'error');
}

if ($do != 'display' && !in_array($_W['role'], array(ACCOUNT_MANAGE_NAME_FOUNDER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER))) {
	itoast('您只有查看权限！', url('module/group'), 'error');
}

if ($do == 'save') {
	$package_info = array(
		'id' => intval($_GPC['id']),
		'name' => $_GPC['name'],
		'modules' => array(
			'modules' => (array) $_GPC['modules'],
			'wxapp' => (array) $_GPC['wxapp'],
			'webapp' => empty($_GPC['webapp']) ? array() : (array) array_keys($_GPC['webapp']),
			'xzapp' => empty($_GPC['xzapp']) ? array() : (array) array_keys($_GPC['xzapp']),
			'phoneapp' => empty($_GPC['phoneapp']) ? array() : (array) array_keys($_GPC['phoneapp']),
			'aliapp' => empty($_GPC['aliapp']) ? array() : (array) array_keys($_GPC['aliapp'])
		),
		'templates' => $_GPC['templates'],
	);

	$package_info = module_save_group_package($package_info);

	if (is_error($package_info)) {
		iajax(1, $package_info['message'], '');
	}
	iajax(0, '', url('module/group'));
}

if ($do == 'display') {
	$_W['page']['title'] = '应用套餐列表';
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize = 10;

	$condition = 'WHERE uniacid = 0';
	$params = array();
	$name = safe_gpc_string($_GPC['name']);
	if (!empty($name)) {
		$condition .= " AND name LIKE :name";
		$params[':name'] = "%{$name}%";
	}
	
		if (user_is_vice_founder()) {
			$condition .= " AND owner_uid = :owner_uid";
			$params[':owner_uid'] = $_W['uid'];
		}
	
	$modules_group_list = pdo_fetchall("SELECT * FROM " . tablename('uni_group') . $condition . " LIMIT " . ($pageindex - 1) * $pagesize . "," . $pagesize, $params);
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('uni_group') . $condition, $params);
	$pager = pagination($total, $pageindex, $pagesize);
	if (!empty($modules_group_list)) {
		foreach ($modules_group_list as $key => $value) {
			$modules = (array)iunserializer($value['modules']);
			if (!empty($modules)) {
				foreach ($modules as $type => $modulenames) {
					if (empty($modulenames) || !is_array($modulenames)) {
						continue;
					}
					foreach ($modulenames as $name) {
						$module = module_fetch($name);
						if (empty($module)) {
							continue;
						}
						switch ($type) {
							case 'modules':
								if ($module[MODULE_SUPPORT_ACCOUNT_NAME] == MODULE_SUPPORT_ACCOUNT) {
									$modules_group_list[$key]['account_num'] += 1;
									$modules_group_list[$key]['account_modules'][] = $module;
								}
								break;
							case 'wxapp':
								if ($module[MODULE_SUPPORT_WXAPP_NAME] == MODULE_SUPPORT_WXAPP) {
									$modules_group_list[$key]['wxapp_num'] += 1;
									$modules_group_list[$key]['wxapp_modules'][] = $module;
								}
								break;
							case 'webapp':
								if ($module[MODULE_SUPPORT_WEBAPP_NAME] == MODULE_SUPPORT_WEBAPP) {
									$modules_group_list[$key]['webapp_num'] += 1;
									$modules_group_list[$key]['webapp_modules'][] = $module;
								}
								break;
							case 'xzapp':
								if ($module[MODULE_SUPPORT_XZAPP_NAME] == MODULE_SUPPORT_XZAPP) {
									$modules_group_list[$key]['xzapp_num'] += 1;
									$modules_group_list[$key]['xzapp_modules'][] = $module;
								}
								break;
							case 'phoneapp':
								if ($module[MODULE_SUPPORT_PHONEAPP_NAME] == MODULE_SUPPORT_PHONEAPP) {
									$modules_group_list[$key]['phoneapp_num'] += 1;
									$modules_group_list[$key]['phoneapp_modules'][] = $module;
								}
								break;
							case 'aliapp':
								if ($module[MODULE_SUPPORT_ALIAPP_NAME] == MODULE_SUPPORT_ALIAPP) {
									$modules_group_list[$key]['aliapp_num'] += 1;
									$modules_group_list[$key]['aliapp_modules'][] = $module;
								}
								break;
						}
					}
				}
			}
			$templates = (array)iunserializer($value['templates']);
			$modules_group_list[$key]['template_num'] = !empty($templates) ? count($templates) : 0;
			$modules_group_list[$key]['templates'] = pdo_getall('site_templates', array('id' => $templates), array('id', 'name', 'title'), 'name');
		}
	}
		$modules = user_modules($_W['uid']);
}

if ($do == 'delete') {
	$id = intval($_GPC['id']);
	if (!empty($id)) {
		pdo_delete('uni_group', array('id' => $id));
		cache_build_uni_group();
		cache_build_account_modules();
	}
	itoast('删除成功！', referer(), 'success');
}

if ($do == 'post') {
	$group_id = intval($_GPC['id']);
	$_W['page']['title'] = $group_id ? '编辑应用套餐' : '添加应用套餐';

	$group_have_module_app = array();
	$group_have_module_wxapp = array();
	$group_have_module_webapp = array();
	$group_have_module_phoneapp = array();
	$group_have_module_xzapp = array();
	$group_have_module_aliapp = array();
	$group_have_template = array();
	if (!empty($group_id)) {
		$module_group = current(uni_groups(array($group_id)));
		$group_have_module_app = empty($module_group['modules']) ? array() : array_filter($module_group['modules']);
		$group_have_module_wxapp = empty($module_group['wxapp']) ? array() : array_filter($module_group['wxapp']);
		$group_have_template = empty($module_group['templates']) ? array() : array_filter($module_group['templates']);
		$group_have_module_webapp = empty($module_group['webapp']) ? array() : array_filter($module_group['webapp']);
		$group_have_module_phoneapp = empty($module_group['phoneapp']) ? array() : array_filter($module_group['phoneapp']);
		$group_have_module_xzapp = empty($module_group['xzapp']) ? array() : array_filter($module_group['xzapp']);
		$group_have_module_aliapp = empty($module_group['aliapp']) ? array() : array_filter($module_group['aliapp']);
	}

	$module_list = user_modules($_W['uid']);
	foreach($module_list as $key => $val) {
		if (!empty($val['issystem'])) {
			unset($module_list[$key]);
		}
	}

	$group_not_have_module_app = array();
	$group_not_have_module_wxapp = array();
	$group_not_have_module_webapp = array();
	$group_not_have_module_phoneapp = array();
	$group_not_have_module_xzapp = array();
	$group_not_have_module_aliapp = array();
	if (!empty($module_list)) {
		foreach ($module_list as $name => $module_info) {
			if ($module_info[MODULE_SUPPORT_ACCOUNT_NAME] == MODULE_SUPPORT_WXAPP && !in_array($name, array_keys($group_have_module_app))) {
				if (!empty($module_info['main_module'])) {
					if (!in_array($module_info['name'], array_keys($group_have_module_app))) {
						$group_not_have_module_app[$name] = $module_info;
					}
				} elseif (is_array($module_info['plugin_list']) && !empty($module_info['plugin_list'])) {
					$group_not_have_module_app[$name] = $module_info;
					foreach ($module_info['plugin_list'] as $plugin) {
						if (!in_array($plugin, array_keys($group_have_module_app))) {
							$plugin = module_fetch($plugin);
							if (!empty($plugin)) {
								$group_not_have_module_app[$plugin['name']] = $plugin;
							}
						}
					}
				} else {
					$group_not_have_module_app[$name] = $module_info;
				}
			}
			if ($module_info['wxapp_support'] == MODULE_SUPPORT_WXAPP && !in_array($name, array_keys($group_have_module_wxapp))) {
				$group_not_have_module_wxapp[$name] = $module_info;
			}

			if ($module_info['webapp_support'] == MODULE_SUPPORT_WEBAPP && !in_array($name, array_keys($group_have_module_webapp))) {
				$group_not_have_module_webapp[$name] = $module_info;
			}

			if ($module_info['phoneapp_support'] == MODULE_SUPPORT_PHONEAPP && !in_array($name, array_keys($group_have_module_phoneapp))) {
				$group_not_have_module_phoneapp[$name] = $module_info;
			}

			if ($module_info['xzapp_support'] == MODULE_SUPPORT_XZAPP && !in_array($name, array_keys($group_have_module_xzapp))) {
				$group_not_have_module_xzapp[$name] = $module_info;
			}

			if ($module_info['aliapp_support'] == MODULE_SUPPORT_ALIAPP && !in_array($name, array_keys($group_have_module_aliapp))) {
				$group_not_have_module_aliapp[$name] = $module_info;
			}
		}
	}

	
		if (user_is_vice_founder($_W['uid'])) {
			$template_list = user_founder_templates($_W['user']['groupid']);
		} else {
			$template_list = pdo_getall('site_templates', array(), array(), 'name');
		}
	

	

	$group_not_have_template = array();	if (!empty($template_list)) {
		foreach ($template_list as $template) {
			if (!in_array($template['name'], array_keys($group_have_template))) {
				$group_not_have_template[$template['name']] =  $template;
			}
		}
	}
}
template('module/group');