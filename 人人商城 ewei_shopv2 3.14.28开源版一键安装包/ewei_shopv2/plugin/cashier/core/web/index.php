<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		if (cv('cashier.user')) {
			header('location: ' . webUrl('cashier/user'));
		}
		else {
			if (cv('cashier.user')) {
				header('location: ' . webUrl('cashier/user'));
			}
		}
	}

	public function ajaxcleartotle()
	{
		global $_W;
		$status0 = (int) pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_cashier_clearing') . ' WHERE uniacid=:uniacid AND status=0 AND deleted=0', array(':uniacid' => $_W['uniacid']));
		$status1 = (int) pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_cashier_clearing') . ' WHERE uniacid=:uniacid AND status=1 AND deleted=0', array(':uniacid' => $_W['uniacid']));
		$status2 = (int) pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_cashier_clearing') . ' WHERE uniacid=:uniacid AND status=2 AND deleted=0', array(':uniacid' => $_W['uniacid']));
		show_json(1, array('status0' => $status0, 'status1' => $status1, 'status2' => $status2));
	}
}

?>
