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

//查询是否有登录缓存，如果没有就跳转
$user=cache_load('user');
if(empty($user)){
	header("location:".$this->createMobileUrl('index'));
}

//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

$breid=intval($_GPC['breid']);
$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_breed')." WHERE weid=:weid AND breid=:breid",array(':weid'=>$_W['uniacid'],':breid'=>$breid));
//提交养殖性收入表单
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		/*
		if($_GPC['hid']==0 || $_GPC['fname']==''){
			message('户ID、姓名是必填的哦~',$this->createMobileUrl('family_add',array()),'error');
		} 
		 * *
		 */
		
		$breid=intval($_GPC['breid']);
		$breed=pdo_fetch("SELECT * FROM ".tablename('nx_information_breed')." WHERE breid=:breid ",array(':breid'=>$breid));
		$hid=intval($_GPC['hid']);
		$hus=pdo_fetch("SELECT * FROM ".tablename('nx_information_hus')." WHERE hid=:hid ",array(':hid'=>$hid));
		$bianma='';
		if(!empty($hus)){
			$bianma=$hus['bianma'];
		}
		
		$images=implode("|",$_GPC['photo']);
		
		if(empty($images)){
			$images=$breed['photo'];
		}
		
		$newdata = array(
			'hid'=>$hid,
			'bianma'=>$bianma,
			'rarul'=>$_GPC['rarul'],
			'bname'=>$_GPC['bname'],
			'btel'=>$_GPC['btel'],
			'varieties'=>$_GPC['varieties'],
			'total'=>$_GPC['total'],
			'address'=>$_GPC['address'],
			'photo'=>$images,
			'price'=>$_GPC['price'],
			'grossincome'=>$_GPC['grossincome'],			
			'costexpenditure'=>$_GPC['costexpenditure'],
			'netincome'=>$_GPC['netincome'],
			
			 );
		$res = pdo_update('nx_information_breed', $newdata,array('breid'=>$breid));
		if (!empty($res)) {
			message('提交成功！', $this -> createMobileUrl('breed_list'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('breed_info',array('breid'=>$breid)), 'error');
		}

	}

}
	

include $this -> template('breed_info');

?>