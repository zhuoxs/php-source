<?php
	
/**
 * [weliam] Copyright (c) 2016/3/23 
 * 团model
 */
defined('IN_IA') or exit('Access Denied');
/**
 * 函数getgroupList，按检索条件检索出所有团
 * $params : 类型：array
 * 
 */
	function group_get_list($args = array()) {
		global $_W;
		
		$usepage = !empty($args['usepage'])? $args['usepage'] : false;
		$page = !empty($args['page'])? intval($args['page']): 1;
		$pagesize = !empty($args['pagesize'])? intval($args['pagesize']): 10;
		$orderby = !empty($args['orderby'])? $args['orderby'] : 'order by id desc';
		
		$condition = ' and `uniacid` = :uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		
		
		if ($usepage) {
			$sql = "SELECT * FROM " . tablename('tg_group') . " where 1 {$condition} {$orderby} LIMIT " . ($page - 1) * $pagesize . ',' . $pagesize;
		} else {
			$sql = "SELECT * FROM " . tablename('tg_group') . " where 1 {$condition} ";
		} 
		
		$list = pdo_fetchall($sql, $params);
		foreach($list as $key=>&$value){
			$value['gimg'] = tomedia($value['gimg']);
			$value['a'] = app_url('group/detail/display',array('id'=>$value['id']));
		}
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('tg_group')."where 1 $condition ",$params);
		
		$data = array();
		$data['list'] = $list;
		$data['total'] = $total;
		return $data;
	} 
/**
 * 函数getgroupByParams，按检索条件检索出指定团
 * $params : 类型：字符串
 * 
 */

function group_get_by_params($params = '') {
		global $_W;
		if(!empty($params)){
			$params = ' where '. $params;
		}
		$sql = "SELECT * FROM " . tablename('tg_group') . $params;
		$group = pdo_fetch($sql);
		return $group;
	}
/**
 * 函数getgroupByParams，按条件检索更新团
 * $data : 类型：array ; $params 类型：array
 * 
 */
function group_update_by_params($data,$params) {
		global $_W;
		$flag = pdo_update('tg_group',$data,$params);
		return $flag;
	}
/**
 * 函数insertgroup，插入新团
 * $data : 类型：array 
 * 返回值：插入ID
 */
function group_insert($data) {
		global $_W;
		$flag = pdo_insert('tg_group',$data);
		if($flag){
			$insertid = pdo_insertid();
		}else{
			$insertid = FALSE;
		}
		return $insertid;
	}
/**
 * 函数deletegroup，删除团
 * $id : 类型：int 
 * 返回值：
 */
function group_delete($id) {
		global $_W;
		$flag = pdo_delete('tg_group',$id);
		return $flag;
	}