<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/page_cashier.php';
class Index_EweiShopV2Page extends CashierWebPage
{
	public function manageMenus()
	{
		global $_GPC;
		global $_W;
		include $this->template('sysset/tabs');
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, $_GPC['page']);
		$psize = 20;
		$where = '';
		$params = array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']);

		if (!empty($_GPC['keyword'])) {
			$where = ' AND title LIKE :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_cashier_goods') . (' WHERE uniacid=:uniacid AND cashierid=:cashierid ' . $where . ' ORDER BY id DESC'), $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_cashier_goods') . (' WHERE uniacid=:uniacid AND cashierid=:cashierid ' . $where . ' LIMIT 1'), $params);
		$pager = pagination2($total, $pindex, $psize);
		$category = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_cashier_goods_category') . ' WHERE uniacid=:uniacid and cashierid=:cashierid and status=1 ORDER BY displayorder desc, id DESC', array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']), 'id');
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

		if ($id) {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_cashier_goods') . ' WHERE id=:id AND cashierid=:cashierid limit 1', array(':id' => $id, ':cashierid' => $_W['cashierid']));
		}

		if ($_W['ispost']) {
			$params = array('uniacid' => $_W['uniacid'], 'cashierid' => $_W['cashierid'], 'title' => trim($_GPC['title']), 'image' => trim($_GPC['image']), 'categoryid' => intval($_GPC['categoryid']), 'price' => floatval($_GPC['price']), 'total' => intval($_GPC['total']), 'status' => intval($_GPC['status']), 'goodssn' => trim($_GPC['goodssn']));

			if (!$params['categoryid']) {
				show_json(0, '请选择分类,没有的话请添加分类!');
			}

			if (!$id) {
				$params['createtime'] = TIMESTAMP;
				pdo_insert('ewei_shop_cashier_goods', $params);
				$id = pdo_insertid();
			}
			else {
				pdo_update('ewei_shop_cashier_goods', $params, array('id' => $id, 'cashierid' => $params['cashierid']));
			}

			show_json(1, array('url' => cashierUrl('goodsmanage/edit', array('id' => $id))));
		}

		$category = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_cashier_goods_category') . ' WHERE uniacid=:uniacid and cashierid=:cashierid and status=1 ORDER BY displayorder desc, id DESC', array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']), 'id');
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

		pdo_query('DELETE FROM ' . tablename('ewei_shop_cashier_goods') . (' WHERE id in(' . $id . ') AND cashierid=' . $_W['cashierid'] . ' AND uniacid=') . $_W['uniacid']);
		show_json(1);
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		pdo_query('UPDATE ' . tablename('ewei_shop_cashier_goods') . (' SET `status` =:status WHERE id in( ' . $id . ' ) AND cashierid=' . $_W['cashierid'] . ' AND uniacid=' . $_W['uniacid']), array(':status' => intval($_GPC['status'])));
		show_json(1, array('url' => referer()));
	}

	/**
     * 商品分类页面
     */
	public function cate()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid and cashierid=:cashierid';
		$params = array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']);

		if ($_GPC['status'] != '') {
			$condition .= ' and status=' . intval($_GPC['status']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and catename  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_cashier_goods_category') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder desc, id DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_cashier_goods_category') . (' WHERE 1 ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function cate_add()
	{
		$this->cate_post();
	}

	public function cate_edit()
	{
		$this->cate_post();
	}

	protected function cate_post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'cashierid' => $_W['cashierid'], 'catename' => trim($_GPC['catename']), 'status' => intval($_GPC['status']), 'displayorder' => intval($_GPC['displayorder']));

			if (!empty($id)) {
				pdo_update('ewei_shop_cashier_goods_category', $data, array('id' => $id));
				plog('cashier.category.edit', '修改收银台分类 ID: ' . $id);
			}
			else {
				$data['createtime'] = time();
				pdo_insert('ewei_shop_cashier_goods_category', $data);
				$id = pdo_insertid();
				plog('cashier.category.add', '添加收银台分类 ID: ' . $id);
			}

			show_json(1, array('url' => cashierUrl('goodsmanage/cate')));
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_cashier_goods_category') . ' where id=:id and uniacid=:uniacid and cashierid=:cashierid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']));
		include $this->template('goodsmanage/cate_post');
	}

	/**
     * 商品分类删除
     */
	public function cate_delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,catename FROM ' . tablename('ewei_shop_cashier_goods_category') . (' WHERE id in( ' . $id . ' ) AND cashierid=' . $_W['cashierid'] . ' AND uniacid=' . $_W['uniacid']));

		foreach ($items as $item) {
			pdo_delete('ewei_shop_cashier_goods_category', array('id' => $item['id']));
		}

		show_json(1, array('url' => referer()));
	}

	/**
     * 商品分类 状态修改
     */
	public function cate_status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('UPDATE ' . tablename('ewei_shop_cashier_goods_category') . (' SET `status`=:status WHERE id in( ' . $id . ' ) AND cashierid=' . $_W['cashierid'] . ' AND uniacid=' . $_W['uniacid']), array(':status' => intval($_GPC['status'])));

		foreach ($items as $item) {
			pdo_update('ewei_shop_cashier_goods_category', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
		}

		show_json(1, array('url' => referer()));
	}

	/**
     * 商城商品
     */
	public function goods()
	{
		global $_W;
		global $_GPC;
		if ($_W['ispost'] && $_W['isajax']) {
			if (empty($_GPC['goods_ids'])) {
				$this->updateUserSet(array(
					'goodsmanage' => array()
				));
				show_json(1);
			}

			$goods_ids = explode(',', $_GPC['goods_ids']);
			$this->updateUserSet(array(
				'goodsmanage' => array('goods_ids' => explode(',', $_GPC['goods_ids']))
			));
			show_json(1);
		}

		$item = $this->getUserSet('goodsmanage');

		if (!empty($item['goods_ids'])) {
			$goods_ids = implode(',', $item['goods_ids']);
			$mer_condition = '';

			if ($_W['cashieruser']['merchid']) {
				$mer_condition = ' AND merchid=' . $_W['cashieruser']['merchid'];
			}

			$goods = pdo_fetchall('SELECT id,uniacid,title,thumb FROM ' . tablename('ewei_shop_goods') . (' WHERE uniacid=:uniacid AND cashier=1 AND id IN (' . $goods_ids . ') ' . $mer_condition), array(':uniacid' => $_W['uniacid']));

			if (!empty($goods)) {
				foreach ($goods as &$v) {
					$v['thumb'] = tomedia($v['thumb']);
				}

				unset($v);
			}
		}

		include $this->template();
	}

	public function query_goods()
	{
		global $_W;
		global $_GPC;
		$where = '';
		$params = array('uniacid' => $_W['uniacid'], 'merchid' => $_W['cashieruser']['merchid']);

		if (!empty($_GPC['keyword'])) {
			$where = ' AND (title LIKE :keyword OR subtitle LIKE :keyword OR shorttitle LIKE :keyword)';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$res = pdo_fetchall('SELECT id,uniacid,title,subtitle,shorttitle,thumb FROM ' . tablename('ewei_shop_goods') . (' WHERE uniacid=:uniacid AND merchid=:merchid AND cashier=1 ' . $where), $params);

		if (!empty($res)) {
			foreach ($res as &$v) {
				$v['thumb'] = tomedia($v['thumb']);
			}

			unset($v);
		}

		show_json(1, array('list' => $res));
	}
}

?>
