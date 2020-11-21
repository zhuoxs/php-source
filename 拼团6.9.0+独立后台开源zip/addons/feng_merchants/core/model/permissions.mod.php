<?php
/**
 * [weliam] Copyright (c) 2014 WE7.CC
 * 商家权限mod
 */
defined('IN_IA') or exit('Access Denied');
//function permissions_get_by_params($do,$ac,$op,$v1,$v2,$v3){
//	global $_W;
//	$role_do = pdo_fetch_one('user_node', array($do => $v1));
//	$role_ac = pdo_fetch_one('user_node', array($do => $v1,$ac=>$v2));
//	$role_op = pdo_fetch_one('user_node', array($do => $v1,$ac=>$v2,$op=>$v3));
//	if (empty($role_do)) {
//		$user_do = array('do'=>$v1,'pid'=>0,'level'=>1,'status'=>2);
//		pdo_insert('user_node',$user_do);
//		$do_id = pdo_insertid();
//	}else{
//		$do_id = $role_do['id'];
//	}
//	if (empty($role_ac)) {
//		$user_ac = array('do'=>$v1,'ac'=>$v2,'do_id'=>$do_id,'level'=>2,'status'=>2);
//		pdo_insert('user_node',$user_ac);
//		$ac_id = pdo_insertid();
//	}else{
//		$ac_id = $role_ac['id'];
//	}
//	if (empty($role_op)) {
//		$user_op = array('do'=>$v1,'ac'=>$v2,'op'=>$v3,'do_id'=>$do_id,'ac_id'=>$ac_id,'level'=>3,'status'=>2);
//		pdo_insert('user_node',$user_op);
//	}
//}
//function permissions_insert($data){
//	global $_W;
//	$f=pdo_insert('user_node',$data);
//	if($f){
//		return pdo_insertid();
//	}else{
//		return FALSE;
//	}
//}
//function role($role_id){
//	global $_W;
//	$role = pdo_fetch_one('user_role', array('id' => $role_id));
//	if (empty($role)) {
//		return array();
//	}
//
//	$role['default_url'] = $_W['siteroot'].'web/index.php?'. $role['default_url'];
//	foreach (array('node_ids', 'nodes', 'menus') as $key) {
//		if (!empty($role[$key])) {
//			$role[$key] = iunserializer($role[$key]);
//		} else {
//			$role[$key] = $key == 'node_id'? array(0) : array();
//		}
//	}
//
//	return $role;
//}
//
//
//function node_merge($node, $pid = 0){
//	$arr = array();
//	foreach ($node as $v){
//		if($v['pid'] == $pid){
//			$v['children'] = node_merge($node, $v['id']);
//			$arr[] = $v;
//		}
//	}
//	return $arr;
//}
//
//function user_node($id){
//	return pdo_fetch_one('user_node', array('id' => $id));
//}
//
//function user_menu($id){
//	return pdo_fetch_one('user_menu', array('id' => $id));
//}
//
//function menu_merge($menu, $pid = 0){
//	$arr = array();
//	foreach ($menu as $v){
//		if($v['pid'] == $pid){
//			$v['children'] = menu_merge($menu, $v['id']);
//			$arr[] = $v;
//		}
//	}
//	return $arr;
//}
//
//function menus(){
//	
//	global $_W, $_GPC;
//	
//	if (empty($_W['role']) || empty($_W['role']['menus'])) {
//		return;
//	}
//	
//	foreach ($_W['role']['menus'] as &$top) {
//		
//		if ($top['children']) {
//			foreach ($top['children'] as &$group) {
//				
//				if (!empty($group['children'])) {
//					foreach ($group['children'] as &$menu) {
//						
//						$query = $menu['query'];
//						if (!empty($query)) {
//							$active = 1;
//							foreach ($query as $key => $value) {
//								if ($_GPC[$key] == $value) {
//									$active *= 1;
//								} else {
//									$active *= 0;
//								}
//							}
//							if ($active) {
//								$top['active'] = 1;
//								$group['active'] = 1;
//								$menu['active'] = 1;
//								return;
//							}
//						}
//						
//						$active_queries = $menu['active_queries'];
//						if (!empty($active_queries)) {
//							foreach ($active_queries as $active_query) {
//								$active = 1;
//								foreach ($active_query as $key => $value) {
//									if ($_GPC[$key] == $value) {
//										$active *= 1;
//									} else {
//										$active *= 0;
//									}
//								}
//								if ($active) {
//									$top['active'] = 1;
//									$group['active'] = 1;
//									$menu['active'] = 1;
//									return;
//								}
//							}
//						}
//					}
//				}
//			}
//		}
//	}
//	
//	unset($top, $group, $menu);
//}
//
//function allow($url = '', $permission_code = ''){
//	global $_W, $_GPC;
//	if ($_GPC['c'] == 'user' && in_array($_GPC['a'], array('login', 'logout'))) {
//		return true;
//	}
//	if (empty($_W['role']) || empty($_W['role']['nodes'])) {
//		return false;
//	}
//	if ($_W['role']['id'] == 1 || $_W['isfounder']){
//		return true;
//	}
//	if (!empty($url)) {
//		
//		$url_query = parse_url($url);
//		parse_str($url_query['query'], $gpc);
//		
//		if (!empty($_W['role']['nodes'])) {
//			foreach ($_W['role']['nodes'] as $node) {
//				
//				$query = $node['query'];
//				$allow = 1;
//				
//				if (!empty($query)) {
//					foreach ($gpc as $key => $value) {
//						if ($query[$key] == $value) {
//							$allow *= 1;
//						} else {
//							$allow *= 0;
//						}
//					}
//				} else {
//					$allow = 0;
//				}
//				
//				if ($allow) {
//					if (empty($permission_code) || $permission_code == $node['code']) {
//						return true;
//					}
//				}
//			}
//		}
//		return false;
//	}
//	
//		if (empty($_W['nodes'])) {
//		foreach ($_W['role']['nodes'] as $node) {
//			
//			$query = $node['query'];
//			$allow = 0;
//			
//			if (!empty($query)) {
//				$allow = 1;
//				foreach ($query as $key => $value) {
//					if ($_GPC[$key] == $value) {
//						$allow *= 1;
//					} else {
//						$allow *= 0;
//					}
//				}
//			}
//			if ($allow) {
//				$_W['nodes'][] = $node;
//			}
//		}
//	}
//	
//	if (empty($_W['nodes'])) {
//		return false;
//	}
//	
//	if (empty($permission_code)) {
//		return true;
//	}
//	
//	foreach ($_W['nodes'] as $node) {
//		if ($node['code'] == $permission_code) {
//			return true;
//		}
//	}
//	
//	return false;
//}
