<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');

$condition = " AND uniacid=:uniacid AND setting_name=:setting_name ";
$params = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'set_store_msg');
$msg = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition, $params);

if ($_W['ispost']) {
    $options = $_GPC['options'];

    $data = array();
    $data['uniacid'] = $_W['uniacid'];
    $data['setting_name'] = 'set_store_msg';
    $data['setting_value'] = json_encode($options);

    if ($msg) {
        pdo_update('slwl_aicard_settings', $data, array('id' => $msg['id']));
    } else {
        $data['addtime'] = $_W['slwl']['datetime']['now'];
        pdo_insert('slwl_aicard_settings', $data);
    }

    $type = $options['type'];
    $appkey = $options['Alidayu']['appkey'];
    $secret = $options['Alidayu']['secret'];
    $mobile = $options['Alidayu']['mobile']; // 手机号
    $sign = $options['Alidayu']['sign']; // 签名
    $sms_id = $options['Alidayu']['sms_id']; // 短信模板ID
    $curr_date = date('m-d H:i:s', time()); // 变量最长只能15个字符

    if (($type == 'Alidayu') && ($mobile) && (intval($_GPC['test']) > 0)){
        $res = sendsms($mobile, array('time'=>$curr_date), $sms_id, array('appkey'=>$appkey, 'secret'=>$secret, 'sign'=>$sign));
    }
    iajax(0, '更新短信设置成功！');
}


if ($msg) {
    $messages = json_decode($msg['setting_value'], true);
}

include $this->template('web/store-msg');

?>