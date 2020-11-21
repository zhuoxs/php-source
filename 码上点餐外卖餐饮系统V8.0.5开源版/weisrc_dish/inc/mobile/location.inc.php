<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$sid = intval($_GPC['sid']);

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'location'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array('typeid' => $typeid, 'areaid' => $areaid, 'sid' => $sid), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array('typeid' => $typeid, 'areaid' => $areaid, 'sid' => $sid), true);
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

$lat = trim($_GPC['lat']);
$lng = trim($_GPC['lng']);
$isposition = 0;
if ($_GPC['pos'] == 1) {
    $isposition = 1;
    setcookie($this->_lat, $lat, TIMESTAMP + 3600 * 12);
    setcookie($this->_lng, $lng, TIMESTAMP + 3600 * 12);
} else {
    if (isset($_COOKIE[$this->_lat])) {
        $isposition = 1;//0的时候才跳转
        $lat = $_COOKIE[$this->_lat];
        $lng = $_COOKIE[$this->_lng];
    }
}

if (empty($from_user)) {
    message('会话已过期，请重新发送关键字!');
}

$strwhere = " WHERE weid=:weid ";
$strorder = " ORDER BY dist ";
$restlist = pdo_fetchall("SELECT *,(lat-:lat) * (lat-:lat) + (lng-:lng) * (lng-:lng) as dist FROM " . tablename('weisrc_dish_school') . " {$strwhere
} {$strorder} LIMIT 100", array(':weid' => $this->_weid, ':lat' => $lat, ':lng' => $lng));

$share_title = !empty($setting['share_title']) ? str_replace("#username#", $nickname, $setting['share_title']) : "您的朋友{$nickname}邀请您来吃饭";
$share_desc = !empty($setting['share_desc']) ? str_replace("#username#", $nickname, $setting['share_desc']) : "最新潮玩法，快来试试！";
$share_image = !empty($setting['share_image']) ? tomedia($setting['share_image']) : tomedia("../addons/weisrc_dish/icon.jpg");
$share_url = $host . 'app/' . $this->createMobileUrl('location', array(), true);

setcookie('global_sid_' . $weid,'',time()-1);
include $this->template($this->cur_tpl . '/location');