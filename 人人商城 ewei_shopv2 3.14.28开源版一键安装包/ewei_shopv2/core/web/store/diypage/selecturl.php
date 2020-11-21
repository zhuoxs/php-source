<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Selecturl_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$full = intval($_GPC['full']);
		$storeid = intval($_W['storeid']);
		$syscate = m('common')->getSysset('category');

		if (0 < $syscate['level']) {
			$categorys = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_category') . ' WHERE uniacid=:uniacid  ORDER BY parentid ASC, displayorder DESC', array(':uniacid' => $_W['uniacid']));
		}

		$goodsgroup = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_newstore_goodsgroup') . ' WHERE uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
		$diypage = p('diypage')->getPageList('allpage');
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
			else {
				if ($type == 'coupon') {
					$list = pdo_fetchall('select id,couponname,coupontype from ' . tablename('ewei_shop_coupon') . ' where couponname LIKE :title and uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':title' => '%' . $kw . '%'));
				}
			}
		}

		include $this->template('store/diypage/selecturl_tpl');
	}
}

?>
