<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Nav_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid and merchid=:merchid';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);

		if ($_GPC['status'] != '') {
			$condition .= ' and status=' . intval($_GPC['status']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and navname  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_merch_nav') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_merch_nav') . (' WHERE 1 ' . $condition), $params);
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
			$data = array('uniacid' => $_W['uniacid'], 'navname' => trim($_GPC['navname']), 'url' => trim($_GPC['url']), 'status' => intval($_GPC['status']), 'displayorder' => intval($_GPC['displayorder']), 'icon' => save_media($_GPC['icon']), 'merchid' => $_W['merchid']);

			if (!empty($id)) {
				pdo_update('ewei_shop_merch_nav', $data, array('id' => $id));
				mplog('shop.nav.edit', '修改首页导航 ID: ' . $id);
			}
			else {
				pdo_insert('ewei_shop_merch_nav', $data);
				$id = pdo_insertid();
				mplog('shop.nav.add', '添加首页导航 ID: ' . $id);
			}

			show_json(1, array('url' => merchUrl('shop/nav')));
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_merch_nav') . ' where id=:id and uniacid=:uniacid and merchid=:merchid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
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

		$items = pdo_fetchall('SELECT id,navname FROM ' . tablename('ewei_shop_merch_nav') . (' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid'] . ' and merchid=' . $_W['merchid']));

		foreach ($items as $item) {
			pdo_delete('ewei_shop_merch_nav', array('id' => $item['id']));
			mplog('shop.nav.delete', '删除首页导航 ID: ' . $item['id'] . ' 标题: ' . $item['navname'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id,navname FROM ' . tablename('ewei_shop_merch_nav') . (' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid'] . ' and merchid=' . $_W['merchid']));

		if (!empty($item)) {
			pdo_update('ewei_shop_merch_nav', array('displayorder' => $displayorder), array('id' => $id));
			mplog('shop.nav.edit', '修改首页导航排序 ID: ' . $item['id'] . ' 标题: ' . $item['navname'] . ' 排序: ' . $displayorder . ' ');
		}

		show_json(1);
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,navname FROM ' . tablename('ewei_shop_merch_nav') . (' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid'] . ' and merchid=' . $_W['merchid']));

		foreach ($items as $item) {
			pdo_update('ewei_shop_merch_nav', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			mplog('shop.nav.edit', '修改首页导航状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['navname'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '显示' : '隐藏');
		}

		show_json(1, array('url' => referer()));
	}
}

?>
