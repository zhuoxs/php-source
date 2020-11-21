<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require __DIR__ . '/base.php';
class Withdraw_EweiShopV2Page extends Base_EweiShopV2Page
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = $this->model->getInfo($openid, array('total', 'ok', 'apply', 'check', 'lock', 'pay', 'wait', 'fail'));
		$cansettle = 1 <= $member['dividend_ok'] && floatval($this->set['withdraw']) <= $member['dividend_ok'];
		$agentid = $member['id'];

		if (!empty($agentid)) {
			$data = pdo_fetch('select sum(deductionmoney) as sumcharge from ' . tablename('ewei_shop_dividend_log') . ' where mid=:mid and uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid'], ':mid' => $agentid));
			$dividend_charge = $data['sumcharge'];
			$member['dividend_charge'] = $dividend_charge;
		}
		else {
			$member['dividend_charge'] = 0;
		}

		$result = array('member' => $member, 'set' => $this->set, 'cansettle' => $cansettle);
		return app_json($result);
	}
}

?>
