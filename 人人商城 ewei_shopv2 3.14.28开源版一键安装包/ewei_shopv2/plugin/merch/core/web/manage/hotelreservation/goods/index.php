<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Index_EweiShopV2Page extends MerchWebPage
{
	public function main()
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
		$shopset_level = intval($_W['shopset']['commission']['level']);
		$merch_user = $_W['merch_user'];
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id and uniacid=:uniacid and merchid=:merchid', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);

		if (p('diyform')) {
			$diyform = p('diyform');
			$globalData = $diyform->globalData();
			extract($globalData);

			if (!empty($item['diysaveid'])) {
				$diyforminfo = $diyform->getDiyformInfo($item['diysaveid'], 0);
			}
		}

		$category = m('shop')->getFullCategory(true, true);
		$levels = array(
			array('id' => 0, 'key' => 'merch', 'levelname' => '促销价')
		);
		$com_virtual = com('virtual');

		if ($_W['ispost']) {
			if (empty($id)) {
				$goodstype = intval($_GPC['type']);
			}
			else {
				$goodstype = intval($_GPC['goodstype']);
			}

			if (intval($_GPC['hoteldaystock']) < 1) {
				show_json(0, array('message' => '每日库存不能小于1！'));
			}

			$data = array('uniacid' => intval($_W['uniacid']), 'merchid' => intval($_W['merchid']), 'displayorder' => intval($_GPC['displayorder']), 'title' => trim($_GPC['goodsname']), 'subtitle' => trim($_GPC['subtitle']), 'keywords' => trim($_GPC['keywords']), 'type' => $goodstype, 'isrecommand' => intval($_GPC['isrecommand']), 'ishot' => intval($_GPC['ishot']), 'isnew' => intval($_GPC['isnew']), 'isdiscount' => intval($_GPC['isdiscount']), 'isdiscount_title' => trim(mb_substr($_GPC['isdiscount_title'], 0, 5, 'UTF-8')), 'isdiscount_time' => strtotime($_GPC['isdiscount_time']), 'issendfree' => intval($_GPC['issendfree']), 'istime' => intval($_GPC['istime']), 'timestart' => strtotime($_GPC['saletime']['start']), 'timeend' => strtotime($_GPC['saletime']['end']), 'description' => trim($_GPC['description']), 'goodssn' => trim($_GPC['goodssn']), 'unit' => trim($_GPC['unit']), 'createtime' => TIMESTAMP, 'total' => intval($_GPC['total']), 'showtotal' => intval($_GPC['showtotal']), 'totalcnf' => intval($_GPC['totalcnf']), 'marketprice' => $_GPC['marketprice'], 'weight' => $_GPC['weight'], 'costprice' => $_GPC['costprice'], 'productprice' => trim($_GPC['productprice']), 'productsn' => trim($_GPC['productsn']), 'maxbuy' => intval($_GPC['maxbuy']), 'minbuy' => intval($_GPC['minbuy']), 'usermaxbuy' => intval($_GPC['usermaxbuy']), 'hasoption' => intval($_GPC['hasoption']), 'sales' => intval($_GPC['sales']), 'share_icon' => trim($_GPC['share_icon']), 'share_title' => trim($_GPC['share_title']), 'status' => intval($_GPC['status']), 'virtualsend' => intval($_GPC['virtualsend']), 'virtualsendcontent' => trim($_GPC['virtualsendcontent']), 'isverify' => intval($_GPC['isverify']), 'verifytype' => intval($_GPC['verifytype']), 'storeids' => is_array($_GPC['storeids']) ? implode(',', $_GPC['storeids']) : '', 'noticeopenid' => is_array($_GPC['noticeopenid']) ? implode(',', $_GPC['noticeopenid']) : '', 'noticetype' => $_GPC['noticetype'], 'needfollow' => intval($_GPC['needfollow']), 'followurl' => trim($_GPC['followurl']), 'followtip' => trim($_GPC['followtip']), 'virtual' => $goodstype == 3 ? intval($_GPC['virtual']) : 0, 'ednum' => intval($_GPC['ednum']), 'edareas' => trim($_GPC['edareas']), 'edmoney' => trim($_GPC['edmoney']), 'invoice' => intval($_GPC['invoice']), 'repair' => intval($_GPC['repair']), 'seven' => intval($_GPC['seven']), 'province' => trim($_GPC['province']), 'city' => trim($_GPC['city']), 'quality' => intval($_GPC['quality']), 'cashier' => intval($_GPC['cashier']), 'ishotel' => intval($_GPC['ishotel']), 'hoteldaystock' => intval($_GPC['hoteldaystock']), 'issetmap' => intval($_GPC['issetmap']));

			if (intval($_GPC['issetmap']) == 1) {
				$data['lng'] = $_GPC['map']['lng'];
				$data['lat'] = $_GPC['map']['lat'];
			}

			if (intval($_GPC['isverify']) == 2 || $goodstype == 2 || $goodstype == 3) {
				$data['cash'] = 0;
			}
			else {
				$data['cash'] = intval($_GPC['cash']);
			}

			if (empty($item)) {
				$data['deduct2'] = -1;
				$data['merchsale'] = 1;
			}

			if (empty($_W['merch_user']['goodschecked'])) {
				if (empty($item)) {
					$data['checked'] = 1;
				}
			}
			else {
				$data['checked'] = 0;
			}

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
			$data['content'] = m('common')->html_images($_GPC['content']);
			$data['buycontent'] = m('common')->html_images($_GPC['buycontent']);

			if (p('commission')) {
				$cset = p('commission')->getSet();
				if (!empty($cset['level']) && $merch_user['commissionchecked'] == 1) {
					$data['sharebtn'] = intval($_GPC['sharebtn']);
					$data['nocommission'] = intval($_GPC['nocommission']);
					$data['hascommission'] = intval($_GPC['hascommission']);
					$data['commission1_rate'] = $_GPC['commission1_rate'];
					$data['commission2_rate'] = $_GPC['commission2_rate'];
					$data['commission3_rate'] = $_GPC['commission3_rate'];
					$data['commission1_pay'] = $_GPC['commission1_pay'];
					$data['commission2_pay'] = $_GPC['commission2_pay'];
					$data['commission3_pay'] = $_GPC['commission3_pay'];
					$data['commission_thumb'] = save_media($_GPC['commission_thumb']);
				}
			}

			if ($diyform) {
				if ($_GPC['diyformtype'] == 2) {
					$diydata = $diyform->getInsertDataByAdmin();
					$diydata = iserializer($diydata);
					$_GPC['diysave'] = intval($_GPC['diysave']);

					if ($_GPC['diysave'] == 1) {
						$diysaveid = $item['diysaveid'];
						$insert = array();
						$insert['title'] = '商品ID' . $item['id'] . '的自定义表单';
						$insert['fields'] = $diydata;
						$is_save = $diyform->isHasDiyform($diysaveid);

						if (empty($is_save)) {
							$insert['uniacid'] = $_W['uniacid'];
							pdo_insert('ewei_shop_diyform_type', $insert);
							$data['diysaveid'] = pdo_insertid();
						}
						else {
							pdo_update('ewei_shop_diyform_type', $insert, array('id' => $diysaveid));
						}
					}

					$data['diyfields'] = $diydata;
					$data['diysave'] = $_GPC['diysave'];
				}

				$data['diyformtype'] = $_GPC['diyformtype'];

				if ($_GPC['diyformtype'] == 1) {
					$data['diyformid'] = $_GPC['diyformid'];
				}

				$data['diymode'] = intval($_GPC['diymode']);
			}

			$data['dispatchtype'] = intval($_GPC['dispatchtype']);
			$data['dispatchprice'] = trim($_GPC['dispatchprice']);
			$data['dispatchid'] = intval($_GPC['dispatchid']);

			if ($data['total'] === -1) {
				$data['total'] = 0;
				$data['totalcnf'] = 2;
			}

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

			if (empty($id)) {
				pdo_insert('ewei_shop_goods', $data);
				$id = pdo_insertid();
				plog('goods.add', '添加商品 ID: ' . $id . '<br>' . (!empty($data['nocommission']) ? '是否参与分销 -- 否' : '是否参与分销 -- 是'));
			}
			else {
				unset($data['createtime']);
				pdo_update('ewei_shop_goods', $data, array('id' => $id));
				plog('goods.edit', '编辑商品 ID: ' . $id . '<br>' . (!empty($data['nocommission']) ? '是否参与分销 -- 否' : '是否参与分销 -- 是'));
			}

			$param_ids = $_POST['param_id'];
			$param_titles = $_POST['param_title'];
			$param_values = $_POST['param_value'];
			$param_displayorders = $_POST['param_displayorder'];
			$len = count($param_ids);
			$paramids = array();
			$k = 0;

			while ($k < $len) {
				$param_id = '';
				$get_param_id = $param_ids[$k];
				$a = array('uniacid' => $_W['uniacid'], 'title' => $param_titles[$k], 'value' => $param_values[$k], 'displayorder' => $k, 'goodsid' => $id);

				if (!is_numeric($get_param_id)) {
					pdo_insert('ewei_shop_goods_param', $a);
					$param_id = pdo_insertid();
				}
				else {
					pdo_update('ewei_shop_goods_param', $a, array('id' => $get_param_id));
					$param_id = $get_param_id;
				}

				$paramids[] = $param_id;
				++$k;
			}

			if (0 < count($paramids)) {
				pdo_query('delete from ' . tablename('ewei_shop_goods_param') . (' where goodsid=' . $id . ' and id not in ( ') . implode(',', $paramids) . ')');
			}
			else {
				pdo_query('delete from ' . tablename('ewei_shop_goods_param') . (' where goodsid=' . $id));
			}

			$totalstocks = 0;
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

			$optionArray = json_decode($_POST['optionArray'], true);
			$isdiscountDiscountsArray = json_decode($_POST['isdiscountDiscountsArray'], true);
			$option_idss = $optionArray['option_ids'];
			$len = count($option_idss);
			$optionids = array();
			$levelArray = array();
			$isDiscountsArray = array();
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
				$totalstocks += $a['stock'];

				if (empty($get_option_id)) {
					pdo_insert('ewei_shop_goods_option', $a);
					$option_id = pdo_insertid();
				}
				else {
					pdo_update('ewei_shop_goods_option', $a, array('id' => $get_option_id));
					$option_id = $get_option_id;
				}

				$optionids[] = $option_id;

				foreach ($levels as $level) {
					$isDiscountsArray[$level['key']]['option' . $option_id] = $isdiscountDiscountsArray['isdiscount_discounts_' . $level['key']][$k];
				}

				++$k;
			}

			$has_default = 0;
			$old_isdiscount_discounts = json_decode($item['isdiscount_discounts'], true);

			if (!empty($old_isdiscount_discounts['default'])) {
				$has_default = 1;
			}

			if (!empty($isDiscountsArray) && $data['hasoption']) {
				$is_discounts_arr = array_merge(array('type' => 1), $isDiscountsArray);

				if ($has_default == 1) {
					if (!empty($old_isdiscount_discounts)) {
						foreach ($old_isdiscount_discounts as $k => $v) {
							if ($k != 'type' && $k != 'merch') {
								$is_discounts_arr[$k] = $v;
							}
						}
					}
				}

				$is_discounts_json = json_encode($is_discounts_arr);
			}
			else {
				foreach ($levels as $level) {
					if ($level['key'] == 'merch') {
						$isDiscountsDefaultArray[$level['key']]['option0'] = $_GPC['isdiscount_discounts_level_' . $level['key'] . '_default'];
					}
				}

				$is_discounts_arr = array_merge(array('type' => 0), $isDiscountsDefaultArray);

				if ($has_default == 1) {
					if (!empty($old_isdiscount_discounts)) {
						foreach ($old_isdiscount_discounts as $k => $v) {
							if ($k != 'type' && $k != 'merch') {
								$is_discounts_arr[$k] = $v;
							}
						}
					}
				}

				$is_discounts_json = is_array($is_discounts_arr) ? json_encode($is_discounts_arr) : json_encode(array());
			}

			pdo_update('ewei_shop_goods', array('isdiscount_discounts' => $is_discounts_json), array('id' => $id));
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

			if ($data['type'] == 3 && $com_virtual) {
				$com_virtual->updateGoodsStock($id);
			}
			else {
				if (0 < $totalstocks && $data['totalcnf'] != 2) {
					pdo_update('ewei_shop_goods', array('total' => $totalstocks), array('id' => $id));
				}
			}

			show_json(1, array('url' => merchUrl('hotelreservation/goods/edit', array('id' => $id, 'tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		if (!empty($id)) {
			if (empty($item)) {
				$this->message('抱歉，商品不存在或是已经删除！', '', 'error');
			}

			$noticetype = explode(',', $item['noticetype']);
			$cates = explode(',', $item['cates']);
			$isdiscount_discounts = json_decode($item['isdiscount_discounts'], true);
			$allspecs = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_spec') . ' where goodsid=:id order by displayorder asc', array(':id' => $id));

			foreach ($allspecs as &$s) {
				$s['items'] = pdo_fetchall('select a.id,a.specid,a.title,a.thumb,a.show,a.displayorder,a.valueId,a.virtual,b.title as title2 from ' . tablename('ewei_shop_goods_spec_item') . ' a left join ' . tablename('ewei_shop_virtual_type') . ' b on b.id=a.virtual  where a.specid=:specid order by a.displayorder asc', array(':specid' => $s['id']));
			}

			unset($s);
			$params = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_param') . ' where goodsid=:id order by displayorder asc', array(':id' => $id));

			if (!empty($item['thumb'])) {
				$piclist = array_merge(array($item['thumb']), iunserializer($item['thumb_url']));
			}

			$item['content'] = m('common')->html_to_images($item['content']);
			$html = '';
			$discounts_html = '';
			$commission_html = '';
			$isdiscount_discounts_html = '';
			$options = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:id order by id asc', array(':id' => $id));
			$specs = array();

			if (0 < count($options)) {
				$specitemids = explode('_', $options[0]['specs']);

				foreach ($specitemids as $itemid) {
					foreach ($allspecs as $ss) {
						$items = $ss['items'];

						foreach ($items as $it) {
							if ($it['id'] == $itemid) {
								$specs[] = $ss;
								break;
							}
						}
					}
				}

				$html = '';
				$html .= '<table class="table table-bordered table-condensed">';
				$html .= '<thead>';
				$html .= '<tr class="active">';
				$isdiscount_discounts_html .= '<table class="table table-bordered table-condensed">';
				$isdiscount_discounts_html .= '<thead>';
				$isdiscount_discounts_html .= '<tr class="active">';
				$len = count($specs);
				$newlen = 1;
				$h = array();
				$rowspans = array();
				$i = 0;

				while ($i < $len) {
					$html .= '<th>' . $specs[$i]['title'] . '</th>';
					$isdiscount_discounts_html .= '<th>' . $specs[$i]['title'] . '</th>';
					$itemlen = count($specs[$i]['items']);

					if ($itemlen <= 0) {
						$itemlen = 1;
					}

					$newlen *= $itemlen;
					$h = array();
					$j = 0;

					while ($j < $newlen) {
						$h[$i][$j] = array();
						++$j;
					}

					$l = count($specs[$i]['items']);
					$rowspans[$i] = 1;
					$j = $i + 1;

					while ($j < $len) {
						$rowspans[$i] *= count($specs[$j]['items']);
						++$j;
					}

					++$i;
				}

				$canedit = mce('goods', $item);

				if ($canedit) {
					foreach ($levels as $level) {
						$isdiscount_discounts_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div><div class="input-group"><input type="text" class="form-control  input-sm isdiscount_discounts_' . $level['key'] . '_all" VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'isdiscount_discounts_' . $level['key'] . '\');"></a></span></div></div></th>';
					}

					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">库存</div><div class="input-group"><input type="text" class="form-control input-sm option_stock_all"  VALUE=""/><span class="input-group-addon" ><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_stock\');"></a></span></div></div></th>';
					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">现价</div><div class="input-group"><input type="text" class="form-control  input-sm option_marketprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_marketprice\');"></a></span></div></div></th>';
					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">原价</div><div class="input-group"><input type="text" class="form-control input-sm option_productprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_productprice\');"></a></span></div></div></th>';
					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">成本价</div><div class="input-group"><input type="text" class="form-control input-sm option_costprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_costprice\');"></a></span></div></div></th>';
					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">编码</div><div class="input-group"><input type="text" class="form-control input-sm option_goodssn_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_goodssn\');"></a></span></div></div></th>';
					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">条码</div><div class="input-group"><input type="text" class="form-control input-sm option_productsn_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_productsn\');"></a></span></div></div></th>';
					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">重量（克）</div><div class="input-group"><input type="text" class="form-control input-sm option_weight_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_weight\');"></a></span></div></div></th>';
				}
				else {
					foreach ($levels as $level) {
						$isdiscount_discounts_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div></div></th>';
					}

					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">库存</div></div></th>';
					$html .= '<th"><div class=""><div style="padding-bottom:10px;text-align:center;">销售价格</div></div></th>';
					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">市场价格</div></div></th>';
					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">成本价格</div></div></th>';
					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">商品编码</div></div></th>';
					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">商品条码</div></div></th>';
					$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">重量（克）</div></th>';
				}

				$html .= '</tr></thead>';
				$isdiscount_discounts_html .= '</tr></thead>';
				$m = 0;

				while ($m < $len) {
					$k = 0;
					$kid = 0;
					$n = 0;
					$j = 0;

					while ($j < $newlen) {
						$rowspan = $rowspans[$m];

						if ($j % $rowspan == 0) {
							$h[$m][$j] = array('html' => '<td class=\'full\' rowspan=\'' . $rowspan . '\'>' . $specs[$m]['items'][$kid]['title'] . '</td>', 'id' => $specs[$m]['items'][$kid]['id']);
						}
						else {
							$h[$m][$j] = array('html' => '', 'id' => $specs[$m]['items'][$kid]['id']);
						}

						++$n;

						if ($n == $rowspan) {
							++$kid;

							if (count($specs[$m]['items']) - 1 < $kid) {
								$kid = 0;
							}

							$n = 0;
						}

						++$j;
					}

					++$m;
				}

				$hh = '';
				$dd = '';
				$isdd = '';
				$cc = '';
				$i = 0;

				while ($i < $newlen) {
					$hh .= '<tr>';
					$dd .= '<tr>';
					$isdd .= '<tr>';
					$cc .= '<tr>';
					$ids = array();
					$j = 0;

					while ($j < $len) {
						$hh .= $h[$j][$i]['html'];
						$dd .= $h[$j][$i]['html'];
						$isdd .= $h[$j][$i]['html'];
						$cc .= $h[$j][$i]['html'];
						$ids[] = $h[$j][$i]['id'];
						++$j;
					}

					$ids = implode('_', $ids);
					$val = array('id' => '', 'title' => '', 'stock' => '', 'costprice' => '', 'productprice' => '', 'marketprice' => '', 'weight' => '', 'virtual' => '');
					$isdiscounts_val = array('id' => '', 'title' => '', 'level' => '', 'costprice' => '', 'productprice' => '', 'marketprice' => '', 'weight' => '', 'virtual' => '');

					foreach ($levels as $level) {
						$isdiscounts_val[$level['key']] = '';
					}

					foreach ($options as $o) {
						if ($ids === $o['specs']) {
							$val = array('id' => $o['id'], 'title' => $o['title'], 'stock' => $o['stock'], 'costprice' => $o['costprice'], 'productprice' => $o['productprice'], 'marketprice' => $o['marketprice'], 'goodssn' => $o['goodssn'], 'productsn' => $o['productsn'], 'weight' => $o['weight'], 'virtual' => $o['virtual']);
							$discount_val = array('id' => $o['id']);

							foreach ($levels as $level) {
								$isdiscounts_val[$level['key']] = is_string($isdiscount_discounts[$level['key']]) ? '' : $isdiscount_discounts[$level['key']]['option' . $o['id']];
							}

							break;
						}
					}

					if ($canedit) {
						foreach ($levels as $level) {
							$isdd .= '<td>';

							if ($level['key'] == 'merch') {
								$isdd .= '<input data-name="isdiscount_discounts_level_' . $level['key'] . '_' . $ids . '"  type="text" class="form-control isdiscount_discounts_' . $level['key'] . ' isdiscount_discounts_' . $level['key'] . '_' . $ids . '" value="' . $isdiscounts_val[$level['key']] . '"/> ';
							}

							$isdd .= '</td>';
						}

						$isdd .= '<input data-name="isdiscount_discounts_id_' . $ids . '"  type="hidden" class="form-control isdiscount_discounts_id isdiscount_discounts_id_' . $ids . '" value="' . $isdiscounts_val['id'] . '"/>';
						$isdd .= '<input data-name="isdiscount_discounts_ids"  type="hidden" class="form-control isdiscount_discounts_ids isdiscount_discounts_ids_' . $ids . '" value="' . $ids . '"/>';
						$isdd .= '<input data-name="isdiscount_discounts_title_' . $ids . '"  type="hidden" class="form-control isdiscount_discounts_title isdiscount_discounts_title_' . $ids . '" value="' . $isdiscounts_val['title'] . '"/>';
						$isdd .= '<input data-name="isdiscount_discounts_virtual_' . $ids . '"  type="hidden" class="form-control isdiscount_discounts_title isdiscount_discounts_virtual_' . $ids . '" value="' . $isdiscounts_val['virtual'] . '"/>';
						$isdd .= '</tr>';
						$hh .= '<td>';
						$hh .= '<input data-name="option_stock_' . $ids . '"  type="text" class="form-control option_stock option_stock_' . $ids . '" value="' . $val['stock'] . '"/>';
						$hh .= '</td>';
						$hh .= '<input data-name="option_id_' . $ids . '"  type="hidden" class="form-control option_id option_id_' . $ids . '" value="' . $val['id'] . '"/>';
						$hh .= '<input data-name="option_ids"  type="hidden" class="form-control option_ids option_ids_' . $ids . '" value="' . $ids . '"/>';
						$hh .= '<input data-name="option_title_' . $ids . '"  type="hidden" class="form-control option_title option_title_' . $ids . '" value="' . $val['title'] . '"/>';
						$hh .= '<input data-name="option_virtual_' . $ids . '"  type="hidden" class="form-control option_virtual option_virtual_' . $ids . '" value="' . $val['virtual'] . '"/>';
						$hh .= '<td><input data-name="option_marketprice_' . $ids . '" type="text" class="form-control option_marketprice option_marketprice_' . $ids . '" value="' . $val['marketprice'] . '"/></td>';
						$hh .= '<td><input data-name="option_productprice_' . $ids . '" type="text" class="form-control option_productprice option_productprice_' . $ids . '" " value="' . $val['productprice'] . '"/></td>';
						$hh .= '<td><input data-name="option_costprice_' . $ids . '" type="text" class="form-control option_costprice option_costprice_' . $ids . '" " value="' . $val['costprice'] . '"/></td>';
						$hh .= '<td><input data-name="option_goodssn_' . $ids . '" type="text" class="form-control option_goodssn option_goodssn_' . $ids . '" " value="' . $val['goodssn'] . '"/></td>';
						$hh .= '<td><input data-name="option_productsn_' . $ids . '" type="text" class="form-control option_productsn option_productsn_' . $ids . '" " value="' . $val['productsn'] . '"/></td>';
						$hh .= '<td><input data-name="option_weight_' . $ids . '" type="text" class="form-control option_weight option_weight_' . $ids . '" " value="' . $val['weight'] . '"/></td>';
						$hh .= '</tr>';
					}
					else {
						$hh .= '<td>' . $val['stock'] . '</td>';
						$hh .= '<td>' . $val['marketprice'] . '</td>';
						$hh .= '<td>' . $val['productprice'] . '</td>';
						$hh .= '<td>' . $val['costprice'] . '</td>';
						$hh .= '<td>' . $val['goodssn'] . '</td>';
						$hh .= '<td>' . $val['productsn'] . '</td>';
						$hh .= '<td>' . $val['weight'] . '</td>';
						$hh .= '</tr>';
					}

					++$i;
				}

				$discounts_html .= $dd;
				$discounts_html .= '</table>';
				$isdiscount_discounts_html .= $isdd;
				$isdiscount_discounts_html .= '</table>';
				$html .= $hh;
				$html .= '</table>';
				$commission_html .= $cc;
				$commission_html .= '</table>';
			}

			$stores = array();

			if (!empty($item['storeids'])) {
				$stores = pdo_fetchall('select id,storename from ' . tablename('ewei_shop_merch_store') . ' where id in (' . $item['storeids'] . ' ) and uniacid=' . $_W['uniacid'] . ' and merchid=' . $_W['merchid']);
			}

			if (!empty($item['noticeopenid'])) {
				$saler = m('member')->getMember($item['noticeopenid']);
			}
		}

		if (p('commission')) {
			$com_set = p('commission')->getSet();
		}

		$dispatch_data = pdo_fetchall('select * from ' . tablename('ewei_shop_dispatch') . ' where uniacid=:uniacid and merchid=:merchid and enabled=1 order by displayorder desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

		if ($com_virtual) {
			$virtual_types = pdo_fetchall('select * from ' . tablename('ewei_shop_virtual_type') . ' where uniacid=:uniacid and merchid=:merchid order by id asc', array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
		}

		$areas = m('common')->getAreas();

		if ($diyform) {
			$form_list = $diyform->getDiyformList();
			$dfields = iunserializer($item['diyfields']);
		}

		include $this->template();
	}
}

?>
