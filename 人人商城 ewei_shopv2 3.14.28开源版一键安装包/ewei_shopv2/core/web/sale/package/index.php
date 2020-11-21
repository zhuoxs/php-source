<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $uniacid);
		$type = trim($_GPC['type']);

		if ($type == 'ing') {
			$condition .= ' and starttime <= ' . time() . ' and endtime >= ' . time() . ' and deleted = 0 ';
		}
		else if ($type == 'none') {
			$condition .= ' and starttime > ' . time() . ' and deleted = 0 ';
		}
		else {
			if ($type == 'end') {
				$condition .= ' and endtime < ' . time() . ' or deleted = 1 ';
			}
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND title LIKE :title';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		$packages = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_package') . '
                    WHERE 1 ' . $condition . ' ORDER BY displayorder DESC,id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, $params);

		if (!empty($packages)) {
			foreach ($packages as $key => &$value) {
				$url = mobileUrl('goods/package/detail', array('pid' => $value['id']), true);
				$value['qrcode'] = m('qrcode')->createQrcode($url);
			}
		}

		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_package') . ' WHERE 1 ' . $condition . ' ', $params);
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
		$uniacid = intval($_W['uniacid']);
		$type = trim($_GPC['type']);
		$id = intval($_GPC['id']);

		if ($_W['ispost']) {
			$data = array('uniacid' => $uniacid, 'displayorder' => intval($_GPC['displayorder']), 'title' => trim($_GPC['title']), 'thumb' => trim($_GPC['thumb']), 'price' => floatval($_GPC['price']), 'goodsid' => $_GPC['goodsid'], 'cash' => intval($_GPC['cash']), 'dispatchtype' => intval($_GPC['dispatchtype']), 'freight' => floatval($_GPC['freight']), 'starttime' => strtotime($_GPC['starttime']), 'endtime' => strtotime($_GPC['endtime']), 'status' => intval($_GPC['status']), 'share_title' => trim($_GPC['share_title']), 'share_icon' => trim($_GPC['share_icon']), 'share_desc' => trim($_GPC['share_desc']));
			if ($data['thumb'] || $data['share_icon']) {
				$data['thumb'] = save_media($data['thumb']);
				$data['share_icon'] = save_media($data['share_icon']);
			}

			if (empty($_GPC['goodsid'])) {
				show_json(0, '套餐商品不能为空！');
			}
			else {
				$goodsid = $data['goodsid'];
				$data['goodsid'] = is_array($_GPC['goodsid']) ? implode(',', $_GPC['goodsid']) : 0;
			}

			$option = $_GPC['packagegoods'];

			foreach ($goodsid as $key => $value) {
				$good_data = pdo_fetch('select title,thumb,marketprice,goodssn,productsn,hasoption,merchid
                            from ' . tablename('ewei_shop_goods') . ' where id = ' . $value . ' and uniacid = ' . $uniacid . ' ');
				if (0 < $good_data['merchid'] && $data['dispatchtype'] == 0) {
					show_json(0, '套餐中包含多商户商品，请在“运费设置”中选择运费模板！');
				}

				if (empty($data['thumb'])) {
					$data['thumb'] = save_media($good_data['thumb']);
				}

				$good_data['option'] = $option[$value] ? $option[$value] : '';
				if ($good_data['hasoption'] && empty($good_data['option'])) {
					show_json(0, '请选择商品规格！');
				}
			}

			if (!empty($id)) {
				foreach ($goodsid as $key => $value) {
					$packagenum = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_package_goods') . ' where goodsid = :goodsid and uniacid = :uniacid', array(':goodsid' => $value, ':uniacid' => $value));
					$thisgoods = pdo_fetch('select id from ' . tablename('ewei_shop_package_goods') . ' where pid = :pid and goodsid = :goodsid and uniacid = :uniacid ', array(':pid' => $id, 'goodsid' => $value, ':uniacid' => $uniacid));
					if (!$thisgoods && 3 <= $packagenum) {
						show_json(0, '同一件商品最多参与三个套餐活动!');
					}
				}

				$package_update = pdo_update('ewei_shop_package', $data, array('id' => $id, 'uniacid' => $uniacid));
				$package_goods_del = pdo_delete('ewei_shop_package_goods', array('pid' => $id, 'uniacid' => $uniacid));
				$package_goods_option_del = pdo_delete('ewei_shop_package_goods_option', array('pid' => $id, 'goodsid' => $value, 'uniacid' => $uniacid));

				foreach ($goodsid as $key => $value) {
					$good_data = pdo_fetch('select title,thumb,marketprice,goodssn,productsn,hasoption
                            from ' . tablename('ewei_shop_goods') . ' where id = ' . $value . ' and uniacid = ' . $uniacid . ' ');
					$good_data['uniacid'] = $uniacid;
					$good_data['goodsid'] = $value;
					$good_data['pid'] = $id;
					$good_data['option'] = $option[$value] ? $option[$value] : '';
					if (empty($good_data['option']) && !$good_data['hasoption']) {
						$packgoodStr = $_GPC['packgoods' . $value . ''];
						$packgoodArray = explode(',', $packgoodStr);
						$good_data['packageprice'] = $packgoodArray[0];
						$good_data['commission1'] = $packgoodArray[1];
						$good_data['commission2'] = $packgoodArray[2];
						$good_data['commission3'] = $packgoodArray[3];
					}

					$package_goods_insert = pdo_insert('ewei_shop_package_goods', $good_data);

					if (!empty($good_data['option'])) {
						$packageGoodsOption = array_filter(explode(',', $good_data['option']));

						foreach ($packageGoodsOption as $k => $val) {
							$op = pdo_fetch('SELECT id,title,marketprice,goodssn,productsn FROM ' . tablename('ewei_shop_goods_option') . '
                                WHERE uniacid = ' . $uniacid . ' and id = ' . $val . ' ');
							$optionStr = $_GPC['packagegoodsoption' . $val . ''];
							$optionArray = explode(',', $optionStr);
							$optionData = array('uniacid' => $uniacid, 'goodsid' => $value, 'pid' => $id, 'title' => $op['title'], 'optionid' => $val, 'marketprice' => $op['marketprice'], 'packageprice' => $optionArray[0], 'commission1' => $optionArray[1], 'commission2' => $optionArray[2], 'commission3' => $optionArray[3]);
							$package_goods_option_insert = pdo_insert('ewei_shop_package_goods_option', $optionData);

							if (!$package_goods_option_insert) {
								show_json(0, '套餐商品规格添加失败！');
							}
						}
					}

					if (!$package_goods_insert) {
						show_json(0, '套餐商品编辑失败！');
					}
				}

				plog('sale.package.edit', '编辑套餐 ID: ' . $id . ' <br/>套餐名称: ' . $data['title']);
			}
			else {
				foreach ($goodsid as $key => $value) {
					$packagenum = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_package_goods') . ' where uniacid = ' . $uniacid . ' and goodsid = ' . $value . ' ');

					if (3 <= $packagenum) {
						show_json(0, '同一件商品最多参与三个套餐活动!');
					}
				}

				$package_insert = pdo_insert('ewei_shop_package', $data);

				if (!$package_insert) {
					show_json(0, '套餐添加失败！');
				}

				$id = pdo_insertid();

				foreach ($goodsid as $key => $value) {
					$good_data = pdo_fetch('select title,thumb,marketprice,goodssn,productsn,hasoption
                            from ' . tablename('ewei_shop_goods') . ' where id = ' . $value . ' and uniacid = ' . $uniacid . ' ');

					if (empty($data['thumb'])) {
						$data['thumb'] = save_media($good_data['thumb']);
					}

					$good_data['uniacid'] = $uniacid;
					$good_data['goodsid'] = $value;
					$good_data['pid'] = $id;
					$good_data['option'] = $option[$value] ? $option[$value] : '';
					if (empty($good_data['option']) && !$good_data['hasoption']) {
						$packgoodStr = $_GPC['packgoods' . $value . ''];
						$packgoodArray = explode(',', $packgoodStr);
						$good_data['packageprice'] = $packgoodArray[0];
						$good_data['commission1'] = $packgoodArray[1];
						$good_data['commission2'] = $packgoodArray[2];
						$good_data['commission3'] = $packgoodArray[3];
					}

					$package_goods_insert = pdo_insert('ewei_shop_package_goods', $good_data);
					$gid = pdo_insertid();

					if (!empty($good_data['option'])) {
						$packageGoodsOption = array_filter(explode(',', $good_data['option']));

						foreach ($packageGoodsOption as $k => $val) {
							$op = pdo_fetch('SELECT id,title,marketprice,goodssn,productsn FROM ' . tablename('ewei_shop_goods_option') . '
                                WHERE uniacid = ' . $uniacid . ' and id = ' . $val . ' ');
							$optionStr = $_GPC['packagegoodsoption' . $val . ''];
							$optionArray = explode(',', $optionStr);
							$optionData = array('uniacid' => $uniacid, 'goodsid' => $value, 'pid' => $id, 'title' => $op['title'], 'optionid' => $val, 'marketprice' => $op['marketprice'], 'packageprice' => $optionArray[0], 'commission1' => $optionArray[1], 'commission2' => $optionArray[2], 'commission3' => $optionArray[3]);
							$package_goods_option_insert = pdo_insert('ewei_shop_package_goods_option', $optionData);

							if (!$package_goods_option_insert) {
								show_json(0, '套餐商品规格添加失败！');
							}
						}
					}

					if (!$package_goods_insert) {
						show_json(0, '套餐商品添加失败！');
					}
				}

				plog('sale.package.add', '添加套餐 ID: ' . $id . '  <br/>套餐名称: ' . $data['title']);
			}

			show_json(1, array('url' => webUrl('sale/package/edit', array('type' => $type, 'id' => $id))));
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_package') . ' WHERE uniacid = ' . $uniacid . (' and id = ' . $id . ' '));

		if ($item) {
			$item = set_medias($item, array('thumb'));
			$package_goods = array();
			$package_goods = pdo_fetchall('select id,pid,title,thumb,packageprice,hasoption,goodsid,`option`,commission1,commission2,commission3
                            from ' . tablename('ewei_shop_package_goods') . ' where pid = ' . $id . ' and uniacid = ' . $uniacid . ' ');

			foreach ($package_goods as $key => $value) {
				if ($value['hasoption']) {
					$package_goods[$key]['optiontitle'] = pdo_fetchall('select id,goodsid,optionid,pid,packageprice,title,marketprice,commission1,commission2,commission3
                            from ' . tablename('ewei_shop_package_goods_option') . ' where pid = ' . $id . ' and goodsid = ' . $value['goodsid'] . ' and uniacid = ' . $uniacid . ' ');
				}
			}
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_package') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_package', array('deleted' => 1, 'status' => 0), array('id' => $item['id']));
			plog('sale.package.delete', '删除套餐 ID: ' . $item['id'] . ' 套餐名称: ' . $item['title'] . ' ');
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_package') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_package', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('sale.package.edit', '修改套餐状态<br/>ID: ' . $item['id'] . '<br/>套餐名称: ' . $item['title'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '上架' : '下架');
		}

		show_json(1, array('url' => referer()));
	}

	public function delete1()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_package') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_package', array('id' => $item['id']));
			pdo_delete('ewei_shop_package_goods', array('pid' => $item['id']));
			pdo_delete('ewei_shop_package_goods_option', array('pid' => $item['id']));
			plog('sale.package.edit', '彻底删除套餐<br/>ID: ' . $item['id'] . '<br/>套餐名称: ' . $item['title']);
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_package') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_package', array('deleted' => 0), array('id' => $item['id']));
			plog('sale.package.edit', '恢复套餐<br/>ID: ' . $item['id'] . '<br/>套餐名称: ' . $item['title']);
		}

		show_json(1, array('url' => referer()));
	}

	public function change()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			show_json(0, array('message' => '参数错误'));
		}

		$type = trim($_GPC['typechange']);
		$value = trim($_GPC['value']);

		if (!in_array($type, array('title', 'displayorder', 'price'))) {
			show_json(0, array('message' => '参数错误'));
		}

		$package = pdo_fetch('select id from ' . tablename('ewei_shop_package') . ' where id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if (empty($package)) {
			show_json(0, array('message' => '参数错误'));
		}

		pdo_update('ewei_shop_package', array($type => $value), array('id' => $id));
		show_json(1);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$kwd = trim($_GPC['keyword']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 8;
		$params = array();
		$params[':uniacid'] = $uniacid;
		$condition = ' and status=1 and deleted=0 and uniacid=:uniacid ';

		if (!empty($kwd)) {
			$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
			$params[':keywords'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title,thumb,marketprice,total,goodssn,productsn,`type`,isdiscount,istime,isverify,share_title,share_icon,description,hasoption,nocommission,groupstype,merchid
            FROM ' . tablename('ewei_shop_goods') . ('
            WHERE 1 ' . $condition . ' ORDER BY displayorder DESC,id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($ds as $key => $row) {
			if (0 < $row['merchid']) {
				$merch = pdo_fetch('select merchname from ' . tablename('ewei_shop_merch_user') . ' where id = :merchid and uniacid = :uniacid ', array(':merchid' => $row['merchid'], ':uniacid' => $uniacid));
				$ds[$key]['merchname'] = $merch['merchname'];
			}
		}

		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_goods') . ' WHERE 1 ' . $condition . ' ', $params);
		$pager = pagination2($total, $pindex, $psize, '', array('before' => 5, 'after' => 4, 'ajaxcallback' => 'select_page', 'callbackfuncname' => 'select_page'));
		$ds = set_medias($ds, array('thumb'));
		include $this->template();
	}

	public function hasoption()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$goodsid = intval($_GPC['goodsid']);
		$pid = intval($_GPC['pid']);
		$hasoption = 0;
		$params = array(':uniacid' => $uniacid, ':goodsid' => $goodsid);
		$commission_level = 0;

		if (p('commission')) {
			$data = m('common')->getPluginset('commission');
			$commission_level = $data['level'];
		}

		$goods = pdo_fetch('select id,title,marketprice,hasoption,nocommission from ' . tablename('ewei_shop_goods') . ' where uniacid = :uniacid and id = :goodsid ', $params);

		if (!empty($pid)) {
			$packgoods = pdo_fetch('select id,title,packageprice,commission1,commission2,commission3,`option`,goodsid from ' . tablename('ewei_shop_package_goods') . '
                        where pid = ' . $pid . ' and uniacid = :uniacid and goodsid = :goodsid ', $params);
		}
		else {
			$packgoods = array('title' => $goods['title'], 'marketprice' => $goods['marketprice'], 'packageprice' => 0, 'commission1' => 0, 'commission2' => 0, 'commission3' => 0);
		}

		if ($goods['hasoption']) {
			$hasoption = 1;
			$option = array();
			$option = pdo_fetchall('SELECT id,title,marketprice,specs,displayorder FROM ' . tablename('ewei_shop_goods_option') . '
            WHERE uniacid = :uniacid and goodsid = :goodsid  ORDER BY displayorder DESC,id DESC ', $params);
			$package_option = pdo_fetchall('SELECT id,uniacid,goodsid,optionid,pid,title,marketprice,packageprice,commission1,commission2,commission3 FROM ' . tablename('ewei_shop_package_goods_option') . '
            WHERE uniacid = :uniacid and goodsid = :goodsid  and pid = ' . $pid . ' ', $params);

			foreach ($option as $key => $value) {
				foreach ($package_option as $k => $val) {
					if ($value['id'] == $val['optionid']) {
						$option[$key]['packageprice'] = $val['packageprice'];
						$option[$key]['commission1'] = $val['commission1'];
						$option[$key]['commission2'] = $val['commission2'];
						$option[$key]['commission3'] = $val['commission3'];
						continue;
					}
				}

				if (strpos($packgoods['option'], $value['id']) !== false) {
					$option[$key]['isoption'] = 1;
				}
			}
		}
		else {
			$packgoods['marketprice'] = $goods['marketprice'];
		}

		include $this->template();
	}

	public function option()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$options = is_array($_GPC['option']) ? implode(',', array_filter($_GPC['option'])) : 0;
		$options = intval($options);
		$option = pdo_fetch('SELECT id,title FROM ' . tablename('ewei_shop_goods_option') . '
            WHERE uniacid = ' . $uniacid . ' and id = ' . $options . '  ORDER BY displayorder DESC,id DESC LIMIT 1');
		show_json(1, $option);
	}
}

?>
