<?php 
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo();
	
	$name = empty( $_W['act']['creditname'] ) ? '花花' : $_W['act']['creditname'];	
	
	$_SESSION['getprize'] = 1;

	$prize = model_prize::getAllPrize( $_W['actid'] );

	$helped = pdo_count('zofui_posterhelp_helplist',array('actid'=>$_W['actid'],'helped'=>$_W['openid']));

	$sharetitle = str_replace('{nick}', $userinfo['nickname'], $_W['act']['sharetitle']);
	$sharedesc = str_replace('{nick}', $userinfo['nickname'], $_W['act']['sharedesc']);

	if( $_W['act']['jftype'] == 1 ){
		$carr = model_user::getUserCredit($userinfo['openid']);
		$userinfo['credit'] = empty($carr['credit1']) ? 0 : $carr['credit1'];
	}

	$settings = array(
		'sharetitle' => $sharetitle,
		'sharedesc' => $sharedesc,
		'shareimg' => tomedia( $_W['act']['shareimg'] ),
		'sharelink' => Util::createModuleUrl('index',array('actid'=>$_GPC['actid'])),
		'do' => 'getprize',
		'sendtype' => $_W['act']['sendtype'],
		'title' => '活动奖品',
		'actid' => $_W['actid'],
		'isshare' => $_W['account']['level'] <= 3 ? 0 : $_W['act']['isshare'],
		'cname' => $_W['act']['creditname'],
	);

	include $this->template ('getprize');
