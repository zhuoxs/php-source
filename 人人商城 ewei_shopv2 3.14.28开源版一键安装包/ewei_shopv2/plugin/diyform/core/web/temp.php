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
		$page = empty($_GPC['page']) ? '' : $_GPC['page'];
		$pindex = max(1, intval($page));
		$psize = 20;
		$kw = empty($_GPC['keyword']) ? '' : $_GPC['keyword'];
		$items = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_diyform_type') . ' WHERE uniacid=:uniacid and title like :name order by id desc limit ' . ($pindex - 1) * $psize . ',' . $psize, array(':name' => '%' . $kw . '%', ':uniacid' => $_W['uniacid']));
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_diyform_type') . ' WHERE uniacid=:uniacid and title like :name order by id desc ', array(':uniacid' => $_W['uniacid'], ':name' => '%' . $kw . '%'));
		$pager = pagination2($total, $pindex, $psize);
		$set = $this->getSet();

		foreach ($items as $key => &$value) {
			$value['err'] = false;
			if ($set['user_diyform_open'] && $set['user_diyform'] == $value['id']) {
				$value['use_flag1'] = 1;
				$value['err'] = true;
			}

			if ($set['commission_diyform_open'] && $set['commission_diyform'] == $value['id']) {
				$value['use_flag2'] = 1;
				$value['err'] = true;
			}

			$value['datacount3'] = $this->model->getCountGoodsUsed($value['id']);

			if ($value['datacount3']) {
				$value['err'] = true;
			}
		}

		unset($value);
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
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_diyform_type') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$dfields = iunserializer($item['fields']);
			$set = $this->getSet();
			if ($set['user_diyform_open'] && $set['user_diyform'] == $id) {
				$use_flag1 = 1;
			}

			if ($set['commission_diyform_open'] && $set['commission_diyform'] == $id) {
				$use_flag2 = 1;
			}

			$datacount3 = $this->model->getCountGoodsUsed($id);
		}

		if ($_W['ispost']) {
			$data = $this->model->getInsertDataByAdmin();
			$insert = array('uniacid' => $_W['uniacid'], 'cate' => intval($_GPC['cate']), 'title' => trim($_GPC['tp_title']), 'fields' => iserializer($data), 'savedata' => intval($_GPC['savedata']));

			if (empty($id)) {
				pdo_insert('ewei_shop_diyform_type', $insert);
				$id = pdo_insertid();
				plog('diyform.temp.add', '新建模板 ID: ' . $id);
			}
			else {
				pdo_update('ewei_shop_diyform_type', $insert, array('id' => $id));
				plog('diyform.temp.edit', '编辑模板 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('diyform/temp')));
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$set = $this->getSet();
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$types = pdo_fetchall('SELECT id,title  FROM ' . tablename('ewei_shop_diyform_type') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);
		$errmsg = '';

		foreach ($types as $type) {
			$err = '';
			if ($set['user_diyform_open'] && $set['user_diyform'] == $id) {
				$err .= '用户资料正在使用该表单，请关闭后再进行删除。<br/>';
			}

			if ($set['commission_diyform_open'] && $set['commission_diyform'] == $id) {
				$err .= '分销商申请资料正在使用该表单，请关闭后再进行删除。<br/>';
			}

			$datacount3 = $this->model->getCountGoodsUsed($id);

			if ($datacount3) {
				$err .= '有' . $datacount3 . '种商品正在使用该表单，请关闭后再进行删除。<br/>';
			}

			if (!empty($err)) {
				$err = '模板【' . $type['title'] . '】不能删除: <br />' . $err . '<br />';
				$errmsg .= $err;
			}
			else {
				pdo_delete('ewei_shop_diyform_type', array('id' => $id));
				pdo_delete('ewei_shop_diyform_data', array('typeid' => $id));
				plog('diyform.temp.delete', '删除模板 ID: ' . $type['id']);
			}
		}

		if (!empty($errmsg)) {
			show_json(0, array('message' => $errmsg, 'url' => webUrl('diyform/temp')));
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
