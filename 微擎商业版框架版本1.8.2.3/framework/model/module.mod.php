<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function module_types() {
	static $types = array(
		'business' => array(
			'name' => 'business',
			'title' => '主要业务',
			'desc' => ''
		),
		'customer' => array(
			'name' => 'customer',
			'title' => '客户关系',
			'desc' => ''
		),
		'activity' => array(
			'name' => 'activity',
			'title' => '营销及活动',
			'desc' => ''
		),
		'services' => array(
			'name' => 'services',
			'title' => '常用服务及工具',
			'desc' => ''
		),
		'biz' => array(
			'name' => 'biz',
			'title' => '行业解决方案',
			'desc' => ''
		),
		'enterprise' => array(
			'name' => 'enterprise',
			'title' => '企业应用',
			'desc' => ''
		),
		'h5game' => array(
			'name' => 'h5game',
			'title' => 'H5游戏',
			'desc' => ''
		),
		'other' => array(
			'name' => 'other',
			'title' => '其他',
			'desc' => ''
		)
	);
	return $types;
}

function module_support_type() {
		$module_support_type = array(
		'wxapp_support' => array(
			'type' => WXAPP_TYPE_SIGN,
			'support' => MODULE_SUPPORT_WXAPP,
		),
		'account_support' => array(
			'type' => ACCOUNT_TYPE_SIGN,
			'support' => MODULE_SUPPORT_ACCOUNT,
		),
		'welcome_support' => array(
			'type' => WELCOMESYSTEM_TYPE_SIGN,
			'support' => MODULE_SUPPORT_SYSTEMWELCOME,
		),
		'webapp_support' => array(
			'type' => WEBAPP_TYPE_SIGN,
			'support' => MODULE_SUPPORT_WEBAPP,
		),
		'phoneapp_support' => array(
			'type' => PHONEAPP_TYPE_SIGN,
			'support' => MODULE_SUPPORT_PHONEAPP,
		),
		'xzapp_support' => array(
			'type' => XZAPP_TYPE_SIGN,
			'support' => MODULE_SUPPORT_XZAPP,
		),
		'aliapp_support' => array(
			'type' => ALIAPP_TYPE_SIGN,
			'support' => MODULE_SUPPORT_ALIAPP,
		)
	);
	return $module_support_type;
}


function module_entries($name, $types = array(), $rid = 0, $args = null) {
	load()->func('communication');

	global $_W;
	
		$ts = array('rule', 'cover', 'menu', 'home', 'profile', 'shortcut', 'function', 'mine', 'system_welcome');
	
	
	if(empty($types)) {
		$types = $ts;
	} else {
		$types = array_intersect($types, $ts);
	}
	$bindings = pdo_getall('modules_bindings', array('module' => $name, 'entry' => $types), array(), '', 'displayorder DESC, eid ASC');
	$entries = array();
	foreach($bindings as $bind) {
		if(!empty($bind['call'])) {
			$response = ihttp_request(url('utility/bindcall', array('modulename' => $bind['module'], 'callname' => $bind['call'], 'args' => $args, 'uniacid' => $_W['uniacid'])), array(), $extra);
			if (is_error($response)) {
				continue;
			}
			$response = json_decode($response['content'], true);
			$ret = $response['message']['message'];
			if(is_array($ret)) {
				foreach($ret as $i => $et) {
					if (empty($et['url'])) {
						continue;
					}
					$et['url'] = $et['url'] . '&__title=' . urlencode($et['title']);
					$entries[$bind['entry']][] = array('eid' => 'user_' . $i, 'title' => $et['title'], 'do' => $et['do'], 'url' => $et['url'], 'from' => 'call', 'icon' => $et['icon'], 'displayorder' => $et['displayorder']);
				}
			}
		} else {
			if (in_array($bind['entry'], array('cover', 'home', 'profile', 'shortcut'))) {
				$url = murl('entry', array('eid' => $bind['eid']));
			}
			if (in_array($bind['entry'], array('menu', 'system_welcome'))) {
				$url = wurl("site/entry", array('eid' => $bind['eid']));
			}
			if($bind['entry'] == 'mine') {
				$url = $bind['url'];
			}
			if($bind['entry'] == 'rule') {
				$par = array('eid' => $bind['eid']);
				if (!empty($rid)) {
					$par['id'] = $rid;
				}
				$url = wurl("site/entry", $par);
			}

			if(empty($bind['icon'])) {
				$bind['icon'] = 'fa fa-puzzle-piece';
			}
			if (!defined('SYSTEM_WELCOME_MODULE') && $bind['entry'] == 'system_welcome') {
				continue;
			}
			$entries[$bind['entry']][] = array('eid' => $bind['eid'], 'title' => $bind['title'], 'do' => $bind['do'], 'url' => $url, 'from' => 'define', 'icon' => $bind['icon'], 'displayorder' => $bind['displayorder'], 'direct' => $bind['direct']);
		}
	}
	return $entries;
}

