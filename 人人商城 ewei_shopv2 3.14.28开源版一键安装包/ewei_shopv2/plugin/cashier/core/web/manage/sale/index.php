<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/page_cashier.php';
class Index_EweiShopV2Page extends CashierWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = $_GPC['data'];
			$data['randtime']['start'] = strtotime($_GPC['randtime']['start']);
			$data['randtime']['end'] = strtotime($_GPC['randtime']['end']);
			$data['enoughtime']['start'] = strtotime($_GPC['enoughtime']['start']);
			$data['enoughtime']['end'] = strtotime($_GPC['enoughtime']['end']);
			$data['discounttime']['start'] = strtotime($_GPC['discounttime']['start']);
			$data['discounttime']['end'] = strtotime($_GPC['discounttime']['end']);
			$data['coupontime']['start'] = strtotime($_GPC['coupontime']['start']);
			$data['coupontime']['end'] = strtotime($_GPC['coupontime']['end']);

			if (!empty($data['randtime']['start1'])) {
				$data['randtime']['start1'] = $this->intdata($data['randtime']['start1']);
				$data['randtime']['start2'] = $this->intdata($data['randtime']['start2']);
				$data['randtime']['end1'] = $this->intdata($data['randtime']['end1']);
				$data['randtime']['end2'] = $this->intdata($data['randtime']['end2']);
			}

			if (!empty($data['enoughtime']['start1'])) {
				$data['enoughtime']['start1'] = $this->intdata($data['enoughtime']['start1']);
				$data['enoughtime']['start2'] = $this->intdata($data['enoughtime']['start2']);
				$data['enoughtime']['end1'] = $this->intdata($data['enoughtime']['end1']);
				$data['enoughtime']['end2'] = $this->intdata($data['enoughtime']['end2']);
			}

			if (!empty($data['discounttime']['start1'])) {
				$data['discounttime']['start1'] = $this->intdata($data['discounttime']['start1']);
				$data['discounttime']['start2'] = $this->intdata($data['discounttime']['start2']);
				$data['discounttime']['end1'] = $this->intdata($data['discounttime']['end1']);
				$data['discounttime']['end2'] = $this->intdata($data['discounttime']['end2']);
			}

			if (!empty($data['coupontime']['start1'])) {
				$data['coupontime']['start1'] = $this->intdata($data['coupontime']['start1']);
				$data['coupontime']['start2'] = $this->intdata($data['coupontime']['start2']);
				$data['coupontime']['end1'] = $this->intdata($data['coupontime']['end1']);
				$data['coupontime']['end2'] = $this->intdata($data['coupontime']['end2']);
			}

			if (!empty($data['rand']['rand_left']) || !empty($data['rand']['rand_right']) || !empty($data['rand']['rand'])) {
				$rand = $data['rand']['rand'];
				$rand_sum = 0;
				$i = 0;

				while ($i < count($rand)) {
					$rand_sum += $rand[$i];
					++$i;
				}

				if ($rand_sum != 100) {
					show_json(0, '概率相加必须为100%');
				}
			}
			else {
				$data['rand'] = '';
			}

			$data['enoughmoney'] = round(floatval($data['enoughmoney']), 2);
			$data['enoughdeduct'] = round(floatval($data['enoughdeduct']), 2);
			$enoughs = array();
			$postenoughs = is_array($_GPC['enough']) ? $_GPC['enough'] : array();

			foreach ($postenoughs as $key => $value) {
				$enough = floatval($value);

				if (0 < $enough) {
					$enoughs[] = array('enough' => floatval($_GPC['enough'][$key]), 'give' => floatval($_GPC['give'][$key]));
				}
			}

			$data['enoughs'] = $enoughs;
			$data['discount'] = floatval($data['discount']);
			$data['coupon']['couponid'] = intval($_GPC['couponid']);
			$data['couponpay']['time']['start'] = strtotime($_GPC['couponpaytime']['start']);
			$data['couponpay']['time']['end'] = strtotime($_GPC['couponpaytime']['end']);
			$data['couponpay']['discount'] = floatval($_GPC['couponpay']['discount']);
			$this->updateUserSet($data);
			show_json(1, array('url' => cashierUrl('sale', array('tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$item = $this->getUserSet();
		$tt = array();

		if (!empty($item['rand'])) {
			$tt = $item['rand'];
		}

		$coupon = array();

		if (!empty($item['coupon']['couponid'])) {
			$coupon = pdo_fetch('SELECT id,couponname as title , thumb  FROM ' . tablename('ewei_shop_coupon') . ' WHERE uniacid = ' . $_W['uniacid'] . ' and id=:id', array(':id' => $item['coupon']['couponid']));
		}

		include $this->template();
	}

	protected function intdata($data)
	{
		$array = array();

		foreach ($data as $key => $val) {
			$array[] = intval($val);
		}

		return $array;
	}

	public function querycoupons()
	{
		global $_W;
		global $_GPC;
		$ds = $this->model->querycoupons($_GPC['keyword']);
		include $this->template('sale/querycoupons');
	}
}

?>
