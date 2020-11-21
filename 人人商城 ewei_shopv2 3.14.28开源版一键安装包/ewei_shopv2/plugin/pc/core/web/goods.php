<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class GoodsController extends PluginWebPage
{
	public function main()
	{
		global $_W;
		$info = pdo_fetchall('SELECT * from' . tablename('ewei_shop_pc_goods') . 'where uniacid=:uniacid', array('uniacid' => $_W['uniacid']));

		foreach ($info as &$val) {
			if ($val['goods_type'] == 0) {
				$val['goods_typetext'] = '自选产品';
			}
			else if ($val['goods_type'] == 1) {
				$val['goods_typetext'] = '商品分组';
			}
			else {
				if ($val['goods_type'] == 2) {
					$val['goods_typetext'] = '商品分类';
				}
			}
		}

		unset($val);
		include $this->template();
	}

	public function add()
	{
		global $_W;
		global $_GPC;
		$this->post();
	}

	public function edit()
	{
		global $_W;
		global $_GPC;
		$this->post();
	}

	public function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		session_start();
		$category = m('shop')->getFullCategory(true, true);
		$groups = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_goods_group') . ' WHERE uniacid=:uniacid  and  enabled =1 order by id desc', array('uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			$data = array();

			if (empty($_GPC['title'])) {
				show_json(0, '请填写商品组标题');
			}

			if (!isset($_GPC['goods_type'])) {
				show_json(0, '请选择商品类型');
			}

			if (empty($_GPC['import_image'])) {
				show_json(0, '请选择主推图片');
			}

			if ($_GPC['goods_type'] == 0) {
				$data['goods_info'] = implode($_GPC['goodsids'], ',');
				$data['goodsid_text'] = $_GPC['goodsid_text'];
				$data['goods_type'] = 0;
			}
			else if ($_GPC['goods_type'] == 1) {
				$data['goods_info'] = $_GPC['category'];
				$data['goods_type'] = 1;
			}
			else {
				if ($_GPC['goods_type'] == 2) {
					$data['goods_info'] = $_GPC['groups'];
					$data['goods_type'] = 2;
				}
			}

			$data['status'] = $_GPC['status'];
			$data['import_url'] = $_GPC['import_url'];
			$data['title'] = $_GPC['title'];
			$data['sort'] = $_GPC['sort'];
			$data['description'] = $_GPC['description'];
			$data['import_image'] = $_GPC['import_image'];
			$data['top_image'] = $_GPC['top_image'];
			$data['bottom_image'] = $_GPC['bottom_image'];
			$data['bottom_url'] = $_GPC['bottom_url'];
			$data['top_url'] = $_GPC['top_url'];
			$data['uniacid'] = $_W['uniacid'];
			$data['create_time'] = time();

			if (!empty($id)) {
				pdo_update('ewei_shop_pc_goods', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
				show_json(1, array('message' => '修改成功', 'url' => webUrl('pc/goods/edit', array('id' => $id))));
			}
			else {
				pdo_insert('ewei_shop_pc_goods', $data);
				$id = pdo_insertid();

				if ($id) {
					show_json(1, array('message' => '添加成功', 'url' => webUrl('pc/goods')));
				}
			}
		}

		$item = pdo_get('ewei_shop_pc_goods', array('id' => $id, 'uniacid' => $_W['uniacid']));

		if ($item['goods_type'] == 0) {
			$goods_info = explode(',', $item['goods_info']);
			$goods = pdo_fetchall('SELECT id,thumb,title FROM ' . tablename('ewei_shop_goods') . ' WHERE id IN (\'' . implode('\',\'', $goods_info) . ('\') AND uniacid=' . $_W['uniacid']));
		}
		else if ($item['goods_type'] == 1) {
			$cates = array($item['goods_info']);
		}
		else {
			if ($item['goods_type'] == 2) {
				$group = array($item['goods_info']);
			}
		}

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

		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_pc_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (empty($items)) {
			$items = array();
		}

		foreach ($items as $item) {
			pdo_delete('ewei_shop_pc_goods', array('id' => $item['id']));
		}

		show_json(1, array('url' => referer()));
	}
}

?>
