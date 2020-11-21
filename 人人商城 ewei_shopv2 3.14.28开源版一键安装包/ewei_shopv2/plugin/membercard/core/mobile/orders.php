<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Orders_EweiShopV2Page extends PluginMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		load()->model('mc');
		$uid = mc_openid2uid($openid);

		if (empty($uid)) {
			mc_oauth_userinfo($openid);
		}

		$this->model->groupsShare();
		include $this->template();
	}

	public function confirm()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		load()->model('mc');
		$uid = mc_openid2uid($openid);

		if (empty($uid)) {
			mc_oauth_userinfo($openid);
		}

		$id = intval($_GPC['id']);
		$member = m('member')->getMember($openid, true);
		$card_info = pdo_fetch('select * from ' . tablename('ewei_shop_member_card') . '
				where id = :id and uniacid = :uniacid  order by sort_order desc', array(':id' => $id, ':uniacid' => $uniacid));

		if ($card_info['stock'] <= 0) {
			$this->message('此会员卡库存不足,无法购买');
		}

		if (empty($card_info['status'])) {
			$this->message('此会员卡已暂停发放,无法购买');
		}

		if ($card_info['isdelete']) {
			$this->message('会员卡不存在或已被删除,请选择其他会员卡');
		}

		$ordersn = m('common')->createNO('member_card_order', 'orderno', 'MC');

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'orderno' => $ordersn, 'total' => $card_info['price'], 'status' => 0, 'member_card_id' => $id, 'payment_name' => $member['realname'], 'telephone' => $member['telephone'], 'createtime' => time());
			$order_insert = pdo_insert('ewei_shop_member_card_order', $data);

			if (!$order_insert) {
				$this->message('生成订单失败！');
			}

			$orderid = pdo_insertid();
			header('location: ' . MobileUrl('membercard/pay', array('orderid' => $orderid)));
		}

		include $this->template();
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		load()->model('mc');
		$uid = mc_openid2uid($openid);

		if (empty($uid)) {
			mc_oauth_userinfo($openid);
		}

		$id = intval($_GPC['card_id']);

		if (empty($id)) {
			show_json(0, '参数错误');
		}

		$member = m('member')->getMember($openid, true);
		$card_info = pdo_fetch('select * from ' . tablename('ewei_shop_member_card') . '
				where id = :id and uniacid = :uniacid  order by sort_order desc', array(':id' => $id, ':uniacid' => $uniacid));

		if ($card_info['stock'] <= 0) {
			show_json(0, '此会员卡库存不足,无法购买');
		}

		if (empty($card_info['status'])) {
			show_json(0, '此会员卡已暂停发放,无法购买');
		}

		if ($card_info['isdelete']) {
			show_json(0, '会员卡不存在或已被删除,请选择其他会员卡');
		}

		$ordersn = m('common')->createNO('member_card_order', 'orderno', 'MC');

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'orderno' => $ordersn, 'total' => $card_info['price'], 'status' => 0, 'member_card_id' => $id, 'payment_name' => $member['realname'], 'telephone' => $member['telephone'], 'createtime' => time());
			$order_insert = pdo_insert('ewei_shop_member_card_order', $data);

			if (!$order_insert) {
				$this->message('生成订单失败！');
			}

			$orderid = pdo_insertid();
		}

		show_json(1, array('orderid' => $orderid));
	}
}

?>
