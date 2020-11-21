<?php
	$ops = array('display');
	$op_names = array('退款日志');
	foreach($ops as$key=>$value){
		permissions('do', 'ac', 'op', 'data', 'refund_log', $ops[$key], '数据中心', '退款日志', $op_names[$key]);
	}
	$op = in_array($op, $ops) ? $op : 'display';
	if($op=='display'){
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = "  uniacid = :uniacid and merchantid=".MERCHANTID;
		$paras = array(':uniacid' => $_W['uniacid']);
		
		$goodsid = $_GPC['goodsid'];	
		$transid = $_GPC['transid'];
		$pay_type = $_GPC['pay_type'];
		$keyword = $_GPC['keyword'];
		$member = $_GPC['member'];
		$time = $_GPC['time'];
		
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}
		if (!empty($_GPC['time'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']) + 86399;
			$condition .= " AND  createtime >= :starttime AND  createtime <= :endtime ";
			$paras[':starttime'] = $starttime;
			$paras[':endtime'] = $endtime;
		}
		if (!empty($_GPC['transid'])) {
		
			$condition .= " AND  transid =  '{$_GPC['transid']}'";
		}
		if (!empty($_GPC['keyword'])) {
			$condition .= " AND  orderno LIKE '%{$_GPC['keyword']}%'";
		}
		if (!empty($_GPC['member'])) {
			$condition .= " AND (refundername LIKE '%{$_GPC['member']}%' or refundermobile LIKE '%{$_GPC['member']}%')";
		}
		if ($goodsid != '') {
			$condition .= " AND  goodsid = '" . intval($goodsid) . "'";
		}
		$sql = "select  * from " . tablename('tg_refund_record') . " where $condition ORDER BY createtime DESC " . "LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $paras);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tg_refund_record') . " WHERE $condition", $paras);
		$pager = pagination($total, $pindex, $psize);
		include wl_template('data/refund_log');
	}

?>