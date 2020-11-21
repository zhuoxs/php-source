<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('user');

$_W['page']['title'] = '添加用户 - 用户管理';

if (checksubmit()) {
	if (!empty($_GPC['vice_founder_name'])) {
		$vice_founder_name = safe_gpc_string($_GPC['vice_founder_name']);
		$vice_founder_info = user_single(array('username' => $vice_founder_name));
		if (empty($vice_founder_info)) {
			itoast('副创始人不存在！');
		}
		if (!user_is_vice_founder($vice_founder_info['uid'])) {
			itoast('请勿添加非副创始人姓名！');
		}
	}
	$user_founder = array(
		'username' => safe_gpc_string($_GPC['username']),
		'password' => $_GPC['password'],
		'repassword' => $_GPC['repassword'],
		'remark' => safe_gpc_string($_GPC['remark']),
		'groupid' => intval($_GPC['groupid']) ? intval($_GPC['groupid']) : 0,
		'starttime' => TIMESTAMP,
		'endtime' => intval(strtotime($_GPC['endtime'])),
		'owner_uid' => !empty($vice_founder_name) ? $vice_founder_info['uid'] : 0,
	);

	$user_add = user_info_save($user_founder);
	if (is_error($user_add)) {
		itoast($user_add['message'], '', '');
	}

	$uid = $user_add['uid'];
	if (!empty($_GPC['extra']['modules']) || !empty($_GPC['extra']['templates'])) {
		$data = array(
			'modules' => iserializer(array('modules' => $_GPC['extra']['modules'], 'wxapp' => $_GPC['extra']['modules'], 'webapp' => $_GPC['extra']['modules'], 'xzapp' => $_GPC['extra']['modules'], 'phoneapp' => $_GPC['extra']['modules'])),
			'templates' => iserializer($_GPC['extra']['templates']),
			'uid' => $uid,
			'uniacid' => 0,
			'owner_uid' => 0,
			'name' => '',
		);
		$id = pdo_fetchcolumn("SELECT id FROM " . tablename('uni_group') . " WHERE uid=:uid and uniacid=:uniacid", array(":uniacid" => 0, ":uid" => $uid));
		if (empty($id)) {
			pdo_insert('uni_group', $data);
		} else {
			pdo_update('uni_group', $data, array('id' => $id));
		}
	} else {
		pdo_delete('uni_group', array('uid' => $uid, 'uniacid' => 0));
	}

	itoast($user_add['message'], url('user/edit', array('uid' => $user_add['uid'])), 'success');
}

$groups = user_group();
$modules = user_modules($_W['uid']);
$modules = array_filter($modules, function($module) {
	return empty($module['issystem']);
});
$templates = pdo_fetchall("SELECT * FROM " . tablename('site_templates'));
template('user/create');