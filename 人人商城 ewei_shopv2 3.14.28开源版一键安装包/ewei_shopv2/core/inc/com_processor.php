<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require dirname(__DIR__) . '/../defines.php';
class ComProcessor extends WeModuleProcessor
{
	public $model;
	public $modulename;
	public $message;

	public function __construct($name = '')
	{
		$this->modulename = 'ewei_shopv2';
		$this->pluginname = $name;
		$this->loadModel();
	}

	/**
     * 加载插件model
     */
	private function loadModel()
	{
		$modelfile = IA_ROOT . '/addons/' . $this->modulename . '/core/com/' . $this->pluginname . '.php';

		if (is_file($modelfile)) {
			$classname = ucfirst($this->pluginname) . '_EweiShopV2ComModel';
			require $modelfile;
			$this->model = new $classname($this->pluginname);
		}
	}

	public function respond()
	{
		$this->message = $this->message;
	}
}

?>
