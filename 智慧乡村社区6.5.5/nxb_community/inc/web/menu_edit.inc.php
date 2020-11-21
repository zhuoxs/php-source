<?php
global $_W, $_GPC;
include 'common.php';
$meid=intval($_GPC['meid']);

if($meid){
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE meid=:meid",array(':meid'=>$meid));
	$authorid=explode(",",$res['authorid']);
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {
		if($_GPC['mtitle']=='' || $_GPC['authorid']==0){
			
			message('分类标题和发帖子权限不能为空！', $this -> createWebUrl('menu'), 'success');
		}

		$newdata = array(
			'mtitle'=>$_GPC['mtitle'],
			'mimg'=>$_GPC['mimg'],
			'jump'=>$_GPC['jump'],
			'murl'=>$_GPC['murl'],
			'mtype'=>$_GPC['mtype'],
			'mstatus'=>$_GPC['mstatus'],
			'authorid'=>$_GPC['authorid'],		
			 );
		$res = pdo_update('bc_community_menu', $newdata,array('meid'=>$meid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('menu'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('menu'), 'error');
		}

	}
}


//获取发帖权限表
$authority=pdo_fetchall("SELECT * FROM".tablename('bc_community_authority')."WHERE weid=:uniacid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));


include $this->template('web/menu_edit');
?>