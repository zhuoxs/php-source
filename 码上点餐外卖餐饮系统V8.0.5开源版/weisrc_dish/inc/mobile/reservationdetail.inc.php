<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$storeid = intval($_GPC['storeid']);
$mode = 3;
$rtype = !isset($_GPC['rtype']) ? 1 : intval($_GPC['rtype']);
$timeid = intval($_GPC['timeid']);
$select_date = trim($_GPC['selectdate']);
$setting = $this->getSetting();
//$is_auto_address = intval($setting['is_auto_address']);
$is_auto_address = 1;

$store = $this->getStoreById($storeid);
$user = $this->getFansByOpenid($from_user);
if ($user['status'] == 0) {
    message('你被禁止下单,不能进行相关操作...');
}

$useraddress = pdo_fetch("SELECT * FROM " . tablename($this->table_useraddress) . " WHERE weid=:weid AND from_user=:from_user AND isdefault=1 LIMIT 1", array(':weid' => $weid, ':from_user' => $from_user));

$time = pdo_fetch("SELECT * FROM " . tablename($this->table_reservation) . " WHERE weid = :weid AND storeid =:storeid AND id=:id ORDER BY id LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':id' => $timeid));
if (!empty($time)) {
    $reservation_time = $select_date . ' ' . $time['time'];
    $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE weid = :weid AND storeid =:storeid AND id=:id ORDER BY id LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':id' => $time['tablezonesid']));
    $tablezonesid = intval($tablezones['id']);

    $cur_date = date("Y-m-d", TIMESTAMP);
    if ($select_date == $cur_date) {
        $tables = pdo_fetchall("SELECT * FROM " . tablename($this->table_tables) . " WHERE storeid =:storeid AND
tablezonesid=:tablezonesid AND status=0 ORDER BY id DESC", array(':storeid' => $storeid, ':tablezonesid' => $tablezonesid), 'id');
    } else {
        $tables = pdo_fetchall("SELECT * FROM " . tablename($this->table_tables) . " WHERE storeid =:storeid AND
tablezonesid=:tablezonesid ORDER BY id DESC", array(':storeid' => $storeid, ':tablezonesid' => $tablezonesid), 'id');
    }

    if ($tables) {
//        $order = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid AND tables IN ('" . implode("','", array_keys($tables)) . "') AND
//meal_time=:meal_time AND dining_mode=3  AND status<>-1 AND paytype<>0", array(':weid' => $this->_weid, ':storeid' => $storeid, ':meal_time' => $reservation_time));
        $order = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid AND tables IN ('" . implode("','", array_keys($tables)) . "') AND
meal_time=:meal_time AND dining_mode=3  AND status<>-1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':meal_time' => $reservation_time));
        foreach ($tables as $key => $value) {
            $tables[$key]['title'] = $value['title'] . '(' . $value['user_count'] . '人桌)';
            foreach($order as $okey => $ovalue) {
                if ($value['id'] == $ovalue['tables']) {
                    break;
                    $tables[$key]['title'] = $value['title'] . '(' . $value['user_count'] . '人桌)' . '(已预订)';
//                    unset($tables[$key]);
                } else {
                    $tables[$key]['title'] = $value['title'] . '(' . $value['user_count'] . '人桌)';
                }
            }
        }
    }

    if (empty($tables)) {
        message('没有可预订的桌台!');
    }
}

$cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " a LEFT JOIN " . tablename('weisrc_dish_goods') . " b ON a.goodsid=b.id WHERE a.weid=:weid AND a.from_user=:from_user AND a.storeid=:storeid", array(':weid' => $weid, ':from_user' => $from_user, ':storeid' => $storeid));
$totalcount = 0;
$totalprice = 0;
foreach ($cart as $key => $value) {
    $totalcount = $totalcount + $value['total'];
    $totalprice = $totalprice + $value['total'] * $value['price'];
}

$url1 = $this->createMobileUrl('reservationdetail', array('storeid' => $storeid, 'mode' => 3, 'selectdate' => $select_date, 'timeid' => $timeid, 'rtype' => 1), true);
$url2 = $this->createMobileUrl('waplist', array('storeid' => $storeid, 'mode' => 3, 'selectdate' => $select_date, 'timeid' => $timeid, 'rtype' => 2), true);

include $this->template($this->cur_tpl . '/reservation_detail');