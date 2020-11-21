<?php
define('IN_OPENAPI', true);
require '../../../../framework/bootstrap.inc.php';
require '../../../../addons/weliam_merchant/core/common/defines.php';
require '../../../../addons/weliam_merchant/core/common/autoload.php';
require '../../../../addons/weliam_merchant/core/function/global.func.php';
global $_W,$_GPC;
load()->model('attachment');

//判断公众号相关
$_W['siteroot'] = str_replace(array('/addons/weliam_merchant/core/common','/addons/weliam_merchant'), '', $_W['siteroot']);
$_W['method'] = $method = !empty($_GPC['do']) ? $_GPC['do'] : 'index';
$_W['aid'] = intval($_GPC['aid']);
$_W['uniacid'] = intval($_GPC['i']);
$_W['apitoken'] = trim($_GPC['token']);
if(empty($_W['uniacid'])) {
	$_W['uniacid'] = intval($_GPC['weid']);
}
$_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
if(empty($_W['uniaccount'])) {
	header('HTTP/1.1 404 Not Found');
	header("status: 404 Not Found");
	exit;
}
if (!empty($_W['uniaccount']['endtime']) && TIMESTAMP > $_W['uniaccount']['endtime']) {
	exit('抱歉，您的公众号服务已过期，请及时联系管理员');
}
$_W['acid'] = $_W['uniaccount']['acid'];
$isdel_account = pdo_get('account', array('isdeleted' => 1, 'acid' => $_W['acid']));
if (!empty($isdel_account)) {
	exit('指定公众号已被删除');
}
$_W['attachurl'] = attachment_set_attach_url();

//寻找对应方法
require IA_ROOT . "/addons/weliam_merchant/plugin/openapi/openapi.php";
$instance = new Weliam_merchantModuleOpenapi();
if (!method_exists($instance, $method)) {
	$method = 'doPage' . ucfirst($method);
}
$instance -> $method();


class Openapi {
	
	public function __construct(){
		global $_W;
		$settings = Setting::wlsetting_read('apiset');
		if ($_W['apitoken'] != $settings['token']) {
			$this->result(-1, '无效Token');
		}
	}
	
	public function result($errno, $message, $data = '') {
		exit(json_encode(array(
			'errno' => $errno,
			'message' => $message,
			'data' => $data,
		)));
	}
	
}
