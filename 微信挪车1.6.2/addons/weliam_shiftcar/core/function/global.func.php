<?php
defined('IN_IA') or exit('Access Denied');

function m($name = '') {
	static $_modules = array();
	if (isset($_modules[$name])) {
		return $_modules[$name];
	}
	$model = WL_CORE . "class/" . strtolower($name) . '.class.php';
	if (!is_file($model)) {
		die(' Class ' . $name . ' Not Found!');
	}
	require $model;
	$class_name = 'Weliam_' . ucfirst($name);
	//调用该类
	$_modules[$name] = new $class_name();
	return $_modules[$name];
}

function p($name = '') {
	$model = PATH_PLUGIN . strtolower($name) . '/config.xml';
	if (!is_file($model)) {
		return FALSE;
	}
	return TRUE;
}

function web_url($segment, $params = array()) {
	global $_W, $_GPC;
	session_start();
	list($do, $ac, $op) = explode('/', $segment);
	if (defined('IN_WEB')) {
		$url = $_W['siteroot'] . 'web/caragent.php?';
	} else {
		$url = $_W['siteroot'] . 'web/index.php?c=site&a=entry&m=' . WL_NAME . '&';
	}
	if (!empty($do)) {
		$url .= "do={$do}&";
	}
	if (!empty($ac)) {
		$url .= "ac={$ac}&";
	}
	if (!empty($op)) {
		$url .= "op={$op}&";
	}
	if (!empty($params)) {
		$queryString = http_build_query($params, '', '&');
		$url .= $queryString;
	}
	return $url;
}

function app_url($segment, $params = array()) {
	global $_W;
	list($do, $ac, $op) = explode('/', $segment);
	$url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=' . WL_NAME . '&';
	if (!empty($do)) {
		$url .= "do={$do}&";
	}
	if (!empty($ac)) {
		$url .= "ac={$ac}&";
	}
	if (!empty($op)) {
		$url .= "op={$op}&";
	}
	if (!empty($params)) {
		$queryString = http_build_query($params, '', '&');
		$url .= $queryString;
	}
	if (substr($url, -1) == '&') {
		$url = substr($url, 0, strlen($url) - 1);
	}
	return $url;
}

function mobile_mask($mobile) {
	return substr($mobile, 0, 3) . '****' . substr($mobile, 7);
}

function wl_debug($value) {
	echo "<br><pre>";
	print_r($value);
	echo "</pre>";
	exit ;
}

function wl_log($message, $data = '') {
	if ($data) {
		pdo_insert('core_text', array('content' => iserializer($data)));
		$text_id = pdo_insertid();
	}
	$log = array('errno' => 0, 'message' => $message, 'text_id' => intval($text_id), 'createtime' => TIMESTAMP, 'ip' => CLIENT_IP);
	pdo_insert('core_error_log', $log);
}

function api_log($message, $data = '') {
	if (DEVELOPMENT && ((CURRENT_IP && CURRENT_IP == CLIENT_IP) || CURRENT_IP == '')) {
		if ($data) {
			$message .= ' -> ';
			if (is_resource($data)) {
				$message .= '资源文件';
			} elseif (gettype($data) == 'object' || is_array($data)) {
				$message .= iserializer($data);
			} else {
				$message .= $data;
			}
		}
		$filename = IA_ROOT . '/data/logs/api-log-' . date('Ymd', TIMESTAMP) . '.' . $_GET['platform'] . '.txt';
		if (!file_exists($filename)) {
			load() -> func('file');
			mkdirs(dirname($filename));
		}
		file_put_contents($filename, $message . PHP_EOL . PHP_EOL, FILE_APPEND);
	}
}

function pwd_hash($password, $salt) {
	return md5("{$password}-{$salt}-{$GLOBALS['_W']['config']['setting']['authkey']}");
}

function is_weixin() {
	if (empty($_SERVER['HTTP_USER_AGENT']) || strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'Windows Phone') === false) {
		return false;
	}
	return true;
}

