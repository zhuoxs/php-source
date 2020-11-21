<?php
global $_GPC,$_W;
		$cfg = $this->module['config'];
		$pid=$_GPC['pid'];
		$tzurl=$_GPC['tzurl'];
		
		
		if ($_W['isajax']){
            $username=trim($_GPC['username']);
            $password=trim($_GPC['password']);

            $share= pdo_fetch("SELECT * FROM " . tablename($this->modulename."_share") . " WHERE pcuser='{$username}' and weid='{$_W['uniacid']}' ");

            if($username==$share['pcuser'] && $password==$share['pcpasswords']){
                $_SESSION["username"]=$share['pcuser'];
                $_SESSION["uid"]=$share['id'];
                $_SESSION["openid"]=$share['from_user'];
                $_SESSION["unionid"]=$share['unionid'];
                $_SESSION["pid"]=$share['dlptpid'];
                 exit(json_encode(array('status' =>1, 'msg'=>'登录成功','data' =>$share,'tzurl'=>$tzurl)));
              }else{
                 exit(json_encode(array('status' =>0, 'msg'=>'帐号密码错误','data' =>'','tzurl'=>$tzurl)));
              }         
         }

		include $this->template ( 'login' );  
?>