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
	
//添加村镇
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		/*
		if($_GPC['ntitle']=='' || $_GPC['ntext']=='' || $_GPC['nmenu']==''){
			message('帖子分类、帖子标题、帖子内容必填的哦~',$this->createMobileUrl('subform',array()),'error');          
     	} 

		 */
				
		$images=implode("|",$_GPC['photo']);
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'lev'=>$_GPC['lev'],
			'pid'=>$manage['townid'],
			'name'=>$_GPC['uname'],
			'cover'=>$_GPC['cover'],
			'photo'=>$images,
			'remark'=>$_GPC['remark'],
			'comment'=>$_GPC['comment'],
			'status'=>0,
			'paixu'=>$_GPC['paixu'],	
			'latlong'=>$_GPC['latlong'],
			'contacts'=>$_GPC['contacts'],	
			'tel'=>$_GPC['tel'],
			'color'=>$_GPC['color'],
			'rd'=>0,	
			'ctime'=>time(),
			 );
		$res = pdo_insert('bc_community_town', $newdata);
		if (!empty($res)) {
			message('恭喜，提交成功', $this -> createMobileUrl('manage_town'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('manage_town'), 'error');
		}

	}

}


	
	
	
	
	include $this->template('manage_town');
}





?>