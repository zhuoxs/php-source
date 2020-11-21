<?php
define('IN_MOBILE', true);
require '../../framework/bootstrap.inc.php';
$postStr = file_get_contents("php://input"); // 这里拿到微信返回的数据结果
libxml_disable_entity_loader(true);
$xmlstring = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
$payreturn = json_decode(json_encode($xmlstring),true);
if ($payreturn['result_code'] == 'SUCCESS' && $payreturn['result_code'] == 'SUCCESS') {

    $ordersn = trim($payreturn['out_trade_no']);
    $order = pdo_get('hcpdd_orders',array('ordersn'=>$ordersn));
    if ($order){
        //更新订单状态
        $order_data = array(
            'paystatus'=>1,
            'paytime'=>time(),
            'transid'=>$payreturn['transaction_id']
        );
        pdo_update('hcpdd_orders', $order_data, array('ordersn'=>$ordersn));

    }

    $fid = pdo_getcolumn('hcpdd_orders',array('ordersn'=>$ordersn),array('fid'));
    if($fid == 0){
        $user_data = array('is_daili'=>1);
        pdo_update('hcpdd_users', $user_data, array('user_id'=>$order['uid']));       //用户状态为代理
    }
    if($fid == 1)
    {
        $user_data = array('is_daili'=>2);
        pdo_update('hcpdd_users', $user_data, array('user_id'=>$order['uid']));       //用户状态为总监
    }
    echo 'success';
    return ;
}
