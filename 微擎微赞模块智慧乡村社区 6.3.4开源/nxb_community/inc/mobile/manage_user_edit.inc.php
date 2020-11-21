<?php
global $_W, $_GPC;
include 'common.php';
load()->func('tpl');
$base=$this->get_base(); 
$title=$base['title'];
//查询缓存是否存在，如果有，就直接登录后台，如果没有就显示登录页
$webtoken= cache_load('webtoken');
if($webtoken==''){
	include $this->template('manage_login');
}else{
	//通过缓存查找到管理员信息
	$manageid= cache_load('manageid');
	
	$manage=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$manageid));
	
//查询当前管理员级别，获取该级别的管理的所有村镇列表

$townid=$manage['townid'];
if($townid==0){
	$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=2 ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
}else{
	$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND pid=:pid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':pid'=>$townid));
}


$nav=intval($_GPC['nav']);
if($nav==0){
	$nav=1;
}

$id=intval($_GPC['id']);
if($id!=0){
	$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE id=:id",array(':id'=>$id));
	
}
	

if ($_W['ispost']) {
	if (checksubmit('submit')) {
		if($_GPC['uname']=='' || $_GPC['upsd']==''){
			message('用户名、密码必填的哦~',$this->createMobileUrl('manage_user_edit',array('nav'=>6,'id'=>$id)),'error');          
     	} 

		//查询当前用户名是否有重名
		$cm=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND uname=:uname",array(':uniacid'=>$_W['uniacid'],':uname'=>$_GPC['uname']));
		if($cm){
			message('已经有这个用户名了，请重新输入~',$this->createMobileUrl('manage_user',array('nav'=>6)),'error');          
			return false;      
		}	
		
		$newdata = array(
			'pid'=>$manage['townid'],
			'uname'=>$_GPC['uname'],
			'upsd'=>md5($_GPC['upsd']),
			'townid'=>$_GPC['townid'],					
			 );
		$res = pdo_update('bc_community_jurisdiction', $newdata,array('id'=>$id));
		if (!empty($res)) {
			message('提交成功', $this -> createMobileUrl('manage_user',array('nav'=>6)), 'success');
		} else {
			message('提交失败！', $this -> createMobileUrl('manage_user',array('nav'=>6)), 'error');
		}
	}

}


	
	
	
	
	include $this->template('manage_user_edit');
}





?>