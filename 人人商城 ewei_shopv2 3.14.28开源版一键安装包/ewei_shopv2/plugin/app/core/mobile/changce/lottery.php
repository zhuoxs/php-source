<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}
require EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Lottery_EweiShopV2Page extends AppMobilePage
{
	public function get_list()
	{
		global $_GPC;
		global $_W;
		$set = pdo_fetchcolumn('SELECT `data` FROM ' . tablename('ewei_shop_lottery_default') . ' WHERE uniacid =:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		if (!empty($set)) {
			$set = unserialize($set);
		}
		$banner = empty($set['thumb'])?'../addons/ewei_shopv2/plugin/lottery/static/images/lottery_banner.png':$set['thumb'];
		$banner = tomedia($banner);
		$task_sql = 'SELECT lottery_id,lottery_title,lottery_icon,lottery_cannot,lottery_type,task_type,task_data,start_time,end_time FROM ' . tablename('ewei_shop_lottery') . ' WHERE uniacid=:uniacid AND `is_delete`=0 and start_time<='.time().' and end_time>='.time().' ORDER BY lottery_id DESC';
		$lottery = pdo_fetchall($task_sql, array(':uniacid' => $_W['uniacid']));
		foreach ($lottery as $key => $value) {
			$lottery[$key]['start_time'] = date('m.d', $value['start_time']);
			$lottery[$key]['end_time'] = date('m.d', $value['end_time']);
			if ($value['lottery_type'] == 1) $lottery[$key]['type_name'] = '大转盘';
			elseif ($value['lottery_type'] == 2) $lottery[$key]['type_name'] = '刮刮卡';
			else $lottery[$key]['type_name'] = '九宫格';
			if(empty($value['lottery_icon'])){
				if ($value['lottery_type'] == 1) {
					$lottery[$key]['lottery_icon'] = '../addons/ewei_shopv2/plugin/lottery/static/images/panicon.png';
				}
				else if ($value['lottery_type'] == 2) {
					$lottery[$key]['lottery_icon'] = '../addons/ewei_shopv2/plugin/lottery/static/images/guaicon.png';
				}
				else {
					if ($value['lottery_type'] == 3) {
						$lottery[$key]['lottery_icon'] = '../addons/ewei_shopv2/plugin/lottery/static/images/gridicon.png';
					}
				}
			}
			$lottery[$key]['lottery_icon'] = tomedia($lottery[$key]['lottery_icon']);
			$lottery[$key]['notes'] = '';
			if($value['task_type']==1){
				$task_data = unserialize($value['task_data']);
				$lottery[$key]['notes'] = ($task_data['pay_type']==1?'付款':($task_data['pay_type']==2?'完成订单':'消费')).'满'.$task_data['pay_money'].'元可抽'.$task_data['pay_num'].'次';
			}elseif($value['task_type']==2){
				$task_data = unserialize($value['task_data']);
				$lottery[$key]['notes'] = '签到满'.$task_data['sign_day'].'天可抽'.$task_data['sign_num'].'次';
			}
			$lottery[$key]['total'] = 0;
			if(!empty($_W['openid'])){
				$task_sql = 'SELECT SUM(lottery_num) FROM ' . tablename('ewei_shop_lottery_join') . '  WHERE uniacid=:uniacid AND lottery_id=:lottery_id and `join_user`=:join_user and lottery_num>0';
				$lottery[$key]['total'] = intval(pdo_fetchcolumn($task_sql, array(':uniacid' => $_W['uniacid'], ':lottery_id'=>$value['lottery_id'], ':join_user' => $_W['openid'])));
			}
		}
		if(!$lottery) $lottery = array();
		app_json(array('banner'=>$banner, 'list'=>$lottery));
	}
	public function lottery_info()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$intro = '暂无说明';
		if ($id) {
			$task_sql = 'SELECT * FROM ' . tablename('ewei_shop_lottery') . ' WHERE uniacid=:uniacid AND lottery_id=:id AND `is_delete`=0  ';
			$lottery = pdo_fetch($task_sql, array(':uniacid' => $_W['uniacid'], ':id' => $id));
			$reward = unserialize($lottery['lottery_data']);
			$set = pdo_fetchcolumn('SELECT `data` FROM ' . tablename('ewei_shop_lottery_default') . ' WHERE uniacid =:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));

			if (!empty($set)) {
				$set = unserialize($set);
				//print_r($set);
				$intro = unserialize($set['lotteryinfo']);
				$intro = htmlspecialchars_decode($intro);
			}

			$where = '';
			if (!empty($lottery['award_start']) && !empty($lottery['award_end'])) {
				$where .= ' AND l.addtime >= ' . $lottery['award_start'] . ' AND l.addtime <= ' . $lottery['award_end'];
			}

			$log = pdo_fetchall('SELECT l.*,m.`nickname`,m.`avatar` FROM ' . tablename('ewei_shop_lottery_log') . ' AS l LEFT JOIN ' . tablename('ewei_shop_member') . ' AS m ON m.openid=l.join_user WHERE l.uniacid=:uniacid AND l.lottery_id=:lottery_id AND l.is_reward=1 ' . $where . ' order by l.log_id desc LIMIT 5', array(':uniacid' => $_W['uniacid'], ':lottery_id' => $id));

			if (!empty($lottery['lottery_days'])) {
				$effecttime = time() - $lottery['lottery_days'];
				$conditon = ' and `addtime` > ' . $effecttime;
			}

			$lottery['has_changes'] = intval(pdo_fetchcolumn('select sum(lottery_num) from ' . tablename('ewei_shop_lottery_join') . 'where uniacid=:uniacid AND lottery_id=:lottery_id  AND join_user=:join_user and lottery_num>0 ' . $conditon, array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid'], ':lottery_id' => $id)));
		}
		app_json(array('data'=>$lottery,'intro'=>$intro));
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
			$reward = array();
		}
		app_json(array('data'=>$reward));
	}
	public function getreward()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['lottery']);
		$check = $this->checkSubmit('lottery_' . $id);

		if (is_error($check)) {
			$data = array('status' => 0, 'info' => $check['message']);
			app_json($data);
		}

		$has_changes = intval(pdo_fetchcolumn('SELECT SUM(lottery_num) FROM ' . tablename('ewei_shop_lottery_join') . ' WHERE uniacid=:uniacid AND lottery_id=:id AND join_user=:join_user AND lottery_num>0', array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid'], ':id' => $id)));

		if (!empty($id)) {
			$task_sql = 'SELECT * FROM ' . tablename('ewei_shop_lottery') . ' WHERE uniacid=:uniacid AND lottery_id=:id AND `is_delete`=0  ';
			$lottery = pdo_fetch($task_sql, array(':uniacid' => $_W['uniacid'], ':id' => $id));
			$reward = unserialize($lottery['lottery_data']);
		}

		if (empty($has_changes)) {
			$data = array('status' => 0, 'info' => $lottery['lottery_cannot']);
			app_json($data);
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
			app_json($data);
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
			$reward_info = '获得奖励：'.$reward_info;
		}

		$log_data = array('uniacid' => $_W['uniacid'], 'lottery_id' => $id, 'join_user' => $_W['openid'], 'lottery_data' => serialize($reward[$reward_id]['reward']), 'is_reward' => $is_reward, 'addtime' => time());
		pdo_insert('ewei_shop_lottery_log', $log_data);
		$res = pdo_query('UPDATE ' . tablename('ewei_shop_lottery_join') . ' SET lottery_num=lottery_num-1 WHERE uniacid=:uniacid AND lottery_id=:id AND join_user=:join_user and id=:join_id', array(':id' => $id, ':join_id' => $join_id, ':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));

		if ($res === false) {
			load()->func('logging');
			logging_run('更新抽奖次数失败');
		}

		$data = array('status' => 1, 'id' => $reward_id, 'info' => $reward_info, 'is_reward' => $is_reward);
		app_json($data);
	}
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
			app_json($info);
		}

		$reward = unserialize($lottery['lottery_data']);
		$reward = $reward[$reward_id]['reward'];
		p('lottery')->reward($reward, $_W['openid'], $lottery['lottery_title'], $id);

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
			app_json($info);
		}
		else {
			$info = array('status' => 0, 'info' => '获取奖励失败');
			app_json($info);
		}
	}
	public function myrewardpage()
	{
		global $_W;
		global $_GPC;
		$page = intval($_GPC['page']);

		if (empty($page)) {
			$page = 1;
		}
		$pagesize = 10;
		$limit = ($page - 1) * $pagesize;
		$mylog = pdo_fetchall('SELECT l.*,m.`nickname`,m.`avatar` FROM ' . tablename('ewei_shop_lottery_log') . ' AS l LEFT JOIN ' . tablename('ewei_shop_member') . ' AS m ON m.openid=l.join_user WHERE l.uniacid=:uniacid  AND l.join_user=:join_user AND l.is_reward=1 order by addtime desc LIMIT ' . $limit . ','.$pagesize, array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));
		$count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_lottery_log') . ' WHERE uniacid=:uniacid  AND join_user=:join_user AND is_reward=1 ', array(':uniacid' => $_W['uniacid'], ':join_user' => $_W['openid']));

		foreach ($mylog as $key => $value) {
			$lottery_data = unserialize($value['lottery_data']);

			if (isset($lottery_data['credit'])) {
				$mylog[$key]['title'] = '积分:' . $lottery_data['credit'];
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
			$mylog[$key]['icon'] = tomedia($mylog[$key]['icon']);
			$mylog[$key]['addtime'] = date('Y.m.d', $value['addtime']);
		}
		app_json(array('list' => $mylog, 'total' => $count, 'pagesize' => $pagesize));
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
}

?>
