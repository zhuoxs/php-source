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
		global $_S;
		$set = $_S['commission'];
		$leveltype = $set['leveltype'];
		$default = array('id' => 'default', 'levelname' => empty($set['levelname']) ? '默认等级' : $set['levelname'], 'commission1' => $set['commission1'], 'commission2' => $set['commission2'], 'commission3' => $set['commission3']);
		$others = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_commission_level') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY commission1 asc'));
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
		$set = $_S['commission'];
		$leveltype = $set['leveltype'];
		$id = trim($_GPC['id']);
		$level_array = array();
		$i = 0;

		while ($i < 101) {
			$level_array[$i] = $i;
			++$i;
		}

		if ($id == 'default') {
			$level = array('id' => 'default', 'levelname' => empty($set['levelname']) ? '默认等级' : $set['levelname'], 'commission1' => $set['commission1'], 'commission2' => $set['commission2'], 'commission3' => $set['commission3']);
		}
		else {
			$level = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_commission_level') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => intval($id), ':uniacid' => $_W['uniacid']));

			if (!empty($level['goodsids'])) {
				$goodsids = iunserializer($level['goodsids']);

				if (!empty($goodsids)) {
					$goods = pdo_fetchall('SELECT id,uniacid,title,thumb FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid=:uniacid AND id IN (' . implode(',', $goodsids) . ')', array(':uniacid' => $_W['uniacid']));
				}
			}
		}

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'levelname' => trim($_GPC['levelname']), 'commission1' => trim(trim($_GPC['commission1']), '%'), 'commission2' => trim(trim($_GPC['commission2']), '%'), 'commission3' => trim(trim($_GPC['commission3']), '%'), 'commissionmoney' => trim($_GPC['commissionmoney'], '%'), 'ordermoney' => $_GPC['ordermoney'], 'ordercount' => intval($_GPC['ordercount']), 'downcount' => intval($_GPC['downcount']), 'goodsids' => $_GPC['goodsids'], 'level' => $_GPC['level'], 'goodsids_text' => $_GPC['goodsids_text']);

			if (!empty($data['goodsids'])) {
				$cont = count($data['goodsids']);

				if (5 < $cont) {
					show_json(0, '商品最多添加五个');
				}

				$data['goodsids'] = iserializer($data['goodsids']);
			}

			if (!empty($id)) {
				if ($id == 'default') {
					$updatecontent = '<br/>等级名称: ' . $set['levelname'] . '->' . $data['levelname'] . ('<br/>一级佣金比例: ' . $set['commission1'] . '->' . $data['commission1']) . ('<br/>二级佣金比例: ' . $set['commission2'] . '->' . $data['commission2']) . ('<br/>三级佣金比例: ' . $set['commission3'] . '->' . $data['commission3']);
					$set['levelname'] = $data['levelname'];
					$set['commission1'] = $data['commission1'];
					$set['commission2'] = $data['commission2'];
					$set['commission3'] = $data['commission3'];
					$this->updateSet($set);
					plog('commission.level.edit', '修改分销商默认等级' . $updatecontent);
				}
				else {
					$updatecontent = '<br/>等级名称: ' . $level['levelname'] . '->' . $data['levelname'] . ('<br/>一级佣金比例: ' . $level['commission1'] . '->' . $data['commission1']) . ('<br/>二级佣金比例: ' . $level['commission2'] . '->' . $data['commission2']) . ('<br/>三级佣金比例: ' . $level['commission3'] . '->' . $data['commission3']);
					pdo_update('ewei_shop_commission_level', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
					plog('commission.level.edit', '修改分销商等级 ID: ' . $id . $updatecontent);
				}
			}
			else {
				pdo_insert('ewei_shop_commission_level', $data);
				$id = pdo_insertid();
				plog('commission.level.add', '添加分销商等级 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('commission/level')));
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

		$items = pdo_fetchall('SELECT id,levelname FROM ' . tablename('ewei_shop_commission_level') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_commission_level', array('id' => $item['id']));
			plog('commission.level.delete', '删除分销商等级 ID: ' . $id . ' 等级名称: ' . $level['levelname']);
		}

		show_json(1);
	}
}

?>
