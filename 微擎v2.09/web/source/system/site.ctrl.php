<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('system');

$dos = array('basic', 'copyright', 'about', 'save_setting');
$do = in_array($do, $dos) ? $do : 'basic';
$settings = $_W['setting']['copyright'];
if(empty($settings) || !is_array($settings)) {
	$settings = array();
} else {
	$settings['slides'] = iunserializer($settings['slides']);
}

if ($do == 'basic') {
	
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

		$template_ch_name = system_template_ch_name();
		$templates_ch = array_keys($template_ch_name);
		if (!empty($template)) {
			foreach ($template as $template_val) {
				if (!in_array($template_val, $templates_ch)) {
					$template_ch_name[$template_val] = $template_val;
				}
			}
		}
	
}

if ($do == 'save_setting') {
	$system_setting_items = system_setting_items();
	$key = safe_gpc_string($_GPC['key']);

	switch ($key) {
		case 'statcode':
			$settings[$key] = system_check_statcode($_GPC['value']);
			break;
		case 'url':
			$settings[$key] = (strexists($_GPC['value'], 'http://') || strexists($_GPC['value'], 'https://')) ? $_GPC['value'] : "http://{$_GPC['value']}";
			break;
		case 'footerleft':
			$settings[$key] = safe_gpc_html(htmlspecialchars_decode($_GPC['value']));
			break;
		case 'footerright':
			$settings[$key] = safe_gpc_html(htmlspecialchars_decode($_GPC['value']));
			break;
		case 'slides':
			$settings[$key] = iserializer($_GPC['value']);
			break;
		case 'companyprofile':
			$settings[$key] = safe_gpc_html(htmlspecialchars_decode($_GPC['value']));
			break;
		case 'template':
			break;
		case 'baidumap':
			break;
		default:
			$settings[$key] = $_GPC['is_int'] == 1 ? intval($_GPC['value']) : safe_gpc_string($_GPC['value']);
			break;
	}

	if (!in_array($key, $system_setting_items)) {
		iajax(-1, '参数错误！', url('system/site'));
	}

	if ($key == 'template') {
		setting_save(array('template' => safe_gpc_string($_GPC['value'])), 'basic');
	} else if($key = 'baidumap') {
		$settings['baidumap'] = array('lng' => $_GPC['lng'], 'lat' => $_GPC['lat']);
		setting_save($settings, 'copyright');
	} else {
		setting_save($settings, 'copyright');
	}

	iajax(0, '更新设置成功！', referer());
}

template('system/site');