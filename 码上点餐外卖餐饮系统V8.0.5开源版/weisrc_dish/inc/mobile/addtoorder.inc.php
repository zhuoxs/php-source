<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$couponid = intval($_GPC['couponid']);
$storeid = intval($_GPC['storeid']);
$rtype = intval($_GPC['rtype']);
$sex = trim($_GPC['sex']); //性别
$meal_time = trim($_GPC['meal_time']); //订餐时间
$counts = intval($_GPC['counts']); //预订人数
$seat_type = intval($_GPC['seat_type']); //就餐形式
$carports = intval($_GPC['carports']); //预订车位
$remark = trim($_GPC['remark']); //备注
$dispatcharea = trim($_GPC['dispatcharea']); //地址
$tablesid = intval($_GPC['tables']); //桌号
$tablezonesid = intval($_GPC['tablezonesid']); //桌台
$append = intval($_GPC['append']); //是否加单
$paymode = intval($_GPC['paymode']);
$isfloor = intval($_GPC['isfloor']);
$iscredit = intval($_GPC['iscredit']);

$card_type = intval($_GPC['card_type']);
$daycount = 0;
$delivery_mode = intval($_GPC['delivery_mode']);
$mode = intval($_GPC['ordertype']) == 0 ? 1 : intval($_GPC['ordertype']);

$setting = $this->getSetting();

$is_handle_goods = 1; //是否处理商品
if ($mode == 5 || $mode == 6 || $mode == 7 || $mode == 8) {
    $is_handle_goods = 0;
}

$is_auto_address = intval($setting['is_auto_address']);
if ($mode == 3) {
    $is_auto_address = 1;
}

$useraddress = pdo_fetch("SELECT * FROM " . tablename($this->table_useraddress) . " WHERE weid=:weid AND from_user=:from_user AND isdefault=1 LIMIT 1", array(':weid' => $weid, ':from_user' => $from_user));

if ($is_auto_address == 0) {
    $lat = trim($useraddress['lat']);
    $lng = trim($useraddress['lng']);
} else {
    $lat = trim($_GPC['lat']);
    $lng = trim($_GPC['lng']);
}


//    $this->showTip($card_type);

if (empty($from_user)) {
    $this->showTip('请重新发送关键字进入系统!');
}
$isvip = $this->get_sys_card($from_user);

if ($mode != 6) {
    if (empty($storeid)) {
        $this->showTip('请先选择门店!');
    }
    $store = $this->getStoreById($storeid);
}

//外卖
if ($mode == 2) {
    if ($delivery_mode == 1) { //送餐上门
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

        //蜂鸟配送只能在距离范围内
        if ($store['is_fengniao_area'] == 1) {
            $return_result = $this->queryStoreDelivery($lng, $lat, $store, $setting);
            if ($return_result['code'] == "40004") {
                $this->showTip('token不正确或token已失效。');
            } elseif ($return_result['code'] != "200") {
                $this->showTip('没在配送范围内，不允许下单。');
            }
        }
    }
}
if ($mode != 6) {
    //购物车为空
    if ($mode == 1 && $paymode == 1) {
        $dishtime = strtotime("-15 minute");
        $cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE weid = :weid AND tableid = :tableid AND storeid=:storeid  AND dateline>{$dishtime}", array(':weid' => $weid, ':tableid' => $tablesid, ':storeid' => $storeid));

        $ismygoods = 0;
        foreach ($cart as $value) {
            if ($value['from_user'] == $from_user) {
                $ismygoods = 1;
            }
        }
        if ($ismygoods == 0) {
            $this->showTip('您的购物车中没有商品或订单已经结算了');
        }
    } else {
        $cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE weid = :weid AND from_user = :from_user AND storeid=:storeid", array(':weid' => $weid, ':from_user' => $from_user, ':storeid' => $storeid));
    }
}

if ($is_handle_goods == 1) {
    if ($rtype != 1) {
        if (empty($cart)) {
            $this->showTip('请先添加商品!');
        }
    }
}
if ($is_auto_address == 0) { //多收餐地址
    $guest_name = $useraddress['realname']; //用户名
    $tel = $useraddress['mobile']; //电话
    $address = $useraddress['address'] . ' ' . $useraddress['doorplate']; //地址
} else {
    $guest_name = trim($_GPC['username']); //用户名
    $tel = trim($_GPC['tel']); //电话
    $address = trim($_GPC['address']);
}

