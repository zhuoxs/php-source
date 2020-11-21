<?php
	if (empty($starttime) || empty($endtime)) {//初始化时间
		$starttime = strtotime('-1 month');
		$endtime = time();
	}
	if($_GPC['type']){
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']);
		$result = model_finance::downloadbill($starttime, $endtime, $_GPC['type']);
		wl_debug($result);
	}
	include wl_template('data/check_log');