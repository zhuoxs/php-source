<?php

global $_W, $_GPC;
$weid = $this->_weid;
$setting = $this->getSetting();
load()->func('tpl');
$action = 'allorder';
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
$returnid = $this->checkPermission($storeid);
$GLOBALS['frames'] = $this->getMainMenu();

if (!$this->exists()) {
    $_GPC['idArr'] = '';
}

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    //门店列表
    $storelist = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid = :weid", array(':weid' => $weid), 'id');
    $shoptype = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " where weid = :weid ORDER BY displayorder DESC", array(':weid' => $weid));
    $deliverylist = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . "  WHERE weid = :weid AND role=4 AND status=2 ORDER BY id DESC LIMIT 50", array(':weid' => $this->_weid));
    $commoncondition = " weid = '{$_W['uniacid']}' ";
    if ($_GPC['types'] != 0) {
        $storeids = pdo_fetchall("SELECT id FROM " . tablename($this->table_stores) . " WHERE typeid = :typeid", array(':typeid' => $_GPC['types']), 'id');
        $commoncondition .= " AND storeid IN ('" . implode("','", array_keys($storeids)) . "')";
    }
    if ($storeid != 0) {
        $commoncondition .= " AND storeid={$storeid} ";
    }
    $ispay = intval($_GPC['ispay']);
    if (isset($_GPC['ispay']) && $_GPC['ispay'] != '') {
        $commoncondition .= " AND ispay={$ispay} ";
    }
    if (!empty($_GPC['from_user'])) {
        $commoncondition .= " AND from_user='{$_GPC['from_user']}' ";
    }

    if (!empty($_GPC['time'])) {
        $starttime = strtotime($_GPC['time']['start']);
        $endtime = strtotime($_GPC['time']['end']);
        $commoncondition .= " AND dateline >= :starttime AND dateline <= :endtime ";
        $paras[':starttime'] = $starttime;
        $paras[':endtime'] = $endtime;
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
        $commoncondition .= " AND status = '" . intval($_GPC['status']) . "'";
    }

    if (isset($_GPC['paytype']) && $_GPC['paytype'] != '') {
        $commoncondition .= " AND paytype = '" . intval($_GPC['paytype']) . "' ";
    }

    if ($_GPC['out_put'] == 'output') {
        $commoncondition .= " AND ismerge = 0 ";
        $this->out_order($commoncondition, $paras);
    } else if ($_GPC['out_put'] == 'out_goods') {
        $commoncondition .= " AND ismerge = 0 ";
        $this->out_goods($commoncondition, $paras);
    }

    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE $commoncondition ORDER BY id desc, dateline DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $paras);

    $order_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_order) . " WHERE weid=:weid AND status=0 LIMIT 1", array(':weid' => $this->_weid));

    $total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_order) . " WHERE $commoncondition ", $paras);
    $pager = pagination($total, $pindex, $psize);

    if (!empty($list)) {
        foreach ($list as $key => $value) {
            $userids[$row['from_user']] = $row['from_user'];
            if ($value['dining_mode'] == 1 || $value['dining_mode'] == 3) {
                $tablesid = intval($value['tables']);
                $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where id=:id LIMIT 1", array(':id' => $tablesid));
                if (!empty($table)) {
                    $table_title = $table['title'];
                    $list[$key]['table'] = $table_title;
                }
            }
            if ($value['dining_mode'] == 2) {
                $deliveryuser = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " where id=:id LIMIT 1", array(':id' => $value['delivery_id']));
                $list[$key]['deliveryuser'] = $deliveryuser['username'];
            }

            $fans = $this->getFansByOpenid($value['from_user']);
            $list[$key]['nickname'] = $fans['nickname'];
            $list[$key]['headimgurl'] = $fans['headimgurl'];

            $goods = pdo_fetchall("SELECT a.goodsid,a.price, a.total,b.thumb,b.title,b.id,b.pcate,b.credit,a.optionname FROM " . tablename($this->table_order_goods) . "
a INNER JOIN " . tablename($this->table_goods) . " b ON a.goodsid=b.id WHERE a.orderid = :id", array(':id' => $value['id']));

            $list[$key]['goods'] = $goods;
        }
    }

    $order_price = pdo_fetchcolumn("SELECT sum(totalprice) FROM " . tablename($this->table_order) . " WHERE $commoncondition ", $paras);
    $order_price = sprintf('%.2f', $order_price);

    //门店列表
    $storelist = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid = :weid AND deleted=0;", array(':weid' => $weid), 'id');
} elseif ($operation == 'detail') {
    //流程 第一步确认付款 第二步确认订单 第三步，完成订单
    $id = intval($_GPC['id']);
//    $this->addRechargePrice($id);
    $order = $this->getOrderById($id);
    $fans = $this->getFansByOpenid($order['from_user']);
    $storeid = $order['storeid'];
    $store = $this->getStoreById($storeid);
    if ($order['dining_mode'] == 1) {
        $tablelist = $this->getAllTableByStoreid($storeid);
    }

    $orderlog = pdo_fetchall("SELECT * FROM " . tablename($this->table_order_log) . " WHERE orderid=:orderid ORDER BY id desc, dateline DESC", array(':orderid' => $id));
    if (!empty($_GPC['confirmtable'])) { //改桌号
        if ($order['status'] == -1 || $order['ispay'] == 3) {
            message('取消和已退款订单不允许操作！', referer(), 'success');
        }

        $tableid = intval($_GPC['tableid']);
        $table = $this->getTableById($tableid);
        if (!empty($table)) {
            $tablezones = $this->getTablezonesById($table['tablezonesid']);
            $tablezonesid = $tablezones['id'];
        }
        pdo_update($this->table_order, array('tables' => $tableid, 'tablezonesid' => $tablezonesid), array('id' => $id));
        message('操作成功！', referer(), 'success');
    }
    if (!empty($_GPC['confirmcounts'])) { //改人数
        if ($order['status'] == -1 || $order['ispay'] == 3) {
            message('取消和已退款订单不允许操作！', referer(), 'success');
        }

        if ($order['paytype'] == 1 || $order['paytype'] == 2 || $order['paytype'] == 4 || $order['status'] == 3) {
            message('在线支付和已完成的单子不允许修改用餐人数！');
        }


        $counts = intval($_GPC['counts']);//人数
        $teavalue = floatval($store['tea_money']) * $counts; //茶位费
        $discount_money = floatval($order['discount_money']);//抵扣金额
        $service_money = floatval($order['service_money']);//服务费
        $goodsprice = floatval($order['goodsprice']);//商品金额
        $newlimitpricevalue = floatval($order['newlimitpricevalue']);//商品金额
        $oldlimitpricevalue = floatval($order['oldlimitpricevalue']);//商品金额
        $totalprice = $goodsprice + $service_money + $teavalue;
        $totalprice = $totalprice - $discount_money - $newlimitpricevalue - $oldlimitpricevalue;
        pdo_update($this->table_order, array('counts' => $counts, 'tea_money' => $teavalue, 'totalprice' => $totalprice), array('id' => $id));
    }
    if (!empty($_GPC['confirmprice'])) { //改价格
        pdo_update($this->table_order, array('totalprice' => $_GPC['updateprice']), array('id' => $id));
        $paylog = pdo_fetch("SELECT * FROM " . tablename('core_paylog') . " WHERE tid=:tid AND uniacid=:uniacid AND status=0 AND module='weisrc_dish'
ORDER BY plid
DESC LIMIT 1", array(':tid' => $id, ':uniacid' => $this->_weid));
        if (!empty($paylog)) {
            pdo_update('core_paylog', array('fee' => $_GPC['updateprice']), array('plid' => $paylog['plid']));
        }
        $this->addOrderLog($id, $_W['user']['username'], 2, 2, 7, $order['totalprice'], $_GPC['updateprice']);
        message('改价成功！', referer(), 'success');
    }

    if (checksubmit('confrimpay')) {
        if ($order['status'] == -1 || $order['ispay'] == 3) {
            message('取消和已退款订单不允许操作！', referer(), 'success');
        }

        pdo_update($this->table_order, array('ispay' => 1), array('id' => $id));
        $this->addOrderLog($id, $_W['user']['username'], 2, 2, 2);
        message('操作成功！', referer(), 'success');
    }

    if (checksubmit('confrimsign')) {
        pdo_update($this->table_order, array('reply' => $_GPC['reply']), array('id' => $id));
        message('操作成功！', referer(), 'success');
    }
    //加菜查询begin
    if ($_POST['selectDish']) {
        $dishCondition = '';
        if ($_POST['addDishName']) {
            $dishCondition = "AND pcate=" . intval($_POST['addDishName']);
        }
        $allGoods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE storeid=:storeid AND weid=:weid  AND deleted=0 " . $dishCondition, array(":storeid" => $storeid, ":weid" => $this->_weid));
        foreach ($allGoods as $key => $value) {
            $allGoods[$key]['thumb'] = tomedia($value['thumb']);
        }
        exit(json_encode($allGoods));
    }
    if ($_POST['addDish'] && !empty($_POST['dish'])) {
        $dish = $_POST['dish'];
        $dishInfo = pdo_fetchall("SELECT goodsid,price,total FROM " . tablename($this->table_order_goods) . " WHERE weid=:weid AND storeid=:storeid AND orderid=:orderid", array(":weid" => $weid, ":storeid" => $storeid, ":orderid" => $id));
        foreach ($dishInfo as $v) {
            $dishid[] = $v['goodsid'];
        }
        foreach ($dish as $k => $v) {
            if ($v['status'] != "己选择" || empty($v['num'])) {
                unset($dish[$k]);
            } else {
                if (!empty($dish)) {
                    if (in_array($k, $dishid)) { //已存在的
                        $num = intval($v['num']);
                        $parm = array(":weid" => $weid, ":storeid" => $storeid, ":orderid" => $id, ":goodsid" => $k);
                        pdo_query("UPDATE " . tablename($this->table_order_goods) . " SET total=total+{$num} WHERE weid=:weid AND storeid=:storeid AND orderid=:orderid AND goodsid=:goodsid",
                            $parm);
                    } else {
                        $parm = array("weid" => $weid, "storeid" => $storeid, "orderid" => $id, "goodsid" => $k, "price" => $v['price'], "total" => $v['num'], 'dateline' => TIMESTAMP);
                        pdo_insert($this->table_order_goods, $parm);
                    }

                    $orderid = $id;
                    $goodstotal = intval($v['num']);
                    $goodprice = floatval($v['price']);
                    $goodsid = $k;
                    pdo_insert("weisrc_dish_print_goods",
                        array(
                            'weid' => $weid,
                            'storeid' => $storeid,
                            'orderid' => $orderid,
                            'goodsid' => $goodsid,
                            'total' => $goodstotal,
                            'price' => $goodprice,
                            'status' => 0,
                            'dateline' => TIMESTAMP
                        )
                    );

                    //商品打印
                    $this->printgoodsfeie($orderid);

                    $add_goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE weid=:weid AND id=:id ORDER by id DESC LIMIT 1", array(':weid' => $this->_weid, ':id' => $k));
                    $touser = $_W['user']['username'] . '&nbsp;加菜：' . $add_goods['title'] . "*" . $v['num'] . ",";
                    $this->addOrderLog($id, $touser, 2, 2, 1);
                }
            }
        }
        $newOrder = pdo_fetchall("SELECT price,total FROM " . tablename($this->table_order_goods) . " WHERE orderid=:id", array(":id" => $id));
        foreach ($newOrder as $v) {
            $dishTotal['num'] += $v['total'];
            $dishTotal['price'] += (number_format(floatval($v['price']), 2) * $v['total']);
        }


        $newtotalprice = 0;
        $newtotalprice = $dishTotal['price'] + floatval($order['tea_money']) + floatval($order['service_money']) + floatval($order['dispatchprice']) + floatval($order['packvalue']);
        $discount_money = floatval($order['discount_money']);//抵扣金额
        $newlimitpricevalue = floatval($order['newlimitpricevalue']);
        $oldlimitpricevalue = floatval($order['oldlimitpricevalue']);
        $newtotalprice = $newtotalprice - $discount_money - $newlimitpricevalue - $oldlimitpricevalue;
        pdo_update($this->table_order, array("totalnum" => $dishTotal['num'], "totalprice" => $newtotalprice, "goodsprice" => $dishTotal['price']), array("id" => $id));

        $log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => 'weisrc_dish', 'tid' => $id));
        if (!empty($log)) {
            pdo_update('core_paylog', array('fee' => $newtotalprice, 'card_fee' => $newtotalprice), array('plid' => $log['plid']));
        }
        message('操作成功！', referer(), 'success');
    }
    //加菜end
    $store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $order['storeid'], ':weid' => $weid));
    if (!empty($_GPC['finish'])) {
        //isfinish
        if ($order['isfinish'] == 0) {
            if ($order['status'] == -1 || $order['ispay'] == 3) {
                message('取消和已退款订单不允许操作！', referer(), 'success');
            }
            //计算积分
            $this->setOrderCredit($order['id']);
            pdo_update($this->table_order, array('isfinish' => 1), array('id' => $id));
            pdo_update($this->table_fans, array('paytime' => TIMESTAMP), array('id' => $fans['id']));
            if ($order['dining_mode'] == 1) {
                pdo_update($this->table_tables, array('status' => 0), array('id' => $order['tables']));
            }
            $this->set_commission($id);
            //奖励配送员
            $delivery_money = floatval($order['delivery_money']);//配送佣金
            $delivery_id = intval($order['delivery_id']);//配送员
            if ($delivery_money > 0) {
                $data = array(
                    'weid' => $_W['uniacid'],
                    'storeid' => $order['storeid'],
                    'orderid' => $order['id'],
                    'delivery_id' => $delivery_id,
                    'price' => $delivery_money,
                    'dateline' => TIMESTAMP,
                    'status' => 0
                );
                pdo_insert("weisrc_dish_delivery_record", $data);
            }
        }

        pdo_update($this->table_order, array('status' => 3, 'finishtime' => TIMESTAMP), array('id' => $id, 'weid' => $weid));
        if ($setting['is_yunzhong'] == 1) {
            $this->yunshop_completeOrder($id);
        }
        pdo_update($this->table_service_log, array('status' => 1), array('orderid' => $id));
        $this->addOrderLog($id, $_W['user']['username'], 2, 2, 4);
        $this->updateFansData($order['from_user']);
        $this->updateFansFirstStore($order['from_user'], $order['storeid']);
        $order = $this->getOrderById($id);
        $this->sendOrderNotice($order, $store, $setting);
        message('订单操作成功！', referer(), 'success');
    }
    if (!empty($_GPC['confirm'])) {
        if ($order['status'] == -1 || $order['ispay'] == 3) {
            message('取消和已退款订单不允许操作！', referer(), 'success');
        }
        pdo_update($this->table_order, array('status' => 1, 'confirmtime' => TIMESTAMP), array('id' => $id, 'weid' => $weid));
        pdo_update($this->table_service_log, array('status' => 1), array('orderid' => $id));
        $this->addOrderLog($id, $_W['user']['username'], 2, 2, 3);
        $order = $this->getOrderById($id);
        $this->sendOrderNotice($order, $store, $setting);
        message('确认订单操作成功！', referer(), 'success');
    }
    if (checksubmit('discount_submit')) {
        $rebate = round(floatval($_GPC['discount_rebate']), 2);
        if (empty($rebate)) {
            message("你输入的折扣率有误", referer(), 'error');
        }
    }
    if (!empty($_GPC['cancel'])) {
        pdo_update($this->table_order, array('status' => -1), array('id' => $id, 'weid' => $weid));
        $this->addOrderLog($id, $_W['user']['username'], 2, 2, 5);
        $order = $this->getOrderById($id);
        $this->sendOrderNotice($order, $store, $setting);

        message('取消订单操作成功！', referer(), 'success');
    }
    if (!empty($_GPC['open'])) {
        pdo_update($this->table_order, array('status' => 0), array('id' => $id, 'weid' => $weid));
        $this->addOrderLog($id, $_W['user']['username'], 2, 2, 8);
        message('开启订单操作成功！', referer(), 'success');
    }

    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = :id", array(':id' => $id));
    $goods = pdo_fetchall("SELECT a.goodsid,a.price, a.total,b.thumb,b.title,b.id,b.pcate,b.credit,a.optionname FROM " . tablename($this->table_order_goods) . "
a INNER JOIN " . tablename($this->table_goods) . " b ON a.goodsid=b.id WHERE a.orderid = :id", array(':id' => $id));

    $discount = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE weid=:weid and storeid=:storeid", array(":weid" => $weid, ":storeid" => $order['storeid']));

    if ($item['dining_mode'] == 1 || $item['dining_mode'] == 3) {
        $tablesid = intval($item['tables']);
        $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tablesid));
        if (!empty($table)) {
            $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $table['tablezonesid']));
            $table_title = $tablezones['title'] . '-' . $table['title'];
        }
    }

    if ($item['couponid'] != 0) {
        $coupon = pdo_fetch("SELECT a.* FROM " . tablename($this->table_coupon) . "
        a INNER JOIN " . tablename($this->table_sncode) . " b ON a.id=b.couponid
 WHERE a.weid = :weid AND b.id=:couponid ORDER BY b.id
 DESC LIMIT 1", array(':weid' => $weid, ':couponid' => $item['couponid']));
        if (!empty($coupon)) {
            if ($coupon['type'] == 2) {
                $coupon_info = "抵用金额" . $order['discount_money'];
            } else {
                $coupon_info = $coupon['title'];
            }
        }
    }

    $distance = $this->getDistance($order['lat'], $order['lng'], $store['lat'], $store['lng']);

} else if ($operation == 'print') {
    $id = $_GPC['id']; //订单id
    $order = $this->getOrderById($id);
    $flag = false;

    $prints = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE weid = :weid AND storeid=:storeid", array(':weid' => $weid, ':storeid' => $order['storeid']));

    if (empty($prints)) {
        message('请先添加打印机或者开启打印机！');
    }

    foreach ($prints as $key => $value) {
        if ($value['print_status'] == 1 && $value['type'] == 'hongxin') {
            $data = array(
                'weid' => $_W['uniacid'],
                'orderid' => $id,
                'print_usr' => $value['print_usr'],
                'print_status' => -1,
                'dateline' => TIMESTAMP
            );
            pdo_insert('weisrc_dish_print_order', $data);
        }
    }
    $this->_feieSendFreeMessage($id);
    $this->_feiyinSendFreeMessage($id);
    $this->_365SendFreeMessage($id);
    $this->_365lblSendFreeMessage($id);
    $this->_yilianyunSendFreeMessage($id);
    $this->jinyunSendFreeMessage($id);
    message('操作成功！', $this->createWebUrl('order', array('op' => 'display', 'storeid' => $order['storeid'])), 'success');
} elseif ($operation == 'printall') {
    $rowcount = 0;
    $notrowcount = 0;
    $position_type = intval($_GPC['position_type']);

    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $this->_feieSendFreeMessage($id, $position_type);
            $this->_feiyinSendFreeMessage($id, $position_type);
            $this->_365SendFreeMessage($id, $position_type);
            $this->_365lblSendFreeMessage($id, $position_type);
            $this->_yilianyunSendFreeMessage($id, $position_type);
            $this->_jinyunSendFreeMessage($id, $position_type);
            $rowcount++;
        }
    }
    $this->message("操作成功！", '', 0);
} elseif ($operation == 'payall') {
    $rowcount = 0;
    $notrowcount = 0;
    $paytype = intval($_GPC['paytype']);
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $order = $this->getOrderById($id);
            if ($order['status'] == -1) {
                continue;
            }
            if ($order['paytype'] == 1 || $order['paytype'] == 2 || $order['paytype'] == 4) {
                continue;
            }
            if ($paytype == 3 || $paytype == 10 || $paytype == 11) {
                $paytype = $paytype;
            } else {
                $paytype = 0;
            }
            if ($order) {
                pdo_update($this->table_order, array('ispay' => 1, 'paytime' => TIMESTAMP, 'paytype' => $paytype), array('id' => $id,
                    'weid' => $weid));
                $this->addOrderLog($id, $_W['user']['username'], 2, 2, 2);
                $rowcount++;
            }
        }
    }
    $this->message("操作成功,共操作{$rowcount}条数据!", '', 0);
} elseif ($operation == 'confirmall') {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $order = $this->getOrderById($id);
            if ($order) {
                if ($order['status'] == -1 || $order['ispay'] == 3) {
                    continue;
                }
                pdo_update($this->table_order, array('status' => 1, 'confirmtime' => TIMESTAMP), array('id' => $id, 'weid' => $weid));
                pdo_update($this->table_service_log, array('status' => 1), array('orderid' => $id));
                $this->addOrderLog($id, $_W['user']['username'], 2, 2, 3);
                $this->setOrderServiceRead($id);
                $rowcount++;
            }
        }
    }
    $this->message("操作成功,共操作{$rowcount}条数据!", '', 0);
} elseif ($operation == 'cancelall') {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $order = $this->getOrderById($id);
            if ($order) {
                pdo_update($this->table_order, array('status' => -1), array('id' => $id, 'weid' => $weid));
                $this->addOrderLog($id, $_W['user']['username'], 2, 2, 5);
                $order = $this->getOrderById($id);
                $this->sendOrderNotice($order, $store, $setting);
                $this->setOrderServiceRead($id);
                $rowcount++;
            }
        }
    }
    $this->message("操作成功,共操作{$rowcount}条数据!", '', 0);
} elseif ($operation == 'finishall') {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $order = $this->getOrderById($id);
            if ($order) {
                if ($order['status'] == -1 || ($order['ispay'] == 3 && intval($order['refund_price']) == 0)) {
                    continue;
                }
                if ($order['isfinish'] == 0) {
                    //计算积分
                    $this->setOrderCredit($order['id']);
                    pdo_update($this->table_order, array('isfinish' => 1), array('id' => $id));
                    pdo_update($this->table_service_log, array('status' => 1), array('orderid' => $id));
//                    pdo_update($this->table_fans, array('paytime' => TIMESTAMP), array('id' => $fans['id']));

                    if ($order['dining_mode'] == 1) { //处理店内
                        pdo_update($this->table_tables, array('status' => 0), array('id' => $order['tables']));
                    }
                    $this->set_commission($id);
                    $delivery_money = floatval($order['delivery_money']);//配送佣金
                    $delivery_id = intval($order['delivery_id']);//配送员
                    if ($delivery_money > 0) {
                        $data = array(
                            'weid' => $_W['uniacid'],
                            'storeid' => $order['storeid'],
                            'orderid' => $order['id'],
                            'delivery_id' => $delivery_id,
                            'price' => $delivery_money,
                            'dateline' => TIMESTAMP,
                            'status' => 0
                        );
                        pdo_insert("weisrc_dish_delivery_record", $data);
                    }
                }
                pdo_update($this->table_order, array('status' => 3, 'finishtime' => TIMESTAMP), array('id' => $id, 'weid' => $weid));
                if ($setting['is_yunzhong'] == 1) {
                    $this->yunshop_completeOrder($id);
                }
                $this->addOrderLog($id, $_W['user']['username'], 2, 2, 4);
                $this->updateFansData($order['from_user']);
                $this->updateFansFirstStore($order['from_user'], $order['storeid']);
                $order = $this->getOrderById($id);
                $store = $this->getStoreById($order['storeid']);
                $this->sendOrderNotice($order, $store, $setting);
                $this->setOrderServiceRead($id);
                $rowcount++;
            }
        }
    }
    $this->message("操作成功,共操作{$rowcount}条数据!", '', 0);
} elseif ($operation == 'noticeall') {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $order = $this->getOrderById($id);
            $store = $this->getStoreById($order['storeid']);
            if ($order) {
                $this->sendOrderNotice($order, $store, $setting);
                $rowcount++;
            }
        }
    }
    $this->message("操作成功,共操作{$rowcount}条数据!", '', 0);
} elseif ($operation == 'refund') {
    $url = $this->createWebUrl('allorder', array('op' => 'display', 'storeid' => $storeid));

    $id = $_GPC['id'];
    $order = $this->getOrderById($id);

    if (empty($order)) {
        message('订单不存在！', '', 'error');
    }
    if (!$this->exists()) {
        message('退款失败!!！', $url, 'error');
    }
    $this->addOrderLog($id, $_W['user']['username'], 2, 2, 6);

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
            if ($store['is_jxkj_unipay'] == 1) { //万融收银
                $result = $this->refund4($id, $storeid);
            } else if ($store['is_jueqi_ymf'] == 1) { //崛起支付
                $result = $this->refund3($id, $order['storeid']);
            } else {
                $result = $this->refund2($id, $refund_price);
            }

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
} elseif ($operation == 'sendmoney') {
//    $payopenid = 'oRjClv3xKJd-L0L7WTEBSdHxHDdw';
//    $payresult = $this->sendMoney($payopenid, 1, '发钱测试', '');
//    $payresult = $this->sendRedPack($payopenid, 1);
//    print_r($payresult);
//    exit;
} elseif ($operation == 'setdelivery') {
    $id = intval($_GPC['id']);
    $deliveryid = intval($_GPC['deliveryid']);
    $delivery_status = intval($_GPC['delivery_status']);

    $order = $this->getOrderById($id);
    if ($order['dining_mode'] != 2) {
        $this->message("您设置的订单不是外卖订单", '', 0);
    }

    $deliveryuser = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " where id=:id LIMIT 1", array(':id' => $deliveryid));
    if ($deliveryuser) {
        $delivery_money = floatval($setting['delivery_money']);
        if ($setting['delivery_commission_mode'] == 2) { //商品佣金
            $delivery_money = 0;
            $goods = pdo_fetchall("SELECT a.goodsid,a.total,b.delivery_commission_money FROM " . tablename($this->table_order_goods) . " a INNER JOIN
" . tablename($this->table_goods) . " b ON a.goodsid=b.id WHERE a.orderid = :orderid", array(':orderid' => $id));
            foreach ($goods as $key => $val) {
                $delivery_money = $delivery_money + floatval($val['delivery_commission_money']) * intval($val['total']);
            }
        }
        if ($setting['delivery_commission_mode'] == 3) { //订单配送费为佣金
            $delivery_money = floatval($order['dispatchprice']);
        }

        $data = array(
            'delivery_status' => $delivery_status,
            'delivery_id' => $deliveryid,
            'delivery_money' => $delivery_money,
            'deliveryareaid' => intval($deliveryuser['areaid']),
        );
        if ($delivery_status == 2) {
            $data['delivery_finish_time'] = TIMESTAMP;
        }
        if ($order['status'] == 0) {
            $data['status'] = 1;
        }

        pdo_update($this->table_order, $data, array('id' => $id));
        if (!empty($deliveryuser['from_user'])) {
            $this->sendDeliveryOrderNotice($id, $deliveryuser['from_user'], $setting);
        }
        $order = $this->getOrderById($id);
        $this->sendUserDeliveryNotice($order, $setting);
        $this->setOrderServiceRead($id);
    }

    $this->message("设置成功", '', 0);
} elseif ($operation == 'acceptdeliveryall') {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $order = $this->getOrderById($id);
            if ($order) {
                $data = array(
                    'delivery_status' => 2,
                    'delivery_finish_time' => TIMESTAMP
                );
                pdo_update($this->table_order, $data, array('id' => $id));
                $this->setOrderServiceRead($id);
                $rowcount++;
            }
        }
    }
    $this->message("操作成功,共操作{$rowcount}条数据!", '', 0);
} elseif ($operation == 'mergeall') {
    $rowcount = 0;
    $notrowcount = 0;
    //1.判断店内订单，未支付的订单;
    //2.以最初的单子为主，生成新订单，合并金额
    //3.先判断商品是否存在，存在的话增加数量

    //订单金额
    $totalprice = 0;
    $totalnum = 0;
    $goodsprice = 0;
    $teavalue = 0;
    $service_money = 0;
    $discount_money = 0;
    $counts = 0;
    $sid = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $order = $this->getOrderById($id);
            if ($order) {
                if ($sid != 0 && $sid != $order['storeid']) {
                    $this->message("不同门店的订单不允许合并!", '', 0);
                }
                if ($order['dining_mode'] != 1) {
                    $this->message("您设置的订单编号{$order['id']}不是店内订单", '', 0);
                }
                if ($order['ismerge'] == 1) {
                    $this->message("您设置的订单编号{$order['id']}是并单，不能合并", '', 0);
                }

                $totalprice = $totalprice + floatval($order['totalprice']);
                $totalnum = $totalnum + intval($order['totalnum']);
                $counts = $counts + intval($order['counts']);
                $goodsprice = $goodsprice + floatval($order['goodsprice']);
                $teavalue = $teavalue + floatval($order['tea_money']);
                $service_money = $service_money + floatval($order['service_money']);
                $discount_money = $discount_money + floatval($order['discount_money']);
                $sid = $order['storeid'];
            }
        }
    }

    $data = array(
        'weid' => $weid,
        'from_user' => $order['from_user'],
        'storeid' => $order['storeid'],
        'couponid' => $order['couponid'],
        'discount_money' => $discount_money,
        'ordersn' => date('Ymd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99)),
        'totalnum' => $totalnum, //产品数量
        'totalprice' => $totalprice, //总价
        'goodsprice' => $goodsprice,
        'tea_money' => $teavalue,
        'service_money' => $service_money,
        'dispatchprice' => 0,
        'packvalue' => 0,
        'paytype' => 3, //付款类型
        'username' => $order['username'],
        'tel' => $order['tel'],
        'meal_time' => '',
        'counts' => $counts,
        'seat_type' => '',
        'tables' => $order['tables'],
        'tablezonesid' => $order['tablezonesid'],
        'carports' => 0,
        'dining_mode' => 1, //订单类型
        'remark' => $order['remark'], //备注
        'address' => $order['address'], //地址
        'status' => 0, //状态
        'rechargeid' => 0,
        'isfinish' => 1,
        'lat' => 0,
        'lng' => 0,
        'isvip' => $order['isvip'],
        'ismerge' => 1,
        'is_append' => 0,
        'dateline' => TIMESTAMP
    );

    //保存订单
    pdo_insert($this->table_order, $data);
    $neworderid = pdo_insertid();

    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid", array(':orderid' => $id));
            foreach ($list as $key => $val) {
                $goodsid = intval($val['goodsid']);
                $order_goods = pdo_fetch("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid AND goodsid=:goodsid", array(':orderid' => $neworderid, ':goodsid' => $goodsid));
                if ($order_goods) {
                    $goodsprice = floatval($order_goods['price']);
                    $goodstotal = intval($order_goods['total']);
                    $goodstotal = intval($val['total']) + $goodstotal;

                    pdo_update($this->table_order_goods, array(
                        'weid' => $_W['uniacid'],
                        'storeid' => $val['storeid'],
                        'goodsid' => $val['goodsid'],
                        'orderid' => $neworderid,
                        'price' => $goodsprice,
                        'total' => $goodstotal,
                        'dateline' => TIMESTAMP,
                    ), array('id' => $order_goods['id']));
                } else {
                    $goodsprice = floatval($val['price']);
                    $goodstotal = intval($val['total']);

                    pdo_insert($this->table_order_goods, array(
                        'weid' => $_W['uniacid'],
                        'storeid' => $val['storeid'],
                        'goodsid' => $val['goodsid'],
                        'orderid' => $neworderid,
                        'price' => $goodsprice,
                        'total' => $goodstotal,
                        'dateline' => TIMESTAMP,
                    ));
                }
            }
        }
    }
    $this->message("操作成功!", '', 0);
} elseif ($operation == 'sendQuickNumNotice') {
    $id = intval($_GPC['id']);
    $this->sendQuickNumNotice($id);
    message('操作成功', referer(), 'success');
}

include $this->template('web/allorder');
