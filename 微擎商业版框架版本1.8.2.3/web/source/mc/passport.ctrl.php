<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$dos = array('passport', 'oauth', 'sync');
$do = in_array($do, $dos) ? $do : 'passport';
if($do == 'passport') {
	uni_user_permission_check('mc_passport_passport');
	$_W['page']['title'] = '会员中心参数 - 会员中心选项 - 会员中心';
	$uc = pdo_fetch("SELECT `uc`,`passport` FROM ".tablename('uni_settings') . " WHERE uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
	$passport = @iunserializer($uc['passport']);
	if(!is_array($passport)) {
		$passport = array();
	}

	if(checksubmit('submit')) {
		$rec = array();
		$passport = array();
		$passport['focusreg'] = intval($_GPC['passport']['focusreg']);
		$passport['item'] = trim($_GPC['passport']['item']);
		$passport['type'] = $_GPC['passport']['type'];
		$passport['audit'] = intval($_GPC['passport']['audit']);
		$passport['type'] = in_array($passport['type'], array('code', 'password', 'hybird')) ? $passport['type'] : 'password';
		$rec['passport'] = iserializer($passport);
		$row = pdo_fetch("SELECT uniacid FROM ".tablename('uni_settings') . " WHERE uniacid = :wid LIMIT 1", array(':wid' => intval($_W['uniacid'])));
		if(!empty($row)) {
			pdo_update('uni_settings', $rec, array('uniacid' => intval($_W['uniacid'])));
		}else {
			pdo_insert('uni_settings', $rec);
		}
		cache_delete("unisetting:{$_W['uniacid']}");
		message('设置成功！', referer(), 'success');
	}
}

if($do == 'oauth') {
	uni_user_permission_check('mc_passport_oauth');
		$_W['page']['title'] = '公众平台oAuth选项 - 会员中心';
	
	$where = '';
	$params = array();
	if(empty($_W['isfounder'])) {
		$where = " WHERE `uniacid` IN (SELECT `uniacid` FROM " . tablename('uni_account_users') . " WHERE `uid`=:uid)";
		$params[':uid'] = $_W['uid'];
	}
	$sql = "SELECT * FROM " . tablename('uni_account') . $where;
	$uniaccounts = pdo_fetchall($sql, $params);
	$accounts = array();
	if(!empty($uniaccounts)) {
		foreach($uniaccounts as $uniaccount) {
			$accountlist = uni_accounts($uniaccount['uniacid']);
			if(!empty($accountlist)) {
				foreach($accountlist as $account) {
					if(!empty($account['key'])
					&& !empty($account['secret'])
					&& in_array($account['level'], array(4))) {
						$accounts[$account['acid']] = $account['name'];
					}
				}
			}
		}
	}
		$oauth = pdo_fetchcolumn('SELECT `oauth` FROM '.tablename('uni_settings').' WHERE `uniacid` = :uniacid LIMIT 1',array(':uniacid' => $_W['uniacid']));
	$oauth = iunserializer($oauth) ? iunserializer($oauth) : array();
	if(checksubmit('submit')) {
		$host = rtrim($_GPC['host'],'/');
		if(!empty($host) && !preg_match('/^http(s)?:\/\//', $host)) {
			$host = $_W['sitescheme'].$host;
		}
		$data = array(
			'host' => $host,
			'account' => intval($_GPC['oauth']),
		);
		pdo_update('uni_settings', array('oauth' => iserializer($data)), array('uniacid' => $_W['uniacid']));
		cache_delete("unisetting:{$_W['uniacid']}");
		message('设置公众平台oAuth成功', referer() ,'success');
	}
}

if($do == 'sync') {
	uni_user_permission_check('mc_passport_sync');
	$_W['page']['title'] = '更新粉丝信息 - 公众号选项';
	$setting = uni_setting($_W['uniacid'], array('sync'));
	$sync = $setting['sync'];
	if(checksubmit('submit')) {
		pdo_update('uni_settings', array('sync' => intval($_GPC['sync'])), array('uniacid' => $_W['uniacid']));
		cache_delete("unisetting:{$_W['uniacid']}");
		message('更新设置成功', referer(),  'success');
	}
}
template('mc/passport');