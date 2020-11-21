<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('statistics');

$dos = array('display', 'app_display', 'get_account_api', 'get_account_app_api', 'get_account_visit');
$do = in_array($do, $dos) ? $do : 'display';

$support_type = array(
		'time' => array('today', 'week', 'month', 'daterange'),
		'divide' => array('bysum', 'byavg', 'byhighest'),
);


	if ($do == 'display') {
		$today = stat_visit_all_bydate('today', array(), true);
		$today = $today['count'];
		$today = !empty($today) ? current($today) : 0;
		$yesterday = stat_visit_all_bydate('yesterday', array(), true);
		$yesterday = $yesterday['count'];
		$yesterday = !empty($yesterday) ? current($yesterday) : 0;
		template('statistics/account');
	}

	if ($do == 'app_display') {
		$today = stat_visit_app_byuniacid('today', '', array(), true);
		$yesterday = stat_visit_app_byuniacid('yesterday', '', array(), true);
		$today_module_api = stat_all_visit_statistics('all_account', $today);
		$yesterday_module_api = stat_all_visit_statistics('all_account', $yesterday);

		template('statistics/app-account');
	}


if ($do == 'get_account_api') {
	$data = array();
	$time_type = trim($_GPC['time_type']);
	$type = trim($_GPC['type']);
	if (!in_array($time_type, $support_type['time'])) {
		iajax(-1, '参数错误！');
	}
	$daterange = array();
	if (!empty($_GPC['daterange'])) {
		$daterange = array(
			'start' => date('Ymd', strtotime($_GPC['daterange']['startDate'])),
			'end' => date('Ymd', strtotime($_GPC['daterange']['endDate'])),
		);
	}
	if ($type == 'web') {
		$all_result = stat_visit_web_bydate($time_type, $daterange, true);
	} elseif ($type == 'app') {
		$all_result = array();
		$visit_info = stat_visit_info('app', $time_type, '', $daterange, true);
		if (!empty($visit_info)) {
			foreach ($visit_info as $visit) {
				$all_result['count'][$visit['date']] += $visit['count'];
				$all_result['ip_count'][$visit['date']] += $visit['ip_count'];
			}
		}
	} else {
		$all_result = stat_visit_all_bydate($time_type, $daterange, true);
	}
	$result = $all_result['count'];
	$ip_visit_result = $all_result['ip_count'];
	if ($time_type == 'today') {
		$data_x = array(date('Ymd'));
	}
	if ($time_type == 'week') {
		$data_x = stat_date_range(date('Ymd', strtotime('-6 days')), date('Ymd'));
	}
	if ($time_type == 'month') {
		$data_x = stat_date_range(date('Ymd', strtotime('-29 days')), date('Ymd'));
	}
	if ($time_type == 'daterange') {
		$data_x = stat_date_range($daterange['start'], $daterange['end']);
	}
	if (empty($result)) {
		foreach ($data_x as $val) {
			$data_y[] = 0;
		}
	} else {
		foreach ($data_x as $key => $data) {
			foreach ($result as $date_key => $val) {
				if (strtotime($date_key) != strtotime($data)) {
					continue;
				}
				$data_y[$key] = $val;
			}
			if (empty($data_y[$key])) {
				$data_y[$key] = 0;
			}
		}
	}

	if (empty($ip_visit_result)) {
		foreach ($data_x as $val) {
			$data_y_ip[] = 0;
		}
	} else {
		foreach ($data_x as $key => $data) {
			foreach ($ip_visit_result as $ip_date_key => $ip_val) {
				if (strtotime($ip_date_key) != strtotime($data)) {
					continue;
				}
				$data_y_ip[$key] = $ip_val;
			}
			if (empty($data_y_ip[$key])) {
				$data_y_ip[$key] = 0;
			}
		}
	}
	if (empty($result) && empty($ip_visit_result)) {
		iajax(0, array('data_x' => $data_x, 'data_y' => $data_y, 'data_y_ip' => $data_y_ip));
	}

	iajax(0, array('data_x' => $data_x, 'data_y' => $data_y, 'data_y_ip' => $data_y_ip));
}

