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

//提交贫困户表单
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
			'photo'=>$images,
			'issuingauthority'=>$_GPC['issuingauthority'],
			'cardname'=>$_GPC['cardname'],
			'address'=>$_GPC['address'],
			'standard'=>$_GPC['standard'],
			'attribute'=>$_GPC['attribute'],
			'degree'=>$_GPC['degree'],
			'starttime'=>$_GPC['starttime'],
			'pname'=>$_GPC['pname'],
			'sex'=>$_GPC['sex'],
			'idcard'=>$_GPC['idcard'],			
			'yktcard'=>$_GPC['yktcard'],
			'zrk'=>$_GPC['zrk'],			
			'ldl'=>$_GPC['ldl'],
			'gdmj'=>$_GPC['gdmj'],
			'tgmj'=>$_GPC['tgmj'],				
			'ggmj'=>$_GPC['ggmj'],
			'fueltype'=>$_GPC['fueltype'],
			'wather'=>$_GPC['wather'],
			'broadcast'=>$_GPC['broadcast'],
			'house'=>$_GPC['house'],			
			'reason'=>$_GPC['reason'],
			'pctime'=>time(),
			
			
			 );
		$res = pdo_insert('nx_information_pinkuns', $newdata);
		if (!empty($res)) {
			message('提交成功！', $this -> createMobileUrl('poor_list'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('poor_add'), 'error');
		}

	}

}
	


include $this -> template('poor_add');

?>