<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$cycelbuy_plugin = p('cycelbuy');

		if (!$cycelbuy_plugin) {
			show_message('未找到周期购应用，请联系系统管理员！');
			exit();
		}

		$trade = m('common')->getSysset('trade');
		header('location:' . mobileUrl('cycelbuy/order/list'));
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$member = m('member')->getMember($openid, true);
		$orderid = intval($_GPC['id']);
		$ispeerpay = m('order')->checkpeerpay($orderid);

		if (empty($orderid)) {
			header('location: ' . mobileUrl('cycelbuy/order'));
			exit();
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

		if (empty($order)) {
			header('location: ' . mobileUrl('order'));
			exit();
		}

		if ($order['merchshow'] == 1) {
			header('location: ' . mobileUrl('order'));
			exit();
		}

		if ($order['userdeleted'] == 2) {
			$this->message('订单已经被删除!', '', 'error');
		}

		if (!empty($order['istrade'])) {
			header('location: ' . mobileUrl('newstore/norder/detail', array('id' => $orderid)));
			exit();
		}

		if ($order['refundid'] != 0) {
			$refund = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_order_refund') . ' WHERE orderid = :orderid and uniacid=:uniacid order by id desc', array(':orderid' => $order['id'], ':uniacid' => $_W['uniacid']));
		}

		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);
		$diyform_plugin = p('diyform');
		$diyformfields = '';

		if ($diyform_plugin) {
			$diyformfields = ',og.diyformfields,og.diyformdata';
		}

		$param = array();
		$param[':uniacid'] = $_W['uniacid'];

		if ($order['isparent'] == 1) {
			$scondition = ' og.parentorderid=:parentorderid';
			$param[':parentorderid'] = $orderid;
		}
		else {
			$scondition = ' og.orderid=:orderid';
			$param[':orderid'] = $orderid;
		}

		$condition1 = '';

		if (p('ccard')) {
			$condition1 .= ',g.ccardexplain,g.ccardtimeexplain';
		}

		$goodsid_array = array();
		$goods = pdo_fetchall('select og.goodsid,og.price,g.title,g.thumb,g.status, g.cannotrefund, og.total,g.credit,og.optionid,
            og.optionname as optiontitle,g.isverify,g.storeids,og.seckill,g.isfullback,
            og.seckill_taskid' . $diyformfields . $condition1 . ',og.prohibitrefund  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . (' where ' . $scondition . ' and og.uniacid=:uniacid '), $param);
		$prohibitrefund = false;

		foreach ($goods as &$g) {
			if ($g['isfullback']) {
				$fullbackgoods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_fullback_goods') . ' WHERE goodsid = :goodsid and uniacid = :uniacid  limit 1 ', array(':goodsid' => $g['goodsid'], ':uniacid' => $uniacid));

				if ($g['optionid']) {
					$option = pdo_fetch('select `day`,allfullbackprice,fullbackprice,allfullbackratio,fullbackratio,isfullback
                      from ' . tablename('ewei_shop_goods_option') . ' where id = :id and uniacid = :uniacid ', array(':id' => $g['optionid'], ':uniacid' => $uniacid));
					$fullbackgoods['minallfullbackallprice'] = $option['allfullbackprice'];
					$fullbackgoods['fullbackprice'] = $option['fullbackprice'];
					$fullbackgoods['minallfullbackallratio'] = $option['allfullbackratio'];
					$fullbackgoods['fullbackratio'] = $option['fullbackratio'];
					$fullbackgoods['day'] = $option['day'];
				}

				$g['fullbackgoods'] = $fullbackgoods;
				unset($fullbackgoods);
				unset($option);
			}

			$g['seckill_task'] = false;

			if ($g['seckill']) {
				$g['seckill_task'] = plugin_run('seckill::getTaskInfo', $g['seckill_taskid']);
			}

			if (!empty($g['prohibitrefund'])) {
				$prohibitrefund = true;
			}
		}

		unset($g);
		$goodsrefund = true;

		if (!empty($goods)) {
			foreach ($goods as &$g) {
				$goodsid_array[] = $g['goodsid'];

				if (!empty($g['optionid'])) {
					$thumb = m('goods')->getOptionThumb($g['goodsid'], $g['optionid']);

					if (!empty($thumb)) {
						$g['thumb'] = $thumb;
					}
				}

				if (!empty($g['cannotrefund']) && $order['status'] == 2) {
					$goodsrefund = false;
				}
			}

			unset($g);
		}

		$diyform_flag = 0;

		if ($diyform_plugin) {
			foreach ($goods as &$g) {
				$g['diyformfields'] = iunserializer($g['diyformfields']);
				$g['diyformdata'] = iunserializer($g['diyformdata']);
				unset($g);
			}

			if (!empty($order['diyformfields']) && !empty($order['diyformdata'])) {
				$order_fields = iunserializer($order['diyformfields']);
				$order_data = iunserializer($order['diyformdata']);
			}
		}

		$address = false;

		if (!empty($order['addressid'])) {
			$address = iunserializer($order['address']);

			if (!is_array($address)) {
				$address = pdo_fetch('select * from  ' . tablename('ewei_shop_member_address') . ' where id=:id limit 1', array(':id' => $order['addressid']));
			}
		}

		$carrier = @iunserializer($order['carrier']);
		if (!is_array($carrier) || empty($carrier)) {
			$carrier = false;
		}

		$store = false;

		if (!empty($order['storeid'])) {
			$store = pdo_fetch('select * from  ' . tablename('ewei_shop_store') . ' where id=:id limit 1', array(':id' => $order['storeid']));
		}

		$stores = false;
		$showverify = false;
		$canverify = false;
		$verifyinfo = false;

		if (com('verify')) {
			$showverify = $order['dispatchtype'] || $order['isverify'];

			if ($order['isverify']) {
				if (0 < $order['verifyendtime'] && $order['verifyendtime'] < time()) {
					$order['status'] = -1;
				}

				$storeids = array();

				foreach ($goods as $g) {
					if (!empty($g['storeids'])) {
						$storeids = array_merge(explode(',', $g['storeids']), $storeids);
					}
				}

				if (empty($storeids)) {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
				}
				else {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
				}

				if ($order['verifytype'] == 0 || $order['verifytype'] == 1 || $order['verifytype'] == 3) {
					$vs = iunserializer($order['verifyinfo']);
					$verifyinfo = array(
						array('verifycode' => $order['verifycode'], 'verified' => $order['verifytype'] == 0 || $order['verifytype'] == 3 ? $order['verified'] : $goods[0]['total'] <= count($vs))
						);
					if ($order['verifytype'] == 0 || $order['verifytype'] == 3) {
						$canverify = empty($order['verified']) && $showverify;
					}
					else {
						if ($order['verifytype'] == 1) {
							$canverify = count($vs) < $goods[0]['total'] && $showverify;
						}
					}
				}
				else {
					$verifyinfo = iunserializer($order['verifyinfo']);
					$last = 0;

					foreach ($verifyinfo as $v) {
						if (!$v['verified']) {
							++$last;
						}
					}

					$canverify = 0 < $last && $showverify;
				}
			}
			else {
				if (!empty($order['dispatchtype'])) {
					$verifyinfo = array(
						array('verifycode' => $order['verifycode'], 'verified' => $order['status'] == 3)
						);
					$canverify = $order['status'] == 1 && $showverify;
				}
			}
		}

		$order['canverify'] = $canverify;
		$order['showverify'] = $showverify;
		if ($order['status'] == 1 || $order['status'] == 2) {
			$canrefund = true;
			if ($order['status'] == 2 && $order['price'] == $order['dispatchprice']) {
				if (0 < $order['refundstate']) {
					$canrefund = true;
				}
				else {
					$canrefund = false;
				}
			}
		}
		else {
			if ($order['status'] == 3) {
				if ($order['isverify'] != 1 && empty($order['virtual'])) {
					if (0 < $order['refundstate']) {
						$canrefund = true;
					}
					else {
						$tradeset = m('common')->getSysset('trade');
						$refunddays = intval($tradeset['refunddays']);

						if (0 < $refunddays) {
							$days = intval((time() - $order['finishtime']) / 3600 / 24);

							if ($days <= $refunddays) {
								$canrefund = true;
							}
						}
					}
				}
			}
		}

		if (!empty($order['isnewstore']) && 1 < $order['status']) {
			$canrefund = false;
		}

		if ($prohibitrefund) {
			$canrefund = false;
		}

		if (!$goodsrefund && $canrefund) {
			$canrefund = false;
		}

		if (p('ccard')) {
			if (!empty($order['ccard']) && 1 < $order['status']) {
				$canrefund = false;
			}

			$comdata = m('common')->getPluginset('commission');
			if (!empty($comdata['become_goodsid']) && !empty($goodsid_array)) {
				if (in_array($comdata['become_goodsid'], $goodsid_array)) {
					$canrefund = false;
				}
			}
		}

		$haveverifygoodlog = m('order')->checkhaveverifygoodlog($orderid);

		if ($haveverifygoodlog) {
			$canrefund = false;
		}

		$order['canrefund'] = $canrefund;
		$express = false;
		$order_goods = array();
		if (2 <= $order['status'] && empty($order['isvirtual']) && empty($order['isverify'])) {
			$expresslist = m('util')->getExpressList($order['express'], $order['expresssn']);

			if (0 < count($expresslist)) {
				$express = $expresslist[0];
			}
		}

		if (0 < $order['sendtype'] && 1 <= $order['status']) {
			$order_goods = pdo_fetchall('select orderid,goodsid,sendtype,expresscom,expresssn,express,sendtime from ' . tablename('ewei_shop_order_goods') . '
            where orderid = ' . $orderid . ' and uniacid = ' . $uniacid . ' and sendtype > 0 group by sendtype order by sendtime asc ');
			$expresslist = m('util')->getExpressList($order['express'], $order['expresssn']);

			if (0 < count($expresslist)) {
				$express = $expresslist[0];
			}

			$order['sendtime'] = $order_goods[0]['sendtime'];
		}

		$shopname = $_W['shopset']['shop']['name'];
		$cycelSql = 'SELECT * FROM ' . tablename('ewei_shop_cycelbuy_periods') . ' WHERE orderid=:orderid AND uniacid=:uniacid';
		$cycelParams = array(':orderid' => $order['id'], ':uniacid' => $_W['uniacid']);
		$cycelData = pdo_fetchall($cycelSql, $cycelParams);
		$cycelUnderway = pdo_fetch('SELECT count(*) as count FROM ' . tablename('ewei_shop_cycelbuy_periods') . ' WHERE orderid=' . $order['id'] . ' AND status<=1 AND uniacid=' . $_W['uniacid']);
		$activity = com('coupon')->activity($order['price']);

		if (count($cycelData) == $cycelUnderway['count']) {
			$norStart = 1;
		}
		else {
			$norStart = 0;
		}

		$notArray = array();
		$start = false;
		$cycelids = array();

		foreach ($cycelData as $key => &$row) {
			if ($row['status'] == 0) {
				$notArray[] = $key;
			}
			else if ($row['status'] == 1) {
				$start = true;
				$period_index = $key;
			}
			else {
				if ($row['status'] == 2) {
				}
			}
		}

		unset($row);
		if (empty($start) && !empty($notArray)) {
			$period_index = min($notArray);
		}

		include $this->template();
	}

	public function express()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['orderid']);
		$id = intval($_GPC['id']);
		if (empty($orderid) || empty($id)) {
			header('location: ' . mobileUrl('cycelbuy/order'));
			exit();
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where id=:id  and orderid = :orderid and uniacid=:uniacid limit 1', array(':id' => $id, ':orderid' => $orderid, ':uniacid' => $uniacid));

		if (empty($order)) {
			header('location: ' . mobileUrl('cycelbuy/order'));
			exit();
		}

		if (empty($order['addressid'])) {
			$this->message('订单非快递单，无法查看物流信息!');
		}

		if ($order['status'] < 1) {
			$this->message('订单未发货，无法查看物流信息!');
		}

		$condition = '';
		$goods = pdo_fetchall('select og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,og.optionname as optiontitle,g.isverify,og.expresssn,og.express,
            og.sendtype,og.expresscom,og.sendtime,g.storeids' . $diyformfields . '
            from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid ' . $condition . ' and og.uniacid=:uniacid ', array(':uniacid' => $uniacid, ':orderid' => $orderid));
		$expresslist = m('util')->getExpressList($order['express'], $order['expresssn']);
		include $this->template();
	}

	public function dispatch()
	{
		global $_W;
		global $_GPC;
		$merchid = intval($_GPC['merchid']);
		$list = m('dispatch')->getDispatchList($merchid);
		include $this->template();
	}

	/**
     *  周期购所有数据
     */
	public function cycledetail()
	{
		global $_GPC;
		global $_W;
		$orderid = intval($_GPC['id']);

		if (empty($orderid)) {
			$this->message('数据不存在!');
		}

		$oSql = 'select id,status,refundstate from ' . tablename('ewei_shop_order') . (' where id = ' . $orderid . ' and uniacid = ' . $_W['uniacid']);
		$oData = pdo_fetch($oSql);
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_cycelbuy_periods') . ' WHERE orderid = :orderid AND uniacid = :uniacid ';
		$params = array(':orderid' => $orderid, ':uniacid' => intval($_W['uniacid']));
		$list = pdo_fetchall($sql, $params);
		$notStart = false;
		$status0 = 0;
		$status2 = 0;
		$weekArr = array('星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六');
		$notArray = array();
		$start = false;

		foreach ($list as $key => &$row) {
			$row['week'] = $weekArr[date('w', $row['receipttime'])];
			$address = unserialize($row['address']);

			if (!empty($address['street'])) {
				$row['addressInfo'] = $address['province'] . $address['city'] . $address['area'] . $address['street'] . $address['address'];
			}
			else {
				$row['addressInfo'] = $address['province'] . $address['city'] . $address['area'] . $address['address'];
			}

			if ($row['status'] == 0) {
				$notArray[] = $key;
				$receipttimeArray[] = $list[$key]['receipttime'];
				$status0 += 1;
			}
			else if ($row['status'] == 1) {
				$start = true;
				$period_index = $key;

				if (!empty($list[$key + 1]['receipttime'])) {
					$receipttime = $list[$key + 1]['receipttime'];
				}
				else {
					$receipttime = $list[$key]['receipttime'];
				}
			}
			else {
				if ($row['status'] == 2) {
					$status2 += 1;
				}
			}
		}

		unset($row);
		if (empty($start) && !empty($notArray)) {
			$period_index = min($notArray);
		}

		if (empty($start) && !empty($receipttimeArray)) {
			$receipttime = min($receipttimeArray);
		}

		$existApply = '';
		$existApply = pdo_get('ewei_shop_address_applyfor', array('orderid' => $orderid, 'uniacid' => $_W['uniacid'], 'isdelete' => 0));
		$cycelbuy_periodic = pdo_fetchcolumn('select cycelbuy_periodic from ' . tablename('ewei_shop_order') . ' where id=:orderid and uniacid=:uniacid limit 1', $params);
		$applyfor = pdo_get('ewei_shop_address_applyfor', array('orderid' => $orderid, 'uniacid' => $_W['uniacid']));
		include $this->template();
	}

	public function success()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$member = m('member')->getMember($openid, true);
		$orderid = intval($_GPC['id']);

		if (empty($orderid)) {
			$this->message('参数错误', mobileUrl('order'), 'error');
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));
		@session_start();

		if (!isset($_SESSION[EWEI_SHOPV2_PREFIX . '_order_pay_complete'])) {
			if (empty($order['istrade'])) {
				header('location: ' . mobileUrl('order'));
			}
			else {
				header('location: ' . mobileUrl('newstore/norder'));
			}

			exit();
		}

		unset($_SESSION[EWEI_SHOPV2_PREFIX . '_order_pay_complete']);
		$hasverifygood = m('order')->checkhaveverifygoods($orderid);
		$isonlyverifygoods = m('order')->checkisonlyverifygoods($orderid);
		$ispeerpay = m('order')->checkpeerpay($orderid);

		if (!empty($ispeerpay)) {
			$peerpay = floatval($_GPC['peerpay']);
			$openid = pdo_fetchcolumn('select openid from ' . tablename('ewei_shop_order') . ' where id=:orderid and uniacid=:uniacid limit 1', array(':orderid' => $orderid, ':uniacid' => $uniacid));
			$order['price'] = $ispeerpay['realprice'];
			$peerpayuid = m('member')->getInfo($_W['openid']);
			$peerprice = pdo_fetch('SELECT `price` FROM ' . tablename('ewei_shop_order_peerpay_payinfo') . ' WHERE uid = :uid ORDER BY id DESC LIMIT 1', array(':uid' => $peerpayuid['id']));
			$activity = com('coupon')->activity(empty($peerprice) ? 0 : $peerprice['price']);

			if ($activity) {
				$share = true;
			}
			else {
				$share = false;
			}
		}
		else {
			if (!empty($order['istrade'])) {
				if ($order['status'] == 1 && $order['tradestatus'] == 1) {
					$order['price'] = $order['dowpayment'];
				}
				else {
					if ($order['status'] == 1 && $order['tradestatus'] == 2) {
						$order['price'] = $order['betweenprice'];
					}
				}
			}

			$merchid = $order['merchid'];
			$goods = pdo_fetchall('select og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,og.optionname as optiontitle,g.isverify,g.storeids from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.uniacid=:uniacid ', array(':uniacid' => $uniacid, ':orderid' => $orderid));
			$address = false;

			if (!empty($order['addressid'])) {
				$address = iunserializer($order['address']);

				if (!is_array($address)) {
					$address = pdo_fetch('select * from  ' . tablename('ewei_shop_member_address') . ' where id=:id limit 1', array(':id' => $order['addressid']));
				}
			}

			$carrier = @iunserializer($order['carrier']);
			if (!is_array($carrier) || empty($carrier)) {
				$carrier = false;
			}

			$activity = com('coupon')->activity($order['price']);

			if ($activity) {
				$share = true;
			}
			else {
				$share = false;
			}
		}

		include $this->template();
	}

	public function confirm_receipt()
	{
		global $_W;
		global $_GPC;
		$p = p('commission');
		$pcoupon = com('coupon');
		$id = $_GPC['id'];
		$orderid = $_GPC['orderid'];

		if (empty($id)) {
			show_json(0, '缺少分期ID');
		}

		if (empty($orderid)) {
			show_json(0, '缺少订单ID');
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and id=:id  limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $orderid));
		$last_periods = pdo_fetch('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where uniacid=:uniacid and orderid=:orderid order by id desc  limit 1', array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));

		if (!empty($last_periods)) {
			if ($last_periods['id'] == $id) {
				pdo_update('ewei_shop_order', array('status' => 3, 'finishtime' => time()), array('id' => $orderid, 'status' => 2));
				$result = pdo_update('ewei_shop_cycelbuy_periods', array('status' => 2, 'finishtime' => time()), array('orderid' => $orderid, 'uniacid' => $_W['uniacid']));
				m('member')->upgradeLevel($order['openid'], $orderid);
				m('order')->setGiveBalance($orderid, 1);
				m('notice')->sendOrderMessage($orderid);
				m('order')->fullback($orderid);
				m('order')->setStocksAndCredits($orderid, 3);

				if ($pcoupon) {
					com('coupon')->sendcouponsbytask($orderid);

					if (!empty($order['couponid'])) {
						$pcoupon->backConsumeCoupon($orderid);
					}
				}

				if ($p) {
					$p->checkOrderFinish($orderid);
				}
			}
			else {
				$result = pdo_update('ewei_shop_cycelbuy_periods', array('status' => 2, 'finishtime' => time()), array('id' => $id, 'uniacid' => $_W['uniacid']));
			}

			if ($result != false) {
				show_json(1, '确认收货成功');
			}
			else {
				show_json(0, '确认收货失败');
			}
		}
	}
}

?>
