<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Quickget_EweiShopV2Page extends MobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);

		if (empty($member)) {
			header('location: ' . mobileUrl());
			exit();
		}

		$time = time();
		$coupon = pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where  1 and uniacid=:uniacid  and id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $id));
		if (empty($coupon) || empty($coupon['quickget'])) {
			header('location: ' . mobileUrl());
			exit();
		}

		$couponlog = array('uniacid' => $_W['uniacid'], 'openid' => $member['openid'], 'logno' => m('common')->createNO('coupon_log', 'logno', 'CC'), 'couponid' => $id, 'status' => 1, 'paystatus' => -1, 'creditstatus' => -1, 'createtime' => time(), 'getfrom' => 8);
		pdo_insert('ewei_shop_coupon_log', $couponlog);
		$data = array('uniacid' => $_W['uniacid'], 'openid' => $member['openid'], 'couponid' => $id, 'gettype' => 8, 'gettime' => time());
		pdo_insert('ewei_shop_coupon_data', $data);
		$id = pdo_insertid();
		header('location: ' . mobileUrl('sale/coupon/my/showcoupons2', array('id' => $id)));
	}
}

?>
