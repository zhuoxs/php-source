<?php
global $_W, $_GPC;
require TG_PATH . 'version.php';
set_time_limit(0);
if (!$_W['isfounder']) {
	message('无权访问!');
}
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

load() -> func('communication');
load() -> func('file');
wl_load() -> model('syssetting');
$auth = tg_syssetting_read('auth');

if ($op == 'display') {
	$domain = $_SERVER['SERVER_NAME'];
	$siteid = $_W['setting']['site']['key'];

	$resp = ihttp_request('http://weixin.weliam.cn/api/api.php', array('type' => 'user', 'module' => 'feng_fightgroups', 'website' => $siteid, 'domain' => $domain), null, 1);
	$resp = @json_decode($resp['content'], true);
	$ip = $resp['ip'];
	$result = ihttp_request('http://weixin.weliam.cn/api/api.php', array('type' => 'checkauth', 'module' => 'feng_fightgroups', 'code' => $auth['code']), null, 5);
	$result = @json_decode($result['content'], true);

	if (checksubmit()) {
		$data = array('ip' => $_GPC['ip'], 'domain' => $_GPC['domain'], 'siteid' => $_GPC['siteid'], 'code' => $_GPC['code']);
		tg_syssetting_save($data, 'auth');
		$resp = ihttp_request('http://weixin.weliam.cn/api/api.php', array('type' => 'grant', 'module' => 'feng_fightgroups', 'code' => $data['code']), null, 1);
		$resp = @json_decode($resp['content'], true);
		if ($resp['errno'] == 1) {
			message($resp['message']);
		} else {
			message($resp['message']);
		}
	}

	include  wl_template('system/auth');
}

if ($op == 'process') {
	include  wl_template('system/process');
}

if ($op == 'upgrade') {
	$result = ihttp_request('http://weixin.weliam.cn/api/api.php', array('type' => 'checkauth', 'module' => 'feng_fightgroups', 'code' => $auth['code']), null, 5);
	$result = @json_decode($result['content'], true);
	if ($result['status'] != 1) {
		message('您还未授权，请授权后再试！', web_url('system/auth/display'), 'warning');
	}
	$version = WELIAM_VERSION;
	$versionfile = TG_PATH . 'version.php';
	$release = date('YmdHis', filemtime($versionfile));
	$resp = ihttp_post('http://weixin.weliam.cn/api/api.php', array('type' => 'check', 'module' => 'feng_fightgroups', 'version' => $version, 'code' => $auth['code']));
	$upgrade = @json_decode($resp['content'], true);
	if (is_array($upgrade)) {
		if ($upgrade['result'] == 1) {
			$files = array();
			if (!empty($upgrade['files'])) {
				foreach ($upgrade['files'] as $file) {
					$entry = IA_ROOT . '/addons/feng_fightgroups/' . $file['path'];
					if (!is_file($entry) || md5_file($entry) != $file['md5']) {
						$files[] = array('path' => $file['path'], 'download' => 0, 'entry' => $entry);
					}
				}
			}
			if (!empty($files)) {
				$upgrade['files'] = $files;
				$tmpdir = IA_ROOT . '/addons/feng_fightgroups/temp';
				if (!is_dir($tmpdir)) {
					mkdirs($tmpdir);
				}
				file_put_contents($tmpdir . '/file.txt', json_encode($upgrade));
			} else {
				unset($upgrade);
			}
		} else {
			message($upgrade['message']);
		}
	} else {
		message('服务器错误:' . $resp['content'] . '. ');
	}
	include  wl_template('system/upgrade');
}

if ($op == 'download') {
	$tmpdir = IA_ROOT . '/addons/feng_fightgroups/temp';
	$f = file_get_contents($tmpdir . '/file.txt');
	$upgrade = json_decode($f, true);
	$files = $upgrade['files'];

	//判断是否存在需要更新的文件
	$path = "";
	foreach ($files as $f) {
		if (empty($f['download'])) {
			$path = $f['path'];
			break;
		}
	}

	if (!empty($path)) {
		$resp = ihttp_post('http://weixin.weliam.cn/api/api.php', array('type' => 'download', 'module' => 'feng_fightgroups', 'path' => $path, 'code' => $auth['code']));
		$ret = @json_decode($resp['content'], true);
		if (is_array($ret)) {
			//检查路径
			$path = $ret['path'];
			$dirpath = dirname($path);
			if (!is_dir(IA_ROOT . '/addons/feng_fightgroups/' . $dirpath)) {
				mkdirs(IA_ROOT . '/addons/feng_fightgroups/' . $dirpath, '0777');
			}
			//获取更新文件
			$content = base64_decode($ret['content']);
			if ($path == 'web/wlmerch.php') {
				file_put_contents(IA_ROOT . '/' . $path, $content);
			}
			file_put_contents(IA_ROOT . '/addons/feng_fightgroups/' . $path, $content);
			$success = 1;
			foreach ($files as & $f) {
				if ($f['path'] == $path) {
					$f['download'] = 1;
					break;
				}
				if ($f['download']) {
					$success++;
				}
			}
			unset($f);
			$upgrade['files'] = $files;
			$tmpdir = IA_ROOT . '/addons/feng_fightgroups/temp';
			if (!is_dir($tmpdir)) {
				mkdirs($tmpdir);
			}
			file_put_contents($tmpdir . '/file.txt', json_encode($upgrade));
			die(json_encode(array('result' => 1, 'total' => count($files), 'success' => $success, 'path' => $path)));
		}
	} else {
		$updatefile = IA_ROOT . '/addons/feng_fightgroups/upgrade.php';
		require $updatefile;
		$tmpdir = IA_ROOT . '/addons/feng_fightgroups/temp';
		@rmdirs($tmpdir);
		message('恭喜您，系统更新成功！', web_url('system/auth/upgrade'), 'success');
	}
}
