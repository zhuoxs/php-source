<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Detail_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$status = intval($_GPC['status']);
		$merchid = $_W['merchid'];
		$apply_type = array(0 => '微信钱包', 2 => '支付宝', 3 => '银行卡');
		$item = $this->model->getOneApply($id);
		$orderids = iunserializer($item['orderids']);
		$keyword = trim($_GPC['keyword']);
		$list = array();

		foreach ($orderids as $key => $value) {
			$data = $this->model->getMerchPriceList($item['merchid'], $value, 10);

			if (!empty($data)) {
				$flag = 1;

				if (!empty($keyword)) {
					if (strpos(trim($data['ordersn']), $keyword) !== false) {
						$flag = 1;
					}
					else {
						$flag = 0;
					}
				}

				if ($flag) {
					$list[] = $data;
				}
			}
		}

		if ($_GPC['export'] == '1') {
			foreach ($list as &$row) {
				$row['finishtime'] = date('Y-m-d H:i', $row['finishtime']);
			}

			$columns = array();
			$columns[] = array('title' => '订单编号', 'field' => 'ordersn', 'width' => 24);
			$columns[] = array('title' => '可提现金额', 'field' => 'realprice', 'width' => 24);
			$columns[] = array('title' => '抽成比例', 'field' => 'payrate', 'width' => 12);
			$columns[] = array('title' => '抽成后获得金额', 'field' => 'realpricerate', 'width' => 24);
			$columns[] = array('title' => '订单完成时间', 'field' => 'finishtime', 'width' => 24);
			$columns[] = array('title' => '订单商品总额', 'field' => 'goodsprice', 'width' => 24);
			$columns[] = array('title' => '快递金额', 'field' => 'dispatchprice', 'width' => 24);
			$columns[] = array('title' => '积分抵扣金额', 'field' => 'deductprice', 'width' => 24);
			$columns[] = array('title' => '余额抵扣金额', 'field' => 'deductcredit2', 'width' => 24);
			$columns[] = array('title' => '会员折扣金额', 'field' => 'discountprice', 'width' => 24);
			$columns[] = array('title' => '促销金额', 'field' => 'isdiscountprice', 'width' => 24);
			$columns[] = array('title' => '满减金额', 'field' => 'deductenough', 'width' => 24);
			$columns[] = array('title' => '实际支付金额', 'field' => 'price', 'width' => 24);
			$columns[] = array('title' => '商户满减金额', 'field' => 'merchdeductenough', 'width' => 24);
			$columns[] = array('title' => '商户优惠券金额', 'field' => 'merchcouponprice', 'width' => 24);
			$columns[] = array('title' => '分销佣金', 'field' => 'commission', 'width' => 24);
			m('excel')->export($list, array('title' => '提现申请订单数据-' . date('Y-m-d-H-i', time()), 'columns' => $columns));
		}

		include $this->template();
	}
}

?>
