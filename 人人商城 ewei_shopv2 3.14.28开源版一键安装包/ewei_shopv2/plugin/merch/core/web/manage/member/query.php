<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Query_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid';

		if (!empty($kwd)) {
			$condition .= ' AND (`realname` LIKE :keyword or `nickname` LIKE :keyword or `mobile` LIKE :keyword)';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member') . (' WHERE 1 ' . $condition . ' order by id asc'), $params);
		if (!empty($ds) && is_array($ds)) {
			foreach ($ds as &$value) {
				$value['nickname'] = htmlspecialchars($value['nickname'], ENT_QUOTES);
				$value['nickname_wechat'] = htmlspecialchars($value['nickname_wechat'], ENT_QUOTES);
			}
		}

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
		exit();
	}
}

?>
