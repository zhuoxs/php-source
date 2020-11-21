<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'app/core/page_auth_mobile.php';
class Order_EweiShopV2Page extends AppMobileAuthPage
{
	public function main()
	{
		return app_json(array(
			'perm' => array('order0' => cv('order.list.status0'), 'order1' => cv('order.list.status1'), 'order2' => cv('order.list.status2'), 'order3' => cv('order.list.status3'), 'order_1' => cv('order.list.status_1'), 'order4' => cv('order.list.status4'), 'order5' => cv('order.list.status5'), 'refund' => cv('order.op.refund'))
		));
	}

	/**
     * 获取订单列表
     */
	public function get_list()
	{
		global $_W;
		global $_GPC;

		if (!cv('order')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$status = intval($_GPC['status']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		$sendtype = !isset($_GPC['sendtype']) ? 0 : $_GPC['sendtype'];
		$condition = ' o.uniacid = :uniacid and o.deleted=0 and o.isparent=0';
		$uniacid = $_W['uniacid'];
		$paras = $paras1 = array(':uniacid' => $uniacid);
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		$searchtime = trim($_GPC['searchtime']);
		if (!empty($searchtime) && is_array($_GPC['time']) && in_array($searchtime, array('create', 'pay', 'send', 'finish'))) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND o.' . $searchtime . 'time >= :starttime AND o.' . $searchtime . 'time <= :endtime ';
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

		if (!empty($_GPC['searchfield']) && !empty($_GPC['keyword'])) {
			$searchfield = trim(strtolower($_GPC['searchfield']));
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$paras[':keyword'] = htmlspecialchars_decode($_GPC['keyword'], ENT_QUOTES);
			$sqlcondition = '';

			if ($searchfield == 'ordersn') {
				$condition .= ' AND locate(:keyword,o.ordersn)>0';
			}
			else if ($searchfield == 'member') {
				$condition .= ' AND (locate(:keyword,m.realname)>0 or locate(:keyword,m.mobile)>0 or locate(:keyword,m.nickname)>0)';
			}
			else if ($searchfield == 'address') {
				$condition .= ' AND ( locate(:keyword,a.realname)>0 or locate(:keyword,a.mobile)>0 or locate(:keyword,o.carrier)>0)';
			}
			else if ($searchfield == 'location') {
				$condition .= ' AND ( locate(:keyword,a.province)>0 or locate(:keyword,a.city)>0 or locate(:keyword,a.area)>0 or locate(:keyword,a.address)>0)';
			}
			else if ($searchfield == 'expresssn') {
				$condition .= ' AND locate(:keyword,o.expresssn)>0';
			}
			else if ($searchfield == 'saler') {
				$condition .= ' AND (locate(:keyword,sm.realname)>0 or locate(:keyword,sm.mobile)>0 or locate(:keyword,sm.nickname)>0 or locate(:keyword,s.salername)>0 )';
			}
			else if ($searchfield == 'store') {
				$condition .= ' AND (locate(:keyword,store.storename)>0)';
				$sqlcondition = ' left join ' . tablename('ewei_shop_store') . ' store on store.id = o.verifystoreid and store.uniacid=o.uniacid';
			}
			else if ($searchfield == 'goodstitle') {
				$sqlcondition = ' inner join ( select  og.orderid from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . (' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and (locate(:keyword,g.title)>0)) gs on gs.orderid=o.id');
			}
			else if ($searchfield == 'goodssn') {
				$sqlcondition = ' inner join ( select og.orderid from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . (' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and (((locate(:keyword,g.goodssn)>0)) or (locate(:keyword,og.goodssn)>0))) gs on gs.orderid=o.id');
			}
			else if ($searchfield == 'goodsoptiontitle') {
				$sqlcondition = ' inner join ( select  og.orderid from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . (' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and (locate(:keyword,og.optionname)>0)) gs on gs.orderid=o.id');
			}
			else {
				if ($searchfield == 'merch') {
					if ($merch_plugin) {
						$condition .= ' AND (locate(:keyword,merch.merchname)>0)';
						$sqlcondition = ' left join ' . tablename('ewei_shop_merch_user') . ' merch on merch.id = o.merchid and merch.uniacid=o.uniacid';
					}
				}
			}
		}

		$statuscondition = '';

		if ($status !== '') {
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
			else if ($status == '2') {
				$statuscondition = ' AND ( o.status = 2 or (o.status=1 and o.sendtype>0) )';
			}
			else {
				$statuscondition = ' AND o.status = ' . intval($status);
			}
		}

		$agentid = intval($_GPC['agentid']);
		$p = p('commission');
		$level = 0;

		if ($p) {
			$cset = $p->getSet();
			$level = intval($cset['level']);
		}

		$olevel = intval($_GPC['olevel']);
		if (!empty($agentid) && 0 < $level) {
			$agent = $p->getInfo($agentid, array());

			if (!empty($agent)) {
				$agentLevel = $p->getLevel($agentid);
			}

			if (empty($olevel)) {
				if (1 <= $level) {
					$condition .= ' and  ( o.agentid=' . intval($_GPC['agentid']);
				}

				if (2 <= $level && 0 < $agent['level2']) {
					$condition .= ' or o.agentid in( ' . implode(',', array_keys($agent['level1_agentids'])) . ')';
				}

				if (3 <= $level && 0 < $agent['level3']) {
					$condition .= ' or o.agentid in( ' . implode(',', array_keys($agent['level2_agentids'])) . ')';
				}

				if (1 <= $level) {
					$condition .= ')';
				}
			}
			else if ($olevel == 1) {
				$condition .= ' and  o.agentid=' . intval($_GPC['agentid']);
			}
			else if ($olevel == 2) {
				if (0 < $agent['level2']) {
					$condition .= ' and o.agentid in( ' . implode(',', array_keys($agent['level1_agentids'])) . ')';
				}
				else {
					$condition .= ' and o.agentid in( 0 )';
				}
			}
			else {
				if ($olevel == 3) {
					if (0 < $agent['level3']) {
						$condition .= ' and o.agentid in( ' . implode(',', array_keys($agent['level2_agentids'])) . ')';
					}
					else {
						$condition .= ' and o.agentid in( 0 )';
					}
				}
			}
		}

