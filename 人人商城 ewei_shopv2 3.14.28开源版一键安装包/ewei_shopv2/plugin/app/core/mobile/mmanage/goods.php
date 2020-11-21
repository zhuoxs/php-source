<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'app/core/page_auth_mobile.php';
class Goods_EweiShopV2Page extends AppMobileAuthPage
{
	public function main()
	{
		return app_json(array(
			'perm' => array('goods_add' => cv('goods.add'), 'goods_view' => cv('goods.view'), 'goods_edit' => cv('goods.edit'), 'goods_status' => cv('goods.status'), 'goods_delete' => cv('goods.delete'), 'goods_restore' => cv('goods.restore'), 'goods_stock' => cv('goods.stock'))
		));
	}

	/**
     * 获取商品列表
     */
	public function get_list()
	{
		global $_W;
		global $_GPC;

		if (!cv('goods')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$offset = intval($_GPC['offset']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$list = array();
		$condition = ' WHERE g.`uniacid` = :uniacid and type!=10 ';
		$params = array(':uniacid' => $_W['uniacid']);
		$goodsfrom = strtolower(trim($_GPC['status']));
		empty($goodsfrom) && $_GPC['status'] = $goodsfrom = 'sale';

		if ($goodsfrom == 'sale') {
			$condition .= ' AND g.`status` > 0 and g.`checked`=0 and g.`total`>0 and g.`deleted`=0';
		}
		else if ($goodsfrom == 'out') {
			$condition .= ' AND g.`status` > 0 and g.`total` <= 0 and g.`deleted`=0';
		}
		else if ($goodsfrom == 'stock') {
			$condition .= ' AND (g.`status` = 0 or g.`checked`=1) and g.`deleted`=0';
		}
		else {
			if ($goodsfrom == 'cycle') {
				$condition .= ' AND g.`deleted`=1';
			}
		}

		$keywords = trim($_GPC['keywords']);

		if ($keywords) {
			$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
			$params[':keywords'] = '%' . $keywords . '%';
		}

		$sql = 'SELECT count(g.id) FROM ' . tablename('ewei_shop_goods') . 'g' . $condition;
		$total = pdo_fetchcolumn($sql, $params);

		if (0 < $total) {
			$presize = ($pindex - 1) * $psize - $offset;
			$sql = 'SELECT g.id, g.title, g.thumb, g.merchid, g.minprice, g.maxprice, g.total, g.sales,g.salesreal FROM ' . tablename('ewei_shop_goods') . 'g' . $condition . ' ORDER BY g.`status` DESC, g.`displayorder` DESC,
                g.`id` DESC LIMIT ' . $presize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
		}

		$list = set_medias($list, 'thumb');
		return app_json(array('total' => $total, 'list' => $list, 'pagesize' => $psize));
	}

	/**
     * 获取商品详情
     */
	public function get_detail()
	{
		global $_W;
		global $_GPC;
		if (!cv('goods.view') && cv('goods.edit')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$fields = 'id, title, subtitle, unit, `type`, hasoption, productprice, marketprice, costprice, total, totalcnf, showtotal, weight, goodssn, productsn, maxbuy, minbuy, usermaxbuy, isnodiscount, nocommission, diyformtype, diyformid, cash, invoice, status, displayorder, thumb, thumb_url, dispatchtype, dispatchprice, dispatchid, isrecommand, isnew, ishot, issendfree, merchid, cates, virtual, virtualsend, virtualsendcontent,verifygoodsnum,verifygoodsdays,verifygoodslimittype,verifygoodslimitdate';
			$item = pdo_fetch('SELECT ' . $fields . ' FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id and uniacid = :uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));

			if (!empty($item)) {
				unset($item['content']);
				$item['marketprice'] = price_format($item['marketprice']);
				$item['productprice'] = price_format($item['productprice']);
				$item['costprice'] = price_format($item['costprice']);
				$item['dispatchprice'] = price_format($item['dispatchprice']);

				if (!empty($item['thumb'])) {
					$item['thumb'] = array_merge(array($item['thumb']), iunserializer($item['thumb_url']));
					$item['thumb_show'] = set_medias($item['thumb']);
				}

				$item['cates'] = explode(',', $item['cates']);

				if ($item['verifygoodslimittype'] == 1) {
					$item['verifygoodsdate'] = date('Y-m-d', $item['verifygoodslimitdate']);
					$item['verifygoodstime'] = date('H:i', $item['verifygoodslimitdate']);
					$item['verifygoodslimitdate'] = date('Y-m-d H:i:s', $item['verifygoodslimitdate']);
				}
			}

			$merchid = 0;
			$merch_plugin = p('merch');
			if (0 < $item['merchid'] && !empty($item)) {
				$merchid = intval($item['merchid']);

				if ($merch_plugin) {
					$merch_user = $merch_plugin->getListUserOne($merchid);
				}
			}
		}

		$dispatch_data = pdo_fetchall('select id, dispatchname from ' . tablename('ewei_shop_dispatch') . ' where uniacid=:uniacid and merchid=:merchid and enabled=1 order by displayorder desc', array(':uniacid' => $_W['uniacid'], ':merchid' => intval($merchid)));
		$levels = m('member')->getLevels();
		$levels = array_merge(array(
			array('id' => 0, 'levelname' => empty($_W['shopset']['shop']['levelname']) ? '默认会员' : $_W['shopset']['shop']['levelname'])
		), $levels);
		$groups = m('member')->getGroups();
		$groups = array_merge(array(
			array('id' => 0, 'groupname' => '未分组')
		), $groups);

		if (p('diyform')) {
			$diyform_list = p('diyform')->getDiyformList();
		}

		if (com('virtual')) {
			$virtual_list = pdo_fetchall('SELECT id,uniacid,title,usedata,alldata FROM ' . tablename('ewei_shop_virtual_type') . ' WHERE uniacid=:uniacid AND merchid=:merchid AND recycled = 0 ORDER BY id ASC', array(':uniacid' => $_W['uniacid'], ':merchid' => 0));
		}

		if ($item['type'] == 3 && !empty($item['virtual']) && !empty($virtual_list)) {
			foreach ($virtual_list as $virtual_item) {
				if ($virtual_item['id'] == $item['virtual']) {
					$item['virtual_name'] = $virtual_item['title'];
				}
			}
		}

		$category = m('shop')->getFullCategory(true, true);
		$allcategory = m('shop')->getCategory();
		$specs = array();
		$optionlist = array();
		$specid = array();
		$spectitle = array();

		if (!empty($item['hasoption'])) {
			$specs = pdo_fetchall('select id,title as value from ' . tablename('ewei_shop_goods_spec') . ' where goodsid = :goodsid and uniacid = :uniacid order by displayorder asc ', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));

			foreach ($specs as $key => $value) {
				$specid[$key] = $value['id'];
				$spectitle[$key] = $value['value'];
				$specs[$key]['specitem'] = pdo_fetchall('select id,title as value from ' . tablename('ewei_shop_goods_spec_item') . ' where specid = :specid and uniacid = :uniacid order by displayorder asc ', array(':specid' => $value['id'], ':uniacid' => $_W['uniacid']));
			}

			$optionlist = pdo_fetchall('select id as optionid,specs as id,title as value,stock,productprice,marketprice from ' . tablename('ewei_shop_goods_option') . ' where goodsid = :goodsid and uniacid = :uniacid order by displayorder asc ', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));

			foreach ($optionlist as $key => $value) {
				$optionlist[$key]['marketprice'] = price_format($value['marketprice']);
				$optionlist[$key]['productprice'] = price_format($value['productprice']);
			}
		}

		return app_json(array(
			'goods'         => $item,
			'level_list'    => $levels,
			'group_list'    => $groups,
			'dispatch_list' => $dispatch_data,
			'diyform_list'  => $diyform_list,
			'category_list' => $category,
			'allcategory'   => $allcategory,
			'hasdiyform'    => p('diyform'),
			'hasvirtual'    => com('virtual'),
			'virtual_list'  => $virtual_list,
			'speclist'      => $specs,
			'optionarray'   => $optionlist,
			'specid'        => $specid,
			'spectitle'     => $spectitle,
			'perm'          => array('goods_edit' => cv('goods.edit'))
		));
	}

	/**
     * 保存商品
     */
	public function submit()
	{
		global $_W;
		global $_GPC;

		if (!$_W['ispost']) {
			return app_error(AppError::$RequestError);
		}

		if (!cv('goods.add') && cv('goods.edit')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$fields = 'id, title, subtitle, unit, `type`, hasoption, productprice, marketprice, costprice, total, totalcnf, showtotal, weight, goodssn, productsn, maxbuy, minbuy, usermaxbuy, isnodiscount, nocommission, diyformtype, diyformid, cash, invoice, status, displayorder, thumb, thumb_url, dispatchtype, dispatchprice, dispatchid, isrecommand, isnew, ishot, issendfree, merchid, cates';
			$item = pdo_fetch('SELECT ' . $fields . ' FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id and uniacid = :uniacid LIMIT 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		}

		$data = array('title' => trim($_GPC['title']), 'subtitle' => trim($_GPC['subtitle']), 'unit' => trim($_GPC['unit']), 'status' => intval($_GPC['status']), 'showtotal' => intval($_GPC['showtotal']), 'cash' => intval($_GPC['cash']), 'invoice' => intval($_GPC['invoice']), 'isnodiscount' => intval($_GPC['isnodiscount']), 'nocommission' => intval($_GPC['nocommission']), 'isrecommand' => intval($_GPC['isrecommand']), 'isnew' => intval($_GPC['isnew']), 'ishot' => intval($_GPC['ishot']), 'issendfree' => intval($_GPC['issendfree']), 'totalcnf' => intval($_GPC['totalcnf']), 'dispatchtype' => intval($_GPC['dispatchtype']), 'maxbuy' => intval($_GPC['maxbuy']), 'minbuy' => intval($_GPC['minbuy']), 'usermaxbuy' => intval($_GPC['usermaxbuy']), 'hasoption' => intval($_GPC['hasoption']), 'displayorder' => intval($_GPC['displayorder']), 'verifygoodsnum' => intval($_GPC['verifygoodsnum']), 'verifygoodslimittype' => intval($_GPC['verifygoodslimittype']));

		if (empty($item)) {
			$data['type'] = intval($_GPC['type']);
		}
		else {
			$data['type'] = $item['type'];
		}

		if ($_GPC['verifygoodslimittype'] == '0') {
			$data['verifygoodsdays'] = $_GPC['verifygoodsdays'];
		}
		else {
			if ($_GPC['verifygoodslimittype'] == '1') {
				$data['verifygoodslimitdate'] = strtotime($_GPC['verifygoodslimitdate']);
			}
		}

		$levels = m('member')->getLevels();

		foreach ($levels as &$l) {
			$l['key'] = 'level' . $l['id'];
		}

		unset($l);
		$discounts = array('type' => 0, 'default' => '', 'default_pay' => '');

		if (!empty($levels)) {
			foreach ($levels as $level) {
				$discounts[$level['key']] = '';
				$discounts[$level['key'] . '_pay'] = '';
			}

			unset($level);
		}

		$data['discounts'] = json_encode($discounts);

		if ($data['type'] == 2) {
			$data['virtualsend'] = intval($_GPC['virtualsend']);

			if (!empty($data['virtualsend'])) {
				$data['virtualsendcontent'] = trim($_GPC['virtualsendcontent']);
			}
		}
		else {
			if ($data['type'] == 3) {
				$data['virtual'] = intval($_GPC['virtual']);
			}
		}

		$thumbs = $_GPC['thumb'];

		if (is_array($thumbs)) {
			$thumb_url = array();

			foreach ($thumbs as $th) {
				$thumb_url[] = trim($th);
			}

			$data['thumb'] = save_media($thumb_url[0]);
			unset($thumb_url[0]);
			$data['thumb_url'] = serialize(m('common')->array_images($thumb_url));
		}

		if (empty($data['hasoption'])) {
			$data['hasoption'] = 0;
			$data['marketprice'] = trim($_GPC['marketprice']);
			$data['productprice'] = trim($_GPC['productprice']);
			$data['costprice'] = trim($_GPC['costprice']);
			$data['total'] = intval($_GPC['total']);
			$data['weight'] = trim($_GPC['weight']);
			$data['goodssn'] = trim($_GPC['goodssn']);
			$data['productsn'] = trim($_GPC['productsn']);
		}

		if ($item['diyformtype'] != 2) {
			$data['diyformid'] = intval($_GPC['diyformid']);

			if (!empty($data['diyformid'])) {
				$data['diyformtype'] = 1;
			}
			else {
				$data['diyformtype'] = 0;
			}
		}

		if (empty($data['dispatchtype'])) {
			$data['dispatchid'] = intval($_GPC['dispatchid']);
		}
		else {
			$data['dispatchprice'] = trim($_GPC['dispatchprice']);
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
		$cates = $_GPC['cates'];
		if (!is_array($cates) && !empty($cates)) {
			$cates = explode(',', $cates);
		}

		if (is_array($cates)) {
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

		if (!empty($item)) {
			pdo_update('ewei_shop_goods', $data, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			plog('goods.edit', '编辑商品 ID: ' . $id . '<br>' . (!empty($data['nocommission']) ? '是否参与分销 -- 否' : '是否参与分销 -- 是'));
		}
		else {
			$data['createtime'] = time();
			$data['uniacid'] = $_W['uniacid'];
			pdo_insert('ewei_shop_goods', $data);
			$id = pdo_insertid();
			$result['id'] = $id;
			plog('goods.add', '添加商品 ID: ' . $id . '<br>' . (!empty($data['nocommission']) ? '是否参与分销 -- 否' : '是否参与分销 -- 是'));
		}

		if (!empty($data['hasoption'])) {
			$speclist = $_GPC['speclist'];
			$totalstocks = 0;
			$files = $_FILES;
			$spec_ids = $_POST['specid'];
			$spec_titles = $_POST['spectitle'];
			$len = count($spec_ids);
			$specids = array();
			$spec_items = array();
			$k = 0;

			while ($k < $len) {
				$spec_id = '';
				$get_spec_id = $spec_ids[$k];
				$a = array('uniacid' => $_W['uniacid'], 'goodsid' => $id, 'displayorder' => $k, 'title' => $spec_titles[$k]);

				if (is_numeric($get_spec_id)) {
					pdo_update('ewei_shop_goods_spec', $a, array('id' => $get_spec_id));
					$spec_id = $get_spec_id;
				}
				else {
					pdo_insert('ewei_shop_goods_spec', $a);
					$spec_id = pdo_insertid();
				}

				$itemlen = count($speclist[$k]['specitem']);
				$itemids = array();
				$n = 0;

				while ($n < $itemlen) {
					$item_id = '';
					$get_item_id = $speclist[$k]['specitem'][$n]['id'];
					$d = array('uniacid' => $_W['uniacid'], 'specid' => $spec_id, 'displayorder' => $n, 'show' => 1, 'title' => $speclist[$k]['specitem'][$n]['value']);
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

			$option = $_GPC['option'];
			$len = count($option);
			$optionids = array();
			$k = 0;

			while ($k < $len) {
				$option_id = '';
				$ids = $option[$k]['id'];
				$get_option_id = $option[$k]['optionid'];
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
				$a = array('uniacid' => $_W['uniacid'], 'title' => $option[$k]['value'], 'productprice' => $option[$k]['productprice'], 'marketprice' => $option[$k]['marketprice'], 'stock' => $option[$k]['stock'], 'goodsid' => $id, 'specs' => $newids);

				if ($data['type'] == 4) {
					$a['presellprice'] = 0;
					$a['productprice'] = 0;
					$a['costprice'] = 0;
					$a['marketprice'] = floatval($_GPC['intervalprice1']);
				}

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
				++$k;
			}

			if (0 < count($optionids)) {
				pdo_query('delete from ' . tablename('ewei_shop_goods_option') . (' where goodsid=' . $id . ' and id not in ( ') . implode(',', $optionids) . ')');
				$sql = 'update ' . tablename('ewei_shop_goods') . ' g set
                g.minprice = (select min(marketprice) from ' . tablename('ewei_shop_goods_option') . (' where goodsid = ' . $id . '),
                g.maxprice = (select max(marketprice) from ') . tablename('ewei_shop_goods_option') . (' where goodsid = ' . $id . ')
                where g.id = ' . $id . ' and g.hasoption=1');
				pdo_query($sql);
			}

			pdo_update('ewei_shop_goods', array('total' => $totalstocks), array('id' => $id, 'uniacid' => $_W['uniacid']));
		}

		if (empty($data['hasoption'])) {
			pdo_query('delete from ' . tablename('ewei_shop_goods_option') . (' where goodsid=' . $id));
			$sql = 'update ' . tablename('ewei_shop_goods') . (' set minprice = marketprice,maxprice = marketprice where id = ' . $id . ' and hasoption=0;');
			pdo_query($sql);
		}

		$sqlgoods = 'SELECT id,title,thumb,marketprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,total,description,merchsale FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1';
		$goodsinfo = pdo_fetch($sqlgoods, array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$goodsinfo = m('goods')->getOneMinPrice($goodsinfo);
		pdo_update('ewei_shop_goods', array('minprice' => $goodsinfo['minprice'], 'maxprice' => $goodsinfo['maxprice']), array('id' => $id, 'uniacid' => $_W['uniacid']));
		$com_virtual = com('virtual');
		if ($data['type'] == 3 && $com_virtual) {
			$com_virtual->updateGoodsStock($id);
		}

		return app_json();
	}

	/**
     * 删除商品
     */
	public function delete()
	{
		global $_W;
		global $_GPC;

		if (!$_W['ispost']) {
			return app_error(AppError::$RequestError);
		}

		if (!cv('goods.delete')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$id = intval($_GPC['id']);
		$ids = $_GPC['ids'];
		if (empty($id) && !empty($ids)) {
			if (is_array($ids)) {
				$id = implode(',', $ids);
			}
			else {
				if (strexists($ids, ',')) {
					$id = $ids;
				}
			}
		}

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$items = pdo_fetchall('SELECT id, title FROM ' . tablename('ewei_shop_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']));

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_update('ewei_shop_goods', array('deleted' => 1), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('goods.delete', '删除商品 ID: ' . $item['id'] . ' 商品名称: ' . $item['title'] . ' ');
			}
		}

		return app_json();
	}

	/**
     * 上下架
     */
	public function status()
	{
		global $_W;
		global $_GPC;

		if (!$_W['ispost']) {
			return app_error(AppError::$RequestError);
		}

		if (!cv('goods.status')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$status = intval($_GPC['status']);
		if ($status != 0 && $status != 1) {
			return app_error(AppError::$ParamsError);
		}

		$id = intval($_GPC['id']);
		$ids = $_GPC['ids'];
		if (empty($id) && !empty($ids)) {
			if (is_array($ids)) {
				$id = implode(',', $ids);
			}
			else {
				if (strexists($ids, ',')) {
					$id = $ids;
				}
			}
		}

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']));

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_update('ewei_shop_goods', array('status' => $status), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('goods.edit', '修改商品状态<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['title'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '上架' : '下架');
			}
		}

		return app_json();
	}

	/**
     * 恢复至仓库
     */
	public function restore()
	{
		global $_W;
		global $_GPC;

		if (!$_W['ispost']) {
			return app_error(AppError::$RequestError);
		}

		if (!cv('goods.restore')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$id = intval($_GPC['id']);
		$ids = $_GPC['ids'];
		if (empty($id) && !empty($ids)) {
			if (is_array($ids)) {
				$id = implode(',', $ids);
			}
			else {
				if (strexists($ids, ',')) {
					$id = $ids;
				}
			}
		}

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (!empty($items)) {
			foreach ($items as $item) {
				pdo_update('ewei_shop_goods', array('deleted' => 0, 'status' => 0), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('goods.restore', '从回收站恢复商品<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['title']);
			}
		}

		return app_json();
	}
}

?>
