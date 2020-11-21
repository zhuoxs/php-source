<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$id = intval($_GPC['orderid']);
$status = trim($_GPC['status']);
$totalprice = floatval($_GPC['totalprice']);
$remark = trim($_GPC['remark']);

$orderstatus = array('cancel' => -1, 'confirm' => 1, 'finish' => 3, 'pay' => 2, 'updateprice' => 4, 'print' => 5);

if (empty($orderstatus[$status])) {
    message('对不起，您没有该功能的操作权限!!');
}

if (empty($from_user)) {
    message('会话已过期，请重新发送关键字!');
}

$is_permission = false;
$tousers = explode(',', $setting['tpluser']);
if (in_array($from_user, $tousers)) {
    $is_permission = true;
}
if ($is_permission == false) {
    $accounts = pdo_fetchall("SELECT storeid FROM " . tablename($this->table_account) . " WHERE weid = :weid AND from_user=:from_user AND
 status=2 AND is_admin_order=1 ORDER BY id DESC ", array(':weid' => $this->_weid, ':from_user' => $from_user));
    if ($accounts) {
        $arr = array();
        foreach ($accounts as $key => $val) {
            $arr[] = $val['storeid'];
        }
        $storeids = implode(',', $arr);
        $is_permission = true;
    }
}

if ($is_permission == false) {
    message('对不起，您没有该功能的操作权限!');
}

$order = $this->getOrderById($id);
$store = $this->getStoreById($order['storeid']);
if (empty($order)) {
    message('订单不存在');
}

//处理打印
if ($orderstatus[$status] == 5) {
    $position_type = intval($_GPC['position_type']);
    $this->_feieSendFreeMessage($id, $position_type);
    $this->_feiyinSendFreeMessage($id, $position_type);
    $this->_365SendFreeMessage($id, $position_type);
    $this->_365lblSendFreeMessage($id, $position_type);
    $this->_yilianyunSendFreeMessage($id, $position_type);
    $this->_jinyunSendFreeMessage($id, $position_type);
    message('操作成功！！', $this->createMobileUrl('adminorderdetail', array('orderid' => $id), true), 'success');
}

$user = $this->getFansByOpenid($from_user);
$touser = empty($user['nickname'])?$user['from_user']:$user['nickname'];

$paylog = pdo_fetch("SELECT * FROM " . tablename('core_paylog') . " WHERE tid=:tid AND uniacid=:uniacid AND status=0 AND module='weisrc_dish'
ORDER BY plid
DESC LIMIT 1", array(':tid' => $order['id'], ':uniacid' => $this->_weid));

$update_data = array(
    'totalprice' => $totalprice,
    'remark' => $remark
);

if ($orderstatus[$status] == 2) { //支付
    $update_data['ispay'] = 1;
    $update_data['paytime'] = TIMESTAMP;
    pdo_update($this->table_order, $update_data, array('id' => $order['id']));
    $this->addOrderLog($id, $touser, 2, 1, 2);

} else if ($orderstatus[$status] == 4) { //改价

    pdo_update($this->table_order, $update_data, array('id' => $order['id']));
    $this->addOrderLog($id, $touser, 2, 1, 7, $order['totalprice'], $totalprice);

} else if ($orderstatus[$status] == -1) { //取消

    if ($order['ispay'] == 1) {
        $update_data['ispay'] = 2;//待退款
    }
    $update_data['status'] = $orderstatus[$status];
    pdo_update($this->table_order, $update_data, array('id' => $order['id']));


    $this->cancelfengniao($order, $store, $setting);

    $this->addOrderLog($id, $touser, 2, 1, 5);

} elseif ($orderstatus[$status] == 1) { //确认

    $update_data['confirmtime'] = TIMESTAMP;
    $update_data['status'] = $orderstatus[$status];
    pdo_update($this->table_order, $update_data, array('id' => $order['id']));
    pdo_update($this->table_service_log, array('status' => 1), array('orderid' => $id));
    $this->addOrderLog($id, $touser, 2, 1, 3);

} else if ($orderstatus[$status] == 3) { //完成

    $update_data['finishtime'] = TIMESTAMP;
    $update_data['status'] = $orderstatus[$status];
    pdo_update($this->table_order, $update_data, array('id' => $order['id']));
    if ($setting['is_yunzhong'] == 1) {
        $this->yunshop_completeOrder($id);
    }
    $this->addOrderLog($id, $touser, 2, 1, 4);

    $this->updateFansData($order['from_user']);
    $this->updateFansFirstStore($order['from_user'], $order['storeid']);
    if ($order['isfinish'] == 0) {
        //计算积分
        $this->setOrderCredit($order['id']);
        pdo_update($this->table_order, array('isfinish' => 1), array('id' => $id));
        pdo_update($this->table_service_log, array('status' => 1), array('orderid' => $id));
        $fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE weid = :weid  AND from_user=:from_user ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':from_user' => $order['from_user']));
        pdo_update($this->table_fans, array('paytime' => TIMESTAMP), array('id' => $fans['id']));
        if ($order['dining_mode'] == 1) {
            pdo_update($this->table_tables, array('status' => 0), array('id' => $order['tables']));
        }
        $this->set_commission($order['id']);
        //奖励配送员
        $delivery_money = floatval($order['delivery_money']);//配送佣金
        $delivery_id = intval($order['delivery_id']);//配送员
        if ($delivery_money > 0) {
            $data = array(
                'weid' => $_W['uniacid'],
                'storeid' => $order['storeid'],
                'orderid' => $order['id'],
                'delivery_id' => $delivery_id,
                'price' => $delivery_money,
                'dateline' => TIMESTAMP,
                'status' => 0
            );
            pdo_insert("weisrc_dish_delivery_record", $data);
        }
    }
}
if (!empty($paylog) && $orderstatus[$status] != -1) {
    pdo_update('core_paylog', array('fee' => $totalprice), array('plid' => $paylog['plid']));
}
if ($this->_accountlevel == 4) {
    $order = $this->getOrderById($id);
    $this->sendOrderNotice($order, $store, $setting);
}
message('操作成功！！', $this->createMobileUrl('adminorderdetail', array('orderid' => $id), true), 'success');