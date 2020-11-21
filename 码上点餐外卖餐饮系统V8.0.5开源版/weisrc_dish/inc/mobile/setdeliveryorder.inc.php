<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$id = intval($_GPC['orderid']);
$status = trim($_GPC['status']);


if (empty($from_user)) {
    message('会话已过期，请重新发送关键字!');
}

$is_permission = false;
$deliveryuser = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " where weid=:weid AND role=4 AND from_user=:from_user AND status=2
LIMIT 1", array(':weid' => $weid, ':from_user' => $from_user));
if ($deliveryuser) {
    $is_permission = true;
}

if ($is_permission == false) {
    message('对不起，您没有该功能的操作权限!');
}

$order = $this->getOrderById($id);
if (empty($order)) {
    message('订单不存在');
}
//if ($order['status'] != 1) {
//    message('该订单商家还未确认，不能配送!');
//}
$user = $this->getFansByOpenid($from_user);
$op = $_GPC['op'];
if ($op == 'acceptorder') {
    if ($order['delivery_status'] > 0) {
        message('对不起，该订单已经在配送中!');
    }

    $delivery_order_max = intval($setting['delivery_order_max']);
    if ($delivery_order_max != 0) { //限制配送量
        $delivery_order_total = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_order) . " WHERE weid=:weid AND delivery_status=1 AND
delivery_id=:delivery_id AND status<>-1 ", array(':delivery_id' => $deliveryuser['id'], ':weid' => $weid));
        if ($delivery_order_total >= $delivery_order_max) {
            message("您同时只能配送{$delivery_order_max}单!");
        }
    }

    $delivery_money = floatval($setting['delivery_money']);//每单固定佣金
    if ($setting['delivery_commission_mode'] == 2) { //商品佣金
        $delivery_money = 0;
        $goods = pdo_fetchall("SELECT a.goodsid,a.total,b.delivery_commission_money FROM " . tablename($this->table_order_goods) . " a INNER JOIN
" . tablename($this->table_goods) . " b ON a.goodsid=b.id WHERE a.orderid = :orderid", array(':orderid' => $id));
        foreach ($goods as $key => $val) {
            $delivery_money = $delivery_money + floatval($val['delivery_commission_money']) * intval($val['total']);
        }
    }
    if ($setting['delivery_commission_mode'] == 3) { //订单配送费为佣金
        $delivery_money = floatval($order['dispatchprice']);
    }
    if ($order['status'] == 0) {
        $update_data['status'] = 1;
    }
    $update_data['delivery_status'] = 1;
    $update_data['delivery_id'] = $deliveryuser['id'];
    $update_data['delivery_money'] = $delivery_money;
    $update_data['deliveryareaid'] = intval($deliveryuser['areaid']);
    pdo_update($this->table_order, $update_data, array('id' => $id));
    $order = $this->getOrderById($id);
    $this->sendUserDeliveryNotice($order, $setting);
    $this->setOrderServiceRead($id);
    message('接单成功！！', $this->createMobileUrl('deliveryorderdetail', array('orderid' => $id), true), 'success');
} else if ($op == 'payorder') {
    $update_data['ispay'] = 1;
    pdo_update($this->table_order, $update_data, array('id' => $order['id']));
} else {
    message('未知操作');
}

message('操作成功！！', $this->createMobileUrl('deliveryorderdetail', array('orderid' => $id), true), 'success');