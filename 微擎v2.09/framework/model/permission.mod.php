<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function permission_build() {
	global $_W, $acl;
	load()->model('system');
	$we7_file_permission = $acl;
	$permission_frames = system_menu();
	if (!in_array($_W['role'], array(ACCOUNT_MANAGE_NAME_OPERATOR, ACCOUNT_MANAGE_NAME_MANAGER)) || empty($_W['uniacid'])) {
		return $we7_file_permission;
	}

	$cachekey = cache_system_key('permission', array('uniacid' => $_W['uniacid'], 'uid' => $_W['uid']));
	$cache = cache_load($cachekey);

	if (!empty($cache)) {
		return $cache;
	}
	$permission_exist = permission_account_user_permission_exist($_W['uid'], $_W['uniacid']);
	if (empty($permission_exist)) {
		cache_write($cachekey, $we7_file_permission);
		return $we7_file_permission;
	}
	$user_account_permission = permission_account_user_menu($_W['uid'], $_W['uniacid'], PERMISSION_ACCOUNT);
	$user_wxapp_permission = permission_account_user_menu($_W['uid'], $_W['uniacid'], PERMISSION_WXAPP);
	$user_permission = array_merge($user_account_permission, $user_wxapp_permission);

	$permission_contain = array('account', 'wxapp', 'system', 'phoneapp');
	$section = array();
	$permission_result = array();
	foreach ($permission_frames as $key => $frames) {
		if (!in_array($key, $permission_contain) || empty($frames['section'])) {
			continue;
		}
		foreach ($frames['section'] as $frame_key => $frame) {
			if (empty($frame['menu'])) {
				continue;
			}
			$section[$key][$frame_key] = $frame['menu'];
		}
	}
	$account = permission_get_nameandurl($section[$permission_contain[0]]);
	$wxapp = permission_get_nameandurl($section[$permission_contain[1]]);
	$system = permission_get_nameandurl($section[$permission_contain[2]]);
	$permission_result = array_merge($account, $wxapp, $system);

	foreach ($permission_result as $permission_val) {
		if (in_array($permission_val['permission_name'], $user_permission)) {
			$we7_file_permission[$permission_val['controller']][$_W['role']][] = $permission_val['action'];
		}
	}
	cache_write($cachekey, $we7_file_permission);
	return $we7_file_permission;
}


function permission_get_nameandurl($permission) {
	$result = array();
	if (empty($permission)) {
		return $result;
	}
	foreach ($permission as $menu) {
		if (empty($menu)) {
			continue;
		}
		foreach ($menu as $permission_name) {
			$url_query_array = url_params($permission_name['url']);
			$result[] = array(
				'url' => $permission_name['url'],
				'controller' => $url_query_array['c'],
				'action' => $url_query_array['a'],
				'permission_name' => $permission_name['permission_name']
			);
			if (!empty($permission_name['sub_permission'])) {
				foreach ($permission_name['sub_permission'] as $key => $sub_permission_name) {
					$sub_url_query_array = url_params($sub_permission_name['url']);
					$result[] = array(
						'url' => $sub_permission_name['url'],
						'controller' => $sub_url_query_array['c'],
						'action' => $sub_url_query_array['a'],
						'permission_name' => $sub_permission_name['permission_name'],
					);
				}
			}
		}
	}
	return $result;
}


