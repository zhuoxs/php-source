<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;

$cur_nave = 'home';
$setting = $this->getSetting();
$title = empty($setting) ? "微餐厅" : $setting['title'];

$areaid = intval($_GPC['areaid']);
$typeid = intval($_GPC['typeid']);
$sortid = intval($_GPC['sortid']);
$sid = intval($_GPC['sid']);
$lat = trim($_GPC['lat']);
$lng = trim($_GPC['lng']);

if ($setting['mode'] == 1) {
    $jump_url = $this->createMobileUrl('detail', array('id' => $setting['storeid']), true);
    header("location:$jump_url");
}

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'index'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array('sid' => $sid, 'lat' => $lat, 'lng' => $lng),
            true) .
        '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array('sid' => $sid, 'lat' => $lat, 'lng' => $lng), true);
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

$isposition = 0;
if (!empty($lat) && !empty($lng)) {
    $isposition = 1;
    setcookie($this->_lat, $lat, TIMESTAMP + 1800);
    setcookie($this->_lng, $lng, TIMESTAMP + 1800);
} else {
    if (isset($_COOKIE[$this->_lat])) {
        $isposition = 1;//0的时候才跳转
        $lat = $_COOKIE[$this->_lat];
        $lng = $_COOKIE[$this->_lng];
    }
}

if ($setting['is_school'] == 1) {
    if ($sid == 0) {
        if (isset($_COOKIE['school_sid'])) {
            $sid = $_COOKIE['school_sid'];
        } else {
            $nearschool = $this->getNearSchool($lat, $lng);
            $sid = intval($nearschool['id']);
        }

        $host = $this->getOAuthHost();
        $jumpurl = $host . 'app/' . $this->createMobileUrl('index', array('sid' => $sid, 'lat' => $lat, 'lng' => $lng), true);
        header("location:$jumpurl");
    } else {
        setcookie('school_sid', $sid, TIMESTAMP + 86400 * 30);
        $schoolname = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_school') . " WHERE id=:id LIMIT 1", array(':id' => $sid));
    }
}

$fans = $this->getFansByOpenid($from_user);
if (empty($fans)) {
    $this->addFans($nickname, $headimgurl);
} else {
    $this->updateFans($nickname, $headimgurl, $fans['id']);
}
$fans = $this->getFansByOpenid($from_user);

if ($setting['is_check_user'] == 1) { //判断是否需要审核
    if ($fans['is_check'] == 0) {
        message('您好，本店只支持内部人员使用!');
    }
}

$slide = $this->getSlidesByPos(2, $setting, $sid);
$adlist = $this->getSlidesByPos(3, $setting, $sid);

$styles = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_style') . " WHERE weid = :weid AND status=1 ORDER BY `displayorder` DESC, id DESC", array(':weid' => $weid));


if ($fans['status'] == 0) {
    message('系统调试中，请稍后访问');
}

$sub = 0;
if ($this->_accountlevel == 4) {
    $userinfo = $this->getUserInfo($from_user);
    if ($userinfo['subscribe'] == 1) {
        $sub = 1;
    }
} else {
    if ($_W['fans']['follow'] == 1) {
        $sub = 1;
    }
}


//门店类型
$where_type = "";
if ($setting['is_school'] == 1 && $sid > 0) {
    $where_type = " AND schoolid={$sid} ";
}

$shoptypes = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " where weid = :weid {$where_type} ORDER BY displayorder DESC", array(':weid' => $weid), 'id');

$typecount = count($shoptypes);

$slidepics = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_pic') . " where weid = :weid AND styleid<>0 ", array(':weid' => $weid));

$slidepics_arr = array();
foreach ($styles as $key => $val) {
    if ($val['type'] == 'home_slide') {
        foreach ($slidepics as $k => $v) {
            if ($val['id'] == $v['styleid']) {
                $slidepics_arr[$val['id']][] = $v;
            }
        }
    }
}

if ($sortid == 0) {
//    $sortid = 2;
}



//$ispass = 0;
//if (isset($_COOKIE['auth2_ispass_' . $_W['uniacid']])) {
//    $ispass = 1;//0的时候才跳转
//} else {
//    setcookie('auth2_ispass_' . $_W['uniacid'], 'ispass', TIMESTAMP + 120);
//}

$pindex = max(1, intval($_GPC['page']));
$psize = $this->more_store_psize;
$strwhere = " where weid = :weid and is_show=1 AND is_list=1 AND deleted=0 ";
$limit = " LIMIT "  . ($pindex - 1) * $psize . ',' . $psize;