if ($mode != 4 && $mode != 1 && $is_handle_goods == 1) {//非堂点非收银
    if (empty($guest_name)) {
        $this->showTip('请选择您的联系方式!');
    }
    if (empty($tel)) {
        $this->showTip('请选择您的联系方式.');
    }
}

//堂点
if ($mode == 1) {
    if ($append == 0 && $counts <= 0) {
        $this->showTip('请输入用餐人数!');
    }
    if ($tablesid == 0) {
        $this->showTip('请先扫描桌台!');
    }

    if ($store['is_locktables'] == 1) {
        $haveorder = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE weid=:weid AND storeid=:storeid AND tables=:tables AND
status<>-1 AND status<>3 LIMIT 1", array(":weid" => $weid, ":storeid" => $storeid, ":tables" => $tablesid));
        if ($haveorder) {
            if ($haveorder['from_user'] != $from_user) {
                $this->showTip('餐台已经有人在使用中！');
            }
        }
    }
} else if ($mode == 2) {//外卖
    if (empty($address)) {
        $this->showTip('请选择您的联系方式!！');
    }
} else if ($mode == 3) {
    if ($tablesid == 0) {
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
$floormoney = 0;
$teavalue = 0;
$service_money = 0;

if ($rtype != 1) { //只预定不点商品
    foreach ($cart as $value) {
        $total = intval($value['total']);
        $totalnum = $totalnum + intval($value['total']);
        $goodsprice = $goodsprice + ($total * floatval($value['price']));
        if ($mode == 2 && $delivery_mode == 1) { //打包费
            $packvalue = $packvalue + ($total * floatval($value['packvalue']));
        }
    }
}

if ($mode == 2) { //外卖
    if ($delivery_mode == 1) { //送餐上门
        //配送费
        $dispatchprice = $store['dispatchprice'];
        if ($store['is_delivery_distance'] == 1 && $is_auto_address == 0) { //按距离收费
            $distance = $this->getDistance($useraddress['lat'], $useraddress['lng'], $store['lat'], $store['lng']);
            $distanceprice = $this->getdistanceprice($storeid, $distance);
            $dispatchprice = floatval($distanceprice['dispatchprice']);
        }
        if ($store['is_delivery_time'] == 1) { //特殊时段加价
            $tprice = $this->getPriceByTime($storeid);
            $dispatchprice = $dispatchprice + $tprice;
        }
        //满金额免配送费
        $freeprice = floatval($store['freeprice']);
        if ($freeprice > 0.00) {
            if ($goodsprice >= $freeprice) {
                $dispatchprice = 0;
            }
        }
        //上楼费
        if ($store['is_floor_money'] == 1 && $isfloor == 1) {
            $floormoney = $store['floor_money'];
        }
    } else { //自提

    }
}
if ($mode == 1) { //店内
    if ($store['is_tea_money'] == 1) {
        $teavalue = $counts * floatval($store['tea_money']);
    }
}

$isnewuser = $this->isNewUser($storeid);
$dlimitprice = 0;
$newlimitprice = '';
$oldlimitprice = '';
$newlimitpricevalue = '';
$oldlimitpricevalue = '';
if ($isnewuser == 1) { //新用户
    if ($store['is_newlimitprice'] == 1) { //新顾客满减
        $coupon_obj1 = $this->getNewLimitPrice($storeid, $goodsprice, $mode);
        if ($coupon_obj1) {
            $dlimitprice = floatval($coupon_obj1['dmoney']);
            $newlimitprice = $coupon_obj1['title'];
            $newlimitpricevalue = $dlimitprice;
        }
    }
} else { //老用户
    if ($store['is_oldlimitprice'] == 1) { //老顾客满减
        $coupon_obj2 = $this->getOldLimitPrice($storeid, $goodsprice, $mode);
        if ($coupon_obj2) {
            $dlimitprice = floatval($coupon_obj2['dmoney']);
            $oldlimitprice = $coupon_obj2['title'];
            $oldlimitpricevalue = $dlimitprice;
        }
    }
}

$totalprice = $goodsprice + $dispatchprice + $floormoney + $packvalue + $teavalue - $dlimitprice;

if ($mode == 1) { //店内
    $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tablesid));
    $tablezonesid = $table['tablezonesid'];
    $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE id = :id", array(':id' => $tablezonesid));
    $service_rate = floatval($tablezones['service_rate']);
    if ($service_rate > 0) {
        $service_money = $totalprice * $service_rate / 100;
    }
    $totalprice = $totalprice + $service_money;
}

