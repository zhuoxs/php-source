<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'seckill/core/seckill_page_web.php';
class Category_EweiShopV2Page extends SeckillWebPage
{
	public function __construct($_com = 'virtual')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		if (!empty($_GPC['catname']) || !empty($_GPC['catname_new'])) {
			ca('seckill.category.edit');

			if (is_array($_GPC['catname'])) {
				foreach ($_GPC['catname'] as $id => $catname) {
					$catname = trim($catname);

					if (empty($catname)) {
						continue;
					}

					pdo_update('ewei_shop_seckill_category', array('name' => $catname), array('id' => $id));
					plog('seckill.category.edit', '修改分类 ID: ' . $id);
				}
			}

			if (is_array($_GPC['catname_new'])) {
				foreach ($_GPC['catname_new'] as $id => $catname) {
					$catname = trim($catname);

					if (empty($catname)) {
						continue;
					}

					pdo_insert('ewei_shop_seckill_category', array('name' => $catname, 'uniacid' => $_W['uniacid']));
					$insert_id = pdo_insertid();
					plog('seckill.category.add', '添加分类 ID: ' . $insert_id);
				}
			}

			plog('seckill.category.edit', '批量修改分类');
			show_json(1, array('url' => webUrl('seckill/category')));
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_seckill_category') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\'  ORDER BY id DESC'));
		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,name FROM ' . tablename('ewei_shop_seckill_category') . (' WHERE id = \'' . $id . '\'  AND uniacid=') . $_W['uniacid'] . '');

		if (empty($item)) {
			$this->message('抱歉，分类不存在或是已经被删除！', webUrl('seckill/category', array('op' => 'display')), 'error');
		}

		pdo_delete('ewei_shop_seckill_category', array('id' => $id));
		plog('seckill.category.delete', '删除分类 ID: ' . $id . ' 标题: ' . $item['name'] . ' ');
		show_json(1, array('url' => webUrl('seckill/category', array('op' => 'display'))));
	}
}

?>
