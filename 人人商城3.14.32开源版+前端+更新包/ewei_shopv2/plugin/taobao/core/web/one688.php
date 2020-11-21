<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class One688_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_category') . ' WHERE `uniacid` = :uniacid ORDER BY `parentid`, `displayorder` DESC';
		$category = m('shop')->getFullCategory(true, true);
		$shopset = $_W['shopset']['shop'];
		load()->func('tpl');
		include $this->template();
	}

	public function fetch()
	{
		global $_GPC;
		global $_W;
		set_time_limit(0);
		$ret = array();
		$url = $_GPC['url'];
		$cates = $_GPC['cate'];

		if (is_numeric($url)) {
			$itemid = $url;
		}
		else {
			preg_match('/(\\d+).html/i', $url, $matches);

			if (isset($matches[1])) {
				$itemid = $matches[1];
			}
		}

		if (empty($itemid)) {
			exit(json_encode(array('result' => 0, 'error' => '未获取到 itemid!')));
		}

		$ret = $this->model->get_item_one688($itemid, $_GPC['url'], $cates, $_W['merchid']);
		plog('1688.main', '1688抓取宝贝 1688id:' . $itemid);
		exit(json_encode($ret));
	}
}

?>
