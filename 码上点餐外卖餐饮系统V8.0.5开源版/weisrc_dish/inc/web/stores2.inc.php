<?php
global $_W, $_GPC, $code;
$action = 'stores2';
$title = $this->actions_titles[$action];

$weid = $this->_weid;
$returnid = $this->checkPermission();
$id = intval($_GPC['id']); //门店编号
$deleted = intval($_GPC['deleted']);
$storeid = $id;
$cur_store = $this->getStoreById($id);

$code = $this->copyright;
$config = $this->module['config']['weisrc_dish'];
$setting = $this->getSetting();

$school = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_school") . " WHERE weid = :weid  ORDER BY displayorder DESC,id DESC", array(':weid' => $this->_weid));

$action = 'stores2';
$title = '门店管理';
$url = $this->createWebUrl($action, array('op' => 'display'));

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'post' && $cur_store) {
    $GLOBALS['frames'] = $this->getNaveMenu($id,$action);
} else {
    $GLOBALS['frames'] = $this->getMainMenu();
}

if ($operation == 'setting') {
    if (checksubmit('submit')) {
        $cfg['weisrc_dish']['storecount'] = trim($_GPC['storecount']);
        $cfg['weisrc_dish']['copyright_name'] = trim($_GPC['copyright_name']);
        $cfg['weisrc_dish']['copyright_url'] = trim($_GPC['copyright_url']);
        $cfg['weisrc_dish']['is_jueqi'] = intval($_GPC['is_jueqi']);
        $cfg['weisrc_dish']['is_fengniao'] = intval($_GPC['is_fengniao']);
        $this->saveSettings($cfg);
        message('更新成功！', $url, 'success');
    }
} else if ($operation == 'display') {
    $shoptypeid = intval($_GPC['shoptypeid']);
    $areaid = intval($_GPC['areaid']);
    $keyword = trim($_GPC['keyword']);

    if (checksubmit('submit')) { //排序
        if (is_array($_GPC['displayorder'])) {
            foreach ($_GPC['displayorder'] as $id => $val) {
                $data = array('displayorder' => intval($_GPC['displayorder'][$id]));
                pdo_update($this->table_stores, $data, array('id' => $id));
            }
        }
        message('操作成功!', $url);
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $where = "WHERE weid = {$weid} AND deleted={$deleted} ";

    if (!empty($keyword)) {
        $where .= " AND title LIKE '%{$keyword}%'";
    }
    if ($shoptypeid != 0) {
        $where .= " AND typeid={$shoptypeid} ";
    }
    if ($areaid != 0) {
        $where .= " AND areaid={$areaid} ";
    }
    if ($returnid != 0) {
        $where .= " AND id={$returnid} ";
    }

    $schoolid = 0;
    $where_type = '';
    if ($_W['role'] == 'operator') {
        $curadmin = $this->getCurAdmin();
        if ($curadmin['role'] == 3) {
            $schoolid = intval($curadmin['schoolid']);
            if ($schoolid > 0) {
                $where .= " AND schoolid={$schoolid} ";
                $where_type .= " AND schoolid={$schoolid} ";
            }
        }
    }

    $area = pdo_fetchall("SELECT * FROM " . tablename($this->table_area) . " where weid = :weid {$where_type} ORDER BY displayorder DESC", array(':weid' => $weid));
    $shoptype = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " where weid = :weid {$where_type} ORDER BY displayorder DESC", array(':weid' => $weid));

    $types = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " WHERE weid = :weid  ORDER BY id DESC, displayorder DESC", array(':weid' => $weid), 'id');

    $storeslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " {$where} order by displayorder desc,id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
    if (!empty($storeslist)) {
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_stores) . " $where");
        $pager = pagination($total, $pindex, $psize);
    }
} elseif ($operation == 'post') {
    load()->func('tpl');
    $reply = pdo_fetch("select * from " . tablename($this->table_stores) . " where id=:id and weid =:weid", array(':id' => $id, ':weid' => $weid));
    $timelist = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_mealtime') . " WHERE weid = :weid AND storeid=:storeid order by id", array(':weid' => $weid, ':storeid' => $id));
    $distancelist = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_distance') . " WHERE weid = :weid AND storeid=:storeid order by id", array(':weid' => $weid, ':storeid' => $id));

    $deliverytimelist = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_deliverytime') . " WHERE weid = :weid AND storeid=:storeid order by id", array(':weid' => $weid, ':storeid' => $id));


    $coupons = pdo_fetchall("SELECT * FROM " . tablename($this->table_coupon) . " WHERE weid =:weid AND (type=1 OR type=2) AND :time<endtime order by
displayorder desc,
id desc LIMIT 10", array(':weid' => $weid, ':time' => TIMESTAMP));

    $schoolid = 0;
    $where_type = '';
    if ($_W['role'] == 'operator') {
        $curadmin = $this->getCurAdmin();
        if ($curadmin['role'] == 3) {
            $schoolid = intval($curadmin['schoolid']);
            if ($schoolid > 0) {
                $where .= " AND schoolid={$schoolid} ";
                $where_type .= " AND schoolid={$schoolid} ";
            }
        }
    }

    $area = pdo_fetchall("SELECT * FROM " . tablename($this->table_area) . " where weid = :weid {$where_type} ORDER BY displayorder DESC", array(':weid' => $weid));
    $shoptype = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " where weid = :weid {$where_type} ORDER BY displayorder DESC", array(':weid' => $weid));


    $is_bm_payu = $this->checkModule("bm_payu");
    $is_bank_pay = $this->checkModule("bm_payms");
    $is_vtiny_bankpay = $this->checkModule("vtiny_bankpay");
    $is_jxkj_unipay = $this->checkModule("jxkj_unipay");//87行加入
    $is_ld_wxserver = $this->checkModule("ld_wxserver");

    if (empty($reply)) {
        $reply = array(
            'begintime' => "09:00",
            'endtime' => "18:00",
            'default_jump' => "1",
            'is_brand' => "1",
            'is_list' => "1",
            'is_meal' => "1",
            'is_delivery' => "1",
            'is_snack' => "1",
            'is_queue' => "1",
            'is_intelligent' => "1",
            'is_reservation' => "1",
            'is_show' => "1",
            'is_delivery_distance' => "0",
            'is_hot' => "1",
            'is_show_sales' => "1",
            'is_operator1' => "0",
            'is_operator2' => "0",
            'is_delivery_time' => "0",
            'is_savewine' => "1",
            'is_speaker' => "1",
            'is_tea_money' => "0",
            'is_more_meal' => "1",
            'is_floor_money' => "0",
            'is_meal_pay_confirm' => "0",
            'is_auto_confirm' => "0",
            'is_order_autoconfirm' => "0",
            'default_user_count' => "5",
            'is_add_dish' => "0",
            'is_shouyin' => "0",
            'is_fengniao' => "0",
            'is_dispatcharea' => "0",
            'is_locktables' => "0",
            'is_add_order' => "0",
            'is_delivery_mode1' => 1,
            'is_delivery_mode2' => 1,
            'is_bank_pay' => "0",
            'is_vtiny_bankpay' => "0",
            'is_jxkj_unipay' => "0",
            'is_delivery_nowtime' => "1",
            'is_jueqi_ymf' => "0",
            'is_order_tip' => "0",
            'is_newlimitprice' => "0",
            'is_oldlimitprice' => "0",
            'is_fengniao_area' => "0",
            'remarkinfo' => "可输入口味偏好要求(选填)",
            'reservation_announce' => "20分钟未到店，商家有权取消本次预订，请安排好您的时间",
            'btn_coupon_type' => "1",
            'btn_coupon_url' => "",
            'btn_coupon_id' => "0",
            'is_check_user' => "0",
            'btn_coupon_price' => "15元",
            'btn_coupon_title' => "商家优惠券",
            'btn_coupon_desc' => "消费满100元可用",
        );

    } else { //编辑
        $this->checkPermission($id);
        $reply['thumbs'] = iunserializer($reply['thumbs']);
        $clist1 = pdo_fetchall("SELECT * FROM " . tablename($this->table_coupon) . " WHERE weid = {$weid} AND storeid={$storeid} AND type=3 AND
:time<endtime ORDER BY displayorder desc,id desc", array(':time' => TIMESTAMP));

        $clist2 = pdo_fetchall("SELECT * FROM " . tablename($this->table_coupon) . " WHERE weid = {$weid} AND storeid={$storeid} AND type=4 AND
:time<endtime ORDER BY displayorder desc,id desc", array(':time' => TIMESTAMP));
    }

    if (checksubmit('submit')) {
        $is_delivery_mode1 = intval($_GPC['is_delivery_mode1']);
        $is_delivery_mode2 = intval($_GPC['is_delivery_mode2']);
        if ($is_delivery_mode1 == 0 && $is_delivery_mode2 == 0) {
            message('送餐上门，自提必须开启一种!');
        }

        $data = array(
            'btn_coupon_type' => intval($_GPC['btn_coupon_type']),
            'btn_coupon_id' => intval($_GPC['btn_coupon_id']),
            'btn_coupon_url' => trim($_GPC['btn_coupon_url']),
            'btn_coupon_price' => trim($_GPC['btn_coupon_price']),
            'btn_coupon_title' => trim($_GPC['btn_coupon_title']),
            'btn_coupon_desc' => trim($_GPC['btn_coupon_desc']),
            'weid' => intval($_W['uniacid']),
            'schoolid' => $schoolid,
            'areaid' => intval($_GPC['area']),
            'typeid' => intval($_GPC['type']),
            'title' => trim($_GPC['title']),
            'info' => trim($_GPC['info']),
            'from_user' => trim($_GPC['from_user']),
            'content' => trim($_GPC['content']),
            'tel' => trim($_GPC['tel']),
            'announce' => trim($_GPC['announce']),
            'reservation_announce' => trim($_GPC['reservation_announce']),
            'logo' => trim($_GPC['logo']),
            'address' => trim($_GPC['address']),
            'lng' => trim($_GPC['baidumap']['lng']),
            'lat' => trim($_GPC['baidumap']['lat']),
            'password' => trim($_GPC['password']),
            'recharging_password' => trim($_GPC['recharging_password']),
            'is_show' => intval($_GPC['is_show']),
            'is_list' => intval($_GPC['is_list']),
            'place' => trim($_GPC['place']),
            'qq' => trim($_GPC['qq']),
            'weixin' => trim($_GPC['weixin']),
            'hours' => trim($_GPC['hours']),
            'consume' => trim($_GPC['consume']),
            'level' => intval($_GPC['level']),
            'is_delivery_time' => intval($_GPC['is_delivery_time']),
            'is_speaker' => intval($_GPC['is_speaker']),
            'enable_wifi' => intval($_GPC['enable_wifi']),
            'enable_card' => intval($_GPC['enable_card']),
            'enable_room' => intval($_GPC['enable_room']),
            'enable_park' => intval($_GPC['enable_park']),
            'is_meal' => intval($_GPC['is_meal']),
            'is_delivery' => intval($_GPC['is_delivery']),
            'is_delivery_mode1' => $is_delivery_mode1,
            'is_delivery_mode2' => $is_delivery_mode2,
            'is_more_meal' => intval($_GPC['is_more_meal']),
            'is_snack' => intval($_GPC['is_snack']),
            'is_queue' => intval($_GPC['is_queue']),
            'is_add_dish' => intval($_GPC['is_add_dish']),
            'default_jump' => intval($_GPC['default_jump']),
            'default_jump_url' => trim($_GPC['default_jump_url']),
            'is_intelligent' => intval($_GPC['is_intelligent']),
            'is_reservation' => intval($_GPC['is_reservation']),
            'is_sms' => intval($_GPC['is_sms']),
            'is_hot' => intval($_GPC['is_hot']),
            'is_check_user' => intval($_GPC['is_check_user']),
            'is_dispatcharea' => intval($_GPC['is_dispatcharea']),
            'is_bank_pay' => intval($_GPC['is_bank_pay']),
            'bank_pay_id' => intval($_GPC['bank_pay_id']),
            'is_vtiny_bankpay' => intval($_GPC['is_vtiny_bankpay']),
            'jxkj_pay_id' => intval($_GPC['jxkj_pay_id']),
            'is_jxkj_unipay' => intval($_GPC['is_jxkj_unipay']),
            'jxkj_pay_name' => trim($_GPC['jxkj_pay_name']),
            'vtiny_bankpay_id' => intval($_GPC['vtiny_bankpay_id']),
            'vtiny_bankpay_url' => trim($_GPC['vtiny_bankpay_url']),
            'is_ld_wxserver' => intval($_GPC['is_ld_wxserver']),
            'ld_wxserver_url' => trim($_GPC['ld_wxserver_url']),
            'business_id' => intval($_GPC['business_id']),
            'is_business' => intval($_GPC['is_business']),
            'is_savewine' => intval($_GPC['is_savewine']),
            'is_operator1' => intval($_GPC['is_operator1']),
            'is_operator2' => intval($_GPC['is_operator2']),
            'is_fengniao_area' => intval($_GPC['is_fengniao_area']),
            'is_meal_pay_confirm' => intval($_GPC['is_meal_pay_confirm']),
            'notice_space_time' => intval($_GPC['notice_space_time']),
            'btn_reservation' => trim($_GPC['btn_reservation']),
            'btn_eat' => trim($_GPC['btn_eat']),
            'btn_delivery' => trim($_GPC['btn_delivery']),
            'btn_snack' => trim($_GPC['btn_snack']),
            'btn_queue' => trim($_GPC['btn_queue']),
            'btn_intelligent' => trim($_GPC['btn_intelligent']),
            'btn_shouyin' => trim($_GPC['btn_shouyin']),
            'coupon_title1' => trim($_GPC['coupon_title1']),
            'coupon_title2' => trim($_GPC['coupon_title2']),
            'coupon_title3' => trim($_GPC['coupon_title3']),
            'coupon_link1' => trim($_GPC['coupon_link1']),
            'coupon_link2' => trim($_GPC['coupon_link2']),
            'coupon_link3' => trim($_GPC['coupon_link3']),
            'remarkinfo' => trim($_GPC['remarkinfo']),
            'listinfo' => trim($_GPC['listinfo']),
            'is_locktables' => intval($_GPC['is_locktables']),
            'is_brand' => intval($_GPC['is_brand']),
            'brandname' => trim($_GPC['brandname']),
            'wechat' => intval($_GPC['wechat']),
            'alipay' => intval($_GPC['alipay']),
            'credit' => intval($_GPC['credit']),
            'delivery' => intval($_GPC['delivery']),
            'is_auto_confirm' => intval($_GPC['is_auto_confirm']),
            'is_order_autoconfirm' => intval($_GPC['is_order_autoconfirm']),
            'delivery_isnot_today' => intval($_GPC['delivery_isnot_today']),
            'sendingprice' => trim($_GPC['sendingprice']),
            'dispatchprice' => trim($_GPC['dispatchprice']),
            'kefu_qrcode' => trim($_GPC['kefu_qrcode']),
            'freeprice' => trim($_GPC['freeprice']),
            'begintime' => trim($_GPC['begintime']),
            'endtime' => trim($_GPC['endtime']),
            'begintime1' => trim($_GPC['begintime1']),
            'endtime1' => trim($_GPC['endtime1']),
            'begintime2' => trim($_GPC['begintime2']),
            'endtime2' => trim($_GPC['endtime2']),
            'updatetime' => TIMESTAMP,
            'is_add_order' => intval($_GPC['is_add_order']),
            'is_delivery_nowtime' => intval($_GPC['is_delivery_nowtime']),
            'is_order_tip' => intval($_GPC['is_order_tip']),
            'dateline' => TIMESTAMP,
            'delivery_within_days' => intval($_GPC['delivery_within_days']),
            'delivery_radius' => floatval($_GPC['delivery_radius']),
            'not_in_delivery_radius' => intval($_GPC['not_in_delivery_radius']),
            'is_tea_money' => intval($_GPC['is_tea_money']),
            'is_floor_money' => intval($_GPC['is_floor_money']),
            'is_shouyin' => intval($_GPC['is_shouyin']),
            'tea_money' => floatval($_GPC['tea_money']),
            'tea_tip' => trim($_GPC['tea_tip']),
            'floor_money' => floatval($_GPC['floor_money']),
            'floor_tip' => trim($_GPC['floor_tip']),
            'default_user_count' => intval($_GPC['default_user_count']),
            'is_jueqi_ymf' => intval($_GPC['is_jueqi_ymf']),
            'jueqi_host' => trim($_GPC['jueqi_host']),
            'jueqi_customerId' => trim($_GPC['jueqi_customerId']),
            'jueqi_secret' => trim($_GPC['jueqi_secret']),
            'is_newlimitprice' => intval($_GPC['is_newlimitprice']),
            'is_oldlimitprice' => intval($_GPC['is_oldlimitprice']),
            'is_delivery_distance' => intval($_GPC['is_delivery_distance']),
            'is_sys_delivery' => intval($_GPC['is_sys_delivery']),
        );

        if ($setting['is_school'] == 1) {
            if ($_W['role'] == 'operator') { //操作员
                $curadmin = $this->getCurAdmin();
                if ($curadmin['role'] == 3) { //分站站长 固定分站id
                    $schoolid = intval($curadmin['schoolid']);
                    if ($schoolid > 0) {
                        $data['schoolid'] = $schoolid;
                    }
                }
            } else {  //站长，管理员
                $data['schoolid'] = intval($_GPC['schoolid']);
            }
        }

        if ($config['is_fengniao']==1) {
            $data['is_fengniao'] = intval($_GPC['is_fengniao']);
        }

        if(!empty($_GPC['thumbs']['image'])) {
            $thumbs = array();
            foreach($_GPC['thumbs']['image'] as $key => $image) {
                if(empty($image)) {
                    continue;
                }
                $thumbs[] = array(
                    'image' => $image,
                    'url' => trim($_GPC['thumbs']['url'][$key]),
                );
            }
            $data['thumbs'] = iserializer($thumbs);
        } else {
            $data['thumbs'] = '';
        }
        if (!$this->exists()) {
//            $data['wechat'] = 0;
//            $data['alipay'] = 0;
//            $data['credit'] = 0;
//            $data['delivery'] = 0;
        }

        if ($data['delivery_isnot_today'] == 1) {
            if ($data['delivery_within_days'] <= 0) {
                message('当设置当天不允许配送的时候需要设置提前点外卖天数.', '', 'error');
            }
        }

        if (istrlen($data['title']) == 0) {
            message('没有输入标题.', '', 'error');
        }
        if (istrlen($data['title']) > 30) {
            message('标题不能多于30个字。', '', 'error');
        }
        if ($_W['role'] == 'operator') {
            unset($data['is_brand']);
            unset($data['brandname']);
            unset($data['is_sys_delivery']);
        }

        if (!empty($id)) {
            unset($data['dateline']);
            pdo_update($this->table_stores, $data, array('id' => $id, 'weid' => $weid));
        } else {
            $shoptotal = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_stores) . " WHERE weid=:weid", array(':weid' => $this->_weid));
            if (!empty($config['storecount'])) {
                if ($shoptotal >= $config['storecount']) {
                    message('您只能添加' . $config['storecount'] . '家门店');
                }
            }
            pdo_insert($this->table_stores, $data);
            $id = pdo_insertid();
        }
        //begin//
        $timeids = array(0);
        if (is_array($_GPC['begintimes'])) {
            foreach ($_GPC['begintimes'] as $oid => $val) {
                $begintime = $_GPC['begintimes'][$oid];
                $endtime = $_GPC['endtimes'][$oid];
                if (empty($begintime) || empty($endtime)) {
                    continue;
                }
                $data = array(
                    'weid' => $weid,
                    'storeid' => $id,
                    'begintime' => $begintime,
                    'endtime' => $endtime,
                );
                pdo_update('weisrc_dish_mealtime', $data, array('id' => $oid));
                $timeids[] = $oid;
            }
        }
        //增加
        if (is_array($_GPC['newbegintime'])) {
            foreach ($_GPC['newbegintime'] as $nid => $val) {
                $begintime = $_GPC['newbegintime'][$nid];
                $endtime = $_GPC['newendtime'][$nid];
                if (empty($begintime) || empty($endtime)) {
                    continue;
                }

                $data = array(
                    'weid' => $weid,
                    'storeid' => $id,
                    'begintime' => $begintime,
                    'endtime' => $endtime,
                    'dateline' => TIMESTAMP
                );
                pdo_insert('weisrc_dish_mealtime', $data);
                $oid = pdo_insertid();
                $timeids[] = $oid;
            }
        }
        $timeids = implode(',', array_unique($timeids));
        if (!empty($timeids)) {
            pdo_query('delete from ' . tablename('weisrc_dish_mealtime') . " where weid = :weid and storeid = :storeid and id not in ({$timeids})", array(':weid' => $_W['uniacid'], ':storeid' => $id));
        }
        //end//

        if ($setting['is_auto_address'] == 0 || empty($setting)) {
            $distanceids = array(0);
            if (is_array($_GPC['begindistance'])) {
                foreach ($_GPC['begindistance'] as $oid => $val) {
                    $begindistance = floatval($_GPC['begindistance'][$oid]);
                    $enddistance = floatval($_GPC['enddistance'][$oid]);
                    $sendingprice = floatval($_GPC['sendingprice'][$oid]);
                    $dispatchprice = floatval($_GPC['dispatchprices'][$oid]);
                    $freeprice = $_GPC['freeprice'][$oid];

                    $data = array(
                        'weid' => $weid,
                        'storeid' => $id,
                        'begindistance' => $begindistance,
                        'enddistance' => $enddistance,
                        'sendingprice' => $sendingprice,
                        'dispatchprice' => $dispatchprice,
                    );
                    pdo_update('weisrc_dish_distance', $data, array('id' => $oid));
                    $distanceids[] = $oid;
                }
            }
            if (is_array($_GPC['newbegindistance'])) {
                foreach ($_GPC['newbegindistance'] as $nid => $val) {
                    $begindistance = floatval($_GPC['newbegindistance'][$nid]);
                    $enddistance = floatval($_GPC['newenddistance'][$nid]);
                    $sendingprice = floatval($_GPC['newsendingprice'][$nid]);
                    $dispatchprice = floatval($_GPC['newdispatchprices'][$nid]);
                    $freeprice = $_GPC['newfreeprice'][$nid];

                    if (empty($enddistance)) {
                        continue;
                    }
                    if ($enddistance <= $begindistance) {
                        continue;
                    }

                    $data = array(
                        'weid' => $weid,
                        'storeid' => $id,
                        'begindistance' => $begindistance,
                        'enddistance' => $enddistance,
                        'sendingprice' => $sendingprice,
                        'dispatchprice' => $dispatchprice,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert('weisrc_dish_distance', $data);
                    $did = pdo_insertid();
                    $distanceids[] = $did;
                }
            }
            $distanceids = implode(',', array_unique($distanceids));
            if (!empty($distanceids)) {
                pdo_query('delete from ' . tablename('weisrc_dish_distance') . " where weid = :weid and storeid = :storeid and id not in ({$distanceids})", array(':weid' => $_W['uniacid'], ':storeid' => $id));
            }
        }


        //配送特殊时间
        $dtimeids = array(0);
        if (is_array($_GPC['dbegintime'])) {
            foreach ($_GPC['dbegintime'] as $oid => $val) {
                $begintime = $_GPC['dbegintime'][$oid];
                $endtime = $_GPC['dendtime'][$oid];
                $price = $_GPC['dprice'][$oid];

                $data = array(
                    'weid' => $weid,
                    'storeid' => $id,
                    'begintime' => $begintime,
                    'endtime' => $endtime,
                    'price' => $price,
                );
                pdo_update('weisrc_dish_deliverytime', $data, array('id' => $oid));
                $dtimeids[] = $oid;
            }
        }

        if (is_array($_GPC['newdbegintime'])) {
            foreach ($_GPC['newdbegintime'] as $nid => $val) {
                $begintime = $_GPC['newdbegintime'][$nid];
                $endtime = $_GPC['newdendtime'][$nid];
                $price = $_GPC['newdprice'][$nid];

                if (empty($begintime) || empty($endtime) || empty($price)) {
                    continue;
                }

                $data = array(
                    'weid' => $weid,
                    'storeid' => $id,
                    'begintime' => $begintime,
                    'endtime' => $endtime,
                    'price' => $price,
                    'dateline' => TIMESTAMP
                );
                pdo_insert('weisrc_dish_deliverytime', $data);
                $oid = pdo_insertid();
                $dtimeids[] = $oid;
            }
        }

        $dtimeids = implode(',', array_unique($dtimeids));

        if (!empty($dtimeids)) {
            pdo_query('delete from ' . tablename('weisrc_dish_deliverytime') . " where weid = :weid and storeid = :storeid and id not in ({$dtimeids})", array(':weid' => $_W['uniacid'], ':storeid' => $id));
        }

        message('操作成功!', $url);
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $store = pdo_fetch("SELECT id FROM " . tablename($this->table_stores) . " WHERE id = {$id} AND weid={$weid} ");
    if (empty($store)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('stores', array('op' => 'display')), 'error');
    }
    pdo_update($this->table_stores, array('deleted' => 1),array('id' => $id, 'weid' => $_W['uniacid']));
    message('删除成功！', $this->createWebUrl('stores', array('op' => 'display')), 'success');
} elseif ($operation == 'restore') {
    $id = intval($_GPC['id']);
    $store = pdo_fetch("SELECT id FROM " . tablename($this->table_stores) . " WHERE id = '$id'");
    if (empty($store)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('stores', array('op' => 'display')), 'error');
    }
    pdo_update($this->table_stores, array('deleted' => 0),array('id' => $id, 'weid' => $_W['uniacid']));
    message('还原成功！', $this->createWebUrl('stores', array('op' => 'display')), 'success');
} elseif ($operation == 'adminbusinesslog') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;

    $list = pdo_fetchall("SELECT a.*,b.pay_account as pay_account FROM " . tablename
        ($this->table_businesslog) . " a LEFT JOIN
" . tablename($this->table_account) . " b ON a.uid=b.uid WHERE a.weid =:weid ORDER BY a.id DESC LIMIT
" . ($pindex - 1) * $psize . ",{$psize}", array(':weid' => $weid));

    $stores = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid=:weid ORDER BY id DESC", array(':weid' => $weid), 'id');

    if (!empty($list)) {
        $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_businesslog) . " WHERE weid = :weid ", array(':weid' => $weid));
        $pager = pagination($total, $pindex, $psize);
    }

} elseif ($operation == 'setstatus') {
    if ($_W['role'] == 'manager' || $_W['isfounder']) {
        $id = intval($_GPC['id']);
        pdo_update($this->table_businesslog, array('status' => 1, 'handletime' => TIMESTAMP), array('id' => $id, 'weid' => $weid));
        message('操作成功！', $this->createWebUrl('stores', array('op' => 'adminbusinesslog')), 'success');
    }
} elseif ($operation == 'openshop') {
    if ($_W['role'] == 'manager' || $_W['isfounder']) {
        pdo_update($this->table_stores, array('is_show' => 1), array('weid' => $weid));
        message('操作成功！', $this->createWebUrl('stores', array('op' => 'display')), 'success');
    }
} elseif ($operation == 'closeshop') {
    if ($_W['role'] == 'manager' || $_W['isfounder']) {
        pdo_update($this->table_stores, array('is_show' => 0), array('weid' => $weid));
        message('操作成功！', $this->createWebUrl('stores', array('op' => 'display')), 'success');
    }
} elseif ($operation == 'changeprice') {
    if ($_W['role'] == 'manager' || $_W['isfounder']) {
        $dispatchprice = trim($_GPC['dispatchprice']);
        $sendingprice = trim($_GPC['sendingprice']);
        if ($dispatchprice != '' || $sendingprice != '') {
            $data = array();
            if ($dispatchprice != '') {
                $data['dispatchprice'] = floatval($_GPC['dispatchprice']);
            }
            if ($sendingprice != '') {
                $data['sendingprice'] = floatval($_GPC['sendingprice']);
            }
            pdo_update($this->table_stores, $data, array('weid' => $weid));
            message('操作成功！', $this->createWebUrl('stores', array('op' => 'display')), 'success');
        }
    }
} elseif ($operation == 'deletetrue') {
    if ($_W['role'] == 'manager' || $_W['isfounder']) {
        $id = intval($_GPC['id']);
        $store = pdo_fetch("SELECT id FROM " . tablename($this->table_stores) . " WHERE id = {$id} AND weid={$weid} ");
        if (empty($store)) {
            message('抱歉，不存在或是已经被删除！', $this->createWebUrl('stores', array('op' => 'display')), 'error');
        }
        pdo_delete($this->table_stores, array('id' => $id, 'weid' => $_W['uniacid']));
        message('删除成功！', $this->createWebUrl('stores', array('op' => 'display', 'deleted' => 1)), 'success');
    } else {
        message('您没有删除权限！', $this->createWebUrl('stores', array('op' => 'display')), 'success');
    }
}

include $this->template('web/stores');