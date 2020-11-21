<?php

class PluginModel
{
	private $pluginname;
	private $set;

	public function __construct($name = '')
	{
		$this->pluginname = $name;
		$this->set = $this->getSet();
	}

	public function getSet()
	{
		if (empty($GLOBALS['_S'][$this->pluginname])) {
			return m('common')->getPluginset($this->pluginname);
		}

		return $GLOBALS['_S'][$this->pluginname];
	}

	public function updateSet($data = array())
	{
		m('common')->updatePluginset(array($this->pluginname => $data));
	}

	public function getName()
	{
		return pdo_fetchcolumn('select name from ' . tablename('ewei_shop_plugin') . ' where identity=:identity limit 1', array(':identity' => $this->pluginname));
	}

	public function checkSubmit($key, $time = 2, $message = '操作频繁，请稍后再试!')
	{
		global $_W;
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = $_W['setting']['site']['key'] . '_' . $_W['account']['key'] . '_' . $_W['uniacid'] . '_' . $_W['openid'] . '_mobilesubmit_' . $key;
			$redis = redis();

			if ($redis->setnx($redis_key, time())) {
				$redis->expireAt($redis_key, time() + $time);
			}
			else {
				return error(-1, $message);
			}
		}

		return true;
	}

	public function checkSubmitGlobal($key, $time = 2, $message = '操作频繁，请稍后再试!')
	{
		global $_W;
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = $_W['setting']['site']['key'] . '_' . $_W['account']['key'] . '_' . $_W['uniacid'] . '_mobilesubmit_' . $key;
			$redis = redis();

			if ($redis->setnx($redis_key, time())) {
				$redis->expireAt($redis_key, time() + $time);
			}
			else {
				return error(-1, $message);
			}
		}

		return true;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
