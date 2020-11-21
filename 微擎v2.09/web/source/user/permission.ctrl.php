<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$_W['page']['title'] = '查看用户权限 - 用户管理 - 用户管理';
load()->model('setting');

$uid = intval($_GPC['uid']);
$user = user_single($uid);
if(empty($user)) {
	message('访问错误, 未找到指定操作用户.');
}

$founders = explode(',', $_W['config']['setting']['founder']);
$isfounder = in_array($user['uid'], $founders);
if($isfounder) {
	message('访问错误, 无法编辑站长.');
}

$do = $_GPC['do'];
$dos = array('deny', 'delete', 'auth', 'revo', 'revos', 'select', 'role', 'menu', 'edit', 'module');
$do = in_array($do, $dos) ? $do: 'edit';

if($do == 'edit') {
		if (!empty($user['groupid'])) {
		$group = pdo_fetch("SELECT * FROM ".tablename('users_group')." WHERE id = '{$user['groupid']}'");
		if (!empty($group)) {
			$package = iunserializer($group['package']);
			$group['package'] = uni_groups($package);
		}
	}
	$weids = pdo_fetchall("SELECT uniacid, role FROM ".tablename('uni_account_users')." WHERE uid = '$uid'", array(), 'uniacid');
	if (!empty($weids)) {
		$wechats = pdo_fetchall("SELECT * FROM ".tablename('uni_account')." WHERE uniacid IN (".implode(',', array_keys($weids)).")");
	}
	template('user/permission');
}

if($do == 'deny') {
	if($_W['ispost'] && $_W['isajax']) {
		$founders = explode(',', $_W['config']['setting']['founder']);
		if(in_array($uid, $founders)) {
			exit('管理员用户不能禁用.');
		}
		$somebody = array();
		$somebody['uid'] = $uid;
		
		if (intval($user['status']) == 2) {
			$somebody['status'] = 1;
		} else {
			$somebody['status'] = 2;
		}
		if(user_update($somebody)) {
			exit('success');
		}
	}
}

if ($do == 'select') {
	$uid = intval($_GPC['uid']);
	$condition = '';
	$params = array();
	if(!empty($_GPC['keyword'])) {
		$condition = ' AND `name` LIKE :name';
		$params[':name'] = "%{$_GPC['keyword']}%";
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$total = 0;
	
	$list = pdo_fetchall("SELECT * FROM ".tablename('uni_account')." WHERE 1 $condition LIMIT ".(($pindex - 1) * $psize).",{$psize}");
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('uni_account')." WHERE 1 $condition");
	$pager = pagination($total, $pindex, $psize, '', array('ajaxcallback'=>'null'));
	
	$permission = pdo_fetchall("SELECT uniacid FROM ".tablename('uni_account_users')." WHERE uid = '$uid'", array(), 'uniacid');
	template('user/select');
}

if($do == 'module') {
	if($_W['isajax']) {
		load()->model('module');
		$m = trim($_GPC['m']);
		$uniacid = intval($_GPC['uniacid']);
		$uid = intval($_GPC['uid']);
		$module = pdo_fetch('SELECT * FROM ' . tablename('modules') . ' WHERE name = :m', array(':m' => $m));
				$purview = pdo_fetch('SELECT * FROM ' . tablename('users_permission') . ' WHERE uniacid = :aid AND uid = :uid AND type = :type', array(':aid' => $uniacid, ':uid' => $uid, ':type' => $m));
		if(!empty($purview['permission'])) {
			$purview['permission'] = explode('|', $purview['permission']);
		} else {
			$purview['permission'] = array();
		}

		$mineurl = array();
		$all = 0;
		if(!empty($mods)) {
			foreach($mods as $mod) {
				if($mod['url'] == 'all') {
					$all = 1;
					break;
				} else {
					$mineurl[] = $mod['url'];
				}
			}
		}
		$data = array();
		if($module['settings']) {
			$data[] = array('title' => '参数设置', 'permission' => $m.'_settings');
		}
		if($module['isrulefields']) {
			$data[] = array('title' => '回复规则列表', 'permission' => $m.'_rule');
		}
		$entries = module_entries($m);
		if(!empty($entries['home'])) {
			$data[] = array('title' => '微站首页导航', 'permission' => $m.'_home');
		}
		if(!empty($entries['profile'])) {
			$data[] = array('title' => '个人中心导航', 'permission' => $m.'_profile');
		}
		if(!empty($entries['shortcut'])) {
			$data[] = array('title' => '快捷菜单', 'permission' => $m.'_shortcut');
		}
		if(!empty($entries['cover'])) {
			foreach($entries['cover'] as $cover) {
				$data[] = array('title' => $cover['title'], 'permission' => $m.'_cover_'.$cover['do']);
			}
		}
		if(!empty($entries['menu'])) {
			foreach($entries['menu'] as $menu) {
				$data[] = array('title' => $menu['title'], 'permission' => $m.'_menu_'.$menu['do']);
			}
		}
		unset($entries);
		if(!empty($module['permissions'])) {
			$module['permissions'] = (array)iunserializer($module['permissions']);
			$data = array_merge($data, $module['permissions']);
		}
		foreach($data as &$da) {
			$da['checked'] = 0;
			if(in_array($da['permission'], $purview['permission']) || in_array('all', $purview['permission'])) {
				$da['checked'] = 1;
			}
		}
		$out['errno'] = 0;
		$out['errmsg'] = '';
		if(empty($data)) {
			$out['errno'] = 1;
		} else {
			$out['errmsg'] = $data;
		}
		exit(json_encode($out));
	}
}

