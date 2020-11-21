<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Cart_EweiShopV2Page extends AppMobilePage
{
	public function get_cart()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$condition = ' and f.uniacid= :uniacid and f.openid=:openid and f.deleted=0';
		$params = array(':uniacid' => $uniacid, ':openid' => $openid);
		$list = array();
		$total = 0;
		$totalprice = 0;
		$ischeckall = true;
		$level = m('member')->getLevel($openid);
		$sql = 'SELECT f.id,f.total,g.status,f.goodsid,g.total as stock, g.discounts,g.isdiscount_discounts,g.deleted,o.stock as optionstock, g.maxbuy,g.title,g.thumb,ifnull(o.marketprice, g.marketprice) as marketprice,' . ' g.productprice,o.title as optiontitle,f.optionid,o.specs,g.minbuy,g.maxbuy,g.unit,f.merchid,g.merchsale' . ' ,f.selected FROM ' . tablename('ewei_shop_member_cart') . ' f ' . ' left join ' . tablename('ewei_shop_goods') . ' g on f.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on f.optionid = o.id ' . ' where 1 ' . $condition . ' ORDER BY `id` DESC ';
		$list = pdo_fetchall($sql, $params);
		$invalidGoods = array();
		$saleoutGoods = array();

		foreach ($list as $index => &$g) {
			$g['cart_number'] = $g['total'];
			$g['cantbuy'] = 0;
			if ($g['status'] == 0 || $g['deleted'] == 1) {
				$g['cantbuy'] = 1;
				$invalidGoods[] = $g;
				unset($list[$index]);
			}

			if ($g['status'] != 0 && $g['optionid'] != 0 && $g['optionstock'] == 0 || $g['status'] != 0 && $g['optionid'] == 0 && $g['stock'] == 0) {
				$g['cantbuy'] = 1;
				$saleoutGoods[] = $g;
				unset($list[$index]);
			}

			if (!empty($g['optionid'])) {
				$g['stock'] = $g['optionstock'];

				if (!empty($g['specs'])) {
					$thumb = m('goods')->getSpecThumb($g['specs']);

					if (!empty($thumb)) {
						$g['thumb'] = $thumb;
					}
				}
			}

			$g['marketprice'] = (double) $g['marketprice'];
			if ($g['status'] == 0 || $g['stock'] == 0 || $g['deleted'] == 1) {
				$g['selected'] = false;
				pdo_update('ewei_shop_member_cart', array('selected' => 0), array('id' => $g['id']));
			}

			$totalmaxbuy = $g['stock'];

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

			if ($totalmaxbuy < $g['total']) {
				$g['total'] = $totalmaxbuy;
			}

			if ($g['selected']) {
				$prices = m('order')->getGoodsDiscountPrice($g, $level, 1);
				$g['marketprice'] = $prices['price'];
				$g['oldprice'] = $prices['price0'];
				$totalprice += $g['marketprice'] * $g['total'];
				$total += $g['total'];
			}

			$g['totalmaxbuy'] = $totalmaxbuy;
			$g['productprice'] = price_format($g['productprice']);
			$g['unit'] = empty($data['unit']) ? '件' : $data['unit'];
			unset($g['maxbuy']);
			if ($g['status'] != 0 && $g['stock'] != 0 && $g['selected'] == 0) {
				$ischeckall = false;
			}
		}

		unset($g);
		$list = array_merge($list, $saleoutGoods, $invalidGoods);
		$list = set_medias($list, 'thumb');
		$result = array('ischeckall' => $ischeckall, 'total' => (int) $total, 'totalprice' => (double) $totalprice, 'empty' => empty($list));
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$getListUser = $merch_plugin->getListUser($list);
			$merch_user = $getListUser['merch_user'];
			$merch = $getListUser['merch'];
			if (is_array($list) && !empty($list)) {
				$newlist = array();

				foreach ($merch as $merchid => $merchlist) {
					$newlist[] = array('merchname' => $merch_user[$merchid]['merchname'], 'merchid' => $merchid, 'list' => $merchlist);
				}
			}

			$result['merch_list'] = $newlist;
		}
		else if ($this->iswxapp) {
			$result['list'] = $list;
		}
		else {
			$result['merch_list'] = array(
				array('merchname' => '', 'merchid' => 0, 'list' => $list)
			);
		}

		$can_sync_goodscircle = false;
		$goodscircle_set = m('common')->getPluginset('goodscircle');
		if (p('goodscircle') && $goodscircle_set['cart']) {
			$can_sync_goodscircle = true;
		}

		$result['can_sync_goodscircle'] = $can_sync_goodscircle;
		return app_json($result);
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
		$sql = 'SELECT f.id,f.total,f.goodsid,g.total as stock, o.stock as optionstock,g.buylevels, g.hasoption,g.maxbuy,g.title,g.thumb,ifnull(o.marketprice, g.marketprice) as marketprice,' . ' g.productprice,o.title as optiontitle,f.optionid,o.specs,g.minbuy,g.maxbuy,g.usermaxbuy,g.unit,g.merchid,g.checked,g.isdiscount_discounts,g.isdiscount,g.isdiscount_time,g.isnodiscount,g.discounts,g.merchsale' . ' ,f.selected,g.status,g.deleted as goodsdeleted,g.type,g.intervalfloor,g.intervalprice  FROM ' . tablename('ewei_shop_member_cart') . ' f ' . ' left join ' . tablename('ewei_shop_goods') . ' g on f.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on f.optionid = o.id ' . ' where 1 ' . $condition . ' ORDER BY `id` DESC ';
		$list = pdo_fetchall($sql, $params);

		if (empty($list)) {
			return app_error(AppError::$CartNoGoodsError);
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

			if ($g['status'] != 1 || $g['goodsdeleted'] == 1) {
				return app_error(AppError::$GoodsSoldOut, $g['title'] . ' 已经下架!');
			}

			if ($g['type'] == 5 && 1 < count($list)) {
				return app_error(AppError::$CanNotCombinePay, $g['title'] . ' 为记次商品，无法合并付款，请单独购买');
			}

			$seckillinfo = plugin_run('seckill::getSeckill', $g['goodsid'], $g['optionid'], true, $_W['openid']);

			if (!empty($g['optionid'])) {
				$g['stock'] = $g['optionstock'];
			}

			if ($g['stock'] - $g['total'] < 0) {
				pdo_update('ewei_shop_member_cart', array('selected' => 0), array('id' => $g['id']));

				if ($g['optionid']) {
					return app_error(AppError::$OrderCreateStockError, $g['title'] . '  ' . $g['optiontitle'] . ' 库存不足');
				}

				return app_error(AppError::$OrderCreateStockError, $g['title'] . ' 库存不足');
			}

			if ($seckillinfo && $seckillinfo['status'] == 0) {
				$check_buy = plugin_run('seckill::checkBuy', $seckillinfo, $g['title'], $g['unit']);

				if (is_error($check_buy)) {
					return app_error(-1, $check_buy['message']);
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
						$this->cartGoodsCheckedStatus($g['id']);
						return app_error(AppError::$LevelNotEnough, '您的会员等级无法购买' . $g['title'] . '!');
					}
				}

				if ($g['buygroups'] != '') {
					if (empty($groupid)) {
						$groupid[] = 0;
					}

					$buygroups = explode(',', $g['buygroups']);
					$intersect = array_intersect($groupid, $buygroups);

					if (empty($intersect)) {
						$this->cartGoodsCheckedStatus($g['id']);
						return app_error(AppError::$MemberGroupCanNotBuy, '您所在会员组无法购买 ' . $g['title'] . '!');
					}
				}

				if ($g['type'] == 4) {
					if ($g['goodsalltotal'] < $g['minbuy']) {
						$this->cartGoodsCheckedStatus($g['id']);
						return app_error(AppError::$ProductNumberNotEnough, $g['title'] . '  ' . $g['minbuy'] . $g['unit'] . '起批!');
					}
				}
				else {
					if (0 < $g['minbuy']) {
						if ($g['total'] < $g['minbuy']) {
							$this->cartGoodsCheckedStatus($g['id']);
							return app_error(AppError::$NumberForSaleNotEnough, $g['title'] . '  ' . $g['minbuy'] . $g['unit'] . '起售!');
						}
					}

					if (0 < $g['maxbuy']) {
						if ($g['maxbuy'] < $g['total']) {
							$this->cartGoodsCheckedStatus($g['id']);
							return app_error(AppError::$PurchaseLimitError, $g['title'] . '  一次限购 ' . $g['maxbuy'] . $g['unit'] . '!');
						}
					}
				}

				if (0 < $g['usermaxbuy']) {
					if ($g['usermaxbuy'] < $g['total'] || $g['usermaxbuy'] < $g['allt']) {
						show_json(AppError::$maxPruchaseLimitError, $g['title'] . '  最多限购 ' . $g['usermaxbuy'] . $g['unit'] . '!');
					}

					$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $g['goodsid'], ':uniacid' => $uniacid, ':openid' => $openid));
					if ($g['usermaxbuy'] < $order_goodscount || $g['usermaxbuy'] < $order_goodscount + $g['allt']) {
						return app_error(AppError::$maxPruchaseLimitError, $g['title'] . '  最多限购 ' . $g['usermaxbuy'] . $g['unit'] . '!');
					}

					$total_buy = $order_goodscount + $g['total'];
					if ($g['usermaxbuy'] < $total_buy || $g['usermaxbuy'] < $order_goodscount + $g['allt']) {
						return app_error(AppError::$maxPruchaseLimitError, $g['title'] . '  最多限购 ' . $g['usermaxbuy'] . $g['unit'] . '!');
					}
				}

				if (!empty($g['optionid'])) {
					$option = pdo_fetch('select id,title,marketprice,goodssn,productsn,stock,`virtual`,weight from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $g['goodsid'], ':id' => $g['optionid']));

					if (!empty($option)) {
						if ($option['stock'] != -1) {
							if (empty($option['stock'])) {
								$this->cartGoodsCheckedStatus($g['id']);
								return app_error(AppError::$OrderCreateStockError, $g['title'] . ' ' . $option['title'] . ' 库存不足!');
							}
						}
					}
				}
				else {
					if ($g['stock'] != -1) {
						if (empty($g['stock'])) {
							$this->cartGoodsCheckedStatus($g['id']);
							return app_error(AppError::$OrderCreateStockError, $g['title'] . ' 库存不足!');
						}
					}
				}
			}
		}

		return app_json(0);
	}

	public function add()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$total = intval($_GPC['total']);
		$total <= 0 && ($total = 1);

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$optionid = intval($_GPC['optionid']);
		$goods = pdo_fetch('select id,marketprice,`type`,total,diyformid,diyformtype,diyfields, isverify,merchid,cannotrefund,hasoption from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($goods)) {
			return app_error(AppError::$GoodsNotFound);
		}

		if (0 < $goods['hasoption'] && empty($optionid)) {
			return app_error(1, '请选择规格!');
		}

		if ($goods['total'] < $total) {
			$total = $goods['total'];
		}

		if ($goods['isverify'] == 2 || $goods['type'] == 2 || $goods['type'] == 3 || $goods['type'] == 5 ) {
			return app_error(AppError::$NotAddCart);
		}

		$diyform_plugin = p('diyform');
		$diyformid = 0;
		$diyformfields = iserializer(array());
		$diyformdata = iserializer(array());

		if ($diyform_plugin) {
			$diyformdata = $_GPC['diyformdata'];

			if (is_string($diyformdata)) {
				$diyformdatastring = htmlspecialchars_decode(str_replace('\\', '', $_GPC['diyformdata']));
				$diyformdata = @json_decode($diyformdatastring, true);
			}

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
					$insert_data = $diyform_plugin->getInsertData($diyformfields, $diyformdata, true);
					$diyformdata = $insert_data['data'];
					$diyformfields = iserializer($diyformfields);
				}
			}
		}

		$data = pdo_fetch('select id,total,diyformid from ' . tablename('ewei_shop_member_cart') . ' where goodsid=:id and openid=:openid and   optionid=:optionid  and deleted=0 and  uniacid=:uniacid   limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':optionid' => $optionid, ':id' => $id));

		if (empty($data)) {
			$data = array('uniacid' => $_W['uniacid'], 'merchid' => $goods['merchid'], 'openid' => $_W['openid'], 'goodsid' => $id, 'optionid' => $optionid, 'marketprice' => $goods['marketprice'], 'total' => $total, 'selected' => 1, 'diyformid' => $diyformid, 'diyformdata' => $diyformdata, 'diyformfields' => $diyformfields, 'createtime' => time());
			pdo_insert('ewei_shop_member_cart', $data);
			$data['id'] = pdo_insertid();
		}
		else {
			$data['diyformid'] = $diyformid;
			$data['diyformdata'] = $diyformdata;
			$data['diyformfields'] = $diyformfields;
			$data['total'] += $total;
			pdo_update('ewei_shop_member_cart', $data, array('id' => $data['id']));
		}

		$cartcount = pdo_fetchcolumn('select sum(total) from ' . tablename('ewei_shop_member_cart') . ' where openid=:openid and deleted=0 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		$goodscircle = p('goodscircle');

		if ($goodscircle) {
			$goodscircle->addShoppingList($_W['openid'], $data['id'], $id);
			$goodscircle->importGoods($id);
		}

		return app_json(array('isnew' => false, 'cartcount' => $cartcount));
	}

	public function update()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$goodstotal = intval($_GPC['total']);

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$optionid = intval($_GPC['optionid']);
		empty($goodstotal) && ($goodstotal = 1);
		$data = pdo_fetch('select * from ' . tablename('ewei_shop_member_cart') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if (empty($data)) {
			return app_error(AppError::$NotInCart);
		}

		$goods = pdo_fetch('select id,maxbuy,minbuy,total,unit from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid and status=1 and deleted=0', array(':id' => $data['goodsid'], ':uniacid' => $_W['uniacid']));

		if (empty($goods)) {
			return app_error(AppError::$GoodsNotFound);
		}

		$diyform_plugin = p('diyform');
		$diyformid = 0;
		$diyformfields = iserializer(array());
		$diyformdata = iserializer(array());

		if ($diyform_plugin) {
			$diyformdata = $_GPC['diyformdata'];
			if (!empty($diyformdata) && is_string($diyformdata)) {
				$diyformdatastring = htmlspecialchars_decode(str_replace('\\', '', $_GPC['diyformdata']));
				$diyformdata = @json_decode($diyformdatastring, true);
			}

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
					$insert_data = $diyform_plugin->getInsertData($diyformfields, $diyformdata, true);
					$diyformdata = $insert_data['data'];
					$diyformfields = iserializer($diyformfields);
				}
			}
		}

		$arr = array('total' => $goodstotal, 'optionid' => $optionid, 'diyformid' => $diyformid, 'diyformdata' => $diyformdata, 'diyformfields' => $diyformfields);
		pdo_update('ewei_shop_member_cart', $arr, array('id' => $id, 'uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
		return app_json();
	}

	public function remove()
	{
		global $_W;
		global $_GPC;
		$ids = $_GPC['ids'];

		if (empty($ids)) {
			return app_error(AppError::$ParamsError);
		}

		if (!is_array($ids)) {
			$ids = htmlspecialchars_decode(str_replace('\\', '', $ids));
			$ids = @json_decode($ids, true);
		}

		if (empty($ids)) {
			return app_error(AppError::$ParamsError);
		}

		$sql = 'update ' . tablename('ewei_shop_member_cart') . ' set deleted=1 where uniacid=:uniacid and openid=:openid and id in (' . implode(',', $ids) . ')';
		pdo_query($sql, array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		return app_json();
	}

	public function tofavorite()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$ids = $_GPC['ids'];

		if (empty($ids)) {
			return app_error(AppError::$ParamsError);
		}

		if (!is_array($ids)) {
			$ids = htmlspecialchars_decode(str_replace('\\', '', $ids));
			$ids = @json_decode($ids, true);
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
		return app_json();
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
			pdo_update('ewei_shop_member_cart', array('selected' => $select), array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
		}

		return app_json();
	}

	public function count()
	{
		global $_W;
		global $_GPC;
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$cartcount = (int) pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('ewei_shop_member_cart') . ' where uniacid=:uniacid and openid=:openid and deleted=0 and selected =1', $params);
		return app_json(array('cartcount' => $cartcount));
	}

	public function ceshi($info = '')
	{
		return $info;
	}
}

?>
