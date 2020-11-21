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
$typeid=intval($_GPC['typeid']);
$id=intval($_GPC['id']);
if($id!=0){
	$lesson=pdo_fetch("SELECT * FROM ".tablename('bc_community_courselesson')." WHERE id=:id",array(':id'=>$id));
	
}


if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		
		if($_GPC['cover']!=''){
			$cover=$_GPC['cover'];
		}else{
			$cover=$lesson['cover'];
		}	
		$newdata = array(
			
			'townid'=>$manage['townid'],
			'userid'=>$manage['id'],
			'typeid'=>$typeid,
			'title'=>$_GPC['title'],
			'comment'=>$_GPC['comment'],
			'cover'=>$cover,	
			'status'=>$_GPC['status'],				

			 );
		$res = pdo_update('bc_community_courselesson', $newdata,array('id'=>$id));
		if (!empty($res)) {
			message('提交成功', $this -> createMobileUrl('manage_course',array('nav'=>3,'id'=>$typeid)), 'success');
		} else {
			message('提交失败！', $this -> createMobileUrl('manage_course',array('nav'=>3,'id'=>$typeid)), 'error');
		}

	}

}


	
	//获取种养技术分类列表
	$type=pdo_fetchall("SELECT * FROM ".tablename('bc_community_coursetype')." WHERE weid=:uniacid  AND pid=0 ORDER BY paixu ASC, id DESC",array(':uniacid'=>$_W['uniacid']));
	
	
	include $this->template('manage_course_edit');
}





?>