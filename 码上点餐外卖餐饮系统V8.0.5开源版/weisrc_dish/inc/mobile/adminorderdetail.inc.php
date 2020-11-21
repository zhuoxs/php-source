<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$id = intval($_GPC['orderid']);

$do = 'adminorderdetail';

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'adminorderdetail'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array('orderid' => $id), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array('orderid' => $id), true);
    if (isset($_COOKIE[$this->_auth2_openid])) {
        $from_user = $_COOKIE[$this->_auth2_openid];
        $nickname = $_COOKIE[$this->_auth2_nickname];
        $headimgurl = $_COOKIE[$this->_auth2_headimgurl];
    } else {
        if (isset($_GPC['code'])) {
            $userinfo = $this->oauth2($authurl);
            if (!empty($userinfo)) {
                $from_user = $userinfo["openid"];
                $nickname = $userinfo["nickname"];
                $headimgurl = $userinfo["headimgurl"];
            } else {
                message('授权失败!');
            }
        } else {
            if (!empty($this->_appsecret)) {
                $this->getCode($url);
            }
        }
    }
} else {
    load()->model('mc');
    if (empty($_W['fans']['nickname'])) {
        mc_oauth_userinfo();
    }
    $from_user = $_W['fans']['openid'];
    $nickname = $_W['fans']['nickname'];
    $headimgurl = $_W['fans']['tag']['avatar'];
}

if (empty($from_user)) {
    message('会话已过期，请重新发送关键字!');
}

$is_permission = false;
$tousers = explode(',', $setting['tpluser']);
if (in_array($from_user, $tousers)) {
    $is_permission = true;
}

$order = $this->getOrderById($id);
if (empty($order)) {
    message('订单不存在');
}
$storeid = intval($order['storeid']);

$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';


if ($is_permission == false) {
    $account = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND from_user=:from_user AND status=2 AND
is_admin_order=1 AND storeid=:storeid LIMIT 1", array(':weid' => $this->_weid, ':from_user' => $from_user, ':storeid' => $storeid));
    if ($account) {
        $is_permission = true;
    }
}

if ($is_permission == false) {
    message('对不起，您没有该功能的操作权限!');
}

$store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND id=:id ORDER BY displayorder DESC", array(':weid' => $weid, ':id' => $storeid));

if ($op == 'display') {
    if ($order['dining_mode'] == 1) {
        $tablesid = intval($order['tables']);
        $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tablesid));

        $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $table['tablezonesid']));
        if (empty($tablezones)) {
            exit('餐桌类型不存在！');
        }
        $table_title = $tablezones['title'] . '-' . $table['title'];
    }

    if ($order['dining_mode'] == 3) {
        $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $order['tablezonesid']));
    }
    $order['goods'] = pdo_fetchall("SELECT a.*,b.title,b.unitname FROM " . tablename($this->table_order_goods) . " as a left join
" . tablename($this->table_goods) . " as b
 on a.goodsid=b.id WHERE a.weid = '{$weid}' and a.orderid={$order['id']}");

    if ($order['couponid'] != 0) {
        $coupon = pdo_fetch("SELECT a.* FROM " . tablename($this->table_coupon) . " a INNER JOIN " . tablename($this->table_sncode) . " b ON a.id=b.couponid
 WHERE a.weid = :weid AND b.id=:couponid ORDER BY b.id
 DESC LIMIT 1", array(':weid' => $weid, ':couponid' => $order['couponid']));
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

    //打印数量
    $printOrderCount = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_print_order) . " WHERE
orderid=:orderid ", array(':orderid' => $id));
    $printOrderCount = intval($printOrderCount);
} else if ($op == 'sendfengniao') {
    $this->sendfengniao($order, $store, $setting);
    message('发送成功!');
} else if ($op == 'refund') { //退款
    if ($order['ispay'] == 1 || $order['ispay'] == 2 || $order['ispay'] == 4) { //已支付和待退款的可以退款
        $refund_price = floatval($_GPC['refund_price']);
        $totalprice = floatval($order['totalprice']);
        if ($refund_price > $totalprice) {
            message('退款金额不能大于订单金额！', $url, 'success');
        }
        $refund_price = $refund_price + $order['refund_price'];
        $update_data = array('ispay' => 3, 'refund_price' => $refund_price);
        if ($order['paytype'] == 2) { //微信支付
            $store = $this->getStoreById($order['storeid']);
            $price = floatval($_GPC['refund_price']);
            wlog('refund_log', '$price');
            wlog('refund_log', $price);
            $result = $this->refund2($id, $price);
            if ($result == 1) {
                message('退款成功！', $url, 'success');
            } else {
                message('退款失败！', $url, 'error');
            }
        } else if ($order['paytype'] == 1) { //余额支付
            if ($totalprice > $refund_price) {
                unset($update_data['ispay']);
            }
            $this->setFansCoin($order['from_user'], $refund_price, "码上点餐单号{$order['ordersn']}退款");
            pdo_update($this->table_order, $update_data, array('id' => $id));
            message('操作成功！', $url, 'success');
        } else if ($order['paytype'] == 4) {
            $result = $this->aliayRefund($id, $refund_price);
            if ($result == 1) {
                message('退款成功！', $url, 'success');
            } else {
                message('退款失败！', $url, 'error');
            }
        } else {
            if ($totalprice > $refund_price) {
                unset($update_data['ispay']);
            }
            pdo_update($this->table_order, $update_data, array('id' => $id));
            message('操作成功！', $url, 'success');
        }
    } else {
        message('操作失败！', '', 'error');
    }
}

include $this->template($this->cur_tpl . '/admin_orderdetail');