		if ($condition != ' o.uniacid = :uniacid and o.deleted=0 and o.isparent=0' || !empty($sqlcondition)) {
			$sql = 'select o.* , a.realname as arealname,a.mobile as amobile,a.province as aprovince ,a.city as acity , a.area as aarea,a.address as aaddress,
                  d.dispatchname,m.nickname,m.id as mid,m.realname as mrealname,m.mobile as mmobile,sm.id as salerid,sm.nickname as salernickname,s.salername,
                  r.rtype,r.status as rstatus,o.sendtype from ' . tablename('ewei_shop_order') . ' o' . ' left join ' . tablename('ewei_shop_order_refund') . ' r on r.id =o.refundid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid and m.uniacid =  o.uniacid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id=o.addressid ' . ' left join ' . tablename('ewei_shop_dispatch') . ' d on d.id = o.dispatchid ' . ' left join ' . tablename('ewei_shop_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' left join ' . tablename('ewei_shop_member') . ' sm on sm.openid = s.openid and sm.uniacid=s.uniacid' . (' ' . $sqlcondition . ' where ' . $condition . ' ' . $statuscondition . ' GROUP BY o.id ORDER BY o.createtime DESC  ');

			if (empty($_GPC['export'])) {
				$sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			}

			$list = pdo_fetchall($sql, $paras);
		}
		else {
			$status_condition = str_replace('o.', '', $statuscondition);
			$sql = 'select * from ' . tablename('ewei_shop_order') . (' where uniacid = :uniacid and deleted=0 and isparent=0 ' . $status_condition . ' GROUP BY id ORDER BY createtime DESC  ');

			if (empty($_GPC['export'])) {
				$sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			}

			$list = pdo_fetchall($sql, $paras);

			if (!empty($list)) {
				$refundid = '';
				$openid = '';
				$addressid = '';
				$dispatchid = '';
				$verifyopenid = '';

				foreach ($list as $key => $value) {
					$refundid .= ',\'' . $value['refundid'] . '\'';
					$openid .= ',\'' . $value['openid'] . '\'';
					$addressid .= ',\'' . $value['addressid'] . '\'';
					$dispatchid .= ',\'' . $value['dispatchid'] . '\'';
					$verifyopenid .= ',\'' . $value['verifyopenid'] . '\'';
				}

				$refundid = ltrim($refundid, ',');
				$openid = ltrim($openid, ',');
				$addressid = ltrim($addressid, ',');
				$dispatchid = ltrim($dispatchid, ',');
				$verifyopenid = ltrim($verifyopenid, ',');
				$refundid_array = pdo_fetchall('SELECT id,rtype,status as rstatus FROM ' . tablename('ewei_shop_order_refund') . (' WHERE id IN (' . $refundid . ')'), array(), 'id');
				$openid_array = pdo_fetchall('SELECT openid,nickname,id as mid,realname as mrealname,mobile as mmobile FROM ' . tablename('ewei_shop_member') . (' WHERE openid IN (' . $openid . ') AND uniacid=' . $_W['uniacid']), array(), 'openid');
				$addressid_array = pdo_fetchall('SELECT id,realname as arealname,mobile as amobile,province as aprovince ,city as acity , area as aarea,address as aaddress FROM ' . tablename('ewei_shop_member_address') . (' WHERE id IN (' . $addressid . ')'), array(), 'id');
				$dispatchid_array = pdo_fetchall('SELECT id,dispatchname FROM ' . tablename('ewei_shop_dispatch') . (' WHERE id IN (' . $dispatchid . ')'), array(), 'id');
				$verifyopenid_array = pdo_fetchall('SELECT sm.id as salerid,sm.nickname as salernickname,sm.openid,s.salername FROM ' . tablename('ewei_shop_saler') . ' s LEFT JOIN ' . tablename('ewei_shop_member') . (' sm ON sm.openid = s.openid and sm.uniacid=s.uniacid WHERE s.openid IN (' . $verifyopenid . ')'), array(), 'openid');

				foreach ($list as $key => &$value) {
					$list[$key]['rtype'] = $refundid_array[$value['refundid']]['rtype'];
					$list[$key]['rstatus'] = $refundid_array[$value['refundid']]['rstatus'];
					$list[$key]['nickname'] = $openid_array[$value['openid']]['nickname'];
					$list[$key]['mid'] = $openid_array[$value['openid']]['mid'];
					$list[$key]['mrealname'] = $openid_array[$value['openid']]['mrealname'];
					$list[$key]['mmobile'] = $openid_array[$value['openid']]['mmobile'];
					$list[$key]['arealname'] = $addressid_array[$value['addressid']]['arealname'];
					$list[$key]['amobile'] = $addressid_array[$value['addressid']]['amobile'];
					$list[$key]['aprovince'] = $addressid_array[$value['addressid']]['aprovince'];
					$list[$key]['acity'] = $addressid_array[$value['addressid']]['acity'];
					$list[$key]['aarea'] = $addressid_array[$value['addressid']]['aarea'];
					$list[$key]['aaddress'] = $addressid_array[$value['addressid']]['aaddress'];
					$list[$key]['dispatchname'] = $dispatchid_array[$value['dispatchid']]['dispatchname'];
					$list[$key]['salerid'] = $verifyopenid_array[$value['verifyopenid']]['salerid'];
					$list[$key]['salernickname'] = $verifyopenid_array[$value['verifyopenid']]['salernickname'];
					$list[$key]['salername'] = $verifyopenid_array[$value['verifyopenid']]['salername'];
				}

				unset($value);
			}
		}

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
		$is_merch = array();
		$is_merchname = 0;

		if ($merch_plugin) {
			$merch_user = $merch_plugin->getListUser($list, 'merch_user');

			if (!empty($merch_user)) {
				$is_merchname = 1;
			}
		}

