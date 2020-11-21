<?php 
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo();

	$prize = model_prize::getAllPrize( $_W['actid'] );
	//include POSETERH_ROOT.'receiver.php';

	$_SESSION['getprize'] = 1;

	$isform = 0;
	if( $_W['act']['isform'] == 1 ){
		$form = pdo_get('zofui_posterhelp_form',array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'openid'=>$_W['openid']));
		$isform = empty( $form ) ? 1 : 0;
	}
    
	if( $_W['act']['gametime'] == 0){ //1天
		$time = strtotime( date('Y-m-d',TIMESTAMP) );
		$where = array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'helper'=>$_W['openid'],'time>'=>$time);
	}else{ // 永久
		$where = array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'helper'=>$_W['openid']);
	}
	$helpnum = Util::countDataNumber('zofui_posterhelp_helplist',$where);
	$canhelp = $_W['act']['maxtimes'] - $helpnum;
	$canhelp = $canhelp < 0 ? 0 : $canhelp;

	// 帮助列表
	$where = array('helped'=>$_W['openid'],'actid'=>$_W['actid']);
	$select = ' a.credit,b.tag ';
	$helplog = model_help::getMyHelpLog($where,1,20,' `id` DESC ',true,false,$select);
	if( !empty( $helplog[0] ) ){
		foreach ($helplog[0] as &$v) {
			$tag = base64_decode($v['tag']);
			$tag = iunserializer($tag);
			
			$v['headimg'] = $tag['headimgurl'];
			$v['nickname'] = $tag['nickname'];
		}
		$helped = pdo_count('zofui_posterhelp_helplist',array('actid'=>$_W['actid'],'helped'=>$_W['openid']));
	}
	unset( $v );
	
	$indextemp = pdo_get('zofui_posterhelp_poster',array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'type'=>2));
	if( !empty( $indextemp['params'] ) ){
		$indextemp['params'] = iunserializer( $indextemp['params'] );
	}
	
	$temp = model_poster::initIndex( $indextemp );


	if( $_W['act']['indextype'] == 1 ){
		$myrank = model_help::getRanK($_W['actid'],$_W['openid'],$_W['act']['jftype']);
		
		$where = array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'status'=>0);
		$rank = Util::getAllDataInSingleTable('zofui_posterhelp_user',$where,1,100,' `credit` DESC,`id` ASC ',true,false);		
	}

	if( $_W['act']['jftype'] == 1 ){
		$carr = model_user::getUserCredit($userinfo['openid']);
		$userinfo['credit'] = empty($carr['credit1']) ? 0 : $carr['credit1'];
	}

	$sharetitle = str_replace('{nick}', $userinfo['nickname'], $_W['act']['sharetitle']);
	$sharedesc = str_replace('{nick}', $userinfo['nickname'], $_W['act']['sharedesc']);
	$settings = array(
		'sharetitle' => $sharetitle,
		'sharedesc' => $sharedesc,
		'shareimg' => tomedia( $_W['act']['shareimg'] ),
		'sharelink' => '',
		'do' => 'index',
		'title' => $_W['act']['name'],
		'islimit' => $_W['islimit'],
		'actid' => $_W['actid'],
		'sendtype' => $_W['act']['sendtype'],
		'isform' => $isform,
		'isshare' => $_W['account']['level'] <= 3 ? 0 : $_W['act']['isshare'],
		'cname' => $_W['act']['creditname'],
	);
	
	include $this->template ('index');
