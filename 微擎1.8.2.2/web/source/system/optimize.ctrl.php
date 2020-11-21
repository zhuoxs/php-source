<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

load()->func('cache');

$dos = array('opcache');
$do = in_array($do, $dos) ? $do : 'index';
$_W['page']['title'] = '性能优化 - 常用系统工具 - 系统管理';

if ($do == 'opcache') {
	opcache_reset();
	itoast('清空缓存成功', url('system/optimize'), 'success');
} else {
	$cache_type = cache_type();
	$clear = array('url' => url('system/updatecache'), 'title' => '更新缓存');
	$extensions = array(
		'memcache' => array(
			'support' => extension_loaded('memcache'),
			'status' => $cache_type == 'memcache',
			'clear' => $clear
		),
		'redis' => array(
			'support' => extension_loaded('redis'),
			'status' => $cache_type == 'redis',
			'clear' => $clear
		),
		'eAccelerator' => array(
			'support' => function_exists('eaccelerator_optimizer'),
			'status' => function_exists('eaccelerator_optimizer'),
		),
		'opcache' => array(
			'support' => function_exists('opcache_get_configuration'),
			'status' => ini_get('opcache.enable') || ini_get('opcache.enable_cli'),
			'clear' => array(
				'url' => url('system/optimize/opcache'),
				'title' => '清空缓存',
			)
		)
	);
	$slave = $_W['config']['db'];
	$setting = $_W['config']['setting'];
	
	if ($extensions['memcache']['status']) {
		$memobj = cache_memcache();
		if (!empty($memobj) && method_exists($memobj, 'getExtendedStats')) {
						$status = $memobj->getExtendedStats();
			if (!empty($status)) {
				foreach ($status as $server => $row) {
					$data_status[] = '已用：' . round($row['bytes'] / 1048576, 2) . ' M / 共：' . round($row['limit_maxbytes'] / 1048576) . ' M';
				}
				$extensions['memcache']['extra'] = ', ' . implode(', ', $data_status);
			}
		}
	}
	if ($extensions['redis']['status']) {
		$redisobj = cache_redis();
		if (!empty($redisobj) && method_exists($redisobj, 'info')) {
						$status = $redisobj->info();
			if (!empty($status)) {
				$extensions['redis']['extra'] = '消耗峰值：' . round($status['used_memory_peak'] / 1048576, 2) . ' M/ 内存总量：' . round($status['used_memory'] / 1048576, 2) . ' M';
			}
		}
	}
	template('system/optimize');
}