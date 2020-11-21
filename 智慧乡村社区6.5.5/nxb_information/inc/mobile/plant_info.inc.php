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

$plaid=intval($_GPC['plaid']);
$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_plant')." WHERE weid=:weid AND plaid=:plaid",array(':weid'=>$_W['uniacid'],':plaid'=>$plaid));
//提交种植性收入表单
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		/*
		if($_GPC['hid']==0 || $_GPC['fname']==''){
			message('户ID、姓名是必填的哦~',$this->createMobileUrl('family_add',array()),'error');
		} 
		 * *
		 */
		
		$plaid=intval($_GPC['plaid']);
		$plant=pdo_fetch("SELECT * FROM ".tablename('nx_information_plant')." WHERE plaid=:plaid ",array(':plaid'=>$plaid));
		$hid=intval($_GPC['hid']);
		$hus=pdo_fetch("SELECT * FROM ".tablename('nx_information_hus')." WHERE hid=:hid ",array(':hid'=>$hid));
		$bianma='';
		if(!empty($hus)){
			$bianma=$hus['bianma'];
		}
		
		$images=implode("|",$_GPC['photo']);
		
		if(empty($images)){
			$images=$plant['photo'];
		}
		
		$newdata = array(
			'hid'=>$hid,
			'bianma'=>$bianma,
			'rarul'=>$_GPC['rarul'],
			'pname'=>$_GPC['pname'],
			'ptel'=>$_GPC['ptel'],
			'management'=>$_GPC['management'],
			'varieties'=>$_GPC['varieties'],
			'area'=>$_GPC['area'],
			'address'=>$_GPC['address'],
			'photo'=>$images,
			'yield'=>$_GPC['yield'],
			'price'=>$_GPC['price'],
			'grossincome'=>$_GPC['grossincome'],			
			'costexpenditure'=>$_GPC['costexpenditure'],
			'netincome'=>$_GPC['netincome'],
			
			 );
		$res = pdo_update('nx_information_plant', $newdata,array('plaid'=>$plaid));
		if (!empty($res)) {
			message('提交成功！', $this -> createMobileUrl('plant_list'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('plant_info',array('plaid'=>$plaid)), 'error');
		}

	}

}
	

include $this -> template('plant_info');

?>