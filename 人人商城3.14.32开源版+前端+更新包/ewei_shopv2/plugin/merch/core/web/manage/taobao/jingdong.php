<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Jingdong_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$this->model->CheckPlugin('taobao');
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_category') . ' WHERE `uniacid` = :uniacid ORDER BY `parentid`, `displayorder` DESC';
		$category = m('shop')->getFullCategory(true, true);
		$set = m('common')->getSysset(array('shop'));
		$shopset = $set['shop'];
		load()->func('tpl');
		include $this->template();
	}

	public function fetch()
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
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

		$taobao_plugin = p('taobao');
		$ret = $taobao_plugin->get_item_jingdong($itemid, $_GPC['url'], $cates, $merchid);
		plog('jingdong.main', '京东抓取宝贝 京东id:' . $itemid);
		exit(json_encode($ret));
	}
}

?>
