<?php 
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
$_W['page']['title'] = '工具 - 系统管理';
$dos = array('bom', 'scan');
$do = in_array($do, $dos) ? $do : 'bom';

if($do == 'bom') {
	if(checksubmit('submit')) {
		set_time_limit(0);
		load()->func('file');
		$path = IA_ROOT;
		$trees = file_tree($path);
		$bomtree = array();
		foreach($trees as $tree) {
			$tree = str_replace($path, '', $tree);
			$tree = str_replace('\\', '/', $tree);
			if(strexists($tree, '.php')) {
				$fname = $path . $tree;
				$fp = fopen($fname, 'r');
				if(!empty($fp)) {
					$bom = fread($fp, 3);
					fclose($fp);
					if($bom == "\xEF\xBB\xBF") {
						$bomtree[] = $tree;
					}
				}
			}
		}
		cache_write('bomtree', $bomtree);
	}
	if (checksubmit('dispose')) {
		$trees = cache_load('bomtree');
		$path = IA_ROOT;
		foreach($trees as $tree) {
			$fname = $path . $tree;
			$string = file_get_contents($fname);
			$string = substr($string, 3);
			file_put_contents($fname, $string);
			fclose($fp);
		}
		cache_delete('bomtree');
	}
	template('system/bom');
}

