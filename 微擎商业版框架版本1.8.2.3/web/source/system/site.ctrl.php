<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

	load()->model('system');

$dos = array('copyright');
$do = in_array($do, $dos) ? $do : 'copyright';
$_W['page']['title'] = '站点设置 - 工具  - 系统管理';
$settings = $_W['setting']['copyright'];

if(empty($settings) || !is_array($settings)) {
	$settings = array();
} else {
	$settings['slides'] = iunserializer($settings['slides']);
}

	$path = IA_ROOT . '/web/themes/';
	if(is_dir($path)) {
		if ($handle = opendir($path)) {
			while (false !== ($templatepath = readdir($handle))) {
				if ($templatepath != '.' && $templatepath != '..') {
					if(is_dir($path.$templatepath)){
						$template[] = $templatepath;
					}
				}
			}
		}
	}

if ($do == 'copyright') {
	
		$template_ch_name = system_template_ch_name();
	
	if (checksubmit('submit')) {
		
			header('X-XSS-Protection: 0');
			$data = array(
				'status' => intval($_GPC['status']),
				'verifycode' => $settings['verifycode'],
				'reason' => trim($_GPC['reason']),
				'sitename' => trim($_GPC['sitename']),
				'url' => (strexists($_GPC['url'], 'http://') || strexists($_GPC['url'], 'https://')) ? $_GPC['url'] : "http://{$_GPC['url']}",
				'statcode' => system_check_statcode($_GPC['statcode']),
				'footerleft' => safe_gpc_html(htmlspecialchars_decode($_GPC['footerleft'])),
				'footerright' => safe_gpc_html(htmlspecialchars_decode($_GPC['footerright'])),
				'icon' => trim($_GPC['icon']),
				'flogo' => trim($_GPC['flogo']),
				'background_img' => trim($_GPC['background_img']),
				'slides' => iserializer($_GPC['slides']),
				'notice' => trim($_GPC['notice']),
				'blogo' => trim($_GPC['blogo']),
				'baidumap' => $_GPC['baidumap'],
				'company' => trim($_GPC['company']),
				'companyprofile' => safe_gpc_html(htmlspecialchars_decode($_GPC['companyprofile'])),
				'address' => trim($_GPC['address']),
				'person' => trim($_GPC['person']),
				'phone' => trim($_GPC['phone']),
				'qq' => trim($_GPC['qq']),
				'email' => trim($_GPC['email']),
				'keywords' => trim($_GPC['keywords']),
				'description' => trim($_GPC['description']),
				'showhomepage' => intval($_GPC['showhomepage']),
				'leftmenufixed' => (!empty($_GPC['leftmenu_fixed'])) ? 1 : 0,
				'mobile_status' => $settings['mobile_status'],
				'login_type' => $settings['login_type'],
				'log_status' => intval($_GPC['log_status']),
				'develop_status' => intval($_GPC['develop_status']),
				'icp' => safe_gpc_string($_GPC['icp']),
				'sms_name'=>trim($_GPC['sms_name']),
                'sms_password'=>trim($_GPC['sms_password']),
                'sms_sign'=>trim($_GPC['sms_sign']),
				'bind' => $settings['bind'],
				'welcome_link' => $settings['welcome_link'],
				'oauth_bind' => $settings['oauth_bind'],
			);
		
		

		$test = setting_save($data, 'copyright');

		
			$template = trim($_GPC['template']);
			setting_save(array('template' => $template), 'basic');
		

		itoast('更新设置成功！', url('system/site'), 'success');
	}
}

template('system/site');