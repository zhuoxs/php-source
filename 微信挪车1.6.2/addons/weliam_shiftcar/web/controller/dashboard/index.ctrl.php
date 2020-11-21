<?php
defined('IN_IA') or exit('Access Denied');
load()->func('tpl');
$ops = array('display', 'post');
$op = in_array($op, $ops) ? $op : 'display';

if ($op == 'display') {
	$today = strtotime(date('Ymd'));
	$firstday = strtotime(date('Y-m-01'));
	$yestoday = $today - 86400;
	//浏览量
	$todaypuv = pdo_get('weliam_shiftcar_puv',array('uniacid' => $_W['uniacid'],'date' => date('Ymd')),array('pv','uv'));
	$yestodaypuv = pdo_get('weliam_shiftcar_puv',array('uniacid' => $_W['uniacid'],'date' => date('Ymd',$today - 86400)),array('pv','uv'));
	
	//会员统计
	$newfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and createtime >= {$firstday}");
	$yes_newfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and createtime < {$today} and createtime > {$yestoday}");
	$allfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and createtime < {$firstday}");
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
	
	//扫描记录
	$starttime = TIMESTAMP -  86399 * 30 ;
	$endtime = TIMESTAMP + 6*86400;
	$where .= " WHERE name = '微信挪车卡' AND uniacid = :uniacid AND acid = :acid AND createtime >= :starttime AND createtime < :endtime";
	$param = array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid'], ':starttime' => $starttime, ':endtime' => $endtime);
	$pindex = 1;
	$psize = 10;
	$count = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('qrcode_stat'). $where, $param);
	$list = pdo_fetchall("SELECT * FROM ".tablename('qrcode_stat')." $where ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.','. $psize, $param);
	if (!empty($list)) {
		$openid = array();
		foreach ($list as $index => &$qrcode) {
			if ($qrcode['type'] == 1) {
				$qrcode['type']='<span class="label label-danger">关注</span>';
			} else {
				$qrcode['type']='<span class="label label-primary">扫描</span>';
			}
			if(!in_array($qrcode['openid'], $openid)) {
				$openid[] = $qrcode['openid'];
			}
			$list[$index]['mid'] = pdo_getcolumn('weliam_shiftcar_member', array('openid' => $qrcode['openid'],'uniacid' => $_W['uniacid']), 'id');
			$list[$index]['cardsn'] = pdo_getcolumn('weliam_shiftcar_qrcode', array('qrid' => $qrcode['qid']), 'cardsn');
		}
		$openids = implode("','", $openid);
		$param_temp[':uniacid'] = $_W['uniacid'];
		$param_temp[':acid'] = $_W['acid'];
		$nickname = pdo_fetchall('SELECT nickname, openid FROM ' . tablename('mc_mapping_fans') . " WHERE uniacid = :uniacid AND acid = :acid AND openid IN ('{$openids}')", $param_temp, 'openid');
	}
	
	include wl_template('dashboard/index');
}
