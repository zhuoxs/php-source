<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Temp_EweiShopV2Page extends MerchWebPage
{
	public function __construct($_com = 'virtual')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$page = empty($_GPC['page']) ? '' : $_GPC['page'];
		$pindex = max(1, intval($page));
		$psize = 12;
		$kw = empty($_GPC['keyword']) ? '' : $_GPC['keyword'];
		$items = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_virtual_type') . ' WHERE uniacid=:uniacid and merchid=:merchid and title like :name and recycled = 0 order by id desc limit ' . ($pindex - 1) * $psize . ',' . $psize, array(':name' => '%' . $kw . '%', ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_virtual_type') . ' WHERE uniacid=:uniacid and merchid=:merchid and title like :name and recycled = 0 order by id desc ', array(':uniacid' => $_W['uniacid'], ':name' => '%' . $kw . '%', ':merchid' => $_W['merchid']));
		$pager = pagination2($total, $pindex, $psize);
		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_virtual_category') . ' where uniacid=:uniacid and merchid=:merchid order by id desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']), 'id');
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
		$datacount = 0;

		if (!empty($id)) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
			$item['fields'] = iunserializer($item['fields']);
			$datacount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_virtual_data') . ' where typeid=:typeid and uniacid=:uniacid and merchid=:merchid and openid=\'\' limit 1', array(':typeid' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
		}

		if ($_W['ispost']) {
			$keywords = $_GPC['tp_kw'];
			$names = $_GPC['tp_name'];

			if (!empty($keywords)) {
				$data = array();

				foreach ($keywords as $key => $val) {
					$data[$keywords[$key]] = $names[$key];
				}
			}

			$insert = array('uniacid' => $_W['uniacid'], 'cate' => intval($_GPC['cate']), 'title' => trim($_GPC['tp_title']), 'fields' => iserializer($data), 'merchid' => $_W['merchid'], 'linktext' => trim($_GPC['tp_linktext']), 'linkurl' => trim($_GPC['tp_linkurl']));

			if (empty($id)) {
				pdo_insert('ewei_shop_virtual_type', $insert);
				$id = pdo_insertid();
				mplog('virtual.temp.edit', '添加模板 ID: ' . $id);
			}
			else {
				pdo_update('ewei_shop_virtual_type', $insert, array('id' => $id));
				mplog('virtual.temp.edit', '编辑模板 ID: ' . $id);
			}

			show_json(1, array('url' => merchUrl('goods/virtual/temp')));
		}

		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_virtual_category') . ' where uniacid=:uniacid and merchid=:merchid order by id desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']), 'id');
		include $this->template();
	}

	public function tpl()
	{
		global $_W;
		global $_GPC;
		$kw = $_GPC['kw'];
		include $this->template('goods/virtual/temp/tpl');
		exit();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$types = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_virtual_type') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid'] . ' and merchid=' . $_W['merchid']);

		foreach ($types as $type) {
			pdo_delete('ewei_shop_virtual_type', array('id' => $type['id']));
			pdo_delete('ewei_shop_virtual_data', array('typeid' => $type['id']));
			mplog('virtual.temp.delete', '删除模板 ID: ' . $type['id']);
		}

		show_json(1, array('url' => merchUrl('goods/virtual')));
	}

	public function recycled()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$types = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_virtual_type') . (' WHERE id in( ' . $id . ' ) and merchid=') . $_W['merchid'] . ' AND uniacid=' . $_W['uniacid']);

		foreach ($types as $type) {
			pdo_update('ewei_shop_virtual_type', array('recycled' => 1), array('id' => $type['id']));
			plog('virtual.temp.recycled', '模板放入回收站 ID: ' . $type['id']);
		}

		show_json(1, array('url' => merchUrl('goods/virtual')));
	}
}

?>