if ($mode == 3) { //预定
    if ($rtype == 1) {
        $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE id = :id", array(':id' => $tablezonesid));
        if (floatval($tablezones['reservation_price']) <= 0) {
            $totalprice = 0.01;
        } else {
            $totalprice = floatval($tablezones['reservation_price']);
        }
    }
}

if ($mode == 2) { //外卖
    $sendingprice = floatval($store['sendingprice']);
    if ($sendingprice > 0.00) {
        if ($goodsprice < $store['sendingprice']) {
            $this->showTip('您的购买金额达不到起送价格!');
        }
    }
}

$coupon = pdo_fetch("SELECT a.*,b.sncode FROM " . tablename($this->table_coupon) . "
        a INNER JOIN " . tablename($this->table_sncode) . " b ON a.id= b.couponid
 WHERE a.weid = :weid AND b.from_user=:from_user AND b.status=0 AND :time<a.endtime AND b.id=:couponid ORDER BY b.id
 DESC LIMIT 1", array(':weid' => $weid, ':from_user' => $from_user, ':time' => TIMESTAMP, ':couponid' => $couponid));

$discount_money = 0;
if ($couponid <> 0 && empty($coupon)) {
    $this->showTip('优惠券不存在!');
} else {
    if ($coupon['type'] == 2) {
        $discount_money = floatval($coupon['dmoney']);
        $totalprice = $totalprice - $coupon['dmoney'];
    }
}
if (!$this->getmodules()) {
    $totalprice = $totalprice;
    $goodsprice = $goodsprice;
}

if ($mode == 5 || $mode == 6) { //收银
    $totalprice = floatval($_GPC['total']);
}

if ($mode == 7) { //门店卡开卡
    $cardprice = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_storecardprice') . " WHERE weid = :weid AND
    storeid=:storeid AND id=:card_type
LIMIT 1;", array(':weid' => $weid, ':storeid' => $storeid, ':card_type' => $card_type));
    if (empty($cardprice)) {
        $this->showTip('支付插件异常!');
    }
    $daycount = intval($cardprice['daycount']);
    $totalprice = floatval($cardprice['price']);
}

if ($mode == 8) { //门店卡充值
    $totalprice = floatval($_GPC['total']);
    if ($totalprice <= 0) {
        $this->showTip('请输入充值金额');
    }
}

$balance_score = 0;
if ($iscredit == 1) { //积分抵扣
    $cardsetting = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_cardsetting') . " WHERE weid=:weid LIMIT 1", array
    (':weid' => $weid));
    $iscardsetting = 0;
    $balance_score = 0;
    if ($cardsetting && $cardsetting['status'] == 1) {
        $startmoney = floatval($cardsetting['startmoney']);
        if ($totalprice >= $startmoney) {
            $iscardsetting = 1;
        }
        $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_card') . " WHERE weid = :weid AND from_user=:from_user
LIMIT 1;", array(':weid' => $weid, ':from_user' => $from_user));
        $maxcredit = intval($cardsetting['maxcredit']);

        if ($card['balance_score'] > $maxcredit) {
            $balance_score = $maxcredit;
        } else {
            $balance_score = $card['balance_score'];
        }
        $totalprice = $totalprice - $balance_score;
    }
}


if ($mode == 6) {
    //充值赠送
    $recharge = pdo_fetch("SELECT * FROM " . tablename($this->table_recharge) . " WHERE weid = :weid AND :nowtime<endtime AND :nowtime>starttime AND :recharge_value>=recharge_value ORDER BY `recharge_value` DESC,`id` DESC LIMIT 1", array(':weid' => $weid, ':nowtime' => TIMESTAMP, ':recharge_value' => $totalprice));
    $rechargeid = intval($recharge['id']);
}

