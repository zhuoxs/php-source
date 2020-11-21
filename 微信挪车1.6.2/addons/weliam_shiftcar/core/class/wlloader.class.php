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
		if (isset($this->cache['wlfunc'][$name])) {
			return true;
		}
		$file = WL_CORE . 'function/' . $name . '.func.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['wlfunc'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Helper Function '.WL_CORE.'function/' . $name . '.func.php', E_USER_ERROR);
			return false;
		}
	}
	
	function model($name) {
		global $_W;
		if (isset($this->cache['wlmodel'][$name])) {
			return true;
		}
		$file = WL_CORE . 'model/' . $name . '.mod.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['wlmodel'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Model '.WL_CORE.'model/' . $name . '.mod.php', E_USER_ERROR);
			return false;
		}
	}
	
	function classs($name) {
		global $_W;
		if (isset($this->cache['wlclass'][$name])) {
			return true;
		}
		$file = WL_CORE . 'class/' . $name . '.class.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['wlclass'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Class '.WL_CORE.'class/' . $name . '.class.php', E_USER_ERROR);
			return false;
		}
	}
	
	function web($name) {
		global $_W;
		if (isset($this->cache['wlweb'][$name])) {
			return true;
		}
		$file = WL_PATH . '/web/common/' . $name . '.func.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['wlweb'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Web Helper '.WL_PATH.'/web/common/' . $name . '.func.php', E_USER_ERROR);
			return false;
		}
	}
	
	function app($name) {
		global $_W;
		if (isset($this->cache['wlapp'][$name])) {
			return true;
		}
		$file = WL_PATH . '/app/common/' . $name . '.func.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['wlapp'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid App Function '.WL_PATH.'/app/common/' . $name . '.func.php', E_USER_ERROR);
			return false;
		}
	}
	
}
