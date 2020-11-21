<?php
global $_W, $_GPC;
        $openid=$_GPC['openid'];
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        //$tgwarr=explode('|',$share['tgwid']);
        $cfg = $this->module['config'];


        $where='';
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

         $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
//         $fsbl=$this->tqbl($share,$bl,$cfg);

			$dldata=pdo_fetch("select * from ".tablename('tiger_wxdaili_dlshuju')." where weid='{$_W['uniacid']}' and uid='{$share['id']}'");  


        $pindex = max(1, intval($_GPC['page']));
		$psize = 20;
        $name=$_GPC['name'];

        if (!empty($name)){
          $where1 .= " and orderid ='{$name}'";
          $where='';
        }

		$list1 = pdo_fetchall("select * from ".tablename("tiger_newhu_tkorder")." where weid='{$_W['uniacid']}' {$where} {$where1}  order by addtime desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}'  {$where} {$where1} ");
		$pager = pagination($total, $pindex, $psize);

        $fs=$this->jcbl($share,$bl);
        $cj=$fs['cj'];//粉丝层级 1 2 3
        
        if(empty($share['dlbl'])){
          $dlbl=$bl['dlbl1'];
        }else{
          $dlbl=$fs['bl'];
        }

        foreach ($list1 as $key => $value) {
        	
               if($cfg['fytype']==1){//按付款金额计算
                  $dlyj=number_format($value['fkprice']*$dlbl/100,2);  
               }else{//按佣金计算
                  if(!empty($bl['dlkcbl'])){//是否平台扣除一部分后计算
                     $xgyg=$value['xgyg']*(100-$bl['dlkcbl'])/100;
                     $kcyj=$value['xgyg']*$bl['dlkcbl']/100;
                  }else{
                    $xgyg=$value['xgyg'];
                  }
                  $zcyj=$xgyg*$dlbl/100;//正常所得佣金
                  if($bl['fxtype']==1){//普通大众
                    $dlyj=number_format($zcyj,2);
                  }else{// 0 抽成模式
                     if($cj==2){//2级被一级抽走
                        $yjcc=$zcyj*$bl['dlbl1t2']/100;//被1级抽在一部分
                        $dlyj=$zcyj-$yjcc;
                        $dlyj=number_format($dlyj,2);
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
//			   $dlyj=$this->dljiangli($value['fkprice'],$v['tkrates'],$bl,$share);
               $pic=$this->gettaopic($value['numid']);
               $list[$key]['title'] = $value['title'];
               $list[$key]['numid'] = $value['numid'];
               if($bl['ddtype']==1){
                 $list[$key]['orderid'] = substr($value['orderid'], 0, -4)."****";
               }else{
                 $list[$key]['orderid'] = $value['orderid'];
               }                              
               $list[$key]['orderzt'] = $value['orderzt'];//订单状态：订单失效   订单付款    订单结算
               $list[$key]['tgwid'] = $value['tgwid'];
               $list[$key]['fkprice'] = number_format($value['fkprice'],2);//付款金额
               $list[$key]['createtime'] = date('Y-m-d H:i:s',$value['createtime']);
               $list[$key]['addtime'] =date('Y-m-d H:i:s',$value['addtime']);//订单付款时间
               $list[$key]['jstime'] =date('Y-m-d H:i:s',$value['jstime']);//订单确认收货时间               
               $list[$key]['picurl'] =$pic;
               $list[$key]['pt']=$value['pt'];
               $list[$key]['shopname']=$value['shopname'];
               $list[$key]['xgyg'] = number_format($value['xgyg'],2);//预估佣金
               $list[$key]['dlkcbl']=$bl['dlkcbl'];//平台扣除比例
               $list[$key]['kcyj']=$kcyj;//平台扣除佣金
               $list[$key]['srbl']=$value['srbl'];//收入比例
               $list[$key]['fcbl']=$value['fcbl'];//分成比例
               $list[$key]['dlbl']=$dlbl;//代理所得比例
               $list[$key]['dlyj'] =$dlyj;//代理所得佣金
               $list[$key]['yjcc']=$yjcc;//二级状态，被一级抽走
               $list[$key]['ejcyj']=$ejcyj;//三级状态 , 被二级抽走
               $list[$key]['sjcyj']=$sjcyj;//三级状态 , 被一级抽走
               $list[$key]['cj']=$cj;//层级 


             }





//        echo '<pre>';
//        print_r($list);
//        exit;
        include $this->template ( 'memberorder' );    
?>