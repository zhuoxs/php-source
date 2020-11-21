<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class pluginadv_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' ';
		$params = array();

		if ($_GPC['enabled'] != '') {
			$condition .= ' and enabled=' . intval($_GPC['enabled']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and advname  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_plugingrant_adv') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_system_plugingrant_adv') . (' WHERE 1 ' . $condition), $params);
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
			$data = array('advname' => trim($_GPC['advname']), 'link' => trim($_GPC['link']), 'enabled' => intval($_GPC['enabled']), 'displayorder' => intval($_GPC['displayorder']), 'thumb' => save_media($_GPC['thumb']));

			if (!empty($id)) {
				pdo_update('ewei_shop_system_plugingrant_adv', $data, array('id' => $id));
				plog('system.plugin.adv.edit', '修改幻灯片 ID: ' . $id);
			}
			else {
				pdo_insert('ewei_shop_system_plugingrant_adv', $data);
				$id = pdo_insertid();
				plog('system.plugin.pluginadv.add', '添加幻灯片 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('system/plugin/pluginadv')));
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_system_plugingrant_adv') . ' where id=:id limit 1', array(':id' => $id));
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

		$items = pdo_fetchall('SELECT id,advname FROM ' . tablename('ewei_shop_system_plugingrant_adv') . (' WHERE id in( ' . $id . ' ) '));

		foreach ($items as $item) {
			pdo_delete('ewei_shop_system_plugingrant_adv', array('id' => $item['id']));
			plog('system.plugin.pluginadv.delete', '删除幻灯片 ID: ' . $item['id'] . ' 标题: ' . $item['advname'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id,advname FROM ' . tablename('ewei_shop_system_plugingrant_adv') . (' WHERE id in( ' . $id . ' ) '));

		if (!empty($item)) {
			pdo_update('ewei_shop_system_plugingrant_adv', array('displayorder' => $displayorder), array('id' => $id));
			plog('system.plugin.pluginadv.edit', '修改幻灯片排序 ID: ' . $item['id'] . ' 标题: ' . $item['advname'] . ' 排序: ' . $displayorder . ' ');
		}

		show_json(1);
	}

	public function enabled()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,advname FROM ' . tablename('ewei_shop_system_plugingrant_adv') . (' WHERE id in( ' . $id . ' ) '));

		foreach ($items as $item) {
			pdo_update('ewei_shop_system_plugingrant_adv', array('enabled' => intval($_GPC['enabled'])), array('id' => $item['id']));
			plog('system.plugin.pluginadv.edit', '修改幻灯片状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['advname'] . '<br/>状态: ' . $_GPC['enabled'] == 1 ? '显示' : '隐藏');
		}

		show_json(1, array('url' => referer()));
	}
}

?>
