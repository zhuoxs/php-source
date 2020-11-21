<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$ret = array();
if(empty($_GPC['module']) || empty($_GPC['sign']) || empty($_W['uniacid']) || empty($_GPC['action'])) {
	return false;
}

$name = trim($_GPC['module']);
$site = WeUtility::createModuleSite($name);
$return = $site->creditOperate($_GPC['sign'], $_GPC['action']);

if(empty($return)) {
	return false;
} elseif(empty($return['credit_total'])) {
	$ret['result'] = 'total-miss';
	moduleInit($_GPC['module'], $ret);
}

$ret = array();
$total = pdo_fetchcolumn('SELECT SUM(credit_value) FROM ' . tablename('mc_handsel') . ' WHERE uniacid = :uniacid AND module = :module AND sign = :sign', array(':uniacid' => $_W['uniacid'], ':module' => $_GPC['module'], ':sign' => $_GPC['sign']));
$credit_total = intval($return['credit_total']);
if($total >= $credit_total) {
	$ret['result'] = 'total-limit';
	moduleInit($_GPC['module'], $ret);
}

if(empty($_GPC['tuid'])) {
	$ret['result'] = 'tuid-miss';
	moduleInit($_GPC['module'], $ret);
} else {
	$tuid = intval($_GPC['tuid']);
	$user = pdo_fetchcolumn('SELECT uid FROM ' . tablename('mc_members'). ' WHERE uniacid = :uniacid AND uid = :uid', array(':uniacid' => $_W['uniacid'], ':uid' => $tuid));
	if(empty($user)) {
		$ret['result'] = 'tuid-error';
		moduleInit($_GPC['module'], $ret);
	}
}

if(empty($_GPC['fuid'])) {
	$fuid = $_W['member']['uid'];
} else {
	$fuid = intval($_GPC['fuid']);
	$user = pdo_fetchcolumn('SELECT uid FROM ' . tablename('mc_members'). ' WHERE uniacid = :uniacid AND uid = :uid', array(':uniacid' => $_W['uniacid'], ':uid' => $fuid));
	if(empty($user)) {
		$ret['result'] = 'fuid-error';
		moduleInit($_GPC['module'], $ret);
	}
}


if(!empty($_GPC['action'])) {
	$sql = 'SELECT id FROM ' . tablename('mc_handsel') . ' WHERE uniacid = :uniacid AND touid = :touid AND fromuid = :fromuid AND module = :module AND sign = :sign AND action = :action';
	$parm = array(':uniacid' => $_W['uniacid'], ':touid' => $tuid, ':fromuid' => $fuid, ':module' => $_GPC['module'], ':sign' => $_GPC['sign'], ':action' => $_GPC['action']);
	$is_add = pdo_fetchcolumn($sql, $parm);
	if(empty($is_add)) {
		$creditbehaviors = pdo_fetchcolumn('SELECT creditbehaviors FROM ' . tablename('uni_settings') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
		$creditbehaviors = iunserializer($creditbehaviors) ? iunserializer($creditbehaviors) : array();
		if(empty($creditbehaviors['activity'])) {
			$ret['result'] = 'creditset-miss';
			moduleInit($_GPC['module'], $ret);
		} else {
			$credittype = $creditbehaviors['activity'];
		}

		$data = array(
			'uniacid' => $_W['uniacid'],
			'touid' => $tuid,
			'fromuid' => $fuid,
			'module' => $_GPC['module'],
			'sign' => $_GPC['sign'],
			'action' => $_GPC['action'],
			'credit_value' => intval($return['credit_value']),
			'createtime' => TIMESTAMP
		);
		pdo_insert('mc_handsel', $data);
		$note = empty($_GPC['note']) ? '系统赠送积分' : $_GPC['note'];
		$log = array(
			'uid' => $tuid,
			'credittype' => $credittype,
			'uniacid' => $_W['uniacid'],
			'num' => intval($return['credit_value']),
			'createtime' => TIMESTAMP,
			'operator' => 0,
			'remark' => $note
		);
		$credit_value = intval($return['credit_value']);
		mc_credit_update($uid, $credittype, $credit_value, $log);
		$ret['result'] = 'success';
		moduleInit($_GPC['module'], $ret);
	} else {
		$ret['result'] = 'repeat';
		moduleInit($_GPC['module'], $ret);
	}
} else {
	$ret['result'] = 'action-miss';
	moduleInit($_GPC['module'], $ret);
}



function moduleInit($name, $params = array()) {
	if(empty($name)) {
		return false;
	}
	$site = WeUtility::createModuleSite($name);
	if(!is_error($site)) {
		$method = 'clickResult';
		if(method_exists($site, $method)) {
			$site->$method($params);
			exit('success');
		}
		exit();
	}
	exit();
}


