<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Adv_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		$condition = '';

		if (!empty($_GPC['keyword'])) {
			$keyword = '%' . trim($_GPC['keyword']) . '%';
			$condition .= ' and name like \'' . $keyword . '\' ';
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 15;
		$list = pdo_fetchall('select * from ' . tablename('ewei_shop_diypage_plu') . ' where merch=:merch and `type`=1 and uniacid=:uniacid ' . $condition . ' order by id desc limit ' . ($pindex - 1) * $psize . ',' . $psize, array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_diypage_plu') . ' where merch=:merch and `type`=1 and uniacid=:uniacid ' . $condition, array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));
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

		if (!empty($id)) {
			$advs = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_diypage_plu') . ' WHERE id=:id and `type`=1 and merch=:merch and uniacid=:uniacid limit 1 ', array(':id' => $id, ':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));

			if (!empty($advs)) {
				$advs['data'] = base64_decode($advs['data']);
				$advs['data'] = json_decode($advs['data'], true);
			}
		}

		if ($_W['ispost']) {
			$data = $_GPC['advs'];
			$advsdata = array('name' => $data['name'], 'status' => intval($data['status']), 'data' => base64_encode(json_encode($data)), 'lastedittime' => time(), 'type' => 1, 'merch' => intval($_W['merchid']));

			if (!empty($id)) {
				plog('diypage.adv.edit', '更新启动广告 id: ' . $id . '  名称:' . $advsdata['name']);
				pdo_update('ewei_shop_diypage_plu', $advsdata, array('id' => $id, 'uniacid' => $_W['uniacid']));
			}
			else {
				plog('diypage.adv.add', '添加启动广告 id: ' . $id . '  名称:' . $advsdata['name']);
				$advsdata['uniacid'] = $_W['uniacid'];
				$advsdata['createtime'] = time();
				pdo_insert('ewei_shop_diypage_plu', $advsdata);
				$id = pdo_insertid();
			}

			show_json(1, array('id' => $id));
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

		$items = pdo_fetchall('SELECT id,`name` FROM ' . tablename('ewei_shop_diypage_plu') . (' WHERE id in( ' . $id . ' ) and merch=:merch and uniacid=:uniacid and `type`=1 '), array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));

		foreach ($items as $item) {
			pdo_delete('ewei_shop_diypage_plu', array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merch' => intval($_W['merchid'])));
			plog('diypage.adv.delete', '删除启动广告 id: ' . $item['id'] . '  名称:' . $item['name']);
		}

		show_json(1);
	}
}

?>
