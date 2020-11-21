<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Banner_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['enabled'] != '') {
			$condition .= ' and enabled=' . intval($_GPC['enabled']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and advname  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_live_adv') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_live_adv') . (' WHERE 1 ' . $condition), $params);
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
			$data = array('uniacid' => $_W['uniacid'], 'advname' => trim($_GPC['advname']), 'link' => trim($_GPC['link']), 'enabled' => intval($_GPC['enabled']), 'displayorder' => intval($_GPC['displayorder']), 'thumb' => save_media($_GPC['thumb']));

			if (!empty($id)) {
				pdo_update('ewei_shop_live_adv', $data, array('id' => $id));
				plog('live.banner.edit', '修改幻灯片 ID: ' . $id);
			}
			else {
				pdo_insert('ewei_shop_live_adv', $data);
				$id = pdo_insertid();
				plog('live.banner.add', '添加幻灯片 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('live/banner')));
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_live_adv') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
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

		$items = pdo_fetchall('SELECT id,advname FROM ' . tablename('ewei_shop_live_adv') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_live_adv', array('id' => $item['id']));
			plog('live.banner.deleted', '删除幻灯片<br/>ID: ' . $item['id'] . '<br/>幻灯片名称: ' . $item['advname']);
			if (function_exists('redis') && !is_error(redis())) {
				$this->model->deleteRedisTable($item['id']);
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function enabled()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$enabled = intval($_GPC['enabled']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,advname FROM ' . tablename('ewei_shop_live_adv') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_live_adv', array('enabled' => $enabled), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			plog('live.banner.edit', '修改幻灯片<br/>ID: ' . $item['id'] . '<br/>幻灯片名称: ' . $item['advname']);
		}

		show_json(1, array('url' => referer()));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$value = intval($_GPC['value']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,advname FROM ' . tablename('ewei_shop_live_adv') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_live_adv', array('displayorder' => $value), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			plog('live.banner.edit', '修改幻灯片<br/>ID: ' . $item['id'] . '<br/>幻灯片名称: ' . $item['advname']);
		}

		show_json(1, array('url' => referer()));
	}
}

?>
