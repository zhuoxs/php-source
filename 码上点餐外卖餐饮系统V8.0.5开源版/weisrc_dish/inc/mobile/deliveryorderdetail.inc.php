<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$id = intval($_GPC['orderid']);

$do = 'deliveryorderdetail';

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'deliveryorderdetail'; //method
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
$order = $this->getOrderById($id);
if (empty($order)) {
    message('订单不存在!');
}
$storeid = intval($order['storeid']);

if ($is_permission == false) {
    $deliveryuser = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " where weid=:weid AND role=4 AND from_user=:from_user AND status=2
LIMIT 1", array(':weid' => $weid, ':from_user' => $from_user));
    if ($deliveryuser) {
        $is_permission = true;
    }
}

if ($is_permission == false) {
    message('对不起，您没有该功能的操作权限!');
}

if ($order['delivery_status'] > 0) {
    if ($order['delivery_id'] != $deliveryuser['id']) {
        message('该订单已经在配送中!', $url, 'success');
    }
}

$store = $this->getStoreById($storeid);
$order['goods'] = pdo_fetchall("SELECT a.*,b.title FROM " . tablename($this->table_order_goods) . " as a left join  " . tablename($this->table_goods) . " as b on a.goodsid=b.id WHERE a.weid = '{$weid}' and a.orderid={$order['id']}");

if ($order['couponid'] != 0) {
    $coupon = pdo_fetch("SELECT a.* FROM " . tablename($this->table_coupon) . "
        a INNER JOIN " . tablename($this->table_sncode) . " b ON a.id=b.couponid
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
    $deliveryuser = $deliveryuser['username'];
}

$user = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE weid = :weid  AND from_user=:from_user ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':from_user' => $order['from_user']));

include $this->template($this->cur_tpl . '/deliveryorderdetail');