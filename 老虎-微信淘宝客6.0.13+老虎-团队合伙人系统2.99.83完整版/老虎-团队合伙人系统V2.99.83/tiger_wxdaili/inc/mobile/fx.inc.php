 <?php
 global $_W, $_GPC;
         $cfg = $this->module['config'];
         load()->model('mc');
//         $fans=mc_oauth_userinfo();
//         if(empty($fans['openid'])){
//            echo '请从微信客户端打开！';
//            exit;
//         }
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
       	  	  	 header("Location: ".$loginurl); 
       	  	  	 exit;
	        }	        
        }
         $openid=$fans['openid'];
         $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
		 $img=$_W['siteroot']."/addons/tiger_newhu/qrcode/mposter". $share['id'].".jpg";
	
		
         //$emw="http://bshare.optimix.asia/barCode?site=weixin&url=".urlencode($share['url']);

         include $this->template ( 'fx' );  
         ?>  