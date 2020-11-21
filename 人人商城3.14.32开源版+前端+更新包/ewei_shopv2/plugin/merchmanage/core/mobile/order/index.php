<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}


require EWEI_SHOPV2_PLUGIN . 'merchmanage/core/inc/page_merchmanage.php';
class Index_EweiShopV2Page extends MerchmanageMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$status = intval($_GPC['status']);
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$p = p('commission');
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$merchid = $_W['merchmanage']['merchid'];
		if ($item['merchid'] != $merchid) {
			$this->message('抱歉，订单不存在!', mobileUrl('merchmanage/order'), 'error');
		}
		$item['statusvalue'] = $item['status'];
		$item['paytypevalue'] = $item['paytype'];
		$order_goods = array();

		if (0 < $item['sendtype']) {
			$order_goods = pdo_fetchall('SELECT orderid,goodsid,sendtype,expresssn,expresscom,express,sendtime FROM ' . tablename('ewei_shop_order_goods') . "\r\n" . '            WHERE orderid = ' . $id . ' and sendtime > 0 and uniacid=' . $_W['uniacid'] . ' and sendtype > 0 group by sendtype order by sendtime desc ');

			foreach ($order_goods as $key => $value ) {
				$order_goods[$key]['goods'] = pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid and og.sendtype=' . $value['sendtype'] . ' ', array(':uniacid' => $_W['uniacid'], ':orderid' => $id));
			}

			$item['sendtime'] = $order_goods[0]['sendtime'];
		}


		$shopset = m('common')->getSysset('shop');

		if (empty($item)) {
			$this->message('抱歉，订单不存在!', referer(), 'error');
		}


		if ($_W['ispost']) {
			pdo_update('ewei_shop_order', array('remark' => trim($_GPC['remark'])), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			plog('order.op.remarksaler', '订单保存备注  ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn']);
			$this->message('订单备注保存成功！', webUrl('order', array('op' => 'detail', 'id' => $item['id'])), 'success');
		}


		$member = m('member')->getMember($item['openid']);
		$dispatch = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_dispatch') . ' WHERE id = :id and uniacid=:uniacid and merchid=0', array(':id' => $item['dispatchid'], ':uniacid' => $_W['uniacid']));

		if (empty($item['addressid'])) {
			$user = unserialize($item['carrier']);
		}
		 else {
			$user = iunserializer($item['address']);

			if (!(is_array($user))) {
				$user = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['addressid'], ':uniacid' => $_W['uniacid']));
			}


			$address_info = $user['address'];
			$user['address'] = $user['province'] . ' ' . $user['city'] . ' ' . $user['area'] . ' ' . $user['street'] . ' ' . $user['address'];
			$item['addressdata'] = array('realname' => $user['realname'], 'mobile' => $user['mobile'], 'address' => $user['address']);
		}

		$refund = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order_refund') . ' WHERE orderid = :orderid and uniacid=:uniacid order by id desc', array(':orderid' => $item['id'], ':uniacid' => $_W['uniacid']));
		$diyformfields = '';

		if (p('diyform')) {
			$diyformfields = ',o.diyformfields,o.diyformdata';
		}


		$goods = pdo_fetchall('SELECT g.*, o.goodssn as option_goodssn, o.productsn as option_productsn,o.total,g.type,o.optionname,o.optionid,o.price as orderprice,o.realprice,o.changeprice,o.oldprice,o.commission1,o.commission2,o.commission3,o.commissions,o.seckill,o.seckill_taskid,o.seckill_roomid' . $diyformfields . ' FROM ' . tablename('ewei_shop_order_goods') . ' o left join ' . tablename('ewei_shop_goods') . ' g on o.goodsid=g.id ' . ' WHERE o.orderid=:orderid and o.uniacid=:uniacid', array(':orderid' => $id, ':uniacid' => $_W['uniacid']));
		$is_merch = false;

		foreach ($goods as &$r ) {
			$r['seckill_task'] = false;

			if ($r['seckill']) {
				$r['seckill_task'] = plugin_run('seckill::getTaskInfo', $r['seckill_taskid']);
				$r['seckill_room'] = plugin_run('seckill::getRoomInfo', $r['seckill_taskid'], $r['seckill_roomid']);
			}


			if (!(empty($r['option_goodssn']))) {
				$r['goodssn'] = $r['option_goodssn'];
			}


			if (!(empty($r['option_productsn']))) {
				$r['productsn'] = $r['option_productsn'];
			}


			$r['marketprice'] = $r['orderprice'] / $r['total'];

			if (p('diyform')) {
				$r['diyformfields'] = iunserializer($r['diyformfields']);
				$r['diyformdata'] = iunserializer($r['diyformdata']);
			}


			if (!(empty($r['merchid']))) {
				$is_merch = true;
			}

		}

		unset($r);
		$item['goods'] = $goods;
		$agents = array();

		if ($p) {
			$agents = $p->getAgents($id);
			$m1 = ((isset($agents[0]) ? $agents[0] : false));
			$m2 = ((isset($agents[1]) ? $agents[1] : false));
			$m3 = ((isset($agents[2]) ? $agents[2] : false));
			$commission1 = 0;
			$commission2 = 0;
			$commission3 = 0;

			foreach ($goods as &$og ) {
				$oc1 = 0;
				$oc2 = 0;
				$oc3 = 0;
				$commissions = iunserializer($og['commissions']);

				if (!(empty($m1))) {
					if (is_array($commissions)) {
						$oc1 = ((isset($commissions['level1']) ? floatval($commissions['level1']) : 0));
					}
					 else {
						$c1 = iunserializer($og['commission1']);
						$l1 = $p->getLevel($m1['openid']);
						$oc1 = ((isset($c1['level' . $l1['id']]) ? $c1['level' . $l1['id']] : $c1['default']));
					}

					$og['oc1'] = $oc1;
					$commission1 += $oc1;
				}


				if (!(empty($m2))) {
					if (is_array($commissions)) {
						$oc2 = ((isset($commissions['level2']) ? floatval($commissions['level2']) : 0));
					}
					 else {
						$c2 = iunserializer($og['commission2']);
						$l2 = $p->getLevel($m2['openid']);
						$oc2 = ((isset($c2['level' . $l2['id']]) ? $c2['level' . $l2['id']] : $c2['default']));
					}

					$og['oc2'] = $oc2;
					$commission2 += $oc2;
				}


				if (!(empty($m3))) {
					if (is_array($commissions)) {
						$oc3 = ((isset($commissions['level3']) ? floatval($commissions['level3']) : 0));
					}
					 else {
						$c3 = iunserializer($og['commission3']);
						$l3 = $p->getLevel($m3['openid']);
						$oc3 = ((isset($c3['level' . $l3['id']]) ? $c3['level' . $l3['id']] : $c3['default']));
					}

					$og['oc3'] = $oc3;
					$commission3 += $oc3;
				}

			}

			unset($og);
			$commission_array = array($commission1, $commission2, $commission3);

			foreach ($agents as $key => $value ) {
				$agents[$key]['commission'] = $commission_array[$key];

				if (2 < $key) {
					unset($agents[$key]);
				}

			}
		}


		$condition = ' o.uniacid=:uniacid and o.deleted=0';
		$paras = array(':uniacid' => $_W['uniacid']);
		$totals = array();
		$coupon = false;
		if (com('coupon') && !(empty($item['couponid']))) {
			$coupon = com('coupon')->getCouponByDataID($item['couponid']);
		}


		$order_fields = false;
		$order_data = false;

		if (p('diyform')) {
			$diyform_set = p('diyform')->getSet();

			foreach ($goods as $g ) {
				if (!(empty($g['diyformdata']))) {
					break;
				}
			}

			if (!(empty($item['diyformid']))) {
				$orderdiyformid = $item['diyformid'];

				if (!(empty($orderdiyformid))) {
					$order_fields = iunserializer($item['diyformfields']);
					$order_data = iunserializer($item['diyformdata']);
				}

			}

		}


		if (com('verify')) {
			$verifyinfo = iunserializer($item['verifyinfo']);

			if (!(empty($item['verifyopenid']))) {
				$saler = m('member')->getMember($item['verifyopenid']);
				$saler['salername'] = pdo_fetchcolumn('select salername from ' . tablename('ewei_shop_saler') . ' where openid=:openid and uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid'], ':openid' => $item['verifyopenid']));
			}


			if (!(empty($item['verifystoreid']))) {
				$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:storeid limit 1 ', array(':storeid' => $item['verifystoreid']));
			}


			if ($item['isverify']) {
				if (is_array($verifyinfo)) {
					if (empty($item['dispatchtype'])) {
						foreach ($verifyinfo as &$v ) {
							if ($v['verified'] || ($item['verifytype'] == 1)) {
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


		include $this->template();
	}

	public function getlist()
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchmanage']['merchid'];
		$status = intval($_GPC['status']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
			$this->updateChildOrderPay();
		}
		 else {
			$is_openmerch = 0;
		}

		$ccard_plugin = p('ccard');
		$sendtype = ((!(isset($_GPC['sendtype'])) ? 0 : $_GPC['sendtype']));
		$condition = ' o.uniacid = :uniacid and o.deleted=0 and o.isparent=0 and o.merchid ="'.$merchid.'"';
		$uniacid = $_W['uniacid'];
		$paras = $paras1 = array(':uniacid' => $uniacid);
		$merch_data = m('common')->getPluginset('merch');
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}


		$searchtime = trim($_GPC['searchtime']);

		if (!(empty($searchtime)) && is_array($_GPC['time']) && in_array($searchtime, array('create', 'pay', 'send', 'finish'))) {
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


		if (!(empty($_GPC['searchfield'])) && !(empty($_GPC['keyword']))) {
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
				$sqlcondition = ' inner join ( select  og.orderid from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and (locate(:keyword,g.title)>0)) gs on gs.orderid=o.id';
			}
			 else if ($searchfield == 'goodssn') {
				$sqlcondition = ' inner join ( select og.orderid from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and (((locate(:keyword,g.goodssn)>0)) or (locate(:keyword,og.goodssn)>0))) gs on gs.orderid=o.id';
			}
			 else if ($searchfield == 'goodsoptiontitle') {
				$sqlcondition = ' inner join ( select  og.orderid from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and (locate(:keyword,og.optionname)>0)) gs on gs.orderid=o.id';
			}
			 else if ($searchfield == 'merch') {
				if ($merch_plugin) {
					$condition .= ' AND (locate(:keyword,merch.merchname)>0)';
					$sqlcondition = ' left join ' . tablename('ewei_shop_merch_user') . ' merch on merch.id = o.merchid and merch.uniacid=o.uniacid';
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

		if (!(empty($agentid)) && (0 < $level)) {
			$agent = $p->getInfo($agentid, array());

			if (!(empty($agent))) {
				$agentLevel = $p->getLevel($agentid);
			}


			if (empty($olevel)) {
				if (1 <= $level) {
					$condition .= ' and  ( o.agentid=' . intval($_GPC['agentid']);
				}


				if ((2 <= $level) && (0 < $agent['level2'])) {
					$condition .= ' or o.agentid in( ' . implode(',', array_keys($agent['level1_agentids'])) . ')';
				}


				if ((3 <= $level) && (0 < $agent['level3'])) {
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
			 else if ($olevel == 3) {
				if (0 < $agent['level3']) {
					$condition .= ' and o.agentid in( ' . implode(',', array_keys($agent['level2_agentids'])) . ')';
				}
				 else {
					$condition .= ' and o.agentid in( 0 )';
				}
			}

		}


		$authorid = intval($_GPC['authorid']);
		$author = p('author');
		if ($author && !(empty($authorid))) {
			$condition .= ' and o.authorid = :authorid';
			$paras[':authorid'] = $authorid;
		}


		if (($condition != ' o.uniacid = :uniacid and and o.deleted=0 and o.isparent=0') || !(empty($sqlcondition))) {
			$sql = 'select o.* , a.realname as arealname,a.mobile as amobile,a.province as aprovince ,a.city as acity , a.area as aarea,a.address as aaddress,' . "\r\n" . '                  d.dispatchname,m.nickname,m.id as mid,m.realname as mrealname,m.mobile as mmobile,sm.id as salerid,sm.nickname as salernickname,s.salername,' . "\r\n" . '                  r.rtype,r.status as rstatus,o.sendtype from ' . tablename('ewei_shop_order') . ' o' . ' left join ' . tablename('ewei_shop_order_refund') . ' r on r.id =o.refundid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid and m.uniacid =  o.uniacid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id=o.addressid ' . ' left join ' . tablename('ewei_shop_dispatch') . ' d on d.id = o.dispatchid ' . ' left join ' . tablename('ewei_shop_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' left join ' . tablename('ewei_shop_member') . ' sm on sm.openid = s.openid and sm.uniacid=s.uniacid' . ' ' . $sqlcondition . ' where ' . $condition . ' ' . $statuscondition . ' GROUP BY o.id ORDER BY o.createtime DESC  ';

			if (empty($_GPC['export'])) {
				$sql .= 'LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
			}


			$list = pdo_fetchall($sql, $paras);
		}
		 else {
			$status_condition = str_replace('o.', '', $statuscondition);
			$sql = 'select * from ' . tablename('ewei_shop_order') . ' where uniacid = :uniacid and deleted=0 and isparent=0 ' . $status_condition . ' GROUP BY id ORDER BY createtime DESC  ';

			if (empty($_GPC['export'])) {
				$sql .= 'LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
			}


			$list = pdo_fetchall($sql, $paras);

			if (!(empty($list))) {
				$refundid = '';
				$openid = '';
				$addressid = '';
				$dispatchid = '';
				$verifyopenid = '';

				foreach ($list as $key => $value ) {
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
				$refundid_array = pdo_fetchall('SELECT id,rtype,status as rstatus FROM ' . tablename('ewei_shop_order_refund') . ' WHERE id IN (' . $refundid . ')', array(), 'id');
				$openid_array = pdo_fetchall('SELECT openid,nickname,id as mid,realname as mrealname,mobile as mmobile FROM ' . tablename('ewei_shop_member') . ' WHERE openid IN (' . $openid . ') AND uniacid=' . $_W['uniacid'], array(), 'openid');
				$addressid_array = pdo_fetchall('SELECT id,realname as arealname,mobile as amobile,province as aprovince ,city as acity , area as aarea,address as aaddress FROM ' . tablename('ewei_shop_member_address') . ' WHERE id IN (' . $addressid . ')', array(), 'id');
				$dispatchid_array = pdo_fetchall('SELECT id,dispatchname FROM ' . tablename('ewei_shop_dispatch') . ' WHERE id IN (' . $dispatchid . ')', array(), 'id');
				$verifyopenid_array = pdo_fetchall('SELECT sm.id as salerid,sm.nickname as salernickname,sm.openid,s.salername FROM ' . tablename('ewei_shop_saler') . ' s LEFT JOIN ' . tablename('ewei_shop_member') . ' sm ON sm.openid = s.openid and sm.uniacid=s.uniacid WHERE s.openid IN (' . $verifyopenid . ')', array(), 'openid');

				foreach ($list as $key => &$value ) {
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

			if (!(empty($merch_user))) {
				$is_merchname = 1;
			}

		}


		if (!(empty($list))) {
			$diy_title_data = array();
			$diy_data = array();

			foreach ($list as &$value ) {
				$value['createtime'] = date('Y/m/d H:i:s', $value['createtime']);

				if ($is_merchname == 1) {
					$value['merchname'] = (($merch_user[$value['merchid']]['merchname'] ? $merch_user[$value['merchid']]['merchname'] : ''));
				}


				$s = $value['status'];
				$pt = $value['paytype'];
				$value['statusvalue'] = $s;
				$value['statuscss'] = $orderstatus[$value['status']]['css'];
				$value['status'] = $orderstatus[$value['status']]['name'];

				if (($pt == 3) && empty($value['statusvalue'])) {
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
						if (!(empty($value['ccard']))) {
							$value['status'] = '待充值';
						}
						 else {
							$value['status'] = '待取货';
						}
					}
					 else if (0 < $value['sendtype']) {
						$value['status'] = '部分发货';
					}

				}


				if ($s == -1) {
					if (!(empty($value['refundtime']))) {
						$value['status'] = '已退款';
					}

				}


				$value['paytypevalue'] = $pt;
				$value['css'] = $paytype[$pt]['css'];
				$value['paytype'] = $paytype[$pt]['name'];
				$value['dispatchname'] = ((empty($value['addressid']) ? '自提' : $value['dispatchname']));

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
				 else if (!(empty($value['virtual']))) {
					$value['dispatchname'] = '虚拟物品(卡密)<br/>自动发货';
				}


				if (($value['dispatchtype'] == 1) || !(empty($value['isverify'])) || !(empty($value['virtual'])) || !(empty($value['isvirtual']))) {
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
					$value['realname'] = (($isarray ? $address['realname'] : $value['arealname']));
					$value['mobile'] = (($isarray ? $address['mobile'] : $value['amobile']));
					$value['province'] = (($isarray ? $address['province'] : $value['aprovince']));
					$value['city'] = (($isarray ? $address['city'] : $value['acity']));
					$value['area'] = (($isarray ? $address['area'] : $value['aarea']));
					$value['address'] = (($isarray ? $address['address'] : $value['aaddress']));
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

				if (!(empty($level)) && empty($agentid)) {
					if (!(empty($value['agentid']))) {
						$m1 = m('member')->getMember($value['agentid']);
						$commission1 = 0;

						if (!(empty($m1['agentid'])) && (1 < $level)) {
							$m2 = m('member')->getMember($m1['agentid']);
							$commission2 = 0;

							if (!(empty($m2['agentid'])) && (2 < $level)) {
								$m3 = m('member')->getMember($m2['agentid']);
								$commission3 = 0;
							}

						}

					}

				}


				if (!(empty($agentid))) {
					$magent = m('member')->getMember($agentid);
				}


				$order_goods = pdo_fetchall('select g.id,g.title,g.thumb,g.goodssn,og.goodssn as option_goodssn, g.productsn,og.productsn as option_productsn, og.total,' . "\r\n" . '                    og.price,og.optionname as optiontitle, og.realprice,og.changeprice,og.oldprice,og.commission1,og.commission2,og.commission3,og.commissions,og.diyformdata,' . "\r\n" . '                    og.diyformfields,op.specs,g.merchid,og.seckill,og.seckill_taskid,og.seckill_roomid,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' left join ' . tablename('ewei_shop_goods_option') . ' op on og.optionid = op.id ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $uniacid, ':orderid' => $value['id']));
				$order_goods = set_medias($order_goods, 'thumb');
				$goods = '';

				foreach ($order_goods as &$og ) {
					$og['seckill_task'] = false;
					$og['seckill_room'] = false;

					if ($og['seckill']) {
						$og['seckill_task'] = plugin_run('seckill::getTaskInfo', $og['seckill_taskid']);
						$og['seckill_room'] = plugin_run('seckill::getRoomInfo', $og['seckill_taskid'], $og['seckill_roomid']);
					}


					if (!(empty($og['specs']))) {
						$thumb = m('goods')->getSpecThumb($og['specs']);

						if (!(empty($thumb))) {
							$og['thumb'] = $thumb;
						}

					}


					if (!(empty($level)) && empty($agentid)) {
						$commissions = iunserializer($og['commissions']);

						if (!(empty($m1))) {
							if (is_array($commissions)) {
								$commission1 += ((isset($commissions['level1']) ? floatval($commissions['level1']) : 0));
							}
							 else {
								$c1 = iunserializer($og['commission1']);
								$l1 = $p->getLevel($m1['openid']);

								if (!(empty($c1))) {
									$commission1 += ((isset($c1['level' . $l1['id']]) ? $c1['level' . $l1['id']] : $c1['default']));
								}

							}
						}


						if (!(empty($m2))) {
							if (is_array($commissions)) {
								$commission2 += ((isset($commissions['level2']) ? floatval($commissions['level2']) : 0));
							}
							 else {
								$c2 = iunserializer($og['commission2']);
								$l2 = $p->getLevel($m2['openid']);

								if (!(empty($c2))) {
									$commission2 += ((isset($c2['level' . $l2['id']]) ? $c2['level' . $l2['id']] : $c2['default']));
								}

							}
						}


						if (!(empty($m3))) {
							if (is_array($commissions)) {
								$commission3 += ((isset($commissions['level3']) ? floatval($commissions['level3']) : 0));
							}
							 else {
								$c3 = iunserializer($og['commission3']);
								$l3 = $p->getLevel($m3['openid']);

								if (!(empty($c3))) {
									$commission3 += ((isset($c3['level' . $l3['id']]) ? $c3['level' . $l3['id']] : $c3['default']));
								}

							}
						}

					}


					$goods .= '' . $og['title'] . "\r\n";

					if (!(empty($og['optiontitle']))) {
						$goods .= ' 规格: ' . $og['optiontitle'];
					}


					if (!(empty($og['option_goodssn']))) {
						$og['goodssn'] = $og['option_goodssn'];
					}


					if (!(empty($og['option_productsn']))) {
						$og['productsn'] = $og['option_productsn'];
					}


					if (!(empty($og['goodssn']))) {
						$goods .= ' 商品编号: ' . $og['goodssn'];
					}


					if (!(empty($og['productsn']))) {
						$goods .= ' 商品条码: ' . $og['productsn'];
					}


					$goods .= ' 单价: ' . ($og['price'] / $og['total']) . ' 折扣后: ' . ($og['realprice'] / $og['total']) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['price'] . ' 折扣后: ' . $og['realprice'] . "\r\n" . ' ';
					if (p('diyform') && !(empty($og['diyformfields'])) && !(empty($og['diyformdata']))) {
						$diyformdata_array = p('diyform')->getDatas(iunserializer($og['diyformfields']), iunserializer($og['diyformdata']), 1);
						$diyformdata = '';
						$dflag = 1;

						foreach ($diyformdata_array as $da ) {
							if (!(empty($diy_title_data))) {
								if (array_key_exists($da['key'], $diy_title_data)) {
									$dflag = 0;
								}

							}


							if ($dflag == 1) {
								$diy_title_data[$da['key']] = $da['name'];
							}


							$og['goods_' . $da['key']] = $da['value'];
							$diyformdata .= $da['name'] . ': ' . $da['value'] . ' ' . "\r\n";
						}

						$og['goods_diyformdata'] = $diyformdata;
					}

				}

				unset($og);

				if (!(empty($level)) && empty($agentid)) {
					$value['commission1'] = $commission1;
					$value['commission2'] = $commission2;
					$value['commission3'] = $commission3;
				}


				$value['goods'] = set_medias($order_goods, 'thumb');
				$value['goods_str'] = $goods;

				if (!(empty($agentid)) && (0 < $level)) {
					$commission_level = 0;

					if ($value['agentid'] == $agentid) {
						$value['level'] = 1;
						$level1_commissions = pdo_fetchall('select commission1,commissions  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join  ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' where og.orderid=:orderid and o.agentid= ' . $agentid . '  and o.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $uniacid));

						foreach ($level1_commissions as $c ) {
							$commission = iunserializer($c['commission1']);
							$commissions = iunserializer($c['commissions']);

							if (empty($commissions)) {
								$commission_level += ((isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default']));
							}
							 else {
								$commission_level += ((isset($commissions['level1']) ? floatval($commissions['level1']) : 0));
							}
						}
					}
					 else if (in_array($value['agentid'], array_keys($agent['level1_agentids']))) {
						$value['level'] = 2;

						if (0 < $agent['level2']) {
							$level2_commissions = pdo_fetchall('select commission2,commissions  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join  ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' where og.orderid=:orderid and  o.agentid in ( ' . implode(',', array_keys($agent['level1_agentids'])) . ')  and o.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $uniacid));

							foreach ($level2_commissions as $c ) {
								$commission = iunserializer($c['commission2']);
								$commissions = iunserializer($c['commissions']);

								if (empty($commissions)) {
									$commission_level += ((isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default']));
								}
								 else {
									$commission_level += ((isset($commissions['level2']) ? floatval($commissions['level2']) : 0));
								}
							}
						}

					}
					 else if (in_array($value['agentid'], array_keys($agent['level2_agentids']))) {
						$value['level'] = 3;

						if (0 < $agent['level3']) {
							$level3_commissions = pdo_fetchall('select commission3,commissions from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join  ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' where og.orderid=:orderid and  o.agentid in ( ' . implode(',', array_keys($agent['level2_agentids'])) . ')  and o.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $uniacid));

							foreach ($level3_commissions as $c ) {
								$commission = iunserializer($c['commission3']);
								$commissions = iunserializer($c['commissions']);

								if (empty($commissions)) {
									$commission_level += ((isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default']));
								}
								 else {
									$commission_level += ((isset($commissions['level3']) ? floatval($commissions['level3']) : 0));
								}
							}
						}

					}


					$value['commission'] = $commission_level;
				}


				if ($ccard_plugin && !(empty($value['ccardid']))) {
					$ccard_data = $ccard_plugin->getOne($value['ccardid']);
					$value['ccard_data'] = $ccard_data;
				}


				$value['goodscount'] = count($order_goods);
			}
		}


		unset($value);
		if (($condition != ' o.uniacid = :uniacid and and o.deleted=0 and o.isparent=0') || !(empty($sqlcondition))) {
			$t = pdo_fetch('SELECT COUNT(*) as count, ifnull(sum(o.price),0) as sumprice   FROM ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_order_refund') . ' r on r.id =o.refundid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('ewei_shop_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('ewei_shop_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' left join ' . tablename('ewei_shop_member') . ' sm on sm.openid = s.openid and sm.uniacid=s.uniacid' . ' ' . $sqlcondition . ' WHERE ' . $condition . ' ' . $statuscondition, $paras);
		}
		 else {
			$t = pdo_fetch('SELECT COUNT(*) as count, ifnull(sum(price),0) as sumprice   FROM ' . tablename('ewei_shop_order') . ' WHERE uniacid = :uniacid and deleted=0 and isparent=0 ' . $status_condition, $paras);
		}

		$total = $t['count'];
		$totalmoney = $t['sumprice'];
		$stores = pdo_fetchall('select id,storename from ' . tablename('ewei_shop_store') . ' where uniacid=:uniacid ', array(':uniacid' => $uniacid));
		$r_type = array('退款', '退货退款', '换货');
		show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));
	}

	public function updateChildOrderPay()
	{
		global $_W;
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$sql = 'select id,parentid from ' . tablename('ewei_shop_order') . ' where parentid>0 and status>0 and paytype=0 and uniacid=:uniacid';
		$list = pdo_fetchall($sql, $params);

		if (!(empty($list))) {
			foreach ($list as $k => $v ) {
				$params[':orderid'] = $v['parentid'];
				$sql1 = 'select paytype from ' . tablename('ewei_shop_order') . ' where id=:orderid and status>0 and paytype>0 and uniacid=:uniacid';
				$item = pdo_fetch($sql1, $params);

				if (0 < $item['paytype']) {
					pdo_update('ewei_shop_order', array('paytype' => $item['paytype']), array('id' => $v['id']));
				}

			}
		}

	}

	protected function getOrder($id)
	{
		global $_W;

		if (empty($id)) {
			show_json(0, '参数错误');
		}


		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($item)) {
			show_json(0, '未找到订单');
		}


		return $item;
	}

	public function express()
	{
		global $_W;
		global $_GPC;
		$express = trim($_GPC['express']);
		$expresssn = trim($_GPC['expresssn']);
		$list = m('util')->getExpressList($express, $expresssn);
		include $this->template();
	}
}


?>