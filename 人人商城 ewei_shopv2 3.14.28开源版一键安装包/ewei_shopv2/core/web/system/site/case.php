<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Case_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = '';
		$params = array();

		if ($_GPC['status'] != '') {
			$condition .= ' and status=' . intval($_GPC['status']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and title like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_case') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_system_case') . (' WHERE 1 ' . $condition), $params);
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
			empty($_GPC['title']) && show_json(0, array('message' => '合作伙伴名称不能为空', 'url' => referer()));
			$data = array('title' => trim($_GPC['title']), 'thumb' => save_media($_GPC['thumb']), 'qr' => save_media($_GPC['qr']), 'displayorder' => intval($_GPC['displayorder']), 'status' => intval($_GPC['status']), 'cate' => intval($_GPC['cate']), 'description' => trim($_GPC['description']));

			if (!empty($id)) {
				pdo_update('ewei_shop_system_case', $data, array('id' => $id));
				plog('system.site.case.edit', '修改 ID: ' . $id);
			}
			else {
				pdo_insert('ewei_shop_system_case', $data);
				$id = pdo_insertid();
				plog('system.site.case.add', '添加 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('system/site/case/edit', array('id' => $id))));
		}

		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_system_casecategory'), array(), 'id');
		$item = pdo_fetch('select * from ' . tablename('ewei_shop_system_case') . ' where id=:id limit 1', array(':id' => $id));
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_system_case') . (' WHERE id in( ' . $id . ' )'));

		foreach ($items as $item) {
			pdo_delete('ewei_shop_system_case', array('id' => $item['id']));
			plog('system.site.case.delete', '删除 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_system_case') . (' WHERE id in( ' . $id . ' )'));

		if (!empty($item)) {
			pdo_update('ewei_shop_system_case', array('displayorder' => $displayorder), array('id' => $id));
			plog('system.site.case.delete', '修改排序 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 排序: ' . $displayorder . ' ');
		}

		show_json(1);
	}

	public function status()
	{
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_system_case') . (' WHERE id in( ' . $id . ' )'));

		foreach ($items as $item) {
			pdo_update('ewei_shop_system_case', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('system.site.csae.edit', '修改幻灯片状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['title'] . '<br/>状态: ' . $_GPC['enabled'] == 1 ? '显示' : '隐藏');
		}

		show_json(1, array('url' => referer()));
	}
}

?>