function removeEmoji($text) {
	$clean_text = "";
	$regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
	$clean_text = preg_replace($regexEmoticons, '', $text);
	$regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
	$clean_text = preg_replace($regexSymbols, '', $clean_text);
	$regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
	$clean_text = preg_replace($regexTransport, '', $clean_text);
	$regexMisc = '/[\x{2600}-\x{26FF}]/u';
	$clean_text = preg_replace($regexMisc, '', $clean_text);
	$regexDingbats = '/[\x{2700}-\x{27BF}]/u';
	$clean_text = preg_replace($regexDingbats, '', $clean_text);

	return $clean_text;
}

function wl_message($msg, $redirect = '', $type = '') {
	global $_W, $_GPC;
	if ($redirect == 'refresh') {
		$redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
	}
	if ($redirect == 'referer') {
		$redirect = referer();
	}
	if ($redirect == 'close') {
		$redirect = 'wx.closeWindow()';
		$close = 1;
	}
	if ($redirect == '') {
		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'info';
	} else {
		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'success';
	}
	if (IN_WXAPP == 'wxapp') {
		die(json_encode(array('errno' => $type == 'success' ? 0 : 1, 'message' => $msg, 'data' => $redirect)));
	}
	if ($_W['isajax'] || !empty($_GET['isajax']) || $type == 'ajax') {
		if ($type != 'ajax' && !empty($_GPC['target'])) {
			exit("
<script type=\"text/javascript\">
parent.require(['jquery', 'util'], function($, util){
	var url = " . (!empty($redirect) ? 'parent.location.href' : "''") . ";
	var modalobj = util.message('" . $msg . "', '', '" . $type . "');
	if (url) {
		modalobj.on('hide.bs.modal', function(){\$('.modal').each(function(){if(\$(this).attr('id') != 'modal-message') {\$(this).modal('hide');}});top.location.reload()});
	}
});
</script>");
		} else {
			$vars = array();
			if (is_array($msg)) {
				$vars['errno'] = $msg['errno'];
				$vars['message'] = $msg['message'];
				die(json_encode($vars));
			} else {
				$vars['message'] = $msg;
			}
			$vars['redirect'] = $redirect;
			$vars['type'] = $type;
			die(json_encode($vars));
		}
	} elseif (is_array($msg)) {
		$msg = $msg['message'];
	}
	if (empty($msg) && !empty($redirect)) {
		header('location: ' . $redirect);
	}
	$label = $type;
	if ($type == 'error') {
		$label = 'danger';
	}
	if ($type == 'ajax' || $type == 'sql') {
		$label = 'warning';
	}
	include      wl_template('common/message', TEMPLATE_INCLUDEPATH);
	exit();
}

function wl_template($filename, $flag = '') {
	global $_W;
	$name = WL_NAME;
	if (defined('IN_SYS') || defined('IN_WEB')) {
		$template = $_W['wlsetting']['templat']['webview'];
		if (empty($template)) {
			$template = "default";
		}
		$source = IA_ROOT . "/addons/{$name}/web/view/{$template}/{$filename}.html";
		$compile = IA_ROOT . "/data/tpl/web/{$name}/web/view/{$template}/{$filename}.tpl.php";
		if (!is_file($source)) {
			$source = IA_ROOT . "/addons/{$name}/plugin/{$_W['plugin']}/sys/view/default/{$filename}.html";
		}
		if (!is_file($source)) {
			$source = IA_ROOT . "/addons/{$name}/plugin/{$_W['plugin']}/web/view/default/{$filename}.html";
		}
	} else {
		$template = $_W['wlsetting']['templat']['appview'];
		if (empty($template)) {
			$template = "default";
		}
		$source = IA_ROOT . "/addons/{$name}/app/view/{$template}/{$filename}.html";
		$compile = IA_ROOT . "/data/tpl/app/{$name}/app/view/{$template}/{$filename}.tpl.php";
		if (!is_file($source)) {
			$source = IA_ROOT . "/addons/{$name}/app/view/default/{$filename}.html";
		}
	}
	if (!is_file($source)) {
		exit("Error: template source '{$filename}' is not exist!!!");
	}
	if (!is_file($compile) || filemtime($source) > filemtime($compile)) {
		wl_template_compile($source, $compile, true);

	}
	if ($flag == TEMPLATE_FETCH) {
		extract($GLOBALS, EXTR_SKIP);
		ob_end_flush();
		ob_clean();
		ob_start();
		include $compile;
		$contents = ob_get_contents();
		ob_clean();
		return $contents;

	} else if ($flag == 'template') {
		extract($GLOBALS, EXTR_SKIP);
		return $compile;
	} else {
		return $compile;
	}

}

function wl_template_compile($from, $to, $inmodule = false) {
	$path = dirname($to);
	if (!is_dir($path)) {
		load() -> func('file');
		mkdirs($path);
	}
	$content = wl_template_parse(file_get_contents($from), $inmodule);
	if (IMS_FAMILY == 'x' && !preg_match('/(footer|header)+/', $from)) {
		$content = str_replace('微擎', '系统', $content);
	}
	file_put_contents($to, $content);
}

function wl_template_parse($str, $inmodule = false) {
	$str = preg_replace('/<!--{(.+?)}-->/s', '{$1}', $str);
	$str = preg_replace('/{template\s+(.+?)}/', '<?php (!empty($this) && $this instanceof WeModuleSite || ' . intval($inmodule) . ') ? (include $this->template($1, TEMPLATE_INCLUDEPATH)) : (include template($1, TEMPLATE_INCLUDEPATH));?>', $str);

	$str = preg_replace('/{php\s+(.+?)}/', '<?php $1?>', $str);
	$str = preg_replace('/{if\s+(.+?)}/', '<?php if($1) { ?>', $str);
	$str = preg_replace('/{else}/', '<?php } else { ?>', $str);
	$str = preg_replace('/{else ?if\s+(.+?)}/', '<?php } else if($1) { ?>', $str);
	$str = preg_replace('/{\/if}/', '<?php } ?>', $str);
	$str = preg_replace('/{loop\s+(\S+)\s+(\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2) { ?>', $str);
	$str = preg_replace('/{loop\s+(\S+)\s+(\S+)\s+(\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2 => $3) { ?>', $str);
	$str = preg_replace('/{\/loop}/', '<?php } } ?>', $str);
	$str = preg_replace('/{(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)}/', '<?php echo $1;?>', $str);
	$str = preg_replace('/{(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff\[\]\'\"\$]*)}/', '<?php echo $1;?>', $str);
	$str = preg_replace('/{url\s+(\S+)}/', '<?php echo url($1);?>', $str);
	$str = preg_replace('/{url\s+(\S+)\s+(array\(.+?\))}/', '<?php echo url($1, $2);?>', $str);
	$str = preg_replace_callback('/<\?php([^\?]+)\?>/s', "template_addquote", $str);
	$str = preg_replace('/{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)}/s', '<?php echo $1;?>', $str);
	$str = str_replace('{##', '{', $str);
	$str = str_replace('##}', '}', $str);
	$str = "<?php defined('IN_IA') or exit('Access Denied');?>" . $str;
	return $str;
}

function wl_template_addquote($matchs) {
	$code = "<?php {$matchs[1]}?>";
	$code = preg_replace('/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\](?![a-zA-Z0-9_\-\.\x7f-\xff\[\]]*[\'"])/s', "['$1']", $code);
	return str_replace('\\\"', '\"', $code);
}

$my_scenfiles = array();
function my_scandir($dir) {
	global $my_scenfiles;
	if ($handle = opendir($dir)) {
		while (($file = readdir($handle)) !== false) {
			if ($file != ".." && $file != ".") {
				if (is_dir($dir . "/" . $file)) {
					my_scandir($dir . "/" . $file);
				} else {
					$my_scenfiles[] = $dir . "/" . $file;
				}
			}
		}
		closedir($handle);
	}
}

function currency_format($currency, $decimals = 2) {
	$currency = floatval($currency);
	if (empty($currency)) {
		return '0.00';
	}
	$currency = number_format($currency, $decimals);
	$currency = str_replace(',', '', $currency);
	return $currency;
}

function object_array($array) {
	if (is_object($array)) {
		$array = (array)$array;
	}
	if (is_array($array)) {
		foreach ($array as $key => $value) {
			$array[$key] = object_array($value);
		}
	}
	return $array;
}

/*创建或更新浏览量*/
function puv() {
	global $_W;
	if ($_W['uniacid'] <= 0) {
		return;
	}
	$puv = pdo_getcolumn('weliam_shiftcar_puv', array('uniacid' => $_W['uniacid'], 'date' => date('Ymd')), 'id');
	if (empty($puv)) {
		pdo_insert('weliam_shiftcar_puv', array('uniacid' => $_W['uniacid'], 'pv' => 0, 'uv' => 0, 'date' => date('Ymd')));
		$puv = pdo_insertid();
	}
	pdo_query('UPDATE ' . tablename('weliam_shiftcar_puv') . " SET `pv` = `pv` + 1 WHERE id = {$puv}");
	if ($_W['mid']) {
		$myp = pdo_getcolumn('weliam_shiftcar_puvrecord', array('uniacid' => $_W['uniacid'], 'date' => date('Ymd'), 'mid' => $_W['mid']), 'id');
		if (empty($myp)) {
			pdo_query('UPDATE ' . tablename('weliam_shiftcar_puv') . " SET `uv` = `uv` + 1 WHERE id = {$puv}");
			pdo_insert('weliam_shiftcar_puvrecord', array('uniacid' => $_W['uniacid'], 'pv' => 0, 'mid' => $_W['mid'], 'date' => date('Ymd')));
			$myp = pdo_insertid();
		}
		pdo_query('UPDATE ' . tablename('weliam_shiftcar_puvrecord') . " SET `pv` = `pv` + 1 WHERE id = {$myp}");
	}
}

function wl_json($status = 1, $return = null) {
	$ret = array('status' => $status);
	if ($return) {
		$ret['result'] = $return;
	}
	die(json_encode($ret));
}

if (!function_exists('show_json')) {
	function show_json($status = 1, $return = NULL) {
		$ret = array('status' => $status, 'result' => $status == 1 ? array('url' => referer()) : array());

		if (!is_array($return)) {
			if ($return) {
				$ret['result']['message'] = $return;
			}

			exit(json_encode($ret));
		} else {
			$ret['result'] = $return;
		}

		if (isset($return['url'])) {
			$ret['result']['url'] = $return['url'];
		} else {
			if ($status == 1) {
				$ret['result']['url'] = referer();
			}
		}

		exit(json_encode($ret));
	}

}

function sendCustomNotice($openid, $msg, $url = '', $account = null) {
	global $_W;
	if (!$account) {
		load() -> model('account');
		$acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account_wechats') . " WHERE `uniacid`=:uniacid LIMIT 1", array(':uniacid' => $_W['uniacid']));
		$account = WeAccount::create($acid);
	}
	if (!$account) {
		return;
	}
	$content = "";
	if (is_array($msg)) {
		foreach ($msg as $key => $value) {
			if (!empty($value['title'])) {
				$content .= $value['title'] . ":" . $value['value'] . "\n";
			} else {
				$content .= $value['value'] . "\n";
				if ($key == 0) {
					$content .= "\n";
				}
			}
		}
	} else {
		$content = $msg;
	}
	if (!empty($url)) {
		$content .= "<a href='{$url}'>点击查看详情</a>";
	}
	return $account -> sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode($content))));
}

