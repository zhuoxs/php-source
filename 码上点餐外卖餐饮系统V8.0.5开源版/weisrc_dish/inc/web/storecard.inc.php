<?php
global $_W, $_GPC;
load()->func('tpl');
$weid = $_W['uniacid'];
$action = 'storecard';
$title = '会员卡管理';

$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$setting = $this->getSetting();

$url = $this->createWebUrl($action, array('storeid' => $storeid, 'op' => 'post'));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
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

    $list = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_storecard') . " {$where} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");

    foreach($list as $key => $value) {
        $fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE from_user = :from_user LIMIT 1;", array(':from_user' => $value['from_user']));
        if ($fans) {
            $list[$key]['headimgurl'] = $fans['headimgurl'];
            $list[$key]['nickname'] = $fans['nickname'];
        }
    }

    if (!empty($list)) {
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('weisrc_dish_storecard') . " $where");
        $pager = pagination($total, $pindex, $psize);
    }

} else if ($operation == 'post') {

    $distancelist = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_storecardprice') . " WHERE weid = :weid AND storeid=:storeid order by id", array(':weid' => $weid, ':storeid' => $storeid));
    $privilegelist = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_storecardprivilege') . " WHERE weid = :weid AND storeid=:storeid order by id", array(':weid' => $weid, ':storeid' => $storeid));

    if (checksubmit('submit')) {

        $data = array(
            'card_title' => trim($_GPC['card_title']),
            'card_rule' => trim($_GPC['card_rule']),
        );

        if (istrlen($data['card_title']) == 0) {
            message('没有输入标题.', '', 'error');
        }
        if (istrlen($data['title']) > 30) {
            message('标题不能多于30个字。', '', 'error');
        }
        pdo_update('weisrc_dish_stores', $data, array('id' => $storeid, 'weid' => $_W['uniacid']));


        //----------------------------
        $storecardprivilege = array(0);
        if (is_array($_GPC['privilegetitle'])) {
            foreach ($_GPC['privilegetitle'] as $oid => $val) {
                $title = trim($_GPC['privilegetitle'][$oid]);
                $desc = trim($_GPC['desc'][$oid]);
                $icon = trim($_GPC['icon'][$oid]);
                $url = trim($_GPC['url'][$oid]);

                if (empty($title)) {
                    continue;
                }

                $data = array(
                    'weid' => $weid,
                    'storeid' => $storeid,
                    'title' => $title,
                    'desc' => $desc,
                    'icon' => $icon,
                    'url' => $url,
                    'dateline' => TIMESTAMP
                );
                pdo_update('weisrc_dish_storecardprivilege', $data, array('id' => $oid));
                $storecardprivilege[] = $oid;
            }
        }

        if (is_array($_GPC['newprivilegetitle'])) {
            foreach ($_GPC['newprivilegetitle'] as $nid => $val) {
                $newtitle = trim($_GPC['newprivilegetitle'][$nid]);
                $newdesc = trim($_GPC['newdesc'][$nid]);
                $newicon = intval($_GPC['newicon'][$nid]);
                $newurl = trim($_GPC['newurl'][$nid]);

                if (empty($newtitle)) {
                    continue;
                }

                $data = array(
                    'weid' => $weid,
                    'storeid' => $storeid,
                    'title' => $newtitle,
                    'desc' => $newdesc,
                    'icon' => $newicon,
                    'url' => $newurl,
                    'dateline' => TIMESTAMP
                );

                pdo_insert('weisrc_dish_storecardprivilege', $data);
                $oid = pdo_insertid();
                $storecardprivilege[] = $oid;
            }
        }

        $storecardprivilege = implode(',', array_unique($storecardprivilege));
        if (!empty($storecardprivilege)) {
            pdo_query('delete from ' . tablename('weisrc_dish_storecardprivilege') . " where weid = :weid and storeid = :storeid and id not in ({$storecardprivilege})", array(':weid' => $weid, ':storeid' => $storeid));
        }
        //----------------------------
        $storecardprices = array(0);

        if (is_array($_GPC['title'])) {
            foreach ($_GPC['title'] as $oid => $val) {

                $title = $_GPC['title'][$oid];
                $day = intval($_GPC['day'][$oid]);
                $price = $_GPC['price'][$oid];

                $data = array(
                    'weid' => $weid,
                    'storeid' => $storeid,
                    'title' => $title,
                    'daycount' => $day,
                    'price' => $price,
                    'dateline' => TIMESTAMP
                );
                pdo_update('weisrc_dish_storecardprice', $data, array('id' => $oid));
                $storecardprices[] = $oid;
            }
        }

        if (is_array($_GPC['newtitle'])) {
            foreach ($_GPC['newtitle'] as $nid => $val) {
                $newtitle = $_GPC['newtitle'][$nid];
                $newday = intval($_GPC['newday'][$nid]);
                $newprice = floatval($_GPC['newprice'][$nid]);

                if (empty($newtitle) || empty($newday) || empty($newprice)) {
                    continue;
                }

                $data = array(
                    'weid' => $weid,
                    'storeid' => $storeid,
                    'title' => $newtitle,
                    'daycount' => $newday,
                    'price' => $newprice,
                    'dateline' => TIMESTAMP
                );
                pdo_insert('weisrc_dish_storecardprice', $data);

                $oid = pdo_insertid();
                $storecardprices[] = $oid;
            }
        }

        $storecardprices = implode(',', array_unique($storecardprices));
        if (!empty($storecardprices)) {
            pdo_query('delete from ' . tablename('weisrc_dish_storecardprice') . " where weid = :weid and storeid = :storeid and id not in ({$storecardprices})", array(':weid' => $_W['uniacid'], ':storeid' => $storeid));
        }

        $url = $this->createWebUrl('storecard', array('storeid' => $storeid, 'op' => 'post'));
        message('操作成功!', $url);
    }
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    if ($id > 0) {
//        pdo_delete($this->table_coupon, array('id' => $id, 'weid' => $_W['uniacid']));
    }
    message('操作成功!', $url);
} else if ($operation == 'couponstatus') {
    $status = intval($_GPC['status']);
    $data = array('is_card' => $status);
    pdo_update($this->table_stores, $data, array('id' => $storeid, 'weid' => $weid));
    $this->message('操作成功!!', '', -1);
} else if ($operation == 'setstatus') {
    $id = intval($_GPC['id']);
    $status = intval($_GPC['status']);
    pdo_query("UPDATE " . tablename('weisrc_dish_storecard') . " SET status = abs(:status - 1) WHERE id=:id", array(':status' => $status, ':id' => $id));
    message('操作成功！', $this->createWebUrl('storecard', array('op' => 'display', 'storeid' => $storeid)), 'success');
} else if ($operation == 'opencard') {

    if (checksubmit('submit')) {
        $from_user = $_GPC['from_user'];
        $daycount = intval($_GPC['daycount']);

        if (empty($from_user)) {
            message('请先选择用户！');
        }

        if ($daycount <= 0) {
            message('请输入开卡天数！');
        }

        $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_storecard') . " WHERE storeid=:storeid AND from_user=:from_user
LIMIT 1;", array(':storeid' => $storeid, ':from_user' => $from_user));

        if (empty($card)) { //新卡
            $time = strtotime('+'.$daycount.' days', TIMESTAMP);
            $data_card = array(
                'weid' => $weid,
                'storeid' => $storeid,
                'from_user' => $from_user,
                'cardpre' => '',
                'carnumber' => '',
                'cardno' => $this->getStoreCardNumber($weid),
                'coin' => 0,
                'balance_score' => 0,
                'total_score' => 0,
                'spend_score' => 0,
                'sign_score' => 0,
                'money' => 0,
                'status' => 1,
                'lasttime' => $time,
                'dateline' => TIMESTAMP
            );
            $data_card['carnumber'] = $data_card['cardno'];
            pdo_insert('weisrc_dish_storecard', $data_card);
        } else {
            $time = strtotime('+'.$daycount.' days', $card['lasttime']);
            pdo_update('weisrc_dish_storecard', array('lasttime' => $time), array('id' => $card['id']));
        }
        message('操作成功！', $this->createWebUrl('storecard', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'addcoin') {
    $price = intval($_GPC['price']);
    $id = intval($_GPC['id']);
    $remark = trim($_GPC['remark']);

    $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_storecard') . " WHERE id=:id
LIMIT 1;", array(':id' => $id));
    if ($card) {
        $data = array(
            'weid' => $weid,
            'storeid' => $storeid,
            'from_user' => $card['from_user'],
            'price' => $price,
            'type' => 1, //充值:1,消费:2
            'remark' => $remark,
            'dateline' => TIMESTAMP
        );
        pdo_insert('weisrc_dish_storecardlog', $data);
        pdo_update('weisrc_dish_storecard', array('coin' => $card['coin'] + $price), array('id' => $card['id']));
        message('充值成功', $url = $this->createWebUrl('storecard', array('storeid' => $storeid, 'op' => 'display')));
    }
}

include $this->template('web/storecard');