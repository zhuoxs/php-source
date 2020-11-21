<?php
	
/**
 * [weliam] Copyright (c) 2016/3/23 
 * 团model
 */
defined('IN_IA') or exit('Access Denied');

function group_get_by_params($params = '') {
	global $_W;
	if(!empty($params)){
		$params = ' where '. $params;
	}
	$sql = "SELECT * FROM " . tablename('tg_group') . $params;
	$group = pdo_fetch($sql);
	return $group;
}

function group_update_by_params($data,$params) {
	global $_W;
	$flag = pdo_update('tg_group',$data,$params);
	return $flag;
}

function updategourp() {
	global $_W;
	$now = time();
	$allgroups = pdo_fetchall("select *from" . tablename('tg_group') . "where groupstatus=3 and uniacid='{$_W['uniacid']}'");
	foreach ($allgroups as $key => $value) {
		if ($value['endtime'] < $now && $value['lacknum'] > 0) {
			pdo_update('tg_group', array('groupstatus' => 1), array('groupnumber' => $value['groupnumber']));
			$orders = pdo_fetchall("select id,pay_type from" . tablename('tg_order') . "where tuan_id='{$value['groupnumber']}' and uniacid='{$_W['uniacid']}' and status in(1,2,3,4) and price<>'' ");
			foreach ($orders as $k => $v) {
				if($v['pay_type'] == 4){
					$res = pdo_update('tg_order', array('status' => 7), array('id' => $v['id']));
				}else{
					$res = pdo_update('tg_order', array('status' => 6), array('id' => $v['id']));
				}
			}
		}
	}
}	
