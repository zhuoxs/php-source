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
	
	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}
	
	//通过缓存查找到管理员信息
	$manageid = $_SESSION['manageid']; //cache_load('manageid');
	
	$manage=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$manageid));
	$v=0;
	if($manage['lev']==2 || $manage['lev']==3){		
		$v=1;		
	}
	
	//获取当前乡镇的乡村组织列表
	$organtypelsit=pdo_fetchall("SELECT * FROM ".tablename('bc_community_organlev')." WHERE weid=:uniacid AND townid=:townid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':townid'=>$manage['townid']));
	//获取当前乡镇详情
	$id=intval($_GPC['id']);
	$organuser=pdo_fetch("SELECT * FROM ".tablename('bc_community_organuser')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$id));
}
	




if ($_W['ispost']) {
	if (checksubmit('submit')) {
			$images='';
			if($_GPC['cover']!=''){
				$images=$_GPC['cover'];
			}else{
				$images=$organuser['cover'];
			}
		
		$newdata = array(
			
			'organid'=>$_GPC['organid1'],
			'username'=>$_GPC['username'],
			'cover'=>$images,
			'sex'=>$_GPC['sex'],
			'tel'=>$_GPC['tel'],
			'zhiwei'=>$_GPC['zhiwei'],
			'company'=>$_GPC['company'],
			'comment'=>$_GPC['comment'],
            'displayorder'=>intval($_GPC['displayorder']),
			
			 );
		$res = pdo_update('bc_community_organuser', $newdata,array('id'=>$id));
		if (!empty($res)) {
			message('提交成功', $this -> createMobileUrl('manage_organ'), 'success');
		} else {
			message('提交失败！', $this -> createMobileUrl('manage_organ'), 'error');
		}

	}

}
	
	
	
	
	
	include $this->template('manage_organuser_edit');





?>