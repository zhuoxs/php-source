<?php

global $_W, $_GPC;
$weid = $this->_weid;
$action = 'start';
$title = $this->actions_titles[$action];
load()->func('tpl');

$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $store_info = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " WHERE id=:storeid AND weid=:weid", array(':storeid' => $storeid, ':weid' => $weid));
    //店铺打烊
    if ($_GPC['check_status']) {
        $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_setting) . " WHERE weid=:weid AND is_notice=1", array(":weid" => $weid));
        if ($setting) {
            $people = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid=:weid AND storeid=:storeid AND is_notice_boss=1 AND status=2", array(":weid" => $weid, "storeid" => $storeid));
        }
        if (empty($_GPC['store_status']) && !empty($people)) {
            $dayStart = strtotime(date('Y-m-d', time()));
            //$dayStart = strtotime("2016-10-17");
            $dayEnd = $dayStart + 86400;
            $conditions = "AND dateline >= {$dayStart} AND dateline <= {$dayEnd}";
            $BossMessage['store'] = $store_info;
            $BossMessage['diningPrice'] = pdo_fetchall('SELECT paytype,sum(totalprice) as total,count(*) as num ,dining_mode as diningType FROM ' . tablename($this->table_order) . " WHERE weid = :weid AND storeid = :storeid AND status=3 AND ispay=1 AND ismerge=0 $conditions  group by dining_mode", array(':weid' => $this->_weid, ':storeid' => $storeid));
            $BossMessage['payPrice'] = pdo_fetchall('SELECT paytype,sum(totalprice) as total,count(*) as num  FROM ' . tablename($this->table_order) . " WHERE weid = :weid AND storeid = :storeid AND status=3 AND ispay=1 AND ismerge=0 $conditions  GROUP BY paytype ORDER BY paytype ASC", array(':weid' => $this->_weid, ':storeid' => $storeid));
            $BossMessage['totalNum'] = pdo_fetch("SELECT sum(counts) as peopleNum,sum(totalprice) as totalPrice,sum(totalprice)/sum(counts) as avgPrice ,count(1) as totalNum FROM " . tablename($this->table_order) . " WHERE storeid=:storeid and weid=:weid AND status=3 AND ismerge=0 AND ispay=1 $conditions", array(":storeid" => $storeid, ":weid" => $this->_weid));
            $message_appid = explode(",", $store_info['message_appid']);
            foreach ($people as $v) {
                $this->sendBossNotice(date('Y年m月d日', time()), $v['from_user'],$setting['tplboss'], $BossMessage);
            }
        }
    }
    $order_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_order) . " WHERE weid=:weid AND ismerge=0 AND status=0 AND storeid=:storeid LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid));

    $zero_time = mktime(0, 0, 0);
    //今日金额
    $today_order_price = pdo_fetchcolumn("SELECT sum(totalprice) FROM " . tablename($this->table_order) . " WHERE weid=:weid AND storeid=:storeid AND dateline>:time
 AND status<>-1 AND ispay=1 AND ismerge=0 ", array(':weid' => $this->_weid, ':storeid' => $storeid, ':time' => $zero_time));
    $today_order_price = sprintf('%.2f', $today_order_price);

    //所有金额
    $total_order_price = pdo_fetchcolumn("SELECT sum(totalprice) FROM " . tablename($this->table_order) . " WHERE weid=:weid
 AND storeid=:storeid AND status<>-1 AND ispay=1 AND ismerge=0 ", array(':weid' => $this->_weid, ':storeid' => $storeid));

//ordercount
    $today_order_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_order) . " WHERE weid=:weid AND storeid=:storeid AND dateline>:time  AND ismerge=0", array(':weid' => $this->_weid, ':storeid' => $storeid, ':time' => $zero_time));
    $total_order_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_order) . " WHERE weid=:weid AND storeid=:storeid AND ismerge=0", array(':weid' => $this->_weid, ':storeid' => $storeid));



//fans
    $today_fans_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_fans) . " WHERE weid=:weid AND lasttime>:time", array(':weid' => $this->_weid, ':time' => $zero_time));
    $total_fans_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_fans) . " WHERE weid=:weid AND from_user<>'' ", array(':weid' => $this->_weid));
//online
    $online_totalprice = pdo_fetchcolumn("SELECT sum(totalprice) FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid AND ispay=1 AND
status<>-1 AND (paytype=2 OR paytype=1 OR paytype=4) ", array(':weid' => $weid, ':storeid' => $storeid));
    $online_todayprice = pdo_fetchcolumn("SELECT sum(totalprice) FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid AND ispay=1 AND
status<>-1 AND (paytype=2 OR paytype=1 OR paytype=4) AND dateline>:time", array(':weid' => $weid, ':storeid' => $storeid, ':time' => $zero_time));
    $online_todayprice = sprintf('%.2f', $online_todayprice);

//goods
    $total_goods_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_goods) . " WHERE weid=:weid AND storeid=:storeid AND deleted=0 ", array(':weid' => $this->_weid, ':storeid' => $storeid));
//print
    $total_print_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_print_setting) . " WHERE weid=:weid AND storeid=:storeid", array(':weid' => $this->_weid, ':storeid' => $storeid));
//table
    $total_table_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_tables) . " WHERE weid=:weid AND storeid=:storeid", array(':weid' => $this->_weid, ':storeid' => $storeid));
