<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$title = '我的菜单';
$do = 'menu';
$storeid = intval($_GPC['storeid']);
$orderid = intval($_GPC['orderid']);
$mode = intval($_GPC['mode']);
$append = intval($_GPC['append']);
$sid = intval($_GPC['sid']);
$tablesid = intval($_GPC['tablesid']);

$setting = $this->getSetting();

if ($mode == 0) {
    message('请先选择下单模式', $this->createMobileUrl('detail', array('id' => $storeid)));
}

$fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE weid = :weid  AND from_user=:from_user ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':from_user' => $from_user));
if ($fans['status'] == 0) {
    message('你被禁止下单,不能进行相关操作...');
}

if (empty($storeid)) {
    message('请先选择门店', $this->createMobileUrl('waprestlist'));
}

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'wapmenu'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'mode' => $mode), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'mode' => $mode), true);
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

$store = $this->getStoreById($storeid);

if ($store['is_check_user'] == 1) {
    $checkuser = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_checkuser") . " WHERE storeid = :storeid AND from_user=:from_user", array(':storeid' => $storeid, ':from_user' => $from_user));
    $is_check = 0;
    if ($checkuser) {
        if ($checkuser['is_check'] == 1) {
            $is_check = 1;
        }
    }
    if ($is_check == 0) {
        message('您好，本店只支持内部人员使用!');
    }
}

if ($this->getstoretimestatus($store) == 0) {
    $str = "{$store['begintime']}-{$store['endtime']}";
    if (!empty($store['begintime1'])) {
        $str .= ",{$store['begintime1']}-{$store['endtime1']}";
    }
    if (!empty($store['begintime2'])) {
        $str .= ",{$store['begintime2']}-{$store['endtime2']}";
    }
    message('商家已经打烊!营业时间' . $str);
}

$iscard = $this->get_sys_card($from_user);

$mealtimes = pdo_fetchall("SELECT * FROM " . tablename($this->table_mealtime) . " WHERE weid=:weid AND storeid=:storeid ORDER BY id ASC", array(':weid' => $weid, ':storeid' => $storeid));

$dispatchareas = pdo_fetchall("SELECT * FROM " . tablename($this->table_dispatcharea) . " WHERE weid=:weid AND storeid=:storeid ORDER BY id ASC", array(':weid' => $weid, ':storeid' => $storeid));

$useraddress = pdo_fetch("SELECT * FROM " . tablename($this->table_useraddress) . " WHERE weid=:weid AND from_user=:from_user AND isdefault=1 LIMIT 1", array(':weid' => $weid, ':from_user' => $from_user));

$select_mealdate = '';
if (!empty($store['delivery_within_days'])) {
    $delivery_within_days = intval($store['delivery_within_days']) + 1;
    for ($i = 0; $i < $delivery_within_days; $i++) {
        $date_title = '';
        if ($i == 0) {
            if ($store['delivery_isnot_today'] == 1) {
                continue;
            }
            $date_value = date("Y-m-d", TIMESTAMP);
            $date_title = '今日';
        } elseif ($i == 1) {
            $date_value = date("Y-m-d", strtotime("+{$i} day"));
            $date_title = '明日';
        } else {
            $date_value = date("Y-m-d", strtotime("+{$i} day"));
            $date_title = date("Y-m-d", strtotime("+{$i} day"));
        }

        $select_mealdate .= "<option value='{$date_value}'>{$date_title}</option>";
    }
}
$select_mealtime = '';
$select_mealtime2 = '';
$cur_date = date("Y-m-d", TIMESTAMP);
foreach ($mealtimes as $key => $value) {
    $begintime = intval(strtotime(date('Y-m-d ') . $value['begintime']));
    $endtime = intval(strtotime(date('Y-m-d ') . $value['endtime']));
    if ($store['delivery_isnot_today'] == 1) {
        $select_mealtime .= '<option value="' . $value['begintime'] . '~' . $value['endtime'] . '">' . $value['begintime'] . '~' . $value['endtime'] . '</option>';
    } else {
        if ($store['is_delivery_nowtime'] == 1) {
            if (TIMESTAMP < $endtime) {//debug
                $select_mealtime .= '<option value="' . $value['begintime'] . '~' . $value['endtime'] . '">' . $value['begintime'] . '~' . $value['endtime'] . '</option>';
            }
        } else {
            if ($begintime > TIMESTAMP) {//debug
                $select_mealtime .= '<option value="' . $value['begintime'] . '~' . $value['endtime'] . '">' . $value['begintime'] . '~' . $value['endtime'] . '</option>';
            }
        }
    }

    $select_mealtime2 .= '<option value="' . $value['begintime'] . '~' . $value['endtime'] . '">' . $value['begintime'] . '~' . $value['endtime'] . '</option>';
}
if (empty($select_mealtime)) {
    $select_mealtime = '<option value="休息中">没在配送时间内</option>';
}

