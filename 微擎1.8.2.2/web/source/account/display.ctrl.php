<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

load()->model('miniapp');
load()->model('phoneapp');

$dos = array('rank', 'display', 'switch', 'platform');
$do = in_array($_GPC['do'], $dos) ? $do : 'display';
$_W['page']['title'] = '所有权限';

if ($do == 'platform') {
	$url = url('account/display');
	$last_uniacid = uni_account_last_switch();
	$cache_last_account_type = cache_load(cache_system_key('last_account_type'));
	if (empty($cache_last_account_type) || empty($last_uniacid)) {
		itoast('', $url, 'info');
	}
	if (!empty($last_uniacid) && $last_uniacid != $_W['uniacid']) {
		uni_account_switch($last_uniacid, '', $cache_last_account_type);
	}
	$permission = permission_account_user_role($_W['uid'], $last_uniacid);
	if (empty($permission)) {
		itoast('', $url, 'info');
	}
	if ($cache_last_account_type == ACCOUNT_TYPE_SIGN || $cache_last_account_type == XZAPP_TYPE_SIGN) {
		$url = url('home/welcome');
	} elseif ($cache_last_account_type == WXAPP_TYPE_SIGN) {
		$last_version = miniapp_fetch($last_uniacid);
		if (!empty($last_version)) {
			$url = url('miniapp/version/home', array('version_id' => $last_version['version']['id']));
		}
	} elseif ($cache_last_account_type == WEBAPP_TYPE_SIGN) {
		$url = url('webapp/home/display');
	} elseif ($cache_last_account_type == PHONEAPP_TYPE_SIGN) {
		$last_version = phoneapp_fetch($last_uniacid);
		if (!empty($last_version)) {
			$url = url('phoneapp/version/home', array('version_id' => $last_version['version']['id']));
		}
	} elseif ($cache_last_account_type == ALIAPP_TYPE_SIGN) {
		$last_version = miniapp_fetch($last_uniacid);
		if (!empty($last_version)) {
			$url = url('miniapp/version/home', array('version_id' => $last_version['version']['id']));
		}
	}
	itoast('', $url);
}

if ($do == 'display') {
	$account_info = permission_user_account_num($_W['uid']);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;

	$title = safe_gpc_string($_GPC['title']);
	$type = in_array($_GPC['type'], array('all', ACCOUNT_TYPE_SIGN, WXAPP_TYPE_SIGN, WEBAPP_TYPE_SIGN, PHONEAPP_TYPE_SIGN, XZAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN)) ? $_GPC['type'] : 'all';

	if ($type == 'all') {
		$title = ' 公众号/微信小程序/PC/APP/熊掌号/支付宝小程序 ';
	}

	if ($type == 'all') {
		$condition = array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH, ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH, ACCOUNT_TYPE_WEBAPP_NORMAL, ACCOUNT_TYPE_PHONEAPP_NORMAL, ACCOUNT_TYPE_XZAPP_NORMAL, ACCOUNT_TYPE_ALIAPP_NORMAL);
		$fields = 'a.uniacid,b.type';
	} elseif ($type == ACCOUNT_TYPE_SIGN) {
		$condition = array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH);
	} elseif ($type == WXAPP_TYPE_SIGN) {
		$condition = array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH);
	} elseif ($type == WEBAPP_TYPE_SIGN) {
		$condition = array(ACCOUNT_TYPE_WEBAPP_NORMAL);
	} elseif ($type == PHONEAPP_TYPE_SIGN) {
		$condition = array(ACCOUNT_TYPE_PHONEAPP_NORMAL);
	} elseif ($type == XZAPP_TYPE_SIGN) {
		$condition = array(ACCOUNT_TYPE_XZAPP_NORMAL);
	} elseif ($type == ALIAPP_TYPE_SIGN) {
		$condition = array(ACCOUNT_TYPE_ALIAPP_NORMAL);
	}

	$table = table('account');
	$table->searchWithType($condition);

	$keyword = safe_gpc_string($_GPC['keyword']);
	if (!empty($keyword)) {
		$table->searchWithKeyword($keyword);
	}

	$letter = safe_gpc_string($_GPC['letter']);
	if (isset($letter) && strlen($letter) == 1) {
		$table->searchWithLetter($letter);
	}

	$table->accountRankOrder();
	$table->searchWithPage($pindex, $psize);

	$list = $table->searchAccountListFields($fields);

	$total = $table->getLastQueryTotal();

	$list = array_values($list);
	foreach($list as &$account) {
		$account = uni_fetch($account['uniacid']);
		switch ($account['type']) {
			case ACCOUNT_TYPE_APP_NORMAL :
			case ACCOUNT_TYPE_APP_AUTH :
			case ACCOUNT_TYPE_ALIAPP_NORMAL :
				$account['versions'] = miniapp_get_some_lastversions($account['uniacid']);
				if (!empty($account['versions'])) {
					foreach ($account['versions'] as $version) {
						if (!empty($version['current'])) {
							$account['current_version'] = $version;
						}
					}
				}
				break;
			case ACCOUNT_TYPE_PHONEAPP_NORMAL :
				$account['versions'] = phoneapp_get_some_lastversions($account['uniacid']);
				if (!empty($account['versions'])) {
					foreach ($account['versions'] as $version) {
						if (!empty($version['current'])) {
							$account['current_version'] = $version;
						}
					}
				}
				break;
		}
	}

	if ($_W['ispost']) {
		iajax(0, $list);
	}
	template('account/display');
}

