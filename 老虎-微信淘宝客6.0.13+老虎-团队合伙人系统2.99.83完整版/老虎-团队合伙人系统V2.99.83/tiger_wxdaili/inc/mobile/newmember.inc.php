 <?php
 global $_W, $_GPC;
 

         $cfg = $this->module['config'];
	 
	 $fans=$this->islogin();
	 if(empty($fans['tkuid'])){
		$fans = mc_oauth_userinfo();
		if(empty($fans)){
 			$tktzurl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
 			$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
 			header("Location: ".$loginurl); 
 			exit;
		}
		$share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");   
		$fans['tkuid']=$share['id'];  	        
	 }
	         
	 if($cfg['newdltype']==0){
 		$newdltm=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('user'))."";        	  	  	     	  	  	 
		header("Location: ".$newdltm); 
		exit;
	 }
	 if($cfg['newdltype']==1){
 		$newdltm=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('member'))."";        	  	  	     	  	  	 
 		header("Location: ".$newdltm); 
 		exit;
	 }
	         
	         
	         
	 $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");  
	       
	 

	 $wquid=mc_openid2uid($fans['openid']);
	 $helpid=$_GPC['helpid'];
	 $share=$this->getmember($fans,$wquid,$helpid);
	 
	 if($share['dltype']<>1){
 	 			$url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl("dlreg",array('dluid'=>$dluid)));
 	 			header("location:".$url);
 	 			exit;
	 }
	$dldata=pdo_fetch("select * from ".tablename('tiger_wxdaili_dlshuju')." where weid='{$_W['uniacid']}' and uid='{$share['id']}'");  
// 	print_r($dlshuju);
// 	exit;

	if($cfg['qdtype']==1){
		if($share['qdid']==0){
			include IA_ROOT . "/addons/tiger_newhu/inc/fun/tiger.php"; 	
			//$tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
			if(!empty($_SESSION["tksign"])){
				$arr=getqudaolist($_SESSION["tksign"],$_W['uniacid'],1);	
			}	
			//$arr=getqudaolist($tksign['sign'],$_W['uniacid'],1);			
			$rtag="tiger".$share['id'];
			$rid = pdo_fetch("select * from ".tablename("tiger_newhu_qudaolist")." where weid='{$_W['uniacid']}' and rtag='{$rtag}'");
			if(!empty($rid['relation_id'])){
				if(empty($share['tgwid'])){
					$b=pdo_update("tiger_newhu_share",array('qdid'=>$rid['relation_id'],'dlptpid'=>$rid['root_pid'],'tgwid'=>11111), array ('id' =>$share['id']));
				}else{
					$b=pdo_update("tiger_newhu_share",array('qdid'=>$rid['relation_id'],'dlptpid'=>$rid['root_pid']), array ('id' =>$share['id']));
				}				
				$share['qdid']=$rid['relation_id'];
			}else{
				$tksignlist = pdo_fetchall("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE weid='{$_W['uniacid']}'");
				$signleng=count($tksignlist);//几个授权
				$suijisum=rand(0,$signleng-1);//随机数
				if($signleng>0){
					$tksign=$tksignlist[$suijisum];
				}else{
					$tksign=$tksignlist[0];
				}
				$_SESSION["tksign"]=$tksign['sign'];
				$qudaourl=$cfg['qdtgurl']."&rtag=".$rtag;
				//echo $qudaourl;
				$qudaotkl=$this->tkl($qudaourl,"http://img.tigertaoke.com/TB1Uey3uhGYBuNjy0FnXXX5lpXa-750-496.jpg","渠道方备案成功后，可为您进行商品、店铺和更多的物料推广");
			}
		}		
	}

         include $this->template ( 'newmember' );  
         ?>  