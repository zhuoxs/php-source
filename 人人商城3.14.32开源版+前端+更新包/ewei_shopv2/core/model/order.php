<?php

class Order_EweiShopV2Model
{
	public function fullback($orderid)
	{
		global $_W;
		$uniacid = $_W['uniacid'];
		$order_goods = pdo_fetchall('select o.openid,og.optionid,og.goodsid,og.price,og.total from ' . tablename('ewei_shop_order_goods') . ' as og
                    left join ' . tablename('ewei_shop_order') . ' as o on og.orderid = o.id
                    where og.uniacid = ' . $uniacid . ' and og.orderid = ' . $orderid . ' ');

		foreach ($order_goods as $key => $value) {
			if (0 < $value['optionid']) {
				$goods = pdo_fetch('select g.hasoption,g.id,go.goodsid,go.isfullback from ' . tablename('ewei_shop_goods') . ' as g
                left join ' . tablename('ewei_shop_goods_option') . ' as go on go.goodsid = :id and go.id = ' . $value['optionid'] . '
                 where g.id=:id and g.uniacid=:uniacid limit 1', array(':id' => $value['goodsid'], ':uniacid' => $uniacid));
			}
			else {
				$goods = pdo_fetch('select * from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $value['goodsid'], ':uniacid' => $uniacid));
			}

			if (0 < $goods['isfullback']) {
				$fullbackgoods = pdo_fetch('SELECT id,minallfullbackallprice,maxallfullbackallprice,minallfullbackallratio,maxallfullbackallratio,`day`,
                          fullbackprice,fullbackratio,status,hasoption,marketprice,`type`,startday
                          FROM ' . tablename('ewei_shop_fullback_goods') . ' WHERE uniacid = ' . $uniacid . ' and status=1 and goodsid = ' . $value['goodsid'] . ' limit 1');
				$condition = '';
				if (!empty($fullbackgoods) && $goods['hasoption'] && 0 < $value['optionid']) {
					$option = pdo_fetch('select id,title,allfullbackprice,allfullbackratio,fullbackprice,fullbackratio,`day` from ' . tablename('ewei_shop_goods_option') . ' 
                        where id=:id and goodsid=:goodsid and uniacid=:uniacid and isfullback = 1 limit 1', array(':uniacid' => $uniacid, ':goodsid' => $value['goodsid'], ':id' => $value['optionid']));

					if (!empty($option)) {
						$fullbackgoods['minallfullbackallprice'] = $option['allfullbackprice'];
						$fullbackgoods['minallfullbackallratio'] = $option['allfullbackratio'];
						$fullbackgoods['fullbackprice'] = $option['fullbackprice'];
						$fullbackgoods['fullbackratio'] = $option['fullbackratio'];
						$fullbackgoods['day'] = $option['day'];
						$fullbackgoods['optionid'] = $option['id'];
						$condition .= 'optionid=:optionid and ';
					}
				}

				if (!empty($fullbackgoods)) {
					$fullbackgoods['startday'] = $fullbackgoods['startday'] - 1;
					$data = array('uniacid' => $uniacid, 'orderid' => $orderid, 'openid' => $value['openid'], 'day' => $fullbackgoods['day'], 'fullbacktime' => strtotime('+' . $fullbackgoods['startday'] . ' days'), 'goodsid' => $value['goodsid'], 'createtime' => time());
					$condition .= 'uniacid=:uniacid AND openid =:openid AND orderid=:orderid AND goodsid=:goodsid';
					$params = array(':uniacid' => $uniacid, ':openid' => $data['openid'], ':orderid' => $orderid, ':goodsid' => $data['goodsid']);

					if (!empty($option)) {
						$data['optionid'] = $fullbackgoods['optionid'];
						$params[':optionid'] = $option['id'];
					}

					if (0 < $fullbackgoods['type']) {
						$data['price'] = $value['price'] * $fullbackgoods['minallfullbackallratio'] / 100;
						$data['priceevery'] = $value['price'] * $fullbackgoods['fullbackratio'] / 100;
					}
					else {
						$data['price'] = $value['total'] * $fullbackgoods['minallfullbackallprice'];
						$data['priceevery'] = $value['total'] * $fullbackgoods['fullbackprice'];
					}

					$has_record = pdo_fetch('select id from ' . tablename('ewei_shop_fullback_log') . (' where ' . $condition), $params);

					if (empty($has_record)) {
						pdo_insert('ewei_shop_fullback_log', $data);
					}
				}
			}
		}
	}

	public function fullbackstop($orderid)
	{
		global $_W;
		global $_S;
		$uniacid = $_W['uniacid'];
		$shopset = $_S['shop'];
		$fullback_log = pdo_fetch('select * from ' . tablename('ewei_shop_fullback_log') . ' where uniacid = ' . $uniacid . ' and orderid = ' . $orderid . ' ');
		pdo_update('ewei_shop_fullback_log', array('isfullback' => 1), array('id' => $fullback_log['id'], 'uniacid' => $uniacid));
	}

	/**
     * 支付成功
     * @global type $_W
     * @param type $params
     */
	public function payResult($params)
	{
		global $_W;
		$fee = intval($params['fee']);
		$data = array('status' => $params['result'] == 'success' ? 1 : 0);
		$ordersn_tid = $params['tid'];
		$ordersn = rtrim($ordersn_tid, 'TR');
		$order = pdo_fetch('select id,uniacid,ordersn, price,openid,dispatchtype,addressid,carrier,status,isverify,deductcredit2,`virtual`,isvirtual,couponid,isvirtualsend,isparent,paytype,merchid,agentid,createtime,buyagainprice,istrade,tradestatus,iscycelbuy from ' . tablename('ewei_shop_order') . ' where  ordersn=:ordersn and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':ordersn' => $ordersn));
		$plugincoupon = com('coupon');

		if ($plugincoupon) {
			$plugincoupon->useConsumeCoupon($order['id']);
		}

		if (1 <= $order['status']) {
			return true;
		}

		$orderid = $order['id'];
		$ispeerpay = $this->checkpeerpay($orderid);

		if (!empty($ispeerpay)) {
			$peerpay_info = (double) pdo_fetchcolumn('select SUM(price) price from ' . tablename('ewei_shop_order_peerpay_payinfo') . ' where pid=:pid limit 1', array(':pid' => $ispeerpay['id']));

			if ($peerpay_info < $ispeerpay['peerpay_realprice']) {
				return NULL;
			}

			pdo_update('ewei_shop_order', array('status' => 0), array('id' => $order['id']));
			$order['status'] = 0;
			pdo_update('ewei_shop_order_peerpay', array('status' => 1), array('id' => $ispeerpay['id']));
			$params['type'] = 'peerpay';
		}

		if ($params['from'] == 'return') {
			$seckill_result = plugin_run('seckill::setOrderPay', $order['id']);

			if ($seckill_result == 'refund') {
				return 'seckill_refund';
			}

			$address = false;

			if (empty($order['dispatchtype'])) {
				$address = pdo_fetch('select realname,mobile,address from ' . tablename('ewei_shop_member_address') . ' where id=:id limit 1', array(':id' => $order['addressid']));
			}

			$carrier = false;
			if ($order['dispatchtype'] == 1 || $order['isvirtual'] == 1) {
				$carrier = unserialize($order['carrier']);
			}

			m('verifygoods')->createverifygoods($order['id']);

			if ($params['type'] == 'cash') {
				if ($order['isparent'] == 1) {
					$change_data = array();
					$change_data['merchshow'] = 1;
					pdo_update('ewei_shop_order', $change_data, array('id' => $order['id']));
					$this->setChildOrderPayResult($order, 0, 0);
					$merchSql = 'SELECT id,merchid FROM ' . tablename('ewei_shop_order') . ' WHERE uniacid = ' . intval($order['uniacid']) . ' AND parentid = ' . intval($order['id']);
					$merchData = pdo_fetchall($merchSql);

					foreach ($merchData as $mk => $mv) {
						com_run('printer::sendOrderMessage', $mv['id']);
					}
				}
				else {
					com_run('printer::sendOrderMessage', $order['id']);
				}

				return true;
			}

			if ($order['istrade'] == 0) {
				if ($order['status'] == 0) {
					if (!empty($order['virtual']) && com('virtual')) {
						return com('virtual')->pay($order, $ispeerpay);
					}

					if ($order['isvirtualsend']) {
						return $this->payVirtualSend($order['id'], $ispeerpay);
					}

					$isonlyverifygoods = $this->checkisonlyverifygoods($order['id']);
					$time = time();
					$change_data = array();

					if ($isonlyverifygoods) {
						$change_data['status'] = 2;
					}
					else {
						$change_data['status'] = 1;
					}

					$change_data['paytime'] = $time;

					if ($order['isparent'] == 1) {
						$change_data['merchshow'] = 1;
					}

					pdo_update('ewei_shop_order', $change_data, array('id' => $order['id']));

					if ($order['iscycelbuy'] == 1) {
						if (p('cycelbuy')) {
							p('cycelbuy')->cycelbuy_periodic($order['id']);
						}
					}

					if ($order['isparent'] == 1) {
						$this->setChildOrderPayResult($order, $time, 1);
					}

					$this->setStocksAndCredits($orderid, 1);

					if (com('coupon')) {
						com('coupon')->sendcouponsbytask($order['id']);
						com('coupon')->backConsumeCoupon($order['id']);
					}

					if ($order['isparent'] == 1) {
						$child_list = $this->getChildOrder($order['id']);

						foreach ($child_list as $k => $v) {
							m('notice')->sendOrderMessage($v['id']);
						}
					}
					else {
						m('notice')->sendOrderMessage($order['id']);
					}

					if ($order['isparent'] == 1) {
						$merchSql = 'SELECT id,merchid FROM ' . tablename('ewei_shop_order') . ' WHERE uniacid = ' . intval($order['uniacid']) . ' AND parentid = ' . intval($order['id']);
						$merchData = pdo_fetchall($merchSql);

						foreach ($merchData as $mk => $mv) {
							com_run('printer::sendOrderMessage', $mv['id']);
						}
					}
					else {
						com_run('printer::sendOrderMessage', $order['id']);
					}

					if (p('commission')) {
						p('commission')->checkOrderPay($order['id']);
					}

					$this->afterPayResult($order, $ispeerpay);
				}
			}
			else {
				$time = time();
				$change_data = array();
				$count_ordersn = $this->countOrdersn($ordersn_tid);
				if ($order['status'] == 0 && $count_ordersn == 1) {
					$change_data['status'] = 1;
					$change_data['tradestatus'] = 1;
					$change_data['paytime'] = $time;
				}
				else {
					if ($order['status'] == 1 && $order['tradestatus'] == 1 && $count_ordersn == 2) {
						$change_data['tradestatus'] = 2;
						$change_data['tradepaytime'] = $time;
					}
				}

				pdo_update('ewei_shop_order', $change_data, array('id' => $order['id']));
				if ($order['status'] == 0 && $count_ordersn == 1) {
					m('notice')->sendOrderMessage($order['id']);
				}
			}

			return true;
		}

		return false;
	}

	/**
     * 子订单支付成功
     * @global type $_W
     * @param type $order
     * @param type $time
     */
	public function setChildOrderPayResult($order, $time, $type)
	{
		global $_W;
		$orderid = $order['id'];
		$list = $this->getChildOrder($orderid);

		if (!empty($list)) {
			$change_data = array();

			if ($type == 1) {
				$change_data['status'] = 1;
				$change_data['paytime'] = $time;
			}

			$change_data['merchshow'] = 0;

			foreach ($list as $k => $v) {
				if ($v['status'] == 0) {
					pdo_update('ewei_shop_order', $change_data, array('id' => $v['id']));
				}
			}
		}
	}

	/**
     * 设置订单支付方式
     * @global type $_W
     * @param type $orderid
     * @param type $paytype
     */
	public function setOrderPayType($orderid, $paytype, $ordersn = '')
	{
		global $_W;
		$count_ordersn = 1;
		$change_data = array();

		if (!empty($ordersn)) {
			$count_ordersn = $this->countOrdersn($ordersn);
		}

		if ($count_ordersn == 2) {
			$change_data['tradepaytype'] = $paytype;
		}
		else {
			$change_data['paytype'] = $paytype;
		}

		pdo_update('ewei_shop_order', $change_data, array('id' => $orderid));

		if (!empty($orderid)) {
			pdo_update('ewei_shop_order', array('paytype' => $paytype), array('parentid' => $orderid));
		}
	}

	/**
     * 获取子订单
     * @global type $_W
     * @param type $orderid
     */
	public function getChildOrder($orderid)
	{
		global $_W;
		$list = pdo_fetchall('select id,ordersn,status,finishtime,couponid,merchid  from ' . tablename('ewei_shop_order') . ' where  parentid=:parentid and uniacid=:uniacid', array(':parentid' => $orderid, ':uniacid' => $_W['uniacid']));
		return $list;
	}

	/**
     * 虚拟商品自动发货
     * @param int $orderid
     * @return bool?
     */
	public function payVirtualSend($orderid = 0, $ispeerpay = false)
	{
		global $_W;
		global $_GPC;
		$order = pdo_fetch('select id,uniacid,ordersn, price,openid,dispatchtype,addressid,carrier,status,isverify,deductcredit2,`virtual`,isvirtual,couponid,isvirtualsend,isparent,paytype,merchid,agentid,createtime,buyagainprice,istrade,tradestatus,iscycelbuy from ' . tablename('ewei_shop_order') . ' where  id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $orderid));
		$order_goods = pdo_fetch('select g.virtualsend,g.virtualsendcontent from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.uniacid=:uniacid limit 1', array(':uniacid' => $order['uniacid'], ':orderid' => $orderid));
		$time = time();
		pdo_update('ewei_shop_order', array('virtualsend_info' => $order_goods['virtualsendcontent'], 'status' => '3', 'paytime' => $time, 'sendtime' => $time, 'finishtime' => $time), array('id' => $orderid));
		$this->fullback($order['id']);
		$this->setStocksAndCredits($orderid, 1);
		$this->setStocksAndCredits($orderid, 3);
		m('member')->upgradeLevel($order['openid'], $order['id']);
		$this->setGiveBalance($orderid, 1);

		if (com('coupon')) {
			com('coupon')->sendcouponsbytask($order['id']);
		}

		if (com('coupon') && !empty($order['couponid'])) {
			com('coupon')->backConsumeCoupon($order['id']);
		}

		m('notice')->sendOrderMessage($orderid);
		com_run('printer::sendOrderMessage', $orderid);

		if (p('commission')) {
			p('commission')->checkOrderPay($order['id']);
			p('commission')->checkOrderFinish($order['id']);
		}

		$this->afterPayResult($order, $ispeerpay);
		return true;
	}

	public function afterPayResult($order, $ispeerpay = false)
	{
		if (p('task')) {
			if (0 < $order['deductcredit2']) {
				$order['price'] = floatval($order['price']) + floatval($order['deductcredit2']);
			}

			if (0 < $order['deductcredit']) {
				$order['price'] = floatval($order['price']) + floatval($order['deductprice']);
			}

			if ($order['agentid']) {
				p('task')->checkTaskReward('commission_order', 1);
			}

			p('task')->checkTaskReward('cost_total', $order['price']);
			p('task')->checkTaskReward('cost_enough', $order['price']);
			p('task')->checkTaskReward('cost_count', 1);
			$goodslist = pdo_fetchall('SELECT goodsid FROM ' . tablename('ewei_shop_order_goods') . ' WHERE orderid = :orderid AND uniacid = :uniacid', array(':orderid' => $order['id'], ':uniacid' => $order['uniacid']));

			foreach ($goodslist as $item) {
				p('task')->checkTaskReward('cost_goods' . $item['goodsid'], 1, $order['openid']);
			}

			if (0 < $order['deductcredit2']) {
				$order['price'] = floatval($order['price']) + floatval($order['deductcredit2']);
			}

			if (0 < $order['deductcredit']) {
				$order['price'] = floatval($order['price']) + floatval($order['deductprice']);
			}

			p('task')->checkTaskProgress($order['price'], 'order_all', '', $order['openid']);
			$goodslist = pdo_fetchall('SELECT goodsid FROM ' . tablename('ewei_shop_order_goods') . ' WHERE orderid = :orderid AND uniacid = :uniacid', array(':orderid' => $order['id'], ':uniacid' => $order['uniacid']));

			foreach ($goodslist as $item) {
				p('task')->checkTaskProgress(1, 'goods', 0, $order['openid'], $item['goodsid']);
			}

			if (pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . (' where openid = \'' . $order['openid'] . '\' and uniacid = ' . $order['uniacid'])) == 1) {
				p('task')->checkTaskProgress(1, 'order_first', '', $order['openid']);
			}
		}

		if (p('lottery') && empty($ispeerpay)) {
			if (0 < $order['deductcredit2']) {
				$order['price'] = floatval($order['price']) + floatval($order['deductcredit2']);
			}

			if (0 < $order['deductcredit']) {
				$order['price'] = floatval($order['price']) + floatval($order['deductprice']);
			}

			$res = p('lottery')->getLottery($order['openid'], 1, array('money' => $order['price'], 'paytype' => 1));

			if ($res) {
				p('lottery')->getLotteryList($order['openid'], array('lottery_id' => $res));
			}
		}
	}

	/**
     * 计算订单中商品累计赠送的积分
     * @param type $order
     */
	public function getGoodsCredit($goods)
	{
		global $_W;
		$credits = 0;

		foreach ($goods as $g) {
			$gcredit = trim($g['credit']);

			if (!empty($gcredit)) {
				if (strexists($gcredit, '%')) {
					$credits += intval(floatval(str_replace('%', '', $gcredit)) / 100 * $g['realprice']);
				}
				else {
					$credits += intval($g['credit']) * $g['total'];
				}
			}
		}

		return $credits;
	}

	/**
     * 返还抵扣的余额
     * @param type $order
     */
	public function setDeductCredit2($order)
	{
		global $_W;

		if (0 < $order['deductcredit2']) {
			m('member')->setCredit($order['openid'], 'credit2', $order['deductcredit2'], array('0', $_W['shopset']['shop']['name'] . ('购物返还抵扣余额 余额: ' . $order['deductcredit2'] . ' 订单号: ' . $order['ordersn'])));
		}
	}

	/**
     * 处理赠送余额情况
     * @param type $orderid
     * @param type $type 1 订单完成 2 售后
     */
	public function setGiveBalance($orderid = '', $type = 0)
	{
		global $_W;
		$order = pdo_fetch('select id,ordersn,price,openid,dispatchtype,addressid,carrier,status from ' . tablename('ewei_shop_order') . ' where id=:id limit 1', array(':id' => $orderid));
		$goods = pdo_fetchall('select og.goodsid,og.total,g.totalcnf,og.realprice,g.money,og.optionid,g.total as goodstotal,og.optionid,g.sales,g.salesreal from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));
		$balance = 0;

		foreach ($goods as $g) {
			$gbalance = trim($g['money']);

			if (!empty($gbalance)) {
				if (strexists($gbalance, '%')) {
					$balance += round(floatval(str_replace('%', '', $gbalance)) / 100 * $g['realprice'], 2);
				}
				else {
					$balance += round($g['money'], 2) * $g['total'];
				}
			}
		}

		if (0 < $balance) {
			$shopset = m('common')->getSysset('shop');

			if ($type == 1) {
				if ($order['status'] == 3) {
					m('member')->setCredit($order['openid'], 'credit2', $balance, array(0, $shopset['name'] . '购物赠送余额 订单号: ' . $order['ordersn']));
				}
			}
			else {
				if ($type == 2) {
					if (1 <= $order['status']) {
						m('member')->setCredit($order['openid'], 'credit2', 0 - $balance, array(0, $shopset['name'] . '购物取消订单扣除赠送余额 订单号: ' . $order['ordersn']));
					}
				}
			}
		}
	}

	/**
     * //处理订单库存及用户积分情况(赠送积分)
     * @param type $orderid
     * @param type $type 0 下单 1 支付 2 取消 3 确认收货
     * @param $flag $flag 代表是不是执行增加积分的方式,如果有读写分离会导致订单状态还未改变就进来了
     */
	public function setStocksAndCredits($orderid = '', $type = 0, $flag = false)
	{
		global $_W;
		$order = pdo_fetch('select id,ordersn,price,openid,dispatchtype,addressid,carrier,status,isparent,paytype,isnewstore,storeid,istrade,status from ' . tablename('ewei_shop_order') . ' where id=:id limit 1', array(':id' => $orderid));

		if (!empty($order['istrade'])) {
			return NULL;
		}

		if (empty($order['isnewstore'])) {
			$newstoreid = 0;
		}
		else {
			$newstoreid = intval($order['storeid']);
		}

		$param = array();
		$param[':uniacid'] = $_W['uniacid'];

		if ($order['isparent'] == 1) {
			$condition = ' og.parentorderid=:parentorderid';
			$param[':parentorderid'] = $orderid;
		}
		else {
			$condition = ' og.orderid=:orderid';
			$param[':orderid'] = $orderid;
		}

		$goods = pdo_fetchall('select og.goodsid,og.seckill,og.total,g.totalcnf,og.realprice,g.credit,og.optionid,g.total as goodstotal,og.optionid,g.sales,g.salesreal,g.type from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . (' where ' . $condition . ' and og.uniacid=:uniacid '), $param);
		$credits = 0;

		foreach ($goods as $g) {
			if (0 < $newstoreid) {
				$store_goods = m('store')->getStoreGoodsInfo($g['goodsid'], $newstoreid);

				if (empty($store_goods)) {
					return NULL;
				}

				$g['goodstotal'] = $store_goods['stotal'];
			}
			else {
				$goods_item = pdo_fetch('select total as goodstotal from' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $g['goodsid'], ':uniacid' => $_W['uniacid']));
				$g['goodstotal'] = $goods_item['goodstotal'];
			}

			$stocktype = 0;

			if ($type == 0) {
				if ($g['totalcnf'] == 0) {
					$stocktype = -1;
				}
			}
			else if ($type == 1) {
				if ($g['totalcnf'] == 1) {
					$stocktype = -1;
				}
			}
			else {
				if ($type == 2) {
					if (1 <= $order['status']) {
						if ($g['totalcnf'] != 2) {
							$stocktype = 1;
						}
					}
					else {
						if ($g['totalcnf'] == 0) {
							$stocktype = 1;
						}
					}
				}
			}

			if (!empty($stocktype)) {
				$data = m('common')->getSysset('trade');

				if (!empty($data['stockwarn'])) {
					$stockwarn = intval($data['stockwarn']);
				}
				else {
					$stockwarn = 5;
				}

				if (!empty($g['optionid'])) {
					$option = m('goods')->getOption($g['goodsid'], $g['optionid']);

					if (0 < $newstoreid) {
						$store_goods_option = m('store')->getOneStoreGoodsOption($g['optionid'], $g['goodsid'], $newstoreid);

						if (empty($store_goods_option)) {
							return NULL;
						}

						$option['stock'] = $store_goods_option['stock'];
					}

					if (!empty($option) && $option['stock'] != -1) {
						$stock = -1;

						if ($stocktype == 1) {
							$stock = $option['stock'] + $g['total'];
						}
						else {
							if ($stocktype == -1) {
								$stock = $option['stock'] - $g['total'];
								$stock <= 0 && ($stock = 0);
								if ($stock <= $stockwarn && $newstoreid == 0) {
									m('notice')->sendStockWarnMessage($g['goodsid'], $g['optionid']);
								}
							}
						}

						if ($stock != -1) {
							if (0 < $newstoreid) {
								pdo_update('ewei_shop_newstore_goods_option', array('stock' => $stock), array('uniacid' => $_W['uniacid'], 'goodsid' => $g['goodsid'], 'id' => $store_goods_option['id']));
							}
							else {
								pdo_update('ewei_shop_goods_option', array('stock' => $stock), array('uniacid' => $_W['uniacid'], 'goodsid' => $g['goodsid'], 'id' => $g['optionid']));
							}
						}
					}
				}

				if ((!empty($g['goodstotal']) && $stocktype == -1 || $stocktype == 1) && $g['goodstotal'] != -1) {
					$totalstock = -1;

					if ($stocktype == 1) {
						$totalstock = $g['goodstotal'] + $g['total'];
					}
					else {
						if ($stocktype == -1) {
							$totalstock = $g['goodstotal'] - $g['total'];
							$totalstock <= 0 && ($totalstock = 0);
							if ($totalstock <= $stockwarn && $newstoreid == 0) {
								m('notice')->sendStockWarnMessage($g['goodsid'], 0);
							}
						}
					}

					if ($totalstock != -1) {
						if (0 < $newstoreid) {
							pdo_update('ewei_shop_newstore_goods', array('stotal' => $totalstock), array('uniacid' => $_W['uniacid'], 'id' => $store_goods['id']));
						}
						else {
							pdo_update('ewei_shop_goods', array('total' => $totalstock), array('uniacid' => $_W['uniacid'], 'id' => $g['goodsid']));
						}
					}
				}
			}

			$isgoodsdata = m('common')->getPluginset('sale');
			$isgoodspoint = iunserializer($isgoodsdata['credit1']);
			if (!empty($isgoodspoint['isgoodspoint']) && $isgoodspoint['isgoodspoint'] == 1) {
				$gcredit = trim($g['credit']);

				if ($g['seckill'] != 1) {
					if (!empty($gcredit)) {
						if (strexists($gcredit, '%')) {
							$credits += intval(floatval(str_replace('%', '', $gcredit)) / 100 * $g['realprice']);
						}
						else {
							$credits += intval($g['credit']) * $g['total'];
						}
					}
				}
			}

			if ($type == 0) {
			}
			else {
				if ($type == 1) {
					if (1 <= $order['status']) {
						$salesreal = pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' where og.goodsid=:goodsid and o.status>=1 and o.uniacid=:uniacid limit 1', array(':goodsid' => $g['goodsid'], ':uniacid' => $_W['uniacid']));
						pdo_update('ewei_shop_goods', array('salesreal' => $salesreal), array('id' => $g['goodsid']));
						$table_flag = pdo_tableexists('ewei_shop_order_buysend');
						if (0 < $credits && $table_flag) {
							$send_data = array('uniacid' => $_W['uniacid'], 'orderid' => $orderid, 'openid' => $order['openid'], 'credit' => $credits, 'createtime' => TIMESTAMP);
							$send_record = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order_buysend') . ' WHERE orderid = :orderid AND uniacid = :uniacid AND openid = :openid', array(':orderid' => $orderid, ':uniacid' => $_W['uniacid'], ':openid' => $order['openid']));

							if ($send_record) {
								pdo_update('ewei_shop_order_buysend', $send_data, array('id' => $send_record['id']));
							}
							else {
								pdo_insert('ewei_shop_order_buysend', $send_data);
							}
						}
					}
				}
			}
		}

		$table_flag = pdo_tableexists('ewei_shop_order_buysend');

		if ($table_flag) {
			$send_record = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order_buysend') . ' WHERE orderid = :orderid AND uniacid = :uniacid AND openid = :openid', array(':orderid' => $orderid, ':uniacid' => $_W['uniacid'], ':openid' => $order['openid']));
			if ($send_record && 0 < $send_record['credit']) {
				$credits = $send_record['credit'];
			}
		}

		if (0 < $credits) {
			$shopset = m('common')->getSysset('shop');

			if ($type == 3) {
				if ($order['status'] == 3 || $flag == true) {
					m('member')->setCredit($order['openid'], 'credit1', $credits, array(0, $shopset['name'] . '购物积分 订单号: ' . $order['ordersn']));
					m('notice')->sendMemberPointChange($order['openid'], $credits, 0, 3);
				}
			}
			else {
				if ($type == 2) {
					if ($order['status'] == 3) {
						m('member')->setCredit($order['openid'], 'credit1', 0 - $credits, array(0, $shopset['name'] . '购物取消订单扣除积分 订单号: ' . $order['ordersn']));
						m('notice')->sendMemberPointChange($order['openid'], $credits, 1, 3);
					}
				}
			}
		}
		else if ($type == 3) {
			if ($order['status'] == 3) {
				$money = com_run('sale::getCredit1', $order['openid'], (double) $order['price'], $order['paytype'], 1);

				if (0 < $money) {
					m('notice')->sendMemberPointChange($order['openid'], $money, 0, 3);
				}
			}
		}
		else {
			if ($type == 2) {
				if ($order['status'] == 3) {
					$money = com_run('sale::getCredit1', $order['openid'], (double) $order['price'], $order['paytype'], 1, 1);

					if (0 < $money) {
						m('notice')->sendMemberPointChange($order['openid'], $money, 1, 3);
					}
				}
			}
		}
	}

	public function getTotals($merch = 0)
	{
		global $_W;
		$paras = array(':uniacid' => $_W['uniacid']);
		$merch = intval($merch);
		$condition = ' and isparent=0';

		if ($merch < 0) {
			$condition .= ' and merchid=0';
		}

		$totals['all'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . (' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0 and deleted=0'), $paras);
		$totals['status_1'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . (' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0 and status=-1 and refundtime=0 and deleted=0'), $paras);
		$totals['status0'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . (' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0  and status=0 and paytype<>3 and deleted=0'), $paras);
		$totals['status1'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . (' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0  and ( status=1 or ( status=0 and paytype=3) ) and deleted=0'), $paras);
		$totals['status2'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . (' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0  and ( status=2 or (status = 1 and sendtype > 0) ) and deleted=0'), $paras);
		$totals['status3'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . (' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0  and status=3 and deleted=0'), $paras);
		$totals['status4'] = pdo_fetchcolumn('SELECT COUNT(1)FROM ' . tablename('ewei_shop_order') . '' . (' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0  and ((refundstate>0 and refundid<>0 and refundtime=0) or (refundtime=0 and refundstate=3)) and deleted=0'), $paras);
		$totals['status5'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . (' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0 and refundtime<>0 and deleted=0'), $paras);
		return $totals;
	}

	public function getFormartDiscountPrice($isd, $gprice, $gtotal = 1)
	{
		$price = $gprice;

		if (!empty($isd)) {
			if (strexists($isd, '%')) {
				$dd = floatval(str_replace('%', '', $isd));
				if (0 < $dd && $dd < 100) {
					$price = round($dd / 100 * $gprice, 2);
				}
			}
			else {
				if (0 < floatval($isd)) {
					$price = round(floatval($isd * $gtotal), 2);
				}
			}
		}

		return $price;
	}

	public function getGoodsDiscounts($goods, $isdiscount_discounts, $levelid, $options = array())
	{
		$key = empty($levelid) ? 'default' : 'level' . $levelid;
		$prices = array();

		if (empty($goods['merchsale'])) {
			if (!empty($isdiscount_discounts[$key])) {
				foreach ($isdiscount_discounts[$key] as $k => $v) {
					$k = substr($k, 6);
					$op_marketprice = m('goods')->getOptionPirce($goods['id'], $k);
					$gprice = $this->getFormartDiscountPrice($v, $op_marketprice);
					$prices[] = $gprice;

					if (!empty($options)) {
						foreach ($options as $key => $value) {
							if ($value['id'] == $k) {
								$options[$key]['marketprice'] = $gprice;
							}
						}
					}
				}
			}
		}
		else {
			if (!empty($isdiscount_discounts['merch'])) {
				foreach ($isdiscount_discounts['merch'] as $k => $v) {
					$k = substr($k, 6);
					$op_marketprice = m('goods')->getOptionPirce($goods['id'], $k);
					$gprice = $this->getFormartDiscountPrice($v, $op_marketprice);
					$prices[] = $gprice;

					if (!empty($options)) {
						foreach ($options as $key => $value) {
							if ($value['id'] == $k) {
								$options[$key]['marketprice'] = $gprice;
							}
						}
					}
				}
			}
		}

		$data = array();
		$data['prices'] = $prices;
		$data['options'] = $options;
		return $data;
	}

	public function getGoodsDiscountPrice($g, $level, $type = 0, $memberCardId = 0)
	{
		global $_W;
		$hasMemberCard = (bool) $memberCardId;
		$hasMemberDeduct = true;

		if (p('membercard')) {
			$membercardSettings = p('membercard')->getMemberCard($memberCardId);

			if ($hasMemberCard) {
				$hasMemberDeduct = (bool) $membercardSettings['discount'];
			}
		}

		if (!empty($level['id'])) {
			$level = pdo_fetch('select * from ' . tablename('ewei_shop_member_level') . ' where id=:id and uniacid=:uniacid and enabled=1 limit 1', array(':id' => $level['id'], ':uniacid' => $_W['uniacid']));
			$level = empty($level) ? array() : $level;
		}

		if ($type == 0) {
			$total = $g['total'];
		}
		else {
			$total = 1;
		}

		$gprice = $g['marketprice'] * $total;

		if (empty($g['buyagain_islong'])) {
			$gprice = $g['marketprice'] * $total;
		}

		$buyagain_sale = true;
		$buyagainprice = 0;
		$canbuyagain = false;

		if (empty($g['is_task_goods'])) {
			if (0 < floatval($g['buyagain'])) {
				if (m('goods')->canBuyAgain($g)) {
					$canbuyagain = true;

					if (empty($g['buyagain_sale'])) {
						$buyagain_sale = false;
					}
				}
			}
		}

		$price = $gprice;
		$price1 = $gprice;
		$price2 = $gprice;
		$taskdiscountprice = 0;
		$lotterydiscountprice = 0;

		if (!empty($g['is_task_goods'])) {
			$buyagain_sale = false;
			$price = $g['task_goods']['marketprice'] * $total;

			if ($price < $gprice) {
				$d_price = abs($gprice - $price);

				if ($g['is_task_goods'] == 1) {
					$taskdiscountprice = $d_price;
				}
				else {
					if ($g['is_task_goods'] == 2) {
						$lotterydiscountprice = $d_price;
					}
				}
			}
		}

		$discountprice = 0;
		$isdiscountprice = 0;
		$isd = false;
		@$isdiscount_discounts = json_decode($g['isdiscount_discounts'], true);
		$discounttype = 0;
		$isCdiscount = 0;
		$isHdiscount = 0;
		if ($g['isdiscount'] == 1 && time() <= $g['isdiscount_time'] && $buyagain_sale && $hasMemberDeduct) {
			if (is_array($isdiscount_discounts)) {
				$key = !empty($level['id']) ? 'level' . $level['id'] : 'default';
				if (!isset($isdiscount_discounts['type']) || empty($isdiscount_discounts['type'])) {
					if (empty($g['merchsale'])) {
						$isd = trim($isdiscount_discounts[$key]['option0']);

						if (!empty($isd)) {
							$price1 = $this->getFormartDiscountPrice($isd, $gprice, $total);
						}
					}
					else {
						$isd = trim($isdiscount_discounts['merch']['option0']);

						if (!empty($isd)) {
							$price1 = $this->getFormartDiscountPrice($isd, $gprice, $total);
						}
					}
				}
				else if (empty($g['merchsale'])) {
					$isd = trim($isdiscount_discounts[$key]['option' . $g['optionid']]);

					if (!empty($isd)) {
						$price1 = $this->getFormartDiscountPrice($isd, $gprice, $total);
					}
				}
				else {
					$isd = trim($isdiscount_discounts['merch']['option' . $g['optionid']]);

					if (!empty($isd)) {
						$price1 = $this->getFormartDiscountPrice($isd, $gprice, $total);
					}
				}
			}

			if ($gprice <= $price1) {
				$isdiscountprice = 0;
				$isCdiscount = 0;
			}
			else {
				$isdiscountprice = abs($price1 - $gprice);
				$isCdiscount = 1;
			}
		}

		if (empty($g['isnodiscount']) && $buyagain_sale && $hasMemberDeduct) {
			$discounts = json_decode($g['discounts'], true);
			if (empty($g['discounts']) && 0 < $g['merchid']) {
				$g['discounts'] = array('type' => '0', 'default' => '', 'default_pay' => '');

				if (!empty($level)) {
					$g['discounts']['level' . $level['id']] = '';
					$g['discounts']['level' . $level['id'] . '_pay'] = '';
				}

				$discounts = $g['discounts'];
			}

			if (is_array($discounts)) {
				$key = !empty($level['id']) ? 'level' . $level['id'] : 'default';
				if (!isset($discounts['type']) || empty($discounts['type'])) {
					if (!empty($discounts[$key])) {
						$dd = floatval($discounts[$key]);
						if (0 < $dd && $dd < 10) {
							$price2 = round($dd / 10 * $gprice, 2);
						}
					}
					else {
						$dd = floatval($discounts[$key . '_pay'] * $total);
						$md = floatval($level['discount']);

						if (!empty($dd)) {
							$price2 = round($dd, 2);
						}
						else {
							if (0 < $md && $md < 10) {
								$price2 = round($md / 10 * $gprice, 2);
							}
						}
					}
				}
				else {
					$isd = trim($discounts[$key]['option' . $g['optionid']]);

					if (!empty($isd)) {
						$price2 = $this->getFormartDiscountPrice($isd, $gprice, $total);
					}
				}
			}

			if ($gprice <= $price2) {
				$discountprice = 0;
				$isHdiscount = 0;
			}
			else {
				$discountprice = abs($price2 - $gprice);
				$isHdiscount = 1;
			}
		}

		if ($isCdiscount == 1) {
			$price = $price1;
			$discounttype = 1;
		}
		else {
			if ($isHdiscount == 1) {
				$price = $price2;
				$discounttype = 2;
			}
		}

		$unitprice = round($price / $total, 2);
		$isdiscountunitprice = round($isdiscountprice / $total, 2);
		$discountunitprice = round($discountprice / $total, 2);

		if ($canbuyagain) {
			if (empty($g['buyagain_islong'])) {
				$buyagainprice = $unitprice * (10 - $g['buyagain']) / 10;
			}
			else {
				$buyagainprice = $price * (10 - $g['buyagain']) / 10;
			}
		}

		$price = $price - $buyagainprice;
		return array('unitprice' => $unitprice, 'price' => $price, 'taskdiscountprice' => $taskdiscountprice, 'lotterydiscountprice' => $lotterydiscountprice, 'discounttype' => $discounttype, 'isdiscountprice' => $isdiscountprice, 'discountprice' => $discountprice, 'isdiscountunitprice' => $isdiscountunitprice, 'discountunitprice' => $discountunitprice, 'price0' => $gprice, 'price1' => $price1, 'price2' => $price2, 'buyagainprice' => $buyagainprice);
	}

	public function getChildOrderPrice(&$order, &$goods, &$dispatch_array, $merch_array, $sale_plugin, $discountprice_array, $orderid = 0)
	{
		global $_GPC;
		$tmp_goods = $goods;
		$is_exchange = p('exchange') && $_SESSION['exchange'];

		if ($is_exchange) {
			foreach ($dispatch_array['dispatch_merch'] as &$dispatch_merch) {
				$dispatch_merch = 0;
			}

			unset($dispatch_merch);
			$postage = $_SESSION['exchange_postage_info'];
			$exchangepriceset = (array) $_SESSION['exchangepriceset'];

			foreach ($goods as $gk => $one_goods) {
				$goods[$gk]['ggprice'] = 0;
				$tmp_goods[$gk]['marketprice'] = 0;
			}

			foreach ($exchangepriceset as $pset) {
				foreach ($goods as $gk => &$one_goods) {
					if ($one_goods['ggprice'] == 0 && ($one_goods['optionid'] == $pset[0] || $one_goods['goodsid'] == $pset[0])) {
						$one_goods['ggprice'] += $pset[2];
						$tmp_goods[$gk]['marketprice'] += $pset[2];
						break;
					}
				}

				unset($one_goods);
			}
		}

		$totalprice = $order['price'];
		$goodsprice = $order['goodsprice'];
		$grprice = $order['grprice'];
		$deductprice = $order['deductprice'];
		$deductcredit = $order['deductcredit'];
		$deductcredit2 = $order['deductcredit2'];
		$deductenough = $order['deductenough'];
		$is_deduct = 0;
		$is_deduct2 = 0;
		$deduct_total = 0;
		$deduct2_total = 0;
		$ch_order = array();

		if ($sale_plugin) {
			if (!empty($_GPC['deduct'])) {
				$is_deduct = 1;
			}

			if (!empty($_GPC['deduct2'])) {
				$is_deduct2 = 1;
			}
		}

		foreach ($goods as $gk => &$g) {
			$merchid = $g['merchid'];
			$ch_order[$merchid]['goods'][] = $g['goodsid'];
			$ch_order[$merchid]['grprice'] += $g['ggprice'];
			$ch_order[$merchid]['goodsprice'] += $tmp_goods[$gk]['marketprice'] * $g['total'];
			$ch_order[$merchid]['couponprice'] = $discountprice_array[$merchid]['deduct'];

			if ($is_deduct == 1) {
				if ($g['manydeduct']) {
					$deduct = $g['deduct'] * $g['total'];
				}
				else {
					$deduct = $g['deduct'];
				}

				if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
				}
				else {
					$deduct_total += $deduct;
					$ch_order[$merchid]['deducttotal'] += $deduct;
				}
			}

			if ($is_deduct2 == 1) {
				if ($g['deduct2'] == 0) {
					$deduct2 = $g['ggprice'];
				}
				else {
					if (0 < $g['deduct2']) {
						if ($g['ggprice'] < $g['deduct2']) {
							$deduct2 = $g['ggprice'];
						}
						else {
							$deduct2 = $g['deduct2'];
						}
					}
				}

				if ($g['seckillinfo'] && $g['seckillinfo']['status'] == 0) {
				}
				else {
					$ch_order[$merchid]['deduct2total'] += $deduct2;
					$deduct2_total += $deduct2;
				}
			}
		}

		unset($g);

		foreach ($ch_order as $k => $v) {
			if ($is_deduct == 1) {
				if (0 < $deduct_total) {
					$n = $v['deducttotal'] / $deduct_total;
					$deduct_credit = ceil(round($deductcredit * $n, 2));
					$deduct_money = round($deductprice * $n, 2);
					$ch_order[$k]['deductcredit'] = $deduct_credit;
					$ch_order[$k]['deductprice'] = $deduct_money;
				}
			}

			if ($is_deduct2 == 1) {
				if (0 < $deduct2_total) {
					$n = $v['deduct2total'] / $deduct2_total;
					$deduct_credit2 = round($deductcredit2 * $n, 2);
					$ch_order[$k]['deductcredit2'] = $deduct_credit2;
				}
			}

			$op = $grprice == 0 ? 0 : round($v['grprice'] / $grprice, 2);
			$ch_order[$k]['op'] = $op;

			if (0 < $deductenough) {
				$deduct_enough = round($deductenough * $op, 2);
				$ch_order[$k]['deductenough'] = $deduct_enough;
			}
		}

		if ($is_exchange) {
			if (is_array($postage)) {
				foreach ($ch_order as $mid => $ch) {
					$flip = array_flip(array_flip($ch['goods']));

					foreach ($flip as $gid) {
						$dispatch_array['dispatch_merch'][$mid] += $postage[$gid];
					}
				}
			}
			else {
				$old_dispatch_price = $order['dispatchprice'];
				$order['dispatchprice'] = $_SESSION['exchangepostage'] = $postage * count($dispatch_array['dispatch_merch']);
				pdo_update('ewei_shop_order', array('dispatchprice' => $order['dispatchprice'], 'price' => $order['price'] + $order['dispatchprice'] - $old_dispatch_price), array('id' => $orderid));

				foreach ($dispatch_array['dispatch_merch'] as &$dispatch_merch) {
					$dispatch_merch = $postage;
				}

				unset($dispatch_merch);
			}
		}

		foreach ($ch_order as $k => $v) {
			$merchid = $k;
			$price = $v['grprice'] - $v['deductprice'] - $v['deductcredit2'] - $v['deductenough'] - $v['couponprice'] + $dispatch_array['dispatch_merch'][$merchid];

			if (0 < $merchid) {
				$merchdeductenough = $merch_array[$merchid]['enoughdeduct'];

				if (0 < $merchdeductenough) {
					$price -= $merchdeductenough;
					$ch_order[$merchid]['merchdeductenough'] = $merchdeductenough;
				}
			}

			$ch_order[$merchid]['price'] = $price;
		}

		return $ch_order;
	}

	public function getMerchEnough($merch_array)
	{
		$merch_enough_total = 0;
		$merch_saleset = array();

		foreach ($merch_array as $key => $value) {
			$merchid = $key;

			if (0 < $merchid) {
				$enoughs = $value['enoughs'];

				if (!empty($enoughs)) {
					$ggprice = $value['ggprice'];

					foreach ($enoughs as $e) {
						if (floatval($e['enough']) <= $ggprice && 0 < floatval($e['money'])) {
							$merch_array[$merchid]['showenough'] = 1;
							$merch_array[$merchid]['enoughmoney'] = $e['enough'];
							$merch_array[$merchid]['enoughdeduct'] = $e['money'];
							$merch_saleset['merch_showenough'] = 1;
							$merch_saleset['merch_enoughmoney'] += $e['enough'];
							$merch_saleset['merch_enoughdeduct'] += $e['money'];
							$merch_enough_total += floatval($e['money']);
							break;
						}
					}
				}
			}
		}

		$data = array();
		$data['merch_array'] = $merch_array;
		$data['merch_enough_total'] = $merch_enough_total;
		$data['merch_saleset'] = $merch_saleset;
		return $data;
	}

	public function validate_city_express($address)
	{
		global $_W;
		$city_express_data = array('state' => 0, 'enabled' => 0, 'price' => 0, 'is_dispatch' => 1);
		$city_express = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_city_express') . ' WHERE uniacid=:uniacid and merchid=0 limit 1', array(':uniacid' => $_W['uniacid']));

		if (!empty($city_express['enabled'])) {
			$city_express_data['enabled'] = 1;
			$city_express_data['is_dispatch'] = $city_express['is_dispatch'];
			$city_express_data['is_sum'] = $city_express['is_sum'];

			if (!empty($address)) {
				if (empty($address['lng']) || empty($address['lat'])) {
					$data = m('util')->geocode($address['province'] . $address['city'] . $address['area'] . $address['street'] . $address['address'], $city_express['geo_key']);
					if ($data['status'] == 1 && 0 < $data['count']) {
						$location = explode(',', $data['geocodes'][0]['location']);
						$addres = $address;
						$addres['lng'] = $location[0];
						$addres['lat'] = $location[1];
						pdo_update('ewei_shop_member_address', $addres, array('id' => $addres['id'], 'uniacid' => $_W['uniacid']));
						$city_express_data = $this->compute_express_price($city_express, $location[0], $location[1]);
					}
				}
				else {
					$city_express_data = $this->compute_express_price($city_express, $address['lng'], $address['lat']);
				}
			}
		}

		return $city_express_data;
	}

	public function compute_express_price($city_express, $lng, $lat)
	{
		$city_express_data = array('state' => 0, 'enabled' => 1, 'price' => 0, 'is_dispatch' => $city_express['is_dispatch'], 'is_sum' => $city_express['is_sum']);
		$distance = m('util')->GetDistance($city_express['lat'], $city_express['lng'], $lat, $lng);

		if ($distance < $city_express['range']) {
			$city_express_data['state'] = 1;

			if ($distance <= $city_express['start_km'] * 1000) {
				$city_express_data['price'] = round($city_express['start_fee'], 2);
			}

			if ($city_express['start_km'] * 1000 < $distance && $distance <= $city_express['start_km'] * 1000 + $city_express['pre_km'] * 1000) {
				$km = $distance - intval($city_express['start_km'] * 1000);
				$city_express_data['price'] = round($city_express['start_fee'] + $city_express['pre_km_fee'] * ceil($km / 1000), 2);
			}

			if ($city_express['fixed_km'] * 1000 <= $distance) {
				$city_express_data['price'] = round($city_express['fixed_fee'], 2);
			}
		}

		return $city_express_data;
	}

	public function getOrderDispatchPrice($goods, $member, $address, $saleset = false, $merch_array, $t, $loop = 0)
	{
		global $_W;
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$realprice = 0;
		$dispatch_price = 0;
		$dispatch_array = array();
		$dispatch_merch = array();
		$total_array = array();
		$totalprice_array = array();
		$nodispatch_array = array();
		$goods_num = count($goods);
		$seckill_payprice = 0;
		$seckill_dispatchprice = 0;
		$user_city = '';
		$user_city_code = '';

		if (empty($new_area)) {
			if (!empty($address)) {
				$user_city = $user_city_code = $address['city'];
			}
			else {
				if (!empty($member['city'])) {
					if (!strexists($member['city'], '市')) {
						$member['city'] = $member['city'] . '市';
					}

					$user_city = $user_city_code = $member['city'];
				}
			}
		}
		else {
			if (!empty($address)) {
				$user_city = $address['city'] . $address['area'];
				$user_city_code = $address['datavalue'];
			}
		}

		$is_merchid = 0;

		foreach ($goods as $g) {
			$realprice += $g['ggprice'];
			$dispatch_merch[$g['merchid']] = 0;
			$total_array[$g['goodsid']] += $g['total'];
			$totalprice_array[$g['goodsid']] += $g['ggprice'];

			if (!empty($g['merchid'])) {
				$is_merchid = 1;
			}
		}

		$city_express_data['state'] = 0;
		$city_express_data['enabled'] = 0;
		$city_express_data['is_dispatch'] = 1;

		if ($is_merchid == 0) {
			$city_express_data = $this->validate_city_express($address);
		}

		foreach ($goods as $g) {
			$seckillinfo = plugin_run('seckill::getSeckill', $g['goodsid'], $g['optionid'], true, $_W['openid']);
			if ($seckillinfo && $seckillinfo['status'] == 0) {
				$seckill_payprice += $g['ggprice'];
			}

			$isnodispatch = 0;
			$sendfree = false;
			$merchid = $g['merchid'];

			if ($g['type'] == 5) {
				$sendfree = true;
			}

			if (!empty($g['issendfree'])) {
				$sendfree = true;
			}
			else {
				if ($seckillinfo && $seckillinfo['status'] == 0) {
				}
				else {
					if ($g['ednum'] <= $total_array[$g['goodsid']] && 0 < $g['ednum']) {
						if (empty($new_area)) {
							$gareas = explode(';', $g['edareas']);
						}
						else {
							$gareas = explode(';', $g['edareas_code']);
						}

						if (empty($gareas)) {
							$sendfree = true;
						}
						else if (!empty($address)) {
							if (!in_array($user_city_code, $gareas)) {
								$sendfree = true;
							}
						}
						else if (!empty($member['city'])) {
							if (!in_array($member['city'], $gareas)) {
								$sendfree = true;
							}
						}
						else {
							$sendfree = true;
						}
					}
				}

				if ($seckillinfo && $seckillinfo['status'] == 0) {
				}
				else {
					if (floatval($g['edmoney']) <= $totalprice_array[$g['goodsid']] && 0 < floatval($g['edmoney'])) {
						if (empty($new_area)) {
							$gareas = explode(';', $g['edareas']);
						}
						else {
							$gareas = explode(';', $g['edareas_code']);
						}

						if (empty($gareas)) {
							$sendfree = true;
						}
						else if (!empty($address)) {
							if (!in_array($user_city_code, $gareas)) {
								$sendfree = true;
							}
						}
						else if (!empty($member['city'])) {
							if (!in_array($member['city'], $gareas)) {
								$sendfree = true;
							}
						}
						else {
							$sendfree = true;
						}
					}
				}
			}

			if ($g['dispatchtype'] == 1) {
				if ($city_express_data['state'] == 0 && $city_express_data['is_dispatch'] == 1) {
					$flag = false;
					$retarr = $this->filterGoods($saleset, $realprice, $seckill_payprice, $goods, $user_city_code, $new_area);

					foreach ($retarr as $v) {
						if (in_array($g['goodsid'], $v)) {
							$flag = true;
							break;
						}
					}

					if ($flag) {
						continue;
					}

					if (!empty($user_city)) {
						if (empty($new_area)) {
							$citys = m('dispatch')->getAllNoDispatchAreas();
						}
						else {
							$citys = m('dispatch')->getAllNoDispatchAreas('', 1);
						}

						if (!empty($citys)) {
							if (in_array($user_city_code, $citys) && !empty($citys)) {
								$isnodispatch = 1;
								$has_goodsid = 0;

								if (!empty($nodispatch_array['goodid'])) {
									if (in_array($g['goodsid'], $nodispatch_array['goodid'])) {
										$has_goodsid = 1;
									}
								}

								if ($has_goodsid == 0) {
									$nodispatch_array['goodid'][] = $g['goodsid'];
									$nodispatch_array['title'][] = $g['title'];
									$nodispatch_array['city'] = $user_city;
								}
							}
						}
					}

					if (0 < $g['dispatchprice'] && !$sendfree && $isnodispatch == 0) {
						$dispatch_merch[$merchid] += $g['dispatchprice'];
						if ($seckillinfo && $seckillinfo['status'] == 0) {
							$seckill_dispatchprice += $g['dispatchprice'];
						}
						else {
							$dispatch_price += $g['dispatchprice'];
						}
					}
				}
				else if ($city_express_data['state'] == 1) {
					if (0 < $g['dispatchprice'] && !$sendfree) {
						if ($city_express_data['is_sum'] == 1) {
							$dispatch_price += $g['dispatchprice'];
						}
						else {
							if ($dispatch_price < $g['dispatchprice']) {
								$dispatch_price = $g['dispatchprice'];
							}
						}
					}
				}
				else {
					$nodispatch_array['goodid'][] = $g['goodsid'];
					$nodispatch_array['title'][] = $g['title'];
					$nodispatch_array['city'] = $user_city;
				}
			}
			else {
				if ($g['dispatchtype'] == 0) {
					if ($city_express_data['state'] == 0 && $city_express_data['is_dispatch'] == 1) {
						if (empty($g['dispatchid'])) {
							$dispatch_data = m('dispatch')->getDefaultDispatch($merchid);
						}
						else {
							$dispatch_data = m('dispatch')->getOneDispatch($g['dispatchid']);
						}

						if (empty($dispatch_data)) {
							$dispatch_data = m('dispatch')->getNewDispatch($merchid);
						}

						if (!empty($dispatch_data)) {
							$isnoarea = 0;
							$dkey = $dispatch_data['id'];
							$isdispatcharea = intval($dispatch_data['isdispatcharea']);

							if (!empty($user_city)) {
								if (empty($isdispatcharea)) {
									if (empty($new_area)) {
										$citys = m('dispatch')->getAllNoDispatchAreas($dispatch_data['nodispatchareas']);
									}
									else {
										$citys = m('dispatch')->getAllNoDispatchAreas($dispatch_data['nodispatchareas_code'], 1);
									}

									if (!empty($citys)) {
										if (in_array($user_city_code, $citys)) {
											$isnoarea = 1;
										}
									}
								}
								else {
									if (empty($new_area)) {
										$citys = m('dispatch')->getAllNoDispatchAreas();
									}
									else {
										$citys = m('dispatch')->getAllNoDispatchAreas('', 1);
									}

									if (!empty($citys)) {
										if (in_array($user_city_code, $citys)) {
											$isnoarea = 1;
										}
									}

									if (empty($isnoarea)) {
										$isnoarea = m('dispatch')->checkOnlyDispatchAreas($user_city_code, $dispatch_data);
									}
								}

								if (!empty($isnoarea)) {
									$isnodispatch = 1;
									$has_goodsid = 0;

									if (!empty($nodispatch_array['goodid'])) {
										if (in_array($g['goodsid'], $nodispatch_array['goodid'])) {
											$has_goodsid = 1;
										}
									}

									if ($has_goodsid == 0) {
										$nodispatch_array['goodid'][] = $g['goodsid'];
										$nodispatch_array['title'][] = $g['title'];
										$nodispatch_array['city'] = $user_city;
									}
								}
							}

							if (!$sendfree && $isnodispatch == 0) {
								$flag = false;
								$retarr = $this->filterGoods($saleset, $realprice, $seckill_payprice, $goods, $user_city_code, $new_area);

								foreach ($retarr as $v) {
									if (in_array($g['goodsid'], $v)) {
										$flag = true;
										break;
									}
								}

								if ($flag) {
									continue;
								}

								$areas = unserialize($dispatch_data['areas']);

								if ($dispatch_data['calculatetype'] == 1) {
									$param = $g['total'];
								}
								else {
									$param = $g['weight'] * $g['total'];
								}

								if (array_key_exists($dkey, $dispatch_array)) {
									$dispatch_array[$dkey]['param'] += $param;
								}
								else {
									$dispatch_array[$dkey]['data'] = $dispatch_data;
									$dispatch_array[$dkey]['param'] = $param;
								}

								if ($seckillinfo && $seckillinfo['status'] == 0) {
									if (array_key_exists($dkey, $dispatch_array)) {
										$dispatch_array[$dkey]['seckillnums'] += $param;
									}
									else {
										$dispatch_array[$dkey]['seckillnums'] = $param;
									}
								}
							}
						}
					}
					else if ($city_express_data['state'] == 1) {
						if (!$sendfree) {
							if ($city_express_data['is_sum'] == 1) {
								$dispatch_price += $city_express_data['price'] * $g['total'];
							}
							else {
								if ($dispatch_price < $city_express_data['price']) {
									$dispatch_price = $city_express_data['price'];
								}
							}
						}
					}
					else {
						$nodispatch_array['goodid'][] = $g['goodsid'];
						$nodispatch_array['title'][] = $g['title'];
						$nodispatch_array['city'] = $user_city;
					}
				}
			}
		}

		if ($city_express_data['state'] == 1 && $g['dispatchtype'] == 0) {
			if ($city_express_data['is_sum'] == 0 && $dispatch_price < $city_express_data['price']) {
				$dispatch_price = $city_express_data['price'];
			}
		}

		if (!empty($dispatch_array)) {
			$dispatch_info = array();

			foreach ($dispatch_array as $k => $v) {
				$dispatch_data = $dispatch_array[$k]['data'];
				$param = $dispatch_array[$k]['param'];
				$areas = unserialize($dispatch_data['areas']);

				if (!empty($address)) {
					$dprice = m('dispatch')->getCityDispatchPrice($areas, $address, $param, $dispatch_data);
					$freeprice = m('dispatch')->getCityfreepricePrice($areas, $address);

					if (0 < $freeprice) {
						$dispatch_data['freeprice'] = $freeprice;
					}
				}
				else {
					$dprice = m('dispatch')->getDispatchPrice($param, $dispatch_data);
				}

				$merchid = $dispatch_data['merchid'];
				$dispatch_merch[$merchid] += $dprice;

				if (0 < $v['seckillnums']) {
					$seckill_dispatchprice += $dprice;
				}
				else {
					$dispatch_price += $dprice;
				}

				$dispatch_info[$dispatch_data['id']]['price'] += $dprice;
				$dispatch_info[$dispatch_data['id']]['freeprice'] = intval($dispatch_data['freeprice']);
			}

			if (!empty($dispatch_info)) {
				foreach ($dispatch_info as $k => $v) {
					if (0 < $v['freeprice'] && $v['freeprice'] <= $v['price']) {
						$dispatch_price -= $v['price'];
					}
				}

				if ($dispatch_price < 0) {
					$dispatch_price = 0;
				}
			}
		}

		if (!empty($merch_array)) {
			foreach ($merch_array as $key => $value) {
				$merchid = $key;

				if (0 < $merchid) {
					$merchset = $value['set'];

					if (!empty($merchset['enoughfree'])) {
						if (floatval($merchset['enoughorder']) <= 0) {
							$dispatch_price = $dispatch_price - $dispatch_merch[$merchid];
							$dispatch_merch[$merchid] = 0;
						}
						else {
							if (floatval($merchset['enoughorder']) <= $merch_array[$merchid]['ggprice']) {
								if (empty($merchset['enoughareas'])) {
									$dispatch_price = $dispatch_price - $dispatch_merch[$merchid];
									$dispatch_merch[$merchid] = 0;
								}
								else {
									$areas = explode(';', $merchset['enoughareas']);

									if (!empty($address)) {
										if (!in_array($address['city'], $areas)) {
											$dispatch_price = $dispatch_price - $dispatch_merch[$merchid];
											$dispatch_merch[$merchid] = 0;
										}
									}
									else if (!empty($member['city'])) {
										if (!in_array($member['city'], $areas)) {
											$dispatch_price = $dispatch_price - $dispatch_merch[$merchid];
											$dispatch_merch[$merchid] = 0;
										}
									}
									else {
										if (empty($member['city'])) {
											$dispatch_price = $dispatch_price - $dispatch_merch[$merchid];
											$dispatch_merch[$merchid] = 0;
										}
									}
								}
							}
						}
					}
				}
			}
		}

		if ($dispatch_price == 0) {
			foreach ($dispatch_merch as &$dm) {
				$dm = 0;
			}

			unset($dm);
		}

		if (!empty($nodispatch_array) && !empty($address)) {
			$nodispatch = '商品“ ';

			foreach ($nodispatch_array['title'] as $k => $v) {
				$nodispatch .= $v . ',';
			}

			$nodispatch = trim($nodispatch, ',');
			$nodispatch .= ' ”不支持配送到' . $nodispatch_array['city'];
			$nodispatch_array['nodispatch'] = $nodispatch;
			$nodispatch_array['isnodispatch'] = 1;
		}

		$data = array();
		$data['dispatch_price'] = $dispatch_price + $seckill_dispatchprice;
		$data['dispatch_merch'] = $dispatch_merch;
		$data['nodispatch_array'] = $nodispatch_array;
		$data['seckill_dispatch_price'] = $seckill_dispatchprice;
		$data['city_express_state'] = $city_express_data['state'];
		return $data;
	}

	public function filterGoods($saleset, $realprice, $seckill_payprice, $goods, $user_city_code, $new_area)
	{
		$new_goods = array();

		if ($saleset) {
			if (!empty($saleset['enoughfree'])) {
				$saleset_free = 0;

				if (floatval($saleset['enoughorder']) <= 0) {
					$saleset_free = 1;
				}
				else {
					if (floatval($saleset['enoughorder']) <= $realprice - $seckill_payprice) {
						if (empty($saleset['enoughareas'])) {
							$saleset_free = 1;
						}
						else {
							if (empty($new_area)) {
								$areas = explode(';', trim($saleset['enoughareas'], ';'));
							}
							else {
								$areas = explode(';', trim($saleset['enoughareas_code'], ';'));
							}

							if (!empty($user_city_code)) {
								if (!in_array($user_city_code, $areas)) {
									$saleset_free = 1;
								}
							}
						}
					}
				}

				if ($saleset_free == 1) {
					$is_nofree = 0;

					if (!empty($saleset['goodsids'])) {
						foreach ($goods as $k => $v) {
							if (!in_array($v['goodsid'], $saleset['goodsids'])) {
								$new_goods[$k] = $goods[$k];
								unset($goods[$k]);
							}
							else {
								$is_nofree = 1;
							}
						}
					}
					else {
						$new_goods = $goods;
					}
				}
			}
		}

		return $new_goods;
	}

	public function changeParentOrderPrice($parent_order)
	{
		global $_W;
		$id = $parent_order['id'];
		$item = pdo_fetch('SELECT price,ordersn2,dispatchprice,changedispatchprice FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (!empty($item)) {
			$orderupdate = array();
			$orderupdate['price'] = $item['price'] + $parent_order['price_change'];
			$orderupdate['ordersn2'] = $item['ordersn2'] + 1;
			$orderupdate['dispatchprice'] = $item['dispatchprice'] + $parent_order['dispatch_change'];
			$orderupdate['changedispatchprice'] = $item['changedispatchprice'] + $parent_order['dispatch_change'];

			if (!empty($orderupdate)) {
				pdo_update('ewei_shop_order', $orderupdate, array('id' => $id, 'uniacid' => $_W['uniacid']));
			}
		}
	}

	public function getOrderCommission($orderid, $agentid = 0)
	{
		global $_W;

		if (empty($agentid)) {
			$item = pdo_fetch('select agentid from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid Limit 1', array('id' => $orderid, ':uniacid' => $_W['uniacid']));

			if (!empty($item)) {
				$agentid = $item['agentid'];
			}
		}

		$level = 0;
		$pc = p('commission');

		if ($pc) {
			$pset = $pc->getSet();
			$level = intval($pset['level']);
		}

		$commission1 = 0;
		$commission2 = 0;
		$commission3 = 0;
		$m1 = false;
		$m2 = false;
		$m3 = false;

		if (!empty($level)) {
			if (!empty($agentid)) {
				$m1 = m('member')->getMember($agentid);

				if (!empty($m1['agentid'])) {
					$m2 = m('member')->getMember($m1['agentid']);

					if (!empty($m2['agentid'])) {
						$m3 = m('member')->getMember($m2['agentid']);
					}
				}
			}
		}

		$order_goods = pdo_fetchall('select g.id,g.title,g.thumb,g.goodssn,og.goodssn as option_goodssn, g.productsn,og.productsn as option_productsn, og.total,og.price,og.optionname as optiontitle, og.realprice,og.changeprice,og.oldprice,og.commission1,og.commission2,og.commission3,og.commissions,og.diyformdata,og.diyformfields from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));

		foreach ($order_goods as &$og) {
			if (!empty($level) && !empty($agentid)) {
				$commissions = iunserializer($og['commissions']);

				if (!empty($m1)) {
					if (is_array($commissions)) {
						$commission1 += isset($commissions['level1']) ? floatval($commissions['level1']) : 0;
					}
					else {
						$c1 = iunserializer($og['commission1']);
						$l1 = $pc->getLevel($m1['openid']);
						$commission1 += isset($c1['level' . $l1['id']]) ? $c1['level' . $l1['id']] : $c1['default'];
					}
				}

				if (!empty($m2)) {
					if (is_array($commissions)) {
						$commission2 += isset($commissions['level2']) ? floatval($commissions['level2']) : 0;
					}
					else {
						$c2 = iunserializer($og['commission2']);
						$l2 = $pc->getLevel($m2['openid']);
						$commission2 += isset($c2['level' . $l2['id']]) ? $c2['level' . $l2['id']] : $c2['default'];
					}
				}

				if (!empty($m3)) {
					if (is_array($commissions)) {
						$commission3 += isset($commissions['level3']) ? floatval($commissions['level3']) : 0;
					}
					else {
						$c3 = iunserializer($og['commission3']);
						$l3 = $pc->getLevel($m3['openid']);
						$commission3 += isset($c3['level' . $l3['id']]) ? $c3['level' . $l3['id']] : $c3['default'];
					}
				}
			}
		}

		unset($og);
		$commission = $commission1 + $commission2 + $commission3;
		return $commission;
	}

	public function checkOrderGoods($orderid)
	{
		global $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid, true);
		$flag = 0;
		$msg = '订单中的商品' . '<br/>';
		$uniacid = $_W['uniacid'];
		$ispeerpay = m('order')->checkpeerpay($orderid);
		$item = pdo_fetch('select * from ' . tablename('ewei_shop_order') . '  where  id = :id and uniacid=:uniacid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid));
		if ((empty($order['isnewstore']) || empty($order['storeid'])) && empty($order['istrade'])) {
			$order_goods = pdo_fetchall('select og.id,g.title, og.goodsid,og.optionid,g.total as stock,og.total as buycount,g.status,g.deleted,g.maxbuy,g.usermaxbuy,g.istime,g.timestart,g.timeend,g.buylevels,g.buygroups,g.totalcnf,og.seckill from  ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id ' . ' where og.orderid=:orderid and og.uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));

			foreach ($order_goods as $data) {
				if (empty($data['status']) || !empty($data['deleted'])) {
					$flag = 1;
					$msg .= $data['title'] . '<br/> 已下架,不能付款!!';
				}

				$unit = empty($data['unit']) ? '件' : $data['unit'];
				$seckillinfo = plugin_run('seckill::getSeckill', $data['goodsid'], $data['optionid'], true, $_W['openid']);
				if ($seckillinfo && $seckillinfo['status'] == 0 || !empty($ispeerpay)) {
				}
				else {
					if ($data['totalcnf'] == 1) {
						if (!empty($data['optionid'])) {
							$option = pdo_fetch('select id,title,marketprice,goodssn,productsn,stock,`virtual` from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $data['goodsid'], ':id' => $data['optionid']));

							if (!empty($option)) {
								if ($option['stock'] != -1) {
									if (empty($option['stock'])) {
										$flag = 1;
										$msg .= $data['title'] . '<br/>' . $option['title'] . ' 库存不足!';
									}
								}
							}
						}
						else {
							if ($data['stock'] != -1) {
								if (empty($data['stock'])) {
									$flag = 1;
									$msg .= $data['title'] . '<br/>库存不足!';
								}
							}
						}
					}
				}
			}
		}
		else if (p('newstore')) {
			$sql = 'select g.id,g.title,ng.gstatus,g.deleted' . ' from ' . tablename('ewei_shop_order_goods') . ' og left join  ' . tablename('ewei_shop_goods') . ' g  on g.id=og.goodsid and g.uniacid=og.uniacid' . ' inner join ' . tablename('ewei_shop_newstore_goods') . ' ng on ng.goodsid = g.id AND ng.storeid=' . $item['storeid'] . ' where og.orderid=:orderid and og.uniacid=:uniacid';
			$list = pdo_fetchall($sql, array(':uniacid' => $uniacid, ':orderid' => $orderid));

			if (!empty($list)) {
				foreach ($list as $k => $v) {
					if (empty($v['gstatus']) || !empty($v['deleted'])) {
						$flag = 1;
						$msg .= $v['title'] . '<br/>';
					}
				}

				if ($flag == 1) {
					$msg .= '已下架,不能付款!';
				}
			}
		}
		else {
			$flag = 1;
			$msg .= '门店歇业,不能付款!';
		}

		$data = array();
		$data['flag'] = $flag;
		$data['msg'] = $msg;
		return $data;
	}

	public function checkpeerpay($orderid)
	{
		global $_W;
		$sql = 'SELECT p.*,o.openid FROM ' . tablename('ewei_shop_order_peerpay') . ' AS p JOIN ' . tablename('ewei_shop_order') . ' AS o ON p.orderid = o.id WHERE p.orderid = :orderid AND p.uniacid = :uniacid AND (p.status = 0 OR p.status=1) AND o.status >= 0 LIMIT 1';
		$query = pdo_fetch($sql, array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']));
		return $query;
	}

	public function peerStatus($param)
	{
		global $_W;

		if (!empty($param['tid'])) {
			$sql = 'SELECT id FROM ' . tablename('ewei_shop_order_peerpay_payinfo') . ' WHERE tid = :tid';
			$id = pdo_fetchcolumn($sql, array(':tid' => $param['tid']));

			if ($id) {
				return $id;
			}
		}

		pdo_insert('ewei_shop_order_peerpay_payinfo', $param);
		$insterid = pdo_insertid();

		if ($insterid) {
			return $insterid;
		}

		return false;
	}

	public function getVerifyCardNumByOrderid($orderid)
	{
		global $_W;
		$num = pdo_fetchcolumn('select SUM(og.total)  from ' . tablename('ewei_shop_order_goods') . ' og
		 inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		 where og.uniacid=:uniacid  and og.orderid =:orderid and g.cardid>0', array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));
		return $num;
	}

	public function checkisonlyverifygoods($orderid)
	{
		global $_W;
		$num = pdo_fetchcolumn('select COUNT(1)  from ' . tablename('ewei_shop_order_goods') . ' og
		 inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		 where og.uniacid=:uniacid  and og.orderid =:orderid and g.type<>5', array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));
		$num = intval($num);

		if (0 < $num) {
			return false;
		}

		$num2 = pdo_fetchcolumn('select COUNT(1)  from ' . tablename('ewei_shop_order_goods') . ' og
             inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
             where og.uniacid=:uniacid  and og.orderid =:orderid and g.type=5', array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));
		$num2 = intval($num2);

		if (0 < $num2) {
			return true;
		}

		return false;
	}

	public function checkhaveverifygoods($orderid)
	{
		global $_W;
		$num = pdo_fetchcolumn('select COUNT(1)  from ' . tablename('ewei_shop_order_goods') . ' og
		 inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		 where og.uniacid=:uniacid  and og.orderid =:orderid and g.type=5', array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));
		$num = intval($num);

		if (0 < $num) {
			return true;
		}

		return false;
	}

	public function checkhaveverifygoodlog($orderid)
	{
		global $_W;
		$num = pdo_fetchcolumn('select COUNT(1)  from ' . tablename('ewei_shop_verifygoods_log') . ' vl
		 inner join ' . tablename('ewei_shop_verifygoods') . ' v on vl.verifygoodsid = v.id
		 where v.uniacid=:uniacid  and v.orderid =:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));
		$num = intval($num);

		if (0 < $num) {
			return true;
		}

		return false;
	}

	public function countOrdersn($ordersn, $str = 'TR')
	{
		global $_W;
		$count = intval(substr_count($ordersn, $str));
		return $count;
	}

	/**
     * 获取订单的虚拟卡密信息
     * @param array $order
     * @return bool
     */
	public function getOrderVirtual($order = array())
	{
		global $_W;

		if (empty($order)) {
			return false;
		}

		if (empty($order['virtual_info'])) {
			return $order['virtual_str'];
		}

		$ordervirtual = array();
		$virtual_type = pdo_fetch('select fields from ' . tablename('ewei_shop_virtual_type') . ' where id=:id and uniacid=:uniacid and merchid = :merchid limit 1 ', array(':id' => $order['virtual'], ':uniacid' => $_W['uniacid'], ':merchid' => $order['merchid']));

		if (!empty($virtual_type)) {
			$virtual_type = iunserializer($virtual_type['fields']);
			$virtual_info = ltrim($order['virtual_info'], '[');
			$virtual_info = rtrim($virtual_info, ']');
			$virtual_info = explode(',', $virtual_info);

			if (!empty($virtual_info)) {
				foreach ($virtual_info as $index => $virtualinfo) {
					$virtual_temp = iunserializer($virtualinfo);

					if (!empty($virtual_temp)) {
						foreach ($virtual_temp as $k => $v) {
							$ordervirtual[$index][] = array('key' => $virtual_type[$k], 'value' => $v, 'field' => $k);
						}

						unset($k);
						unset($v);
					}
				}

				unset($index);
				unset($virtualinfo);
			}
		}

		return $ordervirtual;
	}

	/**
     * 签名生成signature
     */
	public function dada_sign($data, $app_secret)
	{
		ksort($data);
		$args = '';

		foreach ($data as $key => $value) {
			$args .= $key . $value;
		}

		$args = $app_secret . $args . $app_secret;
		$sign = strtoupper(md5($args));
		return $sign;
	}

	/**
     * 构造请求数据
     * data:业务参数，json字符串
     */
	public function dada_bulidRequestParams($data, $app_key, $source_id, $app_secret)
	{
		$requestParams = array();
		$requestParams['app_key'] = $app_key;
		$requestParams['source_id'] = $source_id;
		$requestParams['body'] = json_encode($data);
		$requestParams['format'] = 'json';
		$requestParams['v'] = '1.0';
		$requestParams['timestamp'] = time();
		$requestParams['signature'] = $this->dada_sign($requestParams, $app_secret);
		return $requestParams;
	}

	/**
     * 获取达达的配送城市信息
     */
	public function getdadacity()
	{
		$url = 'http://newopen.imdada.cn/api/cityCode/list';
		$app_key = '';
		$source_id = '73753';
		$app_secret = '';
		$reqParams = $this->dada_bulidRequestParams('', $app_key, $source_id, $app_secret);
		load()->func('communication');
		$resp = ihttp_request($url, json_encode($reqParams), array('Content-Type' => 'application/json'));
		$ret = @json_decode($resp['content'], true);
		return $ret;
	}

	public function dada_send($order)
	{
		global $_W;
		$url = 'http://newopen.imdada.cn/api/order/addOrder';
		$cityexpress = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_city_express') . ' WHERE uniacid=:uniacid AND merchid=:merchid', array(':uniacid' => $_W['uniacid'], ':merchid' => 0));

		if (!empty($cityexpress)) {
			$config = unserialize($cityexpress['config']);

			if ($cityexpress['express_type'] == 1) {
				$app_key = $config['app_key'];
				$app_secret = $config['app_secret'];
				$source_id = $config['source_id'];
				$shop_no = $config['shop_no'];
				$city_code = $config['city_code'];
				$receiver = unserialize($order['address']);
				$location_data = m('util')->geocode($receiver['province'] . $receiver['city'] . $receiver['area'] . $receiver['address'], $cityexpress['geo_key']);
				if ($location_data['status'] == 1 && 0 < $location_data['count']) {
					$location = explode(',', $location_data['geocodes'][0]['location']);
					$data = array('shop_no' => $shop_no, 'city_code' => $city_code, 'origin_id' => $order['ordersn'], 'info' => $order['remark'], 'cargo_price' => $order['price'], 'receiver_name' => $receiver['realname'], 'receiver_address' => $receiver['province'] . $receiver['city'] . $receiver['area'] . $receiver['address'], 'receiver_phone' => $receiver['mobile'], 'receiver_lng' => $location[0], 'receiver_lat' => $location[1], 'is_prepay' => 0, 'expected_fetch_time' => time() + 600, 'callback' => 'http://newopen.imdada.cn/inner/api/order/status/notify');
					$reqParams = $this->dada_bulidRequestParams($data, $app_key, $source_id, $app_secret);
					load()->func('communication');
					$resp = ihttp_request($url, json_encode($reqParams), array('Content-Type' => 'application/json'));
					$ret = @json_decode($resp['content'], true);

					if ($ret['code'] == 0) {
						return array('state' => 1, 'result' => '发货成功');
					}

					return array('state' => 0, 'result' => $ret['msg']);
				}

				return array('state' => 0, 'result' => '获取收件人坐标失败，请检查收件人地址');
			}

			return array('state' => 1, 'result' => '发货成功');
		}
	}

	/**
     * //检测产品的库存
     * @param type $orderid
     * @param type $type 0 下单 1 支付
     */
	public function CheckoodsStock($orderid = '', $type = 0, $flg = true)
	{
		global $_W;

		if (!$flg) {
			return true;
		}

		$order = pdo_fetch('select id,ordersn,price,openid,dispatchtype,addressid,carrier,status,isparent,paytype,isnewstore,storeid,istrade,status from ' . tablename('ewei_shop_order') . ' where id=:id limit 1', array(':id' => $orderid));

		if (!empty($order['istrade'])) {
			return false;
		}

		if (empty($order['isnewstore'])) {
			$newstoreid = 0;
		}
		else {
			$newstoreid = intval($order['storeid']);
		}

		$param = array();
		$param[':uniacid'] = $_W['uniacid'];

		if ($order['isparent'] == 1) {
			$condition = ' og.parentorderid=:parentorderid';
			$param[':parentorderid'] = $orderid;
		}
		else {
			$condition = ' og.orderid=:orderid';
			$param[':orderid'] = $orderid;
		}

		$goods = pdo_fetchall('select og.goodsid,og.total,g.totalcnf,og.realprice,g.credit,og.optionid,g.total as goodstotal,og.optionid,g.sales,g.salesreal,g.type from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . (' where ' . $condition . ' and og.uniacid=:uniacid '), $param);

		if (!empty($goods)) {
			foreach ($goods as $g) {
				if (0 < $newstoreid) {
					$store_goods = m('store')->getStoreGoodsInfo($g['goodsid'], $newstoreid);

					if (empty($store_goods)) {
						return NULL;
					}

					$g['goodstotal'] = $store_goods['stotal'];
				}
				else {
					$goods_item = pdo_fetch('select total as goodstotal from' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $g['goodsid'], ':uniacid' => $_W['uniacid']));
					$g['goodstotal'] = $goods_item['goodstotal'];
				}

				$stocktype = 0;

				if ($type == 0) {
					if ($g['totalcnf'] == 0) {
						$stocktype = -1;
					}
				}
				else {
					if ($type == 1) {
						if ($g['totalcnf'] == 1) {
							$stocktype = -1;
						}
					}
				}

				if (!empty($stocktype)) {
					$data = m('common')->getSysset('trade');

					if (!empty($data['stockwarn'])) {
						$stockwarn = intval($data['stockwarn']);
					}
					else {
						$stockwarn = 5;
					}

					if (!empty($g['optionid'])) {
						$option = m('goods')->getOption($g['goodsid'], $g['optionid']);

						if (0 < $newstoreid) {
							$store_goods_option = m('store')->getOneStoreGoodsOption($g['optionid'], $g['goodsid'], $newstoreid);

							if (empty($store_goods_option)) {
								return NULL;
							}

							$option['stock'] = $store_goods_option['stock'];
						}

						if (!empty($option) && $option['stock'] != -1) {
							if ($stocktype == -1 && $type == 0) {
								$open_redis = function_exists('redis') && !is_error(redis());

								if ($open_redis) {
									$redis_key = $_W['uniacid'] . '_goods_order_option_stock_' . $option['id'];
									$redis = redis();

									if ($redis->setnx($redis_key, $option['stock'])) {
										$totalstock = $option['stock'];
										$newstock = $totalstock - $g['total'];

										if ($newstock < 0) {
											$redis->delete($redis_key);
											return false;
										}

										if ($newstock == 0) {
											$redis->set($redis_key, $newstock);
										}
										else {
											$redis->set($redis_key, $newstock);
										}
									}
									else {
										$totalstock = $redis->get($redis_key);
										if (0 < $option['stock'] && $totalstock == 0) {
											$totalstock = $option['stock'];
										}

										$newstock = $totalstock - $g['total'];

										if ($newstock < 0) {
											$redis->delete($redis_key);
											return false;
										}

										if ($newstock == 0) {
											$redis->set($redis_key, $newstock);
										}
										else {
											$redis->set($redis_key, $newstock);
										}
									}
								}
								else {
									return true;
								}
							}
							else {
								if ($stocktype == -1 && $type == 1) {
									$open_redis = function_exists('redis') && !is_error(redis());

									if ($open_redis) {
										$redis_key = $_W['uniacid'] . '_goods_order_option_stock_' . $option['id'];
										$redis = redis();

										if ($redis->setnx($redis_key, $option['stock'])) {
											$totalstock = $option['stock'];
											$newstock = $totalstock - $g['total'];

											if ($newstock < 0) {
												$redis->delete($redis_key);
												return false;
											}

											if ($newstock == 0) {
												$redis->set($redis_key, $newstock);
											}
											else {
												$redis->set($redis_key, $newstock);
											}
										}
										else {
											$totalstock = $redis->get($redis_key);
											if (0 < $option['stock'] && $totalstock == 0) {
												$totalstock = $option['stock'];
											}

											$newstock = $totalstock - $g['total'];

											if ($newstock < 0) {
												$redis->delete($redis_key);
												return false;
											}

											if ($newstock == 0) {
												$redis->set($redis_key, $newstock);
											}
											else {
												$redis->set($redis_key, $newstock);
											}
										}
									}
									else {
										return true;
									}
								}
							}
						}
					}

					if (!empty($g['goodstotal']) && $g['goodstotal'] != -1) {
						if ($stocktype == -1 && $type == 0) {
							$open_redis = function_exists('redis') && !is_error(redis());

							if ($open_redis) {
								$redis_key = $_W['uniacid'] . '_goods_order_stock_' . $g['goodsid'];
								$redis = redis();

								if ($redis->setnx($redis_key, $g['goodstotal'])) {
									$totalstock = $g['goodstotal'];
									$newstock = $totalstock - $g['total'];

									if ($newstock < 0) {
										$redis->delete($redis_key);
										return false;
									}

									if ($newstock == 0) {
										$redis->set($redis_key, $newstock);
									}
									else {
										$redis->set($redis_key, $newstock);
									}
								}
								else {
									$totalstock = $redis->get($redis_key);
									if (0 < $g['goodstotal'] && $totalstock == 0) {
										$totalstock = $g['goodstotal'];
									}

									$newstock = $totalstock - $g['total'];

									if ($newstock < 0) {
										$redis->delete($redis_key);
										return false;
									}

									if ($newstock == 0) {
										$redis->set($redis_key, $newstock);
									}
									else {
										$redis->set($redis_key, $newstock);
									}
								}
							}
							else {
								return true;
							}
						}
						else {
							if ($stocktype == -1 && $type == 1) {
								$open_redis = function_exists('redis') && !is_error(redis());

								if ($open_redis) {
									$redis_key = $_W['uniacid'] . '_goods_order_stock_' . $g['goodsid'];
									$redis = redis();

									if ($redis->setnx($redis_key, $g['goodstotal'])) {
										$totalstock = $g['goodstotal'];
										$newstock = $totalstock - $g['total'];

										if ($newstock < 0) {
											$redis->delete($redis_key);
											return false;
										}

										if ($newstock == 0) {
											$redis->set($redis_key, $newstock);
										}
										else {
											$redis->set($redis_key, $newstock);
										}
									}
									else {
										$totalstock = $redis->get($redis_key);
										if (0 < $g['goodstotal'] && $totalstock == 0) {
											$totalstock = $g['goodstotal'];
										}

										$newstock = $totalstock - $g['total'];

										if ($newstock < 0) {
											$redis->delete($redis_key);
											return false;
										}

										if ($newstock == 0) {
											$redis->set($redis_key, $newstock);
										}
										else {
											$redis->set($redis_key, $newstock);
										}
									}
								}
								else {
									return true;
								}
							}
						}
					}
					else {
						if ($g['goodstotal'] == 0) {
							$totalstock = 0;
							$totalstock = $g['goodstotal'] - $g['total'];

							if ($totalstock < 0) {
								return false;
							}
						}
					}
				}
			}

			return true;
		}

		return false;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
