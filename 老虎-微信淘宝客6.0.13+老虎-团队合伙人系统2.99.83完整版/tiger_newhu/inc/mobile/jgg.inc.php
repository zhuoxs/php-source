<?php
global $_W, $_GPC;
 $cfg=$this->module['config'];
 
 if(empty($cfg['choujiangtype'])){
 	echo "<b style='font-size:15px;'>订单抽奖功能未开放，请联系管理员后台设置！</b>";
 	exit;
 }
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
     		$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
       	  	  	 header("Location: ".$loginurl); 
       	  	  	 exit;
	        }		              
        }
        $share = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");  
        
        
        if($cfg['dztypelx']==1){//直接到帐号
        	$ordersum = pdo_fetchcolumn("select COUNT(id) from ".tablename($this->modulename."_order")." where weid='{$_W['uniacid']}' and sh<>2 and sh<>4 and type=0 and uid='{$share['id']}'");
        }else{
        	$ordersum = pdo_fetchcolumn("select COUNT(id) from ".tablename($this->modulename."_order")." where weid='{$_W['uniacid']}'  and sh<>2 and sh<>4 and cjdd<>1 and type=0 and uid='{$share['id']}'");
        }
        

		
        
        
        $uid=$share['id'];
 include $this->template ( 'jgg' );
     ?>