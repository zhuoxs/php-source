<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Group_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['status'] != '') {
			$condition .= ' and status=' . intval($_GPC['status']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and groupname  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_merch_group') . (' WHERE 1 ' . $condition . '  ORDER BY isdefault desc, id DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_merch_group') . (' WHERE 1 ' . $condition), $params);
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

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'groupname' => trim($_GPC['groupname']), 'status' => intval($_GPC['status']), 'isdefault' => intval($_GPC['isdefault']), 'goodschecked' => intval($_GPC['goodschecked']), 'commissionchecked' => intval($_GPC['commissionchecked']), 'changepricechecked' => intval($_GPC['changepricechecked']), 'finishchecked' => intval($_GPC['finishchecked']));

			if ($data['isdefault'] == 1) {
				pdo_update('ewei_shop_merch_group', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'isdefault' => 1));
			}

			if (!empty($id)) {
				pdo_update('ewei_shop_merch_group', $data, array('id' => $id));
				plog('merch.group.edit', '修改商户分组 ID: ' . $id);
			}
			else {
				$data['createtime'] = time();
				pdo_insert('ewei_shop_merch_group', $data);
				$id = pdo_insertid();
				plog('merch.group.add', '添加商户分组 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('merch/group')));
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_merch_group') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
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

		$items = pdo_fetchall('SELECT id,groupname FROM ' . tablename('ewei_shop_merch_group') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_merch_group', array('id' => $item['id']));
			plog('merch.group.delete', '删除商户分组 ID: ' . $item['id'] . ' 标题: ' . $item['groupname'] . ' ');
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

		$items = pdo_fetchall('SELECT id,groupname FROM ' . tablename('ewei_shop_merch_group') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_merch_group', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('merch.group.edit', '修改商户分组状态<br/>ID: ' . $item['id'] . '<br/>分组名称: ' . $item['groupname'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '显示' : '隐藏');
		}

		show_json(1, array('url' => referer()));
	}

	public function setdefault()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$group = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_merch_group') . (' WHERE id = \'' . $id . '\''));

		if (empty($group)) {
			show_json(0, '抱歉，商户分组不存在或是已经被删除！');
		}

		pdo_update('ewei_shop_merch_group', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'isdefault' => 1));
		pdo_update('ewei_shop_merch_group', array('isdefault' => 1), array('uniacid' => $_W['uniacid'], 'id' => $group['id']));
		plog('merch.group.setdefault', '设置默认商户分组 ID: ' . $id . ' 分组名称: ' . $group['groupname']);
		show_json(1);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = 'uniacid=:uniacid AND status=1';

		if (!empty($kwd)) {
			$condition .= ' AND `groupname` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$list = pdo_fetchall('SELECT id, groupname FROM ' . tablename('ewei_shop_merch_group') . (' WHERE ' . $condition . ' order by id asc'), $params);
		include $this->template();
		exit();
	}
}

?>
