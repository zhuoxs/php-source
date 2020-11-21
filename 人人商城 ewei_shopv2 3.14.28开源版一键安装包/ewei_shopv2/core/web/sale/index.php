<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends ComWebPage
{
	public function __construct()
	{
		parent::__construct('sale');
	}

	public function main()
	{
		if (cv('sale.enough')) {
			header('location: ' . webUrl('sale/enough'));
		}
		else if (cv('sale.enoughfree')) {
			header('location: ' . webUrl('sale/enoughfree'));
		}
		else if (cv('sale.deduct')) {
			header('location: ' . webUrl('sale/deduct'));
		}
		else if (cv('sale.recharge')) {
			header('location: ' . webUrl('sale/recharge'));
		}
		else if (cv('sale.credit1')) {
			header('location: ' . webUrl('sale/credit1'));
		}
		else if (cv('sale.package')) {
			header('location: ' . webUrl('sale/package'));
		}
		else if (cv('sale.gift')) {
			header('location: ' . webUrl('sale/gift'));
		}
		else if (cv('sale.fullback')) {
			header('location: ' . webUrl('sale/fullback'));
		}
		else if (cv('sale.peerpay')) {
			header('location: ' . webUrl('sale/peerpay'));
		}
		else if (cv('sale.coupon')) {
			header('location: ' . webUrl('sale/coupon'));
		}
		else if (cv('sale.wxcard')) {
			header('location: ' . webUrl('sale/wxcard'));
		}
		else if (cv('sale.virtual')) {
			header('location: ' . webUrl('sale/virtual'));
		}
		else {
			header('location: ' . webUrl());
		}
	}

	public function deduct()
	{
		global $_W;
		global $_GPC;
		if (!function_exists('redis') || is_error(redis())) {
			$this->message('请联系系统管理员设置 Redis 才能使用抵扣!', '', 'error');
		}

		if ($_W['ispost']) {
			$post = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['creditdeduct'] = intval($post['creditdeduct']);
			$data['credit'] = 1;
			$data['moneydeduct'] = intval($post['moneydeduct']);
			$data['money'] = round(floatval($post['money']), 2);
			$data['dispatchnodeduct'] = intval($post['dispatchnodeduct']);
			plog('sale.deduct', '修改抵扣设置');
			m('common')->updatePluginset(array('sale' => $data));
			show_json(1);
		}

		$data = m('common')->getPluginset('sale');
		load()->func('tpl');
		include $this->template('sale/index');
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
			plog('sale.enough', '修改满额立减优惠');
			m('common')->updatePluginset(array('sale' => $data));
			show_json(1);
		}

		$areas = m('common')->getAreas();
		$data = m('common')->getPluginset('sale');
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
			$data['goodsids'] = $_GPC['goodsid'];
			plog('sale.enough', '修改满额包邮优惠');
			m('common')->updatePluginset(array('sale' => $data));
			show_json(1);
		}

		$data = m('common')->getPluginset('sale');

		if (!empty($data['goodsids'])) {
			$goods = pdo_fetchall('SELECT id,uniacid,title,thumb FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid=:uniacid AND id IN (' . implode(',', $data['goodsids']) . ')', array(':uniacid' => $_W['uniacid']));
		}

		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);
		$areas = m('common')->getAreas();
		include $this->template();
	}

	public function recharge()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$recharges = array();
			$datas = is_array($_GPC['enough']) ? $_GPC['enough'] : array();

			foreach ($datas as $key => $value) {
				$enough = trim($value);

				if (!empty($enough)) {
					$recharges[] = array('enough' => trim($_GPC['enough'][$key]), 'give' => trim($_GPC['give'][$key]));
				}
			}

			$data['recharges'] = iserializer($recharges);
			m('common')->updatePluginset(array('sale' => $data));
			plog('sale.recharge', '修改充值优惠设置');
			show_json(1);
		}

		$data = m('common')->getPluginset('sale');
		$recharges = iunserializer($data['recharges']);
		include $this->template();
	}

	public function credit1()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$enough1 = array();
			$postenough1 = is_array($_GPC['enough1_1']) ? $_GPC['enough1_1'] : array();

			foreach ($postenough1 as $key => $value) {
				$enough = floatval($value);

				if (0 < $enough) {
					$enough1[] = array('enough1_1' => floatval($_GPC['enough1_1'][$key]), 'enough1_2' => floatval($_GPC['enough1_2'][$key]), 'give1' => intval($_GPC['give1'][$key]));
				}
			}

			$data['isgoodspoint'] = intval($_GPC['isgoodspoint']);
			$data['enough1'] = $enough1;
			$enough2 = array();
			$postenough2 = is_array($_GPC['enough2_1']) ? $_GPC['enough2_1'] : array();

			foreach ($postenough2 as $key => $value) {
				$enough = floatval($value);

				if (0 < $enough) {
					$enough2[] = array('enough2_1' => floatval($_GPC['enough2_1'][$key]), 'enough2_2' => floatval($_GPC['enough2_2'][$key]), 'give2' => intval($_GPC['give2'][$key]));
				}
			}

			if (!empty($enough2)) {
				m('common')->updateSysset(array(
					'trade' => array('credit' => 0)
				));
			}

			$data['enough1'] = $enough1;
			$data['enough2'] = $enough2;
			$data['paytype'] = is_array($_GPC['paytype']) ? $_GPC['paytype'] : array();
			m('common')->updatePluginset(array(
				'sale' => array('credit1' => iserializer($data))
			));
			plog('sale.credit1.edit', '修改基本积分活动配置');
			show_json(1, array('url' => webUrl('sale/credit1', array('tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$data = m('common')->getPluginset('sale');
		$credit1 = iunserializer($data['credit1']);
		$enough1 = empty($credit1['enough1']) ? array() : $credit1['enough1'];
		$enough2 = empty($credit1['enough2']) ? array() : $credit1['enough2'];
		include $this->template();
	}

	/**
     * 绑定手机送积分
     */
	public function bindmobile()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['bindmobile'] = intval($data['bindmobile']);
			$data['bindmobilecredit'] = intval($data['bindmobilecredit']);
			m('common')->updatePluginset(array('sale' => $data));
			show_json(1);
		}

		$data = m('common')->getPluginset('sale');
		include $this->template();
	}
}

?>