if ($do == 'menu') {
	$uniacid = intval($_GPC['uniacid']);
	$uid = intval($_GPC['uid']);
	load()->model('user');
	load()->model('module');
	load()->model('frame');

	$user = user_single(array('uid' => $uid));
	if (empty($user)) {
		message('您操作的用户不存在或是已经被删除！');
	}
	if (!pdo_fetchcolumn("SELECT id FROM ".tablename('uni_account_users')." WHERE uid = :uid AND uniacid = :uniacid", array(':uid' => $uid, ':uniacid' => $uniacid))) {
		message('此用户没有操作该统一公众号的权限，请选指派“管理者”权限！');
	}
		$system_permission = pdo_fetch('SELECT * FROM ' . tablename('users_permission') . ' WHERE uniacid = :aid AND uid = :uid AND type = :type', array(':aid' => $uniacid, ':uid' => $uid, ':type' => 'system'));
	if(!empty($system_permission['permission'])) {
		$system_permission['permission'] = explode('|', $system_permission['permission']);
	} else {
		$system_permission['permission'] = array();
	}

		$mods = pdo_fetchall('SELECT * FROM ' . tablename('users_permission') . ' WHERE uniacid = :aid AND uid = :uid AND type != :type', array(':aid' => $uniacid, ':uid' => $uid, ':type' => 'system'), 'type');
	$mod_keys = array_keys($mods);

	if (checksubmit('submit')) {
				$system_temp = array();
		if(!empty($_GPC['system'])) {
			foreach($_GPC['system'] as $li) {
				$li = trim($li);
				if(!empty($li)) {
					$system_temp[] = $li;
				}
			}
		}
		if(!empty($system_temp)) {
			if(empty($system_permission['id'])) {
				$insert = array(
					'uniacid' => $uniacid,
					'uid' => $uid,
					'type' => 'system',
				);
				$insert['permission'] = implode('|', $_GPC['system']);
				pdo_insert('users_permission', $insert);
			} else {
				$update = array(
					'permission' => implode('|', $_GPC['system'])
				);
				pdo_update('users_permission', $update, array('uniacid' => $uniacid, 'uid' => $uid));
			}
		} else {
			pdo_delete('users_permission', array('uniacid' => $uniacid, 'uid' => $uid));
		}
		pdo_query('DELETE FROM ' . tablename('users_permission') . ' WHERE uniacid = :uniacid AND uid = :uid AND type != :type', array(':uniacid' => $uniacid, ':uid' => $uid, ':type' => 'system'));
				if(!empty($_GPC['module'])) {
						$arr = array();
			foreach($_GPC['module'] as $li) {
				$insert = array(
					'uniacid' => $uniacid,
					'uid' => $uid,
					'type' => $li,
				);
				if(empty($_GPC['module_'. $li]) || $_GPC[$li . '_select'] == 1) {
					$insert['permission'] = 'all';
					pdo_insert('users_permission', $insert);
					continue;
				} else {
					$data = array();
					foreach($_GPC['module_'. $li] as $v) {
						$data[] = $v;
					}
					if(!empty($data)) {
						$insert['permission'] = implode('|', $data);
						pdo_insert('users_permission', $insert);
					}
				}
			}
		}
		message('操作菜单权限成功！', url('user/permission/menu', array('uid' => $uid, 'uniacid' => $uniacid)), 'success');
	}

	$menus = frame_lists();
	foreach($menus as &$li) {
		$li['childs'] = array();
		if(!empty($li['child'])) {
			foreach($li['child'] as $da) {
				if(!empty($da['grandchild'])) {
					foreach($da['grandchild'] as &$ca) {
						$li['childs'][] = $ca;
					}
				}
			}
			unset($li['child']);
		}
	}
	$_W['uniacid'] = $uniacid;
	$module = uni_modules();
	template('user/menu');
}

if ($do == 'auth') {
	$uniacid = intval($_GPC['uniacid']);
	$uid = intval($uid);
	
	$isexists = pdo_fetch("SELECT * FROM ".tablename('uni_account_users')." WHERE uid = :uid AND uniacid = :uniacid", array(':uid' => $uid, ':uniacid' => $uniacid));
	if (empty($isexists)) {
		pdo_insert('uni_account_users', array('uniacid' => $uniacid, 'uid' => $uid));
	}
	exit('success');
}

if ($do == 'revo') {
	$uniacid = intval($_GPC['uniacid']);
	$uid = intval($uid);
	
	$isexists = pdo_fetch("SELECT * FROM ".tablename('uni_account_users')." WHERE uid = :uid AND uniacid = :uniacid", array(':uid' => $uid, ':uniacid' => $uniacid));
	if (!empty($isexists)) {
		pdo_delete('uni_account_users', array('uniacid' => $uniacid, 'uid' => $uid));
	}
	exit('success');
}

if ($do == 'role') {
	$uid = intval($_GPC['uid']);
	$uniacid = intval($_GPC['uniacid']);
	$role = !empty($_GPC['role']) && in_array($_GPC['role'], array('operator', 'manager')) ? $_GPC['role'] : 'operator';
	pdo_update('uni_account_users', array('role' => $role), array('uid' => $uid, 'uniacid' => $uniacid));
}
