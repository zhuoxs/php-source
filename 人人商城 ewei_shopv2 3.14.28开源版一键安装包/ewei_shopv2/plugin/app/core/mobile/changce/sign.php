<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Sign_EweiShopV2Page extends AppMobilePage
{
	public function get_list()
	{
		global $_GPC;
		global $_W;
		
		session_start();
		$psign = p('sign');
		$set = $psign->getSet();
		if (empty($set['isopen'])) {
			return app_error($set['textsign'] . '未开启!');
		}
		if (!empty($set['sign_rule'])) {
			$set['sign_rule'] = iunserializer($set['sign_rule']);
			$set['sign_rule'] = htmlspecialchars_decode($set['sign_rule']);
		}
		
		$month = $psign->getMonth();
		//去掉太久的日期
		$oneyear = (date('Y')-1).date('m');
		foreach($month as $k=>$v){
			if($v['year'].$v['month']<$oneyear) unset($month[$k]);
		}
		$_SESSION['sign_xcx_isminiprogram'] = true;
		$member = m('member')->getMember($_W['openid']);
//print_r($month);exit;
			$isminiprogram = true;
			$_SESSION['sign_xcx_openid'] = $member['openid'];
			//$_SESSION['sign_uid_' . $_SESSION['sign_xcx_openid']] = $member['uid'];

		if (empty($member) || empty($_W['openid'])) {
			return app_error('获取用户信息失败!');
		}

		$calendar = $psign->getCalendar($_GPC['year'], $_GPC['month']);
		$signinfo = $psign->getSign();
		$advaward = $psign->getAdvAward();
		$member['credit1'] = intval($member['credit1']);
		$json_arr = array('member' => $member, 'months'=>$month, 'calendar' => $calendar, 'signinfo' => $signinfo, 'advaward' => $advaward, 'year' => date('Y', time()), 'month' => date('m', time()), 'today' => date('d', time()), 'signed' => $signinfo['signed'], 'signoldtype' => empty($set['signold_type']) ? $set['textmoney'] : $set['textcredit'], 'set' => $set);
		//$this->model->setShare($set);
		//$texts = array('sign' => $set['textsign'], 'signed' => $set['textsigned'], 'signold' => $set['textsignold'], 'credit' => $set['textcredit'], 'color' => $set['maincolor']);
		return app_json($json_arr);
	}

	public function dosign()
	{
		global $_W;
		global $_GPC;
		if (empty($_W['openid'])) {
			return app_error('您的身份信息未获取!');
		}
		$psign = p('sign');
		$set = $psign->getSet();

		if (empty($set['isopen'])) {
			return app_error($set['textcredit'] . $set['textsign'] . '未开启!');
		}

		$date = trim($_GPC['date']);
		$date = ($date == 'null' ? '' : $date);
		$signinfo = $psign->getSign($date);

		if (!empty($date)) {
			$datemonth = date('Y-m', strtotime($date));
			$thismonth = date('Y-m', time());

			if ($datemonth < $thismonth) {
				return app_error($set['textsign'] . '月份小于当前月份，不可补签!');
			}
		}

		if (!empty($signinfo['signed'])) {
			return app_error('已经' . $set['textsign'] . '，不要重复' . $set['textsign'] . '哦~');
		}

		if (!empty($date) && (time() < strtotime($date))) {
			return app_error($set['textsign'] . '日期大于当前日期!');
		}

		$member = m('member')->getMember($_W['openid']);
		$reword_special = iunserializer($set['reword_special']);
		$credit = 0;
		if (!empty($set['reward_default_day']) && (0 < $set['reward_default_day'])) {
			$credit = $set['reward_default_day'];
			$message = (empty($date) ? '日常' . $set['textsign'] . '+' : $set['textsignold'] . '+');
			$message .= $set['reward_default_day'] . $set['textcredit'];
		}

		if (!empty($set['reward_default_first']) && (0 < $set['reward_default_first']) && empty($signinfo['sum']) && empty($date)) {
			$credit = $set['reward_default_first'];
			$message = '首次' . $set['textsign'] . '+' . $set['reward_default_first'] . $set['textcredit'];
		}

		if (!empty($reword_special) && empty($date)) {
			foreach ($reword_special as $item) {
				$day = date('Y-m-d', $item['date']);
				$today = date('Y-m-d', time());
				if (($day === $today) && !empty($item['credit'])) {
					$credit = $credit + $item['credit'];

					if (!empty($message)) {
						$message .= "\r\n";
					}

					$message .= (empty($item['title']) ? $today : $item['title']);
					$message .= $set['textsign'] . '+' . $item['credit'] . $set['textcredit'];
					break;
				}
			}
		}

		if (!empty($date) && !empty($set['signold']) && (0 < $set['signold_price'])) {
			if (empty($set['signold_type'])) {
				if ($member['credit2'] < $set['signold_price']) {
					return app_error($set['textsignold'] . '失败! 您的' . $set['textmoney'] . '不足, 无法' . $set['textsignold']);
				}

				m('member')->setCredit($_W['openid'], 'credit2', 0 - $set['signold_price'], $set['textcredit'] . $set['textsign'] . ': ' . $set['textsignold'] . '扣除' . $set['signold_price'] . $set['textmoney']);
			}
			else {
				if ($member['credit1'] < $set['signold_price']) {
					return app_error($set['textsignold'] . '失败! 您的' . $set['textcredit'] . '不足, 无法' . $set['textsignold']);
				}

				m('member')->setCredit($_W['openid'], 'credit1', 0 - $set['signold_price'], $set['textcredit'] . $set['textsign'] . ': ' . $set['textsignold'] . '扣除' . $set['signold_price'] . $set['textcredit']);
			}
		}

		if (!empty($credit) && (0 < $credit)) {
			m('member')->setCredit($_W['openid'], 'credit1', 0 + $credit, $set['textcredit'] . $set['textsign'] . ': ' . $message);
		}

		$arr = array('uniacid' => $_W['uniacid'], 'time' => empty($date) ? time() : strtotime($date), 'openid' => $_W['openid'], 'credit' => $credit, 'log' => $message);
		pdo_insert('ewei_shop_sign_records', $arr);
		$signinfo = $psign->getSign();
		$member = m('member')->getMember($_W['openid']);
		$result = array('success'=>1, 'message' => $set['textsign'] . '成功!' . $message, 'signorder' => $signinfo['orderday'], 'signsum' => $signinfo['sum'], 'addcredit' => $credit, 'credit' => intval($member['credit1']));
		$psign->updateSign($signinfo);

		if (p('lottery')) {
			$res = p('lottery')->getLottery($member['openid'], 2, array('day' => $signinfo['orderday']));

			if ($res) {
				p('lottery')->getLotteryList($member['openid'], array('lottery_id' => $res));
			}

			$result['lottery'] = p('lottery')->check_isreward();
		}
		else {
			$result['lottery']['is_changes'] = 0;
		}

		return app_json($result);
	}
	public function doreward()
	{
		global $_W;
		global $_GPC;
		if (empty($_W['openid'])) {
			return app_error('您的身份信息未获取!');
		}
	
		$type = intval($_GPC['type']);
		$day = intval($_GPC['day']);
		if (empty($type) || empty($day)) {
			return app_error('请求参数错误!');
		}
		$psign = p('sign');
		$set = $psign->getSet();

		if (empty($set['isopen'])) {
			return app_error($set['textcredit'] . $set['textsign'] . '未开启!');
		}

		$reword_sum = iunserializer($set['reword_sum']);
		$reword_order = iunserializer($set['reword_order']);
		$condition = '';

		if (!empty($set['cycle'])) {
			$month_start = mktime(0, 0, 0, date('m'), 1, date('Y'));
			$month_end = mktime(23, 59, 59, date('m'), date('t'), date('Y'));
			$condition .= ' and `time` between ' . $month_start . ' and ' . $month_end . ' ';
		}

		$record = pdo_fetch('select * from ' . tablename('ewei_shop_sign_records') . ' where openid=:openid and `type`=' . $type . ' and `day`=' . $day . ' and uniacid=:uniacid ' . $condition . ' limit 1 ', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if (!empty($record)) {
			return app_error('此奖励已经领取, 请不要重复领取!');
		}

		$credit = 0;
		if (($type == 1) && !empty($reword_order)) {
			foreach ($reword_order as $item) {
				if (($item['day'] == $day) && !empty($item['credit'])) {
					$credit = $item['credit'];
				}
			}

			$message = '连续' . $set['textsign'];
		}
		else {
			if (($type == 2) && !empty($reword_sum)) {
				foreach ($reword_sum as $item) {
					if (($item['day'] == $day) && !empty($item['credit'])) {
						$credit = $item['credit'];
					}
				}

				$message = '总' . $set['textsign'];
			}
		}

		$message .= $day . '天获得奖励' . $credit . $set['textcredit'];
		if (!empty($credit) && (0 < $credit)) {
			m('member')->setCredit($_W['openid'], 'credit1', 0 + $credit, $set['textcredit'] . $set['textsign'] . ': ' . $message);
		}

		$arr = array('uniacid' => $_W['uniacid'], 'time' => time(), 'openid' => $_W['openid'], 'credit' => $credit, 'log' => $message, 'type' => $type, 'day' => $day);
		pdo_insert('ewei_shop_sign_records', $arr);
		$member = m('member')->getMember($_W['openid']);
		$result = array('success' => 1, 'message' => '领取成功!' . $message, 'addcredit' => $credit, 'credit' => intval($member['credit1']));
		return app_json($result);
	}
	public function getRecords()
	{
		global $_W;
		global $_GPC;
		if (empty($_W['openid'])) {
			return app_error('您的身份信息未获取!');
		}
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' uniacid = :uniacid and openid=:openid ';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_sign_records') . ' log where ' . $condition;
		$total = pdo_fetchcolumn($sql, $params);
		$list = array();

		if (!empty($total)) {
			$sql = 'SELECT * FROM ' . tablename('ewei_shop_sign_records') . ' where ' . $condition . ' ORDER BY `time` DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
			$list = pdo_fetchall($sql, $params);

			if (!empty($list)) {
				foreach ($list as &$item) {
					$item['date'] = date('Y-m-d H:i:s', $item['time']);
				}

				unset($item);
			}
		}
		return app_json(array('total' => $total, 'list' => $list, 'pagesize' => $psize));
	}
}

?>
