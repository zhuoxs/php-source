<?php
defined('IN_IA') or exit('Access Denied');
load()->func('tpl');
$ops = array('display', 'post');
$op = in_array($op, $ops) ? $op : 'display';

if ($op == 'display') {
	//数据统计	
	$today = strtotime(date('Ymd'));
	$yestoday = $today - 86400;
	$lastweek = $today - 604800;
	$newshiftcar = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_record') . " WHERE uniacid = '{$_W['uniacid']}' and createtime >= {$today}");
	$newapi = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_apirecord') . " WHERE uniacid = '{$_W['uniacid']}' and createtime >= {$today}");
	$totype1 = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_apirecord') . " WHERE uniacid = '{$_W['uniacid']}' and type = 1 and createtime >= {$today}");
	$totype2 = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_apirecord') . " WHERE uniacid = '{$_W['uniacid']}' and type = 2 and createtime >= {$today}");
	$totype3 = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_apirecord') . " WHERE uniacid = '{$_W['uniacid']}' and type = 3 and createtime >= {$today}");
	$totype4 = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_apirecord') . " WHERE uniacid = '{$_W['uniacid']}' and type = 4 and createtime >= {$today}");
	$week_newshiftcar = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_record') . " WHERE uniacid = '{$_W['uniacid']}' and createtime < {$today} and createtime > {$lastweek}");
	$week_newapi = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_apirecord') . " WHERE uniacid = '{$_W['uniacid']}' and createtime < {$today} and createtime > {$lastweek}");
	$allshiftcar = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_record') . " WHERE uniacid = '{$_W['uniacid']}'");
	$allapi = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_apirecord') . " WHERE uniacid = '{$_W['uniacid']}'");
	//曲线图
	$starttime = strtotime(date('Y-m-d')) - 7 * 86400;
	$endtime = strtotime(date('Y-m-d'))+86400;
	$list = array();
	$j = 0;
	while($endtime >= $starttime){
		$allsnum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_record') . " WHERE createtime >= :createtime AND createtime <= :endtime", array( ':createtime' => $endtime-86400, ':endtime' => $endtime));
		$allapinum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_apirecord') . " WHERE createtime >= :createtime AND createtime <= :endtime", array( ':createtime' => $endtime-86400, ':endtime' => $endtime));
		$type1 = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_apirecord') . " WHERE type = 1 AND createtime >= :createtime AND createtime <= :endtime", array( ':createtime' => $endtime-86400, ':endtime' => $endtime));
		$type2 = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_apirecord') . " WHERE type = 2 AND createtime >= :createtime AND createtime <= :endtime", array( ':createtime' => $endtime-86400, ':endtime' => $endtime));
		$type3 = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_apirecord') . " WHERE type = 3 AND createtime >= :createtime AND createtime <= :endtime", array( ':createtime' => $endtime-86400, ':endtime' => $endtime));
		$type4 = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_apirecord') . " WHERE type = 4 AND createtime >= :createtime AND createtime <= :endtime", array( ':createtime' => $endtime-86400, ':endtime' => $endtime));
		
		$list[$j]['allsnum'] = $allsnum;
		$list[$j]['createtime'] = $endtime - 86400;
		$list2[$j]['allapinum'] = $allapinum;
		$list2[$j]['type1'] = $type1;
		$list2[$j]['type2'] = $type2;
		$list2[$j]['type3'] = $type3;
		$list2[$j]['type4'] = $type4;
		$j++;
		$endtime = $endtime - 86400;
	}
	
	$list = array_reverse($list);
	$list2 = array_reverse($list2);
	$day = $allsnum = $allapinums = $type1 = $type2 = $type3 = $type4 = array();
	if (!empty($list)) {
		foreach ($list as $row) {
			$day[] = date('m-d', $row['createtime']);
			$allsnum[] = intval($row['allsnum']);
		}
	}
	if (!empty($list2)) {
		foreach ($list2 as $row) {
			$allapinums[] = intval($row['allapinum']);
			$type1[] = intval($row['type1']);
			$type2[] = intval($row['type2']);
			$type3[] = intval($row['type3']);
			$type4[] = intval($row['type4']);
		}
	}
	
	
	
	
	
	
	
	include wl_template('data/summary');
}
		
	