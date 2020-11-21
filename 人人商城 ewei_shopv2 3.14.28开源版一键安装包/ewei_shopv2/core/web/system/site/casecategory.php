<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Casecategory_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if (!empty($_GPC['catid'])) {
			foreach ($_GPC['catid'] as $k => $v) {
				$data = array('name' => trim($_GPC['catname'][$k]), 'displayorder' => $k, 'status' => intval($_GPC['status'][$k]));

				if (empty($v)) {
					pdo_insert('ewei_shop_system_casecategory', $data);
					$insert_id = pdo_insertid();
					plog('system.casecategory.add', '添加案例分类 ID: ' . $insert_id);
				}
				else {
					pdo_update('ewei_shop_system_casecategory', $data, array('id' => $v));
					plog('system.casecategory.edit', '修改案例分类 ID: ' . $v);
				}
			}

			plog('system.casecategory.edit', '批量修改案例分类');
			show_json(1);
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_casecategory') . ' ORDER BY displayorder asc');
		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,name FROM ' . tablename('ewei_shop_system_casecategory') . ' WHERE id = :id', array(':id' => $id));

		if (!empty($item)) {
			pdo_delete('ewei_shop_system_casecategory', array('id' => $id));
			plog('system.casecategory.delete', '删除案例分类 ID: ' . $id . ' 标题: ' . $item['name'] . ' ');
		}

		show_json(1);
	}
}

?>
