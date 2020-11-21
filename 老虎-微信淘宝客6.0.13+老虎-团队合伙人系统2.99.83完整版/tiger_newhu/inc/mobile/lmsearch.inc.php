<?php
global $_W, $_GPC;
$cfg = $this->module['config'];
       $pid=$_GPC['pid'];        
       $dluid=$_GPC['dluid'];       
       $lm=$cfg['mmtype'];
       $weid=$_W['uniacid'];
        if(!empty($cfg['gyspsj'])){
          $weid=$cfg['gyspsj'];
        }
        
        if(!empty($dluid)){
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$dluid}'");
        }else{
          $fans=mc_oauth_userinfo();
          
          $openid=$fans['openid'];
          $zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        }
        if($zxshare['dltype']==1){
            if(!empty($zxshare['dlptpid'])){
               $cfg['ptpid']=$zxshare['dlptpid'];
               $cfg['qqpid']=$zxshare['dlqqpid'];
            }
            
        }else{
           if(!empty($zxshare['helpid'])){//查询有没有上级
                 $sjshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1 and id='{$zxshare['helpid']}'");           
            }
        }
        

        if(!empty($sjshare['dlptpid'])){
            if(!empty($sjshare['dlptpid'])){
              $cfg['ptpid']=$sjshare['dlptpid'];
              $cfg['qqpid']=$sjshare['dlqqpid'];
            }   
            $dlewm="http://pan.baidu.com/share/qrcode?w=150&h=150&url=".$sjshare['url'];
        }else{
           if($share['dlptpid']){
               if(!empty($share['dlptpid'])){
                 $cfg['ptpid']=$share['dlptpid'];
                 $cfg['qqpid']=$share['dlqqpid'];
               }       
               $dlewm="http://pan.baidu.com/share/qrcode?w=150&h=150&url=".$share['url'];
            }
        }
        if(empty($pid)){
        	$pid=$cfg['ptpid'];
	    }else{
	    	$cfg['ptpid']=$pid;
	    }
	    include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
	    
	    
	    if($lm==2){//云商品库
        	$fzlist=getclass($_W,$cfg['ptpid'],10,1);//首页8个分类
	    }else{
	    	$fzlist1 = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$weid}'  order by px desc limit 10");
	    	$fzlist=array();
	    	 foreach($fzlist1 as $k=>$v){
	    	 	$fzlist[$k]['id']=$v['id']; 
	    	 	$fzlist[$k]['title']=$v['title']; 
	    	 	$fzlist[$k]['picurl']=$v['picurl2']; 	    	 	
	    	 }
	    }

      
       $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单

       $ad = pdo_fetchall("SELECT * FROM " . tablename($this->modulename.'_ad') . " WHERE weid = '{$_W['weid']}' order by id desc");
       
       if(!empty($cfg['serackkey'])){
       	  $keyarr=explode("|",$cfg['serackkey']);
       }
       
       if($cfg['cjsszn']==1){
       		$zn=1;
       }
       
       
       
       //$goods=gettjlist(1,11,'','',$cfg);
       $goodstj=gettjlist(1,12,'','',$cfg);

      if($cfg['cjsstypesy']==1){
      	$goods = pdo_fetchall("SELECT * FROM " . tablename($this->modulename.'_newtbgoods')." where weid='{$weid}' and  qf=1 limit 11");
        $goodstj = pdo_fetchall("SELECT * FROM " . tablename($this->modulename.'_newtbgoods')." where weid='{$weid}' order by id desc limit 11");
      	include $this->template ( 'lmsearch1' );   
      }else{
      	include $this->template ( 'lmsearch' );   
      }
        
?>