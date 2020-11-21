<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];

        $openid=$_GPC['openid'];
        $dd=$_GPC['dd'];
        $zt=$_GPC['zt'];
        $id=$_GPC['id'];//share id
        if(!empty($id)){
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$id}'");
        }else{
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        }        
        $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
        
        $where='';
        $where .=" and p_id='{$share['pddpid']}'";
        //

        
        $day=date('Y-m-d');
        $day=strtotime($day);//今天0点时间戳   
        $dlwhere='';
        
        if($dd==1){//当日
            $dlwhere.=" and order_pay_time>{$day}";        
        }
        if($dd==2){//昨天
            $day3=strtotime(date("Y-m-d",strtotime("-1 day")));//昨天时间
            $dlwhere.=" and order_pay_time>{$day3} and order_pay_time<{$day}";        
        }
        if($dd==3){//本月
            // 本月起始时间:
            $bbegin_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
            $dlwhere.=" and order_pay_time>{$bbegin_time}";        
        }
        /* if(empty($zt)){
        	$zt=1;
        	$dlwhere.=" and order_status=".$zt; //1已成团 2确认收货  4订单失效
        }else{
           $dlwhere.=" and order_status=".$zt; //1已成团 2确认收货  4订单失效
        } */
				
				if($zt==4 || $zt==3){
					$dlwhere.=" and (order_status_desc='审核失败' or order_status_desc='未支付'  or order_status_desc='非多多进宝商品')"; //1已成团 2确认收货  4订单失效
				}elseif($zt==1){
					$dlwhere.=" and order_status_desc='已成团'"; 
				}elseif($zt==2){
					$dlwhere.=" and (order_status_desc='确认收货' or order_status_desc='已结算'  or order_status_desc='审核通过')"; 
				}
				
       
        //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/inc/mobile/log.txt","\n".$dlwhere.'--订单付款--'.$where."select * from ".tablename("tiger_newhu_tkorder")." where weid='{$_W['uniacid']}' {$dlwhere}  {$where}   order by addtime desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}",FILE_APPEND);

        $pindex = max(1, intval($_GPC['limit']));
		$psize = 20;
        $list1 = pdo_fetchall("select * from ".tablename("tiger_newhu_pddorder")." where weid='{$_W['uniacid']}' {$dlwhere}  {$where}   order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_pddorder')." where weid='{$_W['uniacid']}'  {$dlwhere} {$where} ");
		$pager = pagination($total, $pindex, $psize);

		

        //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/inc/mobile/log.txt","\n".json_encode($list1),FILE_APPEND);

        $fs=$this->jcbl($share,$bl);
        $cj=$fs['cj'];//粉丝层级 1 2 3
        

        if($bl['fxtype']==1){//大众模式
           if(empty($share['dlbl'])){
              $dlbl=$bl['dlbl1'];
            }else{
              $dlbl=$fs['bl'];
            }
        }else{
          $dlbl=$fs['bl'];
        }
        


         foreach ($list1 as $key => $value) {
               if($cfg['fytype']==1){
                  $dlyj=$value['promotion_amount'];  
                }else{
                  if(!empty($bl['dlkcbl'])){
                     $xgyg=$value['promotion_amount']*(100-$bl['dlkcbl'])/100;
                  }else{
                    $xgyg=$value['promotion_amount'];
                  }
                  $zcyj=$xgyg*$dlbl/100;//正常所得佣金
                  if($bl['fxtype']==1){//普通大众
                    $dlyj=number_format($zcyj,2);
                  }else{// 0 抽成模式
                     if($cj==2){//2级被一级抽走
                        $yjcc=$zcyj-($zcyj*$bl['dlbl1t2']/100);//被1级抽在一部分
                        $dlyj=number_format($yjcc,2);
                     }elseif($cj==3){
                        $ejcyj=$zcyj*$bl['dlbl2t3']/100;//被2级抽一部分
                        $sjcyj=$zcyj*$bl['dlbl1t3']/100;//被1级抽一部分
                        $dlyj=$zcyj-$ejcyj-$sjcyj;
                        $dlyj=number_format($dlyj,2);
                     }else{//1级不用抽成
                       $dlyj=number_format($zcyj,2);
                     }
                  }
                  
                }
               $list[$key]['title'] = $value['goods_name'];
               $list[$key]['numid'] = $value['goods_id'];

               $list[$key]['fkprice'] = $value['order_amount'];
               if($bl['ddtype']==1){
                 $list[$key]['orderid'] = substr($value['order_sn'], 0, -4)."****";
               }else{
                 $list[$key]['orderid'] = $value['order_sn'];
               }               
               $list[$key]['xgyg'] = number_format($value['promotion_amount'],2);
               $list[$key]['orderzt'] = $value['order_status_desc'];
               $list[$key]['tgwid'] = $value['p_id'];
               if(empty($value['order_amount']) || $value['order_amount']=='--'){
                 $list[$key]['order_amount'] = '0.00';//代理佣金$value['fkprice'];
               }else{
                 $list[$key]['order_amount'] = number_format($value['order_amount'],2);//代理佣金$value['fkprice'];
               }
               $list[$key]['createtime'] = date('Y-m-d H:i:s',$value['createtime']);
               $list[$key]['addtime'] =date('Y-m-d H:i:s',$value['order_create_time']);
               $list[$key]['jstime'] =date('Y-m-d H:i:s',$value['order_receive_time']);
               $list[$key]['dlyj'] =$dlyj;   
               $list[$key]['picurl'] =$value['goods_thumbnail_url'];  
             }

            if (!empty($list)){
                $status=1;
            }else{
                $status=2;
            }
            exit(json_encode(array('status' => $status, 'content' => $list)));
?>