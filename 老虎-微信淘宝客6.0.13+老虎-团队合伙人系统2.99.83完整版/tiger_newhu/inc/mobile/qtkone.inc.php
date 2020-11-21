<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        $miyao=$_GPC['miyao'];
        if($miyao!==$cfg['miyao']){
		exit(json_encode(array('status' => 2, 'content' => '密钥错误，请检测秘钥，或更新缓存！')));
        }
				
	$content=htmlspecialchars_decode($_GPC['content']);
	file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/qtk--ordernews.txt","\n:".$content,FILE_APPEND);
	$userInfo = @json_decode($content, true);
	$list=$userInfo['data']['list'];
	file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/qtk--ordernews.txt","\n:2".json_encode($list),FILE_APPEND);
	if(!empty($list)){
		foreach($list as $k=>$v){
			$fztype=pdo_fetch("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}' and qtktype='{$v['goods_cat']}'");
			
			if($v['is_ju']==1){
				$activity_type="聚划算";
			}
			if($v['is_tqg']==1){
				$activity_type="淘抢购";
			}
			if($v['is_tmall']==1){
				$shoptype="B";
			}else{
				$shoptype="C";
			}
			$item = array(
						'weid' => $_W['uniacid'],
						'fqcat'=>$fztype['id'],
						'zy'=>1,
						'tktype'=>"定向计划",
						'itemid'=>$v['goods_id'],//商品ID
						'itemtitle'=>$v['goods_title'],//商品名称
						'itemdesc'=>$v['goods_introduce'],//推荐内容
						'itempic'=>$v['goods_pic'],//主图地址
						'itemprice'=>$v['goods_price'],//'商品原价', 
						'itemendprice'=>$v['goods_price']-$v['coupon_price'],//商品价格,券后价
						'itemsale'=>$v['goods_sales'],//月销售
						'tkrates'=>$v['commission'],//通用佣金比例
						'couponreceive'=>"",//优惠券总量已领取数量
						'couponsurplus'=>"",//优惠券剩余
						'couponmoney'=>$v['coupon_price'],//优惠券面额
						'couponendtime'=>strtotime($v['coupon_end_time']),//优惠券结束
						'couponurl'=>"",//优惠券链接
						'shoptype'=>$shoptype,//'0不是  1是天猫',
						'quan_id'=>$v['activity_id'],//'优惠券ID',  
						'couponexplain'=>$v['coupon_apply_amount'],//'优惠券使用条件',  					
						'tkurl'=>"",
						'activity_type'=>$activity_type,//活动类型（普通活动、聚划算、淘抢购）
						'createtime'=>TIMESTAMP,
					);
			
			$go = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and  itemid='{$v['goods_id']}' ORDER BY id desc");
			if(empty($go)){
				$upa=pdo_insert($this->modulename."_newtbgoods",$item);
				//echo "更新".$upa;
			}else{
				$ina=pdo_update($this->modulename."_newtbgoods", $item, array('weid'=>$_W['uniacid'],'itemid' => $v['goods_id']));
				//echo "插入".$ina;
			}  
			
		}
	}
	
	
    echo "轻淘客 第".$_GPC['page']."页采集【入库】成功";