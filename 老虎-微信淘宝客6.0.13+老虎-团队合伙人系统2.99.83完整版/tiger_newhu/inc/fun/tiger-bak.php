<?php
//淘宝订单提交
function tbaddorder($cfg,$_W,$member,$orderid){//淘宝 普通用户提交订单
// 		$zgtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['zgtxmsg']);
// 		$zgtxmsg=str_replace('#订单号#',$orderid, $zgtxmsg);
// 		$zgtxmsg=str_replace('#金额#',$jl, $zgtxmsg);
// 		postkefuxiaoxi($cfg,$_W,$member['from_user'],$zgtxmsg);

// 		$mbid=$cfg['khgetorder'];
// 		$mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
// 		postmobanxiaoxi($cfg,$_W,$member['from_user'],$mb['id'],$orderid);
// 		exit;

	if(empty($member['id'])){
		return array("error"=>1,'msg'=>'会员数据异常！请稍后在试！'); 
	}
	
	
	if(pdo_tableexists('tiger_wxdaili_set')){
		$bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
		if($bl['dlfxtype']==1){
				if($member['dltype']==1){
					return array("error"=>1,'msg'=>'对不起!代理不能提交订单!');
				}                  
			}
	}
	
	$order = pdo_fetch("select * from ".tablename("tiger_newhu_order")." where weid='{$_W['uniacid']}' and orderid='{$orderid}'");
	
if(empty($order)){
//查询淘客订单库
		$tkorder = pdo_fetch("select * from ".tablename("tiger_newhu_tkorder")." where weid='{$_W['uniacid']}' and orderid='{$orderid}'");
		if($cfg['dlddfx']==1){
			$dltgw=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and tgwid='{$tkorder['tgwid']}'");
			if(!empty($dltgw)){
				return array("error"=>1,'msg'=>'对不起!该订单不支持奖励,请联系管理员!');
			}
		}
	if(empty($member['tbsbuid6'])){
		$tbsbuid6=substr($orderid,-6);
		$ups=array('tbsbuid6'=>$tbsbuid6);
		$b=pdo_update("tiger_newhu_share",$ups, array ('id' =>$member['id'],'weid'=>$_W['uniacid']));
	}



	if(!empty($tkorder)){
		if($tkorder['orderzt']=='订单失效'){
			$sh=4;//失效
			return array("error"=>1,'msg'=>'您提交的订单已退款');
		}elseif($tkorder['orderzt']=='订单付款'){
			$sh=3;//已审核
		}elseif($tkorder['orderzt']=='订单结算'){
			$sh=1;//待返
		}
	}else{
		return array("error"=>1,'msg'=>'您提交的订单暂未更新，请过15分钟后在提交，感谢您的支持！');
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
			$jl=intval($tkorder['xgyg']*$cfg['zgf']/100*$cfg['jfbl']);
		}                	
	}elseif($cfg['fxtype']==2){//自购余额
		if($cfg['gdfxtype']==1){
			$jl=$cfg['zgf'];
		}else{
			$jl=$tkorder['xgyg']*$cfg['zgf']/100;  
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
		'itemid'=>$tkorder['numid'],
		'jl'=>$jl,
		'jltype'=>$jltype,
		'sh'=>$sh,
		'yongjin'=>$tkorder['xgyg'],//佣金
		'type'=>0,
		'createtime'=>TIMESTAMP
	);

	if (pdo_insert ("tiger_newhu_order", $data ) === false) {
		return array("error"=>1,'msg'=>'系统繁忙、数据有错误！');
	}else{
		//$member=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and from_user='{$member['openid']}'");//当前粉丝信息
		$zgtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['zgtxmsg']);
		$zgtxmsg=str_replace('#订单号#',$orderid, $zgtxmsg);
		$zgtxmsg=str_replace('#金额#',$jl, $zgtxmsg);
		postkefuxiaoxi($cfg,$_W,$member['from_user'],$zgtxmsg);
		//$this->postText($member['from_user'],$zgtxmsg);//自购提示
		
	if(!empty($member['helpid'])){//一级

		if(pdo_tableexists('tiger_wxdaili_set')){//是否开启代理订单不返给二级
			$bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
			if(empty($bl['dlyjfltype'])){
				$tgw=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and tgwid='{$tkorder['tgwid']}'");//有没有代理推广位
				if(!empty($tgw)){
					if(!empty($cfg['khgetorder'])){//管理员订单提交提醒
						$mbid=$cfg['khgetorder'];
						$mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
						//$msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,$orderid);   
						postmobanxiaoxi($cfg,$_W,$cfg['glyopenid'],$mb['id'],$orderid,$member['from_user']);							 
					}
				   return array("error"=>0,'msg'=>'订单提交成功！');//有代理的推广位就提交成功
				}
			}
		}

			//插入一级订单
			if(!empty($cfg['yjf'])){
				if($cfg['fxtype']==1){//自购积分
					if($cfg['gdfxtype']==1){
						$jl=$cfg['yjf'];
					}else{
						$jl=intval($tkorder['xgyg']*$cfg['yjf']/100*$cfg['jfbl']);
					}					                	
				}elseif($cfg['fxtype']==2){//自购余额
					if($cfg['gdfxtype']==1){
						$jl=$cfg['yjf'];
					}else{
						$jl=$tkorder['xgyg']*$cfg['yjf']/100;  
						$jl=number_format($jl, 2, '.', '');
					}					                    
				}
				$yjmember=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and id='{$member['helpid']}' order by id desc");
				$yjtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['yjtxmsg']);
				$yjtxmsg=str_replace('#订单号#',$orderid, $yjtxmsg);
				$yjtxmsg=str_replace('#金额#',$jl, $yjtxmsg);
				//$this->postText($yjmember['from_user'],$yjtxmsg);//一级提示
				postkefuxiaoxi($cfg,$_W,$yjmember['from_user'],$yjtxmsg);
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
					'itemid'=>$tkorder['numid'],
					'yongjin'=>$tkorder['xgyg'],
					'type'=>1,
					'sh'=>$sh,
					'createtime'=>TIMESTAMP
				);
				$order = pdo_fetchall("select * from ".tablename("tiger_newhu_order")." where weid='{$_W['uniacid']}' and type=1 and orderid={$orderid}");
				if(empty($order)){
					pdo_insert ("tiger_newhu_order", $data2 );//添加一级订单
				}
			}
			//一级订单结束
			//二级订单添加
			if(!empty($yjmember['helpid'])){//二级			
				if(!empty($cfg['ejf'])){
						if($cfg['fxtype']==1){//自购积分
							if($cfg['gdfxtype']==1){
								$jl=$cfg['ejf'];
							}else{
								$jl=intval($tkorder['xgyg']*$cfg['ejf']/100*$cfg['jfbl']);
							}					                	
						}elseif($cfg['fxtype']==2){//自购余额
							if($cfg['gdfxtype']==1){
							$jl=$cfg['ejf'];
						}else{
							$jl=$tkorder['xgyg']*$cfg['ejf']/100;  
							$jl=number_format($jl, 2, '.', '');
						}					                    
					}
					$rjmember=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and id='{$yjmember['helpid']}' order by id desc");
					$ejtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['ejtxmsg']);
					$ejtxmsg=str_replace('#订单号#',$orderid, $ejtxmsg);
					$ejtxmsg=str_replace('#金额#',$jl, $ejtxmsg);
					//$this->postText($rjmember['from_user'],$ejtxmsg);//二级提示
					postkefuxiaoxi($cfg,$_W,$rjmember['from_user'],$ejtxmsg);
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
						'itemid'=>$tkorder['numid'],
						'yongjin'=>$tkorder['xgyg'],
						'type'=>2,
						'sh'=>$sh,
						'createtime'=>TIMESTAMP
					);
					$order = pdo_fetchall("select * from ".tablename("tiger_newhu_order")." where weid='{$_W['uniacid']}' and type=2 and orderid={$orderid}");
					if(empty($order)){
						pdo_insert ("tiger_newhu_order", $data3 );//添加二级订单
					}
				}		
			}
		}
	
		if(!empty($cfg['khgetorder'])){//管理员订单提交提醒
			$mbid=$cfg['khgetorder'];
			$mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
			//$msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,$orderid);  
			postmobanxiaoxi($cfg,$_W,$cfg['glyopenid'],$mb['id'],$orderid,$member['from_user']);
		}
		return array("error"=>0,'msg'=>'订单提交成功');
	}
}else{
	return array("error"=>1,'msg'=>'您提交的订单已经存在！');
} 

}
//淘宝订单提交结束

