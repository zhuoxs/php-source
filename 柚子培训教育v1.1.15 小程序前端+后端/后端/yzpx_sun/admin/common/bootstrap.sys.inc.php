<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
load()->model('user');
load()->func('tpl');
if (file_exists(IA_ROOT . '/framework/model/permission.mod.php')) {
	load()->model('permission');
} else {

	function permission_build() {
		global $_W;
		$we7_file_permission = require IA_ROOT . '/web/common/permission.inc.php';
		$permission_frames = require IA_ROOT . '/web/common/frames.inc.php';
		if (!in_array($_W['role'], array(ACCOUNT_MANAGE_NAME_OPERATOR, ACCOUNT_MANAGE_NAME_MANAGER)) || empty($_W['uniacid'])) {
			return $we7_file_permission;
		}

		$cachekey = cache_system_key("permission:{$_W['uniacid']}:{$_W['uid']}");
		$cache = cache_load($cachekey);
		if (!empty($cache)) {
			return $cache;
		}
		$permission_exist = permission_account_user_permission_exist($_W['uid'], $_W['uniacid']);
		if (empty($permission_exist)) {
			$we7_file_permission['platform'][$_W['role']] = array('platform*');
			$we7_file_permission['site'][$_W['role']] = array('site*');
			$we7_file_permission['mc'][$_W['role']] = array('mc*');
			$we7_file_permission['profile'][$_W['role']] = array('profile*');
			$we7_file_permission['module'][$_W['role']] = array('manage-account', 'display');
			$we7_file_permission['wxapp'][$_W['role']] = array('display', 'payment', 'post', 'version');
			cache_write($cachekey, $we7_file_permission);
			return $we7_file_permission;
		}
		$user_account_permission = permission_account_user_menu($_W['uid'], $_W['uniacid'], PERMISSION_ACCOUNT);
		$user_wxapp_permission = permission_account_user_menu($_W['uid'], $_W['uniacid'], PERMISSION_WXAPP);
		$user_permission = array_merge($user_account_permission, $user_wxapp_permission);

		$permission_contain = array('account', 'wxapp', 'system');
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

	function permission_account_user_role($uid = 0, $uniacid = 0) {
		global $_W;
		load()->model('user');
		$role = '';
		$uid = empty($uid) ? $_W['uid'] : intval($uid);

		if (user_is_founder($uid) && !user_is_vice_founder($uid)) {
			return ACCOUNT_MANAGE_NAME_FOUNDER;
		}

		if (user_is_vice_founder($uid)) {
			return ACCOUNT_MANAGE_NAME_VICE_FOUNDER;
		}

		if (!empty($uniacid)) {
			$role = pdo_getcolumn('uni_account_users', array('uid' => $uid, 'uniacid' => $uniacid), 'role');
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
		} else {
			$roles = pdo_getall('uni_account_users', array('uid' => $uid), array('role'), 'role');
			$roles = array_keys($roles);
			if (in_array(ACCOUNT_MANAGE_NAME_VICE_FOUNDER, $roles)) {
				$role = ACCOUNT_MANAGE_NAME_VICE_FOUNDER;
			} elseif (in_array(ACCOUNT_MANAGE_NAME_OWNER, $roles)) {
				$role = ACCOUNT_MANAGE_NAME_OWNER;
			} elseif (in_array(ACCOUNT_MANAGE_NAME_MANAGER, $roles)) {
				$role = ACCOUNT_MANAGE_NAME_MANAGER;
			} elseif (in_array(ACCOUNT_MANAGE_NAME_OPERATOR, $roles)) {
				$role = ACCOUNT_MANAGE_NAME_OPERATOR;
			} elseif (in_array(ACCOUNT_MANAGE_NAME_CLERK, $roles)) {
				$role = ACCOUNT_MANAGE_NAME_CLERK;
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
		if (FRAME == 'system') {
			return true;
		}
		$is_exist = pdo_get('users_permission', array('uid' => $uid, 'uniacid' => $uniacid), array('id'));
		if(empty($is_exist)) {
			return false;
		} else {
			return true;
		}
	}


	function permission_account_user($type = 'system') {
		global $_W;
		$user_permission = pdo_getcolumn('users_permission', array('uid' => $_W['uid'], 'uniacid' => $_W['uniacid'], 'type' => $type), 'permission');
		if (!empty($user_permission)) {
			$user_permission = explode('|', $user_permission);
		} else {
			$user_permission = array('account*', 'wxapp*');
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
		if ($type == 'modules') {
			$user_menu_permission = pdo_fetchall("SELECT * FROM " . tablename('users_permission') . " WHERE uniacid = :uniacid AND uid  = :uid AND type != '" . PERMISSION_ACCOUNT . "' AND type != '" . PERMISSION_WXAPP . "'", array(':uniacid' => $uniacid, ':uid' => $uid), 'type');
		} else {
			$module = uni_modules_by_uniacid($uniacid);
			$module = array_keys($module);
			if (in_array($type, $module) || in_array($type, array(PERMISSION_ACCOUNT, PERMISSION_WXAPP, PERMISSION_SYSTEM))) {
				$menu_permission = pdo_getcolumn('users_permission', array('uniacid' => $uniacid, 'uid' => $uid, 'type' => $type), 'permission');
				if (!empty($menu_permission)) {
					$user_menu_permission = explode('|', $menu_permission);
				}
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
}

function uni_permission($uid = 0, $uniacid = 0) {
	global $_W;
	$role = '';
	$uid = empty($uid) ? $_W['uid'] : intval($uid);

	$founders = explode(',', $_W['config']['setting']['founder']);
	if (in_array($uid, $founders)) {
		return ACCOUNT_MANAGE_NAME_FOUNDER;
	}
	if (!empty($uniacid)) {
		$role = pdo_getcolumn('uni_account_users', array('uid' => $uid, 'uniacid' => $uniacid), 'role');
		if ($role == ACCOUNT_MANAGE_NAME_OWNER) {
			$role = ACCOUNT_MANAGE_NAME_OWNER;
		} elseif ($role == ACCOUNT_MANAGE_NAME_MANAGER) {
			$role = ACCOUNT_MANAGE_NAME_MANAGER;
		} elseif ($role == ACCOUNT_MANAGE_NAME_OPERATOR) {
			$role = ACCOUNT_MANAGE_NAME_OPERATOR;
		}
	} else {
		$roles = pdo_getall('uni_account_users', array('uid' => $uid), array('role'), 'role');
		$roles = array_keys($roles);
		if (in_array(ACCOUNT_MANAGE_NAME_OWNER, $roles)) {
			$role = ACCOUNT_MANAGE_NAME_OWNER;
		} elseif (in_array(ACCOUNT_MANAGE_NAME_MANAGER, $roles)) {
			$role = ACCOUNT_MANAGE_NAME_MANAGER;
		} elseif (in_array(ACCOUNT_MANAGE_NAME_OPERATOR, $roles)) {
			$role = ACCOUNT_MANAGE_NAME_OPERATOR;
		}
	}
	return $role;
}
$_W['token'] = token();
$session = json_decode(base64_decode($_GPC['__session']), true);
if(is_array($session)) {
	$user = user_single(array('uid'=>$session['uid']));
	if(is_array($user) && $session['hash'] == md5($user['password'] . $user['salt'])) {
		$_W['uid'] = $user['uid'];
		$_W['username'] = $user['username'];
		$user['currentvisit'] = $user['lastvisit'];
		$user['currentip'] = $user['lastip'];
		$user['lastvisit'] = $session['lastvisit'];
		$user['lastip'] = $session['lastip'];
		$_W['user'] = $user;
		$founders = explode(',', $_W['config']['setting']['founder']);
		$_W['isfounder'] = in_array($_W['uid'], $founders);
		unset($founders);
	} else {
		isetcookie('__session', false, -100);
	}
	unset($user);
}
unset($session);

if(!empty($_GPC['__uniacid'])) {
	$_W['uniacid'] = intval($_GPC['__uniacid']);
	$_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
	$_W['acid'] = $_W['account']['acid'];
	$_W['weid'] = $_W['uniacid'];
	if(!empty($_W['uid'])) {
		$_W['role'] = uni_permission($_W['uid'], $_W['uniacid']);
	}
}
$_W['template'] = 'default';
if(!empty($_W['setting']['basic']['template'])) {
	$_W['template'] = $_W['setting']['basic']['template'];
}
load()->func('compat.biz');
