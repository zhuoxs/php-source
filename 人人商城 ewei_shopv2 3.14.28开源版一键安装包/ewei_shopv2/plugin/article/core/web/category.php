<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Category_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_article_category') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY displayorder desc ,id desc'));
		include $this->template();
	}

	public function save()
	{
		global $_W;
		global $_GPC;

		if (!empty($_GPC['cate'])) {
			foreach ($_GPC['cate'] as $id => $cate) {
				$data = array('category_name' => trim($cate['name']), 'displayorder' => intval($cate['displayorder']), 'isshow' => intval($cate['isshow']));
				if (!empty($id) && !empty($data['category_name'])) {
					pdo_update('ewei_shop_article_category', $data, array('id' => $id));
					plog('article.category.save', '修改文章分类 ID: ' . $id . ' 名称: ' . $data['category_name']);
				}
			}
		}

		if (!empty($_GPC['cate_new'])) {
			foreach ($_GPC['cate_new'] as $cate_new) {
				$cate_new = trim($cate_new);

				if (empty($cate_new)) {
					continue;
				}

				pdo_insert('ewei_shop_article_category', array('category_name' => $cate_new, 'uniacid' => $_W['uniacid']));
				$insert_id = pdo_insertid();
				plog('article.category.save', '添加分类 ID: ' . $insert_id . ' 名称: ' . $cate_new);
			}
		}

		plog('article.category.save', '批量修改分类');
		show_json(1);
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,category_name FROM ' . tablename('ewei_shop_article_category') . (' WHERE id = \'' . $id . '\' AND uniacid=') . $_W['uniacid'] . '');

		if (!empty($item)) {
			pdo_delete('ewei_shop_article_category', array('id' => $id));
			plog('article.category.delete', '删除分类 ID: ' . $id . ' 标题: ' . $item['name'] . ' ');
		}

		show_json(1);
	}
}

?>