function module_app_entries($name, $types = array(), $args = null) {
	global $_W;
	$ts = array('rule', 'cover', 'menu', 'home', 'profile', 'shortcut', 'function');
	if(empty($types)) {
		$types = $ts;
	} else {
		$types = array_intersect($types, $ts);
	}
	$bindings = pdo_getall('modules_bindings', array('module' => $name, 'entry' => $types));
	$entries = array();
	foreach($bindings as $bind) {
		if(!empty($bind['call'])) {
			$extra = array();
			$extra['Host'] = $_SERVER['HTTP_HOST'];
			load()->func('communication');
			$urlset = parse_url($_W['siteurl']);
			$urlset = pathinfo($urlset['path']);
			$response = ihttp_request($_W['sitescheme'] . '127.0.0.1/'. $urlset['dirname'] . '/' . url('utility/bindcall', array('modulename' => $bind['module'], 'callname' => $bind['call'], 'args' => $args, 'uniacid' => $_W['uniacid'])), array('W'=>base64_encode(iserializer($_W))), $extra);
			if (is_error($response)) {
				continue;
			}
			$response = json_decode($response['content'], true);
			$ret = $response['message'];
			if(is_array($ret)) {
				foreach($ret as $et) {
					$et['url'] = $et['url'] . '&__title=' . urlencode($et['title']);
					$entries[$bind['entry']][] = array('title' => $et['title'], 'url' => $et['url'], 'from' => 'call');
				}
			}
		} else {
			if($bind['entry'] == 'cover') {
				$url = murl("entry", array('eid' => $bind['eid']));
			}
			if($bind['entry'] == 'home') {
				$url = murl("entry", array('eid' => $bind['eid']));
			}
			if($bind['entry'] == 'profile') {
				$url = murl("entry", array('eid' => $bind['eid']));
			}
			if($bind['entry'] == 'shortcut') {
				$url = murl("entry", array('eid' => $bind['eid']));
			}
			$entries[$bind['entry']][] = array('title' => $bind['title'], 'do' => $bind['do'], 'url' => $url, 'from' => 'define');
		}
	}
	return $entries;
}

function module_entry($eid) {
	$sql = "SELECT * FROM " . tablename('modules_bindings') . " WHERE `eid`=:eid";
	$pars = array();
	$pars[':eid'] = $eid;
	$entry = pdo_fetch($sql, $pars);
	if(empty($entry)) {
		return error(1, '模块菜单不存在');
	}
	$module = module_fetch($entry['module']);
	if(empty($module)) {
		return error(2, '模块不存在');
	}
	$querystring = array(
		'do' => $entry['do'],
		'm' => $entry['module'],
	);
	if (!empty($entry['state'])) {
		$querystring['state'] = $entry['state'];
	}

	$entry['url'] = murl('entry', $querystring);
	$entry['url_show'] = murl('entry', $querystring, true, true);
	return $entry;
}


function module_build_form($name, $rid, $option = array()) {
	$rid = intval($rid);
	$m = WeUtility::createModule($name);
	if(!empty($m)) {
		return $m->fieldsFormDisplay($rid, $option);
	}else {
		return null;
	}

}


function module_save_group_package($package) {
	global $_W;
	load()->model('user');
	load()->model('cache');

	if (empty($package['name'])) {
		return error(-1, '请输入套餐名');
	}

	if (user_is_vice_founder()) {
		$package['owner_uid'] = $_W['uid'];
	}
	if (!empty($package['modules'])) {
		$package['modules'] = iserializer($package['modules']);
	}

	if (!empty($package['templates'])) {
		$templates = array();
		foreach ($package['templates'] as $template) {
			$templates[] = $template['id'];
		}
		$package['templates'] = iserializer($templates);
	}

	if (!empty($package['id'])) {
		$name_exist = pdo_get('uni_group', array('uniacid' => 0, 'id <>' => $package['id'], 'name' => $package['name']));
	} else {
		$name_exist = pdo_get('uni_group', array('uniacid' => 0, 'name' => $package['name']));
	}

	if (!empty($name_exist)) {
		return error(-1, '套餐名已存在');
	}

	if (!empty($package['id'])) {
		pdo_update('uni_group', $package, array('id' => $package['id']));
		cache_build_account_modules();
	} else {
		pdo_insert('uni_group', $package);
	}

	cache_build_uni_group();
	return error(0, '添加成功');
}

