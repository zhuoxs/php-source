<?php
class Notice_EweiShopV2Model
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

		if (strexists($url, '/core/task/order/')) {
			$url = str_replace('/core/task/order/', '/', $url);
		}

		return $url;
	}

	/**
     * 拼团发送订单通知
     * @param type $message_type
     * @param type $order
     */
	public function sendTeamMessage($orderid = '0', $delRefund = false)
	{
		global $_W;
		$orderid = intval($orderid);

		if (empty($orderid)) {
			return NULL;
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . ' where id=:id limit 1', array(':id' => $orderid));

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
		$goods = ' (单价: ¥' . $goodsprice . '元 数量: 1 总价: ¥' . $order['price'] . '元); ';
		$orderpricestr = ' ¥' . $price . '元 (包含运费: ¥' . $order['freight'] . '元，积分抵扣: ¥' . $order['creditmoney'] . '元)';
		$member = m('member')->getMember($openid);
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
			array('name' => '收货时间', 'value' => date('Y-m-d H:i', $order['finishtime']))
		);
		$usernotice = unserialize($member['noticeset']);

		if (!is_array($usernotice)) {
			$usernotice = array();
		}

		$set = $set = m('common')->getSysset();

		if (!empty($set)) {
			$shop = $set['shop'];

			if (!empty($shop)) {
				$shopname = $shop['name'];
			}
		}

		$tm = $set['notice'];

		if ($delRefund == true) {
			$refundtype = '';

			if ($order['pay_type'] == 'credit') {
				$refundtype = ', 已经退回您的余额账户，请留意查收！';
			}
			else if ($order['pay_type'] == 'wechat') {
				$refundtype = ', 已经退回您的对应支付渠道（如银行卡，微信钱包等, 具体到账时间请您查看微信支付通知)，请留意查收！';
			}
			else {
				$refundtype = ', 请联系客服进行退款事项！';
			}

			$msg = array(
				'first'    => array('value' => '您的订单已经完成退款！', 'color' => '#000000'),
				'keyword1' => array('title' => '退款金额', 'value' => '¥' . $price . '元', 'color' => '#000000'),
				'keyword2' => array('title' => '商品详情', 'value' => $goods . $orderpricestr, 'color' => '#000000'),
				'keyword3' => array('title' => '订单编号', 'value' => $order['orderno'], 'color' => '#000000'),
				'remark'   => array('value' => '退款金额 ¥' . $price . ($refundtype . '
 【') . $shopname . '】期待您再次购物！', 'color' => '#000000')
			);
			$this->sendGroupsNotice(array('openid' => $openid, 'tag' => 'groups_refund', 'default' => $msg, 'datas' => $datas));
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
						'first'    => array('value' => '您参加的拼团已经成功组团！', 'color' => '#000000'),
						'keyword1' => array('title' => '订单号', 'value' => $value['orderno'], 'color' => '#000000'),
						'keyword2' => array('title' => '时间', 'value' => date('Y-m-d H:i', $value['paytime']), 'color' => '#000000'),
						'keyword3' => array('title' => '商品', 'value' => $order_goods['title'], 'color' => '#000000'),
						'remark'   => array('value' => $remark, 'color' => '#000000')
					);
					$this->sendGroupsNotice(array('openid' => $value['openid'], 'tag' => 'groups_success', 'default' => $msg, 'datas' => $datas));
				}

				$tm = m('common')->getSysset('notice');
				$remarkteam = '拼团成功了，准备发货';

				if ($order['isverify']) {
					$remarkteam = '拼团成功了,买家购买的商品已经确认收货';
				}

				$msgteam = array(
					'first'    => array('value' => '拼团已经成功组团！', 'color' => '#000000'),
					'keyword1' => array('title' => '商品信息', 'value' => $goods, 'color' => '#000000'),
					'keyword2' => array('title' => '付款金额', 'value' => $orderpricestr, 'color' => '#000000'),
					'keyword3' => array('title' => '预计发货时间', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
					'remark'   => array('value' => $remarkteam, 'color' => '#000000')
				);
				$business = explode(',', $tm['openid']);

				foreach ($business as $value) {
					$this->sendGroupsNotice(array('openid' => $value, 'tag' => 'groups_teamsend', 'default' => $msgteam, 'datas' => $datas));
				}
			}
			else if ($order['success'] == -1) {
				$order = pdo_fetchall('select * from ' . tablename('ewei_shop_groups_order') . ' where teamid = :teamid and success = -1 and status = 1 ', array(':teamid' => $order['teamid']));
				$remark = '很抱歉，您所在的拼团为能成功组团，系统会在24小时之内自动退款。如有疑问请联系卖家，谢谢您的参与！';
				$msg = array(
					'first'    => array('value' => '您参加的拼团组团失败！', 'color' => '#000000'),
					'keyword1' => array('title' => '店铺', 'value' => $shopname, 'color' => '#000000'),
					'keyword2' => array('title' => '通知时间', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
					'keyword3' => array('title' => '商品', 'value' => $order_goods['title'], 'color' => '#000000'),
					'remark'   => array('value' => $remark, 'color' => '#000000')
				);

				foreach ($order as $key => $value) {
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
						'first'    => array('value' => '您的订单已提交成功！', 'color' => '#000000'),
						'keyword1' => array('title' => '店铺', 'value' => $shopname, 'color' => '#000000'),
						'keyword2' => array('title' => '下单时间', 'value' => date('Y-m-d H:i:s', $order['createtime']), 'color' => '#000000'),
						'keyword3' => array('title' => '商品', 'value' => $goods, 'color' => '#000000'),
						'keyword4' => array('title' => '金额', 'value' => $orderpricestr, 'color' => '#000000'),
						'remark'   => array('value' => $remark, 'color' => '#000000')
					);
					$this->sendGroupsNotice(array('openid' => $openid, 'tag' => 'groups_pay', 'default' => $msg, 'url' => $url, 'datas' => $datas));

					if (!$order['is_team']) {
						$tm = m('common')->getSysset('notice');
						$remarkteam = '单购订单成功了，准备发货';
						$msgteam = array(
							'first'    => array('value' => '单购订单成功了！', 'color' => '#000000'),
							'keyword1' => array('title' => '商品信息', 'value' => $goods, 'color' => '#000000'),
							'keyword2' => array('title' => '付款金额', 'value' => $orderpricestr, 'color' => '#000000'),
							'keyword3' => array('title' => '预计发货时间', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
							'remark'   => array('value' => $remarkteam, 'color' => '#000000')
						);
						$business = explode(',', $tm['openid']);

						foreach ($business as $value) {
							$this->sendGroupsNotice(array('openid' => $value, 'tag' => 'groups_teamsend', 'default' => $msgteam, 'datas' => $datas));
						}
					}
				}
			}
		}
		else {
			if ($order['status'] == 2) {
				if (!empty($order['addressid'])) {
					$remark = '您的订单已发货，请注意查收！';
				}

				$msg = array(
					'first'    => array('value' => '您的订单已发货！', 'color' => '#000000'),
					'keyword1' => array('title' => '店铺', 'value' => $shopname, 'color' => '#000000'),
					'keyword2' => array('title' => '发货时间', 'value' => date('Y-m-d H:i:s', $order['sendtime']), 'color' => '#000000'),
					'keyword3' => array('title' => '商品', 'value' => $order_goods['title'], 'color' => '#000000'),
					'keyword4' => array('title' => '快递公司', 'value' => $order['expresscom'], 'color' => '#000000'),
					'keyword5' => array('title' => '快递单号', 'value' => $order['expresssn'], 'color' => '#000000'),
					'remark'   => array('value' => $remark, 'color' => '#000000')
				);
				$this->sendGroupsNotice(array('openid' => $openid, 'tag' => 'groups_send', 'default' => $msg, 'datas' => $datas));
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

	/**
     * 订单即将关闭通知
     * @param type $message_type
     * @param type $order
     */
	public function sendOrderWillCancelMessage($orderid = '0', $closedaytimes)
	{
		global $_W;
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id limit 1', array(':id' => $orderid));

		if (empty($order)) {
			return NULL;
		}

		$openid = $order['openid'];
		$url = $this->getUrl('order/detail', array('id' => $orderid));
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

		$order_goods = pdo_fetchall('select g.id,g.title,og.realprice,og.total,og.price,og.optionname as optiontitle,g.noticeopenid,g.noticetype from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . (' where ' . $scondition . ' and og.uniacid=:uniacid '), $param);
		$goods = '';
		$goodsname = '';
		$goodsnum = 0;

		foreach ($order_goods as $og) {
			$goods .= '

' . $og['title'] . '( ';

			if (!empty($og['optiontitle'])) {
				$goods .= ' 规格: ' . $og['optiontitle'];
			}

			$goods .= ' 单价: ' . round($og['realprice'] / $og['total'], 2) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['realprice'] . '); ';
			$goodsname .= $og['title'] . ' 

';
			$goodsnum += $og['total'];
		}

		$orderpricestr = ' 订单总价: ' . $order['price'] . '(包含运费:' . $order['dispatchprice'] . ')';
		$member = m('member')->getMember($openid);
		$carrier = false;
		$store = false;

		if (!empty($order['storeid'])) {
			if (0 < $order['merchid']) {
				$store = pdo_fetch('select * from ' . tablename('ewei_shop_merch_store') . ' where id=:id and uniacid=:uniacid and merchid = :merchid limit 1', array(':id' => $order['storeid'], ':uniacid' => $_W['uniacid'], ':merchid' => $order['merchid']));
			}
			else {
				$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $order['storeid'], ':uniacid' => $_W['uniacid']));
			}
		}

		$buyerinfo = '';
		$buyerinfo_name = '';
		$buyerinfo_mobile = '';
		$addressinfo = '';

		if (!empty($order['address'])) {
			$address = iunserializer($order['address_send']);
			if (is_array($address) && empty($address) || !is_array($address)) {
				$address = iunserializer($order['address']);
				if (is_array($address) && empty($address) || !is_array($address)) {
					$address = pdo_fetch('select id,realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $order['addressid'], ':uniacid' => $_W['uniacid']));
				}
			}

			if (!empty($address)) {
				$addressinfo = $address['province'] . $address['city'] . $address['area'] . ' ' . $address['address'];
				$buyerinfo = '收件人: ' . $address['realname'] . '
联系电话: ' . $address['mobile'] . '
收货地址: ' . $addressinfo;
				$buyerinfo_name = $address['realname'];
				$buyerinfo_mobile = $address['mobile'];
			}
		}
		else {
			$carrier = iunserializer($order['carrier']);
			if (is_array($carrier) && !empty($carrier)) {
				$buyerinfo = '联系人: ' . $carrier['carrier_realname'] . '
联系电话: ' . $carrier['carrier_mobile'];
				$buyerinfo_name = $carrier['carrier_realname'];
				$buyerinfo_mobile = $carrier['carrier_mobile'];
			}
		}

		$datas = array(
			array('name' => '商城名称', 'value' => $_W['shopset']['shop']['name']),
			array('name' => '粉丝昵称', 'value' => $member['nickname']),
			array('name' => '订单号', 'value' => $order['ordersn']),
			array('name' => '订单金额', 'value' => $order['price']),
			array('name' => '运费', 'value' => $order['dispatchprice']),
			array('name' => '商品详情', 'value' => $goods),
			array('name' => '快递公司', 'value' => $order['expresscom']),
			array('name' => '快递单号', 'value' => $order['expresssn']),
			array('name' => '购买者姓名', 'value' => $buyerinfo_name),
			array('name' => '购买者电话', 'value' => $buyerinfo_mobile),
			array('name' => '收货地址', 'value' => $addressinfo),
			array('name' => '下单时间', 'value' => date('Y-m-d H:i', $order['createtime'])),
			array('name' => '支付时间', 'value' => date('Y-m-d H:i', $order['paytime'])),
			array('name' => '发货时间', 'value' => date('Y-m-d H:i', $order['sendtime'])),
			array('name' => '收货时间', 'value' => date('Y-m-d H:i', $order['finishtime'])),
			array('name' => '取消时间', 'value' => date('Y-m-d H:i', intval($order['createtime']) + $closedaytimes)),
			array('name' => '门店', 'value' => !empty($store) ? $store['storename'] : ''),
			array('name' => '门店地址', 'value' => !empty($store) ? $store['address'] : ''),
			array('name' => '门店联系人', 'value' => !empty($store) ? $store['realname'] . '/' . $store['mobile'] : ''),
			array('name' => '门店营业时间', 'value' => !empty($store) ? (empty($store['saletime']) ? '全天' : $store['saletime']) : ''),
			array('name' => '虚拟物品自动发货内容', 'value' => $order['virtualsend_info']),
			array('name' => '虚拟卡密自动发货内容', 'value' => $order['virtual_str']),
			array('name' => '自提码', 'value' => $order['verifycode']),
			array('name' => '备注信息', 'value' => $order['remark']),
			array('name' => '商品数量', 'value' => $goodsnum),
			array('name' => '商品名称', 'value' => $goodsname),
			array('name' => '积分剩余', 'value' => $member['credit1']),
			array('name' => '余额剩余', 'value' => $member['credit2']),
			array('name' => '积分获得时间', 'value' => date('Y-m-d H:i', time()))
		);
		$usernotice = unserialize($member['noticeset']);

		if (!is_array($usernotice)) {
			$usernotice = array();
		}

		$set = m('common')->getSysset();

		if (!empty($set)) {
			$shop = $set['shop'];

			if (!empty($shop)) {
				$shopname = $shop['name'];
			}
		}

		$tm = $set['notice'];
		if (!empty($order['merchid']) && p('merch')) {
			$merch_tm = p('merch')->getSet('notice', $order['merchid']);
			$tm['openid'] = $merch_tm['openid'];
		}

		if ($order['status'] == 0) {
			if (!empty($usernotice['willcancel'])) {
				return NULL;
			}

			pdo_update('ewei_shop_order', array('willcancelmessage' => 1), array('id' => $orderid));
			$remark = '，或<a href=\'' . $url . '\'>点击查看详情</a>';
			$text = '您好，您的订单处于未付款状态，即将关闭，请及时支付!

商品名称：' . substr_replace(str_replace('

', '
', $goodsname), '', strrpos($goodsname, '
'), strlen('
')) . '
订单编号：
[订单号]
订单金额：[订单金额]
下单时间：[下单时间]
关闭时间：[取消时间]

感谢您的关注，如有疑问请联系在线客服咨询' . $remark;
			$msg = array(
				'first'    => array('value' => '您好，您的订单处于未付款状态，即将关闭，请及时支付!
', 'color' => '#ff0000'),
				'keyword1' => array('title' => '订单商品', 'value' => substr_replace(str_replace('

', '
', $goodsname), '', strrpos($goodsname, '
'), strlen('
')), 'color' => '#000000'),
				'keyword2' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
				'keyword3' => array('title' => '下单时间', 'value' => date('Y-m-d H:i', $order['createtime']), 'color' => '#000000'),
				'keyword4' => array('title' => '订单金额', 'value' => $order['price'], 'color' => '#000000'),
				'keyword5' => array('title' => '关闭时间', 'value' => date('Y-m-d H:i', intval($order['createtime']) + $closedaytimes), 'color' => '#000000'),
				'remark'   => array('value' => '
感谢您关注，如有疑问请联系在线客服或点击查看详情！', 'color' => '#000000')
			);
			$this->sendNotice(array('openid' => $openid, 'tag' => 'willcancel', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'mobile' => $buyerinfo_mobile));
			com_run('sms::callsms', array('tag' => 'willcancel', 'datas' => $datas, 'mobile' => $member['mobile']));
		}
	}

	/**
     * 发送订单通知
     * @param type $message_type
     * @param type $order
     * @param type $raid 退回地址id
     */
	public function sendOrderMessage($orderid = '0', $delRefund = false, $raid = NULL)
	{
		global $_W;

		if (empty($orderid)) {
			return NULL;
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id limit 1', array(':id' => $orderid));

		if (empty($order)) {
			return NULL;
		}

		$is_merch = 0;
		$openid = $order['openid'];
		$url = $this->getUrl('order/detail', array('id' => $orderid, 'isshow' => 1));

		if (strpos($openid, 'sns_wa') !== false) {
			$appurl = '/pages/order/detail/index?id=' . $orderid;
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

		$order_goods = pdo_fetchall('select g.id,g.title,og.realprice,og.total,og.price,og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.sendtype,og.expresscom,og.expresssn,og.sendtime from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . (' where ' . $scondition . ' and og.uniacid=:uniacid '), $param);
		$goods = '';
		$goodsname = '';
		$goodsnum = 0;

		foreach ($order_goods as $og) {
			$goods .= '

' . $og['title'] . '( ';

			if (!empty($og['optiontitle'])) {
				$goods .= ' 规格: ' . $og['optiontitle'];
			}

			$goods .= ' 单价: ' . round($og['realprice'] / $og['total'], 2) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['realprice'] . '); ';
			$goodsname .= $og['title'] . ' 

';
			$goodsnum += $og['total'];
		}

		$couponstr = '';
		if (0 < $order['couponid'] && $order['couponprice']) {
			$couponstr = ' 优惠券抵扣 ' . price_format($order['couponprice'], 2) . '元 
';
		}

		$orderpricestr = ' 订单总价: ' . $order['price'] . '(包含运费:' . $order['dispatchprice'] . ')';
		$member = m('member')->getMember($openid);
		$carrier = false;
		$store = false;

		if (!empty($order['storeid'])) {
			if (0 < $order['merchid']) {
				$store = pdo_fetch('select * from ' . tablename('ewei_shop_merch_store') . ' where id=:id and uniacid=:uniacid and merchid = :merchid limit 1', array(':id' => $order['storeid'], ':uniacid' => $_W['uniacid'], ':merchid' => $order['merchid']));
			}
			else {
				$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $order['storeid'], ':uniacid' => $_W['uniacid']));
			}
		}

		$buyerinfo = '';
		$buyerinfo_name = '';
		$buyerinfo_mobile = '';
		$addressinfo = '';

		if (!empty($order['address'])) {
			$address = iunserializer($order['address_send']);
			if (is_array($address) && empty($address) || !is_array($address)) {
				$address = iunserializer($order['address']);
				if (is_array($address) && empty($address) || !is_array($address)) {
					$address = pdo_fetch('select id,realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $order['addressid'], ':uniacid' => $_W['uniacid']));
				}
			}

			if (!empty($address)) {
				$addressinfo = $address['province'] . $address['city'] . $address['area'] . $address['street'] . ' ' . $address['address'];
				$buyerinfo = '收件人: ' . $address['realname'] . '
联系电话: ' . $address['mobile'] . '
收货地址: ' . $addressinfo;
				$buyerinfo_name = $address['realname'];
				$buyerinfo_mobile = $address['mobile'];
			}
		}
		else {
			$carrier = iunserializer($order['carrier']);
			if (is_array($carrier) && !empty($carrier)) {
				$buyerinfo = '联系人: ' . $carrier['carrier_realname'] . '
联系电话: ' . $carrier['carrier_mobile'];
				$buyerinfo_name = $carrier['carrier_realname'];
				$buyerinfo_mobile = $carrier['carrier_mobile'];
			}
		}

		$_W['shopset'] = m('common')->getSysset();
		if (!empty($order['virtual']) && empty($order['virtual_str'])) {
			$open_redis = function_exists('redis') && !is_error(redis());

			if ($open_redis) {
				$redis = redis();
				$virtual_str = $redis->get($order['id'] . '_virtual_str');

				if (!empty($virtual_str)) {
					$order['virtual_str'] = $virtual_str;
				}
			}
		}

		$datas = array(
			array('name' => '商城名称', 'value' => $_W['shopset']['shop']['name']),
			array('name' => '粉丝昵称', 'value' => $member['nickname']),
			array('name' => '订单号', 'value' => $order['ordersn']),
			array('name' => '订单编号', 'value' => $order['ordersn']),
			array('name' => '订单金额', 'value' => $order['price']),
			array('name' => '运费', 'value' => $order['dispatchprice']),
			array('name' => '商品详情', 'value' => $goods),
			array('name' => '快递公司', 'value' => $order['expresscom']),
			array('name' => '快递单号', 'value' => $order['expresssn']),
			array('name' => '购买者姓名', 'value' => $buyerinfo_name),
			array('name' => '购买者电话', 'value' => $buyerinfo_mobile),
			array('name' => '收货地址', 'value' => $addressinfo),
			array('name' => '下单时间', 'value' => date('Y-m-d H:i', $order['createtime'])),
			'支付时间' => array('name' => '支付时间', 'value' => date('Y-m-d H:i', $order['paytime'])),
			array('name' => '发货时间', 'value' => date('Y-m-d H:i', $order['sendtime'])),
			array('name' => '收货时间', 'value' => date('Y-m-d H:i', $order['finishtime'])),
			array('name' => '取消时间', 'value' => date('Y-m-d H:i', $order['canceltime'])),
			array('name' => '门店', 'value' => !empty($store) ? $store['storename'] : ''),
			array('name' => '门店地址', 'value' => !empty($store) ? $store['address'] : ''),
			array('name' => '门店联系人', 'value' => !empty($store) ? $store['realname'] . '/' . $store['mobile'] : ''),
			array('name' => '门店营业时间', 'value' => !empty($store) ? (empty($store['saletime']) ? '全天' : $store['saletime']) : ''),
			array('name' => '虚拟物品自动发货内容', 'value' => $order['virtualsend_info']),
			array('name' => '虚拟卡密自动发货内容', 'value' => $order['virtual_str']),
			array('name' => '自提码', 'value' => $order['verifycode']),
			array('name' => '备注信息', 'value' => $order['remark']),
			array('name' => '商品数量', 'value' => $goodsnum),
			array('name' => '商品名称', 'value' => $goodsname),
			array('name' => '积分剩余', 'value' => $member['credit1']),
			array('name' => '余额剩余', 'value' => $member['credit2']),
			array('name' => '积分获得时间', 'value' => date('Y-m-d H:i', time()))
		);
		$usernotice = unserialize($member['noticeset']);

		if (!is_array($usernotice)) {
			$usernotice = array();
		}

		$set = m('common')->getSysset();

		if (!empty($set)) {
			$shop = $set['shop'];

			if (!empty($shop)) {
				$shopname = $shop['name'];
			}
		}

		$tm = $set['notice'];
		if (!empty($order['merchid']) && p('merch')) {
			$is_merch = 1;
			$merch_tm = p('merch')->getSet('notice', $order['merchid']);
		}

		if ($delRefund) {
			$r_type = array('退款', '退货退款', '换货');

			if (!empty($order['refundid'])) {
				$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $order['refundid']));

				if (empty($refund)) {
					return NULL;
				}

				$datas[] = array('name' => '售后类型', 'value' => $r_type[$refund['rtype']]);
				$datas[] = array('name' => '申请金额', 'value' => $refund['rtype'] == 2 ? '-' : $refund['applyprice']);
				$datas[] = array('name' => '退款金额', 'value' => $refund['price']);
				$datas[] = array('name' => '换货快递公司', 'value' => $refund['rexpresscom']);
				$datas[] = array('name' => '换货快递单号', 'value' => $refund['rexpresssn']);

				if ($refund['status'] == 0) {
					$is_send = 0;

					if (empty($is_merch)) {
						if (empty($usernotice['saler_refund'])) {
							$is_send = 1;
						}
					}
					else {
						if (!empty($merch_tm) && empty($merch_tm['saler_refund_close_advanced'])) {
							$is_send = 1;
							$tm['openid'] = $merch_tm['openid'];
						}
					}

					if (!empty($is_send)) {
						$remark2 = '订单编号:' . $order['ordersn'] . '
商品名称:' . $goods . '
商品数量:' . $goodsnum . '
支付金额:' . $order['price'];
						$msg = array(
							'first'    => array('value' => '您有订单于' . date('Y-m-d H:i', $order['paytime']) . '申请维权！！
请登录后台查看维权详情。', 'color' => '#ff0000'),
							'keyword2' => array('title' => '处理进度', 'value' => $r_type[$refund['rtype']] . '申请', 'color' => '#000000'),
							'keyword3' => array('title' => '处理内容', 'value' => '维权申请通知', 'color' => '#4b9528'),
							'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
							'remark'   => array('value' => $remark2, 'color' => '#000000')
						);

						if ($order['paytype'] == 3) {
							$text = '您有一条维权订单信息！！
请及时处理。

订单号：
[订单号]
订单金额：[订单金额]
---------------------
购买商品信息：[商品详情]
备注信息：[备注信息]
---------------------
收货人：[购买者姓名]
收货人电话:[购买者电话]
收货地址:[收货地址]

请及时处理';
						}
						else {
							$text = '您有一条维权订单信息！！
请及时处理。

订单号：
[订单号]
订单金额：[订单金额]
支付时间：[支付时间]
---------------------
购买商品信息：[商品详情]
备注信息：[备注信息]
---------------------
收货人：[购买者姓名]
收货人电话:[购买者电话]
收货地址:[收货地址]

请及时处理';
						}

						$account = m('common')->getAccount();

						if (!empty($tm['openid4'])) {
							$openids = explode(',', $tm['openid4']);

							foreach ($openids as $tmopenid) {
								if (empty($tmopenid)) {
									continue;
								}

								$this->sendNotice(array('openid' => $tmopenid, 'tag' => 'saler_refund', 'default' => $msg, 'cusdefault' => $text, 'datas' => $datas, 'is_merch' => $is_merch, 'merch_tm' => $merch_tm));
							}
						}
					}

					if (!empty($tm['mobile']) && empty($tm['saler_refund_close_sms']) && empty($is_merch)) {
						$mobiles = explode(',', $tm['mobile']);

						foreach ($mobiles as $mobile) {
							if (empty($mobile)) {
								continue;
							}

							com_run('sms::callsms', array('tag' => 'saler_refund', 'datas' => $datas, 'mobile' => $mobile));
						}
					}
				}
				else if ($refund['status'] == 5) {
					if ($refund['rtype'] == 2) {
						if (empty($address)) {
							return NULL;
						}

						$remark = '<a href=\'' . $url . '\'>点击快速查询物流信息</a>';
						$text = '您申请换货的宝贝已经成功发货，请注意查收 

订单编号：
[订单号]
快递公司：[换货快递公司]
快递单号：[换货快递单号]

' . $remark;
						$msg = array(
							'first'    => array('value' => '您申请换货的宝贝已经成功发货，请注意查收！
', 'color' => '#ff0000'),
							'keyword1' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
							'keyword2' => array('title' => '快递公司', 'value' => $refund['rexpresscom'], 'color' => '#000000'),
							'keyword3' => array('title' => '快递单号', 'value' => $refund['rexpresssn'], 'color' => '#000000'),
							'remark'   => array('value' => '
点击快速查询物流信息', 'color' => '#000000')
						);
						$this->sendNotice(array('openid' => $openid, 'tag' => 'refund4', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'appurl' => $appurl));
						com_run('sms::callsms', array('tag' => 'refund4', 'datas' => $datas, 'mobile' => $member['mobile']));
					}
				}
				else if ($refund['status'] == 3) {
					if ($refund['rtype'] == 2 || $refund['rtype'] == 1) {
						if (0 < $order['merchid']) {
							$raddress = iunserializer($refund['refundaddress']);

							if (!empty($raddress)) {
								$datas[] = array('name' => '卖家收货地址', 'value' => $raddress['province'] . $raddress['city'] . $raddress['area'] . ' ' . $raddress['address']);
								$datas[] = array('name' => '卖家联系电话', 'value' => $raddress['mobile']);
								$datas[] = array('name' => '卖家收货人', 'value' => $raddress['name']);
							}
						}
						else {
							if (empty($raid)) {
								$salerefund = pdo_fetch('select * from ' . tablename('ewei_shop_refund_address') . ' where uniacid=:uniacid and isdefault=1 limit 1', array(':uniacid' => $_W['uniacid']));
							}
							else {
								$salerefund = pdo_fetch('select * from ' . tablename('ewei_shop_refund_address') . ' where uniacid=:uniacid and id=' . $raid . ' limit 1', array(':uniacid' => $_W['uniacid']));
							}

							$datas[] = array('name' => '卖家收货地址', 'value' => $salerefund['province'] . $salerefund['city'] . $salerefund['area'] . ' ' . $salerefund['address']);
							$datas[] = array('name' => '卖家联系电话', 'value' => $salerefund['mobile']);
							$datas[] = array('name' => '卖家收货人', 'value' => $salerefund['name']);
						}

						if (!empty($usernotice['refund3'])) {
							return NULL;
						}

						$text = '您好，您的退换货申请已经通过，请您及时发送快递。

申请退换货订单号：
[订单号]
请将快递发送到以下地址，并随包裹填写您的订单编号以及联系方式，我们将尽快为您处理
邮寄地址：[卖家收货地址]
联系电话：[卖家联系电话]
收货人：[卖家收货人]

感谢您关注，如有疑问请联系在线客服或<a href=\'' . $url . '\'>点击查看详情</a>';
						$remark2 = '请将快递发送到以下地址，并随包裹填写您的订单编号以及联系方式，我们将尽快为您处理

邮寄地址：' . $salerefund['province'] . $salerefund['city'] . $salerefund['area'] . ' ' . $salerefund['address'] . '
联系电话：' . $salerefund['mobile'] . '
收货人：' . $salerefund['name'] . '

感谢您关注，如有疑问请联系在线客服或点击查看详情';
						$msg = array(
							'first'    => array('value' => '您好，您的退换货申请已经通过，请您及时发送快递。
', 'color' => '#ff0000'),
							'keyword2' => array('title' => '处理进度', 'value' => '退换货申请', 'color' => '#000000'),
							'keyword3' => array('title' => '处理内容', 'value' => '退换货通过', 'color' => '#4b9528'),
							'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
							'remark'   => array('value' => $remark2, 'color' => '#000000')
						);
						$this->sendNotice(array('openid' => $openid, 'tag' => 'refund3', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'appurl' => $appurl));
						com_run('sms::callsms', array('tag' => 'refund3', 'datas' => $datas, 'mobile' => $member['mobile']));
					}
				}
				else if ($refund['status'] == 1) {
					if ($refund['rtype'] == 0 || $refund['rtype'] == 1) {
						if (!empty($usernotice['refund1'])) {
							return NULL;
						}

						$refundtype = '';

						if (empty($refund['refundtype'])) {
							$refundtype = '余额账户';
						}
						else if ($refund['refundtype'] == 1) {
							$refundtype = '您的对应支付渠道（如银行卡，微信钱包等, 具体到账时间请您查看微信支付通知)';
						}
						else {
							$refundtype = ' 请联系客服进行退款事项！';
						}

						$text = '您好，您有一笔退款已经成功，[退款金额].元已经退回您的申请退款账户内，请及时查看 。

订单编号：
[订单号]
退款金额：[退款金额]元
退款原因：[售后类型]
退款去向：' . $refundtype . '

感谢您关注，如有疑问请联系在线客服或<a href=\'' . $url . '\'>点击查看详情</a>';
						$msg = array(
							'first'             => array('value' => '您好，您有一笔退款已经成功，' . $refund['price'] . '元已经退回您的申请退款账户内，请及时查看 。', 'color' => '#ff0000'),
							'orderProductPrice' => array('title' => '退款金额', 'value' => $refund['price'] . '元', 'color' => '#000000'),
							'orderProductName'  => array('title' => '商品名称', 'value' => str_replace('
', '', $goodsname), 'color' => '#000000'),
							'orderName'         => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
							'remark'            => array('value' => '
感谢您关注，如有疑问请联系在线客服或点击查看详情', 'color' => '#000000')
						);
						$this->sendNotice(array('openid' => $openid, 'tag' => 'refund1', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'appurl' => $appurl));
						com_run('sms::callsms', array('tag' => 'refund1', 'datas' => $datas, 'mobile' => $member['mobile']));
					}
				}
				else {
					if ($refund['status'] == -1) {
						if (!empty($usernotice['refund2'])) {
							return NULL;
						}

						$remark = '
感谢您关注，如有疑问请联系在线客服或<a href=\'' . $url . '\'>点击查看详情</a>';
						$text = '您好，你那有一笔' . $r_type[$refund['rtype']] . '被驳回，您可以与我们取得联系！

退款金额：[申请金额]元
订单编号：
[订单号]
' . $remark;
						$remark2 = '商品详情：' . substr_replace(str_replace('

', '
', $goodsname), '', strrpos($goodsname, '
'), strlen('
')) . '订单编号：' . $order['ordersn'] . '
退款金额：' . ($refund['rtype'] == 2 ? '-' : $refund['applyprice']) . '元' . '

感谢您关注，如有疑问请联系在线客服或点击查看详情';
						$msg = array(
							'first'    => array('value' => '您好，你有一笔' . $r_type[$refund['rtype']] . '被驳回，您可以与我们取得联系！
', 'color' => '#ff0000'),
							'keyword2' => array('title' => '处理进度', 'value' => '退换货申请', 'color' => '#000000'),
							'keyword3' => array('title' => '处理内容', 'value' => '驳回通知', 'color' => '#ff0000'),
							'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
							'remark'   => array('value' => $remark2, 'color' => '#000000')
						);
						$this->sendNotice(array('openid' => $openid, 'tag' => 'refund2', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'mobile' => $buyerinfo_mobile, 'appurl' => $appurl));
						com_run('sms::callsms', array('tag' => 'refund2', 'datas' => $datas, 'mobile' => $member['mobile']));
					}
				}
			}

			return NULL;
		}

		if ($order['status'] == -1) {
			if (!empty($usernotice['cancel'])) {
				return NULL;
			}

			$remark = '，或<a href=\'' . $url . '\'>点击查看详情</a>';
			$text = '您好，您的订单由于主动取消或长时间未付款已经关闭！！！

商品名称：' . substr_replace($goodsname, '', strrpos($goodsname, '

'), strlen('

')) . '
订单编号：
[订单号]
订单金额：[订单金额]
下单时间：[下单时间]
关闭时间：[取消时间]

感谢您的关注，如有疑问请联系在线客服咨询' . $remark;
			$msg = array(
				'first'    => array('value' => '您好，您的订单由于主动取消或长时间未付款已经关闭！！！', 'color' => '#ff0000'),
				'keyword1' => array('title' => '订单商品', 'value' => substr_replace($goodsname, '', strrpos($goodsname, '

'), strlen('

')), 'color' => '#000000'),
				'keyword2' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
				'keyword3' => array('title' => '下单时间', 'value' => date('Y-m-d H:i', $order['createtime']), 'color' => '#000000'),
				'keyword4' => array('title' => '订单金额', 'value' => $order['price'], 'color' => '#000000'),
				'keyword5' => array('title' => '关闭时间', 'value' => date('Y-m-d H:i', $order['canceltime']), 'color' => '#000000'),
				'remark'   => array('value' => '
感谢您关注，如有疑问请联系在线客服或点击查看详情！', 'color' => '#000000')
			);
			$this->sendNotice(array('openid' => $openid, 'tag' => 'cancel', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'mobile' => $buyerinfo_mobile, 'appurl' => $appurl));
			com_run('sms::callsms', array('tag' => 'cancel', 'datas' => $datas, 'mobile' => $member['mobile']));
		}
		else {
			if ($order['status'] == 0 && $order['paytype'] == 3) {
				$datas['支付时间'] = array('name' => '支付时间', 'value' => '货到付款订单,尚未支付');
				$is_send = 0;

				if (empty($is_merch)) {
					if (empty($usernotice['saler_pay'])) {
						$is_send = 1;
					}
				}
				else {
					if (!empty($merch_tm) && empty($merch_tm['saler_pay_close_advanced'])) {
						$is_send = 1;
						$tm['openid'] = $merch_tm['openid'];
					}
				}

				if (!empty($is_send)) {
					$msg = array(
						'first'    => array('value' => '您有新的货到付款订单于' . date('Y-m-d H:i', $order['createtime']) . '已下单！！
请登录后台查看详情并及时安排发货。', 'color' => '#ff0000'),
						'keyword1' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
						'keyword2' => array('title' => '商品名称', 'value' => $goods, 'color' => '#000000'),
						'keyword3' => array('title' => '商品数量', 'value' => $goodsnum, 'color' => '#000000'),
						'keyword4' => array('title' => '支付金额', 'value' => $order['price'], 'color' => '#000000')
					);
					$text = '您有新的货到付款订单！！
请及时安排发货。

订单号：
[订单号]
订单金额：[订单金额]
下单时间：[下单时间]
---------------------
购买商品信息：[商品详情]
备注信息：[备注信息]
---------------------
收货人：[购买者姓名]
收货人电话:[购买者电话]
收货地址:[收货地址]

请及时安排发货';
					$msgbuy = array(
						'first'    => array('value' => '您的货到付款订单于' . date('Y-m-d H:i', $order['createtime']) . '已成功下单！！', 'color' => '#ff0000'),
						'keyword1' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
						'keyword2' => array('title' => '商品名称', 'value' => $goods, 'color' => '#000000'),
						'keyword3' => array('title' => '商品数量', 'value' => $goodsnum, 'color' => '#000000'),
						'keyword4' => array('title' => '支付金额', 'value' => $order['price'], 'color' => '#000000')
					);
					$textbuy = '您的货到付款订单！！
已成功下单。

订单号：
[订单号]
订单金额：[订单金额]
下单时间：[下单时间]
---------------------
购买商品信息：[商品详情]
备注信息：[备注信息]
---------------------
收货人：[购买者姓名]
收货人电话:[购买者电话]
收货地址:[收货地址]

请保持电话畅通';
					$sendbuyData = array('openid' => $order['openid'], 'tag' => 'saler_pay', 'default' => $msgbuy, 'cusdefault' => $textbuy, 'datas' => $datas, 'is_merch' => $is_merch, 'merch_tm' => $merch_tm);
					$this->sendNotice($sendbuyData);
					$account = m('common')->getAccount();

					if (!empty($tm['openid'])) {
						$openids = explode(',', $tm['openid']);

						foreach ($openids as $tmopenid) {
							if (empty($tmopenid)) {
								continue;
							}

							$sendData = array('openid' => $tmopenid, 'tag' => 'saler_pay', 'default' => $msg, 'cusdefault' => $text, 'datas' => $datas, 'is_merch' => $is_merch, 'merch_tm' => $merch_tm);
							$open_redis = function_exists('redis') && !is_error(redis());

							if ($open_redis) {
								$notice_redis = m('common')->getSysset('notice_redis');

								if (!empty($notice_redis['notice_redis'])) {
									$sendData['is_send'] = 0;
									$sendData['send_underway'] = 0;
									$key = 'notice_uniacid' . $_W['uniacid'] . '_list';
									$redis = redis();
									$redis->rPush($key, serialize($sendData));
								}
								else {
									$this->sendNotice($sendData);
								}
							}
							else {
								$this->sendNotice($sendData);
							}
						}
					}
				}

				if (!empty($tm['mobile']) && empty($tm['saler_pay_close_sms']) && empty($is_merch)) {
					$mobiles = explode(',', $tm['mobile']);

					foreach ($mobiles as $mobile) {
						if (empty($mobile)) {
							continue;
						}

						com_run('sms::callsms', array('tag' => 'saler_pay', 'datas' => $datas, 'mobile' => $mobile));
					}
				}

				foreach ($order_goods as $og) {
					if (!empty($og['noticeopenid']) && !empty($og['noticetype'])) {
						$noticetype = explode(',', $og['noticetype']);
						if ($og['noticetype'] == '1' || is_array($noticetype) && in_array('1', $noticetype)) {
							$goodstr = $og['title'] . '( ';

							if (!empty($og['optiontitle'])) {
								$goodstr .= ' 规格: ' . $og['optiontitle'];
								$optiontitle = '( 规格: ' . $og['optiontitle'] . ')';
							}

							$goodstr .= ' 单价: ' . round($og['price'] / $og['total'], 2) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['price'] . '); ';
							$text = '您有新的货到付款订单！！
请及时安排发货。

订单号：
[订单号]
订单金额：[订单金额]
下单时间：[下单时间]
---------------------
购买商品信息：[单品详情]
备注信息：[备注信息]
---------------------
收货人：[购买者姓名]
收货人电话:[购买者电话]
收货地址:[收货地址]

请及时安排发货';
							$remark = '订单号：
' . $order['ordersn'] . '
商品详情：' . $goodstr . $couponstr;
							$msg = array(
								'first'    => array('value' => '您有新的货到付款订单于' . date('Y-m-d H:i', $order['createtime']) . '已下单！！
请登录后台查看详情并及时安排发货。
', 'color' => '#ff0000'),
								'keyword2' => array('title' => '处理进度', 'value' => '商品付款通知', 'color' => '#000000'),
								'keyword3' => array('title' => '处理内容', 'value' => '已付款', 'color' => '#000000'),
								'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
								'remark'   => array('value' => $remark, 'color' => '#000000')
							);
							$datas['gooddetail'] = array('name' => '单品详情', 'value' => $goodstr);
							$noticeopenids = explode(',', $og['noticeopenid']);

							foreach ($noticeopenids as $noticeopenid) {
								$this->sendNotice(array('openid' => $noticeopenid, 'tag' => 'saler_goodpay', 'cusdefault' => $text, 'default' => $msg, 'datas' => $datas));
							}
						}
					}
				}
			}
			else {
				if ($order['status'] == 1 && !empty($order['istrade'])) {
					$item = pdo_fetch('select og.trade_time,g.title,s.storename,s.mobile,p.nickname,s.id as storeid  from ' . tablename('ewei_shop_order_goods') . '  og
				 left join ' . tablename('ewei_shop_order') . ' o  on  og.orderid = o.id
				 left join ' . tablename('ewei_shop_goods') . ' g  on  og.goodsid = g.id
				 left join ' . tablename('ewei_shop_store') . ' s  on  o.storeid = s.id
				 left join ' . tablename('ewei_shop_newstore_people') . ' p  on  og.peopleid = p.id
				 where o.id =:id limit 1', array(':id' => $order['id']));
					$datas[] = array('name' => '预约商品名称', 'value' => $item['title']);
					$datas[] = array('name' => '预约时间', 'value' => date('Y-m-d H:i:s', $item['trade_time']));
					$datas[] = array('name' => '预约门店', 'value' => $item['storename']);
					$datas[] = array('name' => '技师名称', 'value' => $item['nickname']);
					$datas[] = array('name' => '门店联系电话', 'value' => $item['mobile']);
					$notice = m('common')->getSysset('notice', false);

					if (empty($notice['o2o_bnorder_close_advanced'])) {
						$url = $this->getUrl('newstore/norder/detail', array('id' => $order['id']));
						$text = '您已成功预约！
预约项目： [预约商品名称] 
预约时间：[预约时间] 
预约门店：[预约门店]
服务人：[技师名称]
联系电话：[门店联系电话]
为了完美的服务体验，请提前安排好您的时间，如您需要取消预约或修改预约时间,请拨打[门店联系电话]进行咨询！
<a href=\'' . $url . '\'>点击快速查询预约信息</a>';
						$msg = array(
							'first'    => array('value' => '您已成功预约！
', 'color' => '#ff0000'),
							'keyword1' => array('title' => '预约项目', 'value' => $item['title'], 'color' => '#000000'),
							'keyword2' => array('title' => '预约时间', 'value' => date('Y-m-d H:i:s', $item['trade_time']), 'color' => '#4b9528'),
							'remark'   => array('value' => '预约门店：' . $item['storename'] . '
服务人：' . $item['nickname'] . '
联系电话' . $item['mobile'] . '
为了完美的服务体验，请提前安排好您的时间，如您需要取消预约或修改预约时间,请拨打' . $item['mobile'] . '进行咨询！', 'color' => '#000000')
						);
						$this->sendNotice(array('openid' => $openid, 'tag' => 'o2o_bnorder', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas));
						com_run('sms::callsms', array('tag' => 'o2o_bverify', 'datas' => $datas, 'mobile' => $member['mobile']));
					}

					if (empty($notice['o2o_snorder_close_advanced'])) {
						$member = m('member')->getMember($openid);
						$datas[] = array('name' => '预约人姓名', 'value' => $member['nickname']);
						$datas[] = array('name' => '预约人联系电话', 'value' => $member['mobile']);
						$text = '您有一个新的预约！
预约项目： [预约商品名称] 
预约时间：[预约时间] 
预约门店：[预约门店]
服务人：[技师名称]
预约人：[技师名称]
联系电话：[预约人联系电话]
如有变动可登录管理后台进行操作！！';
						$msg = array(
							'first'    => array('value' => '您有一个新的预约！
', 'color' => '#ff0000'),
							'keyword1' => array('title' => '预约项目', 'value' => $item['title'], 'color' => '#000000'),
							'keyword2' => array('title' => '预约时间', 'value' => date('Y-m-d H:i:s', $item['trade_time']), 'color' => '#4b9528'),
							'remark'   => array('value' => '预约门店：' . $item['storename'] . '
服务人：' . $item['nickname'] . '
联系电话:' . $item['mobile'] . '
如有变动可登录管理后台进行操作！！', 'color' => '#000000')
						);
						$salers = pdo_fetchall('select *   from ' . tablename('ewei_shop_saler') . ' sr  inner join ' . tablename('ewei_shop_store') . ' s on s.id = sr.storeid  where  s.id=:id and sr.getnotice =1', array(':id' => $item['storeid']));

						foreach ($salers as $saler) {
							$this->sendNotice(array('openid' => $saler['openid'], 'tag' => 'o2o_snorder', 'default' => $msg, 'cusdefault' => $text, 'url' => '', 'datas' => $datas));
							com_run('sms::callsms', array('tag' => 'o2o_bverify', 'datas' => $datas, 'mobile' => $saler['mobile']));
						}
					}
				}
				else {
					if ($order['status'] == 1 && empty($order['sendtype']) || $order['status'] == 3 && $order['isvirtualsend'] == 1) {
						$is_send = 0;

						if (empty($is_merch)) {
							if (empty($usernotice['saler_pay'])) {
								$is_send = 1;
							}
						}
						else {
							if (!empty($merch_tm) && empty($merch_tm['saler_pay_close_advanced'])) {
								$is_send = 1;
								$tm['openid'] = $merch_tm['openid'];
							}
						}

						if (!empty($is_send)) {
							if ($order['isvirtualsend'] == 1) {
								$msg = array(
									'first'    => array('value' => '您有新的订单于' . date('Y-m-d H:i', $order['paytime']) . '已付款！！
请登录后台查看详情。', 'color' => '#ff0000'),
									'keyword1' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
									'keyword2' => array('title' => '商品名称', 'value' => $goods, 'color' => '#000000'),
									'keyword3' => array('title' => '商品数量', 'value' => $goodsnum, 'color' => '#000000'),
									'keyword4' => array('title' => '支付金额', 'value' => $order['price'], 'color' => '#000000')
								);
								$text = '您有新的已付款订单！！
请及时查看。

订单号：
[订单号]
订单金额：[订单金额]
支付时间：[支付时间]
---------------------
购买商品信息：[商品详情]
备注信息：[备注信息]
---------------------
收货人：[购买者姓名]
收货人电话:[购买者电话]
收货地址:[收货地址]

';
							}
							else if ($order['isverify']) {
								$msg = array(
									'first'    => array('value' => '您有新的订单于' . date('Y-m-d H:i', $order['paytime']) . '已付款！！
请登录后台查看详情。', 'color' => '#ff0000'),
									'keyword1' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
									'keyword2' => array('title' => '商品名称', 'value' => $goods, 'color' => '#000000'),
									'keyword3' => array('title' => '商品数量', 'value' => $goodsnum, 'color' => '#000000'),
									'keyword4' => array('title' => '支付金额', 'value' => $order['price'], 'color' => '#000000')
								);
								$text = '您有新的已付款订单！！
请及时处理。

订单号：
[订单号]
订单金额：[订单金额]
支付时间：[支付时间]
---------------------
购买商品信息：[商品详情]
备注信息：[备注信息]
---------------------
收货人：[购买者姓名]
收货人电话:[购买者电话]
收货地址:[收货地址]

请及时处理';
							}
							else {
								$msg = array(
									'first'    => array('value' => '您有新的订单于' . date('Y-m-d H:i', $order['paytime']) . '已付款！！
请登录后台查看详情并及时安排发货。', 'color' => '#ff0000'),
									'keyword1' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
									'keyword2' => array('title' => '商品名称', 'value' => $goods, 'color' => '#000000'),
									'keyword3' => array('title' => '商品数量', 'value' => $goodsnum, 'color' => '#000000'),
									'keyword4' => array('title' => '支付金额', 'value' => $order['price'], 'color' => '#000000')
								);
								$text = '您有新的已付款订单！！
请及时安排发货。

订单号：
[订单号]
订单金额：[订单金额]
支付时间：[支付时间]
---------------------
购买商品信息：[商品详情]
备注信息：[备注信息]
---------------------
收货人：[购买者姓名]
收货人电话:[购买者电话]
收货地址:[收货地址]

请及时安排发货';
							}

							$account = m('common')->getAccount();

							if (!empty($tm['openid'])) {
								$openids = explode(',', $tm['openid']);

								foreach ($openids as $tmopenid) {
									if (empty($tmopenid)) {
										continue;
									}

									$sendData = array('openid' => $tmopenid, 'tag' => 'saler_pay', 'default' => $msg, 'cusdefault' => $text, 'datas' => $datas, 'is_merch' => $is_merch, 'merch_tm' => $merch_tm);
									$open_redis = function_exists('redis') && !is_error(redis());

									if ($open_redis) {
										$notice_redis = m('common')->getSysset('notice_redis');

										if (!empty($notice_redis['notice_redis'])) {
											$sendData['is_send'] = 0;
											$sendData['send_underway'] = 0;
											$key = 'notice_uniacid' . $_W['uniacid'] . '_list';
											$redis = redis();
											$redis->rPush($key, serialize($sendData));
										}
										else {
											$this->sendNotice($sendData);
										}
									}
									else {
										$this->sendNotice($sendData);
									}
								}
							}
						}

						if (!empty($tm['mobile']) && empty($tm['saler_pay_close_sms']) && empty($is_merch)) {
							$mobiles = explode(',', $tm['mobile']);

							foreach ($mobiles as $mobile) {
								if (empty($mobile)) {
									continue;
								}

								com_run('sms::callsms', array('tag' => 'saler_pay', 'datas' => $datas, 'mobile' => $mobile));
							}
						}

						foreach ($order_goods as $og) {
							if (!empty($og['noticeopenid']) && !empty($og['noticetype'])) {
								$noticetype = explode(',', $og['noticetype']);
								if ($og['noticetype'] == '1' || is_array($noticetype) && in_array('1', $noticetype)) {
									$goodstr = $og['title'] . '( ';

									if (!empty($og['optiontitle'])) {
										$goodstr .= ' 规格: ' . $og['optiontitle'];
										$optiontitle = '( 规格: ' . $og['optiontitle'] . ')';
									}

									$goodstr .= ' 单价: ' . round($og['price'] / $og['total'], 2) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['price'] . '); ';
									$text = '您有新的已付款订单！！
请及时安排发货。

订单号：
[订单号]
订单金额：[订单金额]
支付时间：[支付时间]
---------------------
购买商品信息：[单品详情]
备注信息：[备注信息]
---------------------
收货人：[购买者姓名]
收货人电话:[购买者电话]
收货地址:[收货地址]

请及时安排发货';
									$remark = '订单号：
' . $order['ordersn'] . '
商品详情：' . $goodstr . $couponstr;
									$msg = array(
										'first'    => array('value' => '您有新的订单于' . date('Y-m-d H:i', $order['paytime']) . '已付款！！
请登录后台查看详情并及时安排发货。
', 'color' => '#ff0000'),
										'keyword2' => array('title' => '处理进度', 'value' => '商品付款通知', 'color' => '#000000'),
										'keyword3' => array('title' => '处理内容', 'value' => '已付款', 'color' => '#000000'),
										'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
										'remark'   => array('value' => $remark, 'color' => '#000000')
									);
									$datas['gooddetail'] = array('name' => '单品详情', 'value' => $goodstr);
									$noticeopenids = explode(',', $og['noticeopenid']);

									foreach ($noticeopenids as $noticeopenid) {
										$this->sendNotice(array('openid' => $noticeopenid, 'tag' => 'saler_goodpay', 'cusdefault' => $text, 'default' => $msg, 'datas' => $datas));
									}
								}
							}
						}

						if (empty($usernotice['pay'])) {
							$remark = '
';

							if ($order['isverify']) {
								$remark = '
点击订单详情查看可消费门店, 【' . $shopname . '】欢迎您的再次购物！
';
								$cusurl = '<a href=\'' . $url . '\'>点击查看详情</a>';
								$text = '您的订单已经成功支付 

订单号：
[订单号]
商品名称：
[商品名称]
商品数量：[商品数量]
下单时间：[下单时间]
订单金额：[订单金额]
' . $couponstr . $remark . $cusurl;
							}
							else if ($order['dispatchtype']) {
								$remark = '
您可以到选择的自提点进行取货了,【' . $shopname . '】欢迎您的再次购物！
';
								$cusurl = '<a href=\'' . $url . '\'>点击查看详情</a>';
								$text = '您的订单已经成功支付，我们将尽快为您安排发货！！ 

订单号：
[订单号]
商品名称：
[商品名称]
商品数量：[商品数量]
下单时间：[下单时间]
订单金额：[订单金额]
' . $couponstr . $remark . $cusurl;
							}
							else {
								$cusurl = '<a href=\'' . $url . '\'>点击查看详情</a>';
								$text = '您的订单已经成功支付，我们将尽快为您安排发货！！ 

订单号：
[订单号]
商品名称：
[商品名称]
商品数量：[商品数量]
下单时间：[下单时间]
订单金额：[订单金额]
' . $couponstr . $remark . $cusurl;
							}

							if ($order['isverify']) {
								$msg = array(
									'first'    => array('value' => '您的订单已于' . date('Y-m-d H:i', $order['paytime']) . '成功支付.
', 'color' => '#4b9528'),
									'keyword1' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
									'keyword2' => array('title' => '商品名称', 'value' => substr_replace($goodsname, '
', strrpos($goodsname, '

'), strlen('

')), 'color' => '#000000'),
									'keyword3' => array('title' => '商品数量', 'value' => $goodsnum, 'color' => '#000000'),
									'keyword4' => array('title' => '支付金额', 'value' => $order['price'], 'color' => '#000000'),
									'remark'   => array('value' => $remark, 'color' => '#000000')
								);
							}
							else {
								$msg = array(
									'first'    => array('value' => '您的订单已于' . date('Y-m-d H:i', $order['paytime']) . '成功支付，我们将尽快为您安排发货！!
', 'color' => '#4b9528'),
									'keyword1' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
									'keyword2' => array('title' => '商品名称', 'value' => substr_replace($goodsname, '
', strrpos($goodsname, '

'), strlen('

')), 'color' => '#000000'),
									'keyword3' => array('title' => '商品数量', 'value' => $goodsnum, 'color' => '#000000'),
									'keyword4' => array('title' => '支付金额', 'value' => $order['price'], 'color' => '#000000'),
									'remark'   => array('value' => $remark, 'color' => '#000000')
								);
							}

							$this->sendNotice(array('openid' => $openid, 'tag' => 'pay', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'appurl' => $appurl));
							com_run('sms::callsms', array('tag' => 'pay', 'datas' => $datas, 'mobile' => !empty($buyerinfo_mobile) && $order['isverify'] ? $buyerinfo_mobile : $member['mobile']));
							if (p('app') && !empty($order['wxapp_prepay_id'])) {
								p('app')->sendNotice($openid, $datas, $order['wxapp_prepay_id'], $orderid, 'pay');
							}
						}

						if ($order['dispatchtype'] == 1 && empty($order['isverify'])) {
							if (!empty($usernotice['carrier'])) {
								return NULL;
							}

							if (!$carrier || !$store) {
								return NULL;
							}

							$remark = '
请您到选择的自提点进行取货, 自提联系人: ' . $store['realname'] . ' 联系电话: ' . $store['mobile'] . ('

<a href=\'' . $url . '\'>点击查看详情</a>');
							$text = '自提订单提交成功!！
自提码：[自提码]
商品详情：[商品详情]
提货地址：[门店地址]
提货时间：[门店营业时间]
' . $couponstr . $remark;
							$msg = array(
								'first'    => array('value' => '自提订单提交成功!', 'color' => '#000000'),
								'keyword1' => array('title' => '自提码', 'value' => $order['verifycode'], 'color' => '#000000'),
								'keyword2' => array('title' => '商品详情', 'value' => $goods . $orderpricestr, 'color' => '#000000'),
								'keyword3' => array('title' => '提货地址', 'value' => $store['address'], 'color' => '#000000'),
								'keyword4' => array('title' => '提货时间', 'value' => $store['saletime'], 'color' => '#000000'),
								'remark'   => array('value' => '
请您到选择的自提点进行取货, 自提联系人: ' . $store['realname'] . ' 联系电话: ' . $store['mobile'], 'color' => '#000000')
							);
							$this->sendNotice(array('openid' => $openid, 'tag' => 'carrier', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'appurl' => $appurl));
							com_run('sms::callsms', array('tag' => 'carrier', 'datas' => $datas, 'mobile' => !empty($buyerinfo_mobile) ? $buyerinfo_mobile : $member['mobile']));
						}
					}
					else {
						if ($order['status'] == 2 || $order['status'] == 1 && !empty($order['sendtype'])) {
							$isonlyverify = m('order')->checkisonlyverifygoods($orderid);
							if (empty($order['dispatchtype']) && !$isonlyverify) {
								if (!empty($usernotice['send'])) {
									return NULL;
								}

								$datas[] = array('name' => '发货类型', 'value' => empty($order['sendtype']) ? '按订单发货' : '按包裹发货');

								if (empty($order['sendtype'])) {
									if (empty($address)) {
										return NULL;
									}

									$remark = '<a href=\'' . $url . '\'>点击快速查询物流信息</a>';
									$text = '您的宝贝已经成功发货！ 
商品名称：[商品详情]
快递公司：[快递公司]
快递单号：[快递单号]
';
									$msg = array();
									$msg['first'] = array('value' => '您的宝贝已经发货！', 'color' => '#000000');
									$msg['keyword1'] = array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000');
									$msg['keyword2'] = array('title' => '快递公司', 'value' => $order['expresscom'], 'color' => '#000000');
									$msg['keyword3'] = array('title' => '快递单号', 'value' => $order['expresssn'], 'color' => '#000000');
									$remark_value = '';

									if (0 < $order['merchid']) {
										$merch_user = p('merch')->getListUserOne($order['merchid']);

										if (!empty($merch_user['mobile'])) {
											$datas[] = array('name' => '商户电话', 'value' => $merch_user['mobile']);
											$text .= '
商户电话：[商户电话]';
											$remark_value .= '
商户电话：' . $merch_user['mobile'];
										}

										if (!empty($merch_user['address'])) {
											$datas[] = array('name' => '商户地址', 'value' => $merch_user['address']);
											$text .= '
商户地址：[商户地址]';
											$remark_value .= '
商户地址：' . $merch_user['address'];
										}
									}

									$text .= $remark;
									$remark_value .= '
我们正加速送到您的手上，请您耐心等候';
									$msg['remark'] = array('value' => $remark_value, 'color' => '#000000');
									$ret = $this->sendNotice(array('openid' => $openid, 'tag' => 'send', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'appurl' => $appurl));
									com_run('sms::callsms', array('tag' => 'send', 'datas' => $datas, 'mobile' => !empty($buyerinfo_mobile) ? $buyerinfo_mobile : $member['mobile']));
								}
								else {
									$package_goods = array();
									$package_expresscom = '';
									$package_expresssn = '';
									$package_sendtime = '';
									$package_goodsdetail = '';
									$package_goodsname = '';

									foreach ($order_goods as $og) {
										if ($og['sendtype'] == $order['sendtype']) {
											$package_goods[] = $og;

											if (empty($package_expresscom)) {
												$package_expresscom = $og['expresscom'];
											}

											if (empty($package_expresssn)) {
												$package_expresssn = $og['expresssn'];
											}

											if (empty($package_sendtime)) {
												$package_sendtime = $og['sendtime'];
											}

											$package_goodsdetail .= '

' . $og['title'] . '( ';

											if (!empty($og['optiontitle'])) {
												$package_goodsdetail .= ' 规格: ' . $og['optiontitle'];
											}

											$package_goodsdetail .= ' 单价: ' . round($og['realprice'] / $og['total'], 2) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['realprice'] . '); ';
											$package_goodsname .= $og['title'] . ' 

';
										}
									}

									if (empty($package_goods)) {
										return NULL;
									}

									$datas[] = array('name' => '包裹快递公司', 'value' => $package_expresscom);
									$datas[] = array('name' => '包裹快递单号', 'value' => $package_expresssn);
									$datas[] = array('name' => '包裹发送时间', 'value' => date('Y-m-d H:i', $package_sendtime));
									$datas[] = array('name' => '包裹商品详情', 'value' => $package_goodsdetail);
									$datas[] = array('name' => '包裹商品名称', 'value' => $package_goodsname);
									$remark = '<a href=\'' . $url . '\'>点击快速查询物流信息</a>';
									$text = '您的包裹已经成功发货！ 
商品名称：[包裹商品名称]快递公司：[包裹快递公司]
快递单号：[包裹快递单号]
' . $remark;
									$msg = array(
										'first'    => array('value' => '您的包裹已经发货！', 'color' => '#000000'),
										'keyword1' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
										'keyword2' => array('title' => '快递公司', 'value' => $package_expresscom, 'color' => '#000000'),
										'keyword3' => array('title' => '快递单号', 'value' => $package_expresssn, 'color' => '#000000'),
										'remark'   => array('value' => '
我们正加速送到您的手上，请您耐心等候。', 'color' => '#000000')
									);
									$this->sendNotice(array('openid' => $openid, 'tag' => 'send', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'appurl' => $appurl));
									com_run('sms::callsms', array('tag' => 'send', 'datas' => $datas, 'mobile' => $member['mobile']));
								}

								if (p('app') && !empty($order['wxapp_prepay_id'])) {
									p('app')->sendNotice($openid, $datas, $order['wxapp_prepay_id'], $orderid, 'send');
								}
							}

							if ($isonlyverify) {
								if (empty($usernotice['pay'])) {
									$remark = '
';
									$cusurl = '<a href=\'' . $url . '\'>点击查看详情</a>';
									$text = '您的记次时商品订单已经成功支付！！ 

订单号：
[订单号]
商品名称：
[商品名称]商品数量：[商品数量]
下单时间：[下单时间]
订单金额：[订单金额]
' . $couponstr . $remark . $cusurl;
									$msg = array(
										'first'    => array('value' => '您的记次时商品订单已于' . date('Y-m-d H:i', $order['paytime']) . '成功支付！
', 'color' => '#4b9528'),
										'keyword1' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
										'keyword2' => array('title' => '商品名称', 'value' => substr_replace($goodsname, '
', strrpos($goodsname, '

'), strlen('

')), 'color' => '#000000'),
										'keyword3' => array('title' => '商品数量', 'value' => $goodsnum, 'color' => '#000000'),
										'keyword4' => array('title' => '支付金额', 'value' => $order['price'], 'color' => '#000000'),
										'remark'   => array('value' => $remark, 'color' => '#000000')
									);
									$this->sendNotice(array('openid' => $openid, 'tag' => 'pay', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'appurl' => $appurl));
									com_run('sms::callsms', array('tag' => 'pay', 'datas' => $datas, 'mobile' => !empty($buyerinfo_mobile) && $order['isverify'] ? $buyerinfo_mobile : $member['mobile']));
									if (p('app') && !empty($order['wxapp_prepay_id'])) {
										p('app')->sendNotice($openid, $datas, $order['wxapp_prepay_id'], $orderid, 'pay');
									}
								}

								$is_send = 0;

								if (empty($is_merch)) {
									$is_send = 1;
								}
								else {
									if (!empty($merch_tm) && empty($merch_tm['saler_pay_close_advanced'])) {
										$is_send = 1;
										$tm['openid'] = $merch_tm['openid'];
									}
								}

								if (!empty($is_send)) {
									$msg = array(
										'first'    => array('value' => '您有新的记次时商品订单于' . date('Y-m-d H:i', $order['paytime']) . '已付款！
请登录后台查看详情。', 'color' => '#ff0000'),
										'keyword1' => array('title' => '订单编号', 'value' => $order['ordersn'], 'color' => '#000000'),
										'keyword2' => array('title' => '商品名称', 'value' => $goods, 'color' => '#000000'),
										'keyword3' => array('title' => '商品数量', 'value' => $goodsnum, 'color' => '#000000'),
										'keyword4' => array('title' => '支付金额', 'value' => $order['price'], 'color' => '#000000')
									);
									$text = '您有新的已付款记次时商品订单！
请登录后台查看详情。

订单号：
[订单号]
订单金额：[订单金额]
支付时间：[支付时间]
---------------------
购买商品信息：[商品详情]
备注信息：[备注信息]';
									$account = m('common')->getAccount();

									if (!empty($tm['openid'])) {
										$openids = explode(',', $tm['openid']);

										foreach ($openids as $tmopenid) {
											if (empty($tmopenid)) {
												continue;
											}

											$sendData = array('openid' => $tmopenid, 'tag' => 'saler_pay', 'default' => $msg, 'cusdefault' => $text, 'datas' => $datas, 'is_merch' => $is_merch, 'merch_tm' => $merch_tm);
											$open_redis = function_exists('redis') && !is_error(redis());

											if ($open_redis) {
												$notice_redis = m('common')->getSysset('notice_redis');

												if (!empty($notice_redis['notice_redis'])) {
													$sendData['is_send'] = 0;
													$sendData['send_underway'] = 0;
													$key = 'notice_uniacid' . $_W['uniacid'] . '_list';
													$redis = redis();
													$redis->rPush($key, serialize($sendData));
												}
												else {
													$this->sendNotice($sendData);
												}
											}
											else {
												$this->sendNotice($sendData);
											}
										}
									}
								}

								if (!empty($tm['mobile']) && empty($tm['saler_pay_close_sms']) && empty($is_merch)) {
									$mobiles = explode(',', $tm['mobile']);

									foreach ($mobiles as $mobile) {
										if (empty($mobile)) {
											continue;
										}

										com_run('sms::callsms', array('tag' => 'saler_pay', 'datas' => $datas, 'mobile' => $mobile));
									}
								}

								foreach ($order_goods as $og) {
									if (!empty($og['noticeopenid']) && !empty($og['noticetype'])) {
										$noticetype = explode(',', $og['noticetype']);
										if ($og['noticetype'] == '1' || is_array($noticetype) && in_array('1', $noticetype)) {
											$goodstr = $og['title'] . '( ';

											if (!empty($og['optiontitle'])) {
												$goodstr .= ' 规格: ' . $og['optiontitle'];
												$optiontitle = '( 规格: ' . $og['optiontitle'] . ')';
											}

											$goodstr .= ' 单价: ' . round($og['price'] / $og['total'], 2) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['price'] . '); ';
											$text = '您有新的已付款记次时商品订单！！
请及时安排发货。

订单号：
[订单号]
订单金额：[订单金额]
支付时间：[支付时间]
---------------------
购买商品信息：[单品详情]
备注信息：[备注信息]';
											$remark = '订单号：
' . $order['ordersn'] . '
商品详情：' . $goodstr;
											$msg = array(
												'first'    => array('value' => '您有新的记次时商品订单于' . date('Y-m-d H:i', $order['paytime']) . '已付款！！
请登录后台查看详情。
', 'color' => '#ff0000'),
												'keyword2' => array('title' => '处理进度', 'value' => '商品付款通知', 'color' => '#000000'),
												'keyword3' => array('title' => '处理内容', 'value' => '已付款', 'color' => '#000000'),
												'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
												'remark'   => array('value' => $remark, 'color' => '#000000')
											);
											$datas['gooddetail'] = array('name' => '单品详情', 'value' => $goodstr);
											$noticeopenids = explode(',', $og['noticeopenid']);

											foreach ($noticeopenids as $noticeopenid) {
												$this->sendNotice(array('openid' => $noticeopenid, 'tag' => 'saler_goodpay', 'cusdefault' => $text, 'default' => $msg, 'datas' => $datas));
											}
										}
									}
								}
							}
						}
						else {
							if ($order['status'] == 3) {
								$pv = com('virtual');
								if ($pv && !empty($order['virtual'])) {
									if (empty($usernotice['virtualsend'])) {
										$text = '您的商品已购买成功，以下为您的购物信息。

商品名称:' . str_replace('
', '', $goodsname) . ('
订单金额：[订单金额]
卡密信息：<a href=\'' . $url . '\'> 点击查看</a>');
										$msg = array(
											'first'    => array('value' => '您的商品已购买成功，以下为您的购物信息。', 'color' => '#4b9528'),
											'keyword1' => array('title' => '商品名称', 'value' => str_replace('
', '', $goodsname), 'color' => '#000000'),
											'keyword2' => array('title' => '订单号', 'value' => $order['ordersn'], 'color' => '#000000'),
											'keyword3' => array('title' => '订单金额', 'value' => '¥' . $order['price'] . '元', 'color' => '#000000'),
											'keyword4' => array('title' => '卡密信息', 'value' => '点击查看详情', 'color' => '#ff0000')
										);
										$this->sendNotice(array('openid' => $openid, 'tag' => 'virtualsend', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'appurl' => $appurl));
										com_run('sms::callsms', array('tag' => 'virtualsend', 'datas' => $datas, 'mobile' => !empty($buyerinfo_mobile) ? $buyerinfo_mobile : $member['mobile']));
										if (p('app') && !empty($order['wxapp_prepay_id'])) {
											p('app')->sendNotice($openid, $datas, $order['wxapp_prepay_id'], $orderid, 'virtualsend');
										}
									}

									$first = '买家购买的商品已经自动发货!
';
									$remark = '订单号：' . $order['ordersn'] . '
收货时间：' . date('Y-m-d H:i', $order['finishtime']) . '
商品详情：' . $goods . '

购买者信息:
' . $buyerinfo;
									$text = $first . '
订单号：' . $order['ordersn'] . '
收货时间：' . date('Y-m-d H:i', $order['finishtime']) . '
商品详情：' . $goods . '

购买者信息:
' . $buyerinfo;
									$is_send = 0;

									if (empty($is_merch)) {
										if (empty($usernotice['saler_finish'])) {
											$is_send = 1;
										}
									}
									else {
										if (!empty($merch_tm) && empty($merch_tm['saler_finish_close_advanced'])) {
											$is_send = 1;
											$tm['openid2'] = $merch_tm['openid2'];
										}
									}

									if (!empty($is_send)) {
										$msg = array(
											'first'    => array('value' => $first, 'color' => '#4b9528'),
											'keyword2' => array('title' => '处理进度', 'value' => '订单收货通知', 'color' => '#000000'),
											'keyword3' => array('title' => '处理内容', 'value' => '虚拟物品及卡密自动发货', 'color' => '#000000'),
											'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
											'remark'   => array('title' => '', 'value' => $remark, 'color' => '#000000')
										);
										$account = m('common')->getAccount();

										if (!empty($tm['openid2'])) {
											$openids = explode(',', $tm['openid2']);

											foreach ($openids as $tmopenid) {
												if (empty($tmopenid)) {
													continue;
												}

												$sendData = array('openid' => $tmopenid, 'tag' => 'saler_finish', 'cusdefault' => $text, 'default' => $msg, 'datas' => $datas, 'is_merch' => $is_merch, 'merch_tm' => $merch_tm);
												$open_redis = function_exists('redis') && !is_error(redis());

												if ($open_redis) {
													$notice_redis = m('common')->getSysset('notice_redis');

													if (!empty($notice_redis['notice_redis'])) {
														$sendData['is_send'] = 0;
														$sendData['send_underway'] = 0;
														$key = 'notice_uniacid' . $_W['uniacid'] . '_list';
														$redis = redis();
														$redis->rPush($key, serialize($sendData));
													}
													else {
														$this->sendNotice($sendData);
													}
												}
												else {
													$this->sendNotice($sendData);
												}
											}
										}
									}

									if (!empty($tm['mobile2']) && empty($tm['saler_finish_close_sms'])) {
										$mobiles = explode(',', $tm['mobile2']);

										foreach ($mobiles as $mobile) {
											if (empty($mobile)) {
												continue;
											}

											com_run('sms::callsms', array('tag' => 'saler_finish', 'datas' => $datas, 'mobile' => $mobile));
										}
									}

									foreach ($order_goods as $og) {
										$noticetype = explode(',', $og['noticetype']);
										if ($og['noticetype'] == '2' || is_array($noticetype) && in_array('2', $noticetype)) {
											$goodstr = $og['title'] . '( ';

											if (!empty($og['optiontitle'])) {
												$goodstr .= ' 规格: ' . $og['optiontitle'];
											}

											$goodstr .= ' 单价: ' . round($og['price'] / $og['total'], 2) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['price'] . '); ';
											$remark = '订单号：' . $order['ordersn'] . '
收货时间：' . date('Y-m-d H:i', $order['finishtime']) . '
商品详情：' . $goodstr . '

购买者信息:
' . $buyerinfo;
											$text = $first . '
订单号：' . $order['ordersn'] . '
收货时间：' . date('Y-m-d H:i', $order['finishtime']) . '
商品详情：' . $goodstr . '

购买者信息:
' . $buyerinfo;
											$msg = array(
												'first'    => array('value' => $first, 'color' => '#4b9528'),
												'keyword2' => array('title' => '处理进度', 'value' => '订单收货通知', 'color' => '#000000'),
												'keyword3' => array('title' => '处理内容', 'value' => '虚拟物品及卡密自动发货', 'color' => '#000000'),
												'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
												'remark'   => array('title' => '', 'value' => $remark, 'color' => '#000000')
											);
											$datas[] = array('name' => '单品详情', 'value' => $goodstr);
											$noticeopenids = explode(',', $og['noticeopenid']);

											foreach ($noticeopenids as $noticeopenid) {
												$this->sendNotice(array('openid' => $noticeopenid, 'tag' => 'saler_finish', 'cusdefault' => $text, 'default' => $msg, 'datas' => $datas));
											}
										}
									}
								}
								else if ($order['isvirtualsend']) {
									if (empty($usernotice['virtualsend'])) {
										$text = '您的商品已购买成功，以下为您的购物信息。

商品名称:' . str_replace('
', '', $goodsname) . ('
订单金额：[订单金额]
卡密信息：<a href=\'' . $url . '\'> 点击查看</a>');
										$msg = array(
											'first'    => array('value' => '您的商品已购买成功，以下为您的购物信息。', 'color' => '#4b9528'),
											'keyword1' => array('title' => '商品名称', 'value' => str_replace('
', '', $goodsname), 'color' => '#000000'),
											'keyword2' => array('title' => '订单号', 'value' => $order['ordersn'], 'color' => '#000000'),
											'keyword3' => array('title' => '订单金额', 'value' => '¥' . $order['price'] . '元', 'color' => '#000000'),
											'keyword4' => array('title' => '卡密信息', 'value' => '点击查看详情', 'color' => '#ff0000')
										);
										$this->sendNotice(array('openid' => $openid, 'tag' => 'virtualsend', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'appurl' => $appurl));
										com_run('sms::callsms', array('tag' => 'virtualsend', 'datas' => $datas, 'mobile' => !empty($buyerinfo_mobile) ? $buyerinfo_mobile : $member['mobile']));
										if (p('app') && !empty($order['wxapp_prepay_id'])) {
											p('app')->sendNotice($openid, $datas, $order['wxapp_prepay_id'], $orderid, 'virtualsend');
										}
									}

									$first = '买家购买的商品已经自动发货!
';
									$remark = '订单号：' . $order['ordersn'] . '
收货时间：' . date('Y-m-d H:i', $order['finishtime']) . '
商品详情：' . $goods . '

购买者信息:
' . $buyerinfo;
									$text = $first . '
订单号：' . $order['ordersn'] . '
收货时间：' . date('Y-m-d H:i', $order['finishtime']) . '
商品详情：' . $goods . '

购买者信息:
' . $buyerinfo;
									$is_send = 0;

									if (empty($is_merch)) {
										if (empty($usernotice['saler_finish'])) {
											$is_send = 1;
										}
									}
									else {
										if (!empty($merch_tm) && empty($merch_tm['saler_finish_close_advanced'])) {
											$is_send = 1;
											$tm['openid2'] = $merch_tm['openid2'];
										}
									}

									if (!empty($is_send)) {
										$msg = array(
											'first'    => array('value' => $first, 'color' => '#4b9528'),
											'keyword2' => array('title' => '处理进度', 'value' => '订单收货通知', 'color' => '#000000'),
											'keyword3' => array('title' => '处理内容', 'value' => '商品自动发货', 'color' => '#000000'),
											'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
											'remark'   => array('title' => '', 'value' => $remark, 'color' => '#000000')
										);
										$account = m('common')->getAccount();

										if (!empty($tm['openid2'])) {
											$openids = explode(',', $tm['openid2']);

											foreach ($openids as $tmopenid) {
												if (empty($tmopenid)) {
													continue;
												}

												$sendData = array('openid' => $tmopenid, 'tag' => 'saler_finish', 'cusdefault' => $text, 'default' => $msg, 'datas' => $datas, 'is_merch' => $is_merch, 'merch_tm' => $merch_tm);
												$open_redis = function_exists('redis') && !is_error(redis());

												if ($open_redis) {
													$notice_redis = m('common')->getSysset('notice_redis');

													if (!empty($notice_redis['notice_redis'])) {
														$sendData['is_send'] = 0;
														$sendData['send_underway'] = 0;
														$key = 'notice_uniacid' . $_W['uniacid'] . '_list';
														$redis = redis();
														$redis->rPush($key, serialize($sendData));
													}
													else {
														$this->sendNotice($sendData);
													}
												}
												else {
													$this->sendNotice($sendData);
												}
											}
										}
									}

									if (!empty($tm['mobile2']) && empty($tm['saler_finish_close_sms'])) {
										$mobiles = explode(',', $tm['mobile2']);

										foreach ($mobiles as $mobile) {
											if (empty($mobile)) {
												continue;
											}

											com_run('sms::callsms', array('tag' => 'saler_finish', 'datas' => $datas, 'mobile' => $mobile));
										}
									}

									foreach ($order_goods as $og) {
										$noticetype = explode(',', $og['noticetype']);
										if ($og['noticetype'] == '2' || is_array($noticetype) && in_array('2', $noticetype)) {
											$goodstr = $og['title'] . '( ';

											if (!empty($og['optiontitle'])) {
												$goodstr .= ' 规格: ' . $og['optiontitle'];
											}

											$goodstr .= ' 单价: ' . round($og['price'] / $og['total'], 2) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['price'] . '); ';
											$remark = '订单号：' . $order['ordersn'] . '
收货时间：' . date('Y-m-d H:i', $order['finishtime']) . '
商品详情：' . $goodstr . '

购买者信息:
' . $buyerinfo;
											$text = $first . '
订单号：' . $order['ordersn'] . '
收货时间：' . date('Y-m-d H:i', $order['finishtime']) . '
商品详情：' . $goodstr . '

购买者信息:
' . $buyerinfo;
											$msg = array(
												'first'    => array('value' => $first, 'color' => '#4b9528'),
												'keyword2' => array('title' => '处理进度', 'value' => '订单收货通知', 'color' => '#000000'),
												'keyword3' => array('title' => '处理内容', 'value' => '虚拟物品及卡密自动发货', 'color' => '#000000'),
												'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
												'remark'   => array('title' => '', 'value' => $remark, 'color' => '#000000')
											);
											$datas[] = array('name' => '单品详情', 'value' => $goodstr);
											$noticeopenids = explode(',', $og['noticeopenid']);

											foreach ($noticeopenids as $noticeopenid) {
												$this->sendNotice(array('openid' => $noticeopenid, 'tag' => 'saler_finish', 'cusdefault' => $text, 'default' => $msg, 'datas' => $datas));
											}
										}
									}
								}
								else {
									$first = '买家购买的商品已经确认收货!
';

									if ($order['isverify'] == 1) {
										$first = '买家购买的商品已经确认核销!
';
									}

									$text = $first . '
订单号：
' . $order['ordersn'] . '
收货时间：' . date('Y-m-d H:i', $order['finishtime']) . '
商品详情：' . $goods;
									$remark = '订单号：' . $order['ordersn'] . '
收货时间：' . date('Y-m-d H:i', $order['finishtime']) . '
商品详情：' . $goods;

									if (!empty($buyerinfo)) {
										$remark = $remark . '
购买者信息:
' . $buyerinfo;
										$text = $text . '

购买者信息:
' . $buyerinfo;
									}

									$is_send = 0;

									if (empty($is_merch)) {
										if (empty($usernotice['saler_finish'])) {
											$is_send = 1;
										}
									}
									else {
										if (!empty($merch_tm) && empty($merch_tm['saler_finish_close_advanced'])) {
											$is_send = 1;
											$tm['openid2'] = $merch_tm['openid2'];
										}
									}

									if (!empty($is_send)) {
										$msg = array(
											'first'    => array('value' => $first, 'color' => '#4b9528'),
											'keyword2' => array('title' => '处理进度', 'value' => '订单收货通知', 'color' => '#000000'),
											'keyword3' => array('title' => '处理内容', 'value' => '商品确认收货', 'color' => '#000000'),
											'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
											'remark'   => array('title' => '', 'value' => $remark, 'color' => '#000000')
										);
										$account = m('common')->getAccount();

										if (!empty($tm['openid2'])) {
											$openids = explode(',', $tm['openid2']);

											foreach ($openids as $tmopenid) {
												if (empty($tmopenid)) {
													continue;
												}

												$sendData = array('openid' => $tmopenid, 'tag' => 'saler_finish', 'cusdefault' => $text, 'default' => $msg, 'datas' => $datas, 'is_merch' => $is_merch, 'merch_tm' => $merch_tm);
												$open_redis = function_exists('redis') && !is_error(redis());

												if ($open_redis) {
													$notice_redis = m('common')->getSysset('notice_redis');

													if (!empty($notice_redis['notice_redis'])) {
														$sendData['is_send'] = 0;
														$sendData['send_underway'] = 0;
														$key = 'notice_uniacid' . $_W['uniacid'] . '_list';
														$redis = redis();
														$redis->rPush($key, serialize($sendData));
													}
													else {
														$this->sendNotice($sendData);
													}
												}
												else {
													$this->sendNotice($sendData);
												}
											}
										}
									}

									if (!empty($tm['mobile2']) && empty($tm['saler_finish_close_sms']) && empty($is_merch)) {
										$mobiles = explode(',', $tm['mobile2']);

										foreach ($mobiles as $mobile) {
											if (empty($mobile)) {
												continue;
											}

											com_run('sms::callsms', array('tag' => 'saler_finish', 'datas' => $datas, 'mobile' => $mobile));
										}
									}

									foreach ($order_goods as $og) {
										$noticetype = explode(',', $og['noticetype']);
										if ($og['noticetype'] == '2' || is_array($noticetype) && in_array('2', $noticetype)) {
											$goodstr = $og['title'] . '( ';

											if (!empty($og['optiontitle'])) {
												$goodstr .= ' 规格: ' . $og['optiontitle'];
											}

											$goodstr .= ' 单价: ' . round($og['price'] / $og['total'], 2) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['price'] . '); ';
											$remark = '订单号：' . $order['ordersn'] . '
收货时间：' . date('Y-m-d H:i', $order['finishtime']) . '
商品详情：' . $goods;
											$text = $first . '
订单号：
' . $order['ordersn'] . '
收货时间：' . date('Y-m-d H:i', $order['finishtime']) . '
商品详情：' . $goods;

											if (!empty($buyerinfo)) {
												$remark = $remark . '
购买者信息:
' . $buyerinfo;
												$text = $text . '

购买者信息:
' . $buyerinfo;
											}

											$msg = array(
												'first'    => array('value' => $first, 'color' => '#4b9528'),
												'keyword2' => array('title' => '处理进度', 'value' => '订单收货通知', 'color' => '#000000'),
												'keyword3' => array('title' => '处理内容', 'value' => '虚拟物品及卡密自动发货', 'color' => '#000000'),
												'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
												'remark'   => array('title' => '', 'value' => $remark, 'color' => '#000000')
											);
											$datas[] = array('name' => '单品详情', 'value' => $goodstr);
											$noticeopenids = explode(',', $og['noticeopenid']);

											foreach ($noticeopenids as $noticeopenid) {
												$this->sendNotice(array('openid' => $noticeopenid, 'tag' => 'saler_finish', 'cusdefault' => $text, 'default' => $msg, 'datas' => $datas));
											}
										}
									}

									if (p('app') && !empty($order['wxapp_prepay_id'])) {
										p('app')->sendNotice($openid, $datas, $order['wxapp_prepay_id'], $orderid, 'finish');
									}
								}
							}
						}
					}
				}
			}
		}
	}

	/**
     * 会员升级提醒
     * @param type $openid
     * @param type $oldlevel
     * @param type $level
     * @return type
     */
	public function sendMemberUpgradeMessage($openid = '', $oldlevel = NULL, $level = NULL)
	{
		global $_W;
		global $_GPC;
		$member = m('member')->getMember($openid);
		$detailurl = $this->getUrl('member');
		$appurl = '/pages/member/index/index';
		$usernotice = unserialize($member['noticeset']);

		if (!is_array($usernotice)) {
			$usernotice = array();
		}

		if (!empty($usernotice['upgrade'])) {
			return NULL;
		}

		if (!$level) {
			$level = m('member')->getLevel($openid);
		}

		$oldlevelname = empty($oldlevel['levelname']) ? '普通会员' : $oldlevel['levelname'];
		$message = array(
			'first'    => array('value' => '亲爱的' . $member['nickname'] . '，恭喜您成功升级！
', 'color' => '#ff0000'),
			'keyword2' => array('title' => '处理进度', 'value' => '会员升级', 'color' => '#000000'),
			'keyword3' => array('title' => '处理内容', 'value' => '您会员等级从 ' . $oldlevelname . ' 升级为 ' . $level['levelname'] . ', 特此通知!', 'color' => '#000000'),
			'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
			'remark'   => array('value' => '
您即可享有' . $level['levelname'] . '的专属优惠及服务！', 'color' => '#000000')
		);
		$datas = array(
			array('name' => '商城名称', 'value' => $_W['shopset']['shop']['name']),
			array('name' => '粉丝昵称', 'value' => $member['nickname']),
			array('name' => '旧等级', 'value' => $oldlevelname),
			array('name' => '新等级', 'value' => $level['levelname'])
		);
		$remark = '
<a href=\'' . $detailurl . '\'>点击进入查看充值订单详情</a>';
		$text = '亲爱的' . $member['nickname'] . '， 恭喜您成功升级！

您会员等级从[旧等级] 升级为[新等级] , 特此通知!
您即可享有[新等级]的专属优惠及服务！' . $remark;
		$this->sendNotice(array('openid' => $openid, 'tag' => 'upgrade', 'default' => $message, 'cusdefault' => $text, 'url' => $detailurl, 'datas' => $datas, 'appurl' => $appurl));
		com_run('sms::callsms', array('tag' => 'upgrade', 'datas' => $datas, 'mobile' => $member['mobile']));
	}

	/**
     * 后台积分变动提示
     * @param type $openid
     * @param type $oldlevel
     * @param type $level
     * @return type
     */
	public function sendMemberPointChange($openid, $pointchange = 0, $changetype = 0, $from = 0)
	{
		global $_W;
		global $_GPC;
		$url = $this->getUrl('member');
		$member = m('member')->getMember($openid);
		$credit1 = m('member')->getCredit($openid);
		$usernotice = unserialize($member['noticeset']);

		if (!is_array($usernotice)) {
			$usernotice = array();
		}

		$account = m('common')->getAccount();

		if (!$account) {
			return NULL;
		}

		if (!empty($usernotice['backpoint_ok'])) {
			return NULL;
		}

		$credittext = empty($_W['shopset']['trade']['credittext']) ? '积分' : $_W['shopset']['trade']['credittext'];
		$pointtext = '';
		$pointcolor = '';

		if ($changetype == 0) {
			$pointcolor = '#0a4b9c';
			$pointtext = '增加' . (double) $pointchange . $credittext;
		}
		else {
			if ($changetype == 1) {
				$pointcolor = '#4b9528';
				$pointtext = '减少' . (double) $pointchange . $credittext;
			}
		}

		if (empty($from)) {
			$fromstr = '管理员后台手动处理';
		}
		else if ($from == 1) {
			$fromstr = '收银台积分变动提醒';
		}
		else {
			if ($from == 2) {
				$fromstr = '购物赠送积分';
			}
		}

		$datas = array(
			array('name' => '商城名称', 'value' => $_W['shopset']['shop']['name']),
			array('name' => '粉丝昵称', 'value' => $member['nickname']),
			array('name' => '积分变动', 'value' => $pointtext),
			array('name' => '赠送时间', 'value' => date('Y-m-d H:i', time())),
			array('name' => '积分余额', 'value' => (double) $member['credit1'] . $credittext)
		);
		$remark = '
[商城名称]感谢您的支持，如有疑问请联系在线客服。';
		$text = '亲爱的[粉丝昵称]， 您的' . $credittext . '发生变动，具体内容如下：

积分变动：[积分变动]
变动时间：[赠送时间]
充值方式：' . $fromstr . '
当前积分余额：[积分余额] 
' . $remark;
		$message = array(
			'first'    => array('value' => '亲爱的' . $member['nickname'] . '，您的' . $credittext . '发生变动，具体如下:', 'color' => '#ff0000'),
			'keyword1' => array('title' => '获得时间', 'value' => date('Y-m-d H:i', time()), 'color' => '#000000'),
			'keyword2' => array('title' => '获得积分', 'value' => $pointtext, 'color' => $pointcolor),
			'keyword3' => array('title' => '获得原因', 'value' => $fromstr, 'color' => '#000000'),
			'keyword4' => array('title' => '当前积分', 'value' => (double) $member['credit1'] . $credittext, 'color' => '#ff0000'),
			'remark'   => array('value' => '
' . $_W['shopset']['shop']['name'] . '感谢您的支持，如有疑问请联系在线客服。', 'color' => '#000000')
		);
		$this->sendNotice(array('openid' => $openid, 'tag' => 'backpoint_ok', 'default' => $message, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas));
		com_run('sms::callsms', array('tag' => 'backpoint_ok', 'datas' => $datas, 'mobile' => $member['mobile']));
	}

	/**
     * 会员充值提现消息
     * @param type $openid
     * @param type $oldlevel
     * @param type $level
     * @return type
     */
	public function sendMemberLogMessage($log_id = '', $channel = 0, $isback = false)
	{
		global $_W;
		global $_GPC;
		$url = $this->getUrl('member/log');
		$appurl = '/pages/member/log/index';
		$log_info = pdo_fetch('select * from ' . tablename('ewei_shop_member_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $log_id, ':uniacid' => $_W['uniacid']));
		$member = m('member')->getMember($log_info['openid']);
		$usernotice = unserialize($member['noticeset']);

		if (!is_array($usernotice)) {
			$usernotice = array();
		}

		$account = m('common')->getAccount();

		if (!$account) {
			return NULL;
		}

		$datas = array(
			array('name' => '商城名称', 'value' => $_W['shopset']['shop']['name']),
			array('name' => '粉丝昵称', 'value' => $member['nickname'])
		);
		$log_info['gives'] = floatval($log_info['gives']);
		$log_info['money'] = floatval($log_info['money']);
		$type = '后台充值';

		if ($channel === 1) {
			$type = '兑换券';
		}
		else {
			if ($channel === 2) {
				$type = '充值券';
			}
		}

		if ($log_info['rechargetype'] == 'wechat') {
			$type = '微信支付';
		}
		else {
			if ($log_info['rechargetype'] == 'alipay') {
				$type = '支付宝';
			}
		}

		$apply_type = array(0 => '微信钱包', 2 => '支付宝', 3 => '银行卡');
		$credittext = empty($_W['shopset']['trade']['credittext']) ? '积分' : $_W['shopset']['trade']['credittext'];
		$moneytext = empty($_W['shopset']['trade']['moneytext']) ? '余额' : $_W['shopset']['trade']['moneytext'];
		$yuan = empty($_W['shopset']['commission']['texts']['yuan']) ? '元' : $_W['shopset']['commission']['texts']['yuan'];
		$datas[] = array('name' => '支付方式', 'value' => $type);
		$datas[] = array('name' => '充值金额', 'value' => $log_info['money'] . $yuan);
		$datas[] = array('name' => '充值时间', 'value' => date('Y-m-d H:i', $log_info['createtime']));
		$datas[] = array('name' => '赠送金额', 'value' => $log_info['gives']);
		$datas[] = array('name' => '到帐金额', 'value' => $log_info['money'] + $log_info['gives']);
		$datas[] = array('name' => '实际到账', 'value' => $log_info['money'] + $log_info['gives']);
		$datas[] = array('name' => '退款金额', 'value' => $log_info['money'] + $log_info['gives']);
		$datas[] = array('name' => '积分余额', 'value' => $member['credit1'] . $credittext);
		$datas[] = array('name' => '账户余额', 'value' => $member['credit2'] . $yuan);
		$datas[] = array('name' => '提现金额', 'value' => $log_info['money'] . '元');
		$datas[] = array('name' => '提现实际到账', 'value' => $log_info['realmoney'] . '元');
		$datas[] = array('name' => '提现手续费率', 'value' => $log_info['charge']);
		$datas[] = array('name' => '提现手续费', 'value' => $log_info['deductionmoney'] . '元');
		$datas[] = array('name' => '提现渠道', 'value' => $apply_type[$log_info['applytype']]);

		if ($log_info['type'] == 0) {
			if ($log_info['status'] == 1) {
				if ($isback) {
					if (!empty($usernotice['backrecharge_ok'])) {
						return NULL;
					}

					$remark = '
' . $_W['shopset']['shop']['name'] . ('感谢您的支持，如有疑问请联系在线客服或<a href=\'' . $url . '\'>点击进入查看详情</a>');
					$text = '亲爱的[粉丝昵称]，您的' . $moneytext . '发生变动，具体如下：

充值金额：[充值金额]
充值时间：[充值时间]
充值方式：管理员后台处理
当前账户' . $moneytext . '：[账户余额]
' . $remark;
					$money = $log_info['money'] . $yuan;

					if (0 < $log_info['gives']) {
						$totalmoney = $log_info['money'] + $log_info['gives'];
						$money .= '，系统赠送' . $log_info['gives'] . $yuan . '合计:' . $totalmoney . $yuan;
					}

					$message = array(
						'first'    => array('value' => '亲爱的' . $member['nickname'] . '，您的' . $moneytext . '发生变动，具体如下：
', 'color' => '#000000'),
						'keyword1' => array('title' => '充值金额', 'value' => $log_info['money'] . $yuan, 'color' => '#ff0000'),
						'keyword2' => array('title' => '充值时间', 'value' => date('Y-m-d H:i', $log_info['createtime']), 'color' => '#000000'),
						'keyword3' => array('title' => '账户余额', 'value' => $member['credit2'] . $yuan, 'color' => '#ff0000'),
						'remark'   => array('value' => '充值方式：管理员后台处理

' . $_W['shopset']['shop']['name'] . '感谢您的支持，如有疑问请联系在线客服。', 'color' => '#000000')
					);
					$this->sendNotice(array('openid' => $log_info['openid'], 'tag' => 'backrecharge_ok', 'default' => $message, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas, 'appurl' => $appurl));
					com_run('sms::callsms', array('tag' => 'backrecharge_ok', 'datas' => $datas, 'mobile' => $member['mobile']));
				}
				else {
					if (!empty($usernotice['recharge_ok'])) {
						return NULL;
					}

					$remark = '
<a href=\'' . $url . '\'>点击进入查看充值订单详情</a>';
					$text = '您充值已经成功，详情如下：
充值金额：[充值金额]
充值时间：[充值时间]
当前账户' . $moneytext . '：[账户余额]
' . $remark;
					$money = $log_info['money'] . $yuan;

					if (0 < $log_info['gives']) {
						$totalmoney = $log_info['money'] + $log_info['gives'];
						$money .= '，系统赠送' . $log_info['gives'] . $yuan . '，合计:' . $totalmoney . $yuan;
					}

					$message = array(
						'first'    => array('value' => '恭喜您充值成功!', 'color' => '#000000'),
						'keyword1' => array('title' => '充值金额', 'value' => $log_info['money'] . $yuan, 'color' => '#000000'),
						'keyword2' => array('title' => '充值时间', 'value' => date('Y-m-d H:i', $log_info['createtime']), 'color' => '#000000'),
						'keyword3' => array('title' => '账户余额', 'value' => $member['credit2'], 'color' => '#000000'),
						'remark'   => array('value' => '
谢谢您对我们的支持！', 'color' => '#000000')
					);
					$this->sendNotice(array('openid' => $log_info['openid'], 'tag' => 'recharge_ok', 'default' => $message, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas));
					com_run('sms::callsms', array('tag' => 'recharge_ok', 'datas' => $datas, 'mobile' => $member['mobile']));
				}
			}
		}
		else {
			if ($log_info['type'] == 1) {
				if ($log_info['status'] == 1) {
					if (!empty($usernotice['withdraw_ok'])) {
						return NULL;
					}

					$url = $this->getUrl('member/log', array('type' => 1));
					$text = '恭喜您已经成功提现，请检查您的账户余额：

提现金额：[提现金额]
提现手续费：[提现手续费]
实际到账金额：[提现实际到账]
提现渠道：[提现渠道] 

如果您选择银行卡提现，预计在1-2个工作日内到账，如有疑问请联系在线客服或<a href=\'' . $url . '\'>点击进入查看详情</a>';
					$message = array(
						'first'    => array('value' => '恭喜您已经成功提现，请检查您的账户余额。
', 'color' => '#ff0000'),
						'keyword1' => array('title' => '申请提现金额', 'value' => $log_info['money'], 'color' => '#000000'),
						'keyword2' => array('title' => '取提现手续费', 'value' => $log_info['deductionmoney'], 'color' => '#000000'),
						'keyword3' => array('title' => '实际到账金额', 'value' => $log_info['realmoeny'], 'color' => '#000000'),
						'keyword4' => array('title' => '提现渠道', 'value' => $apply_type[$log_info['applytype']], 'color' => '#0a4b9c'),
						'remark'   => array('value' => '
如果您选择银行卡提现，预计在1-2个工作日内到账，如有疑问请联系在线客服或点击查看详情。', 'color' => '#000000')
					);
					$this->sendNotice(array('openid' => $log_info['openid'], 'tag' => 'withdraw_ok', 'default' => $message, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas));
					com_run('sms::callsms', array('tag' => 'withdraw_ok', 'datas' => $datas, 'mobile' => $member['mobile']));
				}
			}
		}
	}

	public function sendStockWarnMessage($goodsid, $optionid)
	{
		global $_W;
		$notice = m('common')->getSysset('notice', false);
		$is_send = 0;

		if (empty($notice['saler_stockwarn_close_advanced'])) {
			$is_send = 1;
		}

		if (!empty($order['merchid']) && p('merch')) {
			$is_merch = 1;
			$merch_tm = p('merch')->getSet('notice', $order['merchid']);
		}

		$goodsid = intval($goodsid);
		$optionid = intval($optionid);
		$set = m('common')->getSysset();
		$tm = $set['notice'];

		if (empty($goodsid)) {
			return NULL;
		}

		$goods = pdo_fetch('select  * from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid', array(':id' => $goodsid, ':uniacid' => $_W['uniacid']));

		if (empty($goods)) {
			return NULL;
		}

		$goodtitle = $goods['title'];

		if (!empty($optionid)) {
			$option = pdo_fetch('select  *  from ' . tablename('ewei_shop_goods_option') . ' where id=:id and uniacid=:uniacid and goodsid = :goodsid', array(':uniacid' => $_W['uniacid'], ':goodsid' => $goodsid, ':id' => $optionid));

			if (!empty($option)) {
				$goodtitle = $goodtitle . '(' . $option['title'] . '}';
			}
		}

		$data = m('common')->getSysset('trade');

		if (!empty($data['stockwarn'])) {
			$stockwarn = intval($data['stockwarn']) . '件';
		}
		else {
			$stockwarn = '5件';
		}

		$datas = array(
			array('name' => '商城名称', 'value' => $_W['shopset']['shop']['name']),
			array('name' => '商品名称', 'value' => $goodtitle),
			array('name' => '预警数量', 'value' => $data['stockwarn'])
		);

		if (!empty($is_send)) {
			$text = '您的' . $_W['shopset']['shop']['name'] . '内的商品：' . $goodtitle . '  
库存已经不足' . $data['stockwarn'] . '件，请及时补货！';
			$msg = array(
				'first'    => array('value' => '您的商品库存已经不足' . $stockwarn . '，请及时补货！
', 'color' => '#ff0000'),
				'keyword2' => array('title' => '处理进度', 'value' => '商品库存不足', 'color' => '#000000'),
				'keyword3' => array('title' => '处理内容', 'value' => '请及时补货', 'color' => '#4b9528'),
				'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
				'remark'   => array('value' => '商品名称：' . $goodtitle, 'color' => '#000000')
			);

			if (!empty($tm['openid3'])) {
				$openids = explode(',', $tm['openid3']);

				foreach ($openids as $tmopenid) {
					if (empty($tmopenid)) {
						continue;
					}

					$sendData = array('openid' => $tmopenid, 'tag' => 'saler_stockwarn', 'default' => $msg, 'cusdefault' => $text, 'datas' => $datas, 'is_merch' => $is_merch, 'merch_tm' => $merch_tm);
					$open_redis = function_exists('redis') && !is_error(redis());

					if ($open_redis) {
						$notice_redis = m('common')->getSysset('notice_redis');

						if (!empty($notice_redis['notice_redis'])) {
							$sendData['is_send'] = 0;
							$sendData['send_underway'] = 0;
							$key = 'notice_uniacid' . $_W['uniacid'] . '_list';
							$redis = redis();
							$redis->rPush($key, serialize($sendData));
						}
						else {
							$this->sendNotice($sendData);
						}
					}
					else {
						$this->sendNotice($sendData);
					}
				}
			}
		}

		if (!empty($tm['mobile']) && empty($tm['saler_stockwarn_close_sms']) && empty($is_merch)) {
			$mobiles = explode(',', $tm['mobile3']);

			foreach ($mobiles as $mobile) {
				if (empty($mobile)) {
					continue;
				}

				com_run('sms::callsms', array('tag' => 'saler_stockwarn', 'datas' => $datas, 'mobile' => $mobile));
			}
		}
	}

	public function sendNotice(array $params)
	{
		global $_W;
		global $_GPC;
		$tag = isset($params['tag']) ? $params['tag'] : '';
		$touser = isset($params['openid']) ? $params['openid'] : '';

		if (empty($touser)) {
			return NULL;
		}

		if (isset($params['plugin']) && !empty($params['plugin'])) {
			$tmdata = m('common')->getPluginset($params['plugin']);
			$tm = $tmdata['tm'];
			$tm_temp = $tm[$tag . '_advanced'];
		}
		else {
			$tm = $_W['shopset']['notice'];

			if (empty($tm)) {
				$tm = m('common')->getSysset('notice');
			}

			$tm_temp = $tm[$tag . '_template'];
		}

		$data = m('common')->getSysset('app');
		$miniprogram = array();
		if (p('app') && !empty($data) && empty($data['closetext']) && !empty($data['appid']) && !empty($params['appurl'])) {
			$miniprogram['appid'] = $data['appid'];
			$miniprogram['pagepath'] = $params['appurl'];
		}

		$templateid = $tm_temp;
		$datas = isset($params['datas']) ? $params['datas'] : array();
		$default_message = isset($params['default']) ? $params['default'] : array();
		$cusdefault_message = $this->replaceTemplate(isset($params['cusdefault']) ? $params['cusdefault'] : '', $datas);
		$url = isset($params['url']) ? $params['url'] : '';
		$account = isset($params['account']) ? $params['account'] : m('common')->getAccount();
		$is_merch = intval($params['is_merch']);

		if (empty($is_merch)) {
			if (!empty($tm[$tag . '_close_advanced'])) {
				return NULL;
			}
		}
		else {
			$merch_tm = isset($params['merch_tm']) ? $params['merch_tm'] : '';

			if (!empty($merch_tm[$tag . '_close_advanced'])) {
				return NULL;
			}
		}

		if (!empty($templateid)) {
			$template = pdo_fetch('select * from ' . tablename('ewei_shop_member_message_template') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $templateid, ':uniacid' => $_W['uniacid']));

			if (!empty($template)) {
				$messagetype = $template['messagetype'];

				if (empty($messagetype)) {
					$template_message = array(
						'first'  => array('value' => $this->replaceTemplate($template['first'], $datas), 'color' => $template['firstcolor']),
						'remark' => array('value' => $this->replaceTemplate($template['remark'], $datas), 'color' => $template['remarkcolor'])
					);
					$data = iunserializer($template['data']);

					if (!empty($data)) {
						foreach ($data as $d) {
							$template_message[$d['keywords']] = array('value' => $this->replaceTemplate($d['value'], $datas), 'color' => $d['color']);
						}
					}

					$Custom_message = $this->replaceTemplate($template['send_desc'], $datas);
					$Custom_message = htmlspecialchars_decode($Custom_message, ENT_QUOTES);
					$ret = m('message')->sendTexts($touser, $Custom_message, $url, $account);

					if (is_error($ret)) {
						$ret = m('message')->sendTplNotice($touser, $template['template_id'], $template_message, $url, $account, $miniprogram);
					}
				}
				else if ($messagetype == 1) {
					$template_message = array(
						'first'  => array('value' => $this->replaceTemplate($template['first'], $datas), 'color' => $template['firstcolor']),
						'remark' => array('value' => $this->replaceTemplate($template['remark'], $datas), 'color' => $template['remarkcolor'])
					);
					$data = iunserializer($template['data']);

					foreach ($data as $d) {
						$template_message[$d['keywords']] = array('value' => $this->replaceTemplate($d['value'], $datas), 'color' => $d['color']);
					}

					$ret = m('message')->sendTplNotice($touser, $template['template_id'], $template_message, $url, $account, $miniprogram);
				}
				else {
					if ($messagetype == 2) {
						$Custom_message = $this->replaceTemplate($template['send_desc'], $datas);
						$Custom_message = htmlspecialchars_decode($Custom_message, ENT_QUOTES);
						$ret = m('message')->sendTexts($touser, $Custom_message, $url, $account);
					}
				}
			}
			else {
				$ret = m('message')->sendTexts($touser, $cusdefault_message, '', $account);

				if (is_error($ret)) {
					$templatetype = pdo_fetch('select templateid  from ' . tablename('ewei_shop_member_message_template_default') . ' where typecode=:typecode and uniacid=:uniacid  limit 1', array(':typecode' => $tag, ':uniacid' => $_W['uniacid']));

					if (!empty($templatetype['templateid'])) {
						$ret = m('message')->sendTplNotice($touser, $templatetype['templateid'], $default_message, $url, $account, $miniprogram);
					}
				}
			}
		}
		else {
			$ret = m('message')->sendTexts($touser, $cusdefault_message, '', $account);

			if (is_error($ret)) {
				$templatetype = pdo_fetch('select templateid  from ' . tablename('ewei_shop_member_message_template_default') . ' where typecode=:typecode and uniacid=:uniacid  limit 1', array(':typecode' => $tag, ':uniacid' => $_W['uniacid']));

				if (!empty($templatetype['templateid'])) {
					$ret = m('message')->sendTplNotice($touser, $templatetype['templateid'], $default_message, $url, $account, $miniprogram);
				}
			}

			$notice_redis = m('common')->getSysset('notice_redis');

			if (!empty($notice_redis['notice_redis'])) {
				if (is_error($ret)) {
					return $ret;
				}
			}
		}

		return $ret;
	}

	public function replaceTemplate($str, $datas = array())
	{
		foreach ($datas as $d) {
			$str = str_replace('[' . $d['name'] . ']', trim($d['value']), $str);
		}

		return $str;
	}

	public function sendOrderChangeMessage($openid, $params, $type)
	{
		global $_W;

		if (empty($openid)) {
			return false;
		}

		$member = m('member')->getMember($openid);

		if ($type == 'orderstatus') {
			$datas = array(
				array('name' => '粉丝昵称', 'value' => $member['nickname']),
				array('name' => '修改时间', 'value' => date('Y-m-d H:i:s', time())),
				array('name' => '订单号', 'value' => $params['orderid']),
				array('name' => '订单编号', 'value' => $params['ordersn']),
				array('name' => '原收货地址', 'value' => $params['olddata']),
				array('name' => '新收货地址', 'value' => $params['data']),
				array('name' => '订单原价格', 'value' => $params['olddata']),
				array('name' => '订单新价格', 'value' => $params['data']),
				array('name' => '订单更新内容', 'value' => $params['title'])
			);

			if (empty($params['url'])) {
				$url = $this->getUrl('order/detail', array('id' => $params['orderid']));
			}
			else {
				$url = $params['url'];
			}

			$msg = array(
				'first'   => array('value' => '亲爱的' . $member['nickname'] . '，您的' . $params['title'] . '已更新，详情如下：', 'color' => '#ff0000'),
				'OrderSn' => array('title' => '订单编号', 'value' => $params['ordersn'], 'color' => '#000000'),
				'remark'  => array('value' => '原收货地址 : ' . $params['olddata'] . '
新收货地址 : ' . $params['data'] . '

如有疑问请联系在线客服。', 'color' => '#000000')
			);

			if ($params['type'] == '1') {
				$datas[] = array('name' => '订单更新类型', 'value' => '订单金额变更');
				$msg['OrderStatus'] = array('title' => '订单状态', 'value' => '订单金额变更', 'color' => '#ff0000');
				$msg['remark'] = array('value' => '订单原价格 : ' . $params['olddata'] . '元
订单新价格 : ' . $params['data'] . '元

如有疑问请联系在线客服。', 'color' => '#000000');
				$text2 = '
订单原价 : ' . $params['olddata'] . '元
订单现价 : ' . $params['data'] . '元';
			}
			else {
				$datas[] = array('name' => '订单更新类型', 'value' => '收货地址变更');
				$msg['OrderStatus'] = array('title' => '订单状态', 'value' => '收货地址变更', 'color' => '#ff0000');
				$text2 = '
原收货地址 : ' . $params['olddata'] . '
新收货地址 : ' . $params['data'];
			}

			$text = '亲爱的[粉丝昵称]，您的[订单更新内容]已更新，详情如下：

订单编号：
[订单编号]
订单状态：[订单更新类型]' . $text2 . ('

<a href=\'' . $url . '\'>点击查看详情</a>');
			$this->sendNotice(array('openid' => $openid, 'tag' => 'orderstatus', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas));
			com_run('sms::callsms', array('tag' => 'orderstatus', 'datas' => $datas, 'mobile' => $member['mobile']));
		}
	}

	public function settemplateidbyback($tag, $uniacid = 0)
	{
		global $_W;
		global $_GPC;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		load()->func('communication');
		$account = m('common')->getAccount();
		$token = $account->fetch_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=' . $token;
		$c = ihttp_request($url);
		$result = json_decode($c['content'], true);

		if (!is_array($result)) {
			return false;
		}

		if (!empty($result['errcode'])) {
			return false;
		}

		$error_message = '';
		$templatenum = count($result['template_list']);
		$templatetype = pdo_fetch('select `name`,templatecode,content  from ' . tablename('ewei_shop_member_message_template_type') . ' where typecode=:typecode  limit 1', array(':typecode' => $tag));

		if (empty($templatetype)) {
			return false;
		}

		$content = str_replace('
', '', $templatetype['content']);
		$issnoet = true;

		foreach ($result['template_list'] as $key => $value) {
			if (str_replace('
', '', $value['content']) == $content) {
				$issnoet = false;
				$defaulttemp = pdo_fetch('select 1  from ' . tablename('ewei_shop_member_message_template_default') . ' where typecode=:typecode and uniacid=:uniacid  limit 1', array(':typecode' => $tag, ':uniacid' => $uniacid));

				if (empty($defaulttemp)) {
					pdo_insert('ewei_shop_member_message_template_default', array('typecode' => $tag, 'uniacid' => $uniacid, 'templateid' => $value['template_id']));
				}
				else {
					pdo_update('ewei_shop_member_message_template_default', array('templateid' => $value['template_id']), array('typecode' => $tag, 'uniacid' => $uniacid));
				}

				return true;
			}
		}

		if ($issnoet) {
			if (25 <= $templatenum) {
				return false;
			}

			$bb = '{"template_id_short":"' . $templatetype['templatecode'] . '"}';
			$account = m('common')->getAccount();
			$token = $account->fetch_token();
			$url = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=' . $token;
			$ch1 = curl_init();
			curl_setopt($ch1, CURLOPT_URL, $url);
			curl_setopt($ch1, CURLOPT_POST, 1);
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch1, CURLOPT_POSTFIELDS, $bb);
			$c = curl_exec($ch1);
			$result = @json_decode($c, true);

			if (!is_array($result)) {
				return false;
			}

			if (!empty($result['errcode'])) {
				if (strstr($result['errmsg'], 'template conflict with industry hint')) {
					return false;
				}

				if (strstr($result['errmsg'], 'system error hint')) {
					return false;
				}

				if (strstr($result['errmsg'], 'invalid industry id hint')) {
					return false;
				}

				if (strstr($result['errmsg'], 'access_token is invalid or not latest hint')) {
					return false;
				}

				return false;
			}

			$defaulttemp = pdo_fetch('select 1  from ' . tablename('ewei_shop_member_message_template_default') . ' where typecode=:typecode and uniacid=:uniacid  limit 1', array(':typecode' => $tag, ':uniacid' => $uniacid));

			if (empty($defaulttemp)) {
				pdo_insert('ewei_shop_member_message_template_default', array('typecode' => $tag, 'uniacid' => $uniacid, 'templateid' => $value['template_id']));
			}
			else {
				pdo_update('ewei_shop_member_message_template_default', array('templateid' => $value['template_id']), array('typecode' => $tag, 'uniacid' => $uniacid));
			}
		}

		return true;
	}

	public function sendVerifygoodMessage($verifygoodlogid)
	{
		global $_W;
		$item = pdo_fetch('select vgl.*,vg.limitnum,s.storename,sa.salername,sa.openid as saleropenid,o.openid,g.title,o.ordersn  from ' . tablename('ewei_shop_verifygoods_log') . '   vgl
		left  join ' . tablename('ewei_shop_store') . ' s on s.id = vgl.storeid
		left  join ' . tablename('ewei_shop_saler') . ' sa on sa.id = vgl.salerid
		inner  join ' . tablename('ewei_shop_verifygoods') . ' vg on vg.id = vgl.verifygoodsid
		inner  join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
		inner  join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid
		left  join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
	  where  vgl.id =:id  and vgl.uniacid=:uniacid  limit 1', array(':id' => $verifygoodlogid, ':uniacid' => $_W['uniacid']));
		$verifygoodlogs = pdo_fetchall('select *  from ' . tablename('ewei_shop_verifygoods_log') . '    where verifygoodsid =:id  ', array(':id' => $item['verifygoodsid']));
		$verifynum = 0;

		foreach ($verifygoodlogs as $verifygoodlog) {
			$verifynum += intval($verifygoodlog['verifynum']);
		}

		if (!empty($item['limitnum'])) {
			$lastverifys = intval($item['limitnum']) - $verifynum;
		}
		else {
			$lastverifys = '不限';
		}

		$member = m('member')->getMember($item['openid']);
		$saler = m('member')->getMember($item['saleropenid']);
		$datas = array(
			array('name' => '粉丝昵称', 'value' => $member['nickname']),
			array('name' => '商城名称', 'value' => $_W['shopset']['shop']['name']),
			array('name' => '门店名称', 'value' => $item['storename']),
			array('name' => '核销员', 'value' => $saler['nickname']),
			array('name' => '商品名称', 'value' => $item['title']),
			array('name' => '核销时间', 'value' => date('Y-m-d H:i:s', $item['verifydate'])),
			array('name' => '当前记次', 'value' => $verifynum),
			array('name' => '剩余次数', 'value' => $lastverifys),
			array('name' => '核销订单编号', 'value' => $item['ordersn']),
			array('name' => '总核销次数', 'value' => $verifynum + $lastverifys)
		);
		$notice = m('common')->getSysset('notice', false);

		if (empty($notice['o2o_bverify_close_advanced'])) {
			$url = $this->getUrl('verifygoods/detail', array('id' => $item['verifygoodsid']));
			$text = '您的订单已成功核销!

核销项目： [商品名称] 
核销时间：[核销时间] 
核销门店：[门店名称]
核销数量：[当前记次]
剩余数量：[剩余次数]
总核销次数：[总核销次数]
感谢您的使用！
<a href=\'' . $url . '\'>点击快速查询核销信息</a>';
			$msg = array(
				'first'    => array('value' => '您的订单已成功核销！
', 'color' => '#ff0000'),
				'keyword1' => array('title' => '核销项目', 'value' => $item['title'], 'color' => '#000000'),
				'keyword2' => array('title' => '核销时间', 'value' => date('Y-m-d H:i:s', $item['verifydate']), 'color' => '#4b9528'),
				'keyword3' => array('title' => '核销门店', 'value' => $item['storename'], 'color' => '#4b9528'),
				'remark'   => array('value' => '核销数量：' . $verifynum . '
 剩余数量：' . $lastverifys . '
感谢您的使用！', 'color' => '#000000')
			);
			$this->sendNotice(array('openid' => $member['openid'], 'tag' => 'o2o_bverify', 'default' => $msg, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas));
			com_run('sms::callsms', array('tag' => 'o2o_bverify', 'datas' => $datas, 'mobile' => $member['mobile']));
		}

		if (empty($notice['o2o_sverify_close_advanced'])) {
			$text = '您成功核销了一笔订单！

核销项目： [商品名称] 
核销时间：[核销时间] 
核销门店：[门店名称]
订单编号：
[核销订单编号]
核销数量：[当前记次]
剩余数量：[剩余次数]
如有变动可登录管理后台进行操作！';
			$msg = array(
				'first'    => array('value' => '您成功核销了一笔订单！
', 'color' => '#ff0000'),
				'keyword1' => array('title' => '核销项目', 'value' => $item['title'], 'color' => '#000000'),
				'keyword2' => array('title' => '核销时间', 'value' => date('Y-m-d H:i:s', $item['verifydate']), 'color' => '#4b9528'),
				'keyword3' => array('title' => '核销门店', 'value' => $item['storename'], 'color' => '#4b9528'),
				'remark'   => array('value' => '核销订单编号:' . $item['ordersn'] . ' 
核销数量：' . $verifynum . '
 剩余数量：' . $lastverifys . '
如有变动可登录管理后台进行操作！', 'color' => '#000000')
			);
			$this->sendNotice(array('openid' => $saler['openid'], 'tag' => 'o2o_sverify', 'default' => $msg, 'cusdefault' => $text, 'url' => '', 'datas' => $datas));
			com_run('sms::callsms', array('tag' => 'o2o_bverify', 'datas' => $datas, 'mobile' => $saler['mobile']));
		}
	}

	/**
     * 瓜分券默认活动发起通知
     */
	public function sendFriendCouponTemplateMessage($openid, $params, $type)
	{
		$type = 'friendcoupon_' . $type;
		$allowTypes = array('friendcoupon_launch', 'friendcoupon_complete', 'friendcoupon_failed');
		if (!in_array($type, $allowTypes) || !$openid) {
			return false;
		}

		$datas = array(
			array('name' => '活动名称', 'value' => $params['activity_title']),
			array('name' => '活动开始时间', 'value' => $params['activity_start_time']),
			array('name' => '活动结束时间', 'value' => $params['activity_end_time']),
			array('name' => '瓜分券领取时间', 'value' => $params['receiveTime']),
			array('name' => '瓜分券名称', 'value' => $params['couponName'])
		);

		switch ($type) {
		case 'friendcoupon_launch':
			$defaultTemplate = array(
				'keyword1' => array('value' => '瓜分券活动领取成功！'),
				'keyword2' => array('value' => '[活动名称]活动领取成功', 'color' => '#4b9528'),
				'keyword3' => array('value' => '您于[瓜分券领取时间]领取[活动名称]活动')
			);
			break;

		case 'friendcoupon_complete':
			$defaultTemplate = array(
				'keyword1' => array('value' => '瓜分券活动完成通知！'),
				'keyword2' => array('value' => '[活动名称]活动完成', 'color' => '#4b9528'),
				'keyword3' => array('value' => '您于[瓜分券领取时间]领取[瓜分券名称]')
			);
			break;

		case 'friendcoupon_failed':
			$defaultTemplate = array(
				'keyword1' => array('value' => '瓜分券活动失败通知！'),
				'keyword2' => array('value' => '[活动名称]活动失败', 'color' => '#4b9528'),
				'keyword3' => array('value' => '您于[瓜分券领取时间]领取的[活动名称]未在规定时间内完成')
			);
			break;
		}

		foreach ($defaultTemplate as $key => $item) {
			$defaultTemplate[$key]['value'] = $this->replaceTemplate($item['value'], $datas);
		}

		unset($item);
		return $this->sendNotice(array('openid' => $openid, 'tag' => $type, 'datas' => $datas, 'url' => $params['url'], 'default' => $defaultTemplate));
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
