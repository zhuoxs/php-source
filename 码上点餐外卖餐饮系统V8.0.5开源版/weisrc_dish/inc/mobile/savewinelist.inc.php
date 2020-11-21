<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$cur_nave = 'my';
$status = 0;

if (!empty($_GPC['status'])) {
    $status = intval($_GPC['status']);
}
$do = 'Savewinelist';

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'Savewinelist'; //method
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



if (empty($from_user)) {
    message('会话已过期，请重新发送关键字!');
}

$storelist = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid=:weid ORDER BY id DESC ", array(':weid' => $weid), 'id');

$order_list = pdo_fetchall("SELECT a.* FROM " . tablename($this->table_savewine_log) . " AS a LEFT JOIN " . tablename($this->table_stores) . " AS b ON a.storeid=b.id  WHERE a.status={$status} AND a.from_user='{$from_user}' ORDER BY a.id DESC LIMIT 20");
//数量
$order_total = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_savewine_log) . " WHERE status=1 AND from_user='{$from_user}' ORDER BY id DESC");

include $this->template($this->cur_tpl . '/savewinelist');