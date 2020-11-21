<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require __DIR__ . '/base.php';
class Down_EweiShopV2Page extends Base_EweiShopV2Page
{
	public function get_set()
	{
		global $_W;
		global $_GPC;
		$member = $this->model->getInfo($_W['openid']);
		$levelcount1 = $member['level1'];
		$levelcount2 = $member['level2'];
		$levelcount3 = $member['level3'];
		$level1 = $level2 = $level3 = 0;
		$levels = array();
		$level1 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid=:agentid and uniacid=:uniacid limit 1', array(':agentid' => $member['id'], ':uniacid' => $_W['uniacid']));
		$levels[0] = array('level' => 1, 'name' => $this->set['texts']['c1'], 'total' => $level1);

		if (2 <= $this->set['level']) {
			$levels[1] = array('level' => 2, 'name' => $this->set['texts']['c2'], 'total' => 0);

			if (0 < $levelcount1) {
				$levels[1]['total'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid in( ' . implode(',', array_keys($member['level1_agentids'])) . ') and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
			}
		}

		if (3 <= $this->set['level']) {
			$levels[2] = array('level' => 3, 'name' => $this->set['texts']['c3'], 'total' => 0);

			if (0 < $levelcount2) {
				$levels[2]['total'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid in( ' . implode(',', array_keys($member['level2_agentids'])) . ') and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
			}
		}

		$total = $level1 + $level2 + $level3;
		return app_json(array('total' => $total, 'levels' => $levels, 'textdown' => $this->set['texts']['mydown'], 'textagent' => $this->set['texts']['agent'], 'textyuan' => $this->set['texts']['yuan'], 'down' => $this->set['texts']['down']));
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = $this->model->getInfo($openid);
		$total_level = 0;
		$level = intval($_GPC['level']);
		(3 < $level || $level <= 0) && ($level = 1);
		$condition = '';
		$levelcount1 = $member['level1'];
		$levelcount2 = $member['level2'];
		$levelcount3 = $member['level3'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;

		if ($level == 1) {
			$condition = ' and agentid=' . $member['id'];
			$hasangent = true;
			$total_level = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid=:agentid and uniacid=:uniacid limit 1', array(':agentid' => $member['id'], ':uniacid' => $_W['uniacid']));
		}
		else if ($level == 2) {
			if (empty($levelcount1)) {
				return app_json(array(
					'list'     => array(),
					'total'    => 0,
					'pagesize' => $psize
				));
			}

			$condition = ' and agentid in( ' . implode(',', array_keys($member['level1_agentids'])) . ')';
			$hasangent = true;
			$total_level = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid in( ' . implode(',', array_keys($member['level1_agentids'])) . ') and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
		}
		else {
			if ($level == 3) {
				if (empty($levelcount2)) {
					return app_json(array(
						'list'     => array(),
						'total'    => 0,
						'pagesize' => $psize
					));
				}

				$condition = ' and agentid in( ' . implode(',', array_keys($member['level2_agentids'])) . ')';
				$hasangent = true;
				$total_level = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid in( ' . implode(',', array_keys($member['level2_agentids'])) . ') and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
			}
		}

		$list = pdo_fetchall('select * from ' . tablename('ewei_shop_member') . ' where uniacid = ' . $_W['uniacid'] . (' ' . $condition . '  ORDER BY isagent desc,id desc limit ') . ($pindex - 1) * $psize . ',' . $psize);
		if (!is_array($list) || empty($list)) {
			$list = array();
		}

		foreach ($list as &$row) {
			if ($member['isagent'] && $member['status']) {
				$info = $this->model->getInfo($row['openid'], array('total'));
				$row['commission_total'] = $info['commission_total'];
				$row['agentcount'] = $info['agentcount'];
				$row['agenttime'] = date('Y-m-d H:i', $row['agenttime']);
			}

			$ordercount = pdo_fetchcolumn('select count(id) from ' . tablename('ewei_shop_order') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));
			$row['ordercount'] = number_format(intval($ordercount), 0);
			$moneycount = pdo_fetchcolumn('select sum(og.realprice) from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id where o.openid=:openid  and o.status>=1 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));
			$row['moneycount'] = number_format(floatval($moneycount), 2);
			$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
		}

		unset($row);
		return app_json(array('list' => $list, 'total' => $total_level, 'pagesize' => $psize));
	}
}

?>
