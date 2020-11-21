<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require __DIR__ . '/base.php';
class Log_EweiShopV2Page extends Base_EweiShopV2Page
{
	public function get_list()
	{
		global $_W;
		global $_GPC;
		$member = m('member')->getMember($_W['openid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and `mid`=:mid and uniacid=:uniacid';
		$params = array(':mid' => $member['id'], ':uniacid' => $_W['uniacid']);
		$status = trim($_GPC['status']);

		if ($status != '') {
			if ($status == -1) {
				$condition .= ' and (status=' . intval($status) . ' or status=-2)';
			}
			else {
				$condition .= ' and status=' . intval($status);
			}
		}

		$dividendcount = pdo_fetchcolumn('select sum(dividend) from ' . tablename('ewei_shop_dividend_apply') . ' where mid=:mid and uniacid=:uniacid and status>-1 limit 1', array(':mid' => $member['id'], ':uniacid' => $_W['uniacid']));
		$list = pdo_fetchall('select * from ' . tablename('ewei_shop_dividend_apply') . (' where 1 ' . $condition . ' order by id desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_dividend_apply') . (' where 1 ' . $condition), $params);

		foreach ($list as &$row) {
			if ($row['status'] == 1) {
				$row['statusstr'] = '待审核';
				$row['dealtime'] = date('Y-m-d H:i', $row['applytime']);
			}
			else if ($row['status'] == 2) {
				$row['statusstr'] = '待打款';
				$row['dealtime'] = date('Y-m-d H:i', $row['checktime']);
			}
			else if ($row['status'] == 3) {
				$row['statusstr'] = '已打款';
				$row['dealtime'] = date('Y-m-d H:i', $row['paytime']);
			}
			else if ($row['status'] == -1) {
				$row['dealtime'] = date('Y-m-d H:i', $row['invalidtime']);
				$row['statusstr'] = '无效';
			}
			else {
				if ($row['status'] == -2) {
					$row['dealtime'] = date('Y-m-d H:i', $row['invalidtime']);
					$row['statusstr'] = '驳回';
				}
			}
		}

		unset($row);
		$result = array('total' => $total, 'list' => $list, 'pagesize' => $psize, 'dividendcount' => number_format($dividendcount, 2));
		return app_error($result);
	}

	public function orders()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$member = m('member')->getMember($_W['openid']);
		$id = intval($_GPC['id']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 5;
		$apply = pdo_fetch('select * from ' . tablename('ewei_shop_dividend_apply') . ' where id=:id and `mid`=:mid and uniacid=:uniacid limit 1', array(':id' => $id, ':mid' => $member['id'], ':uniacid' => $_W['uniacid']));

		if (empty($apply)) {
			return app_error(1, array('message' => '未找到提现申请!'));
		}

		$orderids = explode(',', $apply['orderids']);
		if (!is_array($orderids) || count($orderids) <= 0) {
			return app_error(1, array('message' => '未找到订单信息!'));
		}

		$list = pdo_fetchall('select id,headsid, ordersn,price,goodsprice, dispatchprice,createtime, paytype,dividend,dividend_status,dividend_content from ' . tablename('ewei_shop_order') . ' where  id in ( ' . $apply['orderids'] . ' ) LIMIT ' . ($pindex - 1) * $psize . ',' . $psize);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where  id in ( ' . $apply['orderids'] . ' ) ');
		$totaldividend = 0;
		$totalpay = 0;

		foreach ($list as &$row) {
			$orderpay = 0;
			$goods = pdo_fetchall('SELECT og.id,g.thumb,og.price,og.realprice, og.total,g.title,o.paytype,og.optionname from ' . tablename('ewei_shop_order_goods') . ' og' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid  ' . ' left join ' . tablename('ewei_shop_order') . ' o on o.id=og.orderid  ' . ' where og.uniacid = :uniacid and og.orderid=:orderid order by og.createtime  desc ', array(':uniacid' => $_W['uniacid'], ':orderid' => $row['id']));
			$goods = set_medias($goods, 'thumb');
			$dividend = iunserializer($row['dividend']);

			if (!empty($dividend)) {
				$totaldividend += isset($dividend['dividend_price']) ? floatval($dividend['dividend_price']) : 0;
				$row['dividend_price'] = isset($dividend['dividend_price']) ? floatval($dividend['dividend_price']) : 0;

				if (2 <= $row['dividend_status']) {
					$orderpay = isset($dividend['dividend_price']) ? floatval($dividend['dividend_price']) : 0;
				}
			}

			$set_array = array();
			$set_array['charge'] = $apply['charge'];
			$set_array['begin'] = $apply['beginmoney'];
			$set_array['end'] = $apply['endmoney'];
			$realmoney = $row['dividend_price'];
			$deductionmoney = 0;

			if (!empty($set_array['charge'])) {
				$money_array = m('member')->getCalculateMoney($row['dividend_price'], $set_array);

				if ($money_array['flag']) {
					$realmoney = $money_array['realmoney'];
					$deductionmoney = $money_array['deductionmoney'];
				}
			}

			$row['goods'] = $goods;
			$row['deductionmoney'] = $deductionmoney;
			$row['orderpay'] = $orderpay;
		}

		unset($row);
		$result = array('set' => $this->set, 'list' => $list, 'pagesize' => $psize, 'total' => $total, 'totaldividend' => $totaldividend);
		return app_error($result);
	}
}

?>
