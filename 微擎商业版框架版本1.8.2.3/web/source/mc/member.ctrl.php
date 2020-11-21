<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('mc');

$dos = array('address', 'base_information', 'member_credits', 'credit_statistics', 'display','del', 'add', 'group', 'register_setting', 'credit_setting', 'save_credit_setting', 'save_tactics_setting');
$do = in_array($do, $dos) ? $do : 'display';

$creditnames = uni_setting_load('creditnames');
$creditnames = $creditnames['creditnames'];

if ($do == 'save_tactics_setting') {
	$setting = $_GPC['setting'];
	if (empty($setting)) {
		iajax(1, '不可为空！');
	}
	uni_setting_save('creditbehaviors', $setting);
	iajax(0, '设置成功！', referer());
}

if ($do == 'save_credit_setting') {
	$credit_setting = $_GPC['credit_setting'];
	if (empty($credit_setting)) {
		iajax(1, '不可为空');
	}
	uni_setting_save('creditnames', $credit_setting);
	iajax(0, '设置成功！', referer());
}

if ($do == 'register_setting') {
	$_W['page']['title'] = '注册设置';
	if (checksubmit('submit')) {
		$passport = $_GPC['passport'];
		if (!empty($passport)) {
			uni_setting_save('passport', $passport);
			itoast('设置成功', '', 'success');
		}
	}
	$setting = uni_setting_load('passport');
	$register_setting = !empty($setting['passport']) ? $setting['passport'] : array();
	template('mc/member');
}

if ($do == 'credit_setting') {
	$_W['page']['title'] = '积分设置';
	$credit_setting = uni_setting_load('creditnames');
	$credit_setting = $credit_setting['creditnames'];

	$credit_tactics = uni_setting_load('creditbehaviors');
	$credit_tactics = empty($credit_tactics['creditbehaviors']) ? array() : $credit_tactics['creditbehaviors'];

	$enable_credit = array();
	if (!empty($credit_setting)) {
		foreach ($credit_setting as $key => $credit) {
			if ($credit['enabled'] == 1) {
				$enable_credit[] = $key;
			}
		}
		unset($credit);
	}
	template('mc/member');
}

if($do == 'display') {
	$_W['page']['title'] = '会员列表';
	$groups = mc_groups();
	$search_mod = intval($_GPC['search_mod']) == 1 ? '1' : '2';
	$pindex = max(1, intval($_GPC['page']));
	$psize = 25;

	$condition = '';
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($_GPC['username'])) {
		if ($search_mod == 1) {
			$condition .= " AND ((`uid` = :openid) OR (`realname` = :realname) OR (`nickname` = :nickname) OR (`mobile` = :mobile))";
			$params[':realname'] = $params[':nickname'] = $params[':mobile'] = trim($_GPC['username']);
			if (!is_numeric(trim($_GPC['username']))) {
				$uid = pdo_getcolumn('mc_mapping_fans', array('openid' => trim($_GPC['username'])), 'uid');
				$params[':openid'] = empty($uid) ? "" : $uid;
			} else {
				$params[':openid'] =  trim($_GPC['username']);
			}
		} else {
			$condition .= " AND ((`uid` = :openid) OR (`realname` LIKE :realname) OR (`nickname` LIKE :nickname) OR (`mobile` LIKE :mobile))";
			$params[':realname'] = $params[':nickname'] = $params[':mobile'] = '%' . trim($_GPC['username']) . '%';
			if (!is_numeric(trim($_GPC['username']))) {
				$uid = pdo_getcolumn('mc_mapping_fans', array('openid' => trim($_GPC['username'])), 'uid');
				$params[':openid'] = empty($uid) ? "" : $uid;
			} else {
				$params[':openid'] = $_GPC['username'];
			}
		}
	}
	if (!empty($_GPC['datelimit'])) {
		$starttime = strtotime($_GPC['datelimit']['start']);
		$endtime = strtotime($_GPC['datelimit']['end']) + 86399;
		$condition .= " AND createtime > :start AND createtime < :end";
		$params[':start'] = $starttime;
		$params[':end'] = $endtime;
	}
	if (intval($_GPC['groupid']) > 0) {
		$condition .= " AND `groupid` = :groupid";
		$params[':groupid'] = intval($_GPC['groupid']);
	}
	if(checksubmit('export_submit', true)) {
		$account_member_fields = uni_account_member_fields($_W['uniacid']);
		$available_fields = array();
		foreach($account_member_fields as $key => $val) {
			if ($val['available']) {
				$available_fields[$val['field']] = $val['title'];
			}
		}

		$keys = array_keys($available_fields);
		$keys = implode(',', $keys);
		$sql = "SELECT " . $keys . " FROM". tablename('mc_members') . " WHERE uniacid = :uniacid " . $condition;

		$members = pdo_fetchall($sql, $params);
		$html = mc_member_export_parse($members, $available_fields);
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=会员数据.csv");
		echo $html;
		exit();
	}
	$sql = "SELECT uid, uniacid, groupid, realname, nickname, email, mobile, credit1, credit2, credit6, createtime  FROM ".tablename('mc_members')." WHERE uniacid = :uniacid ".$condition." ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
	$list = pdo_fetchall($sql, $params);
	if(!empty($list)) {
		foreach($list as &$li) {
			if(empty($li['email']) || (!empty($li['email']) && substr($li['email'], -6) == 'we7.cc' && strlen($li['email']) == 39)) {
				$li['email_effective'] = 0;
			} else {
				$li['email_effective'] = 1;
			}
		}
	}
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('mc_members')." WHERE uniacid = :uniacid ".$condition, $params);
	$pager = pagination($total, $pindex, $psize);
	$stat['total'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_members') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
	$stat['today'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_members') . ' WHERE uniacid = :uniacid AND createtime >= :starttime AND createtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => strtotime('today'), ':endtime' => strtotime('today') + 86399));
	$stat['yesterday'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_members') . ' WHERE uniacid = :uniacid AND createtime >= :starttime AND createtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => strtotime('today')-86399, ':endtime' => strtotime('today')));
	template('mc/member');
}

