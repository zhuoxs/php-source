<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$status = 0;

if (!empty($_GPC['status'])) {
    $status = intval($_GPC['status']);
}

$do = 'deliveryorder';

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'deliveryorder'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array(), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array(), true);
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

$storeid = 0;
$op = intval($_GPC['op']);
$is_permission = false;
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

$strwhere = " WHERE weid = '{$weid}' AND dining_mode=2 AND status<>-1 AND ispay=1 ";
//$strwhere = " WHERE weid = '{$weid}' AND dining_mode=2 AND status==1 ";
//最近配送点
if ($setting['delivery_mode'] == 3) {
    $areaid = intval($deliveryuser['areaid']);
    if ($areaid == 0) {
        message("您还没有分配配送点！");
    }
    $strwhere .= " AND (deliveryareaid={$areaid} OR delivery_notice=1) ";
}

$storeid = intval($deliveryuser['storeid']);
if ($storeid != 0) {
    $strwhere .= " AND storeid={$storeid} ";
}

if ($op == 0) {
    $strwhere .= " AND delivery_status=0 AND delivery_id=0 AND is_sys_delivery=1 ";
} else {
    $delivery_id = $deliveryuser['id'];
    $strwhere .= " AND delivery_id={$delivery_id} AND is_sys_delivery=1 ";
}

$order_list = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " {$strwhere} ORDER BY id DESC LIMIT 200");
foreach ($order_list as $key => $value) {
    $storeid = intval($value['storeid']);
    $store = $this->getStoreById($storeid);
    $order_list[$key]['storename'] = $store['title'];
    $order_list[$key]['goods'] = pdo_fetchall("SELECT a.*,b.title FROM " . tablename($this->table_order_goods) . " as a left join  " . tablename($this->table_goods) . " as b on a.goodsid=b.id WHERE a.weid = '{$weid}' and a.orderid={$value['id']}");
}

$deliveryid = intval($deliveryuser['id']);
$zero_time = mktime(0, 0, 0);
//todayprice
$today_order_price = pdo_fetchcolumn("SELECT sum(price) FROM " . tablename("weisrc_dish_delivery_record") . " WHERE weid=:weid AND delivery_id=:deliveryid AND
dateline>:time AND status=1 ", array(':weid' => $this->_weid, ':deliveryid' => $deliveryid, ':time' => $zero_time));
$today_order_price = sprintf('%.2f', $today_order_price);

//ordercount
$today_order_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename("weisrc_dish_delivery_record") . " WHERE weid=:weid AND delivery_id=:deliveryid AND dateline>:time", array(':weid' => $this->_weid, ':deliveryid' => $deliveryid, ':time' => $zero_time));

$user = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE weid = :weid  AND from_user=:from_user ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':from_user' => $deliveryuser['from_user']));
$delivery_price = sprintf('%.2f', $user['delivery_price']);

include $this->template($this->cur_tpl . '/deliveryorder');
