<?php

function es_empty()
{
	$empty_file = ES_CONTROLLER_PATH . ES_EMPTY_CONTROLLER . '.php';

	if (is_file($empty_file)) {
		require $empty_file;
		$empty_controller = ES_EMPTY_CONTROLLER . 'Controller';
		$empty_class = new $empty_controller();
		$empty_class->index();
		exit();
	}

	trigger_error('Empty Controller Not Found!');
	exit();
}

function webUrl($route = '', $scheme = false)
{
	if (is_array($route)) {
		if (strncmp($route[0], '/', 1) === 0) {
			ltrim($route[0], '/');
		}

		$routeArr = explode('/', strtolower($route[0]));

		if (1 < count($routeArr)) {
			$classMethod = '?c=' . $routeArr[0] . '&a=' . $routeArr[1];
		}
		else {
			$classMethod = '?c=' . $routeArr[0] . '&a=index';
		}

		unset($route[0]);
		unset($route['c']);
		unset($route['a']);
		$url = '';

		foreach ($route as $key => $value) {
			$url .= '&' . $key . '=' . $value;
		}
	}

	if (is_string($route)) {
		$routeArr = explode('/', strtolower($route));

		if (1 < count($routeArr)) {
			$classMethod = '?c=' . $routeArr[0] . '&a=' . $routeArr[1];
		}
		else {
			$classMethod = '?c=' . $routeArr[0] . '&a=index';
		}
	}

	if ($route == '' || is_bool($route)) {
		$classMethod = '?c=' . ES_DEFAULT_CONTROLLER . '&a=' . ES_DEFAULT_ACTION;
	}

	if ($scheme) {
		return ES_URL . 'index.php' . $classMethod . $url;
	}

	return ES_SCRIPT_NAME . $classMethod . $url;
}

function pctomedia($src, $local_path = false)
{
	global $_W;

	if (empty($src)) {
		return '';
	}

	if (strpos($src, './addons') === 0) {
		return $_W['siteroot'] . str_replace('./', '', $src);
	}

	if (strexists($src, $_W['siteroot']) && !strexists($src, '/addons/')) {
		$urls = parse_url($src);
		$src = $t = substr($urls['path'], strpos($urls['path'], 'images'));
	}

	$t = strtolower($src);
	if (strexists($t, 'http://') || strexists($t, 'https://')) {
		return $src;
	}

	if ($_W['setting']['remote']['type'] != 0) {
		if (!empty($src)) {
			return takeUrl($src);
		}
	}

	$http_type = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? 'https://' : 'http://';
	if ($local_path || empty($_W['setting']['remote']['type']) || file_exists(IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/' . $src)) {
		$src = $http_type . $_SERVER['SERVER_NAME'] . '/' . $_W['config']['upload']['attachdir'] . '/' . $src;
	}
	else {
		$src = $_W['attachurl_remote'] . $src;
	}

	return $src;
}

function takeUrl($url)
{
	global $_W;
	$type = $_W['setting']['remote']['type'];
	$remote = $_W['setting']['remote'];
	$typeStr = '';

	switch ($type) {
	case 1:
		$typeStr = 'ftp';
		break;

	case 2:
		$typeStr = 'alioss';
		break;

	case 3:
		$typeStr = 'qiniu';
		break;

	case 4:
		$typeStr = 'cos';
		break;

	default:
		continue;
	}

	return $remote[$typeStr]['url'] . '/' . $url;
}


?>
