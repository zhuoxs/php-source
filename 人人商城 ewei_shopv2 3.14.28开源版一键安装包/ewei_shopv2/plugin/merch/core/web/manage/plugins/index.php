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
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
		$plugins_data = $this->model->getPluginList($merchid);
		$plugins_list = $plugins_data['plugins_list'];
		$plugins_all = $plugins_data['plugins_all'];
		$cashier = false;

		if (p('cashier')) {
			$sql = 'SELECT * FROM ' . tablename('ewei_shop_cashier_user') . ' WHERE uniacid=:uniacid AND merchid=:merchid AND deleted=0 AND status=1';
			$res = pdo_fetch($sql, array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
			if (!empty($res) && time() < $res['lifetimeend']) {
				$cashier = $res;
				$auth_code = base64_encode(authcode($cashier['username'] . '|' . $cashier['password'] . '|' . $cashier['salt'], 'ENCODE', 'ewei_shopv2_cashier'));
				$url = $_W['siteroot'] . ('web/cashier.php?i=' . $_W['uniacid'] . '&r=login&auth_code=' . $auth_code);
			}
		}

		include $this->template();
	}
}

?>
