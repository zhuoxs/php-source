<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Sale_EweiShopV2Page extends WebPage
{
	public function main()
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
				$dr = array('data' => $hour . '点 - ' . $nexthour . '点', 'count' => pdo_fetchcolumn('SELECT ifnull(' . $countfield . ',0) as cnt FROM ' . tablename('ewei_shop_order') . ' WHERE uniacid=:uniacid and status>=1 and isparent=0 and createtime >=:starttime and createtime <=:endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => strtotime($year . '-' . $month . '-' . $day . ' ' . $hour . ':00:00'), ':endtime' => strtotime($year . '-' . $month . '-' . $day . ' ' . $hour . ':59:59'))));
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
						$dr = array('data' => $m['data'], 'count' => pdo_fetchcolumn('SELECT ifnull(' . $countfield . ',0) as cnt FROM ' . tablename('ewei_shop_order') . ' WHERE uniacid=:uniacid and status>=1 and isparent=0 and createtime >=:starttime and createtime <=:endtime', array(':uniacid' => $_W['uniacid'], ':starttime' => strtotime($year . '-' . $m['data'] . '-01 00:00:00'), ':endtime' => strtotime($year . '-' . $m['data'] . '-' . $lastday . ' 23:59:59'))));
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

		if ($_GPC['export'] == 1) {
			ca('statistics.sale.export');
			$list[] = array('data' => $typename . '总数', 'count' => $totalcount);
			$list[] = array('data' => '最高' . $typename, 'count' => $maxcount);
			$list[] = array('data' => '发生在', 'count' => $maxcount_date);
			m('excel')->export($list, array(
	'title'   => '交易报告-' . (!empty($year) && !empty($month) ? $year . '年' . $month . '月' : $year . '年'),
	'columns' => array(
		array('title' => $dataname, 'field' => 'data', 'width' => 12),
		array('title' => $typename, 'field' => 'count', 'width' => 12),
		array('title' => '所占比例(%)', 'field' => 'percent', 'width' => 24)
		)
	));
			plog('statistics.sale.export', '导出销售统计');
		}

		include $this->template('statistics/sale');
	}
}

?>
