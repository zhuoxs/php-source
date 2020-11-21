<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加问题类型
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'tname'=>$_GPC['tname'],
			'tstatus'=>0,
			'tctime'=>time(),
			 );
		$res = pdo_insert('bc_community_type', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('type'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('type'), 'error');
		}

	}

}else{
	
	//获取问题类型列表
	$typelist=pdo_fetchall("SELECT * FROM".tablename('bc_community_type')."WHERE weid=:uniacid AND tstatus=0 ORDER BY tid DESC",array(':uniacid'=>$_W['uniacid']));
	
	include $this->template('web/type');	
	
}


?>