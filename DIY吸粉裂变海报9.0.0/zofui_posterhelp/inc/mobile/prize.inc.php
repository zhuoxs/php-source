<?php 
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo();
	
	$name = empty( $_W['act']['creditname'] ) ? '花花' : $_W['act']['creditname'];	
	
	if( $_W['act']['jftype'] == 1 ){
		$carr = model_user::getUserCredit($userinfo['openid']);
		$userinfo['credit'] = empty($carr['credit1']) ? 0 : $carr['credit1'];
	}

	$where = array('actid'=>$_W['actid'],'openid'=>$_W['openid']);
	$select = ' a.*,b.pic,b.name,b.type,b.isdetail,b.id AS prizeid,b.tips ';
	$myprize = model_prize::getMyPrize($where,1,99999,' `status` ASC,id DESC ',false,false,$select);

	$prizetemp = pdo_get('zofui_posterhelp_poster',array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'type'=>3));
	if( !empty( $prizetemp['params'] ) ){
		$prizetemp['params'] = iunserializer( $prizetemp['params'] );
	}
	$temp = model_poster::initPrize( $prizetemp );

	$sharetitle = str_replace('{nick}', $userinfo['nickname'], $_W['act']['sharetitle']);
	$sharedesc = str_replace('{nick}', $userinfo['nickname'], $_W['act']['sharedesc']);

	$settings = array(
		'sharetitle' => $sharetitle,
		'sharedesc' => $sharedesc,
		'shareimg' => tomedia( $_W['act']['shareimg'] ),
		'sharelink' => Util::createModuleUrl('index',array('actid'=>$_GPC['actid'])),
		'do' => 'prize',
		'title' => '我的奖品',
		'islimit' => $_W['islimit'],
		'actid' => $_W['actid'],
		'isshare' => $_W['account']['level'] <= 3 ? 0 : $_W['act']['isshare'],
	);

	include $this->template ('prize');