function returnnum_array($brands, $i) {
	switch ($i) {
		case '1' :
			$brandlist = array('A');
			$bgnum = 0;
			$count = 6;
			break;
		case '2' :
			$brandlist = array('B');
			$bgnum = 6;
			$count = 24 - 6;
			break;
		case '3' :
			$brandlist = array('C');
			$bgnum = 24;
			$count = 29 - 24;
			break;
		case '4' :
			$brandlist = array('D');
			$bgnum = 29;
			$count = 43 - 29;
			break;
		case '5' :
			$brandlist = array('E');
			$bgnum = 43;
			$count = 0;
			break;
		case '6' :
			$brandlist = array('F');
			$bgnum = 43;
			$count = 50 - 43;
			break;
		case '7' :
			$brandlist = array('G');
			$bgnum = 50;
			$count = 53 - 50;
			break;
		case '8' :
			$brandlist = array('H');
			$bgnum = 53;
			$count = 69 - 53;
			break;
		case '9' :
			$brandlist = array('I');
			$bgnum = 69;
			$count = 0;
			break;
		case '10' :
			$brandlist = array('J');
			$bgnum = 69;
			$count = 82 - 69;
			break;
		case '11' :
			$brandlist = array('K');
			$bgnum = 82;
			$count = 89 - 82;
			break;
		case '12' :
			$brandlist = array('L');
			$bgnum = 89;
			$count = 104 - 89;
			break;
		case '13' :
			$brandlist = array('M');
			$bgnum = 104;
			$count = 111 - 104;
			break;
		case '14' :
			$brandlist = array('N');
			$bgnum = 111;
			$count = 112 - 111;
			break;
		case '15' :
			$brandlist = array('O');
			$bgnum = 112;
			$count = 115 - 112;
			break;
		case '16' :
			$brandlist = array('P');
			$bgnum = 115;
			$count = 117 - 115;
			break;
		case '17' :
			$brandlist = array('Q');
			$bgnum = 117;
			$count = 120 - 117;
			break;
		case '18' :
			$brandlist = array('R');
			$bgnum = 120;
			$count = 124 - 120;
			break;
		case '19' :
			$brandlist = array('S');
			$bgnum = 124;
			$count = 140 - 124;
			break;
		case '20' :
			$brandlist = array('T');
			$bgnum = 140;
			$count = 145 - 140;
			break;
		case '21' :
			$brandlist = array('U');
			$bgnum = 145;
			$count = 0;
			break;
		case '22' :
			$brandlist = array('V');
			$bgnum = 145;
			$count = 0;
			break;
		case '23' :
			$brandlist = array('W');
			$bgnum = 145;
			$count = 152 - 145;
			break;
		case '24' :
			$brandlist = array('X');
			$bgnum = 152;
			$count = 160 - 152;
			break;
		case '25' :
			$brandlist = array('Y');
			$bgnum = 160;
			$count = 167 - 160;
			break;
		case '26' :
			$brandlist = array('Z');
			$bgnum = 167;
			$count = 170 - 167;
			break;
		default :
			$brandlist = array('#');
			$bgnum = 170;
			$count = 171 - 170;
			break;
	}

	return array($brandlist, array_slice($brands, $bgnum, $count));
}

