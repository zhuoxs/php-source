<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$acid = intval($_GPC['acid']);
$uniacid = intval($_GPC['uniacid']);

$accounts = uni_accounts($uniacid);
$accounts_acids = array_keys($accounts);

$account = account_fetch($acid);
if($acid > 0 && in_array($acid, $accounts_acids)) {
	pdo_update('uni_account', array('name' => $account['name'], 'default_acid' => $acid), array('uniacid' => $uniacid));
	cache_delete("uniaccount:{$uniacid}");
	message('设置默认公众号成功', referer(), 'success');
}
message('公众号不存在或已经删除', referer(), 'error');