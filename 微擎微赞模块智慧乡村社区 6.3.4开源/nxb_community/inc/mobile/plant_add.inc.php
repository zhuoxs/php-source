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



//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));



//提交种植性收入表单
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
		
		$images=implode("|",$_GPC['photo']);
		
		$newdata = array(
			'weid'=>$_W['uniacid'],
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
			'plactime'=>time(),
			
			
			 );
		$res = pdo_insert('nx_information_plant', $newdata);
		if (!empty($res)) {
			message('提交成功！', $this -> createMobileUrl('plant_list'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('plant_add'), 'error');
		}

	}

}
	


include $this -> template('plant_add');

?>