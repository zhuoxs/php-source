<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Mood_EweiShopV2Page extends PluginMobilePage
{
	/**
     * 首页方法
     */
	public function main()
	{
		require_once $this->template();
	}

	/**
     * 绑定用户,成为好友
     */
	public function relation()
	{
		global $_W;
		global $_GPC;
		$this->model->dd(true, $_W, $_GPC);
	}
}

?>
