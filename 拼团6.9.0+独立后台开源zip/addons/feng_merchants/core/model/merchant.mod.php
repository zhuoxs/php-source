<?php
	
/**
 * [weliam] Copyright (c) 2016/3/23 
 * 商家model
 */
defined('IN_IA') or exit('Access Denied');
/**
 * 函数getGoodsList，按检索条件检索出所有商家
 * $params : 类型：array
 * 
 */
	function merchant_get_list($args = array()) {
		global $_W;
		
		$usepage = !empty($args['usepage'])? $args['usepage'] : false;
		$page = !empty($args['page'])? intval($args['page']): 1;
		$pagesize = !empty($args['pagesize'])? intval($args['pagesize']): 10;
		$orderby = !empty($args['orderby'])? $args['orderby'] : 'order by id desc';
		
		$condition = ' and `uniacid` = :uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('tg_merchant')."where 1 $condition ",$params);
		$data = array();
		$data['list'] = $list;
		$data['total'] = $total;
		return $data;
	} 
/**
 * 函数getGoodsByParams，按检索条件检索出指定商家
 * $params : 类型：字符串
 * 
 */

function merchant_get_by_params($params = '') {
		global $_W;
		if(!empty($params)){
			$params = ' where '. $params;
		}
		$sql = "SELECT * FROM " . tablename('tg_merchant') . " {$params} ";
		$goods = pdo_fetch($sql);
		return $goods;
	}
/**
 * 函数getGoodsByParams，按条件检索更新商家
 * $data : 类型：array ; $params 类型：array
 * 
 */
function merchant_update_by_params($data,$params) {
		global $_W;
		$flag = pdo_update('tg_merchant',$data,$params);
		return $flag;
	}
/**
 * 函数insertGoods，插入新商家
 * $data : 类型：array 
 * 返回值：插入ID
 */
function merchant_insert($data) {
		global $_W;
		$flag = pdo_insert('tg_merchant',$data);
		if($flag){
			$insertid = pdo_insertid();
		}else{
			$insertid = FALSE;
		}
		return $insertid;
	}
/**
 * 函数deleteGoods，删除商家
 * $id : 类型：int 
 * 返回值：
 */
function merchant_delete($id) {
		global $_W;
		$flag = pdo_delete('tg_merchant',$id);
		return $flag;
	}

	function merchant_get_by_id($id = '') {
		global $_W;
		if(empty($id)){
			return;
		}
		$sql = "SELECT * FROM " . tablename('tg_merchant') . " where uniacid = {$_W['uniacid']} and id = {$id}";
		$merchant = pdo_fetch($sql);
		return $merchant;
	}
	function  merchant_update_amount($money,$merchantid){
		global $_W;
		if($merchantid){
			$merchant = pdo_fetch("select amount from".tablename('tg_merchant_account')."where uniacid={$_W['uniacid']} and merchantid='{$merchantid}' ");
		}
		if(empty($merchant)){
			pdo_insert("tg_merchant_account",array('no_money'=>0,'merchantid'=>$merchantid,'uniacid'=>$_W['uniacid'],'uid'=>$_W['uid'],'amount'=>$money,'updatetime'=>TIMESTAMP));
		}else{
			pdo_update("tg_merchant_account",array('amount'=>$merchant['amount']+$money),array('merchantid'=>$merchantid));
		}
		return $merchant;
	}
	function  merchant_update_no_money($money,$merchantid){
		global $_W;
		$f=FALSE;
		if($merchantid){
			$merchant = pdo_fetch("select no_money from".tablename('tg_merchant_account')."where uniacid={$_W['uniacid']} and merchantid={$merchantid}");
			if(empty($merchant)){
				pdo_insert("tg_merchant_account",array('no_money'=>0,'merchantid'=>$merchantid,'uniacid'=>$_W['uniacid'],'uid'=>$_W['uid'],'amount'=>0,'updatetime'=>TIMESTAMP));
			}else{
					$m = $merchant['no_money']+$money;
					if($m<0){
						$f=FALSE;
					}else{
						$f=TRUE;
						pdo_update("tg_merchant_account",array('no_money'=>$merchant['no_money']+$money,'updatetime'=>TIMESTAMP),array('merchantid'=>$merchantid	));
					}
			}
		}
		return $f;
	}
	function  merchant_get_no_money($merchantid){
		global $_W;
		$merchant = pdo_fetch("select no_money from".tablename('tg_merchant_account')."where uniacid={$_W['uniacid']} and merchantid='{$merchantid}' ");
		return $merchant['no_money'];
	}