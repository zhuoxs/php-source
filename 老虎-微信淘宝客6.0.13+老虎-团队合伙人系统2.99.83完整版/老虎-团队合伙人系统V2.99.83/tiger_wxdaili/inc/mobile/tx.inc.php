 <?php     global $_W, $_GPC;
        $dluid=$_GPC['dluid'];
         $cfg = $this->module['config'];
         load()->model('mc');
//         $fans=mc_oauth_userinfo();
//         if(empty($fans['openid'])){
//            echo '请从微信客户端打开！';
//           // exit;
//         }  
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
       	  	  	 header("Location: ".$loginurl); 
       	  	  	 exit;
	        }	  
	        $fans=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");        
        }
         //结算时间
         $day=21;//本月开始第20天开始结算上个月的佣金
         $b_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));//本月开始时间
         $b_jstime=$b_time+86400*($day-1);//结算时间，开始结算上个月的时间
         $sbegin_time = date('Y-m-d H:i:s',$b_jstime);//上个月开始结算时间    
         //结算时间结束
         $openid=$fans['openid'];
         $mc = mc_fetch($openid);//credit2
         $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$fans['id']}'");
         //echo '<pre>';
         //print_r($mc);

         if($_W['isajax']){
             $pric=$_GPC['money'];
             if($cfg['txxzprice']>$pric){
                exit(json_encode(array('error' =>2,'message'=>'最低提现金额：'.$cfg['txxzprice']."元才能提现！")));
             }



             if($pric>$share['credit2']){
               exit(json_encode(array('error' =>2,'message'=>'提现金额不得大于可用余额')));
             }else{
               //if(empty($share['zfbuid'])){
               //  exit(json_encode(array('error' =>2,'message'=>'请联系管理员绑定支付宝帐号')));
               //}

               $data=array(
	                'weid'=>$_W['uniacid'],
	                'uid'=>$share['id'],
	                'nickname'=>$share['nickname'],
	                'openid'=>$share['from_user'],
	                'avatar'=>$share['avatar'],
	                'createtime'=>TIMESTAMP,
	                'credit2'=>$pric,
	                'zfbuid'=>$share['zfbuid'],
	                'sh'=>0	                
	            );
                 
               if(!empty($share['from_user'])){
                  //$uid=mc_openid2uid($share['from_user']);
                  
                    if(!empty($cfg['khgettx'])){//管理员提现提醒
	                    $mbid=$cfg['khgettx'];
	                    $mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
	                     $valuedata=array(
				             'rmb'=>$pric,
				             'txzhanghao'=>$share['zfbuid'],//提现支付帐帐号
				             'msg'=>'',
				             'tel'=>$share['tel'],
				             'weixin'=>$share['weixin'],
				             'shenhe'=>'',//'审核通过|审核不通过|资料有误请重新提交审核',
				             'goodstitle'=>''//'积分商城，商品名称'
				         );
	                    $msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,'',$cfg,$valuedata);                  
	                }
                
                  //mc_credit_update($uid,'credit2',-$pric,array($uid,'dl佣金提现'));
                  $this->mc_jl($share['id'],1,7,-$pric,'dl佣金提现','');
                  pdo_insert("tiger_newhu_txlog", $data);
               }
               exit(json_encode(array('error' =>0,'message'=>'提现成功')));
             }
         }

        include $this->template ( 'tx' ); 
        ?>