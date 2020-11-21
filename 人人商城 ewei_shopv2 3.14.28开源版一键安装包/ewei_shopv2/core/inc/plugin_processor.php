<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require dirname(__DIR__) . '/../defines.php';
class PluginProcessor extends WeModuleProcessor
{
	public $model;
	public $modulename;
	public $message;

	public function __construct($name = '')
	{
		global $_W;
		$this->modulename = 'ewei_shopv2';
		$this->pluginname = $name;
		$secure = $this->getIsSecureConnection();
		$http = $secure ? 'https' : 'http';
		$_W['siteroot'] = strexists($_W['siteroot'], 'https://') ? $_W['siteroot'] : str_replace('http', $http, $_W['siteroot']);
		$this->loadModel();
	}

	/**
     * 加载插件model
     */
	private function loadModel()
	{
		$modelfile = IA_ROOT . '/addons/' . $this->modulename . '/plugin/' . $this->pluginname . '/core/model.php';

		if (is_file($modelfile)) {
			$classname = ucfirst($this->pluginname) . 'Model';
			require $modelfile;
			$this->model = new $classname($this->pluginname);
		}
	}

	public function respond($obj = '')
	{
		$this->message = $this->message;
	}

	public function getIsSecureConnection()
	{
		if (isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))) {
			return true;
		}

		if (isset($_SERVER['SERVER_PORT']) && '443' == $_SERVER['SERVER_PORT']) {
			return true;
		}

		return false;
	}
}

?>
