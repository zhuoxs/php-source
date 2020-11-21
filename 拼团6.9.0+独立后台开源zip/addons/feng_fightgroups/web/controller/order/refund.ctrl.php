<?php
defined('IN_IA') or exit('Access Denied');

$ops = array('display', 'initsync');
$op = in_array($op, $ops) ? $op : 'display';

if ($op == 'display') {
	if (empty($starttime) || empty($endtime)) {//初始化时间
		$starttime = strtotime('-1 month');
		$endtime = time();
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$where = array();
	$where['mobile>'] = 10000000000;
	//排除虚拟订单
	$where['status'] = 6;
	if (TG_MERCHANTID)
		$where['merchantid'] = $_SESSION['role_id'];
	if (!empty($_GPC['time']) && !empty($_GPC['timetype'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']);
		switch($_GPC['timetype']) {
			case 1 :
				$where['createtime>'] = $starttime;
				$where['createtime<'] = $endtime;
				break;
			case 2 :
				$where['ptime>'] = $starttime;
				$where['ptime<'] = $endtime;
				break;
			default :
				break;
		}
	}
	if (!empty($_GPC['keyword'])) {
		if (!empty($_GPC['keywordtype'])) {
			switch($_GPC['keywordtype']) {
				case 1 :
					$where['@orderno@'] = $_GPC['keyword'];
					break;
				case 2 :
					$where['@transid@'] = $_GPC['keyword'];
					break;
				case 3 :
					$where['g_id'] = $_GPC['keyword'];
					break;
				case 4 :
					$where['merchantid'] = $_GPC['keyword'];
					break;
				case 5 :
					$where['@addname@'] = $_GPC['keyword'];
					break;
				case 6 :
					$where['@mobile@'] = $_GPC['keyword'];
					break;
				default :
					break;
			}
		}
	}
	$orderData = model_order::getNumOrder('*', $where, 'createtime desc', $pindex, $psize, 1);
	$list = $orderData[0];
	$pager = $orderData[1];
	$total = $orderData[2];
	include  wl_template("order/refund");
}
if ($op == 'initsync') {
	$order_ids = $_GPC['order_ids'];
	$log = $_GPC['log'];
	$all = $_GPC['all'];
	$success = $_GPC['success'];
	$fail = $_GPC['fail'];

	$where = array();
	$where['status'] = 6;
	$con = 'WHERE status = 6';

	if (TG_MERCHANTID) {
		$where['merchantid'] = $_SESSION['role_id'];
		$con .= "AND merchantid = {$_SESSION['role_id']}";
	}

	if ($log == '') {
		if (!empty($order_ids)) {
			$where['#id#'] = "($order_ids)";
			$orderData = model_order::getNumOrder("*", $where, 'createtime desc', 0, 0, 1);
			$list = $orderData[0];
			$all = $orderData[2];
		} else {
			$all = pdo_fetchcolumn('SELECT count(id) FROM ' . tablename('tg_order') . $con);
		}
		message('正在为' . $all . '个订单退款,请不要关闭浏览器', web_url('order/refund/initsync', array('type' => $type, 'groupnumber' => $_GPC['groupnumber'], 'log' => 0, 'order_ids' => $order_ids, 'all' => $all, 'success' => 0, 'fail' => 0)), 'success');
	}
	if (!empty($order_ids)) {
		$where['#id#'] = "($order_ids)";
		$orderData = model_order::getNumOrder("*", $where, 'createtime desc', 0, 9, 1);
		$list = $orderData[0];
		foreach ($list as $key => $value) {
			$res = model_order::refundMoney($value['id'], $value['pay_price'], '', 2);
			if ($res['status']) {
				$success += 1;
			} else {
				$fail += 1;
			}
		}
	} else {
		$orderData = model_order::getNumOrder("*", $where, 'createtime desc', 0, 9, 1);
		$list = $orderData[0];
		foreach ($list as $key => $value) {
			$res = model_order::refundMoney($value['id'], $value['pay_price'], '', 2);
			if ($res['status']) {
				$success++;
			} else {
				$fail++;
			}
		}
	}
	$log += count($list);
	$level_num = $all - $success - $fail;
	if ($level_num <= 0) {
		message('全部退款操作完成,总共' . $all . "个退款单,成功" . $success . "个,失败" . $fail . "个！！", web_url('order/refund'), 'success');
	} else {
		message('正在退款,请不要关闭浏览器,已退 ' . $log . ' 个订单,成功' . $success . '个,失败' . $fail . '个,总共' . $all . "个退款单", web_url('order/refund/initsync', array('type' => $type, 'chou' => $_GPC['groupnumber'], 'log' => $log, 'all' => $all, 'success' => $success, 'fail' => $fail)));
	}
}
