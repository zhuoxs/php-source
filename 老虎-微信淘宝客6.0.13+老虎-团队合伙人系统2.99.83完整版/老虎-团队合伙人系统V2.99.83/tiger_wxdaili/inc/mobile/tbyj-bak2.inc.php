 <?php global $_W, $_GPC;
//http://cs.tigertaoke.com/app/index.php?i=14&c=entry&do=tbyj&m=tiger_wxdaili&uid=7626&day=3
         $uid=$_GPC['uid'];
				 $day=$_GPC['day'];
				 if(empty($uid)){
					 exit("UID必填");
				 }
				 if(empty($day)){
					 exit("d必填"); 
				 }
				 
         $cfg = $this->module['config'];
         $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
         $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
				 

         $dldata=pdo_fetch("select * from ".tablename('tiger_wxdaili_dlshuju')." where weid='{$_W['uniacid']}' and uid='{$uid}'");
         $fsbl=tqbl($share,$bl,$cfg,$day);
// 					echo "<pre>";
// 					echo $fsbl;
// 					print_r($fsbl);
// 					exit;
// 					
					
					function tqbl($share,$bl,$cfg,$day){//代理抽成模式  1结算  2付款 3结算+付款 $day=1 今天  2昨天  3本月  4上月
					         global $_W;
					         $daytime=strtotime(date("Y-m-d 00:00:00"));//今天0点
					         $zttime=strtotime(date("Y-m-d 00:00:00",strtotime("-1 day")));//昨天0点
					         //echo $zttime;
					        // exit;
					         // 本月起始时间:
					         $bbegin_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
					         $bend_time = strtotime(date("Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), date ( "t" ),date( "Y" ))));
					         // 上月起始时间:
					         //$sbegin_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
					         $sbegin_time = strtotime(date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y'))));//上个月开始时间
					         $send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
					        //本人推广位PID
//					        $tgwarr=explode('|',$share['tgwid']);
//					        $where='';
//					        if(!empty($share['tgwid'])){
//					           $where .="and (";
//					           foreach($tgwarr as $k=>$v){
//					               $where .=" tgwid=".$v." or ";
//					           }
//					           $where .="tgwid=".$tgwarr[0].")";
//					        }else{
//					          $where .=" and tgwid=111111";
//					        }
					        if(empty($share['qdid'])){
						    	$where =" and tgwid='{$share['tgwid']}'";									    	
						    }else{
						    	$where =" and  (tgwid='{$share['tgwid']}' || relation_id='{$share['qdid']}') ";
						    }
					
					        $fs=jcbl($share,$bl);
					        $cj=$fs['cj'];//粉丝层级 1 2 3
									
									
									if($day==1){
										//今日本人佣金 订单结算+付款
										$jrygsum=bryj($share,$daytime,'',3,$bl,$cfg);
										$jrygsum=number_format($jrygsum, 2, '.', '');//今日本人预估所得佣金
										$jrjyj=bydlyj($share,$daytime,'',3,$bl,$cfg);  
										if($bl['fxtype']==1){//普通模式
											$jryj=number_format($jrjyj['yj2'], 2, '.', '');//今日本人二级代理提取佣金
											$jrsjyj=number_format($jrjyj['yj3'], 2, '.', '');//今日本人三级代理提取佣金
											$jrzyj=$jrygsum+$jryj+$jrsjyj;//本月本人总佣金
										}else{
										if($bl['dltype']==2){//二级模式不抽成
											$jryj=number_format($jrjyj['yj2']*$bl['dlbl1t2']/100, 2, '.', '');//今日本人二级代理提取佣金
										}elseif($bl['dltype']==3){//三级抽成模式
											$jryj=number_format($jrjyj['yj2']*$bl['dlbl2t3']/100, 2, '.', '');//今日本人二级代理提取佣金
											$jrsjyj=number_format($jrjyj['yj3']*$bl['dlbl1t3']/100, 2, '.', '');//今日本人三级代理提取佣金
										}         
											$jrzyj=$jrygsum+$jryj+$jrsjyj;//本月本人总佣金
										}         
										if(empty($jrzyj)){
											$jrzyj="0.00";
										}
									}
					        
									 
									 
									 if($day==2){
										 //昨日本人佣金 订单结算+付款
										 $zrygsum=bryj($share,$zttime,$daytime,3,$bl,$cfg);								
										 $zrygsum=number_format($zrygsum, 2, '.', '');//上月本人预估所得佣金
										 $zrrsjyj=bydlyj($share,$zttime,$daytime,3,$bl,$cfg);
										 
										 if($bl['fxtype']==1){//普通模式
										 	$zrrjyj=number_format($zrrsjyj['yj2'], 2, '.', '');//昨日本人二级代理提取佣金
										 	$zrsjyj=number_format($zrrsjyj['yj3'], 2, '.', '');//昨日本人三级代理提取佣金
										 	$zrzyj=$zrygsum+$zrrjyj+$zrsjyj;//本月本人总佣金 
										 }else{
										 	if($bl['dltype']==2){//二级模式不抽成
										 		$zrrjyj=number_format($zrrsjyj['yj2']*$bl['dlbl1t2']/100, 2, '.', '');//昨日本人二级代理提取佣金
										 		$zrsjyj='0.00';
										 	}elseif($bl['dltype']==3){//三级抽成模式
										 		$zrrjyj=number_format($zrrsjyj['yj2']*$bl['dlbl2t3']/100, 2, '.', '');//昨日本人二级代理提取佣金
										 		$zrsjyj=number_format($zrrsjyj['yj3']*$bl['dlbl1t3']/100, 2, '.', '');//昨日本人三级代理提取佣金
										 	}           
										 	$zrzyj=$zrygsum+$zrrjyj+$zrsjyj;//本月本人总佣金 
										 }         
										 if(empty($zrzyj)){
										 	$zrzyj="0.00";
										 }
									 }
					         
									 
									 if($day==3){
										 //本月本人佣金 订单结算
										 $byygsum=bryj($share,$bbegin_time,$bend_time,1,$bl,$cfg,1);
										 $byygsum=number_format($byygsum, 2, '.','');//本月本人预估所得佣金
										 $rsjyj=bydlyj($share,$bbegin_time,$bend_time,1,$bl,$cfg,1);   
										 //return $rsjyj;
										 if($bl['fxtype']==1){//普通模式
										 	$rjyj=number_format($rsjyj['yj2'], 2, '.', '');//本月本人二级代理提取佣金
										 	$sjyj=number_format($rsjyj['yj3'], 2, '.', '');//本月本人三级代理提取佣金
										 	$brzyj=$byygsum+$rjyj+$sjyj;//本月本人总佣金
										 	//return $rjyj."---". $sjyj;
										 }else{
										 	if($bl['dltype']==2){//二级模式不抽成
										 		$rjyj=number_format($rsjyj['yj2']*$bl['dlbl1t2']/100, 2, '.', '');//本月本人二级代理提取佣金
										 		$sjyj='0.00';
										 	}elseif($bl['dltype']==3){//三级抽成模式
										 		$rjyj=number_format($rsjyj['yj2']*$bl['dlbl2t3']/100, 2, '.', '');//本月本人二级代理提取佣金
										 		$sjyj=number_format($rsjyj['yj3']*$bl['dlbl1t3']/100, 2, '.', '');//本月本人三级代理提取佣金
										 	}            
										 	$brzyj=$byygsum+$rjyj+$sjyj;//本月本人总佣金
										 }
										 if(empty($brzyj)){
										 	$brzyj="0.00";
										 }
										 
										 //本月本人佣金 [付款]
										 $byfksum=bryj($share,$bbegin_time,$bend_time,2,$bl,$cfg);
										 $byfksum=number_format($byfksum, 2, '.','');//本月本人预估所得佣金
										 $rsjfkyj=bydlyj($share,$bbegin_time,$bend_time,2,$bl,$cfg);   
										 if($bl['fxtype']==1){//普通模式
										 	$rjfkyj=number_format($rsjfkyj['yj2'], 2, '.', '');//本月本人二级代理提取佣金
										 	$sjfkyj=number_format($rsjfkyj['yj3'], 2, '.', '');//本月本人三级代理提取佣金
										 	$brzfkyj=$byfksum+$rjfkyj+$sjfkyj;//本月本人总佣金
										 }else{
										 	if($bl['dltype']==2){//二级模式不抽成
										 		$rjfkyj=number_format($rsjfkyj['yj2']*$bl['dlbl1t2']/100, 2, '.', '');//本月本人二级代理提取佣金
										 		$sjfkyj='0.00';
										 	}elseif($bl['dltype']==3){//三级抽成模式
										 		$rjfkyj=number_format($rsjfkyj['yj2']*$bl['dlbl2t3']/100, 2, '.', '');//本月本人二级代理提取佣金
										 		$sjfkyj=number_format($rsjfkyj['yj3']*$bl['dlbl1t3']/100, 2, '.', '');//本月本人三级代理提取佣金
										 	}            
										 	$brzfkyj=$byfksum+$rjfkyj+$sjfkyj;//本月本人总佣金
										 }
										 if(empty($brzfkyj)){
										 	$brzfkyj="0.00";
										 }
										 
									 }
					        
									 
									 if($day==4){
										 //上个月本人二级三级佣金 【订单结算1】
										 $syygsum=bryj($share,$sbegin_time,$send_time,1,$bl,$cfg,1);
										 $syygsum=number_format($syygsum, 2, '.', '');//上月本人预估所得佣金
										 $syrsjyj=bydlyj($share,$sbegin_time,$send_time,1,$bl,$cfg,1);
										 if($bl['fxtype']==1){//普通模式
										 	$syrjyj=number_format($syrsjyj['yj2'], 2, '.', '');//上月本人二级代理提取佣金
										 	$sysjyj=number_format($syrsjyj['yj3'], 2, '.', '');//上月本人三级代理提取佣金
										 	$syzyj=$syygsum+$syrjyj+$sysjyj;//上月本人总佣金
										 }else{
										 if($bl['dltype']==2){//二级模式不抽成
										 		$syrjyj=number_format($syrsjyj['yj2']*$bl['dlbl1t2']/100, 2, '.', '');//上月本人二级代理提取佣金
										 }elseif($bl['dltype']==3){//三级模式抽成
										 		$syrjyj=number_format($syrsjyj['yj2']*$bl['dlbl2t3']/100, 2, '.', '');//上月本人二级代理提取佣金
										 		$sysjyj=number_format($syrsjyj['yj3']*$bl['dlbl1t3']/100, 2, '.', '');//上月本人三级代理提取佣金
										 }
										 	$syzyj=$syygsum+$syrjyj+$sysjyj;//上月本人总佣金
										 }         
										 if(empty($syzyj)){
										 	$syzyj="0.00";
										 }
										 
										 
										 //上个月本人二级三级佣金 【订单付款 状态2】
										 $wsyygsum=bryj($share,$sbegin_time,$send_time,2,$bl,$cfg);
										 $wsyygsum=number_format($wsyygsum, 2, '.', '');//上月本人预估所得佣金
										 $wsyrsjyj=bydlyj($share,$sbegin_time,$send_time,2,$bl,$cfg);
										 if($bl['fxtype']==1){//普通模式
										 	$wsyrjyj=number_format($wsyrsjyj['yj2'], 2, '.', '');//上月本人二级代理提取佣金
										 	$wsysjyj=number_format($wsyrsjyj['yj3'], 2, '.', '');//上月本人三级代理提取佣金
										 	$wsyzyj=$wsyygsum+$wsyrjyj+$wsysjyj;//上月本人总佣金
										 }else{
										 	if($bl['dltype']==2){//二级模式不抽成
										 		$wsyrjyj=number_format($wsyrsjyj['yj2']*$bl['dlbl1t2']/100, 2);//上月本人二级代理提取佣金
										 	}elseif($bl['dltype']==3){//三级模式抽成
										 		$wsyrjyj=number_format($wsyrsjyj['yj2']*$bl['dlbl2t3']/100, 2);//上月本人二级代理提取佣金
										 		$wsysjyj=number_format($wsyrsjyj['yj3']*$bl['dlbl1t3']/100, 2);//上月本人三级代理提取佣金
										 	}      
										 	$wsyzyj=$wsyygsum+$wsyrjyj+$wsysjyj;//上月本人总佣金
										 }
										 
									 }
					         
									 
							
					         if(empty($zjrzyj)){
					            $zjrzyj="0.00";
					         }
					         if(empty($syzyj)){
					         	$syzyj='0.00';
					         }
					         if(empty($syygsum)){
					         	$syygsum='0.00';
					         }
					         if(empty($syrjyj)){
					         	$syrjyj='0.00';
					         }
					         if(empty($sysjyj)){
					         	$sysjyj='0.00';
					         }
					         if(empty($wsyzyj)){
					         	$wsyzyj='0.00';
					         }
					         if(empty($wsyygsum)){
					         	$wsyygsum='0.00';
					         }
					         if(empty($wsyrjyj)){
					         	$wsyrjyj='0.00';
					         }
					         if(empty($wsysjyj)){
					         	$wsysjyj='0.00';
					         }
					         if(empty($brzyj)){
					         	$brzyj='0.00';
					         }
					         if(empty($byygsum)){
					         	$byygsum='0.00';
					         }
					         if(empty($rjyj)){
					         	$rjyj='0.00';
					         }
					         if(empty($sjyj)){
					         	$sjyj='0.00';
					         }
					         if(empty($jrzyj)){
					         	$jrzyj='0.00';
					         }
					         if(empty($jrygsum)){
					         	$jrygsum='0.00';
					         }
					         if(empty($jryj)){
					         	$jryj='0.00';
					         }
					         if(empty($jrsjyj)){
					         	$jrsjyj='0.00';
					         }
					         if(empty($zrrjyj)){
					         	$zrrjyj='0.00';
					         }
					         if(empty($zrsjyj)){
					         	$zrsjyj='0.00';
					         }
					         $array=array(
					              'zong'=>$zjrzyj,   //总结算汇总[订单结算]
					    //-----上月佣金结算预估[订单结算]------
					              's1'=>$syzyj,    //结算汇总
					              's2'=>$syygsum,  //本人结算
					              's3'=>$syrjyj,   //二当家结算
					              's4'=>$sysjyj,   //三当家结算
					    //------上月佣金结算预估[订单付款]------
					             's5'=>$wsyzyj,    //未结算汇总
					             's6'=>$wsyygsum,  //本人未结算
					             's7'=>$wsyrjyj,   // 二当家未结算
					             's8'=>$wsysjyj,   //三当家未结算
					    //----  -本月预估佣金[订单结算]-----------
					             'b1'=>$brzyj,     //汇总
					             'b2'=>$byygsum,   //本人预估
					             'b3'=>$rjyj,      //二当家预估
					             'b4'=>$sjyj,      //三当家预估
					    //----  -本月预估佣金[订单付款]-----------
					             'd1'=>$brzfkyj,     //汇总
					             'd2'=>$byfksum,   //本人预估
					             'd3'=>$rjfkyj,      //二当家预估
					             'd4'=>$sjfkyj,      //三当家预估    
					    //------昨日预估佣金[订单结算付款]-------------
					             'z1'=>$zrzyj,     //汇总
					             'z2'=>$zrygsum,   //本人预估
					             'z3'=>$zrrjyj,    //二当家预估
					             'z4'=>$zrsjyj,    //三当家预估
					    //------今日预估[订单结算付款]-----------------
					             'j1'=>$jrzyj,     //汇总
					             'j2'=>$jrygsum,   //本人预估
					             'j3'=>$jryj,      //二当家预估
					             'j4'=>$jrsjyj,    //三当家预估
					         );
					         
					         return $array;
					    }
// 							`tb1` int(11)  DEFAULT 0 COMMENT '本人-今天已付款订单数',		
// 							`tb2` Decimal(10,2)  DEFAULT 0 COMMENT '本人-今天已付款佣预估金数',	
// 							
// 							`tb3` int(11)  DEFAULT 0 COMMENT '本人-昨天已付款订单',	
// 							`tb4` Decimal(10,2)  DEFAULT 0 COMMENT '本人-昨天已付款预估佣金数',	
// 							
// 							`tb5` int(11)  DEFAULT 0 COMMENT '本人-本月已付款订单数',	
// 							`tb6` Decimal(10,2)  DEFAULT 0 COMMENT '本人-本月已付款预估佣金数',	
// 							
// 							`tb7` int(11)  DEFAULT 0 COMMENT '本人-上月已结算订单数',	
// 							`tb8` Decimal(10,2)  DEFAULT 0 COMMENT '本人-上月已结算预估佣金数',
// 							
// 							`tb12` Decimal(10,2)  DEFAULT 0 COMMENT '二级-今天已付款佣预估金数',	
// 							`tb14` Decimal(10,2)  DEFAULT 0 COMMENT '二级-昨天已付款预估佣金数',	
// 							`tb16` Decimal(10,2)  DEFAULT 0 COMMENT '二级-本月已付款预估佣金数',	
// 							`tb18` Decimal(10,2)  DEFAULT 0 COMMENT '二级-上月已结算预估佣金数',
// 	
// 							`tb22` Decimal(10,2)  DEFAULT 0 COMMENT '三级-今天已付款佣预估金数',	
// 							`tb24` Decimal(10,2)  DEFAULT 0 COMMENT '三级-昨天已付款预估佣金数',	
// 							`tb26` Decimal(10,2)  DEFAULT 0 COMMENT '三级-本月已付款预估佣金数',	
// 							`tb28` Decimal(10,2)  DEFAULT 0 COMMENT '三级-上月已结算预估佣金数',
							
							$daytime=strtotime(date("Y-m-d 00:00:00"));//今天0点
							$zttime=strtotime(date("Y-m-d 00:00:00",strtotime("-1 day")));//昨天0点
							$b_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));//本月开始时间
							$sy_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
							if($day==1){//今天
							  
							  if(empty($share['qdid'])){
							  	//今日付款笔数
							  	$dyaordercount= pdo_fetchcolumn("SELECT count(id) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and orderzt='订单付款' and tgwid='{$share['tgwid']}' and addtime>'{$daytime}'"); 
							  }else{
							  	//今日付款笔数
							  	$dyaordercount= pdo_fetchcolumn("SELECT count(id) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and orderzt='订单付款' and (tgwid='{$share['tgwid']}' || relation_id='{$share['qdid']}') and addtime>'{$daytime}'"); 
							  }
							  
							  
							  if(empty($dyaordercount)){
									$dyaordercount=0;
							  }
								$data=array(
										'tb1'=>$dyaordercount,//本人-今天已付款订单数
										'tb2'=>$fsbl['j2'],//本人-今天已付款佣预估金
										'tb12'=>$fsbl['j3'],//二级-今天已付款佣预估金数
										'tb22'=>$fsbl['j4'],//三级-今天已付款佣预估金数
								);
								$dayname="今天数据,订单数：".$dyaordercount." 付款预估佣金：".$fsbl['j2']."二级付款预估佣金：".$fsbl['j3']."三级付款预估佣金：".$fsbl['j4'];
							}elseif($day==2){//昨天
							
							if(empty($share['qdid'])){
								//昨日付款笔数
								$zraordercount= pdo_fetchcolumn("SELECT count(id) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and orderzt='订单付款' and tgwid='{$share['tgwid']}' and addtime<'{$daytime}' and addtime>'{$zttime}'");
							}else{
								//昨日付款笔数
								$zraordercount= pdo_fetchcolumn("SELECT count(id) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and orderzt='订单付款' and ( tgwid='{$share['tgwid']}' || relation_id='{$share['qdid']}') and addtime<'{$daytime}' and addtime>'{$zttime}'");
							}	
							
							
						
								
								if(empty($zraordercount)){
									$zraordercount=0;
								}
								$data=array(
										'tb3'=>$zraordercount,//本人-昨天已付款订单
										'tb4'=>$fsbl['z2'],//本人-昨天已付款预估佣金数
										'tb14'=>$fsbl['z3'],//二级-昨天已付款预估佣金数
										'tb24'=>$fsbl['z4'],//三级-昨天已付款预估佣									
								);
							$dayname="昨天数据,订单数：".$zraordercount." 付款预估佣金：".$fsbl['z2']."二级付款预估佣金：".$fsbl['z3']."三级付款预估佣金：".$fsbl['z4'];
									
							}elseif($day==3){//本月
								if(empty($share['qdid'])){
									//本月付款笔数
								$byaordercount= pdo_fetchcolumn("SELECT count(id) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and (orderzt='订单付款' || orderzt='订单结算') and tgwid='{$share['tgwid']}' and addtime>'{$b_time}'");
								}else{
									//本月付款笔数
								$byaordercount= pdo_fetchcolumn("SELECT count(id) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and (orderzt='订单付款' || orderzt='订单结算') and (tgwid='{$share['tgwid']}' || relation_id='{$share['qdid']}') and addtime>'{$b_time}'");
								}
								
								if(empty($byaordercount)){
									$byaordercount=0;
								}
								$data=array(
										'tb5'=>$byaordercount,//本人-本月已付款订单数
										'tb6'=>$fsbl['d2']+$fsbl['b2'],//本人-本月已付款预估佣金数
										'tb16'=>$fsbl['d3']+$fsbl['b3'],//二级-本月已付款预估佣金数
										'tb26'=>$fsbl['d4']+$fsbl['b4'],//三级-本月已付款预估佣金数										
								);
								
							$dayname="本月数据,订单数：".$byaordercount." 付款预估佣金：".$fsbl['d2']."二级付款预估佣金：".$fsbl['d3']."三级付款预估佣金：".$fsbl['d4'];
							}elseif($day==4){//上月
								if(empty($share['qdid'])){
									//上月付款笔数
							$syaordercount= pdo_fetchcolumn("SELECT count(id) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and orderzt='订单结算' and tgwid='{$share['tgwid']}' and jstime>'{$sy_time}' and jstime<'{$b_time}'");
							}else{
								//上月付款笔数
							$syaordercount= pdo_fetchcolumn("SELECT count(id) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and orderzt='订单结算' and (tgwid='{$share['tgwid']}' || relation_id='{$share['qdid']}') and jstime>'{$sy_time}' and jstime<'{$b_time}'");
							}
							
							if(empty($syaordercount)){
								$syaordercount=0;
							}
								$data=array(
										'tb7'=>$syaordercount,//本人-上月已结算订单数
										'tb8'=>$fsbl['s2'],//本人-上月已结算预估佣金数
										'tb18'=>$fsbl['s3'],//二级-上月已结算预估佣金数
										'tb28'=>$fsbl['s4'],//三级-上月已结算预估佣金数
								);
								$dayname="上月数据,订单数：".$syaordercount." 付款预估佣金：".$fsbl['s2']."二级付款预估佣金：".$fsbl['s3']."三级付款预估佣金：".$fsbl['s4'];
							}
							
							
							$data['createtime']=time();
							$data['uid']=$uid;
							$data['weid']=$_W['uniacid'];
							if(empty($dldata['uid'])){
								$res=pdo_insert("tiger_wxdaili_dlshuju",$data);
							}else{
								$res=pdo_update("tiger_wxdaili_dlshuju",$data,array('uid'=>$uid));
							}
							$daytime=date('Y-m-d H:i:s',$data['createtime']);
							if($res){
								$res="已更新".$daytime;
							}else{
								$res="无更新";
							}
							exit(json_encode(array("【淘宝】 UID:".$uid.$dayname.$res,$data)));
							
							
							function jcbl($share,$bl){//单个会员佣金比例 
							         global $_W;
							         $sj=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$share['helpid']}'");//上级
							         if($bl['dltype']==3){//开三级   
							             if(!empty($sj)){
							               $sj2=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$sj['helpid']}'");//上上级
							               if(!empty($sj2)){
							                 $djbl=$bl['dlbl3'];
							                 $tname=$bl['dlname3'];
							                 $cj=3;
							               }else{
							                 $djbl=$bl['dlbl2'];
							                 $tname=$bl['dlname2'];
							                 $cj=2;
							               }           
							             }else{
							               $djbl=$bl['dlbl1'];
							               $tname=$bl['dlname1'];
							               $cj=1;
							             }
							         }elseif($bl['dltype']==2){//开二级
							             if(!empty($sj)){
							                $djbl=$bl['dlbl2'];
							                $tname=$bl['dlname2'];
							                $cj=2;
							             }else{
							                $djbl=$bl['dlbl1'];
							                $tname=$bl['dlname1'];
							                $cj=1;
							             }           
							         }else{
							            $djbl=$bl['dlbl1'];
							            $tname=$bl['dlname1'];
							            $cj=1;
							         }
							         if(!empty($share['dlbl'])){//如果开了代理独立的，就用独立的
							            $djbl=$share['dlbl'];
							            $tname=$bl['dlname1'];
							         }
							         $arr=array(
							             'bl'=>$djbl,
							             'tname'=>$tname,
							             'cj'=>$cj,
							         );
							
							         return $arr;         
							     }
									 
									 
									 function bryj($share,$begin_time,$end_time,$zt,$bl,$cfg,$sd=0){//本人订单//代理抽成比例
									 	global $_W;
									 	if(!empty($share['dlbl'])){//开启代理自定义模式
									 		$bl['dlbl1']=$share['dlbl'];
									 	}
									 	$send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
									 	
									 	// 本月起始时间:
									 	$bbegin_time1 = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
									 	$bend_time1 = strtotime(date("Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), date ( "t" ),date( "Y" ))));
									 	//file_put_contents(IA_ROOT."/addons/tiger_wxdaili/time.txt","\n".$begin_time."---".$end_time."--".$bend_time1,FILE_APPEND);
									 	if($cfg['jsms']==1){
									 			if($send_time==$end_time){//上月结算s
									 				$addtime='jstime';
									 			}elseif($begin_time==$bbegin_time1 and $end_time==$bend_time1){
									 				if($zt==1){
									 					$addtime='jstime';
									 				}else{
									 					$addtime='addtime';
									 				}
									 			}else{
									 				$addtime='addtime';
									 			}
									 			if($zt==2){
									 				$addtime='addtime';
									 			}
									 	}else{
									 		$addtime='addtime';
									 	}
									 // file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log-1.txt","\n".json_encode($addtime),FILE_APPEND);
									 	if($sd==1){
									 		$addtime='jstime';
									 	}
									 	if(empty($end_time)){
									 		if(!empty($begin_time)){
									 			$dwhere="and addtime>={$begin_time}";
									 		}   
									 	}else{
									 		if(!empty($begin_time)){
									 			$dwhere="and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
									 		}        
									 	}
									 	if($zt==1){
									 		$ddzt=" and orderzt='订单结算'";
									 	}elseif($zt==2){
									 		$ddzt=" and orderzt='订单付款'";
									 	}elseif($zt==3){
									 		$ddzt=" and orderzt<>'订单失效'";
									 	}
									 	//本人推广位PID
//									 		$tgwarr=explode('|',$share['tgwid']);
//									 		$where='';
//									 		if(!empty($share['tgwid'])){
//									 			$where .="and (";
//									 			foreach($tgwarr as $k=>$v){
//									 					$where .=" tgwid=".$v." or ";
//									 			}
//									 			$where .="tgwid=".$tgwarr[0].")";
//									 		}else{
//									 			$where .=" and tgwid=111111";
//									 		}
									    if(empty($share['qdid'])){
									    	$where =" and tgwid='{$share['tgwid']}'";									    	
									    }else{
									    	$where =" and  (tgwid='{$share['tgwid']}' || relation_id='{$share['qdid']}') ";
									    }
									 
									 	//本人结束
									 	$byygsum = pdo_fetchcolumn("SELECT sum(xgyg) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}'  {$ddzt} {$dwhere} {$where}");//本月本人预估实际佣金
									 	
									 	//file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log.txt","\n".json_encode($byygsum),FILE_APPEND);
									 	if(!empty($bl['dlkcbl'])){
									 		$byygsum=$byygsum*(100-$bl['dlkcbl'])/100;
									 	}
									 	if(empty($byygsum)){
									 			$byygsum="0.00";
									 	}else{
									 		$sj=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$share['helpid']}'");
									 		
									 		if(!empty($sj)){
									 				if($bl['dltype']==2){//开启二级代理模式
									 					$dj=1;
									 				}
									 				$sj2=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$sj['helpid']}'");            
									 				if($bl['dltype']==3){//开启三级代理模式
									 						if(!empty($sj2)){
									 							$dj=2;
									 						}else{
									 							$dj=1;
									 						}
									 						
									 				}              
									 			
									 		}
									 	}
									 	if($bl['fxtype']==1){//普通模式
									 			$byygsum=$byygsum*$bl['dlbl1']/100;
									 	}else{//抽成模式         
									 		if($dj==1){
									 				$yj2=$byygsum*$bl['dlbl2']/100;//自身所得佣金
									 				$yj1=$yj2*$bl['dlbl1t2']/100;//被上级提取
									 				$byygsum=$yj2-$yj1;
									 				//return $dj;
									 			}elseif($dj==2){
									 				$yj3=$byygsum*$bl['dlbl3']/100;//自身所得佣金
									 				$yj2=$yj3*$bl['dlbl2t3']/100;//被上级提取
									 				$yj1=$yj3*$bl['dlbl1t3']/100;//被上上级提取
									 				$byygsum=$yj3-$yj2-$yj1;
									 			}else{
									 				$byygsum=$byygsum*$bl['dlbl1']/100;
									 			}        
									 	}
									 	return $byygsum;
									 }
									 
									 function bydlyj($share,$begin_time,$end_time='',$zt,$bl,$cfg,$sd=0){//本人二级，三级订单 订单结算//代理抽成比例
									           global $_W;
									           if(!empty($share['dlbl'])){//开启代理一级自定义模式
									             $bl['dlbl1']=$share['dlbl'];
									           }
									           $send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
									 					
									           if($cfg['jsms']==1){
									               if($send_time==$end_time){
									                 $addtime='jstime';
									               }else{
									                 $addtime='addtime';
									               }
									               if($zt==2){
									                 $addtime='addtime';
									               }
									           }else{
									             $addtime='addtime';
									           }
									 					//return $addtime."-----".$cfg['jsms']."----".$zt;
									           if($sd==1){
									           	$addtime='jstime';
									           }
									 					
									           if(empty($end_time)){
									             if(!empty($begin_time)){
									                 $where="and addtime>={$begin_time}";
									             }            
									           }else{            
									             if(!empty($begin_time)){
									               $where="and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
									             }
									           }
									           if($zt==1){
									             $ddzt=" and orderzt='订单结算'";
									           }elseif($zt==2){
									             $ddzt=" and orderzt='订单付款'";
									           }elseif($zt==3){
									             $ddzt=" and orderzt<>'订单失效'";
									           }
									           //return $where;
									           // 本月起始时间:
									            $bbegin_time= strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
									 					
									           //20170506修改
									           $rjshare=pdo_fetchall("SELECT id,helpid,tgwid FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and helpid='{$share['id']}' and dltype=1");//二级粉丝
									 					//return $where;
									           $r='';
									           foreach($rjshare as $k=>$v){
									           	  if(empty($v['qdid'])){
									           	  	$a=pdo_fetchcolumn("SELECT sum(xgyg) FROM ".tablename("tiger_newhu_tkorder")."  where weid='{$_W['uniacid']}' and tgwid='{$v['tgwid']}' {$ddzt} {$where}");//二级订单预估佣金合
									           	  }else{
									           	  	$a=pdo_fetchcolumn("SELECT sum(xgyg) FROM ".tablename("tiger_newhu_tkorder")."  where weid='{$_W['uniacid']}' and (tgwid='{$v['tgwid']}' || relation_id='{$v['qdid']}' ) {$ddzt} {$where}");//二级订单预估佣金合
									           	  }
									              
									              
									              $r=$r+$a;
									           }
									           $rjrs=$r;
									           //结束
									           if(!empty($bl['dlkcbl'])){
									             $rjrs=$rjrs*(100-$bl['dlkcbl'])/100;
									           }
									           if(empty($rjrs)){
									             $rjrs="0.00";
									           }
									           if($bl['dltype']==3){//三级代理模式
									              $fans1=pdo_fetchall("select id from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and dltype=1 and helpid='{$share['id']}'",array(),'id');//二级人数
									               if(!empty($fans1)){
									               	
									                 $sjrs = pdo_fetchcolumn("SELECT sum(t.xgyg) FROM " . tablename("tiger_newhu_share")." s left join ".tablename("tiger_newhu_tkorder")." t ON s.tgwid=t.tgwid where s.weid='{$_W['uniacid']}'   and s.dltype=1  {$ddzt} and s.helpid in (".implode(',',array_keys($fans1)).") {$where}");//三级订单统计
									                 
									                 
									               }
									               if(!empty($bl['dlkcbl'])){
									                 $sjrs=$sjrs*(100-$bl['dlkcbl'])/100;
									               }
									               if(empty($sjrs)){
									                 $sjrs="0.00";
									               }
									           }else{
									             $sjrs="0.00";
									           }
									           if($bl['dltype']==1){//只开一级代理模式，二三级都不计算
									               $rjrs="0.00";
									               $sjrs="0.00";            
									           }
									 
									           $array=array(
									              'yj2'=>$rjrs*$bl['dlbl2']/100,//二级订单求和  
									              'yj3'=>$sjrs*$bl['dlbl3']/100 //三级订单求和  
									           );
									           return $array;
									      }

      
         ?> 