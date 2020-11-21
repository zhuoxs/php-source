<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main($goodsfrom = 'sale')
	{
		global $_W;
		global $_GPC;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$sqlcondition = $groupcondition = '';
		$condition = ' WHERE g.`uniacid` = :uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$sqlcondition = ' left join ' . tablename('ewei_shop_goods_option') . ' op on g.id = op.goodsid';

			if ($merch_plugin) {
				$sqlcondition .= ' left join ' . tablename('ewei_shop_merch_user') . ' merch on merch.id = g.merchid and merch.uniacid=g.uniacid';
			}

			$groupcondition = ' group by g.`id`';
			$condition .= ' AND (g.`id` = :id or g.`title` LIKE :keyword or g.`keywords` LIKE :keyword or g.`goodssn` LIKE :keyword or g.`productsn` LIKE :keyword or op.`title` LIKE :keyword or op.`goodssn` LIKE :keyword or op.`productsn` LIKE :keyword';

			if ($merch_plugin) {
				$condition .= ' or merch.`merchname` LIKE :keyword';
			}

			$condition .= ' )';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
			$params[':id'] = $_GPC['keyword'];
		}

		if (!empty($_GPC['cate'])) {
			$_GPC['cate'] = intval($_GPC['cate']);
			$condition .= ' AND FIND_IN_SET(' . $_GPC['cate'] . ',cates)<>0 ';
		}

		empty($goodsfrom) && $_GPC['goodsfrom'] = $goodsfrom = 'sale';
		$_GPC['goodsfrom'] = $goodsfrom;

		if ($goodsfrom == 'sale') {
			$condition .= ' AND g.`status` > 0 and g.`checked`=0 and g.`total`>0 and g.`deleted`=0 and g.type=9';
			$status = 1;
		}
		else if ($goodsfrom == 'out') {
			$condition .= ' AND g.`status` > 0 and g.`total` <= 0 and g.`deleted`=0 and g.type=9';
			$status = 1;
		}
		else if ($goodsfrom == 'stock') {
			$status = 0;
			$condition .= ' AND (g.`status` = 0 or g.`checked`=1) and g.`deleted`=0 and g.type=9';
		}
		else {
			if ($goodsfrom == 'cycle') {
				$status = 0;
				$condition .= ' AND g.`deleted`=1 and g.type=9';
			}
		}

		$sql = 'SELECT g.id FROM ' . tablename('ewei_shop_goods') . 'g' . $sqlcondition . $condition . $groupcondition;
		$total_all = pdo_fetchall($sql, $params);
		$total = count($total_all);
		unset($total_all);

		if (!empty($total)) {
			$sql = 'SELECT g.* FROM ' . tablename('ewei_shop_goods') . 'g' . $sqlcondition . $condition . $groupcondition . ' ORDER BY g.`status` DESC, g.`displayorder` DESC,
                g.`id` DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);

			foreach ($list as $key => &$value) {
				$url = mobileUrl('goods/detail', array('id' => $value['id']), true);
				$value['qrcode'] = m('qrcode')->createQrcode($url);
			}

			$pager = pagination2($total, $pindex, $psize);

			if ($merch_plugin) {
				$merch_user = $merch_plugin->getListUser($list, 'merch_user');
				if (!empty($list) && !empty($merch_user)) {
					foreach ($list as &$row) {
						$row['merchname'] = $merch_user[$row['merchid']]['merchname'] ? $merch_user[$row['merchid']]['merchname'] : $_W['shopset']['shop']['name'];
					}
				}
			}
		}

		$categorys = m('shop')->getFullCategory(true);
		$category = array();

		foreach ($categorys as $cate) {
			$category[$cate['id']] = $cate;
		}

		$goodstotal = intval($_W['shopset']['shop']['goodstotal']);
		include $this->template('cycelbuy/goods');
	}

	public function sale()
	{
		$this->main('sale');
	}

	public function out()
	{
		$this->main('out');
	}

	public function stock()
	{
		$this->main('stock');
	}

	public function cycle()
	{
		$this->main('cycle');
	}

	public function verify()
	{
		$this->main('verify');
	}

	public function create()
	{
		global $_W;
		global $_GPC;
		$merchid = intval($_W['merchid']);
		$com_virtual = com('virtual');
		$levels = m('member')->getLevels();

		foreach ($levels as &$l) {
			$l['key'] = 'level' . $l['id'];
		}

		unset($l);

		if ($_W['ispost']) {
			$data = array('uniacid' => intval($_W['uniacid']), 'title' => trim($_GPC['goodsname']), 'unit' => trim($_GPC['unit']), 'keywords' => trim($_GPC['keywords']), 'type' => intval($_GPC['type']), 'thumb_first' => intval($_GPC['thumb_first']), 'isrecommand' => intval($_GPC['isrecommand']), 'isnew' => intval($_GPC['isnew']), 'ishot' => intval($_GPC['ishot']), 'issendfree' => intval($_GPC['issendfree']), 'isnodiscount' => intval($_GPC['isnodiscount']), 'marketprice' => floatval($_GPC['marketprice']), 'minprice' => floatval($_GPC['marketprice']), 'maxprice' => floatval($_GPC['marketprice']), 'productprice' => trim($_GPC['productprice']), 'costprice' => $_GPC['costprice'], 'virtualsend' => intval($_GPC['virtualsend']), 'virtualsendcontent' => trim($_GPC['virtualsendcontent']), 'virtual' => intval($_GPC['type']) == 3 ? intval($_GPC['virtual']) : 0, 'cash' => intval($_GPC['cash']), 'cashier' => intval($_GPC['cashier']), 'invoice' => intval($_GPC['invoice']), 'dispatchtype' => intval($_GPC['dispatchtype']), 'dispatchprice' => trim($_GPC['dispatchprice']), 'dispatchid' => intval($_GPC['dispatchid']), 'status' => intval($_GPC['status']), 'goodssn' => trim($_GPC['goodssn']), 'productsn' => trim($_GPC['productsn']), 'weight' => $_GPC['weight'], 'total' => intval($_GPC['total']), 'showtotal' => intval($_GPC['showtotal']), 'totalcnf' => intval($_GPC['totalcnf']), 'hasoption' => intval($_GPC['hasoption']), 'subtitle' => trim($_GPC['subtitle']), 'shorttitle' => trim($_GPC['shorttitle']), 'content' => m('common')->html_images($_GPC['content']), 'createtime' => TIMESTAMP, 'video' => trim($_GPC['video']));
			$discounts = array('type' => 0, 'default' => '', 'default_pay' => '');

			if (!empty($levels)) {
				foreach ($levels as $level) {
					$discounts[$level['key']] = '';
					$discounts[$level['key'] . '_pay'] = '';
				}

				unset($level);
			}

			$data['discounts'] = json_encode($discounts);
			$cateset = m('common')->getSysset('shop');
			$pcates = array();
			$ccates = array();
			$tcates = array();
			$fcates = array();
			$cates = array();
			$pcateid = 0;
			$ccateid = 0;
			$tcateid = 0;

			if (is_array($_GPC['cates'])) {
				$cates = $_GPC['cates'];

				foreach ($cates as $key => $cid) {
					$c = pdo_fetch('select level from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));

					if ($c['level'] == 1) {
						$pcates[] = $cid;
					}
					else if ($c['level'] == 2) {
						$ccates[] = $cid;
					}
					else {
						if ($c['level'] == 3) {
							$tcates[] = $cid;
						}
					}

					if ($key == 0) {
						if ($c['level'] == 1) {
							$pcateid = $cid;
						}
						else if ($c['level'] == 2) {
							$crow = pdo_fetch('select parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
							$pcateid = $crow['parentid'];
							$ccateid = $cid;
						}
						else {
							if ($c['level'] == 3) {
								$tcateid = $cid;
								$tcate = pdo_fetch('select id,parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
								$ccateid = $tcate['parentid'];
								$ccate = pdo_fetch('select id,parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $ccateid, ':uniacid' => $_W['uniacid']));
								$pcateid = $ccate['parentid'];
							}
						}
					}
				}
			}

			$data['pcate'] = $pcateid;
			$data['ccate'] = $ccateid;
			$data['tcate'] = $tcateid;
			$data['cates'] = implode(',', $cates);
			$data['pcates'] = implode(',', $pcates);
			$data['ccates'] = implode(',', $ccates);
			$data['tcates'] = implode(',', $tcates);

			if (is_array($_GPC['thumbs'])) {
				$thumbs = $_GPC['thumbs'];
				$thumb_url = array();

				foreach ($thumbs as $th) {
					$thumb_url[] = trim($th);
				}

				$data['thumb'] = save_media($thumb_url[0]);
				unset($thumb_url[0]);
				$data['thumb_url'] = serialize(m('common')->array_images($thumb_url));
			}

			if ($data['type'] == 4) {
				$intervalfloor = intval($_GPC['intervalfloor']);
				if (3 < $intervalfloor || $intervalfloor < 1) {
					show_json(0, '请至少添加一个区间价格！');
				}

				$intervalprices = array();

				if (0 < $intervalfloor) {
					if (intval($_GPC['intervalnum1']) <= 0) {
						show_json(0, '请设置起批发量！');
					}

					if (floatval($_GPC['intervalprice1']) <= 0) {
						show_json(0, '批发价必须大于0！');
					}

					$intervalprices[] = array('intervalnum' => intval($_GPC['intervalnum1']), 'intervalprice' => floatval($_GPC['intervalprice1']));
				}

				if (1 < $intervalfloor) {
					if (intval($_GPC['intervalnum2']) <= 0) {
						show_json(0, '请设置起批发量！');
					}

					if (intval($_GPC['intervalnum2']) <= intval($_GPC['intervalnum1'])) {
						show_json(0, '批发量需大于上级批发量！');
					}

					if (floatval($_GPC['intervalprice1']) <= floatval($_GPC['intervalprice2'])) {
						show_json(0, '批发价需小于上级批发价！');
					}

					$intervalprices[] = array('intervalnum' => intval($_GPC['intervalnum2']), 'intervalprice' => floatval($_GPC['intervalprice2']));
				}

				if (2 < $intervalfloor) {
					if (intval($_GPC['intervalnum3']) <= 0) {
						show_json(0, '请设置起批发量！');
					}

					if (intval($_GPC['intervalnum3']) <= intval($_GPC['intervalnum2'])) {
						show_json(0, '批发量需大于上级批发量！');
					}

					if (floatval($_GPC['intervalprice2']) <= floatval($_GPC['intervalprice3'])) {
						show_json(0, '批发价需小于上级批发价！');
					}

					$intervalprices[] = array('intervalnum' => intval($_GPC['intervalnum3']), 'intervalprice' => floatval($_GPC['intervalprice3']));
				}

				$intervalprice = iserializer($intervalprices);
				$data['intervalfloor'] = $intervalfloor;
				$data['intervalprice'] = $intervalprice;
				$data['minbuy'] = $_GPC['intervalnum1'];
				$data['marketprice'] = $_GPC['intervalprice1'];
				$data['productprice'] = 0;
				$data['costprice'] = 0;
			}

			$data['isstatustime'] = intval($_GPC['isstatustime']);
			$data['statustimestart'] = strtotime($_GPC['statustime']['start']);
			$data['statustimeend'] = strtotime($_GPC['statustime']['end']);
			if ($data['status'] == 1 && 0 < $data['isstatustime']) {
				if (!($data['statustimestart'] < time() && time() < $data['statustimeend'])) {
					show_json(0, '上架时间不符合要求！');
				}
			}

			pdo_insert('ewei_shop_goods', $data);
			$id = pdo_insertid();
			plog('goods.add', '添加商品 ID: ' . $id . '<br>' . (!empty($data['nocommission']) ? '是否参与分销 -- 否' : '是否参与分销 -- 是'));
			$files = $_FILES;
			$spec_ids = $_POST['spec_id'];
			$spec_titles = $_POST['spec_title'];
			$specids = array();
			$len = count($spec_ids);
			$specids = array();
			$spec_items = array();
			$k = 0;

			while ($k < $len) {
				$spec_id = '';
				$get_spec_id = $spec_ids[$k];
				$a = array('uniacid' => $_W['uniacid'], 'goodsid' => $id, 'displayorder' => $k, 'title' => $spec_titles[$get_spec_id]);

				if (is_numeric($get_spec_id)) {
					pdo_update('ewei_shop_goods_spec', $a, array('id' => $get_spec_id));
					$spec_id = $get_spec_id;
				}
				else {
					pdo_insert('ewei_shop_goods_spec', $a);
					$spec_id = pdo_insertid();
				}

				$spec_item_ids = $_POST['spec_item_id_' . $get_spec_id];
				$spec_item_titles = $_POST['spec_item_title_' . $get_spec_id];
				$spec_item_shows = $_POST['spec_item_show_' . $get_spec_id];
				$spec_item_thumbs = $_POST['spec_item_thumb_' . $get_spec_id];
				$spec_item_oldthumbs = $_POST['spec_item_oldthumb_' . $get_spec_id];
				$spec_item_virtuals = $_POST['spec_item_virtual_' . $get_spec_id];
				$itemlen = count($spec_item_ids);
				$itemids = array();
				$n = 0;

				while ($n < $itemlen) {
					$item_id = '';
					$get_item_id = $spec_item_ids[$n];
					$d = array('uniacid' => $_W['uniacid'], 'specid' => $spec_id, 'displayorder' => $n, 'title' => $spec_item_titles[$n], 'show' => $spec_item_shows[$n], 'thumb' => save_media($spec_item_thumbs[$n]), 'virtual' => $data['type'] == 3 ? $spec_item_virtuals[$n] : 0);
					$f = 'spec_item_thumb_' . $get_item_id;

					if (is_numeric($get_item_id)) {
						pdo_update('ewei_shop_goods_spec_item', $d, array('id' => $get_item_id));
						$item_id = $get_item_id;
					}
					else {
						pdo_insert('ewei_shop_goods_spec_item', $d);
						$item_id = pdo_insertid();
					}

					$itemids[] = $item_id;
					$d['get_id'] = $get_item_id;
					$d['id'] = $item_id;
					$spec_items[] = $d;
					++$n;
				}

				if (0 < count($itemids)) {
					pdo_query('delete from ' . tablename('ewei_shop_goods_spec_item') . (' where uniacid=' . $_W['uniacid'] . ' and specid=' . $spec_id . ' and id not in (') . implode(',', $itemids) . ')');
				}
				else {
					pdo_query('delete from ' . tablename('ewei_shop_goods_spec_item') . (' where uniacid=' . $_W['uniacid'] . ' and specid=' . $spec_id));
				}

				pdo_update('ewei_shop_goods_spec', array('content' => serialize($itemids)), array('id' => $spec_id));
				$specids[] = $spec_id;
				++$k;
			}

			if (0 < count($specids)) {
				pdo_query('delete from ' . tablename('ewei_shop_goods_spec') . (' where uniacid=' . $_W['uniacid'] . ' and goodsid=' . $id . ' and id not in (') . implode(',', $specids) . ')');
			}
			else {
				pdo_query('delete from ' . tablename('ewei_shop_goods_spec') . (' where uniacid=' . $_W['uniacid'] . ' and goodsid=' . $id));
			}

			$totalstocks = 0;
			$optionArray = json_decode($_POST['optionArray'], true);
			$option_idss = $optionArray['option_ids'];
			$len = count($option_idss);
			$optionids = array();
			$k = 0;

			while ($k < $len) {
				$option_id = '';
				$ids = $option_idss[$k];
				$get_option_id = $optionArray['option_id'][$k];
				$idsarr = explode('_', $ids);
				$newids = array();

				foreach ($idsarr as $key => $ida) {
					foreach ($spec_items as $it) {
						if ($it['get_id'] == $ida) {
							$newids[] = $it['id'];
							break;
						}
					}
				}

				$newids = implode('_', $newids);
				$a = array('uniacid' => $_W['uniacid'], 'title' => $optionArray['option_title'][$k], 'productprice' => $optionArray['option_productprice'][$k], 'costprice' => $optionArray['option_costprice'][$k], 'marketprice' => $optionArray['option_marketprice'][$k], 'stock' => $optionArray['option_stock'][$k], 'weight' => $optionArray['option_weight'][$k], 'goodssn' => $optionArray['option_goodssn'][$k], 'productsn' => $optionArray['option_productsn'][$k], 'goodsid' => $id, 'specs' => $newids, 'virtual' => $data['type'] == 3 ? $optionArray['option_virtual'][$k] : 0);

				if ($data['type'] == 4) {
					$a['presellprice'] = 0;
					$a['productprice'] = 0;
					$a['costprice'] = 0;
					$a['marketprice'] = intval($_GPC['intervalprice1']);
				}

				$totalstocks += $a['stock'];
				pdo_insert('ewei_shop_goods_option', $a);
				$option_id = pdo_insertid();
				$optionids[] = $option_id;
				if (0 < count($optionids) && $data['hasoption'] !== 0) {
					pdo_query('delete from ' . tablename('ewei_shop_goods_option') . (' where goodsid=' . $id . ' and id not in ( ') . implode(',', $optionids) . ')');
					$sql = 'update ' . tablename('ewei_shop_goods') . ' g set
                    g.minprice = (select min(marketprice) from ' . tablename('ewei_shop_goods_option') . (' where goodsid = ' . $id . '),
                    g.maxprice = (select max(marketprice) from ') . tablename('ewei_shop_goods_option') . (' where goodsid = ' . $id . ')
                    where g.id = ' . $id . ' and g.hasoption=1');
					pdo_query($sql);
				}
				else {
					pdo_query('delete from ' . tablename('ewei_shop_goods_option') . (' where goodsid=' . $id));
					$sql = 'update ' . tablename('ewei_shop_goods') . (' set minprice = marketprice,maxprice = marketprice where id = ' . $id . ' and hasoption=0;');
					pdo_query($sql);
				}

				++$k;
			}

			$sqlgoods = 'SELECT id,title,thumb,marketprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,total,description,merchsale FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1';
			$goodsinfo = pdo_fetch($sqlgoods, array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$goodsinfo = m('goods')->getOneMinPrice($goodsinfo);
			pdo_update('ewei_shop_goods', array('minprice' => $goodsinfo['minprice'], 'maxprice' => $goodsinfo['maxprice']), array('id' => $id, 'uniacid' => $_W['uniacid']));
			if ($data['type'] == 3 && $com_virtual) {
				$com_virtual->updateGoodsStock($id);
			}
			else {
				if ($data['hasoption'] !== 0 && $data['totalcnf'] != 2 && empty($data['unite_total'])) {
					pdo_update('ewei_shop_goods', array('total' => $totalstocks), array('id' => $id));
				}
			}

			show_json(1, array('url' => webUrl('goods/edit', array('id' => $id))));
		}

		$statustimestart = time();
		$statustimeend = strtotime('+1 month');
		$category = m('shop')->getFullCategory(true, true);
		$com_virtual = com('virtual');
		$dispatch_data = pdo_fetchall('select * from ' . tablename('ewei_shop_dispatch') . ' where uniacid=:uniacid and merchid=:merchid and enabled=1 order by displayorder desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
		$levels = array_merge(array(
	array('id' => 0, 'key' => 'default', 'levelname' => empty($_W['shopset']['shop']['levelname']) ? '默认会员' : $_W['shopset']['shop']['levelname'])
	), $levels);

		if ($com_virtual) {
			$virtual_types = pdo_fetchall('select * from ' . tablename('ewei_shop_virtual_type') . ' where uniacid=:uniacid and merchid=:merchid and recycled = 0 order by id asc', array(':uniacid' => $_W['uniacid'], ':merchid' => 0));
		}

		include $this->template('goods/create');
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
		require dirname(__FILE__) . '/post.php';
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_goods', array('deleted' => 1), array('id' => $item['id']));
			plog('goods.delete', '删除商品 ID: ' . $item['id'] . ' 商品名称: ' . $item['title'] . ' ');
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

		pdo_query('update ' . tablename('ewei_shop_goods') . (' set newgoods = 0 where id in ( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);
		$items = pdo_fetchall('SELECT id,title,status,isstatustime,statustimestart,statustimeend FROM ' . tablename('ewei_shop_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			if (0 < $item['isstatustime']) {
				if (0 < intval($_GPC['status']) && $item['statustimestart'] < time() && time() < $item['statustimeend']) {
				}
				else {
					show_json(0, '商品 [' . $item['title'] . '] 上架时间不符合要求！');
				}
			}

			pdo_update('ewei_shop_goods', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('goods.edit', '修改商品状态<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['title'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '上架' : '下架');
		}

		show_json(1, array('url' => referer()));
	}

	public function checked()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_goods', array('checked' => intval($_GPC['checked'])), array('id' => $item['id']));
			plog('goods.edit', '修改商品状态<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['title'] . '<br/>状态: ' . $_GPC['checked'] == 0 ? '审核通过' : '审核中');
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_goods', array('id' => $item['id']));
			plog('goods.edit', '从回收站彻底删除商品<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['title']);
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_goods', array('deleted' => 0), array('id' => $item['id']));
			plog('goods.edit', '从回收站恢复商品<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['title']);
		}

		show_json(1, array('url' => referer()));
	}

	public function property()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = $_GPC['type'];
		$data = intval($_GPC['data']);

		if (in_array($type, array('new', 'hot', 'recommand', 'discount', 'time', 'sendfree', 'nodiscount'))) {
			pdo_update('ewei_shop_goods', array('is' . $type => $data), array('id' => $id, 'uniacid' => $_W['uniacid']));

			if ($type == 'new') {
				$typestr = '新品';
			}
			else if ($type == 'hot') {
				$typestr = '热卖';
			}
			else if ($type == 'recommand') {
				$typestr = '推荐';
			}
			else if ($type == 'discount') {
				$typestr = '促销';
			}
			else if ($type == 'time') {
				$typestr = '限时卖';
			}
			else if ($type == 'sendfree') {
				$typestr = '包邮';
			}
			else {
				if ($type == 'nodiscount') {
					$typestr = '不参与折扣状态';
				}
			}

			plog('goods.edit', '修改商品' . $typestr . '状态   ID: ' . $id);
		}

		if (in_array($type, array('status'))) {
			pdo_update('ewei_shop_goods', array($type => $data), array('id' => $id, 'uniacid' => $_W['uniacid']));
			plog('goods.edit', '修改商品上下架状态   ID: ' . $id);
		}

		if (in_array($type, array('type'))) {
			pdo_update('ewei_shop_goods', array($type => $data), array('id' => $id, 'uniacid' => $_W['uniacid']));
			plog('goods.edit', '修改商品类型   ID: ' . $id);
		}

		show_json(1);
	}

	public function change()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			show_json(0, array('message' => '参数错误'));
		}
		else {
			pdo_update('ewei_shop_goods', array('newgoods' => 0), array('id' => $id));
		}

		$type = trim($_GPC['type']);
		$value = trim($_GPC['value']);

		if (!in_array($type, array('title', 'marketprice', 'total', 'goodssn', 'productsn', 'displayorder', 'dowpayment'))) {
			show_json(0, array('message' => '参数错误'));
		}

		$goods = pdo_fetch('select id,hasoption,marketprice,dowpayment from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if (empty($goods)) {
			show_json(0, array('message' => '参数错误'));
		}

		if ($type == 'dowpayment') {
			if ($goods['marketprice'] < $value) {
				show_json(0, array('message' => '定金不能大于总价'));
			}
		}
		else {
			if ($type == 'marketprice') {
				if ($value < $goods['dowpayment']) {
					show_json(0, array('message' => '总价不能小于定金'));
				}
			}
		}

		pdo_update('ewei_shop_goods', array($type => $value), array('id' => $id));

		if ($goods['hasoption'] == 0) {
			$sql = 'update ' . tablename('ewei_shop_goods') . (' set minprice = marketprice,maxprice = marketprice where id = ' . $goods['id'] . ' and hasoption=0;');
			pdo_query($sql);
		}

		show_json(1);
	}

	public function tpl()
	{
		global $_GPC;
		global $_W;
		$tpl = trim($_GPC['tpl']);

		if ($tpl == 'specitem') {
			$spec = array('id' => $_GPC['specid']);
			$specitem = array('id' => random(32), 'title' => $_GPC['title'], 'iscycelbuy' => $_GPC['iscycelbuy'], 'show' => 1);
			include $this->template('cycelbuy/goods/tpl/spec_item');
		}
		else {
			if ($tpl == 'param') {
				$tag = random(32);
				include $this->template('cycelbuy/goods/tpl/param');
			}
		}
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$type = intval($_GPC['type']);
		$live = intval($_GPC['live']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and status=1 and deleted=0 and uniacid=:uniacid';

		if (!empty($kwd)) {
			$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
			$params[':keywords'] = '%' . $kwd . '%';
		}

		if (empty($type)) {
			$condition .= ' AND `type` != 10 ';
		}
		else {
			$condition .= ' AND `type` = :type ';
			$params[':type'] = $type;
		}

		$ds = pdo_fetchall('SELECT id,title,thumb,marketprice,productprice,share_title,share_icon,description,minprice,costprice,total,sales,islive,liveprice FROM ' . tablename('ewei_shop_goods') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);
		$ds = set_medias($ds, array('thumb', 'share_icon'));

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}

	public function goodsprice()
	{
		global $_W;
		$sql = 'update ' . tablename('ewei_shop_goods') . ' g set 
g.minprice = (select min(marketprice) from ' . tablename('ewei_shop_goods_option') . ' where g.id = goodsid),
g.maxprice = (select max(marketprice) from ' . tablename('ewei_shop_goods_option') . ' where g.id = goodsid)
where g.hasoption=1 and g.uniacid=' . $_W['uniacid'] . ';
update ' . tablename('ewei_shop_goods') . ' set minprice = marketprice,maxprice = marketprice where hasoption=0 and uniacid=' . $_W['uniacid'] . ';';
		pdo_run($sql);
		show_json(1);
	}

	public function batchcates()
	{
		$categorys = m('shop')->getFullCategory(true);
		$category = array();

		foreach ($categorys as $cate) {
			$category[$cate['id']] = $cate;
		}

		include $this->template();
	}

	public function ajax_batchcates()
	{
		global $_W;
		global $_GPC;
		$iscover = $_GPC['iscover'];
		$goodsids = $_GPC['goodsids'];
		$cates = $_GPC['cates'];
		$data = array();
		$reust_cates = $this->reust_cates($cates);

		foreach ($goodsids as $goodsid) {
			if (!empty($iscover)) {
				$data = $reust_cates;
				$data['cates'] = implode(',', $data['cates']);
				$data['pcates'] = implode(',', $data['pcates']);
				$data['ccates'] = implode(',', $data['ccates']);
				$data['tcates'] = implode(',', $data['tcates']);
				pdo_update('ewei_shop_goods', $data, array('id' => $goodsid));
			}
			else {
				$goods = pdo_fetch('select pcate,ccate,tcate,cates,pcates,ccates,tcates  from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $goodsid, ':uniacid' => $_W['uniacid']));

				if (!empty($goods['cates'])) {
					$goods_cates = explode(',', $goods['cates']);

					if (!empty($reust_cates['cates'])) {
						$data['cates'] = implode(',', array_unique(array_merge($goods_cates, $reust_cates['cates']), SORT_NUMERIC));
					}
				}

				if (!empty($goods['pcates'])) {
					$goods_pcates = explode(',', $goods['pcates']);

					if (!empty($reust_cates['pcates'])) {
						$data['pcates'] = implode(',', array_unique(array_merge($goods_pcates, $reust_cates['pcates']), SORT_NUMERIC));
					}
				}

				if (!empty($goods['ccates'])) {
					$goods_ccates = explode(',', $goods['ccates']);

					if (!empty($reust_cates['ccates'])) {
						$data['ccates'] = implode(',', array_unique(array_merge($goods_ccates, $reust_cates['ccates']), SORT_NUMERIC));
					}
				}

				if (!empty($goods['tcates'])) {
					$goods_tcates = explode(',', $goods['tcates']);

					if (!empty($reust_cates['tcates'])) {
						$data['tcates'] = implode(',', array_unique(array_merge($goods_tcates, $reust_cates['tcates']), SORT_NUMERIC));
					}
				}

				if (!empty($reust_cates['pcate'])) {
					$data['pcate'] = $reust_cates['pcate'];
				}

				if (!empty($reust_cates['ccate'])) {
					$data['ccate'] = $reust_cates['ccate'];
				}

				if (!empty($reust_cates['tcate'])) {
					$data['tcate'] = $reust_cates['tcate'];
				}

				pdo_update('ewei_shop_goods', $data, array('id' => $goodsid));
			}
		}

		show_json(1);
	}

	public function reust_cates($param_cates)
	{
		global $_W;
		$pcates = array();
		$ccates = array();
		$tcates = array();
		$cates = array();
		$pcateid = 0;
		$ccateid = 0;
		$tcateid = 0;

		if (is_array($param_cates)) {
			foreach ($param_cates as $key => $cid) {
				$c = pdo_fetch('select level from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));

				if ($c['level'] == 1) {
					$pcates[] = $cid;
				}
				else if ($c['level'] == 2) {
					$ccates[] = $cid;
				}
				else {
					if ($c['level'] == 3) {
						$tcates[] = $cid;
					}
				}

				if ($key == 0) {
					if ($c['level'] == 1) {
						$pcateid = $cid;
					}
					else if ($c['level'] == 2) {
						$crow = pdo_fetch('select parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
						$pcateid = $crow['parentid'];
						$ccateid = $cid;
					}
					else {
						if ($c['level'] == 3) {
							$tcateid = $cid;
							$tcate = pdo_fetch('select id,parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
							$ccateid = $tcate['parentid'];
							$ccate = pdo_fetch('select id,parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $ccateid, ':uniacid' => $_W['uniacid']));
							$pcateid = $ccate['parentid'];
						}
					}
				}
			}
		}

		$data['pcate'] = $pcateid;
		$data['ccate'] = $ccateid;
		$data['tcate'] = $tcateid;
		$data['cates'] = $param_cates;
		$data['pcates'] = $pcates;
		$data['ccates'] = $ccates;
		$data['tcates'] = $tcates;
		return $data;
	}
}

?>
