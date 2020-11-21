<?php
set_time_limit(0);
ob_end_clean();
 global $_W, $_GPC;
        
        $cfg = $this->module['config'];
        $dtkapp_key=$cfg['dtkapp_key'];
		$dtkapp_secret=$cfg['dtkapp_secret'];
		if(empty($pageId)){
			$pageId=1;
		}
        //echo '<pre>';
        //print_r($dtklist);
        //exit; 
		
		function makeSign($data, $appSecret)
		{
			ksort($data);
			$str = '';
			foreach ($data as $k => $v) {
				$str .= '&' . $k . '=' . $v;
			}
			$str = trim($str, '&');
			$sign = strtoupper(md5($str . '&key=' . $appSecret));
			return $sign;
		}

		function newgoodslist($pageId,$dtkapp_key,$dtkapp_secret){
			//接口地址
			$host = 'https://openapi.dataoke.com/api/goods/get-goods-list';
			$appKey = $dtkapp_key;//应用的key
			$appSecret = $dtkapp_secret;//应用的Secret
			//默认必传参数
			$data = [
				'appKey' => $dtkapp_key,
				'version' => '1',
				'pageId'=>$pageId,
			];
			//加密的参数
			$data['sign'] = makeSign($data,$appSecret);
			//拼接请求地址
			$url = $host .'?'. http_build_query($data);
			//var_dump($url);			
			//执行请求获取数据
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch,CURLOPT_TIMEOUT,10);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		}


        $op=$_GPC['op'];
    if($op=='qcljcp'){//全站领卷采集		
		$goods=newgoodslist($pageId,$dtkapp_key,$dtkapp_secret);
		$userInfo = @json_decode($goods, true);
		$pageId=$userInfo['data']['pageId'];
		if(empty($pageId)){
			$pageId=1;
		}
		if(empty($userInfo['data']['list'])){
			message('温馨提示：该采集任务已完成！', $this->createWebUrl('dtkcaijinew'), 'success');
		}else{
			indtkgoods($userInfo['data']['list'],$cfg);
			message('温馨提示：请不要关闭页面，采集任务正在进行中！（' . $pageId . '）', $this->createWebUrl('dtkcaijinew', array('op' => 'qcljcp','pageId' =>$pageId)), 'success');
		}						
	 }
	 
	 
	 function indtkgoods($dtklist,$cfg) {//大淘客入库
	     global $_W, $_GPC;
	     $page=$_GPC['page'];

	     foreach($dtklist as $v){
	             $fztype=pdo_fetch("select * from ".tablename("tiger_newhu_fztype")." where weid='{$_W['uniacid']}' and dtkcid='{$v['cid']}' order by px desc");
	             //file_put_contents(IA_ROOT."/addons/tiger_newhu/log-type.txt","\n old:".json_encode($fztype),FILE_APPEND);
	             if($v['commissionType']==0){//定向
	               $lxtype='通用';
	               $yjbl=$v['commissionRate'];
	             }elseif($v['commissionType']==1){
	               $lxtype='定向';
	               $yjbl=$v['commissionRate'];
	             }elseif($v['commissionType']==2){
					 $lxtype='高佣';
					 $yjbl=$v['commissionRate'];
				 }elseif($v['commissionType']==3){
					 $lxtype='营销计划';
					 $yjbl=$v['commissionRate'];
				 }
	             if($v['shopType']==1){
	             	$shoptype='B';
	             }else{
	             	$shoptype='C';
	             }
				 $v['couponLink']=$v['couponLink']."&";
				 $Quan_id=Text_qzj($v['couponLink'],"activityId=","&");
				 if(empty($Quan_id)){
					 continue;
				 }
	 
	             $item = array(
	                      'weid' => $_W['uniacid'],
	                      'fqcat'=>$fztype['id'],
	                      'zy'=>1,
	                      'tktype'=>$lxtype,
	                      'itemid'=>$v['goodsId'],//商品ID
	                      'itemtitle'=>$v['dtitle'],//商品名称
	                      'itemdesc'=>$v['desc'],//推荐内容
	                      'itempic'=>$v['mainPic'],//主图地址
						  'itemprice'=>$v['originalPrice'],//'商品原价',
	                      'itemendprice'=>$v['actualPrice'],//商品价格,券后价
	                      'itemsale'=>$v['monthSales'],//月销售
	                      'tkrates'=>$yjbl,//通用佣金比例
	                       'couponreceive'=>$v['couponTotalNum'],//优惠券总量已领取数量
	                       'couponsurplus'=>$v['couponReceiveNum'],//优惠券剩余
	                       'couponmoney'=>$v['couponPrice'],//优惠券面额
	                       'couponendtime'=>strtotime($v['couponEndTime']),//优惠券结束
	                       'couponurl'=>$v['couponLink'],//优惠券链接
	                       'shoptype'=>$shoptype,//'0不是  1是天猫',
	                       'quan_id'=>$Quan_id,//'优惠券ID',  
	                       'couponexplain'=>$v['couponConditions'],//'优惠券使用条件',  
	                        
	                       'tkurl'=>$v['Jihua_link'],
	                       'createtime'=>TIMESTAMP,
	                     );
	                    $go = pdo_fetch("SELECT itemid FROM " . tablename("tiger_newhu_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and  itemid={$v['goodsId']} ");
	                     if(empty($go)){
	                       pdo_insert("tiger_newhu_newtbgoods",$item);
	                     }else{
	                        // file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode("up02:".$go['num_iid']),FILE_APPEND);
	                       pdo_update("tiger_newhu_newtbgoods", $item, array('weid'=>$_W['uniacid'],'itemid' => $v['goodsId']));
	                     }  
	                    
	         }
	     
	 }
	 
	 function Text_qzj($Text,$Front,$behind) {
	 			//语法：strpos(string,find,start)
	 			//函数返回字符串在另一个字符串中第一次出现的位置，如果没有找到该字符串，则返回 false。
	 			//参数描述：
	 			//string 必需。规定被搜索的字符串。
	 			//find   必需。规定要查找的字符。
	 			//start  可选。规定开始搜索的位置。
	 			
	 			//语法：string mb_substr($str,$start,$length,$encoding)
	 			//参数描述：
	 			//str      被截取的母字符串。
	 			//start    开始位置。
	 			//length   返回的字符串的最大长度,如果省略，则截取到str末尾。
	 			//encoding 参数为字符编码。如果省略，则使用内部字符编码。
	 				
	 				$t1 = mb_strpos(".".$Text,$Front);
	 				if($t1==FALSE){
	 					return "";
	 				}else{
	 					$t1 = $t1-1+strlen($Front);
	 				}
	 				$temp = mb_substr($Text,$t1,strlen($Text)-$t1);
	 				$t2 = mb_strpos($temp,$behind);
	 				if($t2==FALSE){
	 					return "";
	 				}
	 				return mb_substr($temp,0,$t2);
	 			}
	 
        include $this->template ( 'dtkcaiji' );       