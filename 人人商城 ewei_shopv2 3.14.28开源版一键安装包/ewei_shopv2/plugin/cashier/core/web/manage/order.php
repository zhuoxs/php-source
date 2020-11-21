<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/page_cashier.php';
class Order_EweiShopV2Page extends CashierWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $this->set;
		$payday = (double) $set['payday'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'AND cashierid=:cashierid';
		$params = array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']);
		if (isset($_GPC['status']) && $_GPC['status'] !== '') {
			$condition .= ' AND status=:status';
			$params[':status'] = intval($_GPC['status']);
		}

		if (isset($_GPC['operatorid']) && $_GPC['operatorid'] !== '') {
			$condition .= ' AND operatorid=:operatorid';
			$params[':operatorid'] = intval($_GPC['operatorid']);
		}

		if (isset($_GPC['paytype']) && $_GPC['paytype'] !== '') {
			$condition .= ' AND paytype=:paytype';
			$params[':paytype'] = intval($_GPC['paytype']);
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$start = strtotime($_GPC['time']['start']);
			$end = strtotime($_GPC['time']['end']);
			$condition .= ' AND createtime BETWEEN :start AND :end';
			$params[':start'] = intval($start);
			$params[':end'] = intval($end);
		}

		$goods = pdo_fetchall('SELECT id,orderid,isgoods FROM ' . tablename('ewei_shop_cashier_pay_log') . ' WHERE uniacid=:uniacid AND cashierid=:cashierid AND status=0 AND createtime < ' . (time() - 3600 * 24), array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']), 'id');
		$gids = array();
		$selfgids = array();

		foreach ($goods as $v) {
			if (!empty($v['orderid'])) {
				$gids[] = $v['orderid'];
			}

			if (!empty($v['isgoods'])) {
				$selfgids[] = $v['id'];
			}
		}

		if (!empty($selfgids)) {
		}

		if (!empty($gids)) {
		}

		if (!empty($goods)) {
		}

		$sql = 'select * from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition . ' ORDER BY id desc');

		if (empty($_GPC['export'])) {
			$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}
		else {
			$sql .= ' LIMIT 0,1000';
		}

		$list = pdo_fetchall($sql, $params);
		$operator = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_cashier_operator') . ' WHERE uniacid=:uniacid AND cashierid=:cashierid ORDER BY id DESC', array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']), 'id');

		if ($_GPC['export'] == 1) {
			set_time_limit(0);
			$columns = array(
				array('title' => '状态', 'field' => 'status', 'width' => 12),
				array('title' => '订单号', 'field' => 'logno', 'width' => 24),
				array('title' => '付款日期', 'field' => 'createtime', 'width' => 24),
				array('title' => '操作员', 'field' => 'operator', 'width' => 12),
				array('title' => '支付方式', 'field' => 'paytype', 'width' => 12),
				array('title' => '金额', 'field' => 'money', 'width' => 12),
				array('title' => '商品金额', 'field' => 'goodsprice', 'width' => 12),
				array('title' => '商城商品', 'field' => 'orderprice', 'width' => 12),
				array('title' => '随机减', 'field' => 'randommoney', 'width' => 12),
				array('title' => '满额减', 'field' => 'enough', 'width' => 12),
				array('title' => '余额抵扣', 'field' => 'deduction', 'width' => 12),
				array('title' => '固定折扣', 'field' => 'discountmoney', 'width' => 12),
				array('title' => '优惠券减免', 'field' => 'usecouponprice', 'width' => 12),
				array('title' => '赠送积分', 'field' => 'present_credit1', 'width' => 12)
			);

			foreach ($list as $k => &$v) {
				if ($v['status'] == '1') {
					$v['status'] = '已支付';
				}
				else if ($v['status'] == '-1') {
					$v['status'] = '已退款';
				}
				else {
					$v['status'] = '未支付';
				}

				$v['createtime'] = date('Y-m-d H:i', $v['createtime']);

				if (empty($v['operatorid'])) {
					$v['operator'] = '管理员';
				}
				else {
					$v['operator'] = isset($operator[$v['operatorid']]) ? $operator[$v['operatorid']]['title'] : '';
				}

				$v['paytype'] = CashierModel::$paytype[$v['paytype']];
				$v['money'] = $v['money'] + $v['deduction'];
			}

			unset($v);
			m('excel')->export($list, array('title' => '收银台收款订单', 'columns' => $columns));
		}

		$total = (int) pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition), $params);
		$total_money = (double) pdo_fetchcolumn('select sum(money+deduction) from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function refund($tid = 0, $fee = 0, $reason = '')
	{
		global $_W;
		global $_GPC;
		$res = $this->model->refund($_GPC['id']);

		if (is_error($res)) {
			show_json(0, $res['message']);
		}

		show_json(1);
	}
}

?>
