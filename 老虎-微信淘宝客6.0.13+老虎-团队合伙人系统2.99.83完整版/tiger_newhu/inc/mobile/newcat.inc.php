<?php
global $_GPC,$_W;
		$cfg = $this->module['config'];
		$lm=$cfg['mmtype'];
		$zt=$_GPC['zt'];
		$weid=$_W['uniacid'];
		$px=$_GPC['px'];
		$type=$_GPC['type'];
		$tm=$_GPC['tm'];
		$price1=$_GPC['price1'];
		$price2=$_GPC['price2'];
		$hd=$_GPC['hd'];
		$page=$_GPC['page'];
		$key=trim($_GPC['key']);
		$dlyj=$_GPC['dlyj'];
		$dluid=$_GPC['dluid'];
		$pid=$_GPC['pid'];
        $rate=$cfg['zgf'];
        $key=str_replace("搜索","",$key);
		$key=str_replace(" ","",$key);

        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();        
        }

		
		
		
		$dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
		//PID绑定
		if(!empty($dluid)){
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$dluid}'");
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
        }else{
           if($share['dlptpid']){
               if(!empty($share['dlptpid'])){
                 $cfg['ptpid']=$share['dlptpid'];
                 $cfg['qqpid']=$share['dlqqpid'];
               }       
            }
        }
		//结束
		if(empty($pid)){
        	$pid=$cfg['ptpid'];
	    }else{
	    	$cfg['ptpid']=$pid;
	    }
		include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 

        if(!empty($cfg['gyspsj'])){
           $weid=$cfg['gyspsj'];
         }
		
		if($lm==2){
			$fzlist=getclass($_W,$cfg['ptpid'],'');
		}else{
			$fzlist = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$weid}'  order by px desc");
		}
		if(!empty($zt)){//专题图片
           $ztview=pdo_fetch("select * from ".tablename('tiger_newhu_zttype')." where weid='{$weid}' and id='{$zt}'");  
        }
        
//      echo "<pre>";
//      print_r($zxshare);
//      exit;
        
    
		$dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单

		include $this->template ( 'tbgoods/style88/newcat' );  
?>