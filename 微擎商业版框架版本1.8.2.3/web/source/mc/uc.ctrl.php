<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('mc_uc');
$_W['page']['title'] = 'UC站点整合 - 会员中心选项 - 会员中心';
$uc = pdo_fetch("SELECT `uc`,`passport` FROM ".tablename('uni_settings') . " WHERE uniacid = :weid", array(':weid' => $_W['weid']));
$uc = @iunserializer($uc['uc']);
if(!is_array($uc)) {
	$uc = array();
}

if(checksubmit('submit')) {
	$rec = array();
	$uc['status'] = intval($_GPC['status']);
	
	if($uc['status'] == '1') {
		$connect = $_GPC['connect'];
		$uc['connect'] = trim($_GPC['connect']);
		$uc['title'] = empty($_GPC['title']) ? message('请填写正确的站点名称！', referer(), 'error') : trim($_GPC['title']);
		$uc['appid'] = empty($_GPC['appid']) ? message('请填写正确的应用id！', referer(), 'error') : intval($_GPC['appid']);
		$uc['key'] = empty($_GPC['key']) ? message('请填写与UCenter的通信密钥！', referer(), 'error') : trim($_GPC['key']);
		$uc['charset'] = empty($_GPC['charset']) ? message('请填写UCenter的字符集！', referer(), 'error') : trim($_GPC['charset']);
		if($connect == 'mysql') {
			$uc['dbhost'] = empty($_GPC['dbhost']) ? message('请填写UCenter数据库主机地址！', referer(), 'error') : trim($_GPC['dbhost']);
			$uc['dbuser'] = empty($_GPC['dbuser']) ? message('请填写UCenter数据库用户名！', referer(), 'error') : trim($_GPC['dbuser']);
			$uc['dbpw'] = empty($_GPC['dbpw']) ? message('请填写UCenter数据库密码！', referer(), 'error') : trim($_GPC['dbpw']);
			$uc['dbname'] = empty($_GPC['dbname']) ? message('请填写UCenter数据库名称！', referer(), 'error') : trim($_GPC['dbname']);
			$uc['dbcharset'] = empty($_GPC['dbcharset']) ? message('请填写UCenter数据库字符集！', referer(), 'error') : trim($_GPC['dbcharset']);
			$uc['dbtablepre'] = empty($_GPC['dbtablepre']) ? message('请填写UCenter数据表前缀！', referer(), 'error') : trim($_GPC['dbtablepre']);
			$uc['dbconnect'] = intval($_GPC['dbconnect']);
			$uc['api'] = trim($_GPC['api']);
			$uc['ip'] = trim($_GPC['ip']);
		} elseif($connect == 'http') {
			$uc['dbhost'] = trim($_GPC['dbhost']);
			$uc['dbuser'] = trim($_GPC['dbuser']);
			$uc['dbpw'] = trim($_GPC['dbpw']);
			$uc['dbname'] = trim($_GPC['dbname']);
			$uc['dbcharset'] = trim($_GPC['dbcharset']);
			$uc['dbtablepre'] = trim($_GPC['dbtablepre']);
			$uc['dbconnect'] = intval($_GPC['dbconnect']);
			$uc['api'] = empty($_GPC['api']) ? message('请填写UCenter 服务端的URL地址！', referer(), 'error') : trim($_GPC['api']);
			$uc['ip'] = empty($_GPC['ip']) ? message('请填写UCenter的IP！', referer(), 'error') : trim($_GPC['ip']);
		}
	}
	$rec['uc'] = iserializer($uc);
	$row = pdo_fetch("SELECT uniacid FROM ".tablename('uni_settings') . " WHERE uniacid = :wid LIMIT 1", array(':wid' => intval($_W['weid'])));
	if(!empty($row)) {
		pdo_update('uni_settings', $rec, array('uniacid' => intval($_W['uniacid'])));
	}else {
		$rec['uniacid'] = $_W['uniacid'];
		pdo_insert('uni_settings', $rec);
	}
	cache_delete("unisetting:{$_W['uniacid']}");
	message('设置UC参数成功！', referer(), 'success');
}

template('mc/uc');