function permission_account_user_role($uid = 0, $uniacid = 0) {
	global $_W;
	load()->model('user');
	$role = '';
	$uid = empty($uid) ? $_W['uid'] : intval($uid);

	if (user_is_founder($uid, true)) {
		return ACCOUNT_MANAGE_NAME_FOUNDER;
	} else {
		$user_info = pdo_get('users', array('uid' => $uid));
		$user_info['endtime'] = user_end_time($user_info['uid']);

		if (!empty($user_info['endtime']) && $user_info['endtime'] < TIMESTAMP) {
			return ACCOUNT_MANAGE_NAME_EXPIRED;
		}
		if (user_is_vice_founder($uid)) {
			return ACCOUNT_MANAGE_NAME_VICE_FOUNDER;
		}
		if (!user_is_bind()) {
			return ACCOUNT_MANAGE_NAME_UNBIND_USER;
		}
		if ($user_info['type'] == ACCOUNT_OPERATE_CLERK) {
			return ACCOUNT_MANAGE_NAME_CLERK;
		}
	}

	if (!empty($uniacid)) {
		$role = table('uni_account_users')->getUserRoleByUniacid($uid, $uniacid);
		if ($role == ACCOUNT_MANAGE_NAME_OWNER) {
			$role = ACCOUNT_MANAGE_NAME_OWNER;
		} elseif ($role == ACCOUNT_MANAGE_NAME_VICE_FOUNDER) {
			$role = ACCOUNT_MANAGE_NAME_VICE_FOUNDER;
		} elseif ($role == ACCOUNT_MANAGE_NAME_MANAGER) {
			$role = ACCOUNT_MANAGE_NAME_MANAGER;
		} elseif ($role == ACCOUNT_MANAGE_NAME_OPERATOR) {
			$role = ACCOUNT_MANAGE_NAME_OPERATOR;
		} elseif ($role == ACCOUNT_MANAGE_NAME_CLERK) {
			$role = ACCOUNT_MANAGE_NAME_CLERK;
		}
		return $role;
	} else {
		$roles = table('uni_account_users')->getAllUserRole($uid);
		$roles = array_keys($roles);
		if (in_array(ACCOUNT_MANAGE_NAME_VICE_FOUNDER, $roles)) {
			$role = ACCOUNT_MANAGE_NAME_VICE_FOUNDER;
		} elseif (in_array(ACCOUNT_MANAGE_NAME_OWNER, $roles)) {
			$role = ACCOUNT_MANAGE_NAME_OWNER;
		} elseif (in_array(ACCOUNT_MANAGE_NAME_MANAGER, $roles)) {
			$role = ACCOUNT_MANAGE_NAME_MANAGER;
		} elseif (in_array(ACCOUNT_MANAGE_NAME_OPERATOR, $roles)) {
			$role = ACCOUNT_MANAGE_NAME_OPERATOR;
		}
	}
	$role = empty($role) ? ACCOUNT_MANAGE_NAME_OPERATOR : $role;
	return $role;
}


function permission_account_user_permission_exist($uid = 0, $uniacid = 0) {
	global $_W;
	load()->model('user');
	$uid = intval($uid) > 0 ? $uid : $_W['uid'];
	$uniacid = intval($uniacid) > 0 ? $uniacid : $_W['uniacid'];
	if (user_is_founder($uid)) {
		return false;
	}
	if (defined('FRAME') && FRAME == 'system') {
		return true;
	}
	$is_exist = table('users_permission')->getUserPermissionByType($uid, $uniacid);
	if(empty($is_exist)) {
		return false;
	} else {
		return true;
	}
}


function permission_account_user($type = 'system') {
	global $_W;
	$user_permission = table('users_permission')->getUserPermissionByType($_W['uid'], $_W['uniacid'], $type);
	$user_permission = $user_permission['permission'];
	if (empty($user_permission)) {
		$user_permission = array('account*', 'wxapp*', 'phoneapp*');
	}
	$permission_append = frames_menu_append();
		if (!empty($permission_append[$_W['role']])) {
		$user_permission = array_merge($user_permission, $permission_append[$_W['role']]);
	}
		if (empty($_W['role']) && empty($_W['uniacid'])) {
		$user_permission = array_merge($user_permission, $permission_append['operator']);
	}
	return (array)$user_permission;
}


function permission_account_user_menu($uid, $uniacid, $type) {
	$user_menu_permission = array();

	$uid = intval($uid);
	$uniacid = intval($uniacid);
	$type = trim($type);
	if (empty($uid) || empty($uniacid) || empty($type)) {
		return error(-1, '参数错误！');
	}
	$permission_exist = permission_account_user_permission_exist($uid, $uniacid);
	if (empty($permission_exist)) {
		return array('all');
	}
	$user_permission_table = table('users_permission');
	if ($type == 'modules') {
		$user_menu_permission = $user_permission_table->getAllUserModulePermission($uid, $uniacid);
	} else {
		$module = uni_modules_by_uniacid($uniacid);
		$module = array_keys($module);
		if (in_array($type, $module) || in_array($type, array(PERMISSION_ACCOUNT, PERMISSION_WXAPP, PERMISSION_SYSTEM))) {
			$menu_permission = $user_permission_table->getUserPermissionByType($uid, $uniacid, $type);
			$user_menu_permission = !empty($menu_permission['permission']) ? $menu_permission['permission'] : array();
		}
	}

	return $user_menu_permission;
}


