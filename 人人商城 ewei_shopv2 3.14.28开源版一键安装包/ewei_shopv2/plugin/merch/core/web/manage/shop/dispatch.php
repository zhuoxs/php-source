<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Dispatch_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid and merchid=:merchid';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);

		if ($_GPC['enabled'] != '') {
			$condition .= ' and enabled=' . intval($_GPC['enabled']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and dispatchname  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_dispatch') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_dispatch') . (' WHERE 1 ' . $condition), $params);
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

		if ($_W['ispost']) {
			$areas = array();
			$randoms = $_GPC['random'];

			if (is_array($randoms)) {
				foreach ($randoms as $random) {
					$citys = trim($_GPC['citys'][$random]);

					if (empty($citys)) {
						continue;
					}

					if ($_GPC['firstnum'][$random] < 1) {
						$_GPC['firstnum'][$random] = 1;
					}

					if ($_GPC['secondnum'][$random] < 1) {
						$_GPC['secondnum'][$random] = 1;
					}

					$areas[] = array('citys' => $_GPC['citys'][$random], 'citys_code' => $_GPC['citys_code'][$random], 'firstprice' => $_GPC['firstprice'][$random], 'firstweight' => $_GPC['firstweight'][$random], 'secondprice' => $_GPC['secondprice'][$random], 'secondweight' => $_GPC['secondweight'][$random], 'firstnumprice' => $_GPC['firstnumprice'][$random], 'firstnum' => $_GPC['firstnum'][$random], 'secondnumprice' => $_GPC['secondnumprice'][$random], 'secondnum' => $_GPC['secondnum'][$random]);
				}
			}

			$_GPC['default_firstnum'] = trim($_GPC['default_firstnum']);

			if ($_GPC['default_firstnum'] < 1) {
				$_GPC['default_firstnum'] = 1;
			}

			$_GPC['default_secondnum'] = trim($_GPC['default_secondnum']);

			if ($_GPC['default_secondnum'] < 1) {
				$_GPC['default_secondnum'] = 1;
			}

			$data = array('uniacid' => $_W['uniacid'], 'displayorder' => intval($_GPC['displayorder']), 'dispatchtype' => intval($_GPC['dispatchtype']), 'isdefault' => intval($_GPC['isdefault']), 'dispatchname' => trim($_GPC['dispatchname']), 'express' => trim($_GPC['express']), 'calculatetype' => trim($_GPC['calculatetype']), 'firstprice' => trim($_GPC['default_firstprice']), 'firstweight' => trim($_GPC['default_firstweight']), 'secondprice' => trim($_GPC['default_secondprice']), 'secondweight' => trim($_GPC['default_secondweight']), 'firstnumprice' => trim($_GPC['default_firstnumprice']), 'firstnum' => $_GPC['default_firstnum'], 'secondnumprice' => trim($_GPC['default_secondnumprice']), 'secondnum' => $_GPC['default_secondnum'], 'areas' => iserializer($areas), 'nodispatchareas' => iserializer($_GPC['nodispatchareas']), 'nodispatchareas_code' => iserializer($_GPC['nodispatchareas_code']), 'isdispatcharea' => intval($_GPC['isdispatcharea']), 'enabled' => intval($_GPC['enabled']), 'merchid' => $_W['merchid']);

			if ($data['isdefault']) {
				pdo_update('ewei_shop_dispatch', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
			}

			if (!empty($id)) {
				mplog('shop.dispatch.edit', '修改配送方式 ID: ' . $id);
				pdo_update('ewei_shop_dispatch', $data, array('id' => $id, 'merchid' => $_W['merchid']));
			}
			else {
				pdo_insert('ewei_shop_dispatch', $data);
				$id = pdo_insertid();
				mplog('shop.dispatch.add', '添加配送方式 ID: ' . $id);
			}

			show_json(1, array('url' => merchUrl('shop/dispatch', array('op' => 'display'))));
		}

		$dispatch = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_dispatch') . (' WHERE id = \'' . $id . '\' and uniacid = \'' . $_W['uniacid'] . '\' and merchid=\'' . $_W['merchid'] . '\''));

		if (!empty($dispatch)) {
			$dispatch_areas = unserialize($dispatch['areas']);
			$dispatch_carriers = unserialize($dispatch['carriers']);
			$dispatch_nodispatchareas = unserialize($dispatch['nodispatchareas']);
			$dispatch_nodispatchareas_code = unserialize($dispatch['nodispatchareas_code']);
		}

		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$areas = m('common')->getAreas();
		$express_list = m('express')->getExpressList();
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

		$items = pdo_fetchall('SELECT id,dispatchname FROM ' . tablename('ewei_shop_dispatch') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid'] . ' AND merchid=' . $_W['merchid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_dispatch', array('id' => $item['id']));
			mplog('shop.dispatch.delete', '删除配送方式 ID: ' . $item['id'] . ' 标题: ' . $item['dispatchname'] . ' ');
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

		$items = pdo_fetchall('SELECT id,dispatchname FROM ' . tablename('ewei_shop_dispatch') . (' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid'] . ' and merchid=' . $_W['merchid']));

		foreach ($items as $item) {
			pdo_update('ewei_shop_dispatch', array('enabled' => intval($_GPC['enabled'])), array('id' => $item['id']));
			mplog('shop.dispatch.edit', '修改配送方式状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['dispatchname'] . '<br/>状态: ' . $_GPC['enabled'] == 1 ? '显示' : '隐藏');
		}

		show_json(1, array('url' => referer()));
	}

	public function setdefault()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		if ($_GPC['isdefault'] == 1) {
			pdo_update('ewei_shop_dispatch', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
		}

		$items = pdo_fetchall('SELECT id,dispatchname FROM ' . tablename('ewei_shop_dispatch') . (' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid'] . ' and merchid=' . $_W['merchid']));

		foreach ($items as $item) {
			pdo_update('ewei_shop_dispatch', array('isdefault' => intval($_GPC['isdefault'])), array('id' => $item['id']));
			mplog('shop.dispatch.edit', '设为默认配送方式<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['dispatchname'] . '<br/>状态: ' . $_GPC['isdefault'] == 1 ? '是' : '否');
		}

		show_json(1, array('url' => referer()));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id,dispatchname FROM ' . tablename('ewei_shop_dispatch') . (' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid'] . ' and merchid=' . $_W['merchid']));

		if (!empty($item)) {
			pdo_update('ewei_shop_dispatch', array('displayorder' => $displayorder), array('id' => $id));
			mplog('shop.dispatch.edit', '修改配送方式排序 ID: ' . $item['id'] . ' 标题: ' . $item['dispatchname'] . ' 排序: ' . $displayorder . ' ');
		}

		show_json(1);
	}

	public function tpl()
	{
		global $_W;
		global $_GPC;
		$random = random(16);
		ob_start();
		include $this->template('shop/dispatch/tpl');
		$contents = ob_get_contents();
		ob_clean();
		exit(json_encode(array('random' => $random, 'html' => $contents)));
	}
}

?>