if($do == 'del') {
	if(!empty($_GPC['uid'])) {
		if (is_array($_GPC['uid'])) {
			$delete_uids = array();
			foreach ($_GPC['uid'] as $uid) {
				$uid = intval($uid);
				if (!empty($uid)) {
					$delete_uids[] = intval($uid);
				}
			}
		} else {
			$delete_uids = $_GPC['uid'];
		}
		if (!empty($delete_uids)) {
			$tables = array('mc_members', 'mc_card_members', 'mc_card_notices', 'mc_card_notices_unread', 'mc_card_record', 'mc_card_sign_record', 'mc_cash_record', 'mc_credits_recharge', 'mc_credits_record', 'mc_member_address', 'mc_mapping_ucenter');
			foreach ($tables as $key => $value) {
				pdo_delete($value, array('uniacid' => $_W['uniacid'], 'uid' => $delete_uids));
			}
			pdo_update('mc_mapping_fans', array('uid' => 0), array('uid' => $delete_uids, 'uniacid' => $_W['uniacid']));
			itoast('删除成功！', referer(), 'success');
		}
		itoast('请选择要删除的项目！', referer(), 'error');
	}
}

if($do == 'add') {
	if($_W['isajax']) {
		$type = trim($_GPC['type']);
		$type_list = array('mobile', 'email');
		$data = trim($_GPC['data']);
		if(empty($data) || empty($type) || !in_array($type, $type_list)) {
			exit(json_encode(array('valid' => false)));
		}
		$user = pdo_get('mc_members', array('uniacid' => $_W['uniacid'], $type => $data));
		if(empty($user)) {
			exit(json_encode(array('valid' => true)));
		} else {
			exit(json_encode(array('valid' => false)));
		}
	}
	if(checksubmit('form')) {
		$realname = trim($_GPC['realname']) ? trim($_GPC['realname']) : itoast('姓名不能为空', '', '');
		$mobile = trim($_GPC['mobile']) ? trim($_GPC['mobile']) : itoast('手机不能为空', '', '');
		$user = pdo_get('mc_members', array('uniacid' => $_W['uniacid'], 'mobile' => $mobile));
		if(!empty($user)) {
			itoast('手机号被占用', '', '');
		}
		$email = trim($_GPC['email']);
		if(!empty($email)) {
			$user = pdo_get('mc_members', array('uniacid' => $_W['uniacid'], 'email' => $email));
			if(!empty($user)) {
				itoast('邮箱被占用', '', '');
			}
		}
		$salt = random(8);
		$data = array(
			'uniacid' => $_W['uniacid'],
			'realname' => $realname,
			'mobile' => $mobile,
			'email' => $email,
			'salt' => $salt,
			'password' => md5(trim($_GPC['password']) . $salt . $_W['config']['setting']['authkey']),
			'credit1' => intval($_GPC['credit1']),
			'credit2' => intval($_GPC['credit2']),
			'groupid' => intval($_GPC['groupid']),
			'createtime' => TIMESTAMP,
		);
		pdo_insert('mc_members', $data);
		$uid = pdo_insertid();
		itoast('添加会员成功,将进入编辑页面', url('mc/member/post', array('uid' => $uid)), 'success');
	}
	template('mc/member-add');
}

