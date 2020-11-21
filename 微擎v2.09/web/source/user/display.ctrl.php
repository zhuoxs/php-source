<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('user');
load()->model('message');

$dos = array('display', 'operate');
$do = in_array($do, $dos) ? $do: 'display';

$founders = explode(',', $_W['config']['setting']['founder']);

if ($do == 'display') {
	$message_id = intval($_GPC['message_id']);
	message_notice_read($message_id);

	$user_groups = user_group();
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$users_table = table('users');
	$users_table->searchWithTimelimitStatus(intval($_GPC['expire']));
	if (!empty($_GPC['user_type'])) {
		$user_type = $_GPC['user_type'] == USER_TYPE_COMMON ? USER_TYPE_COMMON : USER_TYPE_CLERK;
		if ($user_type == USER_TYPE_CLERK) {
			$users_table->searchWithType(USER_TYPE_CLERK);
		} else {
			$users_table->searchWithType(USER_TYPE_COMMON);
		}
	}

	$type = empty($_GPC['type']) ? 'display' : $_GPC['type'];
	if (in_array($type, array('display', 'check', 'recycle'))) {
		switch ($type) {
			case 'check':
				permission_check_account_user('system_user_check');
				$users_table->searchWithStatus(USER_STATUS_CHECK);
				$users_table->userOrderBy('joindate', 'DESC');
				break;
			case 'recycle':
				permission_check_account_user('system_user_recycle');
				$users_table->searchWithStatus(USER_STATUS_BAN);
				break;
			default:
				permission_check_account_user('system_user');
				$users_table->searchWithStatus(USER_STATUS_NORMAL);
				$users_table->searchWithFounder(array(ACCOUNT_MANAGE_GROUP_GENERAL, ACCOUNT_MANAGE_GROUP_FOUNDER));
				break;
		}

		$search = safe_gpc_string($_GPC['search']);
		if (!empty($search)) {
			$users_table->searchWithNameOrMobile($search);
		}

		$group_id = intval($_GPC['groupid']);
		if (!empty($group_id)) {
			$users_table->searchWithGroupId($group_id);
		}

		
			if (user_is_vice_founder()) {
				$users_table->searchFounderOwnUsers($_W['uid']);
			}
		

		$users_table->searchWithoutFounder();
		$users_table->searchWithPage($pindex, $psize);
		$users = $users_table->getUsersList();
		$total = $users_table->getLastQueryTotal();
		$users = user_list_format($users);
		$users = array_values($users);
		$pager = pagination($total, $pindex, $psize);
	}
	template('user/display');
}

if ($do == 'operate') {
	if (!$_W['isajax'] || !$_W['ispost']) {
		iajax(-1, '非法操作！', referer());
	}
	$type = safe_gpc_string($_GPC['type']);
	$types = array('recycle', 'recycle_delete', 'recycle_restore', 'check_pass');
	if (!in_array($type, $types)) {
		iajax(-1, '类型错误!', referer());
	}
	switch ($type) {
		case 'check_pass':
			permission_check_account_user('system_user_check');
			break;
		case 'recycle':
		case 'recycle_delete':
		case 'recycle_restore':
			permission_check_account_user('system_user_recycle');
			break;
	}
	$uid = intval($_GPC['uid']);
	$uid_user = user_single($uid);
	if (in_array($uid, $founders)) {
		iajax(-1, '访问错误, 无法操作站长.', url('user/display'));
	}
	if (empty($uid_user)) {
		exit('未指定用户,无法删除.');
	}
	
		if ($uid_user['founder_groupid'] != ACCOUNT_MANAGE_GROUP_GENERAL) {
			iajax(-1, '非法操作', referer());
		}
	
	switch ($type) {
		case 'check_pass':
			$data = array('status' => USER_STATUS_NORMAL);
			pdo_update('users', $data , array('uid' => $uid));
			iajax(0, '更新成功', referer());
			break;
		case 'recycle':			user_delete($uid, true);
			iajax(0, '更新成功', referer());
			break;
		case 'recycle_delete':			user_delete($uid);
			iajax(0, '删除成功', referer());
			break;
		case 'recycle_restore':
			$data = array('status' => USER_STATUS_NORMAL);
			pdo_update('users', $data , array('uid' => $uid));
			iajax(0, '启用成功', referer());
			break;
	}
}