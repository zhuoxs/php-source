<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Comment_EweiShopV2Page extends MobileLoginPage
{
	public function __construct()
	{
		parent::__construct();
		$trade = m('common')->getSysset('trade');

		if (!empty($trade['closecomment'])) {
			$this->message('不允许评论!', '', 'error');
		}
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$orderid = intval($_GPC['id']);
		$order = pdo_fetch('select id,status,iscomment from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

		if (empty($order)) {
			header('location: ' . mobileUrl('order'));
			exit();
		}

		if ($order['status'] != 3 && $order['status'] != 4) {
			$this->message('订单未收货，不能评价!', mobileUrl('order/detail', array('id' => $orderid)));
		}

		if (2 <= $order['iscomment']) {
			$this->message('您已经评价过了!', mobileUrl('order/detail', array('id' => $orderid)));
		}

		$goods = pdo_fetchall('select og.id,og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,o.title as optiontitle from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on o.id=og.optionid ' . ' where og.orderid=:orderid and og.uniacid=:uniacid ', array(':uniacid' => $uniacid, ':orderid' => $orderid));
		$goods = set_medias($goods, 'thumb');
		include $this->template();
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['orderid']);
		$order = pdo_fetch('select id,status,iscomment from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

		if (empty($order)) {
			show_json(0, '订单未找到');
		}

		$member = m('member')->getMember($openid);
		$comments = $_GPC['comments'];

		if (!is_array($comments)) {
			show_json(0, '数据出错，请重试!');
		}

		$trade = m('common')->getSysset('trade');

		if (!empty($trade['commentchecked'])) {
			$checked = 0;
		}
		else {
			$checked = 1;
		}

		foreach ($comments as $c) {
			$old_c = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where uniacid=:uniacid and orderid=:orderid and goodsid=:goodsid limit 1', array(':uniacid' => $_W['uniacid'], ':goodsid' => $c['goodsid'], ':orderid' => $orderid));

			if (empty($old_c)) {
				$comment = array('uniacid' => $uniacid, 'orderid' => $orderid, 'goodsid' => $c['goodsid'], 'level' => $c['level'], 'content' => trim($c['content']), 'images' => is_array($c['images']) ? iserializer($c['images']) : iserializer(array()), 'openid' => $openid, 'nickname' => $member['nickname'], 'headimgurl' => $member['avatar'], 'createtime' => time(), 'checked' => $checked);
				pdo_insert('ewei_shop_order_comment', $comment);

				if (p('task')) {
					p('task')->checkTaskReward('cost_comment', 1);
				}

				if (p('task')) {
					p('task')->checkTaskProgress(1, 'comment');
				}
			}
			else {
				$comment = array('append_content' => trim($c['content']), 'append_images' => is_array($c['images']) ? iserializer($c['images']) : iserializer(array()), 'replychecked' => $checked);
				pdo_update('ewei_shop_order_comment', $comment, array('uniacid' => $_W['uniacid'], 'goodsid' => $c['goodsid'], 'orderid' => $orderid));
			}
		}

		if ($order['iscomment'] <= 0) {
			$d['iscomment'] = 1;
		}
		else {
			$d['iscomment'] = 2;
		}

		pdo_update('ewei_shop_order', $d, array('id' => $orderid, 'uniacid' => $uniacid));
		show_json(1);
	}
}

?>
