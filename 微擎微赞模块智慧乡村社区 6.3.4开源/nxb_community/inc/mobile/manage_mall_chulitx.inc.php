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
	
	
	

if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			
			'status'=>$_GPC['status'],
			'remark'=>$_GPC['remark'],	
			'etime'=>time(),
			 );
		$res = pdo_update('bc_community_mall_wallet', $newdata,array('id'=>$id));
		if (!empty($res)) {
			message('恭喜，提交成功', $this -> createMobileUrl('manage_mall_tongji'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('manage_mall_tongji'), 'error');
		}

	}

}


	
	
	
	
	include $this->template('manage_mall_chulitx');
}





?>