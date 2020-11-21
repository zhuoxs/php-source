 <?php     
 	global $_W, $_GPC;
    $cfg = $this->module['config'];
	$uid=$_GPC['uid'];
	if(empty($uid)){
		exit("no uid");
	}
    
    
    
     $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");   
    
     $appset= pdo_fetch("SELECT * FROM " . tablename("tiger_app_tuanzhangset") . " WHERE weid='{$_W['uniacid']}' order by px desc ");//团长设置
    
 	$member=pdo_fetchall("select id,nickname,tgwid,qdid,tztime,helpid from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1");
 	//echo "<pre>";
 		//echo 111;
 		//echo $dllist;
 	//print_r($member);
 	//exit;
 	
// 	$member = array(
//			array('id'=>1, 'agentid'=>0, 'nickname' => 'A'), 
//			array('id'=>2, 'agentid'=>1, 'nickname' => 'B'),
//			array('id'=>3, 'agentid'=>1, 'nickname' => 'C'),
//			array('id'=>4, 'agentid'=>8, 'nickname' => 'D'),
//			array('id'=>5, 'agentid'=>3, 'nickname' => 'E'),
//			array('id'=>6, 'agentid'=>3, 'nickname' => 'F'),
//			array('id'=>7, 'agentid'=>3, 'nickname' => 'G'),
//			array('id'=>8, 'agentid'=>8, 'nickname' => 'H')
//		);
		 
		/*
		*2.获取某个会员的无限下级方法
		*$members是所有会员数据表,$mid是用户的id
		*/
		function GetTeamMember($members, $mid) {
			$Teams=array();//最终结果
			$shareteam=array();
			$mids=array($mid);//第一次执行时候的用户id
			do {
				$othermids=array(); 
				$state=false;
				foreach ($mids as $valueone) {
					foreach ($members as $key => $valuetwo) {
						if($valuetwo['helpid']==$valueone){
							$shareteam['id']=$valuetwo[id];
							$shareteam['nickname']=$valuetwo['nickname'];
							$shareteam['helpid']=$valuetwo['helpid'];
							$shareteam['tgwid']=$valuetwo['tgwid'];
							$shareteam['qdid']=$valuetwo['qdid'];
							$shareteam['tztime']=$valuetwo['tztime'];
							$Teams[]=$shareteam;//$valuetwo[id];//找到我的下级立即添加到最终结果中
							$othermids[]=$valuetwo['id'];//将我的下级id保存起来用来下轮循环他的下级
							array_splice($members,$key,1);//从所有会员中删除他
							$state=true;	
						}
					}			
				}
				$mids=$othermids;//foreach中找到的我的下级集合,用来下次循环
			} while ($state==true);
		 
			return $Teams;
		}
		
		$qdtype=$cfg['qdtype'];//渠道开关,1开启渠道的,同步渠道ID的订单
		
		$res=GetTeamMember($member,$share['id']);
// 		echo "<pre>";
// 		print_r($res);
// 		exit;
		
		$byyjsum=0;
		$syyjsum=0;
		$jrfkyj=0;
		$zrfkyj=0;
		$tztemrs=sizeof($res);//团长人数
		foreach($res as $k=>$v){
			$yjs=yjsun($v['id'],$share['tztime'],$appset,$_W['uniacid'],$qdtype);//下级后
			
			$byyjsum=$byyjsum+$yjs['byfkyj'];//本月团长所有代理付款佣金
			$syyjsum=$syyjsum+$yjs['syjsyj'];//上月团长所有代理结算佣金
			$jrfkyj=$jrfkyj+$yjs['jrfkyj'];//今日团长所有代理付款佣金
			$zrfkyj=$zrfkyj+$yjs['zrfkyj'];//昨日团长所有代理付款佣金
		}
		
		
		$xjyjs=yjsun($share['id'],$share['tztime'],$appset,$_W['uniacid'],$qdtype);//团长一级的佣金
		$tzzgjs=tzzgsun($share['id'],$share['tztime'],$appset,$_W['uniacid'],$qdtype);//团长自购