function module_fetch($name, $enabled = true) {
	global $_W;
	$cachekey = cache_system_key('module_info', array('module_name' => $name));
	$module = cache_load($cachekey);
	if (empty($module)) {
		$module_info = table('modules')->getByName($name);
		if (empty($module_info)) {
			return array();
		}
		if (!empty($module_info['subscribes'])) {
			$module_info['subscribes'] = (array)unserialize ($module_info['subscribes']);
		}
		if (!empty($module_info['handles'])) {
			$module_info['handles'] = (array)unserialize ($module_info['handles']);
		}
		$module_info['isdisplay'] = 1;

		if (file_exists (IA_ROOT . '/addons/' . $module_info['name'] . '/icon-custom.jpg')) {
			$module_info['logo'] = tomedia (IA_ROOT . '/addons/' . $module_info['name'] . '/icon-custom.jpg') . "?v=" . time ();
		} else {
			$module_info['logo'] = tomedia (IA_ROOT . '/addons/' . $module_info['name'] . '/icon.jpg') . "?v=" . time ();
		}
		if (file_exists(IA_ROOT . '/addons/' . $module_info['name'] . '/preview-custom.jpg')) {
			$module_info['preview'] = tomedia(IA_ROOT . '/addons/' . $module_info['name'] . '/preview-custom.jpg');
		} else {
			$module_info['preview'] = tomedia(IA_ROOT . '/addons/' . $module_info['name'] . '/preview.jpg');
		}
		$module_info['main_module'] = pdo_getcolumn ('modules_plugin', array ('name' => $module_info['name']), 'main_module');
		if (!empty($module_info['main_module'])) {
			$main_module_info = module_fetch ($module_info['main_module']);
			$module_info['main_module_logo'] = $main_module_info['logo'];
		} else {
			$module_info['plugin_list'] = pdo_getall ('modules_plugin', array ('main_module' => $module_info['name']), array (), 'name');
			if (!empty($module_info['plugin_list'])) {
				$module_info['plugin_list'] = array_keys ($module_info['plugin_list']);
			}
		}
		if ($module_info[MODULE_SUPPORT_ACCOUNT_NAME] != MODULE_SUPPORT_ACCOUNT && $module_info[MODULE_SUPPORT_PHONEAPP_NAME] != MODULE_SUPPORT_PHONEAPP && $module_info[MODULE_SUPPORT_XZAPP_NAME] != MODULE_SUPPORT_XZAPP && $module_info['wxapp_support'] != MODULE_SUPPORT_WXAPP && $module_info['webapp_support'] != MODULE_SUPPORT_WEBAPP && $module_info['welcome_support'] != MODULE_SUPPORT_SYSTEMWELCOME) {
			$module_info[MODULE_SUPPORT_ACCOUNT_NAME] = MODULE_SUPPORT_ACCOUNT;
		}

		$module_receive_ban = (array)setting_load('module_receive_ban');
		if (is_array($module_receive_ban['module_receive_ban']) && in_array($name, $module_receive_ban['module_receive_ban'])) {
			$module_info['is_receive_ban'] = true;
		}
				$module_ban = (array)setting_load('module_ban');
		if (is_array($module_ban['module_ban']) && in_array($name, $module_ban['module_ban'])) {
			$module_info['is_ban'] = true;
		}

		$module_upgrade = (array)setting_load('module_upgrade');
		if (is_array($module_upgrade['module_upgrade']) && in_array($name, array_keys($module_upgrade['module_upgrade']))) {
			$module_info['is_upgrade'] = true;
		}

				$module_is_delete = table('modules_recycle')->getByName($name);
		if (!empty($module_is_delete)) {
			$module_info['is_delete'] = true;
		}

		$module = $module_info;
		cache_write($cachekey, $module_info);
	}

		if (!empty($enabled)) {
		if (!empty($module_info['is_delete'])) {
			return array();
		}
	}

		if (!empty($module) && !empty($_W['uniacid'])) {
		$setting_cachekey = cache_system_key('module_setting', array('module_name' => $name, 'uniacid' => $_W['uniacid']));
		$setting = cache_load($setting_cachekey);
		if (empty($setting)) {
			$setting = pdo_get('uni_account_modules', array('module' => $name, 'uniacid' => $_W['uniacid']));
			$setting = empty($setting) ? array('module' => $name) : $setting;
			cache_write($setting_cachekey, $setting);
		}
		$module['config'] = !empty($setting['settings']) ? iunserializer($setting['settings']) : array();
		$module['enabled'] = $module['issystem'] || !isset($setting['enabled']) ? 1 : $setting['enabled'];
		$module['displayorder'] = $setting['displayorder'];
		$module['shortcut'] = $setting['shortcut'];
	}
	return $module;
}


