<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$activity_id = isset($_GPC['id']) ? $_GPC['id'] : NULL;
		$activity = $this->model->getActivity($activity_id);

		if (!$activity) {
			header('location:' . mobileUrl('', '', true));
		}

		$user = m('member')->getMember($_W['openid']);
		$mid = isset($_GPC['mid']) ? $_GPC['mid'] : NULL;
		$isShare = false;
		if (isset($mid) && $mid != $user['id']) {
			$isShare = true;
		}

		$isReceive = false;
		$success = false;
		$activityData = array();
		$shareParams = array('id' => $activity['id']);
		$overTime = 0;

		if (!$user) {
			header('location:' . mobileUrl('account/login', '', true));
		}

		$activitySetting = $activity;

		if (!$this->model->validateActivity($_GPC['id'])) {
			if ($this->model->errno) {
				if ($isShare) {
					$takePartInUsers = pdo_fetchall('select openid from ' . tablename('ewei_shop_friendcoupon_data') . (' where uniacid = ' . $_W['uniacid'] . ' and headerid = ' . $mid));
				}
				else {
					$takePartInUsers = pdo_fetchall('select openid from' . tablename('ewei_shop_friendcoupon_data') . (' where uniacid = ' . $_W['uniacid'] . ' and activity_id = ' . $activity_id));
				}

				$openIds = array_column($takePartInUsers, 'openid');
				in_array($user['openid'], $openIds) && ($tips = '');
			}
			else {
				$tips = $this->model->errmsg;
			}
		}

		$activitySetting['desc'] = explode('
', $activitySetting['desc']);
		$overPeople = $activitySetting['people_count'];
		$numberOfInvitations = $activitySetting['people_count'] - 1;

		if ($isShare) {
			$share_user = m('member')->getMember($mid);
			$shareActivityInfo = $this->model->getCurrentActivityInfo($share_user['openid'], $activity['id']);
			$currentActivityInfo = $this->model->getCurrentActivityInfo($user['openid'], $activity['id']);
			$overTime = $shareActivityInfo['deadline'];

			if (!$shareActivityInfo) {
				$tips == '' && ($tips = '分享的活动已经不存在了哦');
			}

			if (!empty($currentActivityInfo) && $currentActivityInfo['headerid'] != $shareActivityInfo['headerid']) {
				$tips == '' && ($tips = '您已经参与过这个活动啦，去看看别的活动吧~');
				$_GPC['mid'] = NULL;
				$mylink = mobileUrl('friendcoupon', array('id' => $currentActivityInfo['activity_id']));
			}

			if ($currentActivityInfo) {
				$overTime = $currentActivityInfo['deadline'];
				$isReceive = true;
				$activities = $this->model->getOngoingActivities($shareActivityInfo['activity_id'], $shareActivityInfo['headerid']);

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
				$activities = $this->model->getOngoingActivities($shareActivityInfo['activity_id'], $shareActivityInfo['headerid']);

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
			$currentActivityInfo = $this->model->getCurrentActivityInfo($user['openid'], $activity['id']);

			if ($currentActivityInfo) {
				$isReceive = true;
			}

			if ($currentActivityInfo['status'] == 1) {
				$success = true;
				$activities = $this->model->getOngoingActivities($currentActivityInfo['activity_id'], $currentActivityInfo['headerid']);

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
				$overTime = $currentActivityInfo['deadline'];
				$share_user = $user;
				$overPeople = 0;
				$activities = $this->model->getOngoingActivities($currentActivityInfo['activity_id'], $currentActivityInfo['headerid']);

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

		$shareParams['mid'] = $share_user['id'];
		$activity['desc'] = explode('
', $activity['desc']);

		if ($success) {
			$coupon = pdo_fetch('select id,couponid,openid,uniacid,used from ' . tablename('ewei_shop_coupon_data') . ' where friendcouponid = :friendcouponid', array('friendcouponid' => $currentActivityInfo['id']));
		}

		if ($currentActivityInfo['status'] == 1 || $shareActivityInfo['status'] == 1) {
			$takePartInUserIds = array_column($activityData, 'openid');

			if (!in_array($user['openid'], $takePartInUserIds)) {
				$tips == '' && ($tips = '当前活动已经瓜分成功,下回要快点哦~');
				$_GPC['mid'] = NULL;
			}
		}

		if (isset($overTime) && $overTime < (int) time() && !$success) {
			$tips == '' && ($tips = '很遗憾，没有在规定时间内完成瓜分，下次要快一点哦~');
		}

		if (isset($overTime) && (int) $overTime < (int) time() && !$success && $isReceive) {
			$tips == '' && ($tips = '很遗憾，没有在规定时间内完成瓜分，下次要快一点哦~');
		}

		$_W['shopshare'] = array('title' => $activitySetting['title'], 'imgUrl' => $_W['siteroot'] . 'addons/ewei_shopv2/static/images/friendcoupon.png', 'desc' => $share_user['nickname'] . '邀请您一起瓜分' . $activitySetting['coupon_money'] . '元', 'link' => mobileUrl('friendcoupon', $shareParams, true));

		if ($tips != '') {
			$_GPC['mid'] = NULL;
		}

		$activityDataLen = count($activityData);
		$activityData = array_slice($activityData, 0, 5);
		$backFullUrl = mobileUrl('', '', true);
		$back_url = parse_url($backFullUrl);
		$r = explode('&', $back_url['query']);

		foreach ($r as $key => $item) {
			if (strpos($item, 'mid=') !== false) {
				unset($r[$key]);
			}
		}

		$queryString = implode($r, '&');
		$back = $back_url['scheme'] . '://' . $back_url['host'] . $back_url['path'] . '?' . $queryString;
		include $this->template();
	}

	/**
     * 领取任务,每个任务每个人只允许参加一次
     */
	public function receive()
	{
		global $_W;
		global $_GPC;
		$user = m('member')->getMember($_W['openid']);
		$activity_id = (int) $_GPC['id'];

		if (!($activity = $this->model->validateActivity($activity_id))) {
			show_json(0, $this->model->errmsg);
		}

		$currentActivityInfo = $this->model->getCurrentActivityInfo($user['openid'], $activity_id);
		$isTakePartIn = (bool) $currentActivityInfo;
		$isTakePartIn && show_json(0, '您已经参加了当前活动,请不要重复领取！');
		$couponAmounts = array();

		switch ($activity['allocate']) {
		case 0:
			$totalMoney = $activity['coupon_money'];
			$peopleCount = (int) $activity['people_count'];
			$minimum = $activity['upper_limit'];
			$couponAmounts = $this->model->randomCouponAlgorithm($totalMoney, $peopleCount, $minimum);
			break;

		case 1:
			$couponAmounts = $this->model->avgCouponAlgorithm($activity['coupon_money'], $activity['people_count']);
			break;
		}

		$couponActivities = $this->model->getOngoingActivities($currentActivityInfo['id'], $currentActivityInfo['headerid']);
		$currentActivityIds = array();
		$time = time();

		if (!$couponActivities) {
			$deadline = $time + $activity['duration'] * 3600 < $activity['activity_end_time'] ? $time + $activity['duration'] * 3600 : $activity['activity_end_time'];

			foreach ($couponAmounts as $couponAmount) {
				$data = array('uniacid' => $_W['uniacid'], 'activity_id' => $activity['id'], 'headerid' => $user['id'], 'deduct' => (double) $couponAmount, 'enough' => $activity['use_condition'], 'deadline' => $deadline);
				pdo_insert('ewei_shop_friendcoupon_data', $data);
				$currentActivityIds[] = pdo_insertid();
			}
		}
		else {
			$currentActivityIds[] = array_column($couponActivities, 'id');
		}

		$headerid = min($currentActivityIds);
		pdo_update('ewei_shop_friendcoupon_data', array('openid' => $user['openid'], 'avatar' => $user['avatar'], 'nickname' => $user['nickname'], 'receive_time' => time()), array('id' => $headerid));
		pdo_update('ewei_shop_friendcoupon', array('launches_count +=' => 1), array('id' => $activity['id']));
		$commonModel = m('common');
		$noticeModel = m('notice');
		$tm = $commonModel->getSysset('notice');
		$currentActivityInfo = $this->model->getCurrentActivityInfo($user['openid'], $activity_id);

		if (0 < $currentActivityInfo['enough']) {
			$couponName = '满' . $currentActivityInfo['enough'] . '减' . $currentActivityInfo['deduct'] . '元优惠券';
		}
		else {
			$couponName = '无门槛减' . $currentActivityInfo['deduct'] . '元优惠券';
		}

		if ($tm['friendcoupon_launch_close_advanced']) {
			$noticeModel->sendNotice(array(
				'openid' => $user['openid'],
				'tag'    => 'friendcoupon_launch',
				'datas'  => array(
					array('name' => '活动名称', 'value' => $activity['title']),
					array('name' => '活动开始时间', 'value' => $this->model->dateFormat($currentActivityInfo['receive_time'])),
					array('name' => '活动结束时间', 'value' => $this->model->dateFormat($currentActivityInfo['deadline'])),
					array('name' => '瓜分券领取时间', 'value' => $this->model->dateFormat(time())),
					array('name' => '瓜分券名称', 'value' => $couponName)
				)
			));
		}
		else {
			$params = array('activity_title' => $activity['title'], 'activity_start_time' => $this->model->dateFormat($currentActivityInfo['receive_time']), 'activity_end_time' => $this->model->dateFormat($currentActivityInfo['deadline']), 'receiveTime' => $this->model->dateFormat(time()), 'couponName' => $couponName, 'url' => mobileUrl('friendcoupon', array('id' => $currentActivityInfo['activity_id'], 'mid' => $currentActivityInfo['headerid']), true));
			m('notice')->sendFriendCouponTemplateMessage($user['openid'], $params, 'launch');
		}

		show_json(1, '活动领取成功');
	}

	/**
     * 立即瓜分接口
     */
	public function divide()
	{
		global $_W;
		global $_GPC;
		$activity_id = $_GPC['id'];
		$mid = $_GPC['mid'];
		$share_user = m('member')->getMember($mid);
		$user = m('member')->getMember($_W['openid']);
		$activity = $this->model->getActivity($activity_id);
		$onGoingActivities = $this->model->getOngoingActivities($activity_id, $mid);

		if (!$onGoingActivities) {
			show_json(0, array('url' => mobileUrl('', '', true), 'message' => '没有进行中的活动'));
		}

		$shareActivityInfo = $this->model->getCurrentActivityInfo($share_user['openid'], $activity['id']);

		if ($shareActivityInfo['status'] == 1) {
			show_json(0, '活动已经完成<br>下次早点来啊~');
		}

		$currentActivityInfo = $this->model->getCurrentActivityInfo($user['openid'], $activity_id);

		if (!$currentActivityInfo) {
			$coupons = pdo_fetchall('select * from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and activity_id = :activity_id and headerid = :headerid', array(':uniacid' => $_W['uniacid'], ':activity_id' => $activity['id'], ':headerid' => $mid));

			foreach ($coupons as $coupon) {
				if (!$coupon['openid']) {
					pdo_update('ewei_shop_friendcoupon_data', array('openid' => $user['openid'], 'status' => 0, 'avatar' => $user['avatar'], 'nickname' => $user['nickname'], 'receive_time' => time()), array('id' => $coupon['id']));
					break;
				}
			}

			$overPlus = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and headerid = :headerid and activity_id = :activity_id and openid = \'\'', array(':uniacid' => $_W['uniacid'], ':headerid' => $mid, ':activity_id' => $activity_id));

			if ($overPlus) {
				show_json(1, '瓜分成功!');
			}

			pdo_update('ewei_shop_friendcoupon_data', array('status' => 1), array('activity_id' => $activity_id, 'headerid' => $mid));
			$sql = 'select f.*, fd.enough, fd.id as friendcouponid,fd.deduct,fd.openid,fd.activity_id,fd.receive_time,fd.deadline from' . tablename('ewei_shop_friendcoupon_data') . ' fd ' . ' left join ' . tablename('ewei_shop_friendcoupon') . ' f on fd.activity_id = f.id' . ' where fd.uniacid = :uniacid and fd.headerid = :headerid and fd.activity_id = :activity_id';
			$coupons = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':activity_id' => $activity['id'], ':headerid' => $mid));

			if (false === $this->model->sendFriendCoupon($coupons)) {
				show_json(0, $this->model->errmsg);
			}

			$commonModel = m('common');
			$noticeModel = m('notice');
			$tm = $commonModel->getSysset('notice');

			foreach ($coupons as $coupon) {
				$url = mobileUrl('friendcoupon', array('id' => $coupon['activity_id'], 'mid' => $coupon['headerid']), true);

				if (0 < $coupon['enough']) {
					$couponName = '满' . $coupon['enough'] . '减' . $coupon['deduct'] . '元优惠券';
				}
				else {
					$couponName = '无门槛减' . $coupon['deduct'] . '元优惠券';
				}

				if ($tm['friendcoupon_launch_close_advanced']) {
					$noticeModel->sendNotice(array(
						'openid' => $coupon['openid'],
						'tag'    => 'friendcoupon_complete',
						'datas'  => array(
							array('name' => '活动名称', 'value' => $activity['title']),
							array('name' => '活动开始时间', 'value' => $this->model->dateFormat($coupon['receive_time'])),
							array('name' => '活动结束时间', 'value' => $this->model->dateFormat($coupon['deadline'])),
							array('name' => '瓜分券领取时间', 'value' => $this->model->dateFormat(time())),
							array('name' => '瓜分券名称', 'value' => $couponName)
						),
						'url'    => $url
					));
				}
				else {
					$params = array('activity_title' => $activity['title'], 'activity_start_time' => $this->model->dateFormat($currentActivityInfo['receive_time']), 'activity_end_time' => $this->model->dateFormat($currentActivityInfo['deadline']), 'receiveTime' => $this->model->dateFormat(time()), 'couponName' => $couponName, 'url' => $url);
					m('notice')->sendFriendCouponTemplateMessage($coupon['openid'], $params, 'complete');
				}
			}

			show_json(1, '活动参与成功!');
		}

		show_json(0, '您已经瓜分过优惠券了哦!');
	}

	public function getTakePartInPeopleData($activity_id, $headerid)
	{
		global $_W;
		global $_GPC;
		$activity_id = $_GPC['activity_id'];
		$headerid = $_GPC['mid'];
		$r = pdo_fetchall('select * from ' . tablename('ewei_shop_friendcoupon_data') . ' where unaicid = :unaicid and headerid = :headerid and activity_id = :activity_id', array(':uniacid' => $_W['uniacid'], ':headerid' => $headerid, ':activity_id' => $activity_id));
	}

	public function more()
	{
		global $_W;
		global $_GPC;
		$activity_id = $_GPC['id'];
		$mid = $_GPC['mid'];
		$pindex = max(1, $_GPC['pindex']);
		$psize = 10;

		if (empty($mid)) {
			$currentTakePartActivity = pdo_fetch('select * from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and openid = :openid and activity_id = :activity_id', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':activity_id' => $activity_id));
			$mid = $currentTakePartActivity['headerid'];
		}

		$list = pdo_fetchall('select avatar,nickname,deduct from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and activity_id = :activity_id and headerid = :headerid and openid <> \'\' limit ' . ($pindex - 1) . ',' . $psize, array(':uniacid' => $_W['uniacid'], ':headerid' => $mid, ':activity_id' => $activity_id));
		show_json(0, array('list' => $list));
	}

	public function deadline()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		$mid = isset($_GPC['mid']) ? $_GPC['mid'] : NULL;
		$currentActivityInfo = $this->model->getCurrentActivityInfo($_W['openid'], $id);

		if (!$currentActivityInfo) {
			$deadline = $this->model->getOngoingActivities($id, $mid)[0]['deadline'];
		}
		else {
			$deadline = $currentActivityInfo['deadline'];
		}

		show_json(0, array('deadline' => $deadline));
	}
}

?>
