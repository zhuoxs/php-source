<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Group_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid and merchid=:merchid ';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and `name`  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_goods_group') . (' WHERE 1 ' . $condition . '  ORDER BY id DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_goods_group') . (' WHERE 1 ' . $condition), $params);
		$pager = pagination($total, $pindex, $psize);
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
		$merchid = $_W['merchid'];
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods_group') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $merchid));

			if (!empty($item['goodsids'])) {
				$item['goodsids'] = trim($item['goodsids'], ',');
				$goods = pdo_fetchall('select id,title,thumb from ' . tablename('ewei_shop_goods') . (' where id in (' . $item['goodsids'] . ') and status=1 and deleted=0 and uniacid=' . $_W['uniacid'] . ' and merchid=' . $merchid . ' order by instr(\'' . $item['goodsids'] . '\',id)'));
			}
		}

		if ($_W['ispost']) {
			$groupname = trim($_GPC['name']);
			$goodsids = $_GPC['goodsids'];
			$enabled = intval($_GPC['enabled']);

			if (empty($groupname)) {
				show_json(0, '商品组名称不能为空');
			}

			if (empty($goodsids)) {
				show_json(0, '商品组中商品不能为空');
			}

			$data = array('name' => $groupname, 'merchid' => $merchid, 'goodsids' => implode(',', $goodsids), 'enabled' => $enabled);

			if (!empty($item)) {
				pdo_update('ewei_shop_goods_group', $data, array('id' => $item['id']));
				plog('goods.group.edit', '修改商品组 ID: ' . $id);
			}
			else {
				$data['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_goods_group', $data);
				$id = pdo_insertid();
				plog('goods.group.add', '添加商品组 ID: ' . $id);
			}

			show_json(1, array('url' => merchUrl('goods/group/edit', array('id' => $id))));
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,name FROM ' . tablename('ewei_shop_goods_group') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid'] . ' AND merchid=' . $merchid);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_goods_group', array('id' => $item['id']));
			plog('goods.group.delete', '删除商品组 ID: ' . $item['id'] . ' 标题: ' . $item['name'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function enabled()
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,name FROM ' . tablename('ewei_shop_goods_group') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid'] . ' AND merchid=' . $merchid);

		foreach ($items as $item) {
			pdo_update('ewei_shop_goods_group', array('enabled' => intval($_GPC['enabled'])), array('id' => $item['id']));
			plog('goods.group.edit', '修改商品组状态<br/>ID: ' . $item['id'] . '<br/>商品组名称: ' . $item['name'] . '<br/>状态: ' . $_GPC['enabled'] == 1 ? '启用' : '禁用');
		}

		show_json(1);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$merchid = $_W['merchid'];
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$params[':merchid'] = $merchid;
		$condition = ' and enabled=1 and uniacid=:uniacid and merchid=:merchid';

		if (!empty($kwd)) {
			$condition .= ' AND `name` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_goods_group') . (' WHERE 1 ' . $condition . ' order by id desc'), $params);

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}
}

?>