function module_permission_fetch($name) {
	$module = module_fetch($name);
	$data = array();
	if($module['settings']) {
		$data[] = array('title' => '参数设置', 'permission' => $name.'_settings');
	}
	if($module['isrulefields']) {
		$data[] = array('title' => '回复规则列表', 'permission' => $name.'_rule');
	}
	$entries = module_entries($name);
	if(!empty($entries['home'])) {
		$data[] = array('title' => '微站首页导航', 'permission' => $name.'_home');
	}
	if(!empty($entries['profile'])) {
		$data[] = array('title' => '个人中心导航', 'permission' => $name.'_profile');
	}
	if(!empty($entries['shortcut'])) {
		$data[] = array('title' => '快捷菜单', 'permission' => $name.'_shortcut');
	}
	if(!empty($entries['cover'])) {
		foreach($entries['cover'] as $cover) {
			$data[] = array('title' => $cover['title'], 'permission' => $name.'_cover_'.$cover['do']);
		}
	}
	if(!empty($entries['menu'])) {
		foreach($entries['menu'] as $menu) {
			$data[] = array('title' => $menu['title'], 'permission' => $name.'_menu_'.$menu['do']);
		}
	}
	unset($entries);
	if(!empty($module['permissions'])) {
		$module['permissions'] = (array)iunserializer($module['permissions']);
		foreach ($module['permissions'] as $permission) {
			$data[] = array('title' => $permission['title'], 'permission' => $name . '_permission_' . $permission['permission']);
		}
	}
	return $data;
}



function module_get_plugin_list($module_name) {
	$module_info = module_fetch($module_name);
	if (!empty($module_info['plugin_list']) && is_array($module_info['plugin_list'])) {
		$plugin_list = array();
		foreach ($module_info['plugin_list'] as $plugin) {
			$plugin_info = module_fetch($plugin);
			if (!empty($plugin_info)) {
				$plugin_list[$plugin] = $plugin_info;
			}
		}
		return $plugin_list;
	} else {
		return array();
	}
}


function module_status($module) {
	load()->model('cloud');
	$result = array(
		'upgrade' => array(
			'has_upgrade' => false,
		),
		'ban' => false,
	);

	$module_cloud_info = table('modules_cloud')->getByName($module);
	if (!empty($module_cloud_info['has_new_version']) || !empty($module_cloud_info['has_new_branch'])) {
		$result['upgrade'] = array(
			'has_upgrade' => true,
			'name' => $module_cloud_info['title'],
			'version' => $module_cloud_info['version'],
		);
	}
	if (!empty($module_cloud_info['is_ban'])) {
		$result['ban'] = true;
	}
	return $result;
}


function module_exist_in_account($module_name, $uniacid) {
	global $_W;
	$result = false;
	$module_name = trim($module_name);
	$uniacid = intval($uniacid);
	if (empty($module_name) || empty($uniacid)) {
		return $result;
	}
	$founders = explode(',', $_W['config']['setting']['founder']);
	$owner_uid = pdo_getcolumn('uni_account_users',  array('uniacid' => $uniacid, 'role' => 'owner'), 'uid');
	if (!empty($owner_uid) && !in_array($owner_uid, $founders)) {
		if (IMS_FAMILY == 'x') {
			$site_store_buy_goods = uni_site_store_buy_goods($uniacid);
		} else {
			$site_store_buy_goods = array();
		}
		$account_table = table('account');
		$uni_modules = $account_table->accountGroupModules($uniacid);
		$user_modules = user_modules($owner_uid);
		$modules = array_merge(array_keys($user_modules), $uni_modules, $site_store_buy_goods);
		$result = in_array($module_name, $modules) ? true : false;
	} else {
		$result = true;
	}
	return $result;
}



