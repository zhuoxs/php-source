<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$do = 'payform';
$storeid = intval($_GPC['storeid']);
$sid = intval($_GPC['sid']);

$setting = $this->getSetting();
if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'payform'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid), true);
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



if (empty($from_user)) {
    message('会话已过期，请重新发送关键字!');
}

if (empty($storeid)) {
    message('请先选择门店', $this->createMobileUrl('waprestlist'));
}
$store = $this->getStoreById($storeid);
if ($this->getstoretimestatus($store) == 0) { //休息中
    message('门店暂停营业中,暂不接单!');
}

$fans = $this->getFansByOpenid($from_user);
if (empty($fans)) {
    $this->addFans($nickname, $headimgurl);
} else {
    $this->updateFans($nickname, $headimgurl, $fans['id']);
}
$fans = $this->getFansByOpenid($from_user);
if ($fans['status'] == 0) {
    message('你被禁止下单,不能进行相关操作...');
}

$share_title = !empty($setting['share_title']) ? str_replace("#username#", $nickname, $setting['share_title']) : "您的朋友{$nickname}邀请您来吃饭";
$share_desc = !empty($setting['share_desc']) ? str_replace("#username#", $nickname, $setting['share_desc']) : "最新潮玩法，快来试试！";
$share_image = !empty($setting['share_image']) ? tomedia($setting['share_image']) : tomedia("../addons/weisrc_dish/icon.jpg");
$share_url = $host . 'app/' . $this->createMobileUrl('usercenter', array('agentid' => $fans['id']), true);

$config = $this->module['config']['weisrc_dish'];

include $this->template($this->cur_tpl . '/pay_form');