//加菜
if ($append == 2) {
    $orderid = intval($_GPC['order_id']);
    $dishInfo = pdo_fetchall("SELECT goodsid,price,total FROM " . tablename($this->table_order_goods) . " WHERE weid=:weid AND storeid=:storeid AND orderid=:orderid", array(":weid" => $weid, ":storeid" => $storeid, ":orderid" => $orderid));
    foreach ($dishInfo as $v) {
        $dishid[] = $v['goodsid'];
    }
    if ($rtype != 1) {
        foreach ($cart as $k => $v) {
            $goodsid = intval($v['goodsid']);
            $goodstotal = intval($v['total']);
            $goodprice = floatval($v['price']);
            if (empty($v['total'])) {
                continue;
            }
            if (in_array($goodsid, $dishid)) { //更新
                $dishCon = array(":weid" => $weid, ":storeid" => $storeid, ":orderid" => $orderid, ":goodsid" => $v['goodsid']);
                $sql = "UPDATE " . tablename($this->table_order_goods) . " SET total=total+{$v['total']},dateline=" . time() . " WHERE weid=:weid AND storeid=:storeid AND orderid=:orderid AND goodsid=:goodsid";
                pdo_query($sql, $dishCon);
            } else { //新增
                $parm = array("weid" => $weid, "storeid" => $storeid, "orderid" => $orderid, "goodsid" => $v['goodsid'], "price" => $goodprice, "total" => $goodstotal, 'dateline' => time(), 'optionid' => $v['optionid'], 'optionname' => $v['optionname']);
                pdo_insert($this->table_order_goods, $parm);
            }
            $goodsName = pdo_fetch("SELECT title FROM " . tablename($this->table_goods) . " WHERE id=:id", array(":id" => $goodsid));
            $appendMes .= $goodsName['title'] . "*" . $goodstotal . ",";
            pdo_query("UPDATE " . tablename($this->table_goods) . " SET today_counts=today_counts+:counts,sales=sales+:counts,lasttime=:time WHERE id=:id", array(':id' => $goodsid, ':counts' => $goodstotal, ':time' => TIMESTAMP));

            pdo_insert("weisrc_dish_print_goods",
                array(
                    'weid' => $weid,
                    'storeid' => $storeid,
                    'orderid' => $orderid,
                    'goodsid' => $goodsid,
                    'total' => $goodstotal,
                    'price' => $goodprice,
                    'optionid' => $v['optionid'],
                    'optionname' => $v['optionname'],
                    'status' => 0,
                    'dateline' => TIMESTAMP
                )
            );
            //商品打印
            $this->printgoodsfeie($orderid);
        }
    }

    $orderParm = array(':totalnum' => $totalnum, ':totalprice' => $totalprice, ':goodsprice' => $goodsprice, ':service_money' => $service_money, ':tea_money' => $teavalue, ':id' => $orderid);
    pdo_query("UPDATE " . tablename($this->table_order) . " SET totalnum=totalnum+:totalnum ,totalprice=totalprice+:totalprice,goodsprice=goodsprice+:goodsprice,service_money=service_money+:service_money,tea_money=tea_money+:tea_money,append_dish=1 where id=:id ", $orderParm);

    $log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => 'weisrc_dish', 'tid' => $orderid));
    if (!empty($log)) {
        pdo_update('core_paylog', array('fee' => $totalprice, 'card_fee' => $totalprice), array('plid' => $log['plid']));
    }

    //整单
    $this->_feiyinSendFreeMessage($orderid, 1);
    $this->_365SendFreeMessage($orderid, 1);
    $this->_365lblSendFreeMessage($orderid, 1);
    $this->_feieSendFreeMessage($orderid, 1);
    $this->_yilianyunSendFreeMessage($orderid, 1);
    $this->_jinyunSendFreeMessage($orderid, 1);

    if ($couponid > 0) {
        pdo_update($this->table_sncode, array('status' => 1), array('id' => $couponid));
    }
    $this->msg_status_success = 2;
} else {

    $data = array(
        'weid' => $weid,
        'from_user' => $from_user,
        'storeid' => $storeid,
        'delivery_mode' => $delivery_mode,
        'couponid' => $couponid,
        'discount_money' => $discount_money,
        'ordersn' => date('Ymd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99)),
        'totalnum' => $totalnum, //产品数量
        'totalprice' => $totalprice, //总价
        'oldtotalprice' => $totalprice,
        'goodsprice' => $goodsprice,
        'tea_money' => $teavalue,
        'service_money' => $service_money,
        'dispatchprice' => $dispatchprice,
        'packvalue' => $packvalue,
        'daycount' => $daycount,
        'paytype' => 0, //付款类型
        'newlimitprice' => $newlimitprice,
        'oldlimitprice' => $oldlimitprice,
        'newlimitpricevalue' => $newlimitpricevalue,
        'oldlimitpricevalue' => $oldlimitpricevalue,
        'one_order_getprice' => floatval($setting['one_order_getprice']),
        'username' => $guest_name,
        'tel' => $tel,
        'meal_time' => $meal_time,
        'counts' => $counts,
        'seat_type' => $seat_type,
        'tables' => $tablesid,
        'tablezonesid' => $tablezonesid,
        'carports' => $carports,
        'dining_mode' => $mode, //订单类型
        'remark' => $remark, //备注
        'address' => $dispatcharea . $address, //地址
        'status' => 0, //状态
        'rechargeid' => $rechargeid,
        'floor_money' => $floormoney,
        'lat' => $lat,
        'lng' => $lng,
        'isvip' => $isvip,
        'is_append' => $append,
        'dateline' => TIMESTAMP
    );

    if ($mode == 1) { //店内
        unset($data['username']);
        unset($data['tel']);
        unset($data['address']);
    }

    $quicknum = $this->getQuickNum($storeid);
    $data['quicknum'] = $quicknum;


    //保存订单
    pdo_insert($this->table_order, $data);
    $orderid = pdo_insertid();
    if ($orderid > 0) {
        if ($setting['is_yunzhong'] == 1) {
            $this->yunshop_postOrders($orderid);
        }

        if ($balance_score > 0) {
            $datalog = array(
                'weid' => $weid,
                'title' => '订单号' . $orderid,
                'from_user' => $from_user,
                'type' => 1,
                'price' => -$balance_score,
                'remark' => '用户消费：订单ID' . $orderid,
                'dateline' => TIMESTAMP
            );
            pdo_insert('weisrc_dish_cardlog', $datalog);
            pdo_update('weisrc_dish_card', array('balance_score' => $card['balance_score'] - $balance_score), array('id' => $card['id']));
        }

        if ($couponid > 0) {
            pdo_update($this->table_sncode, array('status' => 1), array('id' => $couponid));
        }
    }
    //保存新订单商品
    if ($rtype != 1) {
        if ($is_handle_goods == 1) {
            foreach ($cart as $row) {
                if (empty($row) || empty($row['total']) || $rtype == 1) {
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
        }
    }
}

if ($is_handle_goods == 1) {
    if ($rtype != 1) {
        if ($mode == 1 && $paymode == 1) {
            pdo_delete($this->table_cart, array('weid' => $weid, 'tableid' => $tablesid));
        } else {
            pdo_delete($this->table_cart, array('weid' => $weid, 'from_user' => $from_user, 'storeid' => $storeid));
        }
    }
}

$touser = empty($user['nickname']) ? $user['from_user'] : $user['nickname'];
if ($this->msg_status_success == 2) {
    $touser .= '&nbsp;加菜：' . $appendMes;
}

$this->addOrderLog($orderid, $touser, 1, 1, 1);
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

if ($mode == 7 || $mode == 8 || $mode == 9) {
    $params['tid'] = $orderid;
    $params['user'] = $_W['fans']['from_user'];
    $params['fee'] = $data['totalprice'];
    $params['ordersn'] = $data['ordersn'];
    $params['virtual'] = true;
    $params['module'] = 'weisrc_dish';
    $params['title'] = '餐饮' . $data['ordersn'];
    $log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
    if (empty($log)) {
        $log = array(
            'uniacid' => $_W['uniacid'],
            'acid' => $_W['acid'],
            'openid' => $_W['member']['uid'],
            'module' => $this->module['name'], //模块名称，请保证$this可用
            'tid' => $params['tid'],
            'fee' => $params['fee'],
            'card_fee' => $params['fee'],
            'status' => '0',
            'is_usecard' => '0',
        );
        pdo_insert('core_paylog', $log);
    }

    $result['orderid'] = $orderid;
    $result['code'] = $this->msg_status_success;
    $result['params'] = base64_encode(json_encode($params));
    $result['msg'] = '操作成功';
    message($result, '', 'ajax');

} else {
    $result['orderid'] = $orderid;
    $result['code'] = $this->msg_status_success;
    $result['msg'] = '操作成功';
    message($result, '', 'ajax');
    message($result, '', 'ajax');
}



