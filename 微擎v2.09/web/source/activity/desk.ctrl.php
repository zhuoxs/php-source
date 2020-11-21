<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');
$dos = array();
$do = in_array($do, $dos) ? $do : 'index';
$_W['page']['title'] = '店员工作台';
if($do == 'index') {
	$clerk_p = pdo_fetchall("SELECT * FROM ". tablename('activity_clerk_menu'). " WHERE (uniacid = :uniacid OR system = '1') AND pid = 0", array(':uniacid' =>  $_W['uniacid']));
	$clerk_c = pdo_fetchall("SELECT * FROM ". tablename('activity_clerk_menu'). " WHERE (uniacid = :uniacid OR system = '1') AND pid <> 0 ORDER BY displayorder ASC, system DESC", array(':uniacid' =>  $_W['uniacid']));
	$permission = array();
	foreach ($clerk_p as $p) {
		$permission[$p['id']]['id'] = $p['id'];
		$permission[$p['id']]['pid'] = $p['id'];
		$permission[$p['id']]['title'] = $p['title'];
		$permission[$p['id']]['system'] = $p['system'];
	}
	foreach ($clerk_c as $c) {
		if (empty($c['permission'])) {
			pdo_update('activity_clerk_menu', array('permission' => 'clerk_'.$c['id']), array('uniacid' => $_W['uniacid'], 'id' => $c['id']));
		}
		$permission[$c['pid']]['items'][] = $c;
	}
	$user_permission = uni_user_permission_exist ();
	if (is_error ($user_permission)) {
		$user_permission = uni_user_permission ('system');
		$permission_list = array();
		foreach ($user_permission as $value) {
			if (!is_numeric($value)) {
				continue;
			}
			$clerk_perm = pdo_get('activity_clerk_menu', array('uniacid' => $_W['uniacid'], 'id' => $value));
			$permission_list[] = $clerk_perm['permission'];
		}
		if (!empty($permission_list)) {
			$post = implode('|', $permission_list);
			pdo_update('users_permission', array('permission' => $post), array('uniacid' => $_W['uniacid'], 'uid' => $_W['uid'], 'type' => 'system'));
		}
		foreach ($permission as $key => &$row) {
			$has = 0;
			foreach ($row['items'] as $key1 => &$row1) {
				if (!in_array ($row1['permission'], $user_permission)) {
					unset($row['items'][$key1]);
				} else {
					if (!$has) {
						$has = 1;
					}
				}
			}
			if (!$has) {
				unset($permission[$key]);
			}
		}
	}
}
template('activity/desk');
