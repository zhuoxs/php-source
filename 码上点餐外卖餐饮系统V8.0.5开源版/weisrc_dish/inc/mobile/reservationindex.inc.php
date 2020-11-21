<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$storeid = intval($_GPC['storeid']);
$setting = $this->getSetting();

$cur_date = date("Y-m-d", TIMESTAMP);
$cur_time = date("H:i", TIMESTAMP);
$select_date = empty($_GPC['selectdate']) ? $cur_date : $_GPC['selectdate'];

$do = 'ReservationIndex';

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'ReservationIndex'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'selectdate' => $select_date), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'selectdate' => $select_date), true);
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



$store = $this->getStoreById($storeid);

$fans = $this->getFansByOpenid($from_user);
if ($this->_accountlevel == 4) {
    if (empty($fans) && !empty($nickname)) {
        $insert = array(
            'weid' => $weid,
            'from_user' => $from_user,
            'nickname' => $nickname,
            'sex' => $sex,
            'headimgurl' => $headimgurl,
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_fans, $insert);
    }
} else {
    if (empty($fans) && !empty($from_user)) {
        $insert = array(
            'weid' => $weid,
            'from_user' => $from_user,
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_fans, $insert);
    }
}
$fans = $this->getFansByOpenid($from_user);

$tablezones = pdo_fetchall("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE weid = :weid AND storeid =:storeid ORDER BY displayorder DESC, id DESC", array(':weid' => $this->_weid, ':storeid' => $storeid));

$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_reservation) . " WHERE weid = :weid AND storeid =:storeid ORDER BY displayorder DESC,id ASC ", array(':weid' => $this->_weid, ':storeid' => $storeid));

if (empty($_GPC['selectdate'])) {
    if ($store['is_reservation_today'] == 0) {
        $select_date = date('Y-m-d',strtotime("+1 day"));
    }
}

foreach ($list as $key => $value) {
    $tabel_count = 0;//默认
    $tablezonesid = intval($value['tablezonesid']);
    $reservation_time = $select_date . ' ' . $value['time'];

    if ($select_date == $cur_date) {
        $tables = pdo_fetchall("SELECT * FROM " . tablename($this->table_tables) . " WHERE storeid =:storeid AND
tablezonesid=:tablezonesid AND status=0 ORDER BY id DESC", array(':storeid' => $storeid, ':tablezonesid' => $tablezonesid), 'id');
    } else {
        $tables = pdo_fetchall("SELECT * FROM " . tablename($this->table_tables) . " WHERE storeid =:storeid AND
tablezonesid=:tablezonesid ORDER BY id DESC", array(':storeid' => $storeid, ':tablezonesid' => $tablezonesid), 'id');
    }

    $order = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid AND tables IN ('" . implode("','", array_keys($tables)) . "') AND
meal_time=:meal_time AND dining_mode=3 AND status<>-1 AND paytype<>0", array(':weid' => $this->_weid, ':storeid' => $storeid, ':meal_time' => $reservation_time));
    foreach ($tables as $key2 => $value2) {
        foreach($order as $okey => $ovalue) {
            if ($value2['id'] == $ovalue['tables']) {
                $tabel_count--;
            }
        }
        $tabel_count++;
    }
    $list[$key]['tablescount'] = $tabel_count;
}

$dates = array();
for ($i = 0; $i < $store['reservation_days']; $i++) {
    if ($i == 0) {
        $dates[] = date("Y-m-d", TIMESTAMP);
    } else {
        $dates[] = date("Y-m-d", strtotime("+{$i} day"));
    }
}

include $this->template($this->cur_tpl . '/reservation_index');