<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Create_EweiShopV2Page extends AppMobilePage
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

		$appDatas = array();

		if ($diyform_plugin) {
			$appDatas = $diyform_plugin->wxApp($fields, $f_data, $this->member);
		}

		return array('diyform_plugin' => $diyform_plugin, 'order_formInfo' => $order_formInfo, 'diyform_set' => $diyform_set, 'orderdiyformid' => $orderdiyformid, 'fields' => $appDatas['fields'], 'f_data' => $appDatas['f_data']);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];

		if (empty($openid)) {
			return app_error(AppError::$UserNotLogin);
		}

		if (p('quick')) {
			$quickid = intval($_GPC['fromquick']);

			if (!empty($quickid)) {
				$quickinfo = p('quick')->getQuick($quickid);

				if (empty($quickinfo)) {
					return app_error(AppError::$ParamsError);
				}
			}
		}

		$open_redis = function_exists('redis') && !is_error(redis());
		$seckillinfo = false;
		$allow_sale = true;
		$canusecard = true;
		$member = m('member')->getMember($openid, true);
		$packageid = intval($_GPC['packageid']);

		if (!$packageid) {
			$merchdata = $this->merchData();
			extract($merchdata);
			$merch_array = array();
			$merchs = array();
			$merch_id = 0;

			if (empty($member)) {
				return app_error(AppError::$UserNotLogin);
			}

			$member['carrier_mobile'] = empty($member['carrier_mobile']) ? $member['mobile'] : $member['carrier_mobile'];
			$level = m('member')->getLevel($openid);
			$diyformdata = $this->diyformData($member);
			extract($diyformdata);
			$id = intval($_GPC['id']);
			$bargain_id = intval($_GPC['bargainid']);
			$_SESSION['bargain_id'] = NULL;
			if (p('bargain') && !empty($bargain_id)) {
				$_SESSION['bargain_id'] = $bargain_id;
				$bargain_act = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_actor') . ' WHERE id = :id AND openid = :openid AND status = \'0\'', array(':id' => $bargain_id, ':openid' => $_W['openid']));

				if (empty($bargain_act)) {
					return app_error(AppError::$OrderCreateNoGoods);
				}

				$bargain_act_id = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_goods') . (' WHERE id = \'' . $bargain_act['goods_id'] . '\''));

				if (empty($bargain_act_id)) {
					return app_error(AppError::$OrderCreateNoGoods);
				}

				$if_bargain = pdo_fetch('SELECT bargain FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id AND uniacid = :uniacid ', array(':id' => $bargain_act_id['goods_id'], ':uniacid' => $_W['uniacid']));

				if (empty($if_bargain['bargain'])) {
					return app_error(AppError::$OrderCreateNoGoods);
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
			$isvirtual = false;
			$isforceverifystore = false;
			$isvirtualsend = false;
			$changenum = false;
			$fromcart = 0;
			$hasinvoice = false;
			$invoicename = '';
			$buyagain_sale = true;
			$buyagainprice = 0;
			$isonlyverifygoods = true;
			$iscycel = false;
			$goods = array();
			$giftid = intval($_GPC['giftid']);
			$giftGood = array();
			$gifts = array();

			if (empty($id)) {
				if (!empty($quickid)) {
					$sql = 'SELECT c.goodsid,c.total,g.maxbuy,g.type,g.intervalfloor,g.intervalprice,g.issendfree,g.isnodiscount,g.ispresell,g.presellprice as gpprice,o.presellprice,g.preselltimeend,g.presellsendstatrttime,g.presellsendtime,g.presellsendtype' . ',g.weight,o.weight as optionweight,g.title,g.thumb,ifnull(o.marketprice, g.marketprice) as marketprice,o.title as optiontitle,c.optionid,' . ' g.storeids,g.isverify,g.isforceverifystore,g.deduct,g.manydeduct,g.manydeduct2,g.virtual,o.virtual as optionvirtual,discounts,' . ' g.deduct2,g.ednum,g.edmoney,g.edareas,g.edareas_code,g.diyformtype,g.diyformid,diymode,g.dispatchtype,g.dispatchid,g.dispatchprice,g.minbuy ' . ' ,g.isdiscount,g.isdiscount_time,g.isdiscount_discounts,g.cates,g.isfullback, ' . ' g.virtualsend,invoice,o.specs,g.merchid,g.checked,g.merchsale,g.unite_total,' . ' g.buyagain,g.buyagain_islong,g.buyagain_condition, g.buyagain_sale, g.hasoption, g.threen' . ' FROM ' . tablename('ewei_shop_quick_cart') . ' c ' . ' left join ' . tablename('ewei_shop_goods') . ' g on c.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on c.optionid = o.id ' . (' where c.openid=:openid and c.selected=1 and  c.deleted=0 and c.uniacid=:uniacid and c.quickid=' . $quickid . '  order by c.id desc');
					$goods = pdo_fetchall($sql, array(':uniacid' => $uniacid, ':openid' => $openid));
				}
				else {
					$sql = 'SELECT c.goodsid,c.total,g.maxbuy,g.type,g.issendfree,g.isnodiscount,g.ispresell,g.presellprice as gpprice,o.presellprice,g.preselltimeend,g.presellsendstatrttime,g.presellsendtime,g.presellsendtype' . ',g.weight,o.weight as optionweight,g.title,g.thumb,ifnull(o.marketprice, g.marketprice) as marketprice,o.title as optiontitle,c.optionid,g.isfullback,' . ' g.storeids,g.isverify,g.isforceverifystore,g.deduct,g.manydeduct,g.manydeduct2,g.virtual,o.virtual as optionvirtual,discounts,' . ' g.deduct2,g.ednum,g.edmoney,g.edareas,g.edareas_code,g.diyformtype,g.diyformid,diymode,g.dispatchtype,g.dispatchid,g.dispatchprice,g.minbuy ' . ' ,g.isdiscount,g.isdiscount_time,g.isdiscount_discounts,g.cates, ' . ' g.virtualsend,invoice,o.specs,g.merchid,g.checked,g.merchsale,' . ' g.buyagain,g.buyagain_islong,g.buyagain_condition, g.buyagain_sale' . ' FROM ' . tablename('ewei_shop_member_cart') . ' c ' . ' left join ' . tablename('ewei_shop_goods') . ' g on c.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on c.optionid = o.id ' . ' where c.openid=:openid and c.selected=1 and  c.deleted=0 and c.uniacid=:uniacid  order by c.id desc';
					$goods = pdo_fetchall($sql, array(':uniacid' => $uniacid, ':openid' => $openid));
				}

				if (empty($goods)) {
					return app_error(AppError::$OrderCreateNoGoods);
				}

				foreach ($goods as $k => $v) {
					if ($is_openmerch == 0) {
						if (0 < $v['merchid']) {
							return app_error(AppError::$OrderCreateNoGoods);
						}
					}
					else {
						if (0 < $v['merchid'] && $v['checked'] == 1) {
							return app_error(AppError::$OrderCreateNoGoods);
						}
					}

					if ($k == 0) {
						$merch_id = $v['merchid'];
					}

					if ($merch_id == $v['merchid']) {
						$merch_id = $v['merchid'];
					}
					else {
						$merch_id = 0;
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
						return app_error(1, '最多购买' . $goods[$k]['seckillinfo']['maxbuy'] . '件');
					}

					if (0 < $goods[$k]['ispresell'] && ($goods[$k]['preselltimeend'] == 0 || time() < $goods[$k]['preselltimeend'])) {
						$canusecard = false;
					}

					if ($goods[$k]['type'] == 4) {
						$canusecard = false;
					}

					if ($goods[$k]['seckillinfo'] && $goods[$k]['seckillinfo']['status'] == 0) {
						$canusecard = false;
					}

					if ($merch_id) {
						$canusecard = false;
					}
				}

				$fromcart = 1;
			}
			else {
				$sql = 'SELECT id as goodsid,type,title,weight,issendfree,isnodiscount,isfullback,ispresell,presellprice,preselltimeend,presellsendstatrttime,presellsendtime,presellsendtype, ' . ' thumb,marketprice,storeids,isverify,isforceverifystore,deduct,' . ' manydeduct,manydeduct2,`virtual`,maxbuy,usermaxbuy,discounts,total as stock,deduct2,showlevels,' . ' ednum,edmoney,edareas,edareas_code,' . ' diyformtype,diyformid,diymode,dispatchtype,dispatchid,dispatchprice,cates,minbuy, ' . ' isdiscount,isdiscount_time,isdiscount_discounts, ' . ' virtualsend,invoice,needfollow,followtip,followurl,merchid,checked,merchsale, ' . ' buyagain,buyagain_islong,buyagain_condition, buyagain_sale' . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
				$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $id));

				if (!empty($bargain_act)) {
					$data['marketprice'] = $bargain_act['now_price'];
				}

				if (0 < $data['ispresell'] && ($data['preselltimeend'] == 0 || time() < $data['preselltimeend'])) {
					$data['marketprice'] = $data['presellprice'];
					$canusecard = false;
				}

				if ($data['type'] == 4) {
					$canusecard = false;
				}

				$merch_id = $data['merchid'];
				$fullbackgoods = array();

				if ($data['isfullback']) {
					$fullbackgoods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_fullback_goods') . ' WHERE goodsid = :goodsid and uniacid = :uniacid and status = 1 limit 1 ', array(':goodsid' => $data['goodsid'], ':uniacid' => $uniacid));
				}

				if (empty($data) || !empty($data['showlevels']) && !strexists($data['showlevels'], $member['level']) || 0 < $data['merchid'] && $data['checked'] == 1 || $is_openmerch == 0 && 0 < $data['merchid']) {
					return app_error(AppError::$OrderCreateNoGoods);
				}

				$follow = m('user')->followed($openid);
				if (0 < $data['minbuy'] && $total < $data['minbuy']) {
					$total = $data['minbuy'];
				}

				$data['total'] = $total;
				$data['optionid'] = $optionid;

				if (!empty($optionid)) {
					$option = pdo_fetch('select * from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $id, ':id' => $optionid));

					if (!empty($option)) {
						$data['optionid'] = $optionid;
						$data['optiontitle'] = $option['title'];
						$data['marketprice'] = 0 < intval($data['ispresell']) && (time() < $data['preselltimeend'] || $data['preselltimeend'] == 0) ? $option['presellprice'] : $option['marketprice'];
						$data['virtual'] = $option['virtual'];
						$data['stock'] = $option['stock'];

						if (!empty($option['weight'])) {
							$data['weight'] = $option['weight'];
						}

						if (!empty($option['specs'])) {
							$thumb = m('goods')->getSpecThumb($option['specs']);

							if (!empty($thumb)) {
								$data['thumb'] = $thumb;
							}
						}

						if ($option['isfullback'] && !empty($fullbackgoods)) {
							$fullbackgoods['minallfullbackallprice'] = $option['allfullbackprice'];
							$fullbackgoods['fullbackprice'] = $option['fullbackprice'];
							$fullbackgoods['minallfullbackallratio'] = $option['allfullbackratio'];
							$fullbackgoods['fullbackratio'] = $option['fullbackratio'];
							$fullbackgoods['day'] = $option['day'];
						}
					}

					$cycelbuy_periodic = explode(',', $option['cycelbuy_periodic']);
					$cycelbuy_day = $cycelbuy_periodic[0];
					$cycelbuy_unit = $cycelbuy_periodic[1];
					$cycelbuy_num = $cycelbuy_periodic[2];
				}

				$data['seckillinfo'] = plugin_run('seckill::getSeckill', $data['goodsid'], $data['optionid'], true, $_W['openid']);
				if (!empty($data['seckillinfo']['maxbuy']) && $data['seckillinfo']['maxbuy'] - $data['seckillinfo']['selfcount'] < $data['total']) {
					return app_error(1, '最多购买' . $data['seckillinfo']['maxbuy'] . '件');
				}

				if ($giftid) {
					$changenum = false;
				}
				else {
					$changenum = true;
				}

				if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
					$changenum = false;
					$canusecard = false;
				}

				$goods[] = $data;
			}

			if (p('bargain') && !empty($bargain_id)) {
				$canusecard = false;
			}

			$goods = set_medias($goods, 'thumb');

			foreach ($goods as &$g) {
				if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
					$g['is_task_goods'] = 0;
				}
				else {
					$rank = intval($_SESSION[$id . '_rank']);
					$join_id = intval($_SESSION[$id . '_join_id']);
					$task_goods_data = m('goods')->getTaskGoods($openid, $id, $rank, $join_id, $optionid);

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

				if ($is_openmerch == 1) {
					$merchid = $g['merchid'];
					$merch_array[$merchid]['goods'][] = $g['goodsid'];
				}

				if ($g['isverify'] == 2) {
					$isverify = true;
				}

				if ($g['isforceverifystore']) {
					$isforceverifystore = true;
				}

				if (!empty($g['virtual']) || $g['type'] == 2) {
					$isvirtual = true;

					if ($g['virtualsend']) {
						$isvirtualsend = true;
					}
				}

				if ($g['invoice']) {
					$hasinvoice = $g['invoice'];
				}

				if ($g['type'] != 5) {
					$isonlyverifygoods = false;
				}

				if ($g['type'] == 9) {
					$iscycel = true;
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
						$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $g['goodsid'], ':uniacid' => $uniacid, ':openid' => $openid));
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
			$invoice_arr = array('entity' => false, 'company' => false, 'title' => false, 'number' => false);

			if ($hasinvoice) {
				$invoicename = pdo_fetchcolumn('select invoicename from ' . tablename('ewei_shop_order') . ' where openid=:openid and uniacid=:uniacid and ifnull(invoicename,\'\')<>\'\' order by id desc limit 1', array(':openid' => $openid, ':uniacid' => $uniacid));
				$invoice_arr = m('sale')->parseInvoiceInfo($invoicename);

				if ($invoice_arr['title'] === false) {
					$invoicename = '';
				}

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

			if ($merch_id) {
				$canusecard = false;
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
			$discountprice = 0;
			$isdiscountprice = 0;
			$deductprice2 = 0;
			$stores = array();
			$address = false;
			$carrier = false;
			$carrier_list = array();
			$store_list = array();
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
					$prices = m('order')->getGoodsDiscountPrice($g, $level);

					if (empty($bargain_id)) {
						$g['ggprice'] = $prices['price'];
					}
					else {
						$g['ggprice'] = $gprice;
					}

					$g['unitprice'] = $prices['unitprice'];
				}

				if ($is_openmerch == 1) {
					$merchid = $g['merchid'];
					$merch_array[$merchid]['ggprice'] += $g['ggprice'];
					$merchs[$merchid] += $g['ggprice'];
				}

				$g['dflag'] = intval($g['ggprice'] < $gprice);
				if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0 || $_SESSION['taskcut']) {
				}
				else {
					if (empty($bargain_id)) {
						$taskdiscountprice += $prices['taskdiscountprice'];
						$g['taskdiscountprice'] = $prices['taskdiscountprice'];
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
									if ($g['ggprice'] < $g['deduct2']) {
										$deccredit2 = $g['ggprice'];
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
			$storeids = array();

			if ($isverify) {
				$merchid = 0;

				foreach ($goods as $g) {
					if (!empty($g['storeids'])) {
						$merchid = $g['merchid'];
						$storeids = array_merge(explode(',', $g['storeids']), $storeids);
					}
				}

				if (empty($storeids)) {
					if (0 < $merchid) {
						$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where  uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
					}
					else {
						$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
					}
				}
				else if (0 < $merchid) {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
				}
				else {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
				}

				if ($isforceverifystore) {
					$storeids_condition = '';

					if (!empty($storeids)) {
						$storeids_condition = '  id in (' . implode(',', $storeids) . ') and ';
					}

					if (0 < $merch_id) {
						$store_list = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where ' . $storeids_condition . '  uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $merch_id));
					}
					else {
						$store_list = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  ' . $storeids_condition . '  uniacid=:uniacid and status=1 and type in(2,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid']));
					}
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

			$card_info = array();
			$plugin_membercard = p('membercard');

			if (!$plugin_membercard) {
				$canusecard = false;
			}

			$availablecard_count = 0;
			$default_cardid = 0;
			$carddiscountprice = 0;
			$pure_totalprice = $realprice;
			$card_free_dispatch = false;

			if ($canusecard) {
				$mycard = $plugin_membercard->get_Mycard($openid);

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
				}

				$card_info['availablecard_count'] = $availablecard_count;
				$card_info['cardid'] = $default_cardid;

				if ($default_cardid) {
					$card_result = $this->caculatecard($default_cardid, $dispatch_price, $pure_totalprice, $discountprice, $isdiscountprice);

					if ($card_result) {
						$card_info['dispatch_price'] = $dispatch_price;
						$dispatch_price = $card_result['dispatch_price'];
						$carddiscountprice = $card_result['carddiscountprice'];
						$card_info['old_discountprice'] = $discountprice;
						$discountprice = $card_result['discountprice'];
						$card_info['old_isdiscountprice'] = $isdiscountprice;
						$isdiscountprice = $card_result['isdiscountprice'];
						$card_info['cardname'] = $card_result['cardname'];
						$card_info['carddiscount_rate'] = $card_result['carddiscount_rate'];
						$card_info['carddiscountprice'] = $carddiscountprice;
						$card_info['beforeprice'] = $pure_totalprice;
					}
				}

				$card_info['carddiscountprice'] = $carddiscountprice;
			}

			if (0 < $card_info['dispatch_price'] && $dispatch_price == 0) {
				$card_free_dispatch = true;
			}

			if (0 < $card_info['old_discountprice'] && $discountprice == 0) {
				$realprice += $card_info['old_discountprice'];
			}

			if (0 < $card_info['old_isdiscountprice'] && $isdiscountprice == 0) {
				$realprice += $card_info['old_isdiscountprice'];
			}

			$realprice -= $carddiscountprice;

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

			if ($iscycel) {
				$realprice += $dispatch_price * $cycelbuy_num;
			}
			else {
				$realprice += $dispatch_price + $seckill_dispatchprice;
			}

			$deductcredit = 0;
			$deductmoney = 0;
			$deductcredit2 = 0;

			if (!empty($saleset)) {
				if (!empty($saleset['creditdeduct'])) {
					$credit = $member['credit1'];
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

					$pure_price = $realprice - $dispatch_price;
					if (0 < $dispatch_price && $pmoney * $pcredit != 0 && $pure_price < ceil($deductmoney / $pmoney * $pcredit)) {
						$deductmoney = $deductmoney - $dispatch_price;
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

			foreach ($goods as $g) {
				if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
				}
				else if (0 < floatval($g['buyagain'])) {
					if (!m('goods')->canBuyAgain($g) || !empty($g['buyagain_sale'])) {
						$goodsdata_temp[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice']);
					}
				}
				else {
					$goodsdata_temp[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice']);
				}

				$goodsdata[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $g['discounttype'], 'isdiscountprice' => $g['isdiscountprice'], 'discountprice' => $g['discountprice'], 'isdiscountunitprice' => $g['isdiscountunitprice'], 'discountunitprice' => $g['discountunitprice']);
			}

			if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
			}
			else if ($g['isverify'] == 2) {
			}
			else {
				$gifttitle = '';

				if ($giftid) {
					$gift = array();
					$giftdata = pdo_fetch('select giftgoodsid,activity,orderprice from ' . tablename('ewei_shop_gift') . ' where uniacid = ' . $uniacid . ' and id = ' . $giftid . ' and status = 1 and starttime <= ' . time() . ' and endtime >= ' . time() . ' ');

					if ($giftdata['giftgoodsid']) {
						$giftgoodsid = explode(',', $giftdata['giftgoodsid']);

						foreach ($giftgoodsid as $key => $value) {
							$giftinfo = pdo_fetch('select id as goodsid,title,thumb from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and status = 2 and total>0 and id = ' . $value . ' and deleted = 0 ');

							if ($giftinfo) {
								$gift[$key] = $giftinfo;
								$gift[$key]['total'] = 1;
							}
						}

						if (!empty($gift)) {
							$gift = set_medias($gift, array('thumb'));
							$goodsdata = array_merge($goodsdata, $gift);
						}
						else {
							$giftid = 0;
						}
					}
				}
				else {
					$isgift = 0;
					$gifts = array();
					$giftgoods = array();
					$gifts = pdo_fetchall('select id,goodsid,giftgoodsid,thumb,title,orderprice from ' . tablename('ewei_shop_gift') . '
                    where uniacid = ' . $uniacid . ' and status = 1 and starttime <= ' . time() . ' and endtime >= ' . time() . ' and orderprice <= ' . $goodsprice . ' and activity = 1 ');

					foreach ($gifts as $key => $value) {
						$giftgoods = explode(',', $value['giftgoodsid']);

						foreach ($giftgoods as $k => $val) {
							$giftinfo = pdo_fetch('select id,title,thumb,marketprice,total from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and status = 2  and id = ' . $val . ' ');

							if ($giftinfo) {
								$isgift = 1;
								$gifts[$key]['gift'][$k] = $giftinfo;
							}

							if ($giftinfo && $giftinfo['total'] == 0) {
								$gifts[$key]['canchose'] = 0;
							}
							else {
								$gifts[$key]['canchose'] = 1;
							}
						}

						$gifts[$key]['gift'] = set_medias($gifts[$key]['gift'], array('thumb'));
						$gifttitle = $gifts[$key]['gift'][0]['title'];
					}

					$gifts = set_medias($gifts, array('thumb'));

					if ($isgift == 0) {
						$gifts = '';
					}
				}
			}

			$couponcount = com_run('coupon::consumeCouponCount', $openid, $realprice, $merch_array, $goodsdata_temp);
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

			$token = md5(microtime());
			$_SESSION['order_token'] = $token;
			$goods_list = array();
			$i = 0;

			if ($ismerch) {
				$getListUser = $merch_plugin->getListUser($goods);
				$merch_user = $getListUser['merch_user'];

				foreach ($getListUser['merch'] as $k => $v) {
					if (empty($merch_user[$k]['merchname'])) {
						$goods_list[$i]['shopname'] = $_W['shopset']['shop']['name'];
					}
					else {
						$goods_list[$i]['shopname'] = $merch_user[$k]['merchname'];
					}

					$goods_list[$i]['goods'] = $v;
					++$i;
				}
			}
			else {
				if ($merchid == 0) {
					$goods_list[$i]['shopname'] = $_W['shopset']['shop']['name'];
				}
				else {
					$merch_data = $merch_plugin->getListUserOne($merchid);
					$goods_list[$i]['shopname'] = $merch_data['merchname'];
				}

				$goods_list[$i]['goods'] = $goods;
			}

			$createInfo = array('id' => $id, 'gdid' => intval($_GPC['gdid']), 'fromcart' => $fromcart, 'addressid' => !empty($address) && !$isverify && !$isvirtual ? $address['id'] : 0, 'storeid' => !empty($carrier_list) && !$isverify && !$isvirtual ? $carrier_list[0]['id'] : 0, 'couponcount' => $couponcount, 'isvirtual' => $isvirtual, 'isverify' => $isverify, 'goods' => $goodsdata, 'merchs' => $merchs, 'orderdiyformid' => $orderdiyformid, 'mustbind' => $mustbind);
			$buyagain = $buyagainprice;
		}
		else {
			$merchdata = $this->merchData();
			extract($merchdata);
			$merch_array = array();
			$merchs = array();
			$g = $_GPC['goods'];
			$package = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_package') . ' WHERE uniacid = ' . $uniacid . ' and id = ' . $packageid . ' ');
			$package = set_medias($package, array('thumb'));

			if (time() < $package['starttime']) {
				return app_error(AppError::$OrderCreatePackageTimeNotStart);
			}

			if ($package['endtime'] < time()) {
				return app_error(AppError::$OrderCreatePackageTimeEnd);
			}

			$goods = array();
			$goodsprice = 0;
			$marketprice = 0;
			$goods_list = array();

			foreach ($g as $key => $value) {
				$goods[$key] = pdo_fetch('select id,title,thumb,marketprice,merchid,dispatchtype,dispatchid,dispatchprice from ' . tablename('ewei_shop_goods') . '
                            where id = ' . $value['goodsid'] . ' and uniacid = ' . $uniacid . ' ');

				if ($is_openmerch == 1) {
					$merchid = $goods[$key]['merchid'];
					$merch_array[$merchid]['goods'][] = $goods[$key]['id'];
				}

				$option = array();
				$packagegoods = array();

				if (0 < $value['optionid']) {
					$option = pdo_fetch('select title,packageprice from ' . tablename('ewei_shop_package_goods_option') . '
                            where optionid = ' . $value['optionid'] . ' and goodsid=' . $value['goodsid'] . ' and uniacid = ' . $uniacid . ' and pid = ' . $packageid . ' ');
					$goods[$key]['packageprice'] = $option['packageprice'];
				}
				else {
					$packagegoods = pdo_fetch('select title,packageprice from ' . tablename('ewei_shop_package_goods') . '
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

				$goodsprice += price_format($goods[$key]['packageprice']);
				$marketprice += price_format($goods[$key]['marketprice']);
			}

			$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where openid=:openid and deleted=0 and isdefault=1  and uniacid=:uniacid limit 1', array(':uniacid' => $uniacid, ':openid' => $openid));
			$total = count($goods);
			$dispatch_price = $package['freight'];
			$realprice = $goodsprice + $package['freight'];

			if (0 < $package['dispatchtype']) {
				$dispatch_array = m('order')->getOrderDispatchPrice($goods, $member, $address, false, $merch_array, 0);
				$dispatch_price = $dispatch_array['dispatch_price'] - $dispatch_array['seckill_dispatch_price'];
			}
			else {
				$dispatch_price = $package['freight'];
			}

			$realprice = $goodsprice + $dispatch_price;
			$packprice = $goodsprice;
			$token = md5(microtime());
			$_SESSION['order_token'] = $token;
			$createInfo = array('id' => 0, 'gdid' => intval($_GPC['gdid']), 'fromcart' => 0, 'packageid' => $packageid, 'addressid' => $address['id'], 'storeid' => 0, 'couponcount' => 0, 'isvirtual' => 0, 'isverify' => 0, 'goods' => $goods, 'merchs' => $merchs, 'orderdiyformid' => 0, 'token' => $token, 'mustbind' => 0);
			$goods_list = array();
			$goods_list[0]['shopname'] = $_W['shopset']['shop']['name'];
			$goods_list[0]['goods'] = $goods;
			$card_info = array();
			$plugin_membercard = p('membercard');

			if (!$plugin_membercard) {
				$canusecard = false;
			}

			$availablecard_count = 0;
			$carddiscountprice = 0;

			if ($canusecard) {
				$mycard = $plugin_membercard->get_Mycard($openid);

				if ($mycard['list']) {
					$all_mycardlist = $mycard['list'];
					$card_info['all_mycardlist'] = $all_mycardlist;
					$availablecard_count = $mycard['total'];
				}
			}

			$card_info['availablecard_count'] = $availablecard_count;
			$card_info['cardid'] = 0;
			$card_info['carddiscountprice'] = 0;
		}

		$_W['shopshare']['hideMenus'] = array('menuItem:share:qq', 'menuItem:share:QZone', 'menuItem:share:email', 'menuItem:copyUrl', 'menuItem:openWithSafari', 'menuItem:openWithQQBrowser', 'menuItem:share:timeline', 'menuItem:share:appMessage');
		$allgoods = array();

		foreach ($goods_list as $k => $v) {
			$allgoods[$k]['shopname'] = $v['shopname'];

			foreach ($v['goods'] as $g) {
				$promotionprice = $g['unitprice'] < $g['marketprice'] ? (double) $g['marketprice'] : (double) $g['unitprice'];
				if (!$g['seckillinfo'] || $g['seckillinfo']['status'] != 0) {
					$dis_prices = m('order')->getGoodsDiscountPrice($g, $level);
				}

				$allgoods[$k]['goods'][] = array('id' => $g['goodsid'], 'goodsid' => $g['goodsid'], 'title' => $g['title'], 'thumb' => tomedia($g['thumb']), 'optionid' => (int) $g['optionid'], 'optiontitle' => $g['optiontitle'], 'hasdiscount' => empty($g['isnodiscount']) && !empty($g['dflag']), 'total' => $g['total'], 'price' => $g['unitprice'] < $g['marketprice'] ? (double) $g['marketprice'] : (double) $g['unitprice'], 'marketprice' => (double) $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'unit' => $g['unit'], 'totalmaxbuy' => $g['totalmaxbuy'], 'minbuy' => $g['minbuy'], 'promotionprice' => $promotionprice * $g['total'] - $g['isdiscountprice'], 'taskdiscountprice' => empty($dis_prices) ? 0 : $dis_prices['taskdiscountprice'], 'discountprice' => empty($dis_prices) ? 0 : $dis_prices['discountprice'], 'discounttype' => empty($dis_prices) ? 0 : $dis_prices['discounttype'], 'isdiscountunitprice' => empty($dis_prices) ? 0 : $dis_prices['isdiscountunitprice'], 'discountunitprice' => empty($dis_prices) ? 0 : $dis_prices['discountunitprice'], 'price0' => empty($dis_prices) ? 0 : $dis_prices['price0'], 'price1' => empty($dis_prices) ? 0 : $dis_prices['price1'], 'price2' => empty($dis_prices) ? 0 : $dis_prices['price2']);
			}
		}

		$sysset = m('common')->getSysset('trade');
		$result = array(
			'member'             => array('realname' => $member['realname'], 'mobile' => $member['carrier_mobile']),
			'showTab'            => 0 < count($carrier_list) && !$isverify && !$isvirtual,
			'showAddress'        => !$isverify && !$isvirtual,
			'isverify'           => $isverify,
			'isvirtual'          => $isvirtual,
			'set_realname'       => $sysset['set_realname'],
			'set_mobile'         => $sysset['set_mobile'],
			'pickuptext'         => $sysset['pickuptext'],
			'carrierInfo'        => !empty($carrier_list) ? $carrier_list[0] : false,
			'storeInfo'          => false,
			'address'            => $address,
			'goods'              => $allgoods,
			'merchid'            => $merch_id,
			'packageid'          => $packageid,
			'fullbackgoods'      => $fullbackgoods,
			'giftid'             => $giftid,
			'gift'               => $gift,
			'gifts'              => $gifts,
			'gifttitle'          => $gifttitle,
			'changenum'          => $changenum,
			'hasinvoice'         => (bool) $hasinvoice,
			'invoicename'        => $invoicename,
			'couponcount'        => (int) $couponcount,
			'deductcredit'       => $deductcredit,
			'deductmoney'        => $deductmoney,
			'deductcredit2'      => $deductcredit2,
			'stores'             => $stores,
			'storeids'           => implode(',', $storeids),
			'fields'             => !empty($order_formInfo) ? $fields : false,
			'f_data'             => !empty($order_formInfo) ? $f_data : false,
			'dispatch_price'     => round($seckill_dispatchprice + $dispatch_price, 2),
			'goodsprice'         => $goodsprice,
			'taskdiscountprice'  => $taskdiscountprice,
			'discountprice'      => $discountprice,
			'isdiscountprice'    => $isdiscountprice,
			'showenough'         => empty($saleset['showenough']) ? false : true,
			'enoughmoney'        => $saleset['enoughmoney'],
			'enoughdeduct'       => $saleset['enoughdeduct'],
			'merch_showenough'   => empty($merch_saleset['merch_showenough']) ? false : true,
			'merch_enoughmoney'  => (double) $merch_saleset['merch_enoughmoney'],
			'merch_enoughdeduct' => (double) $merch_saleset['merch_enoughdeduct'],
			'merchs'             => (array) $merchs,
			'realprice'          => round($realprice, 2),
			'total'              => $total,
			'buyagain'           => round($buyagain, 2),
			'fromcart'           => (int) $fromcart,
			'isonlyverifygoods'  => $isonlyverifygoods,
			'isforceverifystore' => $isforceverifystore,
			'city_express_state' => empty($dispatch_array['city_express_state']) ? 0 : $dispatch_array['city_express_state'],
			'canusecard'         => $canusecard,
			'card_info'          => $card_info,
			'carddiscountprice'  => $carddiscountprice,
			'card_free_dispatch' => $card_free_dispatch
		);

		if ($iscycel) {
			$cycelset = m('common')->getSysset('cycelbuy');
			$selectDate = date('Ymd', $_GPC['selectDate']);
			$result['selectDate'] = $selectDate;
			$result['cycelComboUnit'] = $cycelbuy_unit;
			$result['cycelComboDay'] = $cycelbuy_day;
			$result['cycelComboPeriods'] = $cycelbuy_num;
			$result['iscycelbuy'] = $iscycel;
			$result['receipttime'] = $_GPC['selectDate'];
			$result['scope'] = $cycelset['days'];
		}

		$result['fromquick'] = intval($_GPC['fromquick']);
		$result['fullbacktext'] = m('sale')->getFullBackText();
		$result['seckill_dispatchprice'] = round($seckill_dispatchprice, 2);
		$result['seckill_price'] = round($seckill_price, 2);
		$result['seckill_payprice'] = round($seckill_payprice, 2);

		if ($hasinvoice) {
			$result['invoice_info'] = $invoice_arr;
			$result['invoice_type'] = $invoice_type;
		}

		return app_json($result);
	}

	public function getcouponprice()
	{
		global $_GPC;
		$couponid = intval($_GPC['couponid']);
		$goodsarr = $_GPC['goods'];
		$goodsprice = $_GPC['goodsprice'];
		$discountprice = $_GPC['discountprice'];
		$isdiscountprice = $_GPC['isdiscountprice'];
		$real_price = $_GPC['real_price'];
		$result = $this->caculatecoupon($couponid, $goodsarr, $goodsprice, $discountprice, $isdiscountprice, 0, array(), 0, $real_price);
		return app_json($result);
	}

	public function caculatecoupon($couponid, $goodsarr, $totalprice, $discountprice, $isdiscountprice, $isSubmit = 0, $discountprice_array = array(), $merchisdiscountprice = 0, $real_price = 0)
	{
		global $_W;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];

		if (empty($goodsarr)) {
			return false;
		}

		$sql = 'SELECT d.id,d.couponid,c.enough,c.backtype,c.deduct,c.discount,c.backmoney,c.backcredit,c.backredpack,c.merchid,c.limitgoodtype,c.limitgoodcatetype,c.limitgoodids,c.limitgoodcateids,c.limitdiscounttype  FROM ' . tablename('ewei_shop_coupon_data') . ' d';
		$sql .= ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
		$sql .= ' where d.id=:id and d.uniacid=:uniacid and d.openid=:openid and d.used=0  limit 1';
		$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $couponid, ':openid' => $openid));
		$merchid = intval($data['merchid']);

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

			$deduct = (double) $data['deduct'];
			$discount = (double) $data['discount'];
			$backtype = (double) $data['backtype'];
			$deductprice = 0;
			$coupondeduct_text = '';

			if ($real_price) {
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
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$packageid = intval($_GPC['packageid']);
		$ispackage = 0;
		$merchdata = $this->merchData();
		extract($merchdata);
		$merch_array = array();
		$allow_sale = true;
		$realprice = 0;
		$nowsendfree = false;
		$isverify = false;
		$isvirtual = false;
		$taskdiscountprice = 0;
		$discountprice = 0;
		$isdiscountprice = 0;
		$deductprice = 0;
		$deductprice2 = 0;
		$deductcredit2 = 0;
		$buyagain_sale = true;
		$iscycelbuy = false;
		$isonlyverifygoods = true;
		$isgift = false;
		$cangift = true;
		$buyagainprice = 0;
		$seckill_price = 0;
		$seckill_payprice = 0;
		$seckill_dispatchprice = 0;
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

		if (is_string($goodsarr)) {
			$goodsstring = htmlspecialchars_decode(str_replace('\\', '', $_GPC['goods']));
			$goodsarr = @json_decode($goodsstring, true);
		}

		if ($_GPC['cardid']) {
			$packageid = 0;
		}

		if (0 < $packageid) {
			$ispackage = 1;
			$isgift = false;
			$cangift = false;

			if (is_array($goodsarr)) {
				$package = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_package') . ' WHERE uniacid = ' . $uniacid . ' and id = ' . $packageid . ' ');
				$package = set_medias($package, array('thumb'));

				if (time() < $package['starttime']) {
					return app_error(AppError::$OrderCreatePackageTimeNotStart);
				}

				if ($package['endtime'] < time()) {
					return app_error(AppError::$OrderCreatePackageTimeEnd);
				}

				$goods = array();
				$goodsprice = 0;
				$marketprice = 0;
				$goods_list = array();

				foreach ($goodsarr as $key => $value) {
					$goods[$key] = pdo_fetch('select id,title,thumb,marketprice from ' . tablename('ewei_shop_goods') . '
                            where id = ' . $value['goodsid'] . ' and uniacid = ' . $uniacid . ' ');
					$option = array();
					$packagegoods = array();

					if (0 < $value['optionid']) {
						$option = pdo_fetch('select title,packageprice from ' . tablename('ewei_shop_package_goods_option') . '
                            where optionid = ' . $value['optionid'] . ' and goodsid=' . $value['goodsid'] . ' and uniacid = ' . $uniacid . ' and pid = ' . $packageid . ' ');
						$goods[$key]['packageprice'] = $option['packageprice'];
					}
					else {
						$packagegoods = pdo_fetch('select title,packageprice from ' . tablename('ewei_shop_package_goods') . '
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

					$goodsprice += price_format($goods[$key]['packageprice']);
					$marketprice += price_format($goods[$key]['marketprice']);
				}

				$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where openid=:openid and deleted=0 and isdefault=1  and uniacid=:uniacid limit 1', array(':uniacid' => $uniacid, ':openid' => $openid));
				$total = count($goods);
				$dispatch_price = $package['freight'];
				$realprice = $goodsprice + $package['freight'];
			}

			$plugin_membercard = p('membercard');
			$card_info = array();
			$availablecard_count = 0;
			$carddiscountprice = 0;

			if ($plugin_membercard) {
				$mycard = $plugin_membercard->get_Mycard($openid);

				if ($mycard['list']) {
					$all_mycardlist = $mycard['list'];
					$card_info['all_mycardlist'] = $all_mycardlist;
					$availablecard_count = $mycard['total'];
				}
			}

			$card_info['availablecard_count'] = $availablecard_count;
			$card_info['cardid'] = 0;
			$card_info['cardname'] = '未选择会员卡';
			$card_info['carddiscount_rate'] = 0;
			$card_info['carddiscountprice'] = $carddiscountprice;
		}
		else {
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

					if (0 < $_GPC['bargain_id']) {
						$data = $g;
					}
					else {
						$sql = 'SELECT id as goodsid,title,type, weight,total,issendfree,isnodiscount, thumb,marketprice,cash,isverify,isforceverifystore,goodssn,productsn,sales,istime,' . ' timestart,timeend,usermaxbuy,maxbuy,unit,buylevels,buygroups,deleted,status,deduct,ispresell,presellprice,preselltimeend,manydeduct,manydeduct2,`virtual`,' . ' discounts,deduct2,ednum,edmoney,edareas,edareas_code,diyformid,diyformtype,diymode,dispatchtype,dispatchid,dispatchprice,' . ' isdiscount,isdiscount_time,isdiscount_discounts ,virtualsend,merchid,merchsale,' . ' buyagain,buyagain_islong,buyagain_condition, buyagain_sale,bargain' . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
						$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $goodsid));
						$data['seckillinfo'] = plugin_run('seckill::getSeckill', $goodsid, $optionid, true, $_W['openid']);
						if (0 < $data['ispresell'] && ($data['preselltimeend'] == 0 || time() < $data['preselltimeend'])) {
							$data['marketprice'] = $data['presellprice'];
						}
					}

					if (empty($data)) {
						$nowsendfree = true;
					}

					if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
						$data['is_task_goods'] = 0;
						$isgift = false;
						$cangift = false;
					}
					else {
						$rank = intval($_SESSION[$goodsid . '_rank']);
						$join_id = intval($_SESSION[$goodsid . '_join_id']);
						$task_goods_data = m('goods')->getTaskGoods($openid, $goodsid, $rank, $join_id, $optionid);

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
						$option = pdo_fetch('select id,title,marketprice,presellprice,goodssn,productsn,stock,`virtual`,weight,cycelbuy_periodic from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $goodsid, ':id' => $optionid));

						if (!empty($option)) {
							$data['optionid'] = $optionid;
							$data['optiontitle'] = $option['title'];
							$data['marketprice'] = 0 < intval($data['ispresell']) && (time() < $data['preselltimeend'] || $data['preselltimeend'] == 0) ? $option['presellprice'] : $option['marketprice'];

							if (!empty($option['weight'])) {
								$data['weight'] = $option['weight'];
							}
						}

						$cycelbuy_periodic = explode(',', $option['cycelbuy_periodic']);
						$cycelbuy_day = $cycelbuy_periodic[0];
						$cycelbuy_unit = $cycelbuy_periodic[1];
						$cycelbuy_num = $cycelbuy_periodic[2];
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
						$isgift = false;
						$cangift = false;
					}

					if (!empty($data['virtual']) || $data['type'] == 2) {
						$isvirtual = true;
					}

					if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
						$g['taskdiscountprice'] = 0;
						$g['lotterydiscountprice'] = 0;
						$g['discountprice'] = 0;
						$g['isdiscountprice'] = 0;
						$g['discounttype'] = 0;
					}
					else {
						$g['taskdiscountprice'] = $prices['taskdiscountprice'];
						$g['discountprice'] = $prices['discountprice'];
						$g['isdiscountprice'] = $prices['isdiscountprice'];
						$g['discounttype'] = $prices['discounttype'];
						$taskdiscountprice += $prices['taskdiscountprice'];
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

					if (!empty($_GPC['bargain_id']) && p('bargain')) {
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
					if ($g['type'] != 5 && $isonlyverifygoods == true) {
						$isonlyverifygoods = false;
					}

					if ($g['type'] == 9) {
						$iscycelbuy = true;
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
								if ($g['ggprice'] < $g['deduct2']) {
									$deccredit2 = $g['ggprice'];
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

				if ($isverify || $isvirtual) {
					$nowsendfree = true;
				}

				if (!empty($allgoods) && !$nowsendfree && !$isonlyverifygoods) {
					$dispatch_array = m('order')->getOrderDispatchPrice($allgoods, $member, $address, $saleset, $merch_array, 1);
					$dispatch_price = $dispatch_array['dispatch_price'] - $dispatch_array['seckill_dispatch_price'];
					$nodispatch_array = $dispatch_array['nodispatch_array'];
					$seckill_dispatchprice = $dispatch_array['seckill_dispatch_price'];
				}

				$cardid = intval($_GPC['cardid']);
				$plugin_membercard = p('membercard');
				$card_info = array();
				$carddiscountprice = 0;
				$carddiscount_rate = 0;
				$card_free_dispatch = false;
				$pure_totalprice = $realprice;
				$cardname = '未选择会员卡';
				$select_cardid = 0;
				if ($plugin_membercard && $cardid) {
					$card_result = $this->caculatecard($cardid, $dispatch_price, $pure_totalprice, $discountprice, $isdiscountprice);

					if ($card_result) {
						$card_info['dispatch_price'] = $dispatch_price;
						$dispatch_price = $card_result['dispatch_price'];
						$carddiscountprice = $card_result['carddiscountprice'];
						$card_info['old_discountprice'] = $discountprice;
						$discountprice = $card_result['discountprice'];
						$card_info['old_isdiscountprice'] = $isdiscountprice;
						$isdiscountprice = $card_result['isdiscountprice'];
						$cardname = $card_result['cardname'];
						$carddiscount_rate = $card_result['carddiscount_rate'];
						$select_cardid = $cardid;
					}
				}

				$card_info['cardname'] = $cardname;
				$card_info['carddiscount_rate'] = $carddiscount_rate;
				$card_info['carddiscountprice'] = $carddiscountprice;
				$card_info['cardid'] = $select_cardid;
				if (0 < $card_info['dispatch_price'] && $dispatch_price == 0) {
					$card_free_dispatch = true;
				}

				if (0 < $card_info['old_discountprice'] && $discountprice == 0) {
					$realprice += $card_info['old_discountprice'];
				}

				if (0 < $card_info['old_isdiscountprice'] && $isdiscountprice == 0) {
					$realprice += $card_info['old_isdiscountprice'];
				}

				$realprice -= $carddiscountprice;

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

				if (empty($dflag)) {
					if (empty($saleset['dispatchnodeduct'])) {
						$deductprice2 += $dispatch_price;
					}
				}
				else {
					$dispatch_price = 0;
				}

				$goodsdata_coupon = array();

				foreach ($allgoods as $g) {
					if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
					}
					else {
						$dis_prices = m('order')->getGoodsDiscountPrice($g, $level);

						if (0 < floatval($g['buyagain'])) {
							if (!m('goods')->canBuyAgain($g) || !empty($g['buyagain_sale'])) {
								$goodsdata_coupon[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $dis_prices['discounttype'], 'isdiscountprice' => $dis_prices['isdiscountprice'], 'discountprice' => $dis_prices['discountprice'], 'isdiscountunitprice' => $dis_prices['isdiscountunitprice'], 'discountunitprice' => $dis_prices['discountunitprice']);
							}
						}
						else {
							$goodsdata_coupon[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid'], 'marketprice' => $g['marketprice'], 'merchid' => $g['merchid'], 'cates' => $g['cates'], 'discounttype' => $dis_prices['discounttype'], 'isdiscountprice' => $dis_prices['isdiscountprice'], 'discountprice' => $dis_prices['discountprice'], 'isdiscountunitprice' => $dis_prices['isdiscountunitprice'], 'discountunitprice' => $dis_prices['discountunitprice']);
						}
					}
				}

				$couponcount = com_run('coupon::consumeCouponCount', $openid, $realprice - $seckill_payprice, $merch_array, $goodsdata_coupon);
				if (empty($goodsdata_coupon) || !$allow_sale) {
					$couponcount = 0;
				}

				if ($iscycelbuy) {
					$realprice += $dispatch_price * $cycelbuy_num;
				}
				else {
					$realprice += $dispatch_price + $seckill_dispatchprice;
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
		}

		if ($is_openmerch == 1) {
			$merchs = $merch_plugin->getMerchs($merch_array);
		}

		$coupon_deductprice = 0;
		$couponid = intval($_GPC['couponid']);

		if ($couponid) {
			$express_fee = $dispatch_price + $seckill_dispatchprice;
			$coupon_price = $this->caculatecoupon($couponid, $goodsdata_coupon, $totalprice, $discountprice, $isdiscountprice, 0, array(), 0, $realprice - $express_fee);
			$coupon_deductprice = $coupon_price['deductprice'];
			if (0 < $isdiscountprice && $coupon_price['isdiscountprice'] == 0) {
				$realprice += $isdiscountprice;

				if (0 < $deductcredit2) {
					$deductcredit2 += $isdiscountprice;
				}

				if (0 < $deductmoney) {
					$deductmoney += $isdiscountprice;
				}

				$isdiscountprice = 0;
			}

			if (0 < $discountprice && $coupon_price['discountprice'] == 0) {
				$realprice += $discountprice;

				if (0 < $deductcredit2) {
					$deductcredit2 += $discountprice;
				}

				if (0 < $deductmoney) {
					$deductmoney += $discountprice;
				}

				$discountprice = 0;
			}

			if ($coupon_deductprice < $deductcredit2) {
				$deductcredit2 -= $coupon_deductprice;
			}

			if ($coupon_deductprice < $deductmoney) {
				$deductmoney -= $coupon_deductprice;
			}

			$deductcredit = ceil($pmoney * $pcredit == 0 ? 0 : $deductmoney / $pmoney * $pcredit);
		}

		$gifts = array();
		if (!$isgift && $cangift) {
			$all_price = 0;

			foreach ($_GPC['goods'] as $key => $val) {
				$all_price += $val['total'] * $val['price'];
			}

			$gifts = pdo_fetchall('select id,goodsid,giftgoodsid,thumb,title,orderprice from ' . tablename('ewei_shop_gift') . '
                    where uniacid = ' . $uniacid . ' and status = 1 and starttime <= ' . time() . ' and endtime >= ' . time() . ' and orderprice <= ' . $all_price . ' and activity = 1 ');
			$giftgoods = array();

			foreach ($gifts as $key => $value) {
				$giftgoods = explode(',', $value['giftgoodsid']);
				$gifts[$key]['canchose'] = 0;

				foreach ($giftgoods as $k => $val) {
					$giftinfo = pdo_fetch('select id,title,thumb,marketprice,total from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and status = 2  and id = ' . $val . ' ');

					if ($giftinfo) {
						$gifts[$key]['gift'][$k] = $giftinfo;
						$isgift = true;
					}

					if ($giftinfo && $giftinfo['total'] != 0) {
						$gifts[$key]['canchose'] = 1;
					}
				}

				$gifts[$key]['gift'] = set_medias($gifts[$key]['gift'], array('thumb'));
				$gifttitle = $gifts[$key]['gift'][0]['title'];
			}

			$gifts = set_medias($gifts, array('thumb'));

			if (!$isgift) {
				$gifts = '';
			}
		}

		$return_array = array();
		$return_array['price'] = $dispatch_price + $seckill_dispatchprice;
		$return_array['couponcount'] = (int) $couponcount;
		$return_array['realprice'] = round($realprice, 2);
		$return_array['deductenough_money'] = $deductenough_money;
		$return_array['deductenough_enough'] = $deductenough_enough;
		$return_array['deductcredit2'] = $deductcredit2;
		$return_array['deductcredit'] = $deductcredit;
		$return_array['deductmoney'] = $deductmoney;
		$return_array['taskdiscountprice'] = $taskdiscountprice;
		$return_array['discountprice'] = $discountprice;
		$return_array['isdiscountprice'] = $isdiscountprice;
		$return_array['merch_showenough'] = (double) $merch_saleset['merch_showenough'];
		$return_array['merch_deductenough_money'] = (double) $merch_saleset['merch_enoughdeduct'];
		$return_array['merch_deductenough_enough'] = (double) $merch_saleset['merch_enoughmoney'];
		$return_array['merchs'] = (array) $merchs;
		$return_array['buyagain'] = round($buyagainprice, 2);
		$return_array['seckill_price'] = $seckill_price - $seckill_payprice;
		$return_array['city_express_state'] = empty($dispatch_array['city_express_state']) ? 0 : $dispatch_array['city_express_state'];
		$return_array['card_info'] = $card_info;
		$return_array['carddiscountprice'] = $carddiscountprice;
		$return_array['card_free_dispatch'] = $card_free_dispatch;
		$return_array['coupon_deductprice'] = $coupon_deductprice;
		$return_array['gifts'] = $gifts;

		if (!empty($nodispatch_array['isnodispatch'])) {
			$return_array['isnodispatch'] = 1;
			$return_array['nodispatch'] = $nodispatch_array['nodispatch'];
		}
		else {
			$return_array['isnodispatch'] = 0;
			$return_array['nodispatch'] = '';
		}

		return app_json($return_array);
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$member = m('member')->getMember($openid);

		if ($member['isblack'] == 1) {
			return app_error(AppError::$UserIsBlack);
		}

		if (p('quick') && !empty($_GPC['fromquick'])) {
			$_GPC['fromcart'] = 0;
		}

		$allow_sale = true;
		$packageid = intval($_GPC['packageid']);
		$package = array();
		$packgoods = array();
		$packageprice = 0;

		if ($_GPC['cardid']) {
			$packageid = 0;
		}

		if (!empty($packageid)) {
			$package = pdo_fetch('SELECT id,title,price,freight,cash,starttime,endtime,dispatchtype FROM ' . tablename('ewei_shop_package') . '
                    WHERE uniacid = ' . $uniacid . ' and id = ' . $packageid . ' and deleted = 0 and status = 1  ORDER BY id DESC');

			if (empty($package)) {
				return app_error(AppError::$OrderCreateNoPackage);
			}

			if (time() < $package['starttime']) {
				return app_error(AppError::$OrderCreatePackageTimeNotStart);
			}

			if ($package['endtime'] < time()) {
				return app_error(AppError::$OrderCreatePackageTimeEnd);
			}

			$packgoods = pdo_fetchall('SELECT id,title,thumb,packageprice,`option`,goodsid FROM ' . tablename('ewei_shop_package_goods') . '
                    WHERE uniacid = ' . $uniacid . ' and pid = ' . $packageid . '  ORDER BY id DESC');

			if (empty($packgoods)) {
				return app_error(AppError::$OrderCreateNoPackage);
			}
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

		if (is_string($goods)) {
			$goodsstring = htmlspecialchars_decode(str_replace('\\', '', $_GPC['goods']));
			$goods = @json_decode($goodsstring, true);
		}

		$goods_tmp = array();

		foreach ($goods as $val) {
			$goods_tmp[] = $val;
		}

		$goods = $goods_tmp;
		$goods[0]['bargain_id'] = $_GPC['bargain_id'];
		$_GPC['bargain_id'] = NULL;

		if (!empty($goods[0]['bargain_id'])) {
			$allow_sale = false;
		}

		if (empty($goods) || !is_array($goods)) {
			return app_error(AppError::$OrderCreateNoGoods);
		}

		$allgoods = array();
		$tgoods = array();
		$totalprice = 0;
		$goodsprice = 0;
		$grprice = 0;
		$weight = 0;
		$taskdiscountprice = 0;
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
				$saleset = false;
			}
			else {
				$saleset['enoughs'] = $sale_plugin->getEnoughs();
			}
		}

		$isvirtual = false;
		$isverify = false;
		$isonlyverifygoods = true;
		$iscycelbuy = false;
		$isendtime = 0;
		$endtime = 0;
		$verifytype = 0;
		$isvirtualsend = false;
		$couponmerchid = 0;
		$giftid = $_GPC['giftid'];

		if ($giftid) {
			$gift = array();
			$canmerge = false;
			$giftdata = pdo_fetch('select giftgoodsid from ' . tablename('ewei_shop_gift') . ' where uniacid = ' . $uniacid . ' and id = ' . $giftid . ' and status = 1 and starttime <= ' . time() . ' and endtime >= ' . time() . ' ');

			if ($giftdata['giftgoodsid']) {
				$giftgoodsid = explode(',', $giftdata['giftgoodsid']);

				foreach ($giftgoodsid as $key => $value) {
					$giftinfo = pdo_fetch('select id as goodsid,title,thumb,status from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and status = 2 and id = ' . $value . ' and deleted = 0 ');
					$gift[$key] = $giftinfo;

					if ($giftinfo) {
						$canmerge = true;
						$gift[$key] = $giftinfo;
					}
				}

				if ($canmerge) {
					$goods = array_merge($goods, $gift);
				}
			}
		}

		$need_deduct_num = 0;
		$need_deduct2_num = 0;

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
				return app_error(AppError::$ParamsError);
			}

			$sql = 'SELECT id as goodsid,title,type, weight,total,issendfree,isnodiscount, thumb,marketprice,cash,isverify,isforceverifystore,verifytype,' . ' goodssn,productsn,sales,istime,timestart,timeend,isendtime,usetime,endtime,ispresell,presellprice,preselltimeend,' . ' usermaxbuy,minbuy,maxbuy,unit,buylevels,buygroups,deleted,' . ' status,deduct,manydeduct,manydeduct2,`virtual`,discounts,deduct2,ednum,edmoney,edareas,edareas_code,diyformtype,diyformid,diymode,' . ' dispatchtype,dispatchid,dispatchprice,merchid,merchsale,cates,' . ' isdiscount,isdiscount_time,isdiscount_discounts, virtualsend,' . ' buyagain,buyagain_islong,buyagain_condition, buyagain_sale,verifygoodsdays,verifygoodslimittype,verifygoodslimitdate,status' . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
			$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $goodsid));
			$data['seckillinfo'] = plugin_run('seckill::getSeckill', $goodsid, $optionid, true, $_W['openid']);
			if (0 < $data['ispresell'] && ($data['preselltimeend'] == 0 || time() < $data['preselltimeend'])) {
				$data['marketprice'] = $data['presellprice'];
			}

			if ($data['type'] == 9) {
				$iscycelbuy = true;
			}

			if ($data['type'] == 5) {
				if ($data['verifygoodslimittype'] == 1) {
					if ($data['verifygoodslimitdate'] <= time()) {
						return app_error(AppError::$GoodsNotFound, '"' . $data['title'] . '"商品使用时间已失效,无法购买 !');
					}

					if ($data['verifygoodslimitdate'] - 1800 <= time()) {
						return app_error(AppError::$GoodsNotFound, '"' . $data['title'] . '"商品的使用时间即将失效,无法购买 !');
					}

					if ($data['verifygoodslimittype'] == 0) {
						if ($data['verifygoodsdays'] * 3600 * 24 <= time()) {
							return app_error(AppError::$GoodsNotFound, '"' . $data['title'] . '"商品使用时间已失效,无法购买 !');
						}

						if ($data['verifygoodsdays'] * 3600 * 24 - 1800 <= time()) {
							return app_error(AppError::$GoodsNotFound, '"' . $data['title'] . '"商品的使用时间即将失效,无法购买 !');
						}
					}
				}
			}
			else {
				$isonlyverifygoods = false;
			}

			if (empty($data['status']) || !empty($data['deleted'])) {
				return app_error(AppError::$GoodsNotFound, $data['title'] . '  已下架!');
			}

			if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
				$data['is_task_goods'] = 0;
				$tgoods = false;
			}
			else {
				$rank = intval($_SESSION[$goodsid . '_rank']);
				$join_id = intval($_SESSION[$goodsid . '_join_id']);
				$task_goods_data = m('goods')->getTaskGoods($openid, $goodsid, $rank, $join_id, $optionid);

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
					$message = str_replace(' ', '', $check_buy['message']);
					return app_error(1, $message);
				}
			}
			else {
				if (0 < $data['minbuy']) {
					if ($goodstotal < $data['minbuy']) {
						return app_error(AppError::$OrderCreateMinBuyLimit, $data['title'] . '  ' . $data['minbuy'] . $unit . '起售!');
					}
				}

				if (0 < $data['maxbuy']) {
					if ($data['maxbuy'] < $goodstotal) {
						return app_error(AppError::$OrderCreateOneBuyLimit, $data['title'] . '  一次限购 ' . $data['maxbuy'] . $unit . '!');
					}
				}

				if (0 < $data['usermaxbuy']) {
					$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $data['goodsid'], ':uniacid' => $uniacid, ':openid' => $openid));

					if ($data['usermaxbuy'] <= $order_goodscount) {
						return app_error(AppError::$OrderCreateMaxBuyLimit, $data['title'] . '  最多限购 ' . $data['usermaxbuy'] . $unit . '!');
					}
				}

				if (!empty($data['is_task_goods'])) {
					if ($data['task_goods']['total'] < $goodstotal) {
						return app_error(AppError::$OrderCreateMaxBuyLimit, $data['title'] . '  任务活动优惠限购 ' . $data['task_goods']['total'] . $unit . '!');
					}
				}

				if ($data['istime'] == 1) {
					if (time() < $data['timestart']) {
						return app_error(AppError::$OrderCreateTimeNotStart, $data['title'] . '  限购时间未到!');
					}

					if ($data['timeend'] < time()) {
						return app_error(AppError::$OrderCreateTimeEnd, $data['title'] . '  限购时间已过!');
					}
				}

				$levelid = intval($member['level']);
				$groupid = intval($member['groupid']);

				if ($data['buylevels'] != '') {
					$buylevels = explode(',', $data['buylevels']);

					if (!in_array($levelid, $buylevels)) {
						return app_error(AppError::$OrderCreateMemberLevelLimit, '您的会员等级无法购买 ' . $data['title'] . '!');
					}
				}

				if ($data['buygroups'] != '') {
					$buygroups = explode(',', $data['buygroups']);

					if (!in_array($groupid, $buygroups)) {
						return app_error(AppError::$OrderCreateMemberGroupLimit, '您所在会员组无法购买 ' . $data['title'] . '!');
					}
				}
			}

			if (!empty($optionid)) {
				$option = pdo_fetch('select id,title,marketprice,presellprice,goodssn,productsn,stock,`virtual`,weight,cycelbuy_periodic from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $goodsid, ':id' => $optionid));

				if (empty($option)) {
					return app_error(1, $data['title'] . '规格或已被删除 ,请重新选择规格');
				}

				if ($data['seckillinfo'] && $data['seckillinfo']['status'] == 0) {
				}
				else {
					if ($option['stock'] != -1) {
						if (empty($option['stock'])) {
							return app_error(AppError::$OrderCreateStockError, $data['title'] . ' ' . $option['title'] . ' 库存不足!');
						}
					}
				}

				$data['optionid'] = $optionid;
				$data['optiontitle'] = $option['title'];
				$data['marketprice'] = 0 < intval($data['ispresell']) && (time() < $data['preselltimeend'] || $data['preselltimeend'] == 0) ? $option['presellprice'] : $option['marketprice'];
				$packageoption = array();

				if ($packageid) {
					$packageoption = pdo_fetch('select packageprice from ' . tablename('ewei_shop_package_goods_option') . '
                            where uniacid = ' . $uniacid . ' and goodsid = ' . $goodsid . ' and optionid = ' . $optionid . ' and pid = ' . $packageid . ' ');
					$data['marketprice'] = $packageoption['packageprice'];
					$packageprice += $packageoption['packageprice'];
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

				$cycelbuy_periodic = explode(',', $option['cycelbuy_periodic']);
				$cycelbuy_day = $cycelbuy_periodic[0];
				$cycelbuy_unit = $cycelbuy_periodic[1];
				$cycelbuy_num = $cycelbuy_periodic[2];
			}
			else {
				if ($packageid) {
					$pg = pdo_fetch('select packageprice from ' . tablename('ewei_shop_package_goods') . '
                                where uniacid = ' . $uniacid . ' and goodsid = ' . $goodsid . ' and pid = ' . $packageid . ' ');
					$data['marketprice'] = $pg['packageprice'];
					$packageprice += $pg['packageprice'];
				}

				if ($data['stock'] != -1) {
					if (empty($data['stock']) && $data['status'] != 2) {
						return app_error(AppError::$OrderCreateStockError, $data['title'] . '  库存不足!');
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
			else if (0 < $_GPC['fromquick']) {
				$cartdata = pdo_fetch('select id,diyformdataid,diyformfields,diyformdata from ' . tablename('ewei_shop_quick_cart') . ' ' . ' where goodsid=:goodsid and optionid=:optionid and openid=:openid and deleted=0 order by id desc limit 1', array(':goodsid' => $data['goodsid'], ':optionid' => intval($data['optionid']), ':openid' => $openid));

				if (!empty($cartdata)) {
					$data['diyformdataid'] = $cartdata['diyformdataid'];
					$data['diyformdata'] = $cartdata['diyformdata'];
					$data['diyformfields'] = $cartdata['diyformfields'];
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

			if ($data['status'] == 2) {
				$data['marketprice'] = 0;
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
				$gprice = $data['marketprice'] * $goodstotal;
				$goodsprice += $gprice;
				$prices = m('order')->getGoodsDiscountPrice($data, $level);

				if (empty($packageid)) {
					$data['ggprice'] = $prices['price'];
				}
				else {
					$data['ggprice'] = $data['marketprice'];
					$prices = array();
				}

				$data['taskdiscountprice'] = $prices['taskdiscountprice'];
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

				if ($prices['discounttype'] == 1) {
					$isdiscountprice += $prices['isdiscountprice'];
					$discountprice += $prices['discountprice'];

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

			$merch_array[$merchid]['ggprice'] += $data['ggprice'];
			$totalprice += $data['ggprice'];

			if ($ismerch == 1) {
				$merch_plugin = p('merch');

				foreach ($merch_array as $key => $value) {
					if (0 < $key) {
						$merch_array[$key]['set'] = $merch_plugin->getSet('sale', $key);
						$merch_array[$key]['enoughs'] = $merch_plugin->getEnoughs($merch_array[$key]['set']);
					}
				}
			}

			if ($data['isverify'] == 2) {
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

			if (!empty($data['virtual']) || $data['type'] == 2) {
				$isvirtual = true;

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
						if ($data['ggprice'] < $data['deduct2']) {
							$deduct_price2 = $data['ggprice'];
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
		if (1 < count($goods) && !empty($tgoods)) {
			return app_error(AppError::$OrderCreateTaskGoodsCart, $tgoods['title'] . '不能放入购物车下单,请单独购买!');
		}

		if (empty($allgoods)) {
			return app_error(AppError::$OrderCreateNoGoods);
		}

		$addressid = intval($_GPC['addressid']);
		$address = false;
		if (!empty($addressid) && $dispatchtype == 0 && !$isonlyverifygoods) {
			$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where id=:id and openid=:openid and uniacid=:uniacid   limit 1', array(':uniacid' => $uniacid, ':openid' => $openid, ':id' => $addressid));

			if (empty($address)) {
				return app_error(AppError::$AddressNotFound);
			}

			if (empty($address['province']) || empty($address['city']) || empty($address['area'])) {
				app_error(AppError::$AddressNotFound);
			}
		}

		if (!$isvirtual && !$isverify && $dispatchtype == 0 && !$isonlyverifygoods) {
			$dispatch_array = m('order')->getOrderDispatchPrice($allgoods, $member, $address, $saleset, $merch_array, 2);
			$dispatch_price = $dispatch_array['dispatch_price'] - $dispatch_array['seckill_dispatch_price'];
			$seckill_dispatchprice = $dispatch_array['seckill_dispatch_price'];
			$nodispatch_array = $dispatch_array['nodispatch_array'];

			if (!empty($nodispatch_array['isnodispatch'])) {
				return app_error(AppError::$OrderCreateNoDispatch, $nodispatch_array['nodispatch']);
			}
		}

		$cardid = intval($_GPC['cardid']);
		$plugin_membercard = p('membercard');
		$card_free_dispatch = false;
		$card_info = array();
		$carddiscountprice = 0;
		$pure_totalprice = $totalprice;
		if ($plugin_membercard && $cardid) {
			$card_result = $this->caculatecard($cardid, $dispatch_price, $pure_totalprice, $discountprice, $isdiscountprice);

			if ($card_result) {
				$card_info['dispatch_price'] = $dispatch_price;
				$dispatch_price = $card_result['dispatch_price'];
				$carddiscountprice = $card_result['carddiscountprice'];
				$card_info['old_discountprice'] = $discountprice;
				$discountprice = $card_result['discountprice'];
				$card_info['old_isdiscountprice'] = $isdiscountprice;
				$isdiscountprice = $card_result['isdiscountprice'];
				$card_info['cardname'] = $card_result['cardname'];
				$card_info['carddiscount_rate'] = $card_result['carddiscount_rate'];
				$card_info['carddiscountprice'] = $carddiscountprice;
				$card_info['cardid'] = $cardid;
			}
		}

		if (0 < $card_info['old_discountprice'] && $discountprice == 0) {
			$totalprice += $card_info['old_discountprice'];
		}

		if (0 < $card_info['old_isdiscountprice'] && $isdiscountprice == 0) {
			$totalprice += $card_info['old_isdiscountprice'];
		}

		if (0 < $card_info['dispatch_price'] && $dispatch_price == 0) {
			$card_free_dispatch = true;
		}

		$totalprice -= $carddiscountprice;

		if ($is_openmerch == 1) {
			foreach ($merch_array as $key => $value) {
				if (0 < $key) {
					if (!$packageid) {
						$merch_array[$key]['set'] = $merch_plugin->getSet('sale', $key);
						$merch_array[$key]['enoughs'] = $merch_plugin->getEnoughs($merch_array[$key]['set']);
					}
				}
			}

			if ($allow_sale) {
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

		if ($saleset) {
			if ($allow_sale) {
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
		}

		$totalprice -= $deductenough;
		$couponid = intval($_GPC['couponid']);
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

		$return_array = $this->caculatecoupon($couponid, $goodsdata_coupon, $totalprice, $discountprice, $isdiscountprice, 1, $discountprice_array, $merchisdiscountprice, $totalprice);
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

		if ($isonlyverifygoods) {
			$addressid = 0;
		}

		if ($iscycelbuy) {
			$totalprice += $dispatch_price * $cycelbuy_num;
		}
		else {
			$totalprice += $dispatch_price + $seckill_dispatchprice;
		}

		if ($saleset && empty($saleset['dispatchnodeduct'])) {
			$deductprice2 += $dispatch_price;
		}

		if (empty($goods[0]['bargain_id']) || !p('bargain')) {
			$deductcredit = 0;
			$deductmoney = 0;
			$deductcredit2 = 0;

			if ($sale_plugin) {
				if (!empty($_GPC['deduct']) && $_GPC['deduct'] != 'false') {
					$credit = $member['credit1'];

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

						$deductcredit = round($deductmoney / $pmoney * $pcredit, 2);
					}
				}

				$totalprice -= $deductmoney;
			}

			if (!empty($saleset['moneydeduct'])) {
				if (!empty($_GPC['deduct2']) && $_GPC['deduct2'] != 'false') {
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

		if (is_string($carrier)) {
			$carrierstring = htmlspecialchars_decode(str_replace('\\', '', $carrier));
			$carrier = @json_decode($carrierstring, true);
		}

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
				return app_error(AppError::$OrderCreateNoGoods);
			}

			$totalprice = $bargain_act['now_price'] + $dispatch_price;

			if (!pdo_update('ewei_shop_bargain_actor', array('status' => 1), array('id' => $goods[0]['bargain_id'], 'openid' => $_W['openid']))) {
				return app_error(AppError::$OrderCreateFalse);
			}

			$ordersn = substr_replace($ordersn, 'KJ', 0, 2);
		}

		$is_package = 0;

		if (!empty($packageid)) {
			$goodsprice = price_format($packageprice);

			if ($package['dispatchtype'] == 1) {
				$dispatch_array = m('order')->getOrderDispatchPrice($allgoods, $member, $address, false, $merch_array, 0);
				$dispatch_price = $dispatch_array['dispatch_price'] - $dispatch_array['seckill_dispatch_price'];
			}
			else {
				$dispatch_price = $package['freight'];
			}

			$totalprice = $packageprice + $dispatch_price;
			$is_package = 1;
			$discountprice = 0;
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
		$order['discountprice'] = $discountprice;
		if (!empty($goods[0]['bargain_id']) && p('bargain')) {
			$order['discountprice'] = 0;
		}

		$order['isdiscountprice'] = $isdiscountprice;
		$order['merchisdiscountprice'] = $merchisdiscountprice;
		$order['cash'] = $cash;
		$order['status'] = 0;
		$order['iswxappcreate'] = 1;
		$order['remark'] = trim($_GPC['remark']);
		$order['addressid'] = empty($dispatchtype) ? $addressid : 0;
		$order['goodsprice'] = $goodsprice;
		$order['dispatchtype'] = $dispatchtype;
		$order['dispatchid'] = $dispatchid;
		$order['storeid'] = $carrierid;
		$order['carrier'] = $carriers;
		$order['createtime'] = time();
		$order['olddispatchprice'] = $dispatch_price + $seckill_dispatchprice;
		$order['couponid'] = $couponid;
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
		$order['coupongoodprice'] = $coupongoodprice;

		if ($iscycelbuy) {
			$order['iscycelbuy'] = 1;
			$order['cycelbuy_periodic'] = implode(',', $cycelbuy_periodic);
			$order['dispatchprice'] = $dispatch_price * $cycelbuy_num;
			$order['cycelbuy_predict_time'] = $_GPC['receipttime'];
		}
		else {
			$order['dispatchprice'] = $dispatch_price + $seckill_dispatchprice;
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
			$order['city_express_state'] = empty($dispatch_array['city_express_state']) == true ? 0 : $dispatch_array['city_express_state'];
		}
		else {
			$order['isparent'] = 1;
			$order['merchid'] = 0;
		}

		if ($diyform_plugin) {
			$diydata = $_GPC['diydata'];

			if (is_string($diydata)) {
				$diyformdatastring = htmlspecialchars_decode(str_replace('\\', '', $diydata));
				$diydata = @json_decode($diyformdatastring, true);
			}

			if (is_array($diydata) && !empty($order_formInfo)) {
				$diyform_data = $diyform_plugin->getInsertData($fields, $diydata, true);
				$idata = $diyform_data['data'];
				$order['diyformfields'] = $diyform_plugin->getInsertFields($fields);
				$order['diyformdata'] = $idata;
				$order['diyformid'] = $order_formInfo['id'];
			}
		}

		if (!empty($address)) {
			$order['address'] = iserializer($address);
		}

		pdo_insert('ewei_shop_order', $order);
		$orderid = pdo_insertid();
		if (!empty($goods[0]['bargain_id']) && p('bargain')) {
			pdo_update('ewei_shop_bargain_actor', array('order' => $orderid), array('id' => $goods[0]['bargain_id'], 'openid' => $_W['openid']));
		}

		if (!empty($card_info) && $orderid) {
			$plugin_membercard->member_card_use_record($orderid, $cardid, $carddiscountprice, $openid, $card_free_dispatch);
		}

		if ($multiple_order == 0) {
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
				$order_goods['goodssn'] = $goods['goodssn'];
				$order_goods['productsn'] = $goods['productsn'];
				$order_goods['realprice'] = $goods['ggprice'];
				$order_goods['oldprice'] = $goods['ggprice'];
				$isfullback = $this->isfullbackgoods($goods['goodsid'], $goods['optionid']);
				$order_goods['fullbackid'] = $isfullback;

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
			$ch_order_data = m('order')->getChildOrderPrice($order, $allgoods, $dispatch_array, $merch_array, $sale_plugin, $discountprice_array);

			foreach ($merch_array as $key => $value) {
				$order['ordersn'] = m('common')->createNO('order', 'ordersn', 'ME');
				$merchid = $key;
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
			$order_v = pdo_fetch('select id,ordersn, price,openid,dispatchtype,addressid,carrier,status,isverify,deductcredit2,`virtual`,isvirtual,couponid,isvirtualsend,isparent,paytype,merchid,agentid,createtime,buyagainprice,istrade,tradestatus from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and id = :id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $orderid));
			$virtual_res = com('virtual')->pay_befo($order_v);
			if (is_array($virtual_res) && $virtual_res['message']) {
				return app_error(1, $virtual_res['message']);
			}
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
			m('order')->setStocksAndCredits($orderid, 0);
		}
		else {
			if (isset($allgoods[0])) {
				$vgoods = $allgoods[0];
				pdo_update('ewei_shop_goods', array('sales' => $vgoods['sales'] + $vgoods['total']), array('id' => $vgoods['goodsid']));
			}
		}

		$plugincoupon = com('coupon');

		if ($plugincoupon) {
			if (0 < $couponmerchid && $multiple_order == 1) {
				$oid = $couponorderid;
			}
			else {
				$oid = $orderid;
			}

			$plugincoupon->useConsumeCoupon($oid);
		}

		if (!empty($tgoods)) {
			$rank = intval($_SESSION[$tgoods['goodsid'] . '_rank']);
			$join_id = intval($_SESSION[$tgoods['goodsid'] . '_join_id']);
			m('goods')->getTaskGoods($tgoods['openid'], $tgoods['goodsid'], $rank, $join_id, $tgoods['optionid'], $tgoods['total']);
			$_SESSION[$tgoods['goodsid'] . '_rank'] = 0;
			$_SESSION[$tgoods['goodsid'] . '_join_id'] = 0;
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

		unset($_SESSION[$openid . '_order_create']);
		return app_json(array('orderid' => $orderid));
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
		$diyformdata = $_GPC['diyformdata'];

		if (is_string($diyformdata)) {
			$diyformdatastring = htmlspecialchars_decode(str_replace('\\', '', $_GPC['diyformdata']));
			$diyformdata = @json_decode($diyformdatastring, true);
		}

		if (empty($goodsid) || empty($diyformdata)) {
			return app_error(AppError::$ParamsError);
		}

		$data = $this->singleDiyformData($goodsid);
		extract($data);

		if ($diyformtype == 2) {
			$diyformid = 0;
		}
		else {
			$diyformid = $goods_data['diyformid'];
		}

		$fields = $formInfo['fields'];
		$insert_data = $diyform_plugin->getInsertData($fields, $diyformdata, true);
		$idata = $insert_data['data'];
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

		return app_json(array('gdid' => $gdid));
	}

	public function getcardprice()
	{
		global $_GPC;
		$cardid = intval($_GPC['cardid']);
		$dispatch_price = $_GPC['dispatch_price'];
		$goodsprice = $_GPC['goodsprice'];
		$discountprice = $_GPC['discountprice'];
		$isdiscountprice = $_GPC['isdiscountprice'];
		$result = $this->caculatecard($cardid, $dispatch_price, $goodsprice, $discountprice, $isdiscountprice);
		return app_json($result);
	}

	public function caculatecard($cardid, $dispatch_price, $totalprice, $discountprice = 0, $isdiscountprice = 0)
	{
		global $_W;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];

		if (empty($cardid)) {
			return false;
		}

		$plugin_membercard = p('membercard');

		if (!$plugin_membercard) {
			return NULL;
		}

		$card = $plugin_membercard->getMemberCard($cardid);

		if (empty($card)) {
			return NULL;
		}

		if ($card['isdelete']) {
			return app_error(AppError::$CardisDel);
		}

		$carddiscountprice = 0;
		$carddiscount_rate = 0;

		if ($card['shipping']) {
			$dispatch_price = 0;
		}

		$discount_rate = floatval($card['discount_rate']);
		if (empty($card['member_discount']) && $discount_rate == 0) {
			$discount_rate = 10;
		}

		if (0 < $isdiscountprice && empty($card['discount'])) {
			$totalprice += $isdiscountprice;
			$isdiscountprice = 0;
		}
		else {
			if (0 < $discountprice && empty($card['discount'])) {
				$totalprice += $discountprice;
				$discountprice = 0;
			}
		}

		$carddiscountprice = round($totalprice * (10 - $discount_rate) * 0.10000000000000001, 2);
		$carddiscount_rate = $discount_rate;
		$totalprice -= $carddiscountprice;
		$return_array = array();
		$return_array['carddiscount_rate'] = $carddiscount_rate;
		$return_array['carddiscountprice'] = $carddiscountprice;
		$return_array['dispatch_price'] = $dispatch_price;
		$return_array['totalprice'] = $totalprice;
		$return_array['discountprice'] = $discountprice;
		$return_array['isdiscountprice'] = $isdiscountprice;
		$return_array['cardname'] = $card['name'];
		$return_array['cardid'] = $cardid;
		return $return_array;
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
