<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加问题类型
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'coname'=>$_GPC['coname'],
			'cocontant'=>$_GPC['cocontant'],
			'cotime'=>time(),
			 );
		$res = pdo_insert('bc_community_community', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('community'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('community'), 'error');
		}

	}

}else{
	
	//获取社区列表
	$communitylist=pdo_fetchall("SELECT * FROM".tablename('bc_community_community')."WHERE weid=:uniacid ORDER BY coid DESC",array(':uniacid'=>$_W['uniacid']));
	
	include $this->template('web/community');	
	
}


?>