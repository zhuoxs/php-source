<?php
//你这傻逼，你爸爸的代码好看吗，日你妈，MMB
global $_W,$_GPC;
$orderid = $_GPC['orderid'];
if(empty($orderid)){
	message('参数错误','','error');
}
$order = pdo_fetch("select * from " .tablename('n1ce_mission_orderlog'). " where id = :id",array(':id'=>$orderid));
$params = array(
    'tid' => $order['tid'],      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
    'ordersn' => $order['tid'],  //收银台中显示的订单号
    'title' => '支付兑换商品',          //收银台中显示的标题
    'fee' => $order['fee']/100,      //收银台中显示需要支付的金额,只能大于 0
    'user' => $_W['member']['uid'],     //付款用户, 付款的用户名(选填项)
);
//调用pay方法
$this->pay($params);