//拼多多订单提交
function pddaddorder($cfg,$_W,$member,$orderid){
						if(empty($member['id'])){
							return array("error"=>1,'msg'=>'会员数据异常！请稍后在试！');
	        	}
	        	
	            if(pdo_tableexists('tiger_wxdaili_set')){
	               $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
	               if($bl['dlfxtype']==1){
	                   if($member['dltype']==1){
											 return array("error"=>1,'msg'=>'对不起!代理不能提交订单!');
	                   }                  
	                }
	            }
	            
	            //die(json_encode(array("statusCode"=>100,'msg'=>$orderid)));  
	            
	            $order = pdo_fetch("select * from ".tablename("tiger_newhu_pddtjorder")." where weid='{$_W['uniacid']}' and orderid='{$orderid}'");
	            if(empty($order)){
	                //查询淘客订单库
	                $tkorder = pdo_fetch("select * from ".tablename("tiger_newhu_pddorder")." where weid='{$_W['uniacid']}' and order_sn='{$orderid}'");
	                if($cfg['dlddfx']==1){
	                	$dltgw=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and pddpid='{$tkorder['p_id']}'");
	                	if(!empty($dltgw)){
											return array("error"=>1,'msg'=>'对不起!该订单不支持奖励,请联系管理员!');
	                	}
	                }
	                
	                
	                
	                if(!empty($tkorder)){
	                   if($tkorder['order_status']==4){//审核失败（不可提现）
	                      $sh=4;//失效
												return array("error"=>1,'msg'=>'您提交的订单已退款！');
	                   }elseif($tkorder['order_status']==1){//已成团，付款成功
	                      $sh=3;//已审核
	                   }elseif($tkorder['order_status']==2){//确认收货
	                      $sh=1;//待返
	                   }
	
	                }else{
										return array("error"=>1,'msg'=>'您提交的订单暂未更新，请过15分钟后在提交，感谢您的支持！');
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
	
	                if (pdo_insert ("tiger_newhu_pddtjorder", $data ) === false) {
									return array("error"=>1,'msg'=>'系统繁忙！');
					} else{

	                   $zgtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['zgtxmsg']);
	                   $zgtxmsg=str_replace('#订单号#',$orderid, $zgtxmsg);
	                   $zgtxmsg=str_replace('#金额#',$jl, $zgtxmsg);
	                   //$this->postText($member['from_user'],$zgtxmsg);//自购提示
										 postkefuxiaoxi($cfg,$_W,$member['from_user'],$zgtxmsg);
	                   if(!empty($member['helpid'])){//一级
	                      
	                      if(pdo_tableexists('tiger_wxdaili_set')){//是否开启代理订单不返给二级
	                          $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
	                          if(empty($bl['dlyjfltype'])){
	                             $tgw=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and tgwid='{$tkorder['tgwid']}'");//有没有代理推广位
									 if(!empty($tgw)){
										 if(!empty($cfg['khgetorder'])){//管理员订单提交提醒
												$mbid=$cfg['khgetorder'];
												$mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
												//file_put_contents(IA_ROOT."/addons/tiger_renwubao/log.txt","\n 1old:".json_encode($orderid),FILE_APPEND);
												//$msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,$orderid);  
												postmobanxiaoxi($cfg,$_W,$cfg['glyopenid'],$mb['id'],$orderid,$member['from_user']);	
										 }
										 return array("error"=>0,'msg'=>'订单提交成功');
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
						               $yjmember=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and id='{$member['helpid']}' order by id desc");
				                       $yjtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['yjtxmsg']);
				                       $yjtxmsg=str_replace('#订单号#',$orderid, $yjtxmsg);
				                       $yjtxmsg=str_replace('#金额#',$jl, $yjtxmsg);
				                       //$this->postText($yjmember['from_user'],$yjtxmsg);//一级提示
															 postkefuxiaoxi($cfg,$_W,$yjmember['from_user'],$yjtxmsg);
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
	                                    
	                                    
	                                    $order = pdo_fetchall("select * from ".tablename("tiger_newhu_pddtjorder")." where weid='{$_W['uniacid']}' and type=1 and orderid={$orderid}");
	                                    if(empty($order)){
	                                        pdo_insert ("tiger_newhu_pddtjorder", $data2 );//添加一级订单
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
						               $rjmember=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and id='{$yjmember['helpid']}' order by id desc");
			                           $ejtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['ejtxmsg']);
			                           $ejtxmsg=str_replace('#订单号#',$orderid, $ejtxmsg);
			                           $ejtxmsg=str_replace('#金额#',$jl, $ejtxmsg);
			                           //$this->postText($rjmember['from_user'],$ejtxmsg);//二级提示
																 postkefuxiaoxi($cfg,$_W,$rjmember['from_user'],$ejtxmsg);
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
	                                    $order = pdo_fetchall("select * from ".tablename("tiger_newhu_pddtjorder")." where weid='{$_W['uniacid']}' and type=2 and orderid={$orderid}");
	                                    if(empty($order)){
	                                        pdo_insert ("tiger_newhu_pddtjorder", $data3 );//添加二级订单
	                                    }
	                                 }
	                           //二级订单结束
	
	
	                       }
	                   }
	                   if(!empty($cfg['khgetorder'])){//管理员订单提交提醒
	                        $mbid=$cfg['khgetorder'];
	                        $mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
	                        //$msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,$orderid);   
													postmobanxiaoxi($cfg,$_W,$cfg['glyopenid'],$mb['id'],$orderid,$member['from_user']);	
	                    }
	
											return array("error"=>0,'msg'=>'订单提交成功！');
					}
	            }else{
								return array("error"=>1,'msg'=>'您提交的订单已经存在！');
	            }
}
//拼多多提交订单结束