if ($do == 'get_account_app_api') {
	$accounts = array();
	$data = array();
	$account_table = table('account');
	$account_table->searchWithType(array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH));
	$account_table->accountRankOrder();
	$account_list = $account_table->searchAccountList();
	foreach ($account_list as $key => $account) {
		$account_list[$key] = uni_fetch($account['uniacid']);
		$accounts[] = mb_substr($account_list[$key]['name'], 0, 5, 'utf-8');
	}

	$type = trim($_GPC['time_type']);
	$divide_type = trim($_GPC['divide_type']);
	if (!in_array($type, $support_type['time']) || !in_array($divide_type, $support_type['divide'])) {
		iajax(-1, '参数错误！');
	}
	$daterange = array();
	if (!empty($_GPC['daterange'])) {
		$daterange = array(
			'start' => date('Ymd', strtotime($_GPC['daterange']['startDate'])),
			'end' => date('Ymd', strtotime($_GPC['daterange']['endDate'])),
		);
	}
	$result = stat_visit_app_bydate($type, '', $daterange, true);
	if (empty($result)) {
		if ($type == 'today') {
			$data_x = date('Ymd');
		}
		if ($type == 'week') {
			$data_x = stat_date_range(date('Ymd', strtotime('-7 days')), date('Ymd'));
		}
		if ($type == 'month') {
			$data_x = stat_date_range(date('Ymd', strtotime('-30 days')), date('Ymd'));
		}
		if ($type == 'daterange') {
			$data_x = stat_date_range($daterange['start'], $daterange['end']);
		}
		foreach ($data_x as $val) {
			$data_y[] = 0;
		}
		iajax(0, array('data_x' => $data_x, 'data_y' => $data_y));
	}
	foreach ($result as $val) {
		$data_x[] = $val['date'];
		if ($divide_type == 'bysum') {
			$data_y[] = $val['count'];
		} elseif ($divide_type == 'byavg') {
			$data_y[] = $val['avg'];
		} elseif ($divide_type == 'byhighest') {
			$data_y[] = $val['highest'];
		}
	}
	iajax(0, array('data_x' => $data_x, 'data_y' => $data_y));
}

if ($do == 'get_account_visit') {
	$page = max(1, intval($_GPC['page']));
	$size = max(10, intval($_GPC['size']));
	$start_time = date('Ymd', strtotime($_GPC['start_time']));
	$end_time = date('Ymd', strtotime($_GPC['end_time']) + 86400);
	if (empty($start_time) || empty($end_time)) {
		iajax(1, '参数有误');
	}
	$account_table = table('account');
	$accounts = $account_table->searchWithPage($page, $size)->orderby(array('rank' => 'DESC', 'uniacid' => 'DESC'))->getall('uniacid');
	if (empty($accounts)) {
		iajax(0, array());
	}
	$total_account = $account_table->getLastQueryTotal();
	$tota_visit = 0;
	$account_stat = array();
	$visit_data = pdo_getall('stat_visit', array('date >=' => $start_time, 'date <=' => $end_time), array('uniacid', 'count'));
	foreach ($visit_data as $item) {
		$tota_visit += $item['count'];
		if (!empty($accounts[$item['uniacid']])) {
			$account_stat[$item['uniacid']]['total'] += $item['count'];
			$account_stat[$item['uniacid']]['name'] = $accounts[$item['uniacid']]['name'];
		}
	}
	foreach ($accounts as $uniacid => $account) {
		if (!empty($account_stat[$uniacid])) {
			$accounts[$uniacid] = $account_stat[$uniacid];
		} else {
			$accounts[$uniacid] = array('total' => 0, 'name' => $account['name']);
		}
	}
	iajax(0, array(
		'total_account' => $total_account,
		'total_visit' => $tota_visit,
		'list' => array_values($accounts),
	));
}
