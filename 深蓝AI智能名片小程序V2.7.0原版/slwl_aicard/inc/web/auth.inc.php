<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');

$domain = trim(preg_replace('/http(s)?:\\/\\//', '', rtrim($_W['siteroot'], '/')));

$operation = $_GPC['op'] ? $_GPC['op'] : 'display';

if ($operation == 'display') {

    if ($_W['slwl']['set']['auth_settings']) {
        $settings = $_W['slwl']['set']['auth_settings'];
    }


} elseif ($operation == 'post') {

    if ($_W['ispost']) {
        $options = $_GPC['options'];

        $param = array();
        $param['host'] = 'test.tailea.com';
        $param['ip'] = '42.236.147.69';
        $param['family'] = '2';
        $param['code'] = '888888';

        load()->func('communication');

        $resp = ihttp_request(SLWL_AUTH_URL . 'Index/index', $param);
        $result = @json_decode($resp['content'], true);
        $result['code']=='0';
        @putlog('系统授权', $result);

        if ($result['code'] == '0') {
            $options['status'] = '1';
            $options['end_time'] = $result['Data']['user_end_time'];
        } else if ($result['code'] == '2') {
            $options['status'] = '2';
            $options['end_time'] = '2';
        } else {
            $options['status'] = '0';
            $options['end_time'] = '1';
        }

        $data = array();
        $data['setting_value'] = json_encode($options); // 压缩

        if ($_W['slwl']['set']['auth_settings']) {
            $where['uniacid'] = '0';
            $where['setting_name'] = 'auth_settings';
            $rst = pdo_update('slwl_aicard_settings', $data, $where);
        } else {
            $data['uniacid'] = '0';
            $data['setting_name'] = 'auth_settings';
            $data['addtime'] = $_W['slwl']['datetime']['now'];
            $rst = pdo_insert('slwl_aicard_settings', $data);
        }

        if ($result['code'] == '0') {
            if ($rst !== false) {
                iajax(0, '成功');
            } else {
                iajax(2, '失败');
            }
        } else {
            iajax(1, '失败-'.$result['msg']);
        }
    }


} elseif ($operation == 'post_tablepre') {

    if ($_W['ispost']) {
        $agreement = intval($_GPC['agreement']);

        if ($agreement != '1') {
            iajax(1, '请勾选协议');
        }

        $tablepre = $_W['config']['db']['tablepre'];

        $sql_data = "CREATE TABLE IF NOT EXISTS `{$tablepre}slwl_aicard_settings` (
                      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                      `uniacid` int(11) DEFAULT NULL,
                      `setting_name` varchar(100) DEFAULT '' COMMENT '配置名',
                      `setting_value` longtext COMMENT '配置值',
                      `addtime` datetime DEFAULT '2000-01-01 00:00:00' COMMENT '添加时间，程序插入',
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        $rst = pdo_run($sql_data); // 执行SQL语句
        if ($rst !== false) {
            iajax(0, '修复成功');
        } else {
            iajax(1, '修复失败');
        }
    }


} else {
    message('请求方法不存在');
}


include $this->template('web/auth');

?>