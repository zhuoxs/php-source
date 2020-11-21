<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Storegroup_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		$all = pdo_fetchall('SELECT *FROM ' . tablename('ewei_shop_newstore_storegroup') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT name FROM ' . tablename('ewei_shop_newstore_storegroup') . ' WHERE id = :id AND uniacid = :uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			$name = trim($_GPC['name']);

			if (empty($name)) {
				show_json(0, '门店分组名称不能为空!');
			}

			if (empty($id)) {
				pdo_insert('ewei_shop_newstore_storegroup', array('name' => $name, 'uniacid' => $_W['uniacid']));
			}
			else {
				pdo_update('ewei_shop_newstore_storegroup', array('name' => $name), array('uniacid' => $_W['uniacid'], 'id' => $id));
			}

			show_json(1, array('url' => webUrl('store/storegroup')));
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			exit();
		}

		pdo_delete('ewei_shop_newstore_storegroup', array('id' => $id, 'uniacid' => $_W['uniacid']));
		show_json(1);
	}
}

?>
