<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Source_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$article_sys = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_article_sys') . ' WHERE uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid']));

		if (empty($article_sys['article_source'])) {
			$sourceUrl = '../addons/ewei_shopv2/plugin/article/static/images';
		}
		else {
			$sourceUrl = $article_sys['article_source'];
			$endstr = substr($sourceUrl, -1);

			if ($endstr == '/') {
				$sourceUrl = rtrim($sourceUrl, '/');
			}
		}

		include $this->template();
	}
}

?>
