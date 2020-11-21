<?php
global $_W, $_GPC;
        $dluid=$_GPC['dluid'];//share id
        $now=time();
        $weid=$_W['uniacid'];
        $type= $_GPC['type'];
        if($type=='sw'){
          $where=" and type=1";
        }
        if($type=='xn'){
          $where=" and type=5";
        }
        
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);     	  
       	  	  	 header("Location: ".$loginurl); 
       	  	  	 exit;
	        }	
	        load()->model('mc');
			$mc = mc_fetch($fans['openid']);
        }
        $fans=$this->getmember($fans,$mc['uid']);

        $cfg=$this->module['config']; 
        $goods_list = pdo_fetchall("SELECT * FROM " . tablename("tiger_newhu_goods") . " WHERE weid = '{$weid}' and $now < endtime and amount >= 0 {$where} order by px ASC");
        	
        	
        foreach($goods_list as $k=>$v){
            $requestsum = pdo_fetchcolumn("SELECT count(id) FROM " . tablename($this->modulename . "_request") . " WHERE weid = '{$weid}' and goods_id='{$v['goods_id']}'");
            $good[$k]=$v;
            $good[$k]['requestsum']=$requestsum;
        }
        $goods_list=$good;
//        echo '<pre>';
//        print_r($good);
//        exit;
        
        $xn_list = pdo_fetchall("SELECT * FROM " . tablename("tiger_newhu_goods") . " WHERE weid = '{$weid}' and $now < endtime and amount >= 0 and type=5 order by px ASC");
        $sw_list = pdo_fetchall("SELECT * FROM " . tablename("tiger_newhu_goods") . " WHERE weid = '{$weid}' and $now < endtime and amount >= 0 and type<>5 order by px ASC");

        


        $my_goods_list = pdo_fetch("SELECT * FROM " . tablename($this -> table_request) . " WHERE  from_user='{$fans['openid']}' AND weid = '{$weid}'");
        $ad = pdo_fetchall("SELECT * FROM " . tablename($this -> table_ad) . " WHERE weid = '{$weid}' order by id desc");

        load()->model('account');
        $cfg=$this->module['config'];

        $openid=$fans['openid'];
        
        $sql='select * from '.tablename('tiger_newhu_member').' where weid=:weid AND openid=:openid order by id asc limit 1';
        $member=pdo_fetch($sql,array(':weid'=>$weid,':openid'=>$openid));

		
		$pid = $_GPC['pid'];

         $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
       
        include $this -> template('goods/style1/goodsnew');