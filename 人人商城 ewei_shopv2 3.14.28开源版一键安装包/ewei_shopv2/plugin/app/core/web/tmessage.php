<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Tmessage_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if (empty($_W['shopversion'])) {
			$this->message('请使用新版本访问');
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['status'] != '') {
			$condition .= ' and status=' . intval($_GPC['status']);
		}

		if (!empty($_GPC['keyword'])) {
			$keyword = trim($_GPC['keyword']);
			$condition .= ' and name  like :keyword';
			$params[':keyword'] = '%' . $keyword . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_wxapp_tmessage') . (' WHERE 1 ' . $condition . '  ORDER BY id DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_wxapp_tmessage') . (' WHERE 1 ' . $condition), $params);
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

		if (!empty($id)) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_wxapp_tmessage') . 'WHERE id=:id AND uniacid=:uniacid LIMIT 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

			if (!empty($item)) {
				$datas = iunserializer($item['datas']);
			}
		}

		if (empty($datas)) {
			$datas = array(
				array()
			);
		}

		if ($_W['ispost']) {
			$arr = array('name' => trim($_GPC['name']), 'templateid' => trim($_GPC['templateid']), 'status' => intval($_GPC['status']), 'emphasis_keyword' => $_GPC['tpl_bigkey'] != '' ? intval($_GPC['tpl_bigkey']) : -1);
			$keys = $_GPC['tpl_key'];
			$values = $_GPC['tpl_value'];
			$colors = $_GPC['tpl_color'];
			if (!is_array($keys) || !is_array($values) || empty($keys) || empty($values)) {
				show_json(0, '至少添加一条消息内容');
			}

			$colors = !empty($colors) ? $colors : array();
			$datas = array();

			foreach ($keys as $index => $key) {
				$datas[] = array('key' => trim($key), 'value' => trim($values[$index]), 'color' => trim($colors[$index]));
			}

			$arr['datas'] = iserializer($datas);

			if (empty($item)) {
				$arr['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_wxapp_tmessage', $arr);
				$id = pdo_insertid();
			}
			else {
				pdo_update('ewei_shop_wxapp_tmessage', $arr, array('id' => $id, 'uniacid' => $_W['uniacid']));
			}

			show_json(1, array('url' => webUrl('app/tmessage/edit', array('id' => $id))));
		}

		include $this->template();
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id, `name` FROM ' . tablename('ewei_shop_wxapp_tmessage') . (' WHERE id in(' . $id . ') AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']));

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_update('ewei_shop_wxapp_tmessage', array('status' => intval($_GPC['status'])), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('app.tmessage.status', '更新消息模板状态 ID: ' . $item['id'] . ' 模板名称: ' . $item['name'] . ' 状态:' . $_GPC['status'] == 1 ? '启用' : '禁用');
			}
		}

		show_json(1);
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,`name` FROM ' . tablename('ewei_shop_wxapp_tmessage') . (' WHERE id in( ' . $id . ' ) AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']));

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_delete('ewei_shop_wxapp_tmessage', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('app.tmessage.delete', '删除消息模板 ID: ' . $item['id'] . ' 模板名称: ' . $item['name'] . ' ');
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function tpl()
	{
		global $_GPC;
		$new = intval($_GPC['new']);
		include $this->template();
	}
}

?>
