<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('user');

$dos = array('display', 'operate');
$do = in_array($do, $dos) ? $do: 'display';

$_W['page']['title'] = '用户列表 - 用户管理';
$founders = explode(',', $_W['config']['setting']['founder']);

if ($do == 'display') {
	$condition = " WHERE u.founder_groupid = " . ACCOUNT_MANAGE_GROUP_VICE_FOUNDER;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$params = array();
	if (!empty($_GPC['username'])) {
		$condition .= " AND u.username LIKE :username";
		$params[':username'] = "%{$_GPC['username']}%";
	}
	$sql = 'SELECT u.*, p.avatar FROM ' . tablename('users') .' AS u LEFT JOIN ' . tablename('users_profile') . ' AS p ON u.uid = p.uid '. $condition . " LIMIT " . ($pindex - 1) * $psize .',' .$psize;
	$users = pdo_fetchall($sql, $params);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('users') .' AS u '. $condition, $params);
	$pager = pagination($total, $pindex, $psize);

	$groups = user_group();
	$users = user_list_format($users);
	template('founder/founder-display');
}

if ($do == 'del') {
	$uid = intval($_GPC['uid']);
	$uid_user = user_single($uid);
	if (in_array($uid, $founders)) {
		itoast('访问错误, 无法操作站长.', url('founder/founderdisplay'), 'error');
	}
	if (empty($uid_user)) {
		exit('未指定用户,无法删除.');
	}
	user_delete($uid);
	itoast('删除成功！', referer(), 'success');
}