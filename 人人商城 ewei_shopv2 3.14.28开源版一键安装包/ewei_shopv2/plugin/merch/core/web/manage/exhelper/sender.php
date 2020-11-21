<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Sender_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' uniacid = :uniacid and merchid=:merchid';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and ( sendername like :keyword or sendertel like :keyword or sendersign like :keyword or sendercode like :keyword or senderaddress like :keyword or sendercity like :keyword)';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$sql = 'SELECT * FROM ' . tablename('ewei_shop_exhelper_senduser') . (' where  1 and ' . $condition . ' ORDER BY isdefault desc,id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_exhelper_senduser') . (' where 1 and ' . $condition), $params);
		$pager = pagination($total, $pindex, $psize);
		include $this->template();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_exhelper_senduser') . ' where id=:id and uniacid=:uniacid and merchid=:merchid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
		}

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'merchid' => $merchid, 'sendername' => trim($_GPC['sendername']), 'sendertel' => trim($_GPC['sendertel']), 'sendersign' => trim($_GPC['sendersign']), 'sendercode' => trim($_GPC['sendercode']), 'senderaddress' => trim($_GPC['senderaddress']), 'sendercity' => trim($_GPC['sendercity']), 'isdefault' => intval($_GPC['isdefault']));

			if (!empty($id)) {
				pdo_update('ewei_shop_exhelper_senduser', $data, array('id' => $id));
				plog('merch.exhelper.sender.edit', '修改发件人模板 ID: ' . $id);
			}
			else {
				pdo_insert('ewei_shop_exhelper_senduser', $data);
				$id = pdo_insertid();
				plog('merch.exhelper.sender.add', '添加发件人模板 ID: ' . $id);
			}

			if (!empty($data['isdefault'])) {
				pdo_update('ewei_shop_exhelper_senduser', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'merchid' => $merchid));
				pdo_update('ewei_shop_exhelper_senduser', array('isdefault' => 1), array('id' => $id));
			}

			show_json(1, array('url' => merchUrl('exhelper/sender/edit', array('id' => $id))));
		}

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

	public function setdefault()
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,sendername FROM ' . tablename('ewei_shop_exhelper_senduser') . (' WHERE id = \'' . $id . '\' AND uniacid=') . $_W['uniacid'] . ' AND merchid=' . $merchid);

		if (!empty($item)) {
			pdo_update('ewei_shop_exhelper_senduser', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'merchid' => $merchid));
			pdo_update('ewei_shop_exhelper_senduser', array('isdefault' => 1), array('id' => $id));
			plog('merch.exhelper.sender.edit', '设置 默认发件人 ID: ' . $id . ' 发件人: ' . $item['sendername'] . ' ');
		}

		show_json(1);
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,sendername,sendertel,sendercity,senderaddress FROM ' . tablename('ewei_shop_exhelper_senduser') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid'] . ' AND merchid=' . $merchid);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_exhelper_senduser', array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $merchid));
			plog('merch.exhelper.sender.delete', '删除 发件人模板 ID: ' . $item['id'] . '  <br/>发件人: ' . $item['title'] . '/发件人电话: ' . $item['sendertel'] . '/发件城市: ' . $item['sendercity'] . '/发件地址: ' . $item['senderaddress'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}
}

?>