function module_get_user_account_list($uid, $module_name) {
	$accounts_list = array();
	$uid = intval($uid);
	$module_name = trim($module_name);
	if (empty($uid) || empty($module_name)) {
		return $accounts_list;
	}
	$module_info = module_fetch($module_name);
	if (empty($module_info)) {
		return $accounts_list;
	}

	$account_users_info = table('account')->userOwnedAccount($uid);
	if (empty($account_users_info)) {
		return $accounts_list;
	}
	$accounts = array();
	foreach ($account_users_info as $account) {
		if (empty($account['uniacid'])) {
			continue;
		}
		$uniacid = 0;
		if (($account['type'] == ACCOUNT_TYPE_OFFCIAL_NORMAL || $account['type'] == ACCOUNT_TYPE_OFFCIAL_AUTH) && $module_info[MODULE_SUPPORT_ACCOUNT_NAME] == MODULE_SUPPORT_ACCOUNT) {
			$uniacid = $account['uniacid'];
		} elseif ($account['type'] == ACCOUNT_TYPE_APP_NORMAL && $module_info['wxapp_support'] == MODULE_SUPPORT_WXAPP) {
			$uniacid = $account['uniacid'];
		} elseif (($account['type'] == ACCOUNT_TYPE_XZAPP_NORMAL || $account['type'] == ACCOUNT_TYPE_XZAPP_AUTH) && $module_info[MODULE_SUPPORT_XZAPP_NAME] == MODULE_SUPPORT_XZAPP) {
			$uniacid = $account['uniacid'];
		} elseif (($account['type'] == ACCOUNT_TYPE_WEBAPP_NORMAL && $module_info[MODULE_SUPPORT_WEBAPP_NAME] == MODULE_SUPPORT_WEBAPP)) {
			$uniacid = $account['uniacid'];
		} elseif (($account['type'] == ACCOUNT_TYPE_PHONEAPP_NORMAL && $module_info[MODULE_SUPPORT_PHONEAPP_NAME] == MODULE_SUPPORT_PHONEAPP)) {
			$uniacid = $account['uniacid'];
		} elseif (($account['type'] == ACCOUNT_TYPE_ALIAPP_NORMAL && $module_info[MODULE_SUPPORT_ALIAPP_NAME] == MODULE_SUPPORT_ALIAPP)) {
			$uniacid = $account['uniacid'];
		}
		if (!empty($uniacid)) {
			if (module_exist_in_account($module_name, $uniacid)) {
				$accounts_list[$uniacid] = $account;
			}
		}
	}

	return $accounts_list;
}


