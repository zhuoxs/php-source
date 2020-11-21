<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Category_EweiShopV2Page extends ComWebPage
{
	public function __construct($_com = 'virtual')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		global $_W;
		global $_GPC;

		if (!empty($_W['ispost'])) {
			ca('goods.virtual.category.edit');

			if (!empty($_GPC['catname']['new'])) {
				foreach ($_GPC['catname']['new'] as $k => $v) {
					$_GPC['catname']['new_' . $k] = $v;
				}
			}

			unset($_GPC['catname']['new']);

			foreach ($_GPC['catname'] as $id => $catname) {
				$catname = trim($catname);

				if (empty($catname)) {
					continue;
				}

				if (strpos($id, 'new_') !== false) {
					pdo_insert('ewei_shop_virtual_category', array('name' => $catname, 'uniacid' => $_W['uniacid'], 'merchid' => 0));
					$insert_id = pdo_insertid();
					plog('goods.virtual.category.add', '添加分类 ID: ' . $insert_id);
				}
				else {
					pdo_update('ewei_shop_virtual_category', array('name' => $catname), array('id' => $id, 'merchid' => 0));
					plog('goods.virtual.category.edit', '修改分类 ID: ' . $id);
				}
			}

			plog('goods.virtual.category.edit', '批量修改分类');
			show_json(1, array('url' => webUrl('goods/virtual/category')));
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_virtual_category') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' and merchid=0 ORDER BY id DESC'));
		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,name FROM ' . tablename('ewei_shop_virtual_category') . (' WHERE id = \'' . $id . '\' and merchid=0 AND uniacid=') . $_W['uniacid'] . '');

		if (empty($item)) {
			$this->message('抱歉，分类不存在或是已经被删除！', webUrl('goods/virtual/category', array('op' => 'display')), 'error');
		}

		pdo_delete('ewei_shop_virtual_category', array('id' => $id));
		plog('goods.virtual.category.delete', '删除分类 ID: ' . $id . ' 标题: ' . $item['name'] . ' ');
		show_json(1, array('url' => webUrl('goods/virtual/category', array('op' => 'display'))));
	}
}

?>
