<?php
global $_GPC, $_W;
$weid = $this->_weid;
$action = 'businesssetting';
$title = $this->actions_titles[$action];

$setting = $this->getSetting();
$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$this->checkPermission($storeid);

$setting = $this->getSetting();
$store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);
$operation = 'detail';

if (!empty($store['business_username'])) {
    if ($_W['role'] == 'operator') {
        message('修改提现账号请联系管理员处理');
    }
}

if (!empty($store['business_openid'])) {
    $fans = $this->getFansByOpenid($store['business_openid']);
}

if (checksubmit('submit')) {
    $business_openid = trim($_GPC['from_user']);
    $mobile = trim($_GPC['mobile']);
    if ($_W['role'] == 'operator') {
        if ($setting['is_verify_mobile'] == 1) { //验证手机号
            if (!preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|147[0-9]{8
        }$/", $mobile)
            ) {
                message('手机号码格式不对!');
            }
            $verify_code = trim($_GPC['verify_code']);
            if (empty($verify_code)) {
                message('请输入验证码!');
            } else {
                $item = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_sms_checkcode') . " WHERE weid = :weid  AND mobile=:mobile AND checkcode=:checkcode ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':mobile' => $mobile, ':checkcode' => $verify_code));
                if (empty($item)) {
                    message('验证码输入错误!');
                } else {
                    pdo_update('weisrc_dish_sms_checkcode', array('status' => 1), array('id' => $item['id']));
                }
            }
        }
    }

    if ($_GPC['business_type'] == 1) {
        if (empty($business_openid)) {
            message('请选择提现的粉丝!');
        }
        if (empty($_GPC['business_wechat'])) {
            message('请输入微信账号!');
        }
    } else {
        if (empty($_GPC['business_alipay'])) {
            message('请输入支付宝账号!');
        }
    }
    if (empty($_GPC['business_username'])) {
        message('请输入账户姓名!');
    }

    $data = array(
        'business_type' => intval($_GPC['business_type']),
        'business_openid' => $business_openid,
        'business_username' => trim($_GPC['business_username']),
        'business_alipay' => trim($_GPC['business_alipay']),
        'business_wechat' => trim($_GPC['business_wechat']),
    );
    if ($setting['is_verify_mobile'] == 1) {
        $data['business_mobile'] = $mobile;
    }

    pdo_update($this->table_stores, $data, array('id' => $storeid));

    if ($_W['role'] == 'operator') {
        message('操作成功!!!', $this->createWebUrl('businesscenter', array('op' => 'post', 'storeid' => $storeid)), 'success');
    }
    message('操作成功!!!', $this->createWebUrl('businesssetting', array('storeid' => $storeid)), 'success');
}

include $this->template('web/businesscenter');