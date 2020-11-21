<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/page_cashier.php';
class Clearing_EweiShopV2Page extends CashierWebPage
{
	public function __construct()
	{
		global $_W;
		parent::__construct();

		if (empty($_W['cashieruser']['can_withdraw'])) {
			$this->message('不允许提现!', cashierUrl('index'));
		}
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$id = intval($_W['cashierid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'sc.uniacid=:uniacid AND cashierid=:cashierid AND sc.deleted=0';
		$params = array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid']);

		if ($_GPC['status'] != '') {
			$condition .= ' AND sc.status=:status';
			$params[':status'] = intval($_GPC['status']);
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$start = strtotime($_GPC['time']['start']);
			$end = strtotime($_GPC['time']['end']);
			$condition .= ' AND sc.createtime BETWEEN :start AND :end';
			$params[':start'] = intval($start);
			$params[':end'] = intval($end);
		}

		if (!empty($_GPC['clearno'])) {
			$condition .= ' AND sc.clearno=:clearno';
			$params[':clearno'] = intval($_GPC['clearno']);
		}

		if (!empty($_GPC['keyword'])) {
			if (strexists($_GPC['keyword'], 'MB')) {
				$condition .= ' AND sc.clearno=:clearno';
				$params[':clearno'] = trim($_GPC['keyword']);
			}
			else {
				$condition .= ' AND (u.name like :keyword or u.mobile like :keyword or u.title like :keyword)';
				$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
			}
		}

		$sql = 'select sc.*,u.name,u.mobile,u.title,u.logo,u.openid from ' . tablename('ewei_shop_cashier_clearing') . ' sc left join ' . tablename('ewei_shop_cashier_user') . (' u ON sc.cashierid=u.id where ' . $condition . ' ORDER BY sc.id desc limit ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);

		if ($_GPC['export'] == '1') {
			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
				$row['paytime'] = date('Y-m-d H:i', $row['paytime']);

				if ($row['status'] == 0) {
					$row['status'] = '未结算';
				}
				else if ($row['status'] == 1) {
					$row['status'] = '结算中';
				}
				else {
					if ($row['status'] == 2) {
						$row['status'] = '已结算';
					}
				}
			}

			unset($row);
			m('excel')->export($list, array(
				'title'   => '商户结算数据',
				'columns' => array(
					array('title' => '商城信息', 'field' => 'merchname', 'width' => 12),
					array('title' => '姓名', 'field' => 'realname', 'width' => 12),
					array('title' => '手机号', 'field' => 'mobile', 'width' => 12),
					array('title' => '订单应收', 'field' => 'realprice', 'width' => 12),
					array('title' => '积分抵扣', 'field' => 'deductprice', 'width' => 12),
					array('title' => '余额抵扣', 'field' => 'deductcredit2', 'width' => 12),
					array('title' => '会员抵扣', 'field' => 'discountprice', 'width' => 12),
					array('title' => '促销优惠', 'field' => 'isdiscountprice', 'width' => 12),
					array('title' => '订单实收', 'field' => 'price', 'width' => 12),
					array('title' => '订单开始时间', 'field' => 'starttime', 'width' => 16),
					array('title' => '订单结束时间', 'field' => 'endtime', 'width' => 16),
					array('title' => '结算生成时间', 'field' => 'createtime', 'width' => 16),
					array('title' => '结算状态', 'field' => 'status', 'width' => 12)
				)
			));
		}

		include $this->template();
	}

	public function add()
	{
		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$set = $this->set;
		$userinfo = $this->model->userInfo($_W['cashierid']);
		$payday = (double) $set['payday'];
		$payday_sql = '';

		if (!empty($payday)) {
			$payday_sql = ' AND paytime<=' . (time() - $payday * 3600 * 24);
		}

		$cashierid = intval($_W['cashierid']);
		$id = intval($_GPC['id']);
		$params = array(':uniacid' => $_W['uniacid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'AND status=1 AND (paytype = 101 OR paytype = 102 OR paytype = 2)';

		if (!$id) {
			$condition .= ' AND is_applypay=0 AND cashierid=' . $cashierid;
		}
		else {
			$clearing = pdo_fetch('select sc.*,u.name,u.mobile,u.title,u.logo,u.openid,u.withdraw from ' . tablename('ewei_shop_cashier_clearing') . ' sc left join ' . tablename('ewei_shop_cashier_user') . ' u ON sc.cashierid=u.id where sc.uniacid=:uniacid AND sc.cashierid=:cashierid AND sc.id=:id AND sc.deleted=0', array(':uniacid' => $_W['uniacid'], ':cashierid' => $cashierid, ':id' => $id));
			empty($clearing) && $this->message('没有找到提现单!', '', 'error');
			$condition .= ' AND id IN(' . $clearing['orderids'] . ')';
			$payinfo = json_decode($clearing['payinfo'], true);
		}

		$total = (int) pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition . $payday_sql), $params);

		if (!empty($_W['cashieruser']['merchid'])) {
			$total_money = (double) pdo_fetchcolumn('select sum(money-orderprice+deduction) from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition . $payday_sql), $params);
		}
		else {
			$total_money = (double) pdo_fetchcolumn('select sum(money+deduction) from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition . $payday_sql), $params);
		}

		$withdraw = empty($userinfo['withdraw']) ? 0 : (double) $userinfo['withdraw'];
		$money = round($total_money * (1 - $withdraw / 100), 2);

		if ($_W['ispost']) {
			if (!$id) {
				if (empty($_W['cashieruser']['openid']) && $_GPC['paytype'] == 0) {
					show_json(0, '没有选择收银台打款人!');
				}
			}

			empty($total_money) && show_json(0, '没有金额可以被生成订单!');
			$order_ids = pdo_fetchall('select id from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition . $payday_sql), $params, 'id');
			$order_ids = array_keys($order_ids);
			$paytype = (int) $_GPC['paytype'];
			$payinfo_data = $_GPC['data'];
			$payinfo_data['alipayname'] = trim($payinfo_data['alipayname']);
			$payinfo_data['alipaynum'] = trim($payinfo_data['alipaynum']);
			$payinfo_data['cardtitle'] = trim($payinfo_data['cardtitle']);
			$payinfo_data['cardname'] = trim($payinfo_data['cardname']);
			$payinfo_data['cardnum'] = trim($payinfo_data['cardnum']);
			$payinfo = json_encode($_GPC['data']);
			$data = array('cashierid' => $cashierid, 'uniacid' => $_W['uniacid'], 'clearno' => empty($_GPC['clearno']) ? m('common')->createNO('cashier_clearing', 'clearno', 'MB') : $_GPC['clearno'], 'status' => 0, 'money' => $money, 'orderids' => implode(',', $order_ids), 'createtime' => time(), 'paytype' => $paytype, 'payinfo' => $payinfo, 'charge' => $withdraw);

			if (!$id) {
				pdo_insert('ewei_shop_cashier_clearing', $data);
				pdo_query('UPDATE ' . tablename('ewei_shop_cashier_pay_log') . ' SET is_applypay=1 WHERE uniacid=:uniacid AND id IN(' . $data['orderids'] . ')', $params);
				$this->model->sendMessage(array('name' => !empty($clearing['name']) ? $clearing['name'] : $userinfo['name'], 'mobile' => !empty($clearing['mobile']) ? $clearing['mobile'] : $userinfo['mobile'], 'money' => $data['money'], 'createtime' => time()), 'apply_clearing');
			}

			show_json(1, array('url' => cashierUrl('clearing')));
		}

		$sql = 'select * from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition . $payday_sql . ' ORDER BY id desc limit ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$openids = '';

		foreach ($list as $key => $value) {
			$openids .= '\'' . $value['openid'] . '\',';

			if (!empty($_W['cashieruser']['merchid'])) {
				$list[$key]['money'] = $list[$key]['money'] - $list[$key]['orderprice'];
			}
		}

		if (!empty($openids)) {
			$openids = rtrim($openids, ',');
			$user = pdo_fetchall('SELECT id,openid,nickname FROM ' . tablename('ewei_shop_member') . (' WHERE openid IN (' . $openids . ') AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']), 'openid');
		}

		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$orderids = pdo_fetch('select id,orderids,status from ' . tablename('ewei_shop_cashier_clearing') . ' where uniacid=:uniacid AND id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $id));
		if (!empty($orderids) && $orderids['status'] != 2) {
			pdo_query('UPDATE ' . tablename('ewei_shop_cashier_clearing') . ' SET deleted=1 WHERE id=:id AND status<>2 AND uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			pdo_query('UPDATE ' . tablename('ewei_shop_cashier_pay_log') . ' SET is_applypay=0 WHERE id IN(' . $orderids['orderids'] . ') AND uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
			show_json(1);
		}

		show_json(0, '订单未找到 或者 已结算!');
	}
}

?>