function permission_menu_name() {
	load()->model('system');
	$menu_permission = array();

	$menu_list = system_menu_permission_list();
	$middle_menu = array();
	$middle_sub_menu = array();
	if (!empty($menu_list)) {
		foreach ($menu_list as $nav_id => $section) {
			foreach ($section['section'] as $section_id => $section) {
				if (!empty($section['menu'])) {
					$middle_menu[] = $section['menu'];
				}
			}
		}
	}

	if (!empty($middle_menu)) {
		foreach ($middle_menu as $menu) {
			foreach ($menu as $menu_val) {
				$menu_permission[] = $menu_val['permission_name'];
				if (!empty($menu_val['sub_permission'])) {
					$middle_sub_menu[] = $menu_val['sub_permission'];
				}
			}
		}
	}

	if (!empty($middle_sub_menu)) {
		foreach ($middle_sub_menu as $sub_menu) {
			foreach ($sub_menu as $sub_menu_val) {
				$menu_permission[] = $sub_menu_val['permission_name'];
			}
		}
	}
	return $menu_permission;
}


function permission_update_account_user($uid, $uniacid, $data) {
	$uid = intval($uid);
	$uniacid = intval($uniacid);
	if (empty($uid) || empty($uniacid) || !in_array($data['type'], array(PERMISSION_ACCOUNT, PERMISSION_WXAPP, PERMISSION_SYSTEM))) {
		return error('-1', '参数错误！');
	}
	$user_menu_permission = permission_account_user_menu($uid, $uniacid, $data['type']);
	if (is_error($user_menu_permission)) {
		return error('-1', '参数错误！');
	}

	$permission = table('users_permission')->getUserPermissionByType($uid, $uniacid, $data['type']);
	if (empty($permission)) {
		$result = table('users_permission')->fill(array(
			'uniacid' => $uniacid,
			'uid' => $uid,
			'type' => $data['type'],
			'permission' => $data['permission'],
		))->save();
	}  else {
		$result = table('users_permission')->fill(array('permission' => $data['permission']))->whereId($permission['id'])->save();
	}
	return $result;
}



function permission_check_account_user($permission_name, $show_message = true, $action = '') {
	global $_W, $_GPC, $acl;
	load()->model('module');
	$see_more_info = $acl['see_more_info'];
	if (strpos($permission_name, 'see_') === 0) {
		$can_see_more = false;
		if (in_array(FRAME, array('system', 'site', 'account_manage', 'myself'))) {
			$can_see_more = in_array($permission_name, $see_more_info[$_W['highest_role']]) ? true : false;
		} else {
			if (is_array($see_more_info[$_W['role']]) && !empty($see_more_info[$_W['role']])) {
				$can_see_more = in_array($permission_name, $see_more_info[$_W['role']]) ? true : false;
			}
		}
		return $can_see_more;
	}
	$user_has_permission = permission_account_user_permission_exist();
	if (empty($user_has_permission)) {
		return true;
	}
	$modulename = trim($_GPC['m']);
	$do = trim($_GPC['do']);
	$entry_id = intval($_GPC['eid']);

	if ($action == 'reply') {
		$system_modules = module_system();
		if (!empty($modulename) && !in_array($modulename, $system_modules)) {
			$permission_name = $modulename . '_rule';
			$users_permission = permission_account_user($modulename);
		}
	} elseif ($action == 'cover' && $entry_id > 0) {
		load()->model('module');
		$entry = module_entry($entry_id);
		if (!empty($entry)) {
			$permission_name = $entry['module'] . '_cover_' . trim($entry['do']);
			$users_permission = permission_account_user($entry['module']);
		}
	} elseif ($action == 'nav') {
				if(!empty($modulename)) {
			$permission_name = "{$modulename}_{$do}";
			$users_permission = permission_account_user($modulename);
		} else {
			return true;
		}
	} elseif ($action == 'wxapp' || !empty($_W['account']) && $_W['account']['type_sign'] == WXAPP_TYPE_SIGN) {
		$users_permission = permission_account_user('wxapp');
	} else {
		$users_permission = permission_account_user('system');
	}
	if (!isset($users_permission)) {
		$users_permission = permission_account_user('system');
	}
	if ($users_permission[0] != 'all' && !in_array($permission_name, $users_permission) && !in_array(FRAME . '*', $users_permission)) {
		if (in_array($permission_name, permission_first_sub_permission()) && !empty($show_message)) {
			load()->model('system');
			$permission_string = explode('_', $permission_name);
			$goto_permission = permission_subpermission($permission_string[0] . '_' . $permission_string[1] . '_');
			$system_menu = system_menu_permission_list(ACCOUNT_MANAGE_NAME_OPERATOR);
			$goto_url = $system_menu[FRAME]['section'][$permission_string[0]]['menu'][$permission_string[0] . '_' . $permission_string[1]]['sub_permission'][$goto_permission]['url'];
			itoast('', $goto_url);
		}
		if ($show_message) {
			itoast('您没有进行该操作的权限', referer(), 'error');
		} else {
			return false;
		}
	}
	return true;
}

