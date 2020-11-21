<?php
//QQ63779278
class Statistic_EweiShopV2Model
{
	public function o2oorderstatistic($days, $storeid = 0)
	{
		global $_W;

		if (intval($days) == 0) {
			$days = 1;
		}

		$time = time() - $days * 86400;
		$sql = 'select count(1)   from ' . tablename('ewei_shop_order') . ' where uniacid =:uniacid and isnewstore=1 and paytime > :paytime';
		$params = array(':uniacid' => $_W['uniacid'], ':paytime' => $time);

		if (!empty($storeid)) {
			$sql .= ' and storeid=:storeid';
			$params[':storeid'] = $storeid;
		}

		$total = pdo_fetchcolumn($sql, $params);
		$sql = 'select s.id,s.storename,COUNT(1) as num  from  ' . tablename('ewei_shop_order') . ' o
        inner JOIN  ' . tablename('ewei_shop_store') . '  s on o.storeid =s.id and isnewstore=1
        where o.uniacid =:uniacid and o.isnewstore=1 and o.paytime > :paytime ';

		if (!empty($storeid)) {
			$sql .= ' and o.storeid=:storeid';
		}

		$sql .= ' GROUP BY s.id ORDER BY COUNT(*) desc';
		$top10 = pdo_fetchall($sql, $params);
		$result = array('total' => $total, 'top10' => $top10);
		return $result;
	}

	public function o2osalestatistic($days, $storeid = 0)
	{
		global $_W;

		if (intval($days) == 0) {
			$days = 1;
		}

		$time = time() - $days * 86400;
		$sql = 'select sum(price)  from ' . tablename('ewei_shop_order') . ' where uniacid =:uniacid and isnewstore=1 and paytime > :paytime';
		$params = array(':uniacid' => $_W['uniacid'], ':paytime' => $time);

		if (!empty($storeid)) {
			$sql .= ' and  storeid=:storeid';
			$params[':storeid'] = $storeid;
		}

		$total = pdo_fetchcolumn($sql, $params);

		if (empty($total)) {
			$total = 0;
		}

		$sql = 'select s.id,s.storename,sum(o.price) as num  from  ' . tablename('ewei_shop_order') . ' o
        inner JOIN  ' . tablename('ewei_shop_store') . '  s on o.storeid =s.id and isnewstore=1
        where o.uniacid =:uniacid and o.isnewstore=1 and o.paytime > :paytime';

		if (!empty($storeid)) {
			$sql .= ' and  o.storeid=:storeid';
		}

		$sql .= '   GROUP BY s.id ORDER BY sum(o.price) desc';
		$top10 = pdo_fetchall($sql, $params);
		$result = array('total' => $total, 'top10' => $top10);
		return $result;
	}

	public function o2overifystatistic($days, $storeid = 0)
	{
		global $_W;

		if (intval($days) == 0) {
			$days = 1;
		}

		$time = time() - $days * 86400;
		$sql = 'select count(1)  from ' . tablename('ewei_shop_order') . ' where uniacid =:uniacid and isnewstore=1 and verifytime > :verifytime';
		$params = array(':uniacid' => $_W['uniacid'], ':verifytime' => $time);

		if (!empty($storeid)) {
			$sql .= ' and  storeid=:storeid';
			$params[':storeid'] = $storeid;
		}

		$total = pdo_fetchcolumn($sql, $params);
		$sql = 'select s.id,s.storename,COUNT(1) as num  from  ' . tablename('ewei_shop_order') . ' o
        inner JOIN  ' . tablename('ewei_shop_store') . '  s on o.storeid =s.id and isnewstore=1
        where o.uniacid =:uniacid and o.isnewstore=1 and o.verifytime > :verifytime  ';

		if (!empty($storeid)) {
			$sql .= ' and  o.storeid=:storeid';
		}

		$sql .= '   GROUP BY s.id ORDER BY COUNT(*) desc';
		$top10 = pdo_fetchall($sql, $params);
		$result = array('total' => $total, 'top10' => $top10);
		return $result;
	}

	public function o2orefundmoney($days, $storeid = 0)
	{
		global $_W;

		if (intval($days) == 0) {
			$days = 1;
		}

		$time = time() - $days * 86400;
		$sql = 'select sum(r.applyprice)  from ' . tablename('ewei_shop_order') . ' o INNER JOIN  ' . tablename('ewei_shop_order_refund') . '  r on o.id =r.orderid  where o.uniacid =:uniacid and o.isnewstore=1 and o.paytime > :paytime';
		$params = array(':uniacid' => $_W['uniacid'], ':paytime' => $time);

		if (!empty($storeid)) {
			$sql .= ' and  o.storeid=:storeid';
			$params[':storeid'] = $storeid;
		}

		$total = pdo_fetchcolumn($sql, $params);

		if (empty($total)) {
			$total = 0;
		}

		return $total;
	}

	public function o2orefundstatistic($days, $storeid = 0)
	{
		global $_W;

		if (intval($days) == 0) {
			$days = 1;
		}

		$time = time() - $days * 86400;
		$sql = 'select COUNT(1)  from ' . tablename('ewei_shop_order') . ' o INNER JOIN  ' . tablename('ewei_shop_order_refund') . '  r on o.id =r.orderid  where o.uniacid =:uniacid and isnewstore=1 and paytime > :paytime';
		$params = array(':uniacid' => $_W['uniacid'], ':paytime' => $time);

		if (!empty($storeid)) {
			$sql .= ' and  o.storeid=:storeid';
			$params[':storeid'] = $storeid;
		}

		$total = pdo_fetchcolumn($sql, $params);
		return $total;
	}

	public function o2o($days)
	{
		return 0;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
