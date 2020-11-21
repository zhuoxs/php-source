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
if($townid==0){
	$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=2 ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
}

	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}

$id=intval($_GPC['id']);
if($id!=0){
	$article=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_article')." WHERE id=:id",array(':id'=>$id));
	if($article['photo']!=''){
		$images=explode("|",$article['photo']);
	}
	
}
	
	//查询所有文章分类列表
	$arttype=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_arttype')." WHERE weid=:uniacid AND status=1 ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
	

if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		
		
		$photo='';
		if($_GPC['photo']!=''){
			$photo=implode("|",$_GPC['photo']);
		}else{
			$photo=$article['photo'];
		}
		$cicon='';
		if($_GPC['cicon']!=''){
			$cicon=$_GPC['cicon'];
		}else{
			$cicon=$article['cicon'];
		}
		
		$newdata = array(
		

			'pid'=>$_GPC['pid'],
			'cicon'=>$cicon,
			'ctitle'=>$_GPC['ctitle'],
			'content'=>$_GPC['content'],
			'photo'=>$photo,
			'status'=>$_GPC['content'],

		);
		$res = pdo_update('bc_community_mall_article', $newdata,array('id'=>$id));
		
		if (!empty($res)) {
			message('编辑成功', $this -> createMobileUrl('manage_mall_article'), 'success');
		} else {
			message('编辑失败！', $this -> createMobileUrl('manage_mall_article'), 'error');
		}

	}

}


	
	
	
	
	include $this->template('manage_mall_article_edit');
}





?>