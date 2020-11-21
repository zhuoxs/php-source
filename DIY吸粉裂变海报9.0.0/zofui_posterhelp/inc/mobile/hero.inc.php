<?php 
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo();
	
	if( $_W['act']['isrank'] == 1 ) message('无排行榜');

	$myrank = model_help::getRanK($_W['actid'],$_W['openid'],$_W['act']['jftype']);
	
	
	if( empty($_W['act']['jftype']) ){
		$where = array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'status'=>0);
		$data = Util::getAllDataInSingleTable('zofui_posterhelp_user',$where,1,100,' `credit` DESC,`id` ASC ',true,false);
		$first = $data[0][0];
		$second = $data[0][1];
		$third = $data[0][2];

		$rank = array_slice($data[0], 3);

	}elseif ($_W['act']['jftype'] == 1) {
		$data = model_user::rank($_W['actid'],100);

		$first = $data[0];
		$second = $data[1];
		$third = $data[2];

		$rank = array_slice($data, 3);

	}
	
	

	
	

	$sharetitle = str_replace('{nick}', $userinfo['nickname'], $_W['act']['sharetitle']);
	$sharedesc = str_replace('{nick}', $userinfo['nickname'], $_W['act']['sharedesc']);
	$settings = array(
		'sharetitle' => $sharetitle,
		'sharedesc' => $sharedesc,
		'shareimg' => tomedia( $_W['act']['shareimg'] ),
		'sharelink' => '',
		'do' => 'hero',
		'title' => '排行榜',
		'islimit' => $_W['islimit'],
		'actid' => $_W['actid'],
		'isshare' => $_W['account']['level'] <= 3 ? 0 : $_W['act']['isshare'],
	);
	
	include $this->template ('hero');
