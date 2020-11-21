<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Statistic_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$days = array(1, 7, 30);
		$info = array();
		$list = array();

		foreach ($days as $day) {
			$total = array();
			$top10 = array();
			$result = m('statistic')->o2oorderstatistic($day);
			$total['ordernum'] = $result['total'];
			$top10['ordernum'] = $result['top10'];
			$result = m('statistic')->o2osalestatistic($day);
			$total['salesnum'] = $result['total'];
			$top10['salesnum'] = $result['top10'];
			$result = m('statistic')->o2overifystatistic($day);
			$total['verifynum'] = $result['total'];
			$top10['verifynum'] = $result['top10'];
			$result = m('statistic')->o2orefundmoney($day);
			$total['refundmoney'] = $result;
			$result = m('statistic')->o2orefundstatistic($day);
			$total['refundnum'] = $result;
			$info[$day] = $total;
			$list[$day] = $top10;
		}

		include $this->template();
	}
}

?>
