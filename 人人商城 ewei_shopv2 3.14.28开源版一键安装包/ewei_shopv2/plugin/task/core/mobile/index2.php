<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$tabpage = $_GPC['tabpage'];
		$openid = trim($_W['openid']);
		$is_menu = $this->model->getdefault('menu_state');
		$member = m('member')->getMember($openid);
		$now_time = time();
		$task_sql = 'SELECT * FROM ' . tablename('ewei_shop_task_poster') . ' WHERE timestart<=' . $now_time . ' AND timeend>' . $now_time . ' AND uniacid=' . $_W['uniacid'] . ' AND `status`=1 AND `is_delete`=0 ORDER BY `createtime` DESC LIMIT 0,15';
		$task_list = pdo_fetchall($task_sql);

		foreach ($task_list as $key => $val) {
			if ($val['poster_type'] == 1) {
				$val['reward_data'] = unserialize($val['reward_data']);
				$recward = $val['reward_data']['rec'];
				if (isset($recward['credit']) && 0 < $recward['credit']) {
					$task_list[$key]['is_credit'] = 1;
				}

				if (isset($recward['money']['num']) && 0 < $recward['money']['num']) {
					$task_list[$key]['is_money'] = 1;
				}

				if (isset($recward['bribery']) && 0 < $recward['bribery']) {
					$task_list[$key]['is_bribery'] = 1;
				}

				if (isset($recward['goods']) && count($recward['goods'])) {
					$task_list[$key]['is_goods'] = 1;
				}

				if (isset($recward['coupon']['total']) && 0 < $recward['coupon']['total']) {
					$task_list[$key]['is_coupon'] = 1;
				}
			}
			else {
				if ($val['poster_type'] == 2) {
					$val['reward_data'] = unserialize($val['reward_data']);
					$recward = $val['reward_data']['rec'];

					foreach ($recward as $k => $v) {
						if (isset($v['credit']) && 0 < $v['credit']) {
							$task_list[$key]['is_credit'] = 1;
						}

						if (isset($v['money']['num']) && 0 < $v['money']['num']) {
							$task_list[$key]['is_money'] = 1;
						}

						if (isset($v['bribery']) && 0 < $v['bribery']) {
							$task_list[$key]['is_bribery'] = 1;
						}

						if (isset($v['goods']) && count($v['goods'])) {
							$task_list[$key]['is_goods'] = 1;
						}

						if (isset($v['coupon']['total']) && 0 < $v['coupon']['total']) {
							$task_list[$key]['is_coupon'] = 1;
						}
					}
				}
			}
		}

		$running_sql = 'SELECT `join`.*,`task`.title,`task`.reward_data AS `poster_reward`,`task`.titleicon,`task`.poster_type FROM ' . tablename('ewei_shop_task_join') . ' AS `join` LEFT JOIN ' . tablename('ewei_shop_task_poster') . ' AS `task` ON `join`.task_id=`task`.`id` WHERE `join`.`failtime`>' . $now_time . ' AND `join`.`join_user`="' . $openid . '" AND `join`.uniacid=' . $_W['uniacid'] . ' AND `join`.`is_reward` = 0 ORDER BY `join`.`addtime` DESC LIMIT 0,15';
		$task_running = pdo_fetchall($running_sql);

		foreach ($task_running as $key => $val) {
			if ($val['poster_type'] == 1) {
				$val['reward_data'] = unserialize($val['poster_reward']);
				$recward = $val['reward_data']['rec'];
				if (isset($recward['credit']) && 0 < $recward['credit']) {
					$task_running[$key]['is_credit'] = 1;
				}

				if (isset($recward['money']['num']) && 0 < $recward['money']['num']) {
					$task_running[$key]['is_money'] = 1;
				}

				if (isset($recward['bribery']) && 0 < $recward['bribery']) {
					$task_running[$key]['is_bribery'] = 1;
				}

				if (isset($recward['goods']) && count($recward['goods'])) {
					$task_running[$key]['is_goods'] = 1;
				}

				if (isset($recward['coupon']['total']) && 0 < $recward['coupon']['total']) {
					$task_running[$key]['is_coupon'] = 1;
				}
			}
			else {
				if ($val['poster_type'] == 2) {
					$val['reward_data'] = unserialize($val['poster_reward']);
					$recward = $val['reward_data']['rec'];

					foreach ($recward as $k => $v) {
						if (isset($v['credit']) && 0 < $v['credit']) {
							$task_running[$key]['is_credit'] = 1;
						}

						if (isset($v['money']['num']) && 0 < $v['money']['num']) {
							$task_running[$key]['is_money'] = 1;
						}

						if (isset($v['bribery']) && 0 < $v['bribery']) {
							$task_running[$key]['is_bribery'] = 1;
						}

						if (isset($v['goods']) && count($v['goods'])) {
							$task_running[$key]['is_goods'] = 1;
						}

						if (isset($v['coupon']['total']) && 0 < $v['coupon']['total']) {
							$task_running[$key]['is_coupon'] = 1;
						}
					}
				}
			}
		}

		$complete_sql = 'SELECT `join`.*,`task`.title,`task`.titleicon,`task`.poster_type FROM ' . tablename('ewei_shop_task_join') . ' AS `join` LEFT JOIN ' . tablename('ewei_shop_task_poster') . ' AS `task` ON `join`.task_id=`task`.`id` WHERE `join`.uniacid=' . $_W['uniacid'] . ' AND `join`.`join_user`="' . $openid . '" AND `join`.`is_reward`=1 ORDER BY `join`.`addtime` DESC LIMIT 0,15';
		$task_complete = pdo_fetchall($complete_sql);

		foreach ($task_complete as $key => $val) {
			if ($val['poster_type'] == 1) {
				$task_complete[$key]['reward_data'] = unserialize($val['reward_data']);
				$val['reward_data'] = unserialize($val['reward_data']);
				$recward = $val['reward_data'];
				if (isset($recward['credit']) && 0 < $recward['credit']) {
					$task_complete[$key]['is_credit'] = 1;
				}

				if (isset($recward['money']['num']) && 0 < $recward['money']['num']) {
					$task_complete[$key]['is_money'] = 1;
				}

				if (isset($recward['bribery']) && 0 < $recward['bribery']) {
					$task_complete[$key]['is_bribery'] = 1;
				}

				if (isset($recward['goods']) && count($recward['goods'])) {
					$task_complete[$key]['is_goods'] = 1;
				}

				if (isset($recward['coupon']['total']) && 0 < $recward['coupon']['total']) {
					$task_complete[$key]['is_coupon'] = 1;
				}
			}
			else {
				if ($val['poster_type'] == 2) {
					$val['reward_data'] = unserialize($val['reward_data']);
					$recward = $val['reward_data'];

					foreach ($recward as $k => $v) {
						if (isset($v['credit']) && 0 < $v['credit']) {
							$task_complete[$key]['is_credit'] = 1;
						}

						if (isset($v['money']['num']) && 0 < $v['money']['num']) {
							$task_complete[$key]['is_money'] = 1;
						}

						if (isset($v['bribery']) && 0 < $v['bribery']) {
							$task_complete[$key]['is_bribery'] = 1;
						}

						if (isset($v['goods']) && count($v['goods'])) {
							$task_complete[$key]['is_goods'] = 1;
						}

						if (isset($v['coupon']['total']) && 0 < $v['coupon']['total']) {
							$task_complete[$key]['is_coupon'] = 1;
						}
					}
				}
			}
		}

		$faile_sql = 'SELECT `join`.*,`task`.title,`task`.reward_data AS `poster_reward`,`task`.titleicon,`task`.poster_type FROM ' . tablename('ewei_shop_task_join') . ' AS `join` LEFT JOIN ' . tablename('ewei_shop_task_poster') . ' AS `task` ON `join`.task_id=`task`.`id` WHERE `join`.`failtime`<=' . $now_time . ' AND `join`.`join_user`="' . $openid . '" AND `join`.uniacid=' . $_W['uniacid'] . ' AND `join`.`is_reward`=0 ORDER BY `join`.`addtime` DESC LIMIT 0,15';
		$faile_complete = pdo_fetchall($faile_sql);

		foreach ($faile_complete as $key => $val) {
			if ($val['poster_type'] == 1) {
				$val['reward_data'] = unserialize($val['poster_reward']);
				$recward = $val['reward_data']['rec'];
				if (isset($recward['credit']) && 0 < $recward['credit']) {
					$faile_complete[$key]['is_credit'] = 1;
				}

				if (isset($recward['money']['num']) && 0 < $recward['money']['num']) {
					$faile_complete[$key]['is_money'] = 1;
				}

				if (isset($recward['bribery']) && 0 < $recward['bribery']) {
					$faile_complete[$key]['is_bribery'] = 1;
				}

				if (isset($recward['goods']) && count($recward['goods'])) {
					$faile_complete[$key]['is_goods'] = 1;
				}

				if (isset($recward['coupon']['total']) && 0 < $recward['coupon']['total']) {
					$faile_complete[$key]['is_coupon'] = 1;
				}
			}
			else {
				if ($val['poster_type'] == 2) {
					$val['reward_data'] = unserialize($val['poster_reward']);
					$recward = $val['reward_data']['rec'];

					foreach ($recward as $k => $v) {
						if (isset($v['credit']) && 0 < $v['credit']) {
							$faile_complete[$key]['is_credit'] = 1;
						}

						if (isset($v['money']['num']) && 0 < $v['money']['num']) {
							$faile_complete[$key]['is_credit'] = 1;
						}

						if (isset($v['bribery']) && 0 < $v['bribery']) {
							$faile_complete[$key]['is_money'] = 1;
						}

						if (isset($v['goods']) && count($v['goods'])) {
							$faile_complete[$key]['is_goods'] = 1;
						}

						if (isset($v['coupon']['total']) && 0 < $v['coupon']['total']) {
							$faile_complete[$key]['is_coupon'] = 1;
						}
					}
				}
			}
		}

		$advs = pdo_fetchall('select id,advname,link,thumb from ' . tablename('ewei_shop_task_adv') . ' where uniacid=:uniacid and enabled=1 order by displayorder desc', array(':uniacid' => $_W['uniacid']));
		$advs = set_medias($advs, 'thumb');
		include $this->template();
	}

	public function gettask()
	{
		global $_W;
		global $_GPC;
		$content = trim($_GPC['content']);
		$timeout = 4;
		$url = mobileUrl('task/build', array('timestamp' => TIMESTAMP), true);
		ihttp_request($url, array('openid' => $_W['openid'], 'content' => urlencode($content)), array(), $timeout);
		echo json_encode(array('status' => 1));
		exit();
	}

	public function gettaskinfo()
	{
		global $_W;
		global $_GPC;

		if (intval($_GPC['id'])) {
			$param = array(':id' => intval($_GPC['id']), ':uniacid' => $_W['uniacid']);
			$now_time = time();
			$task_sql = 'SELECT * FROM ' . tablename('ewei_shop_task_poster') . ' WHERE timestart<=' . $now_time . ' AND timeend>' . $now_time . ' AND uniacid=:uniacid AND id=:id AND `status`=1  ';
			$taskinfo = pdo_fetch($task_sql, $param);
			$taskinfo['reward_data'] = unserialize($taskinfo['reward_data']);
			$db_data = pdo_fetchcolumn('select `data` from ' . tablename('ewei_shop_task_default') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
			$res = '';

			if (!empty($db_data)) {
				$res = unserialize($db_data);
			}

			$is_get = 0;

			if ($res['is_posterall'] == 1) {
				$task_count = pdo_fetchcolumn('select COUNT(*) from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_type=' . $taskinfo['poster_type'] . ' and is_reward=0 and failtime>' . time(), array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));

				if (empty($task_count)) {
					$end_task_count = pdo_fetchcolumn('select COUNT(*) from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_id=' . $taskinfo['id'] . ' and (is_reward=1 or failtime<' . time() . ')', array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));

					if ($end_task_count) {
						if ($taskinfo['is_repeat']) {
							$is_get = 1;
						}
					}
					else {
						$is_get = 1;
					}
				}
			}
			else {
				$poster_type = 1;

				if ($taskinfo['poster_type'] == 1) {
					$poster_type = 2;
				}

				$other_task_count = pdo_fetchcolumn('select COUNT(*) from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_type=' . $poster_type . ' and failtime>' . time(), array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));
				$task_count = pdo_fetchcolumn('select task_id from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_type=' . $taskinfo['poster_type'] . ' and failtime>' . time(), array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));
				if (empty($other_task_count) && empty($task_count)) {
					$is_get = 1;
				}
				else {
					if (empty($other_task_count) && (!empty($task_count) && $task_count == intval($_GPC['id']))) {
						$is_get = 1;
					}
				}
			}

			if ($taskinfo['poster_type'] == 1) {
				include $this->template('task/taskinfo');
			}
			else {
				if ($taskinfo['poster_type'] == 2) {
					$rankinfo = array();
					$rankinfoone = array(1 => $res['taskranktitle'] . '1', 2 => $res['taskranktitle'] . '2', 3 => $res['taskranktitle'] . '3', 4 => $res['taskranktitle'] . '4', 5 => $res['taskranktitle'] . '5');
					$rankinfotwo = array(1 => $res['taskranktitle'] . 'Ⅰ', 2 => $res['taskranktitle'] . 'Ⅱ', 3 => $res['taskranktitle'] . 'Ⅲ', 4 => $res['taskranktitle'] . 'Ⅳ', 5 => $res['taskranktitle'] . 'Ⅴ');
					$rankinfothree = array(1 => $res['taskranktitle'] . 'A', 2 => $res['taskranktitle'] . 'B', 3 => $res['taskranktitle'] . 'C', 4 => $res['taskranktitle'] . 'D', 5 => $res['taskranktitle'] . 'E');

					if ($res['taskranktype'] == 1) {
						$rankinfo = $rankinfoone;
					}
					else if ($res['taskranktype'] == 2) {
						$rankinfo = $rankinfotwo;
					}
					else {
						if ($res['taskranktype'] == 3) {
							$rankinfo = $rankinfothree;
						}
					}

					include $this->template('task/ranktaskinfo');
				}
			}
		}
		else {
			$taskinfo = '';
			include $this->template('task/taskinfo');
		}
	}

	public function getcompleteinfo()
	{
		global $_W;
		global $_GPC;

		if (intval($_GPC['id'])) {
			$param = array(':join_user' => $_W['openid'], ':join_id' => intval($_GPC['id']));
			$task_sql = 'SELECT `join`.*,`task`.title,`task`.titleicon,`task`.poster_banner FROM ' . tablename('ewei_shop_task_join') . ' AS `join` LEFT JOIN ' . tablename('ewei_shop_task_poster') . ' AS `task` ON `join`.task_id=`task`.`id` WHERE `join`.uniacid=' . $_W['uniacid'] . ' AND `join`.join_user=:join_user AND `join`.`is_reward`=1 AND `join`.`join_id`=:join_id ';
			$taskinfo = pdo_fetch($task_sql, $param);

			if (!empty($taskinfo['reward_data'])) {
				$taskinfo['reward_data'] = unserialize($taskinfo['reward_data']);
			}

			$db_data = pdo_fetchcolumn('select `data` from ' . tablename('ewei_shop_task_default') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
			$res = '';

			if (!empty($db_data)) {
				$res = unserialize($db_data);
			}

			if ($taskinfo['task_type'] == 1) {
				include $this->template('task/complete');
			}
			else {
				if ($taskinfo['task_type'] == 2) {
					$rankinfo = array();
					$rankinfoone = array(1 => $res['taskranktitle'] . '1', 2 => $res['taskranktitle'] . '2', 3 => $res['taskranktitle'] . '3', 4 => $res['taskranktitle'] . '4', 5 => $res['taskranktitle'] . '5');
					$rankinfotwo = array(1 => $res['taskranktitle'] . 'Ⅰ', 2 => $res['taskranktitle'] . 'Ⅱ', 3 => $res['taskranktitle'] . 'Ⅲ', 4 => $res['taskranktitle'] . 'Ⅳ', 5 => $res['taskranktitle'] . 'Ⅴ');
					$rankinfothree = array(1 => $res['taskranktitle'] . 'A', 2 => $res['taskranktitle'] . 'B', 3 => $res['taskranktitle'] . 'C', 4 => $res['taskranktitle'] . 'D', 5 => $res['taskranktitle'] . 'E');

					if ($res['taskranktype'] == 1) {
						$rankinfo = $rankinfoone;
					}
					else if ($res['taskranktype'] == 2) {
						$rankinfo = $rankinfotwo;
					}
					else if ($res['taskranktype'] == 3) {
						$rankinfo = $rankinfothree;
					}
					else {
						$rankinfo = $rankinfoone;
					}

					include $this->template('task/rankcomplete');
				}
			}
		}
		else {
			$taskinfo = '';
			include $this->template('task/complete');
		}
	}

	public function goodslist()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$tasksql = 'SELECT * FROM ' . tablename('ewei_shop_task_join') . ' WHERE `join_id`=' . $id . ' AND `join_user`=:join_user';
		$taskinfo = pdo_fetch($tasksql, array(':join_user' => $_W['openid']));
		$goodslist = array();

		if ($taskinfo['task_type'] == 1) {
			$taskinfo['reward_data'] = unserialize($taskinfo['reward_data']);
			$goodslist = $taskinfo['reward_data']['goods'];

			foreach ($taskinfo['reward_data']['goods'] as $k => $v) {
				$searchsql = 'SELECT thumb,marketprice FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid= ' . $_W['uniacid'] . ' and id=' . $k . ' and status=1 and deleted=0';
				$goodsinfo = pdo_fetch($searchsql);
				$thumb = tomedia($goodsinfo['thumb']);
				$goodslist[$k]['thumb'] = $thumb;
				$goodslist[$k]['oldprice'] = $goodsinfo['marketprice'];

				if (!empty($goodslist[$k]['spec'])) {
					$goodslist[$k]['total'] = 0;

					foreach ($goodslist[$k]['spec'] as $key => $val) {
						if ($val['marketprice'] < $goodslist[$k]['marketprice']) {
							$goodslist[$k]['marketprice'] = $val['marketprice'];
						}

						$goodslist[$k]['total'] += $val['total'];
					}
				}
			}

			include $this->template('task/goodslist');
		}
		else {
			if ($taskinfo['task_type'] == 2) {
				$taskinfo['reward_data'] = unserialize($taskinfo['reward_data']);

				foreach ($taskinfo['reward_data'] as $key => $value) {
					if (isset($value['is_reward']) && $value['is_reward'] == 1) {
						$goodslist[$key] = $value['goods'];

						foreach ($value['goods'] as $k => $val) {
							$searchsql = 'SELECT thumb,marketprice FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid= ' . $_W['uniacid'] . ' and id=' . $k . ' and status=1 and deleted=0';
							$goodsinfo = pdo_fetch($searchsql);
							$thumb = tomedia($goodsinfo['thumb']);
							$goodslist[$key][$k]['thumb'] = $thumb;
							$goodslist[$key][$k]['oldprice'] = $goodsinfo['marketprice'];

							if (!empty($goodslist[$key][$k]['spec'])) {
								$goodslist[$key][$k]['total'] = 0;

								foreach ($goodslist[$k]['spec'] as $ke => $va) {
									if ($va['marketprice'] < $goodslist[$key][$k]['marketprice']) {
										$goodslist[$key][$k]['marketprice'] = $va['marketprice'];
									}

									$goodslist[$key][$k]['total'] += $va['total'];
								}
							}
						}
					}
				}

				include $this->template('task/goodslist');
			}
		}
	}

	public function getMoreTask()
	{
	}
}

?>
