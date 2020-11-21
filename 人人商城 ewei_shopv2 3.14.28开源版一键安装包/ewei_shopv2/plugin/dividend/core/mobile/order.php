<?php

function order_sort($a, $b)
{
	if ($a['createtime'] == $b['createtime']) {
		return 0;
	}

	return $a['createtime'] < $b['createtime'] ? 1 : -1;
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'dividend/core/page_login_mobile.php';
class Order_EweiShopV2Page extends DividendMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$page_title = '商城';

		if (!empty($_W['shopset']['shop']['name'])) {
			$page_title = $_W['shopset']['shop']['name'];
		}

		$member = $this->model->getInfo($_W['openid'], array('total', 'ordercount0'));
		include $this->template();
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$openid = $_W['openid'];
		$member = $this->model->getInfo($openid, array('ordercount0'));
		$status = trim($_GPC['status']);
		$condition = ' and status>=0';

		if ($status != '') {
			$condition = ' and status=' . intval($status);
		}

		$ordercount = $member['ordercount0'];
		$list = pdo_fetchall('select id,ordersn,openid,createtime,price,status,dividend from ' . tablename('ewei_shop_order') . ' where headsid = ' . $member['id'] . $condition . ' and uniacid = :uniacid order by id desc limit ' . ($pindex - 1) . ',' . $psize, array(':uniacid' => $_W['uniacid']));

		if (!empty($list)) {
			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);

				if ($row['status'] == 0) {
					$row['statusstr'] = '待付款';
				}
				else if ($row['status'] == 1) {
					$row['statusstr'] = '已付款';
				}
				else if ($row['status'] == 2) {
					$row['statusstr'] = '待收货';
				}
				else {
					if ($row['status'] == 3) {
						$row['statusstr'] = '已完成';
					}
				}

				$dividend = iunserializer($row['dividend']);
				$row['dividend_price'] = $dividend['dividend_price'];
				$row['buyer'] = m('member')->getMember($row['openid']);
				$goods = pdo_fetchall('select og.id,og.goodsid,g.thumb,og.price,og.optionname,g.title from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id = og.goodsid' . ' where og.orderid = :orderid and og.uniacid = :uniacid order by og.createtime desc', array(':orderid' => $row['id'], ':uniacid' => $_W['uniacid']));
				$row['order_goods'] = set_medias($goods, 'thumb');
			}

			unset($row);
		}

		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $ordercount));
	}
}

?>
