<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$storeid = intval($_GPC['storeid']);
$op = $_GPC['op'];

$item = $this->getStoreById($storeid);

$title = $item['card_title'];
if ($op == 'open') {
    $title = '开通' . $title;
}

if ($item['is_show'] != 1) {
    message('门店暂停营业中,暂不接单!');
}
if (empty($item)) {
    message('店面不存在！');
}

$do = 'card';
if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'detail'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array('id' => $storeid, 'agentid' => $agentid), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array('id' => $storeid, 'agentid' => $agentid), true);
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



if ($item['is_check_user'] == 1) {
    $checkuser = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_checkuser") . " WHERE storeid = :storeid AND from_user=:from_user", array(':storeid' => $storeid, ':from_user' => $from_user));
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
$share_url = $host . 'app/' . $this->createMobileUrl('detail', array('id' => $storeid,'agentid' => $fans['id']), true);

if ($item['is_list'] == 0) {
    setcookie('global_sid_' . $_W['uniacid'], $storeid, time() + 3600 * 24);
    $this->global_sid = $storeid;
}

$is_online_pay = 0;
if ($item['wechat'] == 1 || $item['alipay'] == 1) {
    $is_online_pay = 1;
}

$pricelist = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_storecardprice') . " WHERE weid = :weid AND storeid=:storeid order by id", array(':weid' => $weid, ':storeid' => $storeid));
$privilegelist = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_storecardprivilege') . " WHERE weid = :weid AND storeid=:storeid order by id", array(':weid' => $weid, ':storeid' => $storeid));

$card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_storecard') . " WHERE weid = :weid AND storeid=:storeid AND from_user=:from_user
LIMIT 1;", array(':weid' => $weid, ':storeid' => $storeid, ':from_user' => $from_user));
$user = $this->getFansByOpenid($from_user);


include $this->template($this->cur_tpl . '/storecard');