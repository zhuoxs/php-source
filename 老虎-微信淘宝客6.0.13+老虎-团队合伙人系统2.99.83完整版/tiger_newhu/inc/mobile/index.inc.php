<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];
        $lm=$cfg['mmtype'];
        $typeid=$_GPC['typeid'];
        $do=$_GPC['do'];
        $pid=$_GPC['pid'];
        $dluid=$_GPC['dluid'];//share id
        $weid=$_W['uniacid'];
        $rate=trim($cfg['zgf']);


        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	if($_W['account']['level']==4){
        		$fans = mc_oauth_userinfo();  
        	}        	      
        }

        if(!empty($dluid)){
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id={$dluid}");
        }else{
          //$fans=mc_oauth_userinfo();
          $openid=$fans['openid'];
          if(empty($openid)){
          	$openid=$_W['openid'];
          }
          $zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");         
        }
        
        if($zxshare['dltype']==1){
            if(!empty($zxshare['dlptpid'])){
               $cfg['ptpid']=$zxshare['dlptpid'];
            }
        }else{
           if(!empty($zxshare['helpid'])){//查询有没有上级
                 $sjshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1 and id='{$zxshare['helpid']}'");           
            }
        }
        if(!empty($sjshare['dlptpid'])){
            if(!empty($sjshare['dlptpid'])){
              $cfg['ptpid']=$sjshare['dlptpid'];
            }            
        }else{    
            if(!empty($share['dlptpid'])){
                 $cfg['ptpid']=$share['dlptpid'];
            }  
        }
        if(empty($pid)){
        	$pid=$cfg['ptpid'];
	    }else{
	    	$cfg['ptpid']=$pid;
	    }



        $day=date("Y/m/d",time());
        $dtime=strtotime($day);

        $fans=$_W['fans'];
        if(empty($fans)){
          //$fans=mc_oauth_userinfo();
            if($_W['account']['level']==4){
        		$fans = mc_oauth_userinfo();  
        	}
        }
       $openid=$fans['openid'];
       if(pdo_tableexists('tiger_wxdaili_set')){
          $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
       }

        $id=$_GPC['id'];
        $tj=$_GPC['tj'];
        $key=$_GPC['key'];
        if(!empty($typeid)){
           $where =" and type='{$typeid}'";
        }
        $lbad = pdo_fetchall("SELECT * FROM " . tablename($this -> table_ad) . " WHERE weid = '{$_W['uniacid']}' and type=0 order by id desc");//轮播图
        $syad = pdo_fetchall("SELECT * FROM " . tablename($this -> table_ad) . " WHERE weid = '{$_W['uniacid']}' and type=1 order by id desc");//首页中部
        $ad2 = pdo_fetchall("SELECT * FROM " . tablename($this -> table_ad) . " WHERE weid = '{$_W['uniacid']}' and type=4 order by id desc");//首页2张图片
        
        
        if($lm==2){//云商品库
        	include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
        	$fzlist8=getclass($_W,$cfg['ptpid'],8);//首页8个分类
        	$fzlist=getclass($_W,$cfg['ptpid'],'');//全部分类
        	$mbmk=getvideolist($_W,$cfg,$pid,$px,18);//边买边看
        	$tjlist=gettjlist(1,18,'','',$cfg);//限时秒杀
//        	echo '<pre>';
//        	print_r($fzlist);
//        	exit;
     }else{

             if(!empty($cfg['gyspsj'])){
               $weid=$cfg['gyspsj'];
             }
	        
	        
	        $tjlist = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$weid}' and tj=1 order by id desc limit 18");//限时秒杀
	        $mbmk = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$weid}' and videoid<>0 order by id desc limit 18");//边买边看
	        
        	$fzlist = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$weid}'  and (cid= 0 or cid='')   order by px desc");

					
					
       	    $fzlist8 = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$weid}'  and (cid= 0 or cid='')    order by px desc limit 10");
      }
      
      if($cfg['lbtx']==1){//订单轮播
	     $msg = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_msg") . " WHERE weid = '{$_W['uniacid']}' order by rand() desc limit 20");
	  }
      
 


        if($cfg['qtstyle']=='style9'){
          $list99 = pdo_fetchall("select * from ".tablename($this->modulename."_tbgoods")." where weid='{$weid}' and coupons_end>={$dtime} and price<10 order by {$rand} id desc LIMIT 10");
        }

        $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
        
        $zdylist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=7  order by px desc");//轮播下面菜单
        
            $newslist = pdo_fetchall("select * from ".tablename($this->modulename."_news")." where weid='{$_W['uniacid']}' and pttype=0  order by id desc");//公告


        $style=$cfg['qtstyle'];
        if(empty($style)){
            $style='style1';        
        }
        
//      echo "<pre>";
//      print_r($fzlist);
//      exit;

       include $this->template ( 'tbgoods/style88/index' );