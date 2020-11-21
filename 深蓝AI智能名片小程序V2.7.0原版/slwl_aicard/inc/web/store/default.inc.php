<?php

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');

if ($_W['ispost']) {
    $options = $_GPC['options'];

    $data = array();
    $data['uniacid'] = $_W['uniacid'];
    $data['setting_value'] = json_encode($options); // 压缩

    if ($_W['slwl']['set']['set_store_default']) {
        $where['uniacid'] = $_W['uniacid'];
        $where['setting_name'] = 'set_store_default';
        pdo_update('slwl_aicard_settings', $data, $where);
    } else {
        $data['uniacid'] = $_W['uniacid'];
        $data['setting_name'] = 'set_store_default';
        $data['addtime'] = $_W['slwl']['datetime']['now'];
        pdo_insert('slwl_aicard_settings', $data);
    }
    sl_ajax(0, '保存成功');
}

if ($_W['slwl']['set']['set_store_default']) {
    $settings = $_W['slwl']['set']['set_store_default'];
}

include $this->template('web/store/default');

