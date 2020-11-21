<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Export_EweiShopV2Page extends MerchWebPage
{
	protected function field_index($columns, $field)
	{
		$index = -1;

		foreach ($columns as $i => $v) {
			if ($v['field'] == $field) {
				$index = $i;
				break;
			}
		}

		return $index;
	}

	protected function defaultColumns()
	{
		return array(
			array('title' => '订单编号', 'field' => 'ordersn', 'width' => 24),
			array('title' => '粉丝昵称', 'field' => 'nickname', 'width' => 12),
			array('title' => '会员姓名', 'field' => 'mrealname', 'width' => 12),
			array('title' => '会员等级', 'field' => 'levelname', 'width' => 12),
			array('title' => '会员手机号', 'field' => 'mmobile', 'width' => 12),
			array('title' => 'openid', 'field' => 'openid', 'width' => 24),
			array('title' => '收货姓名(或自提人)', 'field' => 'realname', 'width' => 12),
			array('title' => '联系电话', 'field' => 'mobile', 'width' => 12),
			array('title' => '收货地址', 'subtitle' => '收货地址(省市区合并)', 'field' => 'address', 'width' => 24),
			array('title' => '收货地址', 'subtitle' => '收货地址(省市区分离)', 'field' => 'address_province', 'width' => 12),
			array('title' => '商品信息', 'subtitle' => '商品信息(信息合并)', 'field' => 'goods_str', 'width' => 36),
			array('title' => '商品信息', 'subtitle' => '商品信息(信息分离)', 'field' => 'goods_title', 'width' => 24),
			array('title' => '卖家备注', 'field' => 'remarksaler', 'width' => 12),
			array('title' => '支付方式', 'field' => 'paytype', 'width' => 12),
			array('title' => '配送方式', 'field' => 'dispatchname', 'width' => 12),
			array('title' => '商品小计', 'field' => 'goodsprice', 'width' => 12),
			array('title' => '运费', 'field' => 'dispatchprice', 'width' => 12),
			array('title' => '积分抵扣', 'field' => 'deductprice', 'width' => 12),
			array('title' => '余额抵扣', 'field' => 'deductcredit2', 'width' => 12),
			array('title' => '满额立减', 'field' => 'deductenough', 'width' => 12),
			array('title' => '优惠券优惠', 'field' => 'couponprice', 'width' => 12),
			array('title' => '订单改价', 'field' => 'changeprice', 'width' => 12),
			array('title' => '运费改价', 'field' => 'changedispatchprice', 'width' => 12),
			array('title' => '应收款', 'field' => 'price', 'width' => 12),
			array('title' => '状态', 'field' => 'status', 'width' => 12),
			array('title' => '下单时间', 'field' => 'createtime', 'width' => 24),
			array('title' => '付款时间', 'field' => 'paytime', 'width' => 24),
			array('title' => '发货时间', 'field' => 'sendtime', 'width' => 24),
			array('title' => '完成时间', 'field' => 'finishtime', 'width' => 24),
			array('title' => '快递公司', 'field' => 'expresscom', 'width' => 24),
			array('title' => '快递单号', 'field' => 'expresssn', 'width' => 24),
			array('title' => '订单备注', 'field' => 'remark', 'width' => 36),
			array('title' => '核销员', 'field' => 'salerinfo', 'width' => 24),
			array('title' => '核销门店', 'field' => 'storeinfo', 'width' => 36),
			array('title' => '订单自定义信息', 'field' => 'order_diyformdata', 'width' => 36),
			array('title' => '商品自定义信息', 'field' => 'goods_diyformdata', 'width' => 36),
			array('title' => '佣金总额', 'field' => 'commission', 'width' => 12),
			array('title' => '一级佣金', 'field' => 'commission1', 'width' => 12),
			array('title' => '二级佣金', 'field' => 'commission2', 'width' => 12),
			array('title' => '三级佣金', 'field' => 'commission3', 'width' => 12),
			array('title' => '扣除佣金后利润', 'field' => 'commission4', 'width' => 12),
			array('title' => '扣除佣金及运费后利润', 'field' => 'profit', 'width' => 12)
		);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$plugin_diyform = p('diyform');
		$sets = $this->model->getSet();
		$shop_set = $sets['shop'];
		$dflag = intval($_GPC['dflag']);
		$level = 0;
		$pc = p('commission');

		if ($pc) {
			$pset = $pc->getSet();
			$level = intval($pset['level']);
		}

		$default_columns = $this->defaultColumns();
		$templates = isset($shop_set['ordertemplates']) ? $shop_set['ordertemplates'] : array();
		$columns = isset($shop_set['ordercolumns']) ? $shop_set['ordercolumns'] : array();

		if (empty($columns)) {
			if ($dflag == 0) {
				$columns = $default_columns;
			}
		}

		foreach ($default_columns as &$dc) {
			$dc['select'] = false;

			foreach ($columns as $c) {
				if ($dc['field'] == $c['field']) {
					$dc['select'] = true;
					break;
				}
			}
		}

		unset($dc);
		$paytype = array(
			0  => array('css' => 'default', 'name' => '未支付'),
			1  => array('css' => 'danger', 'name' => '余额支付'),
			11 => array('css' => 'default', 'name' => '后台付款'),
			2  => array('css' => 'danger', 'name' => '在线支付'),
			21 => array('css' => 'success', 'name' => '微信支付'),
			22 => array('css' => 'warning', 'name' => '支付宝支付'),
			23 => array('css' => 'warning', 'name' => '银联支付'),
			3  => array('css' => 'primary', 'name' => '货到付款')
		);
		$orderstatus = array(
			-1 => array('css' => 'default', 'name' => '已关闭'),
			0  => array('css' => 'danger', 'name' => '待付款'),
			1  => array('css' => 'info', 'name' => '待发货'),
			2  => array('css' => 'warning', 'name' => '待收货'),
			3  => array('css' => 'success', 'name' => '已完成')
		);

		if ($_GPC['export'] == 1) {
			$address2index = $this->field_index($columns, 'address_province');

			if ($address2index != -1) {
				array_splice($columns, $address2index + 1, 0, array(
					array('title' => '', 'field' => 'address_city', 'width' => 12),
					array('title' => '', 'field' => 'address_area', 'width' => 12),
					array('title' => '', 'field' => 'address_street', 'width' => 12),
					array('title' => '', 'field' => 'address_address', 'width' => 24)
				));
			}

			$goodsindex = $this->field_index($columns, 'goods_title');

			if ($goodsindex != -1) {
				array_splice($columns, $goodsindex + 1, 0, array(
					array('title' => '商品编码', 'field' => 'goods_goodssn', 'width' => 12),
					array('title' => '商品规格', 'field' => 'goods_optiontitle', 'width' => 12),
					array('title' => '商品数量', 'field' => 'goods_total', 'width' => 12),
					array('title' => '商品单价(折扣前)', 'field' => 'goods_price1', 'width' => 12),
					array('title' => '商品单价(折扣后)', 'field' => 'goods_price2', 'width' => 12),
					array('title' => '商品价格(折扣后)', 'field' => 'goods_rprice1', 'width' => 12),
					array('title' => '商品价格(折扣后)', 'field' => 'goods_rprice2', 'width' => 12)
				));
			}

			plog('order.export', '导出订单');
			$status = $_GPC['status'];
			$condition = ' o.uniacid = :uniacid and o.merchid = :merchid and o.isparent=0 and o.deleted=0';
			$paras = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);
			if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
				$starttime = strtotime($_GPC['time']['start']);
				$endtime = strtotime($_GPC['time']['end']);
				$condition .= ' AND o.createtime >= :starttime AND o.createtime <= :endtime ';
				$paras[':starttime'] = $starttime;
				$paras[':endtime'] = $endtime;
			}

			if ($_GPC['paytype'] != '') {
				if ($_GPC['paytype'] == '2') {
					$condition .= ' AND ( o.paytype =21 or o.paytype=22 or o.paytype=23 )';
				}
				else {
					$condition .= ' AND o.paytype =' . intval($_GPC['paytype']);
				}
			}

			if (!empty($_GPC['keyword'])) {
				$_GPC['keyword'] = trim($_GPC['keyword']);
				$condition .= ' AND o.ordersn LIKE \'%' . $_GPC['keyword'] . '%\'';
			}

			if (!empty($_GPC['expresssn'])) {
				$_GPC['expresssn'] = trim($_GPC['expresssn']);
				$condition .= ' AND o.expresssn LIKE \'%' . $_GPC['expresssn'] . '%\'';
			}

			if (!empty($_GPC['member'])) {
				$_GPC['member'] = trim($_GPC['member']);
				$condition .= ' AND (m.realname LIKE \'%' . $_GPC['member'] . '%\' or m.mobile LIKE \'%' . $_GPC['member'] . '%\' or m.nickname LIKE \'%' . $_GPC['member'] . '%\' ' . (' or a.realname LIKE \'%' . $_GPC['member'] . '%\' or a.mobile LIKE \'%' . $_GPC['member'] . '%\' or o.carrier LIKE \'%' . $_GPC['member'] . '%\')');
			}

			if (!empty($_GPC['saler'])) {
				$_GPC['saler'] = trim($_GPC['saler']);
				$condition .= ' AND (sm.realname LIKE \'%' . $_GPC['saler'] . '%\' or sm.mobile LIKE \'%' . $_GPC['saler'] . '%\' or sm.nickname LIKE \'%' . $_GPC['saler'] . '%\' ' . (' or s.salername LIKE \'%' . $_GPC['saler'] . '%\' )');
			}

			if (!empty($_GPC['storeid'])) {
				$_GPC['storeid'] = trim($_GPC['storeid']);
				$condition .= ' AND o.verifystoreid=' . intval($_GPC['storeid']);
			}

			$export_dispatch = $_GPC['export_dispatch'];
			$export_since = $_GPC['export_since'];
			$export_verify = $_GPC['export_verify'];
			$export_virtual = $_GPC['export_virtual'];
			if ($export_dispatch == 1 || $export_since == 1 || $export_verify == 1 || $export_virtual == 1) {
				$condition .= ' AND ( ';

				if ($export_dispatch == 1) {
					$condition .= ' o.addressid <> 0 or';
				}

				if ($export_since == 1) {
					$condition .= ' (o.addressid = 0 and o.isverify = 0 and o.isvirtual = 0) or';
				}

				if ($export_verify == 1) {
					$condition .= '  o.isverify = 1 or';
				}

				if ($export_virtual == 1) {
					$condition .= ' o.isvirtual = 1';
				}

				$condition = rtrim($condition, 'or');
				$condition .= ' )';
			}

			$statuscondition = '';

			if ($status != '') {
				if ($status == '-1') {
					$statuscondition = ' AND o.status=-1 and o.refundtime=0';
				}
				else if ($status == '4') {
					$statuscondition = ' AND o.refundstate>0 and o.refundid<>0';
				}
				else if ($status == '5') {
					$statuscondition = ' AND o.refundtime<>0';
				}
				else if ($status == '1') {
					$statuscondition = ' AND ( o.status = 1 or (o.status=0 and o.paytype=3) )';
				}
				else if ($status == '0') {
					$statuscondition = ' AND o.status = 0 and o.paytype<>3';
				}
				else {
					$statuscondition = ' AND o.status = ' . intval($status);
				}
			}

			$sql = 'select o.* , a.realname as arealname,a.mobile as amobile,a.province as aprovince ,a.city as acity , a.area as aarea,a.address as aaddress,a.street as astreet,d.dispatchname,m.nickname,m.id as mid,m.realname as mrealname,m.mobile as mmobile,sm.id as salerid,sm.nickname as salernickname,s.salername from ' . tablename('ewei_shop_order') . ' o' . ' left join ' . tablename('ewei_shop_order_refund') . ' r on r.id =o.refundid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid and m.uniacid =  o.uniacid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id=o.addressid ' . ' left join ' . tablename('ewei_shop_dispatch') . ' d on d.id = o.dispatchid ' . ' left join ' . tablename('ewei_shop_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('ewei_shop_merch_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . (' where ' . $condition . ' ' . $statuscondition . ' ORDER BY o.createtime DESC,o.status DESC  ');
			$list = pdo_fetchall($sql, $paras);
			$goodscount = 0;

			foreach ($list as &$value) {
				$agentid = $value['agentid'];
				$s = $value['status'];
				$pt = $value['paytype'];
				$value['realname'] = str_replace('=', '', $value['realname']);
				$value['nickname'] = str_replace('=', '', $value['nickname']);
				$value['statusvalue'] = $s;
				$value['statuscss'] = $orderstatus[$value['status']]['css'];
				$value['status'] = $orderstatus[$value['status']]['name'];
				if ($pt == 3 && empty($value['statusvalue'])) {
					$value['statuscss'] = $orderstatus[1]['css'];
					$value['status'] = $orderstatus[1]['name'];
				}

				if ($s == 1) {
					if ($value['isverify'] == 1) {
						$value['status'] = '待使用';
					}
					else {
						if (empty($value['addressid'])) {
							$value['status'] = '待取货';
						}
					}
				}

				if ($s == -1) {
					if (!empty($value['refundtime'])) {
						$value['status'] = '已退款';
					}
				}

				$value['paytypevalue'] = $pt;
				$value['css'] = $paytype[$pt]['css'];
				$value['paytype'] = $paytype[$pt]['name'];
				$value['dispatchname'] = empty($value['addressid']) ? '自提' : $value['dispatchname'];

				if (empty($value['dispatchname'])) {
					$value['dispatchname'] = '快递';
				}

				if ($value['isverify'] == 1) {
					$value['dispatchname'] = '线下核销';
				}
				else if ($value['isvirtual'] == 1) {
					$value['dispatchname'] = '虚拟物品';
				}
				else {
					if (!empty($value['virtual'])) {
						$value['dispatchname'] = '虚拟物品(卡密)<br/>自动发货';
					}
				}

				if ($value['dispatchtype'] == 1 || !empty($value['isverify']) || !empty($value['virtual']) || !empty($value['isvirtual'])) {
					$value['address'] = '';
					$carrier = iunserializer($value['carrier']);

					if (is_array($carrier)) {
						$value['addressdata']['realname'] = $value['realname'] = $carrier['carrier_realname'];
						$value['addressdata']['mobile'] = $value['mobile'] = $carrier['carrier_mobile'];
					}
				}
				else {
					$address = iunserializer($value['address']);
					$isarray = is_array($address);
					$value['realname'] = $isarray ? $address['realname'] : $value['arealname'];
					$value['mobile'] = $isarray ? $address['mobile'] : $value['amobile'];
					$value['province'] = $isarray ? $address['province'] : $value['aprovince'];
					$value['city'] = $isarray ? $address['city'] : $value['acity'];
					$value['area'] = $isarray ? $address['area'] : $value['aarea'];
					$value['address'] = $isarray ? $address['address'] : $value['aaddress'];
					$value['street'] = $isarray ? $address['street'] : $value['astreet'];
					$value['address_province'] = $value['province'];
					$value['address_city'] = $value['city'];
					$value['address_area'] = $value['area'];
					$value['address_address'] = $value['address'];
					$value['address_street'] = $value['street'];
					$value['address'] = $value['province'] . ' ' . $value['city'] . ' ' . $value['area'] . ' ' . $value['street'] . ' ' . $value['address'];
				}

				$commission1 = 0;
				$commission2 = 0;
				$commission3 = 0;
				$m1 = false;
				$m2 = false;
				$m3 = false;

				if (!empty($level)) {
					if (!empty($value['agentid'])) {
						$m1 = m('member')->getMember($value['agentid']);

						if (!empty($m1['agentid'])) {
							$m2 = m('member')->getMember($m1['agentid']);

							if (!empty($m2['agentid'])) {
								$m3 = m('member')->getMember($m2['agentid']);
							}
						}
					}
				}

				$order_goods = pdo_fetchall('select g.id,g.title,g.thumb,g.goodssn,og.goodssn as option_goodssn, g.productsn,og.productsn as option_productsn, og.total,og.price,og.optionname as optiontitle, og.realprice,og.changeprice,og.oldprice,og.commission1,og.commission2,og.commission3,og.commissions,og.diyformdata,og.diyformfields from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.merchid = :merchid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid'], ':orderid' => $value['id']));
				$goods = '';
				$goodscount += count($order_goods);

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

					$goods .= '' . $og['title'] . '
';

					if (!empty($og['optiontitle'])) {
						$goods .= ' 规格: ' . $og['optiontitle'];
					}

					if (!empty($og['option_goodssn'])) {
						$og['goodssn'] = $og['option_goodssn'];
					}

					if (!empty($og['option_productsn'])) {
						$og['productsn'] = $og['option_productsn'];
					}

					if (!empty($og['goodssn'])) {
						$goods .= ' 商品编号: ' . $og['goodssn'];
					}

					if (!empty($og['productsn'])) {
						$goods .= ' 商品条码: ' . $og['productsn'];
					}

					$goods .= ' 单价: ' . $og['price'] / $og['total'] . ' 折扣后: ' . $og['realprice'] / $og['total'] . ' 数量: ' . $og['total'] . ' 总价: ' . $og['price'] . ' 折扣后: ' . $og['realprice'] . '
 ';
					if ($plugin_diyform && !empty($og['diyformfields']) && !empty($og['diyformdata'])) {
						$diyformdata_array = $plugin_diyform->getDatas(iunserializer($og['diyformfields']), iunserializer($og['diyformdata']));
						$diyformdata = '';

						foreach ($diyformdata_array as $da) {
							$diyformdata .= $da['name'] . ': ' . $da['value'] . '
';
						}

						$og['goods_diyformdata'] = $diyformdata;
					}
				}

				unset($og);
				$levelname = '普通会员';
				$mlevel = m('member')->getLevel($value['openid']);

				if ($mlevel) {
					$levelname = $mlevel['levelname'];
				}

				$value['levelname'] = $levelname;
				$value['goods'] = $order_goods;
				$value['goodscount'] = count($order_goods);
				$goodscount += $value['goodscount'];
				$value['commission'] = $commission1 + $commission2 + $commission3;
				$value['commission1'] = $commission1;
				$value['commission2'] = $commission2;
				$value['commission3'] = $commission3;
				$value['commission4'] = $value['price'] - ($commission1 + $commission2 + $commission3);
				$value['profit'] = $value['price'] - $value['dispatchprice'] - ($commission1 + $commission2 + $commission3);
				$value['goods_str'] = $goods;
				$value['ordersn'] = $value['ordersn'] . ' ';

				if (0 < $value['deductprice']) {
					$value['deductprice'] = '-' . $value['deductprice'];
				}

				if (0 < $value['deductcredit2']) {
					$value['deductcredit2'] = '-' . $value['deductcredit2'];
				}

				if (0 < $value['deductenough']) {
					$value['deductenough'] = '-' . $value['deductenough'];
				}

				if ($value['changeprice'] < 0) {
					$value['changeprice'] = '-' . $value['changeprice'];
				}
				else {
					if (0 < $value['changeprice']) {
						$value['changeprice'] = '+' . $value['changeprice'];
					}
				}

				if ($value['changedispatchprice'] < 0) {
					$value['changedispatchprice'] = '-' . $value['changedispatchprice'];
				}
				else {
					if (0 < $value['changedispatchprice']) {
						$value['changedispatchprice'] = '+' . $value['changedispatchprice'];
					}
				}

				if (0 < $value['couponprice']) {
					$value['couponprice'] = '-' . $value['couponprice'];
				}

				$value['expresssn'] = $value['expresssn'] . ' ';
				$value['createtime'] = date('Y-m-d H:i:s', $value['createtime']);
				$value['paytime'] = !empty($value['paytime']) ? date('Y-m-d H:i:s', $value['paytime']) : '';
				$value['sendtime'] = !empty($value['sendtime']) ? date('Y-m-d H:i:s', $value['sendtime']) : '';
				$value['finishtime'] = !empty($value['finishtime']) ? date('Y-m-d H:i:s', $value['finishtime']) : '';
				$value['salerinfo'] = '';
				$value['storeinfo'] = '';

				if (!empty($value['verifyopenid'])) {
					$value['salerinfo'] = '[' . $value['salerid'] . ']' . $value['salername'] . '(' . $value['salernickname'] . ')';
				}

				if (!empty($value['verifystoreid'])) {
					$value['storeinfo'] = pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_merch_store') . ' where id=:storeid limit 1 ', array(':storeid' => $value['verifystoreid']));
				}

				if ($plugin_diyform && !empty($value['diyformfields']) && !empty($value['diyformdata'])) {
					$diyformdata_array = p('diyform')->getDatas(iunserializer($value['diyformfields']), iunserializer($value['diyformdata']));
					$diyformdata = '';

					foreach ($diyformdata_array as $da) {
						$diyformdata .= $da['name'] . ': ' . $da['value'] . '
';
					}

					$value['order_diyformdata'] = $diyformdata;
				}
			}

			unset($value);
			$exportlist = array();

			if ($this->field_index($columns, 'goods_title') != -1) {
				$i = 0;

				while ($i < $goodscount) {
					$exportlist['row' . $i] = array();
					++$i;
				}

				$rowindex = 0;

				foreach ($list as $index => $r) {
					$exportlist['row' . $rowindex] = $r;
					$goodsindex = $rowindex;

					foreach ($r['goods'] as $g) {
						$exportlist['row' . $goodsindex]['goods_title'] = $g['title'];
						$exportlist['row' . $goodsindex]['goods_goodssn'] = $g['goodssn'];
						$exportlist['row' . $goodsindex]['goods_optiontitle'] = $g['optiontitle'];
						$exportlist['row' . $goodsindex]['goods_total'] = $g['total'];
						$exportlist['row' . $goodsindex]['goods_price1'] = $g['price'] / $g['total'];
						$exportlist['row' . $goodsindex]['goods_price2'] = $g['realprice'] / $g['total'];
						$exportlist['row' . $goodsindex]['goods_rprice1'] = $g['price'];
						$exportlist['row' . $goodsindex]['goods_rprice2'] = $g['realprice'];
						$exportlist['row' . $goodsindex]['goods_diyformdata'] = $g['goods_diyformdata'];
						++$goodsindex;
					}

					$nextindex = 0;
					$i = 0;

					while ($i <= $index) {
						$nextindex += $list[$i]['goodscount'];
						++$i;
					}

					$rowindex = $nextindex;
				}
			}
			else {
				foreach ($list as $r) {
					$exportlist[] = $r;
				}
			}

			m('excel')->export($exportlist, array('title' => '订单数据-' . date('Y-m-d-H-i', time()), 'columns' => $columns));
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		$stores = pdo_fetchall('select id,storename from ' . tablename('ewei_shop_merch_store') . ' where uniacid=:uniacid and merchid = :merchid', array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
		include $this->template();
	}

	public function save()
	{
		global $_W;
		global $_GPC;
		$columns = $_GPC['columns'];

		if (!is_array($columns)) {
			exit();
		}

		$data = array();
		$tempname = trim($_GPC['tempname']);

		if (!empty($tempname)) {
			$data['ordertemplates'][$tempname] = $columns;
		}

		$data['ordercolumns'] = $columns;
		$this->model->updateSet(array('shop' => $data));

		if (!empty($tempname)) {
			exit(json_encode(array('templates' => array_keys($data['ordertemplates']), 'tempname' => $tempname)));
		}

		exit(json_encode(array()));
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$sets = $this->model->getSet();
		$shop_set = $sets['shop'];
		$data = array('ordertemplates' => $shop_set['shop']['ordertemplates']);
		$tempname = trim($_GPC['tempname']);

		if (!empty($tempname)) {
			unset($data['ordertemplates'][$tempname]);
		}

		$this->model->updateSet(array('shop' => $data));
		exit(json_encode(array('templates' => array_keys($data['ordertemplates']))));
	}

	public function gettemplate()
	{
		global $_W;
		global $_GPC;
		$sets = $this->model->getSet();
		$shop_set = $sets['shop'];
		$tempname = trim($_GPC['tempname']);
		$default_columns = $this->defaultColumns();

		if (empty($tempname)) {
			$columns = array();
		}
		else {
			$columns = $shop_set['ordertemplates'][$tempname];
		}

		if (!is_array($columns)) {
			$columns = array();
		}

		$others = array();

		foreach ($default_columns as $dc) {
			$hascolumn = false;

			foreach ($columns as $c) {
				if ($dc['field'] == $c['field']) {
					$hascolumn = true;
					break;
				}
			}

			if (!$hascolumn) {
				$others[] = $dc;
			}
		}

		exit(json_encode(array('columns' => $columns, 'others' => $others)));
	}

	public function reset()
	{
		global $_W;
		global $_GPC;
		$data['ordercolumns'] = array();
		$this->model->updateSet(array('shop' => $data));
		show_json(1);
	}
}

?>
