<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class O2o_orderusers_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$years = array();
		$current_year = date('Y');
		$year = empty($_GPC['year']) ? $current_year : $_GPC['year'];
		$i = $current_year - 10;

		while ($i <= $current_year) {
			$years[] = array('data' => $i, 'selected' => $i == $year);
			++$i;
		}

		$months = array();
		$current_month = date('m');
		$month = $_GPC['month'];
		$i = 1;

		while ($i <= 12) {
			$months[] = array('data' => $i, 'selected' => $i == $month);
			++$i;
		}

		$day = intval($_GPC['day']);
		$params = array();

		if (!empty($year)) {
			$times = '00:00:00';
			$timee = '23:59:59';
			$yearst = $year;
			$yearen = $year;

			if (empty($month)) {
				$yearst = $year;
				$yearen = $year + 1;
				$monthst = 1;
				$monthen = 1;
				$days = 1;
				$daye = 1;
				$times = '00:00:00';
				$timee = '00:00:00';
			}
			else {
				$monthst = $month;
				$monthen = $month;

				if (empty($day)) {
					if ($month < 12) {
						$monthst = $month;
						$monthen = $month + 1;
					}
					else {
						$monthst = 12;
						$monthen = 1;
						$yearen = $year + 1;
					}

					$days = 1;
					$daye = 1;
					$times = '00:00:00';
					$timee = '00:00:00';
				}
				else {
					$days = $day;
					$daye = $day;
				}
			}

			$starttime = strtotime($yearst . '-' . $monthst . '-' . $days . ' ' . $times);
			$endtime = strtotime($yearen . '-' . $monthen . '-' . $daye . ' ' . $timee);
			$btime = $yearst . '/' . $monthst . '/' . $days;
			$etime = $yearen . '/' . $monthen . '/' . $daye;
			$condition = '  and paytime >:stime and paytime < :etime';
			$params[':stime'] = $starttime;
			$params[':etime'] = $endtime;
		}

		$params2 = array();
		$_GPC['keyword'] = trim($_GPC['keyword']);

		if (!empty($_GPC['keyword'])) {
			$condition2 = ' and storename like :keyword';
			$params2[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$params2[':uniacid'] = $_W['uniacid'];
		$total = pdo_fetchcolumn('select  count(1) from ' . tablename('ewei_shop_store') . (' where uniacid=:uniacid  ' . $condition2), $params2);
		$sql = 'select *  from  ' . tablename('ewei_shop_store') . (' where uniacid=:uniacid ' . $condition2 . ' ');

		if (empty($_GPC['export'])) {
			$sql .= '  LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params2);

		foreach ($list as &$item) {
			$sql = 'select count(a.openid) from (SELECT  openid   from  ' . tablename('ewei_shop_order') . ('    where uniacid=:uniacid and storeid = :storeid  ' . $condition . '  and isnewstore=1 GROUP BY openid) a');
			$params[':storeid'] = $item['id'];
			$params[':uniacid'] = $_W['uniacid'];
			$usercount = pdo_fetchcolumn($sql, $params);
			$item['usercount'] = $usercount;
			$sql = 'SELECT  SUM(price)   from     ' . tablename('ewei_shop_order') . ('  where   uniacid=:uniacid and storeid = :storeid ' . $condition . '  and isnewstore=1 ');
			$allprice = pdo_fetchcolumn($sql, $params);
			if (!empty($usercount) && !empty($allprice)) {
				$item['avguserprice'] = $allprice / $usercount;
			}
			else {
				$item['avguserprice'] = 0;
			}
		}

		unset($item);
		$pager = pagination($total, $pindex, $psize);
		include $this->template();
	}
}

?>
