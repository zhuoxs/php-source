<?php
defined('IN_IA') or exit('Access Denied');
load()->func('tpl');
$ops = array('display', 'post');
$op = in_array($op, $ops) ? $op : 'display';

if ($op == 'display') {
	$today = strtotime(date('Ymd'));
	$firstday = strtotime(date('Y-m-01'));
	
	//浏览量
	$todaypuv = pdo_get('weliam_shiftcar_puv',array('uniacid' => $_W['uniacid'],'date' => date('Ymd')),array('pv','uv'));
	$yestodaypuv = pdo_get('weliam_shiftcar_puv',array('uniacid' => $_W['uniacid'],'date' => date('Ymd',$today - 86400)),array('pv','uv'));
	
	//会员统计
	$newfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and createtime >= {$firstday}");
	$allfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}'");
	$newowner = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and status = 2 and acttime >= {$firstday}");
	$allowner = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and status = 2");
	
	//二维码统计
	$allnumber = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('qrcode_stat') . " WHERE uniacid = '{$_W['uniacid']}' and name = '微信挪车卡'");
	$follownum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('qrcode_stat') . " WHERE uniacid = '{$_W['uniacid']}' and name = '微信挪车卡' and type = 1 and createtime > {$today}");
	$allnum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('qrcode_stat') . " WHERE uniacid = '{$_W['uniacid']}' and name = '微信挪车卡' and createtime > {$today}");
	$scannum = $allnum - $follownum;

	$con =  "uniacid = {$_W['uniacid']}  and name = '微信挪车卡'";
	$starttime = empty($_GPC['time']['start']) ? strtotime(date('Y-m-d')) - 7 * 86400 : strtotime($_GPC['time']['start']);
	$endtime = empty($_GPC['time']['end']) ? strtotime(date('Y-m-d'))+86400 : strtotime($_GPC['time']['end'])+86400;
	
	$list = array();
	$j = 0;
	while($endtime >= $starttime){
		$allsnum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('qrcode_stat') . " WHERE $con AND createtime >= :createtime AND createtime <= :endtime", array( ':createtime' => $endtime-86400, ':endtime' => $endtime));
		$type1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('qrcode_stat') . " WHERE $con and type = 1 AND createtime >= :createtime AND createtime <= :endtime", array( ':createtime' => $endtime-86400, ':endtime' => $endtime));

		$list[$j]['allsnum'] = $allsnum;
		$list[$j]['type1'] = $type1;
		$list[$j]['type2'] = $allsnum - $type1;
		$list[$j]['createtime'] = $endtime - 86400;
		$j++;
		$endtime = $endtime - 86400;
	}
	$list = array_reverse($list);
	$day = $allsnum = $type1 = array();
	if (!empty($list)) {
		foreach ($list as $row) {
			$day[] = date('m-d', $row['createtime']);
			$allsnum[] = intval($row['allsnum']);
			$type1[] = intval($row['type1']);
			$type2[] = intval($row['type2']);
		}
	}
	
	include wl_template('data/dashboard');
}
