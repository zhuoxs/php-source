<?php
 global $_W, $_GPC;
        $cfg = $this->module['config'];
        $dluid=$_GPC['dluid'];//share id
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
        	if(empty($fans)){
        		$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
        				header("Location: ".$loginurl); 
        				exit;
        	}	        
        }
		

			 $mc=mc_fetch($fans['openid']);
       $member=$this->getmember($fans,$mc['uid']);
			 
			 
			 
       if($_W['isajax']){
				 $id=$_GPC['uid'];
				 $code = trim($_GPC['code']);
				 $pcuser = trim($_GPC['pcuser']);
				 $weid=$_W['uniacid'];
				 if(empty($id)){
					 exit(json_encode(array('status' =>0, 'msg'=>'帐号不正确','data' =>'','tzurl'=>'')));
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
				 
           $data=array(
               'tname'=>trim($_GPC['tname']),
               'zfbuid'=>trim($_GPC['zfbuid'])
           );
					$result=pdo_update($this->modulename."_share", $data, array('id' => $id));
					if($result){              
						exit(json_encode(array('status' =>1, 'msg'=>'修改成功','data' =>'','tzurl'=>'')));
					}else{
						exit(json_encode(array('status' =>0, 'msg'=>'异常错误','data' =>'','tzurl'=>'')));
					}
          
       }
       

       include $this->template ( 'user/zfbedit' );