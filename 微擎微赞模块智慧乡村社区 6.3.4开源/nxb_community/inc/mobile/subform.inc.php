<?php
global $_W, $_GPC;
load() -> func('tpl');

$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();

//查询用户角色是否有权限发帖
$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));

if($user['isrz']!=1){
	message('抱歉！认证为村民才可以发布帖子！',$this->createMobileUrl('register',array()),'error');
}

$cx=' AND townid in ('.$user['danyuan'].','.$user['menpai'].')';


$mlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND jump=0 ".$cx." ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid']));	







/*
if($user['grade']==2){
	//普通村民
	$cxtj=' AND mstatus IN(3,6,7) ';
	$mlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND jump=0 AND mtype=2 ".$cxtj." ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid']));	

	include $this -> template('subform1');
	exit;
}

if($user['grade']==3 || $user['grade']==4 || $user['grade']==7){
	//书记，副书记和管理员
	$cxtj=' AND mstatus IN(4,6,7) ';
	$mlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND jump=0 AND mtype!=1 ".$cxtj." ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid']));
	include $this -> template('subform1');
	exit;
}

if($user['grade']==6){
	//小区物业
	$cxtj=' AND IN(1,5) ';
	$mlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND jump=0 AND mtype=2 ".$cxtj." ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid']));	
	include $this -> template('subform1');
	exit;
}

if($user['grade']==5){
	//专家
	$cxtj=' AND mstatus IN(2,5,6) ';
	$mlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND jump=0 AND mtype=2 ".$cxtj." ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid']));	
	include $this -> template('subform1');
	exit;
}
 
 */
 
 


//查询该用户是否被禁言，不能发帖子和留言评论

if(!empty($user)){
	$gag=$user['gag'];
	if($gag==1){
		message('抱歉！您被禁言了，不能发帖子和留言评论，请和管理员联系！',$this->createMobileUrl('index',array()),'error');
	}
}


//提交报料表单
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		if($_GPC['ntitle']=='' || $_GPC['ntext']=='' || $_GPC['nmenu']==''){
			message('帖子分类、帖子标题、帖子内容必填的哦~',$this->createMobileUrl('subform',array()),'error');          
     	} 
				
		$images=implode("|",$_GPC['nimg']);
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'nmenu'=>$_GPC['nmenu'],
			'mid'=>$mid,
			'ntitle'=>$_GPC['ntitle'],
			'ntext'=>$_GPC['ntext'],
			'nimg'=>$images,
			'browser'=>1,					
			'nctime'=>time(),
			 );
		$res = pdo_insert('bc_community_news', $newdata);
		if (!empty($res)) {
			message('恭喜，帖子提交成功', $this -> createMobileUrl('index'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('index'), 'error');
		}

	}

}
	

include $this -> template('subform1');

?>