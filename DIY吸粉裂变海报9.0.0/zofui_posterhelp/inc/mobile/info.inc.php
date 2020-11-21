<?php 
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo();
	
	$prize = pdo_get('zofui_posterhelp_prize',array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'id'=>$_GPC['id']));

	if( empty( $prize ) || $prize['isdetail'] == 0 ) message('没找到奖品信息');

	
	$sharetitle = str_replace('{nick}', $userinfo['nickname'], $_W['act']['sharetitle']);
	$sharedesc = str_replace('{nick}', $userinfo['nickname'], $_W['act']['sharedesc']);

	$settings = array(
		'sharetitle' => $sharetitle,
		'sharedesc' => $sharedesc,
		'shareimg' => tomedia( $_W['act']['shareimg'] ),
		'sharelink' => Util::createModuleUrl('index',array('actid'=>$_GPC['actid'])),
		'do' => 'info',
		'title' => '我的奖品',
		'islimit' => $_W['islimit'],
		'actid' => $_W['actid'],
		'isshare' => $_W['account']['level'] <= 3 ? 0 : $_W['act']['isshare'],
	);

	include $this->template ('info');
