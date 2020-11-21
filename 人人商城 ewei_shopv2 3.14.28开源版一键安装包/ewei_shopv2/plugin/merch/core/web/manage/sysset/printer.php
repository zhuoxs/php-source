<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Printer_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'uniacid=:uniacid AND merchid=:merchid';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and title  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_printer_template') . (' WHERE ' . $condition . '  ORDER BY id asc limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_member_printer_template') . (' WHERE ' . $condition), $params);
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

		if (!empty($id)) {
			$list = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_printer_template') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
			$print_data = json_decode($list['print_data'], true);
			$keys = isset($print_data['key']) ? $print_data['key'] : array();
			$values = isset($print_data['value']) ? $print_data['value'] : array();
		}

		$kw = 0;

		if (isset($print_data['key'])) {
			$kw = count($print_data['key']);
		}

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid'], 'type' => intval($_GPC['type']), 'title' => trim($_GPC['title']), 'print_title' => trim($_GPC['print_title']), 'print_style' => trim($_GPC['print_style']), 'code' => intval($_GPC['code']), 'qrcode' => trim($_GPC['qrcode']), 'goodssn' => trim($_GPC['goodssn']), 'productsn' => trim($_GPC['productsn']));
			$data['print_data'] = json_encode(array('key' => is_array($_GPC['key']) ? array_values($_GPC['key']) : array(), 'value' => is_array($_GPC['value']) ? array_values($_GPC['value']) : array()));

			if (empty($id)) {
				$data['createtime'] = time();
				pdo_insert('ewei_shop_member_printer_template', $data);
				$id = pdo_insertid();
				mplog('sysset.printer.add', '添加打印机模板 ID: ' . $id . ' 标题: ' . $data['title'] . ' ');
			}
			else {
				pdo_update('ewei_shop_member_printer_template', $data, array('id' => $id));
				mplog('sysset.printer.edit', '编辑打印机模板 ID: ' . $id . ' 标题: ' . $data['title'] . ' ');
			}

			show_json(1, array('url' => webUrl('sysset/printer')));
		}

		$style_list = com_run('printer::style_list');
		$style_list = is_array($style_list) ? $style_list : array();
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_printer_template') . (' WHERE id in( ' . $id . ' ) AND uniacid=:uniacid AND merchid=:merchid'), array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

		foreach ($items as $item) {
			pdo_delete('ewei_shop_member_printer_template', array('id' => $id));
			mplog('sysset.printer.delete', '删除群发模板 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$condition = 'uniacid=:uniacid AND merchid=:merchid';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);

		if (!empty($kwd)) {
			$condition .= ' AND `title` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_printer_template') . (' WHERE ' . $condition . ' order by id asc'), $params);

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}

	public function tpl()
	{
		global $_W;
		global $_GPC;
		$kw = intval($_GPC['kw']);
		$style_list = com_run('printer::style_list');
		$style_list = is_array($style_list) ? $style_list : array();
		include $this->template();
	}

	public function printer_list()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'uniacid=:uniacid AND merchid=:merchid';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and title  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_printer') . (' WHERE ' . $condition . '  ORDER BY id asc limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_member_printer') . (' WHERE ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		$printer = com_run('printer::printer_list');
		include $this->template();
	}

	public function printer_add()
	{
		$this->printer_post();
	}

	public function printer_edit()
	{
		$this->printer_post();
	}

	protected function printer_post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$list = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_printer') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
			$print_data = json_decode($list['print_data'], true);
			$printer_365 = isset($print_data['printer_365']) ? $print_data['printer_365'] : array();
			$printer_feie = isset($print_data['printer_feie']) ? $print_data['printer_feie'] : array();
			$printer_yilianyun = isset($print_data['printer_yilianyun']) ? $print_data['printer_yilianyun'] : array();
			$printer_yilianyun_new = isset($print_data['printer_yilianyun_new']) ? $print_data['printer_yilianyun_new'] : array();
			$printer_365_s1 = isset($print_data['printer_365_s1']) ? $print_data['printer_365_s1'] : array();
			$printer_yilianyun_auth2 = isset($print_data['printer_yilianyun_auth2']) ? $print_data['printer_yilianyun_auth2'] : array();
			$printer_feie_new = isset($print_data['printer_feie_new']) ? $print_data['printer_feie_new'] : array();
		}

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid'], 'type' => intval($_GPC['type']), 'title' => trim($_GPC['title']));
			$data['print_data'] = json_encode(array('printer_365' => is_array($_GPC['printer_365']) ? $_GPC['printer_365'] : array(), 'printer_feie' => is_array($_GPC['printer_feie']) ? $_GPC['printer_feie'] : array(), 'printer_yilianyun' => is_array($_GPC['printer_yilianyun']) ? $_GPC['printer_yilianyun'] : array(), 'printer_yilianyun_new' => is_array($_GPC['printer_yilianyun_new']) ? $_GPC['printer_yilianyun_new'] : array(), 'printer_365_s1' => is_array($_GPC['printer_365_s1']) ? $_GPC['printer_365_s1'] : array(), 'printer_feie_new' => is_array($_GPC['printer_feie_new']) ? $_GPC['printer_feie_new'] : array(), 'printer_yilianyun_auth2' => is_array($_GPC['printer_yilianyun_auth2']) ? $_GPC['printer_yilianyun_auth2'] : array()));

			if ($data['type'] == 6) {
				$client_id = trim($_GPC['printer_yilianyun_auth2']['partner']);
				$client_secret = trim($_GPC['printer_yilianyun_auth2']['apikey']);
				$machine_code = trim($_GPC['printer_yilianyun_auth2']['machine_code']);
				$msign = trim($_GPC['printer_yilianyun_auth2']['msign']);
				$res = com_run('printer::bindYilianyunPrinter', $client_id, $client_secret, $machine_code, $msign, $data['merchid']);

				if ($res['error']) {
					show_json(0, $res['error_description']);
				}
			}

			if (empty($id)) {
				$data['createtime'] = time();
				pdo_insert('ewei_shop_member_printer', $data);
				$id = pdo_insertid();
				mplog('sysset.printer.printer_add', '添加打印机 ID: ' . $id . ' 标题: ' . $data['title'] . ' ');
			}
			else {
				pdo_update('ewei_shop_member_printer', $data, array('id' => $id));
				mplog('sysset.printer.printer_edit', '编辑打印机 ID: ' . $id . ' 标题: ' . $data['title'] . ' ');
			}

			show_json(1, array('url' => webUrl('sysset/printer/printer_list')));
		}

		$printer = com_run('printer::printer_list');
		$printer = is_array($printer) ? $printer : array();
		include $this->template('sysset/printer/printer_post');
	}

	public function printer_delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_printer') . (' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid'] . ' AND merchid=' . $_W['merchid']));

		foreach ($items as $item) {
			pdo_delete('ewei_shop_member_printer', array('id' => $id));
			plog('sysset.printer.printer_delete', '删除打印机 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function printer_query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$params[':merchid'] = $_W['merchid'];
		$condition = 'uniacid=:uniacid and merchid=:merchid';

		if (!empty($kwd)) {
			$condition .= ' AND `title` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_printer') . (' WHERE ' . $condition . ' order by id asc'), $params);

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}

	public function printer_tpl()
	{
		global $_W;
		global $_GPC;
		$kw = intval($_GPC['kw']);
		include $this->template();
	}

	public function set()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = array();
			$data['order_printer'] = is_array($_GPC['order_printer']) ? implode(',', $_GPC['order_printer']) : '';
			$data['order_template'] = intval($_GPC['order_template']);
			$data['ordertype'] = is_array($_GPC['ordertype']) ? implode(',', $_GPC['ordertype']) : '';
			$this->updateSet(array('printer' => $data));
			mplog('sysset.printer.set', '修改系统设置-商城打印机设置');
			show_json(1);
		}

		$data = com_run('printer::getPrinterSet', $_W['merchid']);
		$order_printer_array = $data['order_printer'];
		$ordertype = $data['ordertype'];
		$order_template = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_printer_template') . ' WHERE uniacid=:uniacid AND merchid=:merchid', array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
		include $this->template();
	}
}

?>
