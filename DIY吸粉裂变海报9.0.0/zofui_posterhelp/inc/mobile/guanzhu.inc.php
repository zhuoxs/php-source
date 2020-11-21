<?php 
	global $_W,$_GPC;
	
	if ($_W['account']['level'] == 3) {

		$settings = $this->module['config'];
		load() -> model('mc');
		$html = mc_oauth_userinfo();
		
		if( $_W['siteroot'] != 'http://127.0.0.4/' ){
			if( empty($html['unionid']) ) die('公众号还没设置好微信开放平台');
			if( empty($_W['openid']) ) die('公众号还没设置好借权');
		}else{
			$html['unionid'] = '11';
		}
        
		$uid = intval($_GPC['uid']);
		$user = pdo_get('zofui_posterhelp_user',array('uniacid'=>$_W['uniacid'],'id'=>$uid));
		if( empty($user) ) die('没有找到参与记录');

		$isset = pdo_get('zofui_posterhelp_invite',array('unionid'=>$html['unionid'],'uniacid'=>$_W['uniacid'],'actid'=>$user['actid']));
        if(empty($isset) && $html['unionid'] != $user['unionid']){
            $arr=array(
                'unionid' => $html['unionid'],//当前用户的unionid
                'uid' => $uid,//订单id
                'actid' => $user['actid'],
                'uniacid' => $_W['uniacid'],
                'endtime' => TIMESTAMP + 3600*24,
                'status' => 0,
            );
            pdo_insert('zofui_posterhelp_invite',$arr);
        }

	}

	include $this->template ('guanzhu');