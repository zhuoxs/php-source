<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        $miyao=$_GPC['miyao'];
        if($miyao!==$cfg['miyao']){
		exit(json_encode(array('status' => 2, 'content' => '密钥错误，请检测秘钥，或更新缓存！')));
        }
				
	$content=htmlspecialchars_decode($_GPC['content']);
	//file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/ysd--ordernews.txt","\n:".$content,FILE_APPEND);
	$userInfo = @json_decode($content, true);
	$list=$userInfo['data']['items'];
	//file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/ysd--ordernews.txt","\n:2".json_encode($list),FILE_APPEND);
	if(!empty($list)){
		foreach($list as $k=>$v){
			$fztype=pdo_fetch("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}' and ysdtype='{$v['cid']}'");
			$shoptype=$v['shop_type'];
			if($v['isjhs']==1){
				$activity_type="聚划算";
			}
			if($v['istqg']==1){
				$activity_type="淘抢购";
			}
			$item = array(
						'weid' => $_W['uniacid'],
						'fqcat'=>$fztype['id'],
						'zy'=>1,
						'tktype'=>"定向计划",
						'itemid'=>$v['num_iid'],//商品ID
						'itemtitle'=>$v['title'],//商品名称
						'itemdesc'=>$v['intro'],//推荐内容
						'itempic'=>$v['pic_url'],//主图地址
						'itemprice'=>$v['coupon_price']+$v['quan'],//'商品原价', 
						'itemendprice'=>$v['coupon_price'],//商品价格,券后价
						'itemsale'=>$v['shouchu'],//月销售
						'tkrates'=>$v['commission_rate']/100,//通用佣金比例
						'couponreceive'=>"",//优惠券总量已领取数量
						'couponsurplus'=>"",//优惠券剩余
						'couponmoney'=>$v['quan'],//优惠券面额
						'couponendtime'=>$v['coupon_end_time'],//优惠券结束
						'couponurl'=>"",//优惠券链接
						'shoptype'=>$shoptype,//'0不是  1是天猫',
						'quan_id'=>$v['activity_id'],//'优惠券ID',  
						'couponexplain'=>$v['coupon_apply_amount'],//'优惠券使用条件',  					
						'tkurl'=>"",
						'activity_type'=>$activity_type,//活动类型（普通活动、聚划算、淘抢购）
						'createtime'=>TIMESTAMP,
					);
			
			$go = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and  itemid='{$v['num_iid']}' ORDER BY id desc");
			if(empty($go)){
				$upa=pdo_insert($this->modulename."_newtbgoods",$item);
				//echo "更新".$upa;
			}else{
				$ina=pdo_update($this->modulename."_newtbgoods", $item, array('weid'=>$_W['uniacid'],'itemid' => $v['num_iid']));
				//echo "插入".$ina;
			}  
			
		}
	}
	
	
    echo "一手单 第".$_GPC['page']."页采集【入库】成功";