<?php

global $_W,$_GPC;

	$mid=intval($_GPC['mid']);
	$poid=intval($_GPC['orderid']);
	
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_orders')." WHERE weid=".$_W['uniacid']." AND id=".$poid);

	//$res['orderprice']=0.01;

	if($res){
		$n=rand(100001,999999);
		$tid = $poid.'_'.TIMESTAMP.$n;
        $params = array(
            'tid' => $tid, //交易模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
            'ordersn' => $tid, //收银台中显示的订单号
            'title' => '购买商品', //收银台中显示的标题
            'fee' => $res['orderprice'], //收银台中显示需要支付的金额,只能大于 0
            'user' => $_W['member']['uid']
        );
		//调用pay方法
		$this->pay($params);
       
	}
	

		
				
 

	
?>