<?php
global $_W,$_GPC;
        $cfg = $this->module['config'];        
        $helpid=$_GPC['hid'];
		
		$fans=$this->islogin();
		//print_r($fans);
		if(empty($fans['tkuid'])){
			$fans = mc_oauth_userinfo();
			$mc=mc_fetch($fans['openid']);
		}
		$member=$this->getmember($fans,$mc['uid']);
				
		
// 				echo "<pre>";
// 				print_r($member);
// 				exit;


        if ($_W['isajax']){
						$weid=$_W['uniacid'];
            $cfg = $this->module['config'];
            $from_user = trim($_GPC['from_user']);
						$unionid = trim($_GPC['unionid']);
						$uid = trim($_GPC['uid']);//用户ID
						$pcuser = trim($_GPC['pcuser']);
						$pcpasswords = trim($_GPC['pcpasswords']);
						$yaoqingma = trim($_GPC['yaoqingma']);
            $code = trim($_GPC['code']);
						$nickname=trim($_GPC['nickname']);

            $set= pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_share") . " WHERE pcuser='{$pcuser}' and weid='{$weid}' ");
            if(!empty($set['id'])){
							exit(json_encode(array('status' =>0, 'msg'=>'手机号已被占用！请换个手机号','data' =>'','tzurl'=>'')));
            }
			if($cfg['smskgtype']==1){
				if(empty($code)){
								exit(json_encode(array('status' =>0, 'msg'=>'请填写验证码','data' =>'','tzurl'=>'')));
				}
				$mobile = pdo_fetch("select * from ".tablename("tiger_app_mobsend")." where weid='{$weid}' and tel='{$pcuser}'");
				
				if($code<>$mobile['value']){
								exit(json_encode(array('status' =>0, 'msg'=>'验证码不正确','data' =>'','tzurl'=>'')));
				}
			}
            
						
						$share= pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_share") . " WHERE from_user='{$from_user}' and weid='{$weid}' ");
						if(!empty($uid)){//有会员更新TEL
							$updata=array();
							$updata['pcuser']=$pcuser;
							$updata['tel']=$pcuser;
							$updata['pcpasswords']=$pcpasswords;
							if(empty($share['yaoqingma'])){
								$updata['yaoqingma']=$yaoqingma;
							}		
							$result = pdo_update($this->modulename."_share",$updata, array('id' =>$share['id'], 'weid' => $_W['uniacid']));
							
							if($result){              
								exit(json_encode(array('status' =>1, 'msg'=>'绑定成功','data' =>'','tzurl'=>'')));
							}else{
								exit(json_encode(array('status' =>0, 'msg'=>'异常错误','data' =>'','tzurl'=>'')));
							}
						}else{
							if(!empty($yaoqingma)){
								$sjshare = pdo_fetch('select * from '.tablename("tiger_newhu_share")." where weid='{$weid}' and yaoqingma='{$yaoqingma}'");
								if(empty($sjshare['id'])){
									$helpid=0;
								}else{
									$helpid=$sjshare['id'];
								}
							}
							if(empty($pcpasswords)){
								exit(json_encode(array('status' =>0, 'msg'=>'密码必须填写','data' =>'','tzurl'=>'')));
							}
							$intdata=array(
								'weid'=>$weid,
								'nickname'=>$nickname,
								'pcuser'=>$pcuser,
								'tel'=>$pcuser,
								'pcpasswords'=>$pcpasswords,
								'helpid'=>$helpid,
								'lytype'=>0,//来源 2小程序  1APP 0公众号
								'from_user'=>$pcuser."_".rand(10000,99999),
								'updatetime'=>time(),
								'createtime'=>time(),
								'status'=>0,
							);
							$res=pdo_insert("tiger_newhu_share",$intdata);	
							if(empty($res)){
								exit(json_encode(array('status' =>0, 'msg'=>'注册失败，服务器异常！','data' =>$intdata,'tzurl'=>$res)));
							}else{
								$set= pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_share") . " WHERE pcuser='{$pcuser}' and weid='{$weid}' ");
								exit(json_encode(array('status' =>1, 'msg'=>'注册成功','data' =>$share,'tzurl'=>$tzurl)));
							}
							
						}
						
						
						
						
						

        }
        
		include $this -> template('reg');
?>