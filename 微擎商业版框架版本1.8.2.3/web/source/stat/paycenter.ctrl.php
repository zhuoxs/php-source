<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('stat_credit2');
$dos = array('index', 'chart', 'detail');
$do = in_array($do, $dos) ? $do : 'index';
load()->model('mc');
$_W['page']['title'] = "收银台收银统计-统计中心";
load()->model('paycenter');
load()->model('mc');

if($do == 'index') {
	$clerks = pdo_getall('activity_clerks', array('uniacid' => $_W['uniacid']), array('id', 'name'), 'id');
	$stores = pdo_getall('activity_stores', array('uniacid' => $_W['uniacid']), array('id', 'business_name', 'branch_name'), 'id');
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = ' WHERE uniacid = :uniacid AND status = 1';
	$params = array(':uniacid' => $_W['uniacid']);
	$clerk_id = intval($_GPC['clerk_id']);
	if (!empty($clerk_id)) {
		$condition .= ' AND clerk_id = :clerk_id';
		$params[':clerk_id'] = $clerk_id;
	}
	$store_id = trim($_GPC['store_id']);
	if (!empty($store_id)) {
		$condition .= ' AND store_id = :store_id';
		$params[':store_id'] = $store_id;
	}
	$limit = " ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ", {$psize}";
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM' . tablename('paycenter_order') . $condition, $params);
	$orders = pdo_fetchall('SELECT * FROM ' . tablename('paycenter_order') . $condition . $limit, $params);
	$pager = pagination($total, $pindex, $psize);
	$status = paycenter_order_status();
	if(!empty($orders)) {
		foreach ($orders as &$value) {
			$operator = mc_account_change_operator($value['clerk_type'], $value['store_id'], $value['clerk_id']);
			$value['clerk_cn'] = $operator['clerk_cn'];
			$value['store_cn'] = $operator['store_cn'];
		}
	}
}

if($do == 'detail') {
	if($_W['isajax']) {
		$id = intval($_GPC['id']);
		$order = pdo_get('paycenter_order', array('uniacid' => $_W['uniacid'], 'id' => $id));
		if(empty($order)) {
			$info = '订单不存在';
		} elseif($order['status'] == 0) {
			$info = '订单尚未支付';
		} else {
			$types = paycenter_order_types();
			$trade_types = paycenter_order_trade_types();
			$status = paycenter_order_status();
			$info = template('paycenter/payinfo', TEMPLATE_FETCH);
		}
		message(error(0, $info), '', 'ajax');
	}
}

if($do == 'chart') {
	$today_starttime = strtotime(date('Y-m-d'));
	$today_endtime = $today_starttime + 86400;
	$yesterday_starttime = $today_starttime - 86400;
	$yesterday_endtime = $today_starttime;
	$month_starttime = date('Y-m-01', strtotime(date("Y-m-d")));
	$month_endtime = strtotime("$month_starttime + 1month - 1day");
	$today_fee = floatval(pdo_fetchcolumn('SELECT SUM(final_fee) FROM ' . tablename('paycenter_order') . ' WHERE uniacid = :uniacid AND status = 1 AND paytime >= :starttime AND paytime <= :endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => $today_starttime, ':endtime' => $today_endtime)));
	$yesterday_fee = floatval(pdo_fetchcolumn('SELECT SUM(final_fee) FROM ' . tablename('paycenter_order') . ' WHERE uniacid = :uniacid AND status = 1 AND paytime >= :starttime AND paytime <= :endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => $yesterday_starttime, ':endtime' => $yesterday_endtime)));
	$month_fee = floatval(pdo_fetchcolumn('SELECT SUM(final_fee) FROM ' . tablename('paycenter_order') . ' WHERE uniacid = :uniacid AND status = 1 AND paytime >= :starttime AND paytime <= :endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => strtotime($month_starttime), ':endtime' => $month_endtime)));
	$type = trim($_GPC['type']);
	if($_W['isajax']) {
		if($type == 'date') {
			$now = strtotime(date('Y-m-d'));
			$starttime = empty($_GPC['start']) ? $now - 30*86400 : strtotime($_GPC['start']);
			$endtime = empty($_GPC['end']) ? TIMESTAMP : strtotime($_GPC['end']) + 86399;
			$num = ($endtime + 1 - $starttime) / 86400;

			$stat = array(
				'flow1' => array()
			);
			for($i = 0; $i < $num; $i++) {
				$time = $i * 86400 + $starttime;
				$key = date('m-d', $time);
				$stat['flow1'][$key] = 0;
			}
			$data = pdo_fetchall('SELECT id, final_fee, paytime, uniacid FROM ' . tablename('paycenter_order') . ' WHERE uniacid = :uniacid AND status = 1 AND paytime >= :starttime AND paytime <= :endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => $starttime, ':endtime' => $endtime));
			if(!empty($data)) {
				foreach($data as $da) {
					$key = date('m-d', $da['paytime']);
					$stat['flow1'][$key] += $da['final_fee'];
				}
			}
			$total = floatval(pdo_fetchcolumn('SELECT SUM(final_fee) FROM ' . tablename('paycenter_order') . ' WHERE uniacid = :uniacid AND status = 1 AND paytime >= :starttime AND paytime <= :endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => $starttime, ':endtime' => $endtime)));
			$out['total'] = $total;
			$out['label'] = array_keys($stat['flow1']);
			$out['datasets']['flow1'] = array_values($stat['flow1']);
			exit(json_encode($out));
		} elseif($type == 'month') {
			$now = mktime(0,0,0,date('m'),date('t'),date('Y'));
			$end = mktime(23,59,59,date('m'),date('t'),date('Y'));
			$starttime = empty($_GPC['start']) ? strtotime('-6months', $now) : strtotime($_GPC['start']);
			$endtime = empty($_GPC['end']) ? $end : strtotime($_GPC['end']) +  date('t', strtotime($_GPC['end'])) * 86400 - 1;
			$num = ($endtime + 1 - $starttime) / 86400;

			$stat = array(
				'flow1' => array()
			);
			for($i = 0; $i < $num; $i++) {
				$time = $i * 86400 + $starttime;
				$key = date('Y-m', $time);
				$stat['flow1'][$key] = 0;
			}
			$data = pdo_fetchall('SELECT id, final_fee, paytime, uniacid FROM ' . tablename('paycenter_order') . ' WHERE uniacid = :uniacid AND status = 1 AND paytime >= :starttime AND paytime <= :endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => $starttime, ':endtime' => $endtime));
			if(!empty($data)) {
				foreach($data as $da) {
					$key = date('Y-m', $da['paytime']);
					$stat['flow1'][$key] += $da['final_fee'];
				}
			}
			$total = floatval(pdo_fetchcolumn('SELECT SUM(final_fee) FROM ' . tablename('paycenter_order') . ' WHERE uniacid = :uniacid AND status = 1 AND paytime >= :starttime AND paytime <= :endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => $starttime, ':endtime' => $endtime)));
			$out['total'] = $total;
			$out['label'] = array_keys($stat['flow1']);
			$out['datasets']['flow1'] = array_values($stat['flow1']);
			exit(json_encode($out));
		}
	}
}

template('stat/paycenter');

