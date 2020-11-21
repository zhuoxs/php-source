<?php
global $_W, $_GPC;
$tid=intval($_GPC['tid']);

if($tid){
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_type')." WHERE tid=:tid",array(':tid'=>$tid));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'tname'=>$_GPC['tname'],	
			'tstatus'=>$_GPC['tstatus'],			
			 );
		$res = pdo_update('bc_community_type', $newdata,array('tid'=>$tid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('type'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('type'), 'error');
		}

	}
}




include $this->template('web/type_edit');
?>