<?php
//http://cs.tigertaoke.com/app/index.php?i=14&c=entry&do=jdtborder&m=tiger_newhu&time=2018061310
global $_W, $_GPC;
$weid=$_W['uniacid'];//绑定公众号的ID

include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/jd.php"; 
$jdset=pdo_fetch("select * from ".tablename('tuike_jd_jdset')." where weid='{$weid}' order by id desc");
$jdsign=pdo_fetch("select * from ".tablename('tuike_jd_jdsign')." where weid='{$weid}' order by id desc");
$time=date('Y-m-d H:i:s',time());

$sjarr=getDateFromRange($time,$time);


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
				//var_dump($res)."<br>";
//				exit;
//				echo "<pre>";
//				echo $time."执行过来<BR>";
				//print_r($res);
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
exit(json_encode("京东-----".date('Y-m-d',time()).'订单更新成功'));
exit;


//echo "<pre>";
//	echo 111;
//	print_r($jdset);
//print_r($jdsign);
//ECHO;
//exit;

//$time="2018061310";
if(empty($_GPC['time'])){
	$time=date('YmdH',time());	
}else{
	$time=$_GPC['time'];
}

//echo $time;
$page=1;
$res=getkhorder($jdsign['access_token'],$jdset['unionid'],$time,$jdset['appkey'],$jdset['appsecret'],$page);
//	echo "<pre>";
//print_r($res);
//exit;
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
	//	echo "<pre>";
	//print_r($data);
	//exit;
		 $ord=pdo_fetchall ( 'select * from ' . tablename ( $this->modulename . "_jdorder" ) . " where weid='{$_W['uniacid']}' and orderId='{$v['orderId']}'" );
		 if(empty($ord)){
		 	$a=pdo_insert ($this->modulename . "_jdorder", $data );
		 	//echo "插入成功";
		 }else{
		 	$b=pdo_update($this->modulename . "_jdorder",$data, array ('orderId' =>$v['orderId'],'weid'=>$_W['uniacid']));
		 	//echo "更新成功";
		 }
	}
	
}
exit(json_encode("京东-----".date('Y-m-d H点',time()).'订单更新成功'));

//Array
//(
//  [0] => Array
//      (
//          [finishTime] => 0
//          [orderEmt] => 2
//          [orderId] => 76809166629
//          [orderTime] => 1528857152000
//          [parentId] => 0
//          [payMonth] => 0
//          [plus] => 0
//          [popId] => 768075
//          [skuList] => Array
//              (
//                  [0] => Array
//                      (
//                          [actualCommission] => 0
//                          [actualCosPrice] => 0
//                          [actualFee] => 0
//                          [commissionRate] => 20
//                          [estimateCommission] => 7.8
//                          [estimateCosPrice] => 39
//                          [estimateFee] => 7.02
//                          [finalRate] => 90
//                          [firstLevel] => 11729
//                          [frozenSkuNum] => 0
//                          [payPrice] => 0
//                          [pid] => 
//                          [price] => 49
//                          [secondLevel] => 11731
//                          [siteId] => 0
//                          [skuId] => 28910047761
//                          [skuName] => 2018夏季新款拖鞋女外穿平底韩版时尚水钻套趾凉拖鞋女简约百搭 黑色 39
//                          [skuNum] => 1
//                          [skuReturnNum] => 0
//                          [spId] => 1339632433
//                          [subSideRate] => 90
//                          [subUnionId] => 
//                          [subsidyRate] => 0
//                          [thirdLevel] => 9775
//                          [traceType] => 2
//                          [unionAlias] => 
//                          [unionTag] => 00000000
//                          [unionTrafficGroup] => 4
//                          [validCode] => 16
//                      )
//
//              )
//
//          [unionId] => 1000768726
//          [unionUserName] => 
//          [validCode] => 16
//      )
//
//)

