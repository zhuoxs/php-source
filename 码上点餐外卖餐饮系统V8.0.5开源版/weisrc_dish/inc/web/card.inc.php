<?php
global $_W, $_GPC;
load()->func('tpl');
$weid = $_W['uniacid'];
$action = 'card';
$title = '会员卡管理';
$storeid = intval($_GPC['storeid']);
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getMainMenu();

$cardsetting = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_cardsetting') . " WHERE weid=:weid LIMIT 1", array
(':weid' => $weid));


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

    $list = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_card') . " {$where} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");

    foreach($list as $key => $value) {
        $fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE from_user = :from_user LIMIT 1;", array(':from_user' => $value['from_user']));
        if ($fans) {
            $list[$key]['headimgurl'] = $fans['headimgurl'];
            $list[$key]['nickname'] = $fans['nickname'];
        }
    }

    if (!empty($list)) {
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('weisrc_dish_card') . " $where");
        $pager = pagination($total, $pindex, $psize);
    }

} else if ($operation == 'post') {

    $distancelist = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_cardprice') . " WHERE weid = :weid AND storeid=:storeid order by id", array(':weid' => $weid, ':storeid' => $storeid));
    $privilegelist = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_cardprivilege') . " WHERE weid = :weid AND storeid=:storeid order by id", array(':weid' => $weid, ':storeid' => $storeid));

    if (checksubmit('submit')) {

        $data = array(
            'weid' => $weid,
            'title' => trim($_GPC['card_title']),
            'rule' => trim($_GPC['card_rule']),
            'opencardcredit' => intval($_GPC['opencardcredit']),
            'sendcredit' => intval($_GPC['sendcredit']),
            'startmoney' => intval($_GPC['startmoney']),
            'maxcredit' => intval($_GPC['maxcredit']),
        );

        if (istrlen($data['title']) == 0) {
            message('没有输入标题.', '', 'error');
        }
        if (istrlen($data['title']) > 30) {
            message('标题不能多于30个字。', '', 'error');
        }

        if ($cardsetting) {
            pdo_update('weisrc_dish_cardsetting', $data, array('weid' => $_W['uniacid']));
        } else {
            pdo_insert('weisrc_dish_cardsetting', $data);
        }

        //----------------------------
        $cardprivilege = array(0);
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
                pdo_update('weisrc_dish_cardprivilege', $data, array('id' => $oid));
                $cardprivilege[] = $oid;
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

                pdo_insert('weisrc_dish_cardprivilege', $data);
                $oid = pdo_insertid();
                $cardprivilege[] = $oid;
            }
        }

        $cardprivilege = implode(',', array_unique($cardprivilege));
        if (!empty($cardprivilege)) {
            pdo_query('delete from ' . tablename('weisrc_dish_cardprivilege') . " where weid = :weid and storeid = :storeid and id not in ({$cardprivilege})", array(':weid' => $weid, ':storeid' => $storeid));
        }
        //----------------------------
        $cardprices = array(0);

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
                pdo_update('weisrc_dish_cardprice', $data, array('id' => $oid));
                $cardprices[] = $oid;
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
                pdo_insert('weisrc_dish_cardprice', $data);

                $oid = pdo_insertid();
                $cardprices[] = $oid;
            }
        }

        $cardprices = implode(',', array_unique($cardprices));
        if (!empty($cardprices)) {
            pdo_query('delete from ' . tablename('weisrc_dish_cardprice') . " where weid = :weid and storeid = :storeid and id not in ({$cardprices})", array(':weid' => $_W['uniacid'], ':storeid' => $storeid));
        }

        $url = $this->createWebUrl('card', array('storeid' => $storeid, 'op' => 'post'));
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
    $data = array('status' => $status);
    pdo_update('weisrc_dish_cardsetting', $data, array('weid' => $weid));
    $this->message('操作成功!!', '', -1);
} else if ($operation == 'setstatus') {
    $status = intval($_GPC['status']);
    $id = intval($_GPC['id']);
    pdo_query("UPDATE " . tablename('weisrc_dish_card') . " SET status = abs(:status - 1) WHERE id=:id", array(':status' => $status, ':id' => $id));
    message('操作成功!', $this->createWebUrl('card', array('op' => 'display')), 'success');
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

        $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_card') . " WHERE storeid=:storeid AND from_user=:from_user
LIMIT 1;", array(':storeid' => $storeid, ':from_user' => $from_user));

        if (empty($card)) { //新卡
            $time = strtotime('+'.$daycount.' days', TIMESTAMP);
            $data_card = array(
                'weid' => $weid,
                'storeid' => $storeid,
                'from_user' => $from_user,
                'cardpre' => '',
                'carnumber' => '',
                'cardno' => $this->getCardNumber($weid),
                'coin' => 0,
                'balance_score' => 0,
                'total_score' => 0,
                'spend_score' => 0,
                'sign_score' => 0,
                'money' => 0,
                'balance_score' => intval($_GPC['balance_score']),
                'status' => 1,
                'lasttime' => $time,
                'dateline' => TIMESTAMP
            );
            $data_card['carnumber'] = $data_card['cardno'];
            pdo_insert('weisrc_dish_card', $data_card);
        } else {
            $time = strtotime('+'.$daycount.' days', $card['lasttime']);
            pdo_update('weisrc_dish_card', array('lasttime' => $time), array('id' => $card['id']));
        }
        message('操作成功！', $this->createWebUrl('card', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'addcoin') {
    $price = intval($_GPC['price']);
    $id = intval($_GPC['id']);
    $remark = trim($_GPC['remark']);

    $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_card') . " WHERE id=:id
LIMIT 1;", array(':id' => $id));
    if ($card) {
        $datalog = array(
            'weid' => $weid,
            'title' => '',
            'from_user' => $card['from_user'],
            'type' => 1,
            'price' => $price,
            'remark' => '系统后台添加:' . $remark,
            'dateline' => TIMESTAMP
        );
        pdo_insert('weisrc_dish_cardlog', $datalog);
        pdo_update('weisrc_dish_card', array('balance_score' => $card['balance_score'] + $price), array('id' => $card['id']));
        message('充值成功', $url = $this->createWebUrl('card', array('storeid' => $storeid, 'op' => 'display')));
    }
}

include $this->template('web/card');