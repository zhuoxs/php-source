<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Level_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $this->getSet();
		$default = array('id' => 'default', 'levelname' => empty($set['levelname']) ? '社区粉丝' : $set['levelname'], 'credit' => intval($set['levelcredit']), 'color' => empty($set['levelcolor']) ? '#333' : $set['levelcolor'], 'bg' => empty($set['levelbg']) ? '#eee' : $set['levelbg']);
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['enabled'] != '') {
			$condition .= ' and enabled=' . intval($_GPC['enabled']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and ( levelname like :levelname)';
			$params[':levelname'] = '%' . $_GPC['keyword'] . '%';
		}

		if ($set['leveltype']) {
			$orderby = 'post';
		}
		else {
			$orderby = 'credit';
		}

		$others = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_sns_level') . (' WHERE 1 ' . $condition . ' ORDER BY ' . $orderby . ' asc'), $params);
		$list = array_merge(array($default), $others);
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
		global $_S;
		$id = trim($_GPC['id']);
		$set = $this->getSet();

		if ($id == 'default') {
			$level = array('id' => 'default', 'levelname' => empty($set['levelname']) ? '社区粉丝' : $set['levelname'], 'credit' => intval($set['levelcredit']), 'post' => intval($set['post']), 'color' => empty($set['levelcolor']) ? '#333' : $set['levelcolor'], 'bg' => empty($set['levelbg']) ? '#eee' : $set['levelbg']);
		}
		else {
			$level = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_sns_level') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => intval($id)));
		}

		if ($_W['ispost']) {
			$enabled = intval($_GPC['enabled']);
			$data = array('uniacid' => $_W['uniacid'], 'levelname' => trim($_GPC['levelname']), 'credit' => intval($_GPC['credit']), 'post' => intval($_GPC['post']), 'color' => trim($_GPC['color']), 'bg' => trim($_GPC['bg']), 'enabled' => $enabled);

			if (!empty($id)) {
				if ($id == 'default') {
					$updatecontent = '<br/>等级名称: ' . $set['levelname'] . '->' . $data['levelname'] . ('<br/>积分: ' . $set['credit'] . '->' . $data['credit']);
					$set['levelname'] = $data['levelname'];
					$set['levelcredit'] = $data['credit'];
					$set['levelpost'] = $data['post'];
					$set['levelcolor'] = $data['color'];
					$set['levelbg'] = $data['bg'];
					$this->updateSet($set);
					plog('sns.level.edit', '修改默认等级' . $updatecontent);
				}
				else {
					$updatecontent = '<br/>等级名称: ' . $level['levelname'] . '->' . $data['levelname'] . ('<br/>积分: ' . $level['credit'] . '->' . $data['credit']);
					pdo_update('ewei_shop_sns_level', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
					plog('sns.level.edit', '修改会员等级 ID: ' . $id . $updatecontent);
				}
			}
			else {
				pdo_insert('ewei_shop_sns_level', $data);
				$id = pdo_insertid();
				plog('sns.level.add', '添加会员等级 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('sns/level')));
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

		$items = pdo_fetchall('SELECT id,levelname FROM ' . tablename('ewei_shop_sns_level') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_sns_level', array('id' => $item['id']));
			plog('sns.level.delete', '删除等级 ID: ' . $item['id'] . ' 标题: ' . $item['levelname'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function enabled()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,levelname FROM ' . tablename('ewei_shop_sns_level') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_sns_level', array('enabled' => intval($_GPC['enabled'])), array('id' => $item['id']));
			plog('sns.level.edit', '修改会员等级状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['levelname'] . '<br/>状态: ' . $_GPC['enabled'] == 1 ? '启用' : '禁用');
		}

		show_json(1, array('url' => referer()));
	}
}

?>
