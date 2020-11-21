<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Link_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if (!empty($_GPC['id'])) {
			foreach ($_GPC['id'] as $k => $v) {
				$data = array('name' => trim($_GPC['name'][$k]), 'url' => trim($_GPC['url'][$k]), 'thumb' => save_media($_GPC['thumb'][$k]), 'displayorder' => $k, 'status' => intval($_GPC['status'][$k]));
				if (empty($v) && !empty($data['name'])) {
					pdo_insert('ewei_shop_system_link', $data);
					$insert_id = pdo_insertid();
					plog('system.link.add', '添加分类 ID: ' . $insert_id);
				}
				else {
					pdo_update('ewei_shop_system_link', $data, array('id' => $v));
					plog('system.link.edit', '修改分类 ID: ' . $v);
				}
			}

			plog('system.category.edit', '批量修改分类');
			show_json(1);
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_link') . ' ORDER BY displayorder asc');
		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,name FROM ' . tablename('ewei_shop_system_link') . ' WHERE id = :id', array(':id' => $id));

		if (!empty($item)) {
			pdo_delete('ewei_shop_system_link', array('id' => $id));
			plog('system.link.delete', '删除分类 ID: ' . $id . ' 标题: ' . $item['name'] . ' ');
		}

		show_json(1);
	}
}

?>
