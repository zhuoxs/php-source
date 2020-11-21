<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

$account = uni_fetch($_W['uniacid']);
$app_id = $account['key'];
// $secret = $account['secret'];
unset($account);

if ($operation == 'display') {
    $condition = " AND uniacid=:uniacid AND enabled='1' ";
    $params = array(':uniacid' => $_W['uniacid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $sql = "SELECT id, displayorder FROM " . tablename('slwl_aicard_mod_wxapp'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    $mod_count = count($list);


} elseif ($operation == 'post') {
    if ($_W['ispost']) {

        // 查出所有跳转小程序appid
        $condition = " AND uniacid=:uniacid AND enabled='1' ";
        $params = array(':uniacid' => $_W['uniacid']);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $sql = "SELECT * FROM " . tablename('slwl_aicard_mod_wxapp'). ' WHERE 1 '
            . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

        $list = pdo_fetchall($sql, $params);
        // $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_mod_wxapp') . ' WHERE 1 ' . $condition, $params);
        // $pager = pagination($total, $pindex, $psize);

        $app_id_list = array();
        foreach ($list as $k => $v) {
            $app_id_list[] = $v['appid'];
        }

        $domain_https = substr($_GPC['siteroot'], 0, 5);
        if ($domain_https != 'https') {
            iajax(1, '域名必需为https');
        }
        $set_array = array();

        // if ($_W['slwl']['set']['auth_settings']) {
        //     $set_array = $_W['slwl']['set']['auth_settings'];
        // }

        $param = array();
        $param['app_id'] = $_GPC['app_id'];
        $param['plugin'] = $_GPC['plugin'];
        $param['ver'] = $_GPC['ver'];
        $param['version'] = $_GPC['version'];
        $param['desc'] = $_GPC['desc'];
        $param['uniacid'] = $_GPC['uniacid'];
        $param['siteroot'] = $_GPC['siteroot'];
        $param['app_id_list'] = $app_id_list;

        $param['host'] = 'test.tailea.com';
        $param['code'] = '888888';
        $param['family'] = '2';

        $resp = ihttp_request(SLWL_AUTH_URL . 'Index/sl_upload_wxapp', $param);
        $result = @json_decode($resp['content'], true);

         dump($resp);
       var_dump($result);exit;

        if ($result['code'] == '0') {
            iajax(0, $result);
        } else {
            iajax(1, $result['msg']);
        }
    }
    exit;


} elseif ($operation == 'check_up') {
    if ($_W['ispost']) {
        $domain_https = substr($_GPC['siteroot'], 0, 5);
        if ($domain_https != 'https') {
            iajax(1, '域名必需为https');
        }
        $set_array = array();
        if ($_W['slwl']['set']['auth_settings']) {
            $set_array = $_W['slwl']['set']['auth_settings'];
        }

        $param = array();
        $param['app_id'] = $_GPC['app_id'];
        $param['plugin'] = $_GPC['plugin'];
        $param['ver'] = $_GPC['ver'];
        $param['version'] = $_GPC['version'];
        $param['desc'] = $_GPC['desc'];
        $param['uniacid'] = $_GPC['uniacid'];
        $param['siteroot'] = $_GPC['siteroot'];

        $param['host'] = 'test.tailea.com';
        $param['code'] = '888888';
        $param['family'] = '2';

        $resp = ihttp_request(SLWL_AUTH_URL . 'Index/wxapp_check_up', $param);
        $result = @json_decode($resp['content'], true);

        // dump($resp);
        // var_dump($result);exit;

        if ($result['code'] == '0') {
            iajax(0, $result);
        } else if ($result['code'] == '1') {
            iajax(1, $result['msg']);
        } else {
            iajax($result['code'], $result['msg']);
        }
    }
    exit;


} elseif ($operation == 'check_preview') {
    if ($_W['ispost']) {
        $domain_https = substr($_GPC['siteroot'], 0, 5);
        if ($domain_https != 'https') {
            iajax(1, '域名必需为https');
        }
        $set_array = array();
        // if ($_W['slwl']['set']['auth_settings']) {
        //     $set_array = $_W['slwl']['set']['auth_settings'];
        // }

        $param = array();
        $param['app_id'] = $_GPC['app_id'];
        $param['plugin'] = $_GPC['plugin'];
        $param['ver'] = $_GPC['ver'];
        $param['version'] = $_GPC['version'];
        $param['desc'] = $_GPC['desc'];
        $param['uniacid'] = $_GPC['uniacid'];
        $param['siteroot'] = $_GPC['siteroot'];

        $param['host'] = 'test.tailea.com';
        $param['code'] = '888888';
        $param['family'] = '2';

        $resp = ihttp_request(SLWL_AUTH_URL . 'Index/wxapp_check_preview', $param);
        $result = @json_decode($resp['content'], true);

        // dump($resp);
        // var_dump($result);exit;

        if ($result['code'] == '0') {
            iajax(0, $result);
        } else {
            iajax(1, $result['msg']);
        }
    }


} else {
    message('请求方法不存在');
}

include $this->template('web/upwxapp');

?>