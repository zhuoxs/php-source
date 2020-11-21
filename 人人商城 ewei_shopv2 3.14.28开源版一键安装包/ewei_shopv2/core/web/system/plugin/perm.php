<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Perm_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		load()->model('user');
		$path = IA_ROOT . '/addons/ewei_shopv2/data/global';

		if (!is_dir($path)) {
			load()->func('file');
			mkdirs($path);
		}

		$permset = intval(m('cache')->getString('permset', 'global'));
		if (empty($permset) && is_file($path . '/perm.cache')) {
			$permset = authcode(file_get_contents($path . '/perm.cache'), 'DECODE', 'global');
		}

		if ($permset) {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$status = $_GPC['status'];
			$condition = '';
			$params = array();

			if (!empty($_GPC['keyword'])) {
				$_GPC['keyword'] = trim($_GPC['keyword']);
				$condition .= ' and ac.name like :keyword';
				$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
			}

			if ($_GPC['type'] != '') {
				$condition .= ' and p.type=' . intval($_GPC['type']);
			}

			$list = pdo_fetchall('SELECT p.*,ac.name FROM ' . tablename('ewei_shop_perm_plugin') . ' p  ' . ' left join ' . tablename('account_wechats') . ' ac on p.acid = ac.acid  ' . (' WHERE 1 ' . $condition . ' ORDER BY id desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);

			foreach ($list as &$row) {
				$row_plugins = explode(',', $row['plugins']);
				$aplugins = array();

				foreach ($row_plugins as $rp) {
					$aplugins[] = '\'' . $rp . '\'';
				}

				if (!empty($aplugins)) {
					$row['plugins'] = pdo_fetchall('select name from ' . tablename('ewei_shop_plugin') . ' where identity in (' . implode(',', $aplugins) . ') and status=1');
				}
				else {
					$row['plugins'] = array();
				}

				$row_coms = explode(',', $row['coms']);
				$acoms = array();

				foreach ($row_coms as $rc) {
					$acoms[] = '\'' . $rc . '\'';
				}

				if (!empty($acoms)) {
					$row['coms'] = pdo_fetchall('select name from ' . tablename('ewei_shop_plugin') . ' where identity in (' . implode(',', $acoms) . ') and status=1');
				}
				else {
					$row['coms'] = array();
				}
			}

			unset($row);
			$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_perm_plugin') . ' p  ' . ' left join ' . tablename('users') . ' u on p.uid = u.uid  ' . ' left join ' . tablename('account_wechats') . ' ac on p.acid = ac.acid  ' . (' WHERE 1 ' . $condition . ' '), $params);
			$pager = pagination2($total, $pindex, $psize);
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

	protected function post()
	{
		global $_W;
		global $_GPC;
		$plugins = pdo_fetchall('select * from ' . tablename('ewei_shop_plugin') . ' where iscom=0 and deprecated=0 and status=1 order by displayorder asc');
		$coms = pdo_fetchall('select * from ' . tablename('ewei_shop_plugin') . ' where iscom=1 and deprecated=0 and status=1 order by displayorder asc');
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_perm_plugin') . ' WHERE id =:id limit 1', array(':id' => $id));
		$item_plugins = array();
		$item_coms = array();

		if (!empty($item)) {
			$item_plugins = explode(',', $item['plugins']);
			$item_coms = explode(',', $item['coms']);
			$user = pdo_fetch('select uid,username from ' . tablename('users') . ' where uid=:uid limit 1', array(':uid' => $item['uid']));
			$account = pdo_fetch('select acid,name from ' . tablename('account_wechats') . ' where acid=:acid limit 1', array(':acid' => $item['acid']));
			$datas = !empty($item['datas']) ? json_decode($item['datas'], true) : array();
		}

		if ($_W['ispost']) {
			$data = array('type' => 1, 'acid' => intval($_GPC['acid']), 'uid' => intval($_GPC['uid']), 'plugins' => is_array($_GPC['plugins']) ? implode(',', $_GPC['plugins']) : '', 'coms' => is_array($_GPC['coms']) ? implode(',', $_GPC['coms']) : '');
			$data['datas'] = is_array($_GPC['datas']) ? json_encode($_GPC['datas']) : array();

			if (empty($data['type'])) {
				$data['acid'] = 0;
			}
			else {
				$data['uid'] = 0;
			}

			if (!empty($id)) {
				pdo_update('ewei_shop_perm_plugin', $data, array('id' => $id));
			}
			else {
				$wechatcount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_perm_plugin') . ' where acid=:acid limit 1', array(':acid' => $data['acid']));

				if (0 < $wechatcount) {
					show_json(0, '此公众号的插件权限已经存在!', '', 'error');
				}

				pdo_insert('ewei_shop_perm_plugin', $data);
				$id = pdo_insertid();
			}

			show_json(1, array('url' => webUrl('system/plugin/perm')));
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id FROM ' . tablename('ewei_shop_perm_plugin') . (' WHERE id = \'' . $id . '\''));

		if (empty($item)) {
			message('抱歉，权限设置不存在或是已经被删除！', webUrl('perm/plugins', array('op' => 'display')), 'error');
		}

		pdo_delete('ewei_shop_perm_plugin', array('id' => $id));
		show_json(1, array('url' => webUrl('system/plugin/perm')));
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$condition = ' ';

		if (!empty($kwd)) {
			$condition .= ' AND acc.isdeleted=0 AND ( a.name LIKE :keyword or u.username like :keyword)';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT distinct a.acid, a.name FROM ' . tablename('account_wechats') . ' a  ' . ' left join ' . tablename('uni_account') . ' ac on ac.uniacid = a.uniacid ' . ' left join ' . tablename('account') . ' acc on acc.uniacid = ac.uniacid ' . ' left join ' . tablename('uni_account_users') . ' uac on uac.uniacid = ac.uniacid' . ' left join ' . tablename('users') . ' u on u.uid = uac.uid ' . (' WHERE 1 ' . $condition . ' order by a.acid desc'), $params);
		include $this->template();
	}

	public function switchs()
	{
		$path = IA_ROOT . '/addons/ewei_shopv2/data/global';

		if (!is_dir($path)) {
			load()->func('file');
			mkdirs($path);
		}

		$permset = intval(m('cache')->getString('permset', 'global'));
		if (empty($permset) && is_file($path . '/perm.cache')) {
			$permset = authcode(file_get_contents($path . '/perm.cache'), 'DECODE', 'global');
		}

		m('cache')->set('permset', $permset == 1 ? 0 : 1, 'global');
		$data_authcode = authcode($permset == 1 ? 0 : 1, 'ENCODE', 'global');
		file_put_contents($path . '/perm.cache', $data_authcode);
		show_json(1, array('url' => webUrl('system/plugin/perm')));
	}
}

?>
