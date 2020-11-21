<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Create_EweiShopV2Page extends PluginMobilePage
{
	protected function diyformData($member)
	{
		global $_W;
		global $_GPC;
		$diyform_plugin = p('diyform');
		$order_formInfo = false;
		$diyform_set = false;
		$orderdiyformid = 0;
		$fields = array();
		$f_data = array();

		if ($diyform_plugin) {
			$diyform_set = $_W['shopset']['diyform'];

			if (!empty($diyform_set['order_diyform_open'])) {
				$orderdiyformid = intval($diyform_set['order_diyform']);

				if (!empty($orderdiyformid)) {
					$order_formInfo = $diyform_plugin->getDiyformInfo($orderdiyformid);
					$fields = $order_formInfo['fields'];
					$f_data = $diyform_plugin->getLastOrderData($orderdiyformid, $member);
				}
			}
		}

		return array('diyform_plugin' => $diyform_plugin, 'order_formInfo' => $order_formInfo, 'diyform_set' => $diyform_set, 'orderdiyformid' => $orderdiyformid, 'fields' => $fields, 'f_data' => $f_data);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$cycelbuy_plugin = p('cycelbuy');

		if (!$cycelbuy_plugin) {
			show_message('未找到周期购应用，请联系系统管理员！');
			exit();
		}

		$open_redis = function_exists('redis') && !is_error(redis());
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$goodsid = intval($_GPC['id']);
		$sysset = m('common')->getSysset('trade');
		$predicttime = strtotime($_GPC['predicttime']);
		$showpredicttime = date('Y.m.d', $predicttime);
		$allow_sale = true;
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);
		$merch_array = array();
		$merchs = array();
		$merch_id = 0;
		$total_array = array();
		$member = m('member')->getMember($openid, true);
		$member['carrier_mobile'] = empty($member['carrier_mobile']) ? $member['mobile'] : $member['carrier_mobile'];
		$level = m('member')->getLevel($openid);
		$diyformdata = $this->diyformData($member);
		extract($diyformdata);
		$id = intval($_GPC['id']);
		$optionid = intval($_GPC['optionid']);
		$total = intval($_GPC['total']);

		if ($total < 1) {
			$total = 1;
		}

		$buytotal = $total;
		$errcode = 0;
		$hasinvoice = false;
		$invoicename = '';
		$buyagain_sale = true;
		$buyagainprice = 0;
		$goods = array();
		$sql = 'SELECT id as goodsid,type,title,weight,issendfree,isnodiscount,ispresell,presellprice,' . ' thumb,marketprice,storeids,isverify,deduct,hasoption,preselltimeend,presellsendstatrttime,presellsendtime,presellsendtype,' . ' manydeduct,`virtual`,maxbuy,usermaxbuy,discounts,total as stock,deduct2,showlevels,' . ' ednum,edmoney,edareas,edareas_code,unite_total,' . ' diyformtype,diyformid,diymode,dispatchtype,dispatchid,dispatchprice,cates,minbuy, ' . ' isdiscount,isdiscount_time,isdiscount_discounts,isfullback, ' . ' virtualsend,invoice,needfollow,followtip,followurl,merchid,checked,merchsale, ' . ' buyagain,buyagain_islong,buyagain_condition, buyagain_sale' . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
		$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $id));
		if (empty($data) || !empty($data['showlevels']) && !strexists($data['showlevels'], $member['level'])) {
			$err = true;
			include $this->template('newstore/goods/detail');
			exit();
		}

		$follow = m('user')->followed($openid);
		if (!empty($data['needfollow']) && !$follow && is_weixin()) {
			$followtip = empty($goods['followtip']) ? '如果您想要购买此商品，需要您关注我们的公众号，点击【确定】关注后再来购买吧~' : $goods['followtip'];
			$followurl = empty($goods['followurl']) ? $_W['shopset']['share']['followurl'] : $goods['followurl'];
			$this->message($followtip, $followurl, 'error');
		}

		if (0 < $data['minbuy'] && $total < $data['minbuy']) {
			$total = $data['minbuy'];
		}

		$data['total'] = $total;
		$data['optionid'] = $optionid;

		if (!empty($optionid)) {
			$option = pdo_fetch('select id,title,marketprice,presellprice,goodssn,productsn,`virtual`,stock,weight,specs,
                `day`,allfullbackprice,fullbackprice,allfullbackratio,fullbackratio,isfullback,cycelbuy_periodic
                from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $id, ':id' => $optionid));

			if (!empty($option)) {
				$data['optionid'] = $optionid;
				$data['optiontitle'] = $option['title'];
				$data['virtual'] = $option['virtual'];

				if ($option['isfullback']) {
					$fullbackgoods['minallfullbackallprice'] = $option['allfullbackprice'];
					$fullbackgoods['fullbackprice'] = $option['fullbackprice'];
					$fullbackgoods['minallfullbackallratio'] = $option['allfullbackratio'];
					$fullbackgoods['fullbackratio'] = $option['fullbackratio'];
					$fullbackgoods['day'] = $option['day'];
				}

				if (empty($data['unite_total'])) {
					$data['stock'] = $option['stock'];
				}

				if (!empty($option['weight'])) {
					$data['weight'] = $option['weight'];
				}

				if (!empty($option['specs'])) {
					$thumb = m('goods')->getSpecThumb($option['specs']);

					if (!empty($thumb)) {
						$data['thumb'] = $thumb;
					}
				}

				$cycelbuy_periodic = explode(',', $option['cycelbuy_periodic']);
				$cycelbuy_day = $cycelbuy_periodic[0];
				$cycelbuy_unit = $cycelbuy_periodic[1];
				$cycelbuy_num = $cycelbuy_periodic[2];
			}
			else {
				if (!empty($data['hasoption'])) {
					$this->message('商品' . $data['title'] . '的规格不存在,请重新选择规格!', '', 'error');
				}
			}
		}

		$goods[] = $data;
		$goods = set_medias($goods, 'thumb');

		foreach ($goods as &$g) {
			if ($g['invoice']) {
				$hasinvoice = $g['invoice'];
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

				if (0 < $g['usermaxbuy']) {
					$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=0 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $g['goodsid'], ':uniacid' => $uniacid, ':openid' => $openid));
					$last = $data['usermaxbuy'] - $order_goodscount;

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

				$g['totalmaxbuy'] = $totalmaxbuy;
				if ($g['totalmaxbuy'] < $g['total'] && !empty($g['totalmaxbuy'])) {
					$g['total'] = $g['totalmaxbuy'];
				}

				if (0 < floatval($g['buyagain']) && empty($g['buyagain_sale'])) {
					if (m('goods')->canBuyAgain($g)) {
						$buyagain_sale = false;
					}
				}
			}

			if (!empty($option)) {
				$g['marketprice'] = $option['marketprice'];
			}
		}

		unset($g);
		$invoice_arr = '{}';

		if ($hasinvoice) {
			$invoicename = pdo_fetchcolumn('select invoicename from ' . tablename('ewei_shop_order') . ' where openid=:openid and uniacid=:uniacid and ifnull(invoicename,\'\')<>\'\' order by id desc limit 1', array(':openid' => $openid, ':uniacid' => $uniacid));
			$invoice_arr = m('sale')->parseInvoiceInfo($invoicename);

			if ($invoice_arr['title'] === false) {
				$invoicename = '';
			}

			$invoice_arr = json_encode($invoice_arr);
			$invoice_type = m('common')->getSysset('trade');
			$invoice_type = (int) $invoice_type['invoice_entity'];

			if ($invoice_type === 0) {
				$invoicename = str_replace('电子', '纸质', $invoicename);
			}
			else {
				if ($invoice_type === 1) {
					$invoicename = str_replace('纸质', '电子', $invoicename);
				}
			}
		}

		$weight = 0;
		$total = 0;
		$goodsprice = 0;
		$realprice = 0;
		$deductprice = 0;
		$discountprice = 0;
		$isdiscountprice = 0;
		$deductprice2 = 0;
		$stores = array();
		$address = false;
		$carrier = false;
		$carrier_list = array();
		$dispatch_list = false;
		$dispatch_price = 0;
		$ismerch = 0;
		$carrier_list = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(1,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid']));
		$sale_plugin = com('sale');
		$saleset = false;
		if ($sale_plugin && $buyagain_sale && $allow_sale) {
			$saleset = $_W['shopset']['sale'];
			$saleset['enoughs'] = $sale_plugin->getEnoughs();
		}

		foreach ($goods as &$g) {
			if (empty($g['total']) || intval($g['total']) < 1) {
				$g['total'] = 1;
			}

			$gprice = $g['marketprice'] * $g['total'];
			$prices = m('order')->getGoodsDiscountPrice($g, $level);
			$g['ggprice'] = $prices['price'];
			$g['unitprice'] = $prices['unitprice'];
			$g['dflag'] = intval($g['ggprice'] < $gprice);
			$g['lotterydiscountprice'] = $prices['lotterydiscountprice'];
			$g['discountprice'] = $prices['discountprice'];
			$g['isdiscountprice'] = $prices['isdiscountprice'];
			$g['discounttype'] = $prices['discounttype'];
			$g['isdiscountunitprice'] = $prices['isdiscountunitprice'];
			$g['discountunitprice'] = $prices['discountunitprice'];
			$buyagainprice += $prices['buyagainprice'];

			if ($prices['discounttype'] == 1) {
				$isdiscountprice += $prices['isdiscountprice'];
			}
			else {
				if ($prices['discounttype'] == 2) {
					$discountprice += $prices['discountprice'];
				}
			}

			$realprice += $g['ggprice'];

			if ($g['ggprice'] < $gprice) {
				$goodsprice += $gprice;
			}
			else {
				$goodsprice += $g['ggprice'];
			}

			$total += $g['total'];
			if (0 < floatval($g['buyagain']) && empty($g['buyagain_sale'])) {
				if (m('goods')->canBuyAgain($g)) {
					$g['deduct'] = 0;
				}
			}

			if ($open_redis) {
				if ($g['manydeduct']) {
					$deductprice += $g['deduct'] * $g['total'];
				}
				else {
					$deductprice += $g['deduct'];
				}

				if ($g['deduct2'] == 0) {
					$deductprice2 += $g['ggprice'];
				}
				else {
					if (0 < $g['deduct2']) {
						if ($g['ggprice'] < $g['deduct2']) {
							$deductprice2 += $g['ggprice'];
						}
						else {
							$deductprice2 += $g['deduct2'];
						}
					}
				}
			}

			if (!empty($option)) {
				$g['marketprice'] = $option['marketprice'];
			}
		}

		unset($g);
		$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where openid=:openid and deleted=0 and isdefault=1  and uniacid=:uniacid limit 1', array(':uniacid' => $uniacid, ':openid' => $openid));

		if (!empty($carrier_list)) {
			$carrier = $carrier_list[0];
		}

		if ($saleset) {
			foreach ($saleset['enoughs'] as $e) {
				if (floatval($e['enough']) <= $realprice && 0 < floatval($e['money'])) {
					$saleset['showenough'] = true;
					$saleset['enoughmoney'] = $e['enough'];
					$saleset['enoughdeduct'] = $e['money'];
					$realprice -= floatval($e['money']);
					break;
				}
			}

			if (empty($saleset['dispatchnodeduct'])) {
				$deductprice2 += $dispatch_price;
			}
		}

		$realprice += $dispatch_price;
		$deductcredit = 0;
		$deductmoney = 0;
		$deductcredit2 = 0;

		if (!empty($saleset)) {
			if (!empty($saleset['creditdeduct'])) {
				$credit = $member['credit1'];

				if (0 < $credit) {
					$credit = floor($credit);
				}

				$pcredit = intval($saleset['credit']);
				$pmoney = round(floatval($saleset['money']), 2);
				if (0 < $pcredit && 0 < $pmoney) {
					if ($credit % $pcredit == 0) {
						$deductmoney = round(intval($credit / $pcredit) * $pmoney, 2);
					}
					else {
						$deductmoney = round((intval($credit / $pcredit) + 1) * $pmoney, 2);
					}
				}

				if ($deductprice < $deductmoney) {
					$deductmoney = $deductprice;
				}

				if ($realprice < $deductmoney) {
					$deductmoney = $realprice;
				}

				if ($pmoney * $pcredit != 0) {
					$deductcredit = floor($deductmoney / $pmoney * $pcredit);
				}
			}

			if (!empty($saleset['moneydeduct'])) {
				$deductcredit2 = m('member')->getCredit($openid, 'credit2');

				if ($realprice < $deductcredit2) {
					$deductcredit2 = $realprice;
				}

				if ($deductprice2 < $deductcredit2) {
					$deductcredit2 = $deductprice2;
				}
			}
		}

		$goodsdata = array();
		$goodsdata_temp = array();

		foreach ($goods as $g) {
			$goodsdata[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice'], 'type' => $g['type'], 'intervalfloor' => $g['intervalfloor'], 'intervalprice1' => $g['intervalprice1'], 'intervalnum1' => $g['intervalnum1'], 'intervalprice2' => $g['intervalprice2'], 'intervalnum2' => $g['intervalnum2'], 'intervalprice3' => $g['intervalprice3'], 'intervalnum3' => $g['intervalnum3']);

			if (0 < floatval($g['buyagain'])) {
				if (!m('goods')->canBuyAgain($g) || !empty($g['buyagain_sale'])) {
					$goodsdata_temp[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice'], 'type' => $g['type'], 'intervalfloor' => $g['intervalfloor'], 'intervalprice1' => $g['intervalprice1'], 'intervalnum1' => $g['intervalnum1'], 'intervalprice2' => $g['intervalprice2'], 'intervalnum2' => $g['intervalnum2'], 'intervalprice3' => $g['intervalprice3'], 'intervalnum3' => $g['intervalnum3']);
				}
			}
			else {
				$goodsdata_temp[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice'], 'type' => $g['type'], 'intervalfloor' => $g['intervalfloor'], 'intervalprice1' => $g['intervalprice1'], 'intervalnum1' => $g['intervalnum1'], 'intervalprice2' => $g['intervalprice2'], 'intervalnum2' => $g['intervalnum2'], 'intervalprice3' => $g['intervalprice3'], 'intervalnum3' => $g['intervalnum3']);
			}
		}

		$couponcount = com_run('coupon::consumeCouponCount', $openid, $realprice, $merch_array, $goodsdata_temp);
		$couponcount += com_run('wxcard::consumeWxCardCount', $openid, $merch_array, $goodsdata_temp);
		if (empty($goodsdata_temp) || !$allow_sale) {
			$couponcount = 0;
		}

		$mustbind = 0;
		if (!empty($_W['shopset']['wap']['open']) && !empty($_W['shopset']['wap']['mustbind']) && empty($member['mobileverify'])) {
			$mustbind = 1;
		}

		$goods_list = array();
		$goods_list[0]['shopname'] = $_W['shopset']['shop']['name'];
		$goods_list[0]['goods'] = $goods;
		$createInfo = array('id' => $id, 'gdid' => intval($_GPC['gdid']), 'fromcart' => $fromcart, 'addressid' => !empty($address) && !$isvirtual ? $address['id'] : 0, 'couponcount' => $couponcount, 'coupon_goods' => $goodsdata_temp, 'isvirtual' => $isvirtual, 'isverify' => $isverify, 'goods' => $goodsdata, 'merchs' => $merchs, 'orderdiyformid' => $orderdiyformid, 'mustbind' => $mustbind, 'new_area' => $new_area, 'address_street' => $address_street, 'city_express_state' => empty($dispatch_array['city_express_state']) ? 0 : $dispatch_array['city_express_state']);
		$buyagain = $buyagainprice;
		$_W['shopshare']['hideMenus'] = array('menuItem:share:qq', 'menuItem:share:QZone', 'menuItem:share:email', 'menuItem:copyUrl', 'menuItem:openWithSafari', 'menuItem:openWithQQBrowser', 'menuItem:share:timeline', 'menuItem:share:appMessage');
		include $this->template();
	}

	public function getcouponprice()
	{
		global $_GPC;
		$couponid = intval($_GPC['couponid']);
		$goodsarr = $_GPC['goods'];
		$goodsprice = $_GPC['goodsprice'];
		$discountprice = $_GPC['discountprice'];
		$isdiscountprice = $_GPC['isdiscountprice'];
		$contype = intval($_GPC['contype']);
		$wxid = intval($_GPC['wxid']);
		$wxcardid = $_GPC['wxcardid'];
		$wxcode = $_GPC['wxcode'];
		$result = $this->caculatecoupon($contype, $couponid, $wxid, $wxcardid, $wxcode, $goodsarr, $goodsprice, $discountprice, $isdiscountprice);

		if (empty($result)) {
			show_json(0);
		}
		else {
			show_json(1, $result);
		}
	}

	public function caculatecoupon($contype, $couponid, $wxid, $wxcardid, $wxcode, $goodsarr, $totalprice, $discountprice, $isdiscountprice, $isSubmit = 0, $discountprice_array = array(), $merchisdiscountprice = 0)
	{
		global $_W;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];

		if (empty($goodsarr)) {
			return false;
		}

		if ($contype == 0) {
			return NULL;
		}

		if ($contype == 1) {
			$sql = 'select id,uniacid,card_type,logo_url,title, card_id,least_cost,reduce_cost,discount,merchid,limitgoodtype,limitgoodcatetype,limitgoodcateids,limitgoodids,merchid  from ' . tablename('ewei_shop_wxcard');
			$sql .= '  where uniacid=:uniacid  and id=:id and card_id=:card_id   limit 1';
			$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $wxid, ':card_id' => $wxcardid));
			$merchid = intval($data['merchid']);
		}
		else {
			if ($contype == 2) {
				$sql = 'SELECT d.id,d.couponid,c.enough,c.backtype,c.deduct,c.discount,c.backmoney,c.backcredit,c.backredpack,c.merchid,c.limitgoodtype,c.limitgoodcatetype,c.limitgoodids,c.limitgoodcateids,c.limitdiscounttype  FROM ' . tablename('ewei_shop_coupon_data') . ' d';
				$sql .= ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
				$sql .= ' where d.id=:id and d.uniacid=:uniacid and d.openid=:openid and d.used=0  limit 1';
				$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $couponid, ':openid' => $openid));
				$merchid = intval($data['merchid']);
			}
		}

		if (empty($data)) {
			return NULL;
		}

		if (is_array($goodsarr)) {
			$goods = array();

			foreach ($goodsarr as $g) {
				if (empty($g)) {
					continue;
				}

				if (0 < $merchid && $g['merchid'] != $merchid) {
					continue;
				}

				$cates = explode(',', $g['cates']);
				$limitcateids = explode(',', $data['limitgoodcateids']);
				$limitgoodids = explode(',', $data['limitgoodids']);
				$pass = 0;
				if ($data['limitgoodcatetype'] == 0 && $data['limitgoodtype'] == 0) {
					$pass = 1;
				}

				if ($data['limitgoodcatetype'] == 1) {
					$result = array_intersect($cates, $limitcateids);

					if (0 < count($result)) {
						$pass = 1;
					}
				}

				if ($data['limitgoodtype'] == 1) {
					$isin = in_array($g['goodsid'], $limitgoodids);

					if ($isin) {
						$pass = 1;
					}
				}

				if ($pass == 1) {
					$goods[] = $g;
				}
			}

			$limitdiscounttype = intval($data['limitdiscounttype']);
			$coupongoodprice = 0;
			$gprice = 0;

			foreach ($goods as $k => $g) {
				$gprice = (double) $g['marketprice'] * (double) $g['total'];

				switch ($limitdiscounttype) {
				case 1:
					$coupongoodprice += $gprice - (double) $g['discountunitprice'] * (double) $g['total'];
					$discountprice_array[$g['merchid']]['coupongoodprice'] += $gprice - (double) $g['discountunitprice'] * (double) $g['total'];

					if ($g['discounttype'] == 1) {
						$isdiscountprice -= (double) $g['isdiscountunitprice'] * (double) $g['total'];
						$discountprice += (double) $g['discountunitprice'] * (double) $g['total'];

						if ($isSubmit == 1) {
							$totalprice = $totalprice - $g['ggprice'] + $g['price2'];
							$discountprice_array[$g['merchid']]['ggprice'] = $discountprice_array[$g['merchid']]['ggprice'] - $g['ggprice'] + $g['price2'];
							$goodsarr[$k]['ggprice'] = $g['price2'];
							$discountprice_array[$g['merchid']]['isdiscountprice'] -= (double) $g['isdiscountunitprice'] * (double) $g['total'];
							$discountprice_array[$g['merchid']]['discountprice'] += (double) $g['discountunitprice'] * (double) $g['total'];

							if (!empty($data['merchsale'])) {
								$merchisdiscountprice -= (double) $g['isdiscountunitprice'] * (double) $g['total'];
								$discountprice_array[$g['merchid']]['merchisdiscountprice'] -= (double) $g['isdiscountunitprice'] * (double) $g['total'];
							}
						}
					}

					break;

				case 2:
					$coupongoodprice += $gprice - (double) $g['isdiscountunitprice'] * (double) $g['total'];
					$discountprice_array[$g['merchid']]['coupongoodprice'] += $gprice - (double) $g['isdiscountunitprice'] * (double) $g['total'];

					if ($g['discounttype'] == 2) {
						$discountprice -= (double) $g['discountunitprice'] * (double) $g['total'];

						if ($isSubmit == 1) {
							$totalprice = $totalprice - $g['ggprice'] + $g['price1'];
							$discountprice_array[$g['merchid']]['ggprice'] = $discountprice_array[$g['merchid']]['ggprice'] - $g['ggprice'] + $g['price1'];
							$goodsarr[$k]['ggprice'] = $g['price1'];
							$discountprice_array[$g['merchid']]['discountprice'] -= (double) $g['discountunitprice'] * (double) $g['total'];
						}
					}

					break;

				case 3:
					$coupongoodprice += $gprice;
					$discountprice_array[$g['merchid']]['coupongoodprice'] += $gprice;

					if ($g['discounttype'] == 1) {
						$isdiscountprice -= (double) $g['isdiscountunitprice'] * (double) $g['total'];

						if ($isSubmit == 1) {
							$totalprice = $totalprice - $g['ggprice'] + $g['price0'];
							$discountprice_array[$g['merchid']]['ggprice'] = $discountprice_array[$g['merchid']]['ggprice'] - $g['ggprice'] + $g['price0'];
							$goodsarr[$k]['ggprice'] = $g['price0'];

							if (!empty($data['merchsale'])) {
								$merchisdiscountprice -= $g['isdiscountunitprice'] * (double) $g['total'];
								$discountprice_array[$g['merchid']]['merchisdiscountprice'] -= $g['isdiscountunitprice'] * (double) $g['total'];
							}

							$discountprice_array[$g['merchid']]['isdiscountprice'] -= $g['isdiscountunitprice'] * (double) $g['total'];
						}
					}
					else {
						if ($g['discounttype'] == 2) {
							$discountprice -= (double) $g['discountunitprice'] * (double) $g['total'];

							if ($isSubmit == 1) {
								$totalprice = $totalprice - $g['ggprice'] + $g['price0'];
								$goodsarr[$k]['ggprice'] = $g['price0'];
								$discountprice_array[$g['merchid']]['ggprice'] = $discountprice_array[$g['merchid']]['ggprice'] - $g['ggprice'] + $g['price0'];
								$discountprice_array[$g['merchid']]['discountprice'] -= (double) $g['discountunitprice'] * (double) $g['total'];
							}
						}
					}

					break;

				default:
					if ($g['discounttype'] == 1) {
						$coupongoodprice += $gprice - (double) $g['isdiscountunitprice'] * (double) $g['total'];
						$discountprice_array[$g['merchid']]['coupongoodprice'] += $gprice - (double) $g['isdiscountunitprice'] * (double) $g['total'];
					}
					else if ($g['discounttype'] == 2) {
						$coupongoodprice += $gprice - (double) $g['discountunitprice'] * (double) $g['total'];
						$discountprice_array[$g['merchid']]['coupongoodprice'] += $gprice - (double) $g['discountunitprice'] * (double) $g['total'];
					}
					else {
						if ($g['discounttype'] == 0) {
							$coupongoodprice += $gprice;
							$discountprice_array[$g['merchid']]['coupongoodprice'] += $gprice;
						}
					}

					break;
				}
			}

			if ($contype == 1) {
				$deduct = (double) $data['reduce_cost'] / 100;
				$discount = (double) (100 - intval($data['discount'])) / 10;

				if ($data['card_type'] == 'CASH') {
					$backtype = 0;
				}
				else {
					if ($data['card_type'] == 'DISCOUNT') {
						$backtype = 1;
					}
				}
			}
			else {
				if ($contype == 2) {
					$deduct = (double) $data['deduct'];
					$discount = (double) $data['discount'];
					$backtype = (double) $data['backtype'];
				}
			}

			$deductprice = 0;
			$coupondeduct_text = '';
			if (0 < $deduct && $backtype == 0 && 0 < $coupongoodprice) {
				if ($coupongoodprice < $deduct) {
					$deduct = $coupongoodprice;
				}

				if ($deduct <= 0) {
					$deduct = 0;
				}

				$deductprice = $deduct;
				$coupondeduct_text = '优惠券优惠';

				foreach ($discountprice_array as $key => $value) {
					$discountprice_array[$key]['deduct'] = (double) $value['coupongoodprice'] / (double) $coupongoodprice * $deduct;
				}
			}
			else {
				if (0 < $discount && $backtype == 1) {
					$deductprice = $coupongoodprice * (1 - $discount / 10);

					if ($coupongoodprice < $deductprice) {
						$deductprice = $coupongoodprice;
					}

					if ($deductprice <= 0) {
						$deductprice = 0;
					}

					foreach ($discountprice_array as $key => $value) {
						$discountprice_array[$key]['deduct'] = (double) $value['coupongoodprice'] * (1 - $discount / 10);
					}

					if (0 < $merchid) {
						$coupondeduct_text = '店铺优惠券折扣(' . $discount . '折)';
					}
					else {
						$coupondeduct_text = '优惠券折扣(' . $discount . '折)';
					}
				}
			}
		}

		$totalprice -= $deductprice;
		$return_array = array();
		$return_array['isdiscountprice'] = $isdiscountprice;
		$return_array['discountprice'] = $discountprice;
		$return_array['deductprice'] = $deductprice;
		$return_array['coupongoodprice'] = $coupongoodprice;
		$return_array['coupondeduct_text'] = $coupondeduct_text;
		$return_array['totalprice'] = $totalprice;
		$return_array['discountprice_array'] = $discountprice_array;
		$return_array['merchisdiscountprice'] = $merchisdiscountprice;
		$return_array['couponmerchid'] = $merchid;
		$return_array['goodsarr'] = $goodsarr;
		return $return_array;
	}

	public function caculate()
	{
		global $_W;
		global $_GPC;
		$open_redis = function_exists('redis') && !is_error(redis());
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$allow_sale = true;
		$realprice = 0;
		$nowsendfree = false;
		$discountprice = 0;
		$isdiscountprice = 0;
		$deductprice = 0;
		$deductprice2 = 0;
		$deductcredit2 = 0;
		$buyagain_sale = true;
		$buyagainprice = 0;
		$dispatchid = intval($_GPC['dispatchid']);
		$totalprice = floatval($_GPC['totalprice']);
		$dflag = intval($_GPC['dflag']);
		$addressid = intval($_GPC['addressid']);
		$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where  id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $uniacid, ':openid' => $openid, ':id' => $addressid));
		$member = m('member')->getMember($openid, true);
		$level = m('member')->getLevel($openid);
		$weight = floatval($_GPC['weight']);
		$dispatch_price = 0;
		$deductenough_money = 0;
		$deductenough_enough = 0;
		$goodsarr = $_GPC['goods'];

		if (is_array($goodsarr)) {
			$weight = 0;
			$allgoods = array();

			foreach ($goodsarr as &$g) {
				if (empty($g)) {
					continue;
				}

				$goodsid = $g['goodsid'];
				$optionid = $g['optionid'];
				$goodstotal = $g['total'];

				if ($goodstotal < 1) {
					$goodstotal = 1;
				}

				if (empty($goodsid)) {
					$nowsendfree = false;
				}

				$sql = 'SELECT id as goodsid,title,type, weight,total,issendfree,isnodiscount, thumb,marketprice,cash,isverify,goodssn,productsn,sales,istime,' . ' timestart,timeend,usermaxbuy,maxbuy,unit,buylevels,buygroups,deleted,status,deduct,ispresell,preselltimeend,manydeduct,`virtual`,' . ' discounts,deduct2,ednum,edmoney,edareas,edareas_code,diyformid,diyformtype,diymode,dispatchtype,dispatchid,dispatchprice,presellprice,' . ' isdiscount,isdiscount_time,isdiscount_discounts ,virtualsend,merchid,merchsale,' . ' buyagain,buyagain_islong,buyagain_condition, buyagain_sale,bargain,unite_total' . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
				$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $goodsid));

				if (empty($data)) {
					$nowsendfree = false;
				}

				$data['stock'] = $data['total'];
				$data['total'] = $goodstotal;

				if (!empty($optionid)) {
					$option = pdo_fetch('select id,title,marketprice,presellprice,goodssn,productsn,stock,`virtual`,weight,cycelbuy_periodic from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $goodsid, ':id' => $optionid));

					if (!empty($option)) {
						$data['optionid'] = $optionid;
						$data['optiontitle'] = $option['title'];
						$data['marketprice'] = 0 < intval($data['ispresell']) && (time() < $data['preselltimeend'] || $data['preselltimeend'] == 0) ? $option['presellprice'] : $option['marketprice'];

						if (empty($data['unite_total'])) {
							$data['stock'] = $option['stock'];
						}

						if (!empty($option['weight'])) {
							$data['weight'] = $option['weight'];
						}

						$cycelbuy_periodic = explode(',', $option['cycelbuy_periodic']);
						$cycelbuy_day = $cycelbuy_periodic[0];
						$cycelbuy_num = $cycelbuy_periodic[2];
					}
				}

				$data['isdiscount'] = 0;
				$data['isnodiscount'] = 1;
				$prices = m('order')->getGoodsDiscountPrice($data, $level);
				$data['ggprice'] = $prices['price'];
				if (!empty($data['virtual']) || $data['type'] == 2 || $data['type'] == 3 || $data['type'] == 20) {
					$isvirtual = true;
				}

				$g['lotterydiscountprice'] = $prices['lotterydiscountprice'];
				$g['discountprice'] = $prices['discountprice'];
				$g['isdiscountprice'] = $prices['isdiscountprice'];
				$g['discounttype'] = $prices['discounttype'];
				$buyagainprice += $prices['buyagainprice'];

				if ($prices['discounttype'] == 1) {
					$isdiscountprice += $prices['isdiscountprice'];
				}
				else {
					if ($prices['discounttype'] == 2) {
						$discountprice += $prices['discountprice'];
					}
				}

				$realprice += $data['ggprice'];
				$allgoods[] = $data;
				if (0 < floatval($g['buyagain']) && empty($g['buyagain_sale'])) {
					if (m('goods')->canBuyAgain($g)) {
						$buyagain_sale = false;
					}
				}
			}

			unset($g);
			$sale_plugin = com('sale');
			$saleset = false;
			if ($sale_plugin && $buyagain_sale && $allow_sale) {
				$saleset = $_W['shopset']['sale'];
				$saleset['enoughs'] = $sale_plugin->getEnoughs();
			}

			foreach ($allgoods as $g) {
				if (0 < floatval($g['buyagain']) && empty($g['buyagain_sale'])) {
					if (m('goods')->canBuyAgain($g)) {
						$g['deduct'] = 0;
					}
				}

				if ($open_redis) {
					if ($g['manydeduct']) {
						$deductprice += $g['deduct'] * $g['total'];
					}
					else {
						$deductprice += $g['deduct'];
					}

					if ($g['deduct2'] == 0) {
						$deductprice2 += $g['ggprice'];
					}
					else {
						if (0 < $g['deduct2']) {
							if ($g['ggprice'] < $g['deduct2']) {
								$deductprice2 += $g['ggprice'];
							}
							else {
								$deductprice2 += $g['deduct2'];
							}
						}
					}
				}
			}

			if (!empty($allgoods) && !$nowsendfree) {
				$dispatch_array = m('order')->getOrderDispatchPrice($allgoods, $member, $address, $saleset, $merch_array, 0);
				$dispatch_price = $dispatch_array['dispatch_price'];
				$nodispatch_array = $dispatch_array['nodispatch_array'];
			}

			if ($saleset) {
				foreach ($saleset['enoughs'] as $e) {
					if (floatval($e['enough']) <= $realprice && 0 < floatval($e['money'])) {
						$deductenough_money = floatval($e['money']);
						$deductenough_enough = floatval($e['enough']);
						$realprice -= floatval($e['money']);
						break;
					}
				}
			}

			if (empty($dflag)) {
				if (empty($saleset['dispatchnodeduct'])) {
					$deductprice2 += $dispatch_price;
				}
			}

			$goodsdata_coupon = array();

			foreach ($allgoods as $g) {
				if (0 < floatval($g['buyagain'])) {
					if (!m('goods')->canBuyAgain($g) || !empty($g['buyagain_sale'])) {
						$goodsdata_coupon[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice'], 'type' => $g['type']);
					}
				}
				else {
					$goodsdata_coupon[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice'], 'type' => $g['type']);
				}
			}

			$couponcount = com_run('coupon::consumeCouponCount', $openid, $realprice, $merch_array, $goodsdata_coupon);
			$couponcount += com_run('wxcard::consumeWxCardCount', $openid, $merch_array, $goodsdata_coupon);
			if (empty($goodsdata_coupon) || !$allow_sale) {
				$couponcount = 0;
			}

			$realprice += $dispatch_price;
			$deductcredit = 0;
			$deductmoney = 0;

			if (!empty($saleset)) {
				$credit = $member['credit1'];

				if (0 < $credit) {
					$credit = floor($credit);
				}

				if (!empty($saleset['creditdeduct'])) {
					$pcredit = intval($saleset['credit']);
					$pmoney = round(floatval($saleset['money']), 2);
					if (0 < $pcredit && 0 < $pmoney) {
						if ($credit % $pcredit == 0) {
							$deductmoney = round(intval($credit / $pcredit) * $pmoney, 2);
						}
						else {
							$deductmoney = round((intval($credit / $pcredit) + 1) * $pmoney, 2);
						}
					}

					if ($deductprice < $deductmoney) {
						$deductmoney = $deductprice;
					}

					if ($realprice < $deductmoney) {
						$deductmoney = $realprice;
					}

					$deductcredit = floor($pmoney * $pcredit == 0 ? 0 : $deductmoney / $pmoney * $pcredit);
				}

				if (!empty($saleset['moneydeduct'])) {
					$deductcredit2 = $member['credit2'];

					if ($realprice < $deductcredit2) {
						$deductcredit2 = $realprice;
					}

					if ($deductprice2 < $deductcredit2) {
						$deductcredit2 = $deductprice2;
					}
				}
			}
		}

		$return_array = array();
		$return_array['price'] = $dispatch_price * $cycelbuy_num;
		$return_array['couponcount'] = $couponcount;
		$return_array['realprice'] = $realprice;
		$return_array['deductenough_money'] = $deductenough_money;
		$return_array['deductenough_enough'] = $deductenough_enough;
		$return_array['deductcredit2'] = $deductcredit2;
		$return_array['deductcredit'] = $deductcredit;
		$return_array['deductmoney'] = $deductmoney;
		$return_array['discountprice'] = $discountprice;
		$return_array['isdiscountprice'] = $isdiscountprice;
		$return_array['cycelbuy_num'] = $cycelbuy_num;
		$return_array['buyagain'] = $buyagainprice;
		$return_array['city_express_state'] = empty($dispatch_array['city_express_state']) == true ? 0 : $dispatch_array['city_express_state'];

		if (!empty($nodispatch_array['isnodispatch'])) {
			$return_array['isnodispatch'] = 1;
			$return_array['nodispatch'] = $nodispatch_array['nodispatch'];
		}
		else {
			$return_array['isnodispatch'] = 0;
			$return_array['nodispatch'] = '';
		}

		show_json(1, $return_array);
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = $_W['uniacid'] . '_order_submit_' . $openid;
			$redis = redis();

			if (!is_error($redis)) {
				if ($redis->setnx($redis_key, time())) {
					$redis->expireAt($redis_key, time() + 2);
				}
				else {
					show_json(0, '不要短时间重复下单!');
				}
			}
		}

		$member = m('member')->getMember($openid);

		if ($member['isblack'] == 1) {
			show_json(0);
		}

		if (!empty($_W['shopset']['wap']['open']) && !empty($_W['shopset']['wap']['mustbind']) && empty($member['mobileverify'])) {
			show_json(0, array('message' => '请先绑定手机', 'url' => mobileUrl('member/bind', NULL, true)));
		}

		$allow_sale = true;
		$data = $this->diyformData($member);
		extract($data);
		$ismerch = 0;
		$discountprice_array = array();
		$level = m('member')->getLevel($openid);
		$dispatchid = intval($_GPC['dispatchid']);
		$dispatchtype = intval($_GPC['dispatchtype']);
		$addressid = intval($_GPC['addressid']);
		$address = false;
		if (!empty($addressid) && $dispatchtype == 0) {
			$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where id=:id and openid=:openid and uniacid=:uniacid   limit 1', array(':uniacid' => $uniacid, ':openid' => $openid, ':id' => $addressid));

			if (empty($address)) {
				show_json(0, '未找到地址');
			}
			else {
				if (empty($address['province']) || empty($address['city'])) {
					show_json(0, '地址请选择省市信息');
				}
			}
		}

		$carrierid = intval($_GPC['carrierid']);
		$goods = $_GPC['goods'];
		if (empty($goods) || !is_array($goods)) {
			show_json(0, '未找到任何商品');
		}

		$allgoods = array();
		$totalprice = 0;
		$goodsprice = 0;
		$grprice = 0;
		$weight = 0;
		$discountprice = 0;
		$isdiscountprice = 0;
		$merchisdiscountprice = 0;
		$cash = 1;
		$deductprice = 0;
		$deductprice2 = 0;
		$virtualsales = 0;
		$dispatch_price = 0;
		$buyagain_sale = true;
		$buyagainprice = 0;
		$sale_plugin = com('sale');
		$saleset = false;
		if ($sale_plugin && $allow_sale) {
			$saleset = $_W['shopset']['sale'];
			$saleset['enoughs'] = $sale_plugin->getEnoughs();
		}

		$isendtime = 0;
		$endtime = 0;
		$couponmerchid = 0;
		$total_array = array();

		foreach ($goods as $g) {
			if (empty($g)) {
				continue;
			}

			$goodsid = intval($g['goodsid']);
			$goodstotal = intval($g['total']);
			$total_array[$goodsid]['total'] += $goodstotal;
		}

		foreach ($goods as $g) {
			if (empty($g)) {
				continue;
			}

			$goodsid = intval($g['goodsid']);
			$optionid = intval($g['optionid']);
			$goodstotal = intval($g['total']);

			if ($goodstotal < 1) {
				$goodstotal = 1;
			}

			if (empty($goodsid)) {
				show_json(0, '参数错误');
			}

			$sql_condition = '';
			$sql = 'SELECT id as goodsid,' . $sql_condition . 'title,type,intervalfloor,intervalprice, weight,total,issendfree,isnodiscount, thumb,marketprice,cash,isverify,verifytype,' . ' goodssn,productsn,sales,istime,timestart,timeend,hasoption,isendtime,usetime,endtime,ispresell,presellprice,preselltimeend,' . ' usermaxbuy,minbuy,maxbuy,unit,buylevels,buygroups,deleted,unite_total,' . ' status,deduct,manydeduct,`virtual`,discounts,deduct2,ednum,edmoney,edareas,edareas_code,diyformtype,diyformid,diymode,' . ' dispatchtype,dispatchid,dispatchprice,merchid,merchsale,cates,' . ' isdiscount,isdiscount_time,isdiscount_discounts, virtualsend,' . ' buyagain,buyagain_islong,buyagain_condition, buyagain_sale ' . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
			$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $goodsid));

			if ($data['status'] == 2) {
				$data['marketprice'] = 0;
			}

			if (!empty($data['hasoption'])) {
				$opdata = m('goods')->getOption($data['goodsid'], $optionid);
				if (empty($opdata) || empty($optionid)) {
					show_json(0, '商品' . $data['title'] . '的规格不存在,请到购物车删除该商品重新选择规格!');
				}
			}

			$data['stock'] = $data['total'];
			$data['total'] = $goodstotal;

			if ($data['cash'] != 2) {
				$cash = 0;
			}

			$unit = empty($data['unit']) ? '件' : $data['unit'];

			if ($data['type'] != 4) {
				if (0 < $data['minbuy']) {
					if ($goodstotal < $data['minbuy']) {
						show_json(0, $data['title'] . '<br/> ' . $data['minbuy'] . $unit . '起售!');
					}
				}

				if (0 < $data['maxbuy']) {
					if ($data['maxbuy'] < $goodstotal) {
						show_json(0, $data['title'] . '<br/> 一次限购 ' . $data['maxbuy'] . $unit . '!');
					}
				}
			}

			if (0 < $data['usermaxbuy']) {
				$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=0 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $data['goodsid'], ':uniacid' => $uniacid, ':openid' => $openid));

				if ($data['usermaxbuy'] <= $order_goodscount) {
					show_json(0, $data['title'] . '<br/> 最多限购 ' . $data['usermaxbuy'] . $unit . '!');
				}
			}

			$levelid = intval($member['level']);
			$groupid = intval($member['groupid']);

			if ($data['buylevels'] != '') {
				$buylevels = explode(',', $data['buylevels']);

				if (!in_array($levelid, $buylevels)) {
					show_json(0, '您的会员等级无法购买<br/>' . $data['title'] . '!');
				}
			}

			if ($data['buygroups'] != '') {
				$buygroups = explode(',', $data['buygroups']);

				if (!in_array($groupid, $buygroups)) {
					show_json(0, '您所在会员组无法购买<br/>' . $data['title'] . '!');
				}
			}

			$sql_condition = '';

			if (!empty($optionid)) {
				$option = pdo_fetch('select id,title,marketprice,presellprice,goodssn,productsn,stock,`virtual`,weight,cycelbuy_periodic' . $sql_condition . ' from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $goodsid, ':id' => $optionid));

				if (!empty($option)) {
					if (empty($data['unite_total'])) {
						$stock_num = $option['stock'];
					}
					else {
						$stock_num = $data['stock'];
					}

					if ($stock_num != -1) {
						if (empty($stock_num)) {
							show_json(-1, $data['title'] . '<br/>' . $option['title'] . ' 库存不足!stock=' . $stock_num);
						}

						if (!empty($data['unite_total'])) {
							if ($stock_num - intval($total_array[$goodsid]['total']) < 0) {
								show_json(-1, $data['title'] . '<br/>总库存不足!当前总库存为' . $stock_num);
							}
						}
					}

					$data['optionid'] = $optionid;
					$data['optiontitle'] = $option['title'];

					if ($data['type'] != 4) {
						$data['marketprice'] = 0 < intval($data['ispresell']) && (time() < $data['preselltimeend'] || $data['preselltimeend'] == 0) ? $option['presellprice'] : $option['marketprice'];
					}

					if (!empty($option['goodssn'])) {
						$data['goodssn'] = $option['goodssn'];
					}

					if (!empty($option['productsn'])) {
						$data['productsn'] = $option['productsn'];
					}

					if (!empty($option['weight'])) {
						$data['weight'] = $option['weight'];
					}
				}

				$cycelbuy_periodic = $option['cycelbuy_periodic'];
				$cycelbuy_periodics = explode(',', $option['cycelbuy_periodic']);
				$cycelbuy_day = $cycelbuy_periodics[0];
				$cycelbuy_num = $cycelbuy_periodics[2];
			}

			$data['diyformdataid'] = 0;
			$data['diyformdata'] = iserializer(array());
			$data['diyformfields'] = iserializer(array());

			if (intval($_GPC['fromcart']) == 1) {
				if ($diyform_plugin) {
					$cartdata = pdo_fetch('select id,diyformdataid,diyformfields,diyformdata from ' . tablename('ewei_shop_member_cart') . ' ' . ' where goodsid=:goodsid and optionid=:optionid and openid=:openid and deleted=0 order by id desc limit 1', array(':goodsid' => $data['goodsid'], ':optionid' => intval($data['optionid']), ':openid' => $openid));

					if (!empty($cartdata)) {
						$data['diyformdataid'] = $cartdata['diyformdataid'];
						$data['diyformdata'] = $cartdata['diyformdata'];
						$data['diyformfields'] = $cartdata['diyformfields'];
					}
				}
			}
			else {
				if (!empty($data['diyformtype']) && $diyform_plugin) {
					$temp_data = $diyform_plugin->getOneDiyformTemp($_GPC['gdid'], 0);
					$data['diyformfields'] = $temp_data['diyformfields'];
					$data['diyformdata'] = $temp_data['diyformdata'];

					if ($data['diyformtype'] == 2) {
						$data['diyformid'] = 0;
					}
					else {
						$data['diyformid'] = $data['diyformid'];
					}
				}
			}

			$gprice = $data['marketprice'] * $goodstotal;
			$goodsprice += $gprice;
			$data['isdiscount'] = 0;
			$data['isnodiscount'] = 1;
			$prices = m('order')->getGoodsDiscountPrice($data, $level);
			$data['ggprice'] = $prices['price'];
			$data['lotterydiscountprice'] = $prices['lotterydiscountprice'];
			$data['discountprice'] = $prices['discountprice'];
			$data['discountprice'] = $prices['discountprice'];
			$data['discounttype'] = $prices['discounttype'];
			$data['isdiscountunitprice'] = $prices['isdiscountunitprice'];
			$data['discountunitprice'] = $prices['discountunitprice'];
			$data['price0'] = $prices['price0'];
			$data['price1'] = $prices['price1'];
			$data['price2'] = $prices['price2'];
			$data['buyagainprice'] = $prices['buyagainprice'];
			$buyagainprice += $prices['buyagainprice'];

			if ($prices['discounttype'] == 1) {
				$isdiscountprice += $prices['isdiscountprice'];
				$discountprice += $prices['discountprice'];
			}
			else {
				if ($prices['discounttype'] == 2) {
					$discountprice += $prices['discountprice'];
				}
			}

			$totalprice += $data['ggprice'];
			if (!empty($data['virtual']) || $data['type'] == 2 || $data['type'] == 3 || $data['type'] == 20) {
				$isvirtual = true;

				if ($data['virtualsend']) {
					$isvirtualsend = true;
				}
			}

			if (0 < floatval($data['buyagain']) && empty($data['buyagain_sale'])) {
				if (m('goods')->canBuyAgain($data)) {
					$data['deduct'] = 0;
					$saleset = false;
				}
			}

			if ($open_redis) {
				if ($data['manydeduct']) {
					$deductprice += $data['deduct'] * $data['total'];
				}
				else {
					$deductprice += $data['deduct'];
				}

				if ($data['deduct2'] == 0) {
					$deductprice2 += $data['ggprice'];
				}
				else {
					if (0 < $data['deduct2']) {
						if ($data['ggprice'] < $data['deduct2']) {
							$deductprice2 += $data['ggprice'];
						}
						else {
							$deductprice2 += $data['deduct2'];
						}
					}
				}
			}

			$virtualsales += $data['sales'];
			$allgoods[] = $data;
		}

		$grprice = $totalprice;

		if (empty($allgoods)) {
			show_json(0, '未找到任何商品');
		}

		$couponid = intval($_GPC['couponid']);
		$contype = intval($_GPC['contype']);
		$wxid = intval($_GPC['wxid']);
		$wxcardid = $_GPC['wxcardid'];
		$wxcode = $_GPC['wxcode'];

		if ($contype == 1) {
			$ref = com_run('wxcard::wxCardGetCodeInfo', $wxcode, $wxcardid);

			if (!is_wxerror($ref)) {
				$ref = com_run('wxcard::wxCardConsume', $wxcode, $wxcardid);

				if (is_wxerror($ref)) {
					show_json(0, '您的卡券未到使用日期或已经超出使用次数限制!');
				}
			}
			else {
				show_json(0, '您的卡券未到使用日期或已经超出使用次数限制!');
			}
		}

		$deductenough = 0;

		if ($saleset) {
			foreach ($saleset['enoughs'] as $e) {
				if (floatval($e['enough']) <= $totalprice && 0 < floatval($e['money'])) {
					$deductenough = floatval($e['money']);

					if ($totalprice < $deductenough) {
						$deductenough = $totalprice;
					}

					break;
				}
			}
		}

		$goodsdata_coupon = array();
		$goodsdata_coupon_temp = array();

		foreach ($allgoods as $g) {
			if (0 < floatval($g['buyagain'])) {
				if (!m('goods')->canBuyAgain($g) || !empty($g['buyagain_sale'])) {
					$goodsdata_coupon[] = $g;
				}
				else {
					$goodsdata_coupon_temp[] = $g;
				}
			}
			else {
				$goodsdata_coupon[] = $g;
			}
		}

		$return_array = $this->caculatecoupon($contype, $couponid, $wxid, $wxcardid, $wxcode, $goodsdata_coupon, $totalprice, $discountprice, $isdiscountprice, 1, $discountprice_array, $merchisdiscountprice);
		$couponprice = 0;
		$coupongoodprice = 0;

		if (!empty($return_array)) {
			$isdiscountprice = $return_array['isdiscountprice'];
			$discountprice = $return_array['discountprice'];
			$couponprice = $return_array['deductprice'];
			$totalprice = $return_array['totalprice'];
			$discountprice_array = $return_array['discountprice_array'];
			$coupongoodprice = $return_array['coupongoodprice'];
			$couponmerchid = $return_array['couponmerchid'];
			$allgoods = $return_array['goodsarr'];
		}

		if (!$isvirtual && $dispatchtype == 0) {
			if (empty($addressid)) {
				show_json(0, '请选择地址');
			}

			$dispatch_array = m('order')->getOrderDispatchPrice($allgoods, $member, $address, $saleset, $merch_array, 2);
			$dispatch_price = $dispatch_array['dispatch_price'];
			$nodispatch_array = $dispatch_array['nodispatch_array'];

			if (!empty($nodispatch_array['isnodispatch'])) {
				show_json(0, $nodispatch_array['nodispatch']);
			}
		}

		$totalprice -= $deductenough;
		$totalprice += $dispatch_price * $cycelbuy_num;
		if ($saleset && empty($saleset['dispatchnodeduct'])) {
			$deductprice2 += $dispatch_price;
		}

		$deductcredit = 0;
		$deductmoney = 0;
		$deductcredit2 = 0;

		if ($sale_plugin) {
			if (!empty($_GPC['deduct'])) {
				$credit = $member['credit1'];

				if (0 < $credit) {
					$credit = floor($credit);
				}

				if (!empty($saleset['creditdeduct'])) {
					$pcredit = intval($saleset['credit']);
					$pmoney = round(floatval($saleset['money']), 2);
					if (0 < $pcredit && 0 < $pmoney) {
						if ($credit % $pcredit == 0) {
							$deductmoney = round(intval($credit / $pcredit) * $pmoney, 2);
						}
						else {
							$deductmoney = round((intval($credit / $pcredit) + 1) * $pmoney, 2);
						}
					}

					if ($deductprice < $deductmoney) {
						$deductmoney = $deductprice;
					}

					if ($totalprice < $deductmoney) {
						$deductmoney = $totalprice;
					}

					$deductcredit = floor($deductmoney / $pmoney * $pcredit);
				}
			}

			$totalprice -= $deductmoney;
		}

		if (!empty($saleset['moneydeduct'])) {
			if (!empty($_GPC['deduct2'])) {
				$deductcredit2 = $member['credit2'];

				if ($totalprice < $deductcredit2) {
					$deductcredit2 = $totalprice;
				}

				if ($deductprice2 < $deductcredit2) {
					$deductcredit2 = $deductprice2;
				}
			}

			$totalprice -= $deductcredit2;
		}

		$carrier = $_GPC['carriers'];
		$carriers = is_array($carrier) ? iserializer($carrier) : iserializer(array());

		if ($totalprice <= 0) {
			$totalprice = 0;
		}

		$multiple_order = 0;
		$ordersn = m('common')->createNO('order', 'ordersn', 'CB');
		$order = array();
		$order['ismerch'] = $ismerch;
		$order['parentid'] = 0;
		$order['uniacid'] = $uniacid;
		$order['openid'] = $openid;
		$order['ordersn'] = $ordersn;
		$order['price'] = $totalprice;
		$order['oldprice'] = $totalprice;
		$order['grprice'] = $grprice;
		$order['discountprice'] = $discountprice;
		$order['isdiscountprice'] = $isdiscountprice;
		$order['merchisdiscountprice'] = $merchisdiscountprice;
		$order['cash'] = $cash;
		$order['status'] = 0;
		$order['remark'] = trim($_GPC['remark']);
		$order['addressid'] = empty($dispatchtype) ? $addressid : 0;
		$order['goodsprice'] = $goodsprice;
		$order['dispatchprice'] = $dispatch_price * $cycelbuy_num;
		$order['dispatchtype'] = $dispatchtype;
		$order['dispatchid'] = $dispatchid;
		$order['carrier'] = $carriers;
		$order['createtime'] = time();
		$order['olddispatchprice'] = $dispatch_price;
		$order['contype'] = $contype;
		$order['couponid'] = $couponid;
		$order['wxid'] = $wxid;
		$order['wxcardid'] = $wxcardid;
		$order['wxcode'] = $wxcode;
		$order['couponmerchid'] = $couponmerchid;
		$order['paytype'] = 0;
		$order['deductprice'] = $deductmoney;
		$order['deductcredit'] = $deductcredit;
		$order['deductcredit2'] = $deductcredit2;
		$order['deductenough'] = $deductenough;
		$order['couponprice'] = $couponprice;
		$order['merchshow'] = 0;
		$order['buyagainprice'] = $buyagainprice;
		$order['cycelbuy_periodic'] = $cycelbuy_periodic;
		$order['iscycelbuy'] = 1;
		$order['cycelbuy_predict_time'] = strtotime($_GPC['predicttime']);
		$order['invoicename'] = trim($_GPC['invoicename']);
		$order['officcode'] = intval($_GPC['officcode']);

		if ($multiple_order == 0) {
			$order['merchid'] = 0;
			$order['isparent'] = 0;
			$order['city_express_state'] = empty($dispatch_array['city_express_state']) == true ? 0 : $dispatch_array['city_express_state'];
		}

		if ($diyform_plugin) {
			if (is_array($_GPC['diydata']) && !empty($order_formInfo)) {
				$diyform_data = $diyform_plugin->getInsertData($fields, $_GPC['diydata']);
				$idata = $diyform_data['data'];
				$order['diyformfields'] = iserializer($fields);
				$order['diyformdata'] = $idata;
				$order['diyformid'] = $order_formInfo['id'];
			}
		}

		if (!empty($address)) {
			$order['address'] = iserializer($address);
		}

		pdo_insert('ewei_shop_order', $order);
		$orderid = pdo_insertid();
		$exchangepriceset = $_SESSION['exchangepriceset'];
		$exchangetitle = '';

		foreach ($allgoods as $goods) {
			$order_goods = array();
			$order_goods['merchid'] = $goods['merchid'];
			$order_goods['merchsale'] = $goods['merchsale'];
			$order_goods['uniacid'] = $uniacid;
			$order_goods['orderid'] = $orderid;
			$order_goods['goodsid'] = $goods['goodsid'];
			$order_goods['price'] = $goods['marketprice'] * $goods['total'];
			$order_goods['total'] = $goods['total'];
			$order_goods['optionid'] = $goods['optionid'];
			$order_goods['createtime'] = time();
			$order_goods['optionname'] = $goods['optiontitle'];
			$order_goods['goodssn'] = $goods['goodssn'];
			$order_goods['productsn'] = $goods['productsn'];
			$order_goods['realprice'] = $goods['ggprice'];
			$exchangetitle .= $goods['title'];
			if (p('exchange') && is_array($exchangepriceset)) {
				$order_goods['realprice'] = 0;

				foreach ($exchangepriceset as $ke => $va) {
					if (empty($goods['optionid']) && is_array($va) && $goods['goodsid'] == $va[0] && $va[1] == 0) {
						$order_goods['realprice'] = $va[2];
						break;
					}

					if (!empty($goods['optionid']) && is_array($va) && $goods['optionid'] == $va[0] && $va[1] == 1) {
						$order_goods['realprice'] = $va[2];
						break;
					}
				}
			}

			$order_goods['oldprice'] = $goods['ggprice'];

			if ($goods['discounttype'] == 1) {
				$order_goods['isdiscountprice'] = $goods['isdiscountprice'];
			}
			else {
				$order_goods['isdiscountprice'] = 0;
			}

			$order_goods['openid'] = $openid;

			if ($diyform_plugin) {
				if ($goods['diyformtype'] == 2) {
					$order_goods['diyformid'] = 0;
				}
				else {
					$order_goods['diyformid'] = $goods['diyformid'];
				}

				$order_goods['diyformdata'] = $goods['diyformdata'];
				$order_goods['diyformfields'] = $goods['diyformfields'];
			}

			if (0 < floatval($goods['buyagain'])) {
				if (!m('goods')->canBuyAgain($goods)) {
					$order_goods['canbuyagain'] = 1;
				}
			}

			pdo_insert('ewei_shop_order_goods', $order_goods);
		}

		if (com('coupon') && !empty($orderid)) {
			com('coupon')->addtaskdata($orderid);
		}

		if (is_array($carrier)) {
			$up = array('realname' => $carrier['carrier_realname'], 'carrier_mobile' => $carrier['carrier_mobile']);
			pdo_update('ewei_shop_member', $up, array('id' => $member['id'], 'uniacid' => $_W['uniacid']));

			if (!empty($member['uid'])) {
				load()->model('mc');
				mc_update($member['uid'], $up);
			}
		}

		if ($_GPC['fromcart'] == 1) {
			pdo_query('update ' . tablename('ewei_shop_member_cart') . ' set deleted=1 where  openid=:openid and uniacid=:uniacid and selected=1 ', array(':uniacid' => $uniacid, ':openid' => $openid));
		}

		if (0 < $deductcredit) {
			m('member')->setCredit($openid, 'credit1', 0 - $deductcredit, array('0', $_W['shopset']['shop']['name'] . ('购物积分抵扣 消费积分: ' . $deductcredit . ' 抵扣金额: ' . $deductmoney . ' 订单号: ' . $ordersn)));
		}

		if (0 < $buyagainprice) {
			m('goods')->useBuyAgain($orderid);
		}

		if (0 < $deductcredit2) {
			m('member')->setCredit($openid, 'credit2', 0 - $deductcredit2, array('0', $_W['shopset']['shop']['name'] . ('购物余额抵扣: ' . $deductcredit2 . ' 订单号: ' . $ordersn)));
		}

		if (empty($virtualid)) {
			m('order')->setStocksAndCredits($orderid, 0);
		}
		else {
			if (isset($allgoods[0])) {
				$vgoods = $allgoods[0];
				pdo_update('ewei_shop_goods', array('sales' => $vgoods['sales'] + $vgoods['total']), array('id' => $vgoods['goodsid']));
			}
		}

		m('notice')->sendOrderMessage($orderid);
		com_run('printer::sendOrderMessage', $orderid);
		$pluginc = p('commission');

		if ($pluginc) {
			if ($multiple_order == 0) {
				$pluginc->checkOrderConfirm($orderid);
			}
			else {
				if (!empty($merch_array)) {
					foreach ($merch_array as $key => $value) {
						$pluginc->checkOrderConfirm($value['orderid']);
					}
				}
			}
		}

		unset($_SESSION[$openid . '_order_create']);
		show_json(1, array('orderid' => $orderid));
	}

	protected function singleDiyformData($id = 0)
	{
		global $_W;
		global $_GPC;
		$goods_data = false;
		$diyformtype = false;
		$diyformid = 0;
		$diymode = 0;
		$formInfo = false;
		$goods_data_id = 0;
		$diyform_plugin = p('diyform');
		if ($diyform_plugin && !empty($id)) {
			$sql = 'SELECT id as goodsid,type,diyformtype,diyformid,diymode,diyfields FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
			$goods_data = pdo_fetch($sql, array(':uniacid' => $_W['uniacid'], ':id' => $id));

			if (!empty($goods_data)) {
				$diyformtype = $goods_data['diyformtype'];
				$diyformid = $goods_data['diyformid'];
				$diymode = $goods_data['diymode'];

				if ($goods_data['diyformtype'] == 1) {
					$formInfo = $diyform_plugin->getDiyformInfo($diyformid);
				}
				else {
					if ($goods_data['diyformtype'] == 2) {
						$fields = iunserializer($goods_data['diyfields']);

						if (!empty($fields)) {
							$formInfo = array('fields' => $fields);
						}
					}
				}
			}
		}

		return array('goods_data' => $goods_data, 'diyformtype' => $diyformtype, 'diyformid' => $diyformid, 'diymode' => $diymode, 'formInfo' => $formInfo, 'goods_data_id' => $goods_data_id, 'diyform_plugin' => $diyform_plugin);
	}

	public function diyform()
	{
		global $_W;
		global $_GPC;
		$goodsid = intval($_GPC['id']);
		$cartid = intval($_GPC['cartid']);
		$openid = $_W['openid'];
		$data = $this->singleDiyformData($goodsid);
		extract($data);

		if ($diyformtype == 2) {
			$diyformid = 0;
		}
		else {
			$diyformid = $goods_data['diyformid'];
		}

		$fields = $formInfo['fields'];
		$insert_data = $diyform_plugin->getInsertData($fields, $_GPC['diyformdata']);
		$idata = $insert_data['data'];
		$corder_plugin = p('corder');

		if ($corder_plugin) {
			$corder_plugin->check_data($idata);
		}

		$goods_temp = $diyform_plugin->getGoodsTemp($goodsid, $diyformid, $openid);
		$insert = array('cid' => $goodsid, 'openid' => $openid, 'diyformid' => $diyformid, 'type' => 3, 'diyformfields' => iserializer($fields), 'diyformdata' => $idata, 'uniacid' => $_W['uniacid']);

		if (empty($goods_temp)) {
			pdo_insert('ewei_shop_diyform_temp', $insert);
			$gdid = pdo_insertid();
		}
		else {
			pdo_update('ewei_shop_diyform_temp', $insert, array('id' => $goods_temp['id']));
			$gdid = $goods_temp['id'];
		}

		if (!empty($cartid)) {
			$cart_data = array('diyformid' => $insert['diyformid'], 'diyformfields' => $insert['diyformfields'], 'diyformdata' => $insert['diyformdata']);
			pdo_update('ewei_shop_member_cart', $cart_data, array('id' => $cartid));
		}

		show_json(1, array('goods_data_id' => $gdid));
	}
}

?>
