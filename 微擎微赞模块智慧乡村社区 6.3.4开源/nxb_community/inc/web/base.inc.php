<?php
global $_W, $_GPC;
load()->web('tpl'); 



//基础设置
if ($_W['ispost']) {
	if (checksubmit('submit')) {

	//获取基础设置详情
	$base=pdo_fetch("SELECT * FROM".tablename('bc_community_base')."WHERE weid=:uniacid",array(':uniacid'=>$_W['uniacid']));
	if(empty($base)){
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'title'=>$_GPC['title'],
			'ewm'=>$_GPC['ewm'],
			'bg'=>$_GPC['bg'],
			'remark'=>$_GPC['remark'],
			'notice'=>$_GPC['notice'],
			'noticeurl'=>$_GPC['noticeurl'],
			'tianqi'=>$_GPC['tianqi'],
			'tianqibg'=>$_GPC['tianqibg'],
			'agreement'=>$_GPC['agreement'],
			'zdymenu'=>$_GPC['zdymenu'],
			'zdyurl'=>$_GPC['zdyurl'],
			'zdymenu4'=>$_GPC['zdymenu4'],
			'zdyurl4'=>$_GPC['zdyurl4'],
			'zdymenuid'=>$_GPC['zdymenuid'],
			'copyright'=>$_GPC['copyright'],
			'cmslogo1'=>$_GPC['cmslogo1'],
			'cmslogo2'=>$_GPC['cmslogo2'],
			'createtime'=>time(),
			 );
		$res = pdo_insert('bc_community_base', $newdata);
		if (!empty($res)) {
			message('恭喜，设置成功！', $this -> createWebUrl('base'), 'success');
		} else {
			message('抱歉，设置失败！', $this -> createWebUrl('base'), 'error');
		}
	}else{
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'title'=>$_GPC['title'],
			'ewm'=>$_GPC['ewm'],
			'bg'=>$_GPC['bg'],
			'remark'=>$_GPC['remark'],
			'notice'=>$_GPC['notice'],
			'noticeurl'=>$_GPC['noticeurl'],
			'agreement'=>$_GPC['agreement'],
			'tianqi'=>$_GPC['tianqi'],
			'tianqibg'=>$_GPC['tianqibg'],
			'zdymenu'=>$_GPC['zdymenu'],
			'zdyurl'=>$_GPC['zdyurl'],
			'zdymenu4'=>$_GPC['zdymenu4'],
			'zdyurl4'=>$_GPC['zdyurl4'],
			'zdymenuid'=>$_GPC['zdymenuid'],
			'copyright'=>$_GPC['copyright'],
			'cmslogo1'=>$_GPC['cmslogo1'],
			'cmslogo2'=>$_GPC['cmslogo2']
			 );
		$res = pdo_update('bc_community_base', $newdata,array('id'=>$base['id']));
		if (!empty($res)) {
			message('恭喜，设置成功！', $this -> createWebUrl('base'), 'success');
		} else {
			message('抱歉，设置失败！', $this -> createWebUrl('base'), 'error');
		}
	}


		

	}

}


//获取基础设置详情
	$base=pdo_fetch("SELECT * FROM".tablename('bc_community_base')."WHERE weid=:uniacid",array(':uniacid'=>$_W['uniacid']));

	include $this->template('web/base');	


?>