<?php
        global $_W, $_GPC;
        $weid=$_W['uniacid'];//绑定公众号的ID
        $pindex = max(1, intval($_GPC['page']));
		$psize = 20;
        $order=$_GPC['order'];
        $zt=$_GPC['zt'];
        $op=$_GPC['op'];
        $dd=$_GPC['dd'];
        
      if($op==1){//同步
      	include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/jd.php"; 
		$jdset=pdo_fetch("select * from ".tablename('tuike_jd_jdset')." where weid='{$weid}' order by id desc");
		$jdsign=pdo_fetch("select * from ".tablename('tuike_jd_jdsign')." where weid='{$weid}' order by id desc");
		$sjarr=getDateFromRange($_GPC['starttime'], $_GPC['endtime']);
		foreach($sjarr as $k=>$v){
			$xs=date('Ymd',strtotime($v));
			for ($x=0; $x<=24; $x++) {
				if($x<10){
					$time=$xs.'0'.$x;
					//echo $rq."<br>";
				}else{
					$time=$xs.$x;
					//echo $rq."<br>";
				}
				$page=1;
				//echo $time."<BR>";
//				echo $jdsign['access_token']."<BR>";
//				echo $jdset['unionid']."<BR>";
//				echo $jdset['appkey']."<BR>";
//				echo $jdset['appsecret']."<BR>";
				$res=getkhorder($jdsign['access_token'],$jdset['unionid'],$time,$jdset['appkey'],$jdset['appsecret'],$page);
				var_dump($res)."<br>";
//				exit;
//				echo "<pre>";
//				echo $time."执行过来<BR>";
				print_r($res);
//				EXIT;
				if(!empty($res)){
					foreach($res as $k=>$v){
						$data=array(
						    'weid'=>$_W['uniacid'],
						    'finishTime'=>substr($v['finishTime'] , 0 , 10),
						    'orderEmt'=>$v['orderEmt'],
						    'orderId'=>$v['orderId'],
						    'orderTime'=>substr($v['orderTime'] , 0 , 10),
						    'parentId'=>$v['parentId'],
						    'payMonth'=>$v['payMonth'],
						    'plus'=>$v['plus'],
						    'popId'=>$v['popId'],
						    
						    'actualCommission'=>$v['skuList'][0]['actualCommission'],
						    'actualCosPrice'=>$v['skuList'][0]['actualCosPrice'],
						    'actualFee'=>$v['skuList'][0]['actualFee'],
						    'commissionRate'=>$v['skuList'][0]['commissionRate'],
						    'estimateCommission'=>$v['skuList'][0]['estimateCommission'],
						    'estimateCosPrice'=>$v['skuList'][0]['estimateCosPrice'],
						    'estimateFee'=>$v['skuList'][0]['estimateFee'],
						    'finalRate'=>$v['skuList'][0]['finalRate'],
						    'firstLevel'=>$v['skuList'][0]['firstLevel'],
						    'frozenSkuNum'=>$v['skuList'][0]['frozenSkuNum'],
						    'payPrice'=>$v['skuList'][0]['payPrice'],
						    'pid'=>$v['skuList'][0]['pid'],
						    'price'=>$v['skuList'][0]['price'],
						    'secondLevel'=>$v['skuList'][0]['secondLevel'],
						    'siteId'=>$v['skuList'][0]['siteId'],
						    'skuId'=>$v['skuList'][0]['skuId'],
						    'skuName'=>$v['skuList'][0]['skuName'],
						    'skuNum'=>$v['skuList'][0]['skuNum'],
						    'skuReturnNum'=>$v['skuList'][0]['skuReturnNum'],
						    'spId'=>$v['skuList'][0]['spId'],
						    'subSideRate'=>$v['skuList'][0]['subSideRate'],
						    'subUnionId'=>$v['skuList'][0]['subUnionId'],
						    'subsidyRate'=>$v['skuList'][0]['subsidyRate'],
						    'thirdLevel'=>$v['skuList'][0]['thirdLevel'],
						    'traceType'=>$v['skuList'][0]['traceType'],
						    'unionAlias'=>$v['skuList'][0]['unionAlias'],
						    'unionTrafficGroup'=>$v['skuList'][0]['unionTrafficGroup'],
						    'unionTag'=>$v['skuList'][0]['unionTag'],
						    'validCode'=>$v['skuList'][0]['validCode'],
						    
						    'unionId'=>$v['unionId'],
						    'unionUserName'=>$v['unionUserName'],
						    'createtime'=>time()
						);
						//echo "<pre>";
					//print_r($data);
					//exit;
						 $ord=pdo_fetchall ( 'select * from ' . tablename ( $this->modulename . "_jdorder" ) . " where weid='{$_W['uniacid']}' and orderId='{$v['orderId']}'" );
						 if(empty($ord)){
						 	if(!empty($data['orderId'])){
						 		$a=pdo_insert ($this->modulename . "_jdorder", $data );
						 	}						 	
						 	//echo "插入成功";
						 }else{
						 	if(!empty($v['orderId'])){
						 		$b=pdo_update($this->modulename . "_jdorder",$data, array ('orderId' =>$v['orderId'],'weid'=>$_W['uniacid']));
						 	}
						 	//echo "更新成功";
						 }
					}				
					
				}
			} 
		}
		message('订单同步成功', '', 'error');
		exit;
      }
      
      function getDateFromRange($startdate, $enddate){
	    $stimestamp = strtotime($startdate);
	    $etimestamp = strtotime($enddate);
	    // 计算日期段内有多少天
	    $days = ($etimestamp-$stimestamp)/86400+1;
	    // 保存每天日期
	    $date = array();
	    for($i=0; $i<$days; $i++){
	        $date[] = date('Y-m-d', $stimestamp+(86400*$i));
	    }
	    return $date;
	}
	
	if(checksubmit('submitdel')){//删除
			if(!$_GPC['id']){
            	 message('请选择订单', referer(), 'error');
        	}
            foreach ($_GPC['id'] as $id){
                $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename.'_jdorder') . " WHERE id = :id", array(':id' => $id));

                if (empty($row)){
                    continue;
                }
                pdo_delete($this->modulename."_jdorder",array('id'=>$id));
            }
            message('批量删除成功', referer(), 'success');        	
    }
        
       


       if($op=='seach'){
           if (!empty($order)){
              $where .= " and (orderId='{$order}' or spId='{$order}')  ";
            }
//            if (!empty($zt)){
//              $where .= " and orderzt='{$zt}'";
//            }
           $day=date('Y-m-d');
           $day=strtotime($day);//今天0点时间戳  

            if($dd==1){//当日
                $where.=" and orderTime>{$day}";        
            }
            if($dd==2){//昨天
                $day3=strtotime(date("Y-m-d",strtotime("-1 day")));//昨天时间
                $where.=" and orderTime>{$day3} and orderTime<{$day}";        
            }
            if($dd==3){//本月
                // 本月起始时间:
                $bbegin_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
                $where.=" and orderTime>{$bbegin_time}";        
            }
            if($dd==4){
                 // 上月起始时间:
                 //$sbegin_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
                 $sbegin_time = strtotime(date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y'))));//上个月开始时间
                 $send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
                 if($zt==2){//按结算时间算
                   $where.="and finishTime>{$sbegin_time} and finishTime<{$send_time}";
                 }else{
                   $where.="and orderTime>{$sbegin_time} and orderTime<{$send_time}";
                 }
                 
            }
            if($zt==9){//已失效
              $where.=" and validCode<=14";
            }
            if($zt==16){//已付款
              $where.=" and validCode=16";
            }
            if($zt==17){//确认收货
              $where.=" and validCode=17";
            }
            if($zt==18){//已结算
              $where.=" and validCode=18";
            }
       
       }
       echo $where;

        

		$list = pdo_fetchall("select * from ".tablename($this->modulename."_jdorder")." where weid='{$_W['uniacid']}' {$where} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_jdorder')." where weid='{$_W['uniacid']}'  {$where}");
		$pager = pagination($total, $pindex, $psize);
//      $totalsum = pdo_fetchcolumn("SELECT sum(xgyg) FROM " . tablename($this->modulename.'_jdorder')." where weid='{$_W['uniacid']}'  {$where}");

//echo "<pre>";
//print_r($list);



        include $this->template ( 'jdorder' );

