<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

define('TM_CREDITSHOP_LOTTERY', 'TM_CREDITSHOP_LOTTERY');
define('TM_CREDITSHOP_EXCHANGE', 'TM_CREDITSHOP_EXCHANGE');
define('TM_CREDITSHOP_WIN', 'TM_CREDITSHOP_WIN');

if (!class_exists('CycelbuyModel')) {
	class CycelbuyModel extends PluginModel
	{
		public function cycelbuy_periodic($orderid)
		{
			global $_GPC;
			global $_W;
			$openid = $_W['openid'];
			$sql = 'SELECT id,ordersn,status,cycelbuy_periodic,cycelbuy_predict_time,iscycelbuy,addressid,dispatchprice,dispatchtype FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and iscycelbuy=1 and uniacid =:uniacid';
			$param = array(':id' => intval($orderid), ':uniacid' => intval($_W['uniacid']));
			$order = pdo_fetch($sql, $param);

			if ($order['status'] == 1) {
				$cycelbuy_periodic = explode(',', $order['cycelbuy_periodic']);
				$cycelbuy_day = $cycelbuy_periodic[0];
				$cycelbuy_unit = $cycelbuy_periodic[1];
				$cycelbuy_num = $cycelbuy_periodic[2];

				if ($cycelbuy_unit == 1) {
					$cycelbuy_day = $cycelbuy_day * 7;
				}
				else {
					if ($cycelbuy_unit == 2) {
						$cycelbuy_day = $cycelbuy_day * 30;
					}
				}

				$addressSql = 'SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id=:id and uniacid=:uniacid';
				$addressParam = array(':id' => $order['addressid'], ':uniacid' => $_W['uniacid']);
				$address = pdo_fetch($addressSql, $addressParam);
				$addressInfo = serialize($address);
				$data['orderid'] = $order['id'];
				$data['uniacid'] = $_W['uniacid'];
				$data['status'] = 0;
				$data['addressid'] = $order['addressid'];
				$data['address'] = $addressInfo;
				$data['dispatchprice'] = $order['dispatchprice'] / $cycelbuy_num;
				$data['createtime'] = time();
				$data['dispatchtype'] = $order['dispatchtype'];
				$i = 0;

				while ($i < $cycelbuy_num) {
					$data['cycelsn'] = $order['ordersn'] . '_' . ($i + 1);

					if ($i == 0) {
						$data['receipttime'] = $order['cycelbuy_predict_time'];
					}
					else {
						$data['receipttime'] = $order['cycelbuy_predict_time'] + 86400 * $i * $cycelbuy_day;
					}

					pdo_insert('ewei_shop_cycelbuy_periods', $data);
					++$i;
				}
			}
		}

		/**
         * 消息通知
         * @param type $message_type
         * @param type $openid
         * @return type
         */
		public function sendMessage($openid = '', $data = array(), $message_type = '')
		{
			global $_W;
			global $_GPC;
			$set = $this->getSet();
			$tm = $set['tm'];
			$templateid = $tm['templateid'];
			$time = date('Y-m-d H:i', time());
			$member = m('member')->getMember($openid);
			$usernotice = unserialize($member['noticeset']);

			if (!is_array($usernotice)) {
				$usernotice = array();
			}

			if ($message_type == TM_CYCELBUY_SELLER_DATE) {
				if ($tm['cycelbuy_seller_date_close_advanced']) {
					return false;
				}

				if (empty($tm['openids'])) {
					return false;
				}

				$tag = 'cycelbuy_seller_date';
				$text = $data['nickname'] . '修改了收货时间！
' . date('Y-m-d H:i') . '
';
				$message = array(
					'first'    => array('value' => $data['nickname'] . '修改了收货时间', 'color' => '#ff0000'),
					'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
					'keyword2' => array('title' => '业务内容', 'value' => $data['nickname'] . '修改了收货时间', 'color' => '#000000'),
					'keyword3' => array('title' => '处理结果', 'value' => '修改收货时间通知', 'color' => '#000000'),
					'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
					'remark'   => array('value' => '
感谢您的支持', 'color' => '#000000')
				);
				$datas[] = array('name' => '昵称', 'value' => $data['nickname']);
				$datas[] = array('name' => '订单编号', 'value' => $data['ordersn']);
				$datas[] = array('name' => '新收货时间', 'value' => $data['goods']);
				$openids = explode(',', $tm['openids']);

				foreach ($openids as $openid) {
					m('notice')->sendNotice(array('openid' => $openid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'datas' => $datas, 'plugin' => 'cycelbuy'));
				}
			}
			else if ($message_type == TM_CYCELBUY_SELLER_ADDRESS) {
				if ($tm['cycelbuy_seller_address_close_advanced']) {
					return false;
				}

				if (empty($tm['openids'])) {
					return false;
				}

				$tag = 'cycelbuy_seller_address';
				$text = $data['nickname'] . '修改了收货地址！
' . date('Y-m-d H:i') . '
';
				$message = array(
					'first'    => array('value' => $data['nickname'] . '修改了收货地址！', 'color' => '#ff0000'),
					'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
					'keyword2' => array('title' => '业务内容', 'value' => $data['nickname'] . '修改了收货地址', 'color' => '#000000'),
					'keyword3' => array('title' => '处理结果', 'value' => '修改收货地址通知', 'color' => '#000000'),
					'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
					'remark'   => array('value' => '
感谢您的支持', 'color' => '#000000')
				);
				$datas[] = array('name' => '昵称', 'value' => $data['nickname']);
				$datas[] = array('name' => '新收货地址', 'value' => $data['newaddress']);
				$datas[] = array('name' => '时间', 'value' => date('Y-m-d H:i:s', $data['paytime']));
				$datas[] = array('name' => '订单编号', 'value' => $data['ordersn']);
				$openids = implode(',', $tm['openids']);

				foreach ($openids as $openid) {
					m('notice')->sendNotice(array('openid' => $openid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'datas' => $datas, 'plugin' => 'cycelbuy'));
				}
			}
			else if ($message_type == TM_CYCELBUY_BUYER_DATE) {
				if ($tm['cycelbuy_buyer_date_close_advanced']) {
					return false;
				}

				$tag = 'cycelbuy_buyer_date';
				$text = '您已修改了收货时间！
' . date('Y-m-d H:i') . '
';
				$message = array(
					'first'    => array('value' => '亲爱的' . $data['nickname'] . '，您修改了收货时间', 'color' => '#ff0000'),
					'keyword2' => array('title' => '处理进度', 'value' => '修改收货时间通知', 'color' => '#000000'),
					'keyword3' => array('title' => '处理内容', 'value' => '您的收货时间已修改', 'color' => '#000000'),
					'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
					'remark'   => array('value' => '
感谢您的支持', 'color' => '#000000')
				);
				$toopenid = $openid;
				$datas[] = array('name' => '昵称', 'value' => $data['nickname']);
				$datas[] = array('name' => '新收货时间', 'value' => $data['newdate']);
				$datas[] = array('name' => '时间', 'value' => $time);
				$datas[] = array('name' => '订单编号', 'value' => $data['ordersn']);
				m('notice')->sendNotice(array('openid' => $toopenid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'datas' => $datas, 'plugin' => 'cycelbuy'));
			}
			else if ($message_type == TM_CYCELBUY_BUYER_ADDRESS) {
				if ($tm['cycelbuy_buyer_address_close_advanced']) {
					return false;
				}

				$tag = 'cycelbuy_buyer_address';
				$text = '您的收货地址已修改！
' . date('Y-m-d H:i') . '
';
				$message = array(
					'first'    => array('value' => '亲爱的' . $member['nickname'] . '，您的收货地址修改完成', 'color' => '#ff0000'),
					'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
					'keyword2' => array('title' => '业务内容', 'value' => '您的收货地址修改已完成', 'color' => '#000000'),
					'keyword3' => array('title' => '处理结果', 'value' => '修改收货地址通知', 'color' => '#000000'),
					'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
					'remark'   => array('value' => '
感谢您的支持', 'color' => '#000000')
				);
				$toopenid = $openid;
				$datas[] = array('name' => '昵称', 'value' => $member['nickname']);
				$datas[] = array('name' => '新收货地址', 'value' => $data['newaddress']);
				$datas[] = array('name' => '时间', 'value' => $time);
				$datas[] = array('name' => '订单编号', 'value' => $data['ordersn']);
				m('notice')->sendNotice(array('openid' => $toopenid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'datas' => $datas, 'plugin' => 'cycelbuy'));
			}
			else {
				if ($message_type == TM_CYCELBUY_SELLER_SEND) {
					if ($tm['cycelbuy_timing_close_advanced']) {
						return false;
					}

					$address = iunserializer($data['address']);
					$tag = 'cycelbuy_timing';
					$text = '您有新的已付款订单！！
请及时安排发货。

订单号：
' . $data['ordersn'] . '
订单金额：' . $data['price'] . '
---------------------
收货人：' . $address['realname'] . '
收货人电话:' . $address['mobile'] . '
收货地址:' . $address['province'] . $address['city'] . $address['area'] . $address['address'] . '
期数:' . $data['num'] . ' 

请及时安排发货';
					$message = array(
						'first'    => array('value' => '您有订单需要发货，请及时安排！', 'color' => '#ff0000'),
						'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
						'keyword2' => array('title' => '业务内容', 'value' => '订单发货通知', 'color' => '#000000'),
						'keyword3' => array('title' => '处理结果', 'value' => '订单发货通知', 'color' => '#000000'),
						'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
						'remark'   => array('value' => '
感谢您的支持', 'color' => '#000000')
					);
					$datas[] = array('name' => '订单编号', 'value' => $data['ordersn']);
					$datas[] = array('name' => '订单金额', 'value' => $data['price']);
					$datas[] = array('name' => '收货人', 'value' => $address['realname']);
					$datas[] = array('name' => '收货人电话', 'value' => $address['mobile']);
					$datas[] = array('name' => '收货地址', 'value' => $address['province'] . $address['city'] . $address['area'] . $address['address']);
					$datas[] = array('name' => '期数', 'value' => $data['num']);
					$datas[] = array('name' => '时间', 'value' => $time);
					$openids = explode(',', $tm['openids']);

					foreach ($openids as $openid) {
						m('notice')->sendNotice(array('openid' => $openid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'datas' => $datas, 'plugin' => 'cycelbuy'));
					}
				}
			}
		}
	}
}

?>
