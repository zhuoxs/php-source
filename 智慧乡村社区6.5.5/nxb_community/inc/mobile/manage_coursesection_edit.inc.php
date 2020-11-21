<?php
global $_W, $_GPC;
include 'common.php';
load()->func('tpl');
$base=$this->get_base(); 
$title=$base['title'];
//查询缓存是否存在，如果有，就直接登录后台，如果没有就显示登录页
$webtoken = $_SESSION['webtoken']; //cache_load('webtoken');
if($webtoken==''){
	header('Location: '.$_W['siteroot'].'web/index.php?c=user&a=login&referer='.urlencode($_W['siteroot'].'app/'.$this->createMobileUrl('manage_login_go')));
}else{
	//通过缓存查找到管理员信息
	$manageid = $_SESSION['manageid']; //cache_load('manageid');
	
	$manage=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$manageid));
	
	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}
$lessid=intval($_GPC['lessid']);
$id=intval($_GPC['id']);
if($id!=0){
	$section=pdo_fetch("SELECT * FROM ".tablename('bc_community_coursesection')." WHERE id=:id",array(':id'=>$id));
	
}


if ($_W['ispost']) {
	if (checksubmit('submit')) {
				
		$newdata = array(			
			'title'=>$_GPC['title'],
			'videourl'=>$_GPC['videourl'],
			'audiourl'=>$_GPC['audiourl'],
			'clicks'=>0,	
			'status'=>$_GPC['status'],				
		);
		
		$res = pdo_update('bc_community_coursesection', $newdata,array('id'=>$id));
		if (!empty($res)) {
			message('提交成功', $this -> createMobileUrl('manage_coursesection',array('nav'=>3,'id'=>$lessid)), 'success');
		} else {
			message('提交失败！', $this -> createMobileUrl('manage_coursesection',array('nav'=>3,'id'=>$lessid)), 'error');
		}

	}

}


	
	
	
	include $this->template('manage_coursesection_edit');
}





?>