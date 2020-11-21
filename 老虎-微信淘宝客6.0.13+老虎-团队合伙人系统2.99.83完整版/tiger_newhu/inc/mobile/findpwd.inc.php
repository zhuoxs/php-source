<?php
global $_W,$_GPC;
        $cfg = $this->module['config'];        
        $helpid=$_GPC['hid'];
				
				$fans = mc_oauth_userinfo();
				$mc=mc_fetch($fans['openid']);				
				$member=$this->getmember($fans,$mc['uid']);
// 				echo "<pre>";
// 				print_r($member);
// 				exit;


        if ($_W['isajax']){
			$weid=$_W['uniacid'];
			$cfg = $this->module['config'];

			$pcuser = trim($_GPC['pcuser']);
			$pcpasswords = trim($_GPC['pcpasswords']);
			$code = trim($_GPC['code']);

            if(empty($code)){
				exit(json_encode(array('status' =>0, 'msg'=>'请填写验证码','data' =>'','tzurl'=>'')));
            }
            $mobile = pdo_fetch("select * from ".tablename("tiger_app_mobsend")." where weid='{$weid}' and tel='{$pcuser}'");
            
            if($code<>$mobile['value']){
				exit(json_encode(array('status' =>0, 'msg'=>'验证码不正确','data' =>'','tzurl'=>'')));
            }
						
				$share= pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_share") . " WHERE pcuser='{$pcuser}' and weid='{$weid}' ");
				if(empty($share)){
					exit(json_encode(array('status' =>0, 'msg'=>'手机号码不存在！','data' =>'','tzurl'=>'')));
				}else{
					$result = pdo_update($this->modulename."_share",array('pcpasswords'=>$pcpasswords), array('id' =>$share['id'], 'weid' => $_W['uniacid']));
					if($result){              
						exit(json_encode(array('status' =>1, 'msg'=>'修改成功，请重新登录！','data' =>'','tzurl'=>'')));
					}else{
						exit(json_encode(array('status' =>0, 'msg'=>'异常错误','data' =>'','tzurl'=>'')));
					}
				}
				
		}
        
		include $this -> template('findpwd');
?>