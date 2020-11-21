<?php
       global $_W, $_GPC;
      $cfg = $this->module['config'];
      	$dluid=$_GPC['dluid'];
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
		//结束
		if(empty($pid)){
				$pid=$cfg['ptpid'];
		}else{
			$cfg['ptpid']=$pid;
		}
		//echo $pid;
		 $pidSplit=explode('_',$pid);
         $cfg['siteid']=$pidSplit[2];
         $cfg['adzoneid']=$pidSplit[3];
         $memberid=$pidSplit[1];
		if(empty($memberid)){
			$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
		}else{
			$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  memberid='{$memberid}'");
		}
		
        
        
        
        $pic=$_GPC['pic'];
        $title=$_GPC['title'];
        if(empty($pic)){
        	$pic="https://img.alicdn.com/tfs/TB1xdwBIxjaK1RjSZKzXXXVwXXa-440-180.jpg";
        }
        if(empty($title)){
        	$title="2019天猫38女王节-主会场(带超级红包）";
        }
        
        include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
        $hdid=$_GPC['hdid'];
        if(empty($hdid)){
        	$hdid="1551086262817";
        }
        $url=hdlink($hdid,$cfg['adzoneid'],$cfg['siteid'],$tksign['sign'],"");
        $url=$url['msg'];
        $rhyurl=$url;

        $tkl=$this->tkl($rhyurl,$pic,$title);
 
      
       $userAgent = $_SERVER['HTTP_USER_AGENT'];
		if (!strpos($userAgent, 'MicroMessenger')) {
			Header("Location:".$rhyurl); 
		}
		

		if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
		    $sjlx=1;
		}else{
		   $sjlx=2;
		}


       //echo $tkl;

       include $this->template ( 'tbgoods/style99/c11view' );
?>