if($do == 'scan') {
	$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'post';
	if($op == 'post') {
		$config = iunserializer(cache_read('scan:config'));
		$list = glob(IA_ROOT.'/*', GLOB_NOSORT);
		$ignore = array();
		foreach($list as $key => $li) {
			if(in_array(basename($li), $ignore)) {
				unset($list[$key]);
			}
		}

		$safe = array (
			'file_type' => 'php|js',
			'code' => 'weidongli|sinaapp|safedog',
			'func' => 'com|system|exec|eval|escapeshell|cmd|passthru|base64_decode|gzuncompress',
			'dir' => '',
		);

		if(checksubmit('submit')) {
			if(empty($_GPC['dir'])) {
				message('请选择要扫描的目录', referer(), 'success');
			}
			foreach($_GPC['dir'] as $k => $v) {
				if(in_array(basename($v), $ignore)) {
					unset($_GPC['dir'][$k]);
				}
			}
						$info['file_type'] = 'php|js';
			$info['func'] = trim($_GPC['func']) ? trim($_GPC['func']) : 'com|system|exec|eval|escapeshell|cmd|passthru|base64_decode|gzuncompress';
			$info['code'] = trim($_GPC['code']) ? trim($_GPC['code']) : 'weidongli|sinaapp';
			$info['md5_file'] = trim($_GPC['md5_file']);
			$info['dir'] = $_GPC['dir'];
			cache_delete('scan:config');
			cache_delete('scan:file');
			cache_delete('scan:badfile');
			cache_write('scan:config', iserializer($info));
			message("配置保存完成，开始文件统计。。。", url('system/tools/scan', array('op' => 'count')), 'success');
		}
	}

	if($op == 'count') {
		load()->func('file');
		set_time_limit(0);
		$files = array();
		$config = iunserializer(cache_read('scan:config'));
		if(empty($config)) {
			message('获取扫描配置失败', url('system/tools/scan'), 'error');
		}
		$config['file_type'] = explode('|', $config['file_type']);
		$list_arr = array();
		foreach($config['dir'] as $v) {
			if(is_dir($v)) {
				if(!empty($config['file_type'])) {
					foreach ($config['file_type'] as $k) {
						$list_arr = array_merge($list_arr, file_lists($v . '/', 1, $k, 0, 1, 1));
					}
				}
			} else {
				$list_arr = array_merge($list_arr, array(str_replace(IA_ROOT . '/', '', $v) => md5_file($v)));
			}
		}
		unset($list_arr['data/config.php']);
		$list_arr = iserializer($list_arr);
		cache_write('scan:file', $list_arr);
		message("文件统计完成，进行特征函数过滤。。。", url('system/tools/scan', array('op' => 'filter_func')), 'success');
	}

	if($op == 'filter_func') {
		@set_time_limit(0);
		$config = iunserializer(cache_read('scan:config'));
		$file = iunserializer(cache_read('scan:file'));
		if (isset($config['func']) && !empty($config['func'])) {
			foreach ($file as $key => $val) {
				$html = file_get_contents(IA_ROOT . '/' . $key);
				if(stristr($key, '.php.') != false || preg_match_all('/[^a-z]?('.$config['func'].')\s*\(/i', $html, $state, PREG_SET_ORDER)) {
					$badfiles[$key]['func'] = $state;
				}
			}
		}
		if(!isset($badfiles)) $badfiles = array();
		cache_write('scan:badfile', iserializer($badfiles));
		message("特征函数过滤完成，进行特征代码过滤。。。", url('system/tools/scan', array('op' => 'filter_code')), 'success');
	}
	if($op == 'filter_code') {
		@set_time_limit(0);
		$config = iunserializer(cache_read('scan:config'));
		$file = iunserializer(cache_read('scan:file'));
		$badfiles = unserialize(cache_read('scan:badfile'));
		if (isset($config['code']) && !empty($config['code'])) {
			foreach ($file as $key => $val) {
				if(!empty($config['code'])) {
					$html = file_get_contents(IA_ROOT . '/' . $key);
					if(stristr($key, '.php.') != false || preg_match_all('/[^a-z]?('.$config['code'].')/i', $html, $state, PREG_SET_ORDER)) {
						$badfiles[$key]['code'] = $state;
					}
				}
				if(strtolower(substr($key, -4)) == '.php' && function_exists('zend_loader_file_encoded') && zend_loader_file_encoded(IA_ROOT . '/' . $key)) {
					$badfiles[$key]['zend'] = 'zend encoded';
				}
				$html = '';
			}
		}
		cache_write('scan:badfile', iserializer($badfiles));
		message("特征代码过滤完成，进行加密文件过滤。。。", url('system/tools/scan', array('op' => 'encode')), 'success');
	}

	if($op == 'encode') {
		@set_time_limit(0);
		$file = iunserializer(cache_read('scan:file'));
		$badfiles = iunserializer(cache_read('scan:badfile'));

		foreach ($file as $key => $val) {
			if(strtolower(substr($key, -4)) == '.php') {
				$html = file_get_contents(IA_ROOT . '/' . $key);
				$token = token_get_all($html);
				$html = '';
				foreach($token as $to) {
					if(is_array($to) && $to[0] == T_VARIABLE) {
						$pre = preg_match("/([".chr(0xb0)."-".chr(0xf7)."])+/", $to[1]);
						if(!empty($pre)) {
							$badfiles[$key]['danger'] = 'danger';
							break;
						}
					}
				}
			}
		}
		cache_write('scan:badfile', iserializer($badfiles));
		message("扫描完成。。。", url('system/tools/scan', array('op' => 'display')), 'success');
	}

	if($op == 'display') {
		$badfiles = iunserializer(cache_read('scan:badfile'));
		if(empty($badfiles)) {
			message('没有找到扫描结果，请重新扫描',  url('system/tools/scan'), 'error');
		}
		unset($badfiles['data/config.php']);
		foreach($badfiles as $k => &$v) {
			$v['func_count'] = 0;
			if(isset($v['func'])) {
				$v['func_count'] = count($v['func']);
				foreach ($v['func'] as $k1 => $v1) {
					$d[$k1] = strtolower($v1[1]);
				}
				$d = array_unique($d);
				$v['func_str'] = implode(', ', $d);
			}
			$v['code_count'] = 0;
			if(isset($v['code'])) {
				$v['code_count'] = count($v['code']);
				foreach ($v['code'] as $k2 => $v2) {
					$d1[$k2] = strtolower($v2[1]);
				}
				$d1 = array_unique($d1);
				$v['code_str'] = implode(', ', $d1);
			}
		}
	}

	if($op == 'view') {
		$file = authcode(trim($_GPC['file'], 'DECODE'));
		$file_tmp = $file;
		if(empty($file) || strexists($file, './') || strexists($file, '../') || $file == 'data/config.php') {
			message('文件不存在', referer(), 'error');
		}
				$file_arr = explode('/', $file);
		$ignore = array('payment');

		if(is_array($file_arr) && in_array($file_arr[0], $ignore)) {
			message('系统不允许查看当前文件', referer(), 'error');
		}
		$file = IA_ROOT . '/' . $file;
		if(!is_file($file)) {
			message('文件不存在', referer(), 'error');
		}
		$badfiles = iunserializer(cache_read('scan:badfile'));
		$info = $badfiles[$file_tmp];
		unset($badfiles);

		if(!empty($info)) {
			$info['func_count'] = 0;
			if(isset($info['func'])) {
				$info['func_count'] = count($info['func']);
				foreach ($info['func'] as $k1 => $v1) {
					$d[$k1] = strtolower($v1[1]);
				}
				$d = array_unique($d);
				$info['func_str'] = implode(', ', $d);
			}
			$info['code_count'] = 0;
			if(isset($info['code'])) {
				$info['code_count'] = count($info['code']);
				foreach ($info['code'] as $k2 => $v2) {
					$d1[$k2] = strtolower($v2[1]);
				}
				$d1 = array_unique($d1);
				$info['code_str'] = implode(', ', $d1);
			}
		}
		$data = file_get_contents($file);
	}
	template('system/scan');
}



