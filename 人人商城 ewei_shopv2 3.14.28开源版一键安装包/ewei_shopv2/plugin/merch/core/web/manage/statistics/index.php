<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Index_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		if (mcv('statistics.sale.main')) {
			header('location: ' . merchUrl('statistics/sale'));
		}
		else if (mcv('statistics.sale_analysis.main')) {
			header('location: ' . merchUrl('statistics/sale_analysis'));
		}
		else if (mcv('statistics.order.main')) {
			header('location: ' . merchUrl('statistics/order'));
		}
		else if (mcv('statistics.sale_analysis.main')) {
			header('location: ' . merchUrl('statistics/sale_analysis'));
		}
		else if (mcv('statistics.goods.main')) {
			header('location: ' . merchUrl('statistics/goods'));
		}
		else if (mcv('statistics.goods_rank.main')) {
			header('location: ' . merchUrl('statistics/goods_rank'));
		}
		else if (mcv('statistics.goods_trans.main')) {
			header('location: ' . merchUrl('statistics/goods_trans'));
		}
		else if (mcv('statistics.member_cost.main')) {
			header('location: ' . merchUrl('statistics/member_cost'));
		}
		else if (mcv('statistics.member_increase.main')) {
			header('location: ' . merchUrl('statistics/member_increase'));
		}
		else {
			header('location: ' . merchUrl());
		}
	}
}

?>
