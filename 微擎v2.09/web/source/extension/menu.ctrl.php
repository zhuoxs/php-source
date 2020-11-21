<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$dos = array('display', 'del', 'ajax', 'module', 'view', 'switch', 'del_bind');
$do = in_array($do, $dos) ? $do : 'display';

load()->model('frame');
if($do == 'display') {
	$menus = frame_lists();
	if(checksubmit('submit')) {
		foreach($_GPC['id'] as $k => $menuid) {
			$update = array();
			$menuid = intval($menuid);
			
			$title = trim($_GPC['title'][$k]);
			$is_system = intval($_GPC['is_system'][$k]);
			if($menuid && $title) {
				$update = array(
					'title' => $title,
					'displayorder' => intval($_GPC['displayorder'][$k]),
				);
				if(!$is_system) {
					$update['url'] = trim($_GPC['url'][$k]);
					$update['append_title'] = trim($_GPC['append_title'][$k]);
					$update['append_url'] = trim($_GPC['append_url'][$k]);
				}
				pdo_update('core_menu', $update, array('id' => $menuid));
			}
		}

		if(!empty($_GPC['add_parent_name'])) {
			$exist_names = array();
			foreach($_GPC['add_parent_name'] as $k1 => $v1) {
				$insert = array();
				$add_parent_title = trim($_GPC['add_parent_title'][$k1]);
				$add_parent_name = trim($_GPC['add_parent_name'][$k1]);
				$name_exist = pdo_get('core_menu', array('name' => $add_parent_name, 'pid' => 0));
				if (!empty($name_exist)) {
					$exist_names[] = $add_parent_name;
					continue;
				}
				if($add_parent_title && $add_parent_name) {
					$insert = array(
						'pid' => 0,
						'title' => $add_parent_title,
						'name' => $add_parent_name,
						'append_title' => trim($_GPC['add_parent_append_title'][$k1]),
						'displayorder' => intval($_GPC['add_parent_displayorder'][$k1]),
						'is_system' => 0
					);
					pdo_insert('core_menu', $insert);
				}
			}
		}

		if(!empty($_GPC['add_pid'])) {
			foreach($_GPC['add_pid'] as $k1 => $v1) {
				$insert = array();
				$v1 = intval($v1);
				$add_title = trim($_GPC['add_title'][$k1]);
				$add_name = trim($_GPC['add_name'][$k1]);
				if($v1 && $add_title && $add_name) {
					$insert = array(
						'pid' => $v1,
						'title' => $add_title,
						'name' => $add_name,
						'displayorder' => intval($_GPC['add_displayorder'][$k1]),
						'is_system' => 0
					);
					pdo_insert('core_menu', $insert);
				}
			}
		}
		if(!empty($_GPC['add_child_pid'])) {
			foreach($_GPC['add_child_pid'] as $k2 => $v2) {
				$insert = array();
				$v2 = intval($v2);
				$add_child_title = trim($_GPC['add_child_title'][$k2]);
				$add_child_name = trim($_GPC['add_child_name'][$k2]);
				$add_child_url = trim($_GPC['add_child_url'][$k2]);
				if($v2 && $add_child_title && $add_child_name && $add_child_url) {
					$insert = array(
						'pid' => $v2,
						'title' => $add_child_title,
						'name' => $add_child_name,
						'url' => $add_child_url,
						'type' => 'url',
						'displayorder' => intval($_GPC['add_child_displayorder'][$k2]),
						'is_system' => 0,
						'permission_name' => trim($_GPC['add_child_permission'][$k2]),
					);
					$add_child_append_title = trim($_GPC['add_child_append_title'][$k2]);
					$add_child_append_url = trim($_GPC['add_child_append_url'][$k2]);
					if($add_child_append_title && $add_child_append_url) {
						$insert['append_title'] = $add_child_append_title;
						$insert['append_url'] = $add_child_append_url;
					}
					pdo_insert('core_menu', $insert);
				}
			}
		}
		if(!empty($_GPC['add_permission_pid'])) {
			foreach($_GPC['add_permission_pid'] as $k1 => $v1) {
				$insert = array();
				$v1 = intval($v1);
				$add_permission_title = trim($_GPC['add_permission_title'][$k1]);
				$add_permission_name = trim($_GPC['add_permission_name'][$k1]);
				$add_permission_flag = trim($_GPC['add_permission_flag'][$k1]);
				$isexist = pdo_fetchcolumn('SELECT id FROM ' . tablename('core_menu') . ' WHERE permission_name = :permission_name', array(':permission_name' => $add_permission_name));
				if(!empty($isexist)) {
					continue;
				}
				if($v1 && $add_permission_title && $add_permission_name && $add_permission_flag) {
					$insert = array(
						'pid' => $v1,
						'title' => $add_permission_title,
						'name' => $add_permission_flag,
						'permission_name' => $add_permission_name,
						'type' => 'permission',
						'displayorder' => intval($_GPC['add_permission_displayorder'][$k1]),
						'is_system' => 0,
						'is_display' => 0,
					);
					pdo_insert('core_menu', $insert);
				}
			}
		}
		cache_build_frame_menu();
		if (!empty($exist_names)) {
			$exist_names = implode(',', $exist_names);
			message($exist_names."标识已存在", referer(), 'info');
		}
		message('更新菜单成功', referer(), 'success');
	}
	template('extension/menu');
}

