<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('payment');
load()->model('account');

$dos = array('save_setting', 'display');
$do = in_array($do, $dos) ? $do : 'display';
permission_check_account_user('profile_setting');
$_W['page']['title'] = '退款参数 - 公众号选项';

if ($do == 'display') {
	$setting = uni_setting_load('payment', $_W['uniacid']);
	$setting = (array)$setting['payment'];
	if (empty($setting['wechat_refund'])) {
		$setting['wechat_refund'] = array('switch' => 0, 'key' => '', 'cert' => '');
	}
	if (empty($setting['ali_refund'])) {
		$setting['ali_refund'] = array('switch' => 0, 'private_key' => '');
	}
}

if ($do == 'save_setting') {
	$type = $_GPC['type'];
	$param = $_GPC['param'];
	$setting = uni_setting_load('payment', $_W['uniacid']);
	$pay_setting = (array)$setting['payment'];
	if ($type == 'wechat_refund') {
		if (empty($_FILES['cert']['tmp_name'])) {
			if (empty($setting['payment']['wechat_refund']['cert']) && $param['switch'] == 1) {
				itoast('请上传apiclient_cert.pem证书', '', 'info');
			}
			$param['cert'] = $setting['payment']['wechat_refund']['cert'];
		} else {
			$param['cert'] = file_get_contents($_FILES['cert']['tmp_name']);
			if (strexists($param['cert'], '<?php') || substr($param['cert'], 0, 27) != '-----BEGIN CERTIFICATE-----' || substr($param['cert'], -24, 23) != '---END CERTIFICATE-----') {
				itoast('apiclient_cert.pem证书内容不合法，请重新上传');
			}
			$param['cert'] = authcode($param['cert'], 'ENCODE');
		}
		if (empty($_FILES['key']['tmp_name'])) {
			if (empty($setting['payment']['wechat_refund']['key']) && $param['switch'] == 1) {
				itoast ('请上传apiclient_key.pem证书', '', 'info');
			}
			$param['key'] = $setting['payment']['wechat_refund']['key'];
		} else {
			$param['key'] = file_get_contents($_FILES['key']['tmp_name']);
			if (strexists($param['key'], '<?php') || substr($param['key'], 0, 27) != '-----BEGIN PRIVATE KEY-----' || substr($param['key'], -24, 23) != '---END PRIVATE KEY-----') {
				itoast('apiclient_key.pem证书内容不合法，请重新上传');
			}
			$param['key'] = authcode($param['key'], 'ENCODE');
		}
	} elseif ($type == 'ali_refund') {
		if (empty($_FILES['private_key']['tmp_name'])) {
			if (empty($setting['payment']['ali_refund']['private_key']) && $param['switch'] == 1) {
				itoast('请上传rsa_private_key.pem证书', '', 'info');
			}
			$param['private_key'] = $setting['payment']['ali_refund']['private_key'];
		} else {
			$param['private_key'] = file_get_contents($_FILES['private_key']['tmp_name']);
			if (strexists($param['private_key'], '<?php') || substr($param['private_key'], 0, 27) != '-----BEGIN RSA PRIVATE KEY-' || substr($param['private_key'], -24, 23) != 'ND RSA PRIVATE KEY-----') {
				itoast('rsa_private_key.pem证书内容不合法，请重新上传');
			}
			$param['private_key'] = authcode($param['private_key'], 'ENCODE');
		}
	}
	$pay_setting[$type] = $param;
	uni_setting_save('payment', $pay_setting);
	itoast('设置成功', '', 'success');
}

template('profile/refund');