//京东提交订单开始
function jdaddorder($cfg,$_W,$member,$orderid){
	if(empty($member['id'])){

        		return array("error"=>1,'msg'=>'会员数据异常！请稍后在试！');
        	}
        	
            if(pdo_tableexists('tiger_wxdaili_set')){
               $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
               if($bl['dlfxtype']==1){
                   if($member['dltype']==1){                    
                     return array("error"=>1,'msg'=>'对不起!代理不能提交订单!');
                   }                  
                }
            }
            
            //die(json_encode(array("statusCode"=>100,'msg'=>$orderid)));  
            
            $order = pdo_fetch("select * from ".tablename("tiger_newhu_jdtjorder")." where weid='{$_W['uniacid']}' and orderid='{$orderid}'");
            //die(json_encode(array("statusCode"=>100,'msg'=>$orderid)));  
            if(empty($order)){
                //查询淘客订单库
                $tkorder = pdo_fetch("select * from ".tablename("tiger_newhu_jdorder")." where weid='{$_W['uniacid']}' and orderId='{$orderid}'");
                
                
                
                
                
                if(!empty($tkorder)){
                	if($cfg['dlddfx']==1){
	                	$dltgw=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and jdpid='{$tkorder['spId']}'");
	                	if(!empty($dltgw['id'])){
	                		return array("error"=>1,'msg'=>'对不起!该订单不支持奖励,请联系管理员!'.$dltgw['id']."--".$tkorder['spId']);
	                		
	                	}
	                }
                   if($tkorder['validCode']<=14){//审核失败（不可提现）
                      $sh=4;//失效
                      return array("error"=>1,'msg'=>'您提交的订单已退款');
                   }elseif($tkorder['validCode']==16){//已成团，付款成功
                      $sh=3;//已审核
                   }elseif($tkorder['validCode']==17){//确认收货
                      $sh=1;//待返
                   }
                   //$credit2_zg=$tkorder['xgyg']*$cfg['zgf']/100;

                }else{                
                  return array("error"=>1,'msg'=>'您提交的订单暂未更新，请过15分钟后在提交，感谢您的支持'); 
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
                		$jl=intval($tkorder['estimateFee']*$cfg['zgf']/100*$cfg['jfbl']);
                	}                	
                }elseif($cfg['fxtype']==2){//自购余额
                	if($cfg['gdfxtype']==1){
                		 $jl=$cfg['zgf'];
                	}else{
                		 $jl=$tkorder['estimateFee']*$cfg['zgf']/100;  
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
                    'itemid'=>$tkorder['skuId'],
                    'jl'=>$jl,
                    'jltype'=>$jltype,
                    'sh'=>$sh,
                    'yongjin'=>$tkorder['estimateFee'],//佣金
                    'type'=>0,
                    'createtime'=>TIMESTAMP
                );

                if (pdo_insert ("tiger_newhu_jdtjorder", $data ) === false) {
					return array("error"=>1,'msg'=>'系统繁忙'); 
				} else{
					

                   $zgtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['zgtxmsg']);
                   $zgtxmsg=str_replace('#订单号#',$orderid, $zgtxmsg);
                   $zgtxmsg=str_replace('#金额#',$jl, $zgtxmsg);
                    //$this->postText($member['from_user'],$zgtxmsg);//自购提示
                    postkefuxiaoxi($cfg,$_W,$member['from_user'],$zgtxmsg);
                   if(!empty($member['helpid'])){//一级
                      
                      if(pdo_tableexists('tiger_wxdaili_set')){//是否开启代理订单不返给二级
                          $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
                          if(empty($bl['dlyjfltype'])){
                             $tgw=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and tgwid='{$tkorder['tgwid']}'");//有没有代理推广位
                                   if(!empty($tgw)){
                                         if(!empty($cfg['khgetorder'])){//管理员订单提交提醒
                                            $mbid=$cfg['khgetorder'];
                                            $mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
                                            //file_put_contents(IA_ROOT."/addons/tiger_renwubao/log.txt","\n 1old:".json_encode($orderid),FILE_APPEND);
                                            //$msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,$orderid);         
                                            postmobanxiaoxi($cfg,$_W,$cfg['glyopenid'],$mb['id'],$orderid,$member['from_user']);	         
                                         }
                                         return array("error"=>0,'msg'=>'订单提交成功'); 
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
					                		$jl=intval($tkorder['estimateFee']*$cfg['yjf']/100*$cfg['jfbl']);
					                	}					                	
					                }elseif($cfg['fxtype']==2){//自购余额
					                	if($cfg['gdfxtype']==1){
					                		 $jl=$cfg['yjf'];
					                	}else{
					                		$jl=$tkorder['estimateFee']*$cfg['yjf']/100;  
                                       	    $jl=number_format($jl, 2, '.', '');
					                	}					                    
					                }
					               $yjmember=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and id='{$member['helpid']}' order by id desc");
			                       $yjtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['yjtxmsg']);
			                       $yjtxmsg=str_replace('#订单号#',$orderid, $yjtxmsg);
			                       $yjtxmsg=str_replace('#金额#',$jl, $yjtxmsg);
			                      // $this->postText($yjmember['from_user'],$yjtxmsg);//一级提示
			                       postkefuxiaoxi($cfg,$_W,$yjmember['from_user'],$yjtxmsg);
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
                                        'itemid'=>$tkorder['skuId'],
                                        'yongjin'=>$tkorder['estimateFee'],
                                        'type'=>1,
                                        'sh'=>$sh,
                                        'createtime'=>TIMESTAMP
                                    );                    
                                    
                                    
                                    $order = pdo_fetchall("select * from ".tablename("tiger_newhu_jdtjorder")." where weid='{$_W['uniacid']}' and type=1 and orderid={$orderid}");
                                    if(empty($order)){
                                        pdo_insert ( "tiger_newhu_jdtjorder", $data2 );//添加一级订单
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
					                		$jl=intval($tkorder['estimateFee']*$cfg['ejf']/100*$cfg['jfbl']);
					                	}					                	
					                }elseif($cfg['fxtype']==2){//自购余额
					                	if($cfg['gdfxtype']==1){
					                		 $jl=$cfg['ejf'];
					                	}else{
					                		 $jl=$tkorder['estimateFee']*$cfg['ejf']/100;  
                                       		 $jl=number_format($jl, 2, '.', '');
					                	}					                    
					                }
					               $rjmember=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and id='{$yjmember['helpid']}' order by id desc");
		                           $ejtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['ejtxmsg']);
		                           $ejtxmsg=str_replace('#订单号#',$orderid, $ejtxmsg);
		                           $ejtxmsg=str_replace('#金额#',$jl, $ejtxmsg);
		                           //$this->postText($rjmember['from_user'],$ejtxmsg);//二级提示
		                           postkefuxiaoxi($cfg,$_W,$rjmember['from_user'],$ejtxmsg);
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
                                        'itemid'=>$tkorder['skuId'],
                                        'yongjin'=>$tkorder['estimateFee'],
                                        'type'=>2,
                                         'sh'=>$sh,
                                        'createtime'=>TIMESTAMP
                                    );
                                    $order = pdo_fetchall("select * from ".tablename("tiger_newhu_jdtjorder")." where weid='{$_W['uniacid']}' and type=2 and orderid={$orderid}");
                                    if(empty($order)){
                                        pdo_insert ("tiger_newhu_jdtjorder", $data3 );//添加二级订单
                                    }
                                 }
                           //二级订单结束


                       }
                   }
                   if(!empty($cfg['khgetorder'])){//管理员订单提交提醒
                        $mbid=$cfg['khgetorder'];
                        $mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
                        //file_put_contents(IA_ROOT."/addons/tiger_renwubao/log.txt","\n 1old:".json_encode($orderid),FILE_APPEND);
                        //$msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,$orderid);    
                        postmobanxiaoxi($cfg,$_W,$cfg['glyopenid'],$mb['id'],$orderid,$member['from_user']);              
                   }
					return array("error"=>0,'msg'=>'订单提交成功'); 
				}
            }else{
              return array("error"=>1,'msg'=>'您提交的订单已经记录'); 
            }
	
}
//京东提交订单结束

//发送客服消息
function postkefuxiaoxi($cfg,$_W,$openid,$msg){
	$url=$cfg[tknewurl]."app/index.php?i=".$_W['uniacid']."&c=entry&do=kefuxiaoxi&m=tiger_newhu&openid=".$openid."&msg=".urlencode($msg);
	xxcurl($url);
}

//发送模版消息
function postmobanxiaoxi($cfg,$_W,$openid,$id,$orderid,$yhopenid){//$yhopenid 用户的OPENID
	$url=$cfg[tknewurl]."app/index.php?i=".$_W['uniacid']."&c=entry&do=mobanxiaoxi&m=tiger_newhu&openid=".$openid."&id=".$id."&orderid=".$orderid."&yhopenid=".$yhopenid;
	xxcurl($url);
}


/**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function xxcurl($url, $params = false, $ispost = 0)
{
    $httpInfo = array();
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'JuheData');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if ($ispost) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_URL, $url);
    } else {
        if ($params) {
            curl_setopt($ch, CURLOPT_URL, $url.'?'.$params);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    }
    $response = curl_exec($ch);
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
    curl_close($ch);
    return $response;
} 
