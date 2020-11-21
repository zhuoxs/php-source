<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Detail_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$type = $_GPC['type'];

		if ($type == 'all') {
			$lists = $this->model->get_Allcard(1, 100);
		}
		else {
			$lists = $this->model->get_Mycard('', 0, 100);
		}

		$card_list = array();

		foreach ($lists['list'] as $key => &$value) {
			$quanyi = 0;
			$card_history = $this->model->getMembercard_order_history($value['id']);

			if ($card_history) {
				if ($card_history['expire_time'] == -1) {
					$expire_data = '永久有效';
				}
				else {
					$expire_data = date('Y-m-d H:i', $card_history['expire_time']);
				}

				$kaitong = false;
			}
			else {
				$expire_data = false;
				$kaitong = true;
			}

			$expire_card_history = $card_history = $this->model->getExpireMembercard_order_history($value['id']);

			if ($expire_card_history) {
				$chongxin_kaitong = true;
			}
			else {
				$chongxin_kaitong = false;
			}

			if ($value['shipping']) {
				$quanyi = $quanyi + 1;
			}

			if ($value['member_discount'] || $value['discount']) {
				$quanyi = $quanyi + 1;
			}

			if ($value['is_card_points']) {
				$quanyi = $quanyi + 1;
			}

			if ($value['is_card_coupon']) {
				$quanyi = $quanyi + 1;
			}

			if ($value['is_month_points']) {
				$quanyi = $quanyi + 1;
			}

			if ($value['is_month_coupon']) {
				$quanyi = $quanyi + 1;
			}

			$value['quanyi'] = $quanyi;
			$value['expire'] = $expire_data;
			$value['kaitong'] = $kaitong;
			$value['chongxin_kaitong'] = $chongxin_kaitong;
			$value['expire_time'] = $card_history['expire_time'];
			$card_list[$key] = $value;
		}

		include $this->template();
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['card_id'];
		$card_info = $this->model->getMemberCard($id);

		if ($card_info['month_coupon']) {
			$month_coupon = iunserializer($card_info['month_coupon']);
			$coupons_month_list = p('membercard')->querycoupon($month_coupon['couponid']);

			foreach ($coupons_month_list as $cpk => $cpv) {
				$is_receive_month_coupon = $this->model->check_month_coupon($id, $_W['openid'], $cpv['id']);

				if ($is_receive_month_coupon) {
					$coupons_month_list[$cpk]['coupon_receive'] = true;
				}
				else {
					$coupons_month_list[$cpk]['coupon_receive'] = false;
				}

				$coupons_month_list[$cpk]['couponnum'] = $month_coupon['paycpnum' . ($cpk + 1)];
			}

			$list['coupon_month'] = $coupons_month_list;
		}

		if ($card_info['card_coupon']) {
			$card_coupon = iunserializer($card_info['card_coupon']);
			$coupons_card_list = p('membercard')->querycoupon($card_coupon['couponids']);

			foreach ($coupons_card_list as $cpk => $cpv) {
				$condition = ' uniacid = :uniacid and openid=:openid and member_card_id=:card_id';
				$condition .= ' and sendtype=2 and card_couponid=:couponid';
				$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':card_id' => $id, ':couponid' => $cpv['id']);
				$buysend_coupon = $this->model->get_member_card_buysend($condition, $params);

				if ($buysend_coupon) {
					$coupons_card_list[$cpk]['buysend_coupon'] = true;
				}
				else {
					$coupons_card_list[$cpk]['buysend_coupon'] = false;
				}

				$coupons_card_list[$cpk]['couponnum'] = $card_coupon['paycpnum' . ($cpk + 1)];
			}

			$list['coupon_card'] = $coupons_card_list;
		}

		$quanyi = array();

		if ($card_info['shipping']) {
			$quanyi[] = array('icon' => 'icon-mianfeibaoyou', 'text' => '免费包邮');
		}

		if ($card_info['member_discount']) {
			$quanyi[] = array('icon' => 'icon-zhekoutequan', 'text' => '折扣特权');
			$list['member_discount'] = true;
			$list['discount_rate'] = $card_info['discount_rate'];
		}
		else {
			$list['member_discount'] = false;
		}

		if ($card_info['is_card_coupon']) {
			$quanyi[] = array('icon' => 'icon-kaiqiasongquan', 'text' => '开卡送券');
		}

		if ($card_info['is_card_points']) {
			$condition = ' uniacid = :uniacid and openid=:openid and member_card_id=:card_id';
			$condition .= ' and sendtype=1';
			$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':card_id' => $id);
			$buysend = $this->model->get_member_card_buysend($condition, $params);

			if ($buysend) {
				$kaika_jifen = true;
			}
			else {
				$kaika_jifen = false;
			}

			$quanyi[] = array('icon' => 'icon-kaiqiajifen', 'text' => '开卡送积分');
			$list['is_card_points'] = true;
			$list['card_points'] = $card_info['card_points'];
		}
		else {
			$card_points = false;
			$list['is_card_points'] = false;
			$kaika_jifen = false;
		}

		$list['kaika_jifen'] = $kaika_jifen;

		if ($card_info['is_month_coupon']) {
			$quanyi[] = array('icon' => 'icon-meiyuelingquan', 'text' => '每月领券');
		}

		if ($card_info['is_month_points']) {
			$check_month_point = $this->model->check_month_point($id, $_W['openid']);

			if ($check_month_point) {
				$is_check_month_point = true;
			}
			else {
				$is_check_month_point = false;
			}

			$month_card_points = $card_info['month_points'];
			$quanyi[] = array('icon' => 'icon-meiyuejifen', 'text' => '每月积分');
			$list['is_month_points'] = true;
			$list['month_points'] = $card_info['month_points'];
		}
		else {
			$month_card_points = false;
			$is_check_month_point = false;
			$list['is_month_points'] = false;
		}

		$list['is_check_month_point'] = $is_check_month_point;
		$quanyi[] = array('icon' => 'icon-meiyuelingquan', 'text' => '敬请期待');
		$card_history = $this->model->getMembercard_order_history($id);

		if ($card_history) {
			if ($card_history['expire_time'] == -1) {
				$goumai = 3;
			}
			else {
				$goumai = 2;
			}
		}
		else {
			$goumai = 1;
		}

		$expire_card_history = $card_history = $this->model->getExpireMembercard_order_history($card_info['id']);

		if ($expire_card_history) {
			$chongxin_kaitong = true;
		}
		else {
			$chongxin_kaitong = false;
		}

		$list['quanyi'] = $quanyi;
		$list['card_name'] = $card_info['name'];
		$list['card_description'] = $card_info['description'];
		$list['goumai'] = $goumai;
		$list['chongxin_kaitong'] = $chongxin_kaitong;
		$list['price'] = $card_info['price'];

		if ($card_info['validate'] == -1) {
			$list['validate'] = '永久有效';
			$list['expire'] = -1;
		}
		else {
			$list['validate'] = $card_info['validate'] . '个月';
			$list['expire'] = $card_info['validate'];
		}

		show_json(1, array('list' => $list, 'pagesize' => 1, 'total' => 20));
	}

	public function membercard_complete()
	{
		global $_GPC;
		global $_W;
		$set = m('common')->getSysset(array('shop', 'pay'));
		$fromwechat = intval($_GPC['fromwechat']);
		$tid = $_GPC['out_trade_no'];

		if (is_h5app()) {
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);
			$alidata = base64_decode($_GET['alidata']);
			$alidata = json_decode($alidata, true);
			$sign_type = trim($alidata['sign_type'], '"');

			if ($sign_type == 'RSA') {
				$public_key = $sec['app_alipay']['public_key'];
			}
			else {
				if ($sign_type == 'RSA2') {
					$public_key = $sec['app_alipay']['public_key_rsa2'];
				}
			}

			if (empty($set['pay']['app_alipay']) || empty($public_key)) {
				$this->message('支付出现错误，请重试(1)!', mobileUrl('order'));
			}

			$alisign = m('finance')->RSAVerify($alidata, $public_key, false);
			$tid = $this->str($alidata['out_trade_no']);

			if ($alisign == 0) {
				$this->message('支付出现错误，请重试(2)!', mobileUrl('order'));
			}

			if (strexists($tid, 'GJ')) {
				$tids = explode('GJ', $tid);
				$tid = $tids[0];
			}
		}
		else {
			if (empty($set['pay']['alipay'])) {
				$this->message('未开启支付宝支付!', mobileUrl('order'));
			}

			if (!m('finance')->isAlipayNotify($_GET)) {
				$log = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'membercard', ':tid' => $tid));
				if ($log['status'] == 1 && $log['fee'] == $_GPC['total_fee']) {
					if ($fromwechat) {
						$this->message(array('message' => '请返回微信查看支付状态', 'title' => '支付成功!', 'buttondisplay' => false), NULL, 'success');
					}
					else {
						$this->message(array('message' => '请返回商城查看支付状态', 'title' => '支付成功!'), mobileUrl('membercard'), 'success');
					}
				}

				$this->message(array('message' => '支付出现错误，请重试(支付验证失败)!', 'buttondisplay' => $fromwechat ? false : true), $fromwechat ? NULL : mobileUrl('membercard'));
			}
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'membercard', ':tid' => $tid));

		if (empty($log)) {
			$this->message(array('message' => '支付出现错误，请重试(支付验证失败2)!', 'buttondisplay' => $fromwechat ? false : true), $fromwechat ? NULL : mobileUrl('membercard'));
		}

		if (is_h5app()) {
			$alidatafee = $this->str($alidata['total_fee']);
			$alidatastatus = $this->str($alidata['success']);
			if ($log['fee'] != $alidatafee || !$alidatastatus) {
				$this->message('支付出现错误，请重试(4)!', mobileUrl('membercard'));
			}
		}

		if ($log['status'] != 1) {
			$record = array();
			$record['status'] = '1';
			$record['paytype'] = 'alipay';
			pdo_update('core_paylog', $record, array('plid' => $log['plid']));
			$orderid = pdo_fetchcolumn('select id from ' . tablename('ewei_shop_member_card_order') . ' where orderno=:orderno and uniacid=:uniacid', array(':orderno' => $log['tid'], ':uniacid' => $_W['uniacid']));

			if (!empty($orderid)) {
				$this->model->payResult($log['tid'], 'alipay', $log['fee'], is_h5app() ? true : false);
				$data_alipay = array('transid' => $_GET['trade_no']);

				if (is_h5app()) {
					$data_alipay['transid'] = $alidata['trade_no'];
					$data_alipay['apppay'] = 1;
				}

				pdo_update('ewei_shop_member_card_order', $data_alipay, array('id' => $orderid));
			}
		}

		if (is_h5app()) {
			$url = mobileUrl('membercard/detail', array('id' => $orderid), true);
			exit('<script>top.window.location.href=\'' . $url . '\'</script>');
		}
		else if ($fromwechat) {
			$this->message(array('message' => '请返回微信查看支付状态', 'title' => '支付成功!', 'buttondisplay' => false), NULL, 'success');
		}
		else {
			$this->message(array('message' => '请返回商城查看支付状态', 'title' => '支付成功!'), mobileUrl('membercard'), 'success');
		}
	}
}

?>
