<?php
global $_W,$_GPC;
 		$code = $_GPC['code'];       
		load()->func('communication');
		$weid=intval($_GPC['weid']);
        $uid=intval($_GPC['uid']);
        $do=$_GPC['dw'];
        $reply=pdo_fetch('select * from '.tablename('tiger_newhu_poster').' where weid=:weid order by id asc limit 1',array(':weid'=>$weid));
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
                    //echo '<pre>';
                    //print_r($ret);
                   // exit;
                    /**
                    Array
                        (
                            [openid] => oozm3t8q7pk9LB2gn7iOLUl8E73U
                            [nickname] => 胡跃结
                            [sex] => 1
                            [language] => zh_CN
                            [city] => 金华
                            [province] => 浙江
                            [country] => 中国
                            [headimgurl] => http://wx.qlogo.cn/mmopen/ajNVdqHZLLDEXibUAOY2wxI2W4waic22H9r162vtYs0W75hXIX5Lr3hCVRSKnBYxYRwkWbps9BdpnIWr5BT2epRw/0
                            [privilege] => Array
                                (
                                )
                        )
                    **/
					$insert=array(
						'weid'=>$_W['uniacid'],
						'openid'=>$auth['openid'],
                        'helpid'=>$uid,
						'nickname'=>$auth['nickname'],
						'sex'=>$auth['sex'],
                        'city'=>$auth['city'],
                        'province'=>$auth['province'],
                        'country'=>$auth['country'],
						'headimgurl'=>$auth['headimgurl'],
						'unionid'=>$auth['unionid'],
					);
         
                    
					$from_user=$_W['fans']['from_user']; 
                  
					isetcookie('tiger_newhu_openid'.$weid, $auth['openid'], 1 * 86400);

					$sql='select * from '.tablename('tiger_newhu_member').' where weid=:weid AND openid=:openid ';
					$where="  ";	
					$fans=pdo_fetch($sql.$where." order by id asc limit 1 " ,array(':weid'=>$weid,':openid'=>$auth['openid']));
					if(empty($fans)){
						$insert['from_user']=$from_user;
                        $insert['time']=time();
                        //echo '<pre>';
                        //print_r($insert);
                        //exit;
						if($_W['account']['key']==$reply['appid'])$insert['from_user']=$auth['openid'];
						pdo_insert('tiger_newhu_member',$insert);
					}
                    if($do=='Goods'){
                      $forward = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=Goods&m=tiger_newhu&openid=".$auth['openid']."&wxref=mp.weixin.qq.com#wechat_redirect";
                    }
                    if($do=='tixian'){
                      $forward = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=Tixian&m=tiger_newhu&openid=".$auth['openid']."&wxref=mp.weixin.qq.com#wechat_redirect";
                    }
                    if($do=='sharetz'){
                      //$forward=$reply['tzurl'];
                      $forward = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=Sharetz&uid=".$uid."&m=tiger_newhu&wxref=mp.weixin.qq.com#wechat_redirect";
                    }   
					header('location:'.$forward);
					exit;
				}else{
					die('微信授权失败');
				}
			}else{
				die('微信授权失败');
			}
		}else{
            
			if($do=='Goods'){
               $forward = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=Goods&m=tiger_newhu&wxref=mp.weixin.qq.com#wechat_redirect";
            }
            if($do=='tixian'){
               $forward = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=Tixian&m=tiger_newhu&wxref=mp.weixin.qq.com#wechat_redirect";
            }
            
            if($do=='sharetz'){
              //$forward=$reply['tzurl'];
              $forward = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=Sharetz&uid=".$uid."&m=tiger_newhu&wxref=mp.weixin.qq.com#wechat_redirect";
            }  
			header('location: ' .$forward);
			exit;
		}
?>