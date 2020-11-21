<?php
global $_W,$_GPC;
 		$code = $_GPC['code'];       
        $weid=$_GPC['weid'];
		load()->model('account');
        $cfg=$this->module['config'];     
		if(!empty($code)) {
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$cfg['appid']."&secret=".$cfg['secret']."&code={$code}&grant_type=authorization_code";
			$ret = ihttp_get($url);
			if(!is_error($ret)) {
				$auth = @json_decode($ret['content'], true);      
				if(is_array($auth) && !empty($auth['openid'])) {
					$url='https://api.weixin.qq.com/sns/userinfo?access_token='.$auth['access_token'].'&openid='.$auth['openid'].'&lang=zh_CN';
					$ret = ihttp_get($url);//获取的粉丝信息
					$auth = @json_decode($ret['content'], true);//转成数组
					isetcookie('tiger_newhu_openid'.$weid, $auth['openid'], 1 * 86400);
                    $forward=$this->createMobileurl('kending',array('weid'=>$_GPC['weid'],'uid'=>$_GPC['uid']));
					header('location:'.$forward);
					exit;
				}else{
					die('微信授权失败');
				}
			}else{
				die('微信授权失败');
			}
		}else{
            $forward=$this->createMobileurl('kending',array('weid'=>$_GPC['weid'],'uid'=>$_GPC['uid']));
			header('location: ' .$forward);
			exit;
		}
?>