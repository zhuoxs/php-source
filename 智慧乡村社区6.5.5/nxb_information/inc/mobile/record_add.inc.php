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


//查询帮扶信息记录
$messagelist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_message')." WHERE weid=:weid ORDER BY mesid DESC",array(':weid'=>$_W['uniacid']));
//查询帮扶项目记录
$projectlist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_project')." WHERE weid=:weid ORDER BY proid DESC",array(':weid'=>$_W['uniacid']));



//提交帮扶记录表单
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'mesid'=>$_GPC['mesid'],
			'proid'=>$_GPC['proid'],	
			'recctime'=>time(),
			
			
			 );
		$res = pdo_insert('nx_information_record', $newdata);
		if (!empty($res)) {
			message('提交成功！', $this -> createMobileUrl('record_list'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('record_add'), 'error');
		}

	}

}
	


include $this -> template('record_add');

?>