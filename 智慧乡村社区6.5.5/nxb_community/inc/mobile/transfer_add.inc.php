<?php
global $_W, $_GPC;
load() -> func('tpl');
include 'common.php';
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
if ($_W['fans']['follow']==0){
	include $this -> template('follow');
	exit;
};


$mid=$this->get_mid();




//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

//提交转移性收入表单
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		/*
		if($_GPC['hid']==0 || $_GPC['fname']==''){
			message('户ID、姓名是必填的哦~',$this->createMobileUrl('family_add',array()),'error');
		} 
		 * *
		 */
		
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
			'rarul'=>$_GPC['rarul'],
			'pname'=>$_GPC['pname'],
			'ptel'=>$_GPC['ptel'],
			'transfer'=>$_GPC['transfer'],
			'grossincome'=>$_GPC['grossincome'],
			'farmland'=>$_GPC['farmland'],
			'grassland'=>$_GPC['grassland'],
			'commonweal'=>$_GPC['commonweal'],
			'farmer'=>$_GPC['farmer'],			
			'seed'=>$_GPC['seed'],
			'allowances'=>$_GPC['allowances'],
			'birth'=>$_GPC['birth'],
			'poverty'=>$_GPC['poverty'],
			'insurance'=>$_GPC['insurance'],
			'pension'=>$_GPC['pension'],
			'advancedage'=>$_GPC['advancedage'],
			'disability'=>$_GPC['disability'],
			'sociology'=>$_GPC['sociology'],
			'other'=>$_GPC['other'],	
			'tractime'=>time(),
			
			
			 );
		$res = pdo_insert('nx_information_transfer', $newdata);
		if (!empty($res)) {
			message('提交成功！', $this -> createMobileUrl('transfer_list'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('transfer_add'), 'error');
		}

	}

}
	


include $this -> template('transfer_add');

?>