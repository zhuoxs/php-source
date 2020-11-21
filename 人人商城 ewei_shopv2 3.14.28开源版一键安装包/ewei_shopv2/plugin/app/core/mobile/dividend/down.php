<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require __DIR__ . '/base.php';
class Down_EweiShopV2Page extends Base_EweiShopV2Page
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = $this->model->getInfo($openid);
		$groupscount = $member['groupscount'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall('select * from ' . tablename('ewei_shop_member') . ' where headsid = :headsid and isheads = 0 and uniacid = :uniacid order by id desc limit ' . ($pindex - 1) * $psize . ',' . $psize, array(':headsid' => $member['id'], ':uniacid' => $_W['uniacid']));

		if (!empty($list)) {
			foreach ($list as &$row) {
				$money = 0;
				$order = pdo_fetchall('select id,price,dividend from ' . tablename('ewei_shop_order') . ' where openid=:openid and headsid = :headsid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid'], ':headsid' => $member['id']));

				foreach ($order as $k => $v) {
					$dividend = iunserializer($v['dividend']);
					$money += $dividend['dividend_price'];
				}

				$row['ordercount'] = count($order);
				$row['moneycount'] = floatval($money);
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
			}

			unset($row);
		}

		$result = array('member' => $member, 'list' => $list, 'groupscount' => $groupscount, 'total' => $groupscount, 'pagesize' => $psize);
		return app_json($result);
	}
}

?>
