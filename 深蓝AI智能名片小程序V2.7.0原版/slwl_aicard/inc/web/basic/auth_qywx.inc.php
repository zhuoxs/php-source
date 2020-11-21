<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = $_GPC['op'] ? $_GPC['op'] : 'display';

$domain = trim(preg_replace('/http(s)?:\\/\\//', '', rtrim($_W['siteroot'], '/')));
$ip = gethostbyname($_SERVER['HTTP_HOST']);

if ($operation == 'display') {

	if ($_W['ispost']) {
		$options = $_GPC['options'];

		if ($_W['slwl']['set']['auth_settings']) {
			$settings_auth = $_W['slwl']['set']['auth_settings'];

			$sys_id = $_W['uniacid'];
			$param = array();
			$param['host'] = $settings_auth['domain'];
			$param['ip'] = $settings_auth['ip'];
			$param['app_id'] = $sys_id;
			$param['sys_auth_code'] = $settings_auth['code'];
			$param['corp_id'] = $options['corpid'];
			$param['agent_id'] = $options['agentid'];

			$resp = ihttp_request(SLWL_API_URL . 'Radar/Index/save_corp_auth', $param);
			$result = @json_decode($resp['content'], true);

			@putlog('企业微信授权配置', $result);

			if ($result['IsSuccess']) {
				$options['status'] = '1';
			} else {
				$options['status'] = '0';
			}

			if ($result['IsSuccess']) {
				$data = array();
				$data['setting_value'] = json_encode($options); // 压缩

				if ($_W['slwl']['set']['set_auth_qywx_settings']) {
					$where['uniacid'] = $_W['uniacid'];
					$where['setting_name'] = 'set_auth_qywx_settings';
					pdo_update(sl_table_name('settings'), $data, $where);
				} else {
					$data['uniacid'] = $_W['uniacid'];
					$data['setting_name'] = 'set_auth_qywx_settings';
					$data['addtime'] = $_W['slwl']['datetime']['now'];
					pdo_insert(sl_table_name('settings'), $data);
				}

				sl_ajax(0, '保存成功！');
			} else {
				sl_ajax(1, '保存失败-'.$result['ErrMsg']);
			}
		} else {
			sl_ajax(1, '系统还没有授权');
		}
	}

	if ($_W['slwl']['set']['set_auth_qywx_settings']) {
		$settings = $_W['slwl']['set']['set_auth_qywx_settings'];
	}


} else if ($operation == 'post_abook') {
	if ($_W['ispost']) {

		if (empty($_W['slwl']['set']['set_auth_qywx_settings'])) {
			sl_ajax(1, '请先配置企业微信配置');
		}

		$settings_qywx = $_W['slwl']['set']['set_auth_qywx_settings'];

		$sys_id = $_W['uniacid'];
		$param = array();
		$param['host'] = $settings_qywx['domain'];
		$param['ip'] = $settings_qywx['ip'];
		$param['app_id'] = $sys_id;
		$param['sys_auth_code'] = $settings_qywx['code'];
		$param['corp_id'] = $settings_qywx['corpid'];
		$param['agent_id'] = $settings_qywx['agentid'];

		$resp = ihttp_request(SLWL_API_URL . 'Ipa/Index/corp_auth_app', $param);
		$result = @json_decode($resp['content'], true);

		if ($result['IsSuccess']) {
			sl_ajax(0, $result['Data']);
		} else {
			sl_ajax(1, $result['ErrMsg']);
		}
	}


} else if ($operation == 'post_abook_post') {
	if ($_W['ispost']) {

		if (empty($_W['slwl']['set']['set_auth_qywx_settings'])) {
			sl_ajax(1, '请先配置企业微信配置');
			exit;
		}

		$settings_qywx = $_W['slwl']['set']['set_auth_qywx_settings'];

		$param = array();
		$param['corp_id'] = $settings_qywx['corpid'];

		$resp = ihttp_request(SLWL_API_URL . 'Ipa/Index/save_corp_auth', $param);
		$result = @json_decode($resp['content'], true);

		if ($result['IsSuccess']) {
			$condition_ipa = " AND uniacid=:uniacid AND setting_name=:setting_name ";
			$params_ipa = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'ipa_settings');
			$set_ipa = pdo_fetch("SELECT * FROM " . sl_table_name('settings',true)
				. ' WHERE 1 ' . $condition_ipa, $params_ipa);


			$options['status'] = '1';
			$data = array();
			$data['setting_value'] = json_encode($options); // 压缩

			if ($_W['slwl']['set']['ipa_settings']) {
				$where = array();
				$where['uniacid'] = $_W['uniacid'];
				$where['setting_name'] = 'ipa_settings';
				pdo_update(sl_table_name('settings'), $data, $where);
			} else {
				$data['uniacid'] = $_W['uniacid'];
				$data['setting_name'] = 'ipa_settings';
				$data['addtime'] = $_W['slwl']['datetime']['now'];
				pdo_insert(sl_table_name('settings'), $data);
			}

			sl_ajax(0, '保存成功');
		} else {
			sl_ajax(1, '保存失败-'.$result['ErrMsg']);
		}
	}


} else if ($operation == 'post') {

	if ($_W['ispost']) {
		$options = $_GPC['options'];

		$agreement_1 = intval($_GPC['agreement_1']);

		if ($agreement_1 == '1') {
			pdo_delete(sl_table_name('tipswx'), ['uniacid'=>$_W['uniacid']]);
		}

		$data = array();
		$data['setting_value'] = json_encode($options); // 压缩

		if ($_W['slwl']['set']['set_wx_tmplates_settings']) {
			$where['uniacid'] = $_W['uniacid'];
			$where['setting_name'] = 'set_wx_tmplates_settings';
			pdo_update(sl_table_name('settings'), $data, $where);
		} else {
			$data['uniacid'] = $_W['uniacid'];
			$data['setting_name'] = 'set_wx_tmplates_settings';
			$data['addtime'] = $_W['slwl']['datetime']['now'];
			pdo_insert(sl_table_name('settings'), $data);
		}

		if ($options['wx_template_msg_show'] == '1') {
			$rst = send_wx_template_add();
		} else {
			$rst = send_wx_template_delete();
		}

		if ($rst && $rst['code']==0) {
			sl_ajax(0, '成功');
		} else {
			sl_ajax(1, '失败-'.$rst['msg']);
		}
	}

	if ($_W['slwl']['set']['set_wx_tmplates_settings']) {
		$tmp_wx = $_W['slwl']['set']['set_wx_tmplates_settings'];
	}


} else {
	message('请求方式不存在');
}

include $this->template('web/basic/auth-qywx');

