<?php 
	global $_W,$_GPC;
	
	if ($_W['account']['level'] == 3 || $_W['account']['key'] != $settings['appid']) {
		$settings = $this->module['config'];
		if (empty($_GPC['code'])) {
			$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$settings['appid'].'&redirect_uri='.urlencode($_W['siteroot'].'app/'.substr($this->createMobileUrl('auth'), 2)).'&response_type=code&scope=snsapi_base&state='.$_GPC['actid'].'#wechat_redirect';
			header("location: ".$url);
			exit;
		}

		load()->func('communication');
		

		$response = ihttp_get('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$settings['appid'].'&secret='.$settings['secret'].'&code='.$_GPC['code'].'&grant_type=authorization_code');
		$res = json_decode($response['content'],1);
		
		$info = pdo_get('zofui_posterhelp_auth',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['state'],'openid'=>$_W['openid']));

		if ( empty($info['authopenid']) ) {
			
			if (empty($info)) {
				$data['uniacid'] = $_W['uniacid'];
				$data['openid'] = $_W['openid'];
				$data['authopenid'] = $res['openid'];
				$data['actid'] = $_GPC['state'];
				pdo_insert('zofui_posterhelp_auth', $data);
			} else {
				pdo_update('zofui_posterhelp_auth', array('authopenid' => $res['openid']), array('id' => $info['id']));
			}
		}
		header("location: ".$this->createMobileUrl('index', array('actid' => $_GPC['state'])));
		exit;

	}