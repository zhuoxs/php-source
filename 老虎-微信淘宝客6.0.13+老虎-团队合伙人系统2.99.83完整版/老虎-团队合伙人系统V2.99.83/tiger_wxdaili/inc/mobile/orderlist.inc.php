 <?php
 global $_W, $_GPC;
               
         $id=$_GPC['id'];//share id
         $dd=$_GPC['dd'];
         $zt=$_GPC['zt'];
         $cfg = $this->module['config'];
         load()->model('mc');
//         $fans=mc_oauth_userinfo();
//         $openid=$fans['openid'];
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
         if(!empty($id)){
           $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$id}'");
         }else{
           
           $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
         }
         
        // {"error":0,"message":""}
         include $this->template ( 'orderlist' );    
         ?>