if ($areaid != 0) {
    $strwhere .= " AND areaid={$areaid} ";
}

if ($typeid != 0) {
    $strwhere .= " AND typeid={$typeid} ";
}

if ($setting['is_school'] == 1 && $sid > 0) {
    $strwhere .= " AND schoolid={$sid} ";
}


$restlist = pdo_fetchall("SELECT *,(lat-:lat)*(lat-:lat) + (lng-:lng) * (lng-:lng) as dist FROM " . tablename($this->table_stores) . " {$strwhere} ORDER BY displayorder DESC,dist,id DESC " . $limit, array(':weid' => $weid, ':lat' => $lat, ':lng' => $lng));

$shoptotal = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_stores) . " WHERE weid={$weid} AND is_show=1 ORDER BY id DESC");

if (!empty($restlist)) {
    foreach ($restlist as $key => $value) {
//        $good_count = pdo_fetchcolumn("SELECT sum(sales) FROM " . tablename($this->table_goods) . " WHERE storeid=:id ", array(':id' => $value['id']));
        $restlist[$key]['sales'] = intval($good_count);
        $newlimitprice = '';
        $oldlimitprice = '';
        if ($value['is_newlimitprice'] == 1) {
            $couponlist = pdo_fetchall("select * from " . tablename($this->table_coupon) . " WHERE storeid=:storeid AND :time<endtime AND type=3 ORDER BY gmoney desc,id DESC LIMIT 10", array(':storeid' => $value['id'], ':time' => TIMESTAMP));
            foreach ($couponlist as $key2 => $value2) {
                $newlimitprice .= $value2['title'] . ';';
            }
            $restlist[$key]['newlimitprice'] = $newlimitprice;
        }
        if ($value['is_oldlimitprice'] == 1) {
            $couponlist = pdo_fetchall("select * from " . tablename($this->table_coupon) . " WHERE storeid=:storeid AND :time<endtime AND type=4 ORDER BY gmoney
desc,id DESC LIMIT 10", array(':storeid' => $value['id'], ':time' => TIMESTAMP));
            foreach ($couponlist as $key3 => $value3) {
                $oldlimitprice .= $value3['title'] . ';';
            }
            $restlist[$key]['oldlimitprice'] = $oldlimitprice;
        }
    }
}

$ispop = 0;
if ($setting['tiptype'] == 1) { //关注后隐藏
    if ($sub == 0) {
        $ispop = 1;
    }
} else if ($setting['tiptype'] == 2) {
    $ispop = 1;
}

$follow_title = !empty($setting['follow_title']) ? $setting['follow_title'] : "立即关注";
$follow_desc = !empty($setting['follow_desc']) ? $setting['follow_desc'] : "欢迎关注智慧点餐点击马上加入,助力品牌推广 ";
$follow_image = !empty($setting['follow_logo']) ? tomedia($setting['follow_logo']) : tomedia("../addons/weisrc_dish/icon.jpg");
$tipqrcode = tomedia($setting['tipqrcode']);
$tipbtn = intval($setting['tipbtn']);
$follow_url = $setting['follow_url'];
$this->checkRechargePrice($from_user);

if ($setting['is_school'] == 1 && $sid > 0) {
    $where_notice = " AND schoolid={$sid} ";
}
$notice = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_notice") . " WHERE weid = :weid AND status=1 {$where_notice} AND id not in(SELECT noticeid FROM
" . tablename("weisrc_dish_notice_log") . " WHERE from_user=:from_user) ORDER BY displayorder
DESC,id DESC LIMIT 1", array(':weid' => $this->_weid, ':from_user' => $from_user));

pdo_update($this->table_setting, array('visit' => intval($setting['visit']) + 1), array('id' => $setting['id']));

$share_title = !empty($setting['share_title']) ? str_replace("#username#", $nickname, $setting['share_title']) : "您的朋友{$nickname}邀请您来吃饭";
$share_desc = !empty($setting['share_desc']) ? str_replace("#username#", $nickname, $setting['share_desc']) : "最新潮玩法，快来试试！";
$share_image = !empty($setting['share_image']) ? tomedia($setting['share_image']) : tomedia("../addons/weisrc_dish/icon.jpg");
$share_url = $host . 'app/' . $this->createMobileUrl('index', array('agentid' => $fans['id']), true);

include $this->template($this->cur_tpl . '/index');