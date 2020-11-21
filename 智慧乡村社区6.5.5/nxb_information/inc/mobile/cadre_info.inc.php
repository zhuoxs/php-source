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

$cadid=intval($_GPC['cadid']);
$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_cadre')." WHERE weid=:weid AND cadid=:cadid",array(':weid'=>$_W['uniacid'],':cadid'=>$cadid));
//提交干部记录
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		
		$cadid=intval($_GPC['cadid']);
		$cadre=pdo_fetch("SELECT * FROM ".tablename('nx_information_cadre')." WHERE cadid=:cadid ",array(':cadid'=>$cadid));
		
		$images=implode("|",$_GPC['avatar']);
		
		if(empty($images)){
			$images=$cadre['avatar'];
		}
		
		$newdata = array(

			'cname'=>$_GPC['cname'],
			'post'=>$_GPC['post'],
			'company'=>$_GPC['company'],
			'avatar'=>$images,
			'phone'=>$_GPC['phone'],
			'sex'=>$_GPC['sex'],
			'idcard'=>$_GPC['idcard'],
			'nomberone'=>$_GPC['nomberone'],
			'duizhang'=>$_GPC['duizhang'],
			'starttime'=>$_GPC['starttime'],
			'endtime'=>$_GPC['endtime'],
			'techang'=>$_GPC['techang'],
			'zhengzhi'=>$_GPC['zhengzhi'],
			'xueli'=>$_GPC['xueli'],
			'address'=>$_GPC['address'],
			'remark'=>$_GPC['remark'],

			
			 );
		$res = pdo_update('nx_information_cadre', $newdata,array('cadid'=>$cadid));
		if (!empty($res)) {
			message('提交成功！', $this -> createMobileUrl('cadre_list'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('cadre_info',array('cadid'=>$cadid)), 'error');
		}

	}

}
	

include $this -> template('cadre_info');

?>