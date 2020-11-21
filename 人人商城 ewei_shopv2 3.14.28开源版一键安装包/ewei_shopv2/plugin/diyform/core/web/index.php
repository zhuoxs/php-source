<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		if (cv('diyform.temp')) {
			header('location: ' . webUrl('diyform/temp'));
		}
		else if (cv('diyform.category')) {
			header('location: ' . webUrl('diyform/category'));
		}
		else if (cv('diyform.set')) {
			header('location: ' . webUrl('diyform/set'));
		}
		else {
			header('location: ' . webUrl());
		}
	}
}

?>
