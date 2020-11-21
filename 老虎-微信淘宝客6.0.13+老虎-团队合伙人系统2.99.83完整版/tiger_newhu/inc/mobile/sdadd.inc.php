<?php
 global $_W, $_GPC;
 $dluid=$_GPC['dluid'];//share id
       $cfg = $this->module['config'];

       //$dd =pdo_fetch("select * from ".tablename($this->modulename."_sdorder")." where weid='{$_W['uniacid']}' and order=11 ");
       //print_r($dd);
//       $fans=$this->checkoauth();
//       echo '<pre>';
//       print_r($fans);
//       exit;

//       $fans=$_W['fans'];
//       $mc = mc_credit_fetch($fans['uid']);
//       if(empty($fans['openid'])){
//         echo '请从微信浏览器中打开！';
//         exit;
//       }
//       echo '<pre>';
//       print_r($fans);
//       exit;
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	//$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
       	  	  	 //header("Location: ".$loginurl); 
       	  	  	// exit;
	        }	        
        }
//       $mc = mc_credit_fetch($fans['uid']);
//       $fans['credit1']=$mc['credit1'];
//       $fans['avatar']=$fans['tag']['avatar'];
//       $fans['nickname'] =$fans['tag']['nickname'];
       $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单


       include $this->template ( 'user/sdadd' );