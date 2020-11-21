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

$fid=intval($_GPC['fid']);
$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_family')." WHERE weid=:weid AND fid=:fid",array(':weid'=>$_W['uniacid'],':fid'=>$fid));
//提交家庭成员表单
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
		
		$images=implode("|",$_GPC['favatar']);
		
		if(empty($images)){
			$images=$hus['favatar'];
		}
		
		$newdata = array(
			'hid'=>$hid,			
			'city'=>$_GPC['city'],
			'county'=>$_GPC['county'],
			'town'=>$_GPC['town'],
			'village'=>$_GPC['village'],
			'bianma'=>$bianma,
			'mbianma'=>$_GPC['mbianma'],
			'sex'=>$_GPC['sex'],
			'id_card'=>$_GPC['id_card'],
			'guanxi'=>$_GPC['guanxi'],
			'nation'=>$_GPC['nation'],
			'education'=>$_GPC['education'],
			'school'=>$_GPC['school'],			
			'healthy'=>$_GPC['healthy'],
			'skill'=>$_GPC['skill'],			
			'workers'=>$_GPC['workers'],
			'workerstime'=>$_GPC['workerstime'],
			'medicalinsurance'=>$_GPC['medicalinsurance'],				
			'tpattr'=>$_GPC['tpattr'],
			'pkhattr'=>$_GPC['pkhattr'],
			'reason'=>$_GPC['reason'],
			'wfh'=>$_GPC['wfh'],
			'ysaq'=>$_GPC['ysaq'],	
			'yskn'=>$_GPC['yskn'],		
			'income'=>$_GPC['income'],
			'tel'=>$_GPC['tel'],
			'domicile'=>$_GPC['domicile'],				
			'residence'=>$_GPC['residence'],
			'political'=>$_GPC['political'],
			'marriage'=>$_GPC['marriage'],
			'flow'=>$_GPC['flow'],
			'home'=>$_GPC['home'],			
			'identity'=>$_GPC['identity'],
			'birth'=>$_GPC['birth'],
			'remark'=>$_GPC['remark'],	
			
			 );
		$res = pdo_update('nx_information_family', $newdata,array('fid'=>$fid));
		if (!empty($res)) {
			message('提交成功！', $this -> createMobileUrl('family_list'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('family_info',array('fid'=>$fid)), 'error');
		}

	}

}
	

include $this -> template('family_info');

?>