<?php
//QQ63779278
class Ordergoods_EweiShopV2Model
{
	/**
     * 计算订单中商品累计赠送的积分
     * @param type $order
     */
	public function getGoodsCredit1($goods)
	{
		$credit1 = 0;
		$gcredit = trim($goods['credit']);

		if (!empty($gcredit)) {
			if (strexists($gcredit, '%')) {
				$credit1 += intval(floatval(str_replace('%', '', $gcredit)) / 100 * $goods['realprice']);
			}
			else {
				$credit1 += intval($goods['credit']) * $goods['total'];
			}
		}

		return $credit1;
	}

	/**
     * 计算订单中商品累计赠送的余额
     * @param type $order
     */
	public function getGoodsCredit2($goods)
	{
		$credit2 = 0;
		$gbalance = trim($goods['money']);

		if (!empty($gbalance)) {
			if (strexists($gbalance, '%')) {
				$credit2 += round(floatval(str_replace('%', '', $gbalance)) / 100 * $goods['realprice'], 2);
			}
			else {
				$credit2 += round($goods['money'], 2) * $goods['total'];
			}
		}

		return $credit2;
	}

	/**
     * //处理订单库存情况(单品退换货)
     * @param type $goods
     */
	public function setStock($goods)
	{
		global $_W;

		if (!empty($goods['optionid'])) {
			$option = m('goods')->getOption($goods['goodsid'], $goods['optionid']);
			if (!empty($option) && $option['stock'] != -1) {
				$stock = $option['stock'] + $goods['total'];

				if (!empty($stock)) {
					pdo_update('ewei_shop_goods_option', array('stock' => $stock), array('uniacid' => $_W['uniacid'], 'goodsid' => $goods['goodsid'], 'id' => $goods['optionid']));
				}
			}
		}

		$totalstock = $goods['goodstotal'] + $goods['total'];

		if (!empty($totalstock)) {
			pdo_update('ewei_shop_goods', array('total' => $totalstock), array('uniacid' => $_W['uniacid'], 'id' => $goods['goodsid']));
		}
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
