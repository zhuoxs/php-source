<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Set_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$key = pdo_fetch('SELECT `key`,url FROM ' . tablename('ewei_shop_open_plugin') . ' WHERE plugin = :plugin ', array(':plugin' => $this->pluginname));
		$key['url'] = json_decode($key['url']);
		$data = array();

		if ($_W['ispost']) {
			$data['url'] = $_GPC['url'];
			m('common')->updatePluginset(array('open_messikefu' => $data), $_W['uniacid']);
			show_json(1);
		}

		$data = m('common')->getPluginset(array('open_messikefu'), $_W['uniacid']);
		$key['url'] = $data['open_messikefu']['url'];
		include $this->template();
	}
}

?>
