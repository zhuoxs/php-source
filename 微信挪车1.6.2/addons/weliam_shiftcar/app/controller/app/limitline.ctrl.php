<?php
defined('IN_IA') or exit('Access Denied');
$ops = array('detail');
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'detail';
$pagetitle = !empty($config['tginfo']['sname']) ? '限行日历 - '.$config['tginfo']['sname'] : '限行日历';

if($op == 'detail'){
	$id = intval($_GPC['id']);
	$val = pdo_get('weliam_shiftcar_limitlinetpl',array('uniacid'=>$_W['uniacid'],'id'=>$id));
	$val['data'] = unserialize($val['data']);
	if($val['islimittime'] == 2){
		$val['limittime'] = unserialize($val['limittime']);
	}
	$thisyue = strtotime(date("Y-m-"."01"));
	for ($i=0; $i < 42; $i++) {
		$thisDay = $thisyue + 24*60*60*($i - date('w',$thisyue));
		$islimt = '';
		$issend = '';
		if($val['islimittime'] == 1 || ($val['islimittime'] == 2 && $val['limittime']['start'] < $thisDay && $val['limittime']['end'] > $thisDay)){
			if(!empty($val['data'])){
				foreach ($val['data'] as $dk => $da) {
					if($da['data_shop'] == 'ALL'){
						if($da['data_temp'] == $_W['wlmember']['plate1']) $islimt = TRUE;
					}else{
						if($da['data_temp'] == $_W['wlmember']['plate1'] && $da['data_shop'] == $_W['wlmember']['plate2']) $islimt = TRUE;
					}
					if($islimt) break;
				}
			}
			if($val['isnumber'] == 1){
				$plate_number = substr($_W['wlmember']['plate_number'],-1);
				if(!is_numeric($plate_number)){
					$plate_number = 0;
				}
			}else{
				$plate_number = preg_replace('/[\.a-zA-Z]/s','',$_W['wlmember']['plate_number']);
				$plate_number = substr($plate_number,-1);
			}
			if($val['type'] == 1 && $islimt){
				$limitweek = explode(';', $val['limitweek']);
				$week = date('w',$thisDay);
				if($week == 0){
					$week = 6;
				}else{
					$week = $week - 1;
				}
				$limitweek = explode(',', $limitweek[$week]);
				if(in_array($plate_number, $limitweek)){
					$issend = $val['id'];
				}
			}elseif($val['type'] == 2 && $islimt){
				$limitday = explode(';', $val['limitday']);
				$day = date('j',$thisDay);
				$day = $day%2;
				if($day == 0){
					$limitday = explode(',', $limitday[1]);
				}else{
					$limitday = explode(',', $limitday[0]);
				}
				if(in_array($plate_number, $limitday)){
					$issend = $val['id'];
				}
			}
		}
		if($islimt && $issend){
			$alldata[] = TRUE;
		}else{
			$alldata[] = FALSE;
		}
	}
	
	include wl_template('app/limitline_detail');
}
