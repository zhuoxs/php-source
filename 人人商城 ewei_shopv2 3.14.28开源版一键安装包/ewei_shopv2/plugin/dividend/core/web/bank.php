<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'dividend/core/dividend_page_web.php';
class Bank_EweiShopV2Page extends DividendWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_dividend_bank') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC'), $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_dividend_bank') . (' WHERE 1 ' . $condition), $params);
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
			$_GPC['bankname'] = trim($_GPC['bankname']);
			$_GPC['status'] = intval($_GPC['status']);

			if (empty($_GPC['bankname'])) {
				show_json(0, '请输入银行名称');
			}

			$data = array();
			$data['uniacid'] = $_W['uniacid'];
			$data['bankname'] = $_GPC['bankname'];
			$data['status'] = $_GPC['status'];

			if (!empty($id)) {
				pdo_update('ewei_shop_dividend_bank', $data, array('id' => $id));
			}
			else {
				pdo_insert('ewei_shop_dividend_bank', $data);
				$id = pdo_insertid();
			}

			show_json(1);
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_dividend_bank') . (' WHERE id = \'' . $id . '\' and uniacid = \'' . $_W['uniacid'] . '\''));
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

		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_dividend_bank') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_dividend_bank', array('id' => $item['id']));
		}

		show_json(1, array('url' => referer()));
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_dividend_bank') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_dividend_bank', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
		}

		show_json(1, array('url' => referer()));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_dividend_bank') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (!empty($item)) {
			pdo_update('ewei_shop_dividend_bank', array('displayorder' => $displayorder), array('id' => $id));
		}

		show_json(1);
	}
}

?>
