<?php
//QQ63779278
class Page_EweiShopV2Page extends WebPage
{
	/**
     * 门店页面编辑
     */
	public function main()
	{
		global $_W;
		global $_GPC;
		$storeid = intval($_GPC['id']);

		if (empty($storeid)) {
			$this->message('参数错误');
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_store') . 'WHERE uniacid=:uniacid AND id=:id LIMIT 1', array(':uniacid' => $_W['uniacid'], ':id' => $storeid));

		if (empty($item)) {
			$this->message('门店不存在');
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'uniacid=:uniacid AND storeid=:storeid ';
		$params = array(':uniacid' => $_W['uniacid'], ':storeid' => $storeid);
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= ' AND name LIKE :keyword ';
			$params[':keyword'] = '%' . $keyword . '%';
		}

		if ($_GPC['status'] != '') {
			$condition .= ' AND status=:status ';
			$params[':status'] = intval($_GPC['status']);
		}

		$condition .= ' ORDER BY id DESC ';
		$limit = ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_newstore_diypage') . 'WHERE ' . $condition . $limit, $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_newstore_diypage') . 'WHERE ' . $condition, $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function add()
	{
		$this->post(true);
	}

	public function edit()
	{
		$this->post();
	}

	/**
     * 编辑门店自建页面
     */
	protected function post($add = false)
	{
		global $_W;
		global $_GPC;

		if (!p('newstore')) {
			$this->message('O2O应用未安装');
		}

		$id = intval($_GPC['id']);
		$storeid = intval($_GPC['storeid']);
		$templateid = intval($_GPC['templateid']);

		if ($add) {
			if (!empty($templateid)) {
				$item = p('newstore')->getDiyPage($templateid, 0, false, $storeid);
				$fromtemplate = true;
			}
		}
		else {
			$item = p('newstore')->getDiyPage($id, 1, false, $storeid);
		}

		$initJson = json_encode(array('id' => $id, 'data' => $item['data'], 'storeid' => $storeid, 'templateid' => $templateid, 'type' => 1, 'attachurl' => $_W['attachurl'], 'newstore' => $_W['plugin'] == 'newstore'));
		include $this->template();
	}

	/**
     * 保存门店自建页面
     */
	public function save()
	{
		global $_GPC;
		$id = intval($_GPC['id']);
		$storeid = intval($_GPC['storeid']);
		$templateid = intval($_GPC['templateid']);
		$data = $_GPC['data'];
		p('newstore')->saveDiyPage($id, $data, $storeid, $templateid);
	}

	/**
     * 批量\单个删除
     */
	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id, `name` FROM ' . tablename('ewei_shop_newstore_diypage') . (' WHERE id in( ' . $id . ' ) AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']));

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_delete('ewei_shop_newstore_diypage', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('newstore.diypage.delete', '删除门店页面<br/>ID: ' . $item['id'] . '<br/>页面名称: ' . $item['name']);
			}
		}

		show_json(1);
	}

	/**
     * 批量\单个设置状态
     */
	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id, `name` FROM ' . tablename('ewei_shop_newstore_diypage') . (' WHERE id in( ' . $id . ' ) AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']));

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_update('ewei_shop_newstore_diypage', array('status' => intval($_GPC['status'])), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('newstore.diypage.status', '修改门店页面状态<br/>ID: ' . $item['id'] . '<br/>页面名称: ' . $item['name'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '启用' : '禁用');
			}
		}

		show_json(1);
	}
}

?>
