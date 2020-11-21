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
   

         
         $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
         if($share['dltype']<>1){
                $url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl("dlreg",array('dluid'=>$dluid)));
                header("location:".$url);
                exit;
         }
         
               

         $openid=$share['from_user'];
         //已提现记录
         

         

         $fs=$this->jcbl($share,$bl);//粉丝比例和名称
         $fsbl=$this->pddtqbl($share,$bl,$cfg);
  

         //自动结算结束
//       $day=21;//本月开始第20天开始结算上个月的佣金
//       $b_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));//本月开始时间
//       $b_jstime=$b_time+86400*($day-1);//结算时间，开始结算上个月的时间
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
         
         //代理结合汇总
         $jssum= pdo_fetchcolumn("SELECT sum(price) FROM " . tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and uid='{$share['id']}'");//本月本人预估实际佣金
         $jssum=number_format($jssum,2,".","");
         if(empty($jssum)){
           $jssum="0.00";
         }
         
         $daytime=strtotime(date("Y-m-d 00:00:00"));//今天0点
         $zttime=strtotime(date("Y-m-d 00:00:00",strtotime("-1 day")));//昨天0点
         
         //今日付款笔数
         $dyaordercount= pdo_fetchcolumn("SELECT count(id) FROM " . tablename('tiger_newhu_pddorder')." where weid='{$_W['uniacid']}' and p_id='{$share['pddpid']}' and order_pay_time>'{$daytime}'"); 
         if(empty($dyaordercount)){
         	$dyaordercount=0;
         }
         //昨日付款笔数
         $zraordercount= pdo_fetchcolumn("SELECT count(id) FROM " . tablename('tiger_newhu_pddorder')." where weid='{$_W['uniacid']}' and p_id='{$share['pddpid']}' and order_pay_time<'{$daytime}' and addtime>'{$zttime}'");
        if(empty($zraordercount)){
         	$zraordercount=0;
         }
        //今日付款佣金
        $jrygsum=$this->pddbryj($share,$daytime,'',3,$bl,$cfg);
        $jrygsum=number_format($jrygsum,2,".","");
        if(empty($jrygsum)){
        	$jrygsum="0.00";
        }
        //昨天付款佣金
        $zrygsum=$this->pddbryj($share,$zttime,$daytime,3,$bl,$cfg);
        $zrygsum=number_format($zrygsum,2,".","");
        if(empty($zrygsum)){
        	$zrygsum="0.00";
        }
        
         
         
         
//       echo "<pre>";
//       print_r($fsbl);
//       exit;
       
         $openid=$fans['openid'];
         $pid=$share['dlptpid'];
         if($cfg['newdlxjtype']==1){
         	include $this->template ( 'pdddlshouyi1' );   
         }else{
         	include $this->template ( 'pdddlshouyi' );   
         }
          
         ?> 