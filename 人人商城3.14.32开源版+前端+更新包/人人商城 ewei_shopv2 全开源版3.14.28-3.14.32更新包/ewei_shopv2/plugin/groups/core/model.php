<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class GroupsModel extends PluginModel
{
	protected function getUrl($do, $query = NULL)
	{
		$url = mobileUrl($do, $query, true);

		if (strexists($url, '/addons/ewei_shopv2/')) {
			$url = str_replace('/addons/ewei_shopv2/', '/', $url);
		}

		if (strexists($url, '/core/mobile/order/')) {
			$url = str_replace('/core/mobile/order/', '/', $url);
		}

		return $url;
	}

	public function orderstest()
	{
		global $_W;
		$uniacid = $_W['uniacid'];
		$sql = 'SELECT * FROM' . tablename('ewei_shop_groups_order') . 'where uniacid = :uniacid and status = 0 ';
		$params = array('uniacid' => $uniacid);
		$allorders = pdo_fetchall($sql, $params);

		if ($allorders) {
			foreach ($allorders as $key => $value) {
				$hours = $value['endtime'];
				$time = time();
				$date = date('Y-m-d H:i:s', $value['createtime']);
				$endtime = date('Y-m-d H:i:s', strtotime(' ' . $date . ' + ' . $hours . ' hour'));
				$date1 = date('Y-m-d H:i:s', $time);
				$lasttime2 = strtotime($endtime) - strtotime($date1);

				if ($lasttime2 < 0) {
					pdo_update('ewei_shop_groups_order', array('status' => -1), array('id' => $value['id']));
				}
			}
		}

		$sql1 = 'SELECT * FROM' . tablename('ewei_shop_groups_order') . 'where uniacid = :uniacid and heads = 1 and status = 1 and success = 0 ';
		$allteam = pdo_fetchall($sql1, $params);

		if ($allteam) {
			foreach ($allteam as $key => $value) {
				$total = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . '  where uniacid = :uniacid and teamid = :teamid and heads = :heads and status = :status and success = :success ', array(':uniacid' => $uniacid, ':heads' => 1, ':teamid' => $value['teamid'], ':status' => 1, ':success' => 0));

				if ($value['groupnum'] == $total) {
					pdo_update('ewei_shop_groups_order', array('success' => 1), array('teamid' => $value['teamid']));
				}
				else {
					$hours = $value['endtime'];
					$time = time();
					$date = date('Y-m-d H:i:s', $value['starttime']);
					$endtime = date('Y-m-d H:i:s', strtotime(' ' . $date . ' + ' . $hours . ' hour'));
					$date1 = date('Y-m-d H:i:s', $time);
					$lasttime2 = strtotime($endtime) - strtotime($date1);

					if ($lasttime2 < 0) {
						pdo_update('ewei_shop_groups_order', array('success' => -1, 'canceltime' => strtotime($endtime)), array('teamid' => $value['teamid']));
					}
				}
			}
		}
	}

	/**
     * 支付成功
     * @global type $_W
     * @param type $params
     */
	public function payResult($orderno, $type, $app = false)
	{
		global $_W;
		$uniacid = $_W['uniacid'];
		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_paylog') . '
		 WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $uniacid, ':module' => 'groups', ':tid' => $orderno));
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . ' where  orderno =:orderno and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':orderno' => $orderno));
		if (0 < $order['status'] || 0 < $log['status']) {
			return true;
		}

		$openid = $order['openid'];
		$order_goods = pdo_fetch('select * from  ' . tablename('ewei_shop_groups_goods') . '
					where id = :id and uniacid=:uniacid ', array(':uniacid' => $uniacid, ':id' => $order['goodid']));

		if (0 < $order['credit']) {
			$result = m('member')->setCredit($openid, 'credit1', 0 - $order['credit'], array($_W['member']['uid'], $_W['shopset']['shop']['name'] . '消费' . $order['credit'] . '积分'));

			if (is_error($result)) {
				return $result['message'];
			}
		}

		$record = array();
		$record['status'] = '1';
		$record['type'] = $type;
		$params = array(':teamid' => $order['teamid'], ':uniacid' => $uniacid, ':success' => 0, ':status' => 1);
		pdo_update('ewei_shop_groups_order', array('pay_type' => $type, 'status' => 1, 'paytime' => TIMESTAMP, 'starttime' => TIMESTAMP, 'apppay' => $app ? 1 : 0), array('orderno' => $orderno));
		pdo_update('ewei_shop_groups_paylog', array('status' => 1), array('tid' => $orderno));
		$this->sendTeamMessage($order['id']);

		if (!empty($order['is_team'])) {
			$total = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' as o where status = :status and teamid = :teamid and uniacid = :uniacid and success = :success ', $params);

			if ($order['groupnum'] == $total) {
				pdo_update('ewei_shop_groups_order', array('success' => 1), array('teamid' => $order['teamid'], 'status' => 1, 'uniacid' => $uniacid));
				pdo_update('ewei_shop_groups_order', array('success' => -1, 'status' => -1, 'canceltime' => time()), array('teamid' => $order['teamid'], 'status' => 0, 'uniacid' => $uniacid));
				$this->sendTeamMessage($order['id']);
			}
		}

		if ($order_goods['more_spec'] == '1') {
			$order_goods_S = pdo_get('ewei_shop_groups_order_goods', array('groups_order_id' => $order['id']));
			$goods_option = pdo_get('ewei_shop_groups_goods_option', array('goods_option_id' => $order_goods_S['groups_goods_option_id']));
			pdo_update('ewei_shop_groups_goods_option', array('stock' => $goods_option['stock'] - 1), array('id' => $goods_option['id']));
			$stock = intval($order_goods['stock'] - $order_goods['goodsnum']);
			$sales = intval($order_goods['sales']) + $order_goods['goodsnum'];
		}
		else {
			$stock = intval($order_goods['stock'] - $order_goods['goodsnum']);
			$sales = intval($order_goods['sales']) + $order_goods['goodsnum'];
		}

		pdo_update('ewei_shop_groups_goods', array('stock' => $stock, 'sales' => $sales), array('id' => $order_goods['id']));
		return true;
	}

	public function getTotals()
	{
		global $_W;
		$paras = array(':uniacid' => $_W['uniacid']);
		$totals['all'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' o
			 WHERE o.uniacid = :uniacid and o.isverify = 0 ', $paras);
		$totals['status1'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' o
			 WHERE o.uniacid = :uniacid and o.isverify = 0 and o.status = 1 and (o.success = 1 or o.is_team = 0) ', $paras);
		$totals['status2'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' o
			 WHERE o.uniacid = :uniacid and o.isverify = 0 and o.status=2 ', $paras);
		$totals['status3'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' o
			 WHERE o.uniacid = :uniacid and o.isverify = 0 and o.status = 0 ', $paras);
		$totals['status4'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' o
			 WHERE o.uniacid = :uniacid and o.isverify = 0 and o.status = 3 ', $paras);
		$totals['status5'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' o
			 WHERE o.uniacid = :uniacid and o.isverify = 0 and o.status = -1 ', $paras);
		$totals['team1'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' o
			 WHERE o.uniacid = :uniacid and o.heads = 1 and o.paytime > 0 and is_team = 1 and o.success = 1 ', $paras);
		$totals['team2'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' o
			 WHERE o.uniacid = :uniacid and o.heads = 1 and o.paytime > 0 and is_team = 1 and o.success = 0 ', $paras);
		$totals['team3'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' o
			 WHERE o.uniacid = :uniacid and o.heads = 1 and o.paytime > 0 and is_team = 1 and o.success = -1 ', $paras);
		$totals['allteam'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' o
			 WHERE o.uniacid = :uniacid and o.heads = 1 and o.paytime > 0 and is_team = 1 ', $paras);
		$totals['refund1'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order_refund') . ' as ore
			left join ' . tablename('ewei_shop_groups_order') . ' as o on o.id = ore.orderid
			right join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
			right join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid and m.uniacid =  o.uniacid
			left join ' . tablename('ewei_shop_member_address') . ' a on a.id=ore.refundaddressid
			right join ' . tablename('ewei_shop_groups_category') . ' as c on c.id = g.category
			WHERE ore.uniacid = :uniacid AND o.refundstate > 0 and o.refundid != 0 and ore.refundstatus >= 0 ', $paras);
		$totals['refund2'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order_refund') . ' as ore
			left join ' . tablename('ewei_shop_groups_order') . ' as o on o.id = ore.orderid
			right join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
			right join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid and m.uniacid =  o.uniacid
			left join ' . tablename('ewei_shop_member_address') . ' a on a.id=ore.refundaddressid
			right join ' . tablename('ewei_shop_groups_category') . ' as c on c.id = g.category
			WHERE ore.uniacid = :uniacid AND (o.refundtime != 0 or ore.refundstatus < 0) ', $paras);
		$totals['verify1'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' as o
			WHERE o.uniacid=:uniacid and o.isverify = 1 and o.status =  1 ', $paras);
		$totals['verify2'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' as o
			WHERE o.uniacid=:uniacid and o.isverify = 1 and o.status = 3 ', $paras);
		$totals['verify3'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' as o
			WHERE o.uniacid=:uniacid and o.isverify = 1 and o.status <= 0 ', $paras);
		return $totals;
	}

	public function groupsShare()
	{
		global $_W;
		$uniacid = $_W['uniacid'];
		$share = pdo_fetch('select share_title,share_icon,share_desc,share_url from ' . tablename('ewei_shop_groups_set') . ' where uniacid=:uniacid ', array(':uniacid' => $uniacid));
		$myid = m('member')->getMid();
		$set = $_W['shopset'];
		$_W['shopshare'] = array('title' => !empty($share['share_title']) ? $share['share_title'] : $set['shop']['name'], 'imgUrl' => !empty($share['share_icon']) ? tomedia($share['share_icon']) : tomedia($set['shop']['logo']), 'desc' => !empty($share['share_desc']) ? $share['share_desc'] : $set['shop']['description'], 'link' => !empty($share['share_url']) ? $share['share_url'] : mobileUrl('groups', array('shareid' => $myid), true));
	}

	/**
     * 拼团发送订单通知
     * @param type $message_type
     * @param type $order
     */
	public function sendTeamMessage($orderid = '0', $delRefund = false)
	{
		global $_W;
		$uniacid = $_W['uniacid'];
		$orderid = intval($orderid);

		if (empty($orderid)) {
			return NULL;
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . ' where uniacid = :uniacid and id=:id limit 1', array(':uniacid' => $uniacid, ':id' => $orderid));

		if (empty($order)) {
			return NULL;
		}

		$openid = $order['openid'];

		if (intval($order['teamid'])) {
			$url = $this->getUrl('groups/team/detail', array('orderid' => $orderid, 'teamid' => intval($order['teamid'])));
		}
		else {
			$url = $this->getUrl('groups/orders/detail', array('orderid' => $orderid));
		}

		$order_goods = pdo_fetch('select * from ' . tablename('ewei_shop_groups_goods') . ' where uniacid=:uniacid and id=:id ', array(':uniacid' => $_W['uniacid'], ':id' => intval($order['goodid'])));
		$goodsprice = !empty($order['is_team']) ? number_format($order_goods['groupsprice'], 2) : number_format($order_goods['singleprice'], 2);
		$price = number_format($order['price'] - $order['creditmoney'] + $order['freight'], 2);
		$goods = '待发货商品--' . $order_goods['title'];
		$goods2 = $order_goods['title'];
		$orderpricestr = ' ¥' . $price . '元 (包含运费: ¥' . $order['freight'] . '元，积分抵扣: ¥' . $order['creditmoney'] . '元)';
		$member = m('member')->getMember($openid);
		$successTime = pdo_fetchcolumn('select paytime from ' . tablename('ewei_shop_groups_order') . ' where uniacid=:uniacid and teamid=:teamid order by paytime desc', array(':uniacid' => $uniacid, ':teamid' => $order['teamid']));
		$successTime = date('Y-m-d H:i:s', $successTime);
		$datas = array(
			array('name' => '商城名称', 'value' => $_W['shopset']['shop']['name']),
			array('name' => '粉丝昵称', 'value' => $member['nickname']),
			array('name' => '订单号', 'value' => $order['orderno']),
			array('name' => '订单金额', 'value' => $order['price'] - $order['creditmoney'] + $order['freight']),
			array('name' => '运费', 'value' => $order['freight']),
			array('name' => '商品详情', 'value' => $goods),
			array('name' => '快递公司', 'value' => $order['expresscom']),
			array('name' => '快递单号', 'value' => $order['expresssn']),
			array('name' => '下单时间', 'value' => date('Y-m-d H:i', $order['createtime'])),
			array('name' => '支付时间', 'value' => date('Y-m-d H:i', $order['paytime'])),
			array('name' => '发货时间', 'value' => date('Y-m-d H:i', $order['sendtime'])),
			array('name' => '收货时间', 'value' => date('Y-m-d H:i', $order['finishtime'])),
			array('name' => '拼团成功时间', 'value' => $successTime)
		);
		$usernotice = unserialize($member['noticeset']);

		if (!is_array($usernotice)) {
			$usernotice = array();
		}

		$set = $set = m('common')->getSysset();
		$shop = $set['shop'];
		$tm = $set['notice'];

		if ($delRefund == true) {
			$order_refund = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order_refund') . ' where uniacid=:uniacid and id=:id ', array(':uniacid' => $_W['uniacid'], ':id' => intval($order['refundid'])));
			$refundtype = '';

			if ($order['pay_type'] == 'credit') {
				$refundtype = ', 已经退回您的余额账户，请留意查收！';
			}
			else {
				if ($order['pay_type'] == 'wechat') {
					$refundtype = ', 已经退回您的对应支付渠道（如银行卡，微信钱包等, 具体到账时间请您查看微信支付通知)，请留意查收！';
				}
			}

			if ($order_refund['refundtype'] == 2) {
				$refundtype = ', 请联系客服进行退款事项！';
			}

			$applyprice = !empty($order_refund['applyprice']) ? $order_refund['applyprice'] : $order['price'] - $order['creditmoney'] + $order['freight'];

			if ($order_refund['refundstatus'] == 0) {
				$tm = m('common')->getSysset('notice');
				$msgteam = array(
					'first'    => array('value' => '您有一条申请退款的订单！', 'color' => '#4a5077'),
					'keyword1' => array('title' => '企业名称', 'value' => $shop['name'], 'color' => '#4a5077'),
					'keyword2' => array('title' => '订单编号', 'value' => '订单编号：' . $order['orderno'] . ',维权编号：' . $order_refund['refundno'], 'color' => '#4a5077')
				);

				if (!empty($tm['openid'])) {
					$openids = explode(',', $tm['openid']);

					foreach ($openids as $value) {
						$this->sendGroupsNotice(array('openid' => $value, 'tag' => 'groups_teamsend', 'default' => $msgteam, 'datas' => $datas));
					}
				}
			}
			else if ($order_refund['refundstatus'] == -1) {
				$msg = array(
					'first'    => array('value' => '您的退款订单已经被驳回', 'color' => '#4a5077'),
					'keyword1' => array('title' => '订单编号', 'value' => $order['orderno'], 'color' => '#4a5077'),
					'keyword2' => array('title' => '维权编号', 'value' => $order_refund['refundno'], 'color' => '#4a5077'),
					'keyword3' => array('title' => '驳回原因', 'value' => $order_refund['reply'], 'color' => '#4a5077')
				);
				$this->sendGroupsNotice(array('openid' => $openid, 'tag' => 'groups_refund', 'default' => $msg, 'datas' => $datas));
			}
			else {
				if ($order_refund['refundstatus'] == 1) {
					$msg = array(
						'first'    => array('value' => '您的订单已经完成退款！', 'color' => '#4a5077'),
						'keyword1' => array('title' => '退款金额', 'value' => '¥' . $applyprice . '元', 'color' => '#4a5077'),
						'keyword2' => array('title' => '商品详情', 'value' => $goods2, 'color' => '#4a5077'),
						'keyword3' => array('title' => '订单编号', 'value' => $order['orderno'], 'color' => '#4a5077'),
						'remark'   => array('value' => '退款金额 ¥' . $applyprice . ($refundtype . '
 期待您再次购物！'), 'color' => '#4a5077')
					);
					$this->sendGroupsNotice(array('openid' => $openid, 'tag' => 'groups_refund', 'default' => $msg, 'datas' => $datas));
				}
			}
		}
		else if ($order['status'] == 1) {
			if ($order['success'] == 1) {
				$order = pdo_fetchall('select * from ' . tablename('ewei_shop_groups_order') . ' where teamid = :teamid and success = 1 and status = 1 ', array(':teamid' => $order['teamid']));
				$remark = '您参加的拼团已经成功，我们将尽快为您配送~~';

				if ($order['isverify']) {
					$remark = '您参加的拼团已经成功';
				}

				foreach ($order as $key => $value) {
					$msg = array(
						'first'    => array('value' => '您参加的拼团已经成功组团！', 'color' => '#4a5077'),
						'keyword1' => array('title' => '订单编号', 'value' => $value['orderno'], 'color' => '#4a5077'),
						'keyword2' => array('title' => '通知时间', 'value' => date('Y-m-d H:i', time()), 'color' => '#4a5077'),
						'remark'   => array('value' => $remark, 'color' => '#4a5077')
					);
					$this->sendGroupsNotice(array('openid' => $value['openid'], 'tag' => 'groups_success', 'default' => $msg, 'datas' => $datas));
				}

				$tm = m('common')->getSysset('notice');
				$remarkteam = '拼团成功了，准备发货';

				if ($order['isverify']) {
					$remarkteam = '拼团成功了,买家购买的商品已经确认收货';
				}

				$msgteam = array(
					'first'    => array('value' => '拼团已经成功组团！', 'color' => '#4a5077'),
					'keyword1' => array('title' => '待办项目', 'value' => $goods, 'color' => '#4a5077'),
					'keyword2' => array('title' => '待办环节', 'value' => '等待发货', 'color' => '#4a5077'),
					'keyword3' => array('title' => '更新时间', 'value' => date('Y-m-d H:i', time()), 'color' => '#4a5077'),
					'remark'   => array('value' => $remarkteam, 'color' => '#4a5077')
				);

				if (!empty($tm['openid'])) {
					$openids = explode(',', $tm['openid']);

					foreach ($openids as $value) {
						$this->sendGroupsNotice(array('openid' => $value, 'tag' => 'groups_teamsend', 'default' => $msgteam, 'datas' => $datas));
					}
				}
			}
			else if ($order['success'] == -1) {
				$order = pdo_fetchall('select * from ' . tablename('ewei_shop_groups_order') . ' where teamid = :teamid and success = -1 and status = 1 ', array(':teamid' => $order['teamid']));
				$remark = '很抱歉，您所在的拼团未能成功组团，系统会在24小时之内自动退款。如有疑问请联系卖家，谢谢您的参与！';

				foreach ($order as $key => $value) {
					$msg = array(
						'first'    => array('value' => '您参加的拼团组团失败！', 'color' => '#4a5077'),
						'keyword1' => array('title' => '订单编号', 'value' => $value['orderno'], 'color' => '#4a5077'),
						'keyword2' => array('title' => '通知时间', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#4a5077'),
						'remark'   => array('value' => $remark, 'color' => '#4a5077')
					);
					$this->sendGroupsNotice(array('openid' => $value['openid'], 'tag' => 'groups_error', 'default' => $msg, 'datas' => $datas));
				}
			}
			else {
				if ($order['success'] == 0) {
					if (!empty($order['addressid'])) {
						if ($order['is_team']) {
							$remark = '
您的订单我们已经收到，请耐心等待其他团员付款~~';
						}
						else {
							$remark = '
您的订单我们已经收到，我们将尽快配送~~';
						}
					}

					$msg = array(
						'first'    => array('value' => '您的订单已提交成功！', 'color' => '#4a5077'),
						'keyword1' => array('title' => '订单编号', 'value' => $order['orderno'], 'color' => '#4a5077'),
						'keyword2' => array('title' => '消费金额', 'value' => $orderpricestr, 'color' => '#4a5077'),
						'keyword3' => array('title' => '消费门店', 'value' => $shop['name'], 'color' => '#4a5077'),
						'keyword4' => array('title' => '消费时间', 'value' => date('Y-m-d H:i:s', $order['createtime']), 'color' => '#4a5077'),
						'remark'   => array('value' => $remark, 'color' => '#4a5077')
					);
					$this->sendGroupsNotice(array('openid' => $openid, 'tag' => 'groups_pay', 'default' => $msg, 'url' => $url, 'datas' => $datas));

					if (!$order['is_team']) {
						$tm = m('common')->getSysset('notice');
						$remarkteam = '单购订单成功了，准备发货';
						$msgteam = array(
							'first'    => array('value' => '单购订单成功了！', 'color' => '#4a5077'),
							'keyword1' => array('title' => '企业名称', 'value' => $shop['name'], 'color' => '#4a5077'),
							'keyword2' => array('title' => '摘要', 'value' => $goods, 'color' => '#4a5077'),
							'remark'   => array('value' => $remarkteam, 'color' => '#4a5077')
						);
						$business = explode(',', $tm['openid']);

						foreach ($business as $value) {
							$this->sendGroupsNotice(array('openid' => $value, 'tag' => 'groups_teamsend', 'default' => $msgteam, 'datas' => $datas));
						}
					}
				}
			}
		}
		else if ($order['status'] == 2) {
			if (!empty($order['addressid'])) {
				$remark = '您的订单已发货，请注意查收！';
			}

			$msg = array(
				'first'    => array('value' => '您的订单已发货！', 'color' => '#4a5077'),
				'keyword1' => array('title' => '订单编号', 'value' => $order['orderno'], 'color' => '#4a5077'),
				'keyword2' => array('title' => '物流公司', 'value' => $order['expresscom'], 'color' => '#4a5077'),
				'keyword3' => array('title' => '物流单号', 'value' => $order['expresssn'], 'color' => '#4a5077'),
				'remark'   => array('value' => $remark, 'color' => '#4a5077')
			);
			$this->sendGroupsNotice(array('openid' => $openid, 'tag' => 'groups_send', 'default' => $msg, 'datas' => $datas));
		}
		else if ($order['status'] == 3) {
			if (!empty($order['addressid'])) {
				$remark = '您的订单已收货成功！';
			}

			$msg = array(
				'first'    => array('value' => '订单已收货！', 'color' => '#4a5077'),
				'keyword1' => array('title' => '订单编号', 'value' => $order['orderno'], 'color' => '#4a5077'),
				'keyword2' => array('title' => '物流公司', 'value' => $order['expresscom'], 'color' => '#4a5077'),
				'keyword3' => array('title' => '物流单号', 'value' => $order['expresssn'], 'color' => '#4a5077'),
				'remark'   => array('value' => $remark, 'color' => '#4a5077')
			);
			$this->sendGroupsNotice(array('openid' => $openid, 'tag' => 'groups_send', 'default' => $msg, 'datas' => $datas));
		}
		else {
			if ($order['status'] == -1) {
				if (!empty($order['addressid'])) {
					$remark = '您的订单已取消！';
				}

				$msg = array(
					'first'    => array('value' => '订单已取消！', 'color' => '#4a5077'),
					'keyword1' => array('title' => '订单编号', 'value' => $order['orderno'], 'color' => '#4a5077'),
					'keyword2' => array('title' => '通知时间', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#4a5077'),
					'remark'   => array('value' => $remark, 'color' => '#4a5077')
				);
				$this->sendGroupsNotice(array('openid' => $openid, 'tag' => 'groups_error', 'default' => $msg, 'datas' => $datas));
			}
		}
	}

	public function sendGroupsNotice(array $params)
	{
		global $_W;
		global $_GPC;
		$tag = isset($params['tag']) ? $params['tag'] : '';
		$touser = isset($params['openid']) ? $params['openid'] : '';

		if (empty($touser)) {
			return NULL;
		}

		$tm = $_W['shopset']['notice'];

		if (empty($tm)) {
			$tm = m('common')->getSysset('notice');
		}

		$templateid = $tm['is_advanced'] ? $tm[$tag . '_template'] : $tm[$tag];
		$default_message = isset($params['default']) ? $params['default'] : array();
		$url = isset($params['url']) ? $params['url'] : '';
		$account = isset($params['account']) ? $params['account'] : m('common')->getAccount();
		$datas = isset($params['datas']) ? $params['datas'] : array();
		$advanced_message = false;

		if ($tm['is_advanced']) {
			if (!empty($tm[$tag . '_close_advanced'])) {
				return NULL;
			}

			if (!empty($templateid)) {
				$advanced_template = pdo_fetch('select * from ' . tablename('ewei_shop_member_message_template') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $templateid, ':uniacid' => $_W['uniacid']));

				if (!empty($advanced_template)) {
					$advanced_message = array(
						'first'  => array('value' => $this->replaceTemplate($advanced_template['first'], $datas), 'color' => $advanced_template['firstcolor']),
						'remark' => array('value' => $this->replaceTemplate($advanced_template['remark'], $datas), 'color' => $advanced_template['remarkcolor'])
					);
					$data = iunserializer($advanced_template['data']);

					foreach ($data as $d) {
						$advanced_message[$d['keywords']] = array('value' => $this->replaceTemplate($d['value'], $datas), 'color' => $d['color']);
					}

					$ret = m('message')->sendTplNotice($touser, $advanced_template['template_id'], $advanced_message, $url, $account);

					if (is_error($ret)) {
						$ret = m('message')->sendCustomNotice($touser, $advanced_message, $url, $account);

						if (is_error($ret)) {
							$ret = m('message')->sendCustomNotice($touser, $advanced_message, $url, $account);
						}
					}
				}
				else {
					m('message')->sendCustomNotice($touser, $default_message, $url, $account);
				}
			}
			else {
				m('message')->sendCustomNotice($touser, $default_message, $url, $account);
			}
		}
		else {
			if (!empty($tm[$tag . '_close_normal'])) {
				return NULL;
			}

			$ret = m('message')->sendTplNotice($touser, $templateid, $default_message, $url, $account);

			if (is_error($ret)) {
				m('message')->sendCustomNotice($touser, $default_message, $url, $account);
			}
		}
	}

	protected function replaceTemplate($str, $datas = array())
	{
		foreach ($datas as $d) {
			$str = str_replace('[' . $d['name'] . ']', $d['value'], $str);
		}

		return $str;
	}

	public function allow($orderid, $times = 0, $verifycode = '', $openid = '')
	{
		global $_W;
		global $_GPC;

		if (empty($openid)) {
			$openid = $_W['openid'];
		}

		$uniacid = $_W['uniacid'];
		$store = false;
		$merchid = 0;
		$lastverifys = 0;
		$verifyinfo = false;

		if ($times <= 0) {
			$times = 1;
		}

		$saler = pdo_fetch('select * from ' . tablename('ewei_shop_saler') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));

		if ($saler['status'] == 0) {
			return error(-1, '无核销权限!');
		}

		if (empty($saler)) {
			return error(-1, '无核销权限!');
		}

		$merchid = $saler['merchid'];
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . ' where id=:id and uniacid=:uniacid  limit 1', array(':id' => $orderid, ':uniacid' => $uniacid));

		if (empty($order)) {
			return error(-1, '订单不存在!');
		}

		if (empty($order['isverify'])) {
			return error(-1, '订单无需核销!');
		}

		if (!empty($order['is_team'])) {
			if ($order['status'] <= 0 || $order['success'] <= 0) {
				return error(-1, '此订单未满足核销条件!');
			}
		}

		if (empty($order['is_team']) && $order['status'] <= 0) {
			return error(-1, '此订单未满足核销条件!');
		}

		if ($order['isverify'] || $order['istrade']) {
			if (0 < $order['refundid'] && 0 < $order['refundstate']) {
				return error(-1, '订单维权中,无法进行核销!');
			}
		}
		else {
			if ($order['dispatchtype'] == 1) {
				if (0 < $order['refundid'] && 0 < $order['refundstate']) {
					return error(-1, '订单维权中,无法进行自提!');
				}
			}
		}

		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_groups_goods') . '
			where uniacid=:uniacid and id = :goodid ', array(':uniacid' => $uniacid, ':goodid' => $order['goodid']));

		if (empty($goods)) {
			return error(-1, '订单异常!');
		}
		$option_title = '';
        $order_goods = pdo_fetch('select id,option_name from ' . tablename('ewei_shop_groups_order_goods') . '\n\t\t\twhere uniacid=:uniacid and groups_goods_id = :groups_goods_id and groups_order_id = :groups_order_id', array(':uniacid' => $uniacid, ':groups_goods_id' => $goods['id'], ':groups_order_id' => $orderid));
        if (!empty($order_goods)) {
            $option_title = $order_goods['option_name'];
        }
        $goods['optiontitle'] = $option_title;
		if ($order['isverify']) {
			$storeids = array();

			if (!empty($goods['storeids'])) {
				$storeids = explode(',', $goods['storeids']);
			}

			if (!empty($storeids)) {
				if (!empty($saler['storeid'])) {
					if (!in_array($saler['storeid'], $storeids)) {
						return error(-1, '您无此门店的核销权限!');
					}
				}
			}

			if ($order['verifytype'] == 0) {
				$verifynum = pdo_fetchcolumn('select COUNT(1) from ' . tablename('ewei_shop_groups_verify') . ' where uniacid = :uniacid and orderid = :orderid ', array(':uniacid' => $uniacid, ':orderid' => $orderid));

				if ($order['verifynum'] <= $verifynum) {
					return error(-1, '此订单已完成核销！');
				}
			}
			else {
				if ($order['verifytype'] == 1) {
					$verifynum = pdo_fetchcolumn('select COUNT(1) from ' . tablename('ewei_shop_groups_verify') . ' where uniacid = :uniacid and orderid = :orderid ', array(':uniacid' => $uniacid, ':orderid' => $orderid));

					if ($order['verifynum'] <= $verifynum) {
						return error(-1, '此订单已完成核销！');
					}

					$lastverifys = $order['verifynum'] - $verifynum;
					if ($lastverifys < 0 && !empty($order['verifytype'])) {
						return error(-1, '此订单最多核销 ' . $order['verifynum'] . ' 次!');
					}
				}
			}

			if (!empty($saler['storeid'])) {
				if (0 < $merchid) {
					$store = pdo_fetch('select * from ' . tablename('ewei_shop_merch_store') . ' where id=:id and uniacid=:uniacid and merchid = :merchid limit 1', array(':id' => $saler['storeid'], ':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
				}
				else {
					$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $saler['storeid'], ':uniacid' => $_W['uniacid']));
				}
			}
		}

		$carrier = unserialize($order['carrier']);
		return array('order' => $order, 'store' => $store, 'saler' => $saler, 'lastverifys' => $lastverifys, 'goods' => $goods, 'verifyinfo' => $verifyinfo, 'carrier' => $carrier);
	}

	public function verify($orderid = 0, $times = 0, $verifycode = '', $openid = '')
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$current_time = time();

		if (empty($openid)) {
			$openid = $_W['openid'];
		}

		$data = $this->allow($orderid, $times, $openid);

		if (is_error($data)) {
			return NULL;
		}

		extract($data);
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . ' where id=:id and uniacid=:uniacid  limit 1', array(':id' => $orderid, ':uniacid' => $uniacid));

		if (!empty($order['refundid'])) {
			$refund = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order_refund') . ' where id=:id limit 1', array(':id' => $order['refundid']));

			if (!empty($refund)) {
				$time = time();
				pdo_update('ewei_shop_groups_order_refund', array('status' => -1, 'endtime' => $time), array('id' => $order['refundid']));
				pdo_update('ewei_shop_groups_order', array('refundstate' => 0), array('id' => $order['id']));
			}
		}

		if ($order['isverify']) {
			if ($order['verifytype'] == 0) {
				pdo_update('ewei_shop_groups_order', array('status' => 3, 'finishtime' => time(), 'sendtime' => $current_time), array('id' => $order['id']));
				$data = array('uniacid' => $uniacid, 'openid' => $order['openid'], 'orderid' => $orderid, 'verifycode' => $order['verifycode'], 'storeid' => $saler['storeid'], 'verifier' => $openid, 'isverify' => 1, 'verifytime' => time());
				pdo_insert('ewei_shop_groups_verify', $data);
			}
			else {
				if ($order['verifytype'] == 1) {
					if ($order['status'] != 3) {
						pdo_update('ewei_shop_groups_order', array('status' => 3, 'finishtime' => time(), 'sendtime' => $current_time), array('id' => $order['id']));
					}

					$verifyinfo = iunserializer($order['verifyinfo']);
					$i = 1;

					while ($i <= $times) {
						$data = array('uniacid' => $uniacid, 'openid' => $order['openid'], 'orderid' => $orderid, 'verifycode' => $order['verifycode'], 'storeid' => $saler['storeid'], 'verifier' => $openid, 'isverify' => 1, 'verifytime' => time());
						pdo_insert('ewei_shop_groups_verify', $data);
						++$i;
					}
				}
			}
		}

		return true;
	}

	public function tempData($type)
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' uniacid = :uniacid and type=:type ';
		$params = array(':uniacid' => $_W['uniacid'], ':type' => $type);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND expressname LIKE :expressname';
			$params[':expressname'] = '%' . trim($_GPC['keyword']) . '%';
		}

		$sql = 'SELECT id,expressname,expresscom,isdefault FROM ' . tablename('ewei_shop_exhelper_express') . (' where  1 and ' . $condition . ' ORDER BY isdefault desc, id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_exhelper_express') . (' where 1 and ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		return array('list' => $list, 'total' => $total, 'pager' => $pager, 'type' => $type);
	}

	public function setDefault($id, $type)
	{
		global $_W;
		$item = pdo_fetch('SELECT id,expressname,type FROM ' . tablename('ewei_shop_exhelper_express') . ' WHERE id=:id and type=:type AND uniacid=:uniacid', array(':id' => $id, ':type' => $type, ':uniacid' => $_W['uniacid']));

		if (!empty($item)) {
			pdo_update('ewei_shop_exhelper_express', array('isdefault' => 0), array('type' => $type, 'uniacid' => $_W['uniacid']));
			pdo_update('ewei_shop_exhelper_express', array('isdefault' => 1), array('id' => $id));

			if ($type == 1) {
				plog('exhelper.temp.express.setdefault', '设置默认快递单 ID: ' . $item['id'] . '， 模板名称: ' . $item['expressname'] . ' ');
			}
			else {
				if ($type == 2) {
					plog('exhelper.temp.invoice.setdefault', '设置默认发货单 ID: ' . $item['id'] . '， 模板名称: ' . $item['expressname'] . ' ');
				}
			}
		}
	}

	public function tempDelete($id, $type)
	{
		global $_W;
		$items = pdo_fetchall('SELECT id,expressname FROM ' . tablename('ewei_shop_exhelper_express') . (' WHERE id in( ' . $id . ' ) and type=:type and uniacid=:uniacid '), array(':type' => $type, ':uniacid' => $_W['uniacid']));

		foreach ($items as $item) {
			pdo_delete('ewei_shop_exhelper_express', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));

			if ($type == 1) {
				plog('groups.exhelper.expressdelete', '删除 快递助手 快递单模板 ID: ' . $item['id'] . '， 模板名称: ' . $item['expressname'] . ' ');
			}
			else {
				if ($type == 2) {
					plog('groups.exhelper.invoicedelete', '删除 快递助手 发货单模板 ID: ' . $item['id'] . '， 模板名称: ' . $item['expressname'] . ' ');
				}
			}
		}
	}

	public function getTemp()
	{
		global $_W;
		global $_GPC;
		$temp_sender = pdo_fetchall('SELECT id,isdefault,sendername,sendertel FROM ' . tablename('ewei_shop_exhelper_senduser') . ' WHERE uniacid=:uniacid order by isdefault desc ', array(':uniacid' => $_W['uniacid']));
		$temp_express = pdo_fetchall('SELECT id,type,isdefault,expressname FROM ' . tablename('ewei_shop_exhelper_express') . ' WHERE type=1 and uniacid=:uniacid order by isdefault desc ', array(':uniacid' => $_W['uniacid']));
		$temp_invoice = pdo_fetchall('SELECT id,type,isdefault,expressname FROM ' . tablename('ewei_shop_exhelper_express') . ' WHERE type=2 and uniacid=:uniacid order by isdefault desc ', array(':uniacid' => $_W['uniacid']));
		return array('temp_sender' => $temp_sender, 'temp_express' => $temp_express, 'temp_invoice' => $temp_invoice);
	}
}

?>
