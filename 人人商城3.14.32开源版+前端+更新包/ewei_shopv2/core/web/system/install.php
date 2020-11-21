<?php

/*
 * 人人商城V2
 * 
 * @author ewei 狸小狐 QQ:22185157 
 */
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Install_EweiShopV2Page extends SystemPage {

	function main() {

		global $_W,$_GPC;
		$domain = trim( preg_replace( "/http(s)?:\/\//", "", rtrim($_W['siteroot'],"/") )  );
		$ip = gethostbyname($_SERVER['HTTP_HOST']);
		$setting = setting_load('site');
		$id = isset($setting['site']['key']) ? $setting['site']['key'] : '0';
		$auth = get_auth();
		load()->func('communication');
		if ($_W['ispost']) {
			 
			if (empty($_GPC['domain'])) {
				show_json(0,'域名不能为空!');
			}
			if (empty($_GPC['code'])) {
				show_json(0,'请填写授权码!');
			}
			if (empty($_GPC['id'])) {
				show_json('您还没未注册站点!');
			}
			$resp = ihttp_request(EWEI_SHOPV2_AUTH_URL , array( 'ip' => $ip, 'id' => $id, 'code' => $_GPC['code'], 'domain' => $domain));
			$result = @json_decode($resp['content'],true);
			
			if ($result['status'] == '1') {
				$set = pdo_fetch('select id, sets from ' . tablename('ewei_shop_sysset') . ' order by id asc limit 1');
				$sets = iunserializer($set['sets']);
				if (!is_array($sets)) {
					$sets = array();
				}
				$sets['auth'] = array(
					'ip' => $ip,
					'id' => $id,
					'code' => $_GPC['code'],
					'domain' =>$domain
				);
				if (empty($set)) {
					pdo_insert('ewei_shop_sysset', array('sets' => iserializer($sets), 'uniacid' => $_W['uniacid']));
				} else {
					pdo_update('ewei_shop_sysset', array('sets' => iserializer($sets)), array('id' => $set['id']));
				}
				$result['result']['url'] = webUrl('system/install');
				die(json_encode($result));
			}
			die(json_encode($result));
		}
		$result = array('status'=>0);
		if (!empty($ip) && !empty($id) && !empty($auth['code'])) {
			load()->func('communication');
			$resp = ihttp_request(EWEI_SHOPV2_AUTH_URL , array('ip' => $ip, 'id' => $id, 'code' => $auth['code'], 'domain' => $domain));
			$result = @json_decode($resp['content'],true);
		}
		if(!empty($result['status'])){
			$versionfile = IA_ROOT . '/addons/ewei_shopv2/version.php';
			$updatedate = date('Y-m-d H:i', filemtime($versionfile));
			$version = EWEI_SHOPV2_VERSION;
			$release = EWEI_SHOPV2_RELEASE;
		}
			
		include $this->template();
	}

}