//queue
    $total_queue_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_queue_setting) . " WHERE weid=:weid AND storeid=:storeid", array(':weid' => $this->_weid, ':storeid' => $storeid));

    $condition = " ";
    if (!empty($_GPC['time'])) {
        $starttime = strtotime($_GPC['time']['start']);
        $endtime = strtotime($_GPC['time']['end']);
        $condition .= " AND dateline >= {$starttime} AND dateline <= {$endtime} ";
    }
    if (empty($starttime) || empty($endtime)) {
        $starttime = strtotime('-1 month');
        $endtime = TIMESTAMP;
    }

    $detail_total_order_price = pdo_fetchcolumn("SELECT sum(totalprice) FROM " . tablename($this->table_order) . " WHERE
weid=:weid
 AND storeid=:storeid AND status=3 AND ispay=1 $condition ", array(':weid' => $this->_weid, ':storeid' => $storeid));

    $detail_total_order_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_order) . " WHERE weid=:weid AND storeid=:storeid $condition", array(':weid' => $this->_weid, ':storeid' => $storeid));

    $detail_online_totalprice = pdo_fetchcolumn("SELECT sum(totalprice) FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid AND ispay=1 AND
status=3 AND (paytype=2 OR paytype=1 OR paytype=4) $condition ", array(':weid' => $weid, ':storeid' => $storeid));

//营业详情
    $data = pdo_fetchall('SELECT * FROM ' . tablename($this->table_order) . " WHERE weid = :weid AND storeid = :storeid AND status=3 AND ispay=1 $condition ORDER BY
dateline DESC LIMIT 1000", array(':weid' => $this->_weid, ':storeid' => $storeid));
    $total = array();

    $footer_totalprice = 0;
    $footer_totalcount = 0;
    $footer_totalprice1 = 0;
    $footer_totalprice2 = 0;
    $footer_totalprice3 = 0;
    $footer_totalprice4 = 0;
    if (!empty($data)) {
        foreach ($data as &$da) {
            $total_price = $da['totalprice'];
            $key = date('Y-m-d', $da['dateline']);
            $return[$key]['totalprice'] += $total_price;
            $footer_totalprice += $total_price;
            $footer_totalcount += 1;
            $return[$key]['count'] += 1;
            $total['total_price'] += $total_price;
            $total['total_count'] += 1;

            if ($da['paytype'] == '1') {
                //余额
                $return[$key]['1'] += $total_price;
                $footer_totalprice1 += $total_price;
            } elseif ($da['paytype'] == '2') {
                //微信
                $return[$key]['2'] += $total_price;
                $footer_totalprice2 += $total_price;
            } elseif ($da['paytype'] == '4') {
                //支付宝
                $return[$key]['4'] += $total_price;
                $footer_totalprice4 += $total_price;
            } elseif ($da['paytype'] == '3' ||
                    $da['paytype'] == '0') {
                $return[$key]['3'] += $total_price;
                $footer_totalprice3 += $total_price;
            }
        }
    }
}
if ($operation == 'a') {
    if (!empty($_GPC['start'])) {
        $starttime = strtotime($_GPC['start']);
        $endtime = strtotime($_GPC['end']) + 86399;
    } else {
        $starttime = 0;
        $endtime = TIMESTAMP;
    }
    if ($_W['isajax'] && $_W['ispost']) {
        $datasets = array(
            '4' => array('name' => '支付宝支付', 'value' => 0),
            '2' => array('name' => '微信支付', 'value' => 0),
            '3' => array('name' => '现金支付', 'value' => 0),
            '1' => array('name' => '余额支付', 'value' => 0)
        );
        $data = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . 'WHERE weid = :weid AND storeid = :storeid and status = 3 and dateline
 >= :starttime and dateline <= :endtime', array(':weid' => $weid, ':storeid' => $storeid, ':starttime' => $starttime,
            'endtime' => $endtime));
        foreach ($data as $da) {
            if (in_array($da['paytype'], array_keys($datasets))) {
                $datasets[$da['paytype']]['value'] += 1;
            }
        }
        $datasets = array_values($datasets);
        message(error(0, $datasets), '', 'ajax');
    }
}
if ($operation == 'b') {

    if (!empty($_GPC['start'])) {
        $starttime = strtotime($_GPC['start']);
        $endtime = strtotime($_GPC['end']) + 86399;
        $condition .= " AND dateline > '{$starttime}' AND dateline < '{$endtime}'";
    } else {
        $starttime = strtotime('-30 day');
        $endtime = TIMESTAMP;
        $condition .= "";
    }
    $dn = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND 
    storeid = '{$storeid}' AND dining_mode=1
$condition ");
    $wm = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND
    storeid = '{$storeid}' AND
dining_mode=2
$condition ");
    $kc = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND
    storeid = '{$storeid}' AND
dining_mode=4 $condition ");
    $yd = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_order) . " WHERE weid = '{$weid}' AND
    storeid = '{$storeid}' AND dining_mode=3 $condition ");

    if ($_W['isajax'] && $_W['ispost']) {
        $datasets = array(
            'dn' => array('name' => '店内', 'value' => $dn),
            'wm' => array('name' => '外卖', 'value' => $wm),
            'kc' => array('name' => '快餐', 'value' => $kc),
            'yd' => array('name' => '预定', 'value' => $yd)
        );

        $datasets = array_values($datasets);
        message(error(0, $datasets), '', 'ajax');
    }
}

include $this->template('web/start');
