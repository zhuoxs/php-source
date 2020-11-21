<?php
global $_GPC, $_W;
$weid = $this->_weid;
$setting = $this->getSetting();
$action = 'reservation';
$title = $this->actions_titles[$action];

$storeid = intval($_GPC['storeid']);
//检查门店
$this->checkStore($storeid);
$title = $this->actions_titles[$action];
$returnid = $this->checkPermission($storeid);
//当前门店
$cur_store = $this->getStoreById($storeid);
//设置菜单
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$tablezones = pdo_fetchall("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE weid = :weid AND storeid=:storeid ORDER BY displayorder DESC", array(':weid' => $weid, ':storeid' => $storeid));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$order_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_order) . " WHERE weid=:weid AND status=0 AND dining_mode=3 AND
storeid=:storeid LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid));

if ($operation == 'post') {
    $id = intval($_GPC['id']);
    $tablezonesid = intval($_GPC['tablezonesid']);

    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_reservation) . " WHERE id = :id", array(':id' => $id));
        if (empty($item)) {
            message('抱歉，数据不存在或是已经删除！', '', 'error');
        }
    }

    if (checksubmit('submit')) {
        $data = array(
            'weid' => intval($weid),
            'storeid' => $storeid,
            'tablezonesid' => intval($_GPC['tablezonesid']),
            'time' => trim($_GPC['time']),
            'label' => trim($_GPC['label']),
            'dateline' => TIMESTAMP
        );

        if (empty($id)) {
            pdo_insert($this->table_reservation, $data);
        } else {
            unset($data['dateline']);
            pdo_update($this->table_reservation, $data, array('id' => $id, 'weid' => $weid));
        }
        message('操作成功！', $this->createWebUrl('reservation', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'batch') {
    $tablezonesid = intval($_GPC['tablezonesid']);
    if (checksubmit('submit')) {
        $timepoint = intval($_GPC['time_point']);
        $timecount = intval($_GPC['time_count']);
        $time = trim($_GPC['time']);

        if (empty($time)) {
            message('请输入起始时间点！', '', 'error');
        }
        if ($timecount <= 0) {
            message('创建数量不能小于0！', '', 'error');
        } else if ($timecount > 15) {
            message('创建数量不能大于15！', '', 'error');
        }

        $t = strtotime($time);
        for ($i = 0; $i < $timecount; $i++) {
            $time = date('H:i', $t);

            $ishave = pdo_fetch("SELECT * FROM " . tablename($this->table_reservation) . " WHERE weid = :weid AND storeid = :storeid AND tablezonesid = :tablezonesid AND time=:time", array(':weid' => $weid, ':storeid' => $storeid, ':tablezonesid' => $tablezonesid, ':time' => $time));

            $data = array(
                'weid' => $weid,
                'storeid' => $storeid,
                'tablezonesid' => $tablezonesid,
                'time' => $time,
                'dateline' => TIMESTAMP,
            );
            if (empty($ishave)) {
                pdo_insert($this->table_reservation, $data);
            }
            $t = strtotime($time) + $timepoint * 60;
        }
        message('操作成功！', $this->createWebUrl('reservation', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update($this->table_reservation, array('displayorder' => $displayorder), array('id' => $id));
        }
        message('排序更新成功！', $this->createWebUrl('reservation', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }

    $tablezones = pdo_fetchall("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE weid = :weid AND storeid=:storeid ORDER BY displayorder DESC", array(':weid' => $weid, ':storeid' => $storeid), 'id');
    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_reservation) . " WHERE weid = :weid AND storeid =:storeid ORDER BY
tablezonesid DESC,displayorder DESC,id ASC LIMIT
" . ($pindex - 1) * $psize . ',' . $psize, array(':weid' => $this->_weid, ':storeid' => $storeid));
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_reservation) . " WHERE weid = :weid AND storeid =:storeid ", array(':weid' => $this->_weid, ':storeid' => $storeid));
    $pager = pagination($total, $pindex, $psize);
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM " . tablename($this->table_reservation) . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，数据不存在或是已经被删除！');
    }

    pdo_delete($this->table_reservation, array('id' => $id, 'weid' => $weid));
    message('操作成功！', $this->createWebUrl('reservation', array('op' => 'display', 'storeid' => $storeid)), 'success');
} else if ($operation == 'setting') {
    if (checksubmit('submit')) {
        $data = array(
            'is_reservation_dish' => intval($_GPC['is_reservation_dish']),
            'reservation_days' => intval($_GPC['reservation_days']),
            'reservation_wechat' => intval($_GPC['reservation_wechat']),
            'reservation_alipay' => intval($_GPC['reservation_alipay']),
            'reservation_credit' => intval($_GPC['reservation_credit']),
            'reservation_delivery' => intval($_GPC['reservation_delivery']),
            'is_reservation_today' => intval($_GPC['is_reservation_today']),
            'reservation_tip' => trim($_GPC['reservation_tip']),
        );
        pdo_update($this->table_stores, $data, array('id' => $cur_store['id'], 'weid' => $weid));
        message('操作成功！', $this->createWebUrl('reservation', array('op' => 'setting', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'order') {
    if (checksubmit('submit')) {
        $username = trim($_GPC['username']); //用户名
        $mobile = trim($_GPC['mobile']); //电话
        $meal_date = trim($_GPC['meal_date']); //订餐时间
        $time = trim($_GPC['time']);
        $meal_date = $meal_date . ' ' . $time;
        $remark = trim($_GPC['remark']); //备注
        $totalprice = floatval($_GPC['totalprice']); //备注
        $tablezonesid = intval($_GPC['tablezonesid']);
        $tables = intval($_GPC['tables']); //桌号
        $ordertype = 3;
        $paytype = 3;

        $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid AND tables=:tables AND
meal_time=:meal_time AND dining_mode=3 AND status<>-1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':meal_time' => $meal_date, ':tables' => $tables));
        $status = 0;
        if ($order) {
            message('该桌位已被预订!');
        }

        $data = array(
            'weid' => $weid,
            'from_user' => 'admin',
            'storeid' => $storeid,
            'couponid' => 0,
            'ordersn' => date('Ymd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99)),
            'totalnum' => 0, //产品数量
            'totalprice' => $totalprice, //总价
            'paytype' => $paytype, //付款类型
            'dining_mode' => $ordertype, //订单类型
            'username' => $username,
            'tel' => $mobile,
            'meal_time' => $meal_date,
            'tables' => $tables,
            'tablezonesid' => $tablezonesid,
            'remark' => $remark, //备注
            'goodsprice' => 0,
            'dispatchprice' => 0,
            'packvalue' => 0,
            'carports' => 0,
            'counts' => 0,
            'seat_type' => '',
            'address' => '', //地址
            'status' => 1, //状态
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_order, $data);
        message('操作成功！', $this->createWebUrl('order', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }


    $dates = array();
    for ($i = 0; $i < 7; $i++) {
        if ($i == 0) {
            $dates[] = date("Y-m-d", TIMESTAMP);
        } else {
            $dates[] = date("Y-m-d", strtotime("+{$i} day"));
        }
    }

    $timeid = intval($_GPC['id']);
    $time = pdo_fetch("SELECT * FROM " . tablename($this->table_reservation) . " WHERE weid = :weid AND storeid =:storeid AND id=:id ORDER BY id LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':id' => $timeid));

    if (!empty($time)) {
        $reservation_time = date("Y-m-d", TIMESTAMP) . ' ' . $time['time'];
        $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE weid = :weid AND storeid =:storeid AND id=:id ORDER BY id LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':id' => $time['tablezonesid']));
        $tablezonesid = intval($tablezones['id']);
        $tables = pdo_fetchall("SELECT * FROM " . tablename($this->table_tables) . " WHERE weid = :weid AND storeid =:storeid AND
tablezonesid=:tablezonesid ORDER BY id DESC", array(':weid' => $this->_weid, ':storeid' => $storeid, ':tablezonesid' => $tablezonesid), 'id');

        if ($tables) {
            $order = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid AND tables IN ('" . implode("','", array_keys($tables)) . "') AND
meal_time=:meal_time AND dining_mode=3 AND status<>-1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':meal_time' => $reservation_time));

            foreach ($tables as $key => $value) {
                foreach($order as $okey => $ovalue) {
                    if ($value['id'] == $ovalue['tables']) {
                        $tables[$key]['title'] = $value['title'] . '(已预订)';
                    }
                }
            }
        }
    }
} else if ($operation == 'changedate') {
    $select_date = trim($_GPC['select_date']);
    $timeid = intval($_GPC['timeid']);
    $time = pdo_fetch("SELECT * FROM " . tablename($this->table_reservation) . " WHERE weid = :weid AND storeid =:storeid AND id=:id ORDER BY id LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':id' => $timeid));
    $result_str = '';

    if (!empty($time)) {
        $reservation_time = $select_date . ' ' . $time['time'];
        $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE weid = :weid AND storeid =:storeid AND id=:id ORDER BY id LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':id' => $time['tablezonesid']));
        $tablezonesid = intval($tablezones['id']);
        $tables = pdo_fetchall("SELECT * FROM " . tablename($this->table_tables) . " WHERE weid = :weid AND storeid =:storeid AND
tablezonesid=:tablezonesid ORDER BY id ASC", array(':weid' => $this->_weid, ':storeid' => $storeid, ':tablezonesid' => $tablezonesid), 'id');

        if ($tables) {
            $order = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid AND tables IN ('" . implode("','", array_keys($tables)) . "') AND
meal_time=:meal_time AND dining_mode=3 AND status<>-1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':meal_time' => $reservation_time));

            foreach ($tables as $key => $value) {
                foreach($order as $okey => $ovalue) {
                    if ($value['id'] == $ovalue['tables']) {
                        $tables[$key]['title'] = $value['title'] . '(已预订)';
                    }
                }
            }
            foreach ($tables as $key => $value) {
                $result_str .= '<option value="'.$value['id'].'" >'.$value['title'] . '</option>';
            }
        }
        echo json_encode($result_str);
        exit;
    } else {
        echo json_encode(0);
        exit;
    }
}

include $this->template('web/reservation');