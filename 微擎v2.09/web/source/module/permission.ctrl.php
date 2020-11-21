<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$dos = array('display', 'post', 'delete');
$do = !empty($_GPC['do']) ? $_GPC['do'] : 'display';

$module_name = trim($_GPC['m']);
$modulelist = uni_modules();
$module = $_W['current_module'] = $modulelist[$module_name];

if(empty($module)) {
	itoast('抱歉，你操作的模块不能被访问！');
}
if(!permission_check_account_user_module($module_name.'_permissions', $module_name)) {
	itoast('您没有权限进行该操作');
}

if ($do == 'display') {
	$user_permissions = module_clerk_info($module_name); 	$current_module_permission = module_permission_fetch($module_name); 
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
	if($_W['ispost'] && $_W['isajax']) {
		iajax(0, $user_permissions, '');
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
				if (!empty($value['sub_permission'])) {
					foreach ($value['sub_permission'] as $sub_permission_key => $sub_permission_val) {
						if (in_array($sub_permission_val['permission'], $have_permission[$plugin])) {
							$all_permission[$plugin]['permission'][$key]['sub_permission'][$sub_permission_key]['checked'] = 1;
						}
					}
				}
			}
		}
		if (is_error($have_permission)) {
			itoast($have_permission['message']);
		}
	}

	if (checksubmit()) {
		if (empty($uid)) {
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
			$uid = $user['uid'];
		}

		$permission = $_GPC['module_permission'];
		if (!empty($permission) && is_array($permission)) {
			$permission = safe_gpc_array($permission);
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
			if (empty($all_permission[$module_name]['permission'])) {
				$data = array('uniacid' => $_W['uniacid'], 'uid' => $user['uid'], 'type' => $module_name);
				$exists = pdo_get('users_permission', $data);
				if (is_array($exists) && !empty($exists)) {
					itoast('操作员已经存在！', url('module/permission', array('m' => $module_name)), 'error');
				}
				$data['permission'] = 'all';
				pdo_insert('users_permission', $data);
			} else {
				foreach ($module_and_plugins as $name) {
					if (!empty($have_permission[$name]) && empty($all_permission[$module_name]['permission'])) {
						pdo_delete('users_permission', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'type' => $name));
					}
				}
			}
		}

		$role = table('uni_account_users')->getUserRoleByUniacid($uid, $_W['uniacid']);
		if (empty($role)) {
			pdo_insert('uni_account_users', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'role' => 'clerk'));
		} else {
			pdo_update('uni_account_users', array('role' => 'clerk'), array('uniacid' => $_W['uniacid'], 'uid' => $uid));
		}
		itoast('操作成功', url('module/permission', array('m' => $module_name)), 'success');
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

			$module_info = module_fetch($module_name);
			$module_plugin_list = $module_info['plugin_list'];
			if (!empty($module_plugin_list)) {
				pdo_delete('users_permission', array('uid' => $_GPC['uid'], 'uniacid' => $_W['uniacid'], 'type in' => $module_plugin_list));
			}

			$delete_user_permission = pdo_delete('users_permission', array('uid' => $operator_id, 'type' => $module_name, 'uniacid' => $_W['uniacid']));
			pdo_delete('users_lastuse', array('uid' => $operator_id, 'uniacid' => $_W['uniacid'], 'modulename' => $module_name));
		}
		itoast('删除成功', referer(), 'success');
	}
}
template('module/permission');