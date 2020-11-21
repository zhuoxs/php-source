<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Coms_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			if (!empty($_GPC['name'])) {
				foreach ($_GPC['name'] as $id => $name) {
					pdo_update('ewei_shop_plugin', array('status' => $_GPC['status'][$id], 'thumb' => $_GPC['thumb'][$id], 'name' => $_GPC['name'][$id]), array('id' => $id));
				}

				m('plugin')->refreshCache(1);
				show_json(1);
			}
		}

		$condition = ' and iscom=1 and deprecated=0';

		if (!empty($_GPC['keyword'])) {
			$condition .= ' and identity like :keyword or name like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'];
		}

		$list = pdo_fetchall('select * from ' . tablename('ewei_shop_plugin') . (' where 1 ' . $condition . ' order by displayorder asc'), $params);
		$total = count($list);
		include $this->template();
		exit();
	}
}

?>
