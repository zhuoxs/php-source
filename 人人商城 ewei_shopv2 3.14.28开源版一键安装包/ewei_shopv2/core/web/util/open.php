<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Open_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$plugin = $_GPC['plugin'];
		$title = $_GPC['title'];
		$domain = trim(preg_replace('/http(s)?:\\/\\//', '', trim($_GPC['domain'], '/')));
		$key = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_open_plugin') . ' WHERE plugin = :plugin', array(':plugin' => $plugin));

		if (empty($plugin)) {
			header('Location: ' . webUrl());
		}

		$redis = redis();
		if (!function_exists('redis') || is_error($redis)) {
			$this->message('请联系管理员开启 redis 支持，才能使用第三方插件', '', 'error');
			exit();
		}

		if ($_W['ispost']) {
			$key = $_GPC['key'];

			if ($key) {
				$res = $this->checkOpen($key, $plugin, $domain);
				if ($res && $res['errno'] == -1) {
					show_json(0, $res['errmsg']);
				}

				$redis_key = $plugin;

				if (!is_error($redis)) {
					if ($redis->setnx($redis_key, time())) {
						$redis->expireAt($redis_key, time() + 172800);
					}
				}

				$num = pdo_get('ewei_shop_open_plugin', array('plugin' => $plugin), 'status');

				if (!empty($num)) {
					pdo_update('ewei_shop_open_plugin', array('status' => 1, 'expirtime' => time() + 172800), array('plugin' => $plugin));
					show_json(1, array('url' => webUrl($plugin)));
				}

				$data = array('plugin' => $plugin, 'key' => $key, 'expirtime' => time(), 'status' => 1, 'url' => json_encode($_GPC['url']), 'domain' => $domain);
				pdo_insert('ewei_shop_open_plugin', $data);
				$id = pdo_insertid();

				if ($id) {
					show_json(1, array('url' => webUrl($plugin)));
				}
			}
		}

		include $this->template('util/open');
	}

	private function checkOpen($key = '', $plugin = '', $domain = '')
	{
		global $_W;
		$auth = get_auth();
		$ip = $_SERVER['HTTP_ALI_CDN_REAL_IP'];

		if (!$ip) {
			$ip = gethostbyname($domain);
		}

		$data = array('ip' => $ip, 'site_id' => $auth['id'], 'auth_key' => $auth['code'], 'domain' => $domain, 'plugins' => $plugin, 'app_key' => $key);
		$resp = ihttp_post(EWEI_SHOPV2_AUTH_URL . '/grant', $data);

		if (empty($resp['content'])) {
			return array('errno' => -1, 'errmsg' => '访问失败');
		}

		$result = json_decode($resp['content'], true);
		return $result;
	}
}

?>
