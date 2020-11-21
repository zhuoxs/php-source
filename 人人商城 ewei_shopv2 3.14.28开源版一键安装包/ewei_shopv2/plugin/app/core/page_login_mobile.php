<?php
function app_error($errcode = 0, $message = '')
{
	return json_encode(array('error' => $errcode, 'message' => empty($message) ? AppError::getError($errcode) : $message));
}

function app_json($result = NULL)
{
	global $_W;
	global $_GPC;
	$ret = array();

	if (!is_array($result)) {
		$result = array();
	}

	$ret['error'] = 0;
	$ret['sysset'] = array(
		'shopname'    => $_W['shopset']['shop']['name'],
		'shoplogo'    => $_W['shopset']['shop']['logo'],
		'description' => $_W['shopset']['shop']['description'],
		'share'       => $_W['shopset']['share'],
		'texts'       => array('credit' => $_W['shopset']['trade']['credittext'], 'money' => $_W['shopset']['trade']['moneytext']),
		'isclose'     => $_W['shopset']['app']['isclose']
	);
	$ret['sysset']['share']['logo'] = tomedia($ret['sysset']['share']['logo']);
	$ret['sysset']['share']['icon'] = tomedia($ret['sysset']['share']['icon']);
	$ret['sysset']['share']['followqrcode'] = tomedia($ret['sysset']['share']['followqrcode']);

	if (!empty($_W['shopset']['app']['isclose'])) {
		$ret['sysset']['closetext'] = $_W['shopset']['app']['closetext'];
	}

	return json_encode(array_merge($ret, $result));
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'app/core/error_code.php';
class AppMobileLoginPage extends PluginMobilePage
{
	public function __construct()
	{
		parent::__construct();
	}
}

?>
