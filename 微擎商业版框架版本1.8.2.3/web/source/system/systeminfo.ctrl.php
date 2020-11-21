<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('system');

$dos = array('display', 'get_attach_size');
$do = in_array($do, $dos) ? $do : 'display';

if ($do == 'display') {
	$_W['page']['title'] = '系统信息 - 工具  - 系统管理';
	$info = array(
		'os' => php_uname(),
		'php' => phpversion(),
		'sapi' => $_SERVER['SERVER_SOFTWARE'] ? $_SERVER['SERVER_SOFTWARE'] : php_sapi_name(),
	);

		$size = 0;
	$size = @ini_get('upload_max_filesize');
	if ($size) {
		$size = bytecount($size);
	}
	if ($size > 0) {
		$ts = @ini_get('post_max_size');
		if ($ts) {
			$ts = bytecount($size);
		}
		if ($ts > 0) {
			$size = min($size, $ts);
		}
		$ts = @ini_get('memory_limit');
		if ($ts) {
			$ts = bytecount($size);
		}
		if ($ts > 0) {
			$size = min($size, $ts);
		}
	}
	if (empty($size)) {
		$size = '';
	} else {
		$size = sizecount($size);
	}
	$info['limit'] = $size;

		$sql = 'SELECT VERSION();';
	$info['mysql']['version'] = pdo_fetchcolumn($sql);

		$tables = pdo_fetchall("SHOW TABLE STATUS LIKE '".$_W['config']['db']['tablepre']."%'");
	$size = 0;
	foreach ($tables as &$table) {
		$size += $table['Data_length'] + $table['Index_length'];
	}
	if (empty($size)) {
		$size = '';
	} else {
		$size = sizecount($size);
	}
		$info['mysql']['size'] = $size;
		$info['attach']['url'] = $_W['attachurl'];

	template('system/systeminfo');
}

if ($do == 'get_attach_size') {
		$path = IA_ROOT . '/' . $_W['config']['upload']['attachdir'];
	$size = dir_size($path);
	if (empty($size)) {
		$size = '';
	} else {
		$size = sizecount($size);
	}
	iajax(0, array('attach_size' => $size));
}