function permission_first_sub_permission() {
	return array(
		'platform_reply_keyword',
		'platform_menu_default',
		'platform_qr_qr',
		'platform_masstask_post',
		'platform_material_news',
		'platform_site_multi',
		'mc_fans_display',
		'mc_member_diaplsy',
		'profile_setting_remote',
		'profile_payment_pay',
		'statistics_visit_app',
		'wxapp_payment_pay',
	);
}

function permission_check_module_user($permission_name) {
	global $_W;
	if (empty($_W['current_module']) || empty($permission_name)) {
		return false;
	}
	$users_permission = permission_account_user($_W['current_module']['name']);
	if (!in_array($permission_name, $users_permission)) {
		return false;
	}
	return true;
}

function permission_check_account_user_module($action = '', $module_name = '') {
	global $_W, $_GPC;
	$status = permission_account_user_permission_exist();
	if(empty($status)) {
		return true;
	}
	$a = trim($_GPC['a']);
	$do = trim($_GPC['do']);
	$m = trim($_GPC['m']);
		if ($a == 'manage-account' && $do == 'setting' && !empty($m)) {
		$permission_name = $m . '_settings';
		$users_permission = permission_account_user($m);
		if ($users_permission[0] != 'all' && !in_array($permission_name, $users_permission)) {
			return false;
		}
			} elseif (!empty($do) && !empty($m)) {
		$is_exist = table('modules_bindings')->isEntryExists($m, 'menu', $do);
		if(empty($is_exist)) {
			return true;
		}
	}
	if(empty($module_name)) {
		$module_name = IN_MODULE;
	}
	$permission = permission_account_user($module_name);
	if(empty($permission) || ($permission[0] != 'all' && !empty($action) && !in_array($action, $permission))) {
		return false;
	}
	return true;
}


