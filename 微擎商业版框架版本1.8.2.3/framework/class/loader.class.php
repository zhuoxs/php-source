<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function load() {
	static $loader;
	if(empty($loader)) {
		$loader = new Loader();
	}
	return $loader;
}


function table($name) {
	$table_classname = "\\We7\\Table\\";
	$subsection_name = explode('_', $name);
	if (count($subsection_name) == 1) {
		$table_classname .= ucfirst($subsection_name[0]) . "\\" . ucfirst($subsection_name[0]);
	} else {
		foreach ($subsection_name as $key => $val) {
			if ($key == 0) {
				$table_classname .= ucfirst($val) . '\\';
			} else {
				$table_classname .= ucfirst($val);
			}
		}
	}

	if (in_array($name, array(
		'modules_rank',
		'modules_bindings',
		'modules_plugin',
		'modules_cloud',
		'modules_recycle',
		'modules',
		'modules_ignore',
		'account_xzapp',
		'account_aliapp',
		'account_wxapp',
		'uni_account_modules',
		'system_stat_visit',
		'core_profile_fields',
		'article_comment',
		'wxapp_versions',
	))) {
		return new $table_classname;
	}

	load()->classs('table');
	load()->table($name);
	$service = false;

	$class_name = "{$name}Table";
	if (class_exists($class_name)) {
		$service = new $class_name();
	}
	return $service;
}


class Loader {

	private $cache = array();
	private $singletonObject = array();
	private $libraryMap = array(
		'agent' => 'agent/agent.class',
		'captcha' => 'captcha/captcha.class',
		'pdo' => 'pdo/PDO.class',
		'qrcode' => 'qrcode/phpqrcode',
		'ftp' => 'ftp/ftp',
		'pinyin' => 'pinyin/pinyin',
		'pkcs7' => 'pkcs7/pkcs7Encoder',
		'json' => 'json/JSON',
		'phpmailer' => 'phpmailer/PHPMailerAutoload',
		'oss' => 'alioss/autoload',
		'qiniu' => 'qiniu/autoload',
		'cos' => 'cosv4.2/include',
		'cosv3' => 'cos/include',
		'sentry' => 'sentry/Raven/Autoloader',
	);
	private $loadTypeMap = array(
		'func' => '/framework/function/%s.func.php',
		'model' => '/framework/model/%s.mod.php',
		'classs' => '/framework/class/%s.class.php',
		'library' => '/framework/library/%s.php',
		'table' => '/framework/table/%s.table.php',
		'web' => '/web/common/%s.func.php',
		'app' => '/app/common/%s.func.php',
	);
	private $accountMap = array(
		'account' => 'account/account',
		'weixin.account' => 'account/weixin.account',
		'aliapp.account' => 'account/aliapp.account',
		'phoneapp.account' => 'account/phoneapp.account',
		'webapp.account' => 'account/webapp.account',
		'weixin.account' => 'account/weixin.account',
		'weixin.platform' => 'account/weixin.platform',
		'wxapp.account' => 'account/wxapp.account',
		'wxapp.platform' => 'account/wxapp.platform',
		'wxapp.work' => 'account/wxapp.work',
		'xzapp.account' => 'account/xzapp.account',
		'xzapp.platform' => 'account/xzapp.platform',
	);

	public function __construct() {
		$this->registerAutoload();
	}

	public function registerAutoload() {
		spl_autoload_register(array($this, 'autoload'));
			}

	public function autoload($class) {
		$section = array(
			'Table' => '/framework/table/',
		);
				$classmap = array(
			'We7Table' => 'table',
		);
		if (isset($classmap[$class])) {
			load()->classs($classmap[$class]);
		} elseif (preg_match('/^[0-9a-zA-Z\-\\\\_]+$/', $class)
			&& (stripos($class, 'We7') === 0 || stripos($class, '\We7') === 0)
			&& stripos($class, "\\") !== false) {
				$group = explode("\\", $class);
				$path = IA_ROOT . $section[$group[1]];
				unset($group[0]);
				unset($group[1]);
				$file_path = $path . implode('/', $group) . '.php';
				if(is_file($file_path)) {
					include $file_path;
				}
								$file_path = $path . 'Core/' .  implode('', $group) . '.php';
				if(is_file($file_path)) {
					include $file_path;
				}
		}
	}

	public function __call($type, $params) {
		global $_W;
		$name = $cachekey = array_shift($params);
		if (!empty($this->cache[$type]) && isset($this->cache[$type][$cachekey])) {
			return true;
		}
		if (empty($this->loadTypeMap[$type])) {
			return true;
		}
				if ($type == 'library' && !empty($this->libraryMap[$name])) {
			$name = $this->libraryMap[$name];
		}
		if ($type == 'classs' && !empty($this->accountMap[$name])) {
						$filename = sprintf($this->loadTypeMap[$type], $this->accountMap[$name]);
			if (file_exists(IA_ROOT . $filename)) {
				$name = $this->accountMap[$name];
			}
		}
		$file = sprintf($this->loadTypeMap[$type], $name);
		if (file_exists(IA_ROOT . $file)) {
			include IA_ROOT . $file;
			$this->cache[$type][$cachekey] = true;
			return true;
		} else {
			trigger_error('Invalid ' . ucfirst($type) . $file, E_USER_WARNING);
			return false;
		}
	}

	
	function singleton($name) {
		if (isset($this->singletonObject[$name])) {
			return $this->singletonObject[$name];
		}
		$this->singletonObject[$name] = $this->object($name);
		return $this->singletonObject[$name];
	}

	
	function object($name) {
		$this->classs(strtolower($name));
		if (class_exists($name)) {
			return new $name();
		} else {
			return false;
		}
	}
}
