<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$cur_nave = 'detail';
$id = intval($_GPC['id']);
$sid = intval($_GPC['sid']);
$item = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND id=:id ORDER BY displayorder DESC", array(':weid' => $weid, ':id' => $id));
if ($item['is_show'] != 1) {
    message('门店暂停营业中,暂不接单!');
}
$title = $item['title'];

if (empty($item)) {
    message('店面不存在！');
}

$agentid = intval($_GPC['agentid']);
$agentid2 = 0;
$agentid3 = 0;

$do = 'detail';

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'detail'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array('id' => $id, 'agentid' => $agentid), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array('id' => $id, 'agentid' => $agentid), true);
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
                $sex = $userinfo["sex"];
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

$fans = $this->getFansByOpenid($from_user);
if ($agentid != 0) {
    $agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $agentid, ':weid' => $weid));
    $agent = $this->getFansById($agentid);
    if ($setting['commission_mode'] == 2) { //代理商模式
        if ($agent['is_commission'] != 2) {//用户不是代理商重新查找
            $agent = $this->getFansById($agent['agentid']);
            $agentid = intval($agent['id']);
        }
    }

    if (!empty($agent['agentid'])) {
        $agentid2 = intval($agent['agentid']);
        $agent2 = $this->getFansById($agentid2);
        if (!empty($agent2['agentid'])) {
            $agentid3 = intval($agent2['agentid']);
        }
    }
}

if ($this->_accountlevel == 4) {
    if (empty($fans) && !empty($nickname)) {
        $insert = array(
            'weid' => $weid,
            'from_user' => $from_user,
            'nickname' => $nickname,
            'headimgurl' => $headimgurl,
            'agentid' => $agentid,
            'agentid2' => $agentid2,
            'agentid3' => $agentid3,
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_fans, $insert);
    }
} else {
    if (empty($fans) && !empty($from_user)) {
        $insert = array(
            'weid' => $weid,
            'from_user' => $from_user,
            'agentid' => $agentid,
            'agentid2' => $agentid2,
            'agentid3' => $agentid3,
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_fans, $insert);
    }
}
$fans = $this->getFansByOpenid($from_user);

$lat = trim($_GPC['lat']);
$lng = trim($_GPC['lng']);
$isposition = 0;
if (!empty($lat) && !empty($lng)) {
    $isposition = 1;
    setcookie($this->_lat, $lat, TIMESTAMP + 3600 * 12);
    setcookie($this->_lng, $lng, TIMESTAMP + 3600 * 12);
    pdo_update($this->table_fans, array('lat' => $lat, 'lng' => $lng), array('id' => $fans['id']));
}

//$collection = pdo_fetch("SELECT * FROM " . tablename($this->table_collection) . " where weid = :weid AND storeid=:storeid AND from_user=:from_user LIMIT 1", array(':weid' => $weid, ':storeid' => $id, ':from_user' => $from_user));

//智能点餐
//$intelligents = pdo_fetchall("SELECT 1 FROM " . tablename($this->table_intelligent) . " WHERE weid={$weid} AND storeid={$id} GROUP BY name ORDER by name");

//$feedbacklist = pdo_fetchall("SELECT a.*,f.nickname as nickname FROM " . tablename($this->table_feedback) . " a LEFT JOIN " .
//    tablename($this->table_fans) ." f ON a.from_user=f.from_user AND a.weid=f.weid WHERE a.weid=:weid AND a.storeid=:storeid  ORDER by a.id DESC LIMIT 5", array(':storeid' => $id, ':weid' => $weid));

//$feedbackcount = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_feedback) .
//    " a INNER JOIN " . tablename($this->table_fans) . " f ON a
//.from_user=f.from_user AND a.weid=f.weid WHERE a.weid=:weid AND a.storeid=:storeid", array(':storeid' => $id, ':weid' =>
//    $weid));

$couponlist = pdo_fetchall("select * from " . tablename($this->table_coupon) . " WHERE storeid=:storeid AND :time<endtime AND type=3 ORDER BY gmoney desc,id DESC LIMIT 10", array(':storeid' => $item['id'], ':time' => TIMESTAMP));
foreach ($couponlist as $key => $value) {
    $newlimitprice .= $value['title'] . ';';
}
$couponlist = pdo_fetchall("select * from " . tablename($this->table_coupon) . " WHERE storeid=:storeid AND :time<endtime AND type=4 ORDER BY gmoney
desc,id DESC LIMIT 10", array(':storeid' => $item['id'], ':time' => TIMESTAMP));
foreach ($couponlist as $key3 => $value3) {
    $oldlimitprice .= $value3['title'] . ';';
}

$btn_count = 0;
if ($item['is_reservation'] == 1) {
    $jump_url = $this->createMobileUrl('reservationIndex', array('storeid' => $item['id'], 'mode' => 3), true);
    $btn_count++;
}
if ($item['is_meal'] == 1) {
    $jump_url = '';
    $btn_count++;
}
if ($item['is_delivery'] == 1) {
    $jump_url = $this->createMobileUrl('waplist', array('storeid' => $item['id'], 'mode' => 2), true);
    $btn_count++;
}
if ($item['is_snack'] == 1) {
    $jump_url = $this->createMobileUrl('waplist', array('storeid' => $item['id'], 'mode' => 4), true);
    $btn_count++;
}
if ($item['is_queue'] == 1) {
    $jump_url = $this->createMobileUrl('queue', array('storeid' => $item['id']), true);
    $btn_count++;
}
if ($item['is_savewine'] == 1) {
    $jump_url = $this->createMobileUrl('savewineform', array('storeid' => $item['id']), true);
    $btn_count++;
}
if ($item['is_shouyin'] == 1) {
    $jump_url = $this->createMobileUrl('payform', array('storeid' => $item['id']), true);
    $btn_count++;
}

if ($item['is_check_user'] == 1) {
    $checkuser = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_checkuser") . " WHERE storeid = :storeid AND from_user=:from_user", array(':storeid' => $id, ':from_user' => $from_user));
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



$item['thumbs'] = iunserializer($item['thumbs']);
$share_image = tomedia($item['logo']);
$share_title = $item['title'];
$share_desc = $item['title'];
$share_url = $host . 'app/' . $this->createMobileUrl('detail', array('id' => $id,'agentid' => $fans['id']), true);

if ($item['is_list'] == 0) {
    setcookie('global_sid_' . $_W['uniacid'], $id, time() + 3600 * 24);
    $this->global_sid = $id;
}

$is_online_pay = 0;
if ($item['wechat'] == 1 || $item['alipay'] == 1) {
    $is_online_pay = 1;
}

$cardsetting = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_cardsetting') . " WHERE weid=:weid LIMIT 1", array
(':weid' => $weid));


include $this->template($this->cur_tpl . '/detail');