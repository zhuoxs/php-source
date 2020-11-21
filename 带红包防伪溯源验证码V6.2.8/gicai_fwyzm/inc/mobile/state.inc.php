<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$account = cache_load('account:gicai_fwyzm_'.$_GPC['fid'].'_'.$_W['uniacid']);
if(!$account){
$form_s	= "SELECT * FROM " .tablename('gicai_fwyzm')."WHERE `id`=:id and `uniacid`=:uniacid";
$form_p	= array(':id'=>$_GPC['fid'],':uniacid'=>$_W['uniacid']);
$account = pdo_fetch($form_s,$form_p);
cache_write('account:gicai_fwyzm_'.$_GPC['fid'].'_'.$_W['uniacid'],$account);
}
$sql_datalog = "SELECT * FROM " .tablename('gicai_fwyzm_prize_log')."WHERE `id`=:id and `fid`=:fid and `uniacid`=:uniacid and `state`=:state";
$params_datalog = array(':id'=>$_GPC['id'],':fid'=>$_GPC['fid'],':uniacid'=>$_W['uniacid'],':state'=>'1');
$datalog = pdo_fetch($sql_datalog,$params_datalog);
$datalog['data'] = iunserializer($datalog['data']);
if($datalog){
	if($_GPC['password']==$account['passwords'] || $datalog['data']['duijiang']==$_GPC['password']){
		$data['state']		=	'0';
		$data['admin']		=	$_W['openid'];
		$data['ip']			=	$_W['clientip'];
		$data['audittime']	=	time();
		 
		$update = pdo_update('gicai_fwyzm_prize_log',$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid'],'state'=>'1'));
		if($update){
			$query['result']	= '10000';
			$query['messages']	= '兑奖成功！感谢您的参与！';
		}else{
			$query['result']	= '-10000';
			$query['messages']	= '兑奖过程中失败！请联系管理员！';
		}
	}else{
		$query['result']	= '-10000';
		$query['messages']	= '兑奖口令有误！';	
	}
}else{
	$query['result']	= '-10000';
	$query['messages']	= '兑奖信息不存在！请联系管理员！';
}
echo json_encode($query);

