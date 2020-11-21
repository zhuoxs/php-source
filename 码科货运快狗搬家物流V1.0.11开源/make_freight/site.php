<?php
/**
 * dingku_shop模块微站定义
 *
 * @author xiaoyaossdlh
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Make_freightModuleSite extends WeModuleSite {


	public function doWebIndex() {
		session_start();
		global $_W;
		$isLogin = checklogin();

		if(!$isLogin){
			header('Location:' . 'http://'.$_SERVER['HTTP_HOST']);
			exit();
		}


		$admin  = pdo_get('freight_admin');
		if(!$admin){
			message('账号未找到');
		}

		$_SESSION["freight_admin"] = $admin;


		$url = $_W['siteroot'] . 'addons/' . $_W['current_module']['name'] . '/core/public/index.php/admin/index/wq_login';

		if (file_exists(__DIR__ . '/core/public/index.php')) {
			header('Location:' . $url);
			exit;
		}

	}
	


}

