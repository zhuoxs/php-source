<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

$dos = array('uc_setting', 'upload_file');
$do = in_array($do, $dos) ? $do : 'uc_setting';
permission_check_account_user('profile_setting');
$_W['page']['title'] = '系统 - 参数设置';

if ($do == 'uc_setting') {
	$_W['page']['title'] = 'uc站点整合';
	$setting = uni_setting_load('uc');
	$uc = $setting['uc'];
	if(!is_array($uc)) {
		$uc = array();
	}

	if(checksubmit('submit')) {
		$rec = array();
		$uc['status'] = intval($_GPC['status']);
		$uc['connect'] = trim($_GPC['connect']);
		if($uc['status'] == '1' && in_array($uc['connect'], array('mysql','http'))) {
			$uc['title'] = empty($_GPC['title']) ? itoast('请填写正确的站点名称！', referer(), 'error') : trim($_GPC['title']);
			$uc['appid'] = empty($_GPC['appid']) ? itoast('请填写正确的应用id！', referer(), 'error') : intval($_GPC['appid']);
			$uc['key'] = empty($_GPC['key']) ? itoast('请填写与UCenter的通信密钥！', referer(), 'error') : trim($_GPC['key']);
			$uc['charset'] = empty($_GPC['charset']) ? itoast('请填写UCenter的字符集！', referer(), 'error') : trim($_GPC['charset']);
			if($uc['connect'] == 'mysql') {
				$uc['dbhost'] = empty($_GPC['dbhost']) ? itoast('请填写UCenter数据库主机地址！', referer(), 'error') : trim($_GPC['dbhost']);
				$uc['dbuser'] = empty($_GPC['dbuser']) ? itoast('请填写UCenter数据库用户名！', referer(), 'error') : trim($_GPC['dbuser']);
				$uc['dbpw'] = empty($_GPC['dbpw']) ? itoast('请填写UCenter数据库密码！', referer(), 'error') : trim($_GPC['dbpw']);
				$uc['dbname'] = empty($_GPC['dbname']) ? itoast('请填写UCenter数据库名称！', referer(), 'error') : trim($_GPC['dbname']);
				$uc['dbcharset'] = empty($_GPC['dbcharset']) ? itoast('请填写UCenter数据库字符集！', referer(), 'error') : trim($_GPC['dbcharset']);
				$uc['dbtablepre'] = empty($_GPC['dbtablepre']) ? itoast('请填写UCenter数据表前缀！', referer(), 'error') : trim($_GPC['dbtablepre']);
				$uc['dbconnect'] = intval($_GPC['dbconnect']);
				$uc['api'] = trim($_GPC['api']);
				$uc['ip'] = trim($_GPC['ip']);
			} elseif($uc['connect'] == 'http') {
				$uc['dbhost'] = trim($_GPC['dbhost']);
				$uc['dbuser'] = trim($_GPC['dbuser']);
				$uc['dbpw'] = trim($_GPC['dbpw']);
				$uc['dbname'] = trim($_GPC['dbname']);
				$uc['dbcharset'] = trim($_GPC['dbcharset']);
				$uc['dbtablepre'] = trim($_GPC['dbtablepre']);
				$uc['dbconnect'] = intval($_GPC['dbconnect']);
				$uc['api'] = empty($_GPC['api']) ? itoast('请填写UCenter 服务端的URL地址！', referer(), 'error') : trim($_GPC['api']);
				$uc['ip'] = empty($_GPC['ip']) ? itoast('请填写UCenter的IP！', referer(), 'error') : trim($_GPC['ip']);
			}
		}
		$uc = iserializer($uc);
		if(uni_setting_save('uc', $uc)){
			itoast('设置UC参数成功！', referer(), 'success');
		}else {
			itoast('设置UC参数失败，请核对内容重新提交！', referer(), 'error');
		}
	}
}

if ($do == 'upload_file') {
	if (checksubmit('submit')) {
		if (empty($_FILES['file']['tmp_name'])) {
			itoast('请选择文件', url('profile/common/upload_file'), 'error');
		}
		if ($_FILES['file']['type'] != 'text/plain') {
			itoast('文件类型错误', url('profile/common/upload_file'), 'error');
		}
		$file = file_get_contents($_FILES['file']['tmp_name']);
		$file_name = 'MP_verify_'. $file. ".txt";
		if ($file_name != $_FILES['file']['name'] || !preg_match("/^[A-Za-z0-9]+$/", $file)) {
			itoast('上传文件不合法,请重新上传', url('profile/common/upload_file'), 'error');
		}
		file_put_contents(IA_ROOT. "/". $_FILES['file']['name'], $file);
		itoast('上传成功', url('profile/common/upload_file'), 'success');
	}
}

template('profile/uc');
