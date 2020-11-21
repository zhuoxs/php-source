<?php
//http://cs.tigertaoke.com/app/index.php?i=14&c=entry&do=jdtborder&m=tiger_newhu&time=2018061310
global $_W, $_GPC;
		$weid=$_W['uniacid'];//绑定公众号的ID
		$cfg = $this->module['config'];
		 $miyao=$_GPC['miyao'];
		 if($miyao!==$cfg['miyao']){
			exit(json_encode(array('status' => 2, 'content' => '密钥错误，请检测秘钥，或更新缓存！')));
		 }
		 
		 $content=htmlspecialchars_decode($_GPC['content']);
		 //file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/jd--ordernews.txt","\n dantiao:". $content,FILE_APPEND);
         $news=@json_decode($content, true);
		// exit(json_encode($news['data'][0]['finishTime']));

//exit;
if(!empty($news['data'])){

	foreach($news['data'] as $k=>$v){
		if(empty($v['orderId'])){
			continue;
		}
		$data=array(
		    'weid'=>$_W['uniacid'],
		    'finishTime'=>substr($v['finishTime'] , 0 , 10), //订单完成时间
		    'orderEmt'=>$v['orderEmt'],//下单设备(1:PC,2:无线)
		    'orderId'=>$v['orderId'],//订单ID
		    'orderTime'=>substr($v['orderTime'] , 0 , 10),//下单时间
		    'parentId'=>$v['parentId'],//父单ID（订单拆分后,父单的订单号）
		    'payMonth'=>$v['payMonth'],//结算日期（yyyyMMdd）
		    'plus'=>$v['plus'],//会员（0：不是，1：是）
		    'popId'=>$v['popId'],		//商家ID    
		    'actualCommission'=>$v['skuList'][0]['actualCommission'],//：实际佣金
		    'actualCosPrice'=>$v['skuList'][0]['actualCosPrice'],//实际计佣金额
		    'actualFee'=>$v['skuList'][0]['actualFee'],//站长的实际佣金
		    'commissionRate'=>$v['skuList'][0]['commissionRate'],//佣金比例
		    'estimateCommission'=>$v['skuList'][0]['estimateCommission'],//预估佣金
		    'estimateCosPrice'=>$v['skuList'][0]['estimateCosPrice'],//预估计佣金额
		    'estimateFee'=>$v['skuList'][0]['estimateFee'],//站长的预估佣金
		    'finalRate'=>$v['skuList'][0]['finalRate'],//最终比例 (一级分佣比例*二级分佣比例)；
		    'firstLevel'=>$v['skuList'][0]['firstLevel'],//一级类目
		    'frozenSkuNum'=>$v['skuList'][0]['frozenSkuNum'],//商品售后中数量
		    'payPrice'=>$v['skuList'][0]['payPrice'],//实际支付金额
		    'pid'=>$v['skuList'][0]['pid'],//子站长ID_子站长网站ID_子站长推广位ID
		    'price'=>$v['skuList'][0]['price'],//商品单价
		    'secondLevel'=>$v['skuList'][0]['secondLevel'],//二级类目
		    'siteId'=>$v['skuList'][0]['siteId'],//网站ID
		    'skuId'=>$v['skuList'][0]['skuId'],//商品ID
		    'skuName'=>$v['skuList'][0]['skuName'],//商品名称
		    'skuNum'=>$v['skuList'][0]['skuNum'],//商品数量
		    'skuReturnNum'=>$v['skuList'][0]['skuReturnNum'],//商品已退货数量
		    'spId'=>$v['skuList'][0]['spId'],//推广位ID
		    'subSideRate'=>$v['skuList'][0]['subSideRate'],//分成比例
		    'subUnionId'=>$v['skuList'][0]['subUnionId'],//子联盟ID
		    'subsidyRate'=>$v['skuList'][0]['subsidyRate'],//补贴比例
		    'thirdLevel'=>$v['skuList'][0]['thirdLevel'],//三级类目
		    'traceType'=>$v['skuList'][0]['traceType'],//2同店 3跨店
		    'unionAlias'=>$v['skuList'][0]['unionAlias'],//第三方服务来源
		    'unionTrafficGroup'=>$v['skuList'][0]['unionTrafficGroup'],//渠道组（1：1号店，其他：京东）
		    'unionTag'=>$v['skuList'][0]['unionTag'],//unionTag
		    'validCode'=>$v['skuList'][0]['validCode'],//有效码（-1---14.无效-来源与备案网址不符,15.待付款,16.已付款,17.已完成,18.已结算）
		    
		    'unionId'=>$v['unionId'],//站长ID
		    'unionUserName'=>$v['unionUserName'],//扩展信息(euId,需要联系运营开放白名单才能拿到数据)
		    'createtime'=>time()
		);
		echo json_encode($data);
	//	echo "<pre>";
	//print_r($data);
	//exit;
		 $ord=pdo_fetchall ( 'select * from ' . tablename ( $this->modulename . "_jdorder" ) . " where weid='{$_W['uniacid']}' and orderId='{$v['orderId']}'" );
		 if(empty($ord)){
			if(!empty($data['estimateFee'])){
				$a=pdo_insert ($this->modulename . "_jdorder", $data );
			}
		 	echo "插入成功";
		 }else{
			if(!empty($data['estimateFee'])){
				$b=pdo_update($this->modulename . "_jdorder",$data, array ('orderId' =>$v['orderId'],'weid'=>$_W['uniacid']));
			}
		 	echo "更新成功";
		 }
	}
	
}
exit(json_encode("订单上传成功！"));

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

