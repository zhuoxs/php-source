<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Index_EweiShopV2Page extends AppMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$friendcouponModel = p('friendcoupon');
		$coupon = NULL;
		$activity = $friendcouponModel->getActivity($_GPC['id']);
		$user = $friendcouponModel->getMember($_W['openid']);
		$share_id = isset($_GPC['share_id']) ? $_GPC['share_id'] : NULL;
		$isShare = false;
		if (isset($share_id) && !empty($share_id) && $share_id != $user['id']) {
			$isShare = true;
		}

		$tips = '';
		$isReceive = false;
		$success = false;
		$activities = array();
		$activityData = array();
		$share_user = array();
		$shareParams = array('id' => $activity['id']);
		$mylink = '';

		if (!$activity) {
			$tips == '' && ($tips = '当前活动不存在');
		}

		$activitySetting = $activity;

		if (!$friendcouponModel->validateActivity($_GPC['id'])) {
			if ($friendcouponModel->errno) {
				if ($isShare) {
					$takePartInUsers = pdo_fetchall('select openid from ' . tablename('ewei_shop_friendcoupon_data') . (' where uniacid = ' . $_W['uniacid'] . ' and headerid = ' . $share_id));
				}
				else {
					$takePartInUsers = pdo_fetchall('select openid from' . tablename('ewei_shop_friendcoupon_data') . (' where uniacid = ' . $_W['uniacid'] . ' and activity_id = ' . $activitySetting['id']));
				}

				$openIds = array_column($takePartInUsers, 'openid');
				in_array($user['openid'], $openIds) && ($tips = '');
			}
			else {
				$tips = $friendcouponModel->errmsg;
			}
		}

		$activitySetting['activity_start_time'] = $friendcouponModel->dateFormat($activitySetting['activity_start_time']);
		$activitySetting['activity_end_time'] = $friendcouponModel->dateFormat($activitySetting['activity_end_time']);
		$activitySetting['desc'] = explode('
', $activitySetting['desc']);
		$overTime = 0;
		$overPeople = $activitySetting['people_count'];

		if ($isShare) {
			$share_user = m('member')->getMember($share_id);
			$shareActivityInfo = $friendcouponModel->getCurrentActivityInfo($share_user['openid'], $activity['id']);
			$currentActivityInfo = $friendcouponModel->getCurrentActivityInfo($user['openid'], $activity['id']);

			if (!$shareActivityInfo) {
				$tips == '' && ($tips = '分享的活动已经不存在了哦');
			}

			if (!empty($currentActivityInfo) && $currentActivityInfo['headerid'] != $shareActivityInfo['headerid']) {
				$tips == '' && ($tips = '您已经参与过这个活动啦，去看看别的活动吧~');
				$_GPC['share_id'] = NULL;
				$mylink = mobileUrl('friendcoupon', array('id' => $currentActivityInfo['activity_id'], 'share_id' => $currentActivityInfo['headerid']));
			}

			if ($currentActivityInfo) {
				$isReceive = true;
				$activities = $friendcouponModel->getOngoingActivities($shareActivityInfo['activity_id'], $shareActivityInfo['headerid']);

				foreach ($activities as $activity) {
					if (!$activity['openid']) {
						++$overPeople;
					}

					if ($activity['openid'] != '') {
						$activityData[] = $activity;
					}
				}
			}

			if ($currentActivityInfo['status'] == 1) {
				$success = true;
			}
			else {
				$activityData = array();
				$overPeople = 0;
				$activities = $friendcouponModel->getOngoingActivities($shareActivityInfo['activity_id'], $shareActivityInfo['headerid']);

				foreach ($activities as $activity) {
					if (!$activity['openid']) {
						++$overPeople;
					}

					if ($activity['openid'] != '') {
						$activityData[] = $activity;
					}
				}
			}
		}
		else {
			$share_user = $user;
			$currentActivityInfo = $friendcouponModel->getCurrentActivityInfo($user['openid'], $activity['id']);

			if ($currentActivityInfo) {
				$isReceive = true;
			}

			if ($currentActivityInfo['status'] == 1) {
				$success = true;
				$activities = $friendcouponModel->getOngoingActivities($currentActivityInfo['activity_id'], $currentActivityInfo['headerid']);

				foreach ($activities as $activity) {
					if (!$activity['openid']) {
						++$overPeople;
					}

					if ($activity['openid'] != '') {
						$activityData[] = $activity;
					}
				}
			}
			else {
				$overPeople = 0;
				$activities = $friendcouponModel->getOngoingActivities($currentActivityInfo['activity_id'], $currentActivityInfo['headerid']);

				foreach ($activities as $activity) {
					if (!$activity['openid']) {
						++$overPeople;
					}

					if ($activity['openid'] != '') {
						$activityData[] = $activity;
					}
				}
			}
		}

		$shareParams['share_id'] = $share_user['id'];

		if ($success) {
			$coupon = pdo_fetch('select id,couponid,openid,uniacid,used from ' . tablename('ewei_shop_coupon_data') . ' where friendcouponid = :friendcouponid', array('friendcouponid' => $currentActivityInfo['id']));
		}

		if ($currentActivityInfo['status'] == 1 || $shareActivityInfo['status'] == 1) {
			$takePartInUserIds = array_column($activityData, 'openid');

			if (!in_array($user['openid'], $takePartInUserIds)) {
				$tips == '' && ($tips = '当前活动已经瓜分成功,下回要快点哦~');
			}
		}

		if ($currentActivityInfo['deadline'] < time() && !$success && $isReceive) {
			$tips == '' && ($tips = '很遗憾，没有在规定时间内完成瓜分，下次要快一点哦~');
		}

		if ($activities) {
			$overTime = $activities[0]['deadline'];
		}
		else {
			$overTime = 0;
		}

		if ($tips != '') {
			$_GPC['share_id'] = NULL;
		}

		return app_json(array('coupon' => $coupon, 'success' => $success, 'isReceive' => $isReceive, 'isShare' => $isShare, 'currentActivityInfo' => $currentActivityInfo, 'overTime' => $overTime, 'overPeople' => $overPeople, 'activityData' => $activityData, 'activitySetting' => $activitySetting, 'share_user' => $share_user, 'invalidMessage' => $tips, 'isLogin' => (bool) $user, 'mylink' => $mylink));
	}

	public function receive()
	{
		global $_W;
		global $_GPC;
		$friendcouponModel = p('friendcoupon');
		$user = $friendcouponModel->getMember($_GPC['openid']);
		$activity_id = (int) $_GPC['id'];
		$form_id = $_GPC['form_id'];
		$activity = $friendcouponModel->validateActivity($activity_id);

		if (!$user) {
			return app_error(83003, '请先获取登录授权!');
		}

		if (!$activity) {
			return app_error(83004, $friendcouponModel->errmsg);
		}

		$currentUserActivity = $friendcouponModel->getCurrentActivityInfo($user['openid'], $activity['id']);

		if ($currentUserActivity) {
			app_error(10001, '您当前已经领取过任务了,赶快分享给好友吧');
		}

		$couponAmounts = array();

		switch ($activity['allocate']) {
		case 0:
			$couponAmounts = $friendcouponModel->randomCouponAlgorithm($activity['coupon_money'], $activity['people_count'], $activity['upper_limit']);
			break;

		case 1:
			$couponAmounts = $friendcouponModel->avgCouponAlgorithm($activity['coupon_money'], $activity['people_count']);
			break;
		}

		$time = time();
		$couponActivities = $friendcouponModel->getOngoingActivities($currentUserActivity['id'], $currentUserActivity['headerid']);
		$currentActivityIds = array();

		if (!$couponActivities) {
			$deadline = $time + $activity['duration'] * 3600 < $activity['activity_end_time'] ? $time + $activity['duration'] * 3600 : $activity['activity_end_time'];

			foreach ($couponAmounts as $couponAmount) {
				$data = array('uniacid' => $_W['uniacid'], 'activity_id' => $activity['id'], 'headerid' => $user['id'], 'status' => 0, 'deduct' => (double) $couponAmount, 'enough' => $activity['use_condition'], 'deadline' => $deadline);
				pdo_insert('ewei_shop_friendcoupon_data', $data);
				$currentActivityIds[] = pdo_insertid();
			}
		}
		else {
			$currentActivityIds[] = array_column($couponActivities, 'id');
		}

		$headerid = min($currentActivityIds);
		pdo_update('ewei_shop_friendcoupon_data', array('openid' => $user['openid'], 'avatar' => $user['avatar'], 'nickname' => $user['nickname'], 'receive_time' => time(), 'form_id' => $form_id), array('id' => $headerid));
		pdo_update('ewei_shop_friendcoupon', array('launches_count +=' => 1), array('id' => $activity['id']));
		return app_json('活动领取成功');
	}

	public function divide()
	{
		global $_W;
		global $_GPC;
		$activity_id = $_GPC['id'];
		$friendcouponModel = p('friendcoupon');
		$share_id = $_GPC['share_id'];
		$form_id = $_GPC['form_id'];
		$share_user = $friendcouponModel->getMember($share_id);
		$user = $friendcouponModel->getMember($_GPC['openid']);
		$activity = $friendcouponModel->getActivity($activity_id);

		if (!$user) {
			return app_error(83003, '请登陆后在进行操作!');
		}

		if (!$activity) {
			return app_error(83004, $friendcouponModel->errmsg);
		}

		$onGoingActivities = $friendcouponModel->getOngoingActivities($activity_id, $share_id);

		if (!$onGoingActivities) {
			return app_error(83005, array('没有进行中的活动'));
		}

		$shareActivityInfo = $friendcouponModel->getCurrentActivityInfo($share_user['openid'], $activity['id']);

		if ($shareActivityInfo['status'] == 1) {
			return app_error(83006, '活动已经完成<br>下次早点来啊~');
		}

		$currentActivityInfo = $friendcouponModel->getCurrentActivityInfo($user['openid'], $activity_id);

		if (!$currentActivityInfo) {
			$coupons = pdo_fetchall('select * from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and activity_id = :activity_id and headerid = :headerid', array(':uniacid' => $_W['uniacid'], ':activity_id' => $activity['id'], ':headerid' => $share_id));

			foreach ($coupons as $coupon) {
				if (!$coupon['openid']) {
					pdo_update('ewei_shop_friendcoupon_data', array('openid' => $user['openid'], 'status' => 0, 'avatar' => $user['avatar'], 'nickname' => $user['nickname'], 'receive_time' => time(), 'form_id' => $form_id), array('id' => $coupon['id']));
					break;
				}
			}

			$overPlus = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and headerid = :headerid and activity_id = :activity_id and openid = \'\'', array(':uniacid' => $_W['uniacid'], ':headerid' => $share_id, ':activity_id' => $activity_id));

			if ($overPlus) {
				return app_json(array('message' => '瓜分成功！'));
			}

			pdo_update('ewei_shop_friendcoupon_data', array('status' => 1), array('activity_id' => $activity_id, 'headerid' => $share_id));
			$sql = 'select f.*, fd.enough, fd.id as friendcouponid,fd.deduct,fd.form_id,fd.openid,fd.enough from' . tablename('ewei_shop_friendcoupon_data') . ' fd ' . ' left join ' . tablename('ewei_shop_friendcoupon') . ' f on fd.activity_id = f.id' . ' where fd.uniacid = :uniacid and fd.headerid = :headerid and fd.activity_id = :activity_id';
			$coupons = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':activity_id' => $activity['id'], ':headerid' => $share_id));

			if (false === $friendcouponModel->sendFriendCoupon($coupons)) {
				return app_error(83007, $friendcouponModel->errmsg);
			}

			foreach ($coupons as $coupon) {
				$openid = str_replace('sns_wa_', '', $coupon['openid']);
				$templateMessage = $friendcouponModel->getTemplateMessage('complete', true);
				$template_id = $templateMessage['templateid'];
				$page = 'friendcoupon/index?id=' . $activity_id . '&share_id=' . $share_id;

				if (0 < $coupon['enough']) {
					$couponName = '满' . $coupon['enough'] . '减' . $coupon['deduct'] . '元优惠券';
				}
				else {
					$couponName = '无门槛减' . $coupon['deduct'] . '元优惠券';
				}

				$datas = unserialize($templateMessage['datas']);
				$data = array();

				foreach ($datas as $index => $item) {
					$key = trim($item['key'], '{{}}');
					list($key) = explode('.', $key);
					$value = $item['value'];
					preg_match_all('#\\[\\S*?]#', $item['value'], $matchResult);
					$matches = $matchResult[0];

					foreach ($matches as $match) {
						switch ($match) {
						case '[活动名称]':
							$replaceElement = $activity['title'];
							break;

						case '[活动开始时间]':
							$replaceElement = $friendcouponModel->dateFormat($activity['activity_start_time']);
							break;

						case '[活动结束时间]':
							$replaceElement = $friendcouponModel->dateFormat($activity['activity_end_time']);
							break;

						case '[瓜分券名称]':
							$replaceElement = $couponName;
							break;

						case '[瓜分券领取时间]':
							$replaceElement = $friendcouponModel->dateFormat(time());
							break;

						default:
							break;
						}

						$value = str_replace($match, $replaceElement, $value);
					}

					$data[$key] = array('value' => $value);
				}

				$emphasis_keyword = NULL;

				if ($templateMessage['emphasis_keyword'] != -1) {
					$emphasis_keyword = trim($datas[$templateMessage['emphasis_keyword']]['key'], '{{}}');
				}

				$sendResult = $this->sendTemplateMessage($openid, $template_id, $page, $coupon['form_id'], $data, $emphasis_keyword);
				$sendResult = json_decode($sendResult, true);

				if ($sendResult['errcode'] === 0) {
					pdo_update('ewei_shop_friendcoupon_data', array('is_send' => 1), array('id' => $coupon['friendcouponid']));
				}
			}

			return app_json(array('message' => '活动完成！'));
		}

		return app_error(83008, '您已经瓜分过优惠券了,请不要重复瓜分!');
	}

	/**
     * 检查用户登陆状态
     */
	protected function getMember($openid)
	{
		return m('member')->getMember($openid);
	}

	/**
     * 发送客服模板消息
     * @param $openid
     * @param $template_id
     * @param $page
     * @param $form_id
     * @param null $data
     * @param null $emphasis_keyword
     * @return array
     */
	private function sendTemplateMessage($openid, $template_id, $page, $form_id, $data = NULL, $emphasis_keyword = NULL)
	{
		$token = p('app')->getAccessToken();
		$data = json_encode(array('touser' => $openid, 'template_id' => $template_id, 'page' => $page, 'form_id' => $form_id, 'data' => $data, 'emphasis_keyword' => $emphasis_keyword));
		$result = ihttp_post('https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $token, $data);
		return $result['content'];
	}

	public function more()
	{
		global $_W;
		global $_GPC;
		$friendcouponModel = p('friendcoupon');
		$activity_id = $_GPC['id'];
		$share_id = $_GPC['share_id'];
		$pindex = max(1, $_GPC['pindex']);
		$psize = 10;
		$openid = $_GPC['openid'];

		if (empty($share_id)) {
			$currentTakePartActivity = pdo_fetch('select * from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and openid = :openid and activity_id = :activity_id', array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':activity_id' => $activity_id));
			$share_id = $currentTakePartActivity['headerid'];
		}

		$list = pdo_fetchall('select avatar,nickname,deduct from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and activity_id = :activity_id and headerid = :headerid and openid <> \'\' limit ' . ($pindex - 1) . ',' . $psize, array(':uniacid' => $_W['uniacid'], ':headerid' => $share_id, ':activity_id' => $activity_id));
		show_json(0, array('list' => $list));
	}
}

?>
