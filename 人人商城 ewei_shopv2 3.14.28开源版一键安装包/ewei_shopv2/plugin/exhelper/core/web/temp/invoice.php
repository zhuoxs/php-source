<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Invoice_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$data = $this->model->tempData(2);
		extract($data);
		include $this->template('exhelper/temp/invoice/index');
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
		$type = 2;
		$express_list = m('express')->getExpressList();

		if (!empty($id)) {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_exhelper_express') . ' where id=:id and type=:type and uniacid=:uniacid and merchid=0 limit 1', array(':id' => $id, ':type' => $type, ':uniacid' => $_W['uniacid']));

			if (!empty($item)) {
				$elements = htmlspecialchars_decode($item['datas']);
				$elements = json_decode($elements, true);
			}
		}

		if ($_W['ispost']) {
			$id = intval($_GPC['id']);
			$data = array('isdefault' => intval($_GPC['isdefault']), 'expressname' => trim($_GPC['expressname']), 'expresscom' => trim($_GPC['expresscom']), 'express' => trim($_GPC['express']), 'height' => trim($_GPC['height']), 'datas' => trim($_GPC['datas']), 'bg' => trim($_GPC['bg']), 'type' => 2);

			if (!empty($id)) {
				pdo_update('ewei_shop_exhelper_express', $data, array('id' => $id, 'merchid' => 0));
				plog('exhelper.temp.invonice.edit', '修改发货单信息 ID: ' . $id);
			}
			else {
				$data['uniacid'] = $_W['uniacid'];
				$data['merchid'] = 0;
				pdo_insert('ewei_shop_exhelper_express', $data);
				$id = pdo_insertid();
				plog('exhelper.temp.invonice.add', '添加发货单模板 ID: ' . $id);
			}

			if (!empty($data['isdefault'])) {
				pdo_update('ewei_shop_exhelper_express', array('isdefault' => 0), array('type' => 2, 'uniacid' => $_W['uniacid'], 'merchid' => 0));
				pdo_update('ewei_shop_exhelper_express', array('isdefault' => 1), array('type' => 2, 'id' => $id, 'merchid' => 0));
			}

			show_json(1, array('url' => webUrl('exhelper/temp/invoice/edit', array('id' => $id))));
			exit();
		}

		include $this->template('exhelper/temp/invoice/post');
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$this->model->tempDelete($id, 2);
		show_json(1);
	}

	public function setdefault()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$this->model->setDefault($id, 2);
		show_json(1);
	}
}

?>
