<?php
  function tbsysy($share,$bl,$cfg){
   	// 上月起始时间:
         $sbegin_time = strtotime(date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y'))));//上个月开始时间
         $send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
  	 //上个月本人二级三级佣金 【订单结算1】
         $syygsum=bryj($share,$sbegin_time,$send_time,1,$bl,$cfg);
        
         $syygsum=number_format($syygsum, 2, '.', '');//上月本人预估所得佣金
         $syrsjyj=bydlyj($share,$sbegin_time,$send_time,1,$bl,$cfg);
         
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
          //return $sysjyj;
         if(empty($syzyj)){
            $syzyj="0.00";
         }
         return $syzyj;
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
									 			$dwhere=" and addtime>={$begin_time}";
									 		}   
									 	}else{
									 		if(!empty($begin_time)){
									 			$dwhere=" and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
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
									                 $where=" and addtime>={$begin_time}";
									             }            
									           }else{            
									             if(!empty($begin_time)){
									               $where=" and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
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
									           $rjshare=pdo_fetchall("SELECT id,helpid,tgwid,qdid FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and helpid='{$share['id']}' and dltype=1");//二级粉丝
									 		   //return $rjshare;
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
									               	
									                if($cfg['qdtype']==1){
									                	$sjrs = pdo_fetchcolumn("SELECT sum(t.xgyg) FROM " . tablename("tiger_newhu_share")." s left join ".tablename("tiger_newhu_tkorder")." t ON s.qdid=t.relation_id where s.weid='{$_W['uniacid']}'   and s.dltype=1 and s.qdid<>0 {$ddzt} and s.helpid in (".implode(',',array_keys($fans1)).") {$where}");//三级订单统计
									                }else{														
									                	$sjrs = pdo_fetchcolumn("SELECT sum(t.xgyg) FROM " . tablename("tiger_newhu_share")." s left join ".tablename("tiger_newhu_tkorder")." t ON s.tgwid=t.tgwid where s.weid='{$_W['uniacid']}'   and s.dltype=1  {$ddzt} and s.helpid in (".implode(',',array_keys($fans1)).") {$where}");//三级订单统计
									                }
									                 
									                 
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