<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Create_EweiShopV2Page extends MobileLoginPage
{
	protected function merchData()
	{
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		return array('is_openmerch' => $is_openmerch, 'merch_plugin' => $merch_plugin, 'merch_data' => $merch_data);
	}

	protected function diyformData($member, $goods_fields = false, $diyformid = false)
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

			if (!empty($diyformid)) {
				$order_formInfo = $diyform_plugin->getDiyformInfo($diyformid);
				$fields = $order_formInfo['fields'];
			}
			else {
				if (!empty($goods_fields)) {
					$order_formInfo = $goods_fields;
					$fields = $goods_fields;
				}
			}
		}

		return array('diyform_plugin' => $diyform_plugin, 'order_formInfo' => $order_formInfo, 'diyform_set' => $diyform_set, 'orderdiyformid' => $orderdiyformid, 'has_fields' => !empty($fields), 'fields' => $fields, 'f_data' => $f_data);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$trade = m('common')->getSysset('trade');
		$shop = m('common')->getSysset('shop');
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);
		$member = m('member')->getMember($_W['openid']);
		$show_card = true;

		if (p('exchange')) {
			$exchangeOrder = trim($_GPC['exchange']);

			if (!empty($exchangeOrder)) {
				$show_card = false;
				$_SESSION['exchange'] = 1;
				$exchangepostage = $_SESSION['exchangepostage'];
				$exchangeprice = $_SESSION['exchangeprice'];

				if ($_GPC['dflag'] == '1') {
					$exchangeprice = 0;
				}

				$exchangerealprice = $exchangeprice + $exchangepostage;
			}
			else {
				unset($_SESSION['exchange']);
				unset($_SESSION['exchangeprice']);
				unset($_SESSION['exchangepostage']);
			}
		}

		if (p('threen')) {
			$threenvip = p('threen')->getMember($_W['openid']);

			if (!empty($threenvip)) {
				$threenprice = true;
			}
		}

		if (p('quick')) {
			$quickid = intval($_GPC['fromquick']);

			if (!empty($quickid)) {
				$quickinfo = p('quick')->getQuick($quickid);

				if (empty($quickinfo)) {
					$this->message('快速购买页面不存在');
					exit();
				}
			}
		}

		$liveid = intval($_GPC['liveid']);
		$card_live_id = intval($_GPC['liveid']);
		if (p('live') && !empty($liveid)) {
			$isliving = p('live')->isLiving($liveid);
			if (!$isliving || $this->getdefaultMembercardId()) {
				$liveid = 0;
			}
		}

		$open_redis = function_exists('redis') && !is_error(redis());
		$seckillinfo = false;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$goodsid = intval($_GPC['id']);
		$commission = m('common')->getPluginset('commission');
		$offic_register = false;

		if ($commission['become_goodsid'] == $goodsid) {
			$offic_register = true;
		}

		$giftid = intval($_GPC['giftid']);
		$giftGood = array();
		$sysset = m('common')->getSysset('trade');
		$allow_sale = true;
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);
		$packageid = intval($_GPC['packageid']);

		if (!$packageid) {
			$merchdata = $this->merchData();
			extract($merchdata);
			$merch_array = array();
			$merchs = array();
			$merch_id = 0;
			$total_array = array();
			$member = m('member')->getMember($openid, true);
			$member['carrier_mobile'] = empty($member['carrier_mobile']) ? $member['mobile'] : $member['carrier_mobile'];
			$share = m('common')->getSysset('share');
			$level = m('member')->getLevel($openid);
			$id = intval($_GPC['id']);
			$iswholesale = intval($_GPC['iswholesale']);
			$bargain_id = intval($_GPC['bargainid']);
			$_SESSION['bargain_id'] = NULL;
			if (p('bargain') && !empty($bargain_id)) {
				$show_card = false;
				$_SESSION['bargain_id'] = $bargain_id;
				$bargain_act = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_bargain_actor') . ' WHERE id = :id AND openid = :openid AND status = \'0\'', array(':id' => $bargain_id, ':openid' => $_W['openid']));

				if (empty($bargain_act)) {
					exit('没有这个商品!');
				}

				$bargain_act_id = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_bargain_goods') . (' WHERE id = \'' . $bargain_act['goods_id'] . '\''));

				if (empty($bargain_act_id)) {
					exit('没有这个商品!');
				}

				$if_bargain = pdo_fetch('SELECT bargain FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id AND uniacid = :uniacid ', array(':id' => $bargain_act_id['goods_id'], ':uniacid' => $_W['uniacid']));

				if (empty($if_bargain['bargain'])) {
					exit('没有这个商品!');
				}

				$id = $bargain_act_id['goods_id'];
			}

			$optionid = intval($_GPC['optionid']);
			$total = intval($_GPC['total']);

			if ($total < 1) {
				$total = 1;
			}

			$buytotal = $total;
			$errcode = 0;
			$isverify = false;
			$isforceverifystore = false;
			$isvirtual = false;
			$isvirtualsend = false;
			$isonlyverifygoods = true;
			$changenum = false;
			$fromcart = 0;
			$hasinvoice = false;
			$invoicename = '';
			$buyagain_sale = true;
			$buyagainprice = 0;
			$goods = array();

			if (empty($id)) {
				if (!empty($quickid)) {
					$sql = 'SELECT c.goodsid,c.total,g.maxbuy,g.type,g.intervalfloor,g.intervalprice,g.issendfree,g.isnodiscount,g.ispresell,g.presellprice as gpprice,o.presellprice,g.preselltimeend,g.presellsendstatrttime,g.presellsendtime,g.presellsendtype' . ',g.weight,o.weight as optionweight,g.title,g.thumb,ifnull(o.marketprice, g.marketprice) as marketprice,o.title as optiontitle,c.optionid,' . ' g.storeids,g.isverify,g.isforceverifystore,g.deduct,g.manydeduct,g.manydeduct2,g.virtual,o.virtual as optionvirtual,discounts,' . ' g.deduct2,g.ednum,g.edmoney,g.edareas,g.edareas_code,g.diyformtype,g.diyformid,diymode,g.dispatchtype,g.dispatchid,g.dispatchprice,g.minbuy ' . ' ,g.isdiscount,g.isdiscount_time,g.isdiscount_discounts,g.cates,g.isfullback, ' . ' g.virtualsend,invoice,o.specs,g.merchid,g.checked,g.merchsale,g.unite_total,' . ' g.buyagain,g.buyagain_islong,g.buyagain_condition, g.buyagain_sale, g.hasoption, g.threen' . ' FROM ' . tablename('ewei_shop_quick_cart') . ' c ' . ' left join ' . tablename('ewei_shop_goods') . ' g on c.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on c.optionid = o.id ' . (' where c.openid=:openid and c.selected=1 and  c.deleted=0 and c.uniacid=:uniacid and c.quickid=' . $quickid . '  order by c.id desc');
					$goods = pdo_fetchall($sql, array(':uniacid' => $uniacid, ':openid' => $openid));
				}
				else if (empty($exchangeOrder)) {
					$sql = 'SELECT c.goodsid,c.total,g.maxbuy,g.type,g.intervalfloor,g.intervalprice,g.issendfree,g.isnodiscount,g.ispresell,g.presellprice as gpprice,o.presellprice,g.preselltimeend,g.presellsendstatrttime,g.presellsendtime,g.presellsendtype' . ',g.weight,o.weight as optionweight,g.title,g.thumb,ifnull(o.marketprice, g.marketprice) as marketprice,o.title as optiontitle,c.optionid,' . ' g.storeids,g.isverify,g.isforceverifystore,g.deduct,g.manydeduct,g.manydeduct2,g.virtual,o.virtual as optionvirtual,discounts,' . ' g.deduct2,g.ednum,g.edmoney,g.edareas,g.edareas_code,g.diyformtype,g.diyformid,diymode,g.dispatchtype,g.dispatchid,g.dispatchprice,g.minbuy ' . ' ,g.isdiscount,g.isdiscount_time,g.isdiscount_discounts,g.cates, ' . ' g.virtualsend,invoice,o.specs,g.merchid,g.checked,g.merchsale,' . ' g.buyagain,g.buyagain_islong,g.buyagain_condition, g.buyagain_sale, g.hasoption' . ' FROM ' . tablename('ewei_shop_member_cart') . ' c ' . ' left join ' . tablename('ewei_shop_goods') . ' g on c.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on c.optionid = o.id ' . ' where c.openid=:openid and c.selected=1 and  c.deleted=0 and c.uniacid=:uniacid  order by c.id desc';
					$goods = pdo_fetchall($sql, array(':uniacid' => $uniacid, ':openid' => $openid));
				}
				else {
					if (p('exchange')) {
						$sql = 'SELECT c.goodsid,c.total,g.maxbuy,g.type,g.intervalfloor,g.intervalprice,g.issendfree,g.isnodiscount,g.ispresell,g.presellprice as gpprice,o.presellprice,g.preselltimeend,g.presellsendstatrttime,g.presellsendtime,g.presellsendtype' . ',g.weight,o.weight as optionweight,g.title,g.thumb,ifnull(o.marketprice, g.marketprice) as marketprice,o.title as optiontitle,c.optionid,' . ' g.storeids,g.isverify,g.isforceverifystore,g.deduct,g.manydeduct,g.manydeduct2,g.virtual,o.virtual as optionvirtual,discounts,' . ' g.deduct2,g.ednum,g.edmoney,g.edareas,g.edareas_code,g.diyformtype,g.diyformid,diymode,g.dispatchtype,g.dispatchid,g.dispatchprice,g.minbuy ' . ' ,g.isdiscount,g.isdiscount_time,g.isdiscount_discounts,g.cates,g.isfullback, ' . ' g.virtualsend,invoice,o.specs,g.merchid,g.checked,g.merchsale,g.unite_total,' . ' g.buyagain,g.buyagain_islong,g.buyagain_condition, g.buyagain_sale, g.hasoption' . ' FROM ' . tablename('ewei_shop_exchange_cart') . ' c ' . ' left join ' . tablename('ewei_shop_goods') . ' g on c.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on c.optionid = o.id ' . ' where c.openid=:openid and c.selected=1 and  c.deleted=0 and c.uniacid=:uniacid  order by c.id desc';
						$goods = pdo_fetchall($sql, array(':uniacid' => $uniacid, ':openid' => $openid));
					}
				}

				if (empty($goods)) {
					header('location: ' . mobileUrl('member/cart'));
					exit();
					$errcode = 1;
					include $this->template();
					exit();
				}
				else {
					$merch_dif = array();
					$diyformdata = $this->diyformData($member);
					extract($diyformdata);

					foreach ($goods as $k => $v) {
						$merch_dif[] = $v['merchid'];

						if ($v['type'] == 4) {
							$intervalprice = iunserializer($v['intervalprice']);

							if (0 < $v['intervalfloor']) {
								$goods[$k]['intervalprice1'] = $intervalprice[0]['intervalprice'];
								$goods[$k]['intervalnum1'] = $intervalprice[0]['intervalnum'];
							}

							if (1 < $v['intervalfloor']) {
								$goods[$k]['intervalprice2'] = $intervalprice[1]['intervalprice'];
								$goods[$k]['intervalnum2'] = $intervalprice[1]['intervalnum'];
							}

							if (2 < $v['intervalfloor']) {
								$goods[$k]['intervalprice3'] = $intervalprice[2]['intervalprice'];
								$goods[$k]['intervalnum3'] = $intervalprice[2]['intervalnum'];
							}
						}

						$opdata = array();

						if (0 < $v['hasoption']) {
							$opdata = m('goods')->getOption($v['goodsid'], $v['optionid']);
							if (empty($opdata) || empty($v['optionid'])) {
								$this->message('商品' . $v['title'] . '的规格不存在,请到购物车删除该商品重新选择规格!', '', 'error');
							}

							if (!empty($v['unite_total'])) {
								$total_array[$v['goodsid']]['total'] += $v['total'];
							}
						}

						if (!empty($opdata)) {
							$goods[$k]['marketprice'] = $v['marketprice'];
						}

						if (0 < $v['ispresell'] && ($v['preselltimeend'] == 0 || time() < $v['preselltimeend'])) {
							$goods[$k]['marketprice'] = 0 < intval($v['hasoption']) ? $v['presellprice'] : $v['gpprice'];
						}

						$fullbackgoods = array();

						if ($v['isfullback']) {
							$fullbackgoods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_fullback_goods') . ' WHERE goodsid = :goodsid and uniacid = :uniacid and status = 1 limit 1 ', array(':goodsid' => $v['goodsid'], ':uniacid' => $uniacid));
						}

						if ($is_openmerch == 0) {
							if (0 < $v['merchid']) {
								$err = true;
								include $this->template('goods/detail');
								exit();
							}
						}
						else {
							if (0 < $v['merchid'] && $v['checked'] == 1) {
								$err = true;
								include $this->template('goods/detail');
								exit();
							}
						}

						if (!empty($v['specs'])) {
							$thumb = m('goods')->getSpecThumb($v['specs']);

							if (!empty($thumb)) {
								$goods[$k]['thumb'] = $thumb;
							}
						}

						if (!empty($v['optionvirtual'])) {
							$goods[$k]['virtual'] = $v['optionvirtual'];
						}

						if (!empty($v['optionweight'])) {
							$goods[$k]['weight'] = $v['optionweight'];
						}

						$goods[$k]['seckillinfo'] = plugin_run('seckill::getSeckill', $v['goodsid'], $v['optionid'], true, $_W['openid']);
						if (!empty($goods[$k]['seckillinfo']['maxbuy']) && $goods[$k]['seckillinfo']['maxbuy'] - $goods[$k]['seckillinfo']['selfcount'] < $goods[$k]['total']) {
							$this->message('您已购买了' . $goods[$k]['seckillinfo']['selfcount'] . '最多购买' . $goods[$k]['seckillinfo']['maxbuy'] . '件', NULL, 'danger');
						}
					}

					$merch_dif = array_flip(array_flip($merch_dif));
					if ($exchangepostage && !is_array($_SESSION['exchange_postage_info'])) {
						$exchange_postage_count = count($merch_dif) * $exchangepostage;
						$exchangerealprice = $exchangerealprice - $exchangepostage + $exchange_postage_count;
						$exchangepostage = $exchange_postage_count;
					}

					$goods = m('goods')->wholesaleprice($goods);

					foreach ($goods as $k => $v) {
						if ($v['type'] == 4) {
							$goods[$k]['marketprice'] = $v['wholesaleprice'];
						}
					}
				}

				$fromcart = 1;
			}
			else {
				if (!empty($id) && !empty($iswholesale)) {
					$show_card = false;
					$sql = 'SELECT id as goodsid,type,title,weight,issendfree,isnodiscount,ispresell,presellprice,' . ' thumb,marketprice,storeids,isverify,isforceverifystore,deduct,hasoption,preselltimeend,presellsendstatrttime,presellsendtime,presellsendtype,' . ' manydeduct,manydeduct2,`virtual`,maxbuy,usermaxbuy,discounts,total as stock,deduct2,showlevels,' . ' ednum,edmoney,edareas,edareas_code,unite_total,' . ' diyformtype,diyformid,diymode,dispatchtype,dispatchid,dispatchprice,cates,minbuy, ' . ' isdiscount,isdiscount_time,isdiscount_discounts, ' . ' virtualsend,invoice,needfollow,followtip,followurl,merchid,checked,merchsale, ' . ' buyagain,buyagain_islong,buyagain_condition, buyagain_sale ,intervalprice ,intervalfloor ' . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
					$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $id));
					if (empty($data) || $data['type'] != 4) {
						$this->message('商品不存在!', '', 'error');
					}

					$diyformdata = $this->diyformData($member);
					extract($diyformdata);
					$intervalprice = iunserializer($data['intervalprice']);

					if (0 < $data['intervalfloor']) {
						$data['intervalprice1'] = $intervalprice[0]['intervalprice'];
						$data['intervalnum1'] = $intervalprice[0]['intervalnum'];
					}

					if (1 < $data['intervalfloor']) {
						$data['intervalprice2'] = $intervalprice[1]['intervalprice'];
						$data['intervalnum2'] = $intervalprice[1]['intervalnum'];
					}

					if (2 < $data['intervalfloor']) {
						$data['intervalprice3'] = $intervalprice[2]['intervalprice'];
						$data['intervalnum3'] = $intervalprice[2]['intervalnum'];
					}

					$buyoptions = $_GPC['buyoptions'];
					$optionsdata = json_decode(htmlspecialchars_decode($buyoptions, ENT_QUOTES), true);
					if (empty($optionsdata) || !is_array($optionsdata)) {
						$this->message('商品' . $data['title'] . '的规格不存在,请重新选择规格!', '', 'error');
					}

					$follow = m('user')->followed($openid);
					if (!empty($data['needfollow']) && !$follow && is_weixin()) {
						$followtip = empty($goods['followtip']) ? '如果您想要购买此商品，需要您关注我们的公众号，点击【确定】关注后再来购买吧~' : $goods['followtip'];
						$followurl = empty($goods['followurl']) ? $_W['shopset']['share']['followurl'] : $goods['followurl'];
						$this->message($followtip, $followurl, 'error');
					}

					$total = 0;

					foreach ($optionsdata as $option) {
						$good = $data;
						$num = intval($option['total']);

						if ($num <= 0) {
							continue;
						}

						$total = $total + $num;
						$good['total'] = $num;
						$good['optionid'] = $option['optionid'];

						if (0 < $option['optionid']) {
							$option = pdo_fetch('select id,title,marketprice,presellprice,goodssn,productsn,`virtual`,stock,weight,specs from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $id, ':id' => $option['optionid']));

							if (!empty($option)) {
								$good['optiontitle'] = $option['title'];
								$good['virtual'] = $option['virtual'];

								if (empty($data['unite_total'])) {
									$data['stock'] = $option['stock'];

									if ($option['stock'] < $num) {
										$this->message('商品' . $data['title'] . '的购买数量超过库存剩余数量,请重新选择规格!', '', 'error');
									}
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
							}
							else {
								if (!empty($data['hasoption'])) {
									$this->message('商品' . $data['title'] . '的规格不存在,请重新选择规格!', '', 'error');
								}
							}
						}

						$goods[] = $good;
					}

					$goods = m('goods')->wholesaleprice($goods);

					foreach ($goods as $k => $v) {
						if ($v['type'] == 4) {
							$goods[$k]['marketprice'] = $v['wholesaleprice'];
						}
					}
				}
				else {
					$threensql = '';
					if (p('threen') && !empty($threenprice)) {
						$threensql .= ',threen';
					}

					$ishotelsql = '';

					if (p('hotelreservation')) {
					}

					$sql = 'SELECT id as goodsid,type,title,weight,issendfree,isnodiscount,ispresell,presellprice,' . ' thumb,marketprice,liveprice,islive,storeids,isverify,isforceverifystore,deduct,hasoption,preselltimeend,presellsendstatrttime,presellsendtime,presellsendtype,' . ' manydeduct,manydeduct2,`virtual`,maxbuy,usermaxbuy,discounts,total as stock,deduct2,showlevels,' . ' ednum,edmoney,edareas,edareas_code,unite_total,diyfields,' . ' diyformtype,diyformid,diymode,dispatchtype,dispatchid,dispatchprice,cates,minbuy, ' . ' isdiscount,isdiscount_time,isdiscount_discounts,isfullback, ' . ' virtualsend,invoice,needfollow,followtip,followurl,merchid,checked,merchsale, ' . ' buyagain,buyagain_islong,buyagain_condition, buyagain_sale,bargain' . $threensql . $ishotelsql . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
					$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $id));
					$threenprice = json_decode($data['threen'], 1);

					if (0 < $data['bargain']) {
						if ($data['diyformtype'] == 2) {
							$diy = unserialize($data['diyfields']);
							$diyformdata = $this->diyformData($member, $diy);
						}
						else if ($data['diyformtype'] == 1) {
							$diyformdata = $this->diyformData($member, false, $data['diyformid']);
						}
						else {
							$diyformdata = $this->diyformData($member);
						}
					}
					else {
						$diyformdata = $this->diyformData($member);
					}

					extract($diyformdata);
					if (0 < $data['ispresell'] && ($data['preselltimeend'] == 0 || time() < $data['preselltimeend'])) {
						$data['marketprice'] = $data['presellprice'];
						$show_card = false;
					}

					if (!empty($liveid)) {
						$isLiveGoods = p('live')->isLiveGoods($data['goodsid'], $liveid);

						if (!empty($isLiveGoods)) {
							$defaultcardid = $this->getdefaultMembercardId();

							if ($defaultcardid) {
								$live_product = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_goods') . (' WHERE id = \'' . $data['goodsid'] . '\''));

								if ($live_product) {
									$data['marketprice'] = $live_product['marketprice'];
								}
							}
							else {
								$data['marketprice'] = price_format($isLiveGoods['liveprice']);
							}
						}
					}

					if ($data['type'] == 4) {
						$this->message('商品信息错误!', '', 'error');
					}

					$data['seckillinfo'] = plugin_run('seckill::getSeckill', $data['goodsid'], $optionid, true, $_W['openid']);

					if ($data['seckillinfo']) {
						$show_card = false;
					}

					if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
					}
					else if ($data['isverify'] == 2) {
					}
					else {
						if ($giftid) {
							$gift = pdo_fetch('select id,title,thumb,activity,giftgoodsid,goodsid from ' . tablename('ewei_shop_gift') . '
                where uniacid = ' . $uniacid . ' and id = ' . $giftid . ' and status = 1 and starttime <= ' . time() . ' and endtime >= ' . time() . ' ');

							if (!strstr($gift['goodsid'], (string) $goodsid)) {
								$this->message('赠品与商品不匹配或者商品没有赠品!', '', 'error');
							}

							$giftGood = array();

							if (!empty($gift['giftgoodsid'])) {
								$giftGoodsid = explode(',', $gift['giftgoodsid']);

								if ($giftGoodsid) {
									foreach ($giftGoodsid as $key => $value) {
										$giftGood[$key] = pdo_fetch('select id,title,thumb,marketprice from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and total > 0 and status = 2 and id = ' . $value . ' and deleted = 0 ');
									}

									$giftGood = array_filter($giftGood);
								}
							}
						}
					}

					if (!empty($bargain_act)) {
						$data['marketprice'] = $bargain_act['now_price'];
					}

					$fullbackgoods = array();

					if ($data['isfullback']) {
						$fullbackgoods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_fullback_goods') . ' WHERE goodsid = :goodsid and uniacid = :uniacid and status = 1 limit 1 ', array(':goodsid' => $data['goodsid'], ':uniacid' => $uniacid));
					}

					if (empty($data) || !empty($data['showlevels']) && !strexists($data['showlevels'], $member['level']) || 0 < $data['merchid'] && $data['checked'] == 1 || $is_openmerch == 0 && 0 < $data['merchid']) {
						$err = true;
						include $this->template('goods/detail');
						exit();
					}

					$follow = m('user')->followed($openid);
					if (!empty($data['needfollow']) && !$follow && is_weixin()) {
						$followtip = empty($data['followtip']) ? '如果您想要购买此商品，需要您关注我们的公众号，点击【确定】关注后再来购买吧~' : $data['followtip'];
						$followurl = empty($data['followurl']) ? $_W['shopset']['share']['followurl'] : $data['followurl'];
						$followqrcode = empty($_W['shopset']['share']['followqrcode']) ? $_W['account']['qrcode'] : tomedia($_W['shopset']['share']['followqrcode']);
						$followurl = empty($followqrcode) ? $followurl : $followqrcode;
						$this->message($followtip, $followurl, 'error');
					}

					if (0 < $data['minbuy'] && $total < $data['minbuy']) {
						$total = $data['minbuy'];
					}

					if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
						$total = 1;
					}

					$data['total'] = $total;
					$data['optionid'] = $optionid;

					if (!empty($optionid)) {
						$option = pdo_fetch('select id,title,marketprice,liveprice,islive,presellprice,goodssn,productsn,`virtual`,stock,weight,specs,
                    `day`,allfullbackprice,fullbackprice,allfullbackratio,fullbackratio,isfullback
                    from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $id, ':id' => $optionid));

						if (!empty($option)) {
							$data['optionid'] = $optionid;
							$data['optiontitle'] = $option['title'];
							$data['marketprice'] = 0 < intval($data['ispresell']) && (time() < $data['preselltimeend'] || $data['preselltimeend'] == 0) ? $option['presellprice'] : $option['marketprice'];
							if ($isliving && !empty($option['islive']) && 0 < $option['liveprice']) {
								$data['marketprice'] = $option['liveprice'];
							}

							if (!empty($liveid)) {
								$liveOption = p('live')->getLiveOptions($data['goodsid'], $liveid, array($option));
								$defaultcardid = $this->getdefaultMembercardId();

								if ($defaultcardid) {
									$gopdata = m('goods')->getOption($data['goodsid'], $optionid);

									if (empty($gopdata) != true) {
										$data['marketprice'] = price_format($gopdata['marketprice']);
									}
								}
								else {
									if (!empty($liveOption) && !empty($liveOption[0])) {
										$data['marketprice'] = price_format($liveOption[0]['marketprice']);
									}
								}
							}

							$data['virtual'] = $option['virtual'];
							if ($option['isfullback'] && !empty($fullbackgoods)) {
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
						}
						else {
							if (!empty($data['hasoption'])) {
								$this->message('商品' . $data['title'] . '的规格不存在,请重新选择规格!', '', 'error');
							}
						}
					}

					if ($giftid) {
						$changenum = false;
					}
					else {
						$changenum = true;
					}

					if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
						$changenum = false;
					}

					$goods[] = $data;
				}
			}

			$goods = set_medias($goods, 'thumb');

			foreach ($goods as &$g) {
				if ($g['type'] == 4 || 0 < $g['ispresell'] && ($g['preselltimeend'] == 0 || time() < $g['preselltimeend'])) {
					$show_card = false;
				}

				if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
					$g['is_task_goods'] = 0;
					$show_card = false;
				}
				else {
					if (p('task')) {
						$task_id = intval($_SESSION[$id . '_task_id']);

						if (!empty($task_id)) {
							$rewarded = pdo_fetchcolumn('SELECT `rewarded` FROM ' . tablename('ewei_shop_task_extension_join') . ' WHERE id = :id AND openid = :openid AND  uniacid = :uniacid', array(':id' => $task_id, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
							$taskGoodsInfo = unserialize($rewarded);
							$taskGoodsInfo = $taskGoodsInfo['goods'][$id];
							if (!empty($optionid) && !empty($taskGoodsInfo['option']) && $optionid == $taskGoodsInfo['option']) {
								$taskgoodsprice = $taskGoodsInfo['price'];
							}
							else {
								if (empty($optionid)) {
									$taskgoodsprice = $taskGoodsInfo['price'];
								}
							}
						}
					}

					$rank = intval($_SESSION[$id . '_rank']);
					$log_id = intval($_SESSION[$id . '_log_id']);
					$join_id = intval($_SESSION[$id . '_join_id']);
					$task_goods_data = m('goods')->getTaskGoods($openid, $id, $rank, $log_id, $join_id, $optionid);

					if (empty($task_goods_data['is_task_goods'])) {
						$g['is_task_goods'] = 0;
					}
					else {
						$allow_sale = false;
						$g['is_task_goods'] = $task_goods_data['is_task_goods'];
						$g['is_task_goods_option'] = $task_goods_data['is_task_goods_option'];
						$g['task_goods'] = $task_goods_data['task_goods'];
					}
				}

				if ($is_openmerch == 1 && 0 < $g['merchid']) {
					$merchid = $g['merchid'];
					$merch_array[$merchid]['goods'][] = $g['goodsid'];
				}

				if ($g['isverify'] == 2) {
					$isverify = true;
				}

				if ($g['isforceverifystore']) {
					$isforceverifystore = true;
				}

				if (!empty($g['virtual']) || $g['type'] == 2 || $g['type'] == 3 || $g['type'] == 20) {
					$isvirtual = true;

					if ($g['virtualsend']) {
						$isvirtualsend = true;
					}

					if ($g['type'] == 3) {
						$isvirtualsend = true;
					}
				}

				if ($g['invoice']) {
					$hasinvoice = $g['invoice'];
				}

				if ($g['type'] != 5) {
					$isonlyverifygoods = false;
				}

				$totalmaxbuy = $g['stock'];
				if (!empty($g['seckillinfo']) && $g['seckillinfo']['status'] == 0) {
					$seckilllast = 0;

					if (0 < $g['seckillinfo']['maxbuy']) {
						$seckilllast = $g['seckillinfo']['maxbuy'] - $g['seckillinfo']['selfcount'];
					}

					$g['totalmaxbuy'] = $g['total'];
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

					if (!empty($g['is_task_goods'])) {
						if ($g['task_goods']['total'] < $totalmaxbuy) {
							$totalmaxbuy = $g['task_goods']['total'];
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

			if ($is_openmerch == 1) {
				foreach ($merch_array as $key => $value) {
					if (0 < $key) {
						$merch_id = $key;
						$merch_array[$key]['set'] = $merch_plugin->getSet('sale', $key);
						$merch_array[$key]['enoughs'] = $merch_plugin->getEnoughs($merch_array[$key]['set']);
					}
				}
			}

			$weight = 0;
			$total = 0;
			$goodsprice = 0;
			$realprice = 0;
			$deductprice = 0;
			$taskdiscountprice = 0;
			$carddiscountprice = 0;
			$lotterydiscountprice = 0;
			$card_lotterydiscountprice = 0;
			$discountprice = 0;
			$isdiscountprice = 0;
			$deductprice2 = 0;
			$stores = array();
			$address = false;
			$carrier = false;
			$carrier_list = array();
			$dispatch_list = false;
			$dispatch_price = 0;
			$seckill_dispatchprice = 0;
			$seckill_price = 0;
			$seckill_payprice = 0;
			$ismerch = 0;

			if ($is_openmerch == 1) {
				if (!empty($merch_array)) {
					if (1 < count($merch_array)) {
						$ismerch = 1;
					}
				}
			}

			if (empty($merch_array) != true) {
				$show_card = false;
			}

			if (!$isverify && !$isvirtual && !$ismerch) {
				if (0 < $merch_id) {
					$carrier_list = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where  uniacid=:uniacid and merchid=:merchid and status=1 and type in(1,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $merch_id));
				}
				else {
					$carrier_list = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(1,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid']));
				}
			}

			$sale_plugin = com('sale');
			$saleset = false;

			if ($if_bargain) {
				$allow_sale = false;
			}

			if ($sale_plugin && $buyagain_sale && $allow_sale) {
				$saleset = $_W['shopset']['sale'];
				$saleset['enoughs'] = $sale_plugin->getEnoughs();
			}

			foreach ($goods as &$g) {
				if (empty($g['total']) || intval($g['total']) < 1) {
					$g['total'] = 1;
				}

				if ($taskcut || $g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
					$gprice = $g['marketprice'] * $g['total'];
					$g['ggprice'] = $g['seckillinfo']['price'] * $g['total'];
					$seckill_payprice += $g['seckillinfo']['price'] * $g['total'];
					$seckill_price += $g['marketprice'] * $g['total'] - $seckill_payprice;
				}
				else {
					$gprice = $g['marketprice'] * $g['total'];
					$prices = m('order')->getGoodsDiscountPrice($g, $level, 0, $this->getdefaultMembercardId());
					$g['ggprice'] = $prices['price'];
					$g['unitprice'] = $prices['unitprice'];
				}

				if ($is_openmerch == 1) {
					$merchid = $g['merchid'];
					$merch_array[$merchid]['ggprice'] += $g['ggprice'];
					$merchs[$merchid] += $g['ggprice'];
				}

				$g['dflag'] = intval($g['ggprice'] < $gprice);
				if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
				}
				else {
					if (empty($bargain_id)) {
						$taskdiscountprice += $prices['taskdiscountprice'];

						if ($this->getdefaultMembercardId()) {
							$lotterydiscountprice = 0;
						}
						else {
							$lotterydiscountprice += $prices['lotterydiscountprice'];
						}

						$card_lotterydiscountprice += $prices['lotterydiscountprice'];
						$g['taskdiscountprice'] = $prices['taskdiscountprice'];
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

						if ($threenprice && !empty($threenprice['price'])) {
							$discountprice += $g['marketprice'] - $threenprice['price'];
						}
						else {
							if ($threenprice && !empty($threenprice['discount'])) {
								$discountprice += (10 - $threenprice['discount']) / 10 * $g['marketprice'];
							}
						}

						$task_goods_data = m('goods')->getTaskGoods($openid, $id, $rank, $log_id, $join_id, $optionid);
						if ($task_goods_data['is_task_goods'] && $log_id && $this->getdefaultMembercardId()) {
							$g['is_task_goods'] = 0;
							$youxi_prices = m('order')->getGoodsDiscountPrice($g, $level);
							$g['discountprice'] = $youxi_prices['discountprice'];
							$g['isdiscountprice'] = $youxi_prices['isdiscountprice'];
							$g['discounttype'] = $youxi_prices['discounttype'];
							$g['isdiscountunitprice'] = $youxi_prices['isdiscountunitprice'];
							$g['discountunitprice'] = $youxi_prices['discountunitprice'];

							if ($youxi_prices['discounttype'] == 1) {
								$isdiscountprice += $youxi_prices['isdiscountprice'];
							}
							else {
								if ($youxi_prices['discounttype'] == 2) {
									$discountprice += $youxi_prices['discountprice'];
								}
							}
						}
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

				if (empty($bargain_id)) {
					if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
						$g['deduct'] = 0;
					}
					else {
						if (0 < floatval($g['buyagain']) && empty($g['buyagain_sale'])) {
							if (m('goods')->canBuyAgain($g)) {
								$g['deduct'] = 0;
							}
						}
					}

					if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
					}
					else {
						if ($open_redis) {
							if ($g['ggprice'] < $g['deduct']) {
								$g['deduct'] = $g['ggprice'];
							}

							if ($g['manydeduct']) {
								$deductprice += $g['deduct'] * $g['total'];
							}
							else {
								$deductprice += $g['deduct'];
							}

							$deccredit2 = 0;

							if ($g['deduct2'] == 0) {
								$deccredit2 = $g['ggprice'];
							}
							else {
								if (0 < $g['deduct2']) {
									$temp_ggprice = $g['ggprice'] / $g['total'];

									if ($temp_ggprice < $g['deduct2']) {
										$deccredit2 = $temp_ggprice;
									}
									else {
										$deccredit2 = $g['deduct2'];
									}
								}
							}

							if ($g['manydeduct2']) {
								$deccredit2 = $deccredit2 * $g['total'];
							}

							$deductprice2 += $deccredit2;
						}
					}
				}
			}

			unset($g);

			if ($isverify) {
				$storeids = array();
				$merchid = 0;

				foreach ($goods as $g) {
					$merchid = $g['merchid'];

					if (!empty($g['storeids'])) {
						$storeids = array_merge(explode(',', $g['storeids']), $storeids);
					}
				}

				if (empty($storeids)) {
					if (0 < $merchid) {
						$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where  uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
					}
					else {
						$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(2,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid']));
					}
				}
				else if (0 < $merchid) {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
				}
				else {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1 and type in(2,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid']));
				}
			}
			else {
				$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where openid=:openid and deleted=0 and isdefault=1  and uniacid=:uniacid limit 1', array(':uniacid' => $uniacid, ':openid' => $openid));

				if (!empty($carrier_list)) {
					$carrier = $carrier_list[0];
				}

				if (!$isvirtual && !$isonlyverifygoods) {
					$dispatch_array = m('order')->getOrderDispatchPrice($goods, $member, $address, $saleset, $merch_array, 0);
					$dispatch_price = $dispatch_array['dispatch_price'] - $dispatch_array['seckill_dispatch_price'];
					$seckill_dispatchprice = $dispatch_array['seckill_dispatch_price'];
				}
			}

			if ($is_openmerch == 1) {
				if (empty($bargain_id)) {
					$merch_enough = m('order')->getMerchEnough($merch_array);
					$merch_array = $merch_enough['merch_array'];
					$merch_enough_total = $merch_enough['merch_enough_total'];
					$merch_saleset = $merch_enough['merch_saleset'];

					if (0 < $merch_enough_total) {
						$realprice -= $merch_enough_total;
					}
				}
			}

			if ($saleset) {
				if (empty($bargain_id)) {
					foreach ($saleset['enoughs'] as $e) {
						if (floatval($e['enough']) <= $realprice - $seckill_payprice && 0 < floatval($e['money'])) {
							$saleset['showenough'] = true;
							$saleset['enoughmoney'] = $e['enough'];
							$saleset['enoughdeduct'] = $e['money'];
							$realprice -= floatval($e['money']);
							break;
						}
					}
				}

				$include_dispath = false;

				if (empty($saleset['dispatchnodeduct'])) {
					$deductprice2 += $dispatch_price;

					if (!empty($dispatch_price)) {
						$include_dispath = true;
					}
				}
			}

			$realprice += $dispatch_price + $seckill_dispatchprice;
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

					if ($realprice - $seckill_payprice < $deductmoney) {
						$deductmoney = $realprice - $seckill_payprice;
					}

					if ($pmoney * $pcredit != 0) {
						$deductcredit = ceil($deductmoney / $pmoney * $pcredit);
					}
				}

				if (!empty($saleset['moneydeduct'])) {
					$deductcredit2 = m('member')->getCredit($openid, 'credit2');

					if ($realprice - $seckill_payprice < $deductcredit2) {
						$deductcredit2 = $realprice - $seckill_payprice;
					}

					if ($deductprice2 < $deductcredit2) {
						$deductcredit2 = $deductprice2;
					}
				}
			}

			$goodsdata = array();
			$goodsdata_temp = array();
			$gifts = array();

			foreach ($goods as $g) {
				$goodsdata[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice'], 'type' => $g['type'], 'intervalfloor' => $g['intervalfloor'], 'intervalprice1' => $g['intervalprice1'], 'intervalnum1' => $g['intervalnum1'], 'intervalprice2' => $g['intervalprice2'], 'intervalnum2' => $g['intervalnum2'], 'intervalprice3' => $g['intervalprice3'], 'intervalnum3' => $g['intervalnum3'], 'wholesaleprice' => $g['wholesaleprice'], 'goodsalltotal' => $g['goodsalltotal'], 'isnodiscount' => $g['isnodiscount'], 'deduct' => $g['deduct'], 'deduct2' => $g['deduct2'], 'ggprice' => $g['ggprice'], 'manydeduct' => $g['manydeduct'], 'manydeduct2' => $g['manydeduct2']);
				if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
				}
				else if (0 < floatval($g['buyagain'])) {
					if (!m('goods')->canBuyAgain($g) || !empty($g['buyagain_sale'])) {
						$goodsdata_temp[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice'], 'type' => $g['type'], 'intervalfloor' => $g['intervalfloor'], 'intervalprice1' => $g['intervalprice1'], 'intervalnum1' => $g['intervalnum1'], 'intervalprice2' => $g['intervalprice2'], 'intervalnum2' => $g['intervalnum2'], 'intervalprice3' => $g['intervalprice3'], 'intervalnum3' => $g['intervalnum3'], 'wholesaleprice' => $g['wholesaleprice'], 'goodsalltotal' => $g['goodsalltotal'], 'isnodiscount' => $g['isnodiscount']);
					}
				}
				else {
					$goodsdata_temp[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice'], 'type' => $g['type'], 'intervalfloor' => $g['intervalfloor'], 'intervalprice1' => $g['intervalprice1'], 'intervalnum1' => $g['intervalnum1'], 'intervalprice2' => $g['intervalprice2'], 'intervalnum2' => $g['intervalnum2'], 'intervalprice3' => $g['intervalprice3'], 'intervalnum3' => $g['intervalnum3'], 'wholesaleprice' => $g['wholesaleprice'], 'goodsalltotal' => $g['goodsalltotal'], 'isnodiscount' => $g['isnodiscount']);
				}

				if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
				}
				else if ($g['isverify'] == 2) {
				}
				else if ($giftid) {
					$gift = array();
					$giftdata = pdo_fetch('select giftgoodsid from ' . tablename('ewei_shop_gift') . ' where uniacid = ' . $uniacid . ' and id = ' . $giftid . ' and status = 1 and starttime <= ' . time() . ' and endtime >= ' . time() . ' ');

					if ($giftdata['giftgoodsid']) {
						$giftgoodsid = explode(',', $giftdata['giftgoodsid']);

						foreach ($giftgoodsid as $key => $value) {
							$giftinfo = pdo_fetch('select id as goodsid,title,thumb from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and total > 0 and status = 2 and id = ' . $value . ' and deleted = 0 ');

							if ($giftinfo) {
								$gift[$key] = $giftinfo;
								$gift[$key]['total'] = 1;
							}
						}

						if ($gift) {
							$gift = array_filter($gift);
							$goodsdata = array_merge($goodsdata, $gift);
						}
					}
				}
				else {
					$isgift = 0;
					$giftgoods = array();
					$gift_price = array();
					$gifts = pdo_fetchall('select id,goodsid,giftgoodsid,thumb,title ,orderprice from ' . tablename('ewei_shop_gift') . '
                    where uniacid = ' . $uniacid . ' and status = 1 and starttime <= ' . time() . ' and endtime >= ' . time() . ' and orderprice <= ' . $goodsprice . ' and activity = 1 ');

					foreach ($gifts as $key => $value) {
						$giftgoods = explode(',', $value['giftgoodsid']);
						array_push($gift_price, $value['orderprice']);

						foreach ($giftgoods as $k => $val) {
							$giftgoodsdetail = pdo_fetch('select id,title,thumb,marketprice,total from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and deleted = 0 and status = 2 and id = ' . $val . ' ');

							if ($giftgoodsdetail) {
								$gifts[$key]['gift'][$k] = $giftgoodsdetail;
								$isgift = 1;
							}

							if ($giftgoodsdetail['total'] <= 0) {
								$gifts[$key]['canchose'] = 0;
							}
							else {
								$gifts[$key]['canchose'] = 1;
							}
						}

						$gifts = array_filter($gifts);
						$gifttitle = $gifts[$key]['gift'][$key]['title'] ? $gifts[$key]['gift'][$key]['title'] : '赠品';
					}
				}
			}

			if (!empty($gifts) && count($gifts) == 1) {
				$giftid = $gifts[0]['id'];
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

			if ($is_openmerch == 1) {
				$merchs = $merch_plugin->getMerchs($merch_array);
			}

			$createInfo = array('id' => $id, 'gdid' => intval($_GPC['gdid']), 'fromcart' => $fromcart, 'addressid' => !empty($address) && !$isverify && !$isvirtual ? $address['id'] : 0, 'storeid' => 0, 'couponcount' => $couponcount, 'coupon_goods' => $goodsdata_temp, 'isvirtual' => $isvirtual, 'isverify' => $isverify, 'isonlyverifygoods' => $isonlyverifygoods, 'isforceverifystore' => $isforceverifystore, 'goods' => $goodsdata, 'merchs' => $merchs, 'orderdiyformid' => $orderdiyformid, 'has_fields' => $has_fields, 'giftid' => $giftid, 'mustbind' => $mustbind, 'fromquick' => intval($quickid), 'liveid' => intval($card_live_id), 'new_area' => $new_area, 'address_street' => $address_street, 'city_express_state' => empty($dispatch_array['city_express_state']) ? 0 : $dispatch_array['city_express_state']);
			$buyagain = $buyagainprice;
		}
		else {
			$level = m('member')->getLevel($openid);
			$merchdata = $this->merchData();
			extract($merchdata);
			$merch_array = array();
			$merchs = array();
			$g = $_GPC['goods'];
			$g = json_decode(htmlspecialchars_decode($g, ENT_QUOTES), true);
			$package = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_package') . ' WHERE uniacid = ' . $uniacid . ' and id = ' . $packageid . ' ');
			$package = set_medias($package, array('thumb'));

			if (time() < $package['starttime']) {
				$this->message('套餐活动还未开始，请耐心等待!', '', 'error');
			}

			if ($package['endtime'] < time()) {
				$this->message('套餐活动已结束，谢谢您的关注，请浏览其他套餐或商品！', '', 'error');
			}

			$goods = array();
			$goodsprice = 0;
			$marketprice = 0;
			$allgoods = array();

			foreach ($g as $key => $value) {
				$tablename = tablename('ewei_shop_goods');
				$sql = '            SELECT id as goodsid,type,title,weight,issendfree,isnodiscount,isfullback,ispresell,presellprice,preselltimeend,presellsendstatrttime,presellsendtime,presellsendtype,
                  thumb,marketprice,storeids,isverify,isforceverifystore,deduct,
                  manydeduct,manydeduct2,`virtual`,maxbuy,usermaxbuy,discounts,total as stock,deduct2,showlevels,
                  ednum,edmoney,edareas,edareas_code,
                  diyformtype,diyformid,diymode,dispatchtype,dispatchid,dispatchprice,cates,minbuy, 
                  isdiscount,isdiscount_time,isdiscount_discounts,
                  virtualsend,invoice,needfollow,followtip,followurl,merchid,checked,merchsale,
                  buyagain,buyagain_islong,buyagain_condition, buyagain_sale from ' . $tablename . ' where id = ' . $value['goodsid'] . '  and uniacid = ' . $uniacid . ';';
				$goods[$key] = pdo_fetch($sql);

				if ($is_openmerch == 1) {
					$merchid = $goods[$key]['merchid'];
					$merch_array[$merchid]['goods'][] = $goods[$key]['id'];
				}

				$option = array();
				$packagegoods = array();

				if (0 < $value['optionid']) {
					$option = pdo_fetch('select title,packageprice,marketprice from ' . tablename('ewei_shop_package_goods_option') . '
                            where optionid = ' . $value['optionid'] . ' and goodsid=' . $value['goodsid'] . ' and uniacid = ' . $uniacid . ' and pid = ' . $packageid . ' ');
					$goods[$key]['packageprice'] = $option['packageprice'];
					$goods[$key]['marketprice'] = $option['marketprice'];
				}
				else {
					$packagegoods = pdo_fetch('select title,packageprice,marketprice from ' . tablename('ewei_shop_package_goods') . '
                            where goodsid=' . $value['goodsid'] . ' and uniacid = ' . $uniacid . ' and pid = ' . $packageid . ' ');
					$goods[$key]['packageprice'] = $packagegoods['packageprice'];
				}

				$goods[$key]['optiontitle'] = !empty($option['title']) ? $option['title'] : '';
				$goods[$key]['optionid'] = !empty($value['optionid']) ? $value['optionid'] : 0;
				$goods[$key]['goodsid'] = $value['goodsid'];
				$goods[$key]['total'] = 1;

				if ($option) {
					$goods[$key]['packageprice'] = $option['packageprice'];
				}
				else {
					$goods[$key]['packageprice'] = $goods[$key]['packageprice'];
				}

				if ($is_openmerch == 1) {
					$merch_array[$merchid]['ggprice'] += $goods[$key]['packageprice'];
				}

				$goodsprice += $goods[$key]['packageprice'];
				$marketprice += $goods[$key]['marketprice'];
			}

			$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where openid=:openid and deleted=0 and isdefault=1  and uniacid=:uniacid limit 1', array(':uniacid' => $uniacid, ':openid' => $openid));
			$total = count($goods);

			if (0 < $package['dispatchtype']) {
				$dispatch_array = m('order')->getOrderDispatchPrice($goods, $member, $address, false, $merch_array, 0);
				$dispatch_price = $dispatch_array['dispatch_price'] - $dispatch_array['seckill_dispatch_price'];
			}
			else {
				$dispatch_price = $package['freight'];
			}

			if ($packageid && $this->getdefaultMembercardId()) {
				$sale_plugin = com('sale');
				$saleset = false;
				if ($sale_plugin && $allow_sale) {
					$saleset = $_W['shopset']['sale'];
					$saleset['enoughs'] = $sale_plugin->getEnoughs();
				}

				$dispatch_array = m('order')->getOrderDispatchPrice($goods, $member, $address, $saleset, $merch_array, 0);
				$dispatch_price = $dispatch_array['dispatch_price'] - $dispatch_array['seckill_dispatch_price'];
			}

			$realprice = $goodsprice + $dispatch_price;
			$packprice = $goodsprice + $dispatch_price;
			$goodsprice = 0;
			$isdiscountprice = 0;
			$discountprice = 0;

			foreach ($goods as $key => &$value) {
				$prices = m('order')->getGoodsDiscountPrice($value, $level);
				$value['discountprice'] = $prices['discountprice'];
				$value['isdiscountprice'] = $prices['isdiscountprice'];
				$value['discounttype'] = $prices['discounttype'];
				$value['isdiscountunitprice'] = $prices['isdiscountunitprice'];
				$value['discountunitprice'] = $prices['discountunitprice'];

				if ($prices['discounttype'] == 1) {
					$isdiscountprice += $prices['isdiscountprice'];
				}
				else {
					if ($prices['discounttype'] == 2) {
						$discountprice += $prices['discountprice'];
					}
				}

				$goodsprice += $value['marketprice'];
			}

			unset($value);

			if ($this->getdefaultMembercardId()) {
				$packageid = 0;
			}

			$createInfo = array('id' => 0, 'gdid' => intval($_GPC['gdid']), 'fromcart' => 0, 'packageid' => $packageid, 'card_packageid' => $_GPC['packageid'], 'addressid' => $address['id'], 'storeid' => 0, 'couponcount' => 0, 'isvirtual' => 0, 'isverify' => 0, 'isonlyverifygoods' => 0, 'goods' => $goods, 'merchs' => $merchs, 'orderdiyformid' => 0, 'mustbind' => 0, 'fromquick' => intval($quickid), 'new_area' => $new_area, 'address_street' => $address_street);
		}

		$goods_list = array();

		if ($ismerch) {
			$getListUser = $merch_plugin->getListUser($goods);
			$merch_user = $getListUser['merch_user'];

			foreach ($getListUser['merch'] as $k => $v) {
				if (empty($merch_user[$k]['merchname'])) {
					$goods_list[$k]['shopname'] = $_W['shopset']['shop']['name'];
				}
				else {
					$goods_list[$k]['shopname'] = $merch_user[$k]['merchname'];
				}

				$goods_list[$k]['goods'] = $v;
			}
		}
		else {
			if ($merchid == 0) {
				$goods_list[0]['shopname'] = $_W['shopset']['shop']['name'];
			}
			else {
				$merch_data = $merch_plugin->getListUserOne($merchid);
				$goods_list[0]['shopname'] = $merch_data['merchname'];
			}

			$goods_list[0]['goods'] = $goods;
		}

		$_W['shopshare']['hideMenus'] = array('menuItem:share:qq', 'menuItem:share:QZone', 'menuItem:share:email', 'menuItem:copyUrl', 'menuItem:openWithSafari', 'menuItem:openWithQQBrowser', 'menuItem:share:timeline', 'menuItem:share:appMessage');

		if (p('exchange')) {
			$exchangecha = $goodsprice - $exchangeprice;
		}

		if ($taskgoodsprice) {
			$goodsprice = $taskgoodsprice;
		}

		$taskreward = $_SESSION['taskcut'];
		if ($taskreward && p('task')) {
			if ($this->getdefaultMembercardId()) {
				$taskcut = 0;
			}
			else {
				$taskcut = $goodsprice - $taskreward['price'];
			}

			$card_taskcut = $goodsprice - $taskreward['price'];
		}

		if ($this->getdefaultMembercardId()) {
			$taskreward = NULL;
		}

		if (!p('membercard')) {
			$show_card = false;
		}

		if (p('membercard')) {
			$my_card_list = p('membercard')->get_Mycard('', 0, 100);

			if (empty($my_card_list['list'])) {
				$show_card = false;
			}
		}

		$default_cardid = 0;
		if ($show_card && p('membercard')) {
			$default_cardid = $this->getdefaultMembercardId();
		}

		$createInfo['card_id'] = $default_cardid;
		$createInfo['taskcut'] = 0 < $card_taskcut ? $card_taskcut : 0;
		$createInfo['lotterydiscountprice'] = $card_lotterydiscountprice;
		$createInfo['discountprice'] = $discountprice;
		$createInfo['isdiscountprice'] = $isdiscountprice;
		$createInfo['deductenough_money'] = '';
		$createInfo['deductenough_enough'] = '';
		$createInfo['merch_deductenough_enough'] = $merch_saleset['merch_enoughmoney'];
		$createInfo['merch_deductenough_money'] = $merch_saleset['merch_enoughdeduct'];

		if (!empty($exchangeOrder)) {
			$createInfo['dispatch_price'] = $exchangepostage;
		}
		else if ($taskgoodsprice) {
			$createInfo['dispatch_price'] = $taskgoodsprice;
		}
		else {
			$createInfo['dispatch_price'] = $dispatch_price;
		}

		$createInfo['gift_price'] = is_array($gift_price) && empty($gift_price) != true ? min($gift_price) : 0;
		$createInfo['show_card'] = $show_card;
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
		$real_price = $_GPC['real_price'];
		$result = $this->caculatecoupon($contype, $couponid, $wxid, $wxcardid, $wxcode, $goodsarr, $goodsprice, $discountprice, $isdiscountprice, '', '', '', $real_price);

		if (empty($result)) {
			show_json(0);
		}
		else {
			show_json(1, $result);
		}
	}

	public function caculatecoupon($contype, $couponid, $wxid, $wxcardid, $wxcode, $goodsarr, $totalprice, $discountprice, $isdiscountprice, $isSubmit = 0, $discountprice_array = array(), $merchisdiscountprice = 0, $real_price = 0)
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
			$sql = 'select id,uniacid,card_type,logo_url,title, card_id,least_cost,reduce_cost,discount,merchid,limitgoodtype,limitgoodcatetype,limitgoodcateids,limitgoodids,merchid,limitdiscounttype  from ' . tablename('ewei_shop_wxcard');
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
			if ($real_price && $coupongoodprice == 0) {
				$coupongoodprice = $real_price;
			}

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
		$return_array['isdiscountprice'] = (double) $isdiscountprice;
		$return_array['discountprice'] = (double) $discountprice;
		$return_array['deductprice'] = (double) $deductprice;
		$return_array['coupongoodprice'] = (double) $coupongoodprice;
		$return_array['coupondeduct_text'] = $coupondeduct_text;
		$return_array['totalprice'] = (double) $totalprice;
		$return_array['discountprice_array'] = $discountprice_array;
		$return_array['merchisdiscountprice'] = $merchisdiscountprice;
		$return_array['couponmerchid'] = $merchid;
		$return_array['$goodsarr'] = $goodsarr;
		return $return_array;
	}

	public function caculate()
	{
		global $_W;
		global $_GPC;
		$open_redis = function_exists('redis') && !is_error(redis());
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$card_id = intval($_GPC['card_id']);
		$packageid = intval($_GPC['packageid']);
		$merchdata = $this->merchData();
		extract($merchdata);
		$merch_array = array();
		$allow_sale = true;
		$realprice = 0;
		$nowsendfree = false;
		$isverify = false;
		$isseckill = false;
		$isvirtual = false;
		$taskdiscountprice = 0;
		$carddiscountprice = 0;
		$lotterydiscountprice = 0;
		$discountprice = 0;
		$isdiscountprice = 0;
		$deductprice = 0;
		$deductprice2 = 0;
		$deductcredit2 = 0;
		$buyagain_sale = true;
		$isonlyverifygoods = true;
		$buyagainprice = 0;
		$seckill_price = 0;
		$seckill_payprice = 0;
		$seckill_dispatchprice = 0;
		$liveid = intval($_GPC['liveid']);
		if (p('live') && !empty($liveid)) {
			$isliving = p('live')->isLiving($liveid);

			if (!$isliving) {
				$liveid = 0;
			}
		}

		if (!empty($packageid)) {
			$package = pdo_fetch('SELECT id,title,price,freight,cash,starttime,endtime,dispatchtype FROM ' . tablename('ewei_shop_package') . '
                    WHERE uniacid = ' . $uniacid . ' and id = ' . $packageid . ' and deleted = 0 and status = 1  ORDER BY id DESC');
		}

		$dispatchid = intval($_GPC['dispatchid']);
		$totalprice = floatval($_GPC['totalprice']);
		$dflag = $_GPC['dflag'];
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
					$nowsendfree = true;
				}

				$sql = 'SELECT id as goodsid,title,type, weight,total,issendfree,isnodiscount, thumb,marketprice,cash,isverify,isforceverifystore,goodssn,productsn,sales,istime,' . ' timestart,timeend,usermaxbuy,maxbuy,unit,buylevels,buygroups,deleted,status,deduct,ispresell,preselltimeend,manydeduct,manydeduct2,`virtual`,' . ' discounts,deduct2,ednum,edmoney,edareas,edareas_code,diyformid,diyformtype,diymode,dispatchtype,dispatchid,dispatchprice,presellprice,' . ' isdiscount,isdiscount_time,isdiscount_discounts ,virtualsend,merchid,merchsale,' . ' buyagain,buyagain_islong,buyagain_condition, buyagain_sale,bargain,unite_total,islive,liveprice' . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
				$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $goodsid));
				$data['seckillinfo'] = plugin_run('seckill::getSeckill', $goodsid, $optionid, true, $_W['openid']);
				if (0 < $data['ispresell'] && ($data['preselltimeend'] == 0 || time() < $data['preselltimeend'])) {
					$data['marketprice'] = $data['presellprice'];
				}

				if (!empty($liveid)) {
					$isLiveGoods = p('live')->isLiveGoods($data['goodsid'], $liveid);

					if (!empty($isLiveGoods)) {
						if (0 < intval($_GPC['card_id'])) {
							$live_product = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_goods') . (' WHERE id = \'' . $data['goodsid'] . '\''));

							if ($live_product) {
								$data['marketprice'] = $live_product['marketprice'];
							}
						}
						else {
							$data['marketprice'] = price_format($isLiveGoods['liveprice']);
						}
					}
				}

				if (empty($data)) {
					$nowsendfree = true;
				}

				if ($data['status'] == 2) {
					$data['marketprice'] = 0;
				}

				if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
					$data['is_task_goods'] = 0;
				}
				else {
					if (p('task')) {
						$task_id = intval($_SESSION[$goodsid . '_task_id']);

						if (!empty($task_id)) {
							$rewarded = pdo_fetchcolumn('SELECT `rewarded` FROM ' . tablename('ewei_shop_task_extension_join') . ' WHERE id = :id AND openid = :openid AND uniacid = :uniacid', array(':id' => $task_id, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
							$taskGoodsInfo = unserialize($rewarded);
							$taskGoodsInfo = $taskGoodsInfo['goods'][$goodsid];
							if (!empty($optionid) && !empty($taskGoodsInfo['option']) && $optionid == $taskGoodsInfo['option']) {
								$taskgoodsprice = $taskGoodsInfo['price'];
							}
							else {
								if (empty($optionid)) {
									$taskgoodsprice = $taskGoodsInfo['price'];
								}
							}
						}
					}

					$rank = intval($_SESSION[$goodsid . '_rank']);
					$log_id = intval($_SESSION[$goodsid . '_log_id']);
					$join_id = intval($_SESSION[$goodsid . '_join_id']);
					$task_goods_data = m('goods')->getTaskGoods($openid, $goodsid, $rank, $log_id, $join_id, $optionid);

					if (empty($task_goods_data['is_task_goods'])) {
						$data['is_task_goods'] = 0;
					}
					else {
						$allow_sale = false;
						$data['is_task_goods'] = $task_goods_data['is_task_goods'];
						$data['is_task_goods_option'] = $task_goods_data['is_task_goods_option'];
						$data['task_goods'] = $task_goods_data['task_goods'];
					}
				}

				$data['stock'] = $data['total'];
				$data['total'] = $goodstotal;

				if (!empty($optionid)) {
					$option = pdo_fetch('select id,title,marketprice,presellprice,goodssn,productsn,stock,`virtual`,weight,liveprice,islive from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $goodsid, ':id' => $optionid));

					if (!empty($option)) {
						$data['optionid'] = $optionid;
						$data['optiontitle'] = $option['title'];
						$data['marketprice'] = 0 < intval($data['ispresell']) && (time() < $data['preselltimeend'] || $data['preselltimeend'] == 0) ? $option['presellprice'] : $option['marketprice'];

						if (!empty($liveid)) {
							$liveOption = p('live')->getLiveOptions($data['goodsid'], $liveid, array($option));

							if (0 < $_GPC['card_id']) {
								$gopdata = m('goods')->getOption($data['goodsid'], $optionid);

								if (empty($gopdata) != true) {
									$data['marketprice'] = price_format($gopdata['marketprice']);
								}
							}
							else {
								if (!empty($liveOption) && !empty($liveOption[0])) {
									$data['marketprice'] = price_format($liveOption[0]['marketprice']);
								}
							}
						}

						if (empty($data['unite_total'])) {
							$data['stock'] = $option['stock'];
						}

						if (!empty($option['weight'])) {
							$data['weight'] = $option['weight'];
						}
					}
				}

				if ($data['type'] == 4) {
					$data['marketprice'] = $g['wholesaleprice'];
					$data['wholesaleprice'] = $g['wholesaleprice'];
				}

				if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
					$data['ggprice'] = $data['seckillinfo']['price'] * $g['total'];
					$seckill_payprice += $data['ggprice'];
					$seckill_price += $data['marketprice'] * $g['total'];
				}
				else {
					$prices = m('order')->getGoodsDiscountPrice($data, $level);
					$data['ggprice'] = $prices['price'];
				}

				if ($is_openmerch == 1) {
					$merchid = $data['merchid'];
					$merch_array[$merchid]['goods'][] = $data['goodsid'];
					$merch_array[$merchid]['ggprice'] += $data['ggprice'];
				}

				if ($data['isverify'] == 2) {
					$isverify = true;
				}

				if (!empty($data['virtual']) || $data['type'] == 2 || $data['type'] == 3 || $data['type'] == 20) {
					$isvirtual = true;
				}

				if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
					$g['taskdiscountprice'] = 0;
					$g['lotterydiscountprice'] = 0;
					$g['discountprice'] = 0;
					$g['isdiscountprice'] = 0;
					$g['discounttype'] = 0;
					$isseckill = true;
				}
				else {
					$g['taskdiscountprice'] = $prices['taskdiscountprice'];
					$g['lotterydiscountprice'] = $prices['lotterydiscountprice'];
					$g['discountprice'] = $prices['discountprice'];
					$g['isdiscountprice'] = $prices['isdiscountprice'];
					$g['discounttype'] = $prices['discounttype'];
					$taskdiscountprice += $prices['taskdiscountprice'];
					$lotterydiscountprice += $prices['lotterydiscountprice'];
					$buyagainprice += $prices['buyagainprice'];
				}

				if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0 || $_SESSION['taskcut']) {
				}
				else if ($prices['discounttype'] == 1) {
					$isdiscountprice += $prices['isdiscountprice'];
				}
				else {
					if ($prices['discounttype'] == 2) {
						$discountprice += $prices['discountprice'];
					}
				}

				if (!empty($_SESSION['bargain_id']) && p('bargain')) {
					$discountprice = 0;
				}

				$realprice += $data['ggprice'];
				$allgoods[] = $data;
				if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
				}
				else {
					if (0 < floatval($g['buyagain']) && empty($g['buyagain_sale'])) {
						if (m('goods')->canBuyAgain($g)) {
							$buyagain_sale = false;
						}
					}
				}

				if (p('bargain')) {
					$bargain_act_id = pdo_fetchall('SELECT *  FROM ' . tablename('ewei_shop_bargain_goods') . (' WHERE goods_id = \'' . $g['goodsid'] . '\' and status = 0'));

					if (!empty($bargain_act_id)) {
						$allow_sale = false;
					}
				}
			}

			unset($g);

			if ($is_openmerch == 1) {
				foreach ($merch_array as $key => $value) {
					if (0 < $key) {
						$merch_array[$key]['set'] = $merch_plugin->getSet('sale', $key);
						$merch_array[$key]['enoughs'] = $merch_plugin->getEnoughs($merch_array[$key]['set']);
					}
				}
			}

			$sale_plugin = com('sale');
			$saleset = false;
			if ($sale_plugin && $buyagain_sale && $allow_sale) {
				$saleset = $_W['shopset']['sale'];
				$saleset['enoughs'] = $sale_plugin->getEnoughs();
			}

			foreach ($allgoods as $g) {
				if ($g['type'] != 5) {
					$isonlyverifygoods = false;
				}

				if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
					$g['deduct'] = 0;
				}
				else {
					if (0 < floatval($g['buyagain']) && empty($g['buyagain_sale'])) {
						if (m('goods')->canBuyAgain($g)) {
							$g['deduct'] = 0;
						}
					}
				}

				if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
				}
				else {
					if ($open_redis) {
						if ($g['ggprice'] < $g['deduct']) {
							$g['deduct'] = $g['ggprice'];
						}

						if ($g['manydeduct']) {
							$deductprice += $g['deduct'] * $g['total'];
						}
						else {
							$deductprice += $g['deduct'];
						}

						$deccredit2 = 0;

						if ($g['deduct2'] == 0) {
							$deccredit2 = $g['ggprice'];
						}
						else {
							if (0 < $g['deduct2']) {
								$temp_ggprice = $g['ggprice'] / $g['total'];

								if ($temp_ggprice < $g['deduct2']) {
									$deccredit2 = $temp_ggprice;
								}
								else {
									$deccredit2 = $g['deduct2'];
								}
							}
						}

						if ($g['manydeduct2']) {
							$deccredit2 = $deccredit2 * $g['total'];
						}

						$deductprice2 += $deccredit2;
					}
				}
			}

			if ($isverify || $isvirtual) {
				$nowsendfree = true;
			}

			if (!empty($allgoods) && !$nowsendfree && !$isonlyverifygoods) {
				$dispatch_array = m('order')->getOrderDispatchPrice($allgoods, $member, $address, $saleset, $merch_array, 1);
				$dispatch_price = $dispatch_array['dispatch_price'] - $dispatch_array['seckill_dispatch_price'];
				$nodispatch_array = $dispatch_array['nodispatch_array'];
				$seckill_dispatchprice = $dispatch_array['seckill_dispatch_price'];
			}

			if (!empty($packageid)) {
				if ($package['dispatchtype'] == 1) {
					$dispatch_array = m('order')->getOrderDispatchPrice($allgoods, $member, $address, false, $merch_array, 0);
					$dispatch_price = $dispatch_array['dispatch_price'] - $dispatch_array['seckill_dispatch_price'];
				}
				else {
					$dispatch_price = $package['freight'];
				}
			}

			$return_card_array = $this->caculatecard($card_id, $dispatch_price, $lotterydiscountprice, '', $goodsarr, $totalprice, $discountprice, $isdiscountprice, '', 1);

			if (empty($return_card_array) != true) {
				if ($return_card_array['shipping'] == 1) {
					$include_dispath = 0;
					$nowsendfree = true;
					$dispatch_price = 0;
				}
			}

			if (empty($return_card_array) != true) {
				$deductprice2 = $return_card_array['cardgoodprice'];
				$realprice = $return_card_array['cardgoodprice'];
			}

			if ($is_openmerch == 1) {
				$merch_enough = m('order')->getMerchEnough($merch_array);
				$merch_array = $merch_enough['merch_array'];
				$merch_enough_total = $merch_enough['merch_enough_total'];
				$merch_saleset = $merch_enough['merch_saleset'];

				if (0 < $merch_enough_total) {
					$realprice -= $merch_enough_total;
				}
			}

			if ($saleset) {
				foreach ($saleset['enoughs'] as $e) {
					if (floatval($e['enough']) <= $realprice - $seckill_payprice && 0 < floatval($e['money'])) {
						$deductenough_money = floatval($e['money']);
						$deductenough_enough = floatval($e['enough']);
						$realprice -= floatval($e['money']);
						break;
					}
				}
			}

			if ($dflag != '1') {
				$include_dispath = 0;

				if (empty($saleset['dispatchnodeduct'])) {
					$deductprice2 += $dispatch_price;

					if (!empty($dispatch_price)) {
						$include_dispath = 1;
					}
				}
			}

			$goodsdata_coupon = array();

			foreach ($allgoods as $g) {
				if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
				}
				else if (0 < floatval($g['buyagain'])) {
					if (!m('goods')->canBuyAgain($g) || !empty($g['buyagain_sale'])) {
						$goodsdata_coupon[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice'], 'type' => $g['type'], 'wholesaleprice' => $g['wholesaleprice']);
					}
				}
				else {
					$goodsdata_coupon[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice'], 'type' => $g['type'], 'wholesaleprice' => $g['wholesaleprice']);
				}
			}

			$couponcount = com_run('coupon::consumeCouponCount', $openid, $realprice - $seckill_payprice, $merch_array, $goodsdata_coupon);
			$couponcount += com_run('wxcard::consumeWxCardCount', $openid, $merch_array, $goodsdata_coupon);
			if (empty($goodsdata_coupon) || !$allow_sale) {
				$couponcount = 0;
			}

			$realprice += $dispatch_price + $seckill_dispatchprice;

			if ($liveid) {
				$realprice += $discountprice + $isdiscountprice;
				$discountprice = 0;
				$isdiscountprice = 0;
			}

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

					if ($realprice - $seckill_payprice < $deductmoney) {
						$deductmoney = $realprice - $seckill_payprice;
					}

					$deductcredit = ceil($pmoney * $pcredit == 0 ? 0 : $deductmoney / $pmoney * $pcredit);
				}

				if (!empty($saleset['moneydeduct'])) {
					$deductcredit2 = $member['credit2'];

					if ($realprice - $seckill_payprice < $deductcredit2) {
						$deductcredit2 = $realprice - $seckill_payprice;
					}

					if ($deductprice2 < $deductcredit2) {
						$deductcredit2 = $deductprice2;
					}
				}
			}
		}

		if ($is_openmerch == 1) {
			$merchs = $merch_plugin->getMerchs($merch_array);
		}

		$giftid = intval($_GPC['giftid']);
		$isgift = 0;
		if (!$giftid && !$isverify && !$isseckill) {
			$goodsprice = $data['marketprice'] * $data['total'];
			$gifts = pdo_fetchall('select id,goodsid,giftgoodsid,thumb,title ,orderprice from ' . tablename('ewei_shop_gift') . '
                    where uniacid = ' . $uniacid . ' and status = 1 and starttime <= ' . time() . ' and endtime >= ' . time() . ' and orderprice <= ' . $goodsprice . ' and activity = 1 ');

			foreach ($gifts as $key => $value) {
				$giftgoods = explode(',', $value['giftgoodsid']);

				foreach ($giftgoods as $k => $val) {
					$giftgoodsdetail = pdo_fetch('select id,title,thumb,marketprice,total from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and deleted = 0 and status = 2 and id = ' . $val . ' ');

					if ($giftgoodsdetail) {
						$isgift = 1;
					}
				}

				$gifts = array_filter($gifts);
			}
		}

		$return_array = array();
		$return_array['isgift'] = $isgift;
		$return_array['price'] = $dispatch_price + $seckill_dispatchprice;
		$return_array['couponcount'] = $couponcount;
		$return_array['realprice'] = $realprice;
		$return_array['deductenough_money'] = $deductenough_money;
		$return_array['deductenough_enough'] = $deductenough_enough;
		$return_array['deductcredit2'] = $deductcredit2;
		$return_array['include_dispath'] = $include_dispath;
		$return_array['deductcredit'] = $deductcredit;
		$return_array['deductmoney'] = $deductmoney;
		$return_array['taskdiscountprice'] = $taskdiscountprice;
		$return_array['lotterydiscountprice'] = $lotterydiscountprice;
		$return_array['discountprice'] = $discountprice;
		$return_array['isdiscountprice'] = $isdiscountprice;
		$return_array['merch_showenough'] = $merch_saleset['merch_showenough'];
		$return_array['merch_deductenough_money'] = $merch_saleset['merch_enoughdeduct'];
		$return_array['merch_deductenough_enough'] = $merch_saleset['merch_enoughmoney'];
		$return_array['merchs'] = $merchs;
		$return_array['buyagain'] = $buyagainprice;
		$return_array['seckillprice'] = $seckill_price - $seckill_payprice;
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
		$real_price = $_GPC['real_price'];
		$cardid = intval($_GPC['card_id']);
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = $_W['uniacid'] . '_order_submit_' . $openid;
			$redis = redis();

			if (!is_error($redis)) {
				if ($redis->setnx($redis_key, time())) {
					$redis->expireAt($redis_key, time() + 2);
				}
				else if ($redis->get($redis_key) + 2 < time()) {
					$redis->del($redis_key);
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

		if (p('quick') && !empty($_GPC['fromquick'])) {
			$_GPC['fromcart'] = 0;
		}

		if (!empty($_W['shopset']['wap']['open']) && !empty($_W['shopset']['wap']['mustbind']) && empty($member['mobileverify'])) {
			$sendtime = $_SESSION['verifycodesendtime'];
			if (empty($sendtime) || $sendtime + 60 < time()) {
				$endtime = 0;
			}
			else {
				$endtime = 60 - (time() - $sendtime);
			}

			show_json(3, array('endtime' => $endtime, 'imgcode' => $_W['shopset']['wap']['smsimgcode']));
		}

		$allow_sale = true;
		$packageid = intval($_GPC['packageid']);
		$package = array();
		$packgoods = array();
		$packageprice = 0;

		if (!empty($packageid)) {
			$package = pdo_fetch('SELECT id,title,price,freight,cash,starttime,endtime,dispatchtype FROM ' . tablename('ewei_shop_package') . '
                    WHERE uniacid = ' . $uniacid . ' and id = ' . $packageid . ' and deleted = 0 and status = 1  ORDER BY id DESC');

			if (empty($package)) {
				show_json(0, '未找到套餐！');
			}

			if (time() < $package['starttime']) {
				show_json(0, '套餐活动未开始，请耐心等待！');
			}

			if ($package['endtime'] < time()) {
				show_json(0, '套餐活动已结束，谢谢您的关注，请您浏览其他套餐或商品！');
			}

			$packgoods = pdo_fetchall('SELECT id,title,thumb,packageprice,`option`,goodsid FROM ' . tablename('ewei_shop_package_goods') . '
                    WHERE uniacid = ' . $uniacid . ' and pid = ' . $packageid . '  ORDER BY id DESC');

			if (empty($packgoods)) {
				show_json(0, '未找到套餐商品！');
			}
		}

		if (0 < $cardid) {
			$packageid = 0;
		}

		$data = $this->diyformData($member);
		extract($data);
		$merchdata = $this->merchData();
		extract($merchdata);
		$merch_array = array();
		$ismerch = 0;
		$discountprice_array = array();
		$level = m('member')->getLevel($openid);
		$dispatchid = intval($_GPC['dispatchid']);
		$dispatchtype = intval($_GPC['dispatchtype']);
		$carrierid = intval($_GPC['carrierid']);
		$goods = $_GPC['goods'];
		$goods[0]['bargain_id'] = $_SESSION['bargain_id'];
		$_SESSION['bargain_id'] = NULL;

		if (!empty($goods[0]['bargain_id'])) {
			$allow_sale = false;
		}

		$sql = 'SELECT diyformtype,diyfields,bargain,diyformid FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
		$diyinfo = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $goods[0]['goodsid']));
		if (empty($goods) || !is_array($goods)) {
			show_json(0, '未找到任何商品');
		}

		$liveid = intval($_GPC['liveid']);
		if (p('live') && !empty($liveid)) {
			$isliving = p('live')->isLiving($liveid);

			if (!$isliving) {
				$liveid = 0;
			}
		}

		$allgoods = array();
		$task_reward_goods = array();
		$tgoods = array();
		$totalprice = 0;
		$goodsprice = 0;
		$grprice = 0;
		$weight = 0;
		$taskdiscountprice = 0;
		$lotterydiscountprice = 0;
		$discountprice = 0;
		$isdiscountprice = 0;
		$merchisdiscountprice = 0;
		$cash = 1;
		$deductprice = 0;
		$deductprice2 = 0;
		$virtualsales = 0;
		$dispatch_price = 0;
		$seckill_price = 0;
		$seckill_payprice = 0;
		$seckill_dispatchprice = 0;
		$buyagain_sale = true;
		$buyagainprice = 0;
		$sale_plugin = com('sale');
		$saleset = false;
		if ($sale_plugin && $allow_sale) {
			$saleset = $_W['shopset']['sale'];

			if ($packageid) {
				$saleset['enoughs'] = '';
			}
			else {
				$saleset['enoughs'] = $sale_plugin->getEnoughs();
			}
		}

		$isvirtual = false;
		$isverify = false;
		$isonlyverifygoods = true;
		$isendtime = 0;
		$endtime = 0;
		$verifytype = 0;
		$isvirtualsend = false;
		$couponmerchid = 0;
		$total_array = array();
		$giftid = intval($_GPC['giftid']);

		if ($giftid) {
			$gift = array();
			$giftdata = pdo_fetch('select giftgoodsid from ' . tablename('ewei_shop_gift') . ' where uniacid = ' . $uniacid . ' and id = ' . $giftid . ' and status = 1 and starttime <= ' . time() . ' and endtime >= ' . time() . ' ');

			if ($giftdata['giftgoodsid']) {
				$giftgoodsid = explode(',', $giftdata['giftgoodsid']);

				foreach ($giftgoodsid as $key => $value) {
					$giftinfo = pdo_fetch('select id as goodsid,title,thumb from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and status = 2 and total>0 and id = ' . $value . ' and deleted = 0 ');

					if (empty($giftinfo)) {
						continue;
					}

					$gift[$key] = $giftinfo;
					$gift[$key]['giftStatus'] = 1;
				}

				$gift = array_filter($gift);

				if (!empty($gift)) {
					$goods = array_merge($goods, $gift);
				}
			}
		}

		foreach ($goods as $g) {
			if (empty($g)) {
				continue;
			}

			$goodsid = intval($g['goodsid']);
			$goodstotal = intval($g['total']);
			$total_array[$goodsid]['total'] += $goodstotal;
		}

		if (p('threen')) {
			$threenvip = p('threen')->getMember($_W['openid']);

			if (!empty($threenvip)) {
				$threenprice = true;
			}
		}

		$goods = m('goods')->wholesaleprice($goods);
		$need_deduct_num = 0;
		$need_deduct2_num = 0;

		foreach ($goods as $g) {
			if (empty($g)) {
				continue;
			}

			$goodsid = intval($g['goodsid']);
			array_push($task_reward_goods, $goodsid);
			$optionid = intval($g['optionid']);
			$goodstotal = intval($g['total']);

			if ($goodstotal < 1) {
				$goodstotal = 1;
			}

			if (empty($goodsid)) {
				show_json(0, '参数错误');
			}

			if (p('exchange')) {
				$sql_condition = 'exchange_stock,';
			}
			else {
				$sql_condition = '';
			}

			$threensql = '';
			if (p('threen') && !empty($threenprice)) {
				$threensql .= ',threen';
			}

			$sql = 'SELECT id as goodsid,' . $sql_condition . 'title,type,intervalfloor,intervalprice, weight,total,issendfree,isnodiscount, thumb,marketprice,liveprice,cash,isverify,isforceverifystore,verifytype,' . ' goodssn,productsn,sales,istime,timestart,timeend,hasoption,isendtime,usetime,endtime,ispresell,presellprice,preselltimeend,' . ' usermaxbuy,minbuy,maxbuy,unit,buylevels,buygroups,deleted,unite_total,' . ' status,deduct,manydeduct,manydeduct2,`virtual`,discounts,deduct2,ednum,edmoney,edareas,edareas_code,diyformtype,diyformid,diymode,' . ' dispatchtype,dispatchid,dispatchprice,merchid,merchsale,cates,' . ' isdiscount,isdiscount_time,isdiscount_discounts, virtualsend,' . ' buyagain,buyagain_islong,buyagain_condition, buyagain_sale ,verifygoodslimittype,verifygoodslimitdate  ' . $threensql . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
			$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $goodsid));
			$data['seckillinfo'] = plugin_run('seckill::getSeckill', $goodsid, $optionid, true, $_W['openid']);
			if (0 < $data['ispresell'] && ($data['preselltimeend'] == 0 || time() < $data['preselltimeend'])) {
				$data['marketprice'] = $data['presellprice'];
			}

			if ($data['type'] != 5) {
				$isonlyverifygoods = false;
			}
			else {
				if (!empty($data['verifygoodslimittype'])) {
					$verifygoodslimitdate = intval($data['verifygoodslimitdate']);

					if ($verifygoodslimitdate < time()) {
						show_json(0, '商品:"' . $data['title'] . '"的使用时间已失效,无法购买!');
					}

					if ($verifygoodslimitdate - 1800 < time()) {
						show_json(0, '商品:"' . $data['title'] . '"的使用时间即将失效,无法购买!');
					}
				}
			}

			if (!empty($liveid)) {
				$isLiveGoods = p('live')->isLiveGoods($data['goodsid'], $liveid);

				if (!empty($isLiveGoods)) {
					if (intval($_GPC['card_id'])) {
						$live_product = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_goods') . (' WHERE id = \'' . $data['goodsid'] . '\''));

						if ($live_product) {
							$data['marketprice'] = $live_product['marketprice'];
						}
					}
					else {
						$data['marketprice'] = price_format($isLiveGoods['liveprice']);
					}
				}
			}

			if ($data['status'] == 2) {
				$data['marketprice'] = 0;
			}

			if (!empty($_SESSION['exchange']) && p('exchange')) {
				if (empty($data['status']) || !empty($data['deleted'])) {
					show_json(0, $data['title'] . '<br/> 已下架!');
				}
			}

			if (!empty($data['hasoption'])) {
				$opdata = m('goods')->getOption($data['goodsid'], $optionid);
				if (empty($opdata) || empty($optionid)) {
					show_json(0, '商品' . $data['title'] . '的规格不存在,请到购物车删除该商品重新选择规格!');
				}
			}

			$rank = intval($_SESSION[$goodsid . '_rank']);
			$log_id = intval($_SESSION[$goodsid . '_log_id']);
			$join_id = intval($_SESSION[$goodsid . '_join_id']);

			if (p('task')) {
				$task_id = intval($_SESSION[$goodsid . '_task_id']);

				if (!empty($task_id)) {
					$rewarded = pdo_fetchcolumn('SELECT `rewarded` FROM ' . tablename('ewei_shop_task_extension_join') . ' WHERE id = :id AND openid = :openid AND uniacid = :uniacid', array(':id' => $task_id, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
					$taskGoodsInfo0 = unserialize($rewarded);
					$taskGoodsInfo = $taskGoodsInfo0['goods'][$goodsid];
					if (!empty($optionid) && !empty($taskGoodsInfo['option']) && $optionid == $taskGoodsInfo['option']) {
						$taskgoodsprice = $taskGoodsInfo['price'];
					}
					else {
						if (empty($optionid)) {
							$taskgoodsprice = $taskGoodsInfo['price'];
						}
					}
				}
			}

			if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0 || 0 < $_GPC['card_id']) {
				$data['is_task_goods'] = 0;
				$tgoods = false;
			}
			else {
				$task_goods_data = m('goods')->getTaskGoods($openid, $goodsid, $rank, $log_id, $join_id, $optionid);

				if (p('lottery')) {
					$lottery_id = pdo_get('ewei_shop_lottery_log', array('log_id' => $log_id), array('lottery_id'));

					if ($lottery_id['lottery_id']) {
						$is_goods = pdo_get('ewei_shop_lottery', array('lottery_id' => $lottery_id['lottery_id']), array('is_goods'));
						$is_goods = $is_goods['is_goods'];
					}
				}

				if (empty($task_goods_data['is_task_goods'])) {
					$data['is_task_goods'] = 0;
				}
				else {
					$allow_sale = false;
					$tgoods['title'] = $data['title'];
					$tgoods['openid'] = $openid;
					$tgoods['goodsid'] = $goodsid;
					$tgoods['optionid'] = $optionid;
					$tgoods['total'] = $goodstotal;
					$data['is_task_goods'] = $task_goods_data['is_task_goods'];
					$data['is_task_goods_option'] = $task_goods_data['is_task_goods_option'];
					$data['task_goods'] = $task_goods_data['task_goods'];
				}
			}

			$merchid = $data['merchid'];
			$merch_array[$merchid]['goods'][] = $data['goodsid'];

			if (0 < $merchid) {
				$ismerch = 1;
			}

			$virtualid = $data['virtual'];
			$data['stock'] = $data['total'];
			$data['total'] = $goodstotal;

			if ($data['cash'] != 2) {
				$cash = 0;
			}

			if (!empty($packageid)) {
				$cash = $package['cash'];
			}

			$unit = empty($data['unit']) ? '件' : $data['unit'];
			if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
				$check_buy = plugin_run('seckill::checkBuy', $data['seckillinfo'], $data['title'], $data['unit']);

				if (is_error($check_buy)) {
					show_json(-1, $check_buy['message']);
				}
			}
			else {
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

				if (!empty($data['is_task_goods'])) {
					if ($data['task_goods']['total'] < $goodstotal) {
						show_json(0, $data['title'] . '<br/> 任务活动优惠限购 ' . $data['task_goods']['total'] . $unit . '!');
					}
				}

				if ($data['istime'] == 1) {
					if (time() < $data['timestart']) {
						show_json(0, $data['title'] . '<br/> 限购时间未到!');
					}

					if ($data['timeend'] < time()) {
						show_json(0, $data['title'] . '<br/> 限购时间已过!');
					}
				}

				$levelid = intval($member['level']);

				if (empty($member['groupid'])) {
					$groupid = array();
				}
				else {
					$groupid = explode(',', $member['groupid']);
				}

				if ($data['buylevels'] != '') {
					$buylevels = explode(',', $data['buylevels']);

					if (!in_array($levelid, $buylevels)) {
						show_json(0, '您的会员等级无法购买<br/>' . $data['title'] . '!');
					}
				}

				if ($data['buygroups'] != '') {
					if (empty($groupid)) {
						$groupid[] = 0;
					}

					$buygroups = explode(',', $data['buygroups']);
					$intersect = array_intersect($groupid, $buygroups);

					if (empty($intersect)) {
						show_json(0, '您所在会员组无法购买<br/>' . $data['title'] . '!');
					}
				}
			}

			if (p('exchange')) {
				$sql_condition = ',exchange_stock';
			}
			else {
				$sql_condition = '';
			}

			if ($data['type'] == 4) {
				if (!empty($g['wholesaleprice'])) {
					$data['wholesaleprice'] = intval($g['wholesaleprice']);
				}

				if (!empty($g['goodsalltotal'])) {
					$data['goodsalltotal'] = intval($g['goodsalltotal']);
				}

				$data['marketprice'] == 0;
				$intervalprice = iunserializer($data['intervalprice']);

				foreach ($intervalprice as $intervalprice) {
					if ($intervalprice['intervalnum'] <= $data['goodsalltotal']) {
						$data['marketprice'] = $intervalprice['intervalprice'];
					}
				}

				if ($data['marketprice'] == 0) {
					show_json(0, $data['title'] . '<br/> ' . $data['minbuy'] . $unit . '起批!');
				}
			}

			if (!empty($optionid)) {
				$option = pdo_fetch('select id,title,marketprice,liveprice,presellprice,goodssn,productsn,stock,`virtual`,weight' . $sql_condition . ' from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $goodsid, ':id' => $optionid));

				if (!empty($option)) {
					if (!empty($_SESSION['exchange']) && p('exchange')) {
						if ($option['exchange_stock'] <= 0) {
							show_json(-1, $data['title'] . '<br/>' . $option['title'] . ' 库存不足!');
						}
						else {
							pdo_query('UPDATE ' . tablename('ewei_shop_goods_option') . ' SET exchange_stock = exchange_stock - 1 WHERE id = :id AND uniacid = :uniacid', array(':id' => $optionid, ':uniacid' => $_W['uniacid']));
						}
					}
					else {
						if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
						}
						else {
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
						}
					}

					$data['optionid'] = $optionid;
					$data['optiontitle'] = $option['title'];

					if ($data['type'] != 4) {
						$data['marketprice'] = 0 < intval($data['ispresell']) && (time() < $data['preselltimeend'] || $data['preselltimeend'] == 0) ? $option['presellprice'] : $option['marketprice'];

						if (!empty($liveid)) {
							$liveOption = p('live')->getLiveOptions($data['goodsid'], $liveid, array($option));

							if ($_GPC['card_id']) {
								$gopdata = m('goods')->getOption($data['goodsid'], $optionid);

								if (empty($gopdata) != true) {
									$data['marketprice'] = price_format($gopdata['marketprice']);
								}
							}
							else {
								if (!empty($liveOption) && !empty($liveOption[0])) {
									$data['marketprice'] = price_format($liveOption[0]['marketprice']);
								}
							}
						}

						$packageoption = array();

						if ($packageid) {
							$packageoption = pdo_fetch('select packageprice ,marketprice from ' . tablename('ewei_shop_package_goods_option') . '
                                where uniacid = ' . $uniacid . ' and goodsid = ' . $goodsid . ' and optionid = ' . $optionid . ' and pid = ' . $packageid . ' ');
							$data['marketprice'] = $packageoption['packageprice'];

							if (0 < $cardid) {
								$packageprice += $packageoption['marketprice'];
							}
							else {
								$packageprice += $packageoption['packageprice'];
							}
						}
					}

					$virtualid = $option['virtual'];

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
			}
			else {
				if ($packageid) {
					if (empty($g['giftStatus'])) {
						$pg = pdo_fetch('select packageprice,marketprice from ' . tablename('ewei_shop_package_goods') . '
                                    where uniacid = ' . $uniacid . ' and goodsid = ' . $goodsid . ' and pid = ' . $packageid . ' ');
						$data['marketprice'] = $pg['packageprice'];

						if (0 < $cardid) {
							$packageprice += $pg['marketprice'];
						}
						else {
							$packageprice += $pg['packageprice'];
						}
					}
					else {
						if ($data['stock'] != -1) {
							if (empty($data['stock'])) {
								show_json(0, $data['title'] . '<br/>库存不足!');
							}
						}
					}
				}

				if (!empty($_SESSION['exchange']) && p('exchange')) {
					if (0 < $data['exchange_stock']) {
						pdo_query('UPDATE ' . tablename('ewei_shop_goods') . ' SET exchange_stock = exchange_stock - 1 WHERE id = :id AND uniacid = :uniacid', array(':id' => $data['goodsid'], ':uniacid' => $_W['uniacid']));
					}
					else {
						if ($data['status'] != 2) {
							show_json(0, $data['title'] . ' 库存不足!');
						}
					}
				}
				else {
					if ($data['stock'] != -1) {
						if (empty($data['stock'])) {
							show_json(0, $data['title'] . '<br/>库存不足!');
						}
					}
				}
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

			if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
				$data['ggprice'] = $gprice = $data['seckillinfo']['price'] * $goodstotal;
				$seckill_payprice += $gprice;
				$seckill_price += $data['marketprice'] * $goodstotal - $gprice;
				$goodsprice += $data['marketprice'] * $goodstotal;
				$data['taskdiscountprice'] = 0;
				$data['lotterydiscountprice'] = 0;
				$data['discountprice'] = 0;
				$data['discountprice'] = 0;
				$data['discounttype'] = 0;
				$data['isdiscountunitprice'] = 0;
				$data['discountunitprice'] = 0;
				$data['price0'] = 0;
				$data['price1'] = 0;
				$data['price2'] = 0;
				$data['buyagainprice'] = 0;
			}
			else {
				if (0 < intval($_GPC['card_id'])) {
					$data['lotterydiscountprice'] = 0;
					$data['isdiscountunitprice'] = 0;
					$data['discountunitprice'] = 0;
					$data['taskdiscountprice'] = 0;
				}

				$gprice = $data['marketprice'] * $goodstotal;
				$goodsprice += $gprice;
				$prices = m('order')->getGoodsDiscountPrice($data, $level, 0, $cardid);

				if (empty($packageid)) {
					$data['ggprice'] = $prices['price'];
				}
				else {
					$data['ggprice'] = $data['marketprice'];
				}

				$data['taskdiscountprice'] = $prices['taskdiscountprice'];
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
				$taskdiscountprice += $prices['taskdiscountprice'];
				$lotterydiscountprice += $prices['lotterydiscountprice'];

				if ($prices['discounttype'] == 1) {
					$isdiscountprice += $prices['isdiscountprice'];

					if (!empty($data['merchsale'])) {
						$merchisdiscountprice += $prices['isdiscountprice'];
						$discountprice_array[$merchid]['merchisdiscountprice'] += $prices['isdiscountprice'];
					}

					$discountprice_array[$merchid]['isdiscountprice'] += $prices['isdiscountprice'];
				}
				else {
					if ($prices['discounttype'] == 2) {
						$discountprice += $prices['discountprice'];
						$discountprice_array[$merchid]['discountprice'] += $prices['discountprice'];
					}
				}

				$discountprice_array[$merchid]['ggprice'] += $prices['ggprice'];
			}

			$threenprice = json_decode($data['threen'], 1);
			if ($threenprice && !empty($threenprice['price'])) {
				$data['ggprice'] -= $data['price0'] - $threenprice['price'];
			}
			else {
				if ($threenprice && !empty($threenprice['discount'])) {
					$data['ggprice'] -= (10 - $threenprice['discount']) / 10 * $data['price0'];
				}
			}

			$merch_array[$merchid]['ggprice'] += $data['ggprice'];
			$totalprice += $data['ggprice'];
			if ($data['isverify'] == 2 && $data['type'] != 3) {
				$isverify = true;
				$verifytype = $data['verifytype'];
				$isendtime = $data['isendtime'];

				if ($isendtime == 0) {
					if (0 < $data['usetime']) {
						$endtime = time() + 3600 * 24 * intval($data['usetime']);
					}
					else {
						$endtime = 0;
					}
				}
				else {
					$endtime = $data['endtime'];
				}
			}

			if (!empty($data['virtual']) || $data['type'] == 2 || $data['type'] == 3 || $data['type'] == 20) {
				$isvirtual = true;
				if ($data['type'] == 20 && p('ccard')) {
					$ccard = 1;
				}

				if ($data['virtualsend']) {
					$isvirtualsend = true;
				}
			}

			if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
			}
			else {
				if (0 < floatval($data['buyagain']) && empty($data['buyagain_sale'])) {
					if (m('goods')->canBuyAgain($data)) {
						$data['deduct'] = 0;
						$saleset = false;
					}
				}

				if ($open_redis) {
					if ($data['ggprice'] < $data['deduct']) {
						$data['deduct'] = $data['ggprice'];
					}

					$deduct_price = 0;

					if ($data['manydeduct']) {
						$deduct_price = $data['deduct'] * $data['total'];
					}
					else {
						$deduct_price = $data['deduct'];
					}

					$deductprice += $deduct_price;
					$deduct_price2 = 0;

					if ($data['deduct2'] == 0) {
						$deduct_price2 = $data['ggprice'];
					}
					else {
						if (0 < $data['deduct2']) {
							$temp_ggprice = $data['ggprice'] / $data['total'];

							if ($temp_ggprice < $data['deduct2']) {
								$deduct_price2 = $temp_ggprice;
							}
							else {
								$deduct_price2 = $data['deduct2'];
							}
						}
					}

					if ($data['manydeduct2']) {
						$deduct_price2 = $deduct_price2 * $data['total'];
					}

					$deductprice2 += $deduct_price2;
				}

				if (!empty($deduct_price)) {
					++$need_deduct_num;
				}

				if (!empty($deduct_price2)) {
					++$need_deduct2_num;
				}

				$data['need_deduct'] = $deduct_price;
				$data['need_deduct2'] = $deduct_price2;
			}

			$virtualsales += $data['sales'];
			$allgoods[] = $data;
		}

		$grprice = $totalprice;
		isset($_SESSION['exchangeprice']) && $grprice = $_SESSION['exchangeprice'];
		if (1 < count($goods) && !empty($tgoods)) {
			show_json(0, '任务活动优惠商品' . $tgoods['title'] . '不能放入购物车下单,请单独购买');
		}

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

			if (empty($ref)) {
				show_json(0, '卡券分权出错!');
			}

			if (!is_wxerror($ref)) {
				$ref = com_run('wxcard::wxCardConsume', $wxcode, $wxcardid);
				if (empty($ref) || is_wxerror($ref)) {
					show_json(0, '您的卡券未到使用日期或已经超出使用次数限制!');
				}
			}
			else {
				show_json(0, '您的卡券未到使用日期或已经超出使用次数限制!');
			}
		}

		if (0 < $cardid) {
			$lotterydiscountprice = 0;
		}

		if (p('membercard')) {
			$card_data = p('membercard')->getMemberCard($cardid);
		}

		if (!empty($card_data)) {
			if ($card_data['discount'] == 0 || $card_data['discount_rate'] <= 0) {
				$totalprice = $totalprice + $isdiscountprice;
				$isdiscountprice = 0;
			}
		}

		$return_card_array = $this->caculatecard($cardid, $dispatch_price, $lotterydiscountprice, '', $allgoods, $totalprice, $discountprice, $isdiscountprice, '', 1);
		$carddeductprice = 0;

		if (!empty($return_card_array)) {
			$totalprice = $return_card_array['totalprice'];
			$carddeductprice = $return_card_array['carddeductprice'];
			$deductprice2 = $return_card_array['cardgoodprice'];
		}

		if ($is_openmerch == 1) {
			foreach ($merch_array as $key => $value) {
				if (0 < $key) {
					$merch_array[$key]['set'] = $merch_plugin->getSet('sale', $key);

					if (!$packageid) {
						$merch_array[$key]['set'] = $merch_plugin->getSet('sale', $key);
						$merch_array[$key]['enoughs'] = $merch_plugin->getEnoughs($merch_array[$key]['set']);
					}
				}
			}

			if ($allow_sale && empty($_SESSION['taskcut'])) {
				$merch_enough = m('order')->getMerchEnough($merch_array);
				$merch_array = $merch_enough['merch_array'];
				$merch_enough_total = $merch_enough['merch_enough_total'];
				$merch_saleset = $merch_enough['merch_saleset'];

				if (0 < $merch_enough_total) {
					$totalprice -= $merch_enough_total;
				}
			}
		}

		$deductenough = 0;

		if ($saleset['enoughs']) {
			foreach ($saleset['enoughs'] as $e) {
				if (floatval($e['enough']) <= $totalprice - $seckill_payprice && 0 < floatval($e['money'])) {
					$deductenough = floatval($e['money']);

					if ($totalprice - $seckill_payprice < $deductenough) {
						$deductenough = $totalprice - $seckill_payprice;
					}

					break;
				}
			}
		}

		$goodsdata_coupon = array();
		$goodsdata_coupon_temp = array();
		$max_goods_need_deduct = 0;
		$max_goods_need_deduct2 = 0;

		foreach ($allgoods as &$g) {
			$g['consume_deduct'] = 0;
			if (!empty($_GPC['deduct']) && !empty($saleset['creditdeduct']) && !empty($g['need_deduct'])) {
				$credit1 = $member['credit1'];

				if (0 < $credit1) {
					$credit1 = floor($credit1);
				}

				$pcredit = intval($saleset['credit']);
				$pmoney = round(floatval($saleset['money']), 2);
				$order_need_deduct = ceil($deductprice / ($pcredit * $pmoney));
				$goods_need_deduct = floor($g['need_deduct'] / ($pcredit * $pmoney));

				if ($credit1 < $order_need_deduct) {
					$g['consume_deduct'] = floor($credit1 * ($goods_need_deduct / $order_need_deduct));
				}
				else {
					$g['consume_deduct'] = $goods_need_deduct;
				}

				if ($need_deduct_num == 1) {
					if ($credit1 < $order_need_deduct) {
						$g['consume_deduct'] = $credit1 - $max_goods_need_deduct;
					}
					else {
						$g['consume_deduct'] = $order_need_deduct - $max_goods_need_deduct;
					}
				}

				--$need_deduct_num;
				$max_goods_need_deduct += $g['consume_deduct'];
			}

			$g['consume_deduct2'] = 0;
			if (!empty($_GPC['deduct2']) && !empty($saleset['moneydeduct']) && !empty($g['need_deduct2'])) {
				$credit2 = $member['credit2'];
				$order_need_deduct2 = $deductprice2;
				$goods_need_deduct2 = floor($g['need_deduct2']);

				if ($credit2 < $order_need_deduct2) {
					$g['consume_deduct2'] = floor($credit2 * ($goods_need_deduct2 / $order_need_deduct2));
				}
				else {
					$g['consume_deduct2'] = $goods_need_deduct2;
				}

				if ($need_deduct2_num == 1) {
					if ($credit2 < $order_need_deduct2) {
						$g['consume_deduct2'] = $credit2 - $max_goods_need_deduct2;
					}
					else {
						$g['consume_deduct2'] = $order_need_deduct2 - $max_goods_need_deduct2;
					}
				}

				--$need_deduct2_num;
				$max_goods_need_deduct2 += $g['consume_deduct2'];
			}

			if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
				$goodsdata_coupon_temp[] = $g;
			}
			else if (0 < floatval($g['buyagain'])) {
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

		unset($g);
		if (0 < $liveid && $cardid <= 0) {
			$totalprice += $discountprice + $isdiscountprice;
			$discountprice = 0;
			$isdiscountprice = 0;
		}

		$totalprice -= $deductenough;
		$return_array = $this->caculatecoupon($contype, $couponid, $wxid, $wxcardid, $wxcode, $goodsdata_coupon, $totalprice, $discountprice, $isdiscountprice, 1, $discountprice_array, $merchisdiscountprice, $totalprice);
		$couponprice = 0;
		$coupongoodprice = 0;

		if (!empty($return_array)) {
			$isdiscountprice = $return_array['isdiscountprice'];
			$discountprice = $return_array['discountprice'];
			$couponprice = $return_array['deductprice'];
			$totalprice = $return_array['totalprice'];
			$discountprice_array = $return_array['discountprice_array'];
			$merchisdiscountprice = $return_array['merchisdiscountprice'];
			$coupongoodprice = $return_array['coupongoodprice'];
			$couponmerchid = $return_array['couponmerchid'];
			$allgoods = $return_array['$goodsarr'];
			$allgoods = array_merge($allgoods, $goodsdata_coupon_temp);
		}

		$addressid = intval($_GPC['addressid']);
		$address = false;
		if (!empty($addressid) && $dispatchtype == 0 && !$isonlyverifygoods) {
			$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where id=:id and openid=:openid and uniacid=:uniacid   limit 1', array(':uniacid' => $uniacid, ':openid' => $openid, ':id' => $addressid));

			if (empty($address)) {
				show_json(0, '未找到地址');
			}
			else {
				if (empty($address['province']) || empty($address['city'])) {
					show_json(0, '地址请选择省市信息');
				}

				$area_set = m('util')->get_area_config_set();
				$new_area = intval($area_set['new_area']);

				if (!empty($new_area)) {
					if (empty($address['datavalue']) || trim($address['datavalue'] == 'null null null')) {
						show_json(-1, '地址库信息已升级，需要您重新编辑保存您的地址');
					}
				}
			}
		}

		if (!$isvirtual && !$isverify && !$isonlyverifygoods && $dispatchtype == 0 && !$isonlyverifygoods) {
			if (empty($addressid)) {
				show_json(0, '请选择地址');
			}

			$dispatch_array = m('order')->getOrderDispatchPrice($allgoods, $member, $address, $saleset, $merch_array, 2);
			$dispatch_price = $dispatch_array['dispatch_price'] - $dispatch_array['seckill_dispatch_price'];
			$seckill_dispatchprice = $dispatch_array['seckill_dispatch_price'];
			$nodispatch_array = $dispatch_array['nodispatch_array'];

			if (!empty($nodispatch_array['isnodispatch'])) {
				show_json(0, $nodispatch_array['nodispatch']);
			}
		}

		if ($isonlyverifygoods) {
			$addressid = 0;
		}

		if (!empty($return_card_array) && $return_card_array['shipping'] == 1) {
			$dispatch_price = 0;
		}

		$totalprice += $dispatch_price + $seckill_dispatchprice;
		if ($saleset && empty($saleset['dispatchnodeduct'])) {
			$deductprice2 += $dispatch_price;
		}

		if (empty($goods[0]['bargain_id'])) {
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

						if ($totalprice - $seckill_payprice < $deductmoney) {
							$deductmoney = $totalprice - $seckill_payprice;
						}

						$deductcredit = ceil($deductmoney / $pmoney * $pcredit);
					}
				}

				$totalprice -= $deductmoney;
			}

			if (!empty($saleset['moneydeduct'])) {
				if (!empty($_GPC['deduct2'])) {
					$deductcredit2 = $member['credit2'];

					if ($totalprice - $seckill_payprice < $deductcredit2) {
						$deductcredit2 = $totalprice - $seckill_payprice;
					}

					if ($deductprice2 < $deductcredit2) {
						$deductcredit2 = $deductprice2;
					}
				}

				$totalprice -= $deductcredit2;
			}
		}

		$verifyinfo = array();
		$verifycode = '';
		$verifycodes = array();
		if (($isverify || $dispatchtype) && !$isonlyverifygoods) {
			if ($isverify) {
				if ($verifytype == 0 || $verifytype == 1) {
					$verifycode = random(8, true);

					while (1) {
						$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where verifycode=:verifycode and uniacid=:uniacid limit 1', array(':verifycode' => $verifycode, ':uniacid' => $_W['uniacid']));

						if ($count <= 0) {
							break;
						}

						$verifycode = random(8, true);
					}
				}
				else {
					if ($verifytype == 2) {
						$totaltimes = intval($allgoods[0]['total']);

						if ($totaltimes <= 0) {
							$totaltimes = 1;
						}

						$i = 1;

						while ($i <= $totaltimes) {
							$verifycode = random(8, true);

							while (1) {
								$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where concat(verifycodes,\'|\' + verifycode +\'|\' ) like :verifycodes and uniacid=:uniacid limit 1', array(':verifycodes' => '%' . $verifycode . '%', ':uniacid' => $_W['uniacid']));

								if ($count <= 0) {
									break;
								}

								$verifycode = random(8, true);
							}

							$verifycodes[] = '|' . $verifycode . '|';
							$verifyinfo[] = array('verifycode' => $verifycode, 'verifyopenid' => '', 'verifytime' => 0, 'verifystoreid' => 0);
							++$i;
						}
					}
				}
			}
			else {
				if ($dispatchtype) {
					$verifycode = random(8, true);

					while (1) {
						$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where verifycode=:verifycode and uniacid=:uniacid limit 1', array(':verifycode' => $verifycode, ':uniacid' => $_W['uniacid']));

						if ($count <= 0) {
							break;
						}

						$verifycode = random(8, true);
					}
				}
			}
		}

		$carrier = $_GPC['carriers'];
		$carriers = is_array($carrier) ? iserializer($carrier) : iserializer(array());

		if ($totalprice <= 0) {
			$totalprice = 0;
		}

		if ($ismerch == 0 || $ismerch == 1 && count($merch_array) == 1) {
			$multiple_order = 0;
		}
		else {
			$multiple_order = 1;
		}

		if (0 < $ismerch) {
			$ordersn = m('common')->createNO('order', 'ordersn', 'ME');
		}
		else {
			$ordersn = m('common')->createNO('order', 'ordersn', 'SH');
		}

		if (!empty($goods[0]['bargain_id']) && p('bargain')) {
			$bargain_act = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_actor') . ' WHERE id = :id AND openid = :openid ', array(':id' => $goods[0]['bargain_id'], ':openid' => $_W['openid']));

			if (empty($bargain_act)) {
				exit('没有这个商品');
			}

			if ($_SESSION['taskcut']) {
				$dispatch_price = 0;
			}

			$totalprice = $bargain_act['now_price'] + $dispatch_price;
			$goodsprice = $bargain_act['now_price'];

			if (!pdo_update('ewei_shop_bargain_actor', array('status' => 1), array('id' => $goods[0]['bargain_id'], 'openid' => $_W['openid']))) {
				exit('下单失败');
			}

			$ordersn = substr_replace($ordersn, 'KJ', 0, 2);
		}

		$is_package = 0;

		if (!empty($packageid)) {
			$goodsprice = $packageprice;

			if ($package['dispatchtype'] == 1) {
				$dispatch_array = m('order')->getOrderDispatchPrice($allgoods, $member, $address, false, $merch_array, 0);
				$dispatch_price = $dispatch_array['dispatch_price'] - $dispatch_array['seckill_dispatch_price'];
			}
			else {
				$dispatch_price = $package['freight'];
			}

			$totalprice = $packageprice + $dispatch_price;
			if (0 < $cardid && p('membercard')) {
				$card_data = p('membercard')->getMemberCard($cardid);

				if (empty($card_data) != true) {
					if ($card_data['discount'] == 0) {
						$totalprice = $totalprice + $discountprice + $isdiscountprice;
						$discountprice = 0;
						$isdiscountprice = 0;
					}
				}

				$return_card_array = $this->caculatecard($cardid, $dispatch_price, $lotterydiscountprice, '', $allgoods, $totalprice, $discountprice, $isdiscountprice, '', 1);
				$carddeductprice = 0;

				if (!empty($return_card_array)) {
					$totalprice = $return_card_array['totalprice'];
				}
			}

			$is_package = 1;
			$discountprice = 0;
		}

		if ($taskgoodsprice) {
			$totalprice = $taskgoodsprice;
			$goodsprice = $taskgoodsprice;

			if ($taskGoodsInfo0['goods'][$goodsid]['num'] <= 1) {
				unset($taskGoodsInfo0['goods'][$goodsid]);
			}
			else {
				--$taskGoodsInfo0['goods'][$goodsid]['num'];
			}

			pdo_update('ewei_shop_task_extension_join', array('rewarded' => serialize($taskGoodsInfo0)), array('id' => $task_id, 'uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
			unset($_SESSION[$goodsid . '_task_id']);
		}

		$order = array();
		$order['ismerch'] = $ismerch;
		$order['parentid'] = 0;
		$order['uniacid'] = $uniacid;
		$order['openid'] = $openid;
		$order['ordersn'] = $ordersn;
		$order['price'] = $totalprice;
		$order['oldprice'] = $totalprice;
		$order['grprice'] = $grprice;
		$order['taskdiscountprice'] = $taskdiscountprice;

		if ($_SESSION['taskcut']) {
			$order['taskdiscountprice'] = $order['price'] - $_SESSION['taskcut']['price'];
		}

		$order['lotterydiscountprice'] = $lotterydiscountprice;
		$order['discountprice'] = $discountprice;
		if (!empty($goods[0]['bargain_id']) && p('bargain')) {
			$order['discountprice'] = 0;
		}

		$order['isdiscountprice'] = $isdiscountprice;
		$order['merchisdiscountprice'] = $merchisdiscountprice;
		$order['cash'] = $cash;
		$order['status'] = 0;
		$order['remark'] = trim($_GPC['remark']);
		$order['addressid'] = empty($dispatchtype) ? $addressid : 0;
		$order['goodsprice'] = $goodsprice;
		$order['dispatchprice'] = $dispatch_price + $seckill_dispatchprice;
		if (!is_null($_SESSION['exchangeprice']) && !empty($_SESSION['exchange']) && p('exchange')) {
			if ($_GPC['dispatchtype'] === '1') {
				$_SESSION['exchangepostage'] = 0;
			}

			$order['price'] = $_SESSION['exchangeprice'] + $_SESSION['exchangepostage'];
			$order['ordersn'] = m('common')->createNO('order', 'ordersn', 'DH');
			$order['goodsprice'] = $_SESSION['exchangeprice'];
			$order['dispatchprice'] = $_SESSION['exchangepostage'];
		}

		$taskreward = $_SESSION['taskcut'];
		$_SESSION['taskcut'] = NULL;
		if ($taskreward['reward_data'] == $goodsid && p('task') || in_array($taskreward['reward_data'], $task_reward_goods) && p('task')) {
			if (0 < $cardid) {
				$order['price'] = $return_card_array['totalprice'] + $dispatch_price;
			}
			else {
				$order['price'] = $taskreward['price'] + $dispatch_price;
				$order['goodsprice'] = $taskreward['price'];
				$order['dispatchprice'] = $dispatch_price;
				$deductenough = 0;
				$order['discountprice'] = 0;
				$order['isdiscountprice'] = 0;
			}

			p('task')->setTaskRewardGoodsSent($taskreward['id']);
		}

		if (empty($return_card_array) != true && $return_card_array['shipping'] == 1) {
			$dispatch_price = 0;
			$seckill_dispatchprice = 0;
			$order['dispatchprice'] = 0;
			$order['price'] = $totalprice - $dispatch_price - $seckill_dispatchprice;
		}

		if (!empty($_SESSION['exchange']) && p('exchange')) {
			$deductenough = 0;
		}

		$order['dispatchtype'] = $dispatchtype;
		$order['dispatchid'] = $dispatchid;
		$order['storeid'] = $carrierid;
		$order['carrier'] = $carriers;
		$order['createtime'] = time();
		$order['olddispatchprice'] = $dispatch_price + $seckill_dispatchprice;
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
		$order['merchdeductenough'] = $merch_enough_total;
		$order['couponprice'] = $couponprice;
		$order['merchshow'] = 0;
		$order['buyagainprice'] = $buyagainprice;
		$order['ispackage'] = $is_package;
		$order['packageid'] = $packageid;
		$order['seckilldiscountprice'] = $seckill_price;
		$order['quickid'] = intval($_GPC['fromquick']);
		$order['officcode'] = intval($_GPC['officcode']);
		$order['liveid'] = $liveid;

		if (!empty($ccard)) {
			$order['ccard'] = 1;
		}

		$author = p('author');

		if ($author) {
			$author_set = $author->getSet();
			if (!empty($member['agentid']) && !empty($member['authorid'])) {
				$order['authorid'] = $member['authorid'];
			}

			if (!empty($author_set['selfbuy']) && !empty($member['isauthor']) && !empty($member['authorstatus'])) {
				$order['authorid'] = $member['id'];
			}
		}

		if ($multiple_order == 0) {
			$order_merchid = current(array_keys($merch_array));
			$order['merchid'] = intval($order_merchid);
			$order['isparent'] = 0;
			$order['transid'] = '';
			$order['isverify'] = $isverify ? 1 : 0;
			$order['verifytype'] = $verifytype;
			$order['verifyendtime'] = $endtime;
			$order['verifycode'] = $verifycode;
			$order['verifycodes'] = implode('', $verifycodes);
			$order['verifyinfo'] = iserializer($verifyinfo);
			$order['virtual'] = $virtualid;
			$order['isvirtual'] = $isvirtual ? 1 : 0;
			$order['isvirtualsend'] = $isvirtualsend ? 1 : 0;
			$order['invoicename'] = trim($_GPC['invoicename']);
			$order['coupongoodprice'] = $coupongoodprice;
			$order['city_express_state'] = empty($dispatch_array['city_express_state']) == true ? 0 : $dispatch_array['city_express_state'];
		}
		else {
			$order['isparent'] = 1;
			$order['merchid'] = 0;
		}

		if (!empty($diyinfo) && 0 < $diyinfo['bargain']) {
			if ($diyinfo['diyformtype'] == 1) {
				$order_formInfo = $diyform_plugin->getDiyformInfo($diyinfo['diyformid']);
				$fields = $order_formInfo['fields'];
				$diyform_data = $diyform_plugin->getInsertData($fields, $_GPC['diydata']);
				$idata = $diyform_data['data'];
				$order['diyformfields'] = iserializer($fields);
				$order['diyformdata'] = $idata;
				$order['diyformid'] = $diyinfo['diyformid'];
			}
			else {
				if ($diyinfo['diyformtype'] == 2) {
					$fields = unserialize($diyinfo['diyfields']);
					$diyform_data = $diyform_plugin->getInsertData($fields, $_GPC['diydata']);
					$idata = $diyform_data['data'];
					$order['diyformfields'] = iserializer($fields);
					$order['diyformdata'] = $idata;
					$order['diyformid'] = '999999999';
				}
			}
		}
		else {
			if ($diyform_plugin) {
				if (is_array($_GPC['diydata']) && !empty($order_formInfo)) {
					$diyform_data = $diyform_plugin->getInsertData($fields, $_GPC['diydata']);
					$idata = $diyform_data['data'];
					$order['diyformfields'] = iserializer($fields);
					$order['diyformdata'] = $idata;
					$order['diyformid'] = $order_formInfo['id'];
				}
			}
		}

		if (!empty($address)) {
			$order['address'] = iserializer($address);
		}

		list(, $payment) = m('common')->public_build();

		if ($payment['type'] == '4') {
			$order['ordersn2'] = 100;
		}

		pdo_insert('ewei_shop_order', $order);
		$orderid = pdo_insertid();

		if (function_exists('redis_setarr')) {
			$redis_order = $order;
			$redis_order['id'] = $orderid;
			redis_setarr($_W['uniacid'] . '_order_' . $orderid, $redis_order);
		}

		if (!empty($return_card_array) && $orderid) {
			if (p('membercard')) {
				p('membercard')->member_card_use_record($orderid, $cardid, $carddeductprice, $_W['openid']);
			}
		}

		if (!empty($goods[0]['bargain_id']) && p('bargain')) {
			pdo_update('ewei_shop_bargain_actor', array('order' => $orderid), array('id' => $goods[0]['bargain_id'], 'openid' => $_W['openid']));
		}

		if ($multiple_order == 0) {
			$exchangepriceset = $_SESSION['exchangepriceset'];
			$exchangetitle = '';

			foreach ($allgoods as $goods) {
				$order_goods = array();
				if (!empty($bargain_act) && p('bargain')) {
					$goods['total'] = 1;
					$goods['ggprice'] = $bargain_act['now_price'];
					pdo_query('UPDATE ' . tablename('ewei_shop_goods') . ' SET sales = sales + 1 WHERE id = :id AND uniacid = :uniacid', array(':id' => $goods['goodsid'], ':uniacid' => $uniacid));
				}

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
				$order_goods['title'] = $goods['title'];
				$order_goods['goodssn'] = $goods['goodssn'];
				$order_goods['productsn'] = $goods['productsn'];
				$order_goods['realprice'] = $goods['ggprice'];
				$order_goods['consume'] = iserializer(array('consume_deduct' => $goods['consume_deduct'], 'consume_deduct2' => $goods['consume_deduct2']));
				$isfullback = $this->isfullbackgoods($goods['goodsid'], $goods['optionid']);
				$order_goods['fullbackid'] = $isfullback;
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

				if ($goods['seckillinfo'] && $goods['seckillinfo']['status'] == 0) {
					$order_goods['seckill'] = 1;
					$order_goods['seckill_taskid'] = $goods['seckillinfo']['taskid'];
					$order_goods['seckill_roomid'] = $goods['seckillinfo']['roomid'];
					$order_goods['seckill_timeid'] = $goods['seckillinfo']['timeid'];
					if (!empty($goods['seckillinfo']['options']) && $goods['seckillinfo']['options'][0]['timeid'] != $order_goods['seckill_timeid']) {
						$order_goods['seckill_timeid'] = $goods['seckillinfo']['options'][0]['timeid'];
					}
				}

				if (count($allgoods) == 1 && 0 < $order['couponprice']) {
					$order_goods['realprice'] = $order_goods['realprice'] - $order['couponprice'];
				}

				pdo_insert('ewei_shop_order_goods', $order_goods);
				if ($goods['seckillinfo'] && $goods['seckillinfo']['status'] == 0) {
					plugin_run('seckill::setSeckill', $goods['seckillinfo'], $goods, $_W['openid'], $orderid, 0, $order['createtime']);
				}
			}
		}
		else {
			$og_array = array();
			$ch_order_data = m('order')->getChildOrderPrice($order, $allgoods, $dispatch_array, $merch_array, $sale_plugin, $discountprice_array, $orderid);

			foreach ($merch_array as $key => $value) {
				$merchid = $key;
				$is_exchange = p('exchange') && $_SESSION['exchange'];

				if ($is_exchange) {
					$order_head = 'DH';
				}
				else if (!empty($merchid)) {
					$order_head = 'ME';
				}
				else {
					$order_head = 'SH';
				}

				$order['ordersn'] = m('common')->createNO('order', 'ordersn', $order_head);
				$order['merchid'] = $merchid;
				$order['parentid'] = $orderid;
				$order['isparent'] = 0;
				$order['merchshow'] = 1;
				$order['dispatchprice'] = $dispatch_array['dispatch_merch'][$merchid];
				$order['olddispatchprice'] = $dispatch_array['dispatch_merch'][$merchid];

				if (empty($packageid)) {
					$order['merchisdiscountprice'] = $discountprice_array[$merchid]['merchisdiscountprice'];
					$order['isdiscountprice'] = $discountprice_array[$merchid]['isdiscountprice'];
					$order['discountprice'] = $discountprice_array[$merchid]['discountprice'];
				}

				$order['price'] = $ch_order_data[$merchid]['price'];
				$order['grprice'] = $ch_order_data[$merchid]['grprice'];
				$order['goodsprice'] = $ch_order_data[$merchid]['goodsprice'];
				$order['deductprice'] = $ch_order_data[$merchid]['deductprice'];
				$order['deductcredit'] = $ch_order_data[$merchid]['deductcredit'];
				$order['deductcredit2'] = $ch_order_data[$merchid]['deductcredit2'];
				$order['merchdeductenough'] = $ch_order_data[$merchid]['merchdeductenough'];
				$order['deductenough'] = $ch_order_data[$merchid]['deductenough'];
				$order['coupongoodprice'] = $discountprice_array[$merchid]['coupongoodprice'];
				$order['couponprice'] = $discountprice_array[$merchid]['deduct'];

				if (empty($order['couponprice'])) {
					$order['couponid'] = 0;
					$order['couponmerchid'] = 0;
				}
				else {
					if (0 < $couponmerchid) {
						if ($merchid == $couponmerchid) {
							$order['couponid'] = $couponid;
							$order['couponmerchid'] = $couponmerchid;
						}
						else {
							$order['couponid'] = 0;
							$order['couponmerchid'] = 0;
						}
					}
				}

				pdo_insert('ewei_shop_order', $order);
				$ch_orderid = pdo_insertid();
				$merch_array[$merchid]['orderid'] = $ch_orderid;

				if (0 < $couponmerchid) {
					if ($merchid == $couponmerchid) {
						$couponorderid = $ch_orderid;
					}
				}

				foreach ($value['goods'] as $k => $v) {
					$og_array[$v] = $ch_orderid;
				}
			}

			foreach ($allgoods as $goods) {
				$goodsid = $goods['goodsid'];
				$order_goods = array();
				$order_goods['parentorderid'] = $orderid;
				$order_goods['merchid'] = $goods['merchid'];
				$order_goods['merchsale'] = $goods['merchsale'];
				$order_goods['orderid'] = $og_array[$goodsid];
				$order_goods['uniacid'] = $uniacid;
				$order_goods['goodsid'] = $goodsid;
				$order_goods['price'] = $goods['marketprice'] * $goods['total'];
				$order_goods['total'] = $goods['total'];
				$order_goods['optionid'] = $goods['optionid'];
				$order_goods['createtime'] = time();
				$order_goods['optionname'] = $goods['optiontitle'];
				$order_goods['goodssn'] = $goods['goodssn'];
				$order_goods['productsn'] = $goods['productsn'];
				$order_goods['realprice'] = $goods['ggprice'];
				$order_goods['oldprice'] = $goods['ggprice'];
				$order_goods['isdiscountprice'] = $goods['isdiscountprice'];
				$order_goods['openid'] = $openid;
				$order_goods['consume'] = iserializer(array('consume_deduct' => $goods['consume_deduct'], 'consume_deduct2' => $goods['consume_deduct2']));
				$isfullback = $this->isfullbackgoods($goodsid, $goods['optionid']);
				$order_goods['fullbackid'] = $isfullback;

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
		}

		if ($data['type'] == 3) {
			$order_v = array();

			if (function_exists('redis_getarr')) {
				$key = $_W['uniacid'] . '_order_' . $orderid;
				$order_v = redis_getarr($key);
			}

			if (empty($order_v)) {
				$order_v = pdo_fetch('select id,ordersn, price,openid,dispatchtype,addressid,carrier,status,isverify,deductcredit2,`virtual`,isvirtual,couponid,isvirtualsend,isparent,paytype,merchid,agentid,createtime,buyagainprice,istrade,tradestatus from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and id = :id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $orderid));
			}

			if (com('virtual')) {
				$virtual_res = com('virtual')->pay_befo($order_v);
				if (is_array($virtual_res) && $virtual_res['message']) {
					pdo_update('ewei_shop_order', array('status' => -1, 'canceltime' => time()), array('id' => $orderid, 'uniacid' => $_W['uniacid']));
					show_json(0, $virtual_res['message']);
				}
			}
		}

		if (!empty($_SESSION['exchange']) && p('exchange')) {
			$codeResult = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exchange_code') . ' WHERE `key` = :key AND uniacid =:uniacid', array(':key' => $_SESSION['exchange_key'], ':uniacid' => $_W['uniacid']));

			if ($codeResult['status'] == 2) {
				show_json(0, '兑换失败:此兑换码已兑换');
			}

			$groupResult = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exchange_group') . ' WHERE id = :id AND uniacid = :uniacid ', array(':uniacid' => $_W['uniacid'], ':id' => $codeResult['groupid']));
			$record_exsit = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exchange_record') . ' WHERE `key`=:key AND uniacid = :uniacid', array(':key' => $_SESSION['exchange_key'], ':uniacid' => $_W['uniacid']));

			if (empty($record_exsit)) {
				$data = array('key' => $_SESSION['exchange_key'], 'uniacid' => $_W['uniacid'], 'title' => $_SESSION['exchangetitle'], 'serial' => $_SESSION['exchangeserial']);
				pdo_insert('ewei_shop_exchange_record', $data);
			}

			if (empty($_SESSION['exchange_key']) || is_null($_SESSION['exchangeprice']) || is_null($_SESSION['exchangepostage'])) {
				show_json(0, '兑换超时,请重试');
			}
			else {
				$checkSubmit = $this->checkSubmit('exchange_plugin');

				if (is_error($checkSubmit)) {
					show_json(0, $checkSubmit['message']);
				}

				$checkSubmit = $this->checkSubmitGlobal('exchange_key_' . $_SESSION['exchange_key']);

				if (is_error($checkSubmit)) {
					show_json(0, $checkSubmit['message']);
				}

				if ($groupResult['mode'] != 6) {
					$exchange_res = pdo_update('ewei_shop_exchange_code', array('status' => 2), array('key' => $_SESSION['exchange_key'], 'status' => 1, 'uniacid' => $_W['uniacid']));
					pdo_query('UPDATE ' . tablename('ewei_shop_exchange_group') . ' SET `use` = `use` + 1 WHERE id = :id AND uniacid = :uniacid', array(':id' => $_SESSION['groupid'], ':uniacid' => $_W['uniacid']));
				}
				else {
					pdo_update('ewei_shop_exchange_code', array('goodsstatus' => 2), array('key' => $_SESSION['exchange_key'], 'uniacid' => $_W['uniacid']));
					if (($codeResult['balancestatus'] == 2 || empty($groupResult['balance_type'])) && ($codeResult['scorestatus'] == 2 || empty($groupResult['score_type'])) && ($codeResult['redstatus'] == 2 || empty($groupResult['red_type'])) && ($codeResult['couponstatus'] == 2 || empty($groupResult['coupon_type']))) {
						pdo_update('ewei_shop_exchange_code', array('status' => 2), array('key' => $_SESSION['exchange_key'], 'status' => 1, 'uniacid' => $_W['uniacid']));
					}
				}
			}
		}

		if (!is_null($_SESSION['exchangeprice']) && !empty($_SESSION['exchange']) && p('exchange')) {
			$exchangeinfo = m('member')->getInfo($_W['openid']);

			if ($groupResult['mode'] != 6) {
				$exchangedata = array('key' => $_SESSION['exchange_key'], 'uniacid' => $_W['uniacid'], 'goods' => $_SESSION['exchangegoods'], 'orderid' => $orderid, 'time' => time(), 'openid' => $_W['openid'], 'mode' => 1, 'nickname' => $exchangeinfo['nickname'], 'groupid' => $_SESSION['groupid'], 'title' => $_SESSION['exchangetitle'], 'serial' => $_SESSION['exchangeserial'], 'ordersn' => $order['ordersn'], 'goods_title' => $exchangetitle);
				pdo_update('ewei_shop_exchange_record', $exchangedata, array('key' => $_SESSION['exchange_key'], 'uniacid' => $_W['uniacid']));
			}
			else {
				$exchangedata = array('goods' => $_SESSION['exchangegoods'], 'orderid' => $orderid, 'time' => time(), 'openid' => $_W['openid'], 'mode' => 6, 'nickname' => $exchangeinfo['nickname'], 'ordersn' => $order['ordersn'], 'goods_title' => $exchangetitle);
				pdo_update('ewei_shop_exchange_record', $exchangedata, array('key' => $_SESSION['exchange_key'], 'uniacid' => $_W['uniacid']));
			}

			pdo_update('ewei_shop_exchange_cart', array('selected' => 0), array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'selected' => 1));
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

		if (p('quick') && !empty($_GPC['fromquick'])) {
			pdo_update('ewei_shop_quick_cart', array('deleted' => 1), array('quickid' => intval($_GPC['fromquick']), 'uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
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
			$ret = m('order')->CheckoodsStock($orderid, 0);
			if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
			}
			else {
				if (!$ret) {
					pdo_update('ewei_shop_order', array('status' => -1), array('id' => $orderid));
					show_json(0, '您当前下单商品库存不足,此订单已关闭.');
				}
			}

			m('order')->setStocksAndCredits($orderid, 0);
		}
		else {
			if (isset($allgoods[0])) {
				$vgoods = $allgoods[0];
			}
		}

		if (!empty($tgoods)) {
			$rank = intval($_SESSION[$tgoods['goodsid'] . '_rank']);
			$log_id = intval($_SESSION[$tgoods['goodsid'] . '_log_id']);
			$join_id = intval($_SESSION[$tgoods['goodsid'] . '_join_id']);
			m('goods')->getTaskGoods($tgoods['openid'], $tgoods['goodsid'], $rank, $log_id, $join_id, $tgoods['optionid'], $tgoods['total']);
			$_SESSION[$tgoods['goodsid'] . '_rank'] = 0;
			$_SESSION[$tgoods['goodsid'] . '_log_id'] = 0;
			$_SESSION[$tgoods['goodsid'] . '_join_id'] = 0;
		}

		m('notice')->sendOrderMessage($orderid);
		com_run('printer::sendOrderMessage', $orderid);
		$pluginc = p('commission');
		if ($taskreward || isset($task_goods_data['task_goods']['is_goods']) && ($task_goods_data['task_goods']['is_goods'] === '0' || $task_goods_data['task_goods']['is_goods'] === 0)) {
			$pluginc = false;
		}

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
		if (p('exchange') && $_SESSION['exchange']) {
			$_SESSION['exchange'] = NULL;
			$exchangepostage = NULL;
			$exchangeprice = NULL;
			unset($_SESSION['exchangeprice']);
			unset($_SESSION['exchangepostage']);
		}

		$dividend = p('dividend');

		if ($dividend) {
			if ($multiple_order == 0) {
				$a = $dividend->checkOrderConfirm($orderid);
			}
			else {
				if (!empty($merch_array)) {
					foreach ($merch_array as $key => $value) {
						$dividend->checkOrderConfirm($value['orderid']);
					}
				}
			}
		}

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

	public function getcardprice()
	{
		global $_GPC;
		$card_id = intval($_GPC['card_id']);
		$card_price = intval($_GPC['card_price']);
		$goodsarr = $_GPC['goods'];
		$goodsprice = $_GPC['goodsprice'];
		$discountprice = $_GPC['discountprice'];
		$isdiscountprice = $_GPC['isdiscountprice'];
		$dispatch_price = $_GPC['dispatch_price'];
		$lotterydiscountprice = $_GPC['lotterydiscountprice'];
		$taskcut = $_GPC['taskcut'];
		$liveid = intval($_GPC['liveid']);

		if (0 < $liveid) {
			$live_product = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_goods') . (' WHERE id = \'' . $goodsarr[0]['goodsid'] . '\''));

			if ($live_product) {
				$goodsprice = $live_product['marketprice'] * $goodsarr[0]['total'];
			}
		}

		$result = $this->caculatecard($card_id, $dispatch_price, $lotterydiscountprice, $taskcut, $goodsarr, $goodsprice, $discountprice, $isdiscountprice, $liveid);

		if (empty($result)) {
			show_json(0);
		}
		else {
			show_json(1, $result);
		}
	}

	public function caculatecard($card_id, $dispatch_price, $lotterydiscountprice, $taskcut, $goodsarr, $totalprice, $discountprice, $isdiscountprice, $liveid, $isSubmit = 0)
	{
		global $_W;
		$open_redis = function_exists('redis') && !is_error(redis());
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid, true);
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];

		if (empty($goodsarr)) {
			return false;
		}

		if (p('membercard')) {
			$data = p('membercard')->getMemberCard($card_id);
		}

		if (empty($data)) {
			return NULL;
		}

		if (is_array($goodsarr)) {
			$goods = array();
			$member_discount = intval($data['member_discount']);
			$discount_rate = floatval($data['discount_rate']);
			if (isset($data['shipping']) && $data['shipping'] == 1) {
				$dispatch_price = 0;
			}

			$gprice = 0;
			$cardgoodprice = 0;
			$newtotalprice = 0;
			$deductprice = 0;
			$discountprice = 0;
			$isdiscountprice = 0;
			$deductprice1 = 0;
			$deductcredit2 = 0;
			$deductprice2 = 0;

			foreach ($goodsarr as $k => &$g) {
				if ($g['status'] != 2) {
					if (0 < $liveid) {
						$live_product = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_goods') . (' WHERE id = \'' . $g['goodsid'] . '\''));

						if ($live_product) {
							$g['marketprice'] = $live_product['marketprice'];
						}
					}

					$gprice = (double) $g['marketprice'] * (double) $g['total'];
					$newtotalprice = 0 + $gprice;

					if ($g['discounttype'] == 2) {
						if (0 < $data['discount']) {
							if (0 < $discount_rate) {
								$cardgoodprice += ($gprice - (double) $g['discountunitprice'] * (double) $g['total']) * ($discount_rate / 10);
								$goodprice = $gprice - (double) $g['discountunitprice'] * (double) $g['total'];
								$deductprice += $goodprice * (1 - $discount_rate / 10);
								$discountprice += (double) $g['discountunitprice'] * (double) $g['total'];
							}
							else {
								$cardgoodprice += $gprice;
								$discountprice += (double) $g['discountunitprice'] * (double) $g['total'];
							}
						}
						else {
							$discountprice = 0;

							if (0 < $discount_rate) {
								$deductprice += $gprice * (1 - $discount_rate / 10);
								$cardgoodprice += $gprice * ($discount_rate / 10);
							}
							else {
								$cardgoodprice += $gprice;
							}
						}
					}
					else if ($g['discounttype'] == 1) {
						if (0 < $data['discount']) {
							if (0 < $discount_rate) {
								$cardgoodprice += ($gprice - (double) $g['isdiscountunitprice'] * (double) $g['total']) * ($discount_rate / 10);
								$goodprice = $gprice - (double) $g['isdiscountunitprice'] * (double) $g['total'];
								$deductprice += $goodprice * (1 - $discount_rate / 10);
								$isdiscountprice += $g['isdiscountunitprice'] * (double) $g['total'];
							}
							else {
								$cardgoodprice += $gprice;
								$isdiscountprice = 0;
							}
						}
						else {
							$isdiscountprice = 0;

							if (0 < $discount_rate) {
								$deductprice += $gprice * (1 - $discount_rate / 10);
								$cardgoodprice += $gprice * ($discount_rate / 10);
							}
							else {
								$cardgoodprice += $gprice;
							}
						}
					}
					else {
						if ($g['discounttype'] == 0) {
							if ($g['isnodiscount'] == 1) {
								if ($data['discount']) {
									if (0 < $discount_rate) {
										$goodprice = $gprice;
										$deductprice += $goodprice * (1 - $discount_rate / 10);
										$cardgoodprice += $gprice * ($discount_rate / 10);
									}
									else {
										$cardgoodprice += $gprice;
									}
								}
								else if (0 < $discount_rate) {
									$deductprice += $gprice * (1 - $discount_rate / 10);
									$cardgoodprice += $gprice * ($discount_rate / 10);
								}
								else {
									$cardgoodprice += $gprice;
								}
							}
							else if ($data['discount']) {
								if (0 < $discount_rate) {
									$goodprice = $gprice;
									$deductprice += $goodprice * (1 - $discount_rate / 10);
									$cardgoodprice += $gprice * ($discount_rate / 10);
								}
								else {
									$cardgoodprice += $gprice;
								}
							}
							else if (0 < $discount_rate) {
								$deductprice += $gprice * (1 - $discount_rate / 10);
								$cardgoodprice += $gprice * ($discount_rate / 10);
							}
							else {
								$cardgoodprice += $gprice;
							}
						}
					}
				}

				if ($open_redis) {
					if ($g['ggprice'] < $g['deduct']) {
						$g['deduct'] = $g['ggprice'];
					}

					if (0 < $cardgoodprice && $cardgoodprice < $g['deduct']) {
						$g['deduct'] = $cardgoodprice;
					}

					if ($g['manydeduct']) {
						$deductprice1 += $g['deduct'] * $g['total'];
					}
					else {
						$deductprice1 += $g['deduct'];
					}

					if ($g['deduct2'] == 0) {
						$deductprice2 += $cardgoodprice;
					}
					else {
						if (0 < $g['deduct2']) {
							if ($cardgoodprice < $g['deduct2']) {
								$deductprice2 += $cardgoodprice;
							}
							else {
								$deductprice2 += $g['deduct2'];
							}
						}
					}
				}
			}

			if (empty($saleset['dispatchnodeduct'])) {
				$deductprice2 += $dispatch_price;
			}

			$carddeduct_text = '';

			if ($data['discount_rate']) {
				$carddeduct_text = '会员卡优惠';
			}
		}

		$sale_plugin = com('sale');
		$saleset = false;

		if ($sale_plugin) {
			$saleset = $_W['shopset']['sale'];
			$saleset['enoughs'] = $sale_plugin->getEnoughs();
		}

		if ($saleset) {
			foreach ($saleset['enoughs'] as $e) {
				if (floatval($e['enough']) <= $totalprice - $discountprice - $isdiscountprice - $deductprice && 0 < floatval($e['money'])) {
					$deductenough_money = floatval($e['money']);
					$deductenough_enough = floatval($e['enough']);
					$deductprice2 -= $deductenough_money;
					break;
				}
			}
		}

		$taskreward = $_SESSION['taskcut'];
		if ($taskreward && p('task')) {
			$taskcut = 0;
		}

		$totalprice = $totalprice - $deductprice;
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

				if ($deductprice1 < $deductmoney) {
					$deductmoney = $deductprice1;
				}

				if ($totalprice - $isdiscountprice - $discountprice - $deductenough_money < $deductmoney) {
					$deductmoney = $totalprice - $isdiscountprice - $discountprice - $deductenough_money;
				}

				$deductcredit = ceil($pmoney * $pcredit == 0 ? 0 : $deductmoney / $pmoney * $pcredit);
			}

			if (!empty($saleset['moneydeduct'])) {
				$deductcredit2 = $member['credit2'];

				if ($totalprice - $isdiscountprice - $discountprice - $deductenough_money + $dispatch_price < $deductcredit2) {
					$deductcredit2 = $totalprice - $isdiscountprice - $discountprice - $deductenough_money + $dispatch_price;
				}

				if ($deductprice2 < $deductcredit2) {
					$deductcredit2 = $deductprice2;
				}
			}
		}

		$return_array = array();
		$return_array['carddeductprice'] = (double) $deductprice;
		$return_array['cardgoodprice'] = (double) $cardgoodprice;
		$return_array['carddeduct_text'] = $carddeduct_text;
		$return_array['totalprice'] = (double) $totalprice;
		$return_array['dispatch_price'] = (double) $dispatch_price;
		$return_array['cardname'] = $data['name'];
		$return_array['taskcut'] = (double) $taskcut;
		$return_array['lotterydiscountprice'] = 0;
		$return_array['discountprice'] = (double) $discountprice;
		$return_array['isdiscountprice'] = (double) $isdiscountprice;
		$return_array['live_id'] = $liveid;
		$return_array['shipping'] = $data['shipping'];
		$return_array['goodsprice'] = (double) $newtotalprice;
		$return_array['deductenough_money'] = (double) $deductenough_money;
		$return_array['deductenough_enough'] = (double) $deductenough_enough;
		$return_array['deductcredit2'] = $deductcredit2;
		$return_array['deductcredit'] = $deductcredit;
		$return_array['deductmoney'] = $deductmoney;
		$return_array['$goodsarr'] = $goodsarr;
		return $return_array;
	}

	protected function getdefaultMembercardId()
	{
		global $_W;

		if (p('membercard')) {
			$mycard = p('membercard')->get_Mycard($_W['openid']);

			if ($mycard['list']) {
				$all_mycardlist = $mycard['list'];
				$card_info['all_mycardlist'] = $all_mycardlist;
				$availablecard_count = $mycard['total'];
				$c_discount = array();
				$a_discount = array();

				foreach ($all_mycardlist as $ckey => $cvalue) {
					if (empty($cvalue['member_discount'])) {
						continue;
					}

					$c_discount[$cvalue['id']] = (string) $cvalue['discount_rate'];
				}

				foreach ($all_mycardlist as $akey => $avalue) {
					if (empty($avalue['member_discount']) || $avalue['discount'] == 0) {
						continue;
					}

					$a_discount[$avalue['id']] = (string) $avalue['discount_rate'];
				}

				$max_discount_cardid = 0;

				if (!empty($a_discount)) {
					$max_discount = min($a_discount);
					$ex_discount = @array_flip($a_discount);
					$max_discount_cardid = $ex_discount[$max_discount];
				}
				else {
					if (!empty($c_discount)) {
						$max_discount = min($c_discount);
						$ex_discount = @array_flip($c_discount);
						$max_discount_cardid = $ex_discount[$max_discount];
					}
				}

				$default_cardid = empty($max_discount_cardid) ? $all_mycardlist[0]['id'] : $max_discount_cardid;
				return $default_cardid;
			}
		}
		else {
			return false;
		}
	}

	/**
     * 是否为全返订单
     * @param int $goodsid
     * @param int $optionid
     * author 德昂
     * @return int
     */
	public function isfullbackgoods($goodsid = 0, $optionid = 0)
	{
		global $_W;
		$fullbackid = 0;

		if (0 < $optionid) {
			$fullback_goods = pdo_fetch('select id from' . tablename('ewei_shop_fullback_goods') . ('where goodsid=:goodsid and hasoption =1 and status=1 and uniacid=:uniacid and find_in_set(\'' . $optionid . '\',optionid)'), array(':uniacid' => $_W['uniacid'], ':goodsid' => $goodsid));
		}
		else {
			$fullback_goods = pdo_get('ewei_shop_fullback_goods', array('status' => 1, 'goodsid' => $goodsid, 'uniacid' => $_W['uniacid']), 'id');
		}

		if ($fullback_goods) {
			$fullbackid = $fullback_goods['id'];
		}

		return $fullbackid;
	}
}

?>