if($do == 'del') {
	$id = intval($_GPC['id']);
	$menu= pdo_fetch('SELECT * FROM ' . tablename('core_menu') . ' WHERE id = :id', array(':id' => $id));
	if($menu['is_system']) {
		message('系统分类不能删除', referer(), 'error');
	}
	$ids = pdo_fetchall('SELECT id FROM ' . tablename('core_menu') . ' WHERE pid = :id', array(':id' => $id), 'id');
	if(!empty($ids)) {
		$ids_str = implode(',', array_keys($ids));
		pdo_query('DELETE FROM ' . tablename('core_menu') . " WHERE pid IN ({$ids_str})");
		pdo_query('DELETE FROM ' . tablename('core_menu') . " WHERE id IN ({$ids_str})");
	}
	pdo_query('DELETE FROM ' . tablename('core_menu') . " WHERE id = {$id}");
	cache_build_frame_menu();
	message('删除分类成功', referer(), 'success');
}

if($do == 'ajax') {
	$id = intval($_GPC['id']);
	$value = intval($_GPC['value']) ? 0 : 1;
	pdo_update('core_menu', array('is_display' => $value), array('id' => $id));
	cache_build_frame_menu();
	exit();
}

if($do == 'module') {
	load()->model('module');
	if(checksubmit('submit')) {
		if(!empty($_GPC['eid'])) {
			foreach($_GPC['eid'] as $k => $v) {
				$update = array();
				$entry = trim($_GPC['entry'][$k]);
				if($entry == 'mine') {
					$update['url'] = trim($_GPC['url'][$k]);
				}
				$update['icon'] = empty($_GPC['icon'][$k]) ? 'fa fa-puzzle-piece' : $_GPC['icon'][$k];
				$update['displayorder'] = intval($_GPC['displayorder'][$k]);
				pdo_update('modules_bindings', $update, array('eid' => intval($v)));
			}
		}
		if(!empty($_GPC['add_title'])) {
			foreach($_GPC['add_title'] as $k => $v) {
				$title = trim($v);
				$url = trim($_GPC['add_url'][$k]);
				$m =  trim($_GPC['add_module'][$k]);
				if(strexists($url, 'http://') || strexists($url, 'https://')) {
					if(strexists($url, $_W['siteroot'])) {
						$url = './index.php?' . str_replace($_W['siteroot'].'web/index.php?', '', $url);
					}
				}
				$icon = empty($_GPC['add_icon'][$k]) ? 'fa fa-puzzle-piece' : trim($_GPC['add_icon'][$k]);
				if($title && $url && $m) {
					$data = array();
					$data['do'] = '';
					$data['module'] = $m;
					$data['entry'] = 'mine';
					$data['title'] = $title;
					$data['url'] = $url;
					$data['icon'] = $icon;
					$data['displayorder'] = intval($_GPC['add_displayorder'][$k]);
					pdo_insert('modules_bindings', $data);
				} else {
					continue;
				}
			}
		}
		message('更新模块菜单成功', 'refresh', 'success');
	}
	$modules = pdo_fetchall('SELECT mid, name, title FROM ' . tablename('modules') . ' WHERE issystem = 0');
	foreach($modules as &$li) {
		$li['entry'] = module_entries($li['name'], array('mine', 'menu'));
	}
	template('extension/module-permission');
}

if($do == 'del_bind') {
	$eid = intval($_GPC['eid']);
	$permission = intval($_GPC['permission']);
	pdo_delete('modules_bindings', array('eid' => $eid, 'entry' => 'mine'));
	exit();
}








