<?php
global $_W, $_GPC;
include 'common.php';
load()->web('tpl'); 
$mid=$_GPC['mid'];


	
	//获取用户信息
	$member=pdo_fetch("SELECT a.*,b.coname FROM ".tablename('bc_community_member')." as a left join ".tablename('bc_community_community')." as b on a.coid=b.coid WHERE a.weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));

	
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'grade'=>$_GPC['grade'],	
			'isrz'=>$_GPC['isrz'],
			'realname'=>$_GPC['realname'],	
			'tel'=>$_GPC['tel'],	
			'danyuan'=>$_GPC['danyuan'],	
			'menpai'=>$_GPC['menpai'],						
			 );
		$res = pdo_update('bc_community_member', $newdata,array('mid'=>$mid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('member'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('member'), 'error');
		}

	}
}
	
	//获取发帖权限表
	$authority=pdo_fetchall("SELECT * FROM".tablename('bc_community_authority')."WHERE weid=:uniacid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
	
//获取所有镇级列表
$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=2 ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));

	
	
	include $this->template('web/member_edit');	
	


?>