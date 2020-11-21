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
	

$typeid=intval($_GPC['id']);

	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}
//获取当前分类名称
$result=pdo_fetch("SELECT * FROM ".tablename('bc_community_coursetype')." WHERE id=:id",array(':id'=>$typeid));	



if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'townid'=>$manage['townid'],
			'userid'=>$manage['id'],
			'typeid'=>$typeid,
			'title'=>$_GPC['title'],
			'comment'=>$_GPC['comment'],
			'cover'=>$_GPC['cover'],
			'clicks'=>0,	
			'status'=>$_GPC['status'],				
			'ctime'=>time(),
			 );
		$res = pdo_insert('bc_community_courselesson', $newdata);
		
		if (!empty($res)) {
			message('提交成功', $this -> createMobileUrl('manage_course',array('nav'=>3,'id'=>$typeid)), 'success');
		} else {
			message('提交失败！', $this -> createMobileUrl('manage_course',array('nav'=>3,'id'=>$typeid)), 'error');
		}

	}

}


	//获取种养技术分类列表
	$type=pdo_fetchall("SELECT * FROM ".tablename('bc_community_coursetype')." WHERE weid=:uniacid  AND pid=0 ORDER BY paixu ASC, id DESC",array(':uniacid'=>$_W['uniacid']));
	$lessonlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_courselesson')." WHERE weid=:uniacid  AND typeid=:typeid AND townid=:townid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':typeid'=>$typeid,':townid'=>$manage['townid']));
	

	
	include $this->template('manage_course');
}





?>