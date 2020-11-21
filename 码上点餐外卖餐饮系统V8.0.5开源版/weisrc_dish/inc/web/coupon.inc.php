<?php
global $_W, $_GPC;
load()->func('tpl');
$weid = $_W['uniacid'];
$action = 'coupon';
$title = $this->actions_titles[$action];

$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$setting = $this->getSetting();

$url = $this->createWebUrl($action, array('storeid' => $storeid));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $coupon_type = array(
        '1' => '商品赠送',
        '2' => '代金券',
        '3' => '新用户立减',
        '4' => '满减消费'
    );
    $coupon_attr_type = array(
        '1' => '消费券',
        '2' => '营销券'
    );

    if (checksubmit('submit')) { //排序
        if (is_array($_GPC['displayorder'])) {
            foreach ($_GPC['displayorder'] as $id => $val) {
                $data = array('displayorder' => intval($_GPC['displayorder'][$id]));
                pdo_update($this->table_coupon, $data, array('id' => $id));
            }
        }
        message('操作成功!', $url);
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;
    $where = "WHERE weid = {$weid} AND storeid={$storeid} ";

    $attrtype = intval($_GPC['attrtype']);
    if ($attrtype != 0) {
        $where .= " AND attr_type = " . $attrtype;
    }

    $coupons = pdo_fetchall("SELECT * FROM " . tablename($this->table_coupon) . " {$where} order by displayorder desc,id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
    if (!empty($coupons)) {
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_coupon) . " $where");
        $pager = pagination($total, $pindex, $psize);
    }

    $sncount = pdo_fetchall("SELECT count(1) as count,couponid FROM " . tablename($this->table_sncode) . " WHERE weid={$weid} GROUP BY couponid", array(), 'pid');
    //普通券
    $type_count1 = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_coupon) . " WHERE attr_type = 1 AND weid=:weid AND storeid={$storeid} AND type<>4", array(':weid' => $weid));
    //营销券
    $type_count2 = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_coupon) . " WHERE attr_type = 2 AND weid=:weid AND storeid={$storeid} AND type<>4", array(':weid' => $weid));

    //优惠券券
    $coupon_count1 = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_coupon) . " WHERE type = 1 AND type<>4 AND weid=:weid AND storeid={$storeid} ", array(':weid' => $weid));
    //代金券
    $coupon_count2 = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_coupon) . " WHERE type = 2 AND type<>4 AND weid=:weid AND storeid={$storeid} ", array(':weid' => $weid));
    //优惠券券
    $coupon_count3 = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_coupon) . " WHERE type = 3 AND type<>4 AND weid=:weid AND storeid={$storeid} ", array(':weid' => $weid));
} else if ($operation == 'post') {
    $id = intval($_GPC['id']);
    $reply = pdo_fetch("select * from " . tablename($this->table_coupon) . " where id = :id AND weid=:weid
            LIMIT 1", array(':id' => $id, ':weid' => $weid));

    $goodslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE storeid=:storeid ORDER BY
    displayorder DESC,id DESC", array(':storeid' => $storeid), 'id');

    if (!empty($reply)) {
        if (!empty($reply['thumb'])) {
            $thumb = tomedia($reply['thumb']);
        }

        if (!empty($reply['goodsids'])) {
            $goodsids = explode(',', $reply['goodsids']);
        }
    }

    if (!empty($reply)) {
        $starttime = date('Y-m-d H:i', $reply['starttime']);
        $endtime = date('Y-m-d H:i', $reply['endtime']);
    } else {
        $reply = array(
            'is_meal' => 1,
            'is_delivery' => 1,
            'is_snack' => 1,
            'is_reservation' => 1,
            'type' => 1
        );
        $starttime = date('Y-m-d H:i');
        $endtime = date('Y-m-d H:i', TIMESTAMP + 86400 * 30);
    }

    if (checksubmit('submit')) {

        $goodsid = implode(',', $_GPC['goodsid']);

        $data = array(
            'weid' => intval($_W['uniacid']),
            'title' => trim($_GPC['title']),
            'storeid' => $storeid,
            'content' => trim($_GPC['content']),
            'thumb' => trim($_GPC['thumb']),
//                    'levelid' => intval($_GPC['levelid']),
            'totalcount' => intval($_GPC['totalcount']),
            'usercount' => intval($_GPC['usercount']),
            'type' => intval($_GPC['type']),
            'dcredit' => intval($_GPC['dcredit']),
            'attr_type' => 1,
            'goodsids' => $goodsid,
            'gmoney' => floatval($_GPC['gmoney']),
            'dmoney' => floatval($_GPC['dmoney']),
            'starttime' => strtotime($_GPC['datelimit']['start']),
            'endtime' => strtotime($_GPC['datelimit']['end']),
            'displayorder' => intval($_GPC['displayorder']),
            'is_meal' => intval($_GPC['is_meal']),
            'is_delivery' => intval($_GPC['is_delivery']),
            'is_snack' => intval($_GPC['is_snack']),
//            'is_shouyin' => intval($_GPC['is_shouyin']),
            'is_reservation' => intval($_GPC['is_reservation']),
            'dateline' => TIMESTAMP,
        );

        if (istrlen($data['title']) == 0) {
            message('没有输入标题.', '', 'error');
        }
        if (istrlen($data['title']) > 30) {
            message('标题不能多于30个字。', '', 'error');
        }

        if ($data['count'] < 0) {
            message('优惠券张数不能小于于0.', '', 'error');
        }
        if ($data['count'] > 10000) {
            message('优惠券张数不能大于10000.', '', 'error');
        }
        if ($data['count'] < 0) {
            message('优惠券总张数不能小于于0.', '', 'error');
        }

        if (!empty($id)) {
            unset($data['dateline']);
            pdo_update($this->table_coupon, $data, array('id' => $id, 'weid' => $_W['uniacid']));
        } else {
            pdo_insert($this->table_coupon, $data);
        }
        message('操作成功!', $url);
    }
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    if ($id > 0) {
        pdo_delete($this->table_coupon, array('id' => $id, 'weid' => $_W['uniacid']));
    }
    message('操作成功!', $url);
} else if ($operation == 'couponstatus') {
    $type = intval($_GPC['type']);
    $status = intval($_GPC['status']);
    if ($type == 1) {
        $data = array('is_newlimitprice' => $status);
    } else {
        $data = array('is_oldlimitprice' => $status);
    }
    pdo_update($this->table_stores, $data, array('id' => $storeid, 'weid' => $weid));
    $this->message('操作成功!!', '', -1);
} else if ($operation == 'send') {
    $nowtime = mktime(0, 0, 0);

    $time = TIMESTAMP;
    $where = "WHERE weid = {$weid} AND storeid={$storeid} AND {$time}>starttime AND {$time}<endtime AND (type=1 OR type=2)";
    $coupons = pdo_fetchall("SELECT * FROM " . tablename($this->table_coupon) . " {$where} order by displayorder desc,id desc LIMIT 10");

    $goodslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE weid = {$weid} AND storeid={$storeid} ORDER BY status DESC, displayorder DESC, id DESC LIMIT 100");

    $couponid = intval($_GPC['couponid']);
    //类别
    $type = intval($_GPC['type']);
    //指定时间
    $starttime = strtotime($_GPC['date']);
    //用户级别
    $usertype = intval($_GPC['usertype']);
//    $condition = " weid=:weid AND find_in_set('{$storeid}', storeids) ";
    $condition = " weid=:weid AND status=1";
    if ($usertype == 1) {
        $condition .= " AND is_commission=2 AND agentid=0 ";
    } else if ($usertype == 2) {
        $condition .= " AND is_commission=2 AND agentid>0 ";
    } else if ($usertype == 3) {
        $condition .= " AND is_commission=1 ";
    }

    //消费金额
    $startmoney = floatval($_GPC['startmoney']);
    $endmoney = floatval($_GPC['endmoney']);
    if ($endmoney > 0) {
        if ($endmoney <= $startmoney) {
            message('优惠券不存在！');
        }
        $condition .= " AND totalprice>={$startmoney} AND totalprice<={$endmoney} ";
    }

    //未消费用户
    if ($type == 1) {
        $condition .= " AND paytime=0 ";
    } elseif ($type == 2) {
        $condition .= " AND paytime<:time  ";
    }
    //按商品查找
    $goodsid = intval($_GPC['goodsid']);
    if ($goodsid != 0) {
        $openids = pdo_fetchall("SELECT a.from_user FROM " . tablename($this->table_order) . "
a INNER JOIN " . tablename($this->table_order_goods) . " b ON a.id=b.orderid WHERE b.goodsid = :goodsid", array(':goodsid' => $goodsid), 'from_user');
        if (count($openids) > 0) {
            $condition .= " AND from_user IN ('" . implode("','", array_keys($openids)) . "')";
        }
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;
    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";

    $fanslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_fans) . " WHERE {$condition} ORDER BY
lasttime DESC,id DESC " . $limit, array(':weid' => $weid));

    $total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_fans) . " WHERE {$condition}", array(':weid' => $weid));
    $pager = pagination($total, $pindex, $psize);


//    if (checksubmit('submit')) {
//
//        $id = intval($_GPC['couponid']);
//        //优惠券 1.发放总数2.没人领取数量
//        $coupon = pdo_fetch("SELECT * FROM " . tablename($this->table_coupon) . " WHERE id=:id LIMIT 1", array(':id' => $couponid));
//        if (empty($coupon)) {
//            message('优惠券不存在！');
//        } else {
//            //判断优惠券属性  普通券1 营销券2
//            if ($coupon['attr_type'] == 2) {
//                message('该优惠券属于营销券,不能领取!');
//            }
//            if (TIMESTAMP < $coupon['starttime']) {
//                message('活动时间还未开始,不能领取!');
//            }
//            if (TIMESTAMP > $coupon['endtime']) {
//                message('活动时间已经结束啦!');
//
//            }
//        }
//
//        //未消费用户
//        if ($type == 1) {
//            $fanslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_fans) . " WHERE weid=:weid AND storeid=:storeid AND paytime=0 ORDER BY
//lasttime DESC,id DESC ", array(':weid' => $weid, ':storeid' => $storeid));
//        } elseif ($type == 2) {
//            $fanslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_fans) . " WHERE weid=:weid AND storeid=:storeid AND paytime<:time ORDER BY
//lasttime DESC,id DESC ", array(':weid' => $weid, ':storeid' => $storeid, ':time' => $starttime));
//        }
//        $count = 0;
//        foreach ($fanslist as $key => $value) {
//
//            $from_user = $value['from_user'];
//            $sncode = 'SN' . random(11, 1);
//            $sncode = $this->getNewSncode($weid, $sncode);
//            $data = array(
//                'couponid' => $id,
//                'sncode' => $sncode,
//                'storeid' => $coupon['storeid'],
//                'weid' => $weid,
//                'from_user' => $from_user,
//                'dateline' => TIMESTAMP
//            );
//            pdo_insert($this->table_sncode, $data);
//            $count++;
//        }
//        if ($count > 0) {
//            message("优惠券发放成功，总共发放{$count}张！", referer(), 'success');
//        } else {
//            message('没有相关用户！', referer(), 'error');
//        }
//    }
} elseif ($operation == 'sendall') {
    $rowcount = 0;
    $notrowcount = 0;
    $couponid = intval($_GPC['couponid']);
    $coupon = pdo_fetch("select * from " . tablename($this->table_coupon) . " where id = :id AND weid=:weid LIMIT 1", array(':id' => $couponid, ':weid' => $weid));
    if (empty($coupon)) {
        $this->message("优惠券不存在！", '', 0);
    }

    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id = :id", array(':id' => $id));
            if (empty($fans)) {
                $notrowcount++;
                continue;
            }

            $from_user = $fans['from_user'];
            $sncode = 'SN' . random(11, 1);
            $sncode = $this->getNewSncode($weid, $sncode);
            $data = array(
                'couponid' => $couponid,
                'sncode' => $sncode,
                'storeid' => $coupon['storeid'],
                'weid' => $weid,
                'from_user' => $from_user,
                'dateline' => TIMESTAMP
            );
            pdo_insert($this->table_sncode, $data);
            $this->sendCouponNotice($from_user, $coupon, $cur_store, $setting);
            pdo_update($this->table_fans, array('lastsendtime' => TIMESTAMP), array('id' => $fans['id']));
            $rowcount++;
        }
    }
    $this->message("操作成功！共发放{$rowcount}张优惠券!", '', 0);
}

include $this->template('web/coupon');