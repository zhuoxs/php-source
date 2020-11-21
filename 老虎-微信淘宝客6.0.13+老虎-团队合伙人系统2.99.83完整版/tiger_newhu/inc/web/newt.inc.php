<?php
       global $_W, $_GPC;
       $type=$_GPC['type'];
       $cfg = $this->module['config'];
       
	    if($_GPC['uid']){
	    	$uid=$_GPC['uid'];
	    }else{
	    	$fans=$this->islogin();
	        if(empty($fans['tkuid'])){
	        	$fans = mc_oauth_userinfo();	        
	        }
	    }
        
		
		//PID绑定
		if(!empty($dluid)){
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$dluid}'");
        }else{
          //$fans=mc_oauth_userinfo();
          $openid=$fans['openid'];
          if(empty($uid)){
          	$zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
          }else{
          	$zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
          }
          
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
       
		$pid=$cfg['ptpid'];
		
		

		
		//$rhyurl="https://mos.m.taobao.com/activity_newer?from=pub&cpsrc=tiger_tiger&pid=".$pid;
		$rhyurl="https://mos.m.taobao.com/activity_newer?from=tool&sight=tiger&pid=".$pid;
		$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/newt/images/newyears.png";
		
		$ddwz=$this->dwzw($rhyurl);

        $tkl=$this->oldtkl($rhyurl,$pic,"迎新年-有心礼！");
        
     
      
       $userAgent = $_SERVER['HTTP_USER_AGENT'];
		if (!strpos($userAgent, 'MicroMessenger')) {
			Header("Location:".$tzurl); 
		}
       
		
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
		    $sjlx=1;
		}else{
		   $sjlx=2;
		}


       //echo $tkl;

       include $this->template ( 'newt' );
?>