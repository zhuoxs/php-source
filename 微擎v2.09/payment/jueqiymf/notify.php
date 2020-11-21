<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_MOBILE', true);
require '../../framework/bootstrap.inc.php';
load()->app('common');
load()->app('template');

error_reporting(0);

if ($_GPC['orderno']) {
	$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `plid`=:plid and `fee`=:fee';
	$pars = array();
	$pars[':plid'] = $_GPC['tid'];
	$pars[':fee'] = $_GPC['fee'];
	$log = pdo_fetch($sql, $pars);
	
	if(!empty($log) && ($log['status'] == 0)) {
		$tag = array(
			'transaction_id' => $_GPC['orderno']
		);
		$data = array(
			'status' => 1,
			'uniontid' => $_GPC['transId'],
			'openid' => $_GPC['uuid'],
			'tag' => iserializer($tag)
		);
		pdo_update('core_paylog', $data, array('tid' => $log['tid']));
		$site = WeUtility::createModuleSite($log['module']);
		if (!is_error($site)) {
			$method = 'payResult';
			if (method_exists($site, $method)) {
				$ret = array();
				$ret['weid'] = $log['uniacid'];
				$ret['uniacid'] = $log['uniacid'];
				$ret['result'] = 'success';
				$ret['type'] = 'jueqiymf';
				$ret['from'] = 'notify';
				$ret['tid'] = $log['tid'];
				$ret['uniontid'] = $log['uniontid'];
				$ret['transaction_id'] = $_GPC['orderno'];
				$ret['user'] = $log['openid'];
				$ret['fee'] = $log['fee'];
				$ret['tag'] = $tag;
				$ret['is_usecard'] = $log['is_usecard'];
				$ret['card_type'] = $log['card_type'];
				$ret['card_fee'] = $log['card_fee'];
				$ret['card_id'] = $log['card_id'];
				exit($site->$method($ret));
				exit('success'); 
			}
		}
	}
}
exit('fail');