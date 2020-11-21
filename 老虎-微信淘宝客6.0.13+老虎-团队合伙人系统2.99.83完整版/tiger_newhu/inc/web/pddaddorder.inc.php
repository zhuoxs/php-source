<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        $ajax=$_GPC['ajax'];
        $op=$_GPC['op'];
        $fans = $_W['fans'];
        $orderid=trim($_GPC['code']);
        $dluid=$_GPC['dluid'];//share id
        $pid=$_GPC['pid'];
        
        
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
       	  	  	 header("Location: ".$loginurl); 
       	  	  	 exit;
	        }	        
        }
        $mc=mc_fetch($fans['openid']);
        $member=$this->getmember($fans,$mc['uid']);
        



        if($ajax=='ajax'){   
        	
        	$member=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and id='{$_GPC['uid']}'");//当前粉丝信息   
        	if(empty($member['id'])){
        		die(json_encode(array("statusCode"=>100,'msg'=>'会员数据异常！请稍后在试！')));  
        	}
        	
            if(pdo_tableexists('tiger_wxdaili_set')){
               $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
               if($bl['dlfxtype']==1){
                   if($member['dltype']==1){
                     die(json_encode(array("statusCode"=>100,'msg'=>'对不起!代理不能提交订单!')));  
                   }                  
                }
            }
            
            //die(json_encode(array("statusCode"=>100,'msg'=>$orderid)));  
            
            $order = pdo_fetch("select * from ".tablename($this->modulename."_pddtjorder")." where weid='{$_W['uniacid']}' and orderid='{$orderid}'");
            //die(json_encode(array("statusCode"=>100,'msg'=>$orderid)));  
            if(empty($order)){
                //查询淘客订单库
                $tkorder = pdo_fetch("select * from ".tablename($this->modulename."_pddorder")." where weid='{$_W['uniacid']}' and order_sn='{$orderid}'");
                if($cfg['dlddfx']==1){
                	$dltgw=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and pddpid='{$tkorder['p_id']}'");
                	if(!empty($dltgw)){
                		die(json_encode(array("statusCode"=>100,'msg'=>'对不起!该订单不支持奖励,请联系管理员!')));  
                	}
                }
                
                
                
                if(!empty($tkorder)){
                   if($tkorder['order_status']==4){//审核失败（不可提现）
                      $sh=4;//失效
                      die(json_encode(array("statusCode"=>100,'msg'=>'您提交的订单已退款！')));  
                   }elseif($tkorder['order_status']==1){//已成团，付款成功
                      $sh=3;//已审核
                   }elseif($tkorder['order_status']==2){//确认收货
                      $sh=1;//待返
                   }
                   //$credit2_zg=$tkorder['xgyg']*$cfg['zgf']/100;

                }else{
                  die(json_encode(array("statusCode"=>100,'msg'=>'您提交的订单暂未更新，请过15分钟后在提交，感谢您的支持！')));  
                  $sh=0;//待审核
                }
                if($cfg['fxtype']==1){//积分
                	$jltype=0;
                }elseif($cfg['fxtype']==2){//余额
                    $jltype=1;
                }
                
                if($cfg['fxtype']==1){//自购积分
                	if($cfg['gdfxtype']==1){
                		$jl=$cfg['zgf'];
                	}else{
                		$jl=intval($tkorder['promotion_amount']*$cfg['zgf']/100*$cfg['jfbl']);
                	}                	
                }elseif($cfg['fxtype']==2){//自购余额
                	if($cfg['gdfxtype']==1){
                		 $jl=$cfg['zgf'];
                	}else{
                		 $jl=$tkorder['promotion_amount']*$cfg['zgf']/100;  
                   		 $jl=number_format($jl, 2, '.', '');
                	}                    
                }                
                $data=array(
                    'weid'=>$_W['uniacid'],
                    'openid'=>$member['from_user'],
                    'memberid'=>$member['openid'],
                    'uid'=>$member['id'],
                    'nickname'=>$member['nickname'],
                    'avatar'=>$member['avatar'],
                    'orderid'=>$orderid,
                    'itemid'=>$tkorder['goods_id'],
                    'jl'=>$jl,
                    'jltype'=>$jltype,
                    'sh'=>$sh,
                    'yongjin'=>$tkorder['promotion_amount'],//佣金
                    'type'=>0,
                    'createtime'=>TIMESTAMP
                );

                if (pdo_insert ( $this->modulename . "_pddtjorder", $data ) === false) {
					die(json_encode(array("statusCode"=>100,'msg'=>'系统繁忙！')));  
				} else{
					
                   $member=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");//当前粉丝信息
                   $zgtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['zgtxmsg']);
                   $zgtxmsg=str_replace('#订单号#',$orderid, $zgtxmsg);
                   $zgtxmsg=str_replace('#金额#',$jl, $zgtxmsg);
                   $this->postText($member['from_user'],$zgtxmsg);//自购提示
                   if(!empty($member['helpid'])){//一级
                      
                      if(pdo_tableexists('tiger_wxdaili_set')){//是否开启代理订单不返给二级
                          $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
                          if(empty($bl['dlyjfltype'])){
                             $tgw=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and tgwid='{$tkorder['tgwid']}'");//有没有代理推广位
                                   if(!empty($tgw)){
                                         if(!empty($cfg['khgetorder'])){//管理员订单提交提醒
                                            $mbid=$cfg['khgetorder'];
                                            $mb=pdo_fetch("select * from ".tablename($this->modulename."_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
                                            //file_put_contents(IA_ROOT."/addons/tiger_renwubao/log.txt","\n 1old:".json_encode($orderid),FILE_APPEND);
                                            $msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,$orderid);                  
                                         }
                                         die(json_encode(array("statusCode"=>200,'msg'=>'')));//有代理的推广位就提交成功
                                   }
                          }
                      }
                       



                       
                       //插入一级订单
                           if(!empty($cfg['yjf'])){
                               //$credit2_yj=$tkorder['xgyg']*$cfg['yjf']/100;
                               //$ejprice=$cfg['yjf']*$credit2_yj/100;
                                    if($cfg['fxtype']==1){//自购积分
                                    	if($cfg['gdfxtype']==1){
					                		 $jl=$cfg['yjf'];
					                	}else{
					                		$jl=intval($tkorder['promotion_amount']*$cfg['yjf']/100*$cfg['jfbl']);
					                	}					                	
					                }elseif($cfg['fxtype']==2){//自购余额
					                	if($cfg['gdfxtype']==1){
					                		 $jl=$cfg['yjf'];
					                	}else{
					                		$jl=$tkorder['promotion_amount']*$cfg['yjf']/100;  
                                       	    $jl=number_format($jl, 2, '.', '');
					                	}					                    
					                }
					               $yjmember=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and id='{$member['helpid']}' order by id desc");
			                       $yjtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['yjtxmsg']);
			                       $yjtxmsg=str_replace('#订单号#',$orderid, $yjtxmsg);
			                       $yjtxmsg=str_replace('#金额#',$jl, $yjtxmsg);
			                       $this->postText($yjmember['from_user'],$yjtxmsg);//一级提示
                                   $data2=array(
                                        'weid'=>$_W['uniacid'],
                                        'openid'=>$yjmember['from_user'],
                                        'memberid'=>$yjmember['openid'],//用户UID
                                        'uid'=>$yjmember['id'],
                                        'nickname'=>$yjmember['nickname'],
                                        'jl'=>$jl,
                                        'jltype'=>$jltype,
                                        'avatar'=>$yjmember['avatar'],
                                            'jluid'=>$member['id'],
                                            'jlnickname'=>$member['nickname'],
                                            'jlavatar'=>$member['avatar'],
                                        'orderid'=>$orderid,
                                        'itemid'=>$tkorder['goods_id'],
                                        'yongjin'=>$tkorder['promotion_amount'],
                                        'type'=>1,
                                        'sh'=>$sh,
                                        'createtime'=>TIMESTAMP
                                    );                    
                                    
                                    
                                    $order = pdo_fetchall("select * from ".tablename($this->modulename."_pddtjorder")." where weid='{$_W['uniacid']}' and type=1 and orderid={$orderid}");
                                    if(empty($order)){
                                        pdo_insert ( $this->modulename . "_pddtjorder", $data2 );//添加一级订单
                                    }
                                   
                             }
                       //一级订单结束

                       if(!empty($yjmember['helpid'])){//二级
                           
                           //二级订单添加
                                 if(!empty($cfg['ejf'])){
                                     //$ejfprice=$tkorder['xgyg']*$cfg['ejf']/100;
                                     if($cfg['fxtype']==1){//自购积分
                                     	if($cfg['gdfxtype']==1){
					                		 $jl=$cfg['ejf'];
					                	}else{
					                		$jl=intval($tkorder['promotion_amount']*$cfg['ejf']/100*$cfg['jfbl']);
					                	}					                	
					                }elseif($cfg['fxtype']==2){//自购余额
					                	if($cfg['gdfxtype']==1){
					                		 $jl=$cfg['ejf'];
					                	}else{
					                		 $jl=$tkorder['promotion_amount']*$cfg['ejf']/100;  
                                       		 $jl=number_format($jl, 2, '.', '');
					                	}					                    
					                }
					               $rjmember=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and id='{$yjmember['helpid']}' order by id desc");
		                           $ejtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['ejtxmsg']);
		                           $ejtxmsg=str_replace('#订单号#',$orderid, $ejtxmsg);
		                           $ejtxmsg=str_replace('#金额#',$jl, $ejtxmsg);
		                           $this->postText($rjmember['from_user'],$ejtxmsg);//二级提示
                                     $data3=array(
                                        'weid'=>$_W['uniacid'],
                                        'openid'=>$rjmember['from_user'],
                                        'memberid'=>$rjmember['openid'],//用户openid
                                        'uid'=>$rjmember['id'],//用户openid                                        
                                        'nickname'=>$rjmember['nickname'],
                                        'jl'=>$jl,
                                        'jltype'=>$jltype,
                                        'avatar'=>$rjmember['avatar'],
                                            'jluid'=>$member['id'],
                                            'jlnickname'=>$member['nickname'],
                                            'jlavatar'=>$member['avatar'],
                                        'orderid'=>$orderid,
                                        'itemid'=>$tkorder['goods_id'],
                                        'yongjin'=>$tkorder['promotion_amount'],
                                        'type'=>2,
                                         'sh'=>$sh,
                                        'createtime'=>TIMESTAMP
                                    );
                                    $order = pdo_fetchall("select * from ".tablename($this->modulename."_pddtjorder")." where weid='{$_W['uniacid']}' and type=2 and orderid={$orderid}");
                                    if(empty($order)){
                                        pdo_insert ( $this->modulename . "_pddtjorder", $data3 );//添加二级订单
                                    }
                                 }
                           //二级订单结束


                       }
                   }
                   if(!empty($cfg['khgetorder'])){//管理员订单提交提醒
                        $mbid=$cfg['khgetorder'];
                        $mb=pdo_fetch("select * from ".tablename($this->modulename."_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
                        //file_put_contents(IA_ROOT."/addons/tiger_renwubao/log.txt","\n 1old:".json_encode($orderid),FILE_APPEND);
                        $msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,$orderid);                  
                    }

					die(json_encode(array("statusCode"=>200,'msg'=>'')));  
				}
            }else{
              die(json_encode(array("statusCode"=>100,'msg'=>'您提交的订单已经记录！')));  
            }
        }
         $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单

        include $this->template ( 'user/pddaddorder' );      