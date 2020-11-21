<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Util_EweiShopV2Page extends WebPage
{
	public function autonum()
	{
		global $_W;
		global $_GPC;
		$num = $_GPC['num'];
		$len = intval($_GPC['len']);
		$len == 0 && ($len = 1);
		$arr = array($num);
		$maxlen = strlen($num);
		$i = 1;

		while ($i <= $len) {
			$add = bcadd($num, $i) . '';
			$addlen = strlen($add);

			if ($maxlen < $addlen) {
				continue;
			}

			$arr[] = $add;
			++$i;
		}

		$len = count($arr);
		$i = 0;

		while ($i < $len) {
			$zerocount = $maxlen - strlen($arr[$i]);

			if (0 < $zerocount) {
				$arr[$i] = str_pad($arr[$i], $maxlen, '0', STR_PAD_LEFT);
			}

			++$i;
		}

		exit(json_encode($arr));
	}

	public function days()
	{
		global $_W;
		global $_GPC;
		$year = intval($_GPC['year']);
		$month = intval($_GPC['month']);
		exit(get_last_day($year, $month));
	}

	public function express()
	{
		global $_W;
		global $_GPC;
		$express = trim($_GPC['express']);
		$expresssn = trim($_GPC['expresssn']);
		$mobile = trim($_GPC['mobile']);
		$expresssn = str_replace(' ', '', $expresssn);
		$list = m('util')->getExpressList($express, $expresssn, $mobile);
		include $this->template();
	}
}

?>
