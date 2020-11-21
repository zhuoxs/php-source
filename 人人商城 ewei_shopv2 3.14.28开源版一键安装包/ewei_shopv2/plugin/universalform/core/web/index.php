<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		if (cv('universalform.temp')) {
			header('location: ' . webUrl('universalform/temp'));
			return NULL;
		}


		if (cv('universalform.category')) {
			header('location: ' . webUrl('universalform/category'));
			return NULL;
		}


		header('location: ' . webUrl());
	}
}


?>