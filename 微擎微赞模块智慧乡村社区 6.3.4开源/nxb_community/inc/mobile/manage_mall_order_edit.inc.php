<?php
global $_W, $_GPC;
include 'common.php';
load() -> func('tpl');
$base=$this->get_base(); 
$title=$base['title'];
//查询缓存是否存在，如果有，就直接登录后台，如果没有就显示登录页
$webtoken= cache_load('webtoken');
if($webtoken==''){
	include $this->template('manage_login');
}else{
	
	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}
	
	//通过缓存查找到管理员信息
	$manageid= cache_load('manageid');
	
	$manage=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$manageid));
	$v=0;
	if($manage['lev']==2 || $manage['lev']==3){		
		$v=1;		
	}
	
	//获取角色列表
	$rolelsit=pdo_fetchall("SELECT * FROM ".tablename('bc_community_authority')." WHERE weid=:uniacid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
	//获取当前订单详情
	$id=intval($_GPC['id']);
	$order=pdo_fetch("SELECT a.*,b.ptitle,b.pimg,b.punit FROM ".tablename('bc_community_mall_orders')." as a left join ".tablename('bc_community_mall_goods')." as b on a.pid=b.id WHERE a.weid=:uniacid AND a.id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$id));

	if(empty($order)){
		message('订单信息有误，请联系管理员', $this -> createMobileUrl('manag_mall_order',array()), 'error');
		return false;
	}




}

	$nav=7;

//提交订单编辑信息
	
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		if($order['postatus']==9){
			$yf=sprintf("%.2f", $_GPC['yf']);
			$all=$order['goodsprice']+$yf;
			$newdata = array(
				'remark'=>$_GPC['remark'],
				'yf'=>$yf,
				'orderprice'=>$all,
			);
			
	
		}else{
			
			$newdata = array(
				'remark'=>$_GPC['remark'],
				'express'=>$_GPC['express'],
				'postatus'=>$_GPC['postatus'],
				'potime2'=>time(),
			);
			
			
		}
		
			$res = pdo_update('bc_community_mall_orders', $newdata,array('id'=>$id));
			
			if (!empty($res)) {
				message('编辑成功', $this -> createMobileUrl('manage_mall_order'), 'success');
			} else {
				message('编辑失败！', $this -> createMobileUrl('manage_mall_order_edit',array('id'=>$id)), 'error');
			}
			
		
		

	}

}
	



	
	
	
	
	include $this->template('manage_orderinfo_edit');





?>