<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$cur_nave = 'detail';

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'couponlist'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array(), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array(), true);
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

$where = "WHERE weid = :weid AND type<>4 AND attr_type = 1 AND :time > starttime AND :time < endtime ";
$coupons = pdo_fetchall("SELECT * FROM " . tablename($this->table_coupon) . " {$where} order by displayorder desc,id
desc LIMIT 10", array(':time' => TIMESTAMP, ':weid' => $weid));

foreach($coupons as $key => $value) {
    $store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND id=:id ORDER BY displayorder DESC LIMIT 1", array(':weid' => $weid, ':id' => $value['storeid']));
    $coupons[$key]['shopname'] = $store['title'];
}

include $this->template($this->cur_tpl . '/couponlist');