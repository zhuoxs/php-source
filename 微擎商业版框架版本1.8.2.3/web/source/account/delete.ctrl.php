<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->func('file');
$uniacid = intval($_GPC['uniacid']);
$acid = intval($_GPC['acid']);
if (!empty($acid) && empty($uniacid)) {
	$account = account_fetch($acid);
	if (empty($account)) {
		message('子公众号不存在或是已经被删除');
	}
	$state = uni_permission($uid, $uniacid);
	if($state != 'founder' && $state != 'manager') {
		message('没有该公众号操作权限！', url('accound/display'), 'error');
	}
	$uniaccount = uni_fetch($account['uniacid']);
	if ($uniaccount['default_acid'] == $acid) {
		message('默认子公众号不能删除');
	}
	pdo_update('account', array('isdeleted' => 1), array('acid' => $acid));
	message('删除子公众号成功！', referer(), 'success');
}
if (!empty($uniacid)) {
	$account = pdo_fetch("SELECT * FROM ".tablename('uni_account')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
	if (empty($account)) {
		message('抱歉，帐号不存在或是已经被删除', url('account/display'), 'error');
	}
	$state = uni_permission($uid, $uniacid);
	if($state != 'founder' && $state != 'manager') {
		message('没有该公众号操作权限！', url('accound/display'), 'error');
	}
	pdo_update('account', array('isdeleted' => 1), array('acid' => $acid));
}
message('公众帐号信息删除成功！', url('account/display'), 'success');