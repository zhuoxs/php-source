<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Wxapp_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = p('app')->getGlobal();

		if ($_W['ispost']) {
			$set['mmanage'] = array('appid' => trim($_GPC['mmanage']['appid']), 'secret' => trim($_GPC['mmanage']['secret']), 'logo' => trim($_GPC['mmanage']['logo']), 'name' => trim($_GPC['mmanage']['name']), 'open' => intval($_GPC['mmanage']['open']), 'qrcode' => trim($_GPC['mmanage']['qrcode']));
			p('app')->setGlobal($set);
			show_json();
		}

		include $this->template();
	}
}

?>