		if (!empty($list)) {
			$diy_title_data = array();
			$diy_data = array();

			foreach ($list as &$value) {
				$value['createtime'] = date('Y/m/d H:i:s', $value['createtime']);

				if ($is_merchname == 1) {
					$value['merchname'] = $merch_user[$value['merchid']]['merchname'] ? $merch_user[$value['merchid']]['merchname'] : '';
				}

				$s = $value['status'];
				$pt = $value['paytype'];
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

						if (0 < $value['sendtype']) {
							$value['status'] = '部分使用';
						}
					}
					else if (empty($value['addressid'])) {
						if (!empty($value['ccard'])) {
							$value['status'] = '待充值';
						}
						else {
							$value['status'] = '待取货';
						}
					}
					else {
						if (0 < $value['sendtype']) {
							$value['status'] = '部分发货';
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

				if ($pt == 3) {
					$value['dispatchname'] = '货到付款';
				}
				else if ($value['isverify'] == 1) {
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
					$value['address_province'] = $value['province'];
					$value['address_city'] = $value['city'];
					$value['address_area'] = $value['area'];
					$value['address_address'] = $value['address'];
					$value['address'] = $value['province'] . ' ' . $value['city'] . ' ' . $value['area'] . ' ' . $value['address'];
					$value['addressdata'] = array('realname' => $value['realname'], 'mobile' => $value['mobile'], 'address' => $value['address']);
				}

				$commission1 = -1;
				$commission2 = -1;
				$commission3 = -1;
				$m1 = false;
				$m2 = false;
				$m3 = false;
				if (!empty($level) && empty($agentid)) {
					if (!empty($value['agentid'])) {
						$m1 = m('member')->getMember($value['agentid']);
						$commission1 = 0;
						if (!empty($m1['agentid']) && 1 < $level) {
							$m2 = m('member')->getMember($m1['agentid']);
							$commission2 = 0;
							if (!empty($m2['agentid']) && 2 < $level) {
								$m3 = m('member')->getMember($m2['agentid']);
								$commission3 = 0;
							}
						}
					}
				}

				if (!empty($agentid)) {
					$magent = m('member')->getMember($agentid);
				}

				$order_goods = pdo_fetchall('select g.id,g.title,g.thumb,g.goodssn,og.goodssn as option_goodssn, g.productsn,og.productsn as option_productsn, og.total,
                    og.price,og.optionname as optiontitle, og.realprice,og.changeprice,og.oldprice,og.commission1,og.commission2,og.commission3,og.commissions,og.diyformdata,
                    og.diyformfields,op.specs,g.merchid,og.seckill,og.seckill_taskid,og.seckill_roomid,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' left join ' . tablename('ewei_shop_goods_option') . ' op on og.optionid = op.id ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $uniacid, ':orderid' => $value['id']));
				$order_goods = set_medias($order_goods, 'thumb');
				$goods = '';

				foreach ($order_goods as &$og) {
					$og['seckill_task'] = false;
					$og['seckill_room'] = false;

					if ($og['seckill']) {
						$og['seckill_task'] = plugin_run('seckill::getTaskInfo', $og['seckill_taskid']);
						$og['seckill_room'] = plugin_run('seckill::getRoomInfo', $og['seckill_taskid'], $og['seckill_roomid']);
					}

					if (!empty($og['specs'])) {
						$thumb = m('goods')->getSpecThumb($og['specs']);

						if (!empty($thumb)) {
							$og['thumb'] = $thumb;
						}
					}

					if (!empty($level) && empty($agentid)) {
						$commissions = iunserializer($og['commissions']);

						if (!empty($m1)) {
							if (is_array($commissions)) {
								$commission1 += isset($commissions['level1']) ? floatval($commissions['level1']) : 0;
							}
							else {
								$c1 = iunserializer($og['commission1']);
								$l1 = $p->getLevel($m1['openid']);

								if (!empty($c1)) {
									$commission1 += isset($c1['level' . $l1['id']]) ? $c1['level' . $l1['id']] : $c1['default'];
								}
							}
						}

						if (!empty($m2)) {
							if (is_array($commissions)) {
								$commission2 += isset($commissions['level2']) ? floatval($commissions['level2']) : 0;
							}
							else {
								$c2 = iunserializer($og['commission2']);
								$l2 = $p->getLevel($m2['openid']);

								if (!empty($c2)) {
									$commission2 += isset($c2['level' . $l2['id']]) ? $c2['level' . $l2['id']] : $c2['default'];
								}
							}
						}

						if (!empty($m3)) {
							if (is_array($commissions)) {
								$commission3 += isset($commissions['level3']) ? floatval($commissions['level3']) : 0;
							}
							else {
								$c3 = iunserializer($og['commission3']);
								$l3 = $p->getLevel($m3['openid']);

								if (!empty($c3)) {
									$commission3 += isset($c3['level' . $l3['id']]) ? $c3['level' . $l3['id']] : $c3['default'];
								}
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
					if (p('diyform') && !empty($og['diyformfields']) && !empty($og['diyformdata'])) {
						$diyformdata_array = p('diyform')->getDatas(iunserializer($og['diyformfields']), iunserializer($og['diyformdata']), 1);
						$diyformdata = '';
						$dflag = 1;

						foreach ($diyformdata_array as $da) {
							if (!empty($diy_title_data)) {
								if (array_key_exists($da['key'], $diy_title_data)) {
									$dflag = 0;
								}
							}

							if ($dflag == 1) {
								$diy_title_data[$da['key']] = $da['name'];
							}

							$og['goods_' . $da['key']] = $da['value'];
							$diyformdata .= $da['name'] . ': ' . $da['value'] . ' 
';
						}

						$og['goods_diyformdata'] = $diyformdata;
					}
				}

				unset($og);
				if (!empty($level) && empty($agentid)) {
					$value['commission1'] = $commission1;
					$value['commission2'] = $commission2;
					$value['commission3'] = $commission3;
				}

				$value['goods'] = set_medias($order_goods, 'thumb');
				$value['goods_str'] = $goods;
				if (!empty($agentid) && 0 < $level) {
					$commission_level = 0;

					if ($value['agentid'] == $agentid) {
						$value['level'] = 1;
						$level1_commissions = pdo_fetchall('select commission1,commissions  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join  ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' where og.orderid=:orderid and o.agentid= ' . $agentid . '  and o.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $uniacid));

						foreach ($level1_commissions as $c) {
							$commission = iunserializer($c['commission1']);
							$commissions = iunserializer($c['commissions']);

							if (empty($commissions)) {
								$commission_level += isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default'];
							}
							else {
								$commission_level += isset($commissions['level1']) ? floatval($commissions['level1']) : 0;
							}
						}
					}
					else if (in_array($value['agentid'], array_keys($agent['level1_agentids']))) {
						$value['level'] = 2;

						if (0 < $agent['level2']) {
							$level2_commissions = pdo_fetchall('select commission2,commissions  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join  ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' where og.orderid=:orderid and  o.agentid in ( ' . implode(',', array_keys($agent['level1_agentids'])) . ')  and o.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $uniacid));

							foreach ($level2_commissions as $c) {
								$commission = iunserializer($c['commission2']);
								$commissions = iunserializer($c['commissions']);

								if (empty($commissions)) {
									$commission_level += isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default'];
								}
								else {
									$commission_level += isset($commissions['level2']) ? floatval($commissions['level2']) : 0;
								}
							}
						}
					}
					else {
						if (in_array($value['agentid'], array_keys($agent['level2_agentids']))) {
							$value['level'] = 3;

							if (0 < $agent['level3']) {
								$level3_commissions = pdo_fetchall('select commission3,commissions from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join  ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' where og.orderid=:orderid and  o.agentid in ( ' . implode(',', array_keys($agent['level2_agentids'])) . ')  and o.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $uniacid));

								foreach ($level3_commissions as $c) {
									$commission = iunserializer($c['commission3']);
									$commissions = iunserializer($c['commissions']);

									if (empty($commissions)) {
										$commission_level += isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default'];
									}
									else {
										$commission_level += isset($commissions['level3']) ? floatval($commissions['level3']) : 0;
									}
								}
							}
						}
					}

					$value['commission'] = $commission_level;
				}

				$value['goodscount'] = count($order_goods);
			}
		}

		unset($value);
		if ($condition != ' o.uniacid = :uniacid and and o.deleted=0 and o.isparent=0' || !empty($sqlcondition)) {
			$t = pdo_fetch('SELECT COUNT(*) as count, ifnull(sum(o.price),0) as sumprice   FROM ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_order_refund') . ' r on r.id =o.refundid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('ewei_shop_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('ewei_shop_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' left join ' . tablename('ewei_shop_member') . ' sm on sm.openid = s.openid and sm.uniacid=s.uniacid' . (' ' . $sqlcondition . ' WHERE ' . $condition . ' ' . $statuscondition), $paras);
		}
		else {
			$t = pdo_fetch('SELECT COUNT(*) as count, ifnull(sum(price),0) as sumprice   FROM ' . tablename('ewei_shop_order') . (' WHERE uniacid = :uniacid and deleted=0 and isparent=0 ' . $status_condition), $paras);
		}

		$total = $t['count'];
		return app_json(array(
			'list'     => $list,
			'total'    => $total,
			'pagesize' => $psize,
			'perm'     => array('order_pay' => cv('order.op.pay'), 'order_send' => cv('order.op.send'), 'order_verify' => cv('order.op.verify'), 'order_fetch' => cv('order.op.fetch'), 'order_finish' => cv('order.op.finish'), 'order_sendcancel' => cv('order.op.sendcancel'), 'order_remarksaler' => cv('order.op.remarksaler'))
		));
	}

	/**
     * 获取订单详情
     */
	public function get_detail()
	{
		global $_W;
		global $_GPC;

		if (!cv('order.detail')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$id = intval($_GPC['id']);

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($item)) {
			return app_error(AppError::$OrderNotFound);
		}

		$item['statusvalue'] = $item['status'];
		$order_goods = array();

		if (0 < $item['sendtype']) {
			$order_goods = pdo_fetchall('SELECT orderid,goodsid,sendtype,expresssn,expresscom,express,sendtime FROM ' . tablename('ewei_shop_order_goods') . '
            WHERE orderid = ' . $id . ' and sendtime > 0 and uniacid=' . $_W['uniacid'] . ' and sendtype > 0 group by sendtype ');

			foreach ($order_goods as $key => $value) {
				$order_goods[$key]['goods'] = pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid and og.sendtype=' . $value['sendtype'] . ' ', array(':uniacid' => $_W['uniacid'], ':orderid' => $id));

				if (!empty($value['sendtime'])) {
					$order_goods[$key]['sendtime'] = date('Y-m-d H:i:s', $value['sendtime']);
				}
			}

			$item['sendtime'] = $order_goods[0]['sendtime'];
		}

		$dispatch = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_dispatch') . ' WHERE id = :id and uniacid=:uniacid and merchid=0', array(':id' => $item['dispatchid'], ':uniacid' => $_W['uniacid']));

		if (empty($item['addressid'])) {
			$user_address = unserialize($item['carrier']);
		}
		else {
			$user_address = iunserializer($item['address']);

			if (!is_array($user_address)) {
				$user_address = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['addressid'], ':uniacid' => $_W['uniacid']));
			}

			$user_address['address'] = $user_address['province'] . ' ' . $user_address['city'] . ' ' . $user_address['area'] . ' ' . $user_address['street'] . ' ' . $user_address['address'];
		}

		$diyformfields = '';

		if (p('diyform')) {
			$diyformfields = ',o.diyformfields,o.diyformdata';
		}

		$goods = pdo_fetchall('SELECT g.title,g.id,g.thumb,g.marketprice, o.goodssn as option_goodssn, o.productsn as option_productsn,o.total,g.type,o.optionname,o.optionid,o.price as orderprice,o.realprice,o.changeprice,o.oldprice,o.commission1,o.commission2,o.commission3,o.commissions,o.seckill,o.seckill_taskid,o.seckill_roomid' . $diyformfields . ' FROM ' . tablename('ewei_shop_order_goods') . ' o left join ' . tablename('ewei_shop_goods') . ' g on o.goodsid=g.id ' . ' WHERE o.orderid=:orderid and o.uniacid=:uniacid', array(':orderid' => $id, ':uniacid' => $_W['uniacid']));

		foreach ($goods as &$r) {
			$r['seckill_task'] = false;

			if ($r['seckill']) {
				$r['seckill_task'] = plugin_run('seckill::getTaskInfo', $r['seckill_taskid']);
				$r['seckill_room'] = plugin_run('seckill::getRoomInfo', $r['seckill_taskid'], $r['seckill_roomid']);
			}

			if (!empty($r['option_goodssn'])) {
				$r['goodssn'] = $r['option_goodssn'];
			}

			if (!empty($r['option_productsn'])) {
				$r['productsn'] = $r['option_productsn'];
			}

			$r['marketprice'] = $r['orderprice'] / $r['total'];

			if (p('diyform')) {
				$r['diyformfields'] = iunserializer($r['diyformfields']);
				$r['diyformdata'] = iunserializer($r['diyformdata']);
			}
		}

		unset($r);
		$goods = set_medias($goods, 'thumb');
		$item['goods'] = $goods;
		$pcom = p('commission');
		$agents = array();

		if ($pcom) {
			$agents = $pcom->getAgents($id);
			$m1 = isset($agents[0]) ? $agents[0] : false;
			$m2 = isset($agents[1]) ? $agents[1] : false;
			$m3 = isset($agents[2]) ? $agents[2] : false;
			$commission1 = 0;
			$commission2 = 0;
			$commission3 = 0;

			foreach ($goods as &$og) {
				$oc1 = 0;
				$oc2 = 0;
				$oc3 = 0;
				$commissions = iunserializer($og['commissions']);

				if (!empty($m1)) {
					if (is_array($commissions)) {
						$oc1 = isset($commissions['level1']) ? floatval($commissions['level1']) : 0;
					}
					else {
						$c1 = iunserializer($og['commission1']);
						$l1 = $pcom->getLevel($m1['openid']);
						$oc1 = isset($c1['level' . $l1['id']]) ? $c1['level' . $l1['id']] : $c1['default'];
					}

					$og['oc1'] = $oc1;
					$commission1 += $oc1;
				}

				if (!empty($m2)) {
					if (is_array($commissions)) {
						$oc2 = isset($commissions['level2']) ? floatval($commissions['level2']) : 0;
					}
					else {
						$c2 = iunserializer($og['commission2']);
						$l2 = $pcom->getLevel($m2['openid']);
						$oc2 = isset($c2['level' . $l2['id']]) ? $c2['level' . $l2['id']] : $c2['default'];
					}

					$og['oc2'] = $oc2;
					$commission2 += $oc2;
				}

				if (!empty($m3)) {
					if (is_array($commissions)) {
						$oc3 = isset($commissions['level3']) ? floatval($commissions['level3']) : 0;
					}
					else {
						$c3 = iunserializer($og['commission3']);
						$l3 = $pcom->getLevel($m3['openid']);
						$oc3 = isset($c3['level' . $l3['id']]) ? $c3['level' . $l3['id']] : $c3['default'];
					}

					$og['oc3'] = $oc3;
					$commission3 += $oc3;
				}
			}

			unset($og);
			$commission_array = array($commission1, $commission2, $commission3);

			foreach ($agents as $key => $value) {
				$agents[$key]['commission'] = $commission_array[$key];

				if (2 < $key) {
					unset($agents[$key]);
				}
			}
		}

		$coupon = false;
		if (com('coupon') && !empty($item['couponid'])) {
			$coupon = com('coupon')->getCouponByDataID($item['couponid']);
		}

		$order_fields = false;
		$order_data = false;

		if (p('diyform')) {
			$diyform_set = p('diyform')->getSet();

			foreach ($goods as $g) {
				if (!empty($g['diyformdata'])) {
					break;
				}
			}

			if (!empty($item['diyformid'])) {
				$orderdiyformid = $item['diyformid'];

				if (!empty($orderdiyformid)) {
					$order_fields = iunserializer($item['diyformfields']);
					$order_data = iunserializer($item['diyformdata']);
				}
			}
		}

		$verifyinfo = false;

		if (com('verify')) {
			$verifyinfo = iunserializer($item['verifyinfo']);

			if (!empty($item['verifyopenid'])) {
				$saler = m('member')->getMember($item['verifyopenid']);
				$saler['salername'] = pdo_fetchcolumn('select salername from ' . tablename('ewei_shop_saler') . ' where openid=:openid and uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid'], ':openid' => $item['verifyopenid']));
			}

			if (!empty($item['verifystoreid'])) {
				$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:storeid limit 1 ', array(':storeid' => $item['verifystoreid']));
			}

			if ($item['isverify']) {
				if (is_array($verifyinfo)) {
					if (empty($item['dispatchtype'])) {
						foreach ($verifyinfo as &$v) {
							if ($v['verified'] || $item['verifytype'] == 1) {
								$v['storename'] = pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_store') . ' where id=:id limit 1', array(':id' => $v['verifystoreid']));

								if (empty($v['storename'])) {
									$v['storename'] = '总店';
								}

								$v['nickname'] = pdo_fetchcolumn('select nickname from ' . tablename('ewei_shop_member') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':openid' => $v['verifyopenid'], ':uniacid' => $_W['uniacid']));
								$v['salername'] = pdo_fetchcolumn('select salername from ' . tablename('ewei_shop_saler') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':openid' => $v['verifyopenid'], ':uniacid' => $_W['uniacid']));
							}
						}

						unset($v);
					}
				}
			}
		}

		$member = m('member')->getMember($item['openid']);
		unset($item['transid']);
		unset($item['carrier']);
		unset($item['iscomment']);
		unset($item['creditadd']);
		$item['sendtime'] = empty($item['sendtime']) ? 0 : date('Y-m-d H:i:s', $item['sendtime']);
		$item['paytime'] = empty($item['paytime']) ? 0 : date('Y-m-d H:i:s', $item['paytime']);
		$item['createtime'] = empty($item['createtime']) ? 0 : date('Y-m-d H:i:s', $item['createtime']);
		return app_json(array(
			'detail'       => $item,
			'member'       => array('id' => $member['id'], 'nickname' => $member['nickname'], 'realname' => $member['realname'], 'avatar' => tomedia($member['avatar']), 'mobile' => $member['mobile'], 'weixin' => $member['weixin']),
			'dispatch'     => $dispatch,
			'user_address' => $user_address,
			'agents'       => $agents,
			'coupon'       => $coupon,
			'order_fields' => $order_fields,
			'order_data'   => $order_data,
			'order_goods'  => $order_goods,
			'verifyinfo'   => $verifyinfo,
			'store'        => $store,
			'saler'        => $saler
		));
	}

	/**
     * 订单卖家备注
     */
	public function remarksaler()
	{
		global $_W;
		global $_GPC;

		if (!cv('order.op.remarksaler')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$orderid = intval($_GPC['id']);
		$item = $this->getOrder($orderid);

		if ($_W['ispost']) {
			$remarksaler = trim($_GPC['remarksaler']);
			pdo_update('ewei_shop_order', array('remarksaler' => $remarksaler), array('id' => $orderid, 'uniacid' => $_W['uniacid']));
			plog('order.op.remarksaler', '订单备注 ID: ' . $item['id'] . ' 订单编号: ' . $item['ordersn'] . ' 备注内容: ' . $remarksaler);
			return app_json();
		}

		return app_error(0, array('remarksaler' => $item['remarksaler']));
	}

	/**
     * 订单付款
     */
	public function payorder()
	{
		global $_W;
		global $_GPC;

		if (!$_W['ispost']) {
			return app_error(AppError::$RequestError);
		}

		if (!cv('order.op.pay')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$orderid = intval($_GPC['id']);
		$item = $this->getOrder($orderid);

		if (1 < $item['status']) {
			return app_error(AppError::$ParamsError, '订单已付款，不需重复付款');
		}

		if (!empty($item['virtual']) && com('virtual')) {
			com('virtual')->pay($item);
		}
		else {
			pdo_update('ewei_shop_order', array('status' => 1, 'paytype' => 11, 'paytime' => time()), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			m('order')->setStocksAndCredits($item['id'], 1);
			m('notice')->sendOrderMessage($item['id']);
			com_run('printer::sendOrderMessage', $item['id']);

			if (com('coupon')) {
				com('coupon')->sendcouponsbytask($item['id']);
			}

			if (com('coupon') && !empty($item['couponid'])) {
				com('coupon')->backConsumeCoupon($item['id']);
			}

			if (p('commission')) {
				p('commission')->checkOrderPay($item['id']);
			}
		}

		plog('order.op.pay', '订单确认付款 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn']);
		return app_json();
	}

	/**
     * 普通订单发货
     */
	public function send()
	{
		global $_W;
		global $_GPC;

		if (!cv('order.op.send')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$orderid = intval($_GPC['id']);
		$item = $this->getOrder($orderid);

		if (empty($item['addressid'])) {
			return app_error(AppError::$ParamsError, '无收货地址，无法发货');
		}

		if ($item['paytype'] != 3) {
			if ($item['status'] != 1) {
				return app_error(AppError::$ParamsError, '订单未付款，无法发货');
			}
		}

		if ($_W['ispost']) {
			if ($item['city_express_state'] == 0) {
				$expresssn = trim($_GPC['expresssn']);

				if (empty($expresssn)) {
					return app_error(AppError::$ParamsError, '请输入快递单号');
				}

				$express = trim($_GPC['express']);
				$expresscom = trim($_GPC['expresscom']);
				$time = time();
				$data = array('sendtype' => 0 < $item['sendtype'] ? $item['sendtype'] : intval($_GPC['sendtype']), 'express' => $express, 'expresscom' => $expresscom, 'expresssn' => $expresssn, 'sendtime' => $time);
				$sendtype = intval($_GPC['sendtype']);

				if (!empty($sendtype)) {
					$goodsids = $_GPC['sendgoodsids'];

					if (empty($goodsids)) {
						return app_error(AppError::$ParamsError, '请选择发货商品');
					}

					$ogoods = array();
					$ogoods = pdo_fetchall('select sendtype from ' . tablename('ewei_shop_order_goods') . '
                    where orderid = ' . $item['id'] . ' and uniacid = ' . $_W['uniacid'] . ' order by sendtype desc ');
					$senddata = array('sendtype' => $ogoods[0]['sendtype'] + 1, 'sendtime' => $data['sendtime']);
					$data['sendtype'] = $ogoods[0]['sendtype'] + 1;
					$goodsid = trim($_GPC['sendgoodsid']);

					if (!is_array($goodsids)) {
						$goodsids = explode(',', $goodsids);
					}

					if ($goodsids) {
						foreach ($goodsids as $key => $value) {
							pdo_update('ewei_shop_order_goods', $data, array('orderid' => $item['id'], 'goodsid' => $value, 'uniacid' => $_W['uniacid']));
						}
					}

					$send_goods = pdo_fetch('select * from ' . tablename('ewei_shop_order_goods') . '
                    where orderid = ' . $item['id'] . ' and sendtype = 0 and uniacid = ' . $_W['uniacid'] . ' limit 1 ');

					if (empty($send_goods)) {
						$senddata['status'] = 2;
					}

					pdo_update('ewei_shop_order', $senddata, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				}
				else {
					$data['status'] = 2;
					pdo_update('ewei_shop_order', $data, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				}
			}
			else {
				$cityexpress = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_city_express') . ' WHERE uniacid=:uniacid AND merchid=:merchid', array(':uniacid' => $_W['uniacid'], ':merchid' => 0));

				if ($cityexpress['express_type'] == 1) {
					$dada = m('order')->dada_send($item);

					if ($dada['state'] == 0) {
						show_json(0, $dada['result']);
					}
					else {
						$data['status'] = 2;
						$data['refundid'] = 0;
						$data['sendtime'] = time();
						pdo_update('ewei_shop_order', $data, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
					}
				}
				else {
					$data['status'] = 2;
					$data['refundid'] = 0;
					$data['sendtime'] = time();
					pdo_update('ewei_shop_order', $data, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				}
			}

			if (!empty($item['refundid'])) {
				$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $item['refundid']));

				if (!empty($refund)) {
					pdo_update('ewei_shop_order_refund', array('status' => -1, 'endtime' => $time), array('id' => $item['refundid']));
					pdo_update('ewei_shop_order', array('refundstate' => 0), array('id' => $item['id']));
				}
			}

			if ($item['paytype'] == 3) {
				m('order')->setStocksAndCredits($item['id'], 1);
			}

			m('notice')->sendOrderMessage($item['id']);
			plog('order.op.send', '订单发货 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' <br/>快递公司: ' . $_GPC['expresscom'] . ' 快递单号: ' . $_GPC['expresssn']);
			return app_json(1);
		}

		$noshipped = array();
		$shipped = array();

		if (0 < $item['sendtype']) {
			$noshipped = pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell,og.optionname,og.total from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.sendtype = 0 and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
			$i = 1;

			while ($i <= $item['sendtype']) {
				$row = array('sendtype' => $i, 'goods' => pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell,og.optionname,og.total from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.sendtype = ' . $i . ' and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id'])));
				$row['goods'] = set_medias($row['goods'], 'thumb');
				$shipped[] = $row;
				++$i;
			}
		}

		$order_goods = pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell,og.optionname,og.total from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
		$order_goods = set_medias($order_goods, 'thumb');
		$address = iunserializer($item['address']);

		if (!is_array($address)) {
			$address = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['addressid'], ':uniacid' => $_W['uniacid']));
		}

		$express_list = m('express')->getExpressList();
		return app_json(array('address' => $address, 'express_list' => $express_list, 'order_goods' => $order_goods, 'noshipped' => set_medias($noshipped, 'thumb'), 'shipped' => $shipped));
	}

	/**
     * 取消发货
     */
	public function sendcancel()
	{
		global $_W;
		global $_GPC;

		if (!cv('order.op.sendcancel')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$orderid = intval($_GPC['id']);
		$item = $this->getOrder($orderid);
		if ($item['status'] != 2 && $item['sendtype'] == 0) {
			return app_error(AppError::$ParamsError, '订单未发货，无法取消');
		}

		$sendtype = trim($_GPC['sendtype']);

		if ($_W['ispost']) {
			$remark = trim($_GPC['remark']);

			if (!empty($item['remarksend'])) {
				$remark = $item['remarksend'] . '
' . $remark;
			}

			$data = array('sendtime' => 0, 'remarksend' => $remark);

			if (0 < $item['sendtype']) {
				if (empty($sendtype)) {
					if (empty($_GPC['bundles'])) {
						show_json(0, '请选择您要修改的包裹！');
					}

					$sendtype = $_GPC['bundles'];
				}

				if (!is_array($sendtype)) {
					$sendtype = explode(',', $sendtype);
				}

				if (is_array($sendtype)) {
					foreach ($sendtype as $key => $value) {
						$data['sendtype'] = 0;
						pdo_update('ewei_shop_order_goods', $data, array('orderid' => $item['id'], 'sendtype' => $value, 'uniacid' => $_W['uniacid']));
						$order = pdo_fetch('select sendtype from ' . tablename('ewei_shop_order') . ' where id = ' . $item['id'] . ' and uniacid = ' . $_W['uniacid'] . ' ');
						pdo_update('ewei_shop_order', array('sendtype' => $order['sendtype'] - 1, 'status' => 1), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
					}
				}
			}
			else {
				$data['status'] = 1;
				pdo_update('ewei_shop_order', $data, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			}

			if ($item['paytype'] == 3) {
				m('order')->setStocksAndCredits($item['id'], 2);
			}

			plog('order.op.sendcancel', '订单取消发货 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' 原因: ' . $remark);
			return app_json();
		}

		$sendgoods = array();
		$bundles = array();

		if (0 < $sendtype) {
			$sendgoods = pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell,og.optionname,og.total from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid and og.sendtype=' . $sendtype . ' ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
			$sendgoods = set_medias($sendgoods, 'thumb');
		}
		else {
			if (0 < $item['sendtype']) {
				$i = 1;

				while ($i <= intval($item['sendtype'])) {
					$bundles[$i]['goods'] = pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell,og.optionname,og.total from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid and og.sendtype=' . $i . ' ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
					$bundles[$i]['sendtype'] = $i;

					if (empty($bundles[$i]['goods'])) {
						unset($bundles[$i]);
					}

					++$i;
				}
			}
		}

		if (is_array($bundles) && !empty($bundles)) {
			foreach ($bundles as $bid => &$bundle) {
				$bundle['goods'] = set_medias($bundle['goods'], 'thumb');
			}
		}

		return app_json(array('sendgoods' => $sendgoods, 'bundles' => $bundles));
	}

	/**
     * 修改收货地址
     */
	public function changeaddress()
	{
		global $_W;
		global $_GPC;

		if (!cv('order.op.changeaddress')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$orderid = intval($_GPC['id']);
		$item = $this->getOrder($orderid);
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);

		if (empty($item['addressid'])) {
			$user = unserialize($item['carrier']);
		}
		else {
			$user = iunserializer($item['address']);

			if (!is_array($user)) {
				$user = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['addressid'], ':uniacid' => $_W['uniacid']));
			}

			$address_info = $user['address'];
			$user_address = $user['address'];
			$item['addressdata'] = $oldaddress = array('realname' => $user['realname'], 'mobile' => $user['mobile'], 'address' => $user['address'], 'order' => $item);
		}

		if ($_W['ispost']) {
			$realname = $_GPC['realname'];
			$mobile = $_GPC['mobile'];
			$province = $_GPC['province'];
			$city = $_GPC['city'];
			$area = $_GPC['area'];
			$street = $_GPC['street'];
			$changead = intval($_GPC['changead']);
			$address = trim($_GPC['address']);

			if (empty($realname)) {
				return app_error(AppError::$ParamsError, '请填写收件人姓名');
			}

			if (empty($mobile)) {
				return app_error(AppError::$ParamsError, '请填写收件人手机');
			}

			if ($changead) {
				if ($province == '请选择省份') {
					return app_error(AppError::$ParamsError, '请选择省份');
				}

				if (empty($address)) {
					return app_error(AppError::$ParamsError, '请填写详细地址');
				}
			}

			$address_array = iunserializer($item['address']);
			$address_array['realname'] = $realname;
			$address_array['mobile'] = $mobile;

			if ($changead) {
				$address_array['province'] = $province;
				$address_array['city'] = $city;
				$address_array['area'] = $area;
				$address_array['street'] = $street;
				$address_array['address'] = $address;
			}
			else {
				$address_array['province'] = $user['province'];
				$address_array['city'] = $user['city'];
				$address_array['area'] = $user['area'];
				$address_array['street'] = $user['street'];
				$address_array['address'] = $user_address;
			}

			$address_array = iserializer($address_array);
			pdo_update('ewei_shop_order', array('address' => $address_array), array('id' => $orderid, 'uniacid' => $_W['uniacid']));
			plog('order.op.changeaddress', '修改收货地址 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' <br>原地址: 收件人: ' . $oldaddress['realname'] . ' 手机号: ' . $oldaddress['mobile'] . ' 收件地址: ' . $oldaddress['address'] . '<br>新地址: 收件人: ' . $realname . ' 手机号: ' . $mobile . ' 收件地址: ' . $province . ' ' . $city . ' ' . $area . ' ' . $address);
			m('notice')->sendOrderChangeMessage($item['openid'], array('title' => '订单收货地址', 'orderid' => $item['id'], 'ordersn' => $item['ordersn'], 'olddata' => $oldaddress['address'], 'data' => $province . $city . $area . $address, 'type' => 0), 'orderstatus');
			return app_json();
		}

		return app_json(array('user_address' => $user, 'new_area' => $new_area, 'address_street' => $address_street));
	}

	/**
     * 修改物流
     */
	public function changeexpress()
	{
		global $_W;
		global $_GPC;

		if (!cv('order.op.changeexpress')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$orderid = intval($_GPC['id']);
		$item = $this->getOrder($orderid);
		$sendtype = intval($_GPC['sendtype']);

		if ($_W['ispost']) {
			$express = $_GPC['express'];
			$expresscom = $_GPC['expresscom'];
			$expresssn = trim($_GPC['expresssn']);

			if (empty($expresssn)) {
				return app_error(AppError::$ParamsError, '请填写快递单号');
			}

			$change_data = array();
			$change_data['express'] = $express;
			$change_data['expresscom'] = $expresscom;
			$change_data['expresssn'] = $expresssn;

			if (0 < $item['sendtype']) {
				if (empty($sendtype)) {
					if (empty($_GPC['bundles'])) {
						return app_error(AppError::$ParamsError, '请选择您要修改的包裹');
					}

					$sendtype = $_GPC['bundles'];
				}

				if (!is_array($sendtype)) {
					$sendtype = explode(',', $sendtype);
				}

				if (is_array($sendtype)) {
					foreach ($sendtype as $key => $value) {
						pdo_update('ewei_shop_order_goods', $change_data, array('orderid' => $orderid, 'sendtype' => $value, 'uniacid' => $_W['uniacid']));
					}
				}
			}
			else {
				pdo_update('ewei_shop_order', $change_data, array('id' => $orderid, 'uniacid' => $_W['uniacid']));
			}

			plog('order.op.changeexpress', '修改快递状态 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' 快递公司: ' . $expresscom . ' 快递单号: ' . $expresssn);
			return app_json();
		}

		$sendgoods = array();
		$bundles = array();

		if (0 < $sendtype) {
			$sendgoods = pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid and og.sendtype=' . $sendtype . ' ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
			$sendgoods = set_medias($sendgoods, 'thumb');
		}
		else {
			if (0 < $item['sendtype']) {
				$i = 1;

				while ($i <= intval($item['sendtype'])) {
					$bundle = array('goods' => pdo_fetchall('select g.id,g.title,og.optionname,og.total,g.thumb,og.sendtype,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid and og.sendtype=' . $i . ' ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id'])), 'sendtype' => $i);

					if (!empty($bundle['goods'])) {
						$bundle['goods'] = set_medias($bundle['goods'], 'thumb');
						$bundles[] = $bundle;
					}

					++$i;
				}
			}
		}

		$address = iunserializer($item['address']);

		if (!is_array($address)) {
			$address = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['addressid'], ':uniacid' => $_W['uniacid']));
		}

		$express_list = m('express')->getExpressList();
		return app_json(array('address' => $address, 'express_list' => $express_list, 'sendgoods' => $sendgoods, 'bundles' => $bundles, 'order' => $item));
	}

	/**
     * 普通订单收货
     */
	public function finish()
	{
		global $_W;
		global $_GPC;

		if (!cv('order.op.finish')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		if (!$_W['ispost']) {
			return app_error(AppError::$RequestError);
		}

		$orderid = intval($_GPC['id']);
		$item = $this->getOrder($orderid);
		pdo_update('ewei_shop_order', array('status' => 3, 'finishtime' => time()), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
		if (p('ccard') && !empty($item['ccardid'])) {
			p('ccard')->setBegin($item['id'], $item['ccardid']);
		}

		m('member')->upgradeLevel($item['openid'], $item['id']);
		m('order')->setGiveBalance($item['id'], 1);
		m('notice')->sendOrderMessage($item['id']);
		com_run('printer::sendOrderMessage', $item['id']);

		if (com('coupon')) {
			com('coupon')->sendcouponsbytask($item['id']);
		}

		if (!empty($item['couponid'])) {
			com('coupon')->backConsumeCoupon($item['id']);
		}

		if (p('lineup')) {
			p('lineup')->checkOrder($item);
		}

		if (p('commission')) {
			p('commission')->checkOrderFinish($item['id']);
		}

		if (p('lottery')) {
			$res = p('lottery')->getLottery($item['openid'], 1, array('money' => $item['price'], 'paytype' => 2));

			if ($res) {
				p('lottery')->getLotteryList($item['openid'], array('lottery_id' => $res));
			}
		}

		plog('order.op.finish', '订单完成 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn']);
		return app_json();
	}

	/**
     * 虚拟商品收货
     */
	public function fetch()
	{
		global $_W;
		global $_GPC;

		if (!cv('order.op.fetch')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		if (!$_W['ispost']) {
			app_error(AppError::$RequestError);
		}

		$orderid = intval($_GPC['id']);
		$item = $this->getOrder($orderid);

		if ($item['status'] != 1) {
			app_error(AppError::$ParamsError, '订单未付款');
		}

		$time = time();
		$d = array('status' => 3, 'sendtime' => $time, 'finishtime' => $time);

		if ($item['isverify'] == 1) {
			$d['verified'] = 1;
			$d['verifytime'] = $time;
			$d['verifyopenid'] = '';
		}

		pdo_update('ewei_shop_order', $d, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));

		if (com('coupon')) {
			com('coupon')->sendcouponsbytask($item['id']);
		}

		if (!empty($item['couponid'])) {
			com('coupon')->backConsumeCoupon($item['id']);
		}

		if (!empty($item['refundid'])) {
			$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $item['refundid']));

			if (!empty($refund)) {
				pdo_update('ewei_shop_order_refund', array('status' => -1), array('id' => $item['refundid']));
				pdo_update('ewei_shop_order', array('refundstate' => 0), array('id' => $item['id']));
			}
		}

		$log = '订单确认取货';
		if (p('ccard') && !empty($item['ccardid'])) {
			p('ccard')->setBegin($item['id'], $item['ccardid']);
			$log = '订单确认充值';
		}

		$log .= ' ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'];
		m('order')->setGiveBalance($item['id'], 1);
		m('member')->upgradeLevel($item['openid'], $item['id']);
		m('notice')->sendOrderMessage($item['id']);

		if (p('commission')) {
			p('commission')->checkOrderFinish($item['id']);
		}

		plog('order.op.fetch', $log);
		return app_json();
	}

	/**
     * 获取订单物流
     */
	public function express()
	{
		global $_GPC;
		$express = trim($_GPC['express']);
		$expresssn = trim($_GPC['expresssn']);
		$list = m('util')->getExpressList($express, $expresssn);
		return app_json(array('list' => $list));
	}

	/**
     * 公用获取订单
     * @param $id
     * @return bool
     */
	protected function getOrder($id)
	{
		global $_W;

		if (empty($id)) {
			app_error(AppError::$ParamsError);
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($item)) {
			app_error(AppError::$OrderNotFound);
		}

		return $item;
	}

	protected function opData()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($item)) {
			if ($_W['isajax']) {
				app_error(AppError::$OrderNotFound, '未找到订单!');
			}

			app_error(AppError::$OrderNotFound, '未找到订单!');
		}

		return array('id' => $id, 'item' => $item);
	}

	public function changeprice()
	{
		global $_W;
		global $_GPC;

		if (!cv('order.op.pay')) {
			app_error(AppError::$PermError, '您没有订单付款权限!');
		}

		$opdata = $this->opData();
		extract($opdata);
		$is_peerpay = false;
		$is_peerpay = m('order')->checkpeerpay($item['id']);

		if (!empty($is_peerpay)) {
			app_error(AppError::$ParamsError, '代付订单不能改价!');
		}

		if ($_W['ispost']) {
			$changegoodsprice = $_GPC['changegoodsprice'];

			if (!is_array($changegoodsprice)) {
				app_error(AppError::$ParamsError, '未找到改价内容!');
			}

			if (0 < $item['parentid']) {
				$parent_order = array();
				$parent_order['id'] = $item['parentid'];
			}

			$changeprice = 0;

			foreach ($changegoodsprice as $ogid => $change) {
				$changeprice += floatval($change);
			}

			$dispatchprice = floatval($_GPC['changedispatchprice']);

			if ($dispatchprice < 0) {
				$dispatchprice = 0;
			}

			$orderprice = $item['price'] + $changeprice;
			$changedispatchprice = 0;

			if ($dispatchprice != $item['dispatchprice']) {
				$changedispatchprice = $dispatchprice - $item['dispatchprice'];
				$orderprice += $changedispatchprice;
			}

			if ($orderprice < 0) {
				app_error(AppError::$ParamsError, '订单实际支付价格不能小于0元!');
			}

			foreach ($changegoodsprice as $ogid => $change) {
				$og = pdo_fetch('select price,realprice from ' . tablename('ewei_shop_order_goods') . ' where id=:ogid and uniacid=:uniacid limit 1', array(':ogid' => $ogid, ':uniacid' => $_W['uniacid']));

				if (!empty($og)) {
					$realprice = $og['realprice'] + $change;

					if ($realprice < 0) {
						app_error(AppError::$ParamsError, '单个商品不能优惠到负数!');
					}
				}
			}

			$ordersn2 = $item['ordersn2'] + 1;

			if (99 < $ordersn2) {
				app_error(AppError::$ParamsError, '超过改价次数限额!');
			}

			$orderupdate = array();

			if ($orderprice != $item['price']) {
				$orderupdate['price'] = $orderprice;
				$orderupdate['ordersn2'] = $item['ordersn2'] + 1;

				if (0 < $item['parentid']) {
					$parent_order['price_change'] = $orderprice - $item['price'];
				}
			}

			$orderupdate['changeprice'] = $item['changeprice'] + $changeprice;

			if ($dispatchprice != $item['dispatchprice']) {
				$orderupdate['dispatchprice'] = $dispatchprice;
				$orderupdate['changedispatchprice'] += $changedispatchprice;

				if (0 < $item['parentid']) {
					$parent_order['dispatch_change'] = $changedispatchprice;
				}
			}

			if (!empty($orderupdate)) {
				pdo_update('ewei_shop_order', $orderupdate, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			}

			if (0 < $item['parentid']) {
				if (!empty($parent_order)) {
					m('order')->changeParentOrderPrice($parent_order);
				}
			}

			foreach ($changegoodsprice as $ogid => $change) {
				$og = pdo_fetch('select price,realprice,changeprice from ' . tablename('ewei_shop_order_goods') . ' where id=:ogid and uniacid=:uniacid limit 1', array(':ogid' => $ogid, ':uniacid' => $_W['uniacid']));

				if (!empty($og)) {
					$realprice = $og['realprice'] + $change;
					$changeprice = $og['changeprice'] + $change;
					pdo_update('ewei_shop_order_goods', array('realprice' => $realprice, 'changeprice' => $changeprice), array('id' => $ogid));
				}
			}

			$pluginc = p('commission');

			if ($pluginc) {
				$pluginc->calculate($item['id'], true);
			}

			plog('order.op.changeprice', '订单号： ' . $item['ordersn'] . ' <br/> 价格： ' . $item['price'] . ' -> ' . $orderprice);
			m('notice')->sendOrderChangeMessage($item['openid'], array('title' => '订单金额', 'orderid' => $item['id'], 'ordersn' => $item['ordersn'], 'olddata' => $item['price'], 'data' => round($orderprice, 2), 'type' => 1), 'orderstatus');
			app_error(0);
		}

		$order_goods = pdo_fetchall('select og.id,g.title,g.thumb,g.goodssn,og.goodssn as option_goodssn, g.productsn,og.productsn as option_productsn, og.total,og.price,og.optionname as optiontitle, og.realprice,og.oldprice from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
		return app_json(array('list' => $order_goods, 'item' => $item));
	}
}

?>
