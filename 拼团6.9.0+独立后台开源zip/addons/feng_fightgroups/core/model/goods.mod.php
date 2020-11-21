<?php
	
/**
 * [weliam] Copyright (c) 2016/3/23 
 * 商品model
 */
defined('IN_IA') or exit('Access Denied');
/**
 * 函数getGoodsList，按检索条件检索出所有商品
 * $params : 类型：array
 * 
 */
	function goods_get_list($args) {
		global $_W;
		$condition = ' and `uniacid` = :uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		if(is_array($args)){
			$usepage = !empty($args['usepage'])? $args['usepage'] : false;
			$page = !empty($args['page'])? intval($args['page']): 1;
			$pagesize = !empty($args['pagesize'])? intval($args['pagesize']): 10;
			$orderby = !empty($args['orderby'])? $args['orderby'] : 'order by id desc';
			
			$ishows = !empty($args['ishows'])? trim($args['ishows']): '';
			$condition = ' and `uniacid` = :uniacid';
			$params = array(':uniacid' => $_W['uniacid']);
			if (!empty($ishows)) {
				$condition .= " and isshow in ( " . $ishows . ")";
			} 
			$isnew = !empty($args['isnew'])? 1 : 0;
			if (!empty($isnew)) {
				$condition .= " and isnew=1";
			} 
			$ishot = !empty($args['ishot'])? 1 : 0;
			if (!empty($ishot)) {
				$condition .= " and ishot=1";
			} 
			$group_level_status = $args['group_level_status'];
			if ($group_level_status!='') {
				$condition .= " and group_level_status in ({$group_level_status}) ";
			} 
			$isrecommand = !empty($args['isrecommand'])? 1 : 0;
			if (!empty($isrecommand)) {
				$condition .= " and isrecommand=1";
			} 
			$isdiscount = !empty($args['isdiscount'])? 1 : 0;
			if (!empty($isdiscount)) {
				$condition .= " and isdiscount=1";
			} 
			$gname = !empty($args['gname'])? $args['gname'] : '';
			if (!empty($gname)) {
				$condition .= "  AND gname like '%{$gname}%' ";
			} 
			$cid = $args['cid'];
			if (!empty($cid)) {
				$condition .= "  AND category_parentid = '{$cid}'";
			}
			$merchantid = $args['merchantid'];
			if (!empty($merchantid)) {
				$condition .= "  AND merchantid = '{$merchantid}'";
			}
		}else{
			$condition .= $args;
			$orderby = '';
		}
		if ($usepage) {
			$sql = "SELECT * FROM " . tablename('tg_goods') . " where 1 {$condition} {$orderby} LIMIT " . ($page - 1) * $pagesize . ',' . $pagesize;
		} else {
			$sql = "SELECT * FROM " . tablename('tg_goods') . " where 1 {$condition} {$orderby}";
		} 
		$list = pdo_fetchall($sql, $params);
		foreach($list as $key=>&$value){
			$value['gimg'] = tomedia($value['gimg']);
			$value['a'] = app_url('goods/detail/display',array('id'=>$value['id']));
		}
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('tg_goods')."where 1 $condition ",$params);
		
		$data = array();
		$data['list'] = $list;
		$data['total'] = $total;
		return $data;
	} 
/**
 * 函数getGoodsByParams，按检索条件检索出指定商品
 * $params : 类型：字符串
 * 
 */

	function goods_get_by_params($params = '') {
		global $_W;
		if(!empty($params)){
			$params = ' where '. $params;
		}
		$sql = "SELECT * FROM " . tablename('tg_goods') . $params;
		$goods = pdo_fetch($sql);
		$goods['gimg'] = tomedia($goods['gimg']);
		$goods['a'] = app_url('goods/detail/display',array('id'=>$goods['id']));
		return $goods;
	}
/**
 * 函数getGoodsByParams，按条件检索更新商品
 * $data : 类型：array ; $params 类型：array
 * 
 */
	function goods_update_by_params($data,$params) {
		global $_W;
		$flag = pdo_update('tg_goods',$data,$params);
		return $flag;
	}

/**
 * 函数deleteGoods，删除商品
 * $id : 类型：int 
 * 返回值：
 */
	function goods_delete($id) {
		global $_W;
		$flag = pdo_delete('tg_goods',array('id'=>$id));
		return $flag;
	}