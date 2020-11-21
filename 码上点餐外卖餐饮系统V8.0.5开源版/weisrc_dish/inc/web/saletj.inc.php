<?php
global $_W, $_GPC;
$weid = $this->_weid;
$setting = $this->getSetting();
load()->func('tpl');
$action = 'saletj';
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
$returnid = $this->checkPermission($storeid);
$GLOBALS['frames'] = $this->getMainMenu();

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    $years = array();
    $current_year = date('Y');
    $year = empty($_GPC['year']) ? $current_year : $_GPC['year'];
    for ($i = $current_year - 10; $i <= $current_year; $i++) {
        $years[] = array(
            'data' => $i,
            'selected' => ($i == $year)
        );
    }
    $months = array();
    $current_month = date('m');
    $month = $_GPC['month'];
    for ($i = 1; $i <= 12; $i++) {
        $months[] = array(
            'data' => $i,
            'selected' => ($i == $month)
        );
    }
    $day = intval($_GPC['day']);
    $type = intval($_GPC['type']);
    $list = array();
    $totalcount = 0;
    $maxcount = 0;
    $maxcount_date = '';
    $maxdate = '';
    $countfield = empty($type) ? 'sum(totalprice)' : 'count(*)';
    $typename = empty($type) ? '交易额' : '交易量';
    $dataname = (!empty($year) && !empty($month)) ? '月份' : '日期';
    if (!empty($year) && !empty($month) && !empty($day)) {
        for ($hour = 0; $hour < 24; $hour++) {
            $nexthour = $hour + 1;
            $dr = array(
                'data' => $hour . '点 - ' . $nexthour . "点",
                'count' => pdo_fetchcolumn("SELECT ifnull({$countfield},0) as cnt FROM " . tablename($this->table_order) . " WHERE weid=:weid and status>=1 and dateline >=:starttime and dateline <=:endtime", array(
                    ':weid' => $_W['uniacid'],
                    ':starttime' => strtotime("{$year}-{$month}-{$day} {$hour}:00:00"),
                    ':endtime' => strtotime("{$year}-{$month}-{$day} {$hour}:59:59")
                ))
            );
            $totalcount += $dr['count'];
            if ($dr['count'] > $maxcount) {
                $maxcount = $dr['count'];
                $maxcount_date = "{$year}年{$month}月{$day}日 {$hour}点 - {$nexthour}点";
            }
            $list[] = $dr;
        }
    } else if (!empty($year) && !empty($month)) {
        $lastday = date('t', strtotime("{$year}-{$month} -1"));
        for ($d = 1; $d <= $lastday; $d++) {
            $dr = array(
                'data' => $d,
                'count' => pdo_fetchcolumn("SELECT ifnull({$countfield},0) as cnt FROM " . tablename($this->table_order) . " WHERE weid=:weid and status>=1 and dateline >=:starttime and dateline <=:endtime", array(
                    ':weid' => $_W['uniacid'],
                    ':starttime' => strtotime("{$year}-{$month}-{$d} 00:00:00"),
                    ':endtime' => strtotime("{$year}-{$month}-{$d} 23:59:59")
                ))
            );
            $totalcount += $dr['count'];
            if ($dr['count'] > $maxcount) {
                $maxcount = $dr['count'];
                $maxcount_date = "{$year}年{$month}月{$d}日";
            }
            $list[] = $dr;
        }
    } else if (!empty($year)) {
        foreach ($months as $m) {
            $lastday = date('t', strtotime("{$year}-{$m} -1"));
            //$lastday = get_last_day($year, $m);
            $dr = array(
                'data' => $m['data'],
                'count' => pdo_fetchcolumn("SELECT ifnull({$countfield},0) as cnt FROM " . tablename($this->table_order) . " WHERE  weid = :weid and status>=1 and dateline >=:starttime and dateline <=:endtime", array(
                    ':weid' => $_W['uniacid'],
                    ':starttime' => strtotime("{$year}-{$m['data']}-01 00:00:00"),
                    ':endtime' => strtotime("{$year}-{$m['data']}-{$lastday} 23:59:59")
                ))
            );
            $totalcount += $dr['count'];
            if ($dr['count'] > $maxcount) {
                $maxcount = $dr['count'];
                $maxcount_date = "{$year}年{$m['data']}月";
            }
            $list[] = $dr;
        }
    }
    foreach ($list as $key => &$row) {
        $list[$key]['percent'] = number_format($row['count'] / (empty($totalcount) ? 1 : $totalcount) * 100, 2);
    }
    if ($_GPC['out_put'] == 'output') {
        $i = 0;
        foreach ($list as $key => $value) {
            $arr[$i]['percent'] = $value['percent'] . "%";
            if (!empty($year) && !empty($month) && !empty($day)) {
                $arr[$i]['data'] = $value['data'] . '时';
            } else if (!empty($year) && !empty($month)) {
                $arr[$i]['data'] = $value['data'] . '月';
            } else if (!empty($year)) {
                $arr[$i]['data'] = $value['data'] . '月';
            }
            $i++;
        }

        $this->exportexcel($arr, array($typename . '所占比例', '日期'), time());
        exit();

    }
    /* $commoncondition = " a.weid = '{$_W['uniacid']}' ";
     if ($storeid != 0) {
         $commoncondition .= " AND c.storeid={$storeid} ";
     }

     $commonconditioncount = " a.weid = '{$_W['uniacid']}' ";
     if ($storeid != 0) {
         $commonconditioncount .= " AND c.storeid={$storeid} ";
     }

     if (!empty($_GPC['time'])) {
         $starttime = strtotime($_GPC['time']['start']);
         $endtime = strtotime($_GPC['time']['end']) + 86399;
         $commoncondition .= " AND c.dateline >= ".$starttime." AND c.dateline <= ".$endtime." ";
         //$paras[':starttime'] = $starttime;
         //$paras[':endtime'] = $endtime;
     }

     if (empty($starttime) || empty($endtime)) {
         $starttime = strtotime('-1 month');
         $endtime = time();
     }

     $pindex = max(1, intval($_GPC['page']));
     $psize = 10;

     if (!empty($_GPC['ordersn'])) {
         $commoncondition .= " AND ordersn LIKE '%{$_GPC['ordersn']}%' ";
     }
     if (!empty($_GPC['dining_mode'])) {
         $commoncondition .= " AND dining_mode = '" . intval($_GPC['dining_mode']) . "' ";
     }
     $tablesid = $_GPC['tableid'];
     $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND title=:title LIMIT 1", array(':weid' => $weid, ':title' => $tablesid));
     if (!empty($table)) {
         $commoncondition .= " AND tables = '" . $table['id'] . "' ";
     }

     if (isset($_GPC['status']) && $_GPC['status'] != '') {
         $commoncondition .= " AND c.status = '" . intval($_GPC['status']) . "'";
     }

     if (isset($_GPC['paytype']) && $_GPC['paytype'] != '') {
         $commoncondition .= " AND c.paytype = '" . intval($_GPC['paytype']) . "'";
     }

      if (isset($_GPC['selgoodsid']) && $_GPC['selgoodsid'] != '') {
         $selgoodsid = $_GPC['selgoodsid'];
         $commoncondition .= " AND a.goodsid = '" . intval($selgoodsid) . "'";
     }

     if ($_GPC['out_put'] == 'output') {
        // $sql = "select * from " . tablename($this->table_order)
        //     . " WHERE $commoncondition ORDER BY status DESC, dateline DESC ";
        // $list = pdo_fetchall($sql, $paras);
          $list = pdo_fetchall("SELECT c.ordersn,b.title,a.price,a.total,c.dining_mode,c.status,c.paytype,c.ispay,c.dateline,d.title tabletitle,c.from_user FROM " . tablename($this->table_order_goods) . " as a left join " . tablename($this->table_goods) . " as b on a.goodsid=b.id , ". tablename($this->table_order)." c left join ".tablename($this->table_tables)." d on c.tables = d.id WHERE $commoncondition and a.orderid=c.id order by orderid desc ",$paras);
         $orderstatus = array(
             '-1' => array('css' => 'default', 'name' => '已取消'),
             '0' => array('css' => 'danger', 'name' => '待处理'),
             '1' => array('css' => 'info', 'name' => '已确认'),
             '2' => array('css' => 'warning', 'name' => '已付款'),
             '3' => array('css' => 'success', 'name' => '已完成')
         );
         //zzh20160709
         *$paytypes = array(
             '0' => array('css' => 'danger', 'name' => '未支付'),
             '1' => array('css' => 'info', 'name' => '余额支付'),
             '2' => array('css' => 'warning', 'name' => '在线支付'),
             '3' => array('css' => 'success', 'name' => '现金支付')
         );*
         $paytypes = array(
             '0' => array('css' => 'danger', 'name' => '未支付'),
             '1' => array('css' => 'info', 'name' => '余额支付'),
             '2' => array('css' => 'warning', 'name' => '微信支付'),
             '3' => array('css' => 'success', 'name' => '现金支付'),
             '4' => array('css' => 'warning', 'name' => '支付宝')
         );

         $i = 0;
         foreach ($list as $key => $value) {
             $arr[$i]['ordersn'] = $value['ordersn'];
             $arr[$i]['paytype'] = $paytypes[$value['paytype']]['name'];
             $arr[$i]['status'] = $orderstatus[$value['status']]['name'];
                 $arr[$i]['price'] = $value['price']*$value['total'];
             $arr[$i]['sl'] = $value['total'];
             $arr[$i]['goodsname'] = $value['title'];
             $arr[$i]['tabletitle'] = $value['tabletitle'];
             $arr[$i]['username'] = $value['username'];
             $arr[$i]['tel'] = $value['tel'];
             $arr[$i]['address'] = $value['address'];

             $arr[$i]['dateline'] = date('Y-m-d H:i:s', $value['dateline']);
             $i++;
         }

         $this->exportexcel($arr, array('订单号',  '支付方式', '状态', '金额','数量','商品','桌号', '真实姓名', '电话号码', '地址', '时间'), time());
         exit();
     }

     //$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE $commoncondition ORDER BY id desc, dateline DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $paras);
     //echo "===========".$commoncondition;exit();

     $list = pdo_fetchall("SELECT c.ordersn,b.title,a.price,a.total,c.dining_mode,c.status,c.paytype,c.ispay,c.dateline,d.title tabletitle FROM " . tablename($this->table_order_goods) . " as a left join " . tablename($this->table_goods) . " as b on a.goodsid=b.id , ". tablename($this->table_order)." c left join ".tablename($this->table_tables)." d on c.tables = d.id WHERE $commoncondition and a.orderid=c.id order by orderid desc LIMIT ".($pindex - 1) * $psize . ',' . $psize,$paras);

     $sql = "SELECT COUNT(a.id)  FROM " . tablename($this->table_order_goods) . " as a  , ". tablename($this->table_order)." c left join ".tablename($this->table_tables)." d on c.tables = d.id WHERE $commoncondition and a.orderid=c.id ";

     $total = pdo_fetchcolumn($sql);
     //echo $sql."|".$total;exit();
     $pager = pagination($total, $pindex, $psize);

     if (!empty($list)) {
         foreach ($list as $row) {
             $userids[$row['from_user']] = $row['from_user'];
         }
     }

     //打印数量
     $print_order_count = pdo_fetchall("SELECT orderid,COUNT(1) as count FROM " . tablename($this->table_print_order) . "  GROUP BY orderid,weid having weid = :weid", array(':weid' => $_W['uniacid']), 'orderid');

     //门店列表
     $storelist = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid = :weid", array(':weid' => $_W['uniacid']), 'id');

     $goodslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE weid = :weid", array(':weid' => $_W['uniacid']), 'id');*/

} elseif ($operation == 'days') {
    $year = intval($_GPC['year']);
    $month = intval($_GPC['month']);
    die(date('t', strtotime("{$year}-{$month} -1")));
}
include $this->template('web/saletj');