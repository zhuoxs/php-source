<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/page_cashier.php';
class Qrcode_EweiShopV2Page extends CashierWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, $_GPC['page']);
		$psize = 20;
		$where = '';
		$params = array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']);

		if (!empty($_GPC['keyword'])) {
			$where = ' AND title LIKE :keyword OR goodstitle LIKE :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_cashier_qrcode') . (' WHERE uniacid=:uniacid AND cashierid=:cashierid ' . $where . ' ORDER BY id DESC'), $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_cashier_qrcode') . (' WHERE uniacid=:uniacid AND cashierid=:cashierid ' . $where . ' LIMIT 1'), $params);
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

	public function post()
	{
		global $_W;
		global $_GPC;
		$id = (int) $_GPC['id'];

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'cashierid' => $_W['cashierid'], 'title' => trim($_GPC['title']), 'goodstitle' => trim($_GPC['goodstitle']), 'money' => (double) $_GPC['money']);

			if ($id) {
				pdo_update('ewei_shop_cashier_qrcode', $data, array('id' => $id, 'uniacid' => $_W['uniacid'], 'cashierid' => $_W['cashierid']));
			}
			else {
				$data['createtime'] = time();
				pdo_insert('ewei_shop_cashier_qrcode', $data);
			}

			show_json(1);
		}

		if ($id) {
			$item = pdo_get('ewei_shop_cashier_qrcode', array('uniacid' => $_W['uniacid'], 'cashierid' => $_W['cashierid'], 'id' => $id));
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

		pdo_query('DELETE FROM ' . tablename('ewei_shop_cashier_qrcode') . (' WHERE id in(' . $id . ') AND cashierid=' . $_W['cashierid'] . ' AND uniacid=') . $_W['uniacid']);
		show_json(1);
	}

	public function viewqr()
	{
		global $_W;
		global $_GPC;
		$id = trim($_GPC['id']);

		if (empty($id)) {
			return false;
		}

		$url = mobileUrl('cashier/pay', array('cashierid' => $_W['cashierid'], 'id' => $id), true);
		$img = cashierUrl('qr', array('url' => $url));
		include $this->template();
	}
}

?>
