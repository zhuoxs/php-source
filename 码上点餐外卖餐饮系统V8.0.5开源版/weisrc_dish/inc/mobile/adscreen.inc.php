<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'adscreen'; //method
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
if (empty($fans)) {
    $this->addFans($nickname, $headimgurl);
} else {
    $this->updateFans($nickname, $headimgurl, $fans['id']);
}
$fans = $this->getFansByOpenid($from_user);
if ($fans['status'] == 0) {
    die('系统调试中！');
}

//幻灯片
$slide = pdo_fetchall("SELECT * FROM " . tablename($this->table_ad) . " WHERE uniacid = :uniacid AND position=1 AND status=1 AND :time > starttime AND :time < endtime  ORDER BY displayorder DESC,id DESC LIMIT 6", array(':uniacid' => $this->_weid, ':time' => TIMESTAMP));

if (empty($slide)) {
    $jump_url = $this->createMobileUrl('index', array(), true);
    header("location:$jump_url");
}

$setting = $this->getSetting();
$title = empty($setting) ? "微餐厅" : $setting['title'];
if ($setting['mode'] == 1) {
    $jump_url = $this->createMobileUrl('detail', array('id' => $setting['storeid']), true);
} else {
    $jump_url = $this->createMobileUrl('index', array(), true);
}

include $this->template($this->cur_tpl . '/adscreen');