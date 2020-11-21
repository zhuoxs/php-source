<?php
global $_W, $_GPC;
$proid=intval($_GPC['proid']);

if($proid){
	$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_project')." WHERE proid=:proid",array(':proid'=>$proid));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		$newdata = array(

			'projectname'=>$_GPC['projectname'],
			'helpcontent'=>$_GPC['helpcontent'],
			'subsidy'=>$_GPC['subsidy'],
			'aincome'=>$_GPC['aincome'],
			'bincome'=>$_GPC['bincome'],
			'expenditure'=>$_GPC['expenditure'],
			'yearincome'=>$_GPC['yearincome'],	

			 );
		$res = pdo_update('nx_information_project', $newdata,array('proid'=>$proid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('project'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('project'), 'error');
		}

	}
}


	
include $this->template('web/project_edit');
?>