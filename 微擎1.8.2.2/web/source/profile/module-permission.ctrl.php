<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$dos = array('display', 'post', 'delete');
$do = !empty($_GPC['do']) ? $_GPC['do'] : 'display';

$module_name = trim($_GPC['m']);
$modulelist = uni_modules(false);
$module = $_W['current_module'] = $modulelist[$module_name];
if(empty($module)) {
	itoast('抱歉，你操作的模块不能被访问！');
}
if(!uni_user_module_permission_check($module_name.'_permissions', $module_name)) {
	itoast('您没有权限进行该操作');
}

if ($do == 'display') {
	$entries = module_entries($module_name);
	$user_permissions = pdo_getall('users_permission', array('uniacid' => $_W['uniacid'], 'type' => $module_name, 'uid <>' => ''), '', 'uid');
	$uids = !empty($user_permissions) && is_array($user_permissions) ? array_keys($user_permissions) : array();
	$users_lists = array();
	if (!empty($uids)) {
		$users_lists = pdo_getall('users', array('uid' => $uids), '', 'uid');
	}
	$current_module_permission = module_permission_fetch($module_name);
	$permission_name = array();
	if (!empty($current_module_permission)) {
		foreach ($current_module_permission as $key => $permission) {
			$permission_name[$permission['permission']] = $permission['title'];
		}
	}
	if (!empty($user_permissions)) {
		foreach ($user_permissions as $key => &$permission) {
			if (!empty($permission['permission'])) {
				$permission['permission'] = explode('|', $permission['permission']);
				foreach ($permission['permission'] as $k => $val) {
					$permission['permission'][$val] = $permission_name[$val];
					unset($permission['permission'][$k]);
				}
			}
			$permission['user_info'] = $users_lists[$key];
		}
		unset($permission);
	}
}

if ($do == 'post') {
	$uid = intval($_GPC['uid']);
	$user = user_single($uid);
	$have_permission = uni_user_menu_permission($uid, $_W['uniacid'], $module_name);
	if (is_error($have_permission)) {
		itoast($have_permission['message']);
	}
	
	if (checksubmit()) {
		$insert_user = array(
				'username' => trim($_GPC['username']),
				'remark' => trim($_GPC['remark']),
				'password' => trim($_GPC['password']),
				'repassword' => trim($_GPC['repassword']),
				'type' => 3
			);
		if (empty($insert_user['username'])) {
			itoast('必须输入用户名，格式为 1-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
		}
		
		$operator = array();
		if (empty($uid)) {
			if (user_check(array('username' => $insert_user['username']))) {
				itoast('非常抱歉，此用户名已经被注册，你需要更换注册名称！');
			}
			if (empty($insert_user['password']) || istrlen($insert_user['password']) < 8) {
				itoast('必须输入密码，且密码长度不得低于8位。');
			}
			if ($insert_user['repassword'] != $insert_user['password']) {
				itoast('两次输入密码不一致');
			}
			unset($insert_user['repassword']);
			$uid = user_register($insert_user);
			if (!$uid) {
				itoast('注册账号失败', '', '');
			}
		} else {
			if (!empty($insert_user['password'])) {
				if (istrlen($insert_user['password']) < 8) {
					itoast('必须输入密码，且密码长度不得低于8位。');
				}
				if ($insert_user['repassword'] != $insert_user['password']) {
					itoast('两次输入密码不一致');
				}
			}
			$operator['password'] = $insert_user['password'];
			$operator['salt'] = $user['salt'];
			$operator['uid'] = $uid;
			$operator['username'] = $insert_user['username'];
			$operator['remark'] = $insert_user['remark'];
			$operator['type'] = $insert_user['type'];
			user_update($operator);
		}
		$permission = $_GPC['module_permission'];
		if (!empty($permission) && is_array($permission)) {
			$permission = implode('|', array_unique($permission));
		} else {
			$permission = 'all';
		}
		if (empty($have_permission)) {
			pdo_insert('users_permission', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'type' => $module_name, 'permission' => $permission));
		} else {
			pdo_update('users_permission', array('permission' => $permission), array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'type' => $module_name));
		}

		$role = uni_permission($uid, $_W['uniacid']);
		if (empty($role)) {
			pdo_insert('uni_account_users', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'role' => 'operator'));
		} else {
			pdo_update('uni_account_users', array('role' => 'operator'), array('uniacid' => $_W['uniacid'], 'uid' => $uid));
		}
		itoast('编辑店员资料成功', url('profile/module-permission', array('m' => $module_name)), 'success');
	}
	
	$current_module_permission = module_permission_fetch($module_name);
	if (!empty($current_module_permission)) {
		foreach ($current_module_permission as &$data) {
			$data['checked'] = 0;
			if (in_array($data['permission'], $have_permission) || in_array('all', $have_permission)) {
				$data['checked'] = 1;
			}
		}
	}
	unset($data);
}

if ($do == 'delete') {
	$operator_id = intval($_GPC['uid']);
	if (empty($operator_id)) {
		itoast('参数错误', referer(), 'error');
	} else {
		$user = pdo_get('users', array('uid' => $operator_id), array('uid'));
		if (!empty($user)) {
			$delete_account_users = pdo_delete('uni_account_users', array('uid' => $operator_id, 'role' => 'operator', 'uniacid' => $_W['uniacid']));
			$delete_user_permission = pdo_delete('users_permission', array('uid' => $operator_id, 'type' => $module_name, 'uniacid' => $_W['uniacid']));
			if (!empty($delete_account_users) && !empty($delete_user_permission)) {
				pdo_delete('users', array('uid' => $operator_id));
			}
		}
		itoast('删除成功', referer(), 'success');
	}
}
template('profile/module-permission');