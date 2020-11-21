<?php
	
/**
 * [weliam] Copyright (c) 2016/3/23 
 * 订单model
 */
defined('IN_IA') or exit('Access Denied');
/**
 * 函数getorderList，按检索条件检索出所有订单
 * $params : 类型：array
 * 
 */
	function order_get_list($args = array()) {
		global $_W;
		
		$usepage = !empty($args['usepage'])? $args['usepage'] : false;
		$page = !empty($args['page'])? intval($args['page']): 1;
		$pagesize = !empty($args['pagesize'])? intval($args['pagesize']): 10;
		$orderby = !empty($args['orderby'])? $args['orderby'] : 'order by id desc';
		
		$condition = ' and `uniacid` = :uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		
		$status = ($args['status']!='')? $args['status']: '';
		if ($status!='') {
			$condition .= " and status in ( " . $status . ")";
		} 
		
		$openid = !empty($args['openid'])? trim($args['openid']): '';
		if (!empty($openid)) {
			$condition .= " and openid ='".$openid."' ";
		}
		
		$is_tuan = !empty($args['is_tuan'])? trim($args['is_tuan']): '';
		if (!empty($is_tuan)) {
			$condition .= " and is_tuan in ( " . $is_tuan . ")";
		}
		
		$tuan_id = !empty($args['tuan_id'])? trim($args['tuan_id']): '';
		if (!empty($tuan_id)) {
			$condition .= " and tuan_id ='".$tuan_id."'";
		}
		
		if ($usepage) {
			$sql = "SELECT * FROM " . tablename('tg_order') . " where 1 and mobile<>'虚拟' {$condition} {$orderby} LIMIT " . ($page - 1) * $pagesize . ',' . $pagesize;
		} else {
			$sql = "SELECT * FROM " . tablename('tg_order') . " where 1 and mobile<>'虚拟' {$condition} ";
		} 
		
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('tg_order')."where 1 $condition ",$params);
		foreach($list as $key=>&$value){
			$value['date'] = date('Y-m-d H:i:s',$value['createtime']);
			$value['a'] = app_url('order/order/detail',array('id'=>$value['id']));
		}
		$data = array();
		$data['list'] = $list;
		$data['total'] = $total;
		return $data;
	} 
/**
 * 函数getorderByParams，按检索条件检索出指定订单
 * $params : 类型：字符串
 * 
 */

	function order_get_by_params($params = '') {
		global $_W;
		if(!empty($params)){
			$params = ' where '. $params;
		}
		$sql = "SELECT * FROM " . tablename('tg_order') . " {$params} ";
		$order = pdo_fetch($sql);
		return $order;
	}
/**
 * 函数getorderByParams，按条件检索更新订单
 * $data : 类型：array ; $params 类型：array
 * 
 */
	function order_update_by_params($data,$params) {
		global $_W;
		$flag = pdo_update('tg_order',$data,$params);
		return $flag;
	}
/**
 * 函数insertorder，插入新订单
 * $data : 类型：array 
 * 返回值：插入ID
 */
	function order_insert($data) {
		global $_W;
		$flag = pdo_insert('tg_order',$data);
		if($flag){
			$insertid = pdo_insertid();
		}else{
			$insertid = FALSE;
		}
		return $insertid;
	}
/**
 * 函数deleteorder，删除订单
 * $id : 类型：int 
 * 返回值：
 */
	function order_delete($id) {
		global $_W;
		$flag = pdo_delete('tg_order',$id);
		return $flag;
	}
	
	function order_get_by_id($id = '') {
		global $_W;
		if(empty($id)){
			return;
		}
		$sql = "SELECT * FROM " . tablename('tg_order') . " where uniacid = {$_W['uniacid']} and id = {$id}";
		$order = pdo_fetch($sql);
		return $order;
	}