function keyExist($key = '') {
	global $_W;

	if (empty($key)) {
		return NULL;
	}

	$keyword = pdo_fetch('SELECT rid FROM ' . tablename('rule_keyword') . ' WHERE content=:content and uniacid=:uniacid limit 1 ', array(':content' => trim($key), ':uniacid' => $_W['uniacid']));

	if (!empty($keyword)) {
		$rule = pdo_fetch('SELECT * FROM ' . tablename('rule') . ' WHERE id=:id and uniacid=:uniacid limit 1 ', array(':id' => $keyword['rid'], ':uniacid' => $_W['uniacid']));

		if (!empty($rule)) {
			return $rule;
		}
	}
}

function oplog($user, $describe, $view_url, $data) {
	global $_W;
	$data = array('user' => $user, 'uniacid' => $_W['uniacid'], 'describe' => $describe, 'view_url' => $view_url, 'data' => $data, 'ip' => CLIENT_IP, 'createtime' => TIMESTAMP);
	pdo_insert("weliam_shiftcar_oplog", $data);
}

function getMillisecond() {
	list($t1, $t2) = explode(' ', microtime());
	return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
}

if (!function_exists('filter_url')) {
	function filter_url($params) {
		global $_W;
		if (empty($params)) {
			return '';
		}
		$query_arr = array();
		$parse = parse_url($_W['siteurl']);
		if (!empty($parse['query'])) {
			$query = $parse['query'];
			parse_str($query, $query_arr);
		}
		$params = explode(',', $params);
		foreach ($params as $val) {
			if (!empty($val)) {
				$data = explode(':', $val);
				$query_arr[$data[0]] = trim($data[1]);
			}
		}
		$query_arr['page'] = 1;
		$query = http_build_query($query_arr);
		return './caragent.php?' . $query;
	}

}

if (!function_exists('url')) {
	function url($segment, $params = array()) {
		return wurl($segment, $params);
	}

}
