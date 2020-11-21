<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if (cv('taobao.main')) {
			$sql = 'SELECT * FROM ' . tablename('ewei_shop_category') . ' WHERE `uniacid` = :uniacid ORDER BY `parentid`, `displayorder` DESC';
			$category = m('shop')->getFullCategory(true, true);
			$shopset = $_W['shopset']['shop'];
			load()->func('tpl');
			include $this->template();
		}
		else if (cv('taobao.jingdong')) {
			header('location: ' . webUrl('taobao/jingdong'));
			exit();
		}
		else if (cv('taobao.one688')) {
			header('location: ' . webUrl('taobao/one688'));
			exit();
		}
		else {
			if (cv('taobao.taobaocsv')) {
				header('location: ' . webUrl('taobao/taobaocsv'));
				exit();
			}
		}
	}

	public function fetch()
	{
		global $_GPC;
		set_time_limit(0);
		$ret = array();
		$url = $_GPC['url'];
		$cates = $_GPC['cate'];
		$from = $_GPC['from'];

		if (is_numeric($url)) {
			$itemid = $url;
		}
		else {
			preg_match('/id\\=(\\d+)/i', $url, $matches);

			if (isset($matches[1])) {
				$itemid = $matches[1];
			}
		}

		if (empty($itemid)) {
			exit(json_encode(array('result' => 0, 'error' => '未获取到 itemid!')));
		}

		if ($from == 'all') {
			$ret = $this->model->get_item_taobao($itemid, $_GPC['url'], $cates);
		}
		else if ($from == 'tmall') {
			$ret = $this->model->get_item_tmall_bypage($itemid, $_GPC['url'], $cates);
		}
		else {
			if ($from == 'taobao') {
				$ret = $this->model->get_item_taobao($itemid, $_GPC['url'], $cates);
			}
		}

		plog('taobao.main', '淘宝抓取宝贝 淘宝id:' . $itemid);
		exit(json_encode($ret));
	}

	public function set()
	{
		global $_W;
		global $_GPC;
		$setting = setting_load('site');
		$site_id = isset($setting['site']['key']) ? $setting['site']['key'] : (isset($setting['key']) ? $setting['key'] : '0');
		$time = time();
		$sign_str = md5(md5('site_id=' . $site_id . '&request_time=' . $time . '&salt=FOXTEAM_AUTH'));
		load()->func('communication');
		//$result = ihttp_post('https://u.we7shop.com/api/platform/geturl', array('site' => $site_id, 'time' => $time, 'sign' => $sign_str));
		$content = json_decode($result['content'], true);
		$siteroot = $content['errmsg'];

		if (empty($siteroot)) {
			$siteroot = $_W['siteroot'];
		}

		if ($_W['ispost']) {
			$status = intval($_GPC['status']);
			m('common')->updatePluginset(array(
				'taobao' => array('taobao_status' => $status)
			));
			show_json(1);
		}

		$data = m('common')->getPluginset('taobao');
		include $this->template();
	}
}

?>
