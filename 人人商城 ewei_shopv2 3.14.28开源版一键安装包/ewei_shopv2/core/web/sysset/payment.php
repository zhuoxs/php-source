<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Payment_EweiShopV2Page extends WebPage
{
	public $paytype = array('微信支付', '微信支付子商户', '借用微信支付', '借用微信支付子商户');
	public $paytypeali = array('支付宝2.0');

	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and title  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_payment') . (' WHERE 1 ' . $condition . '  ORDER BY id asc limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_payment') . (' WHERE 1 ' . $condition), $params);
		$pager = pagination($total, $pindex, $psize);
		$payment = $this->paytype;
		$paytypeali = $this->paytypeali;

		if (p('qpay')) {
			$payment[4] = '威富通(兼容全付通)';
		}

		$count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_payment') . ' WHERE  uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
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
			$data = array('uniacid' => $_W['uniacid'], 'paytype' => intval($_GPC['paytype']), 'type' => intval($_GPC['type']), 'alitype' => intval($_GPC['alitype']), 'title' => trim($_GPC['title']), 'appid' => trim($_GPC['appid']), 'mch_id' => trim($_GPC['mch_id']), 'apikey' => trim($_GPC['apikey']), 'sub_appid' => trim($_GPC['sub_appid']), 'sub_appsecret' => trim($_GPC['sub_appsecret']), 'sub_mch_id' => trim($_GPC['sub_mch_id']), 'qpay_signtype' => intval($_GPC['qpay_signtype']), 'app_qpay_public_key' => trim($_GPC['app_qpay_public_key']), 'app_qpay_private_key' => trim($_GPC['app_qpay_private_key']), 'is_raw' => intval($_GPC['is_raw']));
			$data['alipay_sec']['public_key'] = trim($_GPC['data']['app_alipay_public_key']);
			$data['alipay_sec']['private_key'] = trim($_GPC['data']['app_alipay_private_key']);
			$data['alipay_sec']['appid'] = trim($_GPC['data']['app_alipay_appid']);
			$data['alipay_sec']['alipay_sign_type'] = intval($_GPC['data']['alipay_sign_type']);
			$data['alipay_sec'] = iserializer($data['alipay_sec']);

			if ($_FILES['cert_file']['name']) {
				$data['cert_file'] = $this->upload_cert('cert_file');
			}

			if ($_FILES['key_file']['name']) {
				$data['key_file'] = $this->upload_cert('key_file');
			}

			if ($_FILES['root_file']['name']) {
				$data['root_file'] = $this->upload_cert('root_file');
			}

			if (empty($id)) {
				$data['createtime'] = time();
				pdo_insert('ewei_shop_payment', $data);
				$id = pdo_insertid();
				plog('sysset.payment.add', '添加支付信息一条 ID: ' . $id . ' 标题: ' . $data['title'] . ' ');
			}
			else {
				pdo_update('ewei_shop_payment', $data, array('id' => $id));
				plog('sysset.payment.edit', '编辑支付信息 ID: ' . $id . ' 标题: ' . $data['title'] . ' ');
			}

			show_json(1);
		}

		if (!empty($id)) {
			$data = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_payment') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		}

		$sec['alipay_sec'] = iunserializer($data['alipay_sec']);

		if (empty($sec['alipay_sec']['private_key'])) {
			$sec['alipay_sec']['private_key'] = '';
		}

		$payment = $this->paytype;
		$paytypeali = $this->paytypeali;

		if (p('qpay')) {
			$payment[4] = '威富通(兼容全付通)';
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_payment') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);
		$count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_payment') . ' WHERE  uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));

		if (count($items) < $count) {
			foreach ($items as $item) {
				pdo_delete('ewei_shop_payment', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('sysset.payment.delete', '删除支付模板 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' ');
			}
		}
		else {
			show_json(0, '请至少保留一个模版!');
		}

		show_json(1, array('url' => referer()));
	}

	protected function upload_cert($fileinput)
	{
		global $_W;
		$filename = $_FILES[$fileinput]['name'];
		$tmp_name = $_FILES[$fileinput]['tmp_name'];
		if (!empty($filename) && !empty($tmp_name)) {
			$ext = strtolower(substr($filename, strrpos($filename, '.')));

			if ($ext != '.pem') {
				$errinput = '';

				if ($fileinput == 'cert_file') {
					$errinput = 'CERT文件格式错误';
				}
				else if ($fileinput == 'key_file') {
					$errinput = 'KEY文件格式错误';
				}
				else {
					if ($fileinput == 'root_file') {
						$errinput = 'ROOT文件格式错误';
					}
				}

				show_json(0, $errinput . ',请重新上传!');
			}

			return file_get_contents($tmp_name);
		}

		return '';
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid';

		if (!empty($kwd)) {
			$condition .= ' AND `title` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_printer_template') . (' WHERE 1 ' . $condition . ' order by id asc'), $params);

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}
}

?>
