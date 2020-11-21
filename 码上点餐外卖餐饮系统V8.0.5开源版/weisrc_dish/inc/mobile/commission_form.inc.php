<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$logtype = intval($_GPC['logtype']);
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
    if ($setting['auth_mode'] == 1 || empty($setting)) {
        $method = 'commission_form'; //method
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

    $user = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE weid = :weid  AND from_user=:from_user ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':from_user' => $from_user));

    $commission_price = floatval($user['commission_price']);
    $commission_price = sprintf('%.2f', $commission_price);

    $delivery_price = floatval($user['delivery_price']);
    $delivery_price = sprintf('%.2f', $delivery_price);
    $delivery_rate = floatval($setting['delivery_rate']);


    include $this->template($this->cur_tpl . '/commission_form');
} else if ($operation == 'post') {
    if (empty($from_user)) {
        $this->showTip('请重新发送关键字进入系统!');
    }

    $user = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE weid = :weid  AND from_user=:from_user ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':from_user' => $from_user));

    if (empty($user)) {
        $this->showTip('用户不存在!');
    }

    if ($logtype == 1) {
        $commission_price = floatval($user['commission_price']);//分销
    } else {
        $commission_price = floatval($user['delivery_price']); //配送
    }

    $totalprice = floatval($_GPC['totalprice']);

    if ($commission_price <= 0) {
        $this->showTip('你当前没有佣金!');
    } else {
        $delivery_cash_price = intval($setting['delivery_cash_price']);
        if ($delivery_cash_price > 0) {
            if ($totalprice < $delivery_cash_price) {
                $this->showTip("最低的提现金额为{$delivery_cash_price}元!");
            }
        }
    }

    if ($totalprice > $commission_price) {
        $this->showTip('提现的金额不能大于您的佣金！');
    }
    $type = intval($_GPC['type']);


    $charges = 0;
    $delivery_rate = floatval($setting['delivery_rate']);
    $successprice = $totalprice;
    if ($delivery_rate > 0) {
        $charges = $totalprice * $delivery_rate / 100;
        $successprice = $totalprice - $charges;
    }

    if ($successprice < 1) {
        $this->showTip('到账金额低于1元，不允许提现！');
    }

    $data = array(
        'weid' => $weid,
        'storeid' => $storeid,
        'from_user' => $from_user,
        'type' => $type,
        'logtype' => $logtype, //佣金类型
        'price' => $totalprice,
        'charges' => $charges,
        'successprice' => $successprice,
        'totalprice' => $commission_price - $totalprice,
        'status' => 0,
        'dateline' => TIMESTAMP
    );
    pdo_insert('weisrc_dish_cashlog', $data);

    //扣除佣金
    if ($logtype == 1) {
        $this->updateFansCommission($from_user, 'commission_price', -$totalprice,  "推广佣金提现");
    } else {
        $this->updateFansCommission($from_user, 'delivery_price', -$totalprice,  "配送佣金提现");
    }
    $this->showTip('已申请提现请等待管理员审核！', 1);
}