if ($do == 'rank' && $_W['isajax'] && $_W['ispost']) {
	$uniacid = intval($_GPC['uniacid']);
	if (!empty($uniacid)) {
		$exist = uni_fetch($uniacid);
		if (!$exist) {
			iajax(1, '账号信息不存在', '');
		}
	}
	uni_account_rank_top($uniacid);
	iajax(0, '更新成功！', '');
}

if ($do == 'switch') {
	$uniacid = intval($_GPC['uniacid']);
	if (!empty($uniacid)) {
		$role = permission_account_user_role($_W['uid'], $uniacid);
		if(empty($role)) {
			itoast('操作失败, 非法访问.', '', 'error');
		}
		$account_info = uni_fetch($uniacid);
		if ($account_info['endtime'] > 0 && TIMESTAMP > $account_info['endtime'] && !user_is_founder($_W['uid'], true)) {
			itoast('帐号已到期。', '', 'error');
		}
		$type = $account_info['type'];
		$module_name = safe_gpc_string($_GPC['module_name']);
		$version_id = intval($_GPC['version_id']);

		if ($type == ACCOUNT_TYPE_OFFCIAL_NORMAL || $type == ACCOUNT_TYPE_OFFCIAL_AUTH || $type == ACCOUNT_TYPE_XZAPP_NORMAL) {
			if (empty($module_name)) {
				$url = url('home/welcome');
			} else {
				$url = url('home/welcome/ext', array('m' => $module_name, 'version_id' => $version_id));
			}
		}

		if ($type == ACCOUNT_TYPE_WEBAPP_NORMAL) {
			$url = url('webapp/home/display');
		}

		if (in_array($type, array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH, ACCOUNT_TYPE_PHONEAPP_NORMAL, ACCOUNT_TYPE_ALIAPP_NORMAL))) {
			if (empty($version_id)) {
				if ($type == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
					$versions = phoneapp_get_some_lastversions($uniacid);
				} else {
					$versions = miniapp_get_some_lastversions($uniacid);
				}
				foreach ($versions as $val) {
					if ($val['current']) {
						$version_id = $val['id'];
					}
				}
			}

			if (!empty($module_name) && !empty($version_id)) {
				if ($type == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
					$version_info = phoneapp_version($version_id);
				} else {
					$version_info = table('wxapp_versions')->getById($version_id);
				}
				$module_info = array();
				if (!empty($version_info['modules'])) {
					foreach ($version_info['modules'] as $key => $module_val) {
						if ($module_val['name'] == $module_name) {
							$module_info = $module_val;
						}
					}
				}
				if (empty($module_info)) {
					itoast('版本信息错误');
				}
				$url = url('home/welcome/ext/', array('m' => $module_name));
				if (!empty($module_info['uniacid'])) {
					$uniacid = $module_info['uniacid'];
				} else {
					$url .= '&version_id=' . $version_id;
				}
			} elseif (in_array($type, array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH, ACCOUNT_TYPE_ALIAPP_NORMAL))) {
				miniapp_update_last_use_version($uniacid, $version_id);
				$url = url('miniapp/version/home', array('version_id' => $version_id));
			} elseif ($type == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
				phoneapp_update_last_use_version($uniacid, $version_id);
				$url = url('phoneapp/version/home', array('version_id' => $version_id));
			}
		}

		uni_account_switch($uniacid, $url, $account_info['type_sign']);
	}
}
