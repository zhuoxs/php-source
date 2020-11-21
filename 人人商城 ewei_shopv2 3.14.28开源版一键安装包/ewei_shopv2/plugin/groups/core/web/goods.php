<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Goods_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' g.uniacid = :uniacid ';
		$params = array(':uniacid' => $_W['uniacid']);
		$type = $_GPC['type'];

		switch ($type) {
		case 'sale':
			$condition .= ' and g.deleted = 0 and g.stock > 0 and g.status = 1 ';
			break;

		case 'sold':
			$condition .= ' and g.deleted = 0 and g.stock <= 0 and g.status = 1 ';
			break;

		case 'store':
			$condition .= ' and g.deleted = 0 and g.status = 0 ';
			break;

		case 'recycle':
			$condition .= ' and g.deleted = 1 ';
			break;

		default:
			$condition .= ' and g.deleted = 0 and g.stock > 0 and g.status = 1 ';
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND title LIKE :title';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		if ($_GPC['status'] != '') {
			$condition .= ' AND status = :status';
			$params[':status'] = intval($_GPC['status']);
		}

		if ($_GPC['category'] != '') {
			$condition .= ' AND category = :category';
			$params[':category'] = intval($_GPC['category']);
		}

		$sql = 'SELECT c.*,g.* FROM ' . tablename('ewei_shop_groups_goods') . ' AS g
				LEFT JOIN ' . tablename('ewei_shop_groups_category') . (' AS c ON g.category = c.id
				where  1 = 1 and ' . $condition . ' ORDER BY g.displayorder DESC,g.id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_groups_goods') . (' AS g where 1 and ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		$category = pdo_fetchall('select id,name,thumb from ' . tablename('ewei_shop_groups_category') . ' where uniacid=:uniacid order by displayorder desc', array(':uniacid' => $_W['uniacid']), 'id');
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
		$item = pdo_fetch('SELECT g.*,c.name as catename FROM ' . tablename('ewei_shop_groups_goods') . ' as g
				left join ' . tablename('ewei_shop_groups_category') . ' as c on c.id = g.category
				WHERE g.id =:id and g.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));
		$item['content'] = m('common')->html_to_images($item['content']);
		$category = pdo_fetchall('select id,name,thumb from ' . tablename('ewei_shop_groups_category') . ' where uniacid=:uniacid order by displayorder desc', array(':uniacid' => $_W['uniacid']));
		$group_goods_id = $item['id'];

		if (!empty($item['thumb'])) {
			$piclist = iunserializer($item['thumb_url']);
		}

		$stores = array();

		if (!empty($item['storeids'])) {
			$stores = pdo_fetchall('select id,storename from ' . tablename('ewei_shop_store') . ' where id in (' . $item['storeids'] . ' ) and uniacid=' . $_W['uniacid']);
		}

		$specs = array();

		if (!empty($item['more_spec'])) {
			$specs = pdo_getall('ewei_shop_groups_goods_option', array('groups_goods_id' => $item['id']));
		}

		$ladder = array();

		if (!empty($item['is_ladder'])) {
			$ladder = pdo_getall('ewei_shop_groups_ladder', array('goods_id' => $item['id']));
		}

		$dispatch_data = pdo_fetchall('select * from ' . tablename('ewei_shop_dispatch') . ' where uniacid=:uniacid and enabled=1 order by displayorder desc', array(':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'displayorder' => intval($_GPC['displayorder']), 'gid' => intval($_GPC['gid']), 'title' => trim($_GPC['title']), 'category' => intval($_GPC['category']), 'thumb' => '', 'thumb_url' => '', 'price' => floatval($_GPC['price']), 'groupsprice' => floatval($_GPC['groupsprice']), 'single' => intval($_GPC['single']), 'singleprice' => floatval($_GPC['singleprice']), 'goodsnum' => intval($_GPC['goodsnum']) < 1 ? 1 : intval($_GPC['goodsnum']), 'purchaselimit' => intval($_GPC['purchaselimit']), 'units' => trim($_GPC['units']), 'stock' => intval($_GPC['stock']), 'showstock' => intval($_GPC['showstock']), 'sales' => intval($_GPC['sales']), 'teamnum' => intval($_GPC['teamnum']), 'dispatchtype' => intval($_GPC['dispatchtype']), 'freight' => floatval($_GPC['freight']), 'status' => intval($_GPC['status']), 'isindex' => intval($_GPC['isindex']), 'groupnum' => intval($_GPC['groupnum']), 'endtime' => intval($_GPC['endtime']), 'description' => trim($_GPC['description']), 'goodssn' => trim($_GPC['goodssn']), 'productsn' => trim($_GPC['productsn']), 'content' => m('common')->html_images($_GPC['content']), 'createtime' => $_W['timestamp'], 'share_title' => trim($_GPC['share_title']), 'share_icon' => trim($_GPC['share_icon']), 'share_desc' => trim($_GPC['share_desc']), 'followneed' => intval($_GPC['followneed']), 'followtext' => trim($_GPC['followtext']), 'followurl' => trim($_GPC['followurl']), 'goodsid' => intval($_GPC['goodsid']), 'deduct' => floatval($_GPC['deduct']), 'isdiscount' => intval($_GPC['isdiscount']), 'discount' => intval($_GPC['discount']), 'headstype' => intval($_GPC['headstype']), 'headsmoney' => floatval($_GPC['headsmoney']), 'headsdiscount' => intval($_GPC['headsdiscount']), 'isverify' => intval($_GPC['isverify']), 'verifytype' => intval($_GPC['verifytype']), 'verifynum' => intval($_GPC['verifynum']), 'storeids' => is_array($_GPC['storeids']) ? implode(',', $_GPC['storeids']) : '', 'more_spec' => intval($_GPC['more_spec']), 'is_ladder' => intval($_GPC['is_ladder']));
			if ($data['is_ladder'] == 1 && $data['more_spec'] == 1) {
				show_json(0, '多规格和团购不能同时开启');
			}

			if ($data['groupsprice'] < $data['headsmoney']) {
				$data['headsmoney'] = $data['groupsprice'];
			}

			if (!empty($data['verifytype']) && $data['verifynum'] < 1) {
				$data['verifynum'] = 1;
			}

			if ($data['headsmoney'] < 0) {
				$data['headsmoney'] = 0;
			}

			if ($data['headsdiscount'] < 0) {
				$data['headsdiscount'] = 0;
			}

			if (100 < $data['headsdiscount']) {
				$data['headsdiscount'] = 100;
			}

			if ($data['goodsnum'] < 0 && empty($data['is_ladder'])) {
				show_json(0, '数量不能小于1！');
			}

			if ($data['groupnum'] < 2 && empty($data['is_ladder'])) {
				show_json(0, '开团人数至少为2人！');
			}

			if ($data['endtime'] < 1) {
				show_json(0, '组团限时不能小于1小时！');
			}

			if ($data['groupsprice'] <= 0 && empty($data['is_ladder']) && empty($data['more_spec'])) {
				show_json(0, '拼团价格不符合要求！');
			}

			if ($data['singleprice'] <= 0 && $data['single'] == 1 && empty($data['more_spec'])) {
				show_json(0, '单购价格不符合要求！');
			}

			$data['title'] = empty($data['goodstype']) ? trim($_GPC['goodsid_text']) : trim($_GPC['couponid_text']);
			$spec = array();

			if ($data['more_spec']) {
				if (empty($_GPC['spec'])) {
					show_json(0, '请填写商品规格');
				}

				$spec = $_GPC['spec'];
				$stock = 0;

				foreach ($spec as $v) {
					$stock += $v['stock'];
				}

				$data['stock'] = $stock;
			}

			$ladder = array();

			if ($data['is_ladder']) {
				$ladder_num = $_GPC['ladder_num'];
				$ladder_price = $_GPC['ladder_price'];
				if (empty($ladder_num) || empty($ladder_price)) {
					show_json(0, '请填写正确阶梯团数据');
				}

				foreach ((array) $ladder_num as $k => $v) {
					if (empty($v) || empty($ladder_price[$k])) {
						show_json(0, '请填写正确阶梯团数据');
					}

					if ($v == 1) {
						show_json(0, '阶梯团不能少于两人哦');
					}

					$ladder[$k]['ladder_num'] = $v;
					$ladder[$k]['ladder_price'] = $ladder_price[$k];
				}
			}

			if (empty($_GPC['thumbs'])) {
				show_json(0, '请上传图片');
			}

			if (is_array($_GPC['thumbs'])) {
				$thumbs = $_GPC['thumbs'];
				$thumb_url = array();

				foreach ($thumbs as $th) {
					$thumb_url[] = trim($th);
				}

				$data['thumb'] = save_media($thumb_url[0]);
				$data['thumb_url'] = serialize(m('common')->array_images($thumb_url));
			}

			if (!empty($id)) {
				$goods_update = pdo_update('ewei_shop_groups_goods', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));

				if (!$goods_update) {
					show_json(0, '商品编辑失败！');
				}

				if (!empty($ladder)) {
					$ladder_id = $_GPC['ladder_id'];
					$ladder_id_str = trim(@implode(',', $ladder_id), ',');

					foreach ($ladder as $k => $v) {
						if ($ladder_id[$k]) {
							pdo_update('ewei_shop_groups_ladder', $v, array('id' => $ladder_id[$k]));
						}
						else {
							$v['goods_id'] = $id;
							$v['uniacid'] = $_W['uniacid'];
							pdo_insert('ewei_shop_groups_ladder', $v);
							$ladder_id_str .= ',' . pdo_insertid();
						}
					}

					$ladder_id_str = trim($ladder_id_str, ',');

					if (!empty($ladder_id_str)) {
						pdo_query('DELETE FROM ' . tablename('ewei_shop_groups_ladder') . (' WHERE id NOT IN(' . $ladder_id_str . ') AND goods_id = :goods_id'), array(':goods_id' => $id));
					}
				}

				if ($data['more_spec'] != 1) {
					$this->del_spec($id);
				}

				if (!empty($spec)) {
					$this->dispose_spec($spec, $id, intval($_GPC['gid']));
				}

				plog('groups.goods.edit', '编辑拼团商品 ID: ' . $id . ' <br/>商品名称: ' . $data['title']);
			}
			else {
				$goods_insert = pdo_insert('ewei_shop_groups_goods', $data);

				if (!$goods_insert) {
					show_json(0, '商品添加失败！');
				}

				$id = pdo_insertid();
				$gid = intval($data['gid']);

				if ($gid) {
					pdo_update('ewei_shop_goods', array('groupstype' => 1), array('id' => $gid, 'uniacid' => $_W['uniacid']));

					if (!empty($spec)) {
						$this->dispose_spec($spec, $id, $gid);
					}
				}

				if (!empty($ladder)) {
					foreach ($ladder as $k => $v) {
						$v['goods_id'] = $id;
						$v['uniacid'] = $_W['uniacid'];
						pdo_insert('ewei_shop_groups_ladder', $v);
					}
				}

				plog('groups.goods.add', '添加拼团商品 ID: ' . $id . '  <br/>商品名称: ' . $data['title']);
			}

			show_json(1, array('url' => webUrl('groups/goods/edit', array('op' => 'post', 'id' => $id, 'tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		include $this->template();
	}

	/**
     * 规格处理
     * @param $spec
     * @param $goods_id
     * @return bool
     */
	public function dispose_spec($spec, $groups_goods_id, $goods_id = 0)
	{
		global $_W;

		foreach ($spec as $k => $v) {
			$specs = explode('_', $v['specs']);
			asort($specs);
			$data = array('goods_option_id' => $v['goods_option_id'], 'title' => $v['name'], 'uniacid' => $_W['uniacid'], 'marketprice' => $v['marketprice'], 'single_price' => $v['single_price'], 'price' => $v['price'], 'stock' => $v['stock'], 'specs' => implode('_', $specs), 'groups_goods_id' => $groups_goods_id);

			if ($goods_id) {
				$data['goodsid'] = $goods_id;
			}

			if (empty($v['id'])) {
				pdo_insert('ewei_shop_groups_goods_option', $data);
			}
			else {
				pdo_update('ewei_shop_groups_goods_option', $data, array('id' => $v['id']));
			}
		}

		return true;
	}

	public function total()
	{
		global $_W;
		global $_GPC;
		$type = intval($_GPC['type']);
		$condition = ' uniacid = :uniacid ';
		$params[':uniacid'] = $_W['uniacid'];

		if ($type == 1) {
			$condition .= ' and deleted = 0 and stock > 0 and status = 1 ';
		}
		else if ($type == 2) {
			$condition .= ' and deleted = 0 and stock = 0 and status = 1';
		}
		else if ($type == 3) {
			$condition .= ' and deleted = 0 and status = 0 ';
		}
		else {
			if ($type == 4) {
				$condition .= ' and deleted = 1 ';
			}
		}

		$total = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_goods') . ' where ' . $condition . ' ', $params);
		echo json_encode($total);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 8;
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid and merchid = 0 and type = 1 and status = 1 and deleted = 0 ';

		if (!empty($kwd)) {
			$condition .= ' AND `title` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id as gid,title,subtitle,thumb,thumb_url,marketprice,content,productprice,subtitle,goodssn,productsn,followtip,followurl
				FROM ' . tablename('ewei_shop_goods') . (' WHERE 1 ' . $condition . ' order by createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($ds as &$d) {
			if (!empty($d['thumb_url'])) {
				$d['thumb_url'] = iunserializer($d['thumb_url']);
			}

			$d['content'] = m('common')->html_to_images($d['content']);
			$d['content'] = str_replace('\'', '"', $d['content']);
		}

		unset($d);
		$ds = set_medias($ds, array('share_icon'));

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_goods') . (' WHERE 1 ' . $condition . ' '), $params);
		$pager = pagination2($total, $pindex, $psize, '', array('before' => 5, 'after' => 4, 'ajaxcallback' => 'select_page', 'callbackfuncname' => 'select_page'));
		include $this->template();
	}

	public function delete1()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title,gid FROM ' . tablename('ewei_shop_groups_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_groups_goods', array('id' => $item['id']));
			pdo_delete('ewei_shop_groups_goods_option', array('groups_goods_id' => $item['id']));
			plog('groups.goods.edit', '从回收站彻底删除商品<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['title']);
		}

		show_json(1, array('url' => referer()));
	}

	public function restore()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title,gid FROM ' . tablename('ewei_shop_groups_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_groups_goods', array('deleted' => 0, 'status' => 0), array('id' => $item['id']));

			if (intval($item['gid'])) {
				pdo_update('ewei_shop_goods', array('groupstype' => 1), array('id' => $item['gid'], 'uniacid' => $_W['uniacid']));
			}

			plog('groups.goods.edit', '从回收站恢复商品<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['title']);
		}

		show_json(1, array('url' => referer()));
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title,gid FROM ' . tablename('ewei_shop_groups_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			$delete_update = pdo_update('ewei_shop_groups_goods', array('deleted' => 1, 'status' => 0), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));

			if (!$delete_update) {
				show_json(0, '删除商品失败！');
			}

			if (intval($item['gid'])) {
				pdo_update('ewei_shop_goods', array('groupstype' => 0), array('id' => $item['gid'], 'uniacid' => $_W['uniacid']));
			}

			plog('groups.goods.delete', '删除拼团商品 ID: ' . $item['id'] . '  <br/>商品名称: ' . $item['title'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$status = intval($_GPC['status']);
		$items = pdo_fetchall('SELECT id,status FROM ' . tablename('ewei_shop_groups_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			$status_update = pdo_update('ewei_shop_groups_goods', array('status' => $status), array('id' => $item['id']));

			if (!$status_update) {
				throw new Exception('商品状态修改失败！');
			}

			plog('groups.goods.edit', '修改拼团商品 ' . $item['id'] . ' <br /> 状态: ' . ($status == 0 ? '下架' : '上架'));
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

		if (in_array($type, array('status', 'displayorder'))) {
			$statusstr = '';

			if ($type == 'status') {
				$typestr = '上下架';
				$statusstr = $value == 1 ? '上架' : '下架';
			}
			else if ($type == 'displayorder') {
				$typestr = '排序';
				$statusstr = '序号 ' . $value;
			}
			else {
				if ($type == 'isindex') {
					$typestr = '是否首页显示';
					$statusstr = $value == 1 ? '是' : '否';
				}
			}

			$property_update = pdo_update('ewei_shop_groups_goods', array($type => $value), array('id' => $id, 'uniacid' => $_W['uniacid']));

			if (!$property_update) {
				throw new Exception('' . $typestr . '修改失败');
			}

			plog('groups.goods.edit', '修改拼团商品' . $typestr . '状态   ID: ' . $id . ' ' . $statusstr . ' ');
		}

		show_json(1);
	}

	/**
     * 获取商品规格
     */
	public function get_spec()
	{
		global $_W;
		global $_GPC;
		$goods_id = intval($_GPC['goods_id']);
		$group_goods_id = intval($_GPC['group_goods_id']);
		$shop_goods_id = intval($_GPC['shop_goods_id']);
		if (!$goods_id && !$group_goods_id) {
			show_json(0, '请先选择商品');
		}

		if ($group_goods_id && empty($shop_goods_id)) {
			show_json(0, '没有关联商城多规格商品无法添加多规格');
		}

		if ($shop_goods_id) {
			$goods_id = $shop_goods_id;
		}

		$specArr = pdo_getall('ewei_shop_goods_option', array('goodsid' => $goods_id), array('id', 'title', 'thumb', 'marketprice', 'stock', 'specs'));

		if (!empty($specArr)) {
			$stock = 0;

			foreach ($specArr as $k => $v) {
				$stock += $v['stock'];
			}
		}
		else {
			show_json(0, '此商品没有多规格');
		}

		show_json(1, array('data' => $specArr, 'stock' => $stock));
	}

	/**
     * 重新开启规格时删除旧数据
     */
	public function del_spec($goods_id)
	{
		$spec = pdo_getall('ewei_shop_groups_goods_option', array('groups_goods_id' => $goods_id));

		if (!empty($spec)) {
			return pdo_delete('ewei_shop_groups_goods_option', array('groups_goods_id' => $goods_id));
		}

		return true;
	}
}

?>
