<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}


require EWEI_SHOPV2_PLUGIN . 'merchmanage/core/inc/page_merchmanage.php';
class Index_EweiShopV2Page extends MerchmanageMobilePage
{
	public function main()
	{
		
		function sale_analysis_count($sql) 
		{
			$c = pdo_fetchcolumn($sql);
			return intval($c);
		}
		global $_W;
		global $_GPC;
		$merchid = $_W['merchmanage']['merchid'];
		$member_count = sale_analysis_count('select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid=' . $_W['uniacid'] . ' and  openid in ( SELECT distinct openid from ' . tablename('ewei_shop_order') . '   WHERE uniacid = \'' . $_W['uniacid'] . '\' and merchid=\'' . $merchid . '\'  )');
		$orderprice = sale_analysis_count('SELECT sum(price) FROM ' . tablename('ewei_shop_order') . ' WHERE  status>=1 and uniacid = \'' . $_W['uniacid'] . '\' and merchid=\'' . $merchid . '\' ');
		$ordercount = sale_analysis_count('SELECT count(*) FROM ' . tablename('ewei_shop_order') . ' WHERE status>=1 and uniacid = \'' . $_W['uniacid'] . '\' and merchid=\'' . $merchid . '\'');
		$viewcount = sale_analysis_count('SELECT sum(viewcount) FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid = \'' . $_W['uniacid'] . '\' and merchid=\'' . $merchid . '\'');
		$member_buycount = sale_analysis_count('select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid=' . $_W['uniacid'] . ' and  openid in ( SELECT distinct openid from ' . tablename('ewei_shop_order') . '   WHERE uniacid = \'' . $_W['uniacid'] . '\' and merchid=\'' . $merchid . '\' and status>=1 )');
		include $this->template();
	}
	public function getsale($value='')
	{
		global $_W;
		global $_GPC;

		$merchid = $_W['merchmanage']['merchid'];
		
		#测试
		$years = array();
		$current_year = date('Y');
		$year = ((empty($_GPC['year']) ? $current_year : $_GPC['year']));
		$i = $current_year - 10;
		while ($i <= $current_year) 
		{
			$years[] = array('data' => $i, 'selected' => $i == $year);
			++$i;
		}
		$months = array();
		$current_month = date('m');
		$month = date('m');
		$i = 1;
		while ($i <= 12) 
		{
			$months[] = array('data' => $i, 'selected' => $i == $month);
			++$i;
		}
		
		$type = intval($_GPC['type']);
		$list = array();
		$totalcount = 0;
		$maxcount = 0;
		$maxcount_date = '';
		$maxdate = '';
		$countfield = ((empty($type) ? 'sum(price)' : 'count(*)'));
		$typename = ((empty($type) ? '交易额' : '交易量'));
		$dataname = ((!(empty($year)) && !(empty($month)) ? '月份' : '日期'));
		

		if (!(empty($year)) && !(empty($month))) 
		{
			$lastday = get_last_day($year, $month);
			$d = 1;
			while ($d <= $lastday) 
			{
				$dr = array('data' => $d, 'count' => pdo_fetchcolumn('SELECT ifnull(' . $countfield . ',0) as cnt FROM ' . tablename('ewei_shop_order') . ' WHERE uniacid=:uniacid and merchid=:merchid and status>=1 and createtime >=:starttime and createtime <=:endtime', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid, ':starttime' => strtotime($year . '-' . $month . '-' . $d . ' 00:00:00'), ':endtime' => strtotime($year . '-' . $month . '-' . $d . ' 23:59:59'))));
				$totalcount += $dr['count'];
				if ($maxcount < $dr['count']) 
				{
					$maxcount = $dr['count'];
					$maxcount_date = $year . '年' . $month . '月' . $d . '日';
				}
				$list[] = $dr;
				++$d;
			}
		}
		foreach ($list as $key => &$row ) 
		{
			$list[$key]['percent'] = number_format(($row['count'] / ((empty($totalcount) ? 1 : $totalcount))) * 100, 2);
		}
		unset($row);
		show_json(1,array('type'=>$type,'list'=>$list,'totalcount'=>$totalcount,'maxcount'=>$maxcount,'maxcount_date'=>$maxcount_date));
	}
}


?>