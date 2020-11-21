<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');
set_time_limit(60);

load()->model('mc');

$dos = array('display', 'add_tag', 'del_tag', 'edit_tagname', 'edit_fans_tag', 'batch_edit_fans_tag', 'download_fans', 'sync', 'fans_sync_set', 'register');
$do = in_array($do, $dos) ? $do : 'display';

if ($do == 'display') {
	$_W['page']['title'] = '粉丝列表';
	$fans_tag = mc_fans_groups(true);
	$pageindex = max(1, intval($_GPC['page']));
	$search_mod = intval($_GPC['search_mod']) == '' ? 1 : intval($_GPC['search_mod']);
	$pagesize = 10;

	$param = array(
		':uniacid' => $_W['uniacid'],
		':acid' => $_W['acid']
		);
	$condition = " WHERE f.`uniacid` = :uniacid AND f.`acid` = :acid";
	$tag = intval($_GPC['tag']) ? intval($_GPC['tag']) : 0;
	if (!empty($tag)) {
		$param[':tagid'] = $tag;
		$condition .= " AND m.`tagid` = :tagid";
	}
	if ($_GPC['type'] == 'bind') {
		$condition .= " AND f.`uid` > 0";
		$type = 'bind';
	}
	$nickname = $_GPC['nickname'] ? addslashes(trim($_GPC['nickname'])) : '';
	if (!empty($nickname)) {
		if ($search_mod == 1) {
			$condition .= " AND ((f.`nickname` = :nickname) OR (f.`openid` = :openid))";
			$param[':nickname'] = $nickname;
			$param[':openid'] = $nickname;
		} else {
			$condition .= " AND ((f.`nickname` LIKE :nickname) OR (f.`openid` LIKE :openid))";
			$param[':nickname'] = "%" . $nickname . "%";
			$param[':openid'] = "%" . $nickname . "%";
		}
	}

	$follow = intval($_GPC['follow']) ? intval($_GPC['follow']) : 1;
	if ($follow == 1) {
		$condition .= " AND f.`follow` = 1";
	} elseif ($follow == 2) {
		$condition .= " AND f.`follow` = 0";
	}
	$select_sql = "SELECT %s FROM " .tablename('mc_mapping_fans')." AS f LEFT JOIN ".tablename('mc_fans_tag_mapping')." AS m ON m.`fanid` = f.`fanid` " . $condition ." %s";
	$fans_list_sql = sprintf($select_sql, "f.fanid, f.acid, f.uniacid, f.uid, f.openid, f.nickname, f.groupid, f.follow, f.followtime, f.unfollowtime, f.tag ", " GROUP BY f.`fanid` ORDER BY f.`fanid` DESC LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize);
	$fans_list = pdo_fetchall($fans_list_sql, $param);
	if (!empty($fans_list)) {
		foreach ($fans_list as &$v) {
			$v['tag_show'] = mc_show_tag($v['groupid']);
			$v['tag_show'] = explode(',', $v['tag_show']);
			$v['groupid'] = trim($v['groupid'], ',');
			if (!empty($v['uid'])) {
				$user = mc_fetch($v['uid'], array('realname', 'nickname', 'mobile', 'email', 'avatar'));
			}
			if (!empty($user)) {
				$v['member'] = $user;
			}
			if (!empty($v['tag']) && is_string($v['tag'])) {
				if (is_base64($v['tag'])) {
					$v['tag'] = base64_decode($v['tag']);
				}
								if (is_serialized($v['tag'])) {
					$v['tag'] = @iunserializer($v['tag']);
				}
				if (!empty($v['tag']['headimgurl'])) {
					$v['tag']['avatar'] = tomedia($v['tag']['headimgurl']);
				}
				if (empty($v['nickname']) && !empty($v['tag']['nickname'])) {
					$v['nickname'] = strip_emoji($v['tag']['nickname']);
				}
			}
			if (empty($v['tag'])) {
				$v['tag'] = array();
			}
			if (empty($v['user']['nickname']) && !empty($v['tag']['nickname'])) {
				$v['user']['nickname'] = strip_emoji($v['tag']['nickname']);
			}
			if (empty($v['user']['avatar']) && !empty($v['tag']['avatar'])) {
				$v['user']['avatar'] = $v['tag']['avatar'];
			}
			unset($user,$niemmo,$niemmo_effective);
		}
		unset($v);
	}

	$total_sql = sprintf($select_sql, "COUNT(DISTINCT f.`fanid`) ", '');
	$total = pdo_fetchcolumn($total_sql, $param);
	$pager = pagination($total, $pageindex, $pagesize);
	$fans['total'] = pdo_getcolumn("mc_mapping_fans", array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid'], 'follow' => 1), 'count(*)');
}

if ($do == 'add_tag') {
	$tag_name = trim($_GPC['tag']);
	if (empty($tag_name)) {
		iajax(1, '请填写标称名称', '');
	}
	$account_api = WeAccount::create();
	$result = $account_api->fansTagAdd($tag_name);
	if (is_error($result)) {
		iajax(1, $result);
	} else {
		iajax(0, '');
	}
}

if ($do == 'del_tag') {
	$tagid = intval($_GPC['tag']);
	if (empty($tagid)) {
		iajax(1, '标签id为空', '');
	}
	$account_api = WeAccount::create();
	$tags = $account_api->fansTagDelete($tagid);

	if (!is_error($tags)) {
		$fans_list = pdo_getall('mc_mapping_fans', array('groupid LIKE' => "%,{$tagid},%"));
		$count = count($fans_list);
		if (!empty($count)) {
			$buffSize = ceil($count / 500);
			for ($i = 0; $i < $buffSize; $i++) {
				$sql = '';
				$wechat_fans = array_slice($fans_list, $i * 500, 500);
				foreach ($wechat_fans as $fans) {
					$tagids = trim(str_replace(','.$tagid.',', ',', $fans['groupid']), ',');
					if ($tagids == ',') {
						$tagids = '';
					}
					$sql .= 'UPDATE ' . tablename('mc_mapping_fans') . " SET `groupid`='" . $tagids . "' WHERE `fanid`={$fans['fanid']};";
				}
				pdo_query($sql); 					}
		}
		pdo_delete('mc_fans_tag_mapping', array('tagid' => $tagid));
		iajax(0, 'success', '');
	} else {
		iajax(-1, $tags['message'], '');
	}
}

if ($do == 'edit_tagname') {
	$tag = intval($_GPC['tag']);
	if (empty($tag)) {
		iajax(1, '标签id为空', '');
	}
	$tag_name = trim($_GPC['tag_name']);
	if (empty($tag_name)) {
		iajax(1, '标签名为空', '');
	}

	$account_api = WeAccount::create();
	$result = $account_api->fansTagEdit($tag, $tag_name);
	if (is_error($result)) {
		iajax(1, $result);
	} else {
		iajax(0, '');
	}
}

if ($do == 'edit_fans_tag') {
	$fanid = intval($_GPC['fanid']);
	$tags = $_GPC['tags'];

	$openid = pdo_getcolumn('mc_mapping_fans', array('uniacid' => $_W['uniacid'], 'fanid' => $fanid), 'openid');
	$account_api = WeAccount::create();
	if (empty($tags) || !is_array($tags)) {
		$fans_tags =pdo_getall('mc_fans_tag_mapping', array('fanid' => $fanid), array(), 'tagid');
		if (!empty($fans_tags)) {
			foreach ($fans_tags as $tag) {
				$result = $account_api->fansTagBatchUntagging(array($openid), $tag['tagid']);
			}
		} else {
			iajax(0);
		}
	} else {
		$result = $account_api->fansTagTagging($openid, $tags);
	}

	if (!is_error($result)) {
		pdo_delete('mc_fans_tag_mapping', array('fanid' => $fanid));
		if (!empty($tags)) {
			foreach ($tags as $tag) {
				pdo_insert('mc_fans_tag_mapping', array('fanid' => $fanid, 'tagid' => $tag));
			}
			$tags = implode(',', $tags);
		}
		pdo_update('mc_mapping_fans', array('groupid' => $tags), array('fanid' => $fanid));
	}
	iajax(0, $result);
}

if ($do == 'batch_edit_fans_tag') {
	$openid_list = $_GPC['openid'];
	if (empty($openid_list) || !is_array($openid_list)) {
		iajax(1, '请选择粉丝', '');
	}
	$tags = $_GPC['tag'];
	if (empty($tags) || !is_array($tags)) {
		iajax(1, '请选择标签', '');
	}

	$account_api = WeAccount::create();
	foreach ($tags as $tag) {
		$result = $account_api->fansTagBatchTagging($openid_list, $tag);
		if (is_error($result)) {
			iajax(-1, $result);
		}
		foreach ($openid_list as $openid) {
			$fan_info = pdo_get('mc_mapping_fans', array('uniacid' => $_W['uniacid'], 'openid' => $openid));
			pdo_insert('mc_fans_tag_mapping', array('fanid' => $fan_info['fanid'], 'tagid' => $tag), true);
			$groupid = $fan_info['group'].",".$tag;
			pdo_update('mc_mapping_fans', array('groupid' => $groupid), array('uniacid' => $_W['uniacid'], 'openid' => $openid));
		}
	}
	iajax(0, '');
}

if ($do == 'download_fans') {
	$next_openid = $_GPC['next_openid'];
	if (empty($next_openid)) {
		pdo_update('mc_mapping_fans', array('follow' => 0), array('uniacid' => $_W['uniacid']));
	}
	$account_api = WeAccount::create();
	$wechat_fans_list = $account_api->fansAll();

		if (!empty($account_api->same_account_exist)) {
		pdo_update('mc_mapping_fans', array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid']), array('uniacid' => array_keys($account_api->same_account_exist)));
	}

	if (!is_error($wechat_fans_list)) {
		$wechat_fans_count = count($wechat_fans_list['fans']);
		$total_page = ceil($wechat_fans_count / 500);
		for ($i = 0; $i < $total_page; $i++) {
			$wechat_fans = array_slice($wechat_fans_list['fans'], $i * 500, 500);
			$system_fans = pdo_getall('mc_mapping_fans', array('openid' => $wechat_fans), array(), 'openid');
			$add_fans_sql = '';
			foreach($wechat_fans as $openid) {
				if (empty($system_fans) || empty($system_fans[$openid])) {
					$salt = random(8);
					$add_fans_sql .= "('{$_W['acid']}', '{$_W['uniacid']}', 0, '{$openid}', '{$salt}', 1, 0, ''),";
				}
			}
			if (!empty($add_fans_sql)) {
				$add_fans_sql = rtrim($add_fans_sql, ',');
				$add_fans_sql = "INSERT INTO " . tablename('mc_mapping_fans') . " (`acid`, `uniacid`, `uid`, `openid`, `salt`, `follow`, `followtime`, `tag`) VALUES " . $add_fans_sql;
				$result = pdo_query($add_fans_sql);
			}
			pdo_update('mc_mapping_fans', array('follow' => 1, 'uniacid' => $_W['uniacid'], 'acid' => $_W['acid']), array('openid' => $wechat_fans));
		}
		$return['total'] = $wechat_fans_list['total'];
		$return['count'] = !empty($wechat_fans_list['fans']) ? $wechat_fans_count : 0;
		$return['next'] = $wechat_fans_list['next'];
		iajax(0, $return, '');
	} else {
		iajax(1, $wechat_fans_list['message']);
	}
}

if ($do == 'sync') {
	$type = $_GPC['type'] == 'all' ? 'all' : 'check';
	$sync_member = intval($_GPC['sync_member']);
	$force_init_member = empty($sync_member) ? false : true;

	if ($type == 'all') {
		$pageindex = $_GPC['pageindex'];
		$pageindex++;
		$sync_fans = pdo_getslice('mc_mapping_fans', array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid'], 'follow' => '1'), array($pageindex, 100), $total, array(), 'openid', 'fanid DESC');
		$total = ceil($total/100);
		$start = time();
		if (!empty($sync_fans)) {
			mc_init_fans_info(array_keys($sync_fans), $force_init_member);
		}
		if ($total == $pageindex) {
			setcookie(cache_system_key('sync_fans_pindex', array('uniacid' => $_W['uniacid'])), '', -1);
		} else {
			setcookie(cache_system_key('sync_fans_pindex', array('uniacid' => $_W['uniacid'])), $pageindex);
		}
		iajax(0, array('pageindex' => $pageindex, 'total' => $total), '');
	}
	if ($type == 'check') {
		$openids = $_GPC['openids'];
		if (empty($openids) || !is_array($openids)) {
			iajax(1, '请选择粉丝', '');
		}
		$sync_fans = pdo_getall('mc_mapping_fans', array('openid' => $openids));
		if (!empty($sync_fans)) {
			foreach ($sync_fans as $fans) {
				mc_init_fans_info($fans['openid'], $force_init_member);
			}
		}
		iajax(0, 'success', '');
	}
}

if ($do == 'fans_sync_set') {
	$_W['page']['title'] = '更新粉丝信息 - 公众号选项';
	$operate = $_GPC['operate'];
	if ($operate == 'save_setting') {
		uni_setting_save('sync', intval($_GPC['setting']));
		iajax(0, '');
	}
	$setting = uni_setting($_W['uniacid'], array('sync'));
	$sync_setting = $setting['sync'];
}

if ($do == 'register') {
	$open_id = trim($_GPC['openid']);
	$password = trim($_GPC['password']);
	$repassword = trim($_GPC['repassword']);
	if (empty($open_id) || empty($password) || empty($repassword)) {
		iajax('-1', '参数错误', url('mc/fans/display'));
	}
	if ($password != $repassword) {
		iajax('-1', '密码不一致', url('mc/fans/display'));
	}
	$member_info = mc_init_fans_info($open_id, true);
	$member_salt = pdo_getcolumn('mc_members', array('uid' => $member_info['uid']), 'salt');
	$password = md5($password . $member_salt . $_W['config']['setting']['authkey']);
	pdo_update('mc_members', array('password' => $password), array('uid' => $uid));
	iajax('0', '注册成功', url('mc/member/base_information', array('uid' => $member_info['uid'])));
}
template('mc/fans');

