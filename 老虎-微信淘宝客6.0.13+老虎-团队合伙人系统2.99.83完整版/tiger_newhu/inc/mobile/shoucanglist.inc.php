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
// 				echo "<pre>";
// 				print_r($member);
// 				exit;
      
            
        $sclist = pdo_fetchall("select * from ".tablename($this->modulename."_shoucang")." where weid='{$_W['uniacid']}' and uid='{$member['id']}'");

       include $this->template ( 'tbgoods/style88/shoucanglist' );