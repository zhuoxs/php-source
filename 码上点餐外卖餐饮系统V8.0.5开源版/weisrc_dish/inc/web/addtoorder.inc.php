<?php
global $_W, $_GPC;

$weid = $this->_weid;
$from_user = $_GPC['from_user'];
if (empty($from_user)) {
    $from_user = "admin";
}
$storeid = intval($_GPC['storeid']);
$ispay = intval($_GPC['ispay']);
$is_print = intval($_GPC['is_print']);

$paytype = intval($_GPC['paytype']);
$setting = $this->getSetting();
$is_auto_address = intval($setting['is_auto_address']);

$mode = intval($_GPC['ordertype']) == 0 ? 1 : intval($_GPC['ordertype']);

$lat = trim($_GPC['lat']);
$lng = trim($_GPC['lng']);

$isvip = $this->get_sys_card($from_user);
$store = $this->getStoreById($storeid);

//外卖
if ($mode == 2) {
    if (empty($lat) || empty($lng)) {
        $this->showTip('请重新选择配送地址!');
    }
    //距离
    $delivery_radius = floatval($store['delivery_radius']);
    $distance = $this->getDistance($lat, $lng, $store['lat'], $store['lng']);
    $distance = floatval($distance);
    if ($store['not_in_delivery_radius'] == 0 && $delivery_radius > 0) { //只能在距离范围内
        if ($distance > $delivery_radius) {
            $this->showTip('超出配送范围，不允许下单。');
        }
    }
}

$cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE weid = :weid AND from_user = :from_user AND storeid=:storeid", array(':weid' => $weid, ':from_user' => 'admin', ':storeid' => $storeid));
if (empty($cart)) {
    $this->showTip('请先添加商品!');
}

$guest_name = trim($_GPC['username']); //用户名
$tel = trim($_GPC['tel']); //电话
$address = trim($_GPC['address']);
$meal_time = trim($_GPC['meal_time']); //订餐时间
$counts = intval($_GPC['counts']); //预订人数
$remark = trim($_GPC['remark']); //备注

$tables = intval($_GPC['tables']); //桌号
$tablezonesid = intval($_GPC['tablezonesid']); //桌台

if ($mode == 1) {
    if ($counts <= 0) {
        $this->showTip('请输入用餐人数!');
    }
    if ($tables == 0) {
        $this->showTip('请先扫描桌台!');
    }
} else if ($mode == 2) {//外卖
    if (empty($address)) {
        $this->showTip('请选择您的联系方式!！');
    }
} else if ($mode == 3) {
    if ($tables == 0) {
        $this->showTip('请先选择桌台!');
    }
}


$user = $this->getFansByOpenid($from_user);
$fansdata = array('weid' => $weid,
    'from_user' => $from_user,
    'username' => $guest_name,
    'address' => $address,
    'mobile' => $tel
);
if (empty($guest_name)) {
    unset($fansdata['username']);
}
if (empty($tel)) {
    unset($fansdata['mobile']);
}
if (empty($address)) {
    unset($fansdata['address']);
}
if ($mode == 2) { //外卖
    $fansdata['lat'] = $lat;
    $fansdata['lng'] = $lng;
}
if (empty($user)) {
    pdo_insert($this->table_fans, $fansdata);
} else {
    pdo_update($this->table_fans, $fansdata, array('id' => $user['id']));
}
//2.购物车 //a.添加订单、订单产品
$totalnum = 0;
$totalprice = 0;
$goodsprice = 0;
$dispatchprice = 0;
$freeprice = 0;
$packvalue = 0;
$teavalue = 0;
$service_money = 0;

foreach ($cart as $value) {
    $total = intval($value['total']);
    $totalnum = $totalnum + intval($value['total']);
    $goodsprice = $goodsprice + ($total * floatval($value['price']));
    if ($mode == 2) { //打包费
        $packvalue = $packvalue + ($total * floatval($value['packvalue']));
    }
}

if ($mode == 2) { //外卖
    $dispatchprice = $store['dispatchprice'];

    if ($store['is_delivery_distance'] == 1 && $is_auto_address == 0) { //按距离收费
        $distance = $this->getDistance($lat, $lng, $store['lat'], $store['lng']);
        $distanceprice = $this->getdistanceprice($storeid, $distance);
        $dispatchprice = floatval($distanceprice['dispatchprice']);
    }

    $freeprice = floatval($store['freeprice']);
    if ($freeprice > 0.00) {
        if ($goodsprice >= $freeprice) {
            $dispatchprice = 0;
        }
    }
}
if ($mode == 1) { //店内
    if ($store['is_tea_money'] == 1) {
        $teavalue = $counts * floatval($store['tea_money']);
    }
}

$totalprice = $goodsprice + $dispatchprice + $packvalue + $teavalue;
if ($mode == 1) { //店内
    $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tables));
    $tablezonesid = $table['tablezonesid'];
    $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE id = :id", array(':id' => $tablezonesid));
    $service_rate = floatval($tablezones['service_rate']);
    if ($service_rate > 0) {
        $service_money = $totalprice * $service_rate / 100;
    }
    $totalprice = $totalprice + $service_money;
}

