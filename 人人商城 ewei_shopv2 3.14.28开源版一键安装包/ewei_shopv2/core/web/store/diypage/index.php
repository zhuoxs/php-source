<?php
//QQ63779278
class Index_EweiShopV2Page extends WebPage
{
	/**
     * 门店页面设置
     */
	public function settings()
	{
		global $_W;
		global $_GPC;
		$storeid = intval($_GPC['id']);

		if (empty($storeid)) {
			$this->message('参数错误');
		}

		if ($_W['ispost']) {
			$type = trim($_GPC['type']);

			if ($type == 'pageset') {
				$this->updatePage($storeid);
			}

			exit();
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_store') . 'WHERE uniacid=:uniacid AND id=:id LIMIT 1', array(':uniacid' => $_W['uniacid'], ':id' => $storeid));

		if (empty($item)) {
			if ($_W['ispost']) {
				show_json(0, '门店不存在');
			}
			else {
				$this->message('门店不存在');
			}
		}

		$templist = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_newstore_diypage_temp') . 'WHERE (uniacid=:uniacid OR uniacid=0) AND status>0 ORDER BY uniacid asc', array(':uniacid' => $_W['uniacid']));
		$pagelist = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_newstore_diypage') . 'WHERE uniacid=:uniacid AND storeid=:storeid AND status=1', array(':uniacid' => $_W['uniacid'], ':storeid' => $storeid));
		include $this->template();
	}

	/**
     * 门店创建页面
     */
	public function create()
	{
		global $_W;
		global $_GPC;
		$storeid = intval($_GPC['storeid']);
		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_newstore_diypage_temp') . 'WHERE (uniacid=:uniacid OR uniacid=0) AND status>0', array(':uniacid' => $_W['uniacid']));
		include $this->template();
	}

	/**
     * 页面/模板预览
     */
	public function preview()
	{
		global $_W;
		global $_GPC;
		$storeid = intval($_GPC['storeid']);
		$pageid = intval($_GPC['id']);
		$ispage = intval($_GPC['ispage']);
		$previewurl = mobileUrl('newstore/stores/detail', array('id' => $storeid, 'pageid' => $pageid, 'preview' => '1', 'ispage' => $ispage), true);

		if (!empty($ispage)) {
			$editurl = webUrl('store/diypage/page/edit', array('id' => $pageid));
		}
		else {
			$editurl = webUrl('store/diypage/edit', array('id' => $pageid));
		}

		include $this->template();
	}

	/**
     * 设置门店模板/页面
     * @param $storeid
     */
	protected function updatePage($storeid)
	{
		global $_W;
		global $_GPC;
		$diypage = trim($_GPC['diypage']);

		if (strexists($diypage, 'temp')) {
			$diypage = str_replace('temp_', '', $diypage);
			$diypage_ispage = 0;
		}
		else {
			$diypage = str_replace('page_', '', $diypage);
			$diypage_ispage = 1;
		}

		$diypage = intval($diypage);

		if ($diypage == 0) {
			$diypage_ispage = 0;
		}

		pdo_update('ewei_shop_store', array('diypage' => $diypage, 'diypage_ispage' => $diypage_ispage), array('uniacid' => $_W['uniacid'], 'id' => $storeid));
		show_json(1, '门店页面设置成功');
	}

	/**
     * 设置门店可用模板
     * @param $storeid
     */
	protected function updateList($storeid)
	{
		global $_W;
		global $_GPC;
		$templist = $_GPC['templist'];
		$templist = is_array($templist) && !empty($templist) ? implode(',', $templist) : '';
		pdo_update('ewei_shop_store', array('diypage_list' => $templist), array('uniacid' => $_W['uniacid'], 'id' => $storeid));
		show_json(1, '门店可用模板设置成功');
	}

	public function goods_query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$storeid = intval($_GPC['storeid']);
		$params = array(':uniacid' => $_W['uniacid']);

		if (empty($storeid)) {
			$condition = ' AND status=1 AND deleted=0 AND merchid=0 AND uniacid=:uniacid AND `type`!=10 ';

			if (!empty($kwd)) {
				$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
				$params[':keywords'] = '%' . $kwd . '%';
			}

			$list = pdo_fetchall('SELECT id, title, thumb, minprice, productprice, total, sales FROM ' . tablename('ewei_shop_goods') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);
		}
		else {
			$condition = ' AND ng.status=1 AND g.deleted=0 AND g.merchid=0 AND g.uniacid=:uniacid AND g.type!=10 AND ng.storeid=:storeid';
			$params[':storeid'] = $storeid;
			$list = pdo_fetchall('SELECT g.id, g.title, g.subtitle, g.thumb, ng.sminprice, g.productprice, g.total, g.sales FROM ' . tablename('ewei_shop_goods') . ' g LEFT JOIN ' . tablename('ewei_shop_newstore_goods') . (' ng ON ng.goodsid=g.id WHERE 1 ' . $condition . ' order by g.createtime desc'), $params);
		}

		$ds = set_medias($list, array('thumb', 'share_icon'));
		include $this->template('goods/query');
	}

	public function goods_group()
	{
		global $_W;
		global $_GPC;
		$condition = ' AND uniacid=:uniacid ';
		$params = array(':uniacid' => $_W['uniacid']);
		$kwd = trim($_GPC['keyword']);

		if (!empty($kwd)) {
			$condition .= ' AND `name` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_newstore_goodsgroup') . (' WHERE 1 ' . $condition . ' order by id desc'), $params);
		include $this->template('goods/group/query');
	}

	/**
     * 站点模板列表
     */
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$keyword = trim($_GPC['keyword']);
		$condition = ' AND (uniacid=:uniacid OR uniacid=0)';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['status'] != '') {
			$condition .= ' AND (status=:status OR uniacid=0)';
			$params[':status'] = intval($_GPC['status']);
		}

		if (!empty($keyword)) {
			$condition .= ' AND name LIKE :keyword';
			$params[':keyword'] = '%' . $keyword . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_newstore_diypage_temp') . (' WHERE 1 ' . $condition . '  ORDER BY uniacid ASC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_newstore_diypage_temp') . (' WHERE 1 ' . $condition), $params);
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

		if (!p('newstore')) {
			$this->message('O2O应用未安装');
		}

		$id = intval($_GPC['id']);
		$item = p('newstore')->getDiyPage($id, 0, false);
		$initJson = json_encode(array('id' => $id, 'data' => $item['data'], 'storeid' => 0, 'type' => 0, 'attachurl' => $_W['attachurl'], 'newstore' => $_W['plugin'] == 'newstore'));
		include $this->template();
	}

	public function save()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$storeid = intval($_GPC['storeid']);
		$data = $_GPC['data'];
		p('newstore')->saveDiyPageTemp($id, $data);
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

		$items = pdo_fetchall('SELECT id, `name` FROM ' . tablename('ewei_shop_newstore_diypage_temp') . (' WHERE id in( ' . $id . ' ) AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']));

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_delete('ewei_shop_newstore_diypage_temp', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('newstore.diypage.delete', '修改模板状态<br/>ID: ' . $item['id'] . '<br/>模板名称: ' . $item['name']);
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

		$items = pdo_fetchall('SELECT id, `name` FROM ' . tablename('ewei_shop_newstore_diypage_temp') . (' WHERE id in( ' . $id . ' ) AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']));

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_update('ewei_shop_newstore_diypage_temp', array('status' => intval($_GPC['status'])), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('newstore.diypage.status', '修改模板状态<br/>ID: ' . $item['id'] . '<br/>模板名称: ' . $item['name'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '启用' : '禁用');
			}
		}

		show_json(1);
	}
}

?>
