<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        $ajax=$_GPC['ajax'];
        $op=$_GPC['op'];
        $fans = $_W['fans'];
        $orderid=trim($_GPC['code']);
        $orderid=str_replace("订单号","",$orderid);
        $dluid=$_GPC['dluid'];//share id
        $pid=$_GPC['pid'];
        
        
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
        



        if($ajax=='ajax'){   
        	include IA_ROOT . "/addons/tiger_newhu/inc/fun/tiger.php"; 	
        	$resarr=pddaddorder($cfg,$_W['uniacid'],$member,$orderid);
        	die(json_encode($resarr));        	
        }
         $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单

        include $this->template ( 'user/pddaddorder' );      