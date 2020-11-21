<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Category_EweiShopV2Page extends ComWebPage
{
	public function __construct($_com = 'coupon')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		global $_W;
		global $_GPC;

		if (!empty($_GPC['catid'])) {
			foreach ($_GPC['catid'] as $k => $v) {
				$data = array('name' => trim($_GPC['catname'][$k]), 'displayorder' => $k, 'status' => intval($_GPC['status'][$k]), 'uniacid' => $_W['uniacid']);

				if (empty($v)) {
					pdo_insert('ewei_shop_coupon_category', $data);
					$insert_id = pdo_insertid();
					plog('sale.coupon.category.add', '添加分类 ID: ' . $insert_id);
				}
				else {
					pdo_update('ewei_shop_coupon_category', $data, array('id' => $v));
					plog('sale.coupon.category.edit', '修改分类 ID: ' . $v);
				}
			}

			plog('sale.coupon.category.edit', '批量修改分类');
			show_json(1);
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_coupon_category') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' and merchid=0 ORDER BY displayorder asc'));
		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,name FROM ' . tablename('ewei_shop_coupon_category') . (' WHERE id = \'' . $id . '\' and merchid=0 AND uniacid=') . $_W['uniacid'] . '');

		if (!empty($item)) {
			pdo_delete('ewei_shop_coupon_category', array('id' => $id));
			plog('sale.coupon.category.delete', '删除分类 ID: ' . $id . ' 标题: ' . $item['name'] . ' ');
		}

		show_json(1);
	}
}

?>
