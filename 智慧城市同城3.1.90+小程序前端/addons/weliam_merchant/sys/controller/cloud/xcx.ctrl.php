<?php
defined('IN_IA') or exit('Access Denied');
set_time_limit(0);
load() -> func('file');

class Xcx_WeliamController {
	public function __construct() {
		global $_W;
		if (!$_W['isfounder']) {
			wl_message('无权访问!');
		}
	}
  
	static function get_wxapp_uniacid($uniacid = '') {
		global $_W, $_GPC;
		$uniacid = $uniacid ? $uniacid : $_W['uniacid'];
		return pdo_getcolumn(PDO_NAME . 'wxapp_relation', array('uniacid' => $uniacid), 'wxapp_uniacid');
	}
  
	public function index() {
		global $_W, $_GPC;
        define("SITE_ID",base64_encode($_SERVER["HTTP_HOST"]));
		$domain = $_W['siteroot'];
		$siteid = $_W['setting']['site']['key'];
        $uniacid = $_W['uniacid'];
        $wxappuniacid = self::get_wxapp_uniacid($_W['uniacid']);
        $library = '2';
        define('HTTP_X_FOR', (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://');
        $auth_url = HTTP_X_FOR .'authxcx.beitog.cn/home/main/release.html?site_id=' . SITE_ID . '&uniacid=' . $uniacid . '&library='. $library. '&wxappuniacid='. $wxappuniacid;

		include  wl_template('cloud/xcx');
	}

}

