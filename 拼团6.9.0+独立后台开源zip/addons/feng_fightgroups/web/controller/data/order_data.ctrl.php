<?php
	
	$ops = array('display');
	$op = in_array($op, $ops) ? $op : 'display';
	if($op=='display'){
		$data = pdo_fetch("select * from".tablename('tg_puv')."where uniacid={$_W['uniacid']} limit 1");
		$allorders = pdo_fetchall("select distinct(openid),pay_price from".tablename('tg_order')."where uniacid={$_W['uniacid']} ".TG_MERCHANTID."");
		$money = 0;
		foreach($allorders as$key=>$value){
			$money = $value['pay_price'];
		}
		$payorders = pdo_fetchall("select distinct(openid) from".tablename('tg_order')."where uniacid={$_W['uniacid']} and status in(1,2,3,4,6,7)  ".TG_MERCHANTID."");
		$payordersnum = pdo_fetchall("select id from".tablename('tg_order')."where uniacid={$_W['uniacid']} and status in(1,2,3,4,6,7) ".TG_MERCHANTID."");
		$allorders2 = pdo_fetchall("select pay_price from".tablename('tg_order')."where uniacid={$_W['uniacid']} and status in(1,2,3,4,6,7) ".TG_MERCHANTID." ");
		$porders = count($payorders);
		$aorders = count($allorders);
		$pordersnum = count($payordersnum);
		$ordersnum = count($orders);
		
		$money2 = 0;
		foreach($allorders2 as$key=>$value){
			$money2 = $value['pay_price'];
		}
	//	wl_debug($orders);
		$seven_orders =  0;
		$obligations =  0;
		$undelivereds =  0;
		$incomes =  0;
		$yesterday_orders =  0;
		$yesterday_payorder =  0;
		$yesterday_obligation = 0;
		$stime = strtotime(date('Y-m-d')) - 6* 86400;
		$etime = strtotime(date('Y-m-d'));
		$ytime = strtotime(date('Y-m-d')) -  86400;
		$seven_orders = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tg_order') . " WHERE uniacid = '{$_W['uniacid']}' and mobile<>'虚拟'  ".TG_MERCHANTID."   AND createtime >= :createtime AND createtime <= :endtime ORDER BY createtime ASC", array( ':createtime' => $stime, ':endtime' => $etime));
		$obligations = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tg_order') . " WHERE uniacid = '{$_W['uniacid']}' and mobile<>'虚拟' and status=0  ".TG_MERCHANTID."");
		$undelivereds = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tg_order') . " WHERE uniacid = '{$_W['uniacid']}' and mobile<>'虚拟' and status=2  ".TG_MERCHANTID."");
		$seven = pdo_fetchall("select pay_price  from" . tablename('tg_order') . " WHERE uniacid = '{$_W['uniacid']}' and mobile<>'虚拟'  ".TG_MERCHANTID." and status in(1,2,3,4,6)  AND createtime >= :createtime AND createtime <= :endtime ORDER BY createtime ASC", array( ':createtime' => $stime, ':endtime' => $etime));
		foreach($seven as$key=>$value){
			$incomes += $value['pay_price'];
		}
		
		$yesterday_orders=pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tg_order') . " WHERE uniacid = '{$_W['uniacid']}' and mobile<>'虚拟'  ".TG_MERCHANTID."  AND createtime >= :createtime AND createtime <= :endtime ORDER BY createtime ASC", array( ':createtime' => $ytime, ':endtime' => $etime));
		$yesterday_payorder = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tg_order') . " WHERE uniacid = '{$_W['uniacid']}' and mobile<>'虚拟' ".TG_MERCHANTID." and status in(1,2,3,4,6,7)   AND createtime >= :createtime AND createtime <= :endtime ORDER BY createtime ASC", array( ':createtime' => $ytime, ':endtime' => $etime));
		$yesterday_obligation = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tg_order') . " WHERE uniacid = '{$_W['uniacid']}' and mobile<>'虚拟'  ".TG_MERCHANTID." and status = 3   AND sendtime >= :createtime AND sendtime <= :endtime ORDER BY createtime ASC", array( ':createtime' => $ytime, ':endtime' => $etime));
	
		$con =  "uniacid = '{$_W['uniacid']}' and mobile<>'虚拟' "  ;
		$starttime = empty($_GPC['time']['start']) ? strtotime(date('Y-m-d')) - 7 * 86400 : strtotime($_GPC['time']['start']);
		$endtime = empty($_GPC['time']['end']) ? strtotime(date('Y-m-d'))+86400 : strtotime($_GPC['time']['end'])+86400;
		$s = $starttime;
		$e = $endtime;
		$list = array();
		$j=0;
		
		while($e >= $s){
			$listone = pdo_fetchall("SELECT id  FROM " . tablename('tg_order') . " WHERE $con   ".TG_MERCHANTID." AND createtime >= :createtime AND createtime <= :endtime ORDER BY createtime ASC", array( ':createtime' => $e-86400, ':endtime' => $e));
			$status1 = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tg_order') . " WHERE $con and status<>0  ".TG_MERCHANTID."  AND createtime >= :createtime AND createtime <= :endtime ORDER BY createtime ASC", array( ':createtime' => $e-86400, ':endtime' => $e));
			$status4 = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tg_order') . " WHERE $con and status=4   ".TG_MERCHANTID." AND createtime >= :createtime AND createtime <= :endtime ORDER BY createtime ASC", array( ':createtime' => $e-86400, ':endtime' => $e));
			$list[$j]['gnum'] = count($listone);
			$list[$j]['status4'] = $status4;
			$list[$j]['status1'] = $status1;
			$list[$j]['createtime'] =  $e-86400;
			$j++;
			$e = $e-86400;
		}
		
		$day = $hit = $status4 = $status1 = array();
		if (!empty($list)) {
			foreach ($list as $row) {
				$day[] = date('m-d', $row['createtime']);
				$hit[] = intval($row['gnum']);
				$status4[] = intval($row['status4']);
				$status1[] = intval($row['status1']);
			}
		}
		
		for ($i = 0; $i = count($hit) < 2; $i++) {
			$day[] = date('m-d', $endtime);
			$hit[] = $day[$i] == date('m-d', $endtime) ? $hit[0] : '0';
		}
		include wl_template('data/order_data');
	}