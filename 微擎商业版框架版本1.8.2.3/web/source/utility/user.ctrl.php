<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('user');
$dos = array('browser');
$do = in_array($do, $dos) ? $do: 'browser';

if ($do == 'browser') {
	$mode = empty($_GPC['mode']) ? 'visible' : $_GPC['mode'];
	$mode = in_array($mode, array('invisible','visible')) ? $mode : 'visible';
	
	$callback = $_GPC['callback'];
	
	$uids = $_GPC['uids'];
	$uidArr = array();
	if(empty($uids)){
		$uids='';
	}else{
		foreach (explode(',', $uids) as $uid) {
			$uidArr[] = intval($uid);
		}
		$uids = implode(',', $uidArr);
	}
	$where = " WHERE status = '2' and type != '".ACCOUNT_OPERATE_CLERK."' AND founder_groupid != " . ACCOUNT_MANAGE_GROUP_VICE_FOUNDER;
	if($mode == 'invisible' && !empty($uids)){
		$where .= " AND uid not in ( {$uids} )";
	}
	$params = array();
	if(!empty($_GPC['keyword'])) {
		$where .= ' AND `username` LIKE :username';
		$params[':username'] = "%{$_GPC['keyword']}%";
	}
	if (user_is_vice_founder()) {
		$where .= ' AND `owner_uid` = :owner_uid';
		$params[':owner_uid'] = $_W['uid'];
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$total = 0;

	$list = pdo_fetchall("SELECT uid, groupid, username, remark FROM ".tablename('users')." {$where} ORDER BY `uid` LIMIT ".(($pindex - 1) * $psize).",{$psize}", $params);
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('users'). $where , $params);
	$pager = pagination($total, $pindex, $psize, '', array('ajaxcallback'=>'null','mode'=>$mode,'uids'=>$uids));
	$usergroups = user_group();
	template('utility/user-browser');
	exit;
}