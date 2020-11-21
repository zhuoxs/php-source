<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

if (!function_exists('json_encode')) {
	function json_encode($value) {
		static $jsonobj;
		if (!isset($jsonobj)) {
			include_once (IA_ROOT . '/framework/library/json/JSON.php');
			$jsonobj = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		}
		return $jsonobj->encode($value);
	}
}

if (!function_exists('json_decode')) {
	function json_decode($jsonString) {
		static $jsonobj;
		if (!isset($jsonobj)) {
			include_once (IA_ROOT . '/framework/library/json/JSON.php');
			$jsonobj = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		}
		return $jsonobj->decode($jsonString);
	}
}

if (!function_exists('http_build_query')) {
	function http_build_query($formdata, $numeric_prefix = null, $arg_separator = null) {
		if (!is_array($formdata))
			return false;
		if ($arg_separator == null)
			$arg_separator = '&';
		return http_build_recursive($formdata, $arg_separator);
	}
	function http_build_recursive($formdata, $separator, $key = '', $prefix = '') {
		$rlt = '';
		foreach ($formdata as $k => $v) {
			if (is_array($v)) {
				if ($key)
					$rlt .= http_build_recursive($v, $separator, $key . '[' . $k . ']', $prefix);
				else
					$rlt .= http_build_recursive($v, $separator, $k, $prefix);
			} else {
				if ($key)
					$rlt .= $prefix . $key . '[' . urlencode($k) . ']=' . urldecode($v) . '&';
				else
					$rlt .= $prefix . urldecode($k) . '=' . urldecode($v) . '&';
			}
		}
		return $rlt;
	}
}

if (!function_exists('file_put_contents')) {
	function file_put_contents($file, $string) {
		$fp = @fopen($file, 'w') or exit("Can not open $file");
		flock($fp, LOCK_EX);
		$stringlen = @fwrite($fp, $string);
		flock($fp, LOCK_UN);
		@fclose($fp);
		return $stringlen;
	}
}

if (!function_exists('getimagesizefromstring')) {
	function getimagesizefromstring($string_data) {
		$uri = 'data://application/octet-stream;base64,'  . base64_encode($string_data);
		return getimagesize($uri);
	}
}


if (!defined('JSON_UNESCAPED_UNICODE')) {
	define('JSON_UNESCAPED_UNICODE', 256);
}

if (!function_exists('hex2bin')) {
	function hex2bin($str) {
		$sbin = '';
		$len = strlen($str);
		for ($i = 0; $i < $len; $i += 2) {
			$sbin .= pack("H*", substr($str, $i, 2));
		}
		return $sbin;
	}
}

if (!function_exists('mb_strlen')) {
	function mb_strlen($string, $charset = '') {
		return istrlen($string, $charset);
	}
}


if (!interface_exists('SessionHandlerInterface')) {
	interface SessionHandlerInterface  {}
}


if (!function_exists("fastcgi_finish_request")) {
	function fastcgi_finish_request() {
		return error(-1, 'Not npm or fast cgi');
	}
}