if($do == 'group') {
	if($_W['isajax']) {
		$id = intval($_GPC['id']);
		$group = $_W['account']['groups'][$id];
		if(empty($group)) {
			exit('会员组信息不存在');
		}
		$uid = intval($_GPC['uid']);
		$member = mc_fetch($uid);
		if(empty($member)) {
			exit('会员信息不存在');
		}
		$credit = intval($group['credit']);
		$credit6 = $credit - $member['credit1'];
		$status_update_groupid = mc_update($uid, array('groupid' => $id));
		$status_update_credit6 = mc_credit_update($uid, 'credit6', $credit6);
		if($status_update_groupid && !is_error($status_update_credit6)) {
			$openid = pdo_fetchcolumn('SELECT openid FROM ' . tablename('mc_mapping_fans') . ' WHERE acid = :acid AND uid = :uid', array(':acid' => $_W['acid'], ':uid' => $uid));
			if(!empty($openid)) {
				mc_notice_group($openid, $_W['account']['groups'][$member['groupid']]['title'], $_W['account']['groups'][$id]['title']);
			}
			exit('success');
		} else {
			exit('更新会员信息出错');
		}
	}
	exit('error');
}

if ($do == 'credit_statistics') {
	$_W['page']['title'] = '积分日志-会员管理';
	$uid = intval($_GPC['uid']);
	$credits = array(
			'credit1' => $creditnames['credit1']['title'],
			'credit2' => $creditnames['credit2']['title']
	);
	$type = intval($_GPC['type']);
	$starttime = strtotime('-7 day');
	$endtime = strtotime('7 day');
	if($type == 1) {
		$starttime = strtotime(date('Y-m-d'));
		$endtime = TIMESTAMP;
	} elseif($type == -1) {
		$starttime = strtotime('-1 day');
		$endtime = strtotime(date('Y-m-d'));
	} else{
		$starttime = strtotime($_GPC['datelimit']['start']);
		$endtime = strtotime($_GPC['datelimit']['end']) + 86399;
	}
	if(!empty($credits)) {
		$data = array();
		foreach($credits as $key => $li) {
			$data[$key]['add'] = round(pdo_fetchcolumn('SELECT SUM(num) FROM ' . tablename('mc_credits_record') . ' WHERE uniacid = :id AND uid = :uid AND createtime > :start AND createtime < :end AND credittype = :type AND num > 0', array(':id' => $_W['uniacid'], ':uid' => $uid, ':start' => $starttime, ':end' => $endtime, ':type' => $key)),2);
			$data[$key]['del'] = abs(round(pdo_fetchcolumn('SELECT SUM(num) FROM ' . tablename('mc_credits_record') . ' WHERE uniacid = :id AND uid = :uid AND createtime > :start AND createtime < :end AND credittype = :type AND num < 0', array(':id' => $_W['uniacid'], ':uid' => $uid, ':start' => $starttime, ':end' => $endtime, ':type' => $key)),2));
			$data[$key]['end'] = $data[$key]['add'] - $data[$key]['del'];
		}
	}

	template('mc/member-information');
}

if($do == 'member_credits') {
	$_W['page']['title'] = '编辑会员资料 - 会员 - 会员中心';
	$uid = intval($_GPC['uid']);
	$credits = mc_credit_fetch($uid, array('credit1', 'credit2'));
		$type = trim($_GPC['type']) ? trim($_GPC['type']) : 'credit1';
	$pindex = max(1, intval($_GPC['page']));
	$psize = 50;

	$member_table = table('member');

	$member_table->searchCreditsRecordUid($uid);
	$member_table->searchCreditsRecordType($type);

	$member_table->searchWithPage($pindex, $psize);

	$records = $member_table->creditsRecordList();
	$total = $member_table->getLastQueryTotal();

	$pager = pagination($total, $pindex, $psize);
	template('mc/member-information');
}

