<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$id = intval($_GPC['orderid']);
$cur_nave = 'order';

$setting = $this->getSetting();

$order = pdo_fetch("SELECT a.* FROM " . tablename($this->table_order) . " AS a LEFT JOIN " . tablename($this->table_stores) . " AS b ON a.storeid=b.id  WHERE a.id =:id AND a.from_user=:from_user ORDER BY a.id DESC LIMIT 1", array(':id' => $id, ':from_user' => $from_user));

if (empty($order)) {
    message('订单不存在!');
}

$op = $_GPC['op'];
if ($op == 'acceptorder') { //收货
    if ($order['from_user'] != $from_user) {
        if ($_W['isajax']) {
            $this->showMsg('您没有该订单的操作权限!', 1);
        } else {
            message('您没有该订单的操作权限!');
        }
    }
    pdo_update($this->table_order, array('delivery_status' => 2, 'delivery_finish_time' => TIMESTAMP), array('id' => $id, 'from_user' => $from_user));
    if ($_W['isajax']) {
        $this->showMsg('收货成功!', 1);
    } else {
        message('收货成功!', $this->createMobileUrl('feedback', array('orderid' => $id)), 'success');
    }
} else {
    $store = $this->getStoreById($order['storeid']);
    $sid = intval($store['schoolid']);

    if ($order['dining_mode'] == 1 || $order['dining_mode'] == 3) {
        $tablesid = intval($order['tables']);
        $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tablesid));
        if (empty($table)) {
            exit('餐桌不存在！');
        } else {
            $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $table['tablezonesid']));
            if (empty($tablezones)) {
                exit('餐桌类型不存在！');
            }
            $table_title = $tablezones['title'] . '-' . $table['title'];
        }
    }

    if ($order['dining_mode'] == 3) {
        $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $order['tablezonesid']));
    }
    $order['goods'] = pdo_fetchall("SELECT a.*,b.title,b.unitname FROM " . tablename($this->table_order_goods) . " as a left join  " . tablename($this->table_goods) . " as b
 on a.goodsid=b.id WHERE a.weid = '{$weid}' and a.orderid={$order['id']}");

    if ($order['couponid'] != 0) {
        $coupon = pdo_fetch("SELECT a.* FROM " . tablename($this->table_coupon) . "
        a INNER JOIN " . tablename($this->table_sncode) . " b ON a.id=b.couponid
 WHERE a.weid = :weid AND b.id=:snid ORDER BY b.id
 DESC LIMIT 1", array(':weid' => $weid, ':snid' => $order['couponid']));

        if (!empty($coupon)) {
            if ($coupon['type'] == 2) {
                $coupon_info = "代金券抵用金额" . $order['discount_money'];
            } else {
                $coupon_info = $coupon['title'];
            }
        }
    }


    if ($order['dining_mode'] == 2) {
        $deliveryuser = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " where id=:id LIMIT 1", array(':id' => $order['delivery_id']));
    }

    if ($order['isfengniao'] == 1) {
        $fengniao = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_fengniao") . " WHERE partner_order_code='{$id}' ORDER BY id DESC LIMIT 1");
    }

    include $this->template($this->cur_tpl . '/orderdetail');
}


