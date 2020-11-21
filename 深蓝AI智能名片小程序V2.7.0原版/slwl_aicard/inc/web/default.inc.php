<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');

if ($_W['ispost']) {
    $options = $_GPC['options'];

    $data = array();
    $data['setting_value'] = json_encode($options); // 压缩

    if ($_W['slwl']['set']['default_set_settings']) {
        $where['uniacid'] = $_W['uniacid'];
        $where['setting_name'] = 'default_set_settings';
        pdo_update('slwl_aicard_settings', $data, $where);
    } else {
        $data['uniacid'] = $_W['uniacid'];
        $data['setting_name'] = 'default_set_settings';
        $data['addtime'] = $_W['slwl']['datetime']['now'];
        pdo_insert('slwl_aicard_settings', $data);
    }

    iajax(0, '保存成功！');
}

if ($_W['slwl']['set']['default_set_settings']) {
    $settings = $_W['slwl']['set']['default_set_settings'];
}

include $this->template('web/default');

?>