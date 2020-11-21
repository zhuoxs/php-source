<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'seckill/core/seckill_page_web.php';
class Index_EweiShopV2Page extends SeckillWebPage
{
	public function main()
	{
		global $_W;

		if (cv('seckill.task')) {
			header('location: ' . webUrl('seckill/task'));
		}
		else if (cv('seckill.goods')) {
			header('location: ' . webUrl('seckill/goods'));
		}
		else if (cv('seckill.category')) {
			header('location: ' . webUrl('seckill/category'));
		}
		else if (cv('seckill.adv')) {
			header('location: ' . webUrl('seckill/adv'));
		}
		else if (cv('seckill.calendar')) {
			header('location: ' . webUrl('seckill/calendar'));
		}
		else if (cv('seckill.cover')) {
			header('location: ' . webUrl('seckill/cover'));
		}
		else {
			header('location: ' . webUrl());
		}
	}
}

?>
