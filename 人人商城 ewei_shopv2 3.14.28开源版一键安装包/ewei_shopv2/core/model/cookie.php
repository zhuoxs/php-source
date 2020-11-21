<?php
class Cookie_EweiShopV2Model
{
	private $prefix;

	public function __construct()
	{
		global $_W;
		$this->prefix = EWEI_SHOPV2_PREFIX . '_cookie_' . $_W['uniacid'] . '_';
	}

	public function set($key, $value)
	{
		setcookie($this->prefix . $key, iserializer($value), time() + 3600 * 24 * 365);
	}

	public function get($key)
	{
		if (!isset($_COOKIE[$this->prefix . $key])) {
			return false;
		}

		return iunserializer($_COOKIE[$this->prefix . $key]);
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
