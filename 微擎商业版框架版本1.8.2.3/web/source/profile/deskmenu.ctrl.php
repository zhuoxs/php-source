<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('profile_deskmenu');
$_W['page']['title'] = '功能选项 - 公众号选项 - 工作台菜单设置';
$dos = array('index', 'addmenu');
$do = in_array($do, $dos) ? $do : 'index';
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
		foreach ($permission as $key => &$row) {
			$has = 0;
			foreach ($row['items'] as $key1 => &$row1) {
				if (!in_array ($row1['id'], $user_permission)) {
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
if ($_W['isajax']) {
	$post = array();
	$post['title'] = trim($_GPC['title']);
	$post['displayorder'] = intval($_GPC['displayorder']);
	$post['icon'] = trim($_GPC['icon']) == '' ? 'glyphicon glyphicon-th' : trim($_GPC['icon']);
	$post['url'] = trim($_GPC['url']);
	$op = $_GPC['op'];
	if ($op == 'edit') {
		if (!empty($_GPC['permission'])) {
			$post['permission'] = trim($_GPC['permission']);
		}
		if (pdo_update('activity_clerk_menu', $post, array('uniacid' => $_W['uniacid'], 'id' => $_GPC['id']))) {
			message(error(1, '编辑成功'), '', 'ajax');
		} else {
			message(error(0, '编辑失败'), '', 'ajax');
		}
	}
	if ($op == 'editmain') {
		$post = array();
		$post['title'] = $_GPC['title'];
		if (pdo_update('activity_clerk_menu', $post, array('uniacid' => $_W['uniacid'], 'id' => $_GPC['id']))) {
			message(error(1, '编辑成功'), '', 'ajax');
		}
	}
	if ($op == 'add') {
		if (!empty($_GPC['permission'])) {
			$post['permission'] = trim($_GPC['permission']);
		}
		$post['system'] = 0;
		$post['pid'] = $_GPC['pid'];
		$post['uniacid'] = $_W['uniacid'];
		$post['type'] = 'url';
		if (pdo_insert('activity_clerk_menu', $post)) {
			message(error(1, '添加子菜单成功'), '', 'ajax');
		} else {
			message(error(0, '添加子菜单失败'), '', 'ajax');
		}
	}
	if ($op == 'addmain') {
		$post = array();
		$post['system'] = 0;
		$post['title'] = $_GPC['main_title'];
		$post['uniacid'] = $_W['uniacid'];
		if (pdo_insert('activity_clerk_menu', $post)) {
			message(error(1, '添加主菜单成功'), '', 'ajax');
		} else {
			message(error(0, '添加主菜单失败'), '', 'ajax');
		}
	}
	if ($op == 'delete') {
		$id = $_GPC['id'];
		$type = $_GPC['type'];
		if (empty($type)) {
			if (pdo_delete('activity_clerk_menu', array('id' => $id, 'uniacid' => $_W['uniacid']))) {
				message(error('1', '删除成功'), '' , 'ajax');
			}
			else {
				message(error('0', '删除失败'), '' , 'ajax');
			}
		} else {
			$result = pdo_delete('activity_clerk_menu', array('id' => $id, 'uniacid' => $_W['uniacid']));
			$resultall = pdo_delete('activity_clerk_menu', array('pid' => $id, 'uniacid' => $_W['uniacid']));
			if ($result && $resultall) {
				message(error('1', '删除成功'), '' , 'ajax');
			} else {
				message(error('0', '删除失败'), '' , 'ajax');
			}
		}
	}
}
template('profile/deskmenu');


