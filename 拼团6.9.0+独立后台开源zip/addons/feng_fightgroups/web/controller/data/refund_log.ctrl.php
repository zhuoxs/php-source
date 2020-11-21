<?php
	$ops = array('display');
	$op = in_array($op, $ops) ? $op : 'display';
	if($op=='display'){
		if (empty($starttime) || empty($endtime)) {//初始化时间
			$starttime = strtotime('-1 month');
			$endtime = time();
		}
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = "  uniacid = :uniacid  ".TG_MERCHANTID."";
		$paras = array(':uniacid' => $_W['uniacid']);
		
		$goodsid = $_GPC['goodsid'];	
		$transid = $_GPC['transid'];
		$keyword = $_GPC['keyword'];
		$member = $_GPC['member'];
		$time = $_GPC['time'];
		
		if (!empty($_GPC['time']) && !empty($_GPC['timetype'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			switch($_GPC['timetype']){
				case 1:$condition .= " AND createtime>='{$starttime}' and createtime<='{$endtime}'";;
				default:break;
			}
		}
		if (!empty($_GPC['keyword'])) {
			if(!empty($_GPC['keywordtype'])){
				switch($_GPC['keywordtype']){
					case 1: $o=pdo_fetch("select id from".tablename('tg_order')."where orderno='{$_GPC['keyword']}'"); if($o['id'])$condition .= " AND orderid='{$o['id']}' ";break;
					case 2:  $condition .= " AND transid LIKE '%{$_GPC['keyword']}%' ";break;
					case 3: $condition .= " AND goodsid LIKE '%{$_GPC['keyword']}%' ";break;
					case 4: $condition .= " AND merchantid LIKE '%{$_GPC['keyword']}%' ";break;
					case 5: $condition .= " AND refundername LIKE '%{$_GPC['keyword']}%' ";break;
					case 6: $condition .= " AND refundermobile LIKE '%{$_GPC['keyword']}%' ";break;
					default:break;
				}
			}
		}
		$sql = "select  * from " . tablename('tg_refund_record') . " where $condition ORDER BY createtime DESC " . "LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $paras);
		foreach ($list as $key => &$value) {
			$value['orderno'] = model_order::getSingleOrder($value['orderid'], '*');
		}
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tg_refund_record') . " WHERE $condition", $paras);
		$pager = pagination($total, $pindex, $psize);
		include wl_template('data/refund_log');
	}

?>