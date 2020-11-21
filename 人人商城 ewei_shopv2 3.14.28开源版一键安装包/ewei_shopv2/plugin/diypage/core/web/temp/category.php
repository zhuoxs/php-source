<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Category_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and merch=:merch and uniacid=:uniacid ';
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= ' and name like \'%' . $keyword . '%\' ';
		}

		$list = pdo_fetchall('select id, `name` from ' . tablename('ewei_shop_diypage_template_category') . ' where 1 ' . $condition . ' order by id desc limit ' . ($pindex - 1) * $psize . ',' . $psize, array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_diypage_template_category') . ' where merch=:merch and uniacid=:uniacid ', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$id = intval($_GPC['id']);

			if (empty($id)) {
				show_json(0, '参数错误，请刷新重试！');
			}

			$item = pdo_fetch('SELECT id, name, uniacid FROM ' . tablename('ewei_shop_diypage_template_category') . ' WHERE id=:id and merch=:merch and uniacid=:uniacid ', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid'], ':id' => $id));

			if (!empty($item)) {
				pdo_delete('ewei_shop_diypage_template_category', array('id' => $id, 'merch' => intval($_W['merchid'])));
				plog('diypage.temp.category.delete', '删除模板分类 名称:' . $item['name']);
			}

			show_json(1);
		}
	}

	public function add()
	{
		global $_W;
		global $_GPC;
		$name = trim($_GPC['name']);

		if (empty($name)) {
			show_json(0, '分类名称为空！');
		}

		pdo_insert('ewei_shop_diypage_template_category', array('name' => $name, 'uniacid' => $_W['uniacid'], 'merch' => intval($_W['merchid'])));
		$id = pdo_insertid();
		plog('diypage.temp.category.add', '添加模板分类 id:' . $id . ' 名称:' . $name);
		show_json(1);
	}

	public function edit()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$name = trim($_GPC['value']);
		$item = pdo_fetch('SELECT id, name, uniacid FROM ' . tablename('ewei_shop_diypage_template_category') . ' WHERE id=:id and merch=:merch and uniacid=:uniacid ', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid'], ':id' => $id));

		if (!empty($item)) {
			pdo_update('ewei_shop_diypage_template_category', array('name' => $name), array('id' => $id, 'merch' => intval($_W['merchid'])));
			plog('diypage.temp.category.edit', '编辑模板分类 id:' . $id . ' 原名称:' . $item['name'] . ' 新名称:' . $name);
			show_json(1);
		}
		else {
			show_json(0, '分类不存在,请刷新页面重试！');
		}
	}
}

?>
