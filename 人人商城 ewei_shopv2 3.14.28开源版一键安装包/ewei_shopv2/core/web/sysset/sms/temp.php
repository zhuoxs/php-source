<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Temp_EweiShopV2Page extends ComWebPage
{
	public function __construct($_com = 'sms')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$keyword = trim($_GPC['keyword']);
			$condition .= ' and name  like :keyword';
			$params[':keyword'] = '%' . $keyword . '%';
		}

		if (trim($_GPC['status']) != '') {
			$status = trim($_GPC['status']);
			$condition .= ' and status=' . $status;
		}

		if (!empty($_GPC['type'])) {
			$type = trim($_GPC['type']);
			$condition .= ' and `type`=:type';
			$params[':type'] = $type;
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_sms') . (' WHERE 1 ' . $condition . '  ORDER BY id desc limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_sms') . (' WHERE 1 ' . $condition), $params);
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

		if (!empty($_GPC['id'])) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_sms') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$item['data'] = iunserializer($item['data']);
		}

		$smsset = com('sms')->sms_set();

		if ($_W['ispost']) {
			$arr = array('name' => trim($_GPC['name']), 'template' => intval($_GPC['template']), 'smstplid' => trim($_GPC['smstplid']), 'smssign' => trim($_GPC['smssign']), 'content' => trim($_GPC['content']), 'status' => intval($_GPC['status']));
			if (empty($item) || empty($item['type'])) {
				$arr['type'] = trim($_GPC['type']);
			}

			$data = array();
			$data_temp = $_GPC['data_temp'];
			$data_shop = $_GPC['data_shop'];

			foreach ($data_temp as $i => $value) {
				$data[] = array('data_temp' => $value, 'data_shop' => $data_shop[$i]);
			}

			if (!empty($data) && is_array($data)) {
				$arr['data'] = iserializer($data);
			}

			if (empty($id)) {
				$arr['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_sms', $arr);
				$id = pdo_insertid();
				plog('sysset.sms.temp.add', '添加短信模板 ID: ' . $id . ' 标题: ' . $arr['title'] . ' ');
			}
			else {
				pdo_update('ewei_shop_sms', $arr, array('id' => $id, 'uniacid' => $_W['uniacid']));
				plog('sysset.sms.temp.edit', '编辑群发模板 ID: ' . $id . ' 标题: ' . $arr['title'] . ' ');
			}

			show_json(1, array('url' => webUrl('sysset/sms/temp/edit', array('id' => $id))));
		}

		include $this->template();
	}

	public function tpl()
	{
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

		if (empty($id)) {
			show_json(0, '参数错误，请刷新重试！');
		}

		$items = pdo_fetchall('SELECT id, name FROM ' . tablename('ewei_shop_sms') . (' WHERE id in( ' . $id . ' ) and uniacid=:uniacid '), array(':uniacid' => $_W['uniacid']));

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_delete('ewei_shop_sms', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('sysset.sms.temp.delete', '删除短信模板 id: ' . $item['id'] . '  名称:' . $item['name']);
			}
		}

		show_json(1);
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$status = intval($_GPC['status']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		if (empty($id)) {
			show_json(0, '参数错误，请刷新重试！');
		}

		$items = pdo_fetchall('SELECT id, name FROM ' . tablename('ewei_shop_sms') . (' WHERE id in( ' . $id . ' ) and uniacid=:uniacid '), array(':uniacid' => $_W['uniacid']));

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_update('ewei_shop_sms', array('status' => $status), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('sysset.sms.temp.edit', '更改短信模板状态 id: ' . $item['id'] . '  名称:' . $item['name'] . empty($status) ? '禁用' : '启用');
			}
		}

		show_json(1);
	}

	public function testsend()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$send = false;

		if (!empty($id)) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_sms') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $id, ':uniacid' => $_W['uniacid']));

			if (!empty($item)) {
				$item['data'] = iunserializer($item['data']);
				if (!empty($item['data']) && is_array($item['data'])) {
					$send = true;
				}
				else {
					$errmsg = '模板数据错误，请编辑后重试!';
				}
			}
			else {
				$errmsg = '模板不存在，请刷新重试!';
			}
		}
		else {
			$errmsg = '参数错误，请刷新重试!';
		}

		if ($_W['ispost'] && $send) {
			$mobile = trim($_GPC['mobile']);
			$postdata = $_GPC['data'];

			if (empty($mobile)) {
				show_json(0, '手机号不能为空!');
			}

			if (empty($postdata)) {
				show_json(0, '数据为空!');
			}

			if ($item['type'] == 'juhe' || $item['type'] == 'dayu' || $item['type'] == 'aliyun' || $item['type'] == 'aliyun_new') {
				$sms_data = array();

				foreach ($item['data'] as $i => $d) {
					$sms_data[$d['data_temp']] = $postdata[$i];
				}
			}
			else {
				if ($item['type'] == 'emay') {
					$sms_data = trim($postdata);
				}
			}

			$result = com('sms')->send($mobile, $item['id'], $sms_data, false);

			if (empty($result['status'])) {
				show_json(0, $result['message']);
			}
			else {
				show_json(1, '发送成功，请查收!');
			}
		}

		include $this->template();
	}
}

?>
