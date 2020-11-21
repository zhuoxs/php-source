<?php

class LiveSocket
{
	public function redis($server)
	{
		return redis();
	}

	/**
     * @param $server
     * @param $data
     */
	public function onMessage($server, $data, $fd)
	{
		global $_W;
		$data = $this->special($data);
		if (empty($data['type']) || empty($data['roomid']) || empty($data['uid'])) {
			return false;
		}

		if ($data['type'] == 'login') {
			$this->addUser($server, $data['uid'], array('fd' => $fd, 'uid' => $data['uid'], 'nickname' => $data['nickname'], 'uniacid' => $data['uniacid'], 'roomid' => $data['roomid'], 'role' => $data['role']));
			$banned = $this->getBanned($server, $data['roomid'], $data['uid']);
			$settings = $this->getRoomSetting($server, $data['roomid'], $data['uid']);
			$this->sendAll($server, array('type' => 'userEnter', 'fromUser' => $data['uid'], 'toUser' => 'all', 'nickname' => $data['nickname'], 'role' => $data['role'], 'banned' => $banned['self'], 'roomid' => $data['roomid']), $fd);
			$sendArr = array('type' => 'connected', 'fromUser' => 'system', 'toUser' => $fd, 'banned' => $banned, 'online' => $this->getUserTotal($server, $data['roomid']), 'settings' => $settings);

			if ($data['role'] == 'manage') {
				if ($this->isManage($data['uid'])) {
					$sendArr['userList'] = $this->getAllUser($server, $data['roomid']);
					$bannedList = $this->getBannedUser($server, $data['roomid']);
					$sendArr['bannedList'] = $bannedList;
					$sendArr['bannedNum'] = count($bannedList);
				}
			}

			$this->send($server, $fd, $sendArr);
			if (isset($settings['virtualadd']) && 1 < intval($settings['virtualadd'])) {
				$table = $this->getTable('settings', $data['roomid']);
				$this->redis($server)->hIncrBy($table, 'virtual', $settings['virtualadd']);
			}

			return true;
		}

		if ($data['type'] == 'update') {
			$this->updateUser($data['uid'], array());
		}
		else {
			if ($data['type'] == 'text' || $data['type'] == 'image') {
				if (!$this->isManage($data['uid'])) {
					$banned = $this->getBanned($server, $data['roomid'], $data['uid']);
					if ($banned['all'] || $banned['self']) {
						return false;
					}
				}

				if ($data['toUser'] == 'all') {
					$at = isset($data['at']) ? $data['at'] : array();
					$msgid = $this->getMsgid($data['uid']);
					$table_records = $this->getTable('chat_records', $data['roomid']);
					$this->redis($server)->rPush($table_records, json_encode(array('id' => $msgid, 'mid' => $data['uid'], 'nickname' => $data['nickname'], 'type' => $data['type'], 'text' => $data['text'], 'sendtime' => time(), 'at' => !empty($at) ? iserializer($at) : '')));
					$rlength = $this->redis($server)->lLen($table_records);

					if (300 < $rlength) {
						$this->redis($server)->lTrim($table_records, $rlength - 300, -1);
					}

					$this->sendAll($server, array('type' => $data['type'], 'fromUser' => $data['uid'], 'toUser' => $data['toUser'], 'nickname' => $data['nickname'], 'text' => $data['text'], 'msgid' => $msgid, 'roomid' => $data['roomid']), 0, $at);
				}
				else {
					return false;
				}
			}
			else if ($data['type'] == 'repeal') {
				$message = $this->getSingleMsg($server, $data['msgid'], $data['roomid']);

				if ($message['mid'] != $data['uid']) {
					return false;
				}

				$this->sendAll($server, array('type' => 'repeal', 'fromUser' => $data['uid'], 'toUser' => 'all', 'nickname' => $data['nickname'], 'msgid' => $data['msgid'], 'roomid' => $data['roomid']));
				$this->updateMsg($server, $data['msgid'], $data['roomid'], 1);
			}
			else if ($data['type'] == 'delete') {
				if (!$this->isManage($data['uid'])) {
					return false;
				}

				$this->sendAll($server, array('type' => 'delete', 'fromUser' => $data['uid'], 'toUser' => 'all', 'nickname' => $data['nickname'], 'msgid' => $data['msgid'], 'deleteNick' => $data['deleteNick'], 'deleteUid' => $data['deleteUid'], 'roomid' => $data['roomid']));
				$this->updateMsg($server, $data['msgid'], $data['roomid'], 2, array('mid_manage' => $data['uid'], 'nickname_manage' => $data['nickname']));
			}
			else if ($data['type'] == 'banned') {
				if (!$this->isManage($data['uid'])) {
					return false;
				}

				$table = $this->getTable('banned', $data['roomid']);

				if ($data['banned'] == 1) {
					$this->redis($server)->hSet($table, $data['bannedUid'], json_encode(array('nickname' => $data['bannedNick'])));
				}
				else {
					$this->redis($server)->hDel($table, $data['bannedUid']);
				}

				$user = $this->getUser($server, $data['roomid'], $data['bannedUid']);
				$this->sendAll($server, array('type' => 'banned', 'fromUser' => $data['uid'], 'toUser' => 'manage', 'nickname' => $data['nickname'], 'banned' => intval($data['banned']), 'bannedUid' => $data['bannedUid'], 'bannedNick' => $data['bannedNick'], 'roomid' => $data['roomid']), !empty($user) ? $user['fd'] : 0);
			}
			else if ($data['type'] == 'bannedAll') {
				if (!$this->isManage($data['uid'])) {
					return false;
				}

				$table = $this->getTable('banned', $data['roomid']);
				$this->redis($server)->hSet($table, 'bannedAll', intval($data['banned']));
				$this->sendAll($server, array('type' => 'bannedAll', 'fromUser' => $data['uid'], 'toUser' => 'all', 'nickname' => $data['nickname'], 'banned' => intval($data['banned']), 'roomid' => $data['roomid']), $fd);
			}
			else if ($data['type'] == 'setting') {
				if (!$this->isManage($data['uid'])) {
					return false;
				}

				$table = $this->getTable('settings', $data['roomid']);
				$settings = $this->redis($server)->hGetAll($table);
				$settings = empty($settings) ? array() : $settings;
				$settings['canat'] = intval($data['canAt']);
				$settings['canrepeal'] = intval($data['canRepeal']);
				$settings['virtual'] = intval($data['virtualNum']);
				$settings['virtualadd'] = intval($data['virtualAddNum']);
				$settings[$data['uid']] = $data['manageNick'];
				$this->redis($server)->hMset($table, $settings);
				unset($settings[$data['uid']]);

				if ($data['manageNick'] != $data['nickname']) {
					$settings['nickname_old'] = $data['nickname'];
					$settings['nickname'] = $data['manageNick'];
					$this->updateUser($data['uid'], array('nickname' => $data['manageNick']));
				}

				$this->sendAll($server, array('type' => 'setting', 'fromUser' => $data['uid'], 'toUser' => 'all', 'settings' => $settings, 'roomid' => $data['roomid']));
			}
			else if ($data['type'] == 'setstatus') {
				if (!$this->isManage($data['uid'])) {
					return false;
				}

				$status = intval($data['status']);
				$table = $this->getTable('settings', $data['roomid']);
				$time = time();
				$setArr = array('status' => $status);

				if ($status == 1) {
					pdo_insert2('ewei_shop_live_status', array('uniacid' => $data['uniacid'], 'roomid' => $data['roomid'], 'starttime' => $time));
					$setArr['statusid'] = pdo_insertid2();
				}
				else {
					if ($status == 0) {
						$statusid = $this->redis($server)->hGet($table, 'statusid');

						if (!empty($statusid)) {
							pdo_update2('ewei_shop_live_status', array('endtime' => $time), array('uniacid' => $data['uniacid'], 'roomid' => $data['roomid'], 'id' => $statusid));
						}
					}
				}

				$this->redis($server)->hMset($table, $setArr);
				$update = array('living' => $status != 1 ? 0 : 1);

				if ($status == 0) {
					$update['lastlivetime'] = $time;
				}

				pdo_update2('ewei_shop_live', $update, array('uniacid' => $data['uniacid'], 'id' => $data['roomid']));
				$this->sendAll($server, array('type' => 'setting', 'fromUser' => $data['uid'], 'toUser' => 'all', 'settings' => $this->getRoomSetting($server, $data['roomid']), 'roomid' => $data['roomid']));
			}
			else if ($data['type'] == 'clicklike') {
				$this->sendAll($server, array('type' => 'clicklike', 'fromUser' => $data['uid'], 'toUser' => 'all', 'roomid' => $data['roomid']), $fd);
			}
			else if ($data['type'] == 'goods') {
				if (!$this->isManage($data['uid'])) {
					return false;
				}

				$msgid = $this->getMsgid($data['uid']);
				$table_records = $this->getTable('chat_records', $data['roomid']);
				$this->redis($server)->rPush($table_records, json_encode(array('id' => $msgid, 'mid' => $data['uid'], 'nickname' => $data['nickname'], 'type' => $data['type'], 'goodstitle' => $data['goodsTitle'], 'goodsprice' => $data['goodsPrice'], 'goodsthumb' => $data['goodsThumb'], 'goodsid' => $data['goodsId'], 'sendtime' => time(), 'at' => !empty($at) ? iserializer($at) : '')));
				$this->redis($server)->lTrim($table_records, 0, 299);
				$this->sendAll($server, array('type' => $data['type'], 'fromUser' => $data['uid'], 'toUser' => $data['toUser'], 'nickname' => $data['nickname'], 'goodsTitle' => $data['goodsTitle'], 'goodsPrice' => $data['goodsPrice'], 'goodsThumb' => $data['goodsThumb'], 'goodsUrl' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=ewei_shopv2&do=mobile&r=goods.detail&liveid=' . $data['roomid'] . '&id=' . $data['goodsId'], 'goodsId' => $data['goodsId'], 'msgid' => $msgid, 'roomid' => $data['roomid']));
			}
			else if ($data['type'] == 'redpack') {
				if (!$this->isManage($data['uid'])) {
					return false;
				}

				$msgid = $this->getMsgid($data['uid']);
				$redpackid = time();
				$redpacktitle = trim($data['redPackTitle']);
				$redpacktype = intval($data['redPackType']);
				$redpackmoney = trim($data['redPackMoney']);
				$redpacktotal = intval($data['redPackTotal']);
				if (empty($redpackmoney) || empty($redpacktotal)) {
					return false;
				}

				if (empty($redpacktitle)) {
					$redpacktitle = '红包来袭，手慢无！';
				}

				if (empty($redpacktype)) {
					$redpacklist = array();
					$i = 0;

					while ($i < $redpacktotal) {
						$redpacklist[] = $redpackmoney;
						++$i;
					}

					$redpackmoney = $redpackmoney * $redpacktotal;
				}
				else {
					$redpacklist = createRedPack($redpackmoney, $redpacktotal);
				}

				if (empty($redpacklist)) {
					return false;
				}

				$table_redpack = $this->getTable('redpack_' . $redpackid, $data['roomid']);

				foreach ($redpacklist as $money) {
					$this->redis($server)->rPush($table_redpack, json_encode(array('money' => $money, 'used' => 0)));
				}

				$table_pushrecords_order = $this->getTable('push_records_order', $data['roomid']);
				$this->redis($server)->rPush($table_pushrecords_order, $redpackid);
				$table_pushrecords = $this->getTable('push_records', $data['roomid']);
				$this->redis($server)->hSet($table_pushrecords, $redpackid, json_encode(array('title' => $redpacktitle, 'type' => $redpacktype, 'time' => $redpackid, 'total' => $redpacktotal, 'total_remain' => $redpacktotal, 'money' => $redpackmoney, 'money_remain' => $redpackmoney)));
				$table_records = $this->getTable('chat_records', $data['roomid']);
				$this->redis($server)->rPush($table_records, json_encode(array('id' => $msgid, 'mid' => $data['uid'], 'nickname' => $data['nickname'], 'type' => $data['type'], 'text' => $redpacktitle, 'pushid' => $redpackid, 'sendtime' => time())));
				$this->sendAll($server, array(
					'type'     => 'redpack',
					'fromUser' => $data['uid'],
					'toUser'   => 'all',
					'nickname' => $data['nickname'],
					'redpack'  => array('title' => $redpacktitle, 'id' => $redpackid, 'total' => $redpacktotal, 'money' => $redpackmoney, 'type' => $redpacktype),
					'msgid'    => $msgid,
					'roomid'   => $data['roomid']
				));
			}
			else if ($data['type'] == 'redpackget') {
				$redpackid = intval($data['pushid']);
				$sendArr = array('type' => 'redpackget', 'fromUser' => 'system', 'toUser' => $fd, 'prestatus' => 0, 'redpackid' => $redpackid, 'money' => 0);

				if (!empty($redpackid)) {
					$table_redpack = $this->getTable('redpack_' . $redpackid, $data['roomid']);
					$table_redpack_list = $this->getTable('redpack_list_' . $redpackid, $data['roomid']);

					if ($this->redis($server)->exists($table_redpack)) {
						$selfdata = $this->redis($server)->hGet($table_redpack_list, $data['openid']);

						if (!empty($selfdata)) {
							$selfdata = json_decode($selfdata, true);
						}

						if (0 < $selfdata['money']) {
							$sendArr['prestatus'] = 1;
							$sendArr['money'] = $selfdata['money'];
							$sendArr['list'] = $this->getRedpackList($server, $table_redpack_list);
							$this->send($server, $fd, $sendArr);
							return false;
						}

						if ($this->redis($server)->hLen($table_redpack_list) < $this->redis($server)->lLen($table_redpack) || $selfdata['redpackindex'] < 0) {
							$sendArr['prestatus'] = 3;
						}
						else {
							$sendArr['prestatus'] = 2;
							$sendArr['list'] = $this->getRedpackList($server, $table_redpack_list);
						}
					}
				}

				$this->send($server, $fd, $sendArr);
			}
			else if ($data['type'] == 'redpackdraw') {
				$redpackid = intval($data['pushid']);
				$siteroot = trim($data['siteroot']);
				$sendArr = array('type' => 'redpackdraw', 'fromUser' => 'system', 'toUser' => $fd, 'status' => 0, 'redpackid' => $redpackid);
				if (!empty($redpackid) && !empty($siteroot)) {
					$table_pushrecords = $this->getTable('push_records', $data['roomid']);
					$pushrecord = $this->redis($server)->hGet($table_pushrecords, $redpackid);

					if (!empty($pushrecord)) {
						$table_redpack = $this->getTable('redpack_' . $redpackid, $data['roomid']);

						if ($this->redis($server)->exists($table_redpack)) {
							$table_redpack_list = $this->getTable('redpack_list_' . $redpackid, $data['roomid']);
							$table_redpack_order = $this->getTable('redpack_order_' . $redpackid, $data['roomid']);
							$redpacktotal = $this->redis($server)->lLen($table_redpack);

							if (0 < $redpacktotal) {
								$selfdata = $this->redis($server)->hGet($table_redpack_list, $data['openid']);

								if (!empty($selfdata)) {
									$selfdata = json_decode($selfdata, true);

									if (0 < $selfdata['money']) {
										$sendArr['status'] = 1;
										$sendArr['redpackindex'] = $selfdata['redpackindex'];
										$sendArr['money'] = $selfdata['money'];
										$sendArr['time'] = $selfdata['time'];
									}
								}
								else {
									if ($this->redis($server)->hLen($table_redpack_list) < $redpacktotal) {
										$this->redis($server)->rPush($table_redpack_order, $data['openid']);
										$this->redis($server)->hSet($table_redpack_list, $data['openid'], json_encode(array('nickname' => $data['nickname'], 'redpackindex' => -1, 'money' => 0, 'time' => 0)));
									}
								}

								$prelist = $this->redis($server)->lRange($table_redpack_order, 0, $redpacktotal);
								$prelist = array_unique($prelist);
								$selfsent = false;

								foreach ($prelist as $index => $openid) {
									$userdata = $this->redis($server)->hGet($table_redpack_list, $openid);

									if (empty($userdata)) {
										continue;
									}

									$userdata = json_decode($userdata, true);

									if (0 < $userdata['money']) {
										continue;
									}

									$preredpack = $this->redis($server)->lIndex($table_redpack, $index);
									$preredpack = json_decode($preredpack, true);
									if (!empty($preredpack['used']) || empty($preredpack['money'])) {
										continue;
									}

									$preredpack['used'] = $openid;
									$preredpack['time'] = time();
									$this->redis($server)->lSet($table_redpack, $index, json_encode($preredpack));
									$userdata['redpackindex'] = $index;
									$userdata['money'] = $preredpack['money'];
									$userdata['time'] = time();
									$this->redis($server)->hSet($table_redpack_list, $openid, json_encode($userdata));
									$this->sendCredit($siteroot, $data['openid'], $preredpack['money'], '直播间推送红包，直播间id:' . $data['roomid']);

									if ($openid == $data['openid']) {
										$selfsent = true;
										$sendArr['redpackindex'] = $userdata['redpackindex'];
										$sendArr['money'] = $userdata['money'];
										$sendArr['time'] = $userdata['time'];
									}

									$this->updateRedpack($server, $data['roomid'], $redpackid, $userdata['money']);
								}

								if (empty($sendArr['status'])) {
									if ($selfsent) {
										$sendArr['status'] = 3;
									}
									else {
										$sendArr['status'] = 2;
									}
								}

								if (0 < $sendArr['status']) {
									$sendArr['list'] = $this->getRedpackList($server, $table_redpack_list);
								}
							}
						}
					}
				}

				$this->send($server, $fd, $sendArr);

				if ($sendArr['status'] == 3) {
					$sendArr['toUser'] = 'manage';
					$sendArr['roomid'] = $data['roomid'];
					$redpack_record = $this->redis($server)->hGet($table_pushrecords, $redpackid);

					if (!empty($redpack_record)) {
						$sendArr['redpack'] = json_decode($redpack_record, true);
						$this->sendAll($server, $sendArr);
					}
				}
			}
			else if ($data['type'] == 'coupon') {
				if (!$this->isManage($data['uid'])) {
					return false;
				}

				$msgid = $this->getMsgid($data['uid']);
				$pushcouponid = time();
				$couponid = intval($data['couponId']);
				$couponname = trim($data['couponName']);
				$coupontotal = intval($data['couponTotal']);
				$couponvaluetext = trim($data['couponValueText']);
				$couponvaluetotal = trim($data['couponValueTotal']);
				$couponuselimit = trim($data['couponUseLimit']);
				if (empty($couponid) || empty($coupontotal)) {
					return false;
				}

				if (empty($couponname)) {
					$couponname = '优惠券来袭，手慢无！';
				}

				$table_coupon = $this->getTable('coupon_' . $pushcouponid, $data['roomid']);
				$i = 0;

				while ($i < $coupontotal) {
					$this->redis($server)->rPush($table_coupon, json_encode(array('couponid' => $couponid, 'used' => 0)));
					++$i;
				}

				$table_pushrecords_order = $this->getTable('push_records_order', $data['roomid']);
				$this->redis($server)->rPush($table_pushrecords_order, $pushcouponid);
				$table_pushrecords = $this->getTable('push_records', $data['roomid']);
				$this->redis($server)->hSet($table_pushrecords, $pushcouponid, json_encode(array('title' => $couponname, 'type' => 2, 'time' => $pushcouponid, 'total' => $coupontotal, 'total_remain' => $coupontotal, 'coupon_value_text' => $couponvaluetext, 'coupon_value_total' => $couponvaluetotal, 'coupon_uselimit' => $couponuselimit)));
				$table_records = $this->getTable('chat_records', $data['roomid']);
				$this->redis($server)->rPush($table_records, json_encode(array('id' => $msgid, 'mid' => $data['uid'], 'nickname' => $data['nickname'], 'type' => $data['type'], 'text' => $couponname, 'pushid' => $pushcouponid, 'sendtime' => time())));
				$this->sendAll($server, array(
					'type'     => 'coupon',
					'fromUser' => $data['uid'],
					'toUser'   => 'all',
					'nickname' => $data['nickname'],
					'coupon'   => array('title' => $couponname, 'id' => $pushcouponid, 'total' => $coupontotal),
					'msgid'    => $msgid,
					'roomid'   => $data['roomid']
				));
			}
			else {
				if ($data['type'] == 'coupondraw') {
					$couponid = intval($data['pushid']);
					$siteroot = trim($data['siteroot']);
					$sendArr = array('type' => 'coupondraw', 'fromUser' => 'system', 'toUser' => $fd, 'status' => 0, 'couponid' => $couponid);
					$table_pushrecords = $this->getTable('push_records', $data['roomid']);
					$pushrecord = $this->redis($server)->hGet($table_pushrecords, $couponid);
					if (!empty($pushrecord) && !empty($siteroot)) {
						$pushrecord = json_decode($pushrecord, true);
						$table_coupon = $this->getTable('coupon_' . $couponid, $data['roomid']);

						if ($this->redis($server)->exists($table_coupon)) {
							$table_coupon_list = $this->getTable('coupon_list_' . $couponid, $data['roomid']);
							$table_coupon_order = $this->getTable('coupon_order_' . $couponid, $data['roomid']);
							$coupontotal = $this->redis($server)->lLen($table_coupon);

							if (0 < $coupontotal) {
								$selfdata = $this->redis($server)->hGet($table_coupon_list, $data['openid']);

								if (!empty($selfdata)) {
									$selfdata = json_decode($selfdata, true);

									if (0 < $selfdata['couponid']) {
										$sendArr['status'] = 1;
										$sendArr['couponname'] = '123';
										$sendArr['couponvaluetext'] = $pushrecord['coupon_value_text'];
										$sendArr['couponvaluetotal'] = $pushrecord['coupon_value_total'];
										$sendArr['couponuselimit'] = $pushrecord['coupon_uselimit'];
										$sendArr['shopcoupon'] = $selfdata['couponid'];
										$sendArr['time'] = $selfdata['time'];
									}
								}
								else {
									if ($this->redis($server)->hLen($table_coupon_list) < $coupontotal) {
										$this->redis($server)->rPush($table_coupon_order, $data['openid']);
										$this->redis($server)->hSet($table_coupon_list, $data['openid'], json_encode(array('nickname' => $data['nickname'], 'couponid' => 0, 'time' => 0)));
									}
								}

								$prelist = $this->redis($server)->lRange($table_coupon_order, 0, $coupontotal);
								$prelist = array_unique($prelist);
								$selfsent = false;

								foreach ($prelist as $index => $openid) {
									$userdata = $this->redis($server)->hGet($table_coupon_list, $openid);

									if (empty($userdata)) {
										continue;
									}

									$userdata = json_decode($userdata, true);

									if (0 < $userdata['couponid']) {
										continue;
									}

									$precoupon = $this->redis($server)->lIndex($table_coupon, $index);
									$precoupon = json_decode($precoupon, true);
									if (!empty($precoupon['used']) || empty($precoupon['couponid'])) {
										continue;
									}

									$precoupon['used'] = $openid;
									$precoupon['time'] = time();
									$this->redis($server)->lSet($table_coupon, $index, json_encode($precoupon));
									$userdata['couponindex'] = $index;
									$userdata['couponid'] = $precoupon['couponid'];
									$userdata['time'] = $precoupon['time'];
									$this->redis($server)->hSet($table_coupon_list, $openid, json_encode($userdata));
									$this->sendCoupon($siteroot, $data['openid'], $precoupon['couponid']);

									if ($openid == $data['openid']) {
										$selfsent = true;
										$sendArr['couponindex'] = $userdata['couponindex'];
										$sendArr['couponvaluetext'] = $pushrecord['coupon_value_text'];
										$sendArr['couponvaluetotal'] = $pushrecord['coupon_value_total'];
										$sendArr['couponuselimit'] = $pushrecord['coupon_uselimit'];
										$sendArr['shopcoupon'] = $userdata['couponid'];
										$sendArr['time'] = $userdata['time'];
									}

									$this->updateCoupon($server, $data['roomid'], $couponid);
								}

								if (empty($sendArr['status'])) {
									if ($selfsent) {
										$sendArr['status'] = 3;
									}
									else {
										$sendArr['status'] = 2;
									}
								}
							}
						}
					}

					$this->send($server, $fd, $sendArr);

					if ($sendArr['status'] == 3) {
						$sendArr['toUser'] = 'manage';
						$sendArr['roomid'] = $data['roomid'];
						$redpack_record = $this->redis($server)->hGet($table_pushrecords, $couponid);

						if (!empty($redpack_record)) {
							$sendArr['coupon'] = json_decode($redpack_record, true);
							$this->sendAll($server, $sendArr);
						}
					}
				}
			}
		}

		return false;
	}

	/**
     * @param $server
     * @param $fd
     */
	public function onClose($server, $fd = 0, $data = array())
	{
		if (empty($data) || empty($data['roomid'])) {
			return false;
		}

		$isFd = true;

		if (!empty($data['uid'])) {
			$fd = $data['uid'];
			$isFd = false;
		}

		$this->delUser($server, $data['roomid'], $fd, $isFd);
		return true;
	}

	/**
     * 向单个用户发送消息
     * @param $server
     * @param $data
     * @return bool
     */
	protected function send($server = NULL, $fd = 0, $data = array())
	{
		if (empty($server) || empty($fd) || empty($data)) {
			return false;
		}

		if (!$this->exist($server, $fd)) {
			$this->delUser($server, $data['roomid'], $fd, true, false);
			return true;
		}

		if (is_array($data)) {
			unset($data['roomid']);

			if (!isset($data['time'])) {
				$data['time'] = time();
			}

			$data = json_encode($data);
		}

		if (isset($server->workerman)) {
			$result = $this->push($fd, $data);
		}
		else {
			$result = $server->push($fd, $data);
		}

		return $result;
	}

	protected function push($uid, $data)
	{
		global $worker;

		if (isset($worker->uidConnections[$uid])) {
			$connection = $worker->uidConnections[$uid];
			$connection->send($data);
			return true;
		}

		return false;
	}

	protected function exist($server = NULL, $fd = 0)
	{
		if (empty($server) || empty($fd)) {
			return false;
		}

		if (isset($server->workerman)) {
			if (!isset($server->uidConnections[$fd])) {
				return false;
			}
		}
		else {
			if (!$server->exist($fd)) {
				return false;
			}
		}

		return true;
	}

	protected function sendAll($server = NULL, $data = array(), $fd = 0, $at = array(), $isUid = false)
	{
		if (empty($server) || empty($data) || empty($data['roomid'])) {
			return false;
		}

		$allUser = $this->getAllUser($server, $data['roomid']);

		if (empty($allUser)) {
			return true;
		}

		$atArr = array();

		if (!empty($at)) {
			$at = array_filter($at);
			$atArr = array_keys($at);
			$data['atUsers'] = $at;
		}

		foreach ($allUser as $uid => $user) {
			if (empty($user)) {
				continue;
			}

			$user = json_decode($user, true);

			if ($data['toUser'] == 'manage') {
				if ($user['role'] != 'manage') {
					if ($isUid) {
						if ($uid != $fd) {
							continue;
						}
					}
					else {
						if ($user['fd'] != $fd) {
							continue;
						}
					}
				}
			}
			else if ($isUid) {
				if ($uid == $fd) {
					continue;
				}
			}
			else {
				if (!empty($fd) && $fd == $user['fd']) {
					continue;
				}
			}

			if (!empty($atArr) && in_array($uid, $atArr)) {
				$data['at'] = 1;
			}

			if ($data['fromUser'] == $uid) {
				$data['self'] = 1;
			}
			else {
				unset($data['self']);
			}

			$this->send($server, $user['fd'], $data);
		}

		return true;
	}

	/**
     * 生成表名
     * @param $table
     * @param $roomid
     * @return string
     */
	protected function getTable($table, $roomid)
	{
		return 'ewei_shop_live_' . $table . '_' . $roomid;
	}

	/**
     * 添加用户
     * @param $uid
     * @param $data
     */
	protected function addUser($server = array(), $uid, $data)
	{
		$table = $this->getTable('room', $data['roomid']);
		$this->redis($server)->hSet($table, $uid, json_encode($data));
		return true;
	}

	/**
     * 更新用户信息
     * @param $uid
     * @param $data
     */
	protected function updateUser($uid, $data)
	{
	}

	/**
     * 获取单个用户信息
     * @param $uid
     * @param $fd 传进来是否是fd
     */
	public function getUser($server = array(), $roomid = 0, $uid = 0, $isFd = false)
	{
		if (empty($roomid) && empty($uid)) {
			return false;
		}

		$table = $this->getTable('room', $roomid);

		if ($isFd) {
			$user = false;
			$allUser = $this->getAllUser($server, $roomid);

			if (!empty($allUser)) {
				foreach ($allUser as $key => $value) {
					if (empty($value)) {
						continue;
					}

					$value = json_decode($value, true);

					if ($value['fd'] == $uid) {
						$user = $value;
						break;
					}
				}
			}
		}
		else {
			$user = $this->redis($server)->hGet($table, $uid);
		}

		if (!empty($user) && !is_array($user)) {
			$user = json_decode($user, true);
		}

		return $user;
	}

	/**
     * 获取所有在线用户列表
     */
	public function getAllUser($server = array(), $roomid = 0)
	{
		$table = $this->getTable('room', $roomid);
		$list = $this->redis($server)->hGetAll($table);
		return $list;
	}

	/**
     * 获取在线用户数量
     */
	public function getUserTotal($server = array(), $roomid = 0)
	{
		$table = $this->getTable('room', $roomid);
		$total = $this->redis($server)->hLen($table);
		return intval($total);
	}

	/**
     * 获取单用户禁言状态
     * @param $uid
     */
	public function getBanned($server = array(), $roomid = 0, $uid = 0)
	{
		$return = array();
		$table = $this->getTable('banned', $roomid);
		$return['all'] = $this->redis($server)->hGet($table, 'bannedAll');

		if (empty($uid)) {
			$return['self'] = 1;
		}
		else {
			$return['self'] = $this->redis($server)->hGet($table, $uid);
		}

		return $return;
	}

	/**
     * 获取禁言用户列表
     */
	public function getBannedUser($server = array(), $roomid = 0)
	{
		$table = $this->getTable('banned', $roomid);
		$list = $this->redis($server)->hGetAll($table);
		unset($list['bannedAll']);
		return $list;
	}

	/**
     * 获取禁言用户数量
     */
	public function getBannedTotal($server = array(), $roomid = 0)
	{
		$table = $this->getTable('banned', $roomid);
		return $this->redis($server)->hLen($table);
	}

	/**
     * 删除用户
     * @param $uid
     * @param bool $fd 传进来是否是fd
     */
	protected function delUser($server, $roomid = 0, $uid = 0, $isFd = false, $notice = true)
	{
		if (empty($roomid) || empty($uid)) {
			return NULL;
		}

		$table = $this->getTable('room', $roomid);

		if ($isFd) {
			$user = $this->getUser($server, $roomid, $uid, true);
		}
		else {
			$user = $this->redis($server)->hGet($table, $uid);
			$user = !empty($user) ? json_decode($user, true) : false;
		}

		if (!empty($user)) {
			if ($notice) {
				$this->sendAll($server, array('type' => 'userLeave', 'fromUser' => $user['uid'], 'toUser' => 'all', 'nickname' => $user['nickname'], 'roomid' => $roomid), $user['fd']);
			}

			$this->redis($server)->hDel($table, $user['uid']);
		}
	}

	/**
     * 获取单用户管理员状态
     * @param $uid
     */
	protected function isManage($uid)
	{
		global $_W;

		if (strexists($uid, 'console')) {
			$user = explode('_', $uid);

			if (is_array($user)) {
				if ($user[2] == 'founder') {
					$founders = $_W['config']['setting']['founder'];

					if (!empty($founders)) {
						$founders = explode(',', $founders);

						if (in_array($user[1], $founders)) {
							return true;
						}
					}
				}
				else {
					if ($user[2] == 'vice') {
						$founders = $_W['config']['setting']['founder'];

						if (!empty($founders)) {
							$founders = explode(',', $founders);

							if (in_array($user[1], $founders)) {
								return true;
							}
						}
					}
				}

				$account = pdo_fetch2('SELECT * FROM ' . tablename('uni_account_users') . ' WHERE uid=:uid AND uniacid=:uniacid', array(':uid' => $user[1], ':uniacid' => $user[3]));
				$account_ne = pdo_fetch2('SELECT * FROM ' . tablename('uni_account_users') . ' WHERE uid=:uid AND uniacid=:uniacid', array(':uid' => $user[1], ':uniacid' => $user[4]));
				if (!empty($account) || !empty($account_ne)) {
					return true;
				}
			}
		}

		return false;
	}

	public function getMsgid($uid)
	{
		$rand = rand(11111111, 99999999);
		$time = time();
		$id = $time . '' . $rand . '' . intval($uid);
		return md5($id);
	}

	/**
     * 获取房间设置
     */
	public function getRoomSetting($server = array(), $roomid, $uid = 0)
	{
		$settings = array('canat' => 0, 'canrepeal' => 0, 'virtual' => 0, 'virtualadd' => 1, 'status' => 0);

		if (empty($roomid)) {
			return $settings;
		}

		$table = $this->getTable('settings', $roomid);
		$settingsArr = $this->redis($server)->hGetAll($table);

		if (!empty($settingsArr)) {
			$settings['canat'] = intval($settingsArr['canat']);
			$settings['canrepeal'] = intval($settingsArr['canrepeal']);
			$settings['virtual'] = intval($settingsArr['virtual']);
			$settings['virtualadd'] = intval($settingsArr['virtualadd']);
			$settings['status'] = intval($settingsArr['status']);
			if (!empty($uid) && isset($settingsArr[$uid])) {
				$settings['nickname'] = $settingsArr[$uid];
			}
		}

		return $settings;
	}

	/**
     * 获取单条聊天
     * @param $msgid
     * @param $roomid
     * @return array
     */
	public function getSingleMsg($server = array(), $msgid = 0, $roomid = 0)
	{
		$message = array();
		if (!empty($msgid) && !empty($roomid)) {
			$table = $this->getTable('chat_records', $roomid);
			$records = $this->redis($server)->lRange($table, 0, -1);

			if (!empty($records)) {
				foreach ($records as $index => $record) {
					$record = json_decode($record, true);

					if (empty($record)) {
						continue;
					}

					if ($record['id'] == $msgid) {
						$message = $record;
						break;
					}
				}
			}
		}

		return $message;
	}

	/**
     * 更新消息状态
     * @param $msgid
     * @param $roomid
     * @return bool
     */
	public function updateMsg($server = array(), $msgid = 0, $roomid = 0, $status = 0, $other = array())
	{
		$result = false;
		if (!empty($msgid) && !empty($roomid) && !empty($status)) {
			$table = $this->getTable('chat_records', $roomid);
			$records = $this->redis($server)->lRange($table, 0, -1);

			if (!empty($records)) {
				foreach ($records as $index => $record) {
					$record = json_decode($record, true);

					if (empty($record)) {
						continue;
					}

					if ($record['id'] == $msgid) {
						$record['status'] = $status;
						$record = array_merge($record, $other);
						$this->redis($server)->lSet($table, $index, json_encode($record));
						$result = true;
						break;
					}
				}
			}
		}

		return $result;
	}

	/**
     * 获取已领取红包列表
     * @param $table
     * @return array
     */
	public function getRedpackList($server = array(), $table)
	{
		$list_arr = array();
		$list = $this->redis($server)->hGetAll($table);

		if (!empty($list)) {
			foreach ($list as $item) {
				$item = json_decode($item, true);

				if (0 < $item['money']) {
					$list_arr[] = $item;
				}
			}
		}

		return $list_arr;
	}

	/**
     * 更新红包数量
     * @param $roomid
     * @param $redpackid
     * @param $money
     * @return bool
     */
	public function updateRedpack($server = array(), $roomid, $redpackid, $money)
	{
		if (empty($roomid) || empty($redpackid)) {
			return false;
		}

		$table_pushrecords = $this->getTable('push_records', $roomid);
		$pushrecord = $this->redis($server)->hGet($table_pushrecords, $redpackid);

		if (empty($pushrecord)) {
			return false;
		}

		$pushrecord = json_decode($pushrecord, true);
		--$pushrecord['total_remain'];
		$pushrecord['money_remain'] -= $money;
		$this->redis($server)->hSet($table_pushrecords, $redpackid, json_encode($pushrecord));
	}

	/**
     * 更新优惠券数量
     * @param $roomid
     * @param $coupon
     */
	public function updateCoupon($server = array(), $roomid, $couponid)
	{
		if (empty($roomid) || empty($couponid)) {
			return false;
		}

		$table_pushrecords = $this->getTable('push_records', $roomid);
		$pushrecord = $this->redis($server)->hGet($table_pushrecords, $couponid);

		if (empty($pushrecord)) {
			return false;
		}

		$pushrecord = json_decode($pushrecord, true);
		--$pushrecord['total_remain'];
		$this->redis($server)->hSet($table_pushrecords, $couponid, json_encode($pushrecord));
	}

	/**
     * 发送优惠券
     * @param $openid
     * @param $couponid
     * @param int $total
     * @return bool
     */
	public function sendCoupon($siteroot = NULL, $openid = NULL, $couponid = 0, $total = 1)
	{
		global $_W;
		if (empty($siteroot) || empty($couponid) || empty($total) || empty($openid)) {
			return false;
		}

		load()->func('communication');
		$code = base64_encode(authcode($openid . '|' . $couponid, 'ENCODE'));
		$url = $siteroot . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=ewei_shopv2&do=mobile&r=live.send.coupon';
		ihttp_post($url, array('code' => $code));
	}

	public function sendCredit($siteroot = NULL, $openid = NULL, $fee = 0, $log = NULL)
	{
		global $_W;
		if (empty($siteroot) || empty($openid) || empty($fee)) {
			return false;
		}

		load()->func('communication');
		$code = base64_encode(authcode($openid . '|' . $fee . '|' . $log, 'ENCODE'));
		$url = $siteroot . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=ewei_shopv2&do=mobile&r=live.send.credit';
		ihttp_post($url, array('code' => $code));
	}

	/**
     * 日志记录
     * @param $name
     * @param $text
     */
	public function log($name, $text)
	{
		$filename = dirname(__FILE__) . '/log_' . $name . '.log';
		$text = '[' . date('Y-m-d H:i:s', time()) . '] ' . $text;
		file_put_contents($filename, $text . '
', FILE_APPEND);
	}

	public function special($obj)
	{
		if (!is_array($obj)) {
			$obj = istripslashes($obj);
			$obj = ihtmlspecialchars($obj);
		}
		else {
			foreach ($obj as $k => &$v) {
				$v = istripslashes($v);
				$v = ihtmlspecialchars($v);
			}
		}

		return $obj;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_CORE . 'socket/pdo.php';

?>
