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


//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));
//查询干部记录
$cadrelist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_cadre')." WHERE weid=:weid ORDER BY cadid DESC",array(':weid'=>$_W['uniacid']));

//提交干部表单
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		$hid=intval($_GPC['hid']);
		$hus=pdo_fetch("SELECT * FROM ".tablename('nx_information_hus')." WHERE hid=:hid ",array(':hid'=>$hid));
		$bianma='';
		if(!empty($hus)){
			$bianma=$hus['bianma'];
		}
		
		
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'hid'=>$hid,
			'bianma'=>$bianma,
			'cadid'=>$_GPC['cadid'],
			'familynum'=>$_GPC['familynum'],
			'labors'=>$_GPC['labors'],
			'tpdate'=>$_GPC['todate'],
			'aincome'=>$_GPC['aincome'],
			'bincome'=>$_GPC['bincome'],
			'economic'=>$_GPC['economic'],
			'area'=>$_GPC['area'],
			'waterarea'=>$_GPC['waterarea'],			
			'breed'=>$_GPC['breed'],
			'mesctime'=>time(),
			
			 );
		$res = pdo_insert('nx_information_message', $newdata);
		if (!empty($res)) {
			message('提交成功！', $this -> createMobileUrl('message_list'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('message_add'), 'error');
		}

	}

}
	


include $this -> template('message_add');

?>