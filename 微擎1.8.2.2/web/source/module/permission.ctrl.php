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
define('IN_MODULE', $module_name);
if(empty($module)) {
	itoast('抱歉，你操作的模块不能被访问！');
}
if(!permission_check_account_user_module($module_name.'_permissions', $module_name)) {
	itoast('您没有权限进行该操作');
}

if ($do == 'display') {
	$user_permissions = module_clerk_info($module_name);
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
		}
		unset($permission);
	}
}

if ($do == 'post') {
	$uid = intval($_GPC['uid']);
	$user = user_single($uid);
	$module_and_plugins = array();
	$all_permission = array();
	if (!empty($module['plugin_list'])) {
		$module_and_plugins = array_reverse($module['plugin_list']);
	}
	array_push($module_and_plugins, $module_name);
	$module_and_plugins = array_reverse($module_and_plugins);

	foreach ($module_and_plugins as $key => $module_val) {
		$all_permission[$module_val]['info'] = module_fetch($module_val);
		$all_permission[$module_val]['permission'] = module_permission_fetch($module_val);
	}
	if (!empty($uid)) {
		foreach ($module_and_plugins as $key => $plugin) {
			$have_permission[$plugin] = permission_account_user_menu($uid, $_W['uniacid'], $plugin);
			foreach ($all_permission[$plugin]['permission'] as $key => $value) {
				$all_permission[$plugin]['permission'][$key]['checked'] = 0;
				if (in_array($value['permission'], $have_permission[$plugin]) || in_array('all', $have_permission[$plugin])) {
					$all_permission[$plugin]['permission'][$key]['checked'] = 1;
				}
			}
		}
		if (is_error($have_permission)) {
			itoast($have_permission['message']);
		}
	}
	if (checksubmit()) {
		$insert_user = array(
			'username' => trim($_GPC['username']),
			'remark' => trim($_GPC['remark']),
			'password' => trim($_GPC['password']),
			'repassword' => trim($_GPC['repassword']),
			'type' => ACCOUNT_OPERATE_CLERK
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
			$uid = user_register($insert_user, 'admin');

			if (is_error($uid)) {
				itoast($uid['message'], '', '');
			}

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
			foreach ($module_and_plugins as $name) {
				if (empty($permission[$name])) {
					$module_permission = '';
				} else {
					$module_permission = implode('|', array_unique($permission[$name]));
				}
				if (empty($module_permission) && !empty($have_permission[$name])) {
					pdo_delete('users_permission', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'type' => $name));
					continue;
				}
				if (empty($module_permission)) {
					continue;
				}
				if (empty($have_permission[$name])) {
					pdo_insert('users_permission', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'type' => $name, 'permission' => $module_permission));
				} else {
					pdo_update('users_permission', array('permission' => $module_permission), array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'type' => $name));
				}
			}
		} else {
			foreach ($module_and_plugins as $name) {
				if (!empty($have_permission[$name])) {
					pdo_delete('users_permission', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'type' => $name));
				}
			}
		}

		$role = table('users')->userOwnedAccountRole($uid, $_W['uniacid']);
		if (empty($role)) {
			pdo_insert('uni_account_users', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'role' => 'clerk'));
		} else {
			pdo_update('uni_account_users', array('role' => 'clerk'), array('uniacid' => $_W['uniacid'], 'uid' => $uid));
		}
		itoast('编辑店员资料成功', url('module/permission', array('m' => $module_name)), 'success');
	}
}

if ($do == 'add_clerk') {
	$founders = explode(',', $_W['config']['setting']['founder']);
	$username = trim($_GPC['username']);
	$user = user_single(array('username' => $username));

	if (!empty($user)) {
		if ($user['status'] != 2) {
			itoast('用户未通过审核或不存在', url('module/permission', array('m' => $module_name)), 'error');
		}
		if (in_array($user['uid'], $founders)) {
			itoast('不可操作网站创始人!', url('module/permission', array('m' => $module_name)), 'error');
		}
	} else {
		itoast('用户不存在', url('module/permission', array('m' => $module_name)), 'error');
	}
	$data = array('uniacid' => $_W['uniacid'], 'uid' => $user['uid'], 'type' => $module_name);
	$exists = pdo_get('users_permission', $data);

	if (is_array($exists) && !empty($exists)) {
		itoast('操作员已经存在！', url('module/permission', array('m' => $module_name)), 'error');
	}

	$data['permission'] = 'all';
	$res = pdo_insert('users_permission', $data);
	if ($res) {
		$role = table('users')->userOwnedAccountRole($user['uid'], $_W['uniacid']);
		if (empty($role)) {
			pdo_insert('uni_account_users', array('uniacid' => $_W['uniacid'], 'uid' => $user['uid'], 'role' => 'clerk'));
		} else {
			pdo_update('uni_account_users', array('role' => 'clerk'), array('uniacid' => $_W['uniacid'], 'uid' => $user['uid']));
		}
		itoast('添加成功!', url('module/permission', array('m' => $module_name)), 'success');
	} else {
		itoast('操作失败!', url('module/permission', array('m' => $module_name)), 'error');
	}
}

if ($do == 'delete') {
	$operator_id = intval($_GPC['uid']);
	if (empty($operator_id)) {
		itoast('参数错误', referer(), 'error');
	} else {
		$user = pdo_get('users', array('uid' => $operator_id), array('uid'));
		if (!empty($user)) {
			$delete_account_users = pdo_delete('uni_account_users', array('uid' => $operator_id, 'role' => 'clerk', 'uniacid' => $_W['uniacid']));
			$delete_user_permission = pdo_delete('users_permission', array('uid' => $operator_id, 'type' => $module_name, 'uniacid' => $_W['uniacid']));
		}
		itoast('删除成功', referer(), 'success');
	}
}
template('module/permission');