<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Newrelease_EweiShopV2Page extends PluginWebPage
{
	private $key = 'asdf734JH3464tr56GJ';

	public function main()
	{
		global $_W;
		$error = NULL;
		$auth = $this->getAuth();

		if (is_error($auth)) {
			$error = $auth['message'];
		}
		else {
			$is_auth = is_array($auth) ? $auth['is_auth'] : false;
			$authUrl = EWEI_SHOPV2_AUTH_WXAPP . 'auth/auth?id=' . $auth['id'];

			if ($is_auth) {
				$release = $this->model->getRelease($auth['id']);
			}

			$list = $this->model->getReleaseList();

			if (is_error($list)) {
				$error = $list['message'];
			}
			else {
				if (empty($list)) {
					$error = '未查询到授权小程序';
				}
			}

			$log = pdo_fetchall('select * from ' . tablename('ewei_shop_upwxapp_log') . ' where uniacid=:uniacid and type=1 order by id desc', array(':uniacid' => $_W['uniacid']));
			$test_code = IA_ROOT . '/addons/ewei_shopv2/plugin/app/static/images/test_code_' . $_W['uniacid'] . '.jpg';
			$version_time = 0;
			if (!filemtime($test_code) || filemtime($test_code) + 1490 < time()) {
				$is_expire = 1;
			}
			else {
				$version_time = filemtime($test_code);
			}

			$wxcode = IA_ROOT . '/addons/ewei_shopv2/plugin/app/static/images/wxcode_' . $_W['uniacid'] . '.jpg';
			if (!filemtime($wxcode) || filemtime($wxcode) + 7200 < time()) {
				$accessToken = $this->model->getAccessToken();

				if (is_error($accessToken)) {
					$error = $accessToken['message'];
				}
				else {
					load()->func('communication');
					$result = ihttp_post('https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $accessToken, json_encode(array('scene' => 'index', 'path' => 'pages/index/index')));
					file_put_contents($wxcode, $result['content']);
				}
			}
		}

		include $this->template();
	}

	public function upload()
	{
		global $_W;
		global $_GPC;
		$sets = m('common')->getSysset(array('app'));
		$appid = $sets['app']['appid'];

		if (empty($appid)) {
			header('location: ' . webUrl('app/setting'));
		}

		$last_log = pdo_fetch('select * from ' . tablename('ewei_shop_upwxapp_log') . ' where uniacid=:uniacid and type=1 order by id desc limit 1', array(':uniacid' => $_W['uniacid']));
		@session_start();
		$ticket = $_SESSION['wxapp_new_ticket'];

		if (empty($ticket)) {
			$need_scan = 1;
			load()->func('communication');
			$res = ihttp_get(EWEI_SHOPV2_AUTH_WXAPP . 'generate/getqrcode');
			$content = json_decode($res['content'], true);

			if (!empty($content)) {
				$uuid = $content['uuid'];
				$qrcode = $content['qrcode'];
			}
		}
		else {
			$need_scan = 0;
		}

		$auth = get_auth();
		$response = ihttp_get(EWEI_SHOPV2_AUTH_WXAPP . 'generate/check-version?site_id=' . $auth['id']);

		if (!empty($response['content'])) {
			$content = $response['content'];
			$ret = json_decode($content, true);

			if ($ret['errno'] == -1) {
				$this->message($ret['errmsg']);
			}
		}

		include $this->template();
	}

	public function getstatus()
	{
		global $_W;
		global $_GPC;
		load()->func('communication');
		$uuid = $_GPC['uuid'];

		if (empty($uuid)) {
			show_json(0);
		}

		$res = ihttp_get(EWEI_SHOPV2_AUTH_WXAPP . 'generate/getstatus?uuid=' . $uuid);
		$content = json_decode($res['content'], true);

		if (empty($content['status'])) {
			show_json(0);
		}

		show_json(1, array('wx_errcode' => $content['wx_errcode'], 'wx_code' => $content['wx_code']));
	}

	public function getticket()
	{
		global $_W;
		global $_GPC;
		load()->func('communication');
		$code = $_GPC['code'];

		if (empty($code)) {
			show_json(0);
		}

		$res = ihttp_get(EWEI_SHOPV2_AUTH_WXAPP . 'generate/getticket?code=' . $code);
		$content = json_decode($res['content'], true);
		if (!empty($content['status']) && !empty($content['new_ticket'])) {
			@session_start();
			$_SESSION['wxapp_new_ticket'] = $content['new_ticket'];
		}
		else {
			show_json(0, 'ticket获取失败');
		}

		show_json(1, array('new_ticket' => $content['new_ticket']));
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$version = $_GPC['version'];

		if (empty($version)) {
			show_json(0, '版本号不能为空！');
		}

		$describe = $_GPC['describe'];

		if (empty($describe)) {
			show_json(0, '版本描述不能为空！');
		}

		$isGoods = intval($_GPC['is_goods']);
		@session_start();
		$ticket = $_SESSION['wxapp_new_ticket'];

		if (empty($ticket)) {
			show_json(0, 'ticket为空，请刷新后重试！');
		}

		$auth = $this->getAuth();

		if (is_error($auth)) {
			show_json(0, '未查询到授权信息！');
		}

		$tabBar = '';
		$app_set = m('common')->getSysset('app');

		if (!empty($app_set)) {
			if (!empty($app_set['tabbar'])) {
				$app_set['tabbar'] = iunserializer($app_set['tabbar']);

				if (!empty($app_set['tabbar'])) {
					$tabBar = $app_set['tabbar'];
				}
			}
		}

		if (is_array($tabBar)) {
			if (is_array($tabBar['list'])) {
				foreach ($tabBar['list'] as $index => &$item) {
					$item['pagePath'] = ltrim($item['pagePath'], '/');
				}

				unset($index);
				unset($item);
			}

			$tabBar = json_encode($tabBar);
		}

		$diy_str = '';
		$list = pdo_fetchall('SELECT `data` FROM ' . tablename('ewei_shop_wxapp_page') . ' WHERE uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));

		foreach ($list as $li) {
			$diy_str .= base64_decode($li['data']);
		}

		preg_match_all('/"appid:(\\w*)/', $diy_str, $appid_arr);
		$appIds = '';

		if (isset($appid_arr[1])) {
			$appid_arr[1] = array_values(array_unique($appid_arr[1]));
			$appIds = json_encode($appid_arr[1]);
		}

		load()->func('communication');
		ihttp_request(EWEI_SHOPV2_AUTH_WXAPP . 'generate/upload?id=' . $auth['id'], array('version' => $version, 'describe' => $describe, 'tabBar' => $tabBar, 'ticket' => $ticket, 'appIds' => $appIds, 'is_goods' => $isGoods), array('Content-Type' => 'application/x-www-form-urlencoded'), 3);
		$data['uniacid'] = $_W['uniacid'];
		$data['type'] = 1;
		$data['is_goods'] = $isGoods;
		$data['version'] = $version;
		$data['describe'] = $describe;
		$data['version_time'] = time();
		pdo_insert('ewei_shop_upwxapp_log', $data);
		show_json(1);
	}

	public function uploadstatus()
	{
		global $_W;
		global $_GPC;
		$auth = $this->getAuth();

		if (is_error($auth)) {
			show_json(-1, '未查询到授权信息！');
		}

		load()->func('communication');
		$response = ihttp_get(EWEI_SHOPV2_AUTH_WXAPP . 'generate/uploadstatus?id=' . $auth['id']);

		if (empty($response)) {
			show_json(-1, '请刷新后重试！');
		}
		else {
			$data = json_decode($response['content'], true);

			if (intval($data['status']) == 202) {
				show_json(202);
			}
			else if (intval($data['status']) != 1) {
				if (intval($data['status']) == 402 || intval($data['status']) == 403) {
					@session_start();
					$_SESSION['wxapp_new_ticket'] = NULL;
				}

				show_json(-1, $data['errmsg']);
			}
			else {
				$wxcode = IA_ROOT . '/addons/ewei_shopv2/plugin/app/static/images/test_code_' . $_W['uniacid'] . '.jpg';
				file_put_contents($wxcode, base64_decode($data['testcode']));
				show_json(1);
			}
		}
	}

	public function deletes()
	{
		global $_W;
		global $_GPC;
		@session_start();
		$_SESSION['wxapp_new_ticket'] = NULL;
	}

	public function wechatset()
	{
		include $this->template();
	}

	public function getAuth()
	{
		global $_W;
		global $_GPC;
		$key = 'app_auth' . $_W['uniacid'];
		@session_start();
		$auth = $_SESSION[$key];
		if (empty($auth) || is_error($auth)) {
			$auth = $this->model->getAuth();
			@session_start();
			$_SESSION[$key] = $auth;
		}

		return $auth;
	}
}

?>
