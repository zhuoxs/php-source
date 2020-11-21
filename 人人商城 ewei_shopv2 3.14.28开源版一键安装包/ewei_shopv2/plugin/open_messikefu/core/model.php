<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Open_MessikefuModel extends PluginModel
{
	public function checkOpen($key = '', $plugin = '', $domain)
	{
		global $_W;
		$auth = get_auth();
		$ip = $_SERVER['HTTP_ALI_CDN_REAL_IP'];

		if (!$ip) {
			$ip = gethostbyname($domain);
		}

		$data = array('ip' => $ip, 'site_id' => $auth['id'], 'auth_key' => $auth['code'], 'domain' => $domain, 'plugins' => $plugin, 'app_key' => $key);
		$resp = ihttp_post(EWEI_SHOPV2_AUTH_URL . '/grant', $data);

		$result = json_decode($resp['content'], true);
		return $result;
	}
}

?>
