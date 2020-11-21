<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Esheet_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' AND uniacid = :uniacid   and merchid=0';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND esheetname LIKE :esheetname';
			$params[':esheetname'] = '%' . trim($_GPC['keyword']) . '%';
		}

		$sql = 'SELECT temp.id,temp.esheetname,esheet.name,temp.isdefault' . ' FROM ' . tablename('ewei_shop_exhelper_esheet_temp') . ' temp ' . ' left join ' . tablename('ewei_shop_exhelper_esheet') . ' esheet on temp.esheetid = esheet.id ' . ' where 1 ' . $condition . ' ORDER BY temp.isdefault DESC, id LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$data['list'] = pdo_fetchall($sql, $params);
		$data['total'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_exhelper_esheet_temp') . (' where 1 ' . $condition), $params);
		$data['pager'] = pagination2($data['total'], $pindex, $psize);
		extract($data);
		include $this->template('exhelper/temp/esheet/index');
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
		$type = 1;
		$esheet_list = pdo_fetchall('select *  from ' . tablename('ewei_shop_exhelper_esheet'));

		foreach ($esheet_list as &$esheet) {
			$datas = json_encode(unserialize($esheet['datas']));
			$esheet['datas'] = str_replace('"', '\'', $datas);
		}

		unset($esheet);

		if (!empty($id)) {
			$params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
			$sql = 'SELECT *  FROM ' . tablename('ewei_shop_exhelper_esheet_temp') . ' temp ' . ' left join ' . tablename('ewei_shop_exhelper_esheet') . ' esheet on temp.esheetid = esheet.id ' . ' where temp.id=:id and temp.uniacid=:uniacid and temp.merchid=0 limit 1';
			$item = pdo_fetch($sql, $params);
			$esheettemp_list = unserialize($item['datas']);
		}

		if ($_W['ispost']) {
			$id = intval($_GPC['id']);
			$data = array('esheetid' => trim($_GPC['esheetid']), 'esheetname' => trim($_GPC['esheetname']), 'customername' => trim($_GPC['customername']), 'customerpwd' => trim($_GPC['customerpwd']), 'monthcode' => trim($_GPC['monthcode']), 'sendsite' => trim($_GPC['sendsite']), 'paytype' => intval($_GPC['paytype']), 'templatesize' => trim($_GPC['templatesize']) == 0 ? '' : trim($_GPC['templatesize']), 'isnotice' => intval($_GPC['isnotice']), 'issend' => intval($_GPC['issend']), 'isdefault' => intval($_GPC['isdefault']));

			if (!empty($id)) {
				pdo_update('ewei_shop_exhelper_esheet_temp', $data, array('id' => $id));
				plog('exhelper.temp.esheet.edit', '修改电子面单模板信息 ID: ' . $id);
			}
			else {
				$data['uniacid'] = $_W['uniacid'];
				$data['merchid'] = 0;
				pdo_insert('ewei_shop_exhelper_esheet_temp', $data);
				$id = pdo_insertid();
				plog('exhelper.temp.esheet.add', '添加电子面单模板 ID: ' . $id);
			}

			if (!empty($data['isdefault'])) {
				pdo_update('ewei_shop_exhelper_esheet_temp', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'merchid' => 0));
				pdo_update('ewei_shop_exhelper_esheet_temp', array('isdefault' => 1), array('id' => $id, 'merchid' => 0));
			}

			show_json(1, array('url' => webUrl('exhelper/temp/esheet/edit', array('id' => $id))));
			exit();
		}

		include $this->template('exhelper/temp/esheet/post');
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,esheetname FROM ' . tablename('ewei_shop_exhelper_esheet_temp') . (' WHERE id in( ' . $id . ' ) and uniacid=:uniacid and merchid=0'), array(':uniacid' => $_W['uniacid']));

		foreach ($items as $item) {
			pdo_delete('ewei_shop_exhelper_esheet_temp', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			plog('exhelper.temp.esheet.delete', '删除 快递助手 电子面单模板 ID: ' . $item['id'] . '， 模板名称: ' . $item['esheetname'] . ' ');
		}

		show_json(1);
	}

	public function setdefault()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$item = pdo_fetch('SELECT id,esheetname FROM ' . tablename('ewei_shop_exhelper_esheet_temp') . ' WHERE id=:id and  uniacid=:uniacid and merchid=0', array(':id' => $id, ':uniacid' => $_W['uniacid']));

			if (!empty($item)) {
				pdo_update('ewei_shop_exhelper_esheet_temp', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'merchid' => 0));
				pdo_update('ewei_shop_exhelper_esheet_temp', array('isdefault' => 1), array('id' => $id, 'merchid' => 0));
				plog('exhelper.temp.esheet.setdefault', '设置电子面单 ID: ' . $item['id'] . '， 模板名称: ' . $item['esheetname'] . ' ');
			}
		}

		show_json(1);
	}
}

?>
