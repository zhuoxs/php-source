<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$task_sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_lottery_join') . '  WHERE lottery_num>0 and uniacid=:uniacid AND `join_user`=:join_user ';
		$lottery = pdo_fetchcolumn($task_sql, array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));
		include $this->template();
	}

	public function getlotterylist()
	{
		global $_W;
		global $_GPC;
		$page = intval($_GPC['page']);

		if ($page == 0) {
			$page = 1;
		}

		$limit = ($page - 1) * 15;
		$task_sql = 'SELECT j.*,l.lottery_title,l.lottery_type,l.lottery_days FROM ' . tablename('ewei_shop_lottery_join') . ' as j left join ' . tablename('ewei_shop_lottery') . ' as l on j.lottery_id=l.lottery_id WHERE j.lottery_num>0 and j.uniacid=:uniacid AND j.`join_user`=:join_user AND l.`is_delete`=0 ORDER BY j.addtime DESC LIMIT ' . $limit . ',15';
		$lottery = pdo_fetchall($task_sql, array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));

		foreach ($lottery as $key => $value) {
			if (!empty($value['lottery_days'])) {
				$effecttime = time() - $value['lottery_days'];

				if ($value['addtime'] < $effecttime) {
					unset($lottery[$key]);
					continue;
				}
			}

			$lottery[$key]['addtime'] = date('Y-m-d', $value['addtime']);
			$lottery[$key]['link'] = mobileUrl('lottery/index/lottery_info', array('id' => $value['lottery_id']), true);

			if ($value['lottery_type'] == 1) {
				$lottery[$key]['icon'] = '../addons/ewei_shopv2/plugin/lottery/static/images/panicon.png';
			}
			else if ($value['lottery_type'] == 2) {
				$lottery[$key]['icon'] = '../addons/ewei_shopv2/plugin/lottery/static/images/guaicon.png';
			}
			else {
				if ($value['lottery_type'] == 3) {
					$lottery[$key]['icon'] = '../addons/ewei_shopv2/plugin/lottery/static/images/gridicon.png';
				}
			}
		}

		$task_sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_lottery_join') . '  WHERE lottery_num>0 and uniacid=:uniacid AND `join_user`=:join_user ';
		$count = pdo_fetchcolumn($task_sql, array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));
		show_json(1, array('list' => $lottery, 'total' => $count, 'pagesize' => 15));
	}

	public function lottery_info()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if ($id) {
			$task_sql = 'SELECT * FROM ' . tablename('ewei_shop_lottery') . ' WHERE uniacid=:uniacid AND lottery_id=:id AND `is_delete`=0  ';
			$lottery = pdo_fetch($task_sql, array(':uniacid' => $_W['uniacid'], ':id' => $id));
			$reward = unserialize($lottery['lottery_data']);
			$set = pdo_fetchcolumn('SELECT `data` FROM ' . tablename('ewei_shop_lottery_default') . ' WHERE uniacid =:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));

			if (!empty($set)) {
				$set = unserialize($set);
			}

			$where = '';
			if (!empty($lottery['award_start']) && !empty($lottery['award_end'])) {
				$where .= ' AND l.addtime >= ' . $lottery['award_start'] . ' AND l.addtime <= ' . $lottery['award_end'];
			}

			$log = pdo_fetchall('SELECT l.*,m.`nickname`,m.`avatar` FROM ' . tablename('ewei_shop_lottery_log') . ' AS l LEFT JOIN ' . tablename('ewei_shop_member') . ' AS m ON m.openid=l.join_user WHERE l.uniacid=:uniacid AND l.lottery_id=:lottery_id AND l.is_reward=1 ' . $where . ' order by l.log_id desc LIMIT 5', array(':uniacid' => $_W['uniacid'], ':lottery_id' => $id));

			if (!empty($log)) {
				$credittext = empty($_W['shopset']['trade']['credittext']) ? '积分' : $_W['shopset']['trade']['credittext'];
				$moneytext = empty($_W['shopset']['trade']['moneytext']) ? '余额' : $_W['shopset']['trade']['moneytext'];

				foreach ($log as &$item) {
					if (empty($item['lottery_data'])) {
						continue;
					}

					$reward_name = '积分';
					$lottery_data = unserialize($item['lottery_data']);

					if (isset($lottery_data['credit'])) {
						$reward_name = $credittext;
					}
					else if (isset($lottery_data['money'])) {
						$reward_name = $moneytext;
					}
					else if (isset($lottery_data['bribery'])) {
						$reward_name = '红包';
					}
					else if (isset($lottery_data['goods'])) {
						$reward_name = '特惠商品';
					}
					else {
						if (isset($lottery_data['coupon'])) {
							$reward_name = '优惠券';
						}
					}

					$reward_text = ' ' . $item['nickname'] . '[抽到' . $reward_name . ',时间' . date('Y-m-d', $item['addtime']) . '] ';
					$item['reward_text'] = $reward_text;
				}

				unset($item);
			}

			if (!empty($lottery['lottery_days'])) {
				$effecttime = time() - $lottery['lottery_days'];
				$conditon = ' and `addtime` > ' . $effecttime;
			}

			$has_changes = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_lottery_join') . 'where uniacid=:uniacid AND lottery_id=:lottery_id  AND join_user=:join_user and lottery_num>0 ' . $conditon, array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid'], ':lottery_id' => $id));
			$member = m('member')->getMember($_W['openid'], true);
		}

		if (isset($lottery['lottery_type']) && $lottery['lottery_type'] == 1) {
			include $this->template('lottery/indexpan');
		}
		else {
			if (isset($lottery['lottery_type']) && $lottery['lottery_type'] == 2) {
				include $this->template('lottery/indexgua');
			}
			else {
				if (isset($lottery['lottery_type']) && $lottery['lottery_type'] == 3) {
					include $this->template('lottery/indexgrid');
				}
				else {
					include $this->template('lottery/indexpan');
				}
			}
		}
	}

	public function lottery_reward()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if ($id) {
			$task_sql = 'SELECT * FROM ' . tablename('ewei_shop_lottery') . ' WHERE uniacid=:uniacid AND lottery_id=:id AND `is_delete`=0  ';
			$lottery = pdo_fetch($task_sql, array(':uniacid' => $_W['uniacid'], ':id' => $id));
			$reward = unserialize($lottery['lottery_data']);
		}
		else {
			$reward = '';
		}

		include $this->template('lottery/lotteryreward');
	}

	public function myreward()
	{
		global $_W;
		global $_GPC;
		$member = m('member')->getMember($_W['openid'], true);
		$mylog = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_lottery_log') . ' WHERE uniacid=:uniacid  AND join_user=:join_user AND is_reward=1 ', array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));
		include $this->template('lottery/myreward');
	}

	public function myrewardpage()
	{
		global $_W;
		global $_GPC;
		$page = intval($_GPC['page']);

		if (empty($page)) {
			$page = 1;
		}

		$limit = ($page - 1) * 15;
		$mylog = pdo_fetchall('SELECT l.*,m.`nickname`,m.`avatar` FROM ' . tablename('ewei_shop_lottery_log') . ' AS l LEFT JOIN ' . tablename('ewei_shop_member') . ' AS m ON m.openid = l.join_user and l.uniacid = m.uniacid WHERE l.uniacid=:uniacid  AND l.join_user=:join_user AND l.is_reward=1 order by addtime desc LIMIT ' . $limit . ',15', array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));
		$count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_lottery_log') . ' WHERE uniacid=:uniacid  AND join_user=:join_user AND is_reward=1 ', array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));
		$set = $this->set;

		foreach ($mylog as $key => $value) {
			$lottery_data = unserialize($value['lottery_data']);

			if (isset($lottery_data['credit'])) {
				$mylog[$key]['title'] = $set['texts']['credit1'] . ':' . $lottery_data['credit'];
				$mylog[$key]['rewarded'] = 1;
				$mylog[$key]['icon'] = '../addons/ewei_shopv2/plugin/lottery/static/images/jifen.png';
			}
			else if (isset($lottery_data['money'])) {
				$mylog[$key]['title'] = '奖金:' . $lottery_data['money']['num'];
				$mylog[$key]['rewarded'] = 1;
				$mylog[$key]['icon'] = '../addons/ewei_shopv2/plugin/lottery/static/images/jiangjin.png';
			}
			else if (isset($lottery_data['bribery'])) {
				$mylog[$key]['title'] = '红包:' . $lottery_data['bribery']['num'];
				$mylog[$key]['rewarded'] = 1;
				$mylog[$key]['icon'] = '../addons/ewei_shopv2/plugin/lottery/static/images/hongbao.png';
			}
			else if (isset($lottery_data['goods'])) {
				$goods = array_shift($lottery_data['goods']);
				$mylog[$key]['title'] = '特惠商品:' . $goods['title'];
				$mylog[$key]['rewarded'] = 0;
				$mylog[$key]['icon'] = '../addons/ewei_shopv2/plugin/lottery/static/images/shangpin.png';
			}
			else {
				if (isset($lottery_data['coupon'])) {
					$coupon = array_shift($lottery_data['coupon']);
					$mylog[$key]['title'] = '优惠券:' . $coupon['couponname'];
					$mylog[$key]['rewarded'] = 1;
					$mylog[$key]['icon'] = '../addons/ewei_shopv2/plugin/lottery/static/images/quan.png';
				}
			}

			$mylog[$key]['addtime'] = date('Y.m.d', $value['addtime']);
			$mylog[$key]['link'] = mobileUrl('lottery/index/mygoods', array(), true);
		}

		show_json(1, array('list' => $mylog, 'total' => $count, 'pagesize' => 15));
	}

	public function getlottery()
	{
		global $_W;
		global $_GPC;
		$set_info = pdo_fetchcolumn('SELECT `data` FROM ' . tablename('ewei_shop_lottery_default') . ' WHERE uniacid =:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		$set_info = unserialize($set_info);
		$set_info = unserialize($set_info['lotteryinfo']);
		$set_info = htmlspecialchars_decode($set_info);
		include $this->template('lottery/getlottery');
	}

	private function getRand($proArr)
	{
		$result = '';
		$proSum = array_sum($proArr);

		foreach ($proArr as $key => $proCur) {
			$randNum = mt_rand(1, $proSum);

			if ($randNum <= $proCur) {
				$result = $key;
				break;
			}

			$proSum -= $proCur;
		}

		unset($proArr);
		return intval($result);
	}

	public function getreward()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['lottery']);
		$check = $this->checkSubmit('lottery_' . $id);

		if (is_error($check)) {
			$data = array('status' => 0, 'info' => $check['message']);
			echo json_encode($data);
			exit();
		}

		$has_changes = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_lottery_join') . ' WHERE uniacid=:uniacid AND lottery_id=:id AND join_user=:join_user AND lottery_num>0', array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid'], ':id' => $id));

		if (!empty($id)) {
			$task_sql = 'SELECT * FROM ' . tablename('ewei_shop_lottery') . ' WHERE uniacid=:uniacid AND lottery_id=:id AND `is_delete`=0  ';
			$lottery = pdo_fetch($task_sql, array(':uniacid' => $_W['uniacid'], ':id' => $id));
			$reward = unserialize($lottery['lottery_data']);
		}

		if (empty($has_changes)) {
			$data = array('status' => 0, 'info' => $lottery['lottery_cannot']);
			echo json_encode($data);
			exit();
		}
		else {
			$join_id = pdo_fetchcolumn('SELECT `id` FROM ' . tablename('ewei_shop_lottery_join') . ' WHERE uniacid=:uniacid AND lottery_id=:id AND join_user=:join_user AND lottery_num>0 order by addtime desc limit 1', array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid'], ':id' => $id));
		}

		$temreward = array();

		foreach ($reward as $key => $value) {
			if (isset($value['reward']['goods'])) {
				$pass = 0;

				foreach ($value['reward']['goods'] as $val) {
					if ($val['total'] <= $val['count']) {
						$pass = 1;
					}
				}

				if ($pass == 1) {
					$temreward[$key] = $value['probability'];
				}
			}
			else if (isset($value['reward']['money'])) {
				if ($value['reward']['money']['num'] <= $value['reward']['money']['total']) {
					$temreward[$key] = $value['probability'];
				}
			}
			else if (isset($value['reward']['bribery'])) {
				if ($value['reward']['bribery']['num'] <= $value['reward']['bribery']['total']) {
					$temreward[$key] = $value['probability'];
				}
			}
			else if (isset($value['reward']['coupon'])) {
				$pass = 0;

				foreach ($value['reward']['coupon'] as $val) {
					if (!empty($val['count']) && $val['couponnum'] <= $val['count']) {
						$pass = 1;
					}
				}

				if ($pass == 1) {
					$temreward[$key] = $value['probability'];
				}
			}
			else {
				$temreward[$key] = $value['probability'];
			}
		}

		if (empty($temreward)) {
			$data = array('status' => 0, 'info' => '很遗憾,奖品库存不足了!');
			echo json_encode($data);
			exit();
		}

		$reward_id = $this->getRand($temreward);
		$reward_info = $reward[$reward_id]['reward'];
		$is_reward = 0;

		if (empty($reward_info)) {
			$is_reward = 0;
			$reward_info = '很遗憾,没有中奖';
		}
		else {
			$is_reward = 1;

			if (isset($reward_info['credit'])) {
				$reward_info = $reward[$reward_id]['title'];
			}

			if (isset($reward_info['bribery'])) {
				$reward_info = $reward[$reward_id]['title'];
			}

			if (isset($reward_info['money'])) {
				$reward_info = $reward[$reward_id]['title'];
			}

			if (isset($reward_info['goods'])) {
				$reward_info = $reward[$reward_id]['title'];
			}

			if (isset($reward_info['coupon'])) {
				$reward_info = $reward[$reward_id]['title'];
			}
		}

		$log_data = array('uniacid' => $_W['uniacid'], 'lottery_id' => $id, 'join_user' => $_W['openid'], 'lottery_data' => serialize($reward[$reward_id]['reward']), 'is_reward' => $is_reward, 'addtime' => time());
		pdo_insert('ewei_shop_lottery_log', $log_data);
		$res = pdo_query('UPDATE ' . tablename('ewei_shop_lottery_join') . ' SET lottery_num=lottery_num-1 WHERE uniacid=:uniacid AND lottery_id=:id AND join_user=:join_user and id=:join_id', array(':id' => $id, ':join_id' => $join_id, ':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));

		if ($res === false) {
			load()->func('logging');
			logging_run('更新抽奖次数失败');
		}

		$data = array('status' => 1, 'id' => $reward_id, 'info' => $reward_info, 'is_reward' => $is_reward);
		echo json_encode($data);
		exit();
	}

	/**
     * @return mixed
     */
	public function reward()
	{
		global $_W;
		global $_GPC;

		if ($_GPC['lottery']) {
			$id = intval($_GPC['lottery']);
		}

		if (isset($_GPC['reward'])) {
			$reward_id = intval($_GPC['reward']);
		}

		$task_sql = 'SELECT * FROM ' . tablename('ewei_shop_lottery') . ' WHERE uniacid=:uniacid AND lottery_id=:id AND `is_delete`=0  ';
		$lottery = pdo_fetch($task_sql, array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if (empty($lottery)) {
			$info = array('status' => 0, 'info' => '此抽奖活动已不存在');
			echo json_encode($info);
			exit();
		}

		$reward = unserialize($lottery['lottery_data']);
		$reward = $reward[$reward_id]['reward'];
		$this->model->reward($reward, $_W['openid'], $lottery['lottery_title'], $id);

		if (isset($reward['money'])) {
			$reward['money']['total'] -= $reward['money']['num'];
		}

		if (isset($reward['bribery'])) {
			$reward['bribery']['total'] -= $reward['bribery']['num'];
		}

		if (isset($reward['coupon'])) {
			foreach ($reward['coupon'] as $key => $val) {
				@$reward['coupon'][$key]['count'] -= $val['couponnum'];
			}
		}

		if (isset($reward['goods'])) {
			foreach ($reward['goods'] as $key => $val) {
				if (empty($val['spec'])) {
					$reward['goods'][$key]['count'] -= $val['total'];
				}
				else {
					foreach ($val['spec'] as $k => $v) {
						$total = $v['total'];
					}

					$reward['goods'][$key]['count'] -= $total;
				}
			}
		}

		$temreward = unserialize($lottery['lottery_data']);
		$temreward[$reward_id]['reward'] = $reward;
		$lottery_data = array('lottery_data' => serialize($temreward));
		$res = pdo_update('ewei_shop_lottery', $lottery_data, array('uniacid' => $_W['uniacid'], 'lottery_id' => $id));

		if ($res !== false) {
			$info = array('status' => 1, 'info' => '恭喜您已获得' . $temreward[$reward_id]['title']);
			echo json_encode($info);
			exit();
		}
		else {
			$info = array('status' => 0, 'info' => '获取奖励失败');
			echo json_encode($info);
			exit();
		}
	}

	public function mygoods()
	{
		global $_W;
		global $_GPC;
		$loglist = pdo_fetchall('SELECT l.* FROM ' . tablename('ewei_shop_lottery_log') . ' AS l WHERE l.uniacid=:uniacid  AND l.join_user=:join_user AND l.is_reward=1', array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));
		$goodslist = array();

		foreach ($loglist as $key => $value) {
			$log_id = $value['log_id'];
			$value = unserialize($value['lottery_data']);
			if (isset($value['goods']) && !empty($value['goods'])) {
				$goods = array_shift($value['goods']);
				$goods['log_id'] = $log_id;

				if (!empty($goods)) {
					$searchsql = 'SELECT thumb,marketprice FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid= ' . $_W['uniacid'] . ' and id=' . $goods['id'] . ' and status=1 and deleted=0';
					$goodsinfo = pdo_fetch($searchsql);
					$thumb = tomedia($goodsinfo['thumb']);
					$goods['thumb'] = $thumb;
					$goods['oldprice'] = $goodsinfo['marketprice'];
				}

				array_push($goodslist, $goods);
			}
		}

		include $this->template('lottery/goodslist');
	}

	public function checkSubmit($key, $time = 2, $message = '操作频繁，请稍后再试!')
	{
		global $_W;
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = $_W['setting']['site']['key'] . '_' . $_W['account']['key'] . '_' . $_W['uniacid'] . '_' . $_W['openid'] . '_mobilesubmit_' . $key;
			$redis = redis();

			if ($redis->setnx($redis_key, time())) {
				$redis->expireAt($redis_key, time() + $time);
			}
			else {
				return error(-1, $message);
			}
		}

		return true;
	}
}

?>
