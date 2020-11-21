<?php

class Cache_EweiShopV2Model
{
	public function get_key($key = '', $uniacid = '')
	{
		global $_W;
		static $APPID;
		static $_uniacid;
		$account_key = '';
		$isme = $uniacid == $_W['uniacid'] || empty($uniacid);

		if ($isme) {
			$uniacid = $_W['uniacid'];
			$account_key = $_W['account']['key'];
		}

		if (function_exists('redis')) {
			$redis = redis();

			if (!is_error($redis)) {
				if (stripos($uniacid, 'global') !== false) {
					return 'ewei_shopv2_syscache_' . $_W['setting']['site']['key'] . '_global_' . $key;
				}

				if (empty($account_key)) {
					if ($isme) {
						if (is_null($APPID) || empty($APPID) || $_uniacid != $uniacid) {
							$_uniacid = $uniacid;
							$APPID = pdo_fetchcolumn('SELECT `key` FROM ' . tablename('account_wechats') . ' WHERE uniacid=:uniacid', array(':uniacid' => $uniacid));
						}

						$account_key = $APPID;
					}
					else {
						$account_key = pdo_fetchcolumn('SELECT `key` FROM ' . tablename('account_wechats') . ' WHERE uniacid=:uniacid', array(':uniacid' => $uniacid));
					}
				}

				return 'ewei_shopv2_syscache_' . $_W['setting']['site']['key'] . '_' . $uniacid . '_' . $account_key . '_' . $key;
			}
		}

		return EWEI_SHOPV2_PREFIX . md5($uniacid . '_new_' . $key);
	}

	public function getArray($key = '', $uniacid = '')
	{
		return $this->get($key, $uniacid);
	}

	public function getString($key = '', $uniacid = '')
	{
		return $this->get($key, $uniacid);
	}

	public function get($key = '', $uniacid = '')
	{
		global $_W;

		if (function_exists('redis')) {
			$redis = redis();

			if (!is_error($redis)) {
				$prefix = '__iserializer__format__::';
				$value = $redis->get($this->get_key($key, $uniacid));

				if (empty($value)) {
					return false;
				}

				if (stripos($value, $prefix) === 0) {
					$ret = iunserializer(substr($value, strlen($prefix)));

					foreach ($ret as $k => &$v) {
						if (is_serialized($v)) {
							$v = iunserializer($v);
						}

						if (is_array($v)) {
							foreach ($v as $k1 => &$v1) {
								if (is_serialized($v1)) {
									$v1 = iunserializer($v1);
								}
							}

							unset($v1);
						}
					}

					return $ret;
				}

				return $value;
			}
		}

		return cache_read($this->get_key($key, $uniacid));
	}

	public function set($key = '', $value = NULL, $uniacid = '')
	{
		if (function_exists('redis')) {
			$redis = redis();

			if (!is_error($redis)) {
				$prefix = '__iserializer__format__::';

				if (is_array($value)) {
					foreach ($value as $k => &$v) {
						if (is_serialized($v)) {
							$v = iunserializer($v);
						}
					}

					unset($v);
					$value = $prefix . iserializer($value);
				}

				$redis->set($this->get_key($key, $uniacid), $value);
				return NULL;
			}
		}

		cache_write($this->get_key($key, $uniacid), $value);
	}

	public function del($key, $uniacid = '')
	{
		if (function_exists('redis')) {
			$redis = redis();

			if (!is_error($redis)) {
				$redis->del($this->get_key($key, $uniacid));
				return NULL;
			}
		}

		cache_delete($this->get_key($key, $uniacid));
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
