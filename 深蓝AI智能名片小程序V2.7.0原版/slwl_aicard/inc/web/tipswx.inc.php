<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');

$account = uni_fetch($_W['uniacid']);
$appid = $account['key'];
$secret = $account['secret'];

require_once MODULE_ROOT . "/lib/jssdk/jssdk.php";

$condition = ' AND uniacid=:uniacid AND setting_name=:setting_name ';
$params = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'tipswx_settings');
$note = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition, $params);

if (checksubmit('submit')) {
    $options = $_GPC['options'];

    $data = array();
    $data['uniacid'] = $_W['uniacid'];
    $data['setting_name'] = 'tipswx_settings';
    $data['setting_value'] = json_encode($options);

    if ($note) {
        pdo_update('slwl_aicard_settings', $data, array('id' => $note['id']));
    } else {
        $data['addtime'] = $_W['slwl']['datetime']['now'];
        pdo_insert('slwl_aicard_settings', $data);
    }

    $jssdk = new JSSDK($appid, $secret, 'token_name_'.$_W['uniacid']);

    message('更新微信消息设置成功！', 'refresh');
}

if ($note) {
    $tips = json_decode($note['setting_value'], true);
}

// var_dump($messages);

include $this->template('web/tipswx');

?>