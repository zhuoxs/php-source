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
		$set = $_W['shopset']['globonus'];
		$leveltype = $set['leveltype'];
		$default = array('id' => 'default', 'levelname' => empty($set['levelname']) ? '默认等级' : $set['levelname'], 'bonus' => $set['bonus']);
		$others = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_globonus_level') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY bonus asc'));
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
		$set = $_W['shopset']['globonus'];
		$leveltype = $set['leveltype'];
		$id = trim($_GPC['id']);

		if ($id == 'default') {
			$level = array('id' => 'default', 'levelname' => empty($set['levelname']) ? '默认等级' : $set['levelname'], 'bonus' => $set['bonus']);
		}
		else {
			$level = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_globonus_level') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => intval($id), ':uniacid' => $_W['uniacid']));
		}

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'levelname' => trim($_GPC['levelname']), 'bonus' => trim(trim($_GPC['bonus']), '%'), 'commissionmoney' => trim($_GPC['commissionmoney'], '%'), 'ordermoney' => $_GPC['ordermoney'], 'ordercount' => intval($_GPC['ordercount']), 'downcount' => intval($_GPC['downcount']), 'bonusmoney' => trim($_GPC['bonusmoney'], '%'));

			if (!empty($id)) {
				if ($id == 'default') {
					$updatecontent = '<br/>等级名称: ' . $set['levelname'] . '->' . $data['levelname'] . ('<br/>分红比例: ' . $set['bonus'] . '->' . $data['bonus']);
					$set['levelname'] = $data['levelname'];
					$set['bonus'] = $data['bonus'];
					$this->updateSet($set);
					plog('globonus.level.edit', '修改股东默认等级' . $updatecontent);
				}
				else {
					$updatecontent = '<br/>等级名称: ' . $level['levelname'] . '->' . $data['levelname'] . ('<br/>分红比例: ' . $level['bonus'] . '->' . $data['bonus']);
					pdo_update('ewei_shop_globonus_level', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
					plog('globonus.level.edit', '修改股东等级 ID: ' . $id . $updatecontent);
				}
			}
			else {
				pdo_insert('ewei_shop_globonus_level', $data);
				$id = pdo_insertid();
				plog('globonus.level.add', '添加股东等级 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('globonus/level')));
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

		$items = pdo_fetchall('SELECT id,levelname FROM ' . tablename('ewei_shop_globonus_level') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_globonus_level', array('id' => $item['id']));
			plog('globonus.level.delete', '删除股东等级 ID: ' . $id . ' 等级名称: ' . $item['levelname']);
		}

		show_json(1);
	}
}

?>
