<?php 
	global $_W,$_GPC;
	$_W['actid'] = $_GPC['actid'];
	
	!empty( $_W['actid'] ) || message('活动不存在');

	$code = md5( $this->module['config']['sendmessauth'].$_W['authkey'] );
	if( $code != $_GPC['code'] || empty( $_GPC['code'] ) ) die;

	$_W['act'] = model_act::getAct( $_W['actid'] );
	!empty( $_W['act'] ) || message('活动不存在');
	!$_W['act']['status'] == 1 || message('活动不存在');

	$_W['act']['creditname'] = empty( $_W['act']['creditname'] ) ? '花花' : $_W['act']['creditname'];	
	$_W['act']['thumb'] = empty( $_W['act']['thumb'] ) ? POSETERH_URL.'public/images/prize_fff.png' : tomedia($_W['act']['thumb']);


	$user = model_user::getSingleUser($_GPC['openid']);

	if( !empty( $user ) ) {
		$img = model_poster::getPoster($user);

		if( !$img ){
			$isbusy = Util::getCache('busy','all');
			if( !empty($isbusy) ){
				Util::deleteCache('busy','all');
				Message::sendText($_GPC['openid'], '系统繁忙，请重试');
			}
		}

		$media = Message::uploadImage($img['dir']);
		$res = Message::sendImage($_GPC['openid'], $media);
		if( !$res['res'] ) {
			file_put_contents(POSETERH_ROOT."/errparams.log", var_export($res, true).PHP_EOL, FILE_APPEND);	
		}
	}


