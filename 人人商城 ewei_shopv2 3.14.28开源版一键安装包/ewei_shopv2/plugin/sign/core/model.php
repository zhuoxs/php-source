<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class SignModel extends PluginModel
{
	public function getSet()
	{
		global $_W;
		$set = pdo_fetch('select *  from ' . tablename('ewei_shop_sign_set') . ' where uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid']));

		if (empty($set)) {
			return '';
		}

		if (empty($set['textsign'])) {
			$set['textsign'] = '签到';
		}

		if (empty($set['textsigned'])) {
			$set['textsigned'] = '已签';
		}

		if (empty($set['textsignold'])) {
			$set['textsignold'] = '补签';
		}

		if (empty($set['textsignforget'])) {
			$set['textsignforget'] = '漏签';
		}

		if (empty($_W['shopset']['trade']['credittext'])) {
			$set['textcredit'] = '积分';
		}
		else {
			$set['textcredit'] = $_W['shopset']['trade']['credittext'];
		}

		if (empty($_W['shopset']['trade']['credittext'])) {
			$set['textmoney'] = '余额';
		}
		else {
			$set['textmoney'] = $_W['shopset']['trade']['moneytext'];
		}

		return $set;
	}

	public function setShare($set = NULL)
	{
		global $_W;
		session_start();

		if (!empty($_SESSION['sign_xcx_openid'])) {
			$_W['openid'] = $_SESSION['sign_xcx_openid'];
		}

		if (empty($set)) {
			$set = $this->getSet();
		}

		if (!empty($set['share'])) {
			$_W['shopshare'] = array('title' => $set['title'], 'imgUrl' => tomedia($set['thumb']), 'desc' => $set['desc'], 'link' => mobileUrl('sign', NULL, true));

			if (p('commission')) {
				$set = p('commission')->getSet();

				if (!empty($set['level'])) {
					$member = m('member')->getMember($_W['openid']);
					if (!empty($member) && $member['status'] == 1 && $member['isagent'] == 1) {
						$_W['shopshare']['link'] = mobileUrl('sign', array('mid' => $member['id']), true);
					}
					else {
						if (!empty($_GPC['mid'])) {
							$_W['shopshare']['link'] = mobileUrl('sign', array('mid' => $_GPC['mid']), true);
						}
					}
				}
			}
		}
		else {
			$_W['shopshare'] = array('title' => $_W['shopset']['shop']['name'], 'imgUrl' => tomedia($_W['shopset']['shop']['logo']), 'desc' => $_W['shopset']['shop']['description'], 'link' => mobileUrl('index', NULL, true));
		}
	}

	public function getDate($date = array())
	{
		global $_W;

		if (empty($date)) {
			$date = array('year' => date('y', time()), 'month' => date('m', time()), 'day' => date('d', time()));
		}

		$lasttime = strtotime($date['year'] . '-' . ($date['month'] + 1) . '-1') - 1;

		if ($date['month'] == 12) {
			$lasttime_year = $date['year'] + 1;
			$lasttime = strtotime($lasttime_year . '-1-1') - 1;
		}

		$days = date('t', strtotime($date['year'] . '-' . $date['month']));
		$result = array('firstday' => 1, 'lastday' => $days, 'firsttime' => strtotime($date['year'] . '-' . $date['month'] . '-1'), 'lasttime' => $lasttime, 'year' => $date['year'], 'thisyear' => date('Y', time()), 'month' => $date['month'], 'thismonth' => date('m', time()), 'day' => $date['day'], 'doday' => date('d', time()), 'days' => $days);
		return $result;
	}

	public function getMonth()
	{
		$month = array();
		$start_year = '2016';
		$start_month = '8';
		$this_year = date('Y', time());
		$this_month = date('m', time());
		$i = $start_year;

		while ($i <= $this_year) {
			if (0 < $this_year - $i) {
				$ii_month = 12;
			}
			else {
				$ii_month = $this_month;
			}

			if ($start_year < $i) {
				$start_month = 1;
			}

			$ii = $start_month;

			while ($ii <= $ii_month) {
				$month[] = array('year' => $i, 'month' => $ii < 10 ? '0' . $ii : $ii);
				++$ii;
			}

			++$i;
		}

		return $month;
	}

	public function getCalendar($year = NULL, $month = NULL, $week = true)
	{
		global $_W;
		session_start();

		if (!empty($_SESSION['sign_xcx_openid'])) {
			$_W['openid'] = $_SESSION['sign_xcx_openid'];
		}

		if (empty($year)) {
			$year = date('Y', time());
		}

		if (empty($month)) {
			$month = date('m', time());
		}

		$set = $this->getSet();
		$date = $this->getDate(array('year' => $year, 'month' => $month));
		$array = array();
		$maxday = 28;

		if (28 < $date['days']) {
			$maxday = 35;
		}

		$i = 1;

		while ($i <= $maxday) {
			$day = 0;

			if ($i <= $date['days']) {
				$day = $i;
			}

			$today = 0;
			if ($date['thisyear'] == $year && $date['thismonth'] == $month && $date['doday'] == $i) {
				$today = 1;
			}

			$array[$i] = array('year' => $date['year'], 'month' => $date['month'], 'day' => $day, 'date' => $date['year'] . '-' . $date['month'] . '-' . $day, 'signed' => 0, 'signold' => 1, 'title' => '', 'today' => $today);
			++$i;
		}

		$records = pdo_fetchall('select *  from ' . tablename('ewei_shop_sign_records') . ' where openid=:openid and `type`=0 and `time` between :starttime and :endtime and uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':starttime' => $date['firsttime'], ':endtime' => $date['lasttime']));

		if (!empty($records)) {
			foreach ($records as $item) {
				$sign_date = array('year' => date('Y', $item['time']), 'month' => date('m', $item['time']), 'day' => date('d', $item['time']));

				foreach ($array as $day => &$row) {
					if ($day == $sign_date['day']) {
						$row['signed'] = 1;
					}
				}

				unset($row);
			}
		}

		$reword_special = iunserializer($set['reword_special']);

		if (!empty($reword_special)) {
			foreach ($reword_special as $item) {
				$sign_date = array('year' => date('Y', $item['date']), 'month' => date('m', $item['date']), 'day' => date('d', $item['date']));

				foreach ($array as $day => &$row) {
					if ($row['day'] == $sign_date['day'] && $row['month'] == $sign_date['month'] && $row['year'] == $sign_date['year']) {
						$row['title'] = $item['title'];
						$row['color'] = $item['color'];
					}
				}

				unset($row);
			}
		}

		if ($week) {
			$calendar = array();

			foreach ($array as $index => $row) {
				if (1 <= $index && $index <= 7) {
					$cindex = 0;
				}
				else {
					if (8 <= $index && $index <= 14) {
						$cindex = 1;
					}
					else {
						if (15 <= $index && $index <= 21) {
							$cindex = 2;
						}
						else {
							if (22 <= $index && $index <= 28) {
								$cindex = 3;
							}
							else {
								if (29 <= $index && $index <= 35) {
									$cindex = 4;
								}
							}
						}
					}
				}

				$calendar[$cindex][] = $row;
			}
		}
		else {
			$calendar = $array;
		}

		return $calendar;
	}

	public function getSign($date = NULL)
	{
		global $_W;
		session_start();

		if (!empty($_SESSION['sign_xcx_openid'])) {
			$_W['openid'] = $_SESSION['sign_xcx_openid'];
		}

		$set = $this->getSet();
		$condition = '';

		if (!empty($set['cycle'])) {
			$month_start = mktime(0, 0, 0, date('m'), 1, date('Y'));
			$month_end = mktime(23, 59, 59, date('m'), date('t'), date('Y'));
			$condition .= ' and `time` between ' . $month_start . ' and ' . $month_end . ' ';
		}

		$records = pdo_fetchall('select * from ' . tablename('ewei_shop_sign_records') . ' where openid=:openid and `type`=0 and uniacid=:uniacid ' . $condition . ' order by `time` desc ', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		$signed = 0;
		$orderindex = 0;
		$order = array();
		$orderday = 0;

		if (!empty($records)) {
			foreach ($records as $key => $item) {
				$day = date('Y-m-d', $item['time']);
				$today = date('Y-m-d', time());
				if (empty($date) && $day == $today) {
					$signed = 1;
				}

				if (!empty($date) && $day == $date) {
					$signed = 1;
				}

				if (1 < count($records) && $key == 0) {
					if (date('Y-m-d', $records[$key + 1]['time']) == date('Y-m-d', strtotime('-1 day'))) {
						++$order[$orderindex];
					}
				}

				$dday = date('d', $item['time']);
				$pday = date('d', isset($records[$key + 1]['time']) ? $records[$key + 1]['time'] : 0);

				if ($dday - $pday == 1) {
					++$order[$orderindex];
				}
				else {
					if ($dday == 1 && date('d', isset($records[$key + 1]['time']) ? $records[$key + 1]['time'] : 0) == date('t', strtotime('-1 month', $item['time']))) {
						++$order[$orderindex];
					}
					else {
						++$orderindex;
						++$order[$orderindex];
					}
				}

				if ($this->dateplus($day, $orderday) == $this->dateminus($today, 1)) {
					++$orderday;
				}
			}
		}

		$data = array('order' => empty($order) ? 0 : max($order), 'orderday' => empty($signed) ? $orderday : $orderday + 1, 'sum' => count($records), 'signed' => $signed);
		return $data;
	}

	public function dateplus($date, $day)
	{
		$time = strtotime($date);
		$time = $time + 3600 * 24 * $day;
		$date = date('Y-m-d', $time);
		return $date;
	}

	public function dateminus($date, $day)
	{
		$time = strtotime($date);
		$time = $time - 3600 * 24 * $day;
		$date = date('Y-m-d', $time);
		return $date;
	}

	public function getAdvAward()
	{
		global $_W;
		$set = $this->getSet();
		$date = $this->getDate();
		$signinfo = $this->getSign();
		$reword_sum = iunserializer($set['reword_sum']);
		$reword_order = iunserializer($set['reword_order']);
		$condition = '';

		if (!empty($set['cycle'])) {
			$month_start = mktime(0, 0, 0, date('m'), 1, date('Y'));
			$month_end = mktime(23, 59, 59, date('m'), date('t'), date('Y'));
			$condition .= ' and `time` between ' . $month_start . ' and ' . $month_end . ' ';
		}

		$records = pdo_fetchall('select * from ' . tablename('ewei_shop_sign_records') . ' where openid=:openid and uniacid=:uniacid ' . $condition . ' order by `time` asc ', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if (!empty($records)) {
			foreach ($records as $item) {
				if (!empty($reword_order)) {
					foreach ($reword_order as $i => &$order) {
						if (!empty($set['cycle']) && $date['days'] < $order['day']) {
							unset($reword_order[$i]);
						}

						if ($item['day'] == $order['day'] && $item['type'] == 1) {
							$order['drawed'] = 1;
						}
						else {
							if ($order['day'] <= $signinfo['order']) {
								$order['candraw'] = 1;
							}
						}
					}

					unset($order);
				}

				if (!empty($reword_sum)) {
					foreach ($reword_sum as $i => &$sum) {
						if (!empty($set['cycle']) && $date['days'] < $sum['day']) {
							unset($reword_sum[$i]);
						}

						if ($item['day'] == $sum['day'] && $item['type'] == 2) {
							$sum['drawed'] = 1;
						}
						else {
							if ($sum['day'] <= $signinfo['sum']) {
								$sum['candraw'] = 1;
							}
						}
					}

					unset($sum);
				}
			}
		}

		$data = array('order' => $reword_order, 'sum' => $reword_sum);
		return $data;
	}

	public function updateSign($signinfo)
	{
		global $_W;
		session_start();

		if (!empty($_SESSION['sign_xcx_openid'])) {
			$_W['openid'] = $_SESSION['sign_xcx_openid'];
		}

		if (empty($signinfo)) {
			$signinfo = $this->getSign();
		}

		$info = pdo_fetch('select id  from ' . tablename('ewei_shop_sign_user') . ' where openid=:openid and uniacid=:uniacid limit 1 ', array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
		$data = array('openid' => $_W['openid'], 'order' => $signinfo['order'], 'orderday' => $signinfo['orderday'], 'sum' => $signinfo['sum'], 'signdate' => date('Y-m'));

		if ($_SESSION['sign_xcx_isminiprogram']) {
			$data['isminiprogram'] = 1;
		}

		if (empty($info)) {
			$data['uniacid'] = $_W['uniacid'];
			pdo_insert('ewei_shop_sign_user', $data);
		}
		else {
			pdo_update('ewei_shop_sign_user', $data, array('id' => $info['id']));
		}
	}
}

?>
