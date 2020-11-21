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
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['status'] != '') {
			$condition .= ' and status=' . intval($_GPC['status']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and catename  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_cashier_category') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder desc, id DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_cashier_category') . (' WHERE 1 ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function add()
	{
		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'catename' => trim($_GPC['catename']), 'status' => intval($_GPC['status']), 'displayorder' => intval($_GPC['displayorder']));

			if (!empty($id)) {
				pdo_update('ewei_shop_cashier_category', $data, array('id' => $id));
				plog('cashier.category.edit', '修改收银台分类 ID: ' . $id);
			}
			else {
				$data['createtime'] = time();
				pdo_insert('ewei_shop_cashier_category', $data);
				$id = pdo_insertid();
				plog('cashier.category.add', '添加收银台分类 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('cashier/category')));
		}

		$item = $this->model->categoryOne($id);
		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,catename FROM ' . tablename('ewei_shop_cashier_category') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_cashier_category', array('id' => $item['id']));
			plog('cashier.category.delete', '删除收银台分类 ID: ' . $item['id'] . ' 标题: ' . $item['catename'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,catename FROM ' . tablename('ewei_shop_cashier_category') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_cashier_category', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('cashier.category.edit', '修改收银台分类状态<br/>ID: ' . $item['id'] . '<br/>分类名称: ' . $item['catename'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '显示' : '隐藏');
		}

		show_json(1, array('url' => referer()));
	}
}

?>
