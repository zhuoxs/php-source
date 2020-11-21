<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];
       $dluid=$_GPC['dluid'];//share id

       //$fans=$_W['fans'];
       load()->model('mc');
//       $fans=mc_oauth_userinfo();
//       if(empty($fans['openid'])){
//          echo '请从微信客户端打开！';
//          exit;
//       }  
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

//       $fans=$_W['fans'];
       $mc = mc_credit_fetch($fans['uid']);
       
       //echo '<pre>';
       //print_r($fans);
       //exit;
       $fans['credit1']=$mc['credit1'];
       $fans['avatar']=$fans['tag']['avatar'];
       $fans['nickname'] =$fans['tag']['nickname'];


       include $this->template ( 'user/index' );