function module_link_uniacid_fetch($uid, $module_name) {
	$result = array();
	$uid = intval($uid);
	$module_name = trim($module_name);
	if (empty($uid) || empty($module_name)) {
		return $result;
	}
	$accounts_list = module_get_user_account_list($uid, $module_name);
	if (empty($accounts_list)) {
		return $result;
	}

	$accounts_link_result = array();
	foreach ($accounts_list as $key => $account_value) {
		if (in_array($account_value['type'], array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_ALIAPP_NORMAL))) {
			$account_value['versions'] = miniapp_version_all($account_value['uniacid']);
			if (empty($account_value['versions'])) {
				$accounts_link_result[$key] = $account_value;
				continue;
			}
			foreach ($account_value['versions'] as $version_key => $version_value) {
				if (empty($version_value['modules'])) {
					continue;
				}
				if ($version_value['modules'][0]['name'] != $module_name) {
					continue;
				}
				if (empty($version_value['modules'][0]['account']) || !is_array($version_value['modules'][0]['account'])) {
					$accounts_link_result[$key] = $account_value;
					continue;
				}
				if (!empty($version_value['modules'][0]['account']['uniacid'])) {
					$accounts_link_result[$version_value['modules'][0]['account']['uniacid']][] = array(
						'uniacid' => $key,
						'version' => $version_value['version'],
						'version_id' => $version_value['id'],
						'name' => $account_value['name'],
					);
					unset($account_value['versions'][$version_key]);
				}

			}
		} elseif ($account_value['type'] == ACCOUNT_TYPE_OFFCIAL_NORMAL || $account_value['type'] == ACCOUNT_TYPE_OFFCIAL_AUTH || $account_value['type']== ACCOUNT_TYPE_XZAPP_NORMAL || $account_value['type'] == ACCOUNT_TYPE_XZAPP_AUTH) {
			if (empty($accounts_link_result[$key])) {
				$accounts_link_result[$key] = $account_value;
			} else {
				$link_wxapp = $accounts_link_result[$key];
				$accounts_link_result[$key] = $account_value;
				$accounts_link_result[$key]['link_wxapp'] = $link_wxapp;
			}
		} else {
			if (empty($accounts_link_result[$key])) {
				$accounts_link_result[$key] = $account_value;
			}
		}
	}
	if (!empty($accounts_link_result)) {
		foreach ($accounts_link_result as $link_key => $link_value) {

			if (in_array($link_value['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH))) {
				$link_value['type_name'] = ACCOUNT_TYPE_SIGN;
			} elseif (in_array($link_value['type'], array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH))) {
				$link_value['type_name'] = WXAPP_TYPE_SIGN;
			} elseif ($link_value['type'] == ACCOUNT_TYPE_WEBAPP_NORMAL) {
				$link_value['type_name'] = WEBAPP_TYPE_SIGN;
			}elseif ($link_value['type'] == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
				$link_value['type_name'] = PHONEAPP_TYPE_SIGN;
			}elseif ($link_value['type'] == ACCOUNT_TYPE_XZAPP_NORMAL) {
				$link_value['type_name'] = XZAPP_TYPE_SIGN;
			}elseif ($link_value['type'] == ACCOUNT_TYPE_ALIAPP_NORMAL) {
				$link_value['type_name'] = ALIAPP_TYPE_SIGN;
			}

			if (in_array($link_value['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH)) && !empty($link_value['link_wxapp']) && is_array($link_value['link_wxapp'])) {

				foreach ($link_value['link_wxapp'] as $value) {
					$result[] = array(
						'app_name' => $link_value['name'],
						'wxapp_name' => $value['name'] . ' ' . $value['version'],
						'uniacid' => $link_value['uniacid'],
						'version_id' => $value['version_id'],
						'type_name' => $link_value['type_name'],
						'account_name' => $link_value['name'],
					);
				}
			} elseif ($link_value['type'] == ACCOUNT_TYPE_APP_NORMAL && !empty($link_value['versions']) && is_array($link_value['versions'])) {
				foreach ($link_value['versions'] as $value) {
					$result[] = array(
						'app_name' => '',
						'wxapp_name' => $link_value['name'] . ' ' . $value['version'],
						'uniacid' => $link_value['uniacid'],
						'version_id' => $value['id'],
						'type_name' => $link_value['type_name'],
						'account_name' => $link_value['name'],
					);
				}
			} else {
				$result[] = array(
					'app_name' => $link_value['name'],
					'wxapp_name' => '',
					'uniacid' => $link_value['uniacid'],
					'version_id' => '',
					'type_name' => $link_value['type_name'],
					'account_name' => $link_value['name'],
				);
			}
		}
	}

	return $result;
}


function module_link_uniacid_info($module_name) {
	if (empty($module_name)) {
		return array();
	}
	$result = table('uni_account_modules')->where('module', $module_name)->getall();
	if (!empty($result)) {
		foreach ($result as $key => $value) {
			$result[$key]['settings'] = iunserializer($value['settings']);
			if (empty($result[$key]['settings']) || (empty($result[$key]['settings']['link_uniacid']) && empty($result[$key]['settings']['passive_link_uniacid']))) {
				unset($result[$key]);
			}
		}
		return $result;
	}
	return array();
}


function module_save_switch($module_name, $uniacid = 0, $version_id = 0) {
	global $_W, $_GPC;
	load()->model('visit');
	if (empty($_GPC['__switch'])) {
		$_GPC['__switch'] = random(5);
	}
	$cache_key = cache_system_key('last_account', array('switch' => $_GPC['__switch']));
	$cache_lastaccount = (array)cache_load($cache_key);
	if (empty($cache_lastaccount)) {
		$cache_lastaccount = array(
			$module_name => array(
				'module_name' => $module_name,
				'uniacid' => $uniacid,
				'version_id' => $version_id
			)
		);
	} else {
		$cache_lastaccount[$module_name] = array(
			'module_name' => $module_name,
			'uniacid' => $uniacid,
			'version_id' => $version_id
		);
	}
	visit_system_update(array('modulename' => $module_name, 'uid' => $_W['uid']));
	cache_write($cache_key, $cache_lastaccount);
	isetcookie('__switch', $_GPC['__switch'], 7 * 86400);
	return true;
}


function module_last_switch($module_name) {
	global $_GPC;
	$module_name = trim($module_name);
	if (empty($module_name)) {
		return array();
	}
	$cache_key = cache_system_key('last_account', array('switch' => $_GPC['__switch']));
	$cache_lastaccount = (array)cache_load($cache_key);
	return $cache_lastaccount[$module_name];
}


function module_clerk_info($module_name) {
	$user_permissions = array();
	$module_name = trim($module_name);
	if (empty($module_name)) {
		return $user_permissions;
	}
	$user_permissions = table('userspermission')->moduleClerkPermission($module_name);
	if (!empty($user_permissions)) {
		foreach ($user_permissions as $key => $value) {
			$user_permissions[$key]['user_info'] = user_single($value['uid']);
		}
	}
	return $user_permissions;
}


function module_rank_top($module_name) {
	global $_W;
	if (empty($module_name)) {
		return false;
	}
	$result = table('modules_rank')->setTop($module_name);
	return empty($result) ? true : false;
}

function module_installed_list($type = '') {
	global $_W;
	$module_list = array();
	$user_has_module = user_modules($_W['uid']);
	if (empty($user_has_module)) {
		return $module_list;
	}
		$module_support_type = module_support_type();

	foreach ($user_has_module as $modulename => $module) {
		if ((!empty($module['issystem']) && $module['name'] != 'we7_coupon')) {
			continue;
		}
		foreach ($module_support_type as $support_name => $support) {

			if ($module[$support_name] == $support['support']) {
				$module_list[$support['type']][$modulename] = $module;
			}
		}
	}

	if (!empty($type)) {
		return (array)$module_list[$type];
	} else {
		return $module_list;
	}
}


function module_uninstall_list()  {
	$uninstall_modules = table('modules_cloud')->getUninstallModule();
	if (!empty($uninstall_modules)) {
		array_walk($uninstall_modules, function(&$row, $key) {
			if ($row[MODULE_SUPPORT_WXAPP_NAME] == MODULE_SUPPORT_WXAPP) {
				$support = MODULE_SUPPORT_WXAPP_NAME;
			} else {
				$support = MODULE_SUPPORT_ACCOUNT_NAME;
			}
			$row['link'] = url('module/manage-system/install', array('module_name' => $row['name'], 'support' => $support));
		});
	}
	return $uninstall_modules;
}


function module_uninstall_total($type) {
	$type_list = module_support_type();
	if (!isset($type_list["{$type}_support"])) {
		return 0;
	}
	$total = table('modules_cloud')->getUninstallTotalBySupportType($type);
	return $total;
}

function module_upgrade_list() {
	$result = array();
	$module_list = user_modules($_W['uid']);
	if (empty($module_list)) {
		return $result;
	}

	$upgrade_modules = table('modules_cloud')->getUpgradeByModuleNameList(array_keys($module_list));
	if (empty($upgrade_modules)) {
		return $result;
	}

	$modules_ignore = table('modules_ignore')->where('name', array_keys($upgrade_modules))->getall('name');
	foreach ($upgrade_modules as $modulename => &$module) {
		if (!empty($modules_ignore[$modulename])) {
			if (ver_compare($modules_ignore[$modulename]['version'], $module['version']) >= 0) {
				$module['is_ignore'] = 1;
			}
		}
		$module['link'] = url('module/manage-system/module_detail', array('name' => $module['name'], 'show' => 'upgrade'));
	}
	unset($module);
	return $upgrade_modules;
}

function module_upgrade_total($type) {
	$type_list = module_support_type();

	if (!isset($type_list["{$type}_support"])) {
		return 0;
	}
	$total = table('modules_cloud')->getUpgradeTotalBySupportType($type);
	return $total;
}


function module_upgrade_info($modulelist = array()) {
	load()->model('cloud');
	load()->model('extension');

	$result = array();

	cloud_prepare();
	$cloud_m_query_module = cloud_m_query();
	if (is_error($cloud_m_query_module)) {
		return array();
	}
		$pirate_apps = $cloud_m_query_module['pirate_apps'];
	unset($cloud_m_query_module['pirate_apps']);

		$manifest_cloud_list = array();
	foreach ($cloud_m_query_module as $modulename => $manifest_cloud) {
		$manifest = array(
			'application' => array(
				'name' => $modulename,
				'title' => $manifest_cloud['title'],
				'version' => $manifest_cloud['version'],
				'logo' => $manifest_cloud['thumb'],
				'version' => $manifest_cloud['version'],
				'last_upgrade_time' => $manifest_cloud['last_upgrade_time'],
			),
			'platform' => array(
				'supports' => array()
			),
		);

		if ($manifest_cloud['site_branch']['app_support'] == MODULE_SUPPORT_ACCOUNT) {
			$manifest['platform']['supports'][] = 'account';
		}
		if ($manifest_cloud['site_branch']['wxapp_support'] == MODULE_SUPPORT_WXAPP) {
			$manifest['platform']['supports'][] = 'wxapp';
		}
		if ($manifest_cloud['site_branch']['xzapp_support'] == MODULE_SUPPORT_XZAPP) {
			$manifest['platform']['supports'][] = 'xzapp';
		}
		if ($manifest_cloud['site_branch']['aliapp_support'] == MODULE_SUPPORT_ALIAPP) {
			$manifest['platform']['supports'][] = 'aliapp';
		}
		if ($manifest_cloud['site_branch']['webapp_support'] == MODULE_SUPPORT_WEBAPP) {
			$manifest['platform']['supports'][] = 'webapp';
		}
		if ($manifest_cloud['site_branch']['android_support'] == MODULE_SUPPORT_PHONEAPP ||
			$manifest_cloud['site_branch']['ios_aupport'] == MODULE_SUPPORT_PHONEAPP) {
			$manifest['platform']['supports'][] = 'phoneapp';
		}
		if ($manifest_cloud['site_branch']['system_welcome_support'] == MODULE_SUPPORT_SYSTEMWELCOME) {
			$manifest['platform']['supports'][] = 'welcome';
		}
		if (empty($manifest['platform']['supports'])) {
			continue;
		}
		$manifest['branches'] = $manifest_cloud['branches'];
		$manifest['site_branch'] = $manifest_cloud['site_branch'];
		$manifest['cloud_id'] = $manifest_cloud['id'];
		$manifest_cloud_list[$modulename] = $manifest;
	}

		if (empty($modulelist)) {
		$modulelist = table('modules')->searchWithType('system', '<>')->getall('name');
	}
	foreach ($modulelist as $modulename => $module) {
		if (!empty($module['issystem'])) {
			unset($modulelist[$modulename]);
			continue;
		}

		$module_upgrade_data = array(
			'name' => $modulename,
			'has_new_version' => 0,
			'has_new_branch' => 0,
		);

		if (!empty($pirate_apps) && in_array($modulename, $pirate_apps)) {
			$module_upgrade_data['is_ban'] = 1;
		}
		$manifest = ext_module_manifest($modulename);

		if (!empty($manifest)) {
			$module_upgrade_data['install_status'] = MODULE_LOCAL_INSTALL;
		} elseif ($manifest_cloud_list[$modulename]) {
			$module_upgrade_data['install_status'] = MODULE_CLOUD_INSTALL;
			$manifest = $manifest_cloud_list[$modulename];
		} else {
						$module_upgrade_data['install_status'] = MODULE_LOCAL_INSTALL;
		}

		$module_upgrade_data['logo'] = $manifest['application']['logo'];
		$module_upgrade_data['version'] = $manifest['application']['version'];
		$module_upgrade_data['title'] = $manifest['application']['title'];
		$module_upgrade_data['title_initial'] = get_first_pinyin($manifest['application']['title']);

						unset($manifest_cloud_list[$modulename]);

		if (version_compare($module['version'], $manifest['application']['version']) == '-1') {
			$module_upgrade_data['has_new_version'] = 1;
			$module_upgrade_data['lastupdatetime'] = TIMESTAMP;
			$result[$modulename] = array(
				'name' => $modulename,
				'new_version' => 1,
				'best_version' => $manifest['application']['version'],
			);
		}

				if ($module_upgrade_data['install_status'] == MODULE_LOCAL_INSTALL && empty($module_upgrade_data['has_new_version'])) {
			continue;
		}

		if (!empty($manifest['branches'])) {
			foreach ($manifest['branches'] as &$branch) {
				if ($branch['displayorder'] > $manifest['site_branch']['displayorder'] || ($branch['displayorder'] == $manifest['site_branch']['displayorder'] && $manifest['site_branch']['id'] < intval($branch['id']))) {
					$module_upgrade_data['has_new_branch'] = 1;
					$result[$modulename]['new_branch'] = 1;
				}
			}
		}

		if (!empty($manifest['platform']['supports'])) {
			foreach (array('account', 'wxapp', 'webapp', 'phoneapp', 'welcome', 'xzapp', 'aliapp') as $support) {
				if (in_array($support, $manifest['platform']['supports'])) {
					$module_upgrade_data["{$support}_support"] = MODULE_SUPPORT_ACCOUNT;
				} else {
					$module_upgrade_data["{$support}_support"] = MODULE_NONSUPPORT_ACCOUNT;
				}
			}
		}

		$module_cloud_upgrade = table('modules_cloud')->getByName($modulename);

		if (empty($module_cloud_upgrade)) {
			pdo_insert('modules_cloud', $module_upgrade_data);
		} else {
			pdo_update('modules_cloud', $module_upgrade_data, array('name' => $modulename));
		}
	}

	if (!empty($manifest_cloud_list)) {
		foreach ($manifest_cloud_list as $modulename => $manifest) {
			$module_upgrade_data = array(
				'name' => $modulename,
				'has_new_version' => 0,
				'has_new_branch' => 0,
				'install_status' => MODULE_CLOUD_UNINSTALL,
				'logo' => $manifest['application']['logo'],
				'version' => $manifest['application']['version'],
				'title' => $manifest['application']['title'],
				'title_initial' => get_first_pinyin($manifest['application']['title']),
				'lastupdatetime' => $manifest['application']['last_upgrade_time'],
				'cloud_id' => $manifest['cloud_id'],
			);
			if (!empty($manifest['platform']['supports'])) {
				foreach (array('account', 'wxapp', 'webapp', 'phoneapp', 'welcome', 'xzapp', 'aliapp') as $support) {
					if (in_array($support, $manifest['platform']['supports'])) {
						$module_upgrade_data["{$support}_support"] = MODULE_SUPPORT_ACCOUNT;
					} else {
						$module_upgrade_data["{$support}_support"] = MODULE_NONSUPPORT_ACCOUNT;
					}
				}
			}

			$module_cloud_upgrade = table('modules_cloud')->getByName($modulename);
			if (empty($module_cloud_upgrade)) {
				pdo_insert('modules_cloud', $module_upgrade_data);
			} else {
				pdo_update('modules_cloud', $module_upgrade_data, array('name' => $modulename));
			}
		}
	}
	return $result;
}

function module_recycle_fetch($modulename) {
	return table('modules_recycle')->getByName($modulename);
}
