<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加分类
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		if($_GPC['mtitle']=='' || $_GPC['authorid']==0){
			
			message('分类标题和发帖子权限不能为空！', $this -> createWebUrl('menu'), 'success');
		}

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
			 );
		$res = pdo_insert('bc_community_menu', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('menu'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('menu'), 'error');
		}

	}

}else{
	
	//获取导航列表
	$menutoplist=pdo_fetchall("SELECT * FROM".tablename('bc_community_menu')."WHERE weid=:uniacid AND mtype=1 ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid']));
	//获取滑动分类列表
	$menuscolist=pdo_fetchall("SELECT * FROM".tablename('bc_community_menu')."WHERE weid=:uniacid AND mtype=2 ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid']));
	//获取发帖权限表
	$authority=pdo_fetchall("SELECT * FROM".tablename('bc_community_authority')."WHERE weid=:uniacid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));

	include $this->template('web/menu');	
	
}


?>