 <?php global $_W, $_GPC;

         $dluid=$_GPC['dluid'];
         $cfg = $this->module['config'];
         load()->model('mc');
 
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();

	        if(empty($fans)){
// 						$tktzurl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
// 	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
//        	  	  	 header("Location: ".$loginurl); 
//        	  	  	 exit;
	        }
	        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");   
	        $fans['tkuid']=$share['id'];  	        
        }

        
        
        $wquid=mc_openid2uid($fans['openid']);
        $helpid=$_GPC['helpid'];
        $share=$this->getmember($fans,$wquid,$helpid);
        $fans['tkuid']=$share['id'];
         $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
         if($share['dltype']<>1){
//                 $url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl("dlreg",array('dluid'=>$dluid)));
//                 header("location:".$url);
//                 exit;
         }
         
         $datime=time();
         
         if($share['tzendtime']<$datime){
         	$dldata=array(
			    'helpid'=>0,
				'tztype'=>0,//1是团长
				'tzpaytime'=>'',
				'tztime'=>'',
				'tzendtime'=>''
			);		
			pdo_update("tiger_newhu_share", $dldata, array('weid' => $_W['uniacid'],'id'=>$share['id']));
         }
         
               

         $openid=$share['from_user'];
         //已提现记录
         $txsum = pdo_fetchcolumn("SELECT sum(credit2) FROM " . tablename('tiger_newhu_txlog')." where weid='{$_W['uniacid']}' and openid='{$openid}'");
         if(empty($txsum)){
            $txsum="0.00";
         }         

				 $contfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1 and helpid='{$share['id']}'");//下级粉丝 代理
				 if(empty($contfans)){
					  $contfans=0;
				 }
				 
				 $appset= pdo_fetch("SELECT * FROM " . tablename("tiger_app_tuanzhangset") . " WHERE weid='{$_W['uniacid']}' order by px desc ");//团长设置
				 
				 $b_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));//本月开始时间
				 $sy_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
								 
				 
//				 $byyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where tgwid in (select tgwid from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and dltype=1 and helpid='{$share['id']}') and addtime>'{$b_time}' and orderzt<>'订单失效' and weid='{$_W['uniacid']}' and addtime>'{$share['tztime']}'");
//				 if(empty($byyj)){
//					 $byyj="0.00";
//				 }else{
//					 $byyj=number_format($byyj*$appset['jl']/100, 2, '.', '');
//				 }
//				 
//				 $syyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where tgwid in (select tgwid from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and dltype=1 and helpid='{$share['id']}') and jstime<='{$b_time}' and jstime>='{$sy_time}' and orderzt<>'订单失效' and weid='{$_W['uniacid']}' and addtime>'{$share['tztime']}'");
//				 if(empty($syyj)){
//					 $syyj="0.00";
//				 }else{
//					 $syyj=number_format($syyj*$appset['jl']/100, 2, '.', '');
//				 }

				$tzyjlog= pdo_fetch("SELECT * FROM " . tablename("tiger_wxdaili_tzyjlog") . " WHERE weid='{$_W['uniacid']}' and uid='{$share['id']}' order by id desc ");//团长佣金
// 				echo "<pre>";
// 				print_r($tzyjlog);
// 				exit;
				
				 
				 

		 
		 // $dblist = pdo_fetchall("select * from ".tablename("tiger_newhu_cdtype")." where weid='{$_W['uniacid']}' and fftype=2  order by px desc");//自定义菜单

         $openid=$fans['openid'];
         $pid=$share['dlptpid'];
         include $this->template ( 'tz/tzmember' );    
         ?> 