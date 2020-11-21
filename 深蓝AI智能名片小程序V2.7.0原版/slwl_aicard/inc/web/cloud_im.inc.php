<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W, $_SL;
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$domain = trim(preg_replace('/http(s)?:\\/\\//', '', rtrim($_W['siteroot'], '/')));
$ip = gethostbyname($_SERVER['HTTP_HOST']);

if ($operation == 'display') {
    $condition = ' AND uniacid=:uniacid AND setting_name=:setting_name ';
    $params = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'set_cloud_im_settings');
    $set = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition, $params);

    if ($_W['ispost']) {
        $options = $_GPC['options'];

        $condition_auth = " AND uniacid=:uniacid AND setting_name=:setting_name ";
        $params_auth = array(':uniacid' => '0', ':setting_name'=>'auth_settings');
        $set_auth = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition_auth, $params_auth);

        if (!(empty($set_auth))) {
            $settings_auth = json_decode($set_auth['setting_value'], true);

            $condition_auth_qywx = ' AND uniacid=:uniacid AND setting_name=:setting_name ';
            $params_auth_qywx = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'set_auth_qywx_settings');
            $set_auth_qywx = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition_auth_qywx, $params_auth_qywx);

            if (!(empty($set_auth_qywx))) {
                $settings_auth_qywx = json_decode($set_auth_qywx['setting_value'], true);

                $param = array();
                $param['corp_id'] = $settings_auth_qywx['corpid'];
                $param['app_id'] = $_W['uniacid'];
                $param['im_app_id'] = $options['sdkappid'];
                $param['account_type'] = $options['accounttype'];
                $param['im_admin'] = $options['adminaccount'];
                $param['private_key'] = $options['privatekey'];
                $param['public_key'] = $options['publickey'];

                $resp = ihttp_request(SLWL_API_URL . 'Radar/Msg/im_config', $param);
                $result = @json_decode($resp['content'], true);

                @putlog('云通信IM授权授权配置', $result);

                if ($result['IsSuccess']) {
                    $options['status'] = '1';
                } else {
                    $options['status'] = '0';
                }

                if ($result['IsSuccess']) {
                    $data = array();
                    $data['uniacid'] = $_W['uniacid'];
                    $data['setting_name'] = 'set_cloud_im_settings';
                    $data['setting_value'] = json_encode($options);

                    if (!empty($set)) {
                        pdo_update('slwl_aicard_settings', $data, array('id' => $set['id']));
                    } else {
                        $data['addtime'] = date('Y-m-d H:i:s', time());
                        pdo_insert('slwl_aicard_settings', $data);
                    }
                    iajax(0, '保存成功！');
                    exit;
                } else {
                    iajax(1, '保存失败-'.$result['ErrMsg']);
                    exit;
                }
            } else {
                iajax(1, '企业微信还没有授权');
            }
        } else {
            iajax(1, '系统还没有授权');
        }
    }

    if (!(empty($set))) {
        $settings = json_decode($set['setting_value'], true);
    }


} elseif ($operation == 'post') {
    $uniacid = $_W['uniacid'];
    $condition = ' and uniacid=:uniacid and setting_name=:setting_name';
    $params = array(':uniacid' => $uniacid, ':setting_name'=>'set_wx_tmplates_settings');
    $set_tmp_wx = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition . ' limit 1', $params);

    if ($_W['ispost']) {
        $options = $_GPC['options'];

        $data = array();
        $data['uniacid'] = $uniacid;
        $data['setting_name'] = 'set_wx_tmplates_settings';
        $data['setting_value'] = json_encode($options);

        if (!empty($set_tmp_wx)) {
            pdo_update('slwl_aicard_settings', $data, array('id' => $set_tmp_wx['id']));
        } else {
            $data['addtime'] = date('Y-m-d H:i:s', time());
            pdo_insert('slwl_aicard_settings', $data);
        }

        if ($options['wx_template_msg_show'] == '1') {
            $res = @send_wx_template_add();
        } else {
            $res = @send_wx_template_delete();
        }

        iajax(0, '保存成功！');
        exit;
    }

    if (!(empty($set_tmp_wx))) {
        $tmp_wx = json_decode($set_tmp_wx['setting_value'], true);
    }


} else {
    message('请求方式不存在');
}

include $this->template('web/cloud-im');

?>