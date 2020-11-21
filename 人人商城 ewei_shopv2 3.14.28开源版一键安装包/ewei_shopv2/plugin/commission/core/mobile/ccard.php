<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'commission/core/page_login_mobile.php';
class Ccard_EweiShopV2Page extends CommissionMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$member = m('member')->getMember($_W['openid']);
		include $this->template();
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$member = m('member')->getMember($_W['openid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$uniacid = $_W['uniacid'];
		$params = array();
		$params[':uniacid'] = $uniacid;
		$params[':uid'] = $member['id'];
		$sql = 'select * from ' . tablename('ewei_shop_ccard') . ' where status = 1 and uniacid=:uniacid and (agentid1 = :uid or agentid2 = :uid) order by id desc LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$sql1 = 'select count(1) from ' . tablename('ewei_shop_ccard') . ' where status = 1 and uniacid=:uniacid and (agentid1 = :uid or agentid2 = :uid)';
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn($sql1, $params);

		foreach ($list as &$row) {
			if (!empty($row['agentid1'])) {
				$row['money'] = $row['commission1'];
				$row['tmoney'] = $row['totalmoney1'];
			}
			else {
				$row['money'] = $row['commission2'];
				$row['tmoney'] = $row['totalmoney2'];
			}

			$row['bdate'] = date('Y-m-d', $row['btime']);
			$row['edate'] = date('Y-m-d', $row['etime']);
		}

		unset($row);
		show_json(1, array('total' => $total, 'list' => $list, 'pagesize' => $psize, 'commissioncount' => number_format($commissioncount, 2)));
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$member = m('member')->getMember($_W['openid']);
		$apply = pdo_fetch('select * from ' . tablename('ewei_shop_commission_apply') . ' where id=:id and `mid`=:mid and uniacid=:uniacid limit 1', array(':id' => $id, ':mid' => $member['id'], ':uniacid' => $_W['uniacid']));

		if (empty($apply)) {
			$this->message('未找到提现申请!', '', 'error');
		}

		$orderids = iunserializer($apply['orderids']);
		if (!is_array($orderids) || count($orderids) <= 0) {
			$this->message('未找到订单信息!', '', 'error');
		}

		include $this->template();
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
		$apply = pdo_fetch('select orderids from ' . tablename('ewei_shop_commission_apply') . ' where id=:id and `mid`=:mid and uniacid=:uniacid limit 1', array(':id' => $id, ':mid' => $member['id'], ':uniacid' => $_W['uniacid']));

		if (empty($apply)) {
			show_json(0, array('message' => '未找到提现申请!'));
		}

		$orderids = iunserializer($apply['orderids']);
		if (!is_array($orderids) || count($orderids) <= 0) {
			show_json(0, array('message' => '未找到订单信息!'));
		}

		$ids = array();

		foreach ($orderids as $o) {
			$ids[] = $o['orderid'];
		}

		$list = pdo_fetchall('select o.id,o.agentid, o.ordersn,o.price,o.goodsprice, o.dispatchprice,o.createtime, o.paytype from ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_member') . ' m on o.openid = m.openid ' . ' where  o.id in ( ' . implode(',', $ids) . ' ) LIMIT ' . ($pindex - 1) * $psize . ',' . $psize);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_member') . ' m on o.openid = m.openid ' . ' where  o.id in ( ' . implode(',', $ids) . ' ) ');
		$totalcommission = 0;
		$totalpay = 0;

		foreach ($list as &$row) {
			$ordercommission = 0;
			$orderpay = 0;

			foreach ($orderids as $o) {
				if ($o['orderid'] == $row['id']) {
					$row['level'] = $o['level'];
					break;
				}
			}

			$condition = '';
			$status = trim($_GPC['status']);

			if ($status != '') {
				$condition .= ' and status=' . intval($status);
			}

			$goods = pdo_fetchall('SELECT og.id,og.goodsid,g.thumb,og.price,og.total,g.title,og.optionname,' . 'og.commission1,og.commission2,og.commission3,og.commissions,' . 'og.status1,og.status2,og.status3,' . 'og.content1,og.content2,og.content3 from ' . tablename('ewei_shop_order_goods') . ' og' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid  ' . ' where og.orderid=:orderid and og.nocommission=0 and og.uniacid = :uniacid order by og.createtime  desc ', array(':uniacid' => $_W['uniacid'], ':orderid' => $row['id']));
			$goods = set_medias($goods, 'thumb');

			foreach ($goods as &$g) {
				$commissions = iunserializer($g['commissions']);

				if ($row['level'] == 1) {
					$commission = iunserializer($g['commission1']);

					if (empty($commissions)) {
						$g['commission'] = isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default'];
					}
					else {
						$g['commission'] = isset($commissions['level1']) ? floatval($commissions['level1']) : 0;
					}

					$totalcommission += $g['commission'];
					$ordercommission += $g['commission'];

					if (2 <= $g['status1']) {
						$totalpay += $g['commission'];
						$orderpay += $g['commission'];
					}
				}

				if ($row['level'] == 2) {
					$commission = iunserializer($g['commission2']);
					$g['commission_pay'] = 0;

					if (empty($commissions)) {
						$g['commission'] = isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default'];
					}
					else {
						$g['commission'] = isset($commissions['level2']) ? floatval($commissions['level2']) : 0;
					}

					$totalcommission += $g['commission'];
					$ordercommission += $g['commission'];

					if (2 <= $g['status2']) {
						$g['commission_pay'] = $g['commission'];
						$totalpay += $g['commission'];
						$orderpay += $g['commission'];
					}
				}

				if ($row['level'] == 3) {
					$commission = iunserializer($g['commission3']);

					if (empty($commissions)) {
						$g['commission'] = isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default'];
					}
					else {
						$g['commission'] = isset($commissions['level3']) ? floatval($commissions['level3']) : 0;
					}

					$totalcommission += $g['commission'];
					$ordercommission += $g['commission'];

					if (2 <= $g['status3']) {
						$totalpay += $g['commission'];
						$orderpay += $g['commission'];
					}
				}

				$status = $g['status' . $row['level']];

				if ($status == 1) {
					$g['statusstr'] = '待审核';
					$g['dealtime'] = date('Y-m-d H:i', $row['applytime' . $row['level']]);
				}
				else if ($status == 2) {
					$g['statusstr'] = '待打款';
					$g['dealtime'] = date('Y-m-d H:i', $row['checktime' . $row['level']]);
				}
				else if ($status == 3) {
					$g['statusstr'] = '已打款';
					$g['dealtime'] = date('Y-m-d H:i', $row['checktime' . $row['level']]);
				}
				else {
					if ($status == -1) {
						$g['dealtime'] = date('Y-m-d H:i', $row['invalidtime' . $row['level']]);
						$g['statusstr'] = '无效';
					}
				}

				$g['status'] = $status;
				$g['content'] = $g['content' . $row['level']];
				$g['level'] = $row['level'];

				if ($row['level'] == 1) {
					$g['level'] = '一';
				}
				else if ($row['level'] == 2) {
					$g['level'] = '二';
				}
				else {
					if ($row['level'] == 3) {
						$g['level'] = '三';
					}
				}
			}

			unset($g);
			$row['goods'] = $goods;
			$row['ordercommission'] = $ordercommission;
			$row['orderpay'] = $orderpay;
		}

		unset($row);
		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total, 'totalcommission' => $totalcommission));
	}
}

?>
