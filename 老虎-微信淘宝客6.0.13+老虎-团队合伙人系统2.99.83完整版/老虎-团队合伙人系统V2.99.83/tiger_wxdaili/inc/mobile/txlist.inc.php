 <?php global $_W, $_GPC;
          $cfg = $this->module['config'];
          $type=$_GPC['type'];
          load()->model('mc');
//          $fans=mc_oauth_userinfo();
//          if(empty($fans['openid'])){
//            echo '请从微信客户端打开！';
//            exit;
//          }
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
         $zt=$_GPC['zt'];

         if($zt==1){
           $where=" and sh<>1";
         }elseif($zt==2){
           $where=" and sh=1";
         }
         if($type==1){
         	$txlog='tiger_wxdaili_txlog';
         }else{
         	$txlog='tiger_newhu_txlog';
         }

         
         $txlist=pdo_fetchall("select * from ".tablename($txlog)." where weid='{$_W['uniacid']}' {$where} and openid='{$openid}' order by id desc limit 100");
         


        include $this->template ( 'txlist' ); 
        ?>