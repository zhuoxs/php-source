<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Points_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		include $this->template();
	}
}

?>
