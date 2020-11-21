 <?php     global $_W, $_GPC;
        $dluid=$_GPC['dluid'];
         $cfg = $this->module['config'];
         load()->model('mc');
         $fans=mc_oauth_userinfo();
         if(empty($fans['openid'])){
            echo '请从微信客户端打开！';
           // exit;
         }  
         //结算时间
         $day=21;//本月开始第20天开始结算上个月的佣金
         $b_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));//本月开始时间
         $b_jstime=$b_time+86400*($day-1);//结算时间，开始结算上个月的时间
         $sbegin_time = date('Y-m-d H:i:s',$b_jstime);//上个月开始结算时间    
         //结算时间结束
         $openid=$fans['openid'];
         $mc = mc_fetch($openid);//credit2
         $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
         //echo '<pre>';
         //print_r($mc);

         if($_W['isajax']){
             $pric=$_GPC['money'];
             if($cfg['txxzprice']>$pric){
                exit(json_encode(array('error' =>2,'message'=>'最低提现金额：'.$cfg['txxzprice']."元才能提现！")));
             }



             if($pric>$mc['credit2']){
               exit(json_encode(array('error' =>2,'message'=>'提现金额不得大于可用余额')));
             }else{
               //if(empty($share['zfbuid'])){
               //  exit(json_encode(array('error' =>2,'message'=>'请联系管理员绑定支付宝帐号')));
               //}
               $data=array(
                   'weid'=>$_W['uniacid'],
                   'nickname'=>$fans['nickname'],
                   'openid'=>$fans['openid'],
                   'avatar'=>$fans['avatar'],
                   'credit2'=>$pric,
                   'zfbuid'=>$share['zfbuid'],
                   'sh'=>0,
                   'createtime'=>TIMESTAMP
               );
                 
               if(!empty($fans['openid'])){
                  $uid=mc_openid2uid($fans['openid']);
                  mc_credit_update($uid,'credit2',-$pric,array($uid,'dl佣金提现'));
                  pdo_insert($this->modulename."_txlog", $data);
               }
               exit(json_encode(array('error' =>0,'message'=>'提现成功')));
             }
         }

        include $this->template ( 'tx' ); 
        ?>