<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Poster_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' AND uniacid=:uniacid ';
		$params = array(':uniacid' => $_W['uniacid']);
		$list_enabled = array();
		$list = array();
		$keyword = trim($_GPC['keyword']);

		if (empty($keyword)) {
			$list_enabled = pdo_fetchall('SELECT id, title, thumb FROM ' . tablename('ewei_shop_wxapp_poster') . ' WHERE uniacid=:uniacid AND status=1 ORDER BY displayorder ASC, id DESC', array(':uniacid' => $_W['uniacid']));
			$list_enabled = set_medias($list_enabled, 'thumb');
			$condition .= ' AND status=0 ';
		}
		else {
			$condition .= ' AND `title` LIKE :keyword';
			$params[':keyword'] = '%' . $keyword . '%';
		}

		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_wxapp_poster') . (' where 1 ' . $condition . ' '), $params);

		if (!empty($total)) {
			$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_wxapp_poster') . (' WHERE 1 ' . $condition . ' ORDER BY createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
			$list = set_medias($list, 'thumb');
		}

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

	private function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_wxapp_poster') . ' WHERE id=:id AND uniacid=:uniacid LIMIT 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

			if (empty($item)) {
				$this->message('海报不存在');
			}

			$item['data'] = iunserializer($item['data']);
		}

		if ($_W['ispost']) {
			$post = $_GPC['data'];
			if (empty($post) || !is_array($post)) {
				show_json(0, '数据为空');
			}

			if (empty($post['title'])) {
				show_json(0, '请填写海报名称');
			}

			if (empty($post['items'])) {
				show_json(0, '海报元素出错，请刷新重试');
			}

			$data = array('title' => $post['title'], 'thumb' => save_media($post['thumb']), 'bgimg' => save_media($post['bgimg']), 'data' => iserializer($post), 'lastedittime' => time());

			if (empty($item)) {
				$data['uniacid'] = $_W['uniacid'];
				$data['createtime'] = time();
				pdo_insert('ewei_shop_wxapp_poster', $data);
				$id = pdo_insertid();
			}
			else {
				pdo_update('ewei_shop_wxapp_poster', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
			}

			show_json(1, array('message' => '保存成功', 'id' => $id));
		}

		$json = json_encode(array('id' => $id, 'attachurl' => $_W['attachurl'], 'data' => !empty($item) && is_array($item['data']) ? $item['data'] : NULL));
		include $this->template();
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$status = intval($_GPC['status']);

		if (!empty($id)) {
			if (!empty($status)) {
				$total = pdo_fetchcolumn('SELECT count(id) FROM ' . tablename('ewei_shop_wxapp_poster') . ' WHERE uniacid=:uniacid AND status=1', array(':uniacid' => $_W['uniacid']));

				if (9 <= $total) {
					show_json(0, '最多启用9个海报');
				}
			}

			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_wxapp_poster') . ' WHERE id=:id AND uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));

			if (empty($item)) {
				show_json(0, '设置失败，海报不存在');
			}

			pdo_update('ewei_shop_wxapp_poster', array('status' => $status, 'displayorder' => empty($status) ? 0 : time()), array('id' => $id, 'uniacid' => $_W['uniacid']));
			plog('app.poster.status', '修改海报状态 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 状态: ' . $status == 1 ? '启用' : '禁用');
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

		$items = pdo_fetchall('SELECT id, title FROM ' . tablename('ewei_shop_wxapp_poster') . (' WHERE id in( ' . $id . ' ) AND status=0 AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']));

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_delete('ewei_shop_wxapp_poster', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('app.poster.delete', '删除海报 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' ');
			}
		}

		show_json(1);
	}

	public function clear()
	{
		global $_W;
		load()->func('file');
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/poster_wxapp/commission/' . $_W['uniacid']);
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/poster_wxapp/goods/' . $_W['uniacid']);
		plog('app.poster.clear', '清除海报缓存');
		show_json(1, array('url' => webUrl('app/poster')));
	}
}

?>
