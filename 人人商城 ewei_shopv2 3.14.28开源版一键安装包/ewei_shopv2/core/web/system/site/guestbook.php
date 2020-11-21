<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Guestbook_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if (!empty($_GPC['catid'])) {
			foreach ($_GPC['catid'] as $k => $v) {
				$data = array('name' => trim($_GPC['catname'][$k]), 'displayorder' => $k, 'status' => intval($_GPC['status'][$k]));

				if (empty($v)) {
					pdo_insert('ewei_shop_system_guestbook', $data);
					$insert_id = pdo_insertid();
					plog('system.guestbook.add', '添加分类 ID: ' . $insert_id);
				}
				else {
					pdo_update('ewei_shop_system_guestbook', $data, array('id' => $v));
					plog('system.guestbook.edit', '修改分类 ID: ' . $v);
				}
			}

			plog('system.guestbook.edit', '批量修改分类');
			show_json(1);
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_guestbook') . ' ORDER BY id desc');
		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,title FROM ' . tablename('ewei_shop_system_guestbook') . ' WHERE id = :id', array(':id' => $id));

		if (!empty($item)) {
			pdo_delete('ewei_shop_system_guestbook', array('id' => $id));
			plog('system.guestbook.delete', '删除留言 ID: ' . $id . ' 标题: ' . $item['title'] . ' ');
		}

		show_json(1);
	}

	public function view()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_system_guestbook') . ' WHERE id = :id', array(':id' => $id));
		include $this->template();
	}
}

?>
