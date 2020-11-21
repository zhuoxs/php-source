<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('user');

$dos = array('display', 'post', 'del');
$do = !empty($_GPC['do']) ? $_GPC['do'] : 'display';

if ($do == 'display') {
	$_W['page']['title'] = '用户组列表 - 用户组 - 用户管理';

	$pageindex = max(1, intval($_GPC['page']));
	$pagesize = 10;

	$condition = '' ;
	$params = array();
	$name = safe_gpc_string($_GPC['name']);
	if (!empty($name)) {
		$condition .= "WHERE name LIKE :name";
		$params[':name'] = "%{$name}%";
	}
	
		if (user_is_vice_founder()) {
			$condition .= "WHERE owner_uid = :owner_uid";
			$params[':owner_uid'] = $_W['uid'];
		}
	
	$lists = pdo_fetchall("SELECT * FROM " . tablename('users_group') . $condition . " LIMIT " . ($pageindex - 1) * $pagesize . "," . $pagesize, $params);
	$lists = user_group_format($lists);

	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('users_group') . $condition, $params);
	$pager = pagination($total, $pageindex, $pagesize);
	template('user/group-display');
}

if ($do == 'post') {
	$id = intval($_GPC['id']);
	$_W['page']['title'] = $id ? '编辑用户组 - 用户组 - 用户管理' : '添加用户组 - 用户组 - 用户管理';
	if (!empty($id)) {
		$group_info = pdo_get('users_group', array('id' => $id));
		$group_info['package'] = iunserializer($group_info['package']);
		if (!empty($group_info['package']) && in_array(-1, $group_info['package'])) {
			$group_info['check_all'] = true;
		} else {
			$checked_groups = pdo_getall('uni_group', array('uniacid' => 0, 'id' => $group_info['package']), array('id', 'name'), '', array('id DESC'));
		}
	}
	$packages = uni_groups();
	if (!empty($packages)) {
		foreach ($packages as $key => &$package_val) {
			if (!empty($group_info['package']) && in_array($key, $group_info['package'])) {
				$package_val['checked'] = true;
			} else {
				$package_val['checked'] = false;
			}
			if ($package_val['id'] == -1) {
				unset($packages[$key]);
			}
		}
		unset($package_val);
		$packages = array_values($packages);
	}
	$pagesize = 15;
	$pager = pagination(count($packages), 1, $pagesize, '', array('ajaxcallback' => true, 'callbackfuncname' => 'loadMore'));
	if (checksubmit('submit')) {
		$user_group = array(
			'id' => intval($_GPC['id']),
			'name' => $_GPC['name'],
			'package' => $_GPC['package'],
			'maxaccount' => intval($_GPC['maxaccount']),
			'maxwxapp' => intval($_GPC['maxwxapp']),
			'maxwebapp' => intval($_GPC['maxwebapp']),
			'maxphoneapp' => intval($_GPC['maxphoneapp']),
			'maxxzapp' => intval($_GPC['maxxzapp']),
			'maxaliapp' => intval($_GPC['maxaliapp']),
			'timelimit' => intval($_GPC['timelimit'])
		);
		$user_group_info = user_save_group($user_group);
		if (is_error($user_group_info)) {
			itoast($user_group_info['message'], '', '');
		}
		cache_clean(cache_system_key('user_modules'));
		itoast('用户组更新成功！', url('user/group/display'), 'success');
	}
	template('user/group-post');
}

if ($do == 'del') {
	$id = intval($_GPC['id']);
	$result = pdo_delete('users_group', array('id' => $id));
	if(!empty($result)){
		itoast('删除成功！', url('user/group/display'), 'success');
	}else {
		itoast('删除失败！请稍候重试！', url('user/group'), 'error');
	}
	exit;
}