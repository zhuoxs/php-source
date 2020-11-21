<?php
defined('IN_IA') or exit('Access Denied');
$op = $_GPC['op'] ? $_GPC['op'] : 'display';

if ($op == 'display') {
	$pagetitle = !empty($config['tginfo']['sname']) ? '余额充值 - ' . $config['tginfo']['sname'] : '余额充值';
	$money = intval($_GPC['money']);
	if (checksubmit('submit')) {
		$orderno = "Credit1_" . date('Ymd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
		if ($money < 1) { print_r('存在非法操作');
			exit ;
		}
		$money = $money / 100;
		$data = array('openid' => $openid, 'uniacid' => $_W['uniacid'], 'orderno' => $orderno, 'status' => 0, 'num' => $money, 'createtime' => TIMESTAMP, 'type' => 1);
		if (pdo_insert('tg_credit1rechargerecord', $data)) {
			$orderid = pdo_insertid();
			header("location:" . app_url('pay/paytype', array('creditType' => 'recharge', 'orderid' => $orderid)));
		} else {
			message('提交失败！');
		}
	}
	include  wl_template('credit/credit1');
}

if ($op == 'record') {
	$pagetitle = !empty($config['tginfo']['sname']) ? '余额记录 - ' . $config['tginfo']['sname'] : '余额记录';
	$time = time();
	$berforeTime = $time - 30 * 24 * 3600;
	$records = pdo_fetchall("select * from" . tablename('tg_credit1rechargerecord') . "where openid='{$_W['openid']}' and status=1");
	foreach ($records as $key => &$value) {
		$value['createtime'] = date('Y-m-d H:i:s', $value['createtime']);
		$value['remark'] = '余额充值';
	}
	$tgRecords = pdo_fetchall("select * from" . tablename('tg_credit_record') . "where uid='{$_W['member']['uid']}' and  type=2 and createtime>'{$berforeTime}' and createtime <'{$time}' order by createtime desc");
	foreach ($tgRecords as $key => &$value) {
		$value['createtime'] = date('Y-m-d H:i:s', $value['createtime']);
	}
	include  wl_template('credit/credit1record');
}
