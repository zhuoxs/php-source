<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$logtype = intval($_GPC['logtype']);
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$storeid = intval($_GPC['storeid']);
$is_contain_delivery = intval($setting['is_contain_delivery']);
//最低提现金额
$getcash_price = intval($setting['getcash_price']);
$fee_rate = floatval($setting['fee_rate']);
$fee_min = intval($setting['fee_min']);
$fee_max = intval($setting['fee_max']);

$store = $this->getStoreById($storeid);
if ($store['is_default_rate'] == 2) {
    $getcash_price = intval($store['getcash_price']);
    $fee_rate = floatval($store['fee_rate']);
    $fee_min = intval($store['fee_min']);
    $fee_max = intval($store['fee_max']);
}

if ($operation == 'display') {
    if ($setting['auth_mode'] == 1 || empty($setting)) {
        $method = 'adminmoney'; //method
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

    $is_permission = false;
    $is_all = false;
    $tousers = explode(',', $setting['tpluser']);
    if (in_array($from_user, $tousers)) {
        $is_all = true;
        $is_permission = true;
    }
    if ($is_permission == false) {
        $accounts = pdo_fetchall("SELECT storeid FROM " . tablename($this->table_account) . " WHERE weid = :weid AND from_user=:from_user AND
 status=2 AND is_admin_order=1 ORDER BY id DESC ", array(':weid' => $this->_weid, ':from_user' => $from_user));
        if ($accounts) {
            $arr = array();
            foreach ($accounts as $key => $val) {
                $arr[] = $val['storeid'];
            }
            $storeids = implode(',', $arr);
            $is_permission = true;
        }
    }
    if ($is_permission == false) {
        message('对不起，您没有该功能的操作权限!');
    }

    $order_totalprice = $this->getStoreOrderTotalPrice($storeid, $is_contain_delivery);
    //已申请
    $totalprice1 = $this->getStoreOutTotalPrice($storeid);
    //未申请
    $totalprice2 = $this->getStoreGetTotalPrice($storeid);

    $totalprice = $order_totalprice - $totalprice1 - $totalprice2;
    $totalprice = sprintf('%.2f', $totalprice);

    include $this->template($this->cur_tpl . '/adminmoney');
} else if ($operation == 'post') {
    if (empty($from_user)) {
        $this->showTip('请重新发送关键字进入系统!');
    }
    $is_permission = false;
    $is_all = false;
    $tousers = explode(',', $setting['tpluser']);
    if (in_array($from_user, $tousers)) {
        $is_all = true;
        $is_permission = true;
    }
    if ($is_permission == false) {
        $accounts = pdo_fetchall("SELECT storeid FROM " . tablename($this->table_account) . " WHERE weid = :weid AND from_user=:from_user AND
 status=2 AND is_admin_order=1 AND storeid=:storeid ORDER BY id DESC ", array(':weid' => $this->_weid, ':from_user' => $from_user, ':storeid' => $storeid));
        if ($accounts) {
            $arr = array();
            foreach ($accounts as $key => $val) {
                $arr[] = $val['storeid'];
            }
            $storeids = implode(',', $arr);
            $is_permission = true;
        }
    }

    if ($is_permission == false) {
        $this->showTip('对不起，您没有该功能的操作权限!');
    }

    $order_totalprice = $this->getStoreOrderTotalPrice($storeid, $is_contain_delivery);
    //已申请
    $totalprice1 = $this->getStoreOutTotalPrice($storeid);
    //未申请
    $totalprice2 = $this->getStoreGetTotalPrice($storeid);

    $totalprice = $order_totalprice - $totalprice1 - $totalprice2;
    $totalprice = sprintf('%.2f', $totalprice);

    if ($store['business_type'] == 0) {
        $this->showTip('请先选择提现的账号');
    }
    $price = floatval($_GPC['price']);
    if ($totalprice <= 0) {
        $this->showTip('已没有足够的余额可提现！');
    }
    if ($getcash_price != 0) {
        if ($price < $getcash_price) {
            $this->showTip('最低的提现金额为' . $getcash_price);
        }
    } else {
        if ($price < 1) {
            $this->showTip('最低的提现金额为1元！');
        }
    }
    if ($price > $totalprice) {
        $this->showTip('可提现余额只有' . $totalprice);
    }
    if ($price > 20000) {
        $this->showTip('每次提现不能大于20000！');
    }
    $charges = 0;
    if ($fee_rate > 0) {
        $charges = $price * $fee_rate / 100;
    }
    if ($fee_min > 0) {
        if ($charges < $fee_min) {
            $charges = $fee_min;
        }
    }
    if ($fee_max > 0) {
        if ($charges > $fee_max) {
            $charges = $fee_max;
        }
    }

    $successprice = $price - $charges;
    $data = array(
        'weid' => $weid,
        'storeid' => $storeid,
        'uid' => $_W['user']['uid'],
        'price' => $price,
        'dining_mode' => 0,
        'business_type' => intval($store['business_type']),
        'charges' => $charges,
        'successprice' => $successprice,
        'haveprice' => $totalprice1,
        'totalprice' => $order_totalprice,
        'status' => 0,
        'dateline' => TIMESTAMP
    );
    pdo_insert($this->table_businesslog, $data);
    $id = pdo_insertid();
    if ($id > 0) {
        if ($setting['is_quick_money'] == 1) {
            $result = $this->sendMoney($store['business_openid'], $successprice, $store['business_username']);
            if ($result['result_code'] == 'SUCCESS') {
                $data = array(
                    'status' => 1,
                    'handletime' => TIMESTAMP,
                    'trade_no' => $result['trade_no'],
                    'payment_no' => $result['payment_no'],
                );
                pdo_update($this->table_businesslog, $data, array('id' => $id, 'weid' => $weid));
            } else {
                pdo_update($this->table_businesslog, array('status' => -1, 'handletime' => TIMESTAMP, 'result' => $result['msg']), array('id' => $id, 'weid' => $weid));
                $this->showTip('提现失败！请联系平台管理员！');
            }
        }
        $this->sendApplyNotice($setting, $store, $price);
    }
    $this->showTip('操作成功！', 1);
}
