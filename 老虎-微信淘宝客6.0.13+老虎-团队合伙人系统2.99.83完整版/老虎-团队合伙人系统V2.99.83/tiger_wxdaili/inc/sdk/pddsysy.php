<?php
  function pddsysy($share,$bl,$cfg){
   	// 上月起始时间:
         $sbegin_time = strtotime(date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y'))));//上个月开始时间
         $send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
         //上个月本人二级三级佣金 【确认收货】
         $syygsum=pddbryj($share,$sbegin_time,$send_time,2,$bl,$cfg);
         $syygsum=number_format($syygsum, 2, '.', '');//上月本人预估所得佣金
         $syrsjyj=pddbydlyj($share,$sbegin_time,$send_time,2,$bl,$cfg);
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
         return $syzyj;
  }
  
  
  /*
            拼多多 二级 三级订单
      $share 一级粉丝信息
      $begin_time 订单开始时间  order_pay_time  按支付时间来筛选
      $end_time 订单结束时间 不传结束时间到当天 order_pay_time
      $zt 订单状态：order_status   -1 未支付; 0-已支付；1-已成团；2-确认收货；3-审核成功；4-审核失败（不可提现）；5-已经结算；8-非多多进宝商品（无佣金订单）
      $set 比率
      promotion_amount 预估佣金
     */
     function pddbydlyj($share,$begin_time,$end_time='',$zt,$bl,$cfg){//本人二级，三级订单 订单结算//代理抽成比例
          global $_W;
          if(!empty($share['dlbl'])){//开启代理一级自定义模式
            $bl['dlbl1']=$share['dlbl'];
          }
          $send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
          $addtime='order_pay_time';

          if(empty($end_time)){
            if(!empty($begin_time)){
                $where="and order_pay_time>={$begin_time}";
            }            
          }else{            
            if(!empty($begin_time)){
              $where="and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
            }
          }

//        $ddzt=" and order_status='{$zt}'";
          if($zt==2){
				  	$ddzt=" and (order_status='{$zt}' || order_status=5 || order_status=3)";
				  }else{
				  	$ddzt=" and (order_status='{$zt}')";
				  }
          //return $where;
          // 本月起始时间:
          $bbegin_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
          //$rjrs = pdo_fetchcolumn("SELECT sum(t.xgyg) FROM " . tablename("tiger_newhu_share")." s left join ".tablename("tiger_newhu_tkorder")." t ON s.tgwid=t.tgwid where s.weid='{$_W['uniacid']}' and s.helpid='{$share['openid']}' {$ddzt} and s.dltype=1 {$where}");//二级订单预估佣金合

          //20170506修改
          $rjshare=pdo_fetchall("SELECT id,helpid,pddpid FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and helpid='{$share['id']}' and dltype=1");//二级粉丝
          $r='';
          foreach($rjshare as $k=>$v){
             $a=pdo_fetchcolumn("SELECT sum(promotion_amount) FROM ".tablename("tiger_newhu_pddorder")."  where weid='{$_W['uniacid']}' and p_id='{$v['pddpid']}' {$ddzt} {$where}");//二级订单预估佣金合
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
                $sjrs = pdo_fetchcolumn("SELECT sum(t.promotion_amount) FROM " . tablename("tiger_newhu_share")." s left join ".tablename("tiger_newhu_pddorder")." t ON s.pddpid=t.p_id where s.weid='{$_W['uniacid']}'   and s.dltype=1  {$ddzt} and s.helpid in (".implode(',',array_keys($fans1)).") {$where}");//三级订单统计
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
    /*
            拼多多 本人订单
      $share 一级粉丝信息
      $begin_time 订单开始时间  order_pay_time  按支付时间来筛选
      $end_time 订单结束时间 不传结束时间到当天 order_pay_time
      $zt 订单状态：order_status   -1 未支付; 0-已支付；1-已成团；2-确认收货；3-审核成功；4-审核失败（不可提现）；5-已经结算；8-非多多进宝商品（无佣金订单）
      $set 比率
      promotion_amount 预估佣金
     */
    function pddbryj($share,$begin_time,$end_time,$zt,$bl,$cfg,$sd=0){//本人订单//代理抽成比例
      global $_W;
      if(!empty($share['dlbl'])){//开启代理自定义模式
        $bl['dlbl1']=$share['dlbl'];
      }
      $send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
      
      // 本月起始时间:
      $bbegin_time1 = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
      $bend_time1 = strtotime(date("Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), date ( "t" ),date( "Y" ))));      
      $addtime='order_pay_time';//最后更新时间

      if(empty($end_time)){
         if(!empty($begin_time)){
           $dwhere="and order_pay_time>={$begin_time}";
         }   
      }else{
        if(!empty($begin_time)){
          $dwhere="and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
        }        
      }
//      $ddzt=" and order_status='{$zt}'";
        if($zt==2){
			  	$ddzt=" and (order_status='{$zt}' || order_status=5 || order_status=3)";
			  }else{
			  	$ddzt=" and (order_status='{$zt}')";
			  }
      //本人推广位PID
      $where =" and p_id='{$share['pddpid']}'";
      //本人结束
      $byygsum = pdo_fetchcolumn("SELECT sum(promotion_amount) FROM " . tablename('tiger_newhu_pddorder')." where weid='{$_W['uniacid']}'  {$ddzt} {$dwhere} {$where}");//本月本人预估实际佣金
//     file_put_contents(IA_ROOT."/addons/tiger_wxdaili/inc/sdk/yj-log.txt","\n--UID:".$share['id']."---".$bl['fxtype']."----".$ddzt."----".$dwhere."----".$where."-----yun:".$byygsum,FILE_APPEND);
      if(!empty($bl['dlkcbl'])){
        $byygsum=$byygsum*(100-$bl['dlkcbl'])/100;
      }
//    file_put_contents(IA_ROOT."/addons/tiger_wxdaili/inc/sdk/yj-log.txt","\n--".$bl['fxtype']."----".$ddzt."----".$dwhere."----".$where."-----yun:".$byygsum."-----kc:".$byygsum,FILE_APPEND);
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
//    file_put_contents(IA_ROOT."/addons/tiger_wxdaili/inc/sdk/yj-log.txt","\n--".$bl['fxtype']."----DJ:".$dj."----Y3:".$yj3."----Y2:".$yj2."-----Y1:".$yj1."-----js:".$byygsum,FILE_APPEND);
      return $byygsum;
    }
?>