if ($mode == 2) { //外卖
    $sendingprice = floatval($store['sendingprice']);
    if ($sendingprice > 0.00) {
        if ($goodsprice < $store['sendingprice']) {
            $this->showTip('您的购买金额达不到起送价格!');
        }
    }
}

if ($paytype == 3 || $paytype == 10 || $paytype == 11) {
    $paytype = $paytype;
} else {
    $paytype = 0;
}

$is_sys_delivery = 1;
if ($store['is_sys_delivery'] == 0) {
    $is_sys_delivery = 0;
}

$data = array(
    'is_sys_delivery' => $is_sys_delivery,
    'weid' => $weid,
    'from_user' => $from_user,
    'storeid' => $storeid,
    'couponid' => 0,
    'discount_money' => 0,
    'ordersn' => date('Ymd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99)),
    'totalnum' => $totalnum, //产品数量
    'totalprice' => $totalprice, //实付金额
    'oldtotalprice' => $totalprice,//订单金额
    'goodsprice' => $goodsprice,
    'tea_money' => $teavalue,
    'service_money' => $service_money,
    'dispatchprice' => $dispatchprice,
    'packvalue' => $packvalue,
    'newlimitprice' => 0,
    'oldlimitprice' => 0,
    'newlimitpricevalue' => '',
    'oldlimitpricevalue' => '',
    'username' => $guest_name,
    'tel' => $tel,
    'meal_time' => $meal_time,
    'counts' => $counts,
    'seat_type' => '',
    'paytype' => $paytype,
    'ispay' => $ispay,
    'tables' => $tables,
    'one_order_getprice' => floatval($setting['one_order_getprice']),
    'tablezonesid' => $tablezonesid,
    'carports' => '',
    'dining_mode' => $mode, //订单类型
    'remark' => $remark, //备注
    'address' => $address, //地址
    'status' => 0, //状态
    'rechargeid' => 0,
    'lat' => $lat,
    'lng' => $lng,
    'isvip' => $isvip,
    'is_append' => 0,
    'dateline' => TIMESTAMP
);

if ($mode == 1) { //店内
    unset($data['username']);
    unset($data['tel']);
    unset($data['address']);
}

if ($mode == 4) { //快餐
    $quicknum = $this->getQuickNum($storeid);
    $data['quicknum'] = $quicknum;
}

//保存订单
pdo_insert($this->table_order, $data);
$orderid = pdo_insertid();
if ($orderid > 0) {
//    //整单
//    $position_type = 1;
//    $this->_feieSendFreeMessage($id, $position_type);
//    $this->_feiyinSendFreeMessage($id, $position_type);
//    $this->_365SendFreeMessage($id, $position_type);
//    $this->_365lblSendFreeMessage($id, $position_type);
//    $this->_yilianyunSendFreeMessage($id, $position_type);
//    $this->_jinyunSendFreeMessage($id, $position_type);
    foreach ($cart as $row) {
        if (empty($row) || empty($row['total'])) {
            continue;
        }
        pdo_query("UPDATE " . tablename($this->table_goods) . " SET today_counts=today_counts+:counts,sales=sales+:counts,lasttime=:time WHERE id=:id", array(':id' => $row['goodsid'], ':counts' => $row['total'], ':time' => TIMESTAMP));
        pdo_insert($this->table_order_goods, array(
            'weid' => $_W['uniacid'],
            'storeid' => $row['storeid'],
            'goodsid' => $row['goodsid'],
            'optionid' => $row['optionid'],
            'optionname' => $row['optionname'],
            'orderid' => $orderid,
            'price' => $row['price'],
            'total' => $row['total'],
            'dateline' => TIMESTAMP,
        ));
    }

    if ($is_print == 1) {
        $this->_feieSendFreeMessage($orderid);
        $this->_feiyinSendFreeMessage($orderid);
        $this->_365SendFreeMessage($orderid);
        $this->_365lblSendFreeMessage($orderid);
        $this->_yilianyunSendFreeMessage($orderid);
        $this->jinyunSendFreeMessage($orderid);
    }

    pdo_delete($this->table_cart, array('weid' => $weid, 'from_user' => 'admin', 'storeid' => $storeid));
    $touser = $_W['user']['username'];
    $this->addOrderLog($orderid, $touser, 2, 2, 1);
    pdo_insert($this->table_service_log,
        array(
            'orderid' => $orderid,
            'storeid' => $storeid,
            'weid' => $weid,
            'from_user' => $from_user,
            'content' => '您有未处理的订单，请尽快处理',
            'dateline' => TIMESTAMP,
            'type' => 1,
            'status' => 0)
    );

    $result['orderid'] = $orderid;
    $result['code'] = 1;
    $result['msg'] = '操作成功';
    message($result, '', 'ajax');
}