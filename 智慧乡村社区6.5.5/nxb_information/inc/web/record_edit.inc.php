<?php
global $_W, $_GPC;
$recid=intval($_GPC['recid']);
//查询帮扶信息记录
$messagelist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_message')." WHERE weid=:weid ORDER BY mesid DESC",array(':weid'=>$_W['uniacid']));
//查询帮扶项目记录
$projectlist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_project')." WHERE weid=:weid ORDER BY proid DESC",array(':weid'=>$_W['uniacid']));


$mesid=intval($_GPC['mesid']);
if($recid){
	$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_record')." WHERE recid=:recid",array(':recid'=>$recid));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		
		$newdata = array(
			
			'mesid'=>$_GPC['mesid'],
			'proid'=>$_GPC['proid'],	
			
			 );
		$res = pdo_update('nx_information_record', $newdata,array('recid'=>$recid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('record',array('mesid'=>$mesid)), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('record',array('mesid'=>$mesid)), 'error');
		}

	}
}


	
include $this->template('web/record_edit');
?>