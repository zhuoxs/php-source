<?php

echo '
';

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Cart_EweiShopV2Page extends MobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			include $this->template('merch/member/cart');
			exit();
		}

		include $this->template();
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];

		if (p('newstore')) {
			$condition = ' and f.uniacid= :uniacid and f.openid=:openid and f.deleted=0 and f.isnewstore=0';
		}
		else {
			$condition = ' and f.uniacid= :uniacid and f.openid=:openid and f.deleted=0';
		}

		$params = array(':uniacid' => $uniacid, ':openid' => $openid);
		$list = array();
		$total = 0;
		$totalprice = 0;
		$ischeckall = true;
		$level = m('member')->getLevel($openid);
		$sql = 'SELECT f.id,f.total,f.goodsid,g.status,g.total as stock,g.preselltimeend,g.presellprice as gpprice,g.hasoption, o.stock as optionstock,g.presellprice,g.ispresell, g.maxbuy,g.title,g.thumb,ifnull(o.marketprice, g.marketprice) as marketprice,' . ' g.deleted,g.productprice,o.title as optiontitle,o.presellprice,f.optionid,o.specs,g.minbuy,g.maxbuy,g.unit,g.merchid,g.checked,g.isdiscount_discounts,g.isdiscount,g.isdiscount_time,g.isnodiscount,g.discounts,g.merchsale' . ' ,f.selected,g.type,g.intervalfloor,g.intervalprice  FROM ' . tablename('ewei_shop_member_cart') . ' f ' . ' left join ' . tablename('ewei_shop_goods') . ' g on f.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on f.optionid = o.id ' . ' where 1 ' . $condition . ' ORDER BY `id` DESC ';
		$list = pdo_fetchall($sql, $params);
		$invalidGoods = array();
		$saleoutGoods = array();

		foreach ($list as $index => &$g) {
			$g['cart_number'] = $g['total'];

			if ($g['type'] == 4) {
				$intervalprice = iunserializer($g['intervalprice']);

				if (0 < $g['intervalfloor']) {
					$g['intervalprice1'] = $intervalprice[0]['intervalprice'];
					$g['intervalnum1'] = $intervalprice[0]['intervalnum'];
				}

				if (1 < $g['intervalfloor']) {
					$g['intervalprice2'] = $intervalprice[1]['intervalprice'];
					$g['intervalnum2'] = $intervalprice[1]['intervalnum'];
				}

				if (2 < $g['intervalfloor']) {
					$g['intervalprice3'] = $intervalprice[2]['intervalprice'];
					$g['intervalnum3'] = $intervalprice[2]['intervalnum'];
				}
			}

			if (0 < $g['ispresell'] && ($g['preselltimeend'] == 0 || time() < $g['preselltimeend'])) {
				$g['marketprice'] = 0 < intval($g['hasoption']) ? $g['presellprice'] : $g['gpprice'];
			}

			$g['thumb'] = tomedia($g['thumb']);
			$seckillinfo = plugin_run('seckill::getSeckill', $g['goodsid'], $g['optionid'], true, $_W['openid']);

			if (!empty($g['optionid'])) {
				$g['stock'] = $g['optionstock'];

				if (!empty($g['specs'])) {
					$thumb = m('goods')->getSpecThumb($g['specs']);

					if (!empty($thumb)) {
						$g['thumb'] = tomedia($thumb);
					}
				}

				$optionData = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods_option') . ' WHERE uniacid = ' . intval($_W['uniacid']) . ' AND id = ' . intval($g['optionid']));
				if (empty($optionData) || $optionData == false) {
					pdo_update('ewei_shop_member_cart', array('deleted' => 1), array('id' => $g['id']));
				}
			}

			if ($g['status'] == 0 || $g['stock'] == 0 || $g['hasoption'] == 1 && $g['optionstock'] == 0) {
				$g['selected'] = false;
				pdo_update('ewei_shop_member_cart', array('selected' => 0), array('id' => $g['id']));
			}

			if ($g['status'] == 0 || $g['deleted'] == 1) {
				$g['desc'] = '失效';
				$invalidGoods[] = $g;
				pdo_update('ewei_shop_member_cart', array('selected' => 0), array('id' => $g['id']));
				unset($list[$index]);
				continue;
			}

			if ($g['hasoption'] == 1 && $g['optionstock'] == 0) {
				$g['desc'] = '售罄';
				$saleoutGoods[] = $g;
				unset($list[$index]);
			}
			else {
				if ($g['stock'] == 0) {
					$saleoutGoods[] = $g;
					unset($list[$index]);
				}
			}

			if ($g['status'] == 2) {
				unset($list[$index]);
				pdo_update('ewei_shop_member_cart', array('deleted' => 1), array('id' => $g['id']));
			}

			if ($g['selected']) {
				$prices = m('order')->getGoodsDiscountPrice($g, $level, 1);
				$total += $g['total'];
				$g['marketprice'] = $g['ggprice'] = $prices['price'];
				$g['discounttype'] = $prices['discounttype'];
				if ($seckillinfo && $seckillinfo['status'] == 0) {
					$seckilllast = 0;

					if (0 < $seckillinfo['maxbuy']) {
						$seckilllast = $seckillinfo['maxbuy'] - $seckillinfo['selfcount'];
					}

					$normal = $g['total'] - $seckilllast;

					if ($normal <= 0) {
						$normal = 0;
					}

					$totalprice += $seckillinfo['price'] * $seckilllast + $g['marketprice'] * $normal;
					$g['seckillmaxbuy'] = $seckillinfo['maxbuy'];
					$g['seckillselfcount'] = $seckillinfo['selfcount'];
					$g['seckillprice'] = $seckillinfo['price'];
					$g['seckilltag'] = $seckillinfo['tag'];
					$g['seckilllast'] = $seckilllast;
				}
				else {
					$totalprice += $g['marketprice'] * $g['total'];
				}
			}

			$totalmaxbuy = $g['stock'];
			if ($seckillinfo && $seckillinfo['status'] == 0) {
				if ($g['seckilllast'] < $totalmaxbuy) {
					$totalmaxbuy = $g['seckilllast'];
				}

				if ($totalmaxbuy < $g['total']) {
					$g['total'] = $totalmaxbuy;
				}

				$g['minbuy'] = 0;
			}
			else if ($g['type'] == 4) {
			}
			else {
				if (0 < $g['maxbuy']) {
					if ($totalmaxbuy != -1) {
						if ($g['maxbuy'] < $totalmaxbuy) {
							$totalmaxbuy = $g['maxbuy'];
						}
					}
					else {
						$totalmaxbuy = $g['maxbuy'];
					}
				}

				if (0 < $g['usermaxbuy']) {
					$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $g['goodsid'], ':uniacid' => $uniacid, ':openid' => $openid));
					$last = $g['usermaxbuy'] - $order_goodscount;

					if ($last <= 0) {
						$last = 0;
					}

					if ($totalmaxbuy != -1) {
						if ($last < $totalmaxbuy) {
							$totalmaxbuy = $last;
						}
					}
					else {
						$totalmaxbuy = $last;
					}
				}

				if (0 < $g['minbuy']) {
					if ($totalmaxbuy < $g['minbuy']) {
						$g['minbuy'] = $totalmaxbuy;
					}
				}
			}

			$g['totalmaxbuy'] = $totalmaxbuy;
			$g['unit'] = empty($data['unit']) ? '件' : $data['unit'];
			$g['productprice'] = price_format($g['productprice']);
		}

		unset($g);
		array_walk($list, function($value) use(&$ischeckall) {
			if ($value['selected'] == 0) {
				$ischeckall = false;
			}
		});
		$list = array_merge($list, $saleoutGoods, $invalidGoods);
		$list = set_medias($list, 'thumb');
		$merch_user = array();
		$merch = array();
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$getListUser = $merch_plugin->getListUser($list);
			$merch_user = $getListUser['merch_user'];
			$merch = $getListUser['merch'];
		}

		if (empty($list)) {
			$list = array();
		}
		else {
			foreach ($list as $g) {
				$goodsmerchid = $g['merchid'];

				if (!isset($merch_user[$goodsmerchid])) {
					$merch_user[$goodsmerchid] = array('goods_count' => 0, 'goods_selected' => 0);
				}

				$merch_user[$goodsmerchid]['goods_count'] = intval($merch_user[$goodsmerchid]['goods_count']);
				$merch_user[$goodsmerchid]['goods_selected'] = intval($merch_user[$goodsmerchid]['goods_selected']);
				++$merch_user[$goodsmerchid]['goods_count'];

				if (!empty($g['selected'])) {
					++$merch_user[$goodsmerchid]['goods_selected'];
				}
			}

			foreach ($merch_user as $merchid => $merchuser) {
				if (!isset($merchuser['goods_selected']) || !isset($merchuser['goods_count'])) {
					continue;
				}

				if ($merchuser['goods_selected'] == $merchuser['goods_count']) {
					$merch_user[$merchid]['selectedall'] = 1;
				}
				else {
					$merch_user[$merchid]['selectedall'] = 0;
				}
			}
		}

		$shopSet = m('common')->getSysset('shop');
		$saleout_icon = isset($shopSet['saleout']) ? tomedia($shopSet['saleout']) : '';
		show_json(1, array('saleout_icon' => $saleout_icon, 'ischeckall' => $ischeckall, 'list' => $list, 'total' => $total, 'totalprice' => round($totalprice, 2), 'merch_user' => $merch_user, 'merch' => $merch));
	}

	public function select()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$select = intval($_GPC['select']);

		if (!empty($id)) {
			$data = pdo_fetch('select id,goodsid,optionid, total from ' . tablename('ewei_shop_member_cart') . ' ' . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			if (!empty($data)) {
				pdo_update('ewei_shop_member_cart', array('selected' => $select), array('id' => $id, 'uniacid' => $_W['uniacid']));
			}
		}
		else {
			$cartGoods = pdo_fetchall('select c.id as cartid,g.id as goodsid, g.total as stock, g.status, c.optionid, o.stock as optionstock from ' . tablename('ewei_shop_member_cart') . ' c' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id = c.goodsid' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on o.id = c.optionid' . ' where c.uniacid = :uniacid and c.openid = :openid and c.deleted = 0 and g.status <> 0', array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
			$ret = array();

			foreach ($cartGoods as $cartGoodItem) {
				if ($cartGoodItem['optionid']) {
					$cartGoodItem['stock'] = $cartGoodItem['optionstock'];
				}

				if ($cartGoodItem['stock'] == 0 || $cartGoodItem['status'] == 0) {
					continue;
				}

				$ret[] = $cartGoodItem['cartid'];
			}

			$ret = implode(',', $ret);
			pdo_query('update ' . tablename('ewei_shop_member_cart') . (' set selected = ' . $select . ' where id in (' . $ret . ')'));
		}

		show_json(1);
	}

	public function update()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$goodstotal = intval($_GPC['total']);
		$optionid = intval($_GPC['optionid']);
		$type = intval($_GPC['type']);

		if ($type == 0) {
			return NULL;
		}

		if (empty($goodstotal)) {
			$goodstotal = 1;
		}

		$data = pdo_fetch('select id,goodsid,optionid,total,selected from ' . tablename('ewei_shop_member_cart') . ' ' . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if (empty($data)) {
			show_json(0, '无购物车记录');
		}

		pdo_update('ewei_shop_member_cart', array('total' => $goodstotal, 'optionid' => $optionid), array('id' => $id, 'uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
		$seckillinfo = plugin_run('seckill::getSeckill', $data['goodsid'], $data['optionid'], true, $_W['openid']);
		if ($seckillinfo && $seckillinfo['status'] == 0) {
			$g = array();
			$g['seckillmaxbuy'] = $seckillinfo['maxbuy'];
			$g['seckillselfcount'] = $seckillinfo['selfcount'];
			$g['seckillprice'] = $seckillinfo['price'];
			show_json(1, array('seckillinfo' => $g));
		}

		show_json(1);
	}

	public function add()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$total = intval($_GPC['total']);
		$this->_validateCartOverLimit();
		$total <= 0 && ($total = 1);
		$optionid = intval($_GPC['optionid']);
		$goods = pdo_fetch('select id,marketprice,diyformid,diyformtype,diyfields, isverify, `type`,merchid, cannotrefund,hasoption from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($goods)) {
			show_json(0, '商品未找到');
		}

		if (0 < $goods['hasoption'] && empty($optionid)) {
			show_json(0, '请选择规格');
		}

		$member = m('member')->getMember($_W['openid']);
		if (!empty($_W['shopset']['wap']['open']) && !empty($_W['shopset']['wap']['mustbind']) && empty($member['mobileverify'])) {
			show_json(0, array('message' => '请先绑定手机', 'url' => mobileUrl('member/bind', NULL, true)));
		}

		if ($goods['isverify'] == 2 || $goods['type'] == 2 || $goods['type'] == 3 || !empty($goods['cannotrefund'])) {
			show_json(0, '此商品不可加入购物车<br>请直接点击立刻购买');
		}

		$giftid = intval($_GPC['giftid']);
		$gift = pdo_fetch('select * from ' . tablename('ewei_shop_gift') . ' where uniacid = ' . $_W['uniacid'] . ' and id = ' . $giftid . ' and starttime >= ' . time() . ' and endtime <= ' . time() . ' and status = 1 ');
		$diyform_plugin = p('diyform');
		$diyformid = 0;
		$diyformfields = iserializer(array());
		$diyformdata = iserializer(array());

		if ($diyform_plugin) {
			$diyformdata = $_GPC['diyformdata'];
			if (!empty($diyformdata) && is_array($diyformdata)) {
				$diyformfields = false;

				if ($goods['diyformtype'] == 1) {
					$diyformid = intval($goods['diyformid']);
					$formInfo = $diyform_plugin->getDiyformInfo($diyformid);

					if (!empty($formInfo)) {
						$diyformfields = $formInfo['fields'];
					}
				}
				else {
					if ($goods['diyformtype'] == 2) {
						$diyformfields = iunserializer($goods['diyfields']);
					}
				}

				if (!empty($diyformfields)) {
					$insert_data = $diyform_plugin->getInsertData($diyformfields, $diyformdata);
					$diyformdata = $insert_data['data'];
					$diyformfields = iserializer($diyformfields);
				}
			}
		}

		$data = pdo_fetch('select id,total,diyformid from ' . tablename('ewei_shop_member_cart') . ' where goodsid=:id and openid=:openid and   optionid=:optionid  and deleted=0 and  uniacid=:uniacid   limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':optionid' => $optionid, ':id' => $id));

		if (empty($data)) {
			$data = array('uniacid' => $_W['uniacid'], 'merchid' => $goods['merchid'], 'openid' => $_W['openid'], 'goodsid' => $id, 'optionid' => $optionid, 'marketprice' => $goods['marketprice'], 'total' => $total, 'selected' => 1, 'diyformid' => $diyformid, 'diyformdata' => $diyformdata, 'diyformfields' => $diyformfields, 'createtime' => time());
			pdo_insert('ewei_shop_member_cart', $data);
		}
		else {
			$data['diyformid'] = $diyformid;
			$data['diyformdata'] = $diyformdata;
			$data['diyformfields'] = $diyformfields;
			$data['total'] += $total;
			pdo_update('ewei_shop_member_cart', $data, array('id' => $data['id']));
		}

		$cartcount = pdo_fetchcolumn('select sum(total) from ' . tablename('ewei_shop_member_cart') . ' where openid=:openid and deleted=0 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		show_json(1, array('isnew' => false, 'cartcount' => $cartcount, 'goodsid' => $id));
	}

	public function addwholesale()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$optionsjson = $_GPC['options'];
		$optionsdata = json_decode(htmlspecialchars_decode($optionsjson, ENT_QUOTES), true);
		$this->_validateCartOverLimit();
		$goods = pdo_fetch('select id,marketprice,diyformid,diyformtype,diyfields, isverify, `type`,merchid, cannotrefund from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($goods)) {
			show_json(0, '商品未找到');
		}

		$member = m('member')->getMember($_W['openid']);
		if (!empty($_W['shopset']['wap']['open']) && !empty($_W['shopset']['wap']['mustbind']) && empty($member['mobileverify'])) {
			show_json(0, array('message' => '请先绑定手机', 'url' => mobileUrl('member/bind', NULL, true)));
		}

		foreach ($optionsdata as $option) {
			if (empty($option['total'])) {
				continue;
			}

			$data = pdo_fetch('select id,total,diyformid from ' . tablename('ewei_shop_member_cart') . ' where goodsid=:id and openid=:openid and   optionid=:optionid  and deleted=0 and  uniacid=:uniacid   limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':optionid' => $option['optionid'], ':id' => $id));

			if (empty($data)) {
				$data = array('uniacid' => $_W['uniacid'], 'merchid' => $goods['merchid'], 'openid' => $_W['openid'], 'goodsid' => $id, 'optionid' => $option['optionid'], 'marketprice' => $goods['marketprice'], 'total' => intval($option['total']), 'selected' => 1, 'createtime' => time());
				pdo_insert('ewei_shop_member_cart', $data);
			}
			else {
				$data['total'] += intval($option['total']);
				pdo_update('ewei_shop_member_cart', $data, array('id' => $data['id']));
			}
		}

		$cartcount = pdo_fetchcolumn('select sum(total) from ' . tablename('ewei_shop_member_cart') . ' where openid=:openid and deleted=0 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		show_json(1, array('isnew' => false, 'cartcount' => $cartcount));
	}

	private function _validateCartOverLimit()
	{
		global $_W;
		global $_GPC;
		$listCount = pdo_fetch('select count(*) sum from' . tablename('ewei_shop_member_cart') . ' where uniacid = :uniacid and openid = :openid and deleted = 0', array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
		$listCount = empty($listCount['sum']) ? 0 : $listCount['sum'];
		$wholesaleCount = 0;
		$simpleGoodsCount = 1;

		if (isset($_GPC['options'])) {
			$optionsdata = json_decode(htmlspecialchars_decode($_GPC['options'], ENT_QUOTES), true);

			foreach ($optionsdata as $item) {
				if (!empty($item['total'])) {
					++$wholesaleCount;
				}
			}
		}

		if (50 < $listCount + $simpleGoodsCount + $wholesaleCount) {
			show_json(0, '您的购物车宝贝超过50个了，建议您先去结算或清理');
		}
	}

	public function remove()
	{
		global $_W;
		global $_GPC;
		$ids = $_GPC['ids'];
		if (empty($ids) || !is_array($ids)) {
			show_json(0, '参数错误');
		}

		$sql = 'update ' . tablename('ewei_shop_member_cart') . ' set deleted=1 where uniacid=:uniacid and openid=:openid and id in (' . implode(',', $ids) . ')';
		pdo_query($sql, array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		show_json(1);
	}

	public function tofavorite()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$ids = $_GPC['ids'];
		if (empty($ids) || !is_array($ids)) {
			show_json(0, '参数错误');
		}

		foreach ($ids as $id) {
			$goodsid = pdo_fetchcolumn('select goodsid from ' . tablename('ewei_shop_member_cart') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1 ', array(':id' => $id, ':uniacid' => $uniacid, ':openid' => $openid));

			if (!empty($goodsid)) {
				$fav = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member_favorite') . ' where goodsid=:goodsid and uniacid=:uniacid and openid=:openid and deleted=0 limit 1 ', array(':goodsid' => $goodsid, ':uniacid' => $uniacid, ':openid' => $openid));

				if ($fav <= 0) {
					$fav = array('uniacid' => $uniacid, 'goodsid' => $goodsid, 'openid' => $openid, 'deleted' => 0, 'createtime' => time());
					pdo_insert('ewei_shop_member_favorite', $fav);
				}
			}
		}

		$sql = 'update ' . tablename('ewei_shop_member_cart') . ' set deleted=1 where uniacid=:uniacid and openid=:openid and id in (' . implode(',', $ids) . ')';
		pdo_query($sql, array(':uniacid' => $uniacid, ':openid' => $openid));
		show_json(1);
	}

	public function caculategoodsprice()
	{
		global $_W;
		global $_GPC;
		$goods = $_GPC['goods'];
		$goods = m('goods')->wholesaleprice($goods);
		$cartgoods = array();

		foreach ($goods as $g) {
			$cartgoods[$g['id']] = $g;
		}

		show_json(1, array('goods' => $cartgoods));
	}

	/**
     * 让商品变为不选中状态
     */
	private function cartGoodsCheckedStatus($id, $checked = false)
	{
		$selected = $checked ? 1 : 0;
		pdo_update('ewei_shop_member_cart', array('selected' => $selected), array('id' => $id));
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$condition = ' and f.uniacid= :uniacid and f.openid=:openid and f.selected=1 and f.deleted=0 ';
		$params = array(':uniacid' => $uniacid, ':openid' => $openid);
		$sql = 'SELECT f.id,f.total,f.goodsid,g.total as stock, o.stock as optionstock, g.hasoption,g.maxbuy,g.title,g.thumb,ifnull(o.marketprice, g.marketprice) as marketprice,' . ' g.productprice,o.title as optiontitle,f.optionid,o.specs,g.minbuy,g.maxbuy,g.usermaxbuy,g.unit,g.merchid,g.checked,g.isdiscount_discounts,g.isdiscount,g.isdiscount_time,g.isnodiscount,g.discounts,g.merchsale' . ' ,f.selected,g.status,g.deleted as goodsdeleted,g.type,g.intervalfloor,g.intervalprice  FROM ' . tablename('ewei_shop_member_cart') . ' f ' . ' left join ' . tablename('ewei_shop_goods') . ' g on f.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on f.optionid = o.id ' . ' where 1 ' . $condition . ' ORDER BY `id` DESC ';
		$list = pdo_fetchall($sql, $params);

		if (empty($list)) {
			show_json(0, '没有选择任何商品');
		}

		$list = m('goods')->wholesaleprice($list);
		$array = pdo_fetchall('select og.optionid  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':uniacid' => $uniacid, ':openid' => $openid));
		$t = 0;

		foreach ($list as $key => $a) {
			foreach ($array as $k => $b) {
				if ($list['hasoption']) {
					if ($list['optionid'] == $array['optionid']) {
						$t += 1;
					}
				}
			}

			$list[$key]['allt'] = $t;
			$t = 0;
		}

		foreach ($list as &$g) {
			if (empty($g['unit'])) {
				$g['unit'] = '件';
			}

			if ($g['optionid']) {
				$g['stock'] = $g['optionstock'];
			}

			if ($g['stock'] - $g['total'] < 0 && (!$g['optionid'] || $g['optionid'] && $g['stock'] != -1)) {
				pdo_update('ewei_shop_member_cart', array('selected' => 0, 'total' => $g['stock']), array('id' => $g['id']));
				$optionTitle = !empty($g['optiontitle']) ? $g['optiontitle'] : '';
				show_json(0, $g['title'] . '<br/>' . $optionTitle . ' 库存不足!');
			}

			if ($g['status'] == 0 || $g['goodsdeleted'] == 1) {
				$this->cartGoodsCheckedStatus($g['id']);
				show_json(0, $g['title'] . '<br/> 已经下架');
			}

			if ($g['type'] == 5 && 1 < count($list)) {
				show_json(0, $g['title'] . '<br/> 为记次商品，无法合并付款，请单独购买');
			}

			$seckillinfo = plugin_run('seckill::getSeckill', $g['goodsid'], $g['optionid'], true, $_W['openid']);

			if (!empty($g['optionid'])) {
				$g['stock'] = $g['optionstock'];
			}

			if ($seckillinfo && $seckillinfo['status'] == 0) {
				$check_buy = plugin_run('seckill::checkBuy', $seckillinfo, $g['title'], $g['unit']);

				if (is_error($check_buy)) {
					show_json(-1, $check_buy['message']);
				}
			}
			else {
				$levelid = intval($member['level']);

				if (empty($member['groupid'])) {
					$groupid = array();
				}
				else {
					$groupid = explode(',', $member['groupid']);
				}

				if ($g['buylevels'] != '') {
					$buylevels = explode(',', $g['buylevels']);

					if (!in_array($levelid, $buylevels)) {
						show_json(0, '您的会员等级无法购买<br/>' . $g['title'] . '!');
					}
				}

				if ($g['buygroups'] != '') {
					if (empty($groupid)) {
						$groupid[] = 0;
					}

					$buygroups = explode(',', $g['buygroups']);
					$intersect = array_intersect($groupid, $buygroups);

					if (empty($intersect)) {
						show_json(0, '您所在会员组无法购买<br/>' . $g['title'] . '!');
					}
				}

				if ($g['type'] == 4) {
					if ($g['goodsalltotal'] < $g['minbuy']) {
						show_json(0, $g['title'] . '<br/> ' . $g['minbuy'] . $g['unit'] . '起批!');
					}
				}
				else {
					if (0 < $g['minbuy']) {
						if ($g['total'] < $g['minbuy']) {
							show_json(0, $g['title'] . '<br/> ' . $g['minbuy'] . $g['unit'] . '起售!');
						}
					}

					if (0 < $g['maxbuy']) {
						if ($g['maxbuy'] < $g['total']) {
							show_json(0, $g['title'] . '<br/> 一次限购 ' . $g['maxbuy'] . $g['unit'] . '!');
						}
					}
				}

				if (0 < $g['usermaxbuy']) {
					if ($g['usermaxbuy'] < $g['total'] || $g['usermaxbuy'] < $g['allt']) {
						show_json(0, $g['title'] . '<br/> 最多限购 ' . $g['usermaxbuy'] . $g['unit'] . '!');
					}

					$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $g['goodsid'], ':uniacid' => $uniacid, ':openid' => $openid));
					if ($g['usermaxbuy'] < $order_goodscount || $g['usermaxbuy'] < $order_goodscount + $g['allt']) {
						show_json(0, $g['title'] . '<br/> 最多限购 ' . $g['usermaxbuy'] . $g['unit'] . '!');
					}

					$total_buy = $order_goodscount + $g['total'];
					if ($g['usermaxbuy'] < $total_buy || $g['usermaxbuy'] < $order_goodscount + $g['allt']) {
						show_json(0, $g['title'] . '<br/> 最多限购 ' . $g['usermaxbuy'] . $g['unit'] . '!');
					}
				}

				if (!empty($g['optionid'])) {
					$option = pdo_fetch('select id,title,marketprice,goodssn,productsn,stock,`virtual`,weight from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $g['goodsid'], ':id' => $g['optionid']));

					if (!empty($option)) {
						if ($option['stock'] != -1) {
							if (empty($option['stock'])) {
								show_json(-1, $g['title'] . '<br/>' . $option['title'] . ' 库存不足!');
							}
						}
					}
				}
				else {
					if ($g['stock'] != -1) {
						if (empty($g['stock'])) {
							show_json(0, $g['title'] . '<br/>库存不足!');
						}
					}
				}
			}
		}

		show_json(1);
	}
}

?>
