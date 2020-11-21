<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Cityexpress_EweiShopV2Page extends MobilePage
{
	public function map()
	{
		global $_W;
		global $_GPC;
		$cityexpress = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_city_express') . ' WHERE uniacid=:uniacid AND merchid=:merchid', array(':uniacid' => $_W['uniacid'], ':merchid' => 0));
		$address = m('common')->getSysset('contact');
		$shop = m('common')->getSysset('shop');

		if (!empty($address)) {
			$cityexpress['address'] = $address['province'] . $address['city'] . $address['address'];
		}

		if (!empty($shop)) {
			$cityexpress['name'] = $shop['name'];
			$cityexpress['logo'] = $shop['logo'];
		}

		include $this->template();
	}
}

?>
