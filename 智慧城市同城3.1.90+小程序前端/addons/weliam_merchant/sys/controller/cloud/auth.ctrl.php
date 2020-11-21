<?php
defined('IN_IA') or exit('Access Denied');
set_time_limit(0);
load() -> func('file');

class Auth_WeliamController {
	public function __construct() {
		global $_W;
		if (!$_W['isfounder']) {
			wl_message('无权访问!');
		}
	}

	public function index() {
		global $_W, $_GPC;
		define('HTTP_X_FOR', (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://');	
		$auth = array();
		$auth['password'] = '';
		$auth['modname'] = 'weliam_merchant';
		$auth['modnamemm'] = '智慧城市O2O';
		$auth['url'] = trim(preg_replace('/http(s)?:\\/\\//', '', rtrim($_W['siteroot'], '/')));
		$auth['forward'] = 'profile';
		$query = base64_encode(json_encode($auth));
		$auth_url = HTTP_X_FOR .'auth.beitog.cn/api/auth_mod.php?__auth=' . $query;

		include  wl_template('cloud/auth');
	}

	public function upgrade() {
		global $_W, $_GPC;
        $auth_url = '/web/index.php?c=mod&a=mod_weliam&';
		include  wl_template('cloud/upgrade');
	}

	public function download() {
		global $_W, $_GPC;
		$auth = Cloud::wl_syssetting_read('auth');
		$tmpdir = IA_ROOT . '/addons/' . MODULE_NAME . '/temp';
		$f = file_get_contents($tmpdir . '/file.txt');
		$upgrade = json_decode($f, true);
		$files = $upgrade['files'];

		//判断是否存在需要校验的文件
		$path = "";
		foreach ($files as $f) {
			if (empty($f['download'])) {
				$path = $f['path'];
				break;
			}
		}

		if (!empty($path)) {
			$ret = Cloud::auth_download($auth, $path);
			if (is_array($ret)) {
				//检查路径
				$path = $ret['path'];
				$dirpath = dirname($path);
				if (!is_dir(IA_ROOT . '/addons/' . MODULE_NAME . '/' . $dirpath)) {
					mkdirs(IA_ROOT . '/addons/' . MODULE_NAME . '/' . $dirpath, '0777');
				}
				//获取校验文件
				$content = base64_decode($ret['content']);
				if ($path == 'web/agent.php') {
					file_put_contents(IA_ROOT . '/' . $path, $content);
				}
				file_put_contents(IA_ROOT . '/addons/' . MODULE_NAME . '/' . $path, $content);
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
				$tmpdir = IA_ROOT . '/addons/' . MODULE_NAME . '/temp';
				if (!is_dir($tmpdir)) {
					mkdirs($tmpdir);
				}
				file_put_contents($tmpdir . '/file.txt', json_encode($upgrade));
				die(json_encode(array('result' => 1, 'total' => count($files), 'success' => $success, 'path' => $path)));
			}
		} else {
			$updatefile = IA_ROOT . '/addons/' . MODULE_NAME . '/upgrade.php';
			require $updatefile;
			$tmpdir = IA_ROOT . '/addons/' . MODULE_NAME . '/temp';
			@rmdirs($tmpdir);
			wl_message('恭喜您，文件校验成功！', web_url('cloud/auth/upgrade'), 'success');
		}
	}

	public function profile() {
		global $_W, $_GPC;
		$auth = Cloud::wl_syssetting_read('auth');
		if (empty($auth['code'])) {
			wl_message('您还未填写授权码！', web_url('cloud/auth/index'), 'warning');
		}
		$resp = Cloud::auth_user($_W['setting']['site']['key'], $_W['siteroot']);
		$ip = $resp['ip'];
		//		$iframe = Cloud::auth_url($forward);
		$iframe = 'http://weixin.weliam.cn/app/index.php?i=26&c=entry&do=cloud&ac=authuser&m=weliam_manage';
		include  wl_template('cloud/frame');
	}

	public function workorder() {
		global $_W, $_GPC;
		$auth = Cloud::wl_syssetting_read('auth');
		$result = Cloud::auth_checkauth($auth);
		if ($result['status'] != 1) {
			wl_message('您还未授权，请授权后再试！', web_url('cloud/auth/index'), 'warning');
		}
		$pindex = max(1,$_GPC['page']);
		$psize = 10;
		$data = Cloud::auth_workorder_list($auth,$pindex);
		if($data['errno'] == 1){
			wl_message($data['message'], web_url('cloud/auth/index'), 'warning');
		}
		$data = $data['message'];
		$pager = pagination($data['total'],$pindex,$psize);
		include  wl_template('cloud/workorderlist');
	}
	
	public function workorderadd() {
		global $_W, $_GPC;
		$auth = Cloud::wl_syssetting_read('auth');
		$result = Cloud::auth_checkauth($auth);
		if ($result['status'] != 1) {
			wl_message('您还未授权，请授权后再试！', web_url('cloud/auth/index'), 'warning');
		}
		if(checksubmit()){
			$picture = $_GPC['logo'];
			if($picture){
				foreach ($picture as $key => &$value) {
					$value = tomedia($value);
				}
			}
			$data = array('type'=>intval($_GPC['type']),'describe'=>$_GPC['desc'],'logo'=>$picture,'contact'=>$_GPC['mobile']);
			$query = base64_encode(json_encode($data));
			$re = Cloud::auth_workorder_add($auth,$query);
			wl_message($re['message'], web_url('cloud/auth/workorder'), 'success');
		}
		include  wl_template('cloud/workorderadd');
	}

	public function workorderdetail() {
		global $_W, $_GPC;
		$auth = Cloud::wl_syssetting_read('auth');
		$result = Cloud::auth_checkauth($auth);
		if ($result['status'] != 1) {
			wl_message('您还未授权，请授权后再试！', web_url('cloud/auth/index'), 'warning');
		}
		
		if(checksubmit()){
			$picture = $_GPC['logo'];
			if($picture){
				foreach ($picture as $key => &$value) {
					$value = tomedia($value);
				}
			}
			$data = array('id'=>intval($_GPC['id']),'describe'=>$_GPC['desc'],'logo'=>$picture);
			$query = base64_encode(json_encode($data));
			$re = Cloud::auth_workorder_reply($auth,$query);
			wl_message($re['message'], web_url('cloud/auth/workorderdetail',array('id' => intval($_GPC['id']))), 'success');
		}
		
		$data = Cloud::auth_workorder_detail($auth,intval($_GPC['id']));
		if($data['errno'] == 1){
			wl_message($data['message'], web_url('cloud/auth/workorder'), 'warning');
		}
		$data = $data['message'];
		foreach ($data['reply'] as $key => &$value) {
			$value['picture'] = unserialize($value['picture']);
		}
		include  wl_template('cloud/workorderdetail');
	}
}
