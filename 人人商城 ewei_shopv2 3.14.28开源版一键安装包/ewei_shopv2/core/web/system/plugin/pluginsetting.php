<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Pluginsetting_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$data = pdo_fetch('select * from ' . tablename('ewei_shop_system_plugingrant_setting') . ' where 1 = 1 limit 1 ');
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

		if ($_W['ispost']) {
			$data_set = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$dates = array();
			$datearray = is_array($_GPC['tel']) ? $_GPC['tel'] : array();

			foreach ($datearray as $key => $value) {
				$date = floatval($value);

				if (0 < $date) {
					$dates[] = array('tel' => trim($_GPC['tel'][$key]), 'note' => trim($_GPC['note'][$key]));
				}
			}

			$data_set['alipay'] = empty($data_set['alipay']) ? 0 : 1;
			$data_set['weixin'] = empty($data_set['weixin']) ? 0 : 1;
			$data_set['contact'] = serialize($dates);

			if (!empty($data)) {
				pdo_update('ewei_shop_system_plugingrant_setting', $data_set, array('id' => $data['id']));
				plog('system.plugin.pluginsetting.edit', '修改授权管理基本设置');
			}
			else {
				pdo_insert('ewei_shop_system_plugingrant_setting', $data_set);
				plog('system.plugin.pluginsetting.add', '添加授权管理基本设置');
			}

			show_json(1, array('url' => webUrl('system/plugin/pluginsetting', array('tab' => str_replace('#tab_', '', $_GPC['tab'])))));
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

		$contacts = unserialize($data['contact']);
		$plugins = pdo_fetchall('select * from ' . tablename('ewei_shop_plugin') . ' where iscom=0 and deprecated=0 and status=1 order by displayorder asc');
		$coms = pdo_fetchall('select * from ' . tablename('ewei_shop_plugin') . ' where iscom=1 and deprecated=0 and status=1 order by displayorder asc');
		$comstr = '';
		$pluginstr = '';

		foreach ($plugins as $key => $value) {
			if (strstr($data['plugin'], $value['identity'])) {
				$pluginstr .= $value['name'] . ';';
			}
		}

		foreach ($coms as $key => $value) {
			if (strstr($data['com'], $value['identity'])) {
				$comstr .= $value['name'] . ';';
			}
		}

		$data['manage'] = $comstr . $pluginstr;
		unset($comstr);
		unset($pluginstr);
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
		show_json(1, array('url' => webUrl('system/plugin/pluginsetting')));
	}
}

?>
