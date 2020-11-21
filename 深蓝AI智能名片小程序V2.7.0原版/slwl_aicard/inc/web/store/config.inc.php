<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');

$condition = " AND uniacid=:uniacid AND setting_name=:setting_name ";
$params = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'set_store_config');
$set = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition . ' limit 1', $params);

if ($_W['ispost']) {
    $options = $_GPC['options'];

    $data = array();
    $data['uniacid'] = $_W['uniacid'];
    $data['setting_name'] = 'set_store_config';
    $data['setting_value'] = json_encode($options);

    if ($set) {
        pdo_update('slwl_aicard_settings', $data, array('id' => $set['id']));
    } else {
        $data['addtime'] = $_W['slwl']['datetime']['now'];
        pdo_insert('slwl_aicard_settings', $data);
    }
    sl_ajax(0, '保存成功！');
}

if ($set) {
    $settings = json_decode($set['setting_value'], true);
}

include $this->template('web/store-config');

