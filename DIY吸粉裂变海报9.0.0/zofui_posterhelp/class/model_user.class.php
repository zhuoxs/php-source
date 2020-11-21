<?php 

/*
	用户表类
*/
class model_user 
{	
	
	static $oauth;

	//初始化用户数据
	static function initUserInfo(){
		global $_W,$_GPC;
		//load() -> model('mc');
		//$oauthinfo = mc_oauth_userinfo($_W['account']['oauth']['acid']);


		if( empty($_W['openid']) || strpos($user_agent, 'MicroMessenger') === false ) self::alertWechatLogin();
		
		$fans = pdo_get('mc_mapping_fans',array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']));
		//if( $fans['follow'] == 0 ) self::alertWechatLogin();

		$_W['actid'] = $_GPC['actid'];
		!empty( $_W['actid'] ) || message('活动不存在');

		$_W['act'] = model_act::getAct( $_W['actid'] );
		!empty( $_W['act'] ) || message('活动不存在');
		!$_W['act']['status'] == 1 || message('活动不存在');

		$_W['act']['creditname'] = empty( $_W['act']['creditname'] ) ? '花花' : $_W['act']['creditname'];	
		$_W['act']['thumb'] = empty( $_W['act']['thumb'] ) ? POSETERH_URL.'public/images/prize_fff.png' : tomedia($_W['act']['thumb']);

		$settings = Util::getModuleConfig();
        if ( !empty( $settings['appid'] ) && ( $_W['account']['level'] == 3 || $_W['account']['key'] != $settings['appid'] ) && strlen( $_W['openid'] ) > 10 ) {
        	$auth = pdo_get('zofui_posterhelp_auth',array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'openid'=>$_W['openid']));
			if (empty($auth['authopenid'])) {
				header("location: ".Util::createModuleUrl('auth', array('actid' => $_W['actid'])));
				die;
			}
        }

		$userinfo = self::getSingleUser($_W['openid']); //查询缓存
		if(!empty($userinfo)){
			if($userinfo['status'] == 1){
				header( "Location: http://www.baidu.com" );
				exit();
			}
			
			if($userinfo['logintime'] < time()-2*3600){ //每2小时更新一次登录时间，用户头像，昵称
				if(!empty( $_W['fans']['tag']['nickname'] )){
					$data = array('logintime'=>time(),'nickname' => $_W['fans']['tag']['nickname'],'headimgurl' => $_W['fans']['tag']['avatar']);
					pdo_update('zofui_posterhelp_user', $data, array('id' => $userinfo['id']));
					Util::deleteCache('u',$_W['openid']);
				}
			}
		}else{
			$userinfo = pdo_get('zofui_posterhelp_user',array('openid'=>$_W['openid'],'uniacid'=>$_W['uniacid'],'actid'=>$_W['actid']));				
			if (empty($userinfo['id']) && !empty($_W['openid'])) {
				$give = $_W['act']['jftype'] == 0 ? $_W['act']['free'] : $_W['act']['free'];
				$data = array(
					'uniacid' => $_W['uniacid'],
					'actid' => $_W['actid'],
					'openid' => $_W['openid'],
					'nickname' => $_W['fans']['tag']['nickname'],
					'headimgurl' => $_W['fans']['tag']['avatar'],
					'logintime' => time(),
					'credit' => $give,
					'authopenid' => $auth['authopenid'],
				);
				pdo_insert('zofui_posterhelp_user', $data);
				$id = pdo_insertid();
				pdo_update('zofui_posterhelp_user',array('code'=>$id.rand(11,99)),array('id'=>$id));
				$userinfo = self::getSingleUser($_W['openid']);
			}
		}

		// 是否获取地理位置
		$_W['islimit'] = 1;
		$sessionstr = $userinfo['id'].'ph'.$_W['uniacid'].$_W['actid'];
		if( !empty( $_SESSION[$sessionstr] ) || $_W['act']['arealimit'] == 0 ){
			$_W['islimit'] = 0;
		}

		// +访问记录
		//self::insertTimes();

		return $userinfo;
	}

	

	//查询一条用户数据,传入openid
	static function getSingleUser($openid){
		global $_W;

		$cache = Util::getCache('u',$openid);
		if( empty( $cache['id'] ) ){
			$cache = pdo_get('zofui_posterhelp_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid'],'actid'=>$_W['actid']));
			Util::setCache('u',$openid,$cache);
		}
		return $cache;
		//需删除缓存
	}

	//查询会员余额和积分
	static function getUserCredit($openid){	
		global $_W;
		load() -> model('mc');
		$uid = mc_openid2uid($openid);
		$setting = uni_setting($_W['uniacid'], array('creditbehaviors'));
		$credtis =  mc_credit_fetch($uid);
		$cache = array('uid'=>$uid,'credit1'=>$credtis[$setting['creditbehaviors']['activity']],'credit2'=>$credtis[$setting['creditbehaviors']['currency']]);; // 1是积分 2是余额
		return $cache;
	}

	// 改变会员余额 和 积分 type 1积分 2余额
	static function updateUserCredit($openid,$value,$type,$from,$mark='zofui_posterhelp'){
		global $_W;
		load() -> model('mc');
		$uid = mc_openid2uid($openid);
		$setting = uni_setting($_W['uniacid'], array('creditbehaviors'));
		if( $type == 1 ){
			$creditbehaviors = $setting['creditbehaviors']['activity'];
		}elseif( $type == 2 ){
			$creditbehaviors = $setting['creditbehaviors']['currency'];
		}else{
			return false;
		}
		$result = mc_credit_update($uid, $creditbehaviors, $value,array($uid,$mark,'zofui_posterhelp',$from));
		
		$res = is_error($result);
		return !$res;
	}

	//非微信端提示
	static function alertWechatLogin(){
		global $_W;
		$falg = '';
		
		$qrcode = tomedia('qrcode_'.$_W['acid'].'.jpg');
		die("<!DOCTYPE html>
            <html><head><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
                <title>提示</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
            </head>
            <body>
            <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>请关注公众号后再打开页面".$falg."。</h4><br><img width='200px' src='".$qrcode."'></div></body></html></div></div></div>
            </body></html>");
	}
	
	static function rank($actid,$num){
		global $_W;

		$sql = "SELECT a.*,c.`credit1` AS credit FROM ".tablename('zofui_posterhelp_user')." AS a LEFT JOIN ".tablename('mc_mapping_fans')." AS b ON a.openid = b.openid AND a.uniacid = b.uniacid LEFT JOIN ".tablename('mc_members')." AS c ON b.uid = c.uid WHERE a.uniacid = :uniacid AND a.actid = :actid AND c.credit1 > 0 ORDER BY c.`credit1` DESC LIMIT ".$num;
		$params = array(':uniacid'=>$_W['uniacid'],':actid'=>$actid);
		
		return pdo_fetchall($sql,$params);

	}
	
}
	
	
	
