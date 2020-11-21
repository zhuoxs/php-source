<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->func('file');
load()->model('user');
load()->model('message');
load()->model('miniapp');

$dos = array('display', 'delete', 'account_detailinfo');
$do = in_array($_GPC['do'], $dos) ? $do : 'display';

$account_info = permission_user_account_num();

if ($do == 'display') {
	$message_id = intval($_GPC['message_id']);
	message_notice_read($message_id);

	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;

	$account_table = table('account');

	$account_type = $_GPC['account_type'];
	if (!empty($account_type) && in_array($account_type, array_keys($account_all_type_sign))) {
		$account_type = $account_all_type_sign[$account_type]['contain_type'];
		$account_table->searchWithType($account_type);
	}

	$order = safe_gpc_string($_GPC['order']);
	$account_table->accountUniacidOrder($order);


	$keyword = safe_gpc_string($_GPC['keyword']);
	if (!empty($keyword)) {
		$account_table->searchWithKeyword($keyword);
	}
	$account_table->searchWithPage($pindex, $psize);

	if (in_array(safe_gpc_string($_GPC['type']), array('expire', 'unexpire'))) {
		$expire_type = safe_gpc_string($_GPC['type']);
	}
	$list = $account_table->searchAccountList($expire_type);

		if (user_is_vice_founder($_W['uid'])) {
		$founder_own_users_table = table('users_founder_own_users');
		$users_uids = $founder_own_users_table->getFounderOwnUsersList($_W['uid']);
		$users_accounts = table('uni_account_users')->getOwnedAccountsByUid(array_keys($users_uids));
		if (!empty($users_accounts)) {
			foreach ($users_accounts as $user_account_kye => $user_account_info) {
				if (in_array($user_account_kye, array_keys($list))) {
					unset($users_accounts[$user_account_kye]);
				}
			}
		}
		$list = array_merge($list,$users_accounts);
	}

	foreach ($account_all_type_sign as $type_sign => $type_value) {
		$type = $type_sign == 'account' ? 'app' : $type_sign;
		$type_accounts = uni_user_accounts($_W['uid'], $type);
		if (!empty($type_accounts)) {
			$account_all_type_sign[$type_sign]['account_num'] = count($type_accounts);
		}
	}

	$list = array_values($list);
	$total = $account_table->getLastQueryTotal();
	$pager = pagination($total, $pindex, $psize);
	template('account/manage-display');
}

if ($do == 'account_detailinfo') {
	$uniacids = safe_gpc_array($_GPC['uniacids']);
	if (empty($uniacids)) {
		return array();
	}
	$account_detailinfo = array();
	foreach ($uniacids as $uniacid_value) {
		$uniacid = intval($uniacid_value['uniacid']);
		if ($uniacid <= 0) {
			continue;
		}
		$account = uni_fetch($uniacid);
		$account['owner_name'] = $account->owner['username'];
		$account['support_version'] = $account->supportVersion;
		$account['sms_num'] = !empty($account['setting']['notify']) ? $account['setting']['notify']['sms']['balance'] : 0;
		$account['end'] = $account['endtime'] == 0 ? '永久' : date('Y-m-d', $account['endtime']);
		$account['manage_premission'] = in_array($account['current_user_role'], array(ACCOUNT_MANAGE_NAME_FOUNDER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER, ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_MANAGER));
		if ($account['support_version']) {
			$account['versions'] = miniapp_get_some_lastversions($uniacid);
			if (!empty($account['versions'])) {
				foreach ($account['versions'] as $version) {
					if (!empty($version['current'])) {
						$account['current_version'] = $version;
					}
				}
			}
		}
		$account_detailinfo[] = $account;
	}
	iajax(0, $account_detailinfo);
}

if ($do == 'delete') {
	if (!empty($_GPC['uniacids'])) {
		foreach ($_GPC['uniacids'] as $uniacid) {
			$uniacid = intval($uniacid);
			$state = permission_account_user_role($_W['uid'], $uniacid);
			if (!in_array($state, array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_FOUNDER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER))) {
				continue;
			}

			if (!empty($uniacid)) {
				$account = pdo_get('uni_account', array('uniacid' => $uniacid));
				if (empty($account)) {
					continue;
				}

				pdo_update('account', array('isdeleted' => 1), array('uniacid' => $uniacid));
				pdo_delete('uni_modules', array('uniacid' => $uniacid));
				pdo_delete('users_lastuse', array('uniacid' => $uniacid));
				pdo_delete('core_menu_shortcut', array('uniacid' => $uniacid));
				if($uniacid == $_W['uniacid']) {
					cache_delete(cache_system_key('last_account', array('switch' => $_GPC['__switch'], 'uid' => $_W['uid'])));
					isetcookie('__uniacid', '');
				}
				cache_delete(cache_system_key('uniaccount', array('uniacid' => $uniacid)));
			}
		}
	}
	iajax(0, '停用成功！，您可以在回收站中恢复', url('account/manage'));
}