$flag = false;
$issms = intval($store['is_sms']);
$checkcode = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_sms_checkcode') . " WHERE weid = :weid  AND from_user=:from_user AND status=1 ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':from_user' => $from_user));
if ($issms == 1 && empty($checkcode)) {
    $flag = true;
}

if ($mode == 1) {
    if ($store['is_more_meal'] == 1) {
        $dishtime = strtotime("-15 minute");
        $cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " a LEFT JOIN " . tablename('weisrc_dish_goods') . " b ON a.goodsid=b.id WHERE
 a.weid=:weid AND a.storeid=:storeid AND a.tableid=:tableid AND a.dateline>{$dishtime}", array(':weid' => $weid, ':storeid' => $storeid, ':tableid' => $tablesid));
//        print_r('调试中');
//        print_r($cart);
//        exit;
    } else {
        $cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " a LEFT JOIN " . tablename('weisrc_dish_goods') . " b ON a.goodsid=b.id WHERE a.weid=:weid AND a.from_user=:from_user AND a.storeid=:storeid AND total<>0", array(':weid' => $weid, ':from_user' =>
            $from_user, ':storeid' => $storeid));
    }
} else {
    $cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " a LEFT JOIN " . tablename('weisrc_dish_goods') . " b ON a.goodsid=b.id WHERE a.weid=:weid AND a.from_user=:from_user AND a.storeid=:storeid AND total<>0", array(':weid' => $weid, ':from_user' =>
        $from_user, ':storeid' => $storeid));
}

$packvalue = 0;
$userlist = array();
foreach ($cart as $key => $value) {
    if ($value['status'] == 0) {
        message('商品' . $value['title'] . '已下架！');
    }
    $packvalue = $packvalue + $value['total'] * $value['packvalue'];
    if (!in_array($value['from_user'], $userlist)) {
        $cartfans = $this->getFansByOpenid($value['from_user']);
        $userlist[$value['from_user']]['cart'][] = $value;
        $userlist[$value['from_user']]['fans'] = $cartfans;
        $userlist[$value['from_user']]['from_user'] = $value['from_user'];
    } else {
        $userlist[$value['from_user']]['cart'][] = $value;
    }
}

if ($mode == 1) {
    if ($store['is_more_meal'] == 1) {
        $dishtime = strtotime("-15 minute");
        $cart2 = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE  storeid=:storeid AND weid=:weid AND
tableid=:tableid AND dateline>{$dishtime}", array(':storeid' => $storeid, ':tableid' => $tablesid, ':weid' => $weid));
    } else {
        $cart2 = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE  storeid=:storeid AND from_user=:from_user AND weid=:weid AND
total>0 ", array(':storeid' => $storeid, ':from_user' => $from_user, ':weid' => $weid));
    }
} else {
    $cart2 = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE  storeid=:storeid AND from_user=:from_user AND weid=:weid AND
total>0 ", array(':storeid' => $storeid, ':from_user' => $from_user, ':weid' => $weid));
}

$totalcount = 0;
$totalprice = 0;
$goodsprice = 0;
$goodsprices = 0;
foreach ($cart2 as $key => $value) {
    $totalcount = $totalcount + $value['total'];
    $totalprice = $totalprice + $value['total'] * $value['price'];
    $goodsprice = $goodsprice + $value['total'] * $value['price'];

    if ($value['from_user'] == $from_user) {
        $goodsprices = $goodsprices + $value['total'] * $value['price'];
    }
}

