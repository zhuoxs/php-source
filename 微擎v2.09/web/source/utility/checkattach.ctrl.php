<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
set_time_limit(0);
if($do == 'ftp') {
	require(IA_ROOT . '/framework/library/ftp/ftp.php');
	$ftp_config = array(
		'hostname' => trim($_GPC['host']),
		'username' => trim($_GPC['username']),
		'password' => strexists($_GPC['password'], '*') ? $_W['setting']['remote']['ftp']['password'] : trim($_GPC['password']),
		'port' => intval($_GPC['port']),
		'ssl' => trim($_GPC['ssl']),
		'passive' => trim($_GPC['pasv']),
		'timeout' => intval($_GPC['overtime']),
		'rootdir' => trim($_GPC['dir']),
	);
	$url = trim($_GPC['url']);
	$filename = 'MicroEngine.ico';
	$ftp = new Ftp($ftp_config);
	if (true === $ftp->connect()) {
				if ($ftp->upload(ATTACHMENT_ROOT .'images/global/'. $filename, $filename)) {
			load()->func('communication');
			$response = ihttp_get($url. '/'. $filename);
			if (is_error($response)) {
				message(error(-1, '配置失败，FTP远程访问url错误'),'','ajax');
			}
			if (intval($response['code']) != 200) {
				message(error(-1, '配置失败，FTP远程访问url错误'),'','ajax');
			}
			$image = getimagesizefromstring($response['content']);
			if (!empty($image) && strexists($image['mime'], 'image')) {
				message(error(0,'配置成功'),'','ajax');
			} else {
				message(error(-1, '配置失败，FTP远程访问url错误'),'','ajax');
			}
		} else {
			message(error(-1, '配置失败，FTP远程访问url错误'),'','ajax');
		}
	} else {
		message(error(-1, 'FTP服务器连接失败，请检查配置'),'','ajax');
	}
}
if ($do == 'oss') {
	load()->model('attachment');
	$key = $_GPC['key'];
	$secret = strexists($_GPC['secret'], '*') ? $_W['setting']['remote']['alioss']['secret'] : $_GPC['secret'];
	$bucket = $_GPC['bucket'];
	$buckets = attachment_alioss_buctkets($key, $secret);
	list($bucket, $url) = explode('@@', $_GPC['bucket']);
	$result = attachment_newalioss_auth($key, $secret, $bucket,$url);
	if (is_error($result)) {
		message(error(-1, 'OSS-Access Key ID 或 OSS-Access Key Secret错误，请重新填写'),'','ajax');
	}
	$ossurl = $buckets[$bucket]['location'].'.aliyuncs.com';
	if (!empty($_GPC['url'])) {
		if (!strexists($_GPC['url'], 'http://') && !strexists($_GPC['url'],'https://')) {
			$url = 'http://'. trim($_GPC['url']);
		} else {
			$url = trim($_GPC['url']);
		}
		$url = trim($url, '/').'/';
	} else {
		$url = 'http://'.$bucket.'.'.$buckets[$bucket]['location'].'.aliyuncs.com/';
	}
	load()->func('communication');
	$filename = 'MicroEngine.ico';
	$response = ihttp_request($url. '/'.$filename, array(), array('CURLOPT_REFERER' => $_SERVER['SERVER_NAME']));
	if (is_error($response)) {
		message(error(-1, '配置失败，阿里云访问url错误'),'','ajax');
	}
	if (intval($response['code']) != 200) {
		message(error(-1, '配置失败，阿里云访问url错误,请保证bucket为公共读取的'),'','ajax');
	}
	$image = getimagesizefromstring($response['content']);
	if (!empty($image) && strexists($image['mime'], 'image')) {
		message(error(0,'配置成功'),'','ajax');
	} else {
		message(error(-1, '配置失败，阿里云访问url错误'),'','ajax');
	}
}
if ($do == 'qiniu') {
	load()->model('attachment');
	$_GPC['secretkey'] = strexists($_GPC['secretkey'], '*') ? $_W['setting']['remote']['qiniu']['secretkey'] : $_GPC['secretkey'];
	$auth= attachment_qiniu_auth(trim($_GPC['accesskey']), trim($_GPC['secretkey']), trim($_GPC['bucket']));
	if (is_error($auth)) {
		message(error(-1, '配置失败，请检查配置。注：请检查存储区域是否选择的是和bucket对应<br/>的区域'), '', 'ajax');
	}
	load()->func('communication');
	$url = $_GPC['url'];
	$url = strexists($url, 'http') ? trim($url, '/') : 'http://'.trim($url, '/');
	$filename = 'MicroEngine.ico';
	$response = ihttp_request($url. '/'.$filename, array(), array('CURLOPT_REFERER' => $_SERVER['SERVER_NAME']));
	if (is_error($response)) {
		message(error(-1, '配置失败，七牛访问url错误'),'','ajax');
	}
	if (intval($response['code']) != 200) {
		message(error(-1, '配置失败，七牛访问url错误,请保证bucket为公共读取的'),'','ajax');
	}
	$image = getimagesizefromstring($response['content']);
	if (!empty($image) && strexists($image['mime'], 'image')) {
		message(error(0,'配置成功'),'','ajax');
	} else {
		message(error(-1, '配置失败，七牛访问url错误'),'','ajax');
	}
}
if ($do == 'cos') {
	load()->model('attachment');
	$url = $_GPC['url'];
	if (empty($url)) {
		$url = 'http://'.$_GPC['bucket'].'-'. $_GPC['appid'].'.cos.myqcloud.com';
	}
	$bucket =  trim($_GPC['bucket']);
	$_GPC['secretkey'] = strexists($_GPC['secretkey'], '*') ? $_W['setting']['remote']['cos']['secretkey'] : $_GPC['secretkey'];
	if (!strexists($url, '//'.$bucket.'-') && strexists($url, '.cos.myqcloud.com')) {
		$url = 'http://'.$bucket.'-'.trim($_GPC['appid']).'.cos.myqcloud.com';
	}
	$auth= attachment_cos_auth(trim($_GPC['bucket']), trim($_GPC['appid']), trim($_GPC['secretid']), trim($_GPC['secretkey']), $_GPC['local']);

	if (is_error($auth)) {
		message(error(-1, $auth['message']), '', 'ajax');
	}
	load()->func('communication');
	$url = strexists($url, 'http') ? trim($url, '/') : 'http://'.trim($url, '/');
	$filename = 'MicroEngine.ico';
	$response = ihttp_request($url. '/'.$filename, array(), array('CURLOPT_REFERER' => $_SERVER['SERVER_NAME']));
	if (is_error($response)) {
		message(error(-1, '配置失败，腾讯cos访问url错误'),'','ajax');
	}
	if (intval($response['code']) != 200) {
		message(error(-1, '配置失败，腾讯cos访问url错误,请保证bucket为公共读取的'),'','ajax');
	}
	$image = getimagesizefromstring($response['content']);
	if (!empty($image) && strexists($image['mime'], 'image')) {
		message(error(0,'配置成功'),'','ajax');
	} else {
		message(error(-1, '配置失败，腾讯cos访问url错误'),'','ajax');
	}
}