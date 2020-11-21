<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Selecticon_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		include $this->template();
	}
}

?>
