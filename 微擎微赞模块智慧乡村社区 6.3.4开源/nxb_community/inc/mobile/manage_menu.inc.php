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
	


$townid=$manage['townid'];
$menulist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND townid=:townid ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid'],':townid'=>$townid));


//获取发帖权限表
$authority=pdo_fetchall("SELECT * FROM".tablename('bc_community_authority')."WHERE weid=:uniacid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));


	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}

if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
				

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'mtitle'=>$_GPC['mtitle'],
			'mimg'=>$_GPC['mimg'],
			'jump'=>$_GPC['jump'],
			'murl'=>$_GPC['murl'],
			'mtype'=>$_GPC['mtype'],
			'mstatus'=>$_GPC['mstatus'],
			'createtime'=>time(),
			'authorid'=>$_GPC['authorid'],
			'townid'=>$townid,
		);
		$res = pdo_insert('bc_community_menu', $newdata);
		if (!empty($res)) {
			message('恭喜，提交成功', $this -> createMobileUrl('manage_menu'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('manage_menu'), 'error');
		}

	}

}


	
	
	
	
	include $this->template('manage_menu');
}





?>