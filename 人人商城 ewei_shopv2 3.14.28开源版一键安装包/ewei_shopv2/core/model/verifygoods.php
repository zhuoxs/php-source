<?php
//QQ63779278
class Verifygoods_EweiShopV2Model
{
	/**
     *
     * @param type $orderid
     */
	public function createverifygoods($orderid)
	{
		global $_W;
		$verifygoods = pdo_fetchall('select  *   from  ' . tablename('ewei_shop_verifygoods') . ' where  orderid=:orderid ', array(':orderid' => $orderid));

		if (!empty($verifygoods)) {
			return false;
		}

		$sql2 = '';
		$ordergoods = pdo_fetchall('select o.openid,o.uniacid,o.id as orderid , og.id as ordergoodsid, g.verifygoodstype, g.verifygoodsdays,g.verifygoodsnum,g.verifygoodslimittype,g.verifygoodslimitdate,og.total,o.storeid ' . $sql2 . ' from ' . tablename('ewei_shop_order_goods') . '   og inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
          inner join ' . tablename('ewei_shop_order') . ' o on og.orderid = o.id
          where   og.orderid =:orderid and g.type = 5', array(':orderid' => $orderid));

		if (count($ordergoods) != 1) {
			return false;
		}

		$time = time();
		$goods = $ordergoods[0];

		if (empty($goods['verifygoodstype'])) {
			foreach ($ordergoods as $ordergood) {
				$total = intval($ordergood['total']);
				$i = 0;

				while ($i < $total) {
					$data = array('uniacid' => $ordergood['uniacid'], 'openid' => $ordergood['openid'], 'orderid' => $ordergood['orderid'], 'ordergoodsid' => $ordergood['ordergoodsid'], 'starttime' => $time, 'limittype' => intval($ordergood['verifygoodslimittype']), 'limitdate' => intval($ordergood['verifygoodslimitdate']), 'limitdays' => intval($ordergood['verifygoodsdays']), 'limitnum' => intval($ordergood['verifygoodsnum']), 'used' => 0, 'invalid' => 0, 'storeid' => intval($ordergood['storeid']));
					pdo_insert('ewei_shop_verifygoods', $data);
					++$i;
				}
			}
		}
		else {
			$data = array('uniacid' => $goods['uniacid'], 'openid' => $goods['openid'], 'orderid' => $goods['orderid'], 'ordergoodsid' => $goods['ordergoodsid'], 'starttime' => $time, 'limittype' => intval($goods['verifygoodslimittype']), 'limitdate' => intval($goods['verifygoodslimitdate']), 'limitdays' => intval($goods['verifygoodsdays']), 'limitnum' => intval($goods['verifygoodsnum']) * $goods['total'], 'used' => 0, 'invalid' => 0, 'storeid' => intval($goods['storeid']));
			pdo_insert('ewei_shop_verifygoods', $data);
		}

		return true;
	}

	/**
     *
     * @param type $openid
     */
	public function getCanUseVerifygoods($openid)
	{
		global $_W;
		$time = time();
		$sql = 'select vg.*,g.title,g.subtitle,g.thumb,c.card_id  from ' . tablename('ewei_shop_verifygoods') . '   vg
                 inner join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
                 left  join ' . tablename('ewei_shop_order') . ' o on vg.orderid = o.id
                 left  join ' . tablename('ewei_shop_order_refund') . ' orf on o.refundid = orf.id
                 inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
                 left  join ' . tablename('ewei_shop_goods_cards') . ' c on c.id = g.cardid
                 where   vg.uniacid=:uniacid and vg.openid=:openid and vg.invalid =0 and (o.refundid=0 or orf.status<0) and o.status>0
                 and    ((vg.limittype=0   and vg.limitdays * 86400 + vg.starttime >=' . $time . ' )or ( vg.limittype=1   and vg.limitdate >=' . $time . ' ))  and  vg.used =0 order by vg.starttime desc';
		$verifygoods = set_medias(pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':openid' => $openid)), 'thumb');

		if (empty($verifygoods)) {
			$verifygoods = array();
		}

		foreach ($verifygoods as $i => &$row) {
			$row['numlimit'] = 0;

			if (!empty($row['limitnum'])) {
				$row['numlimit'] = 1;
			}

			if (is_weixin()) {
				if (!empty($row['card_id']) && empty($row['activecard'])) {
					$row['cangetcard'] = 1;
				}
			}
		}

