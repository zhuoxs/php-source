 <?php global $_W, $_GPC;

         $dluid=$_GPC['dluid'];
         $cfg = $this->module['config'];
         load()->model('mc');
 
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
//      	echo "<pre>";
//      		print_r($fans);
//      		exit;
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
				if($cfg['newdltype']==2){
					$newdltm=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('newmember'))."";        	  	  	     	  	  	 
						header("Location: ".$newdltm); 
						exit;
				}
				
        
        
        
        
        $wquid=mc_openid2uid($fans['openid']);
        $helpid=$_GPC['helpid'];
        $share=$this->getmember($fans,$wquid,$helpid);
        $fans['tkuid']=$share['id'];
   

         
         $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
         if($share['dltype']<>1){
               $url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl("dlreg",array('dluid'=>$dluid)));
               header("location:".$url);
               exit;
         }
         
               

         $openid=$share['from_user'];
         //已提现记录
         $txsum = pdo_fetchcolumn("SELECT sum(credit2) FROM " . tablename('tiger_newhu_txlog')." where weid='{$_W['uniacid']}' and openid='{$openid}'");//本月本人预估实际佣金
         if(empty($txsum)){
           $txsum="0.00";
         }

         

         $fs=$this->jcbl($share,$bl);//粉丝比例和名称
         $fsbl=$this->homeyj($share,$bl,$cfg);
//       echo "<pre>";
//       print_r($fsbl);
//       exit;

         //自动结算结束
//       $day=21;//本月开始第20天开始结算上个月的佣金
//       $b_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));//本月开始时间
//       $b_jstime=$b_time+86400*($day-1);//结算时间，开始结算上个月的时间
//
//       if(time()>$b_jstime){//如果达到结算时间就自动结算
//           $yjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and openid='{$openid}' and createtime>{$b_time}");//如果当月有结算记录，就不在结算
//           if(empty($yjod)){
//              if(!empty($openid) && !empty($share['openid'])){
//                 $sy_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
//                 $data=array(
//                     'weid'=>$_W['uniacid'],
//                     'type'=>1,
//                     'uid'=>$share['id'],
//                     'month'=>$sy_time,
//                     'openid'=>$openid,
//                     'memberid'=>$mc['uid'],//微擎用户ID
//                     'nickname'=>$fans['nickname'],
//                     'msg'=>date('Y年m月',$sy_time)."月结算佣金，自动结算时间：".date('Y-m-d H:i:s',time()),
//                     'createtime'=>time(),
//                     'price'=>$fsbl['s1'],
//                 );
//                 if(!empty($fsbl['s1'])){
//                 	  $result=pdo_insert($this->modulename."_yjlog", $data);
//                 } 
//                 if (!empty($result)) {
//                      $odid = pdo_insertid();
//                      if(!empty($fsbl['s1'])){
//                         $yjsum=$fsbl['s1'];//上月可结算佣金
//                         $this->mc_jl($share['id'],1,11,$yjsum,$data['msg']."记录ID:".$odid,'');
//                      }
//                 }
//              }
//           }
//       }
         //自动结算结束时间
         
         
//       echo "<pre>";
//       print_r($fsbl);
//       exit;

		 $contfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and helpid='{$share['id']}'");//下级粉丝
		 if(empty($contfans)){
		 	$contfans=0;
		 }
		 
		 $dblist = pdo_fetchall("select * from ".tablename("tiger_newhu_cdtype")." where weid='{$_W['uniacid']}' and fftype=2  order by px desc");//自定义菜单
		 
		 
		 if($cfg['qdtype']==1){
		 	if($share['qdid']==0){
		 		include IA_ROOT . "/addons/tiger_newhu/inc/fun/tiger.php"; 	
		 		$tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
		 		$arr=getqudaolist($tksign['sign'],$_W['uniacid']);			
		 		$rtag="tiger".$share['id'];
		 		$rid = pdo_fetch("select * from ".tablename("tiger_newhu_qudaolist")." where weid='{$_W['uniacid']}' and rtag='{$rtag}'");
		 		if(!empty($rid['relation_id'])){
		 			$b=pdo_update("tiger_newhu_share",array('qdid'=>$rid['relation_id']), array ('id' =>$share['id']));
		 		}else{
		 			$qudaourl=$cfg['qdtgurl']."&rtag=".$rtag;
		 			$qudaotkl=$this->tkl($qudaourl,"http://img.tigertaoke.com/TB1Uey3uhGYBuNjy0FnXXX5lpXa-750-496.jpg","渠道方备案成功后，可为您进行商品、店铺和更多的物料推广");
		 		}
		 	}		
		 }

         $openid=$fans['openid'];
         $pid=$share['dlptpid'];
         include $this->template ( 'member' );    
         ?> 