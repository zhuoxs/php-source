 <?php global $_W, $_GPC;

         $dluid=$_GPC['dluid'];
         $cfg = $this->module['config'];
         load()->model('mc');
         $fans=mc_oauth_userinfo();
         if(empty($fans['openid'])){
            echo '请从微信客户端打开！';
            exit;
         }          
         
          


         //echo $sbegin_time = strtotime(date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y'))));//上个月开始时间
         //echo "<br>";
         //echo $send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
         //exit;

         $openid=$fans['openid'];
         $mc = mc_fetch($openid);
//       echo "<pre>";
//       print_r($mc);
//       exit;
         $uid=$mc['uid'];
         //$uid=mc_openid2uid($fans['openid']);
         if(empty($mc['uid'])){
         	echo '会员表没这个会员，请联系管理员';
         	exit;
         }
//         echo "<pre>";
//         print_r($mc);
//         exit;
         $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
         $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
         if($share['dltype']<>1){
              $url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl("dlreg",array('dluid'=>$dluid)));
              header("location:".$url);
              exit;
         }
         


         //已提现记录
         $txsum = pdo_fetchcolumn("SELECT sum(credit2) FROM " . tablename('tiger_wxdaili_txlog')." where weid='{$_W['uniacid']}' and openid='{$openid}'");//本月本人预估实际佣金
         if(empty($txsum)){
           $txsum="0.00";
         }

         

         $fs=$this->jcbl($share,$bl);//粉丝比例和名称
         $fsbl=$this->tqbl($share,$bl,$cfg);
//       echo "<pre>";
//       print_r($fsbl);
//       exit;
         //自动结算结束
         $day=21;//本月开始第20天开始结算上个月的佣金
         $b_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));//本月开始时间
         $b_jstime=$b_time+86400*($day-1);//结算时间，开始结算上个月的时间
         //$sbegin_time = date('Y-m-d H:i:s',$b_jstime);//上个月开始结算时间    
         //echo $sbegin_time;

         if(time()>$b_jstime){//如果达到结算时间就自动结算
             $yjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and openid='{$openid}' and createtime>{$b_time}");//如果当月有结算记录，就不在结算
             //print_r($yjod);
             //exit;
             if(empty($yjod)){
                if(!empty($openid) && !empty($share['openid'])){
                   $sy_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
                   $data=array(
                       'weid'=>$_W['uniacid'],
                       'type'=>1,
                       'uid'=>$share['id'],
                       'month'=>$sy_time,
                       'openid'=>$openid,
                       'memberid'=>$mc['uid'],//微擎用户ID
                       'nickname'=>$fans['nickname'],
                       'msg'=>date('Y年m月',$sy_time)."月结算佣金，自动结算时间：".date('Y-m-d H:i:s',time()),
                       'createtime'=>time(),
                       'price'=>$fsbl['s1'],
                   );
                   if(!empty($fsbl['s1'])){
                   	  $result=pdo_insert($this->modulename."_yjlog", $data);
                   } 
                   if (!empty($result)) {
                        $odid = pdo_insertid();
                        if(!empty($fsbl['s1'])){
                           $yjsum=$fsbl['s1'];//上月可结算佣金
                           //$uid=mc_openid2uid($share['from_user']);
                           mc_credit_update($mc['uid'],'credit2',$yjsum,array($mc['uid'],$data['msg']."记录ID:".$odid));
                        }
                   }
                }
             }
         }
         //自动结算结束时间

       
         $openid=$fans['openid'];
         $pid=$share['dlptpid'];
         include $this->template ( 'user' );    
         ?> 