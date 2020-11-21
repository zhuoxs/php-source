<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Index_EweiShopV2Page extends AppMobilePage
{
	public function getlist()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$cate = trim($_GPC['cate']);
		$cate = empty($cate) ? 'all' : $cate;
		$plugin_membercard = p('membercard');

		if (!$plugin_membercard) {
			return app_error(AppError::$PluginNotFound);
		}

		if ($cate == 'my') {
			$all = $plugin_membercard->get_Mycard($openid, $_GPC['page']);
			$list = $all['list'];
			$psize = $all['psize'];
			$total = $all['total'];
			$condition = ' uniacid = :uniacid ';
			$params = array(':uniacid' => $_W['uniacid']);
			$condition .= ' and status=1 and isdelete=0';
			$all_total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_member_card') . ('where ' . $condition), $params);
			$my_total = $all['total'];
		}
		else {
			$all = $plugin_membercard->get_Allcard($_GPC['page']);
			$list = $all['list'];
			$psize = $all['psize'];
			$total = $all['total'];
			$card_condition = 'openid =:openid and uniacid=:uniacid and isdelete=0';
			$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid);
			$now_time = TIMESTAMP;
			$card_condition .= ' and (expire_time=-1 or expire_time>' . $now_time . ')';
			$my_total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_member_card_history') . (' 
				WHERE ' . $card_condition . ' limit 1'), $params);
			$all_total = $all['total'];
		}

		return app_json(array('list' => $list, 'pagesize' => $psize, 'total' => $total, 'my_total' => $my_total, 'all_total' => $all_total));
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		$cate = trim($_GPC['cate']);
		$cate = empty($cate) ? 'all' : $cate;
		$openid = $_W['openid'];
		$plugin_membercard = p('membercard');

		if (!$plugin_membercard) {
			return app_error(AppError::$PluginNotFound);
		}

		if ($cate == 'my') {
			$all = $plugin_membercard->get_Mycard($openid, $_GPC['page']);
			$list = $all['list'];
			$psize = $all['psize'];
			$total = $all['total'];
		}
		else {
			$all = $plugin_membercard->get_Allcard($_GPC['page']);
			$list = $all['list'];
			$psize = $all['psize'];
			$total = $all['total'];
		}

		if (!empty($list)) {
			foreach ($list as $key => $val) {
				$card = $val;
				$rightsnum = 0;

				if ($card['shipping']) {
					$rightsnum += 1;
				}

				if ($card['member_discount']) {
					$rightsnum += 1;
				}

				$condition = ' and uniacid=:uniacid and openid =:openid and member_card_id = :cardid  ';
				$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':cardid' => $card['id']);

				if ($card['is_card_points']) {
					$rightsnum += 1;
					$send_point = false;
					$buysend_point = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_card_buysend') . (' 
				WHERE sendtype=1 ' . $condition), $params);

					if ($buysend_point) {
						$send_point = true;
					}

					$card['send_point'] = $send_point;
				}

				if ($card['is_card_coupon']) {
					$rightsnum += 1;
					$card_coupon = iunserializer($card['card_coupon']);
					$card_coupons = array();

					if ($card_coupon['couponids']) {
						$card_coupons = $plugin_membercard->querycoupon($card_coupon['couponids']);

						foreach ($card_coupons as $key1 => $val1) {
							$send_coupon = false;
							$condition .= ' and card_couponid = :card_couponid ';
							$params[':card_couponid'] = $val1['id'];
							$buysend_coupon = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_card_buysend') . (' 
				WHERE sendtype=2 ' . $condition), $params);

							if ($buysend_coupon) {
								$send_coupon = true;
							}

							$card_coupons[$key1]['send_coupon'] = $send_coupon;
							$send_coupon_num = 1;

							if ($card_coupon['paycpnum' . ($key1 + 1)]) {
								$send_coupon_num = $card_coupon['paycpnum' . ($key1 + 1)];
							}

							$card_coupons[$key1]['send_coupon_num'] = $send_coupon_num;
						}
					}

					$card['card_coupon'] = $card_coupons;
				}
				else {
					unset($card['card_coupon']);
				}

				if ($card['is_month_points']) {
					$rightsnum += 1;
					$isget_month_point = false;

					if ($plugin_membercard->check_month_point($card['id'], $openid)) {
						$isget_month_point = true;
					}

					$card['isget_month_point'] = $isget_month_point;
				}

				if ($card['is_month_coupon']) {
					$rightsnum += 1;
					$month_coupon = iunserializer($card['month_coupon']);
					$month_coupons = array();

					if ($month_coupon['couponid']) {
						$month_coupons = $plugin_membercard->querycoupon($month_coupon['couponid']);

						foreach ($month_coupons as $key2 => $val2) {
							$isget_month_coupon = false;

							if ($plugin_membercard->check_month_coupon($card['id'], $openid, $val2['id'])) {
								$isget_month_coupon = true;
							}

							$month_coupons[$key2]['isget_month_coupon'] = $isget_month_coupon;
							$month_coupon_num = 1;

							if ($month_coupon['paycpnum' . ($key2 + 1)]) {
								$month_coupon_num = $month_coupon['paycpnum' . ($key2 + 1)];
							}

							$month_coupons[$key2]['month_coupon_num'] = $month_coupon_num;
						}
					}

					$card['month_coupon'] = $month_coupons;
				}
				else {
					unset($card['month_coupon']);
				}

				$card_validate = $card['validate'];
				$card['rightsnum'] = $rightsnum;
				$card['card_validate'] = str_replace('有效期:', '', $card_validate);
				$list[$key] = $card;
				unset($card);
			}
		}

		return app_json(array('list' => $list, 'pagesize' => $psize, 'total' => $total, 'currentid' => $id));
	}

	public function get_month_point()
	{
		global $_W;
		global $_GPC;
		$cardid = $_GPC['id'];
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		if (empty($openid) || empty($cardid)) {
			return app_error(AppError::$ParamsError);
		}

		$plugin_membercard = p('membercard');

		if (!$plugin_membercard) {
			return app_error(AppError::$PluginNotFound);
		}

		$card = $plugin_membercard->getMemberCard($cardid);

		if (empty($card)) {
			return app_error(AppError::$CardNotFund);
		}

		if ($card['isdelete']) {
			return app_error(AppError::$CardisDel);
		}

		$has_flag = $plugin_membercard->check_Hasget($cardid, $openid);

		if (0 < $has_flag['errno']) {
			return app_error(82034, $has_flag['msg']);
		}

		if ($has_flag['using'] == '-1') {
			return app_error(AppError::$CardisOverTime);
		}

		if ($plugin_membercard->check_month_point($cardid, $openid)) {
			return app_error(82033, '本月已领取过');
		}

		if (!$card['is_month_points']) {
			return app_error(82034, '此会员卡没有此项福利');
		}

		$month_points = $card['month_points'];

		if ($month_points <= 0) {
			return app_error(82035, '会员卡数据有误');
		}

		$result = m('member')->setCredit($openid, 'credit1', $month_points, array($_W['member']['uid'], '购买会员卡' . $card['name'] . date('m') . '月领取' . $month_points . '积分'));

		if (is_error($result)) {
			return app_error(82035, $result['message']);
		}

		$send_log = array('uniacid' => $uniacid, 'openid' => $openid, 'member_card_id' => $cardid, 'name' => $card['name'], 'receive_time' => TIMESTAMP, 'create_time' => TIMESTAMP, 'price' => $card['price'], 'validate' => $card['validate'], 'sendtype' => 1, 'card_points' => $month_points);
		$recid = pdo_insert('ewei_shop_member_card_monthsend', $send_log);

		if (!$recid) {
			return app_error(AppError::$SystemError);
		}

		return app_json(array('data' => $send_log));
	}

	public function get_month_coupon()
	{
		global $_W;
		global $_GPC;
		$cardid = $_GPC['id'];
		$couponid = $_GPC['couponid'];
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		if (empty($openid) || empty($cardid) || empty($couponid)) {
			return app_error(AppError::$ParamsError);
		}

		$plugin_membercard = p('membercard');

		if (!$plugin_membercard) {
			return app_error(AppError::$PluginNotFound);
		}

		$card = $plugin_membercard->getMemberCard($cardid);

		if (empty($card)) {
			return app_error(AppError::$CardNotFund);
		}

		if ($card['isdelete']) {
			return app_error(AppError::$CardisDel);
		}

		$has_flag = $plugin_membercard->check_Hasget($cardid, $openid);

		if (0 < $has_flag['errno']) {
			return app_error(82034, $has_flag['msg']);
		}

		if ($has_flag['using'] == '-1') {
			return app_error(AppError::$CardisOverTime);
		}

		if (!$card['is_month_coupon']) {
			return app_error(82034, '此会员卡没有此项福利');
		}

		$month_coupon = iunserializer($card['month_coupon']);
		if (empty($month_coupon) || empty($month_coupon['couponid'])) {
			return app_error(82035, '会员卡数据有误');
		}

		if (!in_array($couponid, $month_coupon['couponid'])) {
			return app_error(82035, '会员卡数据有误(1)');
		}

		$couponnum = $month_coupon['couponnum' . $couponid];
		if (empty($couponnum) || $couponnum < 1) {
			return app_error(82035, '会员卡数据有误(2)' . $couponnum);
		}

		if ($plugin_membercard->check_month_coupon($cardid, $openid, $couponid)) {
			return app_error(82033, '本月已领取过此优惠券');
		}

		$send_res = $plugin_membercard->send_coupon($openid, $couponid, $couponnum, 1);

		if (!$send_res) {
			return app_error(AppError::$SystemError);
		}

		$send_log = array('uniacid' => $uniacid, 'openid' => $openid, 'member_card_id' => $cardid, 'name' => $card['name'], 'receive_time' => TIMESTAMP, 'create_time' => TIMESTAMP, 'price' => $card['price'], 'validate' => $card['validate'], 'sendtype' => 2, 'card_couponid' => $couponid, 'card_couponcount' => $couponnum);
		pdo_insert('ewei_shop_member_card_monthsend', $send_log);
		return app_json(array('data' => $send_log));
	}
}

?>
