<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Package_EweiShopV2Page extends AppMobilePage
{
	/**
     * 商品列表
     */
	public function get_list()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$goodsid = intval($_GPC['goodsid']);
		$packages_goods = array();
		$packages = array();
		$goodsid_array = array();

		if ($goodsid) {
			$packages_goods = pdo_fetchall('SELECT id,pid FROM ' . tablename('ewei_shop_package_goods') . '
                    WHERE uniacid = ' . $uniacid . ' and goodsid = ' . $goodsid . ' group by pid  ORDER BY id DESC');

			foreach ($packages_goods as $key => $value) {
				$packages[$key] = pdo_fetch('SELECT id,title,thumb,price,goodsid FROM ' . tablename('ewei_shop_package') . '
                    WHERE uniacid = ' . $uniacid . ' and id = ' . $value['pid'] . ' and starttime <= ' . time() . ' and endtime >= ' . time() . ' and deleted = 0 and status = 1  ORDER BY id DESC');
			}

			$packages = array_values(array_filter($packages));
		}
		else {
			$packages = pdo_fetchall('SELECT id,title,thumb,price,goodsid FROM ' . tablename('ewei_shop_package') . '
                    WHERE uniacid = ' . $uniacid . ' and starttime <= ' . time() . ' and endtime >= ' . time() . ' and deleted = 0 and status = 1 ORDER BY id DESC');
		}

		if (empty($packages)) {
			$this->message('套餐不存在或已删除!', mobileUrl(), 'error');
		}

		foreach ($packages as $key => $value) {
			$goods = explode(',', $value['goodsid']);

			foreach ($goods as $k => $val) {
				$g = pdo_fetch('SELECT id,marketprice,title,thumb FROM ' . tablename('ewei_shop_goods') . '
                    WHERE uniacid = ' . $uniacid . ' and id = ' . $val . '  ORDER BY id DESC');
				$goods['goodsprice'] += $g['marketprice'];
				$g['thumb'] = tomedia($g['thumb']);
				$packages[$key]['goods'][$k] = $g;
			}

			$packages[$key]['goodsprice'] = $goods['goodsprice'];
		}

		$packages = set_medias($packages, array('thumb'));
		return app_json(array('list' => $packages));
	}

	public function get_detail()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$pid = intval($_GPC['pid']);
		$package = pdo_fetch('SELECT id,title,price,freight,share_title,share_icon,share_desc FROM ' . tablename('ewei_shop_package') . '
                    WHERE uniacid = ' . $uniacid . ' and id = ' . $pid . ' ');
		$packgoods = array();
		$packgoods = pdo_fetchall('SELECT id,title,thumb,marketprice,packageprice,`option`,goodsid FROM ' . tablename('ewei_shop_package_goods') . '
                    WHERE uniacid = ' . $uniacid . ' and pid = ' . $pid . '  ORDER BY id DESC');
		$packgoods = set_medias($packgoods, array('thumb'));
		$option = array();

		foreach ($packgoods as $key => $value) {
			$option_array = array();
			$option_array = explode(',', $value['option']);

			if (0 < $option_array[0]) {
				$pgo = pdo_fetch('SELECT id,title,packageprice FROM ' . tablename('ewei_shop_package_goods_option') . '
                    WHERE uniacid = ' . $uniacid . ' and pid = ' . $pid . ' and goodsid = ' . $value['goodsid'] . ' and optionid = ' . $option_array[0] . ' ');
				$packgoods[$key]['packageprice'] = $pgo['packageprice'];
			}
		}

		return app_json(array('packgoods' => $packgoods, 'package' => $package));
	}

	public function get_option()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = intval($_W['uniacid']);
		$pid = intval($_GPC['pid']);
		$goodsid = intval($_GPC['goodsid']);
		$optionid = array();
		$option = array();
		$packgoods = pdo_fetch('SELECT id,title,`option` FROM ' . tablename('ewei_shop_package_goods') . '
                    WHERE uniacid = ' . $uniacid . ' and goodsid = ' . $goodsid . ' and pid = ' . $pid . '  ORDER BY id DESC');
		$optionid = explode(',', $packgoods['option']);

		foreach ($optionid as $key => $value) {
			$option[$key] = pdo_fetch('SELECT id,title,packageprice,optionid,goodsid FROM ' . tablename('ewei_shop_package_goods_option') . '
                    WHERE pid = :pid and goodsid = :goodsid and uniacid = :uniacid and optionid = :optionid ORDER BY id DESC', array(':goodsid' => $goodsid, ':optionid' => intval($value), ':uniacid' => $uniacid, ':pid' => $pid));
		}

		$option = array_filter($option);
		return app_json(array('option' => $option));
	}
}

?>