$jump_url = $this->createMobileurl('wapmenu', array('from_user' => $from_user, 'storeid' => $storeid), true);
$limitprice = 0;
if ($mode == 1) { //店内
    $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tablesid));
    if (empty($table)) {
        exit('餐桌不存在！');
    } else {
        //餐桌类型
        $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $table['tablezonesid']));
        if (empty($tablezones)) {
            exit('餐桌类型不存在！');
        }
        $table_title = $tablezones['title'] . '-' . $table['title'];
        if ($append == 0) {
            $limitprice = floatval($tablezones['limit_price']);
        }
        $service_rate = floatval($tablezones['service_rate']);
    }

    //茶位费
    $is_tea_money = intval($store['is_tea_money']);
    $teatip = empty($store['tea_tip']) ? "茶位费用" : $store['tea_tip'];
    $teavaule = 0;
    if ($is_tea_money == 1) {
        $default_user_count = intval($store['default_user_count']);
        $teavaule = floatval($store['tea_money']);
        $totalteavalue = $append != 0 ? 0 : $teavaule * $default_user_count;
    }
} elseif ($mode == 2) { //外卖
    //上楼费
    $is_floor_money = intval($store['is_floor_money']);
    $floortip = empty($store['floor_tip']) ? "送货上楼费" : $store['floor_tip'];
    $floorvaule = 0;
    if ($is_floor_money == 1) {
        $totalfloorvalue = floatval($store['floor_money']);
    }

    $limitprice = floatval($store['sendingprice']);
    $jump_url = $this->createMobileurl('wapmenu', array('from_user' => $from_user, 'storeid' => $storeid, 'mode' => 2), true);
} elseif ($mode == 5) {//排队
    $jump_url = $this->createMobileurl('queue', array('from_user' => $from_user, 'storeid' => $storeid), true);
}

$strwhere = " WHERE a.weid = :weid AND b.from_user=:from_user AND a.storeid=:storeid AND b.status=0 AND goodsids<>0 AND FIND_IN_SET(:goodsid, goodsids) AND :time<a.endtime AND (a.type=1 OR a.type=2) ";

$strwhere1 = " WHERE a.weid = :weid AND b.from_user=:from_user AND a.storeid=:storeid AND b.status=0 AND goodsids=0 AND a.gmoney>0 AND a.gmoney<={$totalprice} AND :time<a.endtime AND (a.type=1 OR a.type=2) ";

if ($mode == 1) { //店内
    $strwhere .= " AND a.is_meal=1 ";
    $strwhere1 .= " AND a.is_meal=1 ";
} else if ($mode == 2) { //外卖
    $strwhere .= " AND a.is_delivery=1 ";
    $strwhere1 .= " AND a.is_delivery=1 ";
} else if ($mode == 3) { //预定
    $strwhere .= " AND a.is_reservation=1 ";
    $strwhere1 .= " AND a.is_reservation=1 ";
} else if ($mode == 4) { //快餐
    $strwhere .= " AND a.is_snack=1 ";
    $strwhere1 .= " AND a.is_snack=1 ";
}
$param = array(':weid' => $weid, ':from_user' => $from_user, ':time' => TIMESTAMP, ':storeid' => $storeid);

