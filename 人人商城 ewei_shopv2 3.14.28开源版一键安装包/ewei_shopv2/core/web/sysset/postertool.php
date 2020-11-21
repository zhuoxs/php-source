<?php
//QQ63779278
echo '  ';

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Postertool_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		include $this->template();
	}

	public function clear()
	{
		global $_W;
		global $_GPC;
		load()->func('file');
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/poster/' . $_W['uniacid']);
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/qrcode/' . $_W['uniacid']);
		$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		pdo_update('ewei_shop_poster_qr', array('mediaid' => ''), array('acid' => $acid));
		plog('poster.clear', '清除海报缓存');
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/goodscode/' . $_W['uniacid']);
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/poster_wxapp/commission/' . $_W['uniacid']);
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/poster_wxapp/goods/' . $_W['uniacid']);
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/postera/' . $_W['uniacid']);
		@rmdirs(IA_ROOT . ' /addons/ewei_shopv2/data/task/poster/' . $_W['uniacid']);
		@rmdirs(IA_ROOT . ' /addons/ewei_shopv2/data/upload/exchange/' . $_W['uniacid']);
		show_json(1);
	}
}

?>
