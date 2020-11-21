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
	//获取当前村民详情
	$id=intval($_GPC['id']);
	$member=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$id));
}
	




if ($_W['ispost']) {
	if (checksubmit('submit')) {
			
		
		$newdata = array(
		
			'grade'=>$_GPC['grade'],		
			'isrz'=>$_GPC['isrz'],				
			
		);
		$res = pdo_update('bc_community_member', $newdata,array('mid'=>$id));
		if (!empty($res)) {
			message('提交成功', $this -> createMobileUrl('manage_member'), 'success');
		} else {
			message('提交失败！', $this -> createMobileUrl('manage_member'), 'error');
		}

	}

}
	
	
	
	
	
	include $this->template('manage_member_edit');





?>