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
        $where .=" and spId='{$share['jdpid']}'";
        //

        
        $day=date('Y-m-d');
        $day=strtotime($day);//今天0点时间戳   
        $dlwhere='';
        
        if($dd==1){//当日
            $dlwhere.=" and orderTime>{$day}";        
        }
        if($dd==2){//昨天
            $day3=strtotime(date("Y-m-d",strtotime("-1 day")));//昨天时间
            $dlwhere.=" and orderTime>{$day3} and orderTime<{$day}";        
        }
        if($dd==3){//本月
            // 本月起始时间:
            $bbegin_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
            $dlwhere.=" and orderTime>{$bbegin_time}";        
        }
				
        /* if(empty($zt)){
        	$zt=16;
        	$dlwhere.=" and validCode=".$zt; //1已成团 2确认收货  4订单失效
        }else{
           $dlwhere.=" and validCode=".$zt; //1已成团 2确认收货  4订单失效
        } */
				
				if($zt==-1 || $zt==3){
					$dlwhere.=" and validCode<=14";
				}elseif($zt==16 || $zt==1){
					$dlwhere.=" and validCode=16"; 
				}elseif($zt==18 || $zt==2){
					$dlwhere.=" and (validCode=18 or validCode=17)";
				}
        
        
       
        //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/inc/mobile/log.txt","\n".$dlwhere.'--订单付款--'.$where."select * from ".tablename("tiger_newhu_tkorder")." where weid='{$_W['uniacid']}' {$dlwhere}  {$where}   order by addtime desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}",FILE_APPEND);
		if(empty($_GPC['limit'])){
			$page=1;
		}else{
			$page=$_GPC['limit'];
		}
        $pindex = max(1, intval($page));
		$psize = 20;
        $list1 = pdo_fetchall("select * from ".tablename("tiger_newhu_jdorder")." where weid='{$_W['uniacid']}' {$dlwhere}  {$where}   order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_jdorder')." where weid='{$_W['uniacid']}'  {$dlwhere} {$where} ");
		$pager = pagination($total, $pindex, $psize);
//		echo "<pre>";
//      print_r($list1);
//      exit;

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
                  $dlyj=$value['estimateFee'];  
                }else{
                  if(!empty($bl['dlkcbl'])){
                     $xgyg=$value['estimateFee']*(100-$bl['dlkcbl'])/100;
                  }else{
                    $xgyg=$value['estimateFee'];
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
               $list[$key]['title'] = $value['skuName'];
               $list[$key]['numid'] = $value['skuId'];

               $list[$key]['fkprice'] = $value['estimateCosPrice'];
               if($bl['ddtype']==1){
                 $list[$key]['orderid'] = substr($value['orderId'], 0, -4)."****";
               }else{
                 $list[$key]['orderid'] = $value['orderId'];
               }               
               $list[$key]['xgyg'] = number_format($value['estimateFee'],2);
               
               if($value['validCode']==16){
               	 $list[$key]['orderzt']='已付';
               }elseif($value['validCode']==17){
               	 $list[$key]['orderzt']='已完';
               }elseif($value['validCode']==18){
               	 $list[$key]['orderzt']='已结算';
               }else{
               	 $list[$key]['orderzt']='失效';
               }
               
               
               $list[$key]['tgwid'] = $value['spId'];
               if(empty($value['estimateCosPrice']) || $value['estimateCosPrice']=='--'){
                 $list[$key]['estimateCosPrice'] = '0.00';//代理佣金$value['fkprice'];
               }else{
                 $list[$key]['estimateCosPrice'] = number_format($value['estimateCosPrice'],2);//代理佣金$value['fkprice'];
               }
               $list[$key]['createtime'] = date('Y-m-d H:i:s',$value['createtime']);
               $list[$key]['addtime'] =date('Y-m-d H:i:s',$value['orderTime']);
               if(empty($value['finishTime'])){
               	$list[$key]['jstime'] ="";
               }else{
               	$list[$key]['jstime'] =date('Y-m-d H:i:s',$value['finishTime']);
               }
               
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