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
	
//查询当前管理员级别，获取该级别的管理的所有村镇列表

$townid=$manage['townid'];
$menulist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND townid=:townid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':townid'=>$townid));

	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}

$id=intval($_GPC['id']);
if($id!=0){
	$menu=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE meid=:id",array(':id'=>$id));
	
}
//获取发帖权限表
$authority=pdo_fetchall("SELECT * FROM".tablename('bc_community_authority')."WHERE weid=:uniacid AND town_id=$townid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));


if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		if($_GPC['mimg']!=''){
			$mimg=$_GPC['mimg'];
		}else{
			$mimg=$menu['mimg'];
		}	
		 
		
		$newdata = array(
			
			'mtitle'=>$_GPC['mtitle'],
			'mimg'=>$mimg,
			'jump'=>$_GPC['jump'],
			'murl'=>$_GPC['murl'],
			'mtype'=>$_GPC['mtype'],
			'mstatus'=>$_GPC['mstatus'],
			'authorid'=>$_GPC['authorid'],
            'displayorder'=>$_GPC['displayorder'],
			'townid'=>$townid,

		);
		$res = pdo_update('bc_community_menu', $newdata,array('meid'=>$id));
		if (!empty($res)) {
			message('编辑成功', $this -> createMobileUrl('manage_menu'), 'success');
		} else {
			message('编辑失败！', $this -> createMobileUrl('manage_menu'), 'error');
		}

	}

}


	
	
	
	
	include $this->template('manage_menu_edit');
}





?>