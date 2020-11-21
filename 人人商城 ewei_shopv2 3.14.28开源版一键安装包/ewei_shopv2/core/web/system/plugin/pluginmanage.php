<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Pluginmanage_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = '';
		$params = array();

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and p.name like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		if ($_GPC['state'] != '') {
			$condition .= ' and gp.state=' . intval($_GPC['state']);
		}

		$list = pdo_fetchall('SELECT gp.*,p.identity,p.category,p.name as pname,p.version,p.author,p.status FROM ' . tablename('ewei_shop_system_plugingrant_plugin') . ' as gp
                left join ' . tablename('ewei_shop_plugin') . (' as p on p.id = gp.pluginid
                WHERE 1 ' . $condition . ' ORDER BY gp.displayorder desc,gp.id desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($list as $key => $value) {
			$list[$key]['data'] = unserialize($value['data']);
		}

		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_system_plugingrant_plugin') . ' as gp
                left join ' . tablename('ewei_shop_plugin') . (' as p on p.id = gp.pluginid
                WHERE 1 ' . $condition . ' '), $params);
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
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_system_plugingrant_plugin') . ' WHERE id =:id limit 1', array(':id' => $id));

		if ($_W['ispost']) {
			$data = array('displayorder' => intval($_GPC['displayorder']), 'pluginid' => intval($_GPC['plugintype']) == 0 ? intval($_GPC['pluginid']) : 0, 'thumb' => save_media($_GPC['thumb']), 'name' => trim($_GPC['name']), 'plugintype' => intval($_GPC['plugintype']), 'state' => intval($_GPC['state']), 'content' => m('common')->html_images($_GPC['content']));
			$dates = array();
			$datearray = is_array($_GPC['date']) ? $_GPC['date'] : array();

			foreach ($datearray as $key => $value) {
				$date = floatval($value);

				if (0 <= $date) {
					$dates[] = array('date' => floatval($_GPC['date'][$key]), 'price' => floatval($_GPC['price'][$key]));
				}
			}

			$data['data'] = serialize($dates);

			if (!empty($id)) {
				pdo_update('ewei_shop_system_plugingrant_plugin', $data, array('id' => $id));
			}
			else {
				$data['createtime'] = time();
				pdo_insert('ewei_shop_system_plugingrant_plugin', $data);
				$id = pdo_insertid();
			}

			show_json(1, array('url' => webUrl('system/plugin/pluginmanage/edit', array('id' => $id))));
		}

		$pluginData = unserialize($item['data']);
		if (!empty($item) && 0 < $item['pluginid']) {
			$plugin = pdo_fetch('select * from ' . tablename('ewei_shop_plugin') . ' where id = ' . $item['pluginid'] . ' ');
			$item['title'] = $plugin['title'] = $plugin['name'];
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

		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_system_plugingrant_plugin') . (' WHERE id in( ' . $id . ' ) '));

		foreach ($items as $item) {
			pdo_delete('ewei_shop_system_plugingrant_plugin', array('id' => $item['id']));
			plog('system.plugin.pluginmanage.delete', '删除应用<br/>ID: ' . $item['id']);
		}

		show_json(1, array('url' => referer()));
	}

	public function property()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = trim($_GPC['type']);
		$value = intval($_GPC['value']);

		if (in_array($type, array('state'))) {
			pdo_update('ewei_shop_system_plugingrant_plugin', array($type => $value), array('id' => $id));
			$statusstr = '';

			if ($type == 'state') {
				$typestr = '启用';
				$statusstr = $value == 1 ? '开启' : '关闭';
			}

			plog('system.plugin.pluginmanage.edit', '修改授权应用' . $typestr . '状态   ID: ' . $id . ' ' . $statusstr . ' ');
		}

		show_json(1);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 8;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$condition = ' and deprecated=0 and status=1 ';

		if (!empty($kwd)) {
			$condition .= ' AND name LIKE :keyword ';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$pluginid = '';
		$grantPlugin = array();
		$grantPlugin = pdo_fetchall('select pluginid from ' . tablename('ewei_shop_system_plugingrant_plugin') . ' where 1 ');

		foreach ($grantPlugin as $key => $valeu) {
			$pluginid .= $valeu['pluginid'] . ',';
		}

		$pluginid = substr($pluginid, 0, strlen($pluginid) - 1);

		if (!empty($pluginid)) {
			$condition .= ' and id not in (' . $pluginid . ') ';
		}

		$plugins = pdo_fetchall('select id,`name` as title,thumb,`desc` from ' . tablename('ewei_shop_plugin') . ' where 1 ' . $condition . ' order by displayorder asc LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_plugin') . ' WHERE 1 ' . $condition . ' ', $params);
		$pager = pagination2($total, $pindex, $psize, '', array('before' => 5, 'after' => 4, 'ajaxcallback' => 'select_page', 'callbackfuncname' => 'select_page'));
		include $this->template();
	}
}

?>
