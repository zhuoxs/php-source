<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'commission/core/page_login_mobile.php';
class Withdraw_EweiShopV2Page extends CommissionMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = $this->model->getInfo($openid, array('total', 'ok', 'apply', 'check', 'lock', 'pay', 'wait', 'fail'));
		$cansettle = 1 <= $member['commission_ok'] && floatval($this->set['withdraw']) <= $member['commission_ok'];
		$agentid = $member['id'];

		if (!empty($agentid)) {
			$data = pdo_fetch('select sum(deductionmoney) as sumcharge from ' . tablename('ewei_shop_commission_log') . ' where mid=:mid and uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid'], ':mid' => $agentid));
			$commission_charge = $data['sumcharge'];
			$member['commission_charge'] = $commission_charge;
		}
		else {
			$member['commission_charge'] = 0;
		}

		include $this->template();
	}
}

?>
