<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Refund_EweiShopV2Page extends PluginWebPage
{
	protected function opData()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$refundid = intval($_GPC['refundid']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($item)) {
			if ($_W['isajax']) {
				show_json(0, '未找到订单!');
			}

			$this->message('未找到订单!', '', 'error');
		}

		if (empty($refundid)) {
			$refundid = $item['refundid'];
		}

		if (!empty($refundid)) {
			$refund = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order_refund') . ' where id=:id limit 1', array(':id' => $refundid));
			$refund['images'] = iunserializer($refund['images']);
		}

		$r_type = array('退款', '退货退款', '换货');
		return array('id' => $id, 'item' => $item, 'refund' => $refund, 'r_type' => $r_type);
	}

	public function main()
	{
		global $_W;
		global $_GPC;

		try {
			$refund = true;
			$status = trim($_GPC['status']);
			$pindex = max(1, intval($_GPC['page']));
			$psize = 10;
			$condition = ' and ore.uniacid=:uniacid ';
			$params = array(':uniacid' => $_W['uniacid']);

			if ($status == 'apply') {
				$condition .= ' AND o.refundstate > 0 and o.refundid != 0 and ore.refundstatus >= 0 ';
			}

			if ($status == 'over') {
				$condition .= ' AND (o.refundtime != 0 or ore.refundstatus < 0) and ore.refundstatus<>-1';
			}

			if (empty($starttime) || empty($endtime)) {
				$starttime = strtotime('-1 month');
				$endtime = time();
			}

			$searchtime = trim($_GPC['searchtime']);

			if (!empty($searchtime)) {
				$condition .= ' and ore.' . $searchtime . 'time > ' . strtotime($_GPC['time']['start']) . ' and ore.' . $searchtime . 'time < ' . strtotime($_GPC['time']['end']) . ' ';
				$starttime = strtotime($_GPC['time']['start']);
				$endtime = strtotime($_GPC['time']['end']);
			}

			if (!empty($_GPC['paytype'])) {
				$_GPC['paytype'] = trim($_GPC['paytype']);
				$condition .= ' and o.pay_type = "' . $_GPC['paytype'] . '" ';
				$params[':paytype'] = $_GPC['paytype'];
			}

			if (!empty($_GPC['searchfield']) && !empty($_GPC['keyword'])) {
				$searchfield = trim(strtolower($_GPC['searchfield']));
				$_GPC['keyword'] = trim($_GPC['keyword']);
				$params[':keyword'] = $_GPC['keyword'];

				if ($searchfield == 'orderno') {
					$condition .= ' AND locate(:keyword,o.orderno)>0 ';
				}
				else if ($searchfield == 'refundno') {
					$condition .= ' AND locate(:keyword,ore.refundno)>0 ';
				}
				else if ($searchfield == 'member') {
					$condition .= ' AND (locate(:keyword,m.realname)>0 or locate(:keyword,m.mobile)>0 or locate(:keyword,m.nickname)>0)';
				}
				else if ($searchfield == 'address') {
					$condition .= ' AND ( locate(:keyword,a.realname)>0 or locate(:keyword,a.mobile)>0) ';
				}
				else if ($searchfield == 'expresssn') {
					$condition .= ' AND (locate(:keyword,ore.expresssn)>0 or locate(:keyword,ore.rexpresssn)>0) ';
				}
				else {
					if ($searchfield == 'goodstitle') {
						$condition .= ' AND g.title like "%' . $_GPC['keyword'] . '%" ';
					}
				}
			}

			if (empty($_GPC['export'])) {
				$page = 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			}

			$list = pdo_fetchall('SELECT o.addressid,o.goodid,og.option_name as optiontitle,o.pay_type,o.price,o.creditmoney,o.is_team,o.refundid,ore.*,g.title,g.thumb,g.category,g.groupsprice,g.singleprice,c.name,g.thumb,g.thumb_url' . "\n" . '                ,m.nickname,m.id as mid,m.realname as mrealname,m.mobile as mmobile,a.realname as arealname,a.mobile as amobile,a.province as aprovince ,a.city as acity,o.orderno' . "\n" . '                , a.area as aarea,a.address as aaddress,ore.refundstatus as status' . "\n" . '                FROM ' . tablename('ewei_shop_groups_order_refund') . ' as ore' . "\n" . '                left join ' . tablename('ewei_shop_groups_order') . ' as o on o.id = ore.orderid' . "\n\t\t\t\t" . 'left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid' . "\n\t\t\t\t" . 'left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid and m.uniacid =  o.uniacid' . "\n\t\t\t\t" . 'left join ' . tablename('ewei_shop_member_address') . ' a on a.id=ore.refundaddressid' . "\n\t\t\t\t" . 'left join ' . tablename('ewei_shop_groups_category') . ' as c on c.id = g.category' . "\n\t\t\t\t" . 'left join ' . tablename('ewei_shop_groups_order_goods') . ' as og on og.groups_order_id = o.id' . "\n\t\t\t\t" . 'WHERE 1 ' . $condition . '  ORDER BY ore.applytime DESC ' . $page, $params);

			foreach ($list as $key => $value) {
				if (!empty($value['address'])) {
					$user = unserialize($value['address']);
					$user['address'] = $user['province'] . ' ' . $user['city'] . ' ' . $user['area'] . ' ' . $user['address'];
					$list[$key]['addressdata'] = array('realname' => $user['realname'], 'mobile' => $user['mobile'], 'address' => $user['address']);
				}
				else {
					$user = iunserializer($value['addressid']);

					if (!is_array($user)) {
						$user = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $value['addressid'], ':uniacid' => $_W['uniacid']));
					}

					$user['address'] = $user['province'] . ' ' . $user['city'] . ' ' . $user['area'] . ' ' . $user['address'];
					$list[$key]['addressdata'] = array('realname' => $user['realname'], 'mobile' => $user['mobile'], 'address' => $user['address']);
				}
			}

			$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order_refund') . ' as ore
                left join ' . tablename('ewei_shop_groups_order') . ' as o on o.id = ore.orderid
				right join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
				right join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid and m.uniacid =  o.uniacid
				left join ' . tablename('ewei_shop_member_address') . ' a on a.id=ore.refundaddressid
				right join ' . tablename('ewei_shop_groups_category') . (' as c on c.id = g.category
				WHERE 1 ' . $condition . ' '), $params);
			$pager = pagination2($total, $pindex, $psize);
			$paytype = array('credit' => '余额支付', 'wechat' => '微信支付', 'other' => '其他支付');
			$paystatus = array(-2 => '取消', -1 => '拒绝', 0 => '申请', 1 => '完成', 3 => '通过', 4 => '客户填写退货快递单号', 5 => '店家填写换货快递单号');

			if ($_GPC['export'] == 1) {
				plog('groups.order.export', '导出订单');
				$columns = array(
					array('title' => '订单编号', 'field' => 'orderno', 'width' => 24),
					array('title' => '维权编号', 'field' => 'refundno', 'width' => 24),
					array('title' => '粉丝昵称', 'field' => 'nickname', 'width' => 12),
					array('title' => '会员姓名', 'field' => 'mrealname', 'width' => 12),
					array('title' => 'openid', 'field' => 'openid', 'width' => 30),
					array('title' => '会员手机手机号', 'field' => 'mmobile', 'width' => 15),
					array('title' => '退货人姓名', 'field' => 'arealname', 'width' => 15),
					array('title' => '联系电话', 'field' => 'amobile', 'width' => 12),
					array('title' => '退货地址', 'field' => 'aprovince', 'width' => 12),
					array('title' => '', 'field' => 'acity', 'width' => 12),
					array('title' => '', 'field' => 'aarea', 'width' => 12),
					array('title' => '', 'field' => 'aaddress', 'width' => 20),
					array('title' => '商品名称', 'field' => 'title', 'width' => 30),
					array('title' => '商品编码', 'field' => 'goodssn', 'width' => 15),
					array('title' => '团购价', 'field' => 'groupsprice', 'width' => 12),
					array('title' => '单购价', 'field' => 'singleprice', 'width' => 12),
					array('title' => '原价', 'field' => 'price', 'width' => 12),
					array('title' => '商品数量', 'field' => 'goods_total', 'width' => 15),
					array('title' => '商品小计', 'field' => 'goodsprice', 'width' => 12),
					array('title' => '退还积分', 'field' => 'applycredit', 'width' => 12),
					array('title' => '退款金额', 'field' => 'applyprice', 'width' => 12),
					array('title' => '应收款', 'field' => 'amount', 'width' => 12),
					array('title' => '退款方式', 'field' => 'pay_type', 'width' => 12),
					array('title' => '状态', 'field' => 'status', 'width' => 12),
					array('title' => '申请退款时间', 'field' => 'applytime', 'width' => 24),
					array('title' => '取消申请退款时间', 'field' => 'refundtime', 'width' => 24),
					array('title' => '同意退换货申请时间', 'field' => 'operatetime', 'width' => 24),
					array('title' => '买家发货快递', 'field' => 'expresscom', 'width' => 24),
					array('title' => '买家发货快递单号', 'field' => 'expresssn', 'width' => 24),
					array('title' => '买家发货时间', 'field' => 'sendtime', 'width' => 24),
					array('title' => '卖家发货快递', 'field' => 'rexpresscom', 'width' => 24),
					array('title' => '卖家发货快递单号', 'field' => 'rexpresssn', 'width' => 24),
					array('title' => '卖家发货时间', 'field' => 'returntime', 'width' => 24),
					array('title' => '结束时间', 'field' => 'endtime', 'width' => 24),
					array('title' => '维权原因', 'field' => 'reason', 'width' => 24),
					array('title' => '维权说明', 'field' => 'content', 'width' => 24),
					array('title' => '订单备注', 'field' => 'remark', 'width' => 36)
				);
				$exportlist = array();

				foreach ($list as $key => $value) {
					$r['orderno'] = $value['orderno'];
					$r['refundno'] = $value['refundno'];
					$r['nickname'] = str_replace('=', '', $value['nickname']);
					$r['mrealname'] = $value['mrealname'];
					$r['openid'] = $value['openid'];
					$r['mmobile'] = $value['mmobile'];
					$r['arealname'] = $value['arealname'];
					$r['amobile'] = $value['amobile'];
					$r['aprovince'] = $value['aprovince'];
					$r['acity'] = $value['acity'];
					$r['aarea'] = $value['aarea'];
					$r['aaddress'] = $value['aaddress'];
					$r['pay_type'] = $paytype['' . $value['pay_type'] . ''];
					$r['groupsprice'] = $value['groupsprice'];
					$r['singleprice'] = $value['singleprice'];
					$r['price'] = $value['price'];
					$r['applycredit'] = $value['applycredit'];
					$r['applyprice'] = $value['applyprice'];
					$r['goodsprice'] = $value['groupsprice'] * 1;
					$r['status'] = $paystatus['' . $value['status'] . ''];
					$r['applytime'] = !empty($value['applytime']) ? date('Y-m-d H:i:s', $value['applytime']) : '';
					$r['refundtime'] = !empty($value['refundtime']) ? date('Y-m-d H:i:s', $value['refundtime']) : '';
					$r['operatetime'] = !empty($value['operatetime']) ? date('Y-m-d H:i:s', $value['operatetime']) : '';
					$r['sendtime'] = !empty($value['sendtime']) ? date('Y-m-d H:i:s', $value['sendtime']) : '';
					$r['returntime'] = !empty($value['returntime']) ? date('Y-m-d H:i:s', $value['returntime']) : '';
					$r['endtime'] = !empty($value['endtime']) ? date('Y-m-d H:i:s', $value['endtime']) : '';
					$r['expresscom'] = $value['expresscom'];
					$r['expresssn'] = $value['expresssn'];
					$r['rexpresscom'] = $value['rexpresscom'];
					$r['rexpresssn'] = $value['rexpresssn'];
					$r['amount'] = $value['groupsprice'] * 1 - $value['creditmoney'] + $value['freight'];
					$r['remark'] = $value['remark'];
					$r['title'] = $value['title'];
					$r['goodssn'] = $value['goodssn'];
					$r['reason'] = $value['reason'];
					$r['content'] = $value['content'];
					$r['goods_total'] = 1;
					$exportlist[] = $r;
				}

				unset($r);
				m('excel')->export($exportlist, array('title' => '维权订单-' . date('Y-m-d-H-i', time()), 'columns' => $columns));
			}

			include $this->template();
		}
		catch (Exception $e) {
			throw new $e->getMessage();
		}
	}

	public function detail()
	{
		global $_W;
		global $_GPC;

		try {
			$opdata = $this->opData();
			extract($opdata);
			$refundid = $refund['id'];
			$params = array(':refundid' => $refundid);
			$refund = pdo_fetch('SELECT ore.*,o.price,o.credit,op.title as optiontitle,o.freight,o.paytime,o.pay_type,o.orderno,o.goodid,g.title,g.thumb,g.thumb_url,g.category,g.groupsprice' . "\n" . '                FROM ' . tablename('ewei_shop_groups_order_refund') . ' as ore' . "\n\t\t\t\t" . 'right join ' . tablename('ewei_shop_groups_order') . ' as o on o.id = ore.orderid' . "\n\t\t\t\t" . 'left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid' . "\n\t\t\t\t" . 'left join ' . tablename('ewei_shop_groups_goods_option') . ' as op on op.specs = o.specs' . "\n\t\t\t\t" . 'WHERE ore.id = :refundid ', $params);

			$member = m('member')->getMember($refund['openid']);
			$refund['images'] = iunserializer($refund['images']);
			$step_array = array();
			$step_array[1]['step'] = 1;
			$step_array[1]['title'] = '客户申请维权';
			$step_array[1]['time'] = $refund['applytime'];
			$step_array[1]['done'] = 1;
			$step_array[2]['step'] = 2;
			$step_array[2]['title'] = '商家处理维权申请';
			$step_array[2]['done'] = 1;
			$step_array[3]['step'] = 3;
			$step_array[3]['done'] = 0;

			if (0 <= $refund['refundstatus']) {
				if ($refund['rtype'] == 0) {
					$step_array[3]['title'] = '退款完成';
				}
				else if ($refund['rtype'] == 1) {
					$step_array[3]['title'] = '客户退回物品';
					$step_array[4]['step'] = 4;
					$step_array[4]['title'] = '退款退货完成';
				}
				else {
					if ($refund['rtype'] == 2) {
						$step_array[3]['title'] = '客户退回物品';
						$step_array[4]['step'] = 4;
						$step_array[4]['title'] = '商家重新发货';
						$step_array[5]['step'] = 5;
						$step_array[5]['title'] = '换货完成';
					}
				}

				if ($refund['refundstatus'] == 0) {
					$step_array[2]['done'] = 0;
					$step_array[3]['done'] = 0;
				}

				if ($refund['rtype'] == 0) {
					if (0 < $refund['refundstatus']) {
						$step_array[2]['time'] = $refund['refundtime'];
						$step_array[3]['done'] = 1;
						$step_array[3]['time'] = $refund['refundtime'];
					}
				}
				else {
					$step_array[2]['time'] = $refund['operatetime'];
					if ($refund['refundstatus'] == 1 || 4 <= $refund['refundstatus']) {
						$step_array[3]['done'] = 1;
						$step_array[3]['time'] = $refund['sendtime'];
					}

					if ($refund['refundstatus'] == 1 || $refund['refundstatus'] == 5) {
						$step_array[4]['done'] = 1;

						if ($refund['rtype'] == 1) {
							$step_array[4]['time'] = $refund['refundtime'];
						}
						else {
							if ($refund['rtype'] == 2) {
								$step_array[4]['time'] = $refund['refundexpresstime'];

								if ($refund['refundstatus'] == 1) {
									$step_array[5]['done'] = 1;
									$step_array[5]['time'] = $refund['refundtime'];
								}
							}
						}
					}
				}
			}
			else if ($refund['refundstatus'] == -1) {
				$step_array[2]['done'] = 1;
				$step_array[2]['time'] = $refund['endtime'];
				$step_array[3]['done'] = 1;
				$step_array[3]['title'] = '拒绝' . $r_type[$refund['rtype']];
				$step_array[3]['time'] = $refund['endtime'];
			}
			else {
				if ($refund['refundstatus'] == -2) {
					if (!empty($refund['operatetime'])) {
						$step_array[2]['done'] = 1;
						$step_array[2]['time'] = $refund['operatetime'];
					}

					$step_array[3]['done'] = 1;
					$step_array[3]['title'] = '客户取消' . $r_type[$refund['rtype']];
					$step_array[3]['time'] = $refund['refundtime'];
				}
			}

			include $this->template();
		}
		catch (Exception $e) {
			throw new $e->getMessage();
		}
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		global $_S;
		$opdata = $this->opData();
		extract($opdata);

		if ($_W['ispost']) {
			$shopset = $_S['shop'];

			if (empty($item['refundstate'])) {
				show_json(0, '订单未申请维权，不需处理！');
			}

			$setting = pdo_fetch('SELECT refundday FROM ' . tablename('ewei_shop_groups_set') . ' WHERE uniacid = :uniacid ', array(':uniacid' => $_W['uniacid']));
			$refundtime = $item['finishtime'] + 3600 * 24 * $setting['refundday'];
			if ($item['status'] == 3 && $refundtime < time()) {
				pdo_update('ewei_shop_groups_order', array('refundstate' => 0), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				show_json(0, '订单已完成，不需处理！');
			}

			if ($refund['status'] < 0 || $refund['status'] == 1) {
				pdo_update('ewei_shop_groups_order', array('refundstate' => 0), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				show_json(0, '未找到需要处理的维权申请，不需处理！');
			}

			if (empty($refund['refundno'])) {
				$refund['refundno'] = m('common')->createNO('groups_order_refund', 'refundno', 'PR');
				pdo_update('ewei_shop_groups_order_refund', array('refundno' => $refund['refundno']), array('id' => $refund['id']));
			}

			$refundstatus = intval($_GPC['refundstatus']);
			$refundcontent = trim($_GPC['refundcontent']);
			$time = time();
			$change_refund = array();
			$uniacid = $_W['uniacid'];

			if ($refundstatus == 0) {
				show_json(1);
			}
			else if ($refundstatus == 3) {
				$raid = $_GPC['raid'];
				$message = trim($_GPC['message']);

				if ($raid != 0) {
					$raddress = pdo_fetch('select * from ' . tablename('ewei_shop_refund_address') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $raid, ':uniacid' => $uniacid));
				}
				else {
					$raddress = pdo_fetch('select * from ' . tablename('ewei_shop_refund_address') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $raid, ':uniacid' => $uniacid));
				}

				if (empty($raddress)) {
					$raddress = pdo_fetch('select * from ' . tablename('ewei_shop_refund_address') . ' where uniacid=:uniacid order by id desc limit 1', array(':uniacid' => $uniacid));
				}

				$address_array = iunserializer($change_refund['refundaddress']);
				$address_array = array('id' => $raddress['id'], 'title' => $raddress['title'], 'name' => $raddress['name'], 'mobile' => $raddress['mobile'], 'province' => $raddress['province'], 'city' => $raddress['city'], 'area' => $raddress['area'], 'address' => $raddress['address']);
				$address_array = iserializer($address_array);
				$change_refund['refundaddress'] = $address_array;
				$change_refund['refundaddressid'] = $raid;
				$change_refund['refusereason'] = '';
				$change_refund['message'] = $message;
				$change_refund = array('refundaddress' => $address_array, 'refundaddressid' => !empty($raid) ? $raid : $raddress['id'], 'reply' => '', 'message' => $message, 'operatetime' => $time, 'refundstatus' => 3);
				pdo_update('ewei_shop_groups_order_refund', $change_refund, array('id' => $item['refundid']));
				p('groups')->sendTeamMessage($item['id'], true);
			}
			else if ($refundstatus == 5) {
				$change_refund['rexpress'] = $_GPC['rexpress'];
				$change_refund['rexpresscom'] = $_GPC['rexpresscom'];
				$change_refund['rexpresssn'] = trim($_GPC['rexpresssn']);
				$change_refund['refundstatus'] = 5;
				if ($refund['refundstatus'] != 5 && empty($refund['returntime'])) {
					$change_refund['returntime'] = $time;

					if (empty($refund['operatetime'])) {
						$change_refund['operatetime'] = $time;
					}
				}

				pdo_update('ewei_shop_groups_order_refund', $change_refund, array('id' => $item['refundid']));
				p('groups')->sendTeamMessage($item['id'], true);
			}
			else if ($refundstatus == 10) {
				$refund_data['refundstatus'] = 1;
				$refund_data['refundtime'] = $time;
				pdo_update('ewei_shop_groups_order_refund', $refund_data, array('id' => $item['refundid'], 'uniacid' => $uniacid));
				$order_data = array();
				$order_data['refundstate'] = 0;
				$order_data['status'] = 3;
				$order_data['refundtime'] = $time;
				pdo_update('ewei_shop_groups_order', $order_data, array('id' => $item['id'], 'uniacid' => $uniacid));
				p('groups')->sendTeamMessage($item['id'], true);
			}
			else if ($refundstatus == 1) {
				$ordersn = $item['orderno'];

				if (!empty($item['ordersn2'])) {
					$var = sprintf('%02d', $item['ordersn2']);
					$ordersn .= 'GJ' . $var;
				}

				$realprice = $refund['applyprice'];
				$order = pdo_fetch('SELECT id,orderno,credit,creditmoney,price,freight,status,pay_type,is_team,apppay FROM ' . tablename('ewei_shop_groups_order') . '
                    WHERE id = :orderid and uniacid=:uniacid', array(':orderid' => $item['id'], ':uniacid' => $uniacid));
				$credits = $refund['applycredit'];
				$refundtype = 0;
				$totalmoney = $order['price'] + $order['freight'] - $order['creditmoney'];

				if ($order['pay_type'] == 'credit') {
					m('member')->setCredit($item['openid'], 'credit2', $realprice, array(0, $shopset['name'] . ('退款: ' . $realprice . '元 订单号: ') . $item['orderno']));
					$result = true;
				}
				else if ($order['pay_type'] == 'wechat') {
					$realprice = round($realprice, 2);

					if (empty($item['isborrow'])) {
						$result = m('finance')->refund($item['openid'], $ordersn, $refund['refundno'], $totalmoney * 100, $realprice * 100, !empty($order['apppay']) ? true : false);
					}
					else {
						$result = m('finance')->refundBorrow($item['borrowopenid'], $ordersn, $refund['refundno'], $totalmoney * 100, $realprice * 100, !empty($order['apppay']) ? true : false);
					}

					$refundtype = 2;
				}
				else {
					if ($realprice < 1) {
						show_json(0, '退款金额必须大于1元，才能使用微信企业付款退款!');
					}

					$realprice = round($realprice - $item['deductcredit2'], 2);
					$result = m('finance')->pay($item['openid'], 1, $realprice * 100, $refund['refundno'], $shopset['name'] . ('退款: ' . $realprice . '元 订单号: ') . $item['orderno']);
					$refundtype = 1;
				}

				if (is_error($result)) {
					show_json(0, $result['message']);
				}

				if (0 < $item['credit']) {
					m('member')->setCredit($item['openid'], 'credit1', $item['credit'], array('0', $shopset['name'] . ('购物返还抵扣积分 积分: ' . $item['credit'] . ' 抵扣金额: ' . $item['creditmoney'] . ' 订单号: ' . $item['orderno'])));
				}

				if (!empty($refundtype)) {
					m('order')->setDeductCredit2($item);
				}

				$change_refund['reply'] = '';
				$change_refund['refundstatus'] = 1;
				$change_refund['refundtype'] = $refundtype;
				$change_refund['applyprice'] = $realprice;
				$change_refund['refundtime'] = $time;

				if (empty($refund['operatetime'])) {
					$change_refund['operatetime'] = $time;
				}

				pdo_update('ewei_shop_groups_order_refund', $change_refund, array('id' => $item['refundid']));
				$this->model->sendTeamMessage($item['id'], true);
				pdo_update('ewei_shop_groups_order', array('refundstate' => 0, 'status' => -1, 'refundtime' => $time), array('id' => $item['id'], 'uniacid' => $uniacid));
				$sales = pdo_fetch('select id,sales,stock from ' . tablename('ewei_shop_groups_goods') . ' where id = :id and uniacid = :uniacid ', array(':id' => $item['goodid'], ':uniacid' => $uniacid));
				pdo_update('ewei_shop_groups_goods', array('sales' => $sales['sales'] - 1, 'stock' => $sales['stock'] + 1), array('id' => $sales['id'], 'uniacid' => $uniacid));
				plog('groups.refund', '订单退款 ID: ' . $item['id'] . ' 订单号: ' . $item['orderno']);
			}
			else if ($refundstatus == -1) {
				pdo_update('ewei_shop_groups_order_refund', array('reply' => $refundcontent, 'refundstatus' => -1, 'endtime' => $time), array('id' => $item['refundid']));
				p('groups')->sendTeamMessage($item['id'], true);
				plog('groups.refund', '订单退款拒绝 ID: ' . $item['id'] . ' 订单号: ' . $item['orderno'] . ' 原因: ' . $refundcontent);
				pdo_update('ewei_shop_groups_order', array('refundstate' => 0), array('id' => $item['id'], 'uniacid' => $uniacid));
			}
			else {
				if ($refundstatus == 2) {
					$refundtype = 2;
					$change_refund['reply'] = '';
					$change_refund['refundstatus'] = 1;
					$change_refund['refundtype'] = $refundtype;
					$change_refund['applyprice'] = $refund['applyprice'];
					$change_refund['refundtime'] = $time;

					if (empty($refund['operatetime'])) {
						$change_refund['operatetime'] = $time;
					}

					pdo_update('ewei_shop_groups_order_refund', $change_refund, array('id' => $item['refundid']));
					p('groups')->sendTeamMessage($item['id'], true);
					pdo_update('ewei_shop_groups_order', array('refundstate' => 0, 'status' => -1, 'refundtime' => $time), array('id' => $item['id'], 'uniacid' => $uniacid));
					$sales = pdo_fetch('select id,sales,stock from ' . tablename('ewei_shop_groups_goods') . ' where id = :id and uniacid = :uniacid ', array(':id' => $item['goodid'], ':uniacid' => $uniacid));
					pdo_update('ewei_shop_groups_goods', array('sales' => $sales['sales'] - 1, 'stock' => $sales['stock'] + 1), array('id' => $sales['id'], 'uniacid' => $uniacid));
				}
			}

			show_json(1);
		}

		$refund_address = pdo_fetchall('select * from ' . tablename('ewei_shop_refund_address') . ' where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
		$express_list = m('express')->getExpressList();
		include $this->template();
	}

	public function ajaxgettotals()
	{
		$totals = $this->model->getTotals();
		$result = empty($totals) ? array() : $totals;
		show_json(1, $result);
	}
}

?>
