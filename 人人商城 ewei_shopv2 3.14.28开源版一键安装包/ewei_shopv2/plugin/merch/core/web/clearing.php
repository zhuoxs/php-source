<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Clearing_EweiShopV2Page extends PluginWebPage
{
	protected function main($status = 0)
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and u.uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['datetime']['start']) && !empty($_GPC['datetime']['end'])) {
			$starttime = strtotime($_GPC['datetime']['start']);
			$endtime = strtotime($_GPC['datetime']['end']);
			$condition .= ' AND o.createtime >= :starttime AND o.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		$condition .= ' and o.status=:status';
		$params[':status'] = (int) $status;
		if ($_GPC['status'] !== '' && $_GPC['status'] !== NULL) {
			$_GPC['status'] = intval($_GPC['status']);
			$params[':status'] = $_GPC['status'];
		}

		if (!empty($_GPC['realname'])) {
			$_GPC['realname'] = trim($_GPC['realname']);
			$condition .= ' and ( u.merchname like :realname or u.mobile like :realname or u.realname like :realname)';
			$params[':realname'] = '%' . $_GPC['realname'] . '%';
		}

		$sql = 'select u.merchname,u.mobile,u.realname,u.logo,o.* from ' . tablename('ewei_shop_merch_clearing') . ' o ' . ' left join ' . tablename('ewei_shop_merch_user') . ' u on u.id=o.merchid' . (' where 1 ' . $condition . ' ORDER BY o.id DESC');

		if (empty($_GPC['export'])) {
			$sql .= ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);

		if ($_GPC['export'] == '1') {
			plog('member.list', '导出结算数据');

			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
				$row['starttime'] = date('Y-m-d H:i', $row['starttime']);
				$row['endtime'] = date('Y-m-d H:i', $row['endtime']);
				$row['realprice'] = $row['goodsprice'] + $row['dispatchprice'];

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

		$total = pdo_fetchcolumn('select COUNT(u.id) from ' . tablename('ewei_shop_merch_user') . ' u ' . ' left join ' . tablename('ewei_shop_order') . ' o on u.id=o.merchid' . (' where 1 ' . $condition . ' GROUP BY u.id'), $params);
		$total = count($total);
		$pager = pagination2($total, $pindex, $psize);
		$groups = $this->model->getGroups();
		include $this->template('merch/clearing/index');
	}

	public function status0()
	{
		$this->main(0);
	}

	public function status1()
	{
		$this->main(1);
	}

	public function status2()
	{
		$this->main(2);
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
		$merchid = intval($_GPC['merchid']);
		$id = intval($_GPC['id']);

		if ($_W['ispost']) {
			if (!$id) {
				empty($merchid) && show_json(0, '没有选择联系人!');
			}

			$_GPC['goodsprice'] === '' && show_json(0, '订单商品总额不能为空!');
			$_GPC['dispatchprice'] === '' && show_json(0, '快递金额不能为空!');
			$_GPC['deductprice'] === '' && show_json(0, '积分抵扣金额不能为空!');
			$_GPC['deductcredit2'] === '' && show_json(0, '余额抵扣金额不能为空!');
			$_GPC['discountprice'] === '' && show_json(0, '会员折扣金额不能为空!');
			$_GPC['isdiscountprice'] === '' && show_json(0, '促销金额不能为空!');
			$_GPC['price'] === '' && show_json(0, '实际支付金额不能为空!');
			$_GPC['realprice'] === '' && show_json(0, '实际支付金额不能为空!');
			$_GPC['realpricerate'] === '' && show_json(0, '实际支付金额不能为空!');
			$data = array('merchid' => $merchid, 'clearno' => empty($_GPC['clearno']) ? m('common')->createNO('merch_clearing', 'clearno', 'MB') : $_GPC['clearno'], 'uniacid' => $_W['uniacid'], 'goodsprice' => floatval($_GPC['goodsprice']), 'dispatchprice' => floatval($_GPC['dispatchprice']), 'deductprice' => floatval($_GPC['deductprice']), 'deductcredit2' => floatval($_GPC['deductcredit2']), 'discountprice' => floatval($_GPC['discountprice']), 'isdiscountprice' => floatval($_GPC['isdiscountprice']), 'price' => floatval($_GPC['price']), 'realprice' => floatval($_GPC['realprice']), 'payrate' => floatval($_GPC['payrate']), 'realpricerate' => floatval($_GPC['realpricerate']), 'deductenough' => floatval($_GPC['deductenough']), 'merchdeductenough' => floatval($_GPC['merchdeductenough']), 'merchcouponprice' => floatval($_GPC['merchcouponprice']), 'status' => intval($_GPC['status']), 'finalprice' => floatval($_GPC['finalprice']), 'remark' => $_GPC['remark'], 'starttime' => strtotime($_GPC['datetime']['start']), 'endtime' => strtotime($_GPC['datetime']['end']), 'createtime' => time());
			$data['realprice'] < $data['goodsprice'] + $data['dispatchprice'] ? $data['realprice'] = $data['goodsprice'] + $data['dispatchprice'] - $data['merchdeductenough'] - $data['merchcouponprice'] : $data['realprice'];

			if ($data['status'] == 2) {
				if (empty($data['finalprice'])) {
					$data['finalprice'] = $data['realpricerate'];
				}

				$payprice = $data['finalprice'] * 100;
				$merch_user = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . (' where uniacid=:uniacid and id=' . $merchid), array(':uniacid' => $_W['uniacid']));

				if (empty($merch_user['payopenid'])) {
					show_json(0, '请先设置商户结算收款人!');
				}

				$result = m('finance')->pay($merch_user['payopenid'], 1, $payprice, $data['clearno'], '商户结算');

				if (is_error($result)) {
					show_json(0, $result['message']);
				}

				$data['paytime'] = time();
			}

			if ($id) {
				unset($data['starttime']);
				unset($data['endtime']);
				unset($data['merchid']);
				unset($data['createtime']);
				pdo_update('ewei_shop_merch_clearing', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
			}
			else {
				pdo_insert('ewei_shop_merch_clearing', $data);
				$id = pdo_insertid();
			}

			show_json(1);
		}

		if ($id) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_merch_clearing') . ' WHERE id=:id AND uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			empty($item) && $this->message('未找到该账单', '', 'error');
			$merch = pdo_fetch('select id,merchname,logo,realname,mobile from ' . tablename('ewei_shop_merch_user') . ' where id=:id and uniacid=:uniacid', array(':id' => $item['merchid'], ':uniacid' => $_W['uniacid']));
		}
		else {
			if ($merchid) {
				$merch = pdo_fetch('select id,merchname,logo,realname,mobile from ' . tablename('ewei_shop_merch_user') . ' where id=:id and uniacid=:uniacid', array(':id' => $merchid, ':uniacid' => $_W['uniacid']));
			}
		}

		include $this->template();
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
