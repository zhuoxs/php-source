<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

$dos = array('uc_setting', 'upload_file');
$do = in_array($do, $dos) ? $do : 'uc_setting';
permission_check_account_user('profile_setting');

if ($do == 'uc_setting') {
	$setting = uni_setting_load('uc');
	$uc = $setting['uc'];
	if(!is_array($uc)) {
		$uc = array();
	}

	if(checksubmit('submit')) {
		$uc['connect'] = isset($_GPC['connect']) ? safe_gpc_string($_GPC['connect']) : $uc['connect'];
		$uc['title'] = isset($_GPC['title']) ? safe_gpc_string($_GPC['title']) : $uc['title'];
		$uc['appid'] = isset($_GPC['appid']) ? intval($_GPC['appid']) : $uc['appid'];
		$uc['key'] = isset($_GPC['key']) ? safe_gpc_string($_GPC['key']) : $uc['key'];
		$uc['charset'] = isset($_GPC['charset']) ? safe_gpc_string($_GPC['charset']) : $uc['charset'];
		$uc['dbhost'] = isset($_GPC['dbhost']) ? safe_gpc_string($_GPC['dbhost']) : $uc['dbhost'];
		$uc['dbuser'] = isset($_GPC['dbuser']) ? safe_gpc_string($_GPC['dbuser']) : $uc['dbuser'];
		$uc['dbpw'] = isset($_GPC['dbpw']) ? safe_gpc_string($_GPC['dbpw']) : $uc['dbpw'];
		$uc['dbname'] = isset($_GPC['dbname']) ? safe_gpc_string($_GPC['dbname']) : $uc['dbname'];
		$uc['dbcharset'] = isset($_GPC['dbcharset']) ? safe_gpc_string($_GPC['dbcharset']) : $uc['dbcharset'];
		$uc['dbtablepre'] = isset($_GPC['dbtablepre']) ? safe_gpc_string($_GPC['dbtablepre']) : $uc['dbtablepre'];
		$uc['dbconnect'] = isset($_GPC['dbconnect']) ? intval($_GPC['dbconnect']) : $uc['dbconnect'];
		$uc['api'] = isset($_GPC['api']) ? safe_gpc_string($_GPC['api']) : $uc['api'];
		$uc['ip'] = isset($_GPC['ip']) ? safe_gpc_string($_GPC['ip']) : $uc['ip'];

		if (isset($_GPC['status'])) {
			$uc['status'] = $_GPC['status'] == 1 ? 1 : 0;
		}
		if ($uc['status'] == 1) {
			if (empty($uc['title'])) {
				iajax(-1, '请填写正确的通行证名称！');
			}
			if (empty($uc['appid'])) {
				iajax(-1, '请填写正确的应用ID！');
			}
			if (empty($uc['key'])) {
				iajax(-1, '请填写通信密钥！');
			}
			if (empty($uc['charset'])) {
				iajax(-1, '请填写UCenter的字符集！');
			}
			if (!in_array($uc['connect'], array('mysql','http'))) {
				iajax(1, '通行方式参数有误');
			}
			if($uc['connect'] == 'mysql') {
				if (empty($uc['dbhost'])) {
					iajax(-1, '请填写UCenter数据库主机地址！');
				}
				if (empty($uc['dbuser'])) {
					iajax(-1, '请填写UCenter数据库用户名！');
				}
				if (empty($uc['dbpw'])) {
					iajax(-1, '请填写UCenter数据库密码！');
				}
				if (empty($uc['dbname'])) {
					iajax(-1, '请填写UCenter数据库名称！');
				}
				if (empty($uc['dbcharset'])) {
					iajax(-1, '请填写UCenter数据库字符集！');
				}
				if (empty($uc['dbtablepre'])) {
					iajax(-1, '请填写UCenter数据表前缀！');
				}
			} elseif ($uc['connect'] == 'http') {
				if (empty($uc['api'])) {
					iajax(-1, '请填写UCenter 服务端的URL地址！');
				}
				if (empty($uc['ip'])) { 
					iajax(-1, '请填写UCenter的IP！');
				}
			}
		}
		if(uni_setting_save('uc', $uc)){
			iajax(0, '设置成功！', referer());
		}else {
			iajax(-1, '设置失败！');
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
