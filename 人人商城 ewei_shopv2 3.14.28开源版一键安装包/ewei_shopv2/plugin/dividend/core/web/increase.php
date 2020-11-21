<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'dividend/core/dividend_page_web.php';
class Increase_EweiShopV2Page extends DividendWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$days = intval($_GPC['days']);

		if (empty($_GPC['search'])) {
			$days = 7;
		}

		$years = array();
		$current_year = date('Y');
		$year = $_GPC['year'];
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

		$timefield = 'agenttime';
		$datas = array();
		$title = '';

		if (!empty($days)) {
			$charttitle = '最近' . $days . '天增长趋势图';
			$i = $days;

			while (0 <= $i) {
				$time = date('Y-m-d', strtotime('-' . $i . ' day'));
				$condition = ' and uniacid=:uniacid and ' . $timefield . '>=:starttime and ' . $timefield . '<=:endtime';
				$params = array(':uniacid' => $_W['uniacid'], ':starttime' => strtotime($time . ' 00:00:00'), ':endtime' => strtotime($time . ' 23:59:59'));
				$datas[] = array('date' => $time, 'acount' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . (' where isagent=1 and status=1  ' . $condition), $params));
				--$i;
			}
		}
		else {
			if (!empty($year) && !empty($month)) {
				$charttitle = $year . '年' . $month . '月增长趋势图';
				$lastday = get_last_day($year, $month);
				$d = 1;

				while ($d <= $lastday) {
					$condition = ' and uniacid=:uniacid and ' . $timefield . '>=:starttime and ' . $timefield . '<=:endtime';
					$params = array(':uniacid' => $_W['uniacid'], ':starttime' => strtotime($year . '-' . $month . '-' . $d . ' 00:00:00'), ':endtime' => strtotime($year . '-' . $month . '-' . $d . ' 23:59:59'));
					$datas[] = array('date' => $d . '日', 'acount' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . (' where isagent=1  ' . $condition), $params));
					++$d;
				}
			}
			else {
				if (!empty($year)) {
					$charttitle = $year . '年增长趋势图';

					foreach ($months as $m) {
						$lastday = get_last_day($year, $m['data']);
						$condition = ' and uniacid=:uniacid and ' . $timefield . '>=:starttime and ' . $timefield . '<=:endtime';
						$params = array(':uniacid' => $_W['uniacid'], ':starttime' => strtotime($year . '-' . $m['data'] . '-01 00:00:00'), ':endtime' => strtotime($year . '-' . $m['data'] . '-' . $lastday . ' 23:59:59'));
						$datas[] = array('date' => $m['data'] . '月', 'acount' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . (' where isagent=1  ' . $condition), $params));
					}
				}
			}
		}

		include $this->template();
	}
}

?>
