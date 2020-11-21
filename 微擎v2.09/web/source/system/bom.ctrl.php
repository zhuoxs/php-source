<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

set_time_limit(0);

load()->func('file');

if (checksubmit('submit')) {
	$path = IA_ROOT;
	$trees = file_tree($path);
	$bomtree = array();
	foreach ($trees as $tree) {
		$tree = str_replace($path, '', $tree);
		$tree = str_replace('\\', '/', $tree);
		if (strexists($tree, '.php')) {
			$fname = $path . $tree;
			$fp = fopen($fname, 'r');
			if (!empty($fp)) {
				$bom = fread($fp, 3);
				fclose($fp);
				if ($bom == "\xEF\xBB\xBF") {
					$bomtree[] = $tree;
				}
			}
		}
	}
	cache_write(cache_system_key('bomtree'), $bomtree);
}

if (checksubmit('dispose')) {
	$trees = cache_load(cache_system_key('bomtree'));
	$path = IA_ROOT;
	if (is_array($trees)) {
		foreach ($trees as $tree) {
			$fname = $path . $tree;
			$string = file_get_contents($fname);
			$string = substr($string, 3);
			file_put_contents($fname, $string);
			@fclose($fp);
		}
	}
	cache_delete(cache_system_key('bomtree'));
}

template('system/bom');