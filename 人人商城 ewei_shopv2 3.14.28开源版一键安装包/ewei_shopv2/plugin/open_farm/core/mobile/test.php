<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Test_EweiShopV2Page extends PluginMobilePage
{
	/**
     * 首页方法
     */
	public function main()
	{
		require_once $this->template();
	}

	/**
     * 首页方法
     */
	public function test1()
	{
		require_once $this->template('open_farm/test1');
	}
}

?>
