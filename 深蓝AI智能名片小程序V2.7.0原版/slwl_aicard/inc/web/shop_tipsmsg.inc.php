<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');

$condition = ' and uniacid=:uniacid and setting_name=:setting_name';
$params = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'set_shop_msg_settings');
$msg = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition, $params);

if ($_W['ispost']) {
    $options = $_GPC['options'];

    $data = array();
    $data['uniacid'] = $_W['uniacid'];
    $data['setting_name'] = 'set_shop_msg_settings';
    $data['setting_value'] = json_encode($options);

    if (!empty($msg)) {
        pdo_update('slwl_aicard_settings', $data, array('id' => $msg['id']));
    } else {
        $data['addtime'] = date('Y-m-d H:i:s', time());
        pdo_insert('slwl_aicard_settings', $data);
    }

    $type = $options['type'];
    $appkey = $options['Alidayu']['appkey'];
    $secret = $options['Alidayu']['secret'];
    $mobile = $options['Alidayu']['mobile']; // 手机号
    $sign = $options['Alidayu']['sign']; // 签名
    $sms_id = $options['Alidayu']['sms_id']; // 短信模板ID
    $curr_date = date('m-d H:i:s', time()); // 变量最长只能15个字符

    if (($type == 'Alidayu') && (!(empty($mobile))) && (intval($_GPC['test']) > 0)){
        $res = sendsms($mobile, array('time'=>$curr_date), $sms_id, array('appkey'=>$appkey, 'secret'=>$secret, 'sign'=>$sign));
    }

    iajax(0, '更新短信设置成功！');
    exit;
}

if (!(empty($msg))) {
    $messages = json_decode($msg['setting_value'], true);
}

include $this->template('web/shop/tipsmsg');

?>