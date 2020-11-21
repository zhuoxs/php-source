<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$cur_nave = 'detail';
$id = intval($_GPC['id']);

$do = 'coupon';
if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'coupon'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array('id' => $id), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array('id' => $id), true);
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



$coupon = pdo_fetch("SELECT * FROM " . tablename($this->table_coupon) . " where weid = :weid AND id=:id ORDER BY displayorder DESC LIMIT 1", array(':weid' => $weid, ':id' => $id));

if (empty($coupon)) {
    message('数据不存在!');
}

$store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND id=:id ORDER BY displayorder DESC LIMIT 1", array(':weid' => $weid, ':id' => $coupon['storeid']));

include $this->template($this->cur_tpl . '/coupon');