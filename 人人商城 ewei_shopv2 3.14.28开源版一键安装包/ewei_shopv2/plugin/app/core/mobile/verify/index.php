<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Index_EweiShopV2Page extends AppMobilePage
{
	public function qrcode()
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC['id']);
		$verifycode = $_GPC['verifycode'];
		$query = array('id' => $orderid, 'verifycode' => $verifycode);
		$url = mobileUrl('verify/detail', $query, true);
		$sets = m('common')->getSysset(array('app'));

		if (array_key_exists('verifyurl', $sets['app'])) {
			$verifyurl = $sets['app']['verifyurl'];
			$str = preg_match('/\\/app\\/.*/', $url, $match);
			if ($str && !empty($verifyurl)) {
				$url = $verifyurl . $match[0];
			}
		}

		return app_json(array('url' => m('qrcode')->createQrcode($url)));
	}
}

?>
