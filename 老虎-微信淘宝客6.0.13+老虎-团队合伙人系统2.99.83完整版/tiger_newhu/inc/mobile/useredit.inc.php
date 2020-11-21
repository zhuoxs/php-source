<?php
 global $_W, $_GPC;
       $cfg = $this->module['config'];
      $id=$_GPC['uid'];
      $dluid=$_GPC['dluid'];//share id
        $fans=$this->islogin();
        $fans['uid']=$fans['wquid'];
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	echo "请在微信端打开!";
	        	exit;
	        }
          $fans=$_W['fans'];       
        }
        $mc = mc_credit_fetch($fans['uid']);


       $member = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and id='{$id}'");
       if(empty($member)){
           if(!empty($fans['uid'])){
             pdo_insert($this->modulename."_share",
					array(
							'openid'=>$fans['uid'],
							'nickname'=>$fans['nickname'],
							'avatar'=>$fans['avatar'],
							'pid'=>'',
                            'updatetime'=>time(),
							'createtime'=>time(),
							'parentid'=>0,
							'weid'=>$_W['uniacid'],
							'score'=>'',
							'cscore'=>'',
							'pscore'=>'',
                            'from_user'=>$fans['openid'],
                            'follow'=>1
					));
			  $member['id'] = pdo_insertid();
           }
           
					$member = pdo_fetch('select * from '.tablename($this->modulename."_share")." where id='{$member['id']}'");         
       }
       if($_W['isajax']){
           $data=array(
               'weixin'=>$_GPC['weixin']
           );
          if(!empty($id)){
            $result=pdo_update($this->modulename."_share", $data, array('id' => $id));
						if($result){              
							exit(json_encode(array('status' =>1, 'msg'=>'修改成功','data' =>'','tzurl'=>'')));
						}else{
							exit(json_encode(array('status' =>0, 'msg'=>'异常错误','data' =>'','tzurl'=>'')));
						}
          }
          
       }
       

       include $this->template ( 'user/useredit' );