<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        $miyao=$_GPC['miyao'];
        if($miyao!==$cfg['miyao']){
		exit(json_encode(array('status' => 2, 'content' => '密钥错误，请检测秘钥，或更新缓存！')));
        }
				
	$content=htmlspecialchars_decode($_GPC['content']);
	//file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/hpt--ordernews.txt","\n:".$_GPC['content'],FILE_APPEND);
	$userInfo = @json_decode($content, true);
	$userInfo = @json_decode($content, true);
	$list=$userInfo['data']['result'];
	//file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/hpt--ordernews.txt","\n:2".json_encode($list),FILE_APPEND);
	if(!empty($list)){
		foreach($list as $k=>$v){
			$fztype=pdo_fetch("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}' and hpttype='{$v['Cid']}'");
			if($v['IsTmall']==1){
				$shoptype="B";
			}else{
				$shoptype="C";
			}
			
			$item = array(
						'weid' => $_W['uniacid'],
						'fqcat'=>$fztype['id'],
						'zy'=>1,
						'tktype'=>"定向计划",
						'itemid'=>$v['GoodsID'],//商品ID
						'itemtitle'=>$v['Title'],//商品名称
						'itemdesc'=>$v['Introduce'],//推荐内容
						'itempic'=>$v['Pic'],//主图地址
						'itemprice'=>$v['Org_Price'],//'商品原价', 
						'itemendprice'=>$v['Price'],//商品价格,券后价
						'itemsale'=>$v['Sales_num'],//月销售
						'tkrates'=>$v['Commission_jihua'],//通用佣金比例
						'couponreceive'=>"",//优惠券总量已领取数量
						'couponsurplus'=>"",//优惠券剩余
						'couponmoney'=>$v['Quan_price'],//优惠券面额
						'couponendtime'=>strtotime($v['Quan_time']),//优惠券结束
						'couponurl'=>"",//优惠券链接
						'shoptype'=>$shoptype,//'0不是  1是天猫',
						'quan_id'=>$v['Quan_id'],//'优惠券ID',  
						'couponexplain'=>$v['Quan_condition'],//'优惠券使用条件',  					
						'tkurl'=>"",
						'activity_type'=>'普通活动',//活动类型（普通活动、聚划算、淘抢购）
						'createtime'=>TIMESTAMP,
					);
			
			$go = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and  itemid='{$v['GoodsID']}' ORDER BY id desc");
			if(empty($go)){
				$upa=pdo_insert($this->modulename."_newtbgoods",$item);
				//echo "更新".$upa;
			}else{
				$ina=pdo_update($this->modulename."_newtbgoods", $item, array('weid'=>$_W['uniacid'],'itemid' => $v['GoodsID']));
				//echo "插入".$ina;
			}  
			
		}
	}
	
        echo "好品推 第".$_GPC['page']."页采集【入库】成功";