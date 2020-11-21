<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Clearing_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$id = intval($_W['cashierid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'sc.uniacid=:uniacid AND sc.deleted=0';
		$params = array(':uniacid' => $_W['uniacid']);

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

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$params = array(':uniacid' => $_W['uniacid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'AND status=1 AND (paytype = 101 OR paytype = 102 OR paytype = 2)';

		if (!$id) {
			$this->message('参数错误!', '', 'error');
		}
		else {
			$clearing = pdo_fetch('select sc.*,u.name,u.mobile,u.title,u.logo,u.openid from ' . tablename('ewei_shop_cashier_clearing') . ' sc left join ' . tablename('ewei_shop_cashier_user') . ' u ON sc.cashierid=u.id where sc.uniacid=:uniacid AND sc.id=:id AND sc.deleted=0', array(':uniacid' => $_W['uniacid'], ':id' => $id));
			empty($clearing) && $this->message('没有找到提现单!', '', 'error');
			$condition .= ' AND id IN(' . $clearing['orderids'] . ')';
			$payinfo = json_decode($clearing['payinfo'], true);
		}

		if ($_W['ispost']) {
			if ($clearing['status'] == 0) {
				pdo_update('ewei_shop_cashier_clearing', array('status' => 1), array('id' => $clearing['id'], 'uniacid' => $clearing['uniacid']));
				show_json(1);
			}

			$money = (double) $_GPC['realmoney'];

			if (empty($money)) {
				$money = (double) $clearing['money'];
			}

			$remark = trim($_GPC['remark']);

			if ($clearing['paytype'] == 0) {
				$realmoney = $money * 100;

				if (empty($clearing['openid'])) {
					show_json(0, '请先设置收银台收款人!');
				}

				$result = m('finance')->pay($clearing['openid'], 1, $realmoney, $clearing['clearno'], $clearing['title'] . '-收银台结算');

				if (is_error($result)) {
					show_json(0, $result['message']);
				}
			}

			pdo_query('UPDATE ' . tablename('ewei_shop_cashier_clearing') . ' SET status=2,realmoney=:realmoney,remark=:remark,paytime=:paytime WHERE uniacid=:uniacid AND id=:id', array(':uniacid' => $clearing['uniacid'], ':id' => $clearing['id'], ':paytime' => time(), ':remark' => $remark, ':realmoney' => $money));
			pdo_query('UPDATE ' . tablename('ewei_shop_cashier_pay_log') . ' SET is_applypay=2 WHERE uniacid=:uniacid AND id IN(' . $clearing['orderids'] . ')', $params);
			$this->model->sendMessage(array('name' => $clearing['name'], 'mobile' => $clearing['mobile'], 'money' => $clearing['money'], 'realmoney' => $clearing['realmoney'], 'createtime' => $clearing['createtime'], 'paytime' => time()), 'apply_clearing', $clearing['openid']);
			show_json(1);
		}

		$sql = 'select * from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition . ' ORDER BY id desc limit ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$openids = '';

		foreach ($list as $key => $value) {
			$openids .= '\'' . $value['openid'] . '\',';

			if (!empty($clearing['merchid'])) {
				$list[$key]['money'] = $list[$key]['money'] - $list[$key]['orderprice'];
			}
		}

		if (!empty($openids)) {
			$openids = rtrim($openids, ',');
			$user = pdo_fetchall('SELECT id,openid,nickname FROM ' . tablename('ewei_shop_member') . (' WHERE openid IN (' . $openids . ') AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']), 'openid');
		}

		$total = (int) pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition), $params);

		if (!empty($clearing['merchid'])) {
			$total_money = (double) pdo_fetchcolumn('select sum(money-orderprice+deduction) from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition), $params);
		}
		else {
			$total_money = (double) pdo_fetchcolumn('select sum(money+deduction) from ' . tablename('ewei_shop_cashier_pay_log') . (' where uniacid=:uniacid ' . $condition), $params);
		}

		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}
}

?>
