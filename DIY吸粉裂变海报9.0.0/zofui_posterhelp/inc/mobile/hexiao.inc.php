<?php 
	global $_W,$_GPC;
	

	if( $_GPC['op'] == 'check' ){
		if( empty( $_SESSION['inga'] ) ) die;

		$geted = pdo_get('zofui_posterhelp_geted',array('uniacid'=>$_W['uniacid'],'code'=>$_GPC['code']));

		if( empty( $geted ) ) Util::echoResult(201,'没有找到兑奖记录');
		if( $geted['status'] == 1 ) Util::echoResult(201,'此奖品已经领取过了');
		
		$res = pdo_update('zofui_posterhelp_geted',array('status'=>1),array('id'=>$geted['id']));
		if( $res ){
			Util::echoResult(200,'成功核销奖品');
		}
		Util::echoResult(201,'核销奖品失败');
		
	}

	if( !empty( $_GPC['code'] ) ){
		
		$geted = pdo_get('zofui_posterhelp_geted',array('code'=>$_GPC['code'],'uniacid'=>$_W['uniacid']));
		if( empty( $geted ) ) message('没有找到兑奖记录');

		$prize = pdo_get('zofui_posterhelp_prize',array('id'=>$geted['prizeid'],'uniacid'=>$_W['uniacid']));

		if( empty( $prize ) ) message('没有找到奖品');
	}

	$_SESSION['inga'] = 1;
	// 分享
	$sharetitle = str_replace('{nick}', $userinfo['nickname'], $this->module['config']['sharetitle']);
	$sharedesc = str_replace('{nick}', $userinfo['nickname'], $this->module['config']['sharedesc']);
	$settings = array(
		'sharetitle' => $sharetitle,
		'sharedesc' => $sharedesc,
		'shareimg' => tomedia($this->module['config']['shareimg']),
		'sharelink' => Util::createModuleUrl('hexiao'),
		'do' => 'hexiao',
		'title' => '核销奖品',
		'code' => $join['code'],
	);	
	
	include $this->template ('hexiao');
