<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'app/core/page_auth_mobile.php';
class Statistics_EweiShopV2Page extends AppMobileAuthPage
{
	public function main()
	{
		$notice = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_copyright_notice') . ' WHERE status=1 ORDER BY displayorder ASC,createtime DESC LIMIT 10');

		if (!empty($notice)) {
			foreach ($notice as &$item) {
				$item['createtime'] = date('Y-m-d H:i:s', $item['createtime']);
			}
		}

		return app_json(array('list' => $notice));
	}

	public function sale()
	{
		global $_W;
		global $_GPC;
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
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
		$type = intval($_GPC['type']);
		$list = array();
		$totalcount = 0;
		$maxcount = 0;
		$maxcount_date = '';
		$maxdate = '';
		$countfield = empty($type) ? 'sum(price)' : 'count(*)';
		$typename = empty($type) ? '交易额' : '交易量';
		$dataname = empty($month) ? '月份' : '日期';
		if (!empty($year) && !empty($month) && !empty($day)) {
			$hour = 0;

			while ($hour < 24) {
				$nexthour = $hour + 1;
				$dr = array('data' => $hour . '点 - ' . $nexthour . '点', 'count' => pdo_fetchcolumn('SELECT ifnull(' . $countfield . ',0) as cnt FROM ' . tablename('ewei_shop_order') . ' WHERE uniacid=:uniacid and status>=1 and createtime >=:starttime and createtime <=:endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => strtotime($year . '-' . $month . '-' . $day . ' ' . $hour . ':00:00'), ':endtime' => strtotime($year . '-' . $month . '-' . $day . ' ' . $hour . ':59:59'))));
				$totalcount += $dr['count'];

				if ($maxcount < $dr['count']) {
					$maxcount = $dr['count'];
					$maxcount_date = $year . '年' . $month . '月' . $day . '日 ' . $hour . '点 - ' . $nexthour . '点';
				}

				$list[] = $dr;
				++$hour;
			}
		}
		else {
			if (!empty($year) && !empty($month)) {
				$lastday = get_last_day($year, $month);
				$d = 1;

				while ($d <= $lastday) {
					$dr = array('data' => $d, 'count' => pdo_fetchcolumn('SELECT ifnull(' . $countfield . ',0) as cnt FROM ' . tablename('ewei_shop_order') . ' WHERE uniacid=:uniacid and status>=1 and isparent=0 and createtime >=:starttime and createtime <=:endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => strtotime($year . '-' . $month . '-' . $d . ' 00:00:00'), ':endtime' => strtotime($year . '-' . $month . '-' . $d . ' 23:59:59'))));
					$totalcount += $dr['count'];

					if ($maxcount < $dr['count']) {
						$maxcount = $dr['count'];
						$maxcount_date = $year . '年' . $month . '月' . $d . '日';
					}

					$list[] = $dr;
					++$d;
				}
			}
			else {
				if (!empty($year)) {
					foreach ($months as $k => $m) {
						$lastday = get_last_day($year, $k + 1);
						$dr = array('data' => $m['data'], 'count' => pdo_fetchcolumn('SELECT ifnull(' . $countfield . ',0) as cnt FROM ' . tablename('ewei_shop_order') . ' WHERE uniacid=:uniacid and status>=1 and createtime >=:starttime and createtime <=:endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => strtotime($year . '-' . $m['data'] . '-01 00:00:00'), ':endtime' => strtotime($year . '-' . $m['data'] . '-' . $lastday . ' 23:59:59'))));
						$totalcount += $dr['count'];

						if ($maxcount < $dr['count']) {
							$maxcount = $dr['count'];
							$maxcount_date = $year . '年' . $m['data'] . '月';
						}

						$list[] = $dr;
					}
				}
			}
		}

		foreach ($list as $key => &$row) {
			$list[$key]['percent'] = number_format($row['count'] / (empty($totalcount) ? 1 : $totalcount) * 100, 2);
		}

		unset($row);
		return app_json(array('list' => $list, 'totalcount' => $totalcount, 'maxcount' => $maxcount, 'type' => $type, 'maxcount_date' => $maxcount_date));
	}

	public function get_day()
	{
		global $_W;
		global $_GPC;
		$year = intval($_GPC['year']);
		$month = intval($_GPC['month']);
		$day = get_last_day($year, $month);
		return app_json(array('day' => $day));
	}

	public function goods()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and og.uniacid=:uniacid and o.status>=1';
		$params = array(':uniacid' => $_W['uniacid']);
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['datestart']) && !empty($_GPC['dateend'])) {
			$starttime = intval($_GPC['datestart']);
			$endtime = intval($_GPC['dateend']);

			if (!empty($starttime)) {
				$condition .= ' AND o.createtime >= :starttime';
				$params[':starttime'] = $starttime;
			}

			if (!empty($endtime)) {
				$condition .= ' AND o.createtime <= :endtime ';
				$params[':endtime'] = $endtime;
			}
		}

		if (!empty($_GPC['title'])) {
			$_GPC['title'] = trim($_GPC['title']);
			$condition .= ' and g.title like :title';
			$params[':title'] = '%' . $_GPC['title'] . '%';
		}

		$orderby = !isset($_GPC['orderby']) ? 'og.price' : (empty($_GPC['orderby']) ? 'og.price' : 'og.total');
		$sql = 'select og.price,og.total,o.createtime,o.ordersn,g.title,g.thumb,g.goodssn,op.goodssn as optiongoodssn,op.title as optiontitle from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id = og.goodsid ' . ' left join ' . tablename('ewei_shop_goods_option') . ' op on op.id = og.optionid ' . (' where 1 ' . $condition . ' order by ' . $orderby . ' desc ');

		if (empty($_GPC['export'])) {
			$sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$row) {
			$row['thumb'] = tomedia($row['thumb']);
			$row['price'] = price_format($row['price']);
			$row['createtime'] = date('Y-m-d H:i:s', $row['createtime']);

			if (!empty($row['optiongoodssn'])) {
				$row['goodssn'] = $row['optiongoodssn'];
			}
		}

		unset($row);
		$total = pdo_fetchcolumn('select  count(*) from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id = og.goodsid ' . (' where 1 ' . $condition), $params);
		return app_json(array('list' => $list, 'pagesize' => $psize, 'total' => $total, 'page' => $pindex));
	}
}

?>
