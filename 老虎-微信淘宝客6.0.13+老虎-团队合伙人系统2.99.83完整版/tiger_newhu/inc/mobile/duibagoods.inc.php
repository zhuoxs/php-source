<?php
 //http://wx.youqi18.com/app/index.php?i=3&c=entry&do=duibagoods&m=tiger_newhu
		global $_W,$_GPC;  
        include IA_ROOT . "/addons/tiger_newhu/duiba.php";
        $cfg=$this->module['config'];
        if(empty($cfg['AppKey'])){
          exit;
        }
        checkauth();
        load()->model('mc');
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();	        
        }
        //$uid = mc_openid2uid($fans['openid']);
        $fans=$this->getmember($fans,$mc['uid']);
        //$credit=mc_credit_fetch($uid);
        //echo '<pre>';
        //print_r($credit);
        //exit;
        //$crdeidt=strval(intval($credit['credit1']));
        //var_dump($crdeidt);
        //exit;
        
        $crdeidt=strval(intval($fans['credit1']));
        $uid=$fans['id'];

        
        
        $url=buildCreditAutoLoginRequest($cfg['AppKey'],$cfg['appSecret'],$uid,$crdeidt);
//      echo $url;
//      exit;
        header('location: ' .$url);
?>