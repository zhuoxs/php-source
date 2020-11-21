<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Temp_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$globalData = $this->model->globalData();
		extract($globalData);
		$page = ((empty($_GPC['page']) ? '' : $_GPC['page']));
		$pindex = max(1, intval($page));
		$psize = 20;
		$kw = ((empty($_GPC['keyword']) ? '' : $_GPC['keyword']));
		$items = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_universalform_type') . ' WHERE uniacid=:uniacid and title like :name order by id desc limit ' . (($pindex - 1) * $psize) . ',' . $psize, array(':name' => '%' . $kw . '%', ':uniacid' => $_W['uniacid']));
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_universalform_type') . ' WHERE uniacid=:uniacid and title like :name order by id desc ', array(':uniacid' => $_W['uniacid'], ':name' => '%' . $kw . '%'));
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
		$globalData = $this->model->globalData();
		extract($globalData);
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_universalform_type') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$dfields = iunserializer($item['fields']);
		}


		if ($_W['ispost']) {
			$data = $this->model->getInsertDataByAdmin();
			$insert = array('uniacid' => $_W['uniacid'], 'cate' => intval($_GPC['cate']), 'title' => trim($_GPC['tp_title']), 'adpic' => trim($_GPC['adpic']),'adurl' => trim($_GPC['adurl']),'fields' => iserializer($data));

			if (empty($id)) {
				pdo_insert('ewei_shop_universalform_type', $insert);
				$id = pdo_insertid();
				plog('universalform.temp.add', '新建模板 ID: ' . $id);
			}
			 else {
				pdo_update('ewei_shop_universalform_type', $insert, array('id' => $id));
				plog('universalform.temp.edit', '编辑模板 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('universalform/temp')));
		}


		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = ((is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0));
		}


		$types = pdo_fetchall('SELECT id,title  FROM ' . tablename('ewei_shop_universalform_type') . ' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid']);
		$errmsg = '';

		foreach ($types as $type ) {
			pdo_delete('ewei_shop_universalform_type', array('id' => $id));
			pdo_delete('ewei_shop_universalform_data', array('typeid' => $id));
			plog('universalform.temp.delete', '删除模板 ID: ' . $type['id']);
		}

		show_json(1, array('url' => webUrl('virtual/temp')));
	}

	public function tpl()
	{
		global $_W;
		global $_GPC;
		$globalData = $this->model->globalData();
		extract($globalData);
		$addt = $_GPC['addt'];
		$kw = $_GPC['kw'];
		$flag = intval($_GPC['flag']);
		$data_type = $_GPC['data_type'];
		$tmp_key = $kw;
		include $this->template();
	}
}


?>