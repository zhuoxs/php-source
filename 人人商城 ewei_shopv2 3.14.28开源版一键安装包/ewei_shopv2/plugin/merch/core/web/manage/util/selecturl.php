<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Selecturl_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$full = intval($_GPC['full']);
		$merchid = intval($_W['merchid']);
		$syscate = m('common')->getSysset('category');
		if (isset($_GPC['type']) && !empty($_GPC['type'])) {
			$type = $_GPC['type'];
		}

		if (0 < $syscate['level']) {
			$categorys = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_category') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY parentid ASC, displayorder DESC'));
			$merch_category = $this->getSet('merch_category');
			$groups = pdo_fetchall('SELECT id,name FROM ' . tablename('ewei_shop_goods_group') . (' WHERE enabled=:enabled AND merchid = ' . $merchid . ' AND  uniacid= :uniacid '), array(':uniacid' => $_W['uniacid'], ':enabled' => '1'));

			if (!empty($merch_category)) {
				foreach ($categorys as $index => $row) {
					if (array_key_exists($row['id'], $merch_category)) {
						if (empty($merch_category[$row['id']])) {
							unset($categorys[$index]);
						}
					}
				}
			}
		}

		if (p('diypage')) {
			if ($type == 'topmenu') {
				$diypage = p('diypage')->getPageList('allpage', ' and (`type` = 1 or `type` = 2)');

				if (!empty($diypage)) {
					foreach ($diypage['list'] as $k => $v) {
						$pages = json_decode(base64_decode($v['data']), true);

						foreach ($pages['items'] as $pk => $pv) {
							if ($pv['id'] == 'topmenu') {
								unset($diypage['list'][$k]);
							}
						}
					}
				}

				$allpagetype = p('diypage')->getPageType();
			}
			else {
				$diypage = p('diypage')->getPageList('allpage', ' and `type`<5');
				$allpagetype = p('diypage')->getPageType();
			}
		}

		if (p('quick')) {
			$quickList = p('quick')->getPageList($_W['merchid']);
		}

		include $this->template();
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$type = trim($_GPC['type']);
		$kw = trim($_GPC['kw']);
		$full = intval($_GPC['full']);
		if (!empty($kw) && !empty($type)) {
			if ($type == 'good') {
				$list = pdo_fetchall('SELECT id,title,productprice,marketprice,thumb,sales,unit,minprice FROM ' . tablename('ewei_shop_goods') . ' WHERE merchid=:merchid and uniacid= :uniacid and status=:status and deleted=0 AND title LIKE :title ', array(':title' => '%' . $kw . '%', ':merchid' => intval($_W['merchid']), ':uniacid' => $_W['uniacid'], ':status' => '1'));
				$list = set_medias($list, 'thumb');
			}
			else if ($type == 'article') {
				$list = array();
			}
			else if ($type == 'coupon') {
				$list = pdo_fetchall('select id,couponname,coupontype from ' . tablename('ewei_shop_coupon') . ' where couponname LIKE :title and uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':title' => '%' . $kw . '%'));
			}
			else if ($type == 'groups') {
				$list = array();
			}
			else {
				if ($type == 'sns') {
					$list = array();
				}
			}
		}

		include $this->template('util/selecturl_tpl');
	}
}

?>
