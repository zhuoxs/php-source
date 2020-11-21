<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('stat_credit1');
$dos = array('index', 'chart');
$do = in_array($do, $dos) ? $do : 'index';
load()->model('mc');
$_W['page']['title'] = "积分统计-会员中心";

$starttime = empty($_GPC['time']['start']) ? mktime(0, 0, 0, date('m') , 1, date('Y')) : strtotime($_GPC['time']['start']);
$endtime = empty($_GPC['time']['end']) ? TIMESTAMP : strtotime($_GPC['time']['end']) + 86399;
$num = ($endtime + 1 - $starttime) / 86400;

if($do == 'index') {
	$condition = ' WHERE uniacid = :uniacid AND credittype = :credittype AND createtime >= :starttime AND createtime <= :endtime';
	$params = array(':uniacid' => $_W['uniacid'], ':credittype' => 'credit1', ':starttime' => $starttime, ':endtime' => $endtime);
	$num = intval($_GPC['num']);
	if($num > 0) {
		if($num == 1) {
			$condition .= ' AND num >= 0';
		} else {
			$condition .= ' AND num <= 0';
		}
	}
	$min = intval($_GPC['min']);
	if($min > 0 ) {
		$condition .= ' AND abs(num) >= :minnum';
		$params[':minnum'] = $min;
	}

	$max = intval($_GPC['max']);
	if($max > 0 ) {
		$condition .= ' AND abs(num) <= :maxnum';
		$params[':maxnum'] = $max;
	}
	$user = trim($_GPC['user']);
	if(!empty($user)) {
		$condition .= ' AND (uid IN (SELECT uid FROM '.tablename('mc_members').' WHERE uniacid = :uniacid AND (realname LIKE :username OR uid = :uid OR mobile LIKE :mobile)))';
		$params[':username'] = "%{$user}%";
		$params[':uid'] = intval($user);
		$params[':mobile'] = "%{$user}%";
	}

	$psize = 30;
	$pindex = max(1, intval($_GPC['page']));
	$limit = " ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ", {$psize}";
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_credits_record') . $condition, $params);
	$data = pdo_fetchall('SELECT * FROM ' . tablename('mc_credits_record') . $condition . $limit, $params);
	if(!empty($data)) {
		$uids = array();
		foreach($data as &$da) {
			if(!in_array($da['uid'], $uids)) {
				$uids[] = $da['uid'];
			}
		}
		$uids = implode(',', $uids);
		$users = pdo_fetchall('SELECT mobile,uid,realname FROM ' . tablename('mc_members') . " WHERE uniacid = :uniacid AND uid IN ($uids)", array(':uniacid' => $_W['uniacid']), 'uid');
	}
	$pager = pagination($total, $pindex, $psize);

	if ($_GPC['export'] != '') {
		$exports = pdo_fetchall('SELECT * FROM ' . tablename('mc_credits_record') . $condition . " ORDER BY id DESC", $params);
		if(!empty($exports)) {
			$uids = array();
			foreach($exports as &$da) {
				if(!in_array($da['uid'], $uids)) {
					$uids[] = $da['uid'];
				}
			}
			$uids = implode(',', $uids);
			$users = pdo_fetchall('SELECT mobile,uid,realname FROM ' . tablename('mc_members') . " WHERE uniacid = :uniacid AND uid IN ($uids)", array(':uniacid' => $_W['uniacid']), 'uid');
		}
		
		$html = "\xEF\xBB\xBF";

		
		$filter = array(
			'uid' => '会员编号',
			'name' => '姓名',
			'phone' => '手机',
			'type' => '类型',
			'num' => '数量',
			'createtime' => '操作时间	',
			'remark' => '备注'
		);
		foreach ($filter as $title) {
			$html .= $title . "\t,";
		}
		$html .= "\n";
		foreach ($exports as $k => $v) {
			foreach ($filter as $key => $title) {
				if ($key == 'name') {
					$html .= $users[$v['uid']]['realname']. "\t, ";
				} elseif ($key == 'phone') {
					$html .= $users[$v['uid']]['mobile']. "\t, ";
				}elseif ($key == 'type') {
					if ($v['num'] > 0) {
						$html .= "充值\t, ";
					} else {
						$html .= "消费\t, ";
					}
				}elseif ($key == 'num') {
					$html .= abs($v[$key]). "\t, ";
				}elseif ($key == 'createtime') {
					$html .= date('Y-m-d H:i', $v['createtime']). "\t, ";
				}elseif ($key == 'remark') {
					$html .= cutstr($v['remark'], '30', '...'). "\t, ";
				}else {
					$html .= $v[$key]. "\t, ";
				}
			}
			$html .= "\n";
		}
		
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=全部数据.csv");
		echo $html;
		exit();
	}
}

if($do == 'chart') {
	$today_recharge = floatval(pdo_fetchcolumn('SELECT SUM(num) FROM ' . tablename('mc_credits_record') . ' WHERE uniacid = :uniacid AND credittype = :credittype AND num > 0 AND createtime >= :starttime AND createtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':credittype' => 'credit1', ':starttime' => strtotime(date('Y-m-d')), ':endtime' => TIMESTAMP)));
	$today_consume = floatval(pdo_fetchcolumn('SELECT SUM(num) FROM ' . tablename('mc_credits_record') . ' WHERE uniacid = :uniacid AND credittype = :credittype AND num < 0 AND createtime >= :starttime AND createtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':credittype' => 'credit1', ':starttime' => strtotime(date('Y-m-d')), ':endtime' => TIMESTAMP)));
	$total_recharge = floatval(pdo_fetchcolumn('SELECT SUM(num) FROM ' . tablename('mc_credits_record') . ' WHERE uniacid = :uniacid AND credittype = :credittype AND num > 0 AND createtime >= :starttime AND createtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':credittype' => 'credit1', ':starttime' => $starttime, ':endtime' => $endtime)));
	$total_consume = floatval(pdo_fetchcolumn('SELECT SUM(num) FROM ' . tablename('mc_credits_record') . ' WHERE uniacid = :uniacid AND credittype = :credittype AND num < 0 AND createtime >= :starttime AND createtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':credittype' => 'credit1', ':starttime' => $starttime, ':endtime' => $endtime)));
	if($_W['isajax']) {
		$stat = array();
		for($i = 0; $i < $num; $i++) {
			$time = $i * 86400 + $starttime;
			$key = date('m-d', $time);
			$stat['consume'][$key] = 0;
			$stat['recharge'][$key] = 0;
		}
		$data = pdo_fetchall('SELECT id,num,credittype,createtime,uniacid FROM ' . tablename('mc_credits_record') . ' WHERE uniacid = :uniacid AND credittype = :credittype AND createtime >= :starttime AND createtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':credittype' => 'credit1', ':starttime' => $starttime, ':endtime' => $endtime));

		if(!empty($data)) {
			foreach($data as $da) {
				$key = date('m-d', $da['createtime']);
				if($da['num'] > 0) {
					$stat['recharge'][$key] += $da['num'];
				} else {
					$stat['consume'][$key] += abs($da['num']);
				}
			}
		}

		$out['label'] = array_keys($stat['consume']);
		$out['datasets'] = array('recharge' => array_values($stat['recharge']), 'consume' => array_values($stat['consume']));
		exit(json_encode($out));
	}
}
template('stat/credit1');