<?php
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;
//$_W['openid']				=	"XXXX";
//$_W['fans']['nickname']		=	"盖世英雄";
////$_W['openid']	=	"ZZZZ";
////$_W['openid']	=	"AAAA";
$account = pdo_get('gicai_fwyzm',array('id'=>$_GPC['fid'],'uniacid'=>$_W['uniacid']));
$account['menu'] 	= iunserializer($account['menu']);
if($_W['isajax']){
	if($_GPC['mo']=='ajax'){
		$oath = pdo_get('gicai_fwyzm_oath',array('fid'=>$_GPC['fid'],'uniacid'=>$_W['uniacid'],'openids'=>$_GPC['openids']));
		if($oath){
			$query['result']		=	'10000';
			$query['messages']		=	'ok';
			$query['data']			=	$oath;
		}else{
			$query['result']		=	'-10000';
			$query['messages']		=	'未获取到微信身份！';
			$query['data']			=	$oath;
		}
		exit(json_encode($query));	
	} 
	
	if($_W['openid']!=''){
		
		
		pdo_delete('gicai_fwyzm_oath', array('id' =>$id,'uniacid'=>$_W['uniacid'],'openids'=>$_GPC['openids']));
		$data['uniacid']		=	$_W['uniacid'];
		$data['fid']			=	$_GPC['fid'];
		$data['openids']		=	$_GPC['openids'];
		$data['openid']			=	$_W['openid'];
		$data['name']			=	$_W['fans']['nickname'];
		$data['state']			=	'1';
		$data['addtime']		=	time();
 
		$account 		= pdo_insert('gicai_fwyzm_oath',$data);
		$data['id']		= pdo_insertid();
	 	
		$query['result']		=	'10000';
		$query['messages']		=	'授权成功！';
		$query['data']			=	$data;
		exit(json_encode($query));
		
	}else{
		$query['result']		=	'-10000';
		$query['messages']		=	'未获取到微信身份！';
		exit(json_encode($query));	
	}
	
}else{
	 
	 
	include $this->template($account['template'].'/oath');
}
 