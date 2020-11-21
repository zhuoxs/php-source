<?php
global $_W, $_GPC;
$dluid=$_GPC['dluid'];//share id
$weid=$_W['uniacid'];
        $cfg=$this->module['config']; 
        $ad = pdo_fetchall("SELECT * FROM " . tablename($this -> table_ad) . " WHERE weid = '{$weid}' order by id desc");

        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
       	  	  	 header("Location: ".$loginurl); 
       	  	  	 exit;
	        }	 
	        
	          $fans = $_W['fans'];
			  $mc = mc_fetch($fans['uid']);
              $fans['credit1']=$mc['credit1'];
              $fans['avatar']=$fans['tag']['avatar'];
              $fans['nickname'] =$fans['tag']['nickname'];       
        }
        
		$pid = $_GPC['pid'];
        $goods_list = pdo_fetchall("SELECT * FROM " . tablename("tiger_newhu_goods") . " as t1," . tablename($this -> table_request) . "as t2 WHERE t1.goods_id=t2.goods_id AND from_user='{$fans['openid']}' AND t1.weid = '{$_W['uniacid']}' ORDER BY t2.createtime DESC");
        
        //echo $fans['openid'];
//      print_r($goods_list);
//      exit;
        
        if(empty($goods_list)){
          $olist=1;
        }
        $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
        $mbstyle='style1';
        include $this -> template('goods/'.$mbstyle.'/request');