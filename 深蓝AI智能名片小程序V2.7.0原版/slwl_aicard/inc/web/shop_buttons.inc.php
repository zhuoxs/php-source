<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');

$condition = ' and uniacid=:uniacid and setting_name=:setting_name';
$params = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'set_shop_buttons_settings');
$set = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition . ' limit 1', $params);

if ($_W['ispost']) {

    $options = array();
    $data = array();
    $photo = array();
    $tmp_pic = array();

    if ($_GPC['options']) {
        $options = $_GPC['options'];
        $rownum = 4;

        if ($_GPC['rownum']) {
            $rownum = $_GPC['rownum'];
        }

        foreach ($options['attachment'] as $k => $v) {
            $tmp_pic[$k]['attachment'] = $v;
        }

        foreach ($options['title'] as $k => $v) {
            $tmp_pic[$k]['title'] = $v;
        }

        foreach ($options['page_url'] as $k => $v) {
            $tmp_pic[$k]['page_url'] = $v;
        }

        foreach ($tmp_pic as $k=>$v){
            $photo['items'][] = $v;
        }
    }

    $photo['rownum'] = $rownum;
    $photo['enabled'] = $_GPC['enabled'];

    $data['uniacid'] = $_W['uniacid'];
    $data['setting_name'] = 'set_shop_buttons_settings';
    $data['setting_value'] = json_encode($photo); // 压缩

    if ($set) {
        pdo_update('slwl_aicard_settings', $data, array('id' => $set['id']));
    } else {
        $data['addtime'] = $_W['slwl']['datetime']['now'];
        pdo_insert('slwl_aicard_settings', $data);
    }
    iajax(0, '保存成功！');
    exit;
}

if ($set) {
    $smeta = json_decode($set['setting_value'], true);
}

include $this->template('web/shop-buttons');

?>