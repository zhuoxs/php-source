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
	
	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}

$id=intval($_GPC['id']);
if($id!=0){
	$type=pdo_fetch("SELECT * FROM ".tablename('bc_community_coursetype')." WHERE id=:id",array(':id'=>$id));
	
}


if ($_W['ispost']) {
	if (checksubmit('submit')) {
		if($_GPC['cover']!=''){
			$cover=$_GPC['cover'];
		}else{
			$cover=$type['cover'];
		}	
		$newdata = array(
			
			'title'=>$_GPC['title'],
			'cover'=>$cover,
			'paixu'=>$_GPC['paixu'],	
			'status'=>$_GPC['status'],			

			 );
		$res = pdo_update('bc_community_coursetype', $newdata,array('id'=>$id));
		if (!empty($res)) {
			message('提交成功', $this -> createMobileUrl('manage_technology',array('nav'=>3)), 'success');
		} else {
			message('提交失败！', $this -> createMobileUrl('manage_technology',array('nav'=>3)), 'error');
		}

	}

}


	
	
	
	
	include $this->template('manage_techonlogy_edit');
}





?>