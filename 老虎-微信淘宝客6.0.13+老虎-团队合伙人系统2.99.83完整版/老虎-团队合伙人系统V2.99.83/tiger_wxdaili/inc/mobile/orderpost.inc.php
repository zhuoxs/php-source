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
//      $tgwarr=explode('|',$share['tgwid']);      
//      $where='';
//      if(!empty($share['tgwid'])){
//         $where .="and (";
//         foreach($tgwarr as $k=>$v){
//             $where .=" tgwid=".$v." or ";
//         }
//         $where .="tgwid=".$tgwarr[0].")";
//      }else{
//        $where .=" and tgwid=111111";
//      }
        if(empty($share['qdid'])){
	    	$where =" and tgwid='{$share['tgwid']}'";									    	
	    }else{
	    	$where =" and  (tgwid='{$share['tgwid']}' || relation_id='{$share['qdid']}') ";
	    }

        
        $day=date('Y-m-d');
        $day=strtotime($day);//今天0点时间戳   
        $dlwhere='';
        
        if($dd==1){//当日
            $dlwhere.=" and addtime>{$day}";        
        }
        if($dd==2){//昨天
            $day3=strtotime(date("Y-m-d",strtotime("-1 day")));//昨天时间
            $dlwhere.=" and addtime>{$day3} and addtime<{$day}";        
        }
        if($dd==3){//本月
            // 本月起始时间:
            $bbegin_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
            $dlwhere.=" and addtime>{$bbegin_time}";        
        }
        if($zt==1){//付款
          $dlwhere.=" and orderzt ='订单付款' ";
        }
        if($zt==2){//结算
          $dlwhere.=" and orderzt='订单结算'";
        }
        if($zt==3){//失效
          $dlwhere.=" and orderzt='订单失效'";
        }
        //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/inc/mobile/log.txt","\n".$dlwhere.'--订单付款--'.$where."select * from ".tablename("tiger_newhu_tkorder")." where weid='{$_W['uniacid']}' {$dlwhere}  {$where}   order by addtime desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}",FILE_APPEND);

        $pindex = max(1, intval($_GPC['limit']));
		$psize = 20;
        $list1 = pdo_fetchall("select * from ".tablename("tiger_newhu_tkorder")." where weid='{$_W['uniacid']}' {$dlwhere}  {$where}   order by addtime desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}'  {$dlwhere} {$where} ");
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
                  $dlyj=number_format($value['fkprice']*$dlbl/100,2);  
                }else{
                  if(!empty($bl['dlkcbl'])){
                     $xgyg=$value['xgyg']*(100-$bl['dlkcbl'])/100;
                  }else{
                    $xgyg=$value['xgyg'];
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
               $pic=$this->gettaopic($value['numid']);
               $list[$key]['title'] = $value['title'];
               $list[$key]['numid'] = $value['numid'];
               if($bl['ddtype']==1){
                 $list[$key]['orderid'] = substr($value['orderid'], 0, -4)."****";
               }else{
                 $list[$key]['orderid'] = $value['orderid'];
               }               
               $list[$key]['xgyg'] = number_format($value['xgyg'],2);
               $list[$key]['orderzt'] = $value['orderzt'];
               $list[$key]['tgwid'] = $value['tgwid'];
               if(empty($value['fkprice']) || $value['fkprice']=='--'){
                 $list[$key]['fkprice'] = '0.00';//代理佣金$value['fkprice'];
               }else{
                 $list[$key]['fkprice'] = number_format($value['fkprice'],2);//代理佣金$value['fkprice'];
               }
               $list[$key]['createtime'] = date('Y-m-d H:i:s',$value['createtime']);
               $list[$key]['addtime'] =date('Y-m-d H:i:s',$value['addtime']);
               $list[$key]['jstime'] =date('Y-m-d H:i:s',$value['jstime']);
               $list[$key]['dlyj'] =$dlyj;   
               $list[$key]['picurl'] =$pic;  
             }

            if (!empty($list)){
                $status=1;
            }else{
                $status=2;
            }
            exit(json_encode(array('status' => $status, 'content' => $list)));
?>