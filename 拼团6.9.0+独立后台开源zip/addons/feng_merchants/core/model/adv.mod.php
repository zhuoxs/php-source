<?php
	
/**
 * [weliam] Copyright (c) 2016/3/23 
 * 广告model
 */
defined('IN_IA') or exit('Access Denied');
/**
 * 函数getGoodsList，按检索条件检索出所有广告
 * $params : 类型：array
 * 
 */
	function adv_get_list($args = array()) {
		global $_W;
		$usepage = !empty($args['usepage'])? $args['usepage'] : false;
		$page = !empty($args['page'])? intval($args['page']): 1;
		$pagesize = !empty($args['pagesize'])? intval($args['pagesize']): 10;
		$orderby = !empty($args['orderby'])? $args['orderby'] : 'order by displayorder,id desc';
		$condition = ' and `uniacid` = :uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		$enabled = !empty($args['enabled'])? 1 : 0;
		if (!empty($enabled)) {
			$condition .= " and enabled = 1";
		} 

		if ($usepage) {
			$sql = "SELECT * FROM " . tablename('tg_adv') . " where 1 {$condition} {$orderby} LIMIT " . ($page - 1) * $pagesize . ',' . $pagesize;
		} else {
			$sql = "SELECT * FROM " . tablename('tg_adv') . " where 1 {$condition} ";
		} 
		$list = pdo_fetchall($sql, $params);
		foreach($list as $key=>&$value){
			$value['thumb'] = tomedia($value['thumb']);
		}
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('tg_adv')."where 1 {$condition}", $params);
		$data = array();
		$data['list'] = $list;
		$data['total'] = $total;
		return $data;
	} 
/**
 * 函数getAdvByParams，按检索条件检索出指定商品
 * $params : 类型：字符串
 * 
 */

	function adv_get_by_params($params = '') {
		global $_W;
		if(!empty($params)){
			$params = ' where '. $params;
		}
		$sql = "SELECT * FROM " . tablename('tg_adv') . " {$params} ";
		$goods = pdo_fetch($sql);
		return $goods;
	}
/**
 * 函数updateAdvByParams，按条件检索更新广告
 * $data : 类型：array ; $params 类型：array
 * 
 */
	function adv_update_by_params($data,$params) {
		global $_W;
		$flag = pdo_update('tg_adv',$data,$params);
		return $flag;
	}
/**
 * 函数insertAdv，插入新广告
 * $data : 类型：array 
 * 返回值：插入ID
 */
	function adv_insert($data) {
		global $_W;
		$flag = pdo_insert('tg_adv',$data);
		if($flag){
			$insertid = pdo_insertid();
		}else{
			$insertid = FALSE;
		}
		return $insertid;
	}
/**
 * 函数deleteAdv，删除广告
 * $id : 类型：int 
 * 返回值：
 */
	function adv_delete($id) {
		global $_W;
		$flag = pdo_delete('tg_adv',$id);
		return $flag;
	}