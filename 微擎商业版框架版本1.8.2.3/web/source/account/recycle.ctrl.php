<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('account');

$dos = array('display', 'recover', 'delete');
$do = in_array($do, $dos) ? $do : 'display';

	if (!in_array($_W['role'], array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_FOUNDER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER))) {
		itoast('无权限操作！', referer(), 'error');
	}


$_W['page']['title'] = $account_typename . '回收站 - ' . $account_typename;

if ($do == 'display') {
	$pindex = max(1, $_GPC['page']);
	$psize = 20;
	$start = ($pindex - 1) * $psize;

	$condition = '';
	$param = array();
	$keyword = trim($_GPC['keyword']);

	$type_condition = array(
		ACCOUNT_TYPE_APP_NORMAL => array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH),
		ACCOUNT_TYPE_OFFCIAL_NORMAL => array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH),
		ACCOUNT_TYPE_OFFCIAL_AUTH => array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH),
		ACCOUNT_TYPE_WEBAPP_NORMAL => array(ACCOUNT_TYPE_WEBAPP_NORMAL),
		ACCOUNT_TYPE_PHONEAPP_NORMAL => array(ACCOUNT_TYPE_PHONEAPP_NORMAL),
		ACCOUNT_TYPE_XZAPP_NORMAL => array(ACCOUNT_TYPE_XZAPP_NORMAL, ACCOUNT_TYPE_XZAPP_AUTH),
		ACCOUNT_TYPE_ALIAPP_NORMAL => array(ACCOUNT_TYPE_ALIAPP_NORMAL),
	);
	$type_condition_sql = "'".implode("','", $type_condition[ACCOUNT_TYPE])."'";

	if (user_is_founder($_W['uid'], true)) {
		$condition .= " WHERE a.acid <> 0 AND b.isdeleted = 1 AND b.type IN ($type_condition_sql)";
		$order_by = " ORDER BY a.`acid` DESC";
	} else {
		$condition .= "LEFT JOIN ". tablename('uni_account_users')." as c ON a.uniacid = c.uniacid WHERE a.acid <> 0 AND c.uid = :uid AND b.isdeleted = 1 AND b.type IN ($type_condition_sql)";
		$param[':uid'] = $_W['uid'];
		$order_by = " ORDER BY c.`rank` DESC, a.`acid` DESC";
	}
	if(!empty($keyword)) {
		$condition .=" AND a.`name` LIKE :name";
		$param[':name'] = "%{$keyword}%";
	}
	$tsql = "SELECT count(*) FROM " .tablename(uni_account_tablename(ACCOUNT_TYPE)) . " AS a LEFT JOIN " . tablename('account') . " AS b ON a.acid = b.acid {$condition} {$order_by}";
	$sql = $sql = "SELECT * FROM ". tablename(uni_account_tablename(ACCOUNT_TYPE)). " as a LEFT JOIN ". tablename('account'). " as b ON a.acid = b.acid  {$condition} {$order_by}, a.`uniacid` DESC LIMIT {$start}, {$psize}";
	$total = pdo_fetchcolumn($tsql, $param);
	$del_accounts = pdo_fetchall($sql, $param);
	if(!empty($del_accounts)) {
		foreach ($del_accounts as &$account) {
			$settings = uni_setting($account['uniacid'], array('notify'));
			if(!empty($settings['notify'])) {
				$account['sms'] = $settings['notify']['sms']['balance'];
			}else {
				$account['sms'] = 0;
			}
			$account['thumb'] = tomedia('headimg_'.$account['acid']. '.jpg').'?time='.time();
			$account['setmeal'] = uni_setmeal($account['uniacid']);
		}
	}
	$pager = pagination($total, $pindex, $psize);
	template('account/recycle');
}

if ($do == 'recover') {
	$acid = intval($_GPC['acid']);
	$uniacid = intval($_GPC['uniacid']);
	$state = permission_account_user_role($_W['uid'], $uniacid);
	if (!in_array($state, array(ACCOUNT_MANAGE_NAME_FOUNDER, ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER))) {
		itoast('没有权限，请联系该公众号的主管理员或网站创始人进行恢复操作！', referer(), 'error');
	}
	$account_info = permission_user_account_num();
	if ($account_info['uniacid_limit'] <= 0 && $_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER) {
		itoast('您所在用户组可添加的主公号数量已达上限，请停用后再行恢复此公众号！', referer(), 'error');
	}
	if (!empty($uniacid)) {
		pdo_update('account', array('isdeleted' => 0), array('uniacid' => $uniacid));
		cache_delete(cache_system_key('uniaccount', array('uniacid' => $uniacid)));
	} else {
		pdo_update('account', array('isdeleted' => 0), array('acid' => $acid));
	}
	itoast('恢复成功', referer(), 'success');
}

if($do == 'delete') {
	if (empty($_W['isajax']) || empty($_W['ispost'])) {
		iajax(0, '非法操作！', referer());
	}
	$uniacid = intval($_GPC['uniacid']);
	$acid = intval($_GPC['acid']);
	$state = permission_account_user_role($_W['uid'], $uniacid);
	
		if (!in_array($state, array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_FOUNDER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER))) {
			itoast('没有权限！', referer(), 'error');
		}
	
	
	$jobid = account_delete($acid);
	iajax(0, '删除成功！', url('system/job/display', array('jobid'=>$jobid)));
}