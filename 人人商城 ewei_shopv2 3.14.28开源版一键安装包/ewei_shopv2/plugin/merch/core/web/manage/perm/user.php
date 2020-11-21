<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class User_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$status = $_GPC['status'];
		$condition = ' and u.uniacid = :uniacid and u.merchid = :merchid and u.isfounder<>1';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and u.username like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		if ($_GPC['roleid'] != '') {
			$condition .= ' and u.roleid=' . intval($_GPC['roleid']);
		}

		if ($_GPC['status'] != '') {
			$condition .= ' and u.status=' . intval($_GPC['status']);
		}

		$list = pdo_fetchall('SELECT u.*,r.rolename FROM ' . tablename('ewei_shop_merch_account') . ' u  ' . ' left join ' . tablename('ewei_shop_merch_perm_role') . ' r on u.roleid =r.id  ' . (' WHERE 1 ' . $condition . ' ORDER BY id desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_merch_account') . ' u  ' . ' left join ' . tablename('ewei_shop_merch_perm_role') . ' r on u.roleid =r.id  ' . (' WHERE 1 ' . $condition . ' '), $params);
		$pager = pagination2($total, $pindex, $psize);
		$roles = pdo_fetchall('select id,rolename from ' . tablename('ewei_shop_merch_perm_role') . ' where uniacid=:uniacid and deleted=0', array(':uniacid' => $_W['uniacid']));
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
		$total = $this->model->select_operator();

		if ($id) {
			$item = pdo_fetch('select u.*,r.rolename,r.merchid from ' . tablename('ewei_shop_merch_account') . ' u ' . ' left join ' . tablename('ewei_shop_merch_perm_role') . ' r on u.roleid = r.id ' . ' where u.id=:id AND u.uniacid=:uniacid AND u.merchid=:merchid AND r.uniacid=:uniacid AND r.deleted=0 ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
		}

		if (empty($item)) {
			$_W['accounttotal'] <= $total && $this->message('你最多添加' . $_W['accounttotal'] . '个操作员', '', 'error');
		}

		if ($_W['ispost']) {
			$data = array('username' => trim($_GPC['username']), 'pwd' => trim($_GPC['password']), 'roleid' => trim($_GPC['roleid']), 'status' => trim($_GPC['status']), 'isfounder' => 0, 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid'], 'openid' => trim($_GPC['openid']));
			if ($id && !empty($item)) {
				if (empty($data['pwd'])) {
					unset($data['pwd']);
				}
				else {
					$data['salt'] = random(8);
					strlen($data['pwd']) < 6 && show_json(0, '密码至少6位!');
					$data['pwd'] = md5($data['pwd'] . $data['salt']);
				}

				pdo_update('ewei_shop_merch_account', $data, array('id' => $id, 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
				show_json(1);
			}

			$_W['accounttotal'] <= $total && show_json(0, '你最多添加' . $_W['accounttotal'] . '个操作员');
			strlen($data['pwd']) < 6 && show_json(0, '密码至少6位!');
			$data['salt'] = random(8);
			$data['pwd'] = md5($data['pwd'] . $data['salt']);
			$is_has = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_merch_account') . ' WHERE username=:username AND uniacid=:uniacid AND merchid=:merchid', array(':username' => $data['username'], ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

			if ($is_has) {
				show_json(0, '用户名已存在!');
			}

			pdo_insert('ewei_shop_merch_account', $data);
			show_json(1);
		}

		if (!empty($item['openid'])) {
			$member = m('member')->getMember($item['openid']);
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

		$items = pdo_fetchall('SELECT id,username FROM ' . tablename('ewei_shop_merch_account') . (' WHERE id in( ' . $id . ' ) AND isfounder=0 AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_merch_account', array('id' => $item['id']));
			mplog('perm.user.delete', '删除操作员 ID: ' . $item['id'] . ' 操作员名称: ' . $item['username'] . ' ');
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

		$status = intval($_GPC['status']);
		$items = pdo_fetchall('SELECT id,username FROM ' . tablename('ewei_shop_merch_account') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_merch_account', array('status' => $status), array('id' => $item['id']));
			mplog('perm.user.edit', '修改操作员状态 ID: ' . $item['id'] . ' 操作员名称: ' . $item['username'] . ' 状态: ' . ($status == 0 ? '禁用' : '启用'));
		}

		show_json(1, array('url' => referer()));
	}
}

?>
