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
	
	
	//获取当前乡镇详情
	$town=pdo_fetch("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$manage['townid']));
	//获取当前乡镇的乡村组织列表
	$organtypelsit=pdo_fetchall("SELECT * FROM ".tablename('bc_community_organlev')." WHERE weid=:uniacid AND villageid=:townid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid']));
	//获取当前乡镇的乡村组织成员列表
	$userlsit=pdo_fetchall("SELECT a.*,b.organname FROM ".tablename('bc_community_organuser')." as a left join ".tablename('bc_community_organlev')." as b on a.organid=b.id WHERE a.weid=:uniacid AND a.townid=:townid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid']));
	
	
	//获取所有乡镇列表
	
	$townid=intval($manage['townid']);
	if($townid==0){
		$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=2 ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
	}else{
		$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND pid=:pid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':pid'=>$townid));
	}
	
	//print_r($townlist);exit;
	
if ($_W['ispost']) {
	if (checksubmit('submit')) {
			
		
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'townid'=>$_GPC['townid1'],
			'organid'=>$_GPC['organid'],
			'username'=>$_GPC['username'],
			'cover'=>$_GPC['cover'],
			'sex'=>$_GPC['sex'],
			'tel'=>$_GPC['tel'],
			'zhiwei'=>$_GPC['zhiwei'],
			'company'=>$_GPC['company'],
			'comment'=>$_GPC['comment'],				
			'ctime'=>time(),
			 );
		$res = pdo_insert('bc_community_organuser', $newdata);
		if (!empty($res)) {
			message('提交成功', $this -> createMobileUrl('manage_organ'), 'success');
		} else {
			message('提交失败！', $this -> createMobileUrl('manage_organ'), 'error');
		}

	}

}
	
	
	
	
	
	include $this->template('manage_organ');
}





?>