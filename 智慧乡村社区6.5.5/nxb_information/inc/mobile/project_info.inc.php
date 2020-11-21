<?php
global $_W, $_GPC;
load() -> func('tpl');
include 'common.php';
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['modularname'];
if ($_W['fans']['follow']==0){
	include $this -> template('follow');
	exit;
};


$mid=$this->get_mid();

//查询是否有登录缓存，如果没有就跳转
$user=cache_load('user');
if(empty($user)){
	header("location:".$this->createMobileUrl('index'));
}


$proid=intval($_GPC['proid']);
$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_project')." WHERE weid=:weid AND proid=:proid",array(':weid'=>$_W['uniacid'],':proid'=>$proid));
//提交帮扶项目表单
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
			message('提交成功！', $this -> createMobileUrl('project_list'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('project_info',array('proid'=>$proid)), 'error');
		}

	}

}
	

include $this -> template('project_info');

?>