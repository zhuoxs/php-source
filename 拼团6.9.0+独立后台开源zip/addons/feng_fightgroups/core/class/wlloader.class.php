<?php
defined('IN_IA') or exit('Access Denied');


function wl_load() {
	static $loader;
	if(empty($loader)) {
		$wl_loader = new Wl_loader();
	}
	return $wl_loader;
}


class Wl_loader {
	
	private $cache = array();
	
	function func($name) {
		global $_W;
		if (isset($this->cache['tgfunc'][$name])) {
			return true;
		}
		$file = TG_CORE . 'function/' . $name . '.func.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['tgfunc'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Helper Function '.TG_CORE.'function/' . $name . '.func.php', E_USER_ERROR);
			return false;
		}
	}
	
	function model($name) {
		global $_W;
		if (isset($this->cache['tgmodel'][$name])) {
			return true;
		}
		$file = TG_CORE . 'model/' . $name . '.mod.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['tgmodel'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Model '.TG_CORE.'model/' . $name . '.mod.php', E_USER_ERROR);
			return false;
		}
	}
	
	function classs($name) {
		global $_W;
		if (isset($this->cache['tgclass'][$name])) {
			return true;
		}
		$file = TG_CORE . 'class/' . $name . '.class.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['tgclass'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Class '.TG_CORE.'class/' . $name . '.class.php', E_USER_ERROR);
			return false;
		}
	}
	
	function web($name) {
		global $_W;
		if (isset($this->cache['tgweb'][$name])) {
			return true;
		}
		$file = TG_PATH . '/web/common/' . $name . '.func.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['tgweb'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Web Helper '.TG_PATH.'/web/common/' . $name . '.func.php', E_USER_ERROR);
			return false;
		}
	}
	
	function app($name) {
		global $_W;
		if (isset($this->cache['tgapp'][$name])) {
			return true;
		}
		$file = TG_PATH . '/app/common/' . $name . '.func.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['tgapp'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid App Function '.TG_PATH.'/app/common/' . $name . '.func.php', E_USER_ERROR);
			return false;
		}
	}
	
}