$couponlist = pdo_fetchall("SELECT a.*,b.sncode,b.id AS couponid FROM " . tablename($this->table_coupon) . " a INNER JOIN
" . tablename($this->table_sncode) . " b ON a.id= b.couponid {$strwhere1} ORDER BY a.dmoney DESC, b.id DESC LIMIT 30", $param);

$array = array();
foreach ($cart2 as $key => $value) {
    $param[':goodsid'] = $value['goodsid'];
    $coupon = pdo_fetchall("SELECT a.*,b.sncode,b.id AS couponid FROM " . tablename($this->table_coupon) . " a INNER JOIN
" . tablename($this->table_sncode) . " b ON a.id= b.couponid {$strwhere} ORDER BY a.dmoney DESC, b.id DESC LIMIT 30", $param);
    if ($coupon) {
        $couponlist = array_merge($couponlist, $coupon);
    }
//    foreach ($couponlist as $k => $v) {
//        if ($v['goodsids'] != 0) {
//            $goodsids = explode(',', $v['goodsids']);
//            if (count($goodsids) > 0) {
//                foreach ($cart as $kc => $vc) {
//                    if ($isfirst == 0) {
//                        if (in_array($vc['goodsid'], $goodsids)) {
//                            if (!in_array($v['sncode'], $array)) {
//                                $array[] = $v['sncode'];
//                                $couponlist[$k]['title'] = $v['title'] . '('. $vc['title'] .')';
//                            }
//                        }
//                    }
//                }
//            }
//        }
//    }
    foreach ($couponlist as $k => $v) {
        if (!in_array($v['couponid'], $array)) {
            $array[] = $v['couponid'];
            if ($v['dmoney']>0) {
                $couponlist[$k]['title'] = $v['title'] . '('. $v['dmoney'] .'元)';
            }
        }
    }
}
$couponlist = $this->array_unique_fb($couponlist);
$couponid = intval($couponlist[0]['couponid']);


$isnewuser = $this->isNewUser($storeid);
$dlimitprice = 0;
if ($isnewuser == 1) { //新用户
    if ($store['is_newlimitprice'] == 1) { //新顾客满减
        $coupon_obj1 = $this->getNewLimitPrice($storeid, $goodsprice, $mode);
        if ($store['is_more_meal'] == 1) {
            $coupon_obj1s = $this->getNewLimitPrice($storeid, $goodsprices, $mode); //单用户
            $dlimitprices = floatval($coupon_obj1s['dmoney']);
        }
        if ($coupon_obj1) {
            $dlimitprice = floatval($coupon_obj1['dmoney']);
            $totalprice = $goodsprice - $dlimitprice;
        }
    }
} else { //老用户
    if ($store['is_oldlimitprice'] == 1) { //老顾客满减
        $coupon_obj2 = $this->getOldLimitPrice($storeid, $goodsprice, $mode);
        if ($store['is_more_meal'] == 1) {
            $coupon_obj2s = $this->getOldLimitPrice($storeid, $goodsprices, $mode); //单用户
            $dlimitprices = floatval($coupon_obj2s['dmoney']);
        }
        if ($coupon_obj2) {
            $dlimitprice = floatval($coupon_obj2['dmoney']);
            $totalprice = $goodsprice - $dlimitprice;
        }
    }
}

$is_auto_address = intval($setting['is_auto_address']);

$over_radius = 0;
$delivery_radius = floatval($store['delivery_radius']);
if ($mode == 2) {
    //距离
    $distance = $this->getDistance($fans['lat'], $fans['lng'], $store['lat'], $store['lng']);
    $distance = floatval($distance);
    if ($store['not_in_delivery_radius'] == 0) { //只能在距离范围内
        if ($distance > $delivery_radius) {
            $over_radius = 1;
        }
    }
}

$dispatchprice = 0;
if ($is_auto_address == 0 && $useraddress) { //多收餐地址 算距离
    $distance = $this->getDistance($useraddress['lat'], $useraddress['lng'], $store['lat'], $store['lng']);
    $distance = floatval($distance);
}

if ($store['is_delivery_distance'] == 1) { //按距离收费
    $distanceprice = $this->getdistanceprice($storeid, $distance);
    $dispatchprice = floatval($distanceprice['dispatchprice']);

    if ($store['not_in_delivery_radius'] == 0) { //只能在距离范围内
        if ($distance > $delivery_radius) {
            $over_radius = 1;
        }
    }
} else {
    //配送费
    $dispatchprice = floatval($store['dispatchprice']);
}

if ($store['is_delivery_time'] == 1) { //特殊时段加价
    $tprice = $this->getPriceByTime($storeid);
    $dispatchprice = $dispatchprice + $tprice;
}



$orderlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE weid=:weid AND from_user=:from_user AND status<>3 AND status<>-1
 ORDER BY id DESC LIMIT 5", array(':from_user' => $from_user, ':weid' => $weid));

$share_title = !empty($setting['share_title']) ? str_replace("#username#", $nickname, $setting['share_title']) : "您的朋友{$nickname}邀请您来吃饭";
$share_desc = !empty($setting['share_desc']) ? str_replace("#username#", $nickname, $setting['share_desc']) : "最新潮玩法，快来试试！";
$share_image = !empty($setting['share_image']) ? tomedia($setting['share_image']) : tomedia("../addons/weisrc_dish/icon.jpg");
$share_url = $host . 'app/' . $this->createMobileUrl('usercenter', array('agentid' => $fans['id']), true);

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
}


include $this->template($this->cur_tpl . '/menu');