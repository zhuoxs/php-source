<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;

		if (cv('membercard.cardmanage')) {
			header('location: ' . webUrl('membercard.cardmanage'));
		}
		else if (cv('membercard.getrecord')) {
			header('location: ' . webUrl('membercard.getrecord'));
		}
		else if (cv('membercard.delrecord')) {
			header('location: ' . webUrl('membercard.delrecord'));
		}
		else {
			header('location: ' . webUrl());
		}
	}
}

?>
