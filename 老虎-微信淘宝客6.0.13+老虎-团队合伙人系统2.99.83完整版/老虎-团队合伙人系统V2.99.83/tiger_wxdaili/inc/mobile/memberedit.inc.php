 <?php global $_W, $_GPC;

         $dluid=$_GPC['dluid'];
         $cfg = $this->module['config'];
         $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
       	  	  	 header("Location: ".$loginurl); 
       	  	  	 exit;
	        }
	        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");   
	        $fans['tkuid']=$share['id'];  	        
        }
        $wquid=mc_openid2uid($fans['openid']);
        $helpid=$_GPC['helpid'];
        $share=$this->getmember($fans,$wquid,$helpid);
        $fans['tkuid']=$share['id'];

         include $this->template ( 'memberedit' );    
         ?> 