if ($do == 'base_information') {
	$uid = intval($_GPC['uid']);
	$profile = mc_fetch_one($uid, $_W['uniacid']);
	$profile = mc_parse_profile($profile);
	$member_table = table('member');
	$uniacid_fields = $member_table->mcFieldsList($_W['uniacid']);
	$all_fields = mc_fields();
	$custom_fields = array();
	$base_fields = cache_load(cache_system_key('userbasefields'));
	$base_fields = array_keys($base_fields);
	foreach ($all_fields as $field => $title) {
		if (!in_array($field, $base_fields)) {
			$custom_fields[] = $field;
		}
	}
	$groups = mc_groups($_W['uniacid']);
	$addresses = pdo_getall('mc_member_address', array('uid' => $uid, 'uniacid' => $_W['uniacid']));
	if ($_W['ispost'] && $_W['isajax']) {
		if(!empty($_GPC['type'])) {
			$type = trim($_GPC['type']);
		}else {
			iajax(-1, '参数错误！', '');
		}
		switch ($type) {
			case 'avatar':
				$data = array('avatar' => $_GPC['imgsrc']);
				break;
			case 'groupid':
			case 'gender':
			case 'education':
			case 'constellation':
			case 'zodiac':
			case 'bloodtype':
				$data = array($type => $_GPC['request_data']);
				break;
			case 'nickname':
			case 'realname':
			case 'address':
			case 'qq':
			case 'mobile':
			case 'email':
			case 'telephone':
			case 'msn':
			case 'taobao':
			case 'alipay':
			case 'graduateschool':
			case 'grade':
			case 'studentid':
			case 'revenue':
			case 'position':
			case 'occupation':
			case 'company':
			case 'nationality':
			case 'height':
			case 'weight':
			case 'idcard':
			case 'zipcode':
			case 'site':
			case 'affectivestatus':
			case 'lookingfor':
			case 'bio':
			case 'interest':
				$data = array($type => trim($_GPC['request_data']));
				break;
			case 'births':
				$data = array(
					'birthyear' => $_GPC['birthyear'],
					'birthmonth' => $_GPC['birthmonth'],
					'birthday' => $_GPC['birthday']
				);
				break;
			case 'resides':
				$data = array(
					'resideprovince' => $_GPC['resideprovince'],
					'residecity' => $_GPC['residecity'],
					'residedist' => $_GPC['residedist']
				);
				break;
			case 'password':
				$password = trim($_GPC['password']);
				$sql = 'SELECT `uid`, `salt` FROM ' . tablename('mc_members') . " WHERE `uniacid`=:uniacid AND `uid` = :uid";
				$user = pdo_fetch($sql, array(':uniacid' => $_W['uniacid'], ':uid' => $uid));
				$data = array();
				if(!empty($user) && $user['uid'] == $uid) {
					if (empty($user['salt'])) {
						$user['salt'] = $salt = random(8);
						pdo_update('mc_members', array('salt' => $salt), array('uid' => $uid, 'uniacid' => $_W['uniacid']));
					}
					$password = md5($password . $user['salt'] . $_W['config']['setting']['authkey']);
					$data = array('password' => $password);
				}
				break;
			default:
								$data = array($type => trim($_GPC['request_data']));
				break;
		}
		$result = mc_update($uid, $data);
		if($result) {
			iajax(0, '修改成功！', '');
		}else {
			iajax(1, '修改失败！', '');
		}
	}
	template('mc/member-information');
};
if ($do == 'address') {
	$uid = intval($_GPC['uid']);
	if ($_W['ispost'] && $_W['isajax']) {
		if ($_GPC['op'] == 'addaddress' || $_GPC['op'] == 'editaddress') {
			$post = array(
				'uniacid' => $_W['uniacid'],
				'province' => trim($_GPC['province']),
				'city' => trim($_GPC['city']),
				'district' => trim($_GPC['district']),
				'address' => trim($_GPC['detail']),
				'uid' => intval($_GPC['uid']),
				'username' => trim($_GPC['name']),
				'mobile' => trim($_GPC['phone']),
				'zipcode' => trim($_GPC['code'])
			);
			if ($_GPC['op'] == 'addaddress') {
				$exist_address = pdo_getcolumn('mc_member_address', array('uniacid' => $post['uniacid'], 'uid' => $uid), 'COUNT(*)');
				if (!$exist_address) {
					$post['isdefault'] = 1;
				}
				if(pdo_insert('mc_member_address', $post)){
					$post['id'] = pdo_insertid();
					iajax(0, $post, '');
				} else {
					iajax(1, "收货地址添加失败", '');
				};
			} else {
				$post['id'] = intval($_GPC['id']);
				$result = pdo_update('mc_member_address', $post, array('id' => intval($_GPC['id']), 'uniacid' => $_W['uniacid']));
				if($result){
					iajax(0, $post, '');
				} else {
					iajax(1, "收货地址修改失败", '');
				};
			}
		}
		if ($_GPC['op'] == 'deladdress') {
			$id = intval($_GPC['id']);
			if (pdo_delete('mc_member_address', array('id' => $id, 'uniacid' => $_W['uniacid']))) {
				iajax(0, '删除成功', '');
			}else{
				iajax(1, '删除失败', '');
			}
		}
		if ($_GPC['op'] == 'isdefault') {
			$id = intval($_GPC['id']);
			$uid = intval($_GPC['uid']);
			pdo_update('mc_member_address', array('isdefault' => 0), array('uid' => $uid, 'uniacid' => $_W['uniacid']));
			pdo_update('mc_member_address', array('isdefault' => 1), array('id' => $id, 'uniacid' => $_W['uniacid']));
			iajax(0, '设置成功', '');
		}
	}
}
