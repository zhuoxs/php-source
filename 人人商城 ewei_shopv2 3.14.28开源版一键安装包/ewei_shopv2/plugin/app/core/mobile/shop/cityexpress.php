<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Cityexpress_EweiShopV2Page extends AppMobilePage
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
			$cityexpress['logo'] = tomedia($shop['logo']);
		}

		return app_json(array('cityexpress' => $cityexpress));
	}
}

?>
