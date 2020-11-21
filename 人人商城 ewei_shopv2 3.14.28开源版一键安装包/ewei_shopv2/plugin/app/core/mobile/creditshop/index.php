<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Index_EweiShopV2Page extends AppMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		$contation = ' uniacid=:uniacid ';

		if (0 < intval($_GPC['merchid'])) {
			$contation .= 'and merchid = ' . intval($_GPC['merchid']) . ' ';
		}

		$data = array();
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$shop = m('common')->getSysset('shop');
		$advs = pdo_fetchall('select id,advname,link,thumb from ' . tablename('ewei_shop_creditshop_adv') . ' where ' . $contation . ' and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$advs = set_medias($advs, 'thumb');
		$data['advs'] = $advs;
		$category = array();

		if (0 < intval($_GPC['merchid'])) {
			$merch_category = p('merch')->getSet('merch_creditshop_category', $_GPC['merchid']);

			if (!empty($merch_category)) {
				$i = 0;

				foreach ($merch_category as $index => $row) {
					if (0 < $row) {
						$list = pdo_fetch('select id,name,thumb,isrecommand from ' . tablename('ewei_shop_creditshop_category') . '
						where id = ' . $index . ' and uniacid=:uniacid and  enabled=1 ', array(':uniacid' => $uniacid));
						$list = set_medias($list, 'thumb');
						$category[$i] = $list;
						++$i;
					}
				}
			}
		}
		else {
			$category = pdo_fetchall('select id,name,thumb,isrecommand from ' . tablename('ewei_shop_creditshop_category') . ' where uniacid=:uniacid and  enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
			$category = set_medias($category, 'thumb');
		}

		array_values($category);
		$data['category'] = $category;
		$lotterydraws = pdo_fetchall('select id, title,goodstype, subtitle, credit, money, thumb,`type`,price from ' . tablename('ewei_shop_creditshop_goods') . '
				where ' . $contation . ' and isrecommand = 1 and `type` = 1 and  status=1 and deleted=0 order by displayorder,id desc limit 4', array(':uniacid' => $uniacid));
		$lotterydraws = set_medias($lotterydraws, 'thumb');
		is_array($lotterydraws) ? $lotterydraws : ($lotterydraws = array());

		foreach ($lotterydraws as $key => $value) {
			$lotterydraws[$key]['money'] = price_format($value['money'], 2);
		}

		$data['lotterydraws'] = $lotterydraws;
		$exchanges = pdo_fetchall('select id, title,goodstype, subtitle, credit, money, thumb,`type` from ' . tablename('ewei_shop_creditshop_goods') . '
				where ' . $contation . ' and isrecommand = 1 and goodstype = 0 and `type` = 0 and status=1 and deleted=0 order by id,displayorder desc limit 4', array(':uniacid' => $uniacid));
		$exchanges = set_medias($exchanges, 'thumb');
		is_array($exchanges) ? $exchanges : ($exchanges = array());

		foreach ($exchanges as $key => $value) {
			$exchanges[$key]['money'] = price_format($value['money'], 2);
		}

		$data['exchanges'] = $exchanges;
		$coupons = pdo_fetchall('select id, title, subtitle, credit, money, thumb,`type` from ' . tablename('ewei_shop_creditshop_goods') . '
				where ' . $contation . ' and isrecommand = 1 and goodstype = 1 and `type` = 0 and status=1 and deleted=0 order by id,displayorder desc limit 4', array(':uniacid' => $uniacid));
		$coupons = set_medias($coupons, 'thumb');
		is_array($coupons) ? $coupons : ($coupons = array());

		foreach ($coupons as $key => $value) {
			$coupons[$key]['money'] = price_format($value['money'], 2);
		}

		$data['coupons'] = $coupons;
		$balances = pdo_fetchall('select id, title, subtitle, credit, money, thumb,`type` from ' . tablename('ewei_shop_creditshop_goods') . '
				where ' . $contation . ' and isrecommand = 1 and goodstype = 2 and `type` = 0 and status=1 and deleted=0 order by id,displayorder desc limit 4', array(':uniacid' => $uniacid));
		$balances = set_medias($balances, 'thumb');
		is_array($balances) ? $balances : ($balances = array());

		foreach ($balances as $key => $value) {
			$balances[$key]['money'] = price_format($value['money'], 2);
		}

		$data['balances'] = $balances;
		$redbags = pdo_fetchall('select id, title, subtitle, credit, money, thumb,`type` from ' . tablename('ewei_shop_creditshop_goods') . '
				where ' . $contation . ' and isrecommand = 1 and goodstype = 3 and `type` = 0 and  status=1 and deleted=0 order by id,displayorder desc limit 4', array(':uniacid' => $uniacid));
		$redbags = set_medias($redbags, 'thumb');
		is_array($redbags) ? $redbags : ($redbags = array());

		foreach ($redbags as $key => $value) {
			$redbags[$key]['money'] = price_format($value['money'], 2);
		}

		$data['redbags'] = array();
		return app_json(array('data' => $data, 'is_openmerch' => $is_openmerch));
	}
}

?>
