<?php

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');

$condition = " AND uniacid=:uniacid AND setting_name=:setting_name ";
$params = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'set_shop_adgroup_settings');
$set = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition . ' limit 1', $params);

if ($_W['ispost']) {

    $options = array();
    $data = array();
    $photo = array();
    $tmp_pic = array();

    if ($_GPC['options']) {
        $options = $_GPC['options'];

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
            $photo[] = $v;
        }

        $data['setting_value'] = json_encode($photo); // 压缩
    }

    if ($_W['slwl']['set']['set_shop_adgroup_settings']) {
        $where['uniacid'] = $_W['uniacid'];
        $where['setting_name'] = 'set_shop_adgroup_settings';
        pdo_update('slwl_aicard_settings', $data, $where);
    } else {
        $data['uniacid'] = $_W['uniacid'];
        $data['setting_name'] = 'set_shop_adgroup_settings';
        $data['addtime'] = $_W['slwl']['datetime']['now'];
        pdo_insert('slwl_aicard_settings', $data);
    }

    iajax(0, '保存成功！');
}

if ($_W['slwl']['set']['set_shop_adgroup_settings']) {
    $smeta = $_W['slwl']['set']['set_shop_adgroup_settings'];
}

include $this->template('web/shop-adgroup');

?>