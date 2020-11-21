<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Printset_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$sys = pdo_fetch('select * from ' . tablename('ewei_shop_exhelper_sys') . ' where uniacid=:uniacid and merchid=0 limit 1 ', array(':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			ca('exhelper.printset');
			$data = array('uniacid' => $_W['uniacid'], 'ip' => 'localhost', 'port' => intval($_GPC['port']), 'ebusiness' => trim($_GPC['ebusiness']), 'apikey' => trim($_GPC['apikey']), 'merchid' => 0);

			if (!empty($data)) {
				if (empty($sys)) {
					pdo_insert('ewei_shop_exhelper_sys', $data);
				}
				else {
					pdo_update('ewei_shop_exhelper_sys', $data);
					pdo_update('ewei_shop_exhelper_sys', $data, array('uniacid' => $_W['uniacid'], 'merchid' => 0));
				}

				plog('exhelper.printset.edit', '修改打印机端口 原端口: ' . $sys['port'] . ' 新端口: ' . $data['port']);
				show_json(1);
			}
		}

		include $this->template();
	}
}

?>
