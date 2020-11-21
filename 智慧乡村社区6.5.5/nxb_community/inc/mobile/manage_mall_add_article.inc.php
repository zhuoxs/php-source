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
	
	//查询所有文章分类列表
	$arttype=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_arttype')." WHERE weid=:uniacid AND status=1 ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
	
	$id1=0;
	$id2=0;
	if($manage['lev']==2){
		$id1=$manage['townid'];
	}else if($manage['lev']==3){
		$id2=$manage['townid'];
	}
	
	
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		$photo='';
		if($_GPC['photo']!=''){
			$photo=implode("|",$_GPC['photo']);
		}
		
		
		$newdata = array(
		
			'weid'=>$_W['uniacid'],
			'pid'=>$_GPC['pid'],
			'cicon'=>$_GPC['cicon'],
			'ctitle'=>$_GPC['ctitle'],
			'content'=>$_GPC['content'],
			'photo'=>$photo,
			'status'=>1,
			'ctime'=>time(),
			'clidk'=>0,
			'danyuan'=>$id1,				
			'menpai'=>$id2,
		);
		$res = pdo_insert('bc_community_mall_article', $newdata);
		
		
		if (!empty($res)) {
			message('提交成功', $this -> createMobileUrl('manage_mall_article'), 'success');
		} else {
			message('提交失败！', $this -> createMobileUrl('manage_mall_add_article'), 'error');
		}

	}

}
	
	
	
	
	
	include $this->template('manage_mall_add_article');
}





?>