function permission_user_account_num($uid = 0) {
	global $_W;
	$uid = intval($uid);
	$user = $uid > 0 ? user_single($uid) : $_W['user'];
	if (empty($user)) {
		return array();
	}
	$account_all_type_sign = array_keys(uni_account_type_sign());
	$extra_group_table = table('users_extra_group');
	$extra_limit_table = table('users_extra_limit');
	if (user_is_vice_founder($user['uid'])) {
		$role = ACCOUNT_MANAGE_NAME_VICE_FOUNDER;
		$group = table('users_founder_group')->getById($user['groupid']);
		$group_num = uni_owner_account_nums($user['uid'], $role);

				$uids = table('users_founder_own_users')->getFounderOwnUsersList($user['uid']);
		foreach ($uids as $u_key => $u_val) {
			$own_user_group_nums = uni_owner_account_nums($u_val['uid'], ACCOUNT_MANAGE_NAME_OWNER);
			foreach ($account_all_type_sign as $sign) {
				$sign_num = $sign . '_num';
				$group_num[$sign_num] += $own_user_group_nums[$sign_num];
			}
		}
	} else {
		$role = ACCOUNT_MANAGE_NAME_OWNER;
		$group = table('users_group')->getById($user['groupid']);
		$group_num = uni_owner_account_nums($user['uid'], $role);
		if (empty($_W['isfounder'])) {
			if (!empty($user['owner_uid'])) {
				$owner_info = table('users')->getById($user['owner_uid']);
				$group_vice = table('users_founder_group')->getById($owner_info['groupid']);

				$founder_group_num = uni_owner_account_nums($owner_info['uid'], ACCOUNT_MANAGE_NAME_VICE_FOUNDER);
				foreach ($account_all_type_sign as $sign) {
					$maxsign = 'max' . $sign;
					$group[$maxsign] = min(intval($group[$maxsign]), intval($group_vice[$maxsign]));
				}
			}
		}
	}

	$store_table = table('store');
	$create_buy_num['account'] = $store_table->searchUserCreateAccountNum($user['uid']);
	$create_buy_num['wxapp'] = $store_table->searchUserCreateWxappNum($user['uid']);
	$store_buy['account'] = $store_table->searchUserBuyAccount($user['uid']);
	$store_buy['wxapp'] = $store_table->searchUserBuyWxapp($user['uid']);

	$extra_create_group_info  = array_keys($extra_group_table->getCreateGroupsByUid($user['uid']));
	$extra_limits_info = $extra_limit_table->getExtraLimitByUid($user['uid']);
	$create_group_info_all = array();
	if (!empty($extra_create_group_info)) {
		$create_group_table = table('users_create_group');
		$create_groups = array();
		foreach($extra_create_group_info as $create_group_id) {
			$create_group_info = $create_group_table->getById($create_group_id);
			$create_groups[] = $create_group_info;
			foreach ($account_all_type_sign as $sign) {
				$maxsign = 'max' . $sign;
				$create_group_info_all[$maxsign] += $create_group_info[$maxsign];
			}
		}
	}

	$extra = $limit = $founder_limit = array();
	foreach ($account_all_type_sign as $sign) {
		$maxsign = 'max' . $sign;
		$extra[$sign] = $create_group_info_all[$maxsign] + $extra_limits_info[$maxsign];

		$sign_num = $sign . '_num';
		$limit[$sign] = max((intval($group[$maxsign]) + $extra[$sign] + intval($store_buy[$sign]) - $group_num[$sign_num]), 0);

		$founder_limit[$sign] = max((intval($group_vice[$maxsign]) + intval($store_buy[$sign]) - $founder_group_num[$sign_num]), 0);
	}

	$data = array(
		'group_name' => $group['name'],
		'vice_group_name' => $group_vice['name'],
		'create_groups' => $create_groups,

				'store_buy_account' => $store_buy['account'],
		'store_buy_wxapp' => $store_buy['wxapp'],
	);
	foreach ($account_all_type_sign as $sign) {
		$maxsign = 'max' . $sign;
		$sign_num = $sign . '_num';
				$data['user_group_max' . $sign] = $group[$maxsign];
				$data['usergroup_' . $sign . '_limit'] = max($group[$maxsign] - $group_num[$sign_num] - intval($create_buy_num[$sign]), 0);
				$data[$maxsign] = $group[$maxsign] + intval($store_buy[$sign]) + $extra[$sign];
				$data[$sign_num] = $group_num[$sign_num];
				$data[$sign . '_limit'] = max($limit[$sign], 0);
				$data['extra_' . $sign] = $extra_limits_info[$maxsign];
				$data['founder_' . $sign . '_limit'] = max($founder_limit[$sign], 0);
	}
	ksort($data);
	return $data;
}

function permission_subpermission($prefix, $module = '') {
	global $_W;
	$result = '';
	if (empty($prefix)) {
		return $result;
	}
	$type = !empty($module) ? safe_gpc_string($module) : ($_W['account']['type_sign'] == 'account' ? 'system' : $_W['account']['type_sign']);
	$account_premission = table('users_permission')->getUserPermissionByType($_W['uid'], $_W['uniacid'], $type);
	if (!empty($account_premission['permission'])) {
		foreach ($account_premission['permission'] as $permission) {
			$if_exist = strpos($permission, $prefix);
			$result = $if_exist !== false ? $permission : '';
			if (!empty($result)) break;
		}
	}
	return $result;
}


function permission_user_account_creatable($uid = 0, $type_sign = '') {
	global $_W;
	$uid = empty($uid) ? $_W['uid'] : $uid;
	$type_sign = empty($type_sign) ? 'account' : $type_sign;
	if(user_is_founder($uid) && !user_is_vice_founder()) {
		return true;
	}
	$key = $type_sign . '_limit';
	$data = permission_user_account_num($uid);
	return isset($data[$key]) && $data[$key] > 0;
}
