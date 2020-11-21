<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}
class Index_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$domain = trim(preg_replace('/http(s)?:\\/\\//', '', rtrim($_W['siteroot'], '/')));
		$ip = gethostbyname($_SERVER['HTTP_HOST']);
		$setting = setting_load('site');
		$id = ((isset($setting['site']['key']) ? $setting['site']['key'] : '0'));
		$modname = 'ewei_shopv2';
		$auth = get_auth();
		load()->func('communication');
		if(!$id) $id = rand(56865,99999);
		if ($_W['ispost']) {
			if (empty($_GPC['domain'])) {
				show_json(0, '域名不能为空!');
			}
			if (empty($_GPC['code'])) {
				show_json(0, '请填写授权码!');
			}
			if (empty($_GPC['modname'])) {
				show_json(0,'检查模块标识是否填写正确!');
			}
			$resp = ihttp_request('http://sq.bbs.heirui.cn/mod.php?a=mod', array('ip' => $ip, 'modname' => $modname, 'code' => $_GPC['code'], 'domain' => $domain));
			$result = @json_decode($resp['content'], true);
			
			if ($result['status'] == '1') {
				$set = pdo_fetch('select id, sets from ' . tablename('ewei_shop_sysset') . ' order by id asc limit 1');
				$sets = iunserializer($set['sets']);

				if (!is_array($sets)) {
					$sets = array();
				}

				$sets['auth'] = array('ip' => $ip, 'modname' => $modname, 'code' => $_GPC['code'], 'domain' => $domain);

				if (empty($set)) {
					pdo_insert('ewei_shop_sysset', array('sets' => iserializer($sets), 'uniacid' => $_W['uniacid']));
				}
				 else {
					pdo_update('ewei_shop_sysset', array('sets' => iserializer($sets)), array('id' => $set['id']));
				}

				$result['result']['url'] = webUrl('system/auth');
				show_json(1,$result['message']);
				exit(json_encode($result));
			}else{
				if(!isset($result['status'])) show_json(0,'验证授权失败，无法连接授权服务器！');
				show_json(0,$result['message']);
			}
			exit(json_encode($result));
		}
		
		$result = array('status' => 1);

		// if (!empty($ip) && !empty($id) && !empty($auth['code'])) {
			// load()->func('communication');
			// $resp = ihttp_request(EWEI_SHOPV2_AUTH_URL, array('ip' => $ip, 'modname' => $$modname, 'code' => $auth['code'], 'domain' => $domain));
			// $result = @json_decode($resp['content'], true);
		// }
		include $this->template();
		
		// function get_auth()
		// {
		// global $_W;
		// $set = pdo_fetch('select sets from ' . tablename('ewei_shop_sysset') . ' order by id asc limit 1');
		// $sets = iunserializer($set['sets']);

		// if (is_array($sets)) {
			// return is_array($sets['auth']) ? $sets['auth'] : array();
		// }

		// return array();
		// }
	}
}
?>