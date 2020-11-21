<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Saler_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$condition = ' s.uniacid = :uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['status'] != '') {
			$condition .= ' and s.status = :status';
			$params[':status'] = $_GPC['status'];
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and ( s.salername like :keyword or m.realname like :keyword or m.mobile like :keyword or m.nickname like :keyword)';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$sql = 'SELECT s.*,m.nickname,m.avatar,m.realname,store.storename FROM ' . tablename('ewei_shop_saler') . '  s ' . ' left join ' . tablename('ewei_shop_member') . ' m on s.openid=m.openid and m.uniacid = s.uniacid ' . ' left join ' . tablename('ewei_shop_store') . ' store on store.id=s.storeid ' . (' WHERE ' . $condition . ' ORDER BY id asc');
		$list = pdo_fetchall($sql, $params);
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
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_saler') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if (!empty($item)) {
			$saler = m('member')->getMember($item['openid']);
			$store = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_store') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $item['storeid']));

			if (p('newstore')) {
				$role = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_newstore_perm_role') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $item['roleid']));
			}
		}

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'storeid' => intval($_GPC['storeid']), 'openid' => trim($_GPC['openid']), 'status' => intval($_GPC['status']), 'salername' => trim($_GPC['salername']), 'mobile' => trim($_GPC['mobile']), 'roleid' => intval($_GPC['roleid']));

			if (empty($data['storeid'])) {
				show_json(0, '请选择所属门店');
			}

			if (p('newstore')) {
				$data['getnotice'] = intval($_GPC['getnotice']);

				if (empty($item['username'])) {
					if (empty($_GPC['username'])) {
						show_json(0, '用户名不能为空!');
					}

					$usernames = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_saler') . ' WHERE username=:username limit 1', array(':username' => $_GPC['username']));

					if (0 < $usernames) {
						show_json(0, '该用户名已被使用，请修改后重新提交!');
					}

					$data['username'] = $_GPC['username'];
				}

				if (!empty($_GPC['pwd'])) {
					$salt = random(8);

					while (1) {
						$saltcount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_saler') . ' where salt=:salt limit 1', array(':salt' => $salt));

						if ($saltcount <= 0) {
							break;
						}

						$salt = random(8);
					}

					$pwd = md5(trim($_GPC['pwd']) . $salt);
					$data['pwd'] = $pwd;
					$data['salt'] = $salt;
				}
				else {
					if (empty($item)) {
						show_json(0, '用户密码不能为空!');
					}
				}
			}

			$m = m('member')->getMember($data['openid']);

			if (!empty($id)) {
				pdo_update('ewei_shop_saler', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
				plog('shop.verify.saler.edit', '编辑店员 ID: ' . $id . ' <br/>店员信息: ID: ' . $m['id'] . ' / ' . $m['openid'] . '/' . $m['nickname'] . '/' . $m['realname'] . '/' . $m['mobile'] . ' ');
			}
			else {
				$scount = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_saler') . ' WHERE openid =:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $data['openid']));

				if (0 < $scount) {
					show_json(0, '此会员已经成为店员，没法重复添加');
				}

				pdo_insert('ewei_shop_saler', $data);
				$id = pdo_insertid();
				plog('shop.verify.saler.add', '添加店员 ID: ' . $id . '  <br/>店员信息: ID: ' . $m['id'] . ' / ' . $m['openid'] . '/' . $m['nickname'] . '/' . $m['realname'] . '/' . $m['mobile'] . ' ');
			}

			show_json(1, array('url' => webUrl('store/saler')));
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

		$items = pdo_fetchall('SELECT id,salername FROM ' . tablename('ewei_shop_saler') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_saler', array('id' => $item['id']));
			plog('shop.verify.saler.delete', '删除店员 ID: ' . $item['id'] . ' 店员名称: ' . $item['salername'] . ' ');
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

		$items = pdo_fetchall('SELECT id,salername FROM ' . tablename('ewei_shop_saler') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_saler', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('shop.verify.saler.edit', '修改店员状态<br/>ID: ' . $item['id'] . '<br/>店员名称: ' . $item['salername'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '启用' : '禁用');
		}

		show_json(1, array('url' => referer()));
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and s.uniacid=:uniacid';

		if (!empty($kwd)) {
			$condition .= ' AND ( m.nickname LIKE :keyword or m.realname LIKE :keyword or m.mobile LIKE :keyword or store.storename like :keyword )';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT s.*,m.nickname,m.avatar,m.mobile,m.realname,store.storename FROM ' . tablename('ewei_shop_saler') . '  s ' . ' left join ' . tablename('ewei_shop_member') . ' m on s.openid=m.openid ' . ' left join ' . tablename('ewei_shop_store') . ' store on store.id=s.storeid ' . (' WHERE 1 ' . $condition . ' ORDER BY id asc'), $params);
		include $this->template();
		exit();
	}
}

?>
