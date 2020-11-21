<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$cur_nave = 'my';
$status = 0;
$level = intval($_GPC['level']) == 0 ? 1 : intval($_GPC['level']);
if (!empty($_GPC['status'])) {
    $status = intval($_GPC['status']);
}

$do = 'my';

if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'my'; //method
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

$agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $from_user, ':weid' => $weid));

if ($agent) {
    $total_mymember_count = pdo_fetchcolumn("SELECT COUNT(1) AS count FROM " . tablename($this->table_fans) . " WHERE weid = :weid AND (agentid=:agentid OR agentid2=:agentid)", array(':weid' => $weid, ':agentid' => $agent['id']));
    $total_mymember_count = intval($total_mymember_count);

    //            if ($setting['commission_level'])
    $condition = " agentid=:agentid ";
    if ($level == 2) {
        $condition = " agentid2=:agentid ";
    }
    if ($level == 3) {
        $condition = " agentid3=:agentid ";
    }

    $total_price = pdo_fetchcolumn("SELECT sum(price) AS totalprice FROM " . tablename($this->table_commission) . " WHERE weid =
:weid AND agentid=:agentid AND status=1 ", array(':weid' => $weid, ':agentid' => $agent['id']));
    $total_price = floatval($total_price);

    $pindex = max(1, intval($_GPC['page']));
    $psize = 6;
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_fans) . "  WHERE {$condition} ORDER
            BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(':agentid' => $agent['id']));
    foreach ($list as $key => $value) {
        $mymember_count = pdo_fetchcolumn("SELECT COUNT(1) AS count FROM " . tablename($this->table_fans) . " WHERE weid = :weid AND agentid=:agentid", array(':weid' => $weid, ':agentid' => $value['id']));
        $pay_price = pdo_fetchcolumn("SELECT sum(totalprice) AS totalprice FROM " . tablename($this->table_order) . " WHERE ispay=1 AND status=3 AND weid =
:weid AND from_user=:from_user ", array(':weid' => $weid, ':from_user' => $value['from_user']));
        $pay_price = floatval($pay_price);
        $list[$key]['payprice'] = $pay_price;
        $list[$key]['mymembercount'] = $mymember_count;
    }
}

include $this->template($this->cur_tpl . '/mymemberlist');