// 		echo "<pre>";
// 		print_r($xjyjs);
// 		exit;

		

		
		$bytimeday =date("Ym", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" )));//本月月份
		$tzyjdata=array(
			'weid'=>$_W['uniacid'],
			'uid'=>$share['id'],
			'month'=>$bytimeday,
			'nickname'=>$share['nickname'],
			'openid'=>$share['from_user'],
			'msg'=>"最后更新时间：".date("Y-m-d H:i:s",time()),
			'tbbyfkprice'=>$byyjsum+$xjyjs['byfkyj']+$tzzgjs['byfkyj'],
			'tbsyjsprice'=>$syyjsum+$xjyjs['syjsyj']+$tzzgjs['syjsyj'],
			'tbjrfkprice'=>$jrfkyj+$xjyjs['jrfkyj']+$tzzgjs['jrfkyj'],
			'tbzrfkprice'=>$zrfkyj+$xjyjs['zrfkyj']+$tzzgjs['zrfkyj'],
			'createtime'=>time()
		);
		
		 $mothshuju=pdo_fetch("select * from ".tablename('tiger_wxdaili_tzyjlog')." where weid='{$_W['uniacid']}' and month='{$bytimeday}' and uid='{$share['id']}'");  
// 		 echo "<pre>";
// 		 print_r($mothshuju);
// 		 exit;
		 if($mothshuju){
		 	$result=pdo_update("tiger_wxdaili_tzyjlog", $tzyjdata, array('month' => $bytimeday,'uid'=>$share['id'],'weid'=>$_W['uniacid']));
		 }else{
		 	$result=pdo_insert("tiger_wxdaili_tzyjlog", $tzyjdata);
		 }
		
		
		exit(json_encode(array('byfkyj'=>$byyjsum+$xjyjs['byfkyj']+$tzzgjs['byfkyj'],'syjsyj'=>$syyjsum+$xjyjs['syjsyj']+$tzzgjs['syjsyj'],'jrfkyj'=>$jrfkyj+$xjyjs['jrfkyj']+$tzzgjs['jrfkyj'],'zrfkyj'=>$zrfkyj+$xjyjs['zrfkyj']+$tzzgjs['zrfkyj'])));


	    // 团购自购佣金
		function tzzgsun($uid,$sharetztime,$appset,$weid,$qdtype){			
			$daytime=strtotime(date("Y-m-d 00:00:00"));//今天0点
			$zttime=strtotime(date("Y-m-d 00:00:00",strtotime("-1 day")));//昨天0点
			$b_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));//本月开始时间
			$sy_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
			//本月付款
			if($qdtype==1){
				$byyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where relation_id in (select qdid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and id='{$uid}'  and qdid!=0 ) and addtime>'{$b_time}' and orderzt='订单付款' and weid='{$weid}'");//and addtime>='{$sharetztime}'
			}else{
				$byyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where tgwid in (select tgwid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and id='{$uid}') and addtime>'{$b_time}' and orderzt='订单付款' and weid='{$weid}'");//and addtime>='{$sharetztime}'
			}
			 if(empty($byyj)){
				 $byyj="0.00";
			 }else{
				 $byyj=number_format($byyj*$appset['jl']/100, 2, '.', '');
			 }
			 // 上月
			 if($qdtype==1){
			 	 $syyj=pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")." where relation_id in (select qdid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and id='{$uid}'  and qdid!=0 ) and jstime<='{$b_time}' and jstime>='{$sy_time}' and orderzt='订单结算' and weid='{$weid}'");
			 }else{
			 	$syyj=pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")." where tgwid in (select tgwid from ".tablename("tiger_newhu_share")."  where weid='{$weid}' and dltype=1 and id='{$uid}') and jstime<='{$b_time}' and jstime>='{$sy_time}' and orderzt='订单结算' and weid='{$weid}'");
			 }			 
			 if(empty($syyj)){
			 	$syyj="0.00";
			 }else{
			 	$syyj=number_format($syyj*$appset['jl']/100, 2, '.', '');
			 }
			 // 今日
			 if($qdtype==1){
			 	$jrfkyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where relation_id in (select qdid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and id='{$uid}'  and qdid!=0 ) and addtime>='{$daytime}' and orderzt='订单付款' and weid='{$weid}' ");//and addtime>='{$sharetztime}'
			 }else{
			 	$jrfkyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where tgwid in (select tgwid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and id='{$uid}') and addtime>='{$daytime}' and orderzt='订单付款' and weid='{$weid}' ");//and addtime>='{$sharetztime}'
			 }			 
			 if(empty($jrfkyj)){
			 	$jrfkyj="0.00";
			 }else{
			 	 $jrfkyj=number_format($jrfkyj*$appset['jl']/100, 2, '.', '');
			 }
			 //昨日付款
			 if($qdtype==1){
			 	$zrfkyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where relation_id in (select qdid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and id='{$uid}'  and qdid!=0 ) and addtime>='{$daytime}' and  addtime<='{$zttime}' and orderzt='订单付款' and weid='{$weid}'");// and addtime>'{$sharetztime}'
			 }else{
			 	$zrfkyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where tgwid in (select tgwid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and id='{$uid}') and addtime>='{$daytime}' and  addtime<='{$zttime}' and orderzt='订单付款' and weid='{$weid}'");// and addtime>'{$sharetztime}'
			 }
			  if(empty($zrfkyj)){
			 	 $zrfkyj="0.00";
			  }else{
			 	 $zrfkyj=number_format($zrfkyj*$appset['jl']/100, 2, '.', '');
			  }
			  
			  return array('byfkyj'=>$byyj,'syjsyj'=>$syyj,'jrfkyj'=>$jrfkyj,'zrfkyj'=>$zrfkyj);
		}
		
		// 团长下级
		function yjsun($shareid,$sharetztime,$appset,$weid,$qdtype=0){
			$daytime=strtotime(date("Y-m-d 00:00:00"));//今天0点
            $zttime=strtotime(date("Y-m-d 00:00:00",strtotime("-1 day")));//昨天0点
			$b_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));//本月开始时间
		    $sy_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
		    
		    //本月付款
			if($qdtype==1){
				$byyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where relation_id in (select qdid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and helpid='{$shareid}'  and qdid!=0 ) and addtime>'{$b_time}' and orderzt='订单付款' and weid='{$weid}'");//and addtime>='{$sharetztime}'
			}else{
				$byyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where tgwid in (select tgwid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and helpid='{$shareid}') and addtime>'{$b_time}' and orderzt='订单付款' and weid='{$weid}'");//and addtime>='{$sharetztime}'
			}
			 if(empty($byyj)){
				 $byyj="0.00";
			 }else{
				 $byyj=number_format($byyj*$appset['jl']/100, 2, '.', '');
			 }
			 //return pdo_debug($byyj);
			 
			 
			 //上月结算佣金
			 //$syyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where tgwid in (select tgwid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and helpid='{$shareid}') and jstime<='{$b_time}' and jstime>='{$sy_time}' and orderzt='订单结算' and weid='{$weid}'");//and addtime>='{$sharetztime}'
			 if($qdtype==1){
				 $syyj=pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")." where relation_id in (select qdid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and helpid='{$shareid}'  and qdid!=0 ) and jstime<='{$b_time}' and jstime>='{$sy_time}' and orderzt='订单结算' and weid='{$weid}'");
			 }else{
				 $syyj=pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")." where tgwid in (select tgwid from ".tablename("tiger_newhu_share")."  where weid='{$weid}' and dltype=1 and helpid='{$shareid}') and jstime<='{$b_time}' and jstime>='{$sy_time}' and orderzt='订单结算' and weid='{$weid}'");
			 }
			 
			 if(empty($syyj)){
				 $syyj="0.00";
			 }else{
				 $syyj=number_format($syyj*$appset['jl']/100, 2, '.', '');
			 }
			//return $shareid."---".$syyj."---".$weid."---".$b_time."---".$sy_time."----".$syyj;
			 
			 //今日付款佣金
			 if($qdtype==1){
				 $jrfkyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where relation_id in (select qdid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and helpid='{$shareid}'  and qdid!=0 ) and addtime>='{$daytime}' and orderzt='订单付款' and weid='{$weid}' ");//and addtime>='{$sharetztime}'
			 }else{
				 $jrfkyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where tgwid in (select tgwid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and helpid='{$shareid}') and addtime>='{$daytime}' and orderzt='订单付款' and weid='{$weid}' ");//and addtime>='{$sharetztime}'
			 }
			 
			 if(empty($jrfkyj)){
				 $jrfkyj="0.00";
			 }else{
				 $jrfkyj=number_format($jrfkyj*$appset['jl']/100, 2, '.', '');
			 }
			 
			//昨日付款
			if($qdtype==1){
				$zrfkyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where relation_id in (select qdid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and helpid='{$shareid}'  and qdid!=0 ) and addtime>='{$daytime}' and  addtime<='{$zttime}' and orderzt='订单付款' and weid='{$weid}'");// and addtime>'{$sharetztime}'
			}else{
				$zrfkyj = pdo_fetchcolumn("select SUM(xgyg) from ".tablename("tiger_newhu_tkorder")."  where tgwid in (select tgwid from ".tablename("tiger_newhu_share")." where weid='{$weid}' and dltype=1 and helpid='{$shareid}') and addtime>='{$daytime}' and  addtime<='{$zttime}' and orderzt='订单付款' and weid='{$weid}'");// and addtime>'{$sharetztime}'
			}
		    
			 if(empty($zrfkyj)){
				 $zrfkyj="0.00";
			 }else{
				 $zrfkyj=number_format($zrfkyj*$appset['jl']/100, 2, '.', '');
			 }
			 
			 
			 
			 
			 return array('byfkyj'=>$byyj,'syjsyj'=>$syyj,'jrfkyj'=>$jrfkyj,'zrfkyj'=>$zrfkyj);
		}


?>