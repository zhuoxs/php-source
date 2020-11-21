<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Send_EweiShopV2Page extends PluginMobilePage
{
	/**
     * 发送优惠券
     */
	public function coupon()
	{
		global $_GPC;
		$code = trim($_GPC['code']);

		if (empty($code)) {
			return false;
		}

		$code = base64_decode($code);
		$code = authcode($code);

		if (empty($code)) {
			return false;
		}

		$code = explode('|', $code);
		$openid = trim($code[0]);
		$couponid = intval($code[1]);
		if (empty($openid) || empty($couponid)) {
			return false;
		}

		$member = m('member')->getMember($openid);

		if (empty($member)) {
			return false;
		}

		if (com('coupon')) {
			com('coupon')->poster($member, $couponid, 1, 12);
		}
	}

	/**
     * 发送余额红包
     */
	public function credit()
	{
		global $_GPC;
		$code = trim($_GPC['code']);

		if (empty($code)) {
			return false;
		}

		$code = base64_decode($code);
		$code = authcode($code);

		if (empty($code)) {
			return false;
		}

		$code = explode('|', $code);
		$openid = trim($code[0]);
		$fee = price_format($code[1]);
		$log = trim($code[2]);
		if (empty($openid) || empty($fee)) {
			return false;
		}

		m('member')->setCredit($openid, 'credit2', $fee, $log);
	}
}

?>
