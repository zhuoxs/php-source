<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Credit_EweiShopV2Page extends PluginWebPage
{
	protected function main($status = 1)
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
		$action_status = $status;
		$applytitle = '';

		if ($status == 1) {
			$applytitle = '待确认';
		}
		else if ($status == 2) {
			$applytitle = '待打款';
		}
		else if ($status == 3) {
			$applytitle = '已打款';
		}
		else {
			if ($status == -1) {
				$action_status = '_1';
				$applytitle = '已无效';
			}
		}

		$apply_type = array(0 => '微信钱包', 2 => '支付宝', 3 => '银行卡');
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and u.uniacid=:uniacid and b.creditstatus =1';
		$params = array(':uniacid' => $_W['uniacid']);
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		$timetype = $_GPC['timetype'];

		if (!empty($_GPC['timetype'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);

			if (!empty($timetype)) {
				$condition .= ' AND b.' . $timetype . ' >= :starttime AND b.' . $timetype . '  <= :endtime ';
				$params[':starttime'] = $starttime;
				$params[':endtime'] = $endtime;
			}
		}

		$condition .= ' and b.status=:status';
		$params[':status'] = (int) $status;
		if ($_GPC['status'] !== '' && $_GPC['status'] !== NULL) {
			$_GPC['status'] = intval($_GPC['status']);
			$params[':status'] = $_GPC['status'];
		}

		$searchfield = strtolower(trim($_GPC['searchfield']));
		$keyword = trim($_GPC['keyword']);
		if (!empty($searchfield) && !empty($keyword)) {
			if ($searchfield == 'applyno') {
				$condition .= ' and b.applyno like :keyword';
			}
			else {
				if ($searchfield == 'member') {
					$condition .= ' and ( u.merchname like :keyword or u.mobile like :keyword or u.realname like :keyword)';
				}
			}

			$params[':keyword'] = '%' . $keyword . '%';
		}

		$sql = 'select b.*,u.merchname,u.realname,u.mobile from ' . tablename('ewei_shop_merch_bill') . ' b ' . ' left join ' . tablename('ewei_shop_merch_user') . ' u on b.merchid = u.id' . (' where 1 ' . $condition . ' ORDER BY b.id desc ');

		if (empty($_GPC['export'])) {
			$sql .= ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);
		$_condition = ' and uniacid=:uniacid  and id=:id ';
		$_sql = 'select iscreditmoney,creditrate from ' . tablename('ewei_shop_merch_user') . ('where 1 ' . $_condition);
		$_params = array(':uniacid' => $_W['uniacid'], ':id' => $merchid);
		$iscreditmoneys = pdo_fetchall($_sql, $_params);
		$iscreditmoney = $iscreditmoneys[0]['iscreditmoney'];

		if ($_GPC['export'] == '1') {
			plog('member.list', '导出结算数据');

			foreach ($list as &$row) {
				$row['applytime'] = date('Y-m-d H:i', $row['applytime']);
				$row['paytime'] = date('Y-m-d H:i', $row['paytime']);
				$row['typestr'] = $apply_type[$row['applytype']];
			}

			unset($row);
			$columns = array();
			$columns[] = array('title' => '商城信息', 'field' => 'merchname', 'width' => 12);
			$columns[] = array('title' => '姓名', 'field' => 'realname', 'width' => 12);
			$columns[] = array('title' => '手机号', 'field' => 'mobile', 'width' => 12);
			$columns[] = array('title' => '申请金额', 'field' => 'realprice', 'width' => 12);
			$columns[] = array('title' => '申请订单个数', 'field' => 'ordernum', 'width' => 16);
			$columns[] = array('title' => '提现方式', 'field' => 'typestr', 'width' => 12);

			if (1 < $status) {
				$columns[] = array('title' => '通过申请金额', 'field' => 'passrealprice', 'width' => 12);
				$columns[] = array('title' => '通过申请订单个数', 'field' => 'passordernum', 'width' => 16);
			}

			if ($status == 3) {
				$columns[] = array('title' => '实际打款金额', 'field' => 'finalprice', 'width' => 12);
			}

			if ($iscreditmoney == 0) {
				$columns[] = array('title' => '兑换比例*积分/一元', 'field' => 'creditrate', 'width' => 12);
				$columns[] = array('title' => '申请积分', 'field' => 'creditnum', 'width' => 12);
				$columns[] = array('title' => '通过的积分', 'field' => 'passcreditnum', 'width' => 12);
				$columns[] = array('title' => '积分兑换的金额', 'field' => 'passcreditmoney', 'width' => 12);
			}

			$columns[] = array('title' => '申请时间', 'field' => 'applytime', 'width' => 16);

			if ($status == 3) {
				$columns[] = array('title' => '最终打款时间', 'field' => 'paytime', 'width' => 12);
			}

			m('excel')->export($list, array('title' => '提现申请数据', 'columns' => $columns));
		}

		$total = pdo_fetchcolumn('select COUNT(1) from ' . tablename('ewei_shop_merch_bill') . ' b ' . ' left join ' . tablename('ewei_shop_merch_user') . ' u on b.merchid = u.id' . (' where 1 ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		$groups = $this->model->getGroups();
		include $this->template('merch/credit/index');
	}

	public function status1()
	{
		$this->main(1);
	}

	public function status2()
	{
		$this->main(2);
	}

	public function status3()
	{
		$this->main(3);
	}

	public function status_1()
	{
		$this->main(-1);
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$status = intval($_GPC['status']);
		$item = $this->model->getOneApply($id);

		if (empty($item['applytype'])) {
			$merch_user = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . (' where uniacid=:uniacid and id=' . $item['merchid']), array(':uniacid' => $_W['uniacid']));

			if (!empty($merch_user['payopenid'])) {
				$member = m('member')->getMember($merch_user['payopenid']);
			}
		}

		$apply_type = array(0 => '微信钱包', 2 => '支付宝', 3 => '银行卡');

		if ($status == 1) {
			$is_check = 1;
		}

		if ($status <= 1) {
			$orderids = iunserializer($item['orderids']);
		}
		else {
			$orderids = iunserializer($item['passorderids']);
		}

		$keyword = trim($_GPC['keyword']);
		$list = array();

		foreach ($orderids as $key => $orderid) {
			$data = $this->model->getMerchCreditList($item['merchid'], $orderid, 10, $item['creditrate'], $item['isbillcredit']);

			if (!empty($data)) {
				$flag = 1;

				if (!empty($keyword)) {
					if (strpos(trim($data['ordersn']), $keyword) !== false) {
						$flag = 1;
					}
					else {
						$flag = 0;
					}
				}

				if ($flag) {
					$list[] = $data;
				}
			}
		}

		if ($_GPC['export'] == '1') {
			foreach ($list as &$row) {
				$row['finishtime'] = date('Y-m-d H:i', $row['finishtime']);
			}

			$columns = array();
			$columns[] = array('title' => '订单编号', 'field' => 'ordersn', 'width' => 24);
			$columns[] = array('title' => '可提现金额', 'field' => 'realprice', 'width' => 24);
			$columns[] = array('title' => '抽成比例', 'field' => 'payrate', 'width' => 12);
			$columns[] = array('title' => '抽成后获得金额', 'field' => 'realpricerate', 'width' => 24);
			$columns[] = array('title' => '订单完成时间', 'field' => 'finishtime', 'width' => 24);
			$columns[] = array('title' => '订单商品总额', 'field' => 'goodsprice', 'width' => 24);
			$columns[] = array('title' => '快递金额', 'field' => 'dispatchprice', 'width' => 24);
			$columns[] = array('title' => '积分抵扣金额', 'field' => 'deductprice', 'width' => 24);
			$columns[] = array('title' => '余额抵扣金额', 'field' => 'deductcredit2', 'width' => 24);
			$columns[] = array('title' => '会员折扣金额', 'field' => 'discountprice', 'width' => 24);
			$columns[] = array('title' => '促销金额', 'field' => 'isdiscountprice', 'width' => 24);
			$columns[] = array('title' => '满减金额', 'field' => 'deductenough', 'width' => 24);
			$columns[] = array('title' => '实际支付金额', 'field' => 'price', 'width' => 24);
			$columns[] = array('title' => '商户满减金额', 'field' => 'merchdeductenough', 'width' => 24);
			$columns[] = array('title' => '商户优惠券金额', 'field' => 'merchcouponprice', 'width' => 24);
			$columns[] = array('title' => '分销佣金', 'field' => 'commission', 'width' => 24);
			m('excel')->export($list, array('title' => '提现申请订单数据-' . date('Y-m-d-H-i', time()), 'columns' => $columns));
		}

		include $this->template();
	}

	public function merchpay()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$handpay = intval($_GPC['handpay']);
		$finalprice = floatval($_GPC['finalprice']);

		if (empty($id)) {
			show_json(0, '参数错误!');
		}

		if ($finalprice <= 0) {
			show_json(0, '打款金额错误!');
		}

		$item = $this->model->getOneApply($id);

		if (empty($item)) {
			show_json(0, '未找到提现申请!');
		}

		$payprice = $finalprice * 100;
		if (empty($handpay) && empty($item['applytype'])) {
			$merch_user = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . (' where uniacid=:uniacid and id=' . $item['merchid']), array(':uniacid' => $_W['uniacid']));

			if (empty($merch_user['payopenid'])) {
				show_json(0, '请先设置商户结算收款人!');
			}

			$result = m('finance')->pay($merch_user['payopenid'], 1, $payprice, $item['applyno'], '商户提现申请打款');

			if (is_error($result)) {
				show_json(0, $result['message']);
			}
		}

		$change_data = array();
		$change_data['paytime'] = time();
		$change_data['status'] = 3;
		$change_data['finalprice'] = $finalprice;
		$change_data['handpay'] = $handpay;
		pdo_update('ewei_shop_merch_bill', $change_data, array('id' => $id));
		$orderids = iunserializer($item['passorderids']);

		foreach ($orderids as $key => $orderid) {
			pdo_update('ewei_shop_order', array('merchapply' => 3), array('id' => $orderid));
		}

		show_json(1);
	}

	public function confirm()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$bpid = $_GPC['bpid'];
		$type = intval($_GPC['type']);

		if (empty($bpid)) {
			if ($type == 1) {
				show_json(0, '参数错误!');
			}
		}
		else {
			$bpid = array_unique($bpid);
		}

		$item = $this->model->getOneApply($id);

		if (empty($item)) {
			show_json(0, '未找到提现申请!');
		}

		$orderids = iunserializer($item['orderids']);
		$orderids = array_unique($orderids);

		if (empty($orderids)) {
			show_json(0, '参数错误!');
		}

		if ($type == 1) {
			$change_data = array();
			$change_data['checktime'] = time();
			$change_data['status'] = 2;
			$pass_data = $this->model->getPassApplyCredit($item['merchid'], $bpid, $item['creditrate'], $item['isbillcredit']);
			$change_data['passrealprice'] = $pass_data['realprice'];
			$change_data['passrealpricerate'] = $pass_data['realprice'];
			$change_data['passorderprice'] = $pass_data['orderprice'];
			$change_data['passorderids'] = iserializer($bpid);
			$change_data['passordernum'] = count($bpid);
			$change_data['passcreditnum'] = $pass_data['credit'];
			$change_data['passcreditmoney'] = $pass_data['realpricerate'];
			pdo_update('ewei_shop_merch_bill', $change_data, array('id' => $id));

			foreach ($orderids as $key => $orderid) {
				if (in_array($orderid, $bpid)) {
					pdo_update('ewei_shop_creditshop_log', array('merchapply' => 2), array('id' => $orderid));
				}
				else {
					pdo_update('ewei_shop_creditshop_log', array('merchapply' => -1), array('id' => $orderid));
				}
			}
		}
		else {
			if ($type == -1) {
				$change_data = array();
				$change_data['invalidtime'] = time();
				$change_data['status'] = -1;
				pdo_update('ewei_shop_merch_bill', $change_data, array('id' => $id));

				foreach ($orderids as $key => $orderid) {
					pdo_update('ewei_shop_creditshop_log', array('merchapply' => -1), array('id' => $orderid));
				}
			}
		}

		show_json(1);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid';

		if (!empty($kwd)) {
			$condition .= ' AND ( merchname LIKE :keyword or realname LIKE :keyword or mobile LIKE :keyword)';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$sql = 'select id,merchname,logo,realname,mobile from ' . tablename('ewei_shop_merch_user') . (' where 1 ' . $condition . ' ORDER BY id ASC');
		$ds = pdo_fetchall($sql, $params);
		include $this->template();
		exit();
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$status = intval($_GPC['data']['status']);

		if ($id) {
			pdo_update('ewei_shop_merch_clearing', array('status' => $status), array('id' => $id, 'uniacid' => $_W['uniacid']));
			show_json(1);
		}

		show_json(0);
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if ($id) {
			pdo_query('DELETE FROM ' . tablename('ewei_shop_merch_clearing') . ' WHERE id=:id AND status<>2 AND uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			show_json(1);
		}

		show_json(0);
	}
}

?>
