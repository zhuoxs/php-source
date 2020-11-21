<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Index_EweiShopV2Page extends MerchWebPage
{
	public function __construct($_com = 'sale')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		if (mcv('sale.enough')) {
			header('location: ' . merchUrl('sale/enough'));
		}
		else if (mcv('sale.enoughfree')) {
			header('location: ' . merchUrl('sale/enoughfree'));
		}
		else if (mcv('sale.coupon')) {
			header('location: ' . merchUrl('sale/coupon'));
		}
		else {
			header('location: ' . merchUrl());
		}
	}

	public function enough()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
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
			mplog('sale.enough', '修改满额立减优惠');
			$this->model->updateSet(array('sale' => $data));
			show_json(1);
		}

		$areas = m('common')->getAreas();
		$data = $this->model->getSet('sale');
		load()->func('tpl');
		include $this->template();
	}

	public function enoughfree()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['enoughfree'] = intval($data['enoughfree']);
			$data['enoughorder'] = round(floatval($data['enoughorder']), 2);
			mplog('sale.enough', '修改满额包邮优惠');
			$this->model->updateSet(array('sale' => $data));
			show_json(1);
		}

		$set = $this->model->getSet();
		$data = $set['sale'];

		if (!empty($data)) {
			$merchdata = m('cache')->get('merch_sets_' . $_W['merchid']);
			$data = $merchdata['sale'];
		}

		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);
		$areas = m('common')->getAreas();
		include $this->template();
	}
}

?>