		unset($row);
		return $verifygoods;
	}

	/**
     * 检测计次核销码是否可用，返回核销verify_goods记录
     * @param $verifycode
     */
	public function search($verifycode)
	{
		global $_W;
		global $_GPC;
		$verifygood = pdo_fetch('select *  from ' . tablename('ewei_shop_verifygoods') . ' where uniacid=:uniacid and  verifycode=:verifycode and invalid =0  limit 1 ', array(':uniacid' => $_W['uniacid'], ':verifycode' => $verifycode));

		if (empty($verifygood)) {
			return error(1, '未查询到记次时商品或核销码已失效,请核对核销码!');
		}

		if (intval($verifygood['codeinvalidtime']) < time()) {
			return error(1, '核销码已过期，请刷新页面重新获取核销码!');
		}

		$saler = pdo_fetch('select * from ' . tablename('ewei_shop_saler') . ' where  status=1  and  openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if (empty($saler)) {
			return error(1, '您不是核销员,无权核销');
		}

		$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $saler['storeid'], ':uniacid' => $_W['uniacid']));
		if (!empty($verifygood['storeid']) && !empty($store) && $verifygood['storeid'] != $store['id']) {
			return error(1, '该商品无法在您所属门店核销!请重新确认!');
		}

		return $verifygood;
	}

	public function allow($verifycode, $times)
	{
		global $_W;
		global $_GPC;
		$verifygood = pdo_fetch('select *  from ' . tablename('ewei_shop_verifygoods') . ' where uniacid=:uniacid and  verifycode=:verifycode and invalid =0  limit 1 ', array(':uniacid' => $_W['uniacid'], ':verifycode' => $verifycode));

		if (empty($verifygood)) {
			return error(1, '未查询到记次时商品或核销码已失效,请核对核销码!');
		}

		if (intval($verifygood['codeinvalidtime']) < time()) {
			return error(1, '核销码已过期，请刷新页面重新获取核销码!');
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid  limit 1', array(':id' => $verifygood['orderid'], ':uniacid' => $verifygood['uniacid']));

		if (empty($order)) {
			return error(-1, '订单不存在!');
		}

		$saler = pdo_fetch('select * from ' . tablename('ewei_shop_saler') . ' where status=1  and openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if (empty($saler)) {
			return error(1, '您不是核销员,无权核销');
		}

		$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $saler['storeid'], ':uniacid' => $_W['uniacid']));
		if (!empty($verifygood['storeid']) && !empty($store) && $verifygood['storeid'] != $store['id']) {
			return error(1, '该商品无法在您所属门店核销!请重新确认!');
		}

		$used = 0;

		if (!empty($verifygood['limitnum'])) {
			$verifygoodlogs = pdo_fetchall('select *  from ' . tablename('ewei_shop_verifygoods_log') . '    where verifygoodsid =:id  ', array(':id' => $verifygood['id']));
			$verifynum = 0;

			foreach ($verifygoodlogs as $verifygoodlog) {
				$verifynum += intval($verifygoodlog['verifynum']);
			}

			$lastverifys = intval($verifygood['limitnum']) - $verifynum;

			if ($lastverifys < $times) {
				return error(1, '商品可核销次数不足!');
			}

			if ($lastverifys == $times) {
				$used = 1;
			}
		}

		if (empty($verifygood['limittype'])) {
			$limitdate = intval($verifygood['starttime']) + intval($verifygood['limitdays']) * 86400;
		}
		else {
			$limitdate = intval($verifygood['limitdate']);
		}

		if ($limitdate < time()) {
			return error(1, '该商品已过期!');
		}

		$verifygoods_detail = pdo_fetch('select vg.*,g.id as goodsid ,g.title,g.subtitle,g.thumb,vg.storeid  from ' . tablename('ewei_shop_verifygoods') . '   vg
		 inner join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
		 inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		 where  vg.id =:id and  vg.verifycode=:verifycode and vg.uniacid=:uniacid and vg.invalid =0 limit 1', array(':id' => $verifygood['id'], ':uniacid' => $_W['uniacid'], ':verifycode' => $verifycode));
		$order['verifytype'] = 1;

		if (intval($lastverifys) <= 0) {
			$lastverifys = '不限';
		}

		return array('verifygood' => $verifygood, 'saler' => $saler, 'used' => $used, 'store' => $store, 'lastverifys' => $lastverifys, 'order' => $order, 'allgoods' => $verifygoods_detail);
	}

	/**
     * 进行核销
     * @param $verifycode
     * @param $times
     * @param $remarks
     * @return array
     */
	public function complete($verifycode, $times, $remarks)
	{
		global $_W;
		global $_GPC;
		$allow = $this->allow($verifycode, $times);

		if (is_error($allow)) {
			return $allow;
		}

		extract($allow);
		$data = array('uniacid' => $_W['uniacid'], 'verifygoodsid' => $verifygood['id'], 'salerid' => $saler['id'], 'storeid' => $store['id'], 'verifynum' => $times, 'verifydate' => time(), 'remarks' => $remarks);
		pdo_insert('ewei_shop_verifygoods_log', $data);
		$logid = pdo_insertid();
		m('notice')->sendVerifygoodMessage($logid);
		pdo_query('update ' . tablename('ewei_shop_verifygoods') . ' set used=:used , verifycode=null ,codeinvalidtime=0 where id=:id', array(':id' => $verifygood['id'], ':used' => $used));

		if (!empty($verifygood['activecard'])) {
			com_run('wxcard::updateusercardbyvarifygoodid', $verifygood['id']);
		}

		$finishorderid = 0;
		$isonlyverifygood = m('order')->checkisonlyverifygoods($verifygood['orderid']);

		if ($isonlyverifygood) {
			$status = pdo_fetchcolumn('select status  from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and id=:id  limit 1 ', array(':uniacid' => $_W['uniacid'], ':id' => $verifygood['orderid']));

			if ($status == 2) {
				$finishorderid = $verifygood['orderid'];
				$this->finishorder($finishorderid);
			}
		}

		return array('verifygoodid' => $verifygood['id'], 'orderid' => $finishorderid);
	}

	/**
     * 记次商品完成订单
     * @param $id
     */
	public function finishorder($id)
	{
		global $_W;
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		if (empty($item) || $item['status'] != 2) {
			return false;
		}

		pdo_update('ewei_shop_order', array('status' => 3, 'sendtime' => time(), 'finishtime' => time()), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
		m('order')->fullback($item['id']);
		if (p('ccard') && !empty($item['ccardid'])) {
			p('ccard')->setBegin($item['id'], $item['ccardid']);
		}

		m('member')->upgradeLevel($item['openid'], $item['id']);
		m('order')->setStocksAndCredits($item['id'], 3);
		m('order')->setGiveBalance($item['id'], 1);
		m('notice')->sendOrderMessage($item['id']);
		com_run('printer::sendOrderMessage', $item['id']);

		if (com('coupon')) {
			com('coupon')->sendcouponsbytask($item['id']);

			if (!empty($item['couponid'])) {
				com('coupon')->backConsumeCoupon($item['id']);
			}
		}

		if (p('lineup')) {
			p('lineup')->checkOrder($item);
		}

		if (p('commission')) {
			p('commission')->checkOrderFinish($item['id']);
		}

		if (p('lottery')) {
			$res = p('lottery')->getLottery($item['openid'], 1, array('money' => $item['price'], 'paytype' => 2));

			if ($res) {
				p('lottery')->getLotteryList($item['openid'], array('lottery_id' => $res));
			}
		}

		plog('order.op.finish', '订单完成 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn']);
		return true;
	}

	/**
     *
     * @param type $openid
     */
	public function checkhaveverifygoods($openid)
	{
		global $_W;
		$sql = 'select  COUNT(1)  from ' . tablename('ewei_shop_verifygoods') . '   vg
                 inner join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
                 left  join ' . tablename('ewei_shop_order') . ' o on vg.orderid = o.id
                 left  join ' . tablename('ewei_shop_order_refund') . ' orf on o.refundid = orf.id
                 inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
                 left  join ' . tablename('ewei_shop_goods_cards') . ' c on c.id = g.cardid
                 where   vg.uniacid=:uniacid and vg.openid=:openid and vg.invalid =0   order by vg.starttime desc';
		$verifygoods = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':openid' => $openid));

		if (!empty($verifygoods)) {
			return 1;
		}

		return 0;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
