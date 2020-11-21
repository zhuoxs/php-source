<?php
global $_W, $_GPC;
        //checkauth();
        load()->model('mc');
		$weid=$_W['uniacid'];
        $cfg=$this->module['config']; 
        $memberid=intval($_GPC['memberid']);
        $goods_id = intval($_GPC['goods_id']);
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);     	  
       	  	  	 header("Location: ".$loginurl); 
       	  	  	 exit;
	        }	
//	        load()->model('mc');
//			$mc = mc_fetch($fans['openid']);
			$share=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'"); 
            $fans['credit1']=$share['credit1'];
            $fans['avatar']=$fans['tag']['avatar'];
            $fans['nickname'] =$fans['tag']['nickname']; 
            $fans['tkuid']=$share['id'];
//          echo "<pre>";
//          	print_r($mc);
//          	exit;
        }

        
        $dluid=$_GPC['dluid'];//share id
        
        
        $goods_info = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_goods") . " WHERE goods_id = $goods_id AND weid = '{$weid}'");
       

         $request1 = pdo_fetchall("SELECT * FROM " . tablename($this->modulename . "_request") . " WHERE weid = '{$weid}' and goods_id='{$goods_info['goods_id']}' order by id desc limit 20");
         $requestsum = pdo_fetchcolumn("SELECT count(id) FROM " . tablename($this->modulename . "_request") . " WHERE weid = '{$weid}' and goods_id='{$goods_info['goods_id']}'");
         foreach($request1 as $k=>$v){
             $gx=mc_fetch($v['from_user']);
             $request[$k]['from_user_realname']=$v['from_user_realname'];
             $request[$k]['createtime']=$v['createtime'];
             $request[$k]['avatar']=$gx['avatar'];
         }
//        '<pre>';
//        print_r($request);
//        exit;
         
        

        $mbstyle='style1';
        include $this -> template('goods/'.$mbstyle.'/fillinfo');