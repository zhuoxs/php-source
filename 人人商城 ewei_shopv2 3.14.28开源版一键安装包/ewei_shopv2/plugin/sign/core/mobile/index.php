<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		session_start();
		$set = $this->model->getSet();

		if (!empty($set['sign_rule'])) {
			$set['sign_rule'] = iunserializer($set['sign_rule']);
			$set['sign_rule'] = htmlspecialchars_decode($set['sign_rule']);
		}

		if (empty($set['isopen'])) {
			$this->message($set['textsign'] . '未开启!', mobileUrl());
		}

		$month = $this->model->getMonth();
		$_SESSION['sign_xcx_isminiprogram'] = false;

		if (!empty($_GPC['uid'])) {
			$member = m('member')->getMember($_GPC['uid']);
		}
		else {
			$member = m('member')->getMember($_W['openid']);
		}

		if (strexists($member['openid'], 'sns_wa_')) {
			$isminiprogram = true;
			$_SESSION['sign_xcx_openid'] = $member['openid'];
			$_SESSION['sign_xcx_isminiprogram'] = true;
			$_SESSION['sign_uid_' . $_SESSION['sign_xcx_openid']] = $_GPC['uid'];
		}
		else {
			$_SESSION['sign_xcx_openid'] = NULL;
			$_SESSION['sign_uid_' . $_SESSION['sign_xcx_openid']] = NULL;
			$_SESSION['sign_xcx_isminiprogram'] = false;
		}

		if (empty($member) || empty($_W['openid'])) {
			$this->message('获取用户信息失败!', mobileUrl());
		}

		$calendar = $this->model->getCalendar();
		$signinfo = $this->model->getSign();
		$advaward = $this->model->getAdvAward();
		$json_arr = array('calendar' => $calendar, 'signinfo' => $signinfo, 'advaward' => $advaward, 'year' => date('Y', time()), 'month' => date('m', time()), 'today' => date('d', time()), 'signed' => $signinfo['signed'], 'signold' => $set['signold'], 'signoldprice' => $set['signold_price'], 'signoldtype' => empty($set['signold_type']) ? $set['textmoney'] : $set['textcredit'], 'textsign' => $set['textsign'], 'textsigned' => $set['textsigned'], 'textsignold' => $set['textsignold'], 'textsignforget' => $set['textsignforget']);
		$json = json_encode($json_arr);
		$this->model->setShare($set);
		$texts = array('sign' => $set['textsign'], 'signed' => $set['textsigned'], 'signold' => $set['textsignold'], 'credit' => $set['textcredit'], 'color' => $set['maincolor']);
		include $this->template();
	}

	public function getCalendar()
	{
		global $_W;
		global $_GPC;
		session_start();

		if (!empty($_SESSION['sign_xcx_openid'])) {
			$_W['openid'] = $_SESSION['sign_xcx_openid'];
		}

		$date = trim($_GPC['date']);
		$date = explode('-', $date);
		$calendar = $this->model->getCalendar($date[0], $date[1]);
		include $this->template('sign/calendar');
	}

	public function getAdvAward()
	{
		$set = $this->model->getSet();
		$advaward = $this->model->getAdvAward();
		include $this->template('sign/advaward');
	}

	public function dosign()
	{
		global $_W;
		global $_GPC;
		session_start();

		if (!empty($_SESSION['sign_xcx_openid'])) {
			$_W['openid'] = $_SESSION['sign_xcx_openid'];
		}

		if (!$_W['ispost'] || empty($_W['openid'])) {
			show_json(0, '错误的请求!');
		}

		if (!is_error(redis())) {
			$redis_key = $_W['uniacid'] . '_sign_refund_' . $_W['openid'];
			$redis = redis();

			if ($redis->setnx($redis_key, time())) {
				$redis->expireAt($redis_key, time() + 2);
			}
			else if ($redis->get($redis_key) + 2 < time()) {
				$redis->del($redis_key);
			}
			else {
				return false;
			}
		}

		$set = $this->model->getSet();

		if (empty($set['isopen'])) {
			show_json(0, $set['textcredit'] . $set['textsign'] . '未开启!');
		}

		$date = trim($_GPC['date']);
		$date = $date == 'null' ? '' : $date;

		if (!empty($date)) {
			$dates = date('Y-m-d', strtotime($date));
			$date_verify = date('Y-m-d', strtotime($date));

			if ($date_verify != $dates) {
				show_json(0, '日期传入错误');
			}
		}

		$signinfo = $this->model->getSign($date);

		if (!empty($date)) {
			$datemonth = date('m', strtotime($date));
			$thismonth = date('m', time());

			if ($datemonth < $thismonth) {
				show_json(0, $set['textsign'] . '月份小于当前月份!');
			}
		}

		if (!empty($signinfo['signed'])) {
			show_json(2, '已经' . $set['textsign'] . '，不要重复' . $set['textsign'] . '哦~');
		}

		if (!empty($date) && time() < strtotime($date)) {
			show_json(0, $set['textsign'] . '日期大于当前日期!');
		}

		$member = m('member')->getMember($_W['openid']);
		$reword_special = iunserializer($set['reword_special']);
		$credit = 0;
		if (!empty($set['reward_default_day']) && 0 < $set['reward_default_day']) {
			$credit = $set['reward_default_day'];
			$message = empty($date) ? '日常' . $set['textsign'] . '+' : $set['textsignold'] . '+';
			$message .= $set['reward_default_day'] . $set['textcredit'];
		}

		if (!empty($set['reward_default_first']) && 0 < $set['reward_default_first'] && empty($signinfo['sum']) && empty($date)) {
			$credit = $set['reward_default_first'];
			$message = '首次' . $set['textsign'] . '+' . $set['reward_default_first'] . $set['textcredit'];
		}

		if (!empty($reword_special) && empty($date)) {
			foreach ($reword_special as $item) {
				$day = date('Y-m-d', $item['date']);
				$today = date('Y-m-d', time());
				if ($day === $today && !empty($item['credit'])) {
					$credit = $credit + $item['credit'];

					if (!empty($message)) {
						$message .= '
';
					}

					$message .= empty($item['title']) ? $today : $item['title'];
					$message .= $set['textsign'] . '+' . $item['credit'] . $set['textcredit'];
					break;
				}
			}
		}

		if (!empty($date) && !empty($set['signold']) && 0 < $set['signold_price']) {
			if (empty($set['signold_type'])) {
				if ($member['credit2'] < $set['signold_price']) {
					show_json(0, $set['textsignold'] . '失败! 您的' . $set['textmoney'] . '不足, 无法' . $set['textsignold']);
				}

				m('member')->setCredit($_W['openid'], 'credit2', 0 - $set['signold_price'], $set['textcredit'] . $set['textsign'] . ': ' . $set['textsignold'] . '扣除' . $set['signold_price'] . $set['textmoney']);
			}
			else {
				if ($member['credit1'] < $set['signold_price']) {
					show_json(0, $set['textsignold'] . '失败! 您的' . $set['textcredit'] . '不足, 无法' . $set['textsignold']);
				}

				m('member')->setCredit($_W['openid'], 'credit1', 0 - $set['signold_price'], $set['textcredit'] . $set['textsign'] . ': ' . $set['textsignold'] . '扣除' . $set['signold_price'] . $set['textcredit']);
			}
		}

		if (!empty($credit) && 0 < $credit) {
			m('member')->setCredit($_W['openid'], 'credit1', 0 + $credit, $set['textcredit'] . $set['textsign'] . ': ' . $message);
		}

		$arr = array('uniacid' => $_W['uniacid'], 'time' => empty($date) ? time() : strtotime($date), 'openid' => $_W['openid'], 'credit' => $credit, 'log' => $message);
		pdo_insert('ewei_shop_sign_records', $arr);
		$id = pdo_insertid();

		if ($_SESSION['sign_xcx_isminiprogram']) {
			$log_text = '小程序';
		}
		else {
			$log_text = '公众号';
		}

		plog('sign', '签到ID:' . $id . '通过' . $log_text . '积分签到');
		$signinfo = $this->model->getSign();
		$member = m('member')->getMember($_W['openid']);
		$result = array('message' => $set['textsign'] . '成功!' . $message, 'signorder' => $signinfo['orderday'], 'signsum' => $signinfo['sum'], 'addcredit' => $credit, 'credit' => intval($member['credit1']));
		$this->model->updateSign($signinfo);

		if (p('lottery')) {
			$res = p('lottery')->getLottery($member['openid'], 2, array('day' => $signinfo['orderday']));

			if ($res) {
				p('lottery')->getLotteryList($member['openid'], array('lottery_id' => $res));
			}

			$result['lottery'] = p('lottery')->check_isreward();

			if ($_SESSION['sign_xcx_isminiprogram']) {
				$result['lottery']['is_changes'] = 0;
			}
		}
		else {
			$result['lottery']['is_changes'] = 0;
		}

		show_json(1, $result);
	}

	public function doreward()
	{
		global $_W;
		global $_GPC;
		session_start();

		if (!empty($_SESSION['sign_xcx_openid'])) {
			$_W['openid'] = $_SESSION['sign_xcx_openid'];
		}

		if (!$_W['ispost'] || empty($_W['openid'])) {
			show_json(0, '错误的请求!');
		}

		$type = intval($_GPC['type']);
		$day = intval($_GPC['day']);
		if (empty($type) || empty($day)) {
			show_json(0, '请求参数错误!');
		}

		$set = $this->model->getSet();

		if (empty($set['isopen'])) {
			show_json(0, $set['textcredit'] . $set['textsign'] . '未开启!');
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
			show_json(0, '此奖励已经领取, 请不要重复领取!');
		}

		$credit = 0;
		if ($type == 1 && !empty($reword_order)) {
			foreach ($reword_order as $item) {
				if ($item['day'] == $day && !empty($item['credit'])) {
					$credit = $item['credit'];
				}
			}

			$message = '连续' . $set['textsign'];
		}
		else {
			if ($type == 2 && !empty($reword_sum)) {
				foreach ($reword_sum as $item) {
					if ($item['day'] == $day && !empty($item['credit'])) {
						$credit = $item['credit'];
					}
				}

				$message = '总' . $set['textsign'];
			}
		}

		$message .= $day . '天获得奖励' . $credit . $set['textcredit'];
		if (!empty($credit) && 0 < $credit) {
			m('member')->setCredit($_W['openid'], 'credit1', 0 + $credit, $set['textcredit'] . $set['textsign'] . ': ' . $message);
		}

		$arr = array('uniacid' => $_W['uniacid'], 'time' => time(), 'openid' => $_W['openid'], 'credit' => $credit, 'log' => $message, 'type' => $type, 'day' => $day);
		pdo_insert('ewei_shop_sign_records', $arr);
		$member = m('member')->getMember($_W['openid']);
		$result = array('message' => '领取成功!' . $message, 'addcredit' => $credit, 'credit' => intval($member['credit1']));
		show_json(1, $result);
	}

	public function records()
	{
		global $_W;
		session_start();

		if (!empty($_SESSION['sign_xcx_openid'])) {
			$_W['openid'] = $_SESSION['sign_xcx_openid'];
		}

		$set = $this->model->getSet();
		$texts = array('sign' => $set['textsign'], 'signed' => $set['textsigned'], 'signold' => $set['textsignold'], 'credit' => $set['textcredit'], 'color' => $set['maincolor']);
		include $this->template();
	}

	public function getRecords()
	{
		global $_W;
		global $_GPC;
		session_start();

		if (!empty($_SESSION['sign_xcx_openid'])) {
			$_W['openid'] = $_SESSION['sign_xcx_openid'];
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and openid=:openid and uniacid = :uniacid ';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_sign_records') . (' log where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$list = array();

		if (!empty($total)) {
			$sql = 'SELECT * FROM ' . tablename('ewei_shop_sign_records') . ' where 1 ' . $condition . ' ORDER BY `time` DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);

			if (!empty($list)) {
				foreach ($list as &$item) {
					$item['date'] = date('Y-m-d H:i:s', $item['time']);
				}

				unset($item);
			}
		}

		show_json(1, array('total' => $total, 'list' => $list, 'pagesize' => $psize));
	}

	public function rank()
	{
		global $_W;
		global $_GPC;
		session_start();

		if (!empty($_SESSION['sign_xcx_openid'])) {
			$_W['openid'] = $_SESSION['sign_xcx_openid'];
		}

		$set = $this->model->getSet();
		$texts = array('sign' => $set['textsign'], 'signed' => $set['textsigned'], 'signold' => $set['textsignold'], 'credit' => $set['textcredit'], 'color' => $set['maincolor']);
		include $this->template();
	}

	public function getRank()
	{
		global $_W;
		global $_GPC;
		session_start();

		if (!empty($_SESSION['sign_xcx_openid'])) {
			$_W['openid'] = $_SESSION['sign_xcx_openid'];
		}

		$type = trim($_GPC['type']);
		$set = $this->getSet();
		$total = 0;
		$list = array();
		$psize = 10;

		if (!empty($type)) {
			$pindex = max(1, intval($_GPC['page']));
			$condition = ' and su.uniacid=:uniacid and sm.uniacid=:uniacid ';
			$conditioncol = ' and uniacid=:uniacid ';

			if (!empty($set['cycle'])) {
				$condition .= ' and su.signdate="' . date('Y-m', time()) . '"';
				$conditioncol .= ' and signdate="' . date('Y-m', time()) . '"';
			}

			if ($_SESSION['sign_xcx_isminiprogram']) {
				$condition .= ' and su.isminiprogram = 1 ';
				$conditioncol .= ' and isminiprogram = 1 ';
			}

			$params = array(':uniacid' => $_W['uniacid']);
			$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_sign_user') . (' where 1 ' . $conditioncol);
			$total = pdo_fetchcolumn($sql, $params);
			$list = array();

			if (!empty($total)) {
				$type = 'su.' . $type;
				$sql = 'SELECT su.*, sm.nickname, sm.avatar FROM ' . tablename('ewei_shop_sign_user') . ' su left join ' . tablename('ewei_shop_member') . ' sm on sm.openid=su.openid where 1 ' . $condition . ' ORDER BY ' . $type . ' DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
				$list = pdo_fetchall($sql, $params);

				if (!empty($list)) {
					foreach ($list as &$item) {
						$item['type'] = str_replace('su.', '', $type);
					}

					unset($item);
				}
			}
		}

		show_json(1, array('total' => $total, 'list' => $list, 'pagesize' => $psize));
	}
}

?>
