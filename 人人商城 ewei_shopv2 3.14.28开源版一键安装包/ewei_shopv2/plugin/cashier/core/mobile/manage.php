<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/mobile_cashier.php';
class Manage_EweiShopV2Page extends CashierMobilePage
{
	public function __construct()
	{
		global $_W;
		parent::__construct();
		$userset = $this->model->getUserSet('', $_W['cashierid']);
		if (empty($_W['openid']) || $_W['openid'] != $_W['cashieruser']['manageopenid'] && !strexists($_W['cashieruser']['management'], $_W['openid'])) {
			$this->message('您不是我们的管理员!', 'close', 'error');
		}
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$today = $this->model->getTodayOrder();
		$week = $this->model->getWeekOrder();
		$month = $this->model->getMonthOrder();
		$total = $this->model->getOrderMoney();
		$cashierid = intval($_GPC['cashierid']);
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$cashierid = intval($_GPC['cashierid']);
		$params = array('type' => intval($_GPC['type']), 'cashierid' => $cashierid, 'starttime' => !empty($_GPC['starttime']) ? strtotime($_GPC['starttime']) : 0, 'endtime' => !empty($_GPC['endtime']) ? strtotime($_GPC['endtime']) : 0);
		include $this->template();
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$type = intval($_GPC['type']);
		$starttime = intval($_GPC['starttime']);
		$endtime = intval($_GPC['endtime']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;

		if ($type == 0) {
			$starttime = strtotime(date('Y-m-d'));
			$endtime = time();
		}
		else {
			if ($type == 3 || $type == 7) {
				$starttime = strtotime(date('Y-m-d')) - ($type - 1) * 3600 * 24;
				$endtime = time();
			}
		}

		$list = pdo_fetchall('SELECT *,money+deduction money,FROM_UNIXTIME(paytime) as paytime FROM ' . tablename('ewei_shop_cashier_pay_log') . ' WHERE uniacid=:uniacid AND status=1 AND cashierid=:cashierid AND paytime BETWEEN :starttime AND :endtime ORDER BY id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid'], ':starttime' => $starttime, ':endtime' => $endtime));
		$total = pdo_fetch('SELECT COUNT(*) total,SUM(money+deduction) money FROM ' . tablename('ewei_shop_cashier_pay_log') . ' WHERE uniacid=:uniacid AND status=1 AND cashierid=:cashierid AND paytime BETWEEN :starttime AND :endtime', array(':uniacid' => $_W['uniacid'], ':cashierid' => $_W['cashierid'], ':starttime' => $starttime, ':endtime' => $endtime));
		show_json(1, array('total' => intval($total['total']), 'money' => floatval($total['money']), 'list' => $list, 'pagesize' => $psize));
	}
}

?>
