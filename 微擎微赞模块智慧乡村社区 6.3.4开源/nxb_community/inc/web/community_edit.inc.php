<?php
global $_W, $_GPC;
$coid=intval($_GPC['coid']);

if($coid){
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_community')." WHERE coid=:coid",array(':coid'=>$coid));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'coname'=>$_GPC['coname'],	
			'cocontant'=>$_GPC['cocontant'],
			 );
		$res = pdo_update('bc_community_community', $newdata,array('coid'=>$coid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('community'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('community'), 'error');
		}

	}
}




include $this->template('web/community_edit');
?>