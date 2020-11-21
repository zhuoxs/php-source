<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

permission_check_account_user('mc_member');

$dos = array('display', 'change_group_level', 'save_group', 'get_group', 'set_default', 'del_group');
$do = in_array($do, $dos) ? $do : 'display';

if ($do == 'display') {
	$_W['page']['title'] = '会员 - 会员组 ';
	$group_level_setting = pdo_get('uni_settings', array('uniacid' => $_W['uniacid']), array('grouplevel'));
	$group_level = empty($group_level_setting['grouplevel']) ? 0 : $group_level_setting['grouplevel'];

	$group_list = pdo_getall('mc_groups', array('uniacid' => $_W['uniacid']), array(), 'groupid',array(' isdefault DESC', ' credit ASC'));
	$group_person_count = pdo_fetchall('SELECT groupid,COUNT(*) AS num FROM ' . tablename('mc_members') . ' WHERE uniacid = :uniacid GROUP BY groupid', array(':uniacid' => $_W['uniacid']), 'groupid');
	$default_group = pdo_get('mc_groups', array('uniacid' => $_W['uniacid'], 'isdefault' => 1));
	if (empty($default_group)) {
		$default_group = array();
	}
}

if ($do == 'change_group_level') {
	$group_level = intval($_GPC['group_level']);
	pdo_update('uni_settings', array('grouplevel' => $group_level), array('uniacid' => $_W['uniacid']));
	cache_delete(cache_system_key('unisetting', array('uniacid' =>$_W['uniacid'])));
	iajax(0, '');
}

if ($do == 'save_group') {
	$group = $_GPC['group'];
	if (empty($group)) {
		iajax(1, '编辑失败', '');
	}
	$data = array(
		'title' => $group['title'],
		'credit' => $group['credit']
	);
	if (empty($data['title'])) {
		iajax(1, '请填写会员组名称', '');
	}
	if (!empty($group['groupid'])) {
		pdo_update('mc_groups', $data, array('groupid' => $group['groupid']));
		iajax(2, '修改成功', '');
	} else {
		$data['uniacid'] = $_W['uniacid'];
		$default_group = pdo_get('mc_groups', array('uniacid' => $_W['uniacid'], 'isdefault' => 1));
		$data['isdefault'] = empty($default_group) ? 1 : 0;
		pdo_insert('mc_groups', $data);
		$data['groupid'] = pdo_insertid();
		iajax(3, $data, '');
	}
}

if ($do == 'get_group') {
	$group_id = intval($_GPC['group_id']);
	if (empty($group_id)) {
		$data = array(
			'title' => '',
			'is_default' => 0,
			'credit' => 0
		);
		iajax(0, $data, '');
	}
	$group_info = pdo_get('mc_groups', array('groupid' => $group_id));
	if (empty($group_info)) {
		iajax(1, '会员组不存在', '');
	} else {
		iajax(0, $group_info, '');
	}
}

if ($do == 'set_default') {
	$group_id = intval($_GPC['group_id']);
	pdo_update('mc_groups', array('isdefault' => 0), array('uniacid' => $_W['uniacid']));
	pdo_update('mc_groups', array('isdefault' => 1), array('groupid' => $group_id));
	iajax(0, '');
}

if ($do == 'del_group') {
	$group_id = intval($_GPC['group_id']);
	pdo_delete('mc_groups', array('groupid' => $group_id));
	iajax(0, '